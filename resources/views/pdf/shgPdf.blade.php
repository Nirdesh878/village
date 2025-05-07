<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SHG</title>
</head>
<style>
    .round {
        border-radius: 85%;
        width: 35px;
        height: 35px;
    }

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

    .table td th {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        text-align: ;
    }

    ;

    .table-primary,
    .table-primary>td,
    .table-primary> {
        background-color: #01a9ac;
        color: #ffffff;

        font-size: 16px;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #e9ecef;
    }

    .checkmark {
        display: inline-block;
        transform: rotate(45deg);
        height: 25px;
        width: 12px;
        margin-left: 60%;
        border-bottom: 7px solid black;
        border-right: 7px solid black;
        margin-left: ;
    }

</style>

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:70%;top:-50px;font-size:20px;">Generated
        On- @php
            echo generated_date();
        @endphp
    </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>SHG<u>
            </h2>
        </div>
    </div>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:#01a9ac" colspan="15">SHG</td>
            </tr>
            <tr>
                <th>S.No</th>
                <th>UIN</th>
                <th>Agency</th>
                <th>Federation</th>
                <th>Cluster</th>
                <th>SHG</th>
                <th>Formed</th>
                <th>Country</th>
                <th>State</th>
                <th>District</th>
                <th>Village</th>
                <th>Status</th>
                <th>Current Result</th>
                <th>Name of Facilitator</th>
                <th>Locked</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($data as $res)
                @php
                    $visit = 'Created';
                    if ($res->dm_a == 'V' && $res->qa_a == 'V' && $res->locked == 1) {
                        $visit = 'Locked';
                    } elseif ($res->dm_a == 'V' && $res->qa_a == 'V') {
                        $visit = 'Initial Rating';
                    } elseif ($res->dm_a == 'V' && $res->qa_a == 'P') {
                        $visit = 'Analytics Complete';
                    } elseif ($res->dm_a == 'P') {
                        $visit = 'Visit Complete';
                    } elseif ($res->dm_a == 'N' && $res->flag == 0) {
                        $visit = 'Visit Pending';
                    } elseif ($res->dm_a == 'R' && $res->flag == 1) {
                        $visit = 'Visit Reassigned';
                    }
                    if ($res->locked == 1) {
                        $locked = 'Yes';
                    } elseif ($res->locked == 0) {
                        $locked = 'No';
                    }
                    
                    if ($visit != 'Created') {
                        $result = $res->analysis_rating;
                        $grdcolor = $result >= 90 ? 'green' : ($result >= 75 ? 'yellow' : ($result >= 60 ? 'grey' : 'red'));
                    } else {
                        $grdcolor = 'white';
                    }
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $res->uin }}</td>
                    <td>{{ $res->agency_name }}</td>
                    <td>{{ $res->name_of_federation }}</td>
                    <td>{{ ($res->name_of_cluster != '' or $res->name_of_cluster == 'NULL') ? $res->name_of_cluster : '-' }}
                    </td>
                    <td>{{ $res->shgName }}</td>
                    <td>{{ change_date_month_name_char(str_replace('/', '-', $res->formed)) }}</td>
                    <td>{{ $res->country_name }}</td>
                    <td>{{ $res->state_name }}</td>
                    <td>{{ $res->district_name }}</td>
                    <td>{{ $res->village }}</td>
                    <td>{{ $visit }}</td>
                    <td>
                        <div class="round" style="background:{{ $grdcolor }};margin-left:5px; "></div>
                    </td>
                    <td>{{ $res->name !='' ? $res->name :'N/A' }}</td>
                    <td>{{ $locked }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach

        </tbody>

    </table>


</body>

</html>
