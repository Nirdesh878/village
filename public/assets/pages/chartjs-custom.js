"use strict";
$(document).ready(function () {
    /*Doughnut chart*/
    var ctx = document.getElementById("myChart");
    var data = {
        labels: [
            "A", "B", "C", "D "
        ],
        datasets: [{
            data: [40, 10, 40, 10],
            backgroundColor: [
                "#1ABC9C",
                "#FCC9BA",
                "#B8EDF0",
                "#B4C1D7"
            ],
            borderWidth: [
                "0px",
                "0px",
                "0px",
                "0px"
            ],
            borderColor: [
                "#1ABC9C",
                "#FCC9BA",
                "#B8EDF0",
                "#B4C1D7"

            ]
        }]
    };

    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: data
    });


    /*Bar chart*/
    var data1 = {
        labels: [0, 1, 2, 3, 4, 5, 6, 7],
        datasets: [{
            label: "My First dataset",
            backgroundColor: [
                'rgba(95, 190, 170, 0.99)',
                'rgba(95, 190, 170, 0.99)',
                'rgba(95, 190, 170, 0.99)',
                'rgba(95, 190, 170, 0.99)',
                'rgba(95, 190, 170, 0.99)',
                'rgba(95, 190, 170, 0.99)',
                'rgba(95, 190, 170, 0.99)'
            ],
            hoverBackgroundColor: [
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)'
            ],
            data: [65, 59, 80, 81, 56, 55, 50],
        }, {
            label: "My second dataset",
            backgroundColor: [
                'rgba(93, 156, 236, 0.93)',
                'rgba(93, 156, 236, 0.93)',
                'rgba(93, 156, 236, 0.93)',
                'rgba(93, 156, 236, 0.93)',
                'rgba(93, 156, 236, 0.93)',
                'rgba(93, 156, 236, 0.93)',
                'rgba(93, 156, 236, 0.93)'
            ],
            hoverBackgroundColor: [
                'rgba(103, 162, 237, 0.82)',
                'rgba(103, 162, 237, 0.82)',
                'rgba(103, 162, 237, 0.82)',
                'rgba(103, 162, 237, 0.82)',
                'rgba(103, 162, 237, 0.82)',
                'rgba(103, 162, 237, 0.82)',
                'rgba(103, 162, 237, 0.82)'
            ],
            data: [60, 69, 85, 91, 58, 50, 45],
        }]
    };

    var bar = document.getElementById("barChart").getContext('2d');
    var myBarChart = new Chart(bar, {
        type: 'bar',
        data: data1,
        options: {
            barValueSpacing: 20
        }
    });


    var data2 = {
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
        datasets: [{
            label: "My First dataset",
            backgroundColor: "rgba(100, 221, 187, 0.52)",
            borderColor: "rgba(72, 206, 168, 0.88)",
            pointBackgroundColor: "rgba(51, 175, 140, 0.88)",
            pointBorderColor: "rgba(44, 130, 105, 0.88)",
            pointHoverBackgroundColor: "rgba(44, 130, 105, 0.88)",
            pointHoverBorderColor: "rgba(107, 226, 193, 0.98)",
            data: [65, 59, 90, 81, 56, 55, 40]
        }, {
            label: "My Second dataset",
            backgroundColor: "rgba(255, 204, 189, 0.95)",
            borderColor: "rgba(255, 165, 138, 0.95)",
            pointBackgroundColor: "rgba(255, 116, 22, 0.94)",
            pointBorderColor: "rgba(251, 142, 109, 0.95)",
            pointHoverBackgroundColor: "rgba(251, 142, 109, 0.95)",
            pointHoverBorderColor: "rgba(255, 165, 138, 0.95)",
            data: [28, 48, 40, 19, 96, 27, 100]
        }]
    };
    var myRadarChart = new Chart(radarElem, {
        type: 'radar',
        data: data2,
        options: {
            scale: {
                reverse: true,
                ticks: {
                    beginAtZero: true
                }
            }
        }
    });


});


//adolescent Gender status
var pieElem = document.getElementById("adolescent_gender_chart");
var data = {
    labels: [
        "Male",
        "Female",
    ],
    datasets: [{
        data: [total_adl_male, total_adl_female],
        backgroundColor: ["#4C4D4F", "#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#4C4D4F", "#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F", "#FCAF17"],
    }]

};
var myPieChart = new Chart(pieElem, {
    type: 'doughnut',
    data: data,
    options: {
        legend: {
            display: true
        },

        // tooltips: {
        //     callbacks: {
        //         label: function(tooltipItem, data) {
        //             return data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
        //         }
        //     }
        // }
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                        return parseFloat(previousValue) + parseFloat(currentValue);
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    // alert(total);
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
            }
        }
    }
});

//adolescent age status
var pieElem = document.getElementById("adolescent_age_chart");
var data = {
    labels: [
        "12-14 Year",
        "15-19 Year"
    ],
    datasets: [{
        data: [total_adl_less_then_fifteen, total_adl_greater_then_fifteen],
        backgroundColor: ["#4C4D4F", "#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#4C4D4F", "#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F", "#FCAF17"],
    }]

};

var myPieChart = new Chart(pieElem, {
    type: 'doughnut',
    data: data,
    options: {

        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                        return parseFloat(previousValue) + parseFloat(currentValue);
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    // alert(total);
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
            }
        }
    }
});

//adolescent school status
var ctx = document.getElementById("adolescent_schooling_chart");
var data = {
    labels: ["In School", "Out School"],
    datasets: [{
        data: [total_adl_in_school, total_adl_out_school],
        backgroundColor: ["#FCAF17", "#4C4D4F"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#FCAF17", "#4C4D4F"],
        hoverBackgroundColor: ["#FCAF17", "#4C4D4F"],

    }]

};
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: {
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                        return parseFloat(previousValue) + parseFloat(currentValue);
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    // alert(total);
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
            }
        }
    }
});

