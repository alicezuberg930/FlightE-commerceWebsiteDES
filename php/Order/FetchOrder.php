<?php require_once("../../class/order.php");
require_once("../../class/flight.php");
session_start();
if (isset($_SESSION["Member"])) {
    $OrderList = $OrderObject->GetOrder(" where MemberID = '" . $_SESSION["Member"]["MEMBERID"] . "'");
} else {
    $OrderList = $OrderObject->GetOrder('');
}
$Total = 0;
$Array = array("Header" => array_keys($OrderList[0]), "Row" => []);
$TempArray = array();
foreach ($OrderList as $Order) {
    $Price = trim(DecryptCiphertext(utf8_decode($Order["TOTALPRICE"])));
    $Total += $Price;
    $TempArray[] = [
        $Order["ORDERID"],
        trim(DecryptCiphertext(utf8_decode($Order["STARTFLIGHT"]))),
        trim(DecryptCiphertext(utf8_decode($Order["QUANTITY"]))),
        number_format($Price) . " VND",
        trim(DecryptCiphertext(utf8_decode($Order["STATE"]))),
        $Order["EMPLOYEEID"],
        $Order["ORDERDATE"],
        $Order["MEMBERID"],
        trim(DecryptCiphertext(utf8_decode($Order["CONTACTEMAIL"]))),
        trim(DecryptCiphertext(utf8_decode($Order["CONTACTNAME"]))),
        trim(DecryptCiphertext(utf8_decode($Order["ADDRESS"]))),
        trim(DecryptCiphertext(utf8_decode($Order["TOTALWEIGHT"]))),
        trim(DecryptCiphertext(utf8_decode($Order["RETURNFLIGHT"]))),
        trim(DecryptCiphertext(utf8_decode($Order["STARTDATE"]))),
        trim(DecryptCiphertext(utf8_decode($Order["RETURNDATE"])))
    ];
}
$TempArray[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', "Tổng thành tiền: " . number_format($Total) . " VND"];
$Array["Row"] = $TempArray;
die(json_encode($Array));
