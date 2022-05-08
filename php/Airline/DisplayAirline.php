<?php require_once("../../class/airline.php");
session_start();
$Start = ($_POST["p"] - 1) * 10;
$AirlineList = $AirlineObject->GetAirline($Start, 10);
$Array = array('CardBody' => '', 'CardFooter' => '', 'Page' => '');
foreach ($AirlineList as $Airline) {
    $AirlineID = $Airline["AIRLINEID"];
    $AirlineName = $Airline["AIRLINENAME"];
    $CountryName = $Airline["COUNTRYNAME"];
    $AirlineImage = $Airline["AIRLINEIMAGE"];
    if ($_SESSION["Employee"]["ROLE"] == "Quản trị viên") {
        $AirlineName = trim(DecryptCiphertext(utf8_decode($AirlineName)));
        $AirlineImage = trim(DecryptCiphertext(utf8_decode($AirlineImage)));
    }
    $Array["CardBody"] .= '<tr data-countryid="' . $Airline["COUNTRYID"] . '">
    <td>' . $AirlineID . '</td>
    <td>' . $AirlineName . '</td>
    <td>' . $CountryName . '</td>
    <td><img style="object-fit: contain;" alt="' . $AirlineImage . '" style="" width="200" height=70" src="../icon/' . $AirlineImage . '"></td>
    <td><button id="Delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></td>
    <td><button id="Edit" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></button></td>
</tr>';
}
$NumberOfPages = ceil(GetRows("select count(*) as NUMBER_OF_ROWS from airline") / 10);
for ($i = 1; $i <= $NumberOfPages; $i++) {
    $Array['CardFooter'] .= '<span>' . $i . '</span> ';
}
$Array['Page'] = $NumberOfPages;
die(json_encode($Array));