//adolescent Marital status
var pieElem = document.getElementById("adolescent_marrage_chart");
var data4 = {
    labels: [
        "Married",
        "Unmarried",
    ],
    datasets: [{
        data: [total_adl_married, total_adl_unmarried],
        backgroundColor: ["#4C4D4F", "#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 8,
        hoverBorderColor: ["#4C4D4F", "#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F", "#FCAF17"],
    }]

};
var myPieChart = new Chart(pieElem, {
    type: 'doughnut',
    data: data4,
    options: {
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                        return parseFloat(previousValue) + parseFloat(currentValue);
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    // alert(total);
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
            }
        }
    }
});

//religion chart
var pieElem = document.getElementById("adolescent_religion_chart");
var religion_dataset = {
    labels: ["Hindu","Muslim"],
    datasets: [{
        //data: [total_adl_hindu, total_adl_muslim, total_adl_christian, total_adl_buddhist, total_adl_jain, total_adl_sikh, total_adl_parsi, total_adl_jew, total_adl_other],
        data: [total_adl_hindu, total_adl_muslim],
        //backgroundColor: ["#F3661A","#003F5C","#f8981f","#0ac282","#fe9365","#01dbdf","#DBFF33","#75FF33","#D81FDE"],
        backgroundColor: ["#FCAF17", "#4C4D4F"],
        borderWidth: 2,
        hoverBorderWidth: 8,
        hoverBorderColor:["#FCAF17", "#4C4D4F"],
        hoverBackgroundColor: ["#FCAF17", "#4C4D4F"],
    }]

};
var myPieChart = new Chart(pieElem, {
    type: 'doughnut',
    data: religion_dataset,
    options: {
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                        return parseFloat(previousValue) + parseFloat(currentValue);
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    // alert(total);
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
            }
        }
    }
});

//Category chart
var pieElem = document.getElementById("adolescent_occupation_chart");
var category_dataset = {
    labels:["SC","ST","General","OBC","Other"],
    //labels: ["ST","SC","OBC","EBC","General","MBC"],
    //labels: ["ST","SC","OBC","EBC","DNT/VJNT","NT","General","Not Known","MBC","Other"],
    datasets: [{
        //data: [total_adl_sc, total_adl_st, total_adl_obc, total_adl_ebc, total_adl_dnt_jnt, total_adl_nt, total_adl_general, total_adl_not_known, total_adl_mbc, total_adl_other],
        //data:[total_adl_sc, total_adl_st, total_adl_obc, total_adl_ebc, total_adl_general, total_adl_mbc],
        //backgroundColor: ["#bf00ff","#fe9365","#00ffbf","#ffbf00","#40ff00","#ff0040","#1F1FDE","#DE671F","#A5231C","#353c4e"],
        data:[total_adl_sc,total_adl_st,total_adl_general,total_adl_obc,total_adl_others],
        //backgroundColor: ["#4C4D4F", "#FCAF17","#FFCE71","#4C4D4F","#FFD990","#FFEFCE"],
        backgroundColor: ["#1D1D1E", "#FCAF17","#FFCE71","#FFEFCE","#4C4D4F"],
        borderWidth: 2,
        hoverBorderWidth: 8,
        //hoverBorderColor: ["#4C4D4F", "#FCAF17","#FFCE71","#4C4D4F","#FFD990","#FFEFCE"],
        //hoverBackgroundColor: ["#4C4D4F", "#FCAF17","#FFCE71","#4C4D4F","#FFD990","#FFEFCE"]
        hoverBorderColor: ["#1D1D1E", "#FCAF17","#FFCE71","#FFEFCE","#4C4D4F"],
        hoverBackgroundColor: ["#1D1D1E", "#FCAF17","#FFCE71","#FFEFCE","#4C4D4F"]
    }]

};
var myPieChart = new Chart(pieElem, {
    type: 'doughnut',
    data: category_dataset,
    options: {
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                        return parseFloat(previousValue) + parseFloat(currentValue);
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    // alert(total);
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
            }
        }
    }
});

//adolescent Gender status

