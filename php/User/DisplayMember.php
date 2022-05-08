<?php require_once("../../class/member.php");
require_once("../../DESAlgorithm.php");
session_start();
$Array = array('CardBody' => '', 'CardFooter' => '', 'Page' => '');
$i = 1;
$Start = ($_POST["p"] - 1) * 10;
$MemberList = $MemberObject->GetMember($Start, 10);
foreach ($MemberList as $Member) {
    if ($Member["STATE"] == 1) {
        $Lock = '<button id="Lock" class="btn btn-danger btn-sm"><i class="fas fa-lock"></i></button>';
    } else {
        $Lock = '<button id="Unlock" class="btn btn-danger btn-sm"><i class="fas fa-unlock"></i></button>';
    }
    $Fullname = $Member["FULLNAME"];
    $Email = $Member["EMAIL"];
    $Password = $Member["PASSWORD"];
    $Phonenumber = $Member["PHONENUMBER"];
    $Gender = $Member["GENDER"];
    if (isset($_SESSION["Employee"]) && $_SESSION["Employee"]["ROLE"] == "Quản trị viên") {
        $Fullname = DecryptCiphertext(utf8_decode($Fullname));
        $Email = DecryptCiphertext(utf8_decode($Email));
        $Password = DecryptCiphertext(utf8_decode($Password));
        $Phonenumber = DecryptCiphertext(utf8_decode($Phonenumber));
        $Gender = DecryptCiphertext(utf8_decode($Gender));
    }
    $Array['CardBody'] .= '<tr data-id="' . $Member["MEMBERID"] . '">
        <td>' . $i . '</td>
        <td>' . $Fullname . '</td>
        <td>' . $Email . '</td>
        <td>' . $Password . '</td>
        <td>' . $Phonenumber . '</td>
        <td>' . $Gender . '</td>
        <td><button id="history" class="btn btn-info"><i class="fas fa-history"></i></button></td>
        <td>' . $Lock . '</td>
    </tr>';
    $i++;
}
$NumberOfPages = ceil(GetRows("select count(*) as NUMBER_OF_ROWS from member") / 10);
for ($i = 1; $i <= $NumberOfPages; $i++) {
    $Array['CardFooter'] .= '<span>' . $i . '</span> ';
}
die(json_encode($Array));
