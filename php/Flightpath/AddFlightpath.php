<?php require_once("../../class/flightpath.php");
$FlightpathInfo = array(
    "PathID" =>  $_POST["StartAirport"] . "-" . $_POST["EndAirport"],
    "StartAirport" => $_POST["StartAirport"],
    "EndAirport" => $_POST["EndAirport"],
    "Time" => $_POST['Hour'] . ':' . $_POST["Minute"]
);
die($FlightPathObject->AddFlightpath($FlightpathInfo));
