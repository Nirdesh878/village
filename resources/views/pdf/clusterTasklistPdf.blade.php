<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cluster Pre-Assignment</title>
</head>
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
    .tdc{text-align:center;}
    th{text-align: start;}
</style>

<body class="antialiased container mt-5">
<h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:70%;top:-50px;font-size:20px;">Generated On- @php
                echo generated_date();
                @endphp
            </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;margin-top:-10px;"><u>Cluster Pre-Assignment<u>
            </h2>
        </div>
    </div>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:#01a9ac" colspan="9">Cluster </td>
            </tr>
        <tr>
        <th class="tdc">S.No</th>
        <th>Cluster-UIN</th>
        <th>Name</th>
        <th>Federation</th>
        <th>Facilitator</th>
        <th>Task</th>
        <th>Status</th>
        <th>Create</th>
        <th>Update</th>
        
        </tr>
    </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($cluster as $res )
                @php
                    if($res->task == 'A')
                    {
                        $task = 'Analystics';
                    }
                    else
                    {
                        $task= 'Rating';
                    }
                    if($res->status == 'D')
                    {
                        $status = 'Done';
                    }
                    if($res->status == 'P')
                    {
                        $status = 'Pending';
                    }
                    if($res->status == 'R')
                    {
                        $status = 'Reject';
                    }
                @endphp
                <tr>
                    <td class="tdc">{{$i}}</td>
                    <td>{{$res->uin}}</td>
                    <td>{{$res->name_of_cluster}}</td>
                    <td>{{$res->name_of_federation}}</td>
                    <td>{{$res->name}}</td>
                    <td>{{$task}}</td>
                    <td>{{$status}}</td>
                    <td>{{change_date_month_name_char(str_replace('/','-',$res->created_at))}}</td>
                    <td>{{change_date_month_name_char(str_replace('/','-',$res->updated_at))}}</td>
                    
                </tr>
                @php
                    $i++ ;
                @endphp
            @endforeach

        </tbody>

    </table>


</body>

</html>
