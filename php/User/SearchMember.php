<?php require_once("../../class/member.php");
$Array = array('CardBody' => '', 'CardFooter' => '', 'Page' => '');
$MemberList = '';
if ($_POST["Name"] != '') {
    $MemberList = $MemberObject->SearchMember("select * from member where Name = '" . $_POST['Name'] . "'");
} else if ($_POST["Email"] != '') {
    $MemberList = $MemberObject->SearchMember("select * from member where Email = '" . $_POST['Email'] . "'");
} else if ($_POST["Phone"] != '') {
    $MemberList = $MemberObject->SearchMember("select * from member where Phone = '" . $_POST['Phone'] . "'");
}
if ($MemberList == '') {
    die(json_encode($Array));
}
$i = 1;
foreach ($MemberList as $Member) {
    if ($Member["STATE"] == 1) {
        $Lock = '<button id="Lock" class="btn btn-danger btn-sm"><i class="fas fa-lock"></i></button>';
    } else {
        $Lock = '<button id="Unlock" class="btn btn-danger btn-sm"><i class="fas fa-unlock"></i></button>';
    }
    $Array['CardBody'] .= '<tr data-id="' . $Member["MEMBERID"] . '">
        <td>' . $i . '</td>
        <td>' . $Member["FULLNAME"] . '</td>
        <td>' . $Member["EMAIL"] . '</td>
        <td>' . $Member["PASSWORD"] . '</td>
        <td>' . $Member["PHONENUMBER"] . '</td>
        <td>' . $Member["GENDER"] . '</td>
        <td><button id="history" class="btn btn-info"><i class="fas fa-history"></i></button></td>
        <td>' . $Lock . '</td>
    </tr>';
    $i++;
}
die(json_encode($Array));