var optbarchart = {
    maintainAspectRatio: false,
    legend: {
        position: 'right',
        labels: {
            boxWidth: 10
        }
    },
    tooltips: {
        callbacks: {
            label: function (tooltipItem, data) {
                var dataset = data.datasets[tooltipItem.datasetIndex];
                // console.log(data.datasets[0].data[tooltipItem.index]);
                if(tooltipItem.datasetIndex > 0)
                {
                    var total = data.datasets[0].data[tooltipItem.index];

                    // console.log(dataset.data);
                    var currentValue = dataset.data[tooltipItem.index];
                    // return currentValue;
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
                else return '';

            }
        }
    },
    scales: {
        xAxes: [{
            gridLines: {
                display:false
            }
        }],
        yAxes: [{
            gridLines: {
                display:false
            }
        }]
    },
    animation: {
        onComplete: function () {
            var ctx = this.chart.ctx;
            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
            ctx.fillStyle = "black";
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';

            //  console.log(Chart.defaults.global.legend);

            // Chart.defaults.global.legend.forEach(function(legend){
            //     console.log(legend);
            // });

            // var ci = this.chart;
            // var meta = ci.getDatasetMeta(0);
            // meta.hidden = meta.hidden === null ? !ci.data.datasets[0].hidden : null;
            // console.log(meta.hidden);

            this.data.datasets.forEach(function (dataset) {
                for (var i = 0; i < dataset.data.length; i++) {
                    for (var key in dataset._meta) {
                        // console.log(dataset._meta[key].hidden);
                        if(!dataset._meta[key].hidden)
                        {
                            var model = dataset._meta[key].data[i]._model;
                            ctx.fillText(dataset.data[i], model.x, model.y - 5);
                        }

                    }
                }
            });
        }
    },
    layout: {
        padding: {
            top: 20
        }
    }

}
var optlinechart = {
    scales: {
        xAxes: [{
            gridLines: {
                drawOnChartArea: false
            },
            ticks: {
                    beginAtZero: true
                }
        }],
        yAxes: [{
            gridLines: {
                drawOnChartArea: false
            },
            ticks: {
                    beginAtZero: true
                }
        }]
    },
    legend: {
        position: 'right',
        labels: {
            boxWidth: 10
        }
    },
    animation: {
        onComplete: function () {
            var ctx = this.chart.ctx;
            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
            ctx.fillStyle = "black";
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';



            this.data.datasets.forEach(function (dataset) {
                for (var i = 0; i < dataset.data.length; i++) {
                    for (var key in dataset._meta) {
                        var model = dataset._meta[key].data[i]._model;
                        ctx.fillText(dataset.data[i], model.x, model.y - 5);
                    }
                }
            });
        }
    },
    layout: {
        padding: {
            top: 20
        }
    }
}

$('.adolescents_age_category').on('click', adolescents_age_category);
$('.adolescents_schooling_status').on('click', adolescents_schooling_status);
$('.adolescents_marital_status').on('click', adolescents_marital_status);

adolescents_age_category(1);

$('.change_adolscent').click(function () {
    if ($('.adolescents_age_category').is(':checked')) {
        adolescents_age_category();
    }
    if ($('.adolescents_schooling_status').is(':checked')) {
        adolescents_schooling_status();
    }
    if ($('.adolescents_marital_status').is(':checked')) {
        adolescents_marital_status();
    }
});

function adolescents_age_category(initial) {
    $.ajax({
        type: 'GET',
        url: '/adolescents_age_category',
        data: '_token = <?php echo csrf_token() ?>',
        success: function (response) {
            if (response != '') {
                /*if (!initial) {
                    $('.adolescents').hide();
                    $('#adolescents_age_category').parents('.adolescents').show();
                }*/

                $('.adolescents').hide();
                $('#adolescents_age_category').parents('.adolescents').show();

                let chart = new Chart(document.getElementById("adolescents_age_category"), {
                    type: "bar",

                    data: {},
                    options: optbarchart
                });
                let data = {
                    labels: [
                        "12-14 Year",
                        "15-19 Year"
                    ],
                    //labels:[
                       // "<15 Year",
                        //">=15 Year"
                    //],
                    datasets: [{
                        label: "Total",
                        data: response.adolescents.split(','),
                        fill: true,
                        backgroundColor: "#4C4D4F",
                        borderWidth: 1
                    },
                        {
                            label: "Male",
                            data: response.boys.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        },
                        {
                            label: "Female",
                            data: response.girls.split(','),
                            fill: true,
                            backgroundColor: "#FCAF17",
                            borderWidth: 1
                        }]

                };
                chart.data = data;
                chart.update();
            }
        }
    });
}

function adolescents_schooling_status() {
    $.ajax({
        type: 'GET',
        url: '/adolescents_schooling_status',
        data: '_token = <?php echo csrf_token() ?>',
        success: function (response) {
            if (response != '') {
                $('.adolescents').hide();
                $('#adolescents_schooling_status').parents('.adolescents').show();
                let chart = new Chart(document.getElementById("adolescents_schooling_status"), {
                    type: "bar",
                    data: {},
                    options: optbarchart
                });
                let data = {
                    labels: [
                        "In School",
                        "Out School",
                    ],
                    datasets: [{
                        label: "Total",
                        data: response.adolescents.split(','),
                        fill: true,
                        backgroundColor: "#4C4D4F",
                        borderWidth: 1
                    },
                        {
                            label: "Male",
                            data: response.boys.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        },
                        {
                            label: "Female",
                            data: response.girls.split(','),
                            fill: true,
                            backgroundColor: "#FCAF17",
                            borderWidth: 1
                        }]

                };
                chart.data = data;
                chart.update();
            }
        }
    });
};

function adolescents_marital_status() {
    $.ajax({
        type: 'GET',
        url: '/adolescents_marital_status',
        data: '_token = <?php echo csrf_token() ?>',
        success: function (response) {
            if (response != '') {
                $('.adolescents').hide();
                $('#adolescents_marital_status').parents('.adolescents').show();
                let chart = new Chart(document.getElementById("adolescents_marital_status"), {
                    type: "bar",
                    data: {},
                    options: optbarchart
                });

                let data = {
                    labels: [
                        "UnMarried",
                        "Married"
                    ],
                    datasets: [{
                        label: "Total",
                        data: response.adolescents.split(','),
                        fill: true,
                        backgroundColor: "#4C4D4F",
                        borderWidth: 1
                    },
                        {
                            label: "Male",
                            data: response.boys.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        },
                        {
                            label: "Female",
                            data: response.girls.split(','),
                            fill: true,
                            backgroundColor: "#FCAF17",
                            borderWidth: 1
                        }]

                };
                chart.data = data;
                chart.update();
            }
        }
    });
}

var ticksdata_tot = {
    legend: {
        position: 'none'
    },

    animation: {
        onComplete: function () {
            var ctx = this.chart.ctx;
            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
            ctx.fillStyle = "black";
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';
            var lastindex = parseInt(this.data.datasets.length)-1;
            var tempArr = Array();
            // console.log(this.data.datasets[0].data.length);
            for (var i = 0; i < this.data.datasets[0].data.length; i++) {
                tempArr[i] = 0;
            }

            this.data.datasets.forEach(function (dataset, currentindex) {

                // alert(lastindex)
                for (var i = 0; i < dataset.data.length; i++) {
                    var total = 0;
                    for (var key in dataset._meta) {
                        if(!dataset._meta[key].hidden)
                        {
                            var model = dataset._meta[key].data[i]._model;
                            //  alert(tempArr[i]);
                            tempArr[i] = parseFloat(tempArr[i])+parseFloat(dataset.data[i]);

                        }

                    }
                    // console.log(tempArr);
                    // alert(lastindex+' == '+currentindex);
                    if(lastindex == currentindex)
                        ctx.fillText(tempArr[i], model.x, model.y - 5);
                }
            });
        }
    },
    tooltips: {
        callbacks: {
            label: function (tooltipItem, data) {
                var dataset = data.datasets[tooltipItem.datasetIndex];

                var total = parseFloat(data.datasets[0].data[tooltipItem.index]) + parseFloat(data.datasets[1].data[tooltipItem.index]);
                // var currentValue = dataset.data[tooltipItem.index];
                // // console.log(total);
                // var percentage = Math.floor(((currentValue / total) * 100) + 0.5);


                if(isNaN(total))
                    total = 0;

                var currentValue = parseFloat(dataset.data[tooltipItem.index]);
                if(isNaN(currentValue))
                    currentValue = 0;

                // alert('total='+ total+' current='+currentValue);
                var percentage = Math.floor((parseFloat(currentValue / total) * 100) + 0.5);
                if(isNaN(percentage))
                    percentage = 0;


                return percentage + "%";
            }
        }
    },

    scales: {
        xAxes: [{
            //stacked: true,
            gridLines: {
                display:false
            },
            stacked: true,
            ticks: {
                beginAtZero: true,
                maxRotation: 0,
                minRotation: 0,
            }
        }],
        yAxes: [{
            gridLines: {
                display:false
            },
            stacked: true,
            ticks: {
                beginAtZero: true,
                max: 120,
                min: 0,
                stepSize:'10'
              }
        }]
    },
}

if(partner_id == 1 || partner_id == 2 || partner_id == 3)
{
    var ticksdata_tot = {
        legend: {position: 'none'},
        animation: {
            onComplete: function () {
                var ctx = this.chart.ctx;
                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = "black";
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';
                var lastindex = parseInt(this.data.datasets.length)-1;
                var tempArr = Array();
                // console.log(this.data.datasets[0].data.length);
                for (var i = 0; i < this.data.datasets[0].data.length; i++) {
                    tempArr[i] = 0;
                }

                this.data.datasets.forEach(function (dataset, currentindex) {

                    // alert(lastindex)
                    for (var i = 0; i < dataset.data.length; i++) {
                        var total = 0;
                        for (var key in dataset._meta) {
                            if(!dataset._meta[key].hidden)
                            {
                                var model = dataset._meta[key].data[i]._model;
                                //  alert(tempArr[i]);
                                tempArr[i] = parseFloat(tempArr[i])+parseFloat(dataset.data[i]);

                            }

                        }
                        // console.log(tempArr);
                        // alert(lastindex+' == '+currentindex);
                        if(lastindex == currentindex)
                        {
                            
                            if(isNaN(tempArr[i]))
                            {
                                ctx.fillText(0, model.x, model.y - 5);
                            }
                            else
                            {
                                ctx.fillText(tempArr[i], model.x, model.y - 5);
                            }
                        }

                    }
                });
            }
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];

                    var total = parseFloat(data.datasets[0].data[tooltipItem.index]) + parseFloat(data.datasets[1].data[tooltipItem.index]);
                    if(isNaN(total))
                        total = 0;

                    var currentValue = parseFloat(dataset.data[tooltipItem.index]);
                    if(isNaN(currentValue))
                        currentValue = 0;

                    // alert('total='+ total+' current='+currentValue);
                    var percentage = Math.floor((parseFloat(currentValue / total) * 100) + 0.5);
                    if(isNaN(percentage))
                        percentage = 0;
                    return percentage + "%";
                }
            }
        },
        scales: {
            xAxes: [{
                //stacked: true,
                gridLines: {
                    display:false
                },
                stacked: true,
                ticks: {
                    beginAtZero: true,
                    maxRotation: 0,
                    minRotation: 0,
                }
            }],
            yAxes: [{
                gridLines: {
                    display:false
                },
                stacked: true,
                ticks: {
                    beginAtZero: true,
                    max: 25,
                    min: 0,
                    stepSize:'5'
                  }
            }]
        },
    }
}

