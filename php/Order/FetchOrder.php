<?php require_once("../../class/order.php");
require_once("../../class/flight.php");
session_start();
if (isset($_SESSION["Member"])) {
    $OrderList = $OrderObject->GetOrder(" where MemberID = '" . $_SESSION["Member"][0]["MEMBERID"] . "'");
} else {
    $OrderList = $OrderObject->GetOrder('');
}
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
$TempArray[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', "Tổng thành tiền: " . number_format($Total) . " VND"];
$Array["Row"] = $TempArray;
die(json_encode($Array));
