<?php require_once("../../connection.php");
require_once("../../DESAlgorithm.php");
class employee
{
    public function SearchEmployee($SQL)
    {
        return GetObjectArray("SELECT * FROM employee" . $SQL);
    }
    public function GetEmployee($Start, $Quantity)
    {
        $a = utf8_encode(EncryptPlaintext('Quản trị viên'));
        return GetObjectArray("SELECT * FROM employee where Role != '$a' ORDER BY EmployeeID ASC offset $Start rows fetch next $Quantity row only");
    }
    public function AddEmployee($Employee)
    {
        $Fullname = utf8_encode(EncryptPlaintext($Employee["Fullname"]));
        $Email = utf8_encode(EncryptPlaintext($Employee["Email"]));
        $Password = utf8_encode(EncryptPlaintext($Employee["Password"]));
        $Phonenumber = utf8_encode(EncryptPlaintext($Employee["Phonenumber"]));
        $Gender = utf8_encode(EncryptPlaintext($Employee["Gender"]));
        $Role = utf8_encode(EncryptPlaintext($Employee["Role"]));
        return Query("INSERT INTO employee(Fullname,Email,Password,Phonenumber,Gender,Role) 
        VALUES(q'[$Fullname]',q'[$Email]',q'[$Password]',q'[$Phonenumber]',q'[$Gender]',q'[$Role]')");
    }
    public function DeleteEmployee($ID)
    {
        return Query("DELETE FROM employee WHERE EmployeeID = '$ID'");
    }
    public function UpdateEmployee($Employee)
    {
        $Fullname = utf8_encode(EncryptPlaintext($Employee["Fullname"]));
        $Email = utf8_encode(EncryptPlaintext($Employee["Email"]));
        $Password = utf8_encode(EncryptPlaintext($Employee["Password"]));
        $Phonenumber = utf8_encode(EncryptPlaintext($Employee["Phonenumber"]));
        $Gender = utf8_encode(EncryptPlaintext($Employee["Gender"]));
        $Role = utf8_encode(EncryptPlaintext($Employee["Role"]));
        $ID = $Employee["ID"];
        return Query("UPDATE employee SET Fullname=q'[$Fullname]', Email=q'[$Email]', Password=q'[$Password]', 
        Phonenumber=q'[$Phonenumber]', Gender=q'[$Gender]', Role=q'[$Role]' WHERE EmployeeID='$ID'");
    }
}
$EmployeeObject = new employee();
