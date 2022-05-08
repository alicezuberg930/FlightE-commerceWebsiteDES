<?php require_once("../../connection.php");
require_once("../../DESAlgorithm.php");
class flightpath
{
    public function GetFlightPath($SearchString)
    {
        return GetObjectArray(
            "select fp.*, a1.AirportName AN1, a2.AirportName AN2, c1.CityName CN1, c2.CityName CN2, cc1.CountryName CCN1, cc2.CountryName CCN2
            from flightpath fp, airport a1, city c1, country cc1, airport a2, city c2, country cc2 where fp.StartAirport = a1.AirportID and c1.CityID = a1.CityID 
            and cc1.CountryID = c1.CountryID and fp.EndAirport = a2.AirportID 
            and a2.CityID = c2.CityID and cc2.CountryID = c2.CountryID" . $SearchString
        );
    }
    public function AddFlightpath($Obj)
    {
        $PathID = $Obj["PathID"];
        $StartAirport = $Obj["StartAirport"];
        $EndAirport = $Obj["EndAirport"];
        $Time = utf8_encode(EncryptPlaintext($Obj["Time"]));
        return Query("INSERT INTO flightpath(PathID, StartAirport, EndAirport, Time) VALUES ('" . $PathID . "','" . $StartAirport . "','" . $EndAirport . "',q'[" . $Time . "]')");
    }
    public function DeleteFlightpath($ID)
    {
        return Query("delete from flightpath where PathID = '" . $ID . "'");
    }
    public function UpdateFlightpath($Obj)
    {
        $PathID = $Obj["PathID"];
        $StartAirport = $Obj["StartAirport"];
        $EndAirport = $Obj["EndAirport"];
        $Time = utf8_encode(EncryptPlaintext($Obj["Time"]));
        return Query("UPDATE flightpath SET StartAirport='" . $StartAirport . "',EndAirport='" . $EndAirport . "',Time=q'[" . $Time . "]' WHERE PathID='" . $PathID . "'");
    }
}
$FlightPathObject = new flightpath();
