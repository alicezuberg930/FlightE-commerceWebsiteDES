<?php require_once("../../class/flight.php");
require_once("../../class/flightpath.php");
require_once("../../DESAlgorithm.php");
session_start();
$Flight = $FlightObject->SearchFlight(" and FlightID = '" . $_POST["FlightID"] . "'")[0];
$Flightpath = $FlightPathObject->GetFlightPath(" and PathID = '" . $Flight["PATHID"] . "'")[0];
$CN1 = $Flightpath["CN1"];
$CN2 = $Flightpath["CN2"];
$AN1 = $Flightpath["AN1"];
$AN2 = $Flightpath["AN2"];
$EndTime = $Flight["ENDTIME"];
$EndDate = $Flight["ENDDATE"];
$Time = $Flightpath["TIME"];
if ($_SESSION["Employee"]["ROLE"] == "Quản trị viên") {
    $AN1 = trim(DecryptCiphertext(utf8_decode($AN1)));
    $AN2 = trim(DecryptCiphertext(utf8_decode($AN2)));
    $EndTime = trim(DecryptCiphertext(utf8_decode($EndTime)));
    $EndDate = trim(DecryptCiphertext(utf8_decode($EndDate)));
    $Time = trim(DecryptCiphertext(utf8_decode($Time)));
}
$String = '<tr>
<td>' . $CN1 . '</td>
<td>' . $CN2 . '</td>
<td>' . $AN1 . '</td>
<td>' . $AN2 . '</td>
<td>' . $EndTime . '</td>
<td>' . $EndDate . '</td>
<td>' . $Time . '</td>
</tr>';
die($String);
