<?php session_start();
$Member = $Employee = $State = array("Membername" => '', "Employeename" => '', "Email" => '', 'Role' => '');
if (isset($_SESSION["Member"])) {
    $Member = $_SESSION["Member"];
    $State["Membername"] = $Member["FULLNAME"];
}
if (isset($_SESSION["Employee"])) {
    $Employee = $_SESSION["Employee"];
    $State["Employeename"] = $Employee["FULLNAME"];
    $State["Email"] = $Employee["EMAIL"];
    $State["Role"] = $Employee["ROLE"];
}
die(json_encode($State));
