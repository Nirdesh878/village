<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facilitator Wise Report</title>
</head>

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generated On- @php
        echo generated_date();
        @endphp
    </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Facilitator Wise Report</u>


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
    </style>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac">Country</td>
                <td style="background-color:#01a9ac">State</td>
                <td style="background-color:#01a9ac">District</td>
                <td style="background-color:#01a9ac">Facilitator</td>
                <td colspan="2" style="background-color:#01a9ac">Date</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    @if(!empty($session_data['country']))
                     @php
                        $dt_from = change_date_month_name_char(str_replace('/','-',$session_data['dt_from']));
                        $dt_to = change_date_month_name_char(str_replace('/','-',$session_data['dt_to']));
                    @endphp
                    <td>{{getCountryByID($session_data['country'])}}</td>
                    <td>{{getStateName($session_data['country'],$session_data['state'])}}</td>
                    <td>{{getDistrictName($session_data['state'],$session_data['district'])}}</td>
                    <td>{{$session_data['facilitator']}}</td>
                    <td>{{$dt_from}}</td>
                    <td>{{$dt_to}}</td>
                    @else
                    <td>{{getCountryByID(101)}}</td>
                    <td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
                    @endif

                </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead >
            <tr class="table-primary" >
                <td>S.No</td>
                <td>Country</td>
                <td>State</td>
                {{-- <td>District</td> --}}
                <td>Facilitator Name</td>
                <td>Total Task Assigned</td>
                <td>Total Task Completed</td>
                <td>Total Task Pending</td>

            </tr>
        </thead>

        <tbody>
            @php
                $i=1;
            @endphp
            @foreach ($res['dataset'] as $data)
                @php
                    $total_task = 0;
                    $done = 0;
                    if($data->total != '')
                    {
                        $total_task =  $data->total;
                    }
                    if($data->done != '')
                    {
                        $done =  $data->done;
                    }
                @endphp
                <tr>
                    <td>{{ $i}}</td>
                    <td>{{ $data->country_name }}</td>
                    <td>{{ $data->state_name }}</td>
                    {{-- <td>{{ $data->district_name }}</td> --}}
                    <td>{{ $data->fac_name }}</td>
                    <td>@php echo $total_task @endphp</td>
                    <td>@php echo $done @endphp</td>
                    <td>@php echo $total_task - $done @endphp</td>
                </tr>
                @php
                $i++;
            @endphp
            @endforeach
        </tbody>
    </table>
</body>

</html>
