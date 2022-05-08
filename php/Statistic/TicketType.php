<?php require_once("../../class/ticket.php");
$TicketArray = $TicketObject->GetTicketType("");
$Array = array("Class" => [], "Ticket" => []);
foreach ($TicketArray as $Ticket) {
    array_push($Array["Class"], $Ticket["CLASS"]);
    array_push($Array["Ticket"], $Ticket["TICKET"]);
}
die(json_encode($Array));
