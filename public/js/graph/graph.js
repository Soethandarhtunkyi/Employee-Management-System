$(function () {
    Chart.plugins.register({
        afterDraw: function (chart) {
            if (chart.data.datasets[0].data.every(item => item === 0)) {
                let ctx = chart.chart.ctx;
                let width = chart.chart.width;
                let height = chart.chart.height;

                chart.clear();
                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText('No data for today', width / 2, height / 2);
                ctx.restore();
            }
        }
    });
    //get the pie chart canvas
    var cData = JSON.parse(chartdata);
    var ctx = $("#pie-chart");

    //pie chart data
    var data = {
        labels: cData.label,
        datasets: [{
            label: "Users Count",
            data: cData.data,
            backgroundColor: [
                "#FF851B",
                "#0074D9",
                "#3D9970",
                "#5C40C0",
                "#DC143C",
                "#F4A460",
                "#2E8B57",
                "#BE4ABA",
                "#001f3f",
                "#FD8083"
            ],
            borderColor: [
                "#FF851B",
                "#0074D9",
                "#3D9970",
                "#5C40C0",
                "#DC143C",
                "#F4A460",
                "#2E8B57",
                "#BE4ABA",
                "#001f3f",
                "#FD8083"
            ],
            borderWidth: [1, 1, 1, 1, 1, 1, 1]
        }]
    };

    //create Pie Chart class object
    var chart1 = new Chart(ctx, {
        type: "pie",
        data: data,
        options: {
            responsive: true
        }
    });

    //get the bar chart canvas
    var cBarData = JSON.parse(barchartdata);
    var barctx = $("#bar-chart");

    //bar chart data
    var data = {
        labels: cBarData.label,
        datasets: [{
            label: "Total Absent Person",
            data: cBarData.data,
            backgroundColor: "#0074D9",
            borderColor: "#0074D9",
            borderWidth: 1
        }]
    };
    //create bar Chart class object
    var chart2 = new Chart(barctx, {
        type: "bar",
        data: data,
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                        maxTicksLimit: 10
                    },
                    gridLines: {
                        display: true
                    },
                    stacked: true,
                }]
            }
        }
    });
    $('#value,#newem-value,#turnover-value,#office-value').each(function () {
        var $this = $(this),
            countTo = $this.attr('data-count');

        $({
            countNum: $this.text()
        }).animate({
                countNum: countTo
            },

            {
                duration: 800,
                easing: 'linear',
                step: function () {
                    $this.text(commaSeparateNumber(Math.floor(this.countNum)));
                },
                complete: function () {
                    $this.text(commaSeparateNumber(this.countNum));
                }
            }
        );

    });

    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
});
