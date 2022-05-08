<?php require_once("../../class/airport.php");
$AirportID = $_POST["AirportID"];
$AirportName = $_POST["AirportName"];
$CityName = $_POST["CityName"];
$CountryName = $_POST["CountryName"];
$AirportList = $String = '';
if ($AirportID != '')
    $AirportList = $AirportObject->SearchAirport(" and AirportID like '%" . $AirportID . "%'");
if ($AirportName != '')
    $AirportList = $AirportObject->SearchAirport(" and AirportName like '%" . $AirportName . "%'");
if ($CityName != '')
    $AirportList = $AirportObject->SearchAirport(" and CityName like '%" . $CityName . "%'");
if ($CountryName != '')
    $AirportList = $AirportObject->SearchAirport(" and CountryName like '%" . $CountryName . "%'");
foreach ($AirportList as $Airport) {
    $String .= '<tr data-cityid="' . $Airport["CITYID"] . '">
    <td>' . $Airport["AIRPORTID"] . '</td>
    <td>' . $Airport["AIRPORTNAME"] . '</td>
    <td>' . $Airport["CITYNAME"] . '</td>
    <td>' . $Airport["LENGTH"] . ' km</td>
    <td>' . $Airport["COUNTRYNAME"] . '</td>
    <td><button id="Delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></td>
    <td><button id="Edit" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></button></td>
</tr>';
}
die($String);
