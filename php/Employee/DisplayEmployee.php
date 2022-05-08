<?php require_once("../../class/employee.php");
require_once("../../DESAlgorithm.php");
session_start();
$Array = array('CardBody' => '', 'CardFooter' => '');
$Start = ($_POST["p"] - 1) * 5;
$EmployeeList = $EmployeeObject->GetEmployee($Start, 5);
foreach ($EmployeeList as $Employee) {
    $Fullname = $Employee["FULLNAME"];
    $Email = $Employee["EMAIL"];
    $Password = $Employee["PASSWORD"];
    $Phonenumber = $Employee["PHONENUMBER"];
    $Gender = $Employee["GENDER"];
    $Role = $Employee["ROLE"];
    if ($_SESSION["Employee"]["ROLE"] == 'Quản trị viên') {
        $Fullname = trim(DecryptCiphertext(utf8_decode($Fullname)));
        $Email = trim(DecryptCiphertext(utf8_decode($Email)));
        $Password = trim(DecryptCiphertext(utf8_decode($Password)));
        $Phonenumber = trim(DecryptCiphertext(utf8_decode($Phonenumber)));
        $Gender = trim(DecryptCiphertext(utf8_decode($Gender)));
        $Role = trim(DecryptCiphertext(utf8_decode($Role)));
    }
    $Array['CardBody'] .= '<tr>
        <td>' . $Employee["EMPLOYEEID"] . '</td>
        <td>' . $Fullname . '</td>
        <td>' . $Email . '</td>
        <td>' . $Password . '</td>
        <td>' . $Phonenumber . '</td>
        <td>' . $Gender . '</td>
        <td>' . $Role . '</td>
        <td><button id="Delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></td>
        <td><button id="Edit" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></button></td>
    </tr>';
}
$NumberOfPages = ceil(GetRows("select count(*) as NUMBER_OF_ROWS from employee") / 5);
for ($i = 1; $i <= $NumberOfPages; $i++) {
    $Array['CardFooter'] .= '<span>' . $i . '</span> ';
}
die(json_encode($Array));