//ToT Perspective Building Chart
new Chart(document.getElementById("tot_trainee_pr_status_chart"), {
    type: 'bar',

      data: {
        //labels: [Facilitator,ClusterCoordinator],
        labels: total_tot_trainee_pr_district.split(','),

        datasets: [{
            label: "Male",
            type: "bar",
            stack: "tot",
            backgroundColor: "#4C4D4F",
            data: total_male_trainee_pr_allmodule.split(','),
            //formatter: formatter
            //data: [126, 4, 15, 70],
        }, {
            label: "Female",
            type: "bar",
            stack: "tot",
            backgroundColor: "#FCAF17",
            data: total_female_trainee_pr_allmodule.split(','),
            //formatter: formatter
            //data: [2731, 2829, 2998, 2813],
        },
    ]
    },
    options: ticksdata_tot
});

//Refresher Module 1
new Chart(document.getElementById("module1_status_chart_refresher"), {
    type: 'bar',
    data: {
        labels: total_ref_mod1_designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "Refresher",
            backgroundColor: "#4C4D4F",
            data: total_ref_mod1_male_tot.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "Refresher",
            backgroundColor: "#FCAF17",
            data: total_ref_mod1_female_tot.split(','),
            //data: [1778, 725, 1514, 1391],
        }//, {
           // label: "Male",
            //type: "bar",
            //stack: "Refresher",
            //backgroundColor: "#4C4D4F",
            //data: total_ref_mod1_male_refresher.split(','),
            //data: [351, 299, 567, 648],
        //}, {
            //label: "Female",
           // type: "bar",
            //stack: "Refresher",
            //backgroundColor: "#FCAF17",
            //data: total_ref_mod1_female_refresher.split(','),
            //data: [580, 262, 435, 542]
        //}
    ]
    },
    options: ticksdata_tot
});

