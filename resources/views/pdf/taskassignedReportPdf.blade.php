<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Assigned Report </title>
</head>

<body class="antialiased container mt-5">
<h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:80%;top:-50px;font-size:20px;">Generated On- @php
                echo generated_date();
                @endphp
            </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Task Assigned Report -{{$name[0]->name}}</u>
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
                <td style="background-color:#01a9ac">S.No</td>
                <td style="background-color:#01a9ac">UIN</td>
                <td style="background-color:#01a9ac">Name</td>
                <td style="background-color:#01a9ac">Assignment Type</td>
                <td style="background-color:#01a9ac">Task</td>
                <td style="background-color:#01a9ac">Task Status</td>
                <td style="background-color:#01a9ac">Task Assign Date</td>
                <td style="background-color:#01a9ac">Task Submitted Date</td>
                <td style="background-color:#01a9ac">Manager Status</td>
                <td style="background-color:#01a9ac">Manager Verified</td>
                <td style="background-color:#01a9ac">QA Status</td>
                <td style="background-color:#01a9ac">Quality Verified</td>
            </tr>
        </thead>
        <tbody>

                @php  $i = 1;  $part=''; @endphp

                    @foreach ($result as $row)
                        @php
                        $part = '';
                        if ($row->type == 'FAMILY') {
                            if ($row->task == 'A') {
                                $part = ' - ' . $row->task_a1;
                            }
                        }
                        if ($row->task == 'A') {
                            $task = 'Analytics';
                        } else {
                            $task = 'Rating';
                        }
                        if ($row->status == 'D') {
                            if ($row->qa_status == 'P') {
                                $dm_status = 'Pending';
                            }
                            if ($row->qa_status == 'V') {
                                $dm_status = 'Verified';
                            }
                            if ($row->qa_status == 'R') {
                                $dm_status = 'Rejected';
                            }
                            if ($row->qa_status == '') {
                                $dm_status = '-';
                            }
                        } else {
                            $dm_status = '-';
                        }
                        if ($row->quality_status == 'P') {
                            $quality_status = 'Pending';
                        }
                        if ($row->quality_status == 'V') {
                            $quality_status = 'Verified';
                        }
                        if ($row->quality_status == 'R') {
                            $quality_status = 'Rejected';
                        }
                        if ($row->quality_status == '') {
                            $quality_status = '-';
                        }
                        if ($row->status == 'D') {
                            $submit_status = change_date_month_name_char($row->updated_at);
                        } else {
                            $submit_status = '-';
                        }
                        $task_status = '';
                        if($row->status == 'D'){
                            $task_status = 'Done';
                        }
                        elseif($row->status == 'R'){
                            $task_status = 'Recalled';
                            $submit_status = change_date_month_name_char($row->updated_at);
                        }
                        else{
                            $task_status = 'Pending';
                        }


                        $manager_date = change_date_month_name_char($row->manger_date);
                        $quality_date = change_date_month_name_char($row->quality_date);
                    @endphp
                        <tr>
                        <td> {{ $i  }}  </td>
                        <td> {{ $row->uin }}   </td>
                        <td> {{ $row->task_name }}   </td>
                        <td> {{ $row->type }}   </td>
                        <td> {{ $task . $part }}   </td>
                        <td> {{ $task_status  }}    </td>

                        <td> {{ change_date_month_name_char($row->created_at)  }}  </td>

                        <td> {{ $submit_status }}   </td>

                        <td> {{ $dm_status }}   </td>
                        <td> {{ $manager_date }}   </td>

                        <td> {{ $quality_status }}   </td>
                        <td> {{$quality_date  }} </td>
                        </tr>

                    @php $i++; @endphp
                    @endforeach

        </tbody>
    </table>
    <br>

</body>

</html>
