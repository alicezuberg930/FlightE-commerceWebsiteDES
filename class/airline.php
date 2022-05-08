<?php require_once("../../connection.php");
require_once("../../DESAlgorithm.php");
class airline
{
    public function GetAirline($StartFrom, $Quantity)
    {
        return GetObjectArray("select * from airline a, country c where c.CountryID = a.CountryID order by AirlineID asc offset $StartFrom rows fetch next $Quantity row only");
    }
    public function AddAirline($Obj)
    {
        $AirlineID = $Obj["AirlineID"];
        $CountryID = $Obj["CountryID"];
        $AirlineName = utf8_encode(EncryptPlaintext($Obj["AirlineName"]));
        $AirlineImage = utf8_encode(EncryptPlaintext($Obj["AirlineImage"]));
        return Query("insert into airline(AirlineID, AirlineName, CountryID, AirlineImage) 
        values('" . $AirlineID . "', q'[" . $AirlineName . "]','" . $CountryID . "', q'[" . $AirlineImage . "]')");
    }
    public function DeleteAirline($ID)
    {
        return Query("delete from airline where AirlineID = '" . $ID . "'");
    }
    public function UpdateAirline($Obj)
    {
        $HiddenAirlineID = $Obj["HiddenAirlineID"];
        $AirlineID = $Obj["AirlineID"];
        $AirlineName = utf8_encode(EncryptPlaintext($Obj["AirlineName"]));
        $CountryID = $Obj["CountryID"];
        $AirlineImage = utf8_encode(EncryptPlaintext($Obj["AirlineImage"]));
        if ($AirlineImage == '') {
            return Query("UPDATE airline SET AirlineID='" . $AirlineID . "',AirlineName=q'[" . $AirlineName . "]',CountryID='" . $CountryID . "' WHERE AirlineID = '" . $HiddenAirlineID . "'");
        } else {
            return Query("UPDATE airline SET AirlineID='" . $AirlineID . "',AirlineName=q'[" . $AirlineName . "]',CountryID='" . $CountryID . "', AirlineImage=q'[" . $AirlineImage . "]' WHERE AirlineID = '" . $HiddenAirlineID . "'");
        }
    }
    public function SearchFlight($SQL)
    {
        return GetObjectArray("select * from flight f, plane p, airline a, flightpath fp where f.PlaneID = p.PlaneID 
        and f.AirlineID = a.AirlineID and fp.PathID = f.PathID" . $SQL);
    }
    public function SearchAirline($SQL)
    {
        return GetObjectArray("select * from airline a, country c where c.CountryID = a.CountryID" . $SQL);
    }
}
$AirlineObject = new airline();