//Tot module 1
new Chart(document.getElementById("module1_status_chart"), {
    type: 'bar',
    data: {
        labels: total_tot_mod1_designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#4C4D4F",
            data: total_tot_mod1_male.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#FCAF17",
            data: total_tot_mod1_female.split(','),
            //data: [1778, 725, 1514, 1391],
        }
        // , {
        //     label: "Male",
        //     type: "bar",
        //     stack: "ToT",
        //     backgroundColor: "#4C4D4F",
        //     data: total_tot_mod1_male_refresher.split(','),
        //     //data: [351, 299, 567, 648],
        // }, {
        //     label: "Female",
        //     type: "bar",
        //     stack: "ToT",
        //     backgroundColor: "#FCAF17",

        //     data: total_tot_mod1_female_refresher.split(','),
        //     //data: [580, 262, 435, 542]
        // }
    ]
    },
    options: ticksdata_tot
});

//Refresher Module2

new Chart(document.getElementById("module2_status_chart_refresher"), {
    type: 'bar',
    data: {
        labels: total_ref_mod2_designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "Refresher",
            backgroundColor: "#4C4D4F",
            data: total_ref_mod2_male_tot.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "Refresher",
            backgroundColor: "#FCAF17",
            data: total_ref_mod2_female_tot.split(','),
            //data: [1778, 725, 1514, 1391],
        }
        //, {
            //label: "Male",
            //type: "bar",
            //stack: "Refresher",
            //backgroundColor: "#4C4D4F",
            //data: total_ref_mod2_male_refresher.split(','),
            //data: [351, 299, 567, 648],
        //}, {
            //label: "Female",
            //type: "bar",
            //stack: "Refresher",
            //backgroundColor: "#FCAF17",
            //data: total_ref_mod2_female_refresher.split(','),
            //data: [580, 262, 435, 542]
        //}
    ]
    },
    options: ticksdata_tot
});

// Tot module2


new Chart(document.getElementById("module2_status_chart"), {
    type: 'bar',
    data: {
        labels: total_tot_mod2_designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#4C4D4F",
            data: ttotal_tot_mod2_male_tot.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#FCAF17",
            data: total_tot_mod2_female_tot.split(','),
            //data: [1778, 725, 1514, 1391],
        }//, {
            //label: "Male",
            //type: "bar",
            //stack: "ToT",
            //backgroundColor: "#4C4D4F",
            //data: total_tot_mod2_male_refresher.split(','),
            //data: [351, 299, 567, 648],
        //}, {
            //label: "Female",
            //type: "bar",
            //stack: "ToT",
            //backgroundColor: "#FCAF17",
            //data: total_tot_mod2_female_refresher.split(','),
            //data: [580, 262, 435, 542]
        //}
    ]
    },
    options: ticksdata_tot
});

//Refresher Module 3

new Chart(document.getElementById("module3_status_chart_refresher"), {
    type: 'bar',
    data: {
        labels: total_ref_mod3_designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "Refresher",
            backgroundColor: "#4C4D4F",
            data: total_ref_mod3_male_tot.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "Refresher",
            backgroundColor: "#FCAF17",
            data: total_ref_mod3_female_tot.split(','),
            //data: [1778, 725, 1514, 1391],
        }//, {
            //label: "Male",
            //type: "bar",
            //stack: "Refresher",
            //backgroundColor: "#4C4D4F",
            //data: total_ref_mod3_male_refresher.split(','),
            //data: [351, 299, 567, 648],
        //}, {
            //label: "Female",
            //type: "bar",
            //stack: "Refresher",
            //backgroundColor: "#FCAF17",
            //data: total_ref_mod3_female_refresher.split(','),
            //data: [580, 262, 435, 542]
        //}
    ]
    },
    options: ticksdata_tot
});

//Tot Module 3
new Chart(document.getElementById("module3_status_chart"), {
    type: 'bar',
    data: {
        labels: total_tot_mod3_designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#4C4D4F",
            data: total_tot_mod3_male_tot.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#FCAF17",
            data: total_tot_mod3_female_tot.split(','),
            //data: [1778, 725, 1514, 1391],
        }//, {
            //label: "Male",
            //type: "bar",
            //stack: "ToT",
            //backgroundColor: "#4C4D4F",
            //data: total_tot_mod3_male_refresher.split(','),
            //data: [351, 299, 567, 648],
        //}, {
            //label: "Female",
            //type: "bar",
            //stack: "ToT",
            //backgroundColor: "#FCAF17",
            //data: total_tot_mod3_female_refresher.split(','),
            //data: [580, 262, 435, 542]
        //}
    ]
    },
    options: ticksdata_tot
});

//Refresher Module 4

new Chart(document.getElementById("module4_status_chart_refresher"), {
    type: 'bar',
    data: {
        labels: total_ref_mod4_designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "Refresher",
            backgroundColor: "#4C4D4F",
            data: total_ref_mod4__male_tot.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "Refresher",
            backgroundColor: "#FCAF17",
            data: total_ref_mod4_female_tot.split(','),
            //data: [1778, 725, 1514, 1391],
        }//, {
            //label: "Male",
            //type: "bar",
            //stack: "Refresher",
            //backgroundColor: "#4C4D4F",
            //data: total_ref_mod4__male_refresher.split(','),
            //data: [351, 299, 567, 648],
        //}, {
            //label: "Female",
            //type: "bar",
            //stack: "Refresher",
            //backgroundColor: "#FCAF17",
            //data: total_ref_mod4__female_refresher.split(','),
            //data: [580, 262, 435, 542]
        //}
    ]
    },
    options: ticksdata_tot
});

