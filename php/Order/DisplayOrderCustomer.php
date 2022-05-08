<?php require_once("../../class/order.php");
session_start();
if (isset($_SESSION["Payment"]) && isset($_SESSION["Order"]) && isset($_SESSION["OrderDetail"])) {
    unset($_SESSION["Payment"]);
    unset($_SESSION["Order"]);
    unset($_SESSION["OrderDetail"]);
}
$UserID = $OrderHTML = $ReturnDate  = '';
$i = 1;
if (isset($_SESSION["Member"]))
    $UserID = $_SESSION["Member"]["MEMBERID"];
$OrderList = $OrderObject->GetOrder(" where MemberID = '" . $UserID . "' order by OrderDate desc");
if (sizeof($OrderList) != 0) {
    foreach ($OrderList as $Order) {
        if (!empty($Order["RETURNDATE"])) {
            $ReturnDate = date("d-m-Y", strtotime(trim(DecryptCiphertext(utf8_decode($Order["RETURNDATE"])))));
        } else {
            $ReturnDate = '';
        }
        $OrderDate = $Order["ORDERDATE"];
        $TotalPrice = trim(DecryptCiphertext(utf8_decode($Order["TOTALPRICE"])));
        $TotalWeight = trim(DecryptCiphertext(utf8_decode($Order["TOTALWEIGHT"])));
        $Quantity = trim(DecryptCiphertext(utf8_decode($Order["QUANTITY"])));
        $Startflight = trim(DecryptCiphertext(utf8_decode($Order["STARTFLIGHT"])));
        $StarDate = trim(DecryptCiphertext(utf8_decode($Order["STARTDATE"])));
        $Returnflight = trim(DecryptCiphertext(utf8_decode($Order["RETURNFLIGHT"])));
        $State = trim(DecryptCiphertext(utf8_decode($Order["STATE"])));
        $OrderHTML .= "<tr data-id='" . $Order["ORDERID"] . "'>
            <td>" . date("d-m-Y", strtotime($OrderDate))  . "</td>
            <td>" . number_format($TotalPrice) . " VND</td>
            <td>" . $TotalWeight . " kg</td>
            <td>" . $Quantity . "</td>
            <td>" . $Startflight . "</td>
            <td>" . date("d-m-Y", strtotime($StarDate))  . "</td>
            <td>" . $Returnflight . "</td>
            <td>" . $ReturnDate  . "</td>
            <td>" . $State . "</td>
            <td><button id='cancel' class='btn bg-danger btn-sm'><i class='fas fa-trash-alt'></i></button></td>
            <td><button id='detail' class='btn bg-info btn-sm'><i class='fas fa-info-circle'></i></button></td>
        </tr>";
        $i++;
    }
} else {
    $OrderHTML = "<tr><td colspan='12' style='font-size: 2rem;' class='text-center'>Không có đơn hàng</td></tr>";
}
die($OrderHTML);
