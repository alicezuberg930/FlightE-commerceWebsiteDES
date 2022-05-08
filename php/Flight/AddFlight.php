<?php require_once("../../class/flight.php");
require_once("../../class/ticket.php");
$FlightTime = GetObjectArray("select Time from flightpath where PathID = '" . $_POST["PathID"] . "'")[0];
$Time = explode(":", trim(DecryptCiphertext(utf8_decode($FlightTime["TIME"]))));
$CurrentDate = ($_POST["StartDate"] . "T" . $_POST["StartTime"]);
$CurrentDateClass = new DateTime($CurrentDate);
$ModifyDate =  ("+" . $Time[0] . " hour +" . $Time[1] . " minute");
$CurrentDateClass->modify($ModifyDate);
$PlaneDetails = explode("-", $_POST["Airplane"]);
$Array = array(
    'StartDate' => date("d-m-Y", strtotime($_POST["StartDate"])), 'StartTime' => $_POST["StartTime"], 'EndTime' => $CurrentDateClass->format("H:i"),
    'PlaneID' => $PlaneDetails[0], 'AirlineID' => $_POST["AirlineID"], 'PathID' => $_POST["PathID"], 'EndDate' => $CurrentDateClass->format("d-m-Y"),
    'AdultPrice' => $_POST["AdultPrice"], 'ChildrenPrice' => $_POST["ChildrenPrice"], 'ToddlerPrice' => $_POST["ToddlerPrice"]
);
$FlightAddCheck = $FlightObject->AddFlight($Array);
if ($FlightAddCheck != 0) {
    $FlightID = GetObjectArray("select max(FlightID) as MaxID from flight")[0];
    $Array = array('State' => 'Empty', 'SeatCode' => '', 'FlightID' => $FlightID["MAXID"], 'Class' => '');
    for ($row = 1; $row <= $PlaneDetails[1]; $row++) {
        $letter = "A";
        if ($row <= $PlaneDetails[3]) {
            $Array["Class"] = 'Business';
        } else {
            $Array["Class"] =  'Economy';
        }
        for ($column = 0; $column < $PlaneDetails[2]; $column++) {
            $Array["SeatCode"] = $row . $letter;
            $TicketObject->AddTicket($Array);
            $letter++;
        }
    }
}
die("<h3>Thêm chuyến bay và vé thành công</h3>");
