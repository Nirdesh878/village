<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cummulative Report</title>
</head>

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:70%;top:-50px;font-size:20px;">Generated On- @php
        echo generated_date();
        @endphp
    </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Cummulative Report</u>
                
                
            </h2>
        </div>

    </div>
    <style>
        .table1{
            width:100%;
        }
    .table { border: 1px solid #e9ecef; }
    .table td, .table th {
    padding: .50rem;

    }
    .table td { font-family: Arial, Helvetica, sans-serif; font-size:14px; text-align:center;};
        .table-primary, .table-primary>td, .table-primary>th {
            background-color: #01a9ac;
            color:#ffffff;
            text-align:center;
            font-size:16px;
        }
        .table-bordered td, .table-bordered th {
    border: 1px solid #e9ecef;

}
.green {
    background-color: green !important;
}
.font-weight-bold {
    font-weight: 700;
}
.yellow {
    background-color: #ffeb3b !important;
}
.grey {
    background-color: grey!important;
}
.red_status {
    background-color: red !important;
}
    </style>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <th style="background-color:#01a9ac">Country</th>
                <th style="background-color:#01a9ac">State</th>
                <th style="background-color:#01a9ac">District</th>
                <th style="background-color:#01a9ac">Agency</th>
                <th colspan="2" style="background-color:#01a9ac">Date</th>
                {{-- <th style="background-color:#01a9ac">Batch</th> --}}
            </tr>
        </thead>
        <tbody>
                <tr>@if(!empty($session_data['country']))
                    @php 
                        $dt_from = change_date_month_name_char(str_replace('/','-',$session_data['dt_from']));
                        $dt_to = change_date_month_name_char(str_replace('/','-',$session_data['dt_to']));
                    @endphp
                    <td>{{getCountryByID($session_data['country'])}}</td>
                    <td>{{getStateName($session_data['country'],$session_data['state'])}}</td>
                    <td>{{getDistrictName($session_data['state'],$session_data['district'])}}</td>
                    <td>{{$session_data['agency']}}</td>
                    <td>{{$dt_from}}</td>
                    <td>{{$dt_to}}</td>
                    @else
                    <td>{{getCountryByID(101)}}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    @endif
                </tr>
        </tbody>
    </table>
    <br>
    <div class="page-header-title">
        <div class="d-inline">
            <h3 style="text-align:left;">
                Federation
                <span style="float:right;">
                    Total:<?php echo $Federation_a[0]->Federation_Initiated_Analytics;?>
                </span>
            </h3>
        </div>
    </div>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <th></th>
                <th>Initiate</th>
                <th>Completed</th>
                <th>Pending</th>
                <th>Minimal Risk</th>
                <th>Low Risk</th>
                <th>Moderate Risk</th>
                <th>High Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-weight-bold">Analytics</td>
                <td><?php echo $Federation_a[0]->Federation_Initiated_Analytics;?></td>
                <td><?php echo $Federation_a[0]->Federation_Full_Analytics;?></td>
                <td><?php echo $Federation_a[0]->Federation_Initiated_Analytics - ($Federation_a[0]->Federation_Full_Analytics); ?></td>
                <td class="green"><?php echo $Federation_a[0]->green_analysis;?></td>
                <td class="yellow"><?php echo $Federation_a[0]->yellow_analysis; ?></td>
                <td class="grey"><?php echo $Federation_a[0]->grey_analysis; ?></td>
                <td class="red_status"><?php echo $Federation_a[0]->red_analysis; ?></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Ratings</td>
                 <td><?php echo $Federation_r[0]->Federation_Initiated_Rating;?></td>
                <td><?php echo $Federation_r[0]->Federation_Full_Rating;?></td>
                <td><?php echo $Federation_r[0]->Federation_Initiated_Rating - ($Federation_r[0]->Federation_Full_Rating); ?></td>

                <td class="green"><?php echo $Federation_r[0]->green_rate;?></td>
                <td class="yellow"><?php echo $Federation_r[0]->yellow_rate; ?></td>
                <td class="grey"><?php echo $Federation_r[0]->grey_rate; ?></td>
                <td class="red_status"><?php echo $Federation_r[0]->red_rate; ?></td>
            </tr>
        </tbody>
    </table>

    <div class="page-header-title">
        <div class="d-inline">
            <h3 style="text-align:left;">
                Cluster
                <span style="float:right;">
                    Total:<?php echo $Cluster_a[0]->Cluster_Initiated_Analytics;?>
                </span>
            </h3>
        </div>
    </div>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <th></th>
                <th>Initiate</th>
                <th>Completed</th>
                <th>Pending</th>
                <th>Minimal Risk</th>
                <th>Low Risk</th>
                <th>Moderate Risk</th>
                <th>High Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-weight-bold">Analytics</td>
                <td><?php echo $Cluster_a[0]->Cluster_Initiated_Analytics;?></td>
                <td><?php echo $Cluster_a[0]->Cluster_Full_Analytics;?></td>
                <td><?php echo $Cluster_a[0]->Cluster_Initiated_Analytics - ($Cluster_a[0]->Cluster_Full_Analytics); ?></td>
                <td class="green"><?php echo $Cluster_a[0]->green_analysis;?></td>
                <td class="yellow"><?php echo $Cluster_a[0]->yellow_analysis; ?></td>
                <td class="grey"><?php echo $Cluster_a[0]->grey_analysis; ?></td>
                <td class="red_status"><?php echo $Cluster_a[0]->red_analysis; ?></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Ratings</td>
                <td><?php echo $Cluster_r[0]->Cluster_Initiated_Rating;?></td>
                <td><?php echo $Cluster_r[0]->Cluster_Full_Rating;?></td>
                <td><?php echo $Cluster_r[0]->Cluster_Initiated_Rating - ($Cluster_r[0]->Cluster_Full_Rating); ?></td>
                <td class="green"><?php echo $Cluster_r[0]->green_rate;?></td>
                <td class="yellow"><?php echo $Cluster_r[0]->yellow_rate; ?></td>
                <td class="grey"><?php echo $Cluster_r[0]->grey_rate; ?></td>
                <td class="red_status"><?php echo $Cluster_r[0]->red_rate; ?></td>
            </tr>
        </tbody>
    </table>

    <div class="page-header-title">
        <div class="d-inline">
            <h3 style="text-align:left;">
                SHG
                <span style="float:right;">
                    Total:<?php echo $Shg_a[0]->Shg_Initiated_Analytics;?>
                </span>
            </h3>
        </div>
    </div>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <th></th>
                <th>Initiate</th>
                <th>Completed</th>
                <th>Pending</th>
                <th>Minimal Risk</th>
                <th>Low Risk</th>
                <th>Moderate Risk</th>
                <th>High Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-weight-bold">Analytics</td>
                <td><?php echo $Shg_a[0]->Shg_Initiated_Analytics;?></td>
                <td><?php echo $Shg_a[0]->Shg_Full_Analytics;?></td>
                <td><?php echo $Shg_a[0]->Shg_Initiated_Analytics - ($Shg_a[0]->Shg_Full_Analytics); ?></td>
                <td class="green"><?php echo $Shg_a[0]->green_analysis;?></td>
                <td class="yellow"><?php echo $Shg_a[0]->yellow_analysis; ?></td>
                <td class="grey"><?php echo $Shg_a[0]->grey_analysis; ?></td>
                <td class="red_status"><?php echo $Shg_a[0]->red_analysis; ?></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Ratings</td>
                <td><?php echo $Shg_r[0]->Shg_Initiated_Rating;?></td>
                <td><?php echo $Shg_r[0]->Shg_Full_Rating;?></td>
                 <td><?php echo $Shg_r[0]->Shg_Initiated_Rating - ($Shg_r[0]->Shg_Full_Rating); ?></td>
                <td class="green"><?php echo $Shg_r[0]->green_rate;?></td>
                <td class="yellow"><?php echo $Shg_r[0]->yellow_rate; ?></td>
                <td class="grey"><?php echo $Shg_r[0]->grey_rate; ?></td>
                <td class="red_status"><?php echo $Shg_r[0]->red_rate; ?></td>
            </tr>
        </tbody>
    </table>
    <div class="page-header-title">
        <div class="d-inline">
            <h3 style="text-align:left;">
                Family
                <span style="float:right; margin-right:60px;">
                Total:<?php echo $Family_a[0]->Initiated_Analytics;?>
                </span>
            </h3>
        </div>
    </div>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <th></th>
                <th>Initiate</th>
                <th>Completed</th>
                <th>Pending</th>
                <th>Minimal Risk</th>
                <th>Low Risk</th>
                <th>Moderate Risk</th>
                <th>High Risk</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-weight-bold">Analytics</td>
                <td><?php echo $Family_a[0]->Initiated_Analytics;?></td>
                <td><?php echo $Family_a[0]->Fully_Completed;?></td>
                 <td><?php echo $Family_a[0]->Initiated_Analytics - ($Family_a[0]->Fully_Completed); ?></td>
                <td class="green"><?php echo $Family_a[0]->green_analysis;?></td>
                <td class="yellow"><?php echo $Family_a[0]->yellow_analysis; ?></td>
                <td class="grey"><?php echo $Family_a[0]->grey_analysis; ?></td>
                <td class="red_status"><?php echo $Family_a[0]->red_analysis; ?></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Ratings</td>
                <td><?php echo $Family_r[0]->Initiated_Rating;?></td>
                <td><?php echo $Family_r[0]->Completed_Rating;?></td>
                 <td><?php echo $Family_r[0]->Initiated_Rating - ($Family_r[0]->Completed_Rating); ?></td>

              <td class="green"><?php echo $Family_r[0]->green_rate;?></td>
                <td class="yellow"><?php echo $Family_r[0]->yellow_rate; ?></td>
                <td class="grey"><?php echo $Family_r[0]->grey_rate; ?></td>
                <td class="red_status"><?php echo $Family_r[0]->red_rate; ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
