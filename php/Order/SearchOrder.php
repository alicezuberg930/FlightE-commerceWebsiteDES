<?php require_once("../../class/order.php");
$OrderHTML = $State = $ReturnDate = '';
$i = 1;
$Array = array("CardBody" => '', 'CardFooter' => '');
$Query = " where OrderID like '%" . $_POST["SearchString"] . "%'";
$OrderList = $OrderObject->GetOrder($Query);
$States = [
    "Đã thanh toán",
    "Đang chuyển",
    "Đã giao"
];
foreach ($OrderList as $Order) {
    if ($Order["STATE"] == 'Đã giao') {
        $Disabled = "disabled='disabled'";
    } else {
        $Disabled = '';
    }
    $State .= "<option selected value='" . $Order["STATE"] . "'>" . $Order["STATE"] . "</option>";
    foreach ($States as $s) {
        if ($Order["STATE"] == $s)
            continue;
        else
            $State .= "<option value='" . $s . "'>" . $s . "</option>";
    }
    if (!empty($Order["RETURNDATE"])) {
        $ReturnDate = date("d-m-Y", strtotime($Order["RETURNDATE"]));
    } else {
        $ReturnDate = '';
    }
    $Array["CardBody"] .= "<tr data-id='" . $Order["ORDERID"] . "'>
        <td>" . $i . "</td>
        <td>" . date("d-m-Y", strtotime($Order["ORDERDATE"]))  . "</td>
        <td>" . number_format($Order["TOTALPRICE"]) . " VND</td>
        <td>" . $Order["TOTALWEIGHT"] . " kg</td>
        <td>" . $Order["QUANTITY"] . " người</td>
        <td>" . $Order["STARTFLIGHT"] . "</td>
        <td>" . date("d-m-Y", strtotime($Order["STARTDATE"]))  . "</td>
        <td>" . $Order["RETURNFLIGHT"] . "</td>
        <td>" . $ReturnDate  . "</td>
        <td>
            <select " . $Disabled . " id='state' class='form-control'>'" . $State . "'</select>
        </td>
        <td>
            <p>Email: " . $Order["CONTACTEMAIL"] . "</p>
            <p>Tên người đặt: " . $Order["CONTACTNAME"] . "</p>
            <p>Địa chỉ: " . $Order["ADDRESS"] . "</p>
        </td>
        <td><button id='deletebutton' class='btn bg-danger btn-sm'><i class='fas fa-trash-alt'></i></button></td>
        <td><button id='detail' class='btn bg-info btn-sm'><i class='fas fa-info-circle'></i></button></td>
    </tr>";
    $i++;
    $State = '';
}
$Array['CardFooter'] = "<button id='export-orders' class='btn bg-primary'>Xuất hóa đơn</button>";
die(json_encode($Array));
