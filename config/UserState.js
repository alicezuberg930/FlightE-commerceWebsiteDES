$.ajax({
    url: "../php/LoginRegister/UserState.php",
    method: "get",
    success: function (data) {
        console.log(JSON.parse(data))
        let Obj = JSON.parse(data)
        if (Obj.Membername != '' || Obj.Employeename != '') {
            $("#login-register").remove()
        }
        if (Obj.Membername == '' && Obj.Employeename == '') {
            $("#logout").remove()
            $("#orders").remove()
            $("#username").remove()
            $("#management").remove()
        }
        if (Obj.Membername != '') {
            $("#management").remove()
            $("#username a span").text(Obj.Membername)
        }
        if (Obj.Employeename != '') {
            $("#orders").remove()
            $("#username a span").text(Obj.Employeename)
        }
        if (Obj.Role == 'Quản trị viên') {
            $("#manage-employee").css("display", "block")
        } else {
            $("#manage-employee").css("display", "none")
        }
        $("#name").text("Xin chào, " + Obj.Employeename)
    }
}) 