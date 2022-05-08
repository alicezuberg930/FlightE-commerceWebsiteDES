<?php require_once("../../connection.php");
class country
{
    public function GetCountry()
    {
        return GetObjectArray("select * from country");
    }
}
$CountryObject = new country();
