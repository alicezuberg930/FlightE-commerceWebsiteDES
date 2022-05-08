<?php

use JetBrains\PhpStorm\Deprecated;

class pair
{
    public $a, $b;
    function __construct($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }
}

function DecimalToBinary($decimal, $length)
{
    $binary = "";
    while ($decimal > 0) {
        $binary = ($decimal % 2) . $binary;
        $decimal = floor($decimal / 2);
    }
    return str_pad($binary, $length, "0", STR_PAD_LEFT);
}

// Hàm chuyển kí tự thành chuỗi nhị phân
function charToBinaryAscii($ch)
{
    return DecimalToBinary((ord($ch)), 8);
}

// Hàm chuyển chuỗi nhị phân thành kí tự
function binaryAsciiToChar($binaryAscii)
{
    return chr(bindec($binaryAscii));
}

// Hàm chuyển chuỗi bản rõ thành các khối nhị phân 64 bit
function textToBinaryAscii($str)
{
    $blocksOfData = [];
    $block = "";
    for ($i = 0; $i < floor(strlen($str) / 8); ++$i) {
        $blockStr = substr($str, $i * 8, 8);
        $block = "";
        for ($j = 0; $j < 8; ++$j)
            $block .= charToBinaryAscii($blockStr[$j]);
        array_push($blocksOfData, $block);
    }
    if (strlen($str) % 8 != 0) {
        $start = floor(strlen($str) / 8) * 8;
        $length = strlen($str) - $start;
        $blockStr = substr($str, $start, $length);
        while (strlen($blockStr) < 8)
            $blockStr .= " ";
        $block = "";
        for ($i = 0; $i < 8; ++$i)
            $block .= charToBinaryAscii($blockStr[$i]);
        array_push($blocksOfData, $block);
    }
    return $blocksOfData;
}

// Hàm chuyển khối nhị phân thành chuỗi bản rõ
function binaryAsciiToText($str)
{
    $blocksOfData = "";
    for ($i = 0; $i < strlen($str) / 64; $i++) {
        $blockStr = substr($str, $i * 64, 64);
        $block = "";
        for ($j = 0; $j < 8; $j++) {
            $ascii = substr($blockStr, $j * 8, 8);
            $block .= binaryAsciiToChar($ascii);
        }
        $blocksOfData .= $block;
    }
    return $blocksOfData;
}

// Hàm tạo 16 khóa con từ chuỗi đầu vào
function keyGeneration($key)
{
    $permutedKey = "";
    $PC1_permutations = [
        57, 49, 41, 33, 25, 17, 9, 1, 58, 50, 42, 34, 26, 18,
        10, 2, 59, 51, 43, 35, 27, 19, 11, 3, 60, 52, 44, 36,
        63, 55, 47, 39, 31, 23, 15, 7, 62, 54, 46, 38, 30, 22,
        14, 6, 61, 53, 45, 37, 29, 21, 13, 5, 28, 20, 12, 4
    ];
    for ($i = 0; $i < 56; ++$i) {
        $permutedKey .= $key[$PC1_permutations[$i] - 1];
    }
    $shifts = [1, 1, 2, 2, 2, 2, 2, 2, 1, 2, 2, 2, 2, 2, 2, 1];
    $C0 = substr($permutedKey, 0, 28);
    $D0 = substr($permutedKey, 28, 56);
    $keys = [];
    array_push($keys, new pair($C0, $D0));
    for ($i = 0; $i < 16; ++$i) {
        $C = $keys[$i]->a;
        $D = $keys[$i]->b;
        $C = substr($C, $shifts[$i],  strlen($C)) .  substr($C, 0, $shifts[$i]);
        $D = substr($D, $shifts[$i], strlen($D)) . substr($D, 0, $shifts[$i]);
        array_push($keys, new pair($C, $D));
    }
    $PC2_permutations = [
        14, 17, 11, 24, 1, 5, 3, 28, 15, 6, 21, 10,
        23, 19, 12, 4, 26, 8, 16, 7, 27, 20, 13, 2,
        41, 52, 31, 37, 47, 55, 30, 40, 51, 45, 33, 48,
        44, 49, 39, 56, 34, 53, 46, 42, 50, 36, 29, 32
    ];
    $finalKeys = [];
    for ($i = 0; $i < 16; ++$i) {
        $k = $keys[$i + 1]->a . $keys[$i + 1]->b;
        $fk = "";
        for ($j = 0; $j < 48; ++$j) {
            $fk .= $k[$PC2_permutations[$j] - 1];
        }
        array_push($finalKeys, $fk);
    }
    return $finalKeys;
}

