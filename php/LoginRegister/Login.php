<?php session_start();
require_once("../../class/member.php");
require_once("../../DESAlgorithm.php");
$Array = array("Email" => '', "Password" => '', "Username" => '', "State" => 1);
$email = $_POST["email"];
$password = $_POST["password"];
$User = $MemberObject->Login($email, "member");
$Employee = $MemberObject->Login($email, "employee");
if (empty($User) && empty($Employee)) {
    $Array["Email"] = "Email không tồn tại";
    $Array["Password"] = "Mật khẩu không đúng";
}
if (!empty($User)) {
    if (trim(DecryptCiphertext(utf8_decode($User[0]["PASSWORD"]))) != $password) {
        $Array["Email"] = "";
        $Array["Password"] = "Mật khẩu không đúng";
    } else {
        $Temp = array(
            "FULLNAME" => trim(DecryptCiphertext(utf8_decode($User[0]["FULLNAME"]))),
            "EMAIL" => trim(DecryptCiphertext(utf8_decode($User[0]["EMAIL"]))),
            "PASSWORD" => trim(DecryptCiphertext(utf8_decode($User[0]["PASSWORD"]))),
            "PHONENUMBER" => trim(DecryptCiphertext(utf8_decode($User[0]["PHONENUMBER"]))),
            "STATE" => $User[0]["STATE"],
            "MEMBERID" => $User[0]["MEMBERID"],
            "GENDER" => trim(DecryptCiphertext(utf8_decode($User[0]["GENDER"])))
        );
        $Array["Email"] = '';
        $Array["Password"] = '';
        $_SESSION["Member"] = $Temp;
        $Array["Username"]  = $Temp["FULLNAME"];
        $Array["State"] = $Temp["STATE"];
    }
}
if (!empty($Employee)) {
    if (trim(DecryptCiphertext(utf8_decode($Employee[0]["PASSWORD"]))) != $password) {
        $Array["Password"] = "Mật khẩu không đúng";
    } else {
        $Temp = array(
            "FULLNAME" => trim(DecryptCiphertext(utf8_decode($Employee[0]["FULLNAME"]))),
            "EMAIL" => trim(DecryptCiphertext(utf8_decode($Employee[0]["EMAIL"]))),
            "PASSWORD" => trim(DecryptCiphertext(utf8_decode($Employee[0]["PASSWORD"]))),
            "PHONENUMBER" => trim(DecryptCiphertext(utf8_decode($Employee[0]["PHONENUMBER"]))),
            "EMPLOYEEID" => $Employee[0]["EMPLOYEEID"],
            "GENDER" => trim(DecryptCiphertext(utf8_decode($Employee[0]["GENDER"]))),
            "ROLE" => trim(DecryptCiphertext(utf8_decode($Employee[0]["ROLE"])))
        );
        $Array["Email"] = '';
        $Array["Password"] = '';
        $_SESSION["Employee"] = $Temp;
        $Array["Username"] = $Temp["FULLNAME"];
    }
}
die(json_encode($Array));
