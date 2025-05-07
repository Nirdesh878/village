"use strict";
$(document).ready(function(){
    /*Bar chart*/
    /*var data1 = {
        labels: ['1-10', '11-20', '21-30', '31-40', '41-50', '50-60'],
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
            data: [11, 22, 33, 44, 23, 32, 18],
        }]
    };

    var bar = document.getElementById("barChart").getContext('2d');
    var myBarChart = new Chart(bar, {
        type: 'bar',
        data: data1,
        options: {
            barValueSpacing: 30
        }
    });*/

    // UTarray.forEach(function(e) {console.log(e.Month+',');});

    /*UT Month Bar chart*/
    var UTlabels = Array();
    var UTdataset = Array();
    UTarray.forEach(function(e) {  UTlabels.push(e.Year+ "," +e.Month); UTdataset.push(e.total) });
    var data1 = {
        labels: UTlabels ,
        datasets: [{
            label: "UT " ,
            backgroundColor: [
                'rgba(254, 147, 101, 1)',
                'rgba(254, 147, 101, 1)',
                'rgba(254, 147, 101, 1)',
                'rgba(254, 147, 101, 1)',
                'rgba(254, 147, 101, 1)',
                'rgba(254, 147, 101, 1)',
                'rgba(254, 147, 101, 1)'
            ],
            /*hoverBackgroundColor: [
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)'
            ],*/
            data: UTdataset,
        }]
    };

    var bar = document.getElementById("ut_monthbarChart").getContext('2d');
    var myMonthBarChart = new Chart(bar, {
        type: 'bar',
        data: data1,
        options: {
            barValueSpacing: 30,
            legend: {position: 'none'} //TO hide legend
        }
    });

    // UT Case Monthbarchart

    var Ut_cases_labels = Array();
    var Ut_cases_dataset = Array();
    Ut_cases_array.forEach(function(e) {  Ut_cases_labels.push(e.Year+ "," +e.Month); Ut_cases_dataset.push(e.total) });

    var data1 = {
        labels: Ut_cases_labels,
        datasets: [{
            label: "Case",
            backgroundColor: [
                'rgba(10, 198, 133, 1)',
                'rgba(10, 198, 133, 1)',
                'rgba(10, 198, 133, 1)',
                'rgba(10, 198, 133, 1)',
                'rgba(10, 198, 133, 1)',
                'rgba(10, 198, 133, 1)',
                'rgba(10, 198, 133, 1)'
            ],
            /*hoverBackgroundColor: [
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)'
            ],*/
            data: Ut_cases_dataset,
        }]
    };

    var bar = document.getElementById("ut_case_monthbarChart").getContext('2d');
    var myMonthBarChart = new Chart(bar, {
        type: 'bar',
        data: data1,
        options: {
            barValueSpacing: 30,
            legend: {position: 'none'} //TO hide legend
        }
    });

    //Intervention MonthChart
    var intervention_labels = Array();
    var intervention_dataset = Array();
    intervention_array.forEach(function(e) {  intervention_labels.push(e.Year+ "," +e.Month); intervention_dataset.push(e.total) });
    var data1 = {
        labels: intervention_labels,
        datasets: [{
            label: "Intervention",
            backgroundColor: [
                'rgba(1, 172, 175, 1)',
                'rgba(1, 172, 175, 1)',
                'rgba(1, 172, 175, 1)',
                'rgba(1, 172, 175, 1)',
                'rgba(1, 172, 175, 1)',
                'rgba(1, 172, 175, 1)',
                'rgba(1, 172, 175, 1)'
            ],
            /*hoverBackgroundColor: [
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)',
                'rgba(26, 188, 156, 0.88)'
            ],*/
            data: intervention_dataset,
        }]
    };

    var bar = document.getElementById("intervention_monthbarChart").getContext('2d');
    var myMonthBarChart = new Chart(bar, {
        type: 'bar',
        data: data1,
        options: {
            barValueSpacing: 30,
            legend: {position: 'none'} //TO hide legend
        }
    });


    /*District Pie chart*/
    /*var pieElem = document.getElementById("pieChartDistrict");
    var data4 = {
        labels: [
            "District1",
            "District2",
            "District3"
        ],
        datasets: [{
            data: [30, 30, 40],
            backgroundColor: [
                "#25A6F7",
                "#FB9A7D",
                "#01C0C8"
            ],
            hoverBackgroundColor: [
                "#6cc4fb",
                "#ffb59f",
                "#0dedf7"
            ]
        }]
    };
    var myPieChart = new Chart(pieElem, {
        type: 'pie',
        data: data4
    });*/


    /*Doughnut chart*/
    /*var ctx = document.getElementById("myChartCategory");
    var data = {
        labels: [
            "SC", "ST", "OBC", "EBC", "DNT", "VJNT"
        ],
        datasets: [{
            data: [20, 10, 5, 10, 40, 15],
            backgroundColor: [
                "#1ABC9C",
                "#FCC9BA",
                "#B8EDF0",
                "#B4C1D7",
                "#b8bef0",
                "#d5b4d7"
            ],
            borderWidth: [
                "0px",
                "0px",
                "0px",
                "0px",
                "0px",
                "0px"
            ],
            borderColor: [
                "#1ABC9C",
                "#FCC9BA",
                "#B8EDF0",
                "#B4C1D7",
                "#b8bef0",
                "#d5b4d7"

            ]
        }]
    };

    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: data
    });*/


});