// Hàm XOR
function apply_xor($str1, $str2)
{
    if (strlen($str1) != strlen($str2))
        die("Error in XORed Strings, Length Not Equal");
    $result = "";
    for ($i = 0; $i < strlen($str1); ++$i) {
        if ($str1[$i] == $str2[$i])
            $result .= '0';
        else
            $result .= '1';
    }
    return $result;
}

// Hàm chuyển chuỗi R(n-1) từ 32 bit thành chuỗi 48 bit
function function_E($str)
{
    $result = "";
    $ePermutations = [
        32, 1, 2, 3, 4, 5,
        4, 5, 6, 7, 8, 9,
        8, 9, 10, 11, 12, 13,
        12, 13, 14, 15, 16, 17,
        16, 17, 18, 19, 20, 21,
        20, 21, 22, 23, 24, 25,
        24, 25, 26, 27, 28, 29,
        28, 29, 30, 31, 32, 1
    ];
    for ($i = 0; $i < 48; ++$i) {
        $result .= $str[$ePermutations[$i] - 1];
    }
    return $result;
}

// Hàm fiestel dùng để chuyển đổi XOR của 2 chuỗi 48 bit e và R(n-1) thành chuỗi 32 bit
function feistel($str1, $str2)
{
    $result = apply_xor($str1, $str2);
    $sboxes = [
        [
            [14, 4, 13, 1, 2, 15, 11, 8, 3, 10, 6, 12, 5, 9, 0, 7],
            [0, 15, 7, 4, 14, 2, 13, 1, 10, 6, 12, 11, 9, 5, 3, 8],
            [4, 1, 14, 8, 13, 6, 2, 11, 15, 12, 9, 7, 3, 10, 5, 0],
            [15, 12, 8, 2, 4, 9, 1, 7, 5, 11, 3, 14, 10, 0, 6, 13]
        ],
        [
            [15, 1, 8, 14, 6, 11, 3, 4, 9, 7, 2, 13, 12, 0, 5, 10],
            [3, 13, 4, 7, 15, 2, 8, 14, 12, 0, 1, 10, 6, 9, 11, 5],
            [0, 14, 7, 11, 10, 4, 13, 1, 5, 8, 12, 6, 9, 3, 2, 15],
            [13, 8, 10, 1, 3, 15, 4, 2, 11, 6, 7, 12, 0, 5, 14, 9]
        ],
        [
            [10, 0, 9, 14, 6, 3, 15, 5, 1, 13, 12, 7, 11, 4, 2, 8],
            [13, 7, 0, 9, 3, 4, 6, 10, 2, 8, 5, 14, 12, 11, 15, 1],
            [13, 6, 4, 9, 8, 15, 3, 0, 11, 1, 2, 12, 5, 10, 14, 7],
            [1, 10, 13, 0, 6, 9, 8, 7, 4, 15, 14, 3, 11, 5, 2, 12]
        ],
        [
            [7, 13, 14, 3, 0, 6, 9, 10, 1, 2, 8, 5, 11, 12, 4, 15],
            [13, 8, 11, 5, 6, 15, 0, 3, 4, 7, 2, 12, 1, 10, 14, 9],
            [10, 6, 9, 0, 12, 11, 7, 13, 15, 1, 3, 14, 5, 2, 8, 4],
            [3, 15, 0, 6, 10, 1, 13, 8, 9, 4, 5, 11, 12, 7, 2, 14]
        ],
        [
            [2, 12, 4, 1, 7, 10, 11, 6, 8, 5, 3, 15, 13, 0, 14, 9],
            [14, 11, 2, 12, 4, 7, 13, 1, 5, 0, 15, 10, 3, 9, 8, 6],
            [4, 2, 1, 11, 10, 13, 7, 8, 15, 9, 12, 5, 6, 3, 0, 14],
            [11, 8, 12, 7, 1, 14, 2, 13, 6, 15, 0, 9, 10, 4, 5, 3]
        ],
        [
            [12, 1, 10, 15, 9, 2, 6, 8, 0, 13, 3, 4, 14, 7, 5, 11],
            [10, 15, 4, 2, 7, 12, 9, 5, 6, 1, 13, 14, 0, 11, 3, 8],
            [9, 14, 15, 5, 2, 8, 12, 3, 7, 0, 4, 10, 1, 13, 11, 6],
            [4, 3, 2, 12, 9, 5, 15, 10, 11, 14, 1, 7, 6, 0, 8, 13]
        ],
        [
            [4, 11, 2, 14, 15, 0, 8, 13, 3, 12, 9, 7, 5, 10, 6, 1],
            [13, 0, 11, 7, 4, 9, 1, 10, 14, 3, 5, 12, 2, 15, 8, 6],
            [1, 4, 11, 13, 12, 3, 7, 14, 10, 15, 6, 8, 0, 5, 9, 2],
            [6, 11, 13, 8, 1, 4, 10, 7, 9, 5, 0, 15, 14, 2, 3, 12]
        ],
        [
            [13, 2, 8, 4, 6, 15, 11, 1, 10, 9, 3, 14, 5, 0, 12, 7],
            [1, 15, 13, 8, 10, 3, 7, 4, 12, 5, 6, 11, 0, 14, 9, 2],
            [7, 11, 4, 1, 9, 12, 14, 2, 0, 6, 10, 13, 15, 3, 5, 8],
            [2, 1, 14, 7, 4, 10, 8, 13, 15, 12, 9, 0, 3, 5, 6, 11]
        ]
    ];
    $output = $outerBits = $innerBits = "";
    for ($j = 0; $j < 8; $j++) {
        $temp6bit = substr($result, $j * 6, 6);
        $outerBits = $temp6bit[0] . $temp6bit[5];
        $innerBits = $temp6bit[1] . $temp6bit[2] . $temp6bit[3] . $temp6bit[4];
        $row = bindec($outerBits);
        $column = bindec($innerBits);
        $valInSBox = $sboxes[$j][$row][$column];
        $output .= DecimalToBinary($valInSBox, 4);
    }
    $permutedOutput = "";
    $permutations = [
        16, 7, 20, 21,
        29, 12, 28, 17,
        1, 15, 23, 26,
        5, 18, 31, 10,
        2, 8, 24, 14,
        32, 27, 3, 9,
        19, 13, 30, 6,
        22, 11, 4, 25
    ];
    for ($i = 0; $i < 32; ++$i) {
        $permutedOutput .= $output[$permutations[$i] - 1];
    }
    return $permutedOutput;
}

