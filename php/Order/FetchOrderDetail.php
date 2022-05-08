<?php require_once("../../class/order.php");
require_once("../../class/flight.php");
$OrderList = $OrderObject->GetOrder(" where OrderID='" . $_POST["OrderID"] . "'");
$Total = 0;
$TempArray = array();
$Array = array("Header" => array_keys($OrderList[0]), "Row" => []);
foreach ($OrderList as $Order) {
    $Price = trim(DecryptCiphertext(utf8_decode($Order["TOTALPRICE"])));
    $Total += $Price;
    $TempArray[] = [
        $Order["ORDERID"],
        trim(DecryptCiphertext(utf8_decode($Order["STARTFLIGHT"]))),
        trim(DecryptCiphertext(utf8_decode($Order["QUANTITY"]))),
        number_format($Price) . " VND",
        trim(DecryptCiphertext(utf8_decode($Order["STATE"]))),
        $Order["EMPLOYEEID"],
        $Order["ORDERDATE"],
        $Order["MEMBERID"],
        trim(DecryptCiphertext(utf8_decode($Order["CONTACTEMAIL"]))),
        trim(DecryptCiphertext(utf8_decode($Order["CONTACTNAME"]))),
        trim(DecryptCiphertext(utf8_decode($Order["ADDRESS"]))),
        trim(DecryptCiphertext(utf8_decode($Order["TOTALWEIGHT"]))),
        trim(DecryptCiphertext(utf8_decode($Order["RETURNFLIGHT"]))),
        trim(DecryptCiphertext(utf8_decode($Order["STARTDATE"]))),
        trim(DecryptCiphertext(utf8_decode($Order["RETURNDATE"])))
    ];
}
$TempArray[] = [''];
$TempArray[] = ['CHI TIẾT HÓA ĐƠN'];
$OrderDetailList = $OrderObject->GetOrderDetail($_POST["OrderID"]);
$TempArray[] = array_keys($OrderDetailList[0]);
foreach ($OrderDetailList as $OrderDetail) {
    $TempArray[] = [
        $OrderDetail["ORDERID"],
        $OrderDetail["TICKETID"],
        trim(DecryptCiphertext(utf8_decode($OrderDetail["PASSENGERNAME"]))),
        trim(DecryptCiphertext(utf8_decode($OrderDetail["AGE"]))),
        number_format(trim(DecryptCiphertext(utf8_decode($OrderDetail["TICKETPRICE"])))) . " VND",
        number_format($OrderDetail["PRICE"]) . " VND",
        $OrderDetail["WEIGHT"],
        trim(DecryptCiphertext(utf8_decode($OrderDetail["SEATCODE"]))),
        trim(DecryptCiphertext(utf8_decode($OrderDetail["CLASS"]))),
        trim(DecryptCiphertext(utf8_decode($OrderDetail["TYPE"]))),
    ];
}
$TempArray[] = ["Tổng thành tiền: " . number_format($Total) . " VND"];
$Array["Row"] = $TempArray;
die(json_encode($Array));
