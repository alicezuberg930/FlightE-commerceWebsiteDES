<?php require_once("../../class/employee.php");
$User = $_POST["Employee"];
$ID = $User["EmployeeID"];
$Fullname = $User["Fullname"];
$Email = $User["Email"];
$Password = $User["Password"];
$Phonenumber = $User["Phonenumber"];
$Gender = $User["Gender"];
$Role = $User["Role"];
$EmployeeArray = array("Fullname" => $Fullname, "Email" => $Email, "Password" => $Password, "Phonenumber" => $Phonenumber, "Gender" => $Gender, "Role" => $Role, "ID" => $ID);
die($EmployeeObject->UpdateEmployee($EmployeeArray));