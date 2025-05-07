<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Wealth Ranking Report</title>
</head>

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:78%;top:-50px;font-size:20px;">Generated
        On- @php
            echo generated_date();
        @endphp
    </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Family Wealth
                    Ranking Report</u>
                @php
                    $type = '';
                    if (!empty($session_data['group'])) {
                        if ($session_data['group'] == 'FD') {
                            $type = 'Federation';
                            echo '(Federation';
                        }
                        if ($session_data['group'] == 'CL') {
                            $type = 'Cluster';
                            echo '(Cluster';
                        }
                        if ($session_data['group'] == 'SH') {
                            $type = 'SHG';
                            echo '(SHG';
                        }
                        if ($session_data['group'] == 'FM') {
                            $type = 'Family';
                            echo '(Family';
                        }
                        if ($session_data['group'] == 'AG') {
                            $type = 'Agency';
                            echo '(Agency';
                        }
                    }
                    if (!empty($session_data['federation'])) {
                        echo ' - ' . $session_data['federation'] . ')';
                    } else {
                        echo ' )';
                    }
                @endphp

            </h2>
        </div>

    </div>
    <style>
        .table1 {
            width: 100%;
        }

        .table {
            border: 1px solid #e9ecef;
        }

        .table td,
        .table th {
            padding: .50rem;

        }

        .table td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            text-align: center;
        }

        ;

        .table-primary,
        .table-primary>td,
        .table-primary>th {
            background-color: #01a9ac;
            color: #ffffff;
            text-align: center;
            font-size: 16px;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #e9ecef;
        }

        .status_analysis {

            width: 20px;
            height: 20px;
            border-radius: 10px;
        }

        .red_status {
            background-color: red !important;
        }

        .green {
            background-color: green !important;
        }

        .grey {
            background-color: grey !important;
        }

        .yellow {
            background-color: #ffeb3b !important;
        }

    </style>

    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac">Country</td>
                <td style="background-color:#01a9ac">State</td>
                <td style="background-color:#01a9ac">District</td>
                <td style="background-color:#01a9ac">Group</td>
                <td style="background-color:#01a9ac">Name</td>
                <td style="background-color:#01a9ac;text-align:center;" colspan="2">Date</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                @if (!empty($session_data['country']))
                    <td>{{ getCountryByID($session_data['country']) }}</td>
                    <td>{{ getStateName($session_data['country'], $session_data['state']) }}</td>
                    <td>{{ getDistrictName($session_data['state'], $session_data['district']) }}</td>
                    <td>{{ $type }}</td>
                    <td>{{ $session_data['federation'] }}</td>
                    <td>{{ change_date_month_name_char(str_replace('/','-',$session_data['dt_from'])) }}</td>
                    <td>{{ change_date_month_name_char(str_replace('/','-',$session_data['dt_to'])) }}</td>
                @else
                    <td>{{ getCountryByID(101) }}</td>
                    <td>-</td>
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



    <table class="table table-bordered table-stripped" cellspacing="0" width="100%">
        <thead>
            <tr class="table-primary">
                <td>SN</td>
                <td style="background-color:#01a9ac">UIN</td>
                @if (!empty($session_data))
                    @if ($session_data['group'] == 'FM' && !empty($session_data['federation']))
                        <td>Husband Name</td>
                        <td>Adhar Card No</td>
                        <td>SHG Name</td>
                        <td>Cluster Name</td>
                        <td>Federation Name</td>
                        <td>Agency Name</td>
                    @elseif ($session_data['group'] == "AG" && !empty($session_data['federation']))
                        <td>SHG Member Name</td>
                        <td>Husband Name</td>
                        <td>Adhar Card No</td>
                        <td>SHG Name</td>
                        <td>Cluster Name</td>
                        <td>Federation Name</td>
                    @elseif ($session_data['group'] == "FD" && !empty($session_data['federation']))
                        <td>SHG Member Name</td>
                        <td>Husband Name</td>
                        <td>Adhar Card No</td>
                        <td>SHG Name</td>
                        <td>Cluster Name</td>
                        <td>Agency Name</td>
                    @elseif ($session_data['group'] == "CL" && !empty($session_data['federation']))
                        <td>SHG Member Name</td>
                        <td>Husband Name</td>
                        <td>Adhar Card No</td>
                        <td>SHG Name</td>
                        <td>Federation Name</td>
                        <td>Agency Name</td>
                    @elseif ($session_data['group'] == "SH" && !empty($session_data['federation']))
                        <td>SHG Member Name</td>
                        <td>Husband Name</td>
                        <td>Adhar Card No</td>
                        <td>Cluster Name</td>
                        <td>Federation Name</td>
                        <td>Agency Name</td>
                    @else
                        <td>SHG Member Name</td>
                        <td>Husband Name</td>
                        <td>Adhar Card No</td>
                        <td>SHG Name</td>
                        <td>Cluster Name</td>
                        <td>Federation Name</td>
                        <td>Agency Name</td>
                    @endif
                @else
                    <td>SHG Member Name</td>
                    <td>Husband Name</td>
                    <td>Adhar Card No</td>
                    <td>SHG Name</td>
                    <td>Cluster Name</td>
                    <td>Federation Name</td>
                    <td>Agency Name</td>
                @endif
                @if (!empty($session_data))
                    @if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                        <td>District</td>
                        <td>State</td>
                    @elseif (!empty($session_data['country']) &&
                        !empty($session_data['state']) &&
                        empty($session_data['district']))
                        <td>District</td>
                    @endif

                @else
                    <td>District</td>
                    <td>State</td>
                    <td>Country</td>
                @endif

                <td>Wealth Rank</td>
                <td>Score</td>
                <td>Color</td>
            </tr>
        </thead>
        <tbody>
            @php
                $count = 0;
            @endphp
            @foreach ($res['families'] as $data)
                @php

                    if ($data->analysis_rating != '') {
                        $x1 = ((float) $data->analysis_rating * 100) / 100;
                        $x2 = $x1 >= 90 ? 'green' : ($x1 >= 75 ? 'yellow' : ($x1 >= 60 ? 'grey' : 'red_status'));
                    } else {
                        $x1 = '-';
                        $x2 = '-';
                    }
                @endphp
                <tr>
                    <td>{{ ++$count }}</td>
                    <td>{{ $data->uin }}</td>

                    @if (!empty($session_data))
                    @if ($session_data['group'] == 'FM' && !empty($session_data['federation']))

                        <td>{{ $data->fp_spouse_name }}</td>
                        <td>{{ aadhar($data->fp_aadhar_no) }}</td>
                        <td>{{ $data->shgName }}</td>
                        <td>{{ $data->name_of_cluster != '' ? $data->name_of_cluster : '---' }}</td>
                        <td>{{ $data->name_of_federation }}</td>
                        <td>{{ $data->agency_name }}</td>
                    @elseif ($session_data['group'] == "AG" && !empty($session_data['federation']))
                        <td>{{ $data->fp_member_name }}</td>
                        <td>{{ $data->fp_spouse_name }}</td>
                        <td>{{ aadhar($data->fp_aadhar_no) }}</td>
                        <td>{{ $data->shgName }}</td>
                        <td>{{ $data->name_of_cluster != '' ? $data->name_of_cluster : '---' }}</td>
                        <td>{{ $data->name_of_federation }}</td>

                    @elseif ($session_data['group'] == "FD" && !empty($session_data['federation']))
                        <td>{{ $data->fp_member_name }}</td>
                        <td>{{ $data->fp_spouse_name }}</td>
                        <td>{{ aadhar($data->fp_aadhar_no) }}</td>
                        <td>{{ $data->shgName }}</td>
                        <td>{{ $data->name_of_cluster != '' ? $data->name_of_cluster : '---' }}</td>
                        <td>{{ $data->agency_name }}</td>
                    @elseif ($session_data['group'] == "CL" && !empty($session_data['federation']))
                        <td>{{ $data->fp_member_name }}</td>
                        <td>{{ $data->fp_spouse_name }}</td>
                        <td>{{ aadhar($data->fp_aadhar_no) }}</td>
                        <td>{{ $data->shgName }}</td>
                        <td>{{ $data->name_of_federation }}</td>
                        <td>{{ $data->agency_name }}</td>
                    @elseif ($session_data['group'] == "SH" && !empty($session_data['federation']))
                        <td>{{ $data->fp_member_name }}</td>
                        <td>{{ $data->fp_spouse_name }}</td>
                        <td>{{ aadhar($data->fp_aadhar_no) }}</td>
                        <td>{{ $data->name_of_cluster != '' ? $data->name_of_cluster : '---' }}</td>
                        <td>{{ $data->name_of_federation }}</td>
                        <td>{{ $data->agency_name }}</td>
                    @else
                        <td>{{ $data->fp_member_name }}</td>
                        <td>{{ $data->fp_spouse_name }}</td>
                        <td>{{ aadhar($data->fp_aadhar_no) }}</td>
                        <td>{{ $data->shgName }}</td>
                        <td>{{ $data->name_of_cluster != '' ? $data->name_of_cluster : '---' }}</td>
                        <td>{{ $data->name_of_federation }}</td>
                        <td>{{ $data->agency_name }}</td>
                    @endif
                    @else
                        <td>{{ $data->fp_member_name }}</td>
                        <td>{{ $data->fp_spouse_name }}</td>
                        <td>{{ aadhar($data->fp_aadhar_no) }}</td>
                        <td>{{ $data->shgName }}</td>
                        <td>{{ $data->name_of_cluster != '' ? $data->name_of_cluster : '---' }}</td>
                        <td>{{ $data->name_of_federation }}</td>
                        <td>{{ $data->agency_name }}</td>
                    @endif
                    @if (!empty($session_data))
                        @if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                            <td>{{ $data->fp_district }}</td>
                            <td>{{ $data->fp_state }}</td>
                        @elseif (!empty($session_data['country']) && !empty($session_data['state']) && empty($session_data['district']))
                            <td>{{ $data->fp_district }}</td>
                        @endif
                    @else
                        <td>{{ $data->fp_district }}</td>
                        <td>{{ $data->fp_state }}</td>
                        <td>{{ $data->fp_country }}</td>
                    @endif
                    <td>{{ $data->fp_wealth_rank }}</td>
                    <td>{{ $data->analysis_rating }}</td>
                    <td>
                        <div class='status_analysis {{ $x2 }}' style="margin:auto"></div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