function DESEncryption($dataBlock, $keys)
{
    $permutedBlock = "";
    $initPermutation = [
        58, 50, 42, 34, 26, 18, 10, 2,
        60, 52, 44, 36, 28, 20, 12, 4,
        62, 54, 46, 38, 30, 22, 14, 6,
        64, 56, 48, 40, 32, 24, 16, 8,
        57, 49, 41, 33, 25, 17, 9, 1,
        59, 51, 43, 35, 27, 19, 11, 3,
        61, 53, 45, 37, 29, 21, 13, 5,
        63, 55, 47, 39, 31, 23, 15, 7
    ];
    for ($i = 0; $i < 64; ++$i) {
        $permutedBlock .= $dataBlock[$initPermutation[$i] - 1];
    }
    $L0 = substr($permutedBlock, 0, 32);
    $R0 = substr($permutedBlock, 32, 64);
    $data = [];
    array_push($data, new pair($L0, $R0));
    for ($i = 1; $i < 17; ++$i) {
        $L = $data[$i - 1]->b;
        $R = apply_xor($data[$i - 1]->a, feistel(function_E($data[$i - 1]->b), $keys[$i - 1]));
        array_push($data, new pair($L, $R));
    }
    $encryptedDataReversedKey = $data[sizeof($data) - 1]->b . $data[sizeof($data) - 1]->a;
    $finalPermutedBlock = "";
    $finalPermutation = [
        40, 8, 48, 16, 56, 24, 64, 32,
        39, 7, 47, 15, 55, 23, 63, 31,
        38, 6, 46, 14, 54, 22, 62, 30,
        37, 5, 45, 13, 53, 21, 61, 29,
        36, 4, 44, 12, 52, 20, 60, 28,
        35, 3, 43, 11, 51, 19, 59, 27,
        34, 2, 42, 10, 50, 18, 58, 26,
        33, 1, 41, 9, 49, 17, 57, 25
    ];
    for ($i = 0; $i < 64; ++$i) {
        $finalPermutedBlock .= $encryptedDataReversedKey[$finalPermutation[$i] - 1];
    }
    return $finalPermutedBlock;
}

