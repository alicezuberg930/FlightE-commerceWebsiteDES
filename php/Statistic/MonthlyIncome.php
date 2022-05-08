<?php require_once("../../class/order.php");
$OrderArray = $OrderObject->GetOrder("");
$Array = array("Date" => [], "Total" => []);
$Date = date_create($_POST["Date"]);
for ($i = 1; $i <= 12; $i++) {
    $TimeString = date_format($Date, "m-Y");
    array_push($Array["Date"], $TimeString);
    date_sub($Date, date_interval_create_from_date_string("1 month"));
    $Total = 0;
    foreach ($OrderArray as $Order) {
        if ($TimeString == date('m-Y', strtotime($Order["ORDERDATE"])))
            $Total += DecryptCiphertext(utf8_decode($Order["TOTALPRICE"]));
    }
    array_push($Array["Total"], $Total);
}
die(json_encode($Array));
