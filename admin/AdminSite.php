<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/admin.css">
    <script src="../library/jquery/jquery.min.js"></script>
    <script src="../library/chart.js/dist/chart.js"></script>
    <link rel="stylesheet" href="../library/boostrap/css/bootstrap.min.css">
</head>

<body>
    <style>
        .sidebar__link:nth-child(9) {
            background-color: rgba(38, 107, 197, 0.5);
        }
    </style>
    <div class="containers">
        <?php require_once("./Navbar.html") ?>
        <main>
            <div class="main__container">
                <div class="main__title">
                    <img src="../icon/rem.jpeg" width="40">
                    <div class="main__greeting">
                        <h1><?php echo $_SESSION["Employee"]["FULLNAME"]; ?></h1>
                        <p>Chào mừng đến bảng điều khiển</p>
                    </div>
                </div>
                <div class="main__card">
                    <div class="cards">
                        <i class="fa fa-user"></i>
                        <div class="card__inner">
                            <p class="text-primary">Số Người Dùng</p>
                            <span class="font-bold text-title">312</span>
                        </div>
                    </div>
                    <div class="cards">
                        <i class="fas fa-calendar"></i>
                        <div class="card__inner">
                            <p class="text-primary">Số Người Xem</p>
                            <span class="font-bold text-title">6969</span>
                        </div>
                    </div>
                    <div class="cards">
                        <i class="fas fa-thumbs-up"></i>
                        <div class="card__inner">
                            <p class="text-primary">Số Người Thích</p>
                            <span class="font-bold text-title">475</span>
                        </div>
                    </div>
                    <div class="cards">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="card__inner">
                            <p class="text-primary">Số Vé Đã Đặt</p>
                            <span class="font-bold text-title">135</span>
                        </div>
                    </div>
                </div>
                <div class="charts">
                    <div class="charts__left">
                        <div class="charts___right__title">
                            <div>
                                <h1>Chọn thông tin cần thống kê</h1>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3">
                                    <select class="form-control" id="yearly">
                                        <option value="" disabled selected hidden>Theo năm</option>
                                        <option value="2022-12-01">2022</option>
                                        <option value="2021-12-01">2021</option>
                                        <option value="2020-12-01">2020</option>
                                        <option value="2019-12-01">2019</option>
                                        <option value="2018-12-01">2018</option>
                                        <option value="2017-12-01">2017</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" id="12-month-back">
                                        <option value="" disabled selected hidden>Trong 12 tháng trở lại</option>
                                        <option value="2022-12-01">2022-12</option>
                                        <option value="2022-11-01">2022-11</option>
                                        <option value="2022-10-01">2022-10</option>
                                        <option value="2022-09-01">2022-09</option>
                                        <option value="2022-08-01">2022-08</option>
                                        <option value="2022-07-01">2022-07</option>
                                        <option value="2022-06-01">2022-06</option>
                                        <option value="2022-05-01">2022-05</option>
                                        <option value="2022-04-01">2022-04</option>
                                        <option value="2022-03-01">2022-03</option>
                                        <option value="2022-02-01">2022-02</option>
                                        <option value="2022-01-01">2022-01</option>
                                        <option value="2021-12-01">2021-12</option>
                                        <option value="2021-11-01">2021-11</option>
                                        <option value="2021-10-01">2021-10</option>
                                        <option value="2021-09-01">2021-09</option>
                                        <option value="2021-08-01">2021-08</option>
                                        <option value="2021-07-01">2021-07</option>
                                        <option value="2021-06-01">2021-06</option>
                                        <option value="2021-05-01">2021-05</option>
                                        <option value="2021-04-01">2021-04</option>
                                        <option value="2021-03-01">2021-03</option>
                                        <option value="2021-02-01">2021-02</option>
                                        <option value="2021-01-01">2021-01</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" id="choose-stat">
                                        <option value="" disabled selected hidden>Chọn thông tin cần thống kê</option>
                                        <option value="income">Thống kê thu nhập</option>
                                        <option value="orders">Thống kê đơn hàng đã đặt</option>
                                        <option value="ticket">Thống kê vé đã bán</option>
                                        <option value="ticket-type">Thống kê loại vé đã bán</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="charts__right">
                        <div class="chars__left__title">
                            <div>
                                <h1>Báo Cáo Thường Niên</h1>
                            </div>
                            <i class="fa fa-usd"></i>
                            <canvas id="Chart"></canvas>
                            <canvas id="Blank"></canvas>
                        </div>
                        <div id="apex1"></div>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once("sidebar.html"); ?>
    </div>
    <script async src="../config/Statistics.js"></script>
    <script src="../config/AdminResponsive.js"></script>
</body>

</html>