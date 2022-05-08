<?php require_once("../../connection.php");
class baggage
{
    public function GetBaggage()
    {
        return GetObjectArray("select * from baggage ");
    }
}
$BaggageObject = new baggage();
