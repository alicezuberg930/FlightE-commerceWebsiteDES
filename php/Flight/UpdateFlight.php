<?php require_once("../../class/flight.php");
$Time = GetObjectArray("select Time from flightpath where PathID = '" . $_POST["PathID"] . "'")[0];
$Time = explode(":", trim(DecryptCiphertext(utf8_decode($Time["TIME"]))));
$CurrentDate = ($_POST["StartDate"] . "T" . $_POST["StartTime"]);
$CurrentDateClass = new DateTime($CurrentDate);
$ModifyDate =  ("+" . $Time[0] . " hour +" . $Time[1] . " minute");
$CurrentDateClass->modify($ModifyDate);
$Needles = [" ", "VND", ","];
$Array = array(
    "FlightID" => $_POST["FlightID"],
    "StartDate" => date("d-m-Y", strtotime($_POST["StartDate"])),
    "StartTime" => $_POST["StartTime"],
    "EndTime" => $CurrentDateClass->format("H:i"),
    "AirlineID" => $_POST["AirlineID"],
    "PathID" => $_POST["PathID"],
    "EndDate" =>  $CurrentDateClass->format("d-m-Y"),
    "AdultPrice" => str_replace($Needles, "", $_POST["AdultPrice"]),
    "ChildrenPrice" => str_replace($Needles, "", $_POST["ChilrenPrice"]),
    "ToddlerPrice" => str_replace($Needles, "", $_POST["ToddlerPrice"])
);
die($FlightObject->UpdateFlight($Array));
