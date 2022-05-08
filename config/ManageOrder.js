$.ajax({
    url: "../php/Order/DisplayOrderCustomer.php",
    method: "get",
    success: function (data) {
        $(".orders tbody").html(data)
    }
})
$.ajax({
    url: "../php/Order/DisplayOrderDetail.php",
    method: "get",
    success: function (data) {
        $(".order-details tbody").html(data)
    }
})
$(document).on("click", "#detail", function () {
    let OrderID = $(this).parent().parent().attr("data-id")
    GetDetails(OrderID)
})
$(document).on("click", "#cancel", function () {
    let OrderDate = $(this).parent().parent().children().eq(0).text().split("-")
    if ((new Date().getTime() - new Date(OrderDate[2] + "-" + OrderDate[1] + "-" + OrderDate[0]).getTime()) / (1000 * 60 * 60) >= 24) {
        Swal.fire({
            position: 'center',
            icon: 'error',
            html: "<h4>Đã quá 24h</h4>",
        })
        return
    }
    let StartDate = $(this).parent().parent().children().eq(5).text().split("-")
    if (new Date(StartDate[2] + "-" + StartDate[1] + "-" + StartDate[0]) < new Date()) {
        Swal.fire({
            position: 'center',
            icon: 'error',
            html: "<h4>Đã qua ngày khởi hành</h4>",
        })
        return
    }
    let OrderID = $(this).parent().parent().attr("data-id")
    Swal.fire({
        position: 'center',
        icon: 'warning',
        title: "Cảnh báo",
        html: "<h4>Bạn có muốn hủy hóa đơn này không?</h4>",
        showCancelButton: true
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
                    } else {
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'error',
                            html: "<h4>Đã quá 24h hoặc chuyến bay đã khởi hành</h4>",
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