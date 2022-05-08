<?php require_once("../../class/airport.php");
session_start();
$Start = ($_POST["p"] - 1) * 5;
$AirportList = $AirportObject->GetAirport($Start, 5);
$Array = array('CardBody' => '', 'CardFooter' => '', 'Page' => '');
foreach ($AirportList as $Airport) {
    $AirportID = $Airport["AIRPORTID"];
    $AirportName = $Airport["AIRPORTNAME"];
    $CityName = $Airport["CITYNAME"];
    $Length = $Airport["LENGTH"];
    $Country = $Airport["COUNTRYNAME"];
    if ($_SESSION["Employee"]["ROLE"] == "Quản trị viên") {
        $AirportName = DecryptCiphertext(utf8_decode($AirportName));
        $Length = DecryptCiphertext(utf8_decode($Length));
    }
    $Array["CardBody"] .= '<tr data-cityid="' . $Airport["CITYID"] . '">
    <td>' . $AirportID . '</td>
    <td>' . $AirportName . '</td>
    <td>' . $CityName . '</td>
    <td>' . $Length . ' km</td>
    <td>' . $Country . '</td>
    <td><button id="Delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></td>
    <td><button id="Edit" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></button></td>
</tr>';
}
$NumberOfPages = ceil(GetRows("select count(*) as NUMBER_OF_ROWS from airport") / 5);
for ($i = 1; $i <= $NumberOfPages; $i++) {
    $Array['CardFooter'] .= '<span>' . $i . '</span> ';
}
$Array['Page'] = $NumberOfPages;
die(json_encode($Array));
