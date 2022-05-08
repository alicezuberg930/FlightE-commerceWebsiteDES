<?php require_once("../../class/order.php");
require_once("../../DESAlgorithm.php");
session_start();
if (!isset($_SESSION['Employee'])) {
    die(json_encode(array("status" => "error", "message" => "You are not logged in")));
}
$State = $Style = $ReturnDate = '';
if (isset($_POST["p"])) {
    $Start = ($_POST["p"] - 1) * 5;
    $OrderList = $OrderObject->GetOrder(" ORDER BY StartDate desc offset $Start rows fetch next 5 row only");
} else if (isset($_POST["MemberID"])) {
    $Style = "style='display:none;'";
    $OrderList = $OrderObject->GetOrder(" where MemberID = '" . $_POST["MemberID"] . "'");
}
$Array = array("CardBody" => '', 'CardFooter' => '');
$States = [
    "Đã chấp thuận",
    "Đã thanh toán",
    "Đang chuyển",
    "Đã xuất kho",
    "Đã giao",
    "Đã hủy"
];
foreach ($OrderList as $Order) {
    $OrderDate = $Order["ORDERDATE"];
    $TotalPrice = $Order["TOTALPRICE"];
    $TotalWeight = $Order["TOTALWEIGHT"];
    $Quantity = $Order["QUANTITY"];
    $StartFlight = $Order["STARTFLIGHT"];
    $StartDate = $Order["STARTDATE"];
    $ContactName = $Order["CONTACTNAME"];
    $ContactEmail = $Order["CONTACTEMAIL"];
    $Address = $Order["ADDRESS"];
    $ReturnFlight = $Order["RETURNFLIGHT"];
    $ReturnDate = $Order["RETURNDATE"];
    $OrderState = $Order["STATE"];
    if ($_SESSION["Employee"]["ROLE"] == "Bán hàng" || $_SESSION["Employee"]["ROLE"] == "Quản trị viên") {
        $TotalPrice = number_format(trim(DecryptCiphertext(utf8_decode($TotalPrice)))) . "VND";
        $TotalWeight = trim(DecryptCiphertext(utf8_decode($TotalWeight)));
        $Quantity = trim(DecryptCiphertext(utf8_decode($Quantity)));
        $StartFlight = trim(DecryptCiphertext(utf8_decode($StartFlight)));
        $StartDate = date("d-m-Y", strtotime(trim(DecryptCiphertext(utf8_decode($StartDate)))));
        $ContactName = trim(DecryptCiphertext(utf8_decode($ContactName)));
        $ContactEmail = trim(DecryptCiphertext(utf8_decode($ContactEmail)));
        $Address = trim(DecryptCiphertext(utf8_decode($Address)));
        $ReturnFlight = trim(DecryptCiphertext(utf8_decode($ReturnFlight)));
        $ReturnDate = date("d-m-Y", strtotime(trim(DecryptCiphertext(utf8_decode($ReturnDate)))));
        $OrderState = trim(DecryptCiphertext(utf8_decode($OrderState)));
    }
    if ($OrderState == 'Đã giao' || $OrderState == 'Đã hủy' || $_SESSION["Employee"]["ROLE"] == "Kế toán") {
        $Disabled = "disabled='disabled'";
    } else {
        $Disabled = '';
    }
    $State .= "<option selected value='" . $OrderState . "'>" . $OrderState . "</option>";
    foreach ($States as $s) {
        if ($s != $OrderState) {
            $State .= "<option value='" . $s . "'>" . $s . "</option>";
        }
    }
    $Array["CardBody"] .= "
        <tr data-id='" . $Order["ORDERID"] . "'>
            <td>" . $OrderDate . "</td>
            <td>" . $TotalPrice . "</td>
            <td>" . $TotalWeight . "</td>
            <td>" . $Quantity . "</td>
            <td>" . $StartFlight . "</td>
            <td>" . $StartDate  . "</td>
            <td>" . $ReturnFlight . "</td>
            <td>" . $ReturnFlight . "</td>";
    if (isset($_POST["MEMBERID"])) {
        $Array["CardBody"] .= "<td>" . $Order["STATE"] . "</td>";
    } else {
        $Array["CardBody"] .= "<td>
            <select " . $Disabled . " id='state' class='form-control'>'" . $State . "'</select>
        </td>";
    }
    $Array["CardBody"] .= "<td>
                <p>Email: " . $ContactEmail . "</p>
                <p>Tên người đặt: " . $ContactName . "</p>
                <p>Địa chỉ: " . $Address . "</p>
            </td>
            <td " . $Style . "><button id='deletebutton' class='btn bg-danger btn-sm'><i class='fas fa-trash-alt'></i></button></td>
            <td><button id='detail' class='btn bg-info btn-sm'><i class='fas fa-info-circle'></i></button></td>
        </tr>";
    $State = '';
}
$NumberOfPages = ceil(GetRows("select count(*) as NUMBER_OF_ROWS from orders") / 5);
$Array['CardFooter'] .= "<div class='page-list'>";
for ($i = 1; $i <= $NumberOfPages; $i++) {
    $Array['CardFooter'] .= '<span>' . $i . '</span>';
}
$Array['CardFooter'] .= "</div>
<button id='export-orders' class='btn bg-primary'>Xuất hóa đơn</button>";
echo json_encode($Array);
