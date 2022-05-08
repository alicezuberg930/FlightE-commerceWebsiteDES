function DisplayData(CurrentPage, url) {
    $.ajax({
        url: url,
        method: "post",
        data: { p: CurrentPage },
        success: function (result) {
            console.log(JSON.parse(result))
            let Obj = JSON.parse(result)
            $(".main-table tbody").html((Obj.CardBody))
            $(".card-footer").html(Obj.CardFooter)
        }
    })
}
function AddData(CurrentPage, DataObject, url, displayurl) {
    $.ajax({
        url: url,
        method: "post",
        data: { Object: DataObject },
        success: function (result) {
            console.log(result)
            if (result != 0) {
                Swal.fire({
                    text: 'Thêm thông tin thành công',
                    position: "bottom-end",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true
                })
                $("form")[0].reset();
                DisplayData(CurrentPage, displayurl);
            } else {
                Swal.fire({
                    text: 'Trùng thông tin',
                    position: "bottom-end",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true
                })
            }
        }
    })
}
function UpdateData(CurrentPage, DataObject, url, displayurl) {
    $.ajax({
        url: url,
        method: "post",
        data: { Employee: DataObject },
        success: function (result) {
            console.log(result)
            if (!result.includes("0")) {
                Swal.fire({
                    text: 'Sửa thông tin thành công',
                    position: "bottom-end",
                    icon: 'success',
                    timer: 1000,
                    timerProgressBar: true,
                    showConfirmButton: false
                })
                DisplayData(CurrentPage, displayurl);
                $("#myModal").modal("toggle")
            } else {
                Swal.fire({
                    text: 'Sửa thông tin thất bại',
                    position: "bottom-end",
                    icon: 'error',
                    timer: 1000,
                    timerProgressBar: true,
                    showConfirmButton: false
                })
            }
        }
    })
}
function DeleteData(CurrentPage, DataObject, url, Notification, displayurl) {
    $.ajax({
        url: url,
        method: "post",
        data: {
            ID: DataObject
        },
        success: function (data) {
            if (data.includes("0")) {
                Swal.fire({
                    text: Notification,
                    position: "bottom-end",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true
                })
            } else {
                Swal.fire({
                    text: 'Xóa thông tin thành công',
                    position: "bottom-end",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true
                })
                DisplayData(CurrentPage, displayurl)
            }
        }
    })
}
export { DisplayData, AddData, UpdateData, DeleteData }