const ctx = document.getElementById('Chart').getContext('2d');
let myChart;
function Income(label, labels, data, type) {
    myChart = new Chart(ctx, {
        type: type,
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
$("#12-month-back").on("change", () => {
    $("#yearly").val("")
    if (myChart) {
        myChart.destroy()
    }
    let type = $("#choose-stat").val()
    if (type == 'income') {
        $.ajax({
            url: "../php/Statistic/MonthlyIncome.php",
            method: "post",
            data: { Date: $("#12-month-back").val() },
            success: function (data) {
                console.log(data)
                let Obj = JSON.parse(data)
                if (myChart) {
                    myChart.destroy()
                }
                Income('VND', Obj.Date, Obj.Total, 'bar')
            }
        })
    }
    if (type == 'orders') {
        $.ajax({
            url: "../php/Statistic/MonthlyOrder.php",
            method: "post",
            data: { Date: $("#12-month-back").val() },
            success: function (data) {
                console.log(data)
                let Obj = JSON.parse(data)
                if (myChart) {
                    myChart.destroy()
                }
                Income('Đơn hàng', Obj.Date, Obj.Order, 'line')
            }
        })
    }
    if (type == "ticket") {
        $.ajax({
            url: "../php/Statistic/MonthlyTicket.php",
            method: "post",
            data: { Date: $("#12-month-back").val() },
            success: function (data) {
                let Obj = JSON.parse(data)
                if (myChart) {
                    myChart.destroy()
                }
                Income("Vé máy bay", Obj.Date, Obj.Ticket, 'line')
            }
        })
    }
})
$("#yearly").on("change", () => {
    $("#12-month-back").val("")
    if (myChart) {
        myChart.destroy()
    }
    let type = $("#choose-stat").val()
    if (type == 'income') {
        $.ajax({
            url: "../php/Statistic/MonthlyIncome.php",
            method: "post",
            data: { Date: $("#yearly").val() },
            success: function (data) {
                console.log(data)
                let Obj = JSON.parse(data)
                if (myChart) {
                    myChart.destroy()
                }
                Income('VND', Obj.Date, Obj.Total, 'bar')
            }
        })
    }
    if (type == 'orders') {
        $.ajax({
            url: "../php/Statistic/MonthlyOrder.php",
            method: "post",
            data: { Date: $("#yearly").val() },
            success: function (data) {
                console.log(data)
                let Obj = JSON.parse(data)
                if (myChart) {
                    myChart.destroy()
                }
                Income('Đơn hàng', Obj.Date, Obj.Order, 'line')
            }
        })
    }
    if (type == "ticket") {
        $.ajax({
            url: "../php/Statistic/MonthlyTicket.php",
            method: "post",
            data: { Date: $("#yearly").val() },
            success: function (data) {
                let Obj = JSON.parse(data)
                if (myChart) {
                    myChart.destroy()
                }
                Income("Vé máy bay", Obj.Date, Obj.Ticket, 'line')
            }
        })
    }
})
$("#choose-stat").on("change", () => {
    $("#yearly").val("")
    $("#12-month-back").val("")
    if ($("#choose-stat").val() == "ticket-type") {
        if (myChart) {
            myChart.destroy()
        }
        $.ajax({
            url: "../php/Statistic/TicketType.php",
            method: "get",
            success: function (data) { console.log(data)
                let Obj = JSON.parse(data)
                myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Obj.Class,
                        datasets: [{
                            label: 'Số lượng',
                            data: Obj.Ticket,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        })
    }
})

