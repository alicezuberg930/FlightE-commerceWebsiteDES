<?php require_once("../../connection.php");
require_once("../../DESAlgorithm.php");
class order
{
    public function CancelOrder($ID)
    {
        $State = utf8_encode(EncryptPlaintext("Đã hủy"));
        return Query("update orders set State = q'[" . $State . "]' where OrderID = '" . $ID . "'");
    }
    public function DeleteOrderDetail($ID)
    {
        $TicketArray = GetObjectArray("select TicketID from orderdetails where OrderID = '" . $ID . "'");
        foreach ($TicketArray as $Ticket) {
            Query("update ticket set State = 'Empty' where TicketID = '" . $Ticket["TicketID"] . "'");
        }
        Query("delete from orderdetails where OrderID = '" . $ID . "'");
    }
    public function GetOrder($SQL)
    {
        return GetObjectArray("select * from orders" . $SQL);
    }
    public function GetOrders()
    {
        return GetObjectArray("select * from orderdetails od, orders o where od.OrderID = o.OrderID");
    }
    public function GetOrderDetail($ID)
    {
        return GetObjectArray("select * from orderdetails o left join baggage b on o.BaggageID = b.BaggageID where o.OrderID = '" . $ID . "'");
    }
    public function ChangeStatus($State, $ID, $EmployeeID)
    {
        $State = utf8_encode(EncryptPlaintext($State));
        return Query("update orders set EmployeeID = '" . $EmployeeID . "' , State = q'[" . $State . "]' where OrderID = '" . $ID . "'");
    }
}
$OrderObject = new order();
