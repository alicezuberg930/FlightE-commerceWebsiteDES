<?php require_once("../../connection.php");
require_once("../../DESAlgorithm.php");
class flight
{
    public function AirPlanes($SQL)
    {
        return GetObjectArray("select * from plane " . $SQL);
    }
    public function Airlines()
    {
        return GetObjectArray("select * from airline");
    }
    public function CitiesAndAirports($StartAirport)
    {
        return GetObjectArray("select * from city c, airport a where c.CityID = a.CityID and a.AirportID <> '" . $StartAirport . "'");
    }
    public function AddFlight($Obj)
    {
        $StartDate = utf8_encode(EncryptPlaintext($Obj["StartDate"]));
        $StartTime = utf8_encode(EncryptPlaintext($Obj["StartTime"]));
        $EndTime = utf8_encode(EncryptPlaintext($Obj["EndTime"]));
        $EndDate = utf8_encode(EncryptPlaintext($Obj["EndDate"]));
        $AdultPrice = utf8_encode(EncryptPlaintext($Obj["AdultPrice"]));
        $ChildrenPrice = utf8_encode(EncryptPlaintext($Obj["ChildrenPrice"]));
        $ToddlerPrice = utf8_encode(EncryptPlaintext($Obj["ToddlerPrice"]));
        $PlaneID = $Obj["PlaneID"];
        $AirlineID = $Obj["AirlineID"];
        $PathID = $Obj["PathID"];
        return Query("insert into flight(StartDate,StartTime,EndTime,PlaneID,AirlineID,PathID,EndDate,AdultPrice,ChildrenPrice,ToddlerPrice) 
        VALUES(q'[" . $StartDate . "]',q'[" . $StartTime . "]',q'[" . $EndTime . "]',q'[" . $PlaneID . "]',q'[" . $AirlineID . "]',
        q'[" . $PathID . "]',q'[" . $EndDate . "]',q'[" . $AdultPrice . "]',q'[" . $ChildrenPrice . "]',q'[" . $ToddlerPrice . "]')");
    }
    public function UpdateFlight($Obj)
    {
        $ID = $Obj["FlightID"];
        $AirlineID = $Obj["AirlineID"];
        $PathID = $Obj["PathID"];
        $StartDate = utf8_encode(EncryptPlaintext($Obj["StartDate"]));
        $StartTime = utf8_encode(EncryptPlaintext($Obj["StartTime"]));
        $EndTime = utf8_encode(EncryptPlaintext($Obj["EndTime"]));
        $EndDate = utf8_encode(EncryptPlaintext($Obj["EndDate"]));
        $AdultPrice = utf8_encode(EncryptPlaintext($Obj["AdultPrice"]));
        $ChildrenPrice = utf8_encode(EncryptPlaintext($Obj["ChildrenPrice"]));
        $ToddlerPrice = utf8_encode(EncryptPlaintext($Obj["ToddlerPrice"]));
        return Query("update flight set StartDate='" . $StartDate . "', StartTime='$StartTime', EndTime='$EndTime',
        AirlineID='$AirlineID', PathID='$PathID', EndDate='" . $EndDate . "', AdultPrice='$AdultPrice', ChildrenPrice='$ChildrenPrice', 
        ToddlerPrice='$ToddlerPrice' where FlightID = '" . $ID . "'");
    }
    public function DeleteFlight($FlightID)
    {
        return Query("delete from flight where FlightID = '$FlightID'");
    }
    public function GetFlight($StartFrom, $Quantity)
    {
        return GetObjectArray("select * from flight f, plane p, airline a, flightpath fp where f.PlaneID = p.PlaneID 
        and f.AirlineID = a.AirlineID and fp.PathID = f.PathID order by FlightID asc offset $StartFrom rows fetch next $Quantity row only");
    }
    public function SearchFlight($SQL)
    {
        return GetObjectArray("select * from flight f, plane p, airline a, flightpath fp where f.PlaneID = p.PlaneID 
        and f.AirlineID = a.AirlineID and fp.PathID = f.PathID" . $SQL);
    }
}
$FlightObject = new flight();
