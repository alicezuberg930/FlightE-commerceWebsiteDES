<?php require_once("../../class/country.php");
$String = '';
$CountryList = $CountryObject->GetCountry();
foreach ($CountryList as $Country) {
    $String .= '<option value="' . $Country["COUNTRYID"] . '">' . $Country["COUNTRYNAME"] . '</option>';
}
die($String);
