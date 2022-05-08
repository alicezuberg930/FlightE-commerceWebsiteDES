<?php require_once("../../class/Member.php");
session_start();
if (isset($_SESSION["Member"])) {
    die(json_encode($_SESSION["Member"]));
}
if (isset($_SESSION["EMployee"])) {
    die(json_encode($_SESSION["Employee"]));
}
