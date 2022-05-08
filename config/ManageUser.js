import { DisplayData } from "./CRUD.js";
let CurrentPage = 1
DisplayData(CurrentPage, "../php/User/DisplayMember.php")
$(document).on('click', '.card-footer span', function () {
    CurrentPage = parseInt($(this).text())
    DisplayData(CurrentPage, "../php/User/DisplayMember.php")
})
function LockUnlock(ID, State) {
    $.ajax({
        url: "../php/User/LockAndUnlock.php",
        method: "post",
        data: { ID: ID, State: State },
        success: function (data) {
            if (data == "Success") {
                DisplayData(CurrentPage, "../php/User/DisplayMember.php")
            }
        }
    })
}
$(document).on("click", "#history", function () {
    let ID = $(this).parent().parent().attr("data-id")
    $.ajax({
        url: "../php/Order/DisplayOrderEmployee.php",
        method: "post",
        data: { MemberID: ID },
        success: function (data) {
            let Obj = JSON.parse(data)
            $(".member-history tbody").html(Obj.CardBody)
        }
    })
    $("#orderModal").modal("toggle")
})
let GetDetails = (OrderID) => {
    $.ajax({
        url: "../php/Order/DisplayOrderDetail.php",
        method: "post",
        data: { OrderID: OrderID },
        success: function (data) {
            $("#myModal table tbody").html(data)
        }
    })
}
$(document).on("click", "#detail", function () {
    let OrderID = $(this).parent().parent().attr("data-id")
    GetDetails(OrderID)
    $("#orderModal").modal("toggle")
    $("#myModal").modal("toggle")
})
$(document).on("click", "#Lock", function () {
    let ID = $(this).parent().parent().attr("data-id")
    Swal.fire({
        position: 'center',
        icon: 'warning',
        html: '<h3>Khóa tài khoản của người dùng này?</h3>',
        confirmButtonText: "Đồng ý",
        showCancelButton: true,
        cancelButtonText: "Thoát"
    }).then((choice) => {
        if (choice.isConfirmed) {
            LockUnlock(ID, 0)
            Swal.fire({
                position: 'bottom-end',
                icon: 'info',
                html: '<h3>Đã khóa tài khoản</h3>',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true
            })
        }
    })
})
$(document).on("click", "#Unlock", function () {
    let ID = $(this).parent().parent().attr("data-id")
    LockUnlock(ID, 1)
    Swal.fire({
        position: 'bottom-end',
        icon: 'info',
        html: '<h3>Đã mở khóa tài khoản</h3>',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true
    })
})
$(document).on("keyup", ".search", function () {
    if ($(this).attr("id") == "fullname") {
        $("#email").val("")
        $("#phone").val("")
    }
    if ($(this).attr("id") == "phone") {
        $("#email").val("")
        $("#fullname").val("")
    }
    if ($(this).attr("id") == "email") {
        $("#fullname").val("")
        $("#phone").val("")
    }
    if ($(this).val() == "") DisplayData(CurrentPage, "../php/User/DisplayMember.php");
    $.ajax({
        url: "../php/User/SearchMember.php",
        method: "post",
        data: { Name: $("#fullname").val(), Email: $("#email").val(), Phone: $("#phone").val() },
        success: function (a) {
            let Obj = JSON.parse(a)
            if (Obj.CardBody.length != 0)
                $(".main-table tbody").html(Obj.CardBody)
        }
    })
})