/*
document.addEventListener('DOMContentLoaded', function() {
    // Create the chart
    Highcharts.chart('highcharts', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Nombre de thèse par an'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Nombre de thèse'
            }
        },
        legend: {
            enabled: false
        },
        /!*plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },*!/
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> thèses<br/>'
        },

        series: [
            {
                name: "Population",
                colorByPoint: true,
                data: datas
            }
        ],
    });
})*/
