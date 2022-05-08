<?php require_once("../../class/flight.php");
require_once("../../class/ticket.php");
$Query = $FlightObject->DeleteFlight($_POST["ID"]);
if ($Query != 0) {
    $TicketObject->DeleteTicket($_POST["ID"]);
}
echo $Query;