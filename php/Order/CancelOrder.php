<?php require_once("../../class/order.php");
die($OrderObject->CancelOrder($_POST["OrderID"]));