<?php require_once("../../class/order.php");
session_start();
die($OrderObject->ChangeStatus($_POST["State"], $_POST["ID"], $_SESSION["Employee"]["EMPLOYEEID"]));
