<?php $vnp_TmnCode = "Y4U88XFK"; //Mã website tại VNPAY 
$vnp_HashSecret = "DTHXNFNBUMNKFKQOZVHTXUXNUQUUXMTV"; //Chuỗi bí mật
$vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost/projects/QuanLyVeMayBay/vnpay_php/vnpay_return.php";
require_once("../DESAlgorithm.php");
function AddOrder($order)
{
    $OrderID = $order["OrderID"];
    $EmployeeID = $order["EmployeeID"];
    $MemberID = $order["MemberID"];
    $StartFlight = utf8_encode(EncryptPlaintext($order["StartFlight"]));
    $Quantity = utf8_encode(EncryptPlaintext($order["Quantity"]));
    $TotalPrice = utf8_encode(EncryptPlaintext($order["TotalPrice"]));
    $State  = utf8_encode(EncryptPlaintext($order["State"]));
    $OrderDate = $order["OrderDate"];
    $ContactEmail = utf8_encode(EncryptPlaintext($order["ContactEmail"]));
    $ContactName = utf8_encode(EncryptPlaintext($order["ContactName"]));
    $Address = utf8_encode(EncryptPlaintext($order["Address"]));
    $TotalWeight = utf8_encode(EncryptPlaintext($order["TotalWeight"]));
    $StartDate = $order["StartDate"];
    $ReturnDate = $order["ReturnDate"];
    $ReturnFlight = utf8_encode(EncryptPlaintext($order["ReturnFlight"]));
    if ($ReturnDate == '') {
        $sql = "INSERT INTO orders(OrderID,StartDate,StartFlight,Quantity,TotalPrice,State,EmployeeID,OrderDate,MemberID,ContactEmail,ContactName,Address,TotalWeight) 
        VALUES('" . $OrderID . "',q'[$StartDate]',q'[" . $StartFlight . "]',q'[" . $Quantity . "]',q'[" . $TotalPrice . "]',q'[" . $State . "]',$EmployeeID,'$OrderDate','" . $MemberID . "',q'[" . $ContactEmail . "]',
        '" . $ContactName . "','" . $Address . "','" . $TotalWeight . "')";
    } else {
        $sql  = "INSERT INTO orders(OrderID,StartDate,ReturnDate,StartFlight,Quantity,TotalPrice,State,EmployeeID,OrderDate,MemberID,ContactEmail,ContactName,Address,TotalWeight,ReturnFlight) 
        VALUES('" . $OrderID . "',q'[$StartDate]',q'[$ReturnDate]',q'[" . $StartFlight . "]',q'[" . $Quantity . "]',q'[" . $TotalPrice . "]',q'[" . $State . "]',$EmployeeID,'$OrderDate'),'" . $MemberID . "',q'[" . $ContactEmail . "]',
        q'[" . $ContactName . "]',q'[" . $Address . "]',q'[" . $TotalWeight . "]',q'[" . $ReturnFlight . "]')";
    }
    return Query($sql);
}

function AddOrderDetails($orderdetails)
{
    $i = 1;
    foreach ($orderdetails as $detail) {
        $OrderID = $detail["OrderID"];
        $TicketID = $detail["TicketID"];
        $BaggageID = $detail["BaggageID"];
        $PassengerName = utf8_encode(EncryptPlaintext($detail["PassengerName"]));
        $Age = utf8_encode(EncryptPlaintext($detail["Age"]));
        $TicketPrice = utf8_encode(EncryptPlaintext($detail["TicketPrice"]));
        $SeatCode = utf8_encode(EncryptPlaintext($detail["SeatCode"]));
        $Class = utf8_encode(EncryptPlaintext($detail["Class"]));
        $Type = utf8_encode(EncryptPlaintext($detail["Type"]));
        Query("UPDATE ticket SET State = 'Occupied' WHERE TicketID = '" . $TicketID . "'");
        if (Query("INSERT INTO orderdetails(OrderID,TicketID,PassengerName,Age,TicketPrice,SeatCode,Class,Type,BaggageID) 
            VALUES('" . $OrderID . "','" . $TicketID . "',q'[" . $PassengerName . "]',q'[" . $Age . "]',q'[" . $TicketPrice . "]',q'[" . $SeatCode . "]',
            q'[" . $Class . "]',q'[" . $Type . "]','" . $BaggageID . "')") == 0) {
            $i = 0;
        }
    }
    return $i;
}

function AddPayment($PaymentArr)
{
    $OrderID = $PaymentArr["OrderID"];
    $Total = $PaymentArr["Total"];
    $Note = $PaymentArr["Note"];
    $vnp_response_code = $PaymentArr["vnp_response_code"];
    $code_vnpay = $PaymentArr["code_vnpay"];
    $BankCode = $PaymentArr["BankCode"];
    $PaymentTime = $PaymentArr["PaymentTime"];
    return Query("INSERT INTO payments(OrderID,Total,Note,vnp_response_code,code_vnpay,BankCode,PaymentTime) 
        VALUES ('" . $OrderID . "','" . $Total . "','" . $Note . "','" . $vnp_response_code . "','" . $code_vnpay . "','" . $BankCode . "',to_date('$PaymentTime','dd-mm-yyyy'))");
}
