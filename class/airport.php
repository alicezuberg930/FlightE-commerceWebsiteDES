<?php require_once("../../connection.php");
require_once("../../DESAlgorithm.php");
class airport
{
    public function SearchAirport($SQL)
    {
        return GetObjectArray("SELECT * FROM airport a, city c, country ctr where a.CityID = c.CityID and 
        c.CountryID = ctr.CountryID" . $SQL);
    }
    public function GetAirport($Start, $Quantity)
    {
        return GetObjectArray("SELECT * FROM airport a, city c, country ctr where a.CityID = c.CityID and 
        c.CountryID = ctr.CountryID offset $Start rows fetch next $Quantity row only");
    }
    public function AddAirport($Obj)
    {
        $AirportID = $Obj["AirportID"];
        $CityID = $Obj["CityID"];
        $AirportName = utf8_encode(EncryptPlaintext($Obj["AirportName"]));
        $Length = utf8_encode(EncryptPlaintext($Obj["Length"]));
        return Query("INSERT INTO airport(AirportID, AirportName, CityID, Length) VALUES ('" . $AirportID . "',
        q'[" . $AirportName . "]','" . $CityID . "',q'[" . $Length . "]')");
    }
    public function DeleteAirport($ID)
    {
        return Query("delete from airport where AirportID = '$ID'");
    }
    public function UpdateAirport($Obj)
    {
        $AirportID = $Obj["AirportID"];
        $CityID = $Obj["CityID"];
        $AirportName = utf8_encode(EncryptPlaintext($Obj["AirportName"]));
        $Length = utf8_encode(EncryptPlaintext($Obj["Length"]));
        $HiddenAirportID = $Obj["HiddenAirportID"];
        return Query("UPDATE airport SET AirportID='" . $AirportID . "',AirportName=q'[" . $AirportName . "]',CityID='" . $CityID . "',Length=q'[" . $Length . "]' 
        WHERE AirportID = '" . $HiddenAirportID . "'");
    }
}
$AirportObject = new airport();