function EncryptPlaintext($plainText)
{
    $keys = keyGeneration("0001001100110100010101110111100110011011101111001101111111110001");
    $blocks = textToBinaryAscii($plainText);
    $encryptedText = "";
    for ($i = 0; $i < sizeof($blocks); ++$i)
        $encryptedText .= DESEncryption($blocks[$i], $keys);
    $encryptedText = binaryAsciiToText($encryptedText);
    return $encryptedText;
}

function DecryptCiphertext($encryptedText)
{
    $encryptedText = textToBinaryAscii($encryptedText);
    $keys = keyGeneration("0001001100110100010101110111100110011011101111001101111111110001");
    $reverseKeys = array_reverse($keys);
    $allPlainText = "";
    for ($i = 0; $i < sizeof($encryptedText); ++$i) {
        $allPlainText .= DESEncryption($encryptedText[$i], $reverseKeys);
    }
    return binaryAsciiToText($allPlainText);
}

function EncryptPlaintextToHexadecimal($plainText)
{
    $EncryptedText = "";
    $TempEncrptedText = EncryptPlaintext($plainText);
    for ($i = 0; $i < strlen($TempEncrptedText); $i++) {
        $Char = dechex(ord($TempEncrptedText[$i]));
        if (strlen($Char) == 1)
            $Char = "0" . $Char;
        $EncryptedText .= $Char;
    }
    return $EncryptedText;
}

function DecryptCiphertextFromHexadecimal($encryptedText)
{
    $Plaintext = "";
    for ($i = 0; $i < strlen($encryptedText) / 2; $i++) {
        $Char = chr(hexdec($encryptedText[$i * 2] . $encryptedText[$i * 2 + 1]));
        $Plaintext .= $Char;
    }
    $a = DecryptCiphertext($Plaintext);
    return $a;
}
// $encryptedText = EncryptPlaintext("adu vjp 12 - 00", "0001001100110100010101110111100110011011101111001101111111110001");
// $decryptedText = DecryptCiphertext($encryptedText, "0001001100110100010101110111100110011011101111001101111111110001");
// echo  "Giải mã DES: " . $decryptedText;
// function DecryptCiphertext($encryptedText)
// {
//     $encryptedText = implode(textToBinaryAscii($encryptedText));
//     $keys = keyGeneration("0001001100110100010101110111100110011011101111001101111111110001");
//     $reverseKeys = array_reverse($keys);
//     $stdPlainText = $encryptedText;
//     $allPlainText = "";
//     for ($i = 0; $i < strlen($encryptedText) / 64; ++$i) {
//         $allPlainText .= DESEncryption(substr($stdPlainText, $i * 64, 64), $reverseKeys);
//     }
//     return binaryAsciiToText($allPlainText);
// }