//Tot Module 4
new Chart(document.getElementById("module4_status_chart"), {
    type: 'bar',
    data: {
        labels: total_tot_mod4_designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#4C4D4F",
            data: total_tot_mod4_male_tot.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#FCAF17",
            data: total_tot_mod4_female_tot.split(','),
            //data: [1778, 725, 1514, 1391],
        }//, {
            //label: "Male",
            //type: "bar",
            //stack: "ToT",
            //backgroundColor: "#4C4D4F",
            //data: total_tot_mod4_male_refresher.split(','),
            //data: [351, 299, 567, 648],
        //}, {
            //label: "Female",
            //type: "bar",
            //stack: "ToT",
            //backgroundColor: "#FCAF17",
            //data: total_tot_mod4_female_refresher.split(','),
            //data: [580, 262, 435, 542]
        //}
    ]
    },
    options: ticksdata_tot
});

//all module Tot
new Chart(document.getElementById("allmodule_status_chart"), {
    type: 'bar',
    data: {
        labels: total_tot_all_designation_allmodule.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#4C4D4F",
            data: total_tot_all_male_tot_allmodule.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#FCAF17",
            data: total_tot_all_female_tot_allmodule.split(','),
            //data: [1778, 725, 1514, 1391],
        }//, {
            //label: "Male",
           // type: "bar",
            //stack: "ToT",
            //backgroundColor: "#4C4D4F",
            //data: total_tot_all_male_refresher_allmodule.split(','),
            //data: [351, 299, 567, 648],
        //}, {
            //label: "Female",
            //type: "bar",
            //stack: "ToT",
            //backgroundColor: "#FCAF17",
            //data: total_tot_all_female_refresher_allmodule.split(','),
            //data: [580, 262, 435, 542]
        //}
    ]
    },
    options: {
        legend: {position: 'none'},
        scales: {
            xAxes: [{
                //stacked: true,
                stacked: true,
                ticks: {
                    beginAtZero: true,
                    maxRotation: 0,
                    minRotation: 0
                }
            }],
            yAxes: [{
                stacked: true,
                ticks: ticksdata_tot
            }]
        },
    }
});

//all module Refresher

new Chart(document.getElementById("allmodule5_status_chart"), {
    type: 'bar',
    data: {
        labels: total_ref_designation_allmodule.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "Refresher",
            backgroundColor: "#4C4D4F",
            data: total_ref_male_tot_allmodule.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "Refresher",
            backgroundColor: "#FCAF17",
            data: total_ref_female_tot_allmodule.split(','),
            //data: [1778, 725, 1514, 1391],
        }//, {
            //label: "Male",
            //type: "bar",
            //stack: "Refresher",
            //backgroundColor: "#4C4D4F",
            //data: total_ref_male_refresher_allmodule.split(','),
            //data: [351, 299, 567, 648],
        //}, {
            //label: "Female",
           // type: "bar",
            //stack: "Refresher",
            //backgroundColor: "#FCAF17",
            //data: total_ref_female_refresher_allmodule.split(','),
            //data: [580, 262, 435, 542]
        //}
    ]
    },
    options: {
        legend: {position: 'none'},
        scales: {
            xAxes: [{
                //stacked: true,
                stacked: true,
                ticks: {
                    beginAtZero: true,
                    maxRotation: 0,
                    minRotation: 0
                }
            }],
            yAxes: [{
                stacked: true,
                ticks: ticksdata_tot
            }]
        },
    }
});

var labelcounter=0;

var labels1 = ['Session 1:Module 1', 'Session 2:Module 1', 'Session 3:Module 1', 'Session 4:Module 1', 'Session 1:Module 2', 'Session 2:Module 2', 'Session 3:Module 2', 'Session 1:Module 3', 'Session 2:Module 3', 'Session 3:Module 3', 'Session 4:Module 3', 'Session 5:Module 3', 'Session 6:Module 3', 'Session 1:Module 4', 'Session 2:Module 4', 'Session 3:Module 4', 'Session 4:Module 4'];


var horizonalLinePlugin = {
    afterDraw: function(chartInstance) {
        // console.log((chartInstance.scales));
      var yScale = chartInstance.scales["y-axis-0"];
      var canvas = chartInstance.chart;
      var ctx = canvas.ctx;
      var index;
      var line;
      var style;
      var yValue;

      if (chartInstance.options.horizontalLine) {
        for (index = 0; index < chartInstance.options.horizontalLine.length; index++) {
          line = chartInstance.options.horizontalLine[index];

          if (!line.style) {
            style = "rgba(169,169,169, .6)";
          } else {
            style = line.style;
          }

          if (line.y) {
            yValue = yScale.getPixelForValue(line.y);
          } else {
            yValue = 0;
          }

          ctx.lineWidth = 1;

          if (yValue) {
            ctx.beginPath();
            ctx.moveTo(0, yValue);
            ctx.lineTo(canvas.width, yValue);
            ctx.strokeStyle = style;
            ctx.setLineDash([7]);
            ctx.lineWidth = 1;
            ctx.stroke();
          }

          if (line.text) {
            ctx.fillStyle = style;
            ctx.fillText(line.text, 200, yValue - 15);
          }
        }
        return;
      };
    }
  };


