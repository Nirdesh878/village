<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quality Check Reporttfvybuijmubytvgybu</title>
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
<h5 style="font-family: Arial, Helvetica,sans-serif;position:relative;left:78%;top:-50px;font-size:20px;">Generated On- @php 
                echo generated_date();

                @endphp
            </h5>
            @php
            
                $session_data = Session::get('quality_filter_session');
                
                $heading = 'Quality Check Report';
                if($user_type == 'M')
                {
                    $heading = 'District Manager Report';
                }
                elseif($user_type == 'QA'){
                    $heading = 'Quality Manager Report';
                }
            @endphp
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>{{$heading}}<u>
            </h2>
        </div>

    </div>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">

                <th style="background-color:#01a9ac;width:50%;" >Group Type</th>
                <th style="background-color:#01a9ac;width:50%;" >Status</th>

            </tr>

    </thead>
        <tbody>
          @php
          $user = Auth::User();
          $group_type = '';
          $status_type = '';
          if (!empty($session_data['group']) && !empty($session_data['type'])) {
          if($session_data['group'] == 'FM')
          {
            $group_type = 'Family';
          }
          if($session_data['group'] == 'FD')
          {
            $group_type = 'Federation';
          }
          if($session_data['group'] == 'CL')
          {
            $group_type = 'Cluster';
          }
          if($session_data['group'] == 'SH')
          {
            $group_type = 'SHG';
          }
          if($session_data['group'] == 'ALL')
          {
            $group_type = 'ALL';
          }

          if($session_data['type'] == 'P')
          {
            $status_type = 'Pending';
          }
          if($session_data['type'] == 'C')
          {
            $status_type = 'Complete';
          }
          if($session_data['type'] == 'ALL')
          {
            $status_type = 'ALL';
          }
        }
          @endphp

            <tr style="text-align: center;">
                <td>{{$group_type}}</td>
                <td>{{$status_type}}</td>
            </tr>


        </tbody>

    </table>
<br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:#01a9ac" colspan="10">Quality Check Report</td>

            </tr>
            <tr>
        <th>S.No</th>
        <th>UIN</th>
        <th>Name</th>
        <th>Type</th>
        <th>Facilitator</th>
        <th>Task</th>
        <th>Manager Status</th>
        <th>Manager Update</th>
        <th>Quality Status</th>
        <th>Quality Update</th>

            </tr>


    </thead>
    @if(!empty($session_data))
        <tbody>
            @php $i=1; @endphp
           @foreach ($families as $row )
           @php
             if($row->qa_status == 'P')
             {
               $qa_status = 'Pending';
             }
             if($row->qa_status == 'V')
             {
               $qa_status = 'Verified';
             }
             if($row->qa_status == 'R')
             {
               $qa_status = 'Rejected';
             }

             if($row->quality_status == 'P')
             {
               $quality_status = 'Pending';
             }
             if($row->quality_status == 'V')
             {
               $quality_status = 'Verified';
             }
             if($row->quality_status == 'R')
             {
               $quality_status = 'Rejected';
             }

             if($row->task == 'A')
             {
               $task = 'Analysis';
             }
             else{
                $task = 'Rating';
             }

             if ($row->assignment_type == 'FD') {

                    $type = 'Federation';
                }
                if ($row->assignment_type == 'SH') {

                    $type = 'SHG';
                }
                if ($row->assignment_type == 'CL') {

                    $type = 'Cluster';
                }
                if ($row->assignment_type == 'FM') {

                    $type = 'Family';
                }
                $part = '';
                if ($row->assignment_type == 'FM'  && $user->u_type != 'QA') {
                    if ($row->task == 'A') {

                        $part = ' - ' . $row->task_a1;
                    }
                }
                else{
                    $part = '';
                }

           @endphp
           <tr style="text-align: center;">
            <td>{{$i}}</td>
            <td>{{$row->uin}}</td>
            <td>{{$row->name}}</td>
            <td>{{$type}}</td>
            <td>{{$row->fac_name}}</td>
            <td>{{$task.$part}}</td>
            <td>{{$qa_status}}</td>
            <td>{{change_date_month_name_char($row->manger_date) }}</td>
            <td>{{$quality_status}}</td>
            <td>{{change_date_month_name_char($row->quality_date) }}</td>


        </tr>
        @php $i++ ; @endphp
           @endforeach



        </tbody>
      @endif
    </table>


</body>

</html>
