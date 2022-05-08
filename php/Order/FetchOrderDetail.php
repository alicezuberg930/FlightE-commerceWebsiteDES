<?php require_once("../../class/order.php");
require_once("../../class/flight.php");
$OrderList = $OrderObject->GetOrder(" where OrderID='" . $_POST["OrderID"] . "'");
$Total = 0;
$Array = array("Header" => array_keys($OrderList[0]), "Row" => []);
$TempArray = array();
foreach ($OrderList as $Order) {
    $Total += $Order["TOTALPRICE"];
    $TempArray[] = [
        $Order["ORDERID"],
        $Order["STARTFLIGHT"],
        $Order["QUANTITY"],
        number_format($Order["TOTALPRICE"]) . " VND",
        $Order["STATE"],
        $Order["EMPLOYEEID"],
        $Order["ORDERDATE"],
        $Order["MEMBERID"],
        $Order["CONTACTEMAIL"],
        $Order["CONTACTNAME"],
        $Order["ADDRESS"],
        $Order["TOTALWEIGHT"] . " kg",
        $Order["RETURNFLIGHT"],
        $Order["STARTDATE"],
        $Order["RETURNDATE"]
    ];
}
$TempArray[] = [''];
$TempArray[] = ['', '', '', '', 'Chi tiết hóa đơn'];
$OrderDetailList = $OrderObject->GetOrderDetail($_POST["OrderID"]);
$TempArray[] = array_keys($OrderDetailList[0]);
foreach ($OrderDetailList as $OrderDetail) {
    $TempArray[] = [
        $OrderDetail["ORDERID"],
        $OrderDetail["TICKETID"],
        $OrderDetail["PASSENGERNAME"],
        $OrderDetail["AGE"],
        number_format($OrderDetail["TICKETPRICE"]) . " VND",
        number_format($OrderDetail["PRICE"]) . " VND",
        $OrderDetail["WEIGHT"] . " kg",
        $OrderDetail["SEATCODE"],
        $OrderDetail["CLASS"],
        $OrderDetail["TYPE"],
    ];
}
$TempArray[] = ["Tổng thành tiền: " . number_format($Total) . " VND"];
$Array["Row"] = $TempArray;
die(json_encode($Array));