//cse chart
var ticksdata = {
    beginAtZero:true,
    max: 12000,
    min: 0,
    stepSize:'1000'
  }
var horizontalLinedata = {
    "y": 10000,
    "style": "rgba(255, 0, 0, .8)",
    "text": "Target",
  }
if(partner_id == 1 || partner_id == 2 || partner_id == 3)
{
    var ticksdata = {
                        beginAtZero:true,
                        max: 3000,
                        min: 0,
                        stepSize:'500'
                    }
    var horizontalLinedata = {
                        "y": 2500,
                        "style": "rgba(255, 0, 0, .8)",
                        "text": "Target",
                      }
}

var optbarchartcse = {
    maintainAspectRatio: false,
    legend: {
        position: 'right',
        labels: {
            boxWidth: 10
        }
    },

    animation: {
        onComplete: function () {
            var ctx = this.chart.ctx;
            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
            ctx.fillStyle = "black";
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';
            var lastindex = parseInt(this.data.datasets.length)-1;
            var tempArr = Array();
            // console.log(this.data.datasets[0].data.length);
            for (var i = 0; i < this.data.datasets[0].data.length; i++) {
                tempArr[i] = 0;
            }

            this.data.datasets.forEach(function (dataset, currentindex) {

                // alert(lastindex)
                for (var i = 0; i < dataset.data.length; i++) {
                    var total = 0;
                    for (var key in dataset._meta) {
                        if(!dataset._meta[key].hidden)
                        {
                            var model = dataset._meta[key].data[i]._model;
                            //  alert(tempArr[i]);
                            tempArr[i] = parseFloat(tempArr[i])+parseFloat(dataset.data[i]);

                        }

                    }
                    // console.log(tempArr);
                    // alert(lastindex+' == '+currentindex);
                    if(lastindex == currentindex)
                        ctx.fillText(tempArr[i], model.x, model.y - 5);
                }
            });
        }
    },
    layout: {
        padding: {
            top: 20
        }
    },
    // tooltips: {
    //     callbacks: {
    //       title: function(tooltipItem, data) {
    //         var session = data['labels'][tooltipItem[0]['index']];
    //         var val = session.split(':')[1] + " - " +session.split(':')[0];
    //         return val;
    //       },

    //     }
    //   },
    tooltips: {
        callbacks: {
            title: function(tooltipItem, data) {
                var session = data['labels'][tooltipItem[0]['index']];
                var val = session.split(':')[1] + " - " +session.split(':')[0];
                return val;
              },
            label: function (tooltipItem, data) {
                var dataset = data.datasets[tooltipItem.datasetIndex];

                var total = parseFloat(data.datasets[0].data[tooltipItem.index]) + parseFloat(data.datasets[1].data[tooltipItem.index]);
                var currentValue = dataset.data[tooltipItem.index];
                // console.log(total);
                var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                if(isNaN(percentage))
                    percentage = 0;
                return percentage + "%";
            }
        }
    },
    horizontalLine: [horizontalLinedata],
    scales:{
        xAxes:[
          {
            gridLines: {
                display:false
            },
            id:'xAxis1',
            type:"category",
            ticks:{
              callback:function(label){
                var session = label.split(':')[0];
                return session;
              }
            }
          },
          {
              id:'groupAxis',
              type:"category",
              gridLines: {
                drawOnChartArea: false,
              },

              ticks:{
                padding:0,
                maxRotation:0,
                autoSkip: false,
                callback:function(label){

                    if(label == 'Session 3:Module 1')
                    {
                        var module = label.split(':')[1];
                        return module;
                    }
                    if(label == 'Session 2:Module 2')
                    {
                        var module = label.split(':')[1];
                        return module;
                    }
                    /* if(label == 'Session 4(a):Module 3')
                    {
                        var module = label.split(':')[1];
                        return module;
                    } */
                    if(label == 'Session 3:Module 3')
                    {
                        var module = label.split(':')[1];
                        return module;
                    }
                    if(label == 'Session 2:Module 4')
                    {
                        var module = label.split(':')[1];
                        return module;
                    }
                    else
                    {
                        return '';
                    }


                }
              },
              // labels:labels

            }
      ],
        yAxes:[{
            gridLines: {
                display:false
            },
          ticks:ticksdata
        }]
      }
}


$('.cse_genderwise_status').on('click', cse_genderwise_status);
$('.cse_age_category').on('click', cse_age_category);
$('.cse_schooling_status').on('click', cse_schooling_status);
$('.cse_marital_status').on('click', cse_marital_status);
cse_genderwise_status(1);

function cse_genderwise_status(initial) {

    $.ajax({
        type: 'GET',
        url: '/cse_genderwise_status',
        data: '_token = <?php echo csrf_token() ?>',
        success: function (response) {
            if (response != '') {
                $('.cse').hide();
                $('#cse_genderwise_status').parents('.cse').show();
                var labelcounter = 0;
                let chart = new Chart(document.getElementById("cse_genderwise_status"), {
                    type: "bar",
                    xAxisID:'xAxis1',
                    data: {},
                    options: optbarchartcse
                });
                let data = {
                    // labels: response.session_name.split(','),
                    labels: labels1,
                    datasets: [
                        {
                            label: "Male",
                            type: "bar",
                            stack: "cse",
                            data: response.male_adol_allmodule.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        },
                        {
                            label: "Female",
                            type: "bar",
                            stack: "cse",
                            data: response.female_adol_allmodule.split(','),
                            fill: true,
                            backgroundColor: "#FCAF17",
                            borderWidth: 1
                        }]

                };
                chart.data = data;
                Chart.pluginService.register(horizonalLinePlugin);
                chart.update();
            }
        }
    });
}

