<?php require_once("../../class/order.php");
$OrderArray = $OrderObject->GetOrders(" and o.OrderID='" . $_POST["OrderID"] . "'");
foreach ($OrderArray as $Order) {
    Query("update ticket set State='Empty' where TicketID='" . $Order["TICKETID"] . "'");
}
die($OrderObject->CancelOrder($_POST["OrderID"]));
