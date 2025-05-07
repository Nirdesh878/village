"use strict";

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
        "15-17 Year",
        "18-19 Year"
    ],
    datasets: [{
        data: [total_adl_less_then_fifteen, total_adl_greater_then_fifteen,total_adl_greater_then_seventeen],
        //backgroundColor: ["#4C4D4F", "#FCAF17","#1D1D1E"],
        backgroundColor: ["#FCAF17", "#4C4D4F","#1D1D1E"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#FCAF17", "#4C4D4F","#1D1D1E"],
        hoverBackgroundColor: ["#FCAF17", "#4C4D4F","#1D1D1E"],
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
    labels: ["Out School", "In School"],
    datasets: [{
        data: [total_adl_out_school, total_adl_in_school],
        backgroundColor: ["#4C4D4F", "#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#4C4D4F", "#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F", "#FCAF17"],

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
        hoverBorderWidth: 10,
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
    labels: ["Muslim", "Hindu"],
    datasets: [{
        //data: [total_adl_hindu, total_adl_muslim, total_adl_christian, total_adl_buddhist, total_adl_jain, total_adl_sikh, total_adl_parsi, total_adl_jew, total_adl_other],
        data: [total_adl_muslim, total_adl_hindu],
        //backgroundColor: ["#F3661A","#003F5C","#f8981f","#0ac282","#fe9365","#01dbdf","#DBFF33","#75FF33","#D81FDE"],
        backgroundColor: ["#4C4D4F", "#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#4C4D4F", "#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F", "#FCAF17"],
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
        //backgroundColor: ["#FCAF17", "#1D1D1E","#FFCE71","#4C4D4F","#A57404"],
        //backgroundColor: ["#4C4D4F", "#1D1D1E","#FFCE71","#FCAF17","#A57404"],
        backgroundColor: ["#1D1D1E", "#FCAF17","#FFCE71","#4C4D4F","#A57404"],
        borderWidth: 2,
        hoverBorderWidth: 8,
        //hoverBorderColor: ["#4C4D4F", "#FCAF17","#FFCE71","#4C4D4F","#FFD990","#FFEFCE"],
        //hoverBackgroundColor: ["#4C4D4F", "#FCAF17","#FFCE71","#4C4D4F","#FFD990","#FFEFCE"]
        hoverBorderColor: ["#1D1D1E", "#FCAF17","#FFCE71","#4C4D4F","#A57404"],
        //hoverBorderColor: ["#4C4D4F", "#1D1D1E","#FFCE71","#FCAF17","#A57404"],
        hoverBackgroundColor: ["#1D1D1E", "#FCAF17","#FFCE71","#4C4D4F","#A57404"],
        //hoverBackgroundColor: ["#4C4D4F", "#1D1D1E","#FFCE71","#FCAF17","#A57404"],

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
var ticks_adol = {
    beginAtZero:true,
    max: 12000,
    min: 0,
    stepSize:'1000'
  }
if((partner_id == 1) || (partner_id == 2) || (partner_id == 3) || (dash_district_id > 0))
  {
      var ticks_adol = {
                          beginAtZero:true,
                          max: 3500,
                          min: 0,
                          stepSize:'500'
                      }
  }
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
            title: function(tooltipItem, data) {
                var session = data['labels'][tooltipItem[0]['index']];
                var sss = data['datasets'][tooltipItem[0]['datasetIndex']]['label'];
                //alert(sss);
                var val = session +'-'+sss;
                return val;
              },
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
            },
            ticks: {
                beginAtZero: true
            }
        }],
        yAxes: [{
            gridLines: {
                display:false
            },
            ticks: ticks_adol
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



$('.adolescents_age_category').on('click', adolescents_age_category);
$('.adolescents_schooling_status').on('click', adolescents_schooling_status);
$('.adolescents_marital_status').on('click', adolescents_marital_status);
$('.adolescents_schooling_status_agewise').on('click', adolescents_schooling_status_agewise);
$('.adolescents_marital_status_agewise').on('click', adolescents_marital_status_agewise);
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
    if ($('.adolescents_schooling_status_agewise').is(':checked')) {
        adolescents_schooling_status_agewise();
    }
    if ($('.adolescents_marital_status_agewise').is(':checked')) {
        adolescents_marital_status_agewise();
    }
});

function adolescents_age_category(initial) {
    $.ajax({
        type: 'GET',
        url: '/adolescents_age_category',
        data: '',
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
                        backgroundColor: "#A57404",
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
        data: '',
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
                        backgroundColor: "#A57404",
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
        data: '',
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
                        backgroundColor: "#A57404",
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
function adolescents_schooling_status_agewise(initial) {
    $.ajax({
        type: 'GET',
        url: '/adolescents_schooling_status_agewise',
        data: '',
        success: function (response) {
            if (response != '') {
                $('.adolescents').hide();
                $('#adolescents_schooling_status_agewise').parents('.adolescents').show();
                let chart = new Chart(document.getElementById("adolescents_schooling_status_agewise"), {
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
                        backgroundColor: "#A57404",
                        borderWidth: 1
                    },
                        {
                            label: "12-14 Year",
                            data: response.adol_less15.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        },
                        {
                            label: "15-19 Year",
                            data: response.adol_greater15.split(','),
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
function adolescents_marital_status_agewise() {
    $.ajax({
        type: 'GET',
        url: '/adolescents_marital_status_agewise',
        data: '',
        success: function (response) {
            if (response != '') {
                $('.adolescents').hide();
                $('#adolescents_marital_status_agewise').parents('.adolescents').show();
                let chart = new Chart(document.getElementById("adolescents_marital_status_agewise"), {
                    type: "bar",
                    data: {},
                    options: optbarchart
                });

                let data = {
                    labels: [
                        "Married",
                        "UnMarried"
                    ],
                    datasets: [{
                        label: "Total",
                        data: response.adolescents.split(','),
                        fill: true,
                        backgroundColor: "#A57404",
                        borderWidth: 1
                    },
                        {
                            label: "12-14 Year",
                            data: response.adol_less15.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        },
                        {
                            label: "15-19 Year",
                            data: response.adol_greater15.split(','),
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

var ticksdata_tot = {

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
            title: function(tooltipItem, data) {
                var session = data['labels'][tooltipItem[0]['index']];
                var sss = data['datasets'][tooltipItem[0]['datasetIndex']]['label'];
                //alert(sss);
                var val = session +'-'+sss;
                return val;
              },
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

if((partner_id == 1) || (partner_id == 2) || (partner_id == 3) || (dash_district_id > 0))
{
    var ticksdata_tot = {
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
                title: function(tooltipItem, data) {
                    var session = data['labels'][tooltipItem[0]['index']];
                    var sss = data['datasets'][tooltipItem[0]['datasetIndex']]['label'];
                    //alert(sss);
                    var val = session +'-'+sss;
                    return val;
                  },
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
        layout: {
            padding: {
                top: 20
            }
        }
    }
}

//ToT Perspective Building Chart
var i = 0;
var perspectiveArr = perspective_module1.data;
var perspectiveArr_count = perspectiveArr.length;
var perspectiveArr_count_ss = perspectiveArr_count-1;
for(i=0; i<perspectiveArr_count; i++)
{
new Chart(document.getElementById("tot_trainee_pr_status_chart"+i), {
    type: 'bar',

      data: {
        //labels: [Facilitator,ClusterCoordinator],
        labels: perspectiveArr[i].designation.split(','),

        datasets: [{
            label: "Male",
            type: "bar",
            stack: "tot",
            backgroundColor: "#4C4D4F",
            data: perspectiveArr[i].male_trainee_pr_allmodule.split(','),
            //formatter: formatter
            //data: [126, 4, 15, 70],
        }, {
            label: "Female",
            type: "bar",
            stack: "tot",
            backgroundColor: "#FCAF17",

            data: perspectiveArr[i].female_trainee_pr_allmodule.split(','),
            //formatter: formatter
            //data: [2731, 2829, 2998, 2813],
        },
    ]
    },
    options: ticksdata_tot
    });
}
//Refresher Module 1
var i = 0;
var refmodule1Arr = refmodule1.data;
var refmodule1Arr_count = refmodule1Arr.length;
var refmodule1Arr_count_ss = refmodule1Arr_count-1;
for(i=0; i<refmodule1Arr_count; i++)
{
    new Chart(document.getElementById("module1_status_chart_refresher"+i), {
        type: 'bar',
        data: {
            labels: refmodule1Arr[i].designation.split(','),
            datasets: [{
                label: "Male",
                type: "bar",
                stack: "Refresher",
                backgroundColor: "#4C4D4F",
                data: refmodule1Arr[i].male.split(','),
            }, {
                label: "Female",
                type: "bar",
                stack: "Refresher",
                backgroundColor: "#FCAF17",
                data: refmodule1Arr[i].femmale.split(','),
            }]
        },
        options: ticksdata_tot
    });
}


//Tot module 1

var i = 0;
var totArr = tot_module11.data;
var totArr_count = totArr.length;

for(i=0; i<totArr_count; i++)
{
new Chart(document.getElementById("module1_status_chart"+i), {
    type: 'bar',
    data: {
        labels: totArr[i].designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#4C4D4F",
            data: totArr[i].male.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#FCAF17",
            data: totArr[i].femmale.split(','),
            //data: [1778, 725, 1514, 1391],
        }

    ]
    },
    options: ticksdata_tot
});
}

//Refresher Module 2
var i = 0;
var refmodule2Arr = refmodule2.data;
var refmodule2Arr_count = refmodule2Arr.length;
var refmodule2Arr_count_ss = refmodule2Arr_count-1;

for(i=0; i<refmodule2Arr_count; i++)
{
    new Chart(document.getElementById("module2_status_chart_refresher"+i), {
        type: 'bar',
        data: {
            labels: refmodule2Arr[i].designation.split(','),
            datasets: [{
                label: "Male",
                type: "bar",
                stack: "Refresher",
                backgroundColor: "#4C4D4F",
                data: refmodule2Arr[i].male.split(','),
            }, {
                label: "Female",
                type: "bar",
                stack: "Refresher",
                backgroundColor: "#FCAF17",
                data: refmodule2Arr[i].femmale.split(','),
            }]
        },
        options: ticksdata_tot
    });
}


// Tot module2

var i = 0;
var totArr2 = tot_module22.data;
var totArr2_count = totArr2.length;

for(i=0; i<totArr2_count; i++)
{
new Chart(document.getElementById("module2_status_chart"+i), {
    type: 'bar',
    data: {
        labels: totArr2[i].designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#4C4D4F",
            data: totArr2[i].male.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#FCAF17",

            data: totArr2[i].femmale.split(','),
            //data: [1778, 725, 1514, 1391],
        }
    ]
    },
    options: ticksdata_tot
});
}
//Refresher Module 3

var i = 0;
var refmodule3Arr = refmodule3.data;
var refmodule3Arr_count = refmodule3Arr.length;
var refmodule3Arr_count_ss = refmodule3Arr_count-1;

for(i=0; i<refmodule3Arr_count; i++)
{
    new Chart(document.getElementById("module3_status_chart_refresher"+i), {
        type: 'bar',
        data: {
            labels: refmodule3Arr[i].designation.split(','),
            datasets: [{
                label: "Male",
                type: "bar",
                stack: "Refresher",
                backgroundColor: "#4C4D4F",
                data: refmodule3Arr[i].male.split(','),
            }, {
                label: "Female",
                type: "bar",
                stack: "Refresher",
                backgroundColor: "#FCAF17",
                data: refmodule3Arr[i].femmale.split(','),
            }]
        },
        options: ticksdata_tot
    });
}


//Tot Module 3
var i = 0;
var totArr3 = tot_module33.data;
var totArr3_count = totArr3.length;

for(i=0; i<totArr3_count; i++)
{
new Chart(document.getElementById("module3_status_chart"+i), {
    type: 'bar',
    data: {
        labels: totArr3[i].designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#4C4D4F",
            data: totArr3[i].male.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#FCAF17",

            data: totArr3[i].femmale.split(','),
            //data: [1778, 725, 1514, 1391],
        }
    ]
    },
    options: ticksdata_tot
});
}
//Refresher Module 4

var i = 0;
var refmodule4Arr = refmodule4.data;

var refmodule4Arr_count = refmodule4Arr.length;
var refmodule4Arr_count_ss = refmodule4Arr_count-1;
//alert(refmodule1Arr_count_ss);
for(i=0; i<refmodule4Arr_count; i++)
{
    new Chart(document.getElementById("module4_status_chart_refresher"+i), {
        type: 'bar',
        data: {
            labels: refmodule4Arr[i].designation.split(','),
            datasets: [{
                label: "Male",
                type: "bar",
                stack: "Refresher",
                backgroundColor: "#4C4D4F",
                data: refmodule4Arr[i].male.split(','),
            }, {
                label: "Female",
                type: "bar",
                stack: "Refresher",
                backgroundColor: "#FCAF17",
                data: refmodule4Arr[i].femmale.split(','),
            }]
        },
        options: ticksdata_tot
    });
}


//Tot Module 4
var i = 0;
var totArr4 = tot_module44.data;
var totArr4_count = totArr4.length;

for(i=0; i<totArr4_count; i++)
{
new Chart(document.getElementById("module4_status_chart"+i), {
    type: 'bar',
    data: {
        labels: totArr4[i].designation.split(','),
        datasets: [{
            label: "Male",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#4C4D4F",
            data: totArr4[i].male.split(','),
            //data: [1119, 842, 1499, 1492],
        }, {
            label: "Female",
            type: "bar",
            stack: "ToT",
            backgroundColor: "#FCAF17",

            data: totArr4[i].femmale.split(','),
            //data: [1778, 725, 1514, 1391],
        }
    ]
    },
    options: ticksdata_tot
});
}
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

var labels1 = ['Introduction and Orientation:Module 1', 'Me and My Body-External:Module 1', 'Me and My Body-Internal:Module 1', 'Intersectionality-Identity and Power:Module 2', 'Gender and Socialisation:Module 2', 'Body Diversity:Module 2','Diversity - Family and Love:Module 2','Sex:Module 3', 'Healthy and Unhealthy Relationships:Module 3', 'Impact of the Image of Real Man(Boys):Module 3', 'Agency and Assertive Communication(Girls):Module 3', 'Consent and Violence:Module 3','Contraception and Abortion:Module 4', 'RTIs and STIs:Module 4'];


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



  var horizontalLinedata_leader = {
    "y": 0,
    "style": "rgba(255, 0, 0, .8)",
    "text": "Leader Adolescents",
  }

if((partner_id == 1) || (partner_id == 2) || (partner_id == 3) || (dash_district_id > 0))
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
                var sss = data['datasets'][tooltipItem[0]['datasetIndex']]['label'];
                var val = session.split(':')[1] + " - " +session.split(':')[0] + " - " +sss;
                return val;
              },
            label: function (tooltipItem, data) {
                var dataset = data.datasets[tooltipItem.datasetIndex];

                var total = parseFloat(data.datasets[0].data[tooltipItem.index]) + parseFloat(data.datasets[1].data[tooltipItem.index]);

                if(typeof data.datasets[2] === 'undefined') {
                    // does not exist
                }
                else {
                    total = total + parseFloat(data.datasets[2].data[tooltipItem.index]);
                }
                var currentValue = dataset.data[tooltipItem.index];
                // console.log(total);
                var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                if(isNaN(percentage))
                    percentage = 0;
                return percentage + "%";
            }
        }
    },


    horizontalLine: [horizontalLinedata, horizontalLinedata_leader],

    scales:{
        xAxes:[
            {
                gridLines: {
                    display:false
                },
                id:'xAxis1',
                type:"category",
                ticks:{
                    maxRotation:90,
                    minRotation:90,
                    autoSkip: false,
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
                    minRotation:0,
                    autoSkip: false,
                    callback:function(label){

                        if(label == 'Me and My Body-External:Module 1')
                        {
                            var module = label.split(':')[1];
                            return module;
                        }
                        if(label == 'Gender and Socialisation:Module 2')
                        {
                            var module = label.split(':')[1];
                            return module;
                        }

                        if(label == 'Impact of the Image of Real Man(Boys):Module 3')
                        {
                            var module = label.split(':')[1];
                            return module;
                        }
                        if(label == 'Contraception and Abortion:Module 4')
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

    //alert(horizontalLinedata_leader.y);
    $.ajax({
        type: 'GET',
        url: '/cse_genderwise_status',
        data: '',
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
                            label: "Female",
                            type: "bar",
                            stack: "cse",
                            data: response.female_adol_allmodule.split(','),
                            fill: true,
                            backgroundColor: "#FCAF17",

                            borderWidth: 1
                        },
                        {
                            label: "Male",
                            type: "bar",
                            stack: "cse",
                            data: response.male_adol_allmodule.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        }
                        ]

                };
                horizontalLinedata_leader.y = response.leader_adolescent;
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
        data: '',
        success: function (response) {
            if (response != '') {
                console.log(response);
                $('.cse').hide();
                $('#cse_age_category').parents('.cse').show();

                // let chart = new Chart(document.getElementById("cse_age_category"), {
                //     type: "bar",

                //     data: {},
                //     options: optbarchartcse
                // });

                let canvas = document.getElementById("cse_age_category");
                let ctx = canvas.getContext("2d");
                let chart = new Chart(ctx, {
                    type: 'bar',
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
                            backgroundColor: "#FCAF17",
                            borderWidth: 1
                        },
                        {
                            label: "15-19 Year",
                            type: "bar",
                            stack: "cse",
                            data: response.age_15_19.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        }]

                };

                chart.data = data;

                canvas.onclick = function(evt) {
                    var activePoints = chart.getElementsAtEvent(evt);
                   // console.log(activePoints);
                    if (activePoints[0]) {
                      var chartData = activePoints[0]['_chart'].config.data;
                      var idx = activePoints[0]['_index'];
                      var label = chartData.labels[idx];
                      var value = chartData.datasets[0].data[idx];
                      var myarr = label.split(":");
                      var session = myarr[0];
                      //alert(session);
                      $.ajax({
                        type: 'GET',
                        url: '/cse_module_status_age/' +session,
                        data: '',
                        success: function (response) {
                            if (response != '') {
                                console.log(response);
                                $('#large-Modal_age').modal('show');
                                //alert(response.age_boy);
                                let bb = response.age_boy.split(',');
                                let cc = response.age_girl.split(',');

                                let canvas_new = document.getElementById("cse_module_status_age");
                                let ctx_new = canvas_new.getContext("2d");
                                let chart_new = new Chart(ctx_new, {
                                    type: 'bar',
                                    data: {
                                        labels: [
                                            "12-14 Year",
                                            "15-19 Year"
                                        ],
                                        datasets: [{
                                                        label: "Male",
                                                        type: "bar",
                                                        stack: "12-14 Year",
                                                        backgroundColor: "#4C4D4F",
                                                        data: bb,

                                                        //data: response.age_boy.split(','),
                                                    },
                                                    {
                                                        label: "Female",
                                                        type: "bar",
                                                        stack: "15-19 Year",
                                                        backgroundColor: "#FCAF17",
                                                        //data: ['300','200']
                                                        data: cc,

                                                    }]
                            },
                            options: {
                                legend: {position: 'right'},
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
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                },
                            }
                        });
                        chart_new.update();
                            }
                        }
                    });

                    }
                  };

                chart.update();


            }
        }
    });
}

function cse_schooling_status() {
    $.ajax({
        type: 'GET',
        url: '/cse_schooling_status',
        data: '',
        success: function (response) {
            if (response != '') {
                $('.cse').hide();
                $('#cse_schooling_status').parents('.cse').show();
                let canvas = document.getElementById("cse_schooling_status");
                let ctx = canvas.getContext("2d");
                let chart = new Chart(ctx, {
                    type: 'bar',
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
                            backgroundColor: "#FCAF17",
                            borderWidth: 1
                        },
                        {
                            label: "Out School",
                            type: "bar",
                            stack: "cse",
                            data: response.adl_outschool.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        }]

                };
                chart.data = data;
                canvas.onclick = function(evt) {
                    var activePoints = chart.getElementsAtEvent(evt);
                    if (activePoints[0]) {
                      var chartData = activePoints[0]['_chart'].config.data;
                      var idx = activePoints[0]['_index'];
                      var label = chartData.labels[idx];
                      var value = chartData.datasets[0].data[idx];
                      var myarr = label.split(":");
                      var session = myarr[0];
                      //alert(session);
                      $.ajax({
                        type: 'GET',
                        url: '/cse_schooling_status_genderwise/' +session,
                        data: '',
                        success: function (response) {
                            if (response != '') {
                                console.log(response);
                                $('#large-Modal_age').modal('show');
                                //alert(response.age_boy);
                                let bb = response.adl_inschool.split(',');
                                let cc = response.adl_outschool.split(',');

                                let canvas_new = document.getElementById("cse_module_status_age");
                                let ctx_new = canvas_new.getContext("2d");
                                let chart_new = new Chart(ctx_new, {
                                    type: 'bar',
                                    data: {
                                        labels: [
                                            "In School",
                                            "Out School"
                                        ],
                                        datasets: [{
                                                        label: "Male",
                                                        type: "bar",
                                                        stack: "In School",
                                                        backgroundColor: "#4C4D4F",
                                                        data: bb,

                                                        //data: response.age_boy.split(','),
                                                    },
                                                    {
                                                        label: "Female",
                                                        type: "bar",
                                                        stack: "Out School",
                                                        backgroundColor: "#FCAF17",
                                                        //data: ['300','200']
                                                        data: cc,

                                                    }]
                            },
                            options: {
                                legend: {position: 'right'},
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
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                },
                            }
                        });
                        chart_new.update();
                            }
                        }
                    });

                    }
                  };

                chart.update();
            }
        }
    });
}

function cse_marital_status() {
    $.ajax({
        type: 'GET',
        url: '/cse_marital_status',
        data: '',
        success: function (response) {
            if (response != '') {
                $('.cse').hide();
                $('#cse_marital_status').parents('.cse').show();

                let canvas = document.getElementById("cse_marital_status");
                let ctx = canvas.getContext("2d");
                let chart = new Chart(ctx, {
                    type: 'bar',
                    data: {},
                    options: optbarchartcse
                });
                let data = {
                    labels: labels1,
                    datasets: [
                        {
                            label: "Unmarried",
                            type: "bar",
                            stack: "cse",
                            data: response.adl_unmarred.split(','),
                            fill: true,
                            backgroundColor: "#FCAF17",

                            borderWidth: 1
                        },
                        {
                            label: "Married",
                            type: "bar",
                            stack: "cse",
                            data: response.adl_married.split(','),
                            fill: true,
                            backgroundColor: "#4C4D4F",
                            borderWidth: 1
                        }
                        ]

                };
                chart.data = data;
                canvas.onclick = function(evt) {
                    var activePoints = chart.getElementsAtEvent(evt);
                    if (activePoints[0]) {
                      var chartData = activePoints[0]['_chart'].config.data;
                      var idx = activePoints[0]['_index'];
                      var label = chartData.labels[idx];
                      var value = chartData.datasets[0].data[idx];
                      var myarr = label.split(":");
                      var session = myarr[0];
                      //alert(session);
                      $.ajax({
                        type: 'GET',
                        url: '/cse_marital_status_genderwise/' +session,
                        data: '',
                        success: function (response) {
                            if (response != '') {
                                console.log(response);
                                $('#large-Modal_age').modal('show');
                                //alert(response.age_boy);
                                let bb = response.male_adl_married.split(',');
                                let cc = response.female_adl_married.split(',');

                                let canvas_new = document.getElementById("cse_module_status_age");
                                let ctx_new = canvas_new.getContext("2d");
                                let chart_new = new Chart(ctx_new, {
                                    type: 'bar',
                                    data: {
                                        labels: [
                                            "Married",
                                            "Un Married"
                                        ],
                                        datasets: [{
                                                label: "Male",
                                                type: "bar",
                                                stack: "Married",
                                                backgroundColor: "#4C4D4F",
                                                data: bb,

                                                },
                                                {
                                                    label: "Female",
                                                    type: "bar",
                                                    stack: "Un Married",
                                                    backgroundColor: "#FCAF17",
                                                        //data: ['300','200']
                                                    data: cc,

                                                }]
                            },
                            options: {
                                legend: {position: 'right'},
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
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                },
                            }
                        });
                        chart_new.update();
                            }
                        }
                    });

                    }
                  };

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
        backgroundColor: ["#4C4D4F", "#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#4C4D4F", "#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F", "#FCAF17"],
    }]

};

//peer educator chart
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

var ctx = document.getElementById("adolescent_peer_educator_chart_age_wise");
var data = {
    labels: [
        "12-14 Year",
        "15-17 Year","18-19 Year"
    ],
    datasets: [{
        data: [adllt15, adlgte15,adlgte17],
        backgroundColor: ["#FCAF17", "#4C4D4F","#1D1D1E"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#FCAF17", "#4C4D4F","#1D1D1E"],
        hoverBackgroundColor: ["#FCAF17", "#4C4D4F","#1D1D1E"],
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

var ctx = document.getElementById("adolescent_peer_educator_chart_school_wise");
var data = {
    labels: [
        "In School",
        "Out School"
    ],
    datasets: [{
        data: [adl_in_school, adl_out_school],
        backgroundColor: ["#4C4D4F", "#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#4C4D4F", "#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F", "#FCAF17"],
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

var ctx = document.getElementById("adolescent_peer_educator_chart_maritial_wise");
var data = {
    labels: [
        "Married",
        "Un Married"
    ],
    datasets: [{
        data: [adl_married, adl_unmarried],
        backgroundColor: ["#4C4D4F", "#FCAF17"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#4C4D4F", "#FCAF17"],
        hoverBackgroundColor: ["#4C4D4F", "#FCAF17"],
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


new Chart(document.getElementById("gatekeeper_adolescent"), {
    type: 'bar',
    data: {
        labels: activity_type.split(','),
        datasets: [{
            //label: "Activity",
            backgroundColor: "#FCAF17",
            data: adolescent_sum.split(','),
        }]
    },
    options: {
        legend: {position: 'none'},
        scales: {
            xAxes: [{
               stacked: true,
                ticks: {
                    beginAtZero: true,
                    maxRotation: 65,
                    minRotation: 65
                }
            }],
            yAxes: [{
                stacked: true,
                ticks: {
                    beginAtZero: true,
                    stepSize:'5'
                }
            }]
        },
    }
});

//peer session chart

var ticksdata_peer = {
    beginAtZero:true,
    min: 0,
    userCallback: function(label, index, labels) {
        // when the floored value is the same as the value we have a whole number
        if (Math.floor(label) === label) {
            return label;
        }

    },

  }
var optbarchartpeer = {
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

    tooltips: {
        callbacks: {
            title: function(tooltipItem, data) {
                var session = data['labels'][tooltipItem[0]['index']];
                var sss = data['datasets'][tooltipItem[0]['datasetIndex']]['label'];
                var val = session.split(':')[1] + " - " +session.split(':')[0] + " - " +sss;
                return val;
              },
            label: function (tooltipItem, data) {
                var dataset = data.datasets[tooltipItem.datasetIndex];

                var total = parseFloat(data.datasets[0].data[tooltipItem.index]) + parseFloat(data.datasets[1].data[tooltipItem.index]);

                if(typeof data.datasets[2] === 'undefined') {
                    // does not exist
                }
                else {
                    total = total + parseFloat(data.datasets[2].data[tooltipItem.index]);
                }
                var currentValue = dataset.data[tooltipItem.index];
                // console.log(total);
                var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                if(isNaN(percentage))
                    percentage = 0;
                return percentage + "%";
            }
        }
    },
    scales:{
        xAxes:[
            {
                gridLines: {
                    display:false
                },
                id:'xAxis1',
                type:"category",
                ticks:{
                    maxRotation:90,
                    minRotation:90,
                    autoSkip: false,
                    beginAtZero: true,
                    min: 0,
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
                    minRotation:0,
                    autoSkip: false,
                    callback:function(label){

                        if(label == 'Me and My Body-External:Module 1')
                        {
                            var module = label.split(':')[1];
                            return module;
                        }
                        if(label == 'Body Diversity:Module 2')
                        {
                            var module = label.split(':')[1];
                            return module;
                        }
                        if(label == 'Impact of the Image of Real Man(Boys):Module 3')
                        {
                            var module = label.split(':')[1];
                            return module;
                        }
                        if(label == 'Contraception and Abortion:Module 4')
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
            }
      ],
        yAxes:[{
            gridLines: {
                display:false,
                beginAtZero: true,
                min: 0,
            },
            ticks:ticksdata_peer
        }]
      }
}
new Chart(document.getElementById("peer_genderwise_status"), {
    type: 'bar',
    data: {
        labels: labels1,
        datasets: [
            {
                label: "Female",
                type: "bar",
                stack: "cse",
                data: female_adol_allmodule.split(','),
                fill: true,
                backgroundColor: "#FCAF17",

                borderWidth: 1
            },
            {
                label: "Male",
                type: "bar",
                stack: "cse",
                data: male_adol_allmodule.split(','),
                fill: true,
                backgroundColor: "#4C4D4F",
                borderWidth: 1
            }]
    },
    options: optbarchartpeer
});

new Chart(document.getElementById("gatekeeper_adolescent_community"), {
    type: 'bar',
    data: {
        labels: activity_type.split(','),
        datasets: [
            {
                label: "Teacher",
                type: "bar",
                data: teacher.split(','),
                fill: true,
                backgroundColor: "#4C4D4F",
                borderWidth: 1
            },
            {
                label: "Parent",
                type: "bar",
                data: parents.split(','),
                fill: true,
                backgroundColor: "#FCAF17",
                borderWidth: 1
            },
            {
                label: "Local Leader",
                type: "bar",
                data: local_leader.split(','),
                fill: true,
                backgroundColor: "#A57404",
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive:true,
        maintainAspectRatio:false,
        legend: {position: 'right'},
        layout: {
            padding: {
            left: 0,
            right: 0,
            top: 5,
            bottom: 100
            }},
        scales: {
            xAxes: [{
               stacked: true,
                ticks: {
                    beginAtZero: true,
                    maxRotation: 90,
                    minRotation: 90
                }
            }],
            yAxes: [{
                stacked: true,
                ticks: {
                    beginAtZero: true,
                    min: 0,
                    userCallback: function(label, index, labels) {
                        // when the floored value is the same as the value we have a whole number
                        if (Math.floor(label) === label) {
                            return label;
                        }

                    },
                }
            }]
        },
    }
});

new Chart(document.getElementById("gatekeeper_adolescent_community_held"), {
    type: 'bar',
    data: {
        labels: activity_type.split(','),
        datasets: [
            {

                data: activity_count.split(','),
                fill: true,
                backgroundColor: "#FCAF17",
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive:true,
        maintainAspectRatio:false,
        legend: {position: 'none'},
        layout: {
            padding: {
            left: 0,
            right: 0,
            top: 5,
            bottom: 100
            }},
        scales: {
            xAxes: [{
               stacked: true,
                ticks: {
                    beginAtZero: true,
                    maxRotation: 90,
                    minRotation: 90
                }
            }],
            yAxes: [{
                stacked: true,
                ticks: {
                    beginAtZero: true,
                    min: 0,
                    userCallback: function(label, index, labels) {
                        // when the floored value is the same as the value we have a whole number
                        if (Math.floor(label) === label) {
                            return label;
                        }

                    },
                }
            }]
        },
    }
});

new Chart(document.getElementById("adolescent_peer_educator_chart_sex_wise"), {
    type: 'bar',
    data: {
            labels: ["Male",
                    "Female"],
            datasets: [{
                            data: [male, female],
                            fill: true,
                            backgroundColor: ["#4C4D4F","#FCAF17"],

                            borderWidth: 1
                        }]
        },
    options: {
        legend: {position: 'none'},
        scales: {
            xAxes: [{
               stacked: true,
                ticks: {
                    beginAtZero: true,
                    barPercentage: 0.2
                }
            }],
            yAxes: [{
                stacked: true,
                ticks: {
                    beginAtZero: true,
                    min: 0,
                    userCallback: function(label, index, labels) {
                        // when the floored value is the same as the value we have a whole number
                        if (Math.floor(label) === label) {
                            return label;
                        }

                    },
                }
            }]
        },
    }
});

var pieElem = document.getElementById("activity_wise_adolescent");
var data = {
    labels: [
        "Peer Session",
        "Gatekeeper Engagement"
    ],
    datasets: [{
        data: [peer, gatekeper],
        backgroundColor: ["#FCAF17", "#4C4D4F"],
        borderWidth: 2,
        hoverBorderWidth: 10,
        hoverBorderColor: ["#FCAF17", "#4C4D4F"],
        hoverBackgroundColor: ["#FCAF17", "#4C4D4F"],
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
