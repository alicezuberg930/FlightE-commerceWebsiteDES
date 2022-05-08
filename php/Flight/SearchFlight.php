<?php require_once("../../class/flight.php");
$SearchString = date("d-m-Y", strtotime($_POST["SearchString"]));
$Array = array('CardBody' => '', 'CardFooter' => '', 'Page' => '');
$Query = " and StartDate = to_date('$SearchString','dd-mm-yyyy')";
$FlightList = $FlightObject->SearchFlight($Query);
foreach ($FlightList as $Flight) {
    $CurrentDateClass = new DateTime($Flight["STARTDATE"]);
    $Array['CardBody'] .= '<tr class="FlightRow" data-airlineID="' . $Flight["AIRLINEID"] . '">
        <td id="Time" style="display: none;">' . $Flight["TIME"] . '</td>
        <td>' . $Flight["FLIGHTID"] . '</td>
        <td>' . $CurrentDateClass->format("d-m-Y") . '</td>
        <td>' . date("H:i", strtotime($Flight["STARTTIME"])) . '</td>
        <td>' . $Flight["PLANENAME"] . '</td>
        <td>' . $Flight["AIRLINENAME"] . '</td>
        <td>' . $Flight["PATHID"] . '</td>
        <td>' . number_format($Flight["ADULTPRICE"]) . ' VND</td>
        <td>' . number_format($Flight["CHILDRENPRICE"]) . ' VND</td>
        <td>' . number_format($Flight["TODDLERPRICE"]) . ' VND</td>
        <td><button id="Delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></td>
        <td><button id="Edit" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></button></td>
        <td><button id="detail" class="btn bg-info btn-sm"><i class="fas fa-info-circle"></i></button></td>
    </tr>';
}
die(json_encode($Array));
