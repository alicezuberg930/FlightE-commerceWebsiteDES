<?php require_once("../../class/flight.php");
require_once("../../DESAlgorithm.php");
session_start();
$Array = array('CardBody' => '', 'CardFooter' => '', 'Page' => '');
$Start = ($_POST["p"] - 1) * 10;
$FlightList = $FlightObject->GetFlight($Start, 10);
foreach ($FlightList as $Flight) {
    $FlightID = $Flight["FLIGHTID"];
    $StartDate = $Flight["STARTDATE"];
    $StartTime = $Flight["STARTTIME"];
    $PlaneName = $Flight["PLANENAME"];
    $AirlineName = $Flight["AIRLINENAME"];
    $PathID = $Flight["PATHID"];
    $AdultPrice = $Flight["ADULTPRICE"];
    $ChildrenPrice = $Flight["CHILDRENPRICE"];
    $ToddlerPrice = $Flight["TODDLERPRICE"];
    $Time = $Flight["TIME"];
    if ($_SESSION["Employee"]["ROLE"] == "Quản trị viên") {
        $StartDate = trim(DecryptCiphertext(utf8_decode($StartDate)));
        $StartTime = trim(DecryptCiphertext(utf8_decode($StartTime)));
        $PlaneName = trim(DecryptCiphertext(utf8_decode($PlaneName)));
        $AirlineName = trim(DecryptCiphertext(utf8_decode($AirlineName)));
        $AdultPrice = number_format(trim(DecryptCiphertext(utf8_decode($AdultPrice))));
        $ChildrenPrice = number_format(trim(DecryptCiphertext(utf8_decode($ChildrenPrice))));
        $ToddlerPrice = number_format(trim(DecryptCiphertext(utf8_decode($ToddlerPrice))));
        $Time = date("H:i", strtotime(trim(DecryptCiphertext(utf8_decode($Time)))));
    }
    $Array['CardBody'] .= '<tr class="FlightRow" data-airlineID="' . $Flight["AIRLINEID"] . '">
        <td id="Time" style="display: none;">' . $Time . '</td>
        <td>' . $FlightID . '</td>
        <td>' . $StartDate . '</td>
        <td>' . $StartTime . '</td>
        <td>' . $PlaneName . '</td>
        <td>' . $AirlineName . '</td>
        <td>' . $PathID . '</td>
        <td>' . $AdultPrice . ' VND</td>
        <td>' . $ChildrenPrice . ' VND</td>
        <td>' . $ToddlerPrice . ' VND</td>
        <td><button id="Delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></td>
        <td><button id="Edit" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></button></td>
        <td><button id="detail" class="btn bg-info btn-sm"><i class="fas fa-info-circle"></i></button></td>
    </tr>';
}
$NumberOfPages = ceil(GetRows("select count(*) as NUMBER_OF_ROWS from flight") / 10);
for ($i = 1; $i <= $NumberOfPages; $i++) {
    $Array['CardFooter'] .= '<span>' . $i . '</span> ';
}
$Array['Page'] = $NumberOfPages;
die(json_encode($Array));
