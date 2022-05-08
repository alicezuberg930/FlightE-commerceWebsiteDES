<?php require_once("../../class/order.php");
session_start();
$OrderDetailHTML = $Age = '';
$OrderDetailList = $OrderObject->GetOrderDetail($_POST["OrderID"]);
foreach ($OrderDetailList as $OrderDetail) {
    $Age = $OrderDetail["AGE"];
    $OrderID = $OrderDetail["ORDERID"];
    $TicketID = $OrderDetail["TICKETID"];
    $PassengerName = $OrderDetail["PASSENGERNAME"];
    $TicketPrice = $OrderDetail["TICKETPRICE"];
    $Price = $OrderDetail["PRICE"];
    $Weight = $OrderDetail["WEIGHT"];
    $SeatCode = $OrderDetail["SEATCODE"];
    $Class = $OrderDetail["CLASS"];
    $Type = $OrderDetail["TYPE"];
    if ((isset($_SESSION["Employee"]) && ($_SESSION["Employee"]["ROLE"] == "Bán hàng" || $_SESSION["Employee"]["ROLE"] == "Quản trị viên")) || isset($_SESSION["Member"])) {
        $PassengerName = trim(DecryptCiphertext(utf8_decode($PassengerName)));
        $Age = trim(DecryptCiphertext(utf8_decode($Age)));
        $TicketPrice = number_format(trim(DecryptCiphertext(utf8_decode($TicketPrice))));
        $SeatCode = trim(DecryptCiphertext(utf8_decode($SeatCode)));
        $Class = trim(DecryptCiphertext(utf8_decode($Class)));
        $Type = trim(DecryptCiphertext(utf8_decode($Type)));
    }
    $OrderDetailHTML .= "<tr data-orderid='" . $OrderDetail["ORDERID"] . "'>
        <td>" . $OrderID . "</td>
        <td>" . $TicketID . "</td>
        <td>" . $PassengerName . "</td>
        <td>" . $Age . "</td>
        <td>" . $TicketPrice . " VND</td>
        <td>" . number_format($Price) . " VND</td>
        <td>" . $Weight . "</td>
        <td>" . $SeatCode . "</td>
        <td>" . $Class . "</td>
        <td>" . $Type . "</td>
    </tr>";
}
die($OrderDetailHTML);
