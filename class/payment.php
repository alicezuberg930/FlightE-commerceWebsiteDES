<?php require_once("../../connection.php");
class payment
{
    public function AddPayment($PaymentArray)
    {
        $OrderID = $PaymentArray["OrderID"];
        $Total = $PaymentArray["Total"];
        $Note = $PaymentArray["Note"];
        $vnp_response_code = $PaymentArray["vnp_response_code"];
        $code_vnpay = $PaymentArray["code_vnpay"];
        $BankCode = $PaymentArray["BankCode"];
        $PaymentTime = $PaymentArray["PaymentTime"];
        return Query("INSERT INTO `payments`(`OrderID`, `Total`, `Note`, `vnp_response_code`, `code_vnpay`, `BankCode`, `PaymentTime`) 
        VALUES ('" . $OrderID . "','" . $Total . "','" . $Note . "','" . $vnp_response_code . "','" . $code_vnpay . "','" . $BankCode . "','" . $PaymentTime . "')");
    }
}
$PaymenObject = new payment();
