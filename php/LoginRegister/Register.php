<?php require_once("../../class/member.php");
require_once("../../DESAlgorithm.php");
$Array = array('Response' => '', 'Phonenumber' => '', "Email" => '');
$Member = $_POST["UserInfo"];
$username = $Member["username"];
$email = $Member["email"];
$password = $Member["password"];
$phonenumber = $Member["phonenumber"];
$gender = $Member["gender"];
$CheckEmail = GetRows("select count(*) as NUMBER_OF_ROWS from Member where Email = '$email'");
$CheckPhonenumber = GetRows("select count(*) as NUMBER_OF_ROWS from Member where Phonenumber = '$phonenumber'");
if ($CheckEmail > 0) {
    $Array["Email"] = "Email đã tồn tại";
    $Array["Response"] = "Error";
    die(json_encode($Array));
}
if ($CheckPhonenumber > 0) {
    $Array["Phonenumber"] = "Số điện thoại đã tồn tại";
    $Array["Response"] = "Error";
    die(json_encode($Array));
}
$UserObj = array(
    "Fullname" => $username,
    "Email" => $email,
    "Password" => $password,
    "Phonenumber" => $phonenumber,
    "Gender" => $gender
);
if ($MemberObject->Register($UserObj) != 0) {
    $Array["Response"] = "Success";
} else {
    $Array["Response"] = "Error";
}
die(json_encode($Array));
