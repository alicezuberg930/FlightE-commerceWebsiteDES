<?php require_once("../../class/flight.php");
require_once("../../class/flightpath.php");
$SearchResult = $_POST["SearchResult"];
$Array = array("Error" => '', "FirstList" => '', "SecondList" => '');
$Sort1 = $Sort2 = $Sort3 = $Sort4 = 0;
$AirlineID = $StartTimeArray = $EndTimeArray = "";
if (isset($SearchResult["AirlineID"]) && !empty($SearchResult["AirlineID"])) {
  $AirlineID = " and a.AirlineID = '" . $SearchResult["AirlineID"] . "'";
}
$TempFlightList = $FlightObject->SearchFlight(" and fp.PathID = '" . $SearchResult["StartAirport"] . "-" . $SearchResult["EndAirport"] . "'$AirlineID");
if (isset($SearchResult["StartTime"]) && !empty($SearchResult["StartTime"])) {
  $Sort1 = 1;
  $StartTimeArray = explode("-", $SearchResult["StartTime"]);
} else {
  $Sort1 = 0;
}
if (isset($SearchResult["EndTime"]) && !empty($SearchResult["EndTime"])) {
  $Sort2 = 1;
  $EndTimeArray = explode("-", $SearchResult["EndTime"]);
} else {
  $Sort2 = 0;
}
if (isset($SearchResult["SortValue"]) && !empty($SearchResult["SortValue"])) {
  $Sort3 = 1;
} else {
  $Sort3 = 0;
}
function Push($Flight)
{
  $TempFlight = array(
    "TIME" => strtotime(trim(DecryptCiphertext(utf8_decode($Flight["TIME"])))),
    "ADULTPRICE" => trim(DecryptCiphertext(utf8_decode($Flight["ADULTPRICE"]))),
    "CHILDRENPRICE" => trim(DecryptCiphertext(utf8_decode($Flight["CHILDRENPRICE"]))),
    "TODDLERPRICE" => trim(DecryptCiphertext(utf8_decode($Flight["TODDLERPRICE"]))),
    "AIRLINENAME" => trim(DecryptCiphertext(utf8_decode($Flight["AIRLINENAME"]))),
    "AIRLINEID" => $Flight["AIRLINEID"],
    "FLIGHTID" => $Flight["FLIGHTID"],
    "PLANEID" => $Flight["PLANEID"],
    "STARTTIME" => trim(DecryptCiphertext(utf8_decode($Flight["STARTTIME"]))),
    "ENDTIME" => trim(DecryptCiphertext(utf8_decode($Flight["ENDTIME"]))),
    "STARTDATE" => trim(DecryptCiphertext(utf8_decode($Flight["STARTDATE"]))),
    "ENDDATE" => trim(DecryptCiphertext(utf8_decode($Flight["ENDDATE"]))),
    "PLANENAME" => trim(DecryptCiphertext(utf8_decode($Flight["PLANENAME"]))),
    "AIRLINEIMAGE" => trim(DecryptCiphertext(utf8_decode($Flight["AIRLINEIMAGE"])))
  );
  return $TempFlight;
}
$FlightList = [];
foreach ($TempFlightList as $Flight) {
  $StartDate = trim(DecryptCiphertext(utf8_decode($Flight["STARTDATE"])));
  if (strtotime($SearchResult["StartDate"]) == strtotime($StartDate)) {
    array_push($FlightList, Push($Flight));
  }
}
$TempArr = [];
if ($Sort1 == 1 && $Sort2 == 1) {
  foreach ($TempFlightList as $Flight) {
    $StartTime = trim(DecryptCiphertext(utf8_decode($Flight["STARTTIME"])));
    $EndTime = trim(DecryptCiphertext(utf8_decode($Flight["ENDTIME"])));
    if (strtotime($StartTime) >= strtotime($StartTimeArray[0]) && strtotime($StartTime) <= strtotime($StartTimeArray[1]) && strtotime($EndTime) >= strtotime($EndTimeArray[0]) && strtotime($EndTime) <= strtotime($EndTimeArray[1])) {
      array_push($TempArr, Push($Flight));
    }
  }
  $FlightList = $TempArr;
}
if ($Sort1 == 1 && $Sort2 == 0) {
  foreach ($TempFlightList as $Flight) {
    $StartTime = trim(DecryptCiphertext(utf8_decode($Flight["STARTTIME"])));
    if (strtotime($StartTime) >= strtotime($StartTimeArray[0]) && strtotime($StartTime) <= strtotime($StartTimeArray[1])) {
      array_push($TempArr, Push($Flight));
    }
  }
  $FlightList = $TempArr;
}
if ($Sort2 == 1 && $Sort1 == 0) {
  foreach ($TempFlightList as $Flight) {
    $EndTime = trim(DecryptCiphertext(utf8_decode($Flight["ENDTIME"])));
    if (strtotime($EndTime) >= strtotime($EndTimeArray[0]) && strtotime($EndTime) <= strtotime($EndTimeArray[1])) {
      array_push($TempArr, Push($Flight));
    }
  }
  $FlightList = $TempArr;
}
if ($Sort3 == 1) {
  $price = array_column($FlightList, strtoupper($SearchResult["SortValue"]));
  array_multisort($price, SORT_ASC, $FlightList);
}
$HeaderPath = $FlightPathObject->GetFlightPath(" and PathID = '" . $SearchResult['StartAirport'] . '-' . $SearchResult['EndAirport'] . "'");
function HeaderHTML($SD, $HeaderPath)
{
  $String = '<div class="flight-header">';
  if (!empty($HeaderPath)) {
    $HeaderPath = $HeaderPath[0];
    $String .= '
<i class="fas fa-plane-departure"></i>
<div class="flight-title">
    <p>' . $HeaderPath["CN1"] . ', ' . $HeaderPath["CCN1"] . ' (' . $HeaderPath["STARTAIRPORT"] . ') 
    <i class="fas fa-long-arrow-alt-right"></i>
    ' . $HeaderPath["CN2"] . ', ' . $HeaderPath["CCN2"] . ' (' . $HeaderPath["ENDAIRPORT"] . ')</p> 
    <span>' . date("d-m-Y", strtotime($SD)) . '</span>
</div>';
  } else {
    $String .= '<div class="flight-title"><h3>Không có đường bay</h3></div>';
  }
  $String .= '</div>
<ul class="date-list">';
  for ($i = -3; $i <= 3; $i++) {
    $CurrentDateClass = new DateTime($SD);
    $CurrentDateClass->modify('+' . $i . ' day');
    $DateOfWeek  = $CurrentDateClass->format("l");
    switch ($DateOfWeek) {
      case "Monday":
        $DateOfWeek = "Thứ 2";
        break;
      case "Tuesday":
        $DateOfWeek = "Thứ 3";
        break;
      case "Wednesday":
        $DateOfWeek = "Thứ 4";
        break;
      case "Thursday":
        $DateOfWeek = "Thứ 5";
        break;
      case "Friday":
        $DateOfWeek = "Thứ 6";
        break;
      case "Saturday":
        $DateOfWeek = "Thứ 7";
        break;
      default:
        $DateOfWeek = "Chủ nhật";
        break;
    }
    $Class = '';
    if ($i == 0) {
      $Class = "style='background-color: aliceblue'";
    }
    $String .= '
    <li class="date-value" ' . $Class . '>
      <span>' . $CurrentDateClass->format("d-m-Y") . '</span>
      <span>' . $DateOfWeek . '</span>
    </li>';
  }
  $String .= '</ul>';
  return $String;
}
function BodyHTML($FlightList, $FPO)
{
  $String = '<div class="flight-list">';
  if (empty($FlightList)) {
    $String .= '<div class="flight-item"><h1>Không có chuyến bay<h1></div>';
  } else {
    foreach ($FlightList as $Flight) {
      $NewFPO = $FPO[0];
      $String .= '
  <div id="" class="flight-item">
    <ul class="flight-info">
        <li>
            <img src="../icon/' . $Flight["AIRLINEID"] . '.gif">
            <p>' . $Flight["AIRLINENAME"] . '</p>
        </li>
        <li>
            <span class="flight-city">' . $NewFPO["CN1"] . '</span>
            <span class="flight-time">' . date("H:i", strtotime($Flight["STARTTIME"])) . '</span>
        </li>
        <li>
            <div class="flight-id">' . $Flight["AIRLINEID"] . $Flight["FLIGHTID"] . '</div>
            <div class="ftl-flight-line">
                <div class="flight-line"></div>
            </div>
            <div class="expand-details">
              <a class="flight-detail">Chi tiết</a>
              <i class="fas fa-chevron-down"></i>
            </div>        
        </li>
        <li>
            <span class="flight-city">' . $NewFPO["CN2"] . '</span>
            <span class="flight-time">' . date("H:i", strtotime($Flight["ENDTIME"])) . '</span>
        </li>
        <li>
            <div class="flight-price">
            <h4>' . number_format($Flight["ADULTPRICE"]) . ' VND</h4>
            </div>
            <button data-flight=' . $Flight["FLIGHTID"] . ' data-plane=' . $Flight["PLANEID"] . ' class="OrderTicket">Chọn chuyến bay</button>
        </li>
    </ul>
    <div data-expand="0" class="flight-box-detail">
        <div class="box-item">
            <div class="flight-box-detail-header">
                <i class="fa fa-info-circle"></i>
                <span>Chi tiết chuyến bay</span>
            </div>
            <ul class="box-item-flight">
                <li>
                    <img src="../icon/' . $Flight["AIRLINEIMAGE"] . '">
                    <p>' . $Flight["AIRLINENAME"] . '</p>
                </li>
                <li>
                    <span><b>' . $NewFPO["CN1"] . ' - ' . $NewFPO["STARTAIRPORT"] . '</b></span>
                    <span><i>Sân bay ' . trim(DecryptCiphertext(utf8_decode($NewFPO["AN1"]))) . '</i></span>
                    <span>Cất cánh: <b>' . date("H:i", strtotime($Flight["STARTTIME"])) . '</b></span>
                    <span>Ngày đi: <b>' . date("d-m-Y", strtotime($Flight["STARTDATE"])) . '</b></span>
                </li>
                <li>
                    <span><b>' . $NewFPO["CN2"] . ' - ' . $NewFPO["ENDAIRPORT"] . '</b></span>
                    <span><i>Sân bay ' . trim(DecryptCiphertext(utf8_decode($NewFPO["AN2"]))) . '</i></span>
                    <span>Hạ cánh: <b>' . date("H:i", strtotime($Flight["ENDTIME"])) . '</b></span>
                    <span>Ngày đến: <b>' . date("d-m-Y", strtotime($Flight["ENDDATE"])) . '</b></span>
                </li>
                <li>
                    <span>Chuyến bay: <b>' . $Flight["AIRLINEID"] . $Flight["FLIGHTID"] . '</b></span>
                    <span>Thời gian bay: <b>' . date("H", strtotime(trim(DecryptCiphertext(utf8_decode($NewFPO["TIME"]))))) . 'g' . date("i", strtotime(trim(DecryptCiphertext(utf8_decode($NewFPO["TIME"]))))) . 'p</b></span>
                    <span>Hạng chỗ:<b>ECO, BUSINESS</b></span>
                    <span>Máy bay: <b>' . $Flight["PLANENAME"] . '</b></span>
                </li>
            </ul>
        </div>
        <div class="box-item">
            <div class="box-item-fare-header">
                <i class="fa fa-eye"></i>
                <span>Chi tiết giá vé</span>
            </div>
            <ul class="box-item-fare">
                <li><b>Hành khách</b></li>
                <li><b>Giá vé (ECO)</b></li>
                <li><b>Giá vé (BUSINESS)</b></li>
                <li><b>Thuế và phí</b></li>
            </ul>
            <ul class="box-item-fare">
                <li>Người lớn</li>
                <li>' . number_format($Flight["ADULTPRICE"]) . ' VND</li>
                <li>' . number_format($Flight["ADULTPRICE"] * 2) . ' VND</li>
                <li>' . number_format($Flight["ADULTPRICE"] * 0.2) . ' VND</li>
            </ul>
             <ul class="box-item-fare">
                <li>Trẻ em</li>
                <li>' . number_format($Flight["CHILDRENPRICE"]) . ' VND</li>
                <li>' . number_format($Flight["CHILDRENPRICE"] * 2) . ' VND</li>
                <li>' . number_format($Flight["CHILDRENPRICE"] * 0.2) . ' VND</li>
            </ul>
             <ul class="box-item-fare">
                <li>Em bé</li>
                <li>' . number_format($Flight["TODDLERPRICE"]) . ' VND</li>
                <li>' . number_format($Flight["TODDLERPRICE"] * 2) . ' VND</li>
                <li>' . number_format($Flight["TODDLERPRICE"] * 0.2) . ' VND</li>
            </ul>
        </div>
    </div>
  </div>';
    }
  }
  $String .= '</div>';
  return $String;
}
$Array["FirstList"] = HeaderHTML($SearchResult["StartDate"], $HeaderPath) . BodyHTML($FlightList, $HeaderPath);
if (!empty($SearchResult["EndDate"])) {
  $EndPath = " and fp.PathID = '" . $SearchResult["EndAirport"] . "-" . $SearchResult["StartAirport"] . "'";;
  $ReturnFlightList = $FlightObject->SearchFlight("$EndPath$AirlineID");
  $ReversePath = $FlightPathObject->GetFlightPath(" and PathID = $EndPath");
  $Array["SecondList"] = HeaderHTML($SearchResult["EndDate"], $ReversePath) . BodyHTML($ReturnFlightList, $ReversePath);
}
die(json_encode($Array));
