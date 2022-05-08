<?php require_once("../../class/member.php");
session_start();
$ID = $Table = $IDType = '';
if (isset($_SESSION["Member"])) {
    $ID = $_SESSION["Member"]["MEMBERID"];
    $Table = 'member';
    $IDType = 'MemberID';
} 
if (isset($_SESSION["Employee"])) {
    $ID = $_SESSION["Employee"]["EMPLOYEEID"];
    $Table = 'employee';
    $IDType = 'EmployeeID';
}
$User = array(
    "ID" => $ID, "Fullname" => $_POST["User"]["Fullname"], "Email" => $_POST["User"]["Email"],
    "Phonenumber" => $_POST["User"]["Phonenumber"], "Gender" => $_POST["User"]["Gender"]
);
die($MemberObject->UpdateMember($User, $Table, $IDType));
