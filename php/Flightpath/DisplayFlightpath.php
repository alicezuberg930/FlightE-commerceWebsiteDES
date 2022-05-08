<?php require_once("../../class/flightpath.php");
session_start();
$Start = ($_POST["p"] - 1) * 10;
$FlightpathList = $FlightPathObject->GetFlightPath(" offset $Start rows fetch next 10 rows only");
$Array = array('CardBody' => '', 'CardFooter' => '', 'Page' => '');
foreach ($FlightpathList as $Flightpath) {
    $PathID = $Flightpath["PATHID"];
    $AN1 = $Flightpath["AN1"];
    $AN2 = $Flightpath["AN2"];
    $Time = $Flightpath["TIME"];
    $CN1 = $Flightpath["CN1"];
    $CN2 = $Flightpath["CN2"];
    if ($_SESSION["Employee"]["ROLE"] == "Quản trị viên") {
        $AN1 = trim(DecryptCiphertext(utf8_decode($AN1)));
        $AN2 = trim(DecryptCiphertext(utf8_decode($AN2)));
        $Time = date("h:i", strtotime(trim(DecryptCiphertext(utf8_decode($Time)))));
    }
    $Array["CardBody"] .= '<tr data-endaid="' . $Flightpath["ENDAIRPORT"] . '" data-startaid="' . $Flightpath["STARTAIRPORT"] . '">
    <td>' . $PathID . '</td>
    <td>' . $AN1 . '</td>
    <td>' . $AN2 . '</td>
    <td>' . $Time . '</td>
    <td><button id="Delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></td>
    <td><button id="Edit" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></button></td>
</tr>';
}
$NumberOfPages = ceil(GetRows("select count(*) as NUMBER_OF_ROWS from flightpath") / 10);
for ($i = 1; $i <= $NumberOfPages; $i++) {
    $Array['CardFooter'] .= '<span>' . $i . '</span> ';
}
$Array['Page'] = $NumberOfPages;
die(json_encode($Array));
