<?php require_once("../../class/plane.php");
require_once("../../DESAlgorithm.php");
session_start();
$Start = ($_POST["p"] - 1) * 10;
$PlaneList = $PlaneObject->GetPlane($Start, 10);
$Array = array('CardBody' => '', 'CardFooter' => '', 'Page' => '');
foreach ($PlaneList as $Plane) {
    $PlaneID = $Plane["PLANEID"];
    $PlaneName = $Plane["PLANENAME"];
    $SeatAmount = $Plane["SEATAMOUNT"];
    $PlaneRows = $Plane["PLANEROWS"];
    $PlaneColumns = $Plane["PLANECOLUMNS"];
    $BusinessClassRow = $Plane["BUSINESSCLASSROW"];
    if ($_SESSION["Employee"]["ROLE"] == 'Quản trị viên') {
        $PlaneName = trim(DecryptCiphertext(utf8_decode($PlaneName)));
        $SeatAmount = trim(DecryptCiphertext(utf8_decode($SeatAmount)));
        $PlaneRows = trim(DecryptCiphertext(utf8_decode($PlaneRows)));
        $PlaneColumns = trim(DecryptCiphertext(utf8_decode($PlaneColumns)));
        $BusinessClassRow = trim(DecryptCiphertext(utf8_decode($BusinessClassRow)));
    }
    $Array["CardBody"] .= '<tr>
    <td>' . $PlaneID . '</td>
    <td>' . $PlaneName . '</td>
    <td>' . $SeatAmount . '</td>
    <td>' . $PlaneRows . '</td>
    <td>' . $PlaneColumns . '</td>
    <td>' . $BusinessClassRow . '</td>
    <td><button id="Delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></td>
    <td><button id="Edit" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></button></td>
</tr>';
}
$NumberOfPages = ceil(GetRows("select count(*) as NUMBER_OF_ROWS from plane") / 10);
for ($i = 1; $i <= $NumberOfPages; $i++) {
    $Array['CardFooter'] .= '<span>' . $i . '</span> ';
}
$Array['Page'] = $NumberOfPages;
die(json_encode($Array));

// ABA330	Airbus A330	192	32	6	4
// ABA350	Airbus A350	130	26	5	3
// BOE787	Boeing 787	174	29	6	3
// BOE7879	Boeing 787-9 Dreamliner	174	29	6	4
// EME195	Embrear E195	80	16	5	3