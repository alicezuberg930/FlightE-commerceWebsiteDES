<?php require_once("../../connection.php");
class city
{
    public function GetCity()
    {
        return GetObjectArray("select * from city");
    }
}
$CityObject = new city();
