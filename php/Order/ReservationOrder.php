<?php require_once("../../class/order.php");
require_once("../../class/flight.php");
require_once("../../class/flightpath.php");
session_start();
$OrderInfo = $_POST["OrderDetails"];
$FlightID = $OrderInfo["StartFlight"];
$Quantity = count($OrderInfo["CustomerInfo"]);
$Flight = $FlightObject->SearchFlight(" and FlightID = '$FlightID'")[0];
$StartFlightPath = $FlightPathObject->GetFlightPath(" and PathID = '" . $Flight["PATHID"] . "'")[0];
$StartFlightPathString = $StartFlightPath["CN1"] . " (" . $StartFlightPath["STARTAIRPORT"] . ") - " . $StartFlightPath["CN2"] . " (" . $StartFlightPath["ENDAIRPORT"] . ")";
$Flight2 = $ReturnDate = $EndFlightPathString = $EndFlightPath = '';
if (isset($OrderInfo["ReturnFlight"])) {
    $Flight2 = $FlightObject->SearchFlight(" and FlightID = '" . $OrderInfo["ReturnFlight"] . "'")[0];
    $EndFlightPath = $FlightPathObject->GetFlightPath(" and PathID = '" . $Flight2["PATHID"] . "'")[0];
    $EndFlightPathString = $EndFlightPath["CN1"] . " (" . $EndFlightPath["STARTAIRPORT"] . ") - " . $EndFlightPath["CN2"] . " (" . $EndFlightPath["ENDAIRPORT"] . ")";
    $ReturnDate = $Flight2["STARTDATE"];
}
$PriceDetails = [];
$TotalPrice = $TotalWeight = 0;
foreach ($OrderInfo["CustomerInfo"] as $o) {
    $AdultPrice = (trim(DecryptCiphertext(utf8_decode($Flight["ADULTPRICE"]))));
    $ChildrenPrice = (trim(DecryptCiphertext(utf8_decode($Flight["CHILDRENPRICE"]))));
    $ToddlerPrice = (trim(DecryptCiphertext(utf8_decode($Flight["TODDLERPRICE"]))));
    $TotalWeight += $o["BaggageWeight"];
    $TotalPrice += $o["BaggagePrice"];
    if (isset($OrderInfo["ReturnFlight"])) {
        $AdultPrice2 = (trim(DecryptCiphertext(utf8_decode($Flight2["ADULTPRICE"]))));
        $ChildrenPrice2 = (trim(DecryptCiphertext(utf8_decode($Flight2["CHILDRENPRICE"]))));
        $ToddlerPrice2 = (trim(DecryptCiphertext(utf8_decode($Flight2["TODDLERPRICE"]))));
        if ($o["Age"] == 'Người lớn' && $o["Class"] == 'Economy') {
            $TotalPrice += $AdultPrice2;
            $PriceDetails[] = $AdultPrice2;
        }
        if ($o["Age"] == 'Người lớn' && $o["Class"] == 'Business') {
            $TotalPrice += $AdultPrice2 * 2;
            $PriceDetails[] = $AdultPrice2 * 2;
        }
        if ($o["Age"] == 'Trẻ em' && $o["Class"] == 'Economy') {
            $TotalPrice += $ChildrenPrice2;
            $PriceDetails[] = $ChildrenPrice2;
        }
        if ($o["Age"] == 'Trẻ em' && $o["Class"] == 'Business') {
            $TotalPrice += $ChildrenPrice2 * 2;
            $PriceDetails[] = $ChildrenPrice2 * 2;
        }
        if ($o["Age"] == 'Em bé' && $o["Class"] == 'Economy') {
            $TotalPrice += $ToddlerPrice2;
            $PriceDetails[] = $ToddlerPrice2;
        }
        if ($o["Age"] == 'Em bé' && $o["Class"] == 'Business') {
            $TotalPrice += $ToddlerPrice2 * 2;
            $PriceDetails[] = $ToddlerPrice2 * 2;
        }
    }
    if ($o["Age"] == 'Người lớn' && $o["Class"] == 'Economy') {
        $TotalPrice += $AdultPrice;
        $PriceDetails[] = $AdultPrice;
    }
    if ($o["Age"] == 'Người lớn' && $o["Class"] == 'Business') {
        $TotalPrice += $AdultPrice * 2;
        $PriceDetails[] = $AdultPrice * 2;
    }
    if ($o["Age"] == 'Trẻ em' && $o["Class"] == 'Economy') {
        $TotalPrice += $ChildrenPrice;
        $PriceDetails[] = $ChildrenPrice;
    }
    if ($o["Age"] == 'Trẻ em' && $o["Class"] == 'Business') {
        $TotalPrice += $ChildrenPrice * 2;
        $PriceDetails[] = $ChildrenPrice * 2;
    }
    if ($o["Age"] == 'Em bé' && $o["Class"] == 'Economy') {
        $TotalPrice += $ToddlerPrice;
        $PriceDetails[] = $ToddlerPrice;
    }
    if ($o["Age"] == 'Em bé' && $o["Class"] == 'Business') {
        $TotalPrice += $ToddlerPrice * 2;
        $PriceDetails[] = $ToddlerPrice * 2;
    }
}
$OrderID = date("Ymdhis");
$MemberID = $_SESSION["Member"]["MEMBERID"];
$ContactEmail = $OrderInfo["ContactEmail"];
$ContactName = $OrderInfo["ContactName"];
$Address = $OrderInfo["Address"];
$OrderArray = array(
    'OrderID' => $OrderID, "StartDate" => $Flight["STARTDATE"], "ReturnDate" => $ReturnDate, 'StartFlight' => $StartFlightPathString,
    'Quantity' => $Quantity, 'TotalPrice' => $TotalPrice, 'State' => "Đã thanh toán", 'EmployeeID' => 'null', 'OrderDate' => '',
    'MemberID' => $MemberID, 'ContactEmail' => $ContactEmail, 'ContactName' => $ContactName, 'Address' => $Address,
    'TotalWeight' => $TotalWeight, "ReturnFlight" => $EndFlightPathString
);
$i = 0;
$OrderDetailsArray = array();
foreach ($OrderInfo["CustomerInfo"] as $o) {
    if ($o["BaggageID"] == '') {
        $BaggageID = '';
    } else {
        $BaggageID = $o["BaggageID"];
    }
    $Bruh = array(
        "OrderID" => $OrderID, "TicketID" => $o['TicketID'], "PassengerName" => $o["PassengerName"],
        "Age" => $o["Age"], "TicketPrice" => $PriceDetails[$i], "SeatCode" => $o["SeatCode"],
        "Class" => $o["Class"], "Type" => $o["Type"], "BaggageID" => $BaggageID
    );
    $OrderDetailsArray[] = $Bruh;
    $i++;
}
$_SESSION["Order"] = $OrderArray;
$_SESSION["OrderDetail"] = $OrderDetailsArray;
die(json_encode($OrderDetailsArray));
