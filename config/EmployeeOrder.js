import { GetDetails } from './MemberOrder.js'
import { DisplayData } from './CRUD.js'
let CurrentPage = 1
DisplayData(CurrentPage, "../php/Order/DisplayOrderEmployee.php")
$(document).on('click', '.card-footer span', function () {
    CurrentPage = parseInt($(this).text())
    DisplayData(CurrentPage, "../php/Order/DisplayOrderEmployee.php")
})
$(document).on("click", "#detail", function () {
    let OrderID = $(this).parent().parent().attr("data-id")
    GetDetails(OrderID)
    $("#myModal").modal("toggle")
})
$(document).on("change", "#state", function () {
    $.ajax({
        url: "../php/Order/ChangeStatus.php",
        data: { State: $(this).val(), ID: $(this).parent().parent().attr("data-id") },
        method: "post",
        success: function (data) {
            console.log(data)
            if (data != 0) {
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'info',
                    html: "<h4>Đã cập nhật trạng thái!</h4>",
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true
                })
                DisplayData(CurrentPage, "../php/Order/DisplayOrderEmployee.php")
            }
        }
    })
})
$(document).on("click", "#deletebutton", function () {
    let StartDate = $(this).parent().parent().children().eq(6).text().split("-")
    let EndDate = $(this).parent().parent().children().eq(8).text().split("-")
    let OrderID = $(this).parent().parent().attr("data-id")
    Swal.fire({
        position: 'center',
        icon: 'warning',
        title: "Cảnh báo",
        html: "<h4>Bạn có muốn hủy đơn hàng này không?</h4>",
        showCancelButton: true,
        cancelButtonText: "Hủy",
        confirmButtonText: "Đồng ý"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../php/Order/CancelOrder.php",
                method: "post",
                data: { OrderID: OrderID },
                success: function (data) {
                    if (data != '') {
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'success',
                            html: "<h4>Đơn hàng đã được hủy thành công</h4>",
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true
                        })
                        DisplayData(CurrentPage, "../php/Order/DisplayOrderEmployee.php")
                    }
                }
            })
        }
    })
})
let ExportExcel = (data, columnnames, filename, filepath) => {
    const workbook = XLSX.utils.book_new()
    const worksheetdata = [columnnames, ...data]
    const worksheet = XLSX.utils.aoa_to_sheet(worksheetdata)
    XLSX.utils.book_append_sheet(workbook, worksheet, filename)
    XLSX.writeFile(workbook, filepath)
}
function ExportOrder() {
    $.ajax({
        url: "../php/Order/FetchOrder.php",
        method: "get",
        success: function (data) {
            let Obj = JSON.parse(data)
            ExportExcel(Obj.Row, Obj.Header, "Report", "XuatHoaDon.xlsx")
        }
    })
}
function ExportOrderDetail(ID) {
    $.ajax({
        url: "../php/Order/FetchOrderDetail.php",
        method: "post",
        data: { OrderID: ID },
        success: function (data) {
            let Obj = JSON.parse(data)
            ExportExcel(Obj.Row, Obj.Header, "OrderDetails", "ChiTietHoaDon.xlsx")
        }
    })
}
export { ExportExcel, ExportOrder, ExportOrderDetail }
$("#search").keyup(function () {
    if ($(this).val() == '') {
        DisplayData(CurrentPage, "../php/Order/DisplayOrderEmployee.php")
        return
    }
    $.ajax({
        url: "../php/Order/SearchOrder.php",
        method: "post",
        data: { SearchString: $(this).val() },
        success: function (a) {
            console.log(a)
            let Obj = JSON.parse(a)
            $(".main-table tbody").html(Obj.CardBody)
            $(".card-footer").html(Obj.CardFooter)
        }
    })
})