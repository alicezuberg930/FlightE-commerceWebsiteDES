<?php require_once("../../connection.php");
require_once("../../DESAlgorithm.php");
class member
{
    public function Login($Email, $Table)
    {
        $Email = utf8_encode(EncryptPlaintext($Email));
        return GetObjectArray("SELECT * FROM $Table WHERE Email = q'[$Email]'");
    }
    public function Register($UserObj)
    {
        $Fullname = utf8_encode(EncryptPlaintext($UserObj["Fullname"]));
        $Email = utf8_encode(EncryptPlaintext($UserObj["Email"]));
        $Password = utf8_encode(EncryptPlaintext($UserObj["Password"]));
        $Phonenumber = utf8_encode(EncryptPlaintext($UserObj["Phonenumber"]));
        $Gender = utf8_encode(EncryptPlaintext($UserObj["Gender"]));
        return Query("INSERT INTO member(FullName,Email,Password,Phonenumber,Gender) 
        VALUES(q'[$Fullname]',q'[$Email]',q'[$Password]',q'[$Phonenumber]',q'[$Gender]')");
    }
    public function GetMember($Start, $Quantity)
    {
        return GetObjectArray("SELECT * FROM member ORDER BY MemberID asc offset $Start rows fetch next $Quantity row only");
    }
    public function SearchMember($SQL)
    {
        return GetObjectArray($SQL);
    }
    public function UpdateMember($User, $Table, $IDType)
    {
        $ID = $User["ID"];
        $Fullname = utf8_encode(EncryptPlaintext($User["Fullname"]));
        $Email = utf8_encode(EncryptPlaintext($User["Email"]));
        $Phonenumber = utf8_encode(EncryptPlaintext($User["Phonenumber"]));
        $Gender = utf8_encode(EncryptPlaintext($User["Gender"]));
        return Query("UPDATE $Table SET Fullname=q'[$Fullname]', Email=q'[$Email]', Phonenumber=q'[$Phonenumber]', Gender=q'[$Gender]' WHERE $IDType='$ID'");
    }
    public function ChangePassword($User, $Table, $IDType)
    {
        $ID = $User["ID"];
        $Password = utf8_encode(EncryptPlaintext($User["Password"]));
        return Query("UPDATE $Table SET Password = q'[$Password]' WHERE $IDType='$ID'");
    }
    public function DeleteMember($ID)
    {
        return Query("delete from member where MemberID = '$ID'");
    }
    public function LockUnlock($ID, $State)
    {
        return Query("update member set State = '" . $State . "' where MemberID = '" . $ID . "' ");
    }
    public function GetSpecificMember($ID, $Table, $IDType)
    {
        return GetObjectArray("select * from $Table where $IDType='$ID'");
    }
}
$MemberObject = new member();