function cse_age_category() {
    $.ajax({
        type: 'GET',
        url: '/cse_age_category',
        data: '_token = <?php echo csrf_token() ?>',
        success: function (response) {
            if (response != '') {
                console.log(response);
                $('.cse').hide();
                $('#cse_age_category').parents('.cse').show();

                let chart = new Chart(document.getElementById("cse_age_category"), {
                    type: "bar",

                    data: {},
                    options: optbarchartcse
                });
                let data = {
                    labels: labels1,
                    datasets: [
                        {
                            label: "12-14 Year",
                            type: "bar",
                            stack: "cse",
                            data: response.age_12_14.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        },
                        {
                            label: "15-19 Year",
                            type: "bar",
                            stack: "cse",
                            data: response.age_15_19.split(','),
                            fill: true,
                            backgroundColor: "#FCAF17",
                            borderWidth: 1
                        },
                        {
                            label: "DOB not available",
                            type: "bar",
                            stack: "cse",
                            data: response.dob_avai.split(','),
                            fill: true,
                            backgroundColor: "#1D1D1E",
                            borderWidth: 1
                        }]

                };
                chart.data = data;
                chart.update();
            }
        }
    });
}

function cse_schooling_status() {
    $.ajax({
        type: 'GET',
        url: '/cse_schooling_status',
        data: '_token = <?php echo csrf_token() ?>',
        success: function (response) {
            if (response != '') {
                $('.cse').hide();
                $('#cse_schooling_status').parents('.cse').show();

                let chart = new Chart(document.getElementById("cse_schooling_status"), {
                    type: "bar",

                    data: {},
                    options: optbarchartcse
                });
                let data = {
                    labels: labels1,
                    datasets: [
                        {
                            label: "In School",
                            type: "bar",
                            stack: "cse",
                            data: response.adl_inschool.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        },
                        {
                            label: "Out School",
                            type: "bar",
                            stack: "cse",
                            data: response.adl_outschool.split(','),
                            fill: true,
                            backgroundColor: "#FCAF17",
                            borderWidth: 1
                        }]

                };
                chart.data = data;
                chart.update();
            }
        }
    });
}

function cse_marital_status() {
    $.ajax({
        type: 'GET',
        url: '/cse_marital_status',
        data: '_token = <?php echo csrf_token() ?>',
        success: function (response) {
            if (response != '') {
                $('.cse').hide();
                $('#cse_marital_status').parents('.cse').show();

                let chart = new Chart(document.getElementById("cse_marital_status"), {
                    type: "bar",

                    data: {},
                    options: optbarchartcse
                });
                let data = {
                    labels: labels1,
                    datasets: [
                        {
                            label: "Married",
                            type: "bar",
                            stack: "cse",
                            data: response.adl_married.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        },
                        {
                            label: "Unmarried",
                            type: "bar",
                            stack: "cse",
                            data: response.adl_unmarred.split(','),
                            fill: true,
                            backgroundColor: "#FCAF17",
                            borderWidth: 1
                        }]

                };
                chart.data = data;
                chart.update();
            }
        }
    });
}

var ctx = document.getElementById("adolescent_peer_educator_chart");
var data = {
    labels: [
        "Male",
        "Female"
    ],
    datasets: [{
        data: [total_male_peer_educator_allmodule, total_female_peer_educator_allmodule],
        backgroundColor: ["#4C4D4F","#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#4C4D4F","#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F","#FCAF17"]
    }]

};
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: {
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                        return parseFloat(previousValue) + parseFloat(currentValue);
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    // alert(total);
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
            }
        }
    }
});

var ctx = document.getElementById("adolescent_peer_session_chart");
var data = {
    labels: [
        "Male",
        "Female"
    ],
    datasets: [{
        data: [total_male_peer_session_allmodule, total_female_peer_session_allmodule],
        backgroundColor: ["#4C4D4F","#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor:["#4C4D4F","#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F","#FCAF17"],
    }]

};
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: {
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                        return parseFloat(previousValue) + parseFloat(currentValue);
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    // alert(total);
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
            }
        }
    }
});

var ctx = document.getElementById("adolescent_young_leader_chart");
var data = {
    labels: [
        "Male",
        "Female"
    ],
    datasets: [{
        data: [total_male_young_leader_allmodule, total_female_young_leader_allmodule],
        backgroundColor: ["#4C4D4F","#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#4C4D4F","#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F","#FCAF17"]
    }]

};
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: {
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                        return parseFloat(previousValue) + parseFloat(currentValue);
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    // alert(total);
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
            }
        }
    }
});

var ctx = document.getElementById("adolescent_young_leader_trained_chart");
var data = {
    labels: [
        "Male",
        "Female"
    ],
    datasets: [{
        data: [total_adolscent_young_leader_trained_male, total_adolscent_young_leader_trained_female],
        backgroundColor: ["#4C4D4F","#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#4C4D4F","#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F","#FCAF17"],
    }]

};
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: {
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    return data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                }
            }
        }
    }
});

var ctx = document.getElementById("adolescent_manthan_chart");
var data = {
    labels: [],
    datasets: [{
        data: [total_manthan_allmodule],
        backgroundColor: ["#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#FCAF17"],
        hoverBackgroundColor: ["#FCAF17"]
    }]

};
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: {
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                        return parseFloat(previousValue) + parseFloat(currentValue);
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    // alert(total);
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
            }
        }
    }
});

var ctx = document.getElementById("adolescent_community_event_chart");
var data = {
    labels: [],
    datasets: [{
        data: [total_adolscent_community_event_allmodule],
        backgroundColor: ["#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#FCAF17"],
        hoverBackgroundColor: ["#FCAF17"]
    }]

};
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: {
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                        return parseFloat(previousValue) + parseFloat(currentValue);
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    // alert(total);
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return percentage + "%";
                }
            }
        }
    }
});
