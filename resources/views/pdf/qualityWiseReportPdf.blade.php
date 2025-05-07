<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quality Wise Report</title>
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
        text-align:center ;
    }

    

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
    td{text-align: center;}
</style>

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:70%;top:-50px;font-size:20px;">Generate On- @php
        echo generated_date();
        @endphp
    </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Quality Wise Report</u>
            </h2>
        </div>

    </div>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:#01a9ac" colspan="5">Quality Wise Report </td>
            </tr>
        </thead>
        <tbody id="simpletable">
            <tr>
                <th>S.No</th>
                
                <th>Dart Team</th>
                <th>Total Task Assigned</th>
                <th>Total Task Completed</th>
                <th>Total Task Pending</th>
                
            </tr>
            @php $i = 1; @endphp
            @foreach ($result as $res)

            <tr>
                <td>{{$i}}</td>
                <td>{{$res->quality}}</td>
                <td>{{$res->total != '' ? $res->total : '0'}}</td>
                <td>{{$res->done_task != '' ? $res->done_task : '0'}}</td>
                <td>{{$res->Pending_task != '' ? $res->Pending_task : '0'}}</td>
            </tr>
            @php $i++; @endphp
            @endforeach
        </tbody>

    </table>
    <br>




    <br>



</body>

</html>