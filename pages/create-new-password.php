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
    <title>Document</title>
</head>

<body>
    <nav style="background-color: #364744;" class="nav-bar"></nav>

    <div class="container-sm mt-5 mb-5">
        <div class="row justify-content-md-center">
            <div class="col-md-4">
                <h3>Nhập mật khẩu mới</h3>
                <?php if (isset($_GET["notify"])) {
                    $val = $_GET["notify"];
                    switch ($val) {
                        case "expired";
                            echo '<div class="align-items-center my-2">
                                    <p class="text-danger fw-bold mb-0">
                                        <small>Đã quá thời hạn</small>
                                    </p>
                                </div>';
                            break;
                        case "emptyfields":
                            echo '<div class="align-items-center my-2">
                                    <p class="text-danger fw-bold mb-0">
                                        <small>Không được để trống</small>
                                    </p>
                                </div>';
                            break;
                        case "notmatch":
                            echo '<div class="align-items-center my-2">
                                    <p class="text-danger fw-bold mb-0">
                                        <small>Mật khẩu không khớp</small>
                                    </p>
                                </div>';
                            break;
                        default:
                            echo '<script>alert("Đổi mật khẩu thành công!")
                            window.location.href = "./login-register.html"
                            </script>';
                            break;
                    }
                } ?>
                <?php $selector = $validator = "";
                if (empty($_GET["selector"]) || empty($_GET["validator"])) {
                    echo "Could not validate your request!";
                } else {
                    $selector = $_GET["selector"];
                    $validator = $_GET["validator"] ?>
                    <form action="../reset_password/reset-password-handler.php" method="post">
                        <input hidden name="selector" type="text" value="<?php echo $selector ?>">
                        <input hidden name="validator" type="text" value="<?php echo $validator ?>">
                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="floatingInput" placeholder="Nhập mật khẩu mới">
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="retype_password" class="form-control" id="floatingInput" placeholder="Nhập lại mật khẩu mới">
                        </div>
                        <button class="btn btn-primary btn-lg" name="reset-password-submit">Reset mật khẩu</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="description"></div>
    <script src="../config/HeaderFooter.js"></script>
    <script src="../config/UserState.js"></script>
</body>

</html>