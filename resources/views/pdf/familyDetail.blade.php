<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family</title>
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
<h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:70%;top:-50px;font-size:20px;">Generated On- @php
                echo generated_date();
                @endphp
            </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Family<u>
            </h2>
        </div>
    </div>
    <table class="table table-bordered table-stripped table1 " style="margin-left: -40px;" cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:#01a9ac ; " colspan="15">Family</td>
            </tr>
        <tr>
        <th width="2%">S.No</th>
        <th>UIN</th>
        <th>Agency</th>
        <th>Federation</th>
        <th>Cluster</th>
        <th>SHG</th>
        <th>Member Name</th>
        <th>Spouse</th>
        {{-- <th>Country</th> --}}
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
            @foreach ($data as $res )
                @php
                if ($res->dm_p1 == 'V' && $res->qa_p1 == 'V' && $res->dm_p2 == 'V' && $res->qa_p2 == 'V' && $res->locked == 1) {
                    $visit = 'Locked';
                } elseif ($res->dm_p1 == 'V' && $res->dm_p2 == 'V' && $res->qa_p1 == 'V' && $res->qa_p2 == 'V') {
                    $visit = 'Initial Rating';
                } elseif ($res->dm_p1 == 'V' && $res->dm_p2 == 'V') {
                    $visit = 'Analytics Complete';
                } else if (($res->dm_p1 == 'P' && $res->dm_p2 == 'P')) {
                    $visit = 'Both Visit Completed';
                } else if (($res->dm_p1 == 'V' && $res->dm_p2 == 'P' )) {
                    $visit = 'Both Visit Completed';
                } else if ($res->dm_p2 == 'R' && $res->dm_p1 == 'V' && $res->flag == 1) {
                    $visit = 'Second Visit Rejected';
                } else if ($res->dm_p1 == 'P' or $res->dm_p1 == 'V') {
                    $visit = 'Second Visit Pending ';
                } else if ($res->dm_p1 == 'R' && $res->flag == 1) {
                    $visit = 'First Visit Rejected';
                } elseif ($res->dm_p1 == 'N') {
                    $visit = 'First Visit Pending';
                } elseif ($res->recalled == 1) {
                    $visit = 'Recalled';
                } else {
                    $visit = 'Created';
                }
                if($res->locked==1)
                {
                   $locked = 'Yes';
                }
                else if($res->locked==0)
                {
                   $locked = 'No';
                }
                if($visit !='Created'){
                    $result =$res->analysis_rating;
                $grdcolor = $result >= 90 ? 'green' : ($result >= 75 ? 'yellow' : ($result >= 60 ? 'grey' : 'red'));
                }
                else {
                    $grdcolor ='white';
                }
                 
                @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$res->uin}}</td>
                    <td>{{$res->agency_name}}</td>
                    <td>{{$res->name_of_federation}}</td>
                    <td>{{($res->name_of_cluster != '' OR $res->name_of_cluster == 'NULL') ? $res->name_of_cluster : '-'}}</td>
                    <td>{{$res->shgName}}</td>
                    <td>{{$res->fp_member_name}}</td>
                    <td>{{$res->fp_spouse_name}}</td>
                    {{-- <td>{{$res->country_name}}</td> --}}
                    <td>{{$res->state_name}}</td>
                    <td>{{$res->district_name}}</td>
                    <td>{{$res->fp_village}}</td>
                    <td>{{$visit}}</td>
                    <td>
                        <div class="round" style="background:{{ $grdcolor }};margin-left:5px; "></div>
                    </td>
                    <td>{{$res->name !='' ? $res->name : 'N/A'   }}</td>
                    <td>{{ $locked }}</td>
                </tr>
                @php
                    $i++ ;
                @endphp
            @endforeach

        </tbody>

    </table>


</body>

</html>
