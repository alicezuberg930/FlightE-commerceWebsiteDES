<?php require_once("../../class/order.php");
require_once("../../DESAlgorithm.php");
session_start();
$OrderHTML = $State = $Style = $ReturnDate = '';
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
        $TotalPrice = number_format(DecryptCiphertext(utf8_decode($TotalPrice)));
        $TotalWeight = DecryptCiphertext(utf8_decode($TotalWeight));
        $Quantity = DecryptCiphertext(utf8_decode($Quantity));
        $StartFlight = DecryptCiphertext(utf8_decode($StartFlight));
        $StartDate = date("d-m-Y", strtotime(DecryptCiphertext(utf8_decode($StartDate))));
        $ContactName = DecryptCiphertext(utf8_decode($ContactName));
        $ContactEmail = DecryptCiphertext(utf8_decode($ContactEmail));
        $Address = DecryptCiphertext(utf8_decode($Address));
        $ReturnFlight = DecryptCiphertext(utf8_decode($ReturnFlight));
        $ReturnDate = date("d-m-Y", strtotime(DecryptCiphertext(utf8_decode($ReturnDate))));
        $OrderState = DecryptCiphertext(utf8_decode($OrderState));
    }
    if ($OrderState == 'Đã giao' || $OrderState == 'Đã hủy') {
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
