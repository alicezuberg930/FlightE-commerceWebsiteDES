<?php require_once("../../connection.php");
class ticket
{
    public function AddTicket($Obj)
    {
        $State = $Obj["State"];
        $SeatCode = $Obj["SeatCode"];
        $FlightID = $Obj["FlightID"];
        $Class = $Obj["Class"];
        return Query("insert into ticket(State,SeatCode,FlightID,Class) 
        values('$State','$SeatCode','$FlightID','$Class')");
    }
    public function DeleteTicket($ID)
    {
        return Query("delete from ticket where FlightID = '$ID'");
    }
    public function GetTicket($SQL)
    {
        return GetObjectArray("select * from ticket" . $SQL);
    }
    public function GetTicketType()
    {
        return GetObjectArray("select count(*) Ticket, t.Class from ticket t, orderdetails od where od.TicketID = t.TicketID group by t.Class");
    }
}
$TicketObject  = new ticket();
