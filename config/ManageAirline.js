import { DisplayData, AddData, UpdateData, DeleteData } from "./CRUD.js"
let CurrentPage = 1;
DisplayData(CurrentPage, "../php/Airline/DisplayAirline.php");
$(document).on('click', '.card-footer span', function () {
    CurrentPage = $(this).text()
    DisplayData(CurrentPage, "../php/Airline/DisplayAirline.php")
})
$("#Add").click((e) => {
    e.preventDefault();
    let image = $("#AirlineImage").prop("files")[0]
    let form = new FormData()
    form.append("AirlineImage", image);
    $.ajax({
        url: "../php/Airline/UploadFile.php",
        method: "post",
        data: form,
        contentType: false,
        processData: false,
        success: function (a) {
            $.ajax({
                url: "../php/Airline/AddAirline.php",
                method: "post",
                data: a + "&" + $("#add-form").serialize(),
                success: function (data) {
                    console.log(data)
                    if (data != 0) {
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'success',
                            html: '<h3>Thêm thành công</h3>',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true
                        })
                        $("form")[0].reset();
                        DisplayData(CurrentPage, "../php/Airline/DisplayAirline.php")
                    } else {
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'warning',
                            html: '<h3>Trùng mã hãng hàng không</h3>',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true
                        })
                    }
                }
            })
        }
    })
})
$(document).on('click', '#Delete', function () {
    let ID = $(this).parent().parent().find('td:nth-child(1)').text()
    Swal.fire({
        position: 'center',
        icon: 'warning',
        html: '<h3>Bạn có chắc chắn xóa không?</h3>',
        showCancelButton: true,
        cancelButtonText: "Thoát",
        confirmButtonText: "Đồng ý"
    }).then(re => {
        if (re.isConfirmed) {
            DeleteData(CurrentPage, ID, "../php/Airline/DeleteAirline.php", "<h3>Hãng hàng không đã lập chuyến bay</h3>", "../php/Airline/DisplayAirline.php")
        }
    })
})
$(document).on('click', '#Edit', function () {
    let AirlineID = $(this).parent().parent().find('td:nth-child(1)').text(),
        AirlineName = $(this).parent().parent().find('td:nth-child(2)').text(),
        CountryID = $(this).parent().parent().attr("data-countryid")
    $("#AirlineIDTemp").val(AirlineID), $("#AirlineNameTemp").val(AirlineName), $("#CountryIDTemp").val(CountryID), $("#HiddenAirlineID").val(AirlineID)
    $("#EditModal").modal("toggle")
})
$("#Confirm").click((e) => {
    e.preventDefault()
    let image = $("#AirlineImageTemp").prop("files")[0]
    let form = new FormData()
    form.append("AirlineImage", image);
    $.ajax({
        url: "../php/Airline/UploadFile.php",
        method: "post",
        data: form,
        contentType: false,
        processData: false,
        success: function (a) {
            $.ajax({
                url: "../php/Airline/UpdateAirline.php",
                method: "post",
                data: a + "&" + $("#edit-form").serialize(),
                success: function (a) {
                    if (a != 0) {
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'success',
                            html: '<h3>Cập nhật thành công</h3>',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true
                        })
                        DisplayData(CurrentPage, "../php/Airline/DisplayAirline.php");
                        $("#EditModal").modal("toggle")
                    } else {
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'error',
                            html: '<h3>Trùng mã máy bay</h3>',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true
                        })
                    }
                }
            })
        }
    })
})
$.ajax({
    url: "../php/Airline/CountryList.php",
    method: "get",
    success: function (a) {
        $("#CountryID").append(a)
        $("#CountryIDTemp").append(a)
    }
})
$("#search").keyup(function () {
    if ($(this).val() == '') {
        DisplayData(CurrentPage, "../php/Airline/DisplayAirline.php")
    }
    $.ajax({
        url: "../php/Airline/SearchAirline.php",
        method: "post",
        data: { SearchString: $(this).val() },
        success: function (a) {
            let Obj = JSON.parse(a)
            $(".main-table tbody").html(Obj.CardBody)
        }
    })
})