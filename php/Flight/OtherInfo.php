<?php require_once("../../class/flightpath.php");
require_once("../../class/flight.php");
require_once("../../class/plane.php");
$Array = array('AirplaneArray' => [], 'AirlineArray' => [], 'FlightpathArray' => []);
$PlaneArray = $PlaneObject->SearchPlane("");
$AirlineArray = $FlightObject->Airlines();
$FlightPathArray = $FlightPathObject->GetFlightPath("");
$TempAirplaneArray = $TempAirlineArray = $TempFlightPathArray = array();
foreach ($PlaneArray as $Plane) {
    $TempAirplaneArray = array(
        "PLANEID" => $Plane["PLANEID"], "PLANENAME" => trim(DecryptCiphertext(utf8_decode($Plane["PLANENAME"]))),
        "SEATAMOUNT" => trim(DecryptCiphertext(utf8_decode($Plane["SEATAMOUNT"]))), "PLANEROWS" => trim(DecryptCiphertext(utf8_decode($Plane["PLANEROWS"]))),
        "PLANECOLUMNS" => trim(DecryptCiphertext(utf8_decode($Plane["PLANECOLUMNS"]))), "BUSINESSCLASSROW" => trim(DecryptCiphertext(utf8_decode($Plane["BUSINESSCLASSROW"])))
    );
    array_push($Array["AirplaneArray"], $TempAirplaneArray);
}
foreach ($AirlineArray as $Plane) {
    $TempAirplaneArray = array(
        "AIRLINEID" => $Plane["AIRLINEID"],
        "AIRLINENAME" => trim(DecryptCiphertext(utf8_decode($Plane["AIRLINENAME"]))),
    );
    array_push($Array["AirlineArray"], $TempAirplaneArray);
}
foreach ($FlightPathArray as $FlightPath) {
    $TempFlightPathArray = array(
        "PATHID" => $FlightPath["PATHID"], "CN1" => $FlightPath["CN1"], "CN2" => $FlightPath["CN2"],
        "AN1" => trim(DecryptCiphertext(utf8_decode($FlightPath["AN1"]))), "AN2" => trim(DecryptCiphertext(utf8_decode($FlightPath["AN2"]))),
    );
    array_push($Array["FlightpathArray"], $TempFlightPathArray);
}
die(json_encode($Array));
