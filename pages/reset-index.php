<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../library/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../style/header.css">
    <link rel="stylesheet" type="text/css" href="../style/footer.css">
    <link rel="stylesheet" href="../library/boostrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <title>Nhập email</title>
</head>

<body>
    <nav style="background-color: #364744;" class="nav-bar"></nav>
    <div class="container-sm mt-5 mb-5">
        <div class="row justify-content-md-center">
            <div class="col-md-6" id="contentmail">
                <h2>Nhập địa chỉ email</h2>
                <p>Một đường dẫn sẽ gửi tới email của bạn, nhấp vào đó để tạo mật khẩu mới</p>
                <form action="./reset-request.php" method="post">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <div class="form-floating">
                                <input type="email" class="p-2 form-control" placeholder="Nhập email" name="email">
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <button type="button" name="reset-request-submit" id="send-email" class="btn btn-primary btn-lg">Gửi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="description"></div>
    <script src="../config/HeaderFooter.js"></script>
    <script src="../config/UserState.js"></script>
    <script>
        $("#send-email").click((e) => {
            e.preventDefault()
            var xhttp = new XMLHttpRequest() || ActiveXObject();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('contentmail').innerHTML = this.responseText;
                }
            }
            xhttp.open('POST', '../reset_password/reset-request.php', true);
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send('reset-request-submit' + '&email=' + $("input[name='email']").val());
        })
    </script>

</html>