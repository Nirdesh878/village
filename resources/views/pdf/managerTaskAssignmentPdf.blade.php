<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manager Wise Report</title>
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
</style>

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:70%;top:-50px;font-size:20px;">Generated On- @php
        echo generated_date();
        @endphp
    </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Manager Wise Report - {{$name[0]->name}}</u>
            </h2>
        </div>

    </div>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:#01a9ac" colspan="8">Manager Wise Report </td>
            </tr>
        </thead>
        <tbody id="simpletable">
            <tr>
                <th>S.No</th>
                <th>Assignment Type</th>
                <th>UIN</th>
                <th>Task</th>
                <th>Task Status </th>
                <th>DM Status</th>
                <th>Date Task assigned </th>
                <th>Date Task completed</th>
            </tr>
            @php $i = 1; $task_type='_'; $task_a1='_'; $qa_status='_'; @endphp
            @foreach ($result as $row)
            @php
            if($row->task == 'A'){
            $task_type = 'Analysis';
            }
            else
            {
            $task_type = 'Rating';
            }

            if ($row->type == 'FAMILY'){
            if ($row->task == 'A'){
            $task_a1 = $row->task_a1;
            }
            }

            if ($row->qa_status == 'P'){
            $qa_status = 'Pending';
            }
            if ($row->qa_status == 'V'){
            $qa_status = 'Verified';
            }
            if ($row->qa_status == 'R'){
            $qa_status = 'Rejected';
            }
            $manager_date = change_date_month_name_char($row->manger_date);
            @endphp

                    <tr style="text-align:center;">
                        <td>{{$i}}</td>
                        <td>{{$row->type}}</td>
                        <td>{{$row->uin}}</td>
                        <td>{{$task_type}}</td>
                        <td>{{$task_a1}}</td>
                        <td>{{$qa_status}}</td>
                        <td>{{change_date_month_name_char($row->created_at)}}</td>
                        <td>{{$manager_date}}</td>
                    </tr>
                    @php $i++; @endphp
            @endforeach
        </tbody>

    </table>






</body>

</html>