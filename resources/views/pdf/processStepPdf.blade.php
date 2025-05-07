<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Process Step Report</title>

</head>

<body class="antialiased container mt-5">
    
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:70%;top:-50px;font-size:20px;">Generated On- @php
        echo generated_date();
        @endphp
    </h5>
                @php
                $type = "";
                
                if(!empty($group))
                {
                    if($group == 'FD')
                    {
                        
                        $type = "Federation";
                    }
                    if($group == 'CL')
                    {
                        
                        $type = "Cluster";
                    }
                    if($group == 'SH')
                    {
                        
                        $type = "SHG";
                    }
                    if($group == 'FM')
                    {
                        
                        $type = "Family";
                    }
                    if($group == 'AG')
                    {
                        
                        $type = "Agency";
                    }
                    
                }

                @endphp
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Process Step Report @if(!empty($agency_name[0]->agency_name))({{$agency_name[0]->agency_name}})@endif</u>
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

        .table td th {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            text-align: center;
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
    </style>
    <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%" @if($group == 'FM')style="margin-left: -20px;"@else
    style="margin-left:20px;"@endif >
        <thead>
            <tr style="text-align: center;background-color:#01a9ac;">
                <th colspan="8" style="text-align: center;text-transform: capitalize;font-size:20px;border-style:none;">{{$task}}@if($group == 'AG'){{'-'.$agency_name[0]->agency_name}}@endif</th>
                
                <th style="border-style:none;"></th>
                @if($group == 'FM')
                <th colspan="5" style="border-style:none;"></th>
                @endif
                
            </tr>
            @if($group !='FM')
            <tr  >
                <th width="10%"></th>
                <th width="10%">No of Analytics/Ratings Initiated
                </th>
                <th width="10%">No of Analytics/Ratings Submitted 
                </th>
                <th width="10%">No of Analytics/Ratings Pending
                </th>
                <th width="10%">No of Analytics/Rating Rejected by Field Operations Manager
                </th>
                <th width="10%">No of Analytics/Rating Verified by Field Operations Manager
                </th>
                <th width="10%">No of Analytics/Ratings Rejected by Quality Analyst</th>
                <th width="10%">No of Analytics/Ratings Verified by Quality Analyst
                </th>
                <th width="15%">No of Task Locked</th>
               
                

            </tr>
            @else
            <tr>
                <th width="10%"></th>
                <th width="10%">Analytics/Ratings Initiated

                </th>
                <th width="10%" colspan="2">No of Analytics/Ratings Submitted 
                </th>
                <th width="10%" colspan="2">No of Analytics/Ratings Pending
                </th>
                
                <th width="10%">No of Analytics/Rating Rejected by Field Operations Manager
                </th>
                <th width="10%">No of Analytics/Rating Verified by Field Operations Manager
                </th>
                <th width="10%">No of Analytics/Ratings Rejected by Quality Analyst
                </th>
                <th width="10%">No of Analytics/Ratings Cleared/Verified by Quality Analyst
                </th>
                <th width="10%">No of Task Locked
                </th>
               
                <th width="10%">No of Families Qualified</th>
                <th width="10%">No of Families Received Loan Approval</th>
                <th width="10%">No of family recievd loan amount</th>
                

            </tr>
            <tr>
                <th width="10%"></th>
                <th width="10%">

                </th>
                <th width="10%">1st Visits 

                </th>
                <th width="10%">2nd visits 

                </th>
                <th width="10%">1st Visits 

                </th>
                <th width="10%">
                    2nd visits 
                </th>
                <th width="10%">
                </th>
                <th width="10%">
                </th>
                <th width="10%">
                </th>
                <th width="10%">
                </th>
                <th width="10%">
                </th>
               
                <th width="10%"></th>
                <th width="10%"></th>
                <th width="10%"></th>
                
            </tr>
            @endif
        </thead>
        <tbody>
            @php
            $r='R';
            $a='A';
                @endphp

        @if( $group != 'FM' )
            <tr style="height: 40px;text-align: center;">
                <td width="100px">Analytics </td>
                <td>{{!empty($total_task[0]->total) ? $total_task[0]->total : '0'}}</td>
                <td>{{!empty($total_done[0]->total) ? $total_done[0]->total : '0'}}</td>
                <td>{{!empty($total_pending) ? $total_pending : '0'}}</td>
                <td>{{!empty($dm_task[0]->ManagerReject) ? $dm_task[0]->ManagerReject : '0'}}</td>
                <td>{{!empty($dm_task[0]->ManagerVerified) ? $dm_task[0]->ManagerVerified : '0'}}</td>
                <td>{{!empty($dm_task[0]->QualityReject) ? $dm_task[0]->QualityReject : '0'}}</td>
                <td>{{!empty($dm_task[0]->QualityVerified) ? $dm_task[0]->QualityVerified : '0'}}</td>
                <td>{{!empty($locked[0]->total_locked) ? $locked[0]->total_locked : '0'}}</td>
                

            </tr>
        @else
        <tr style="height: 40px;text-align: center;">
            <td width="100px">Analytics</td>
            <td>{{!empty($family_total_task) ? $family_total_task : 0}}</td>

            <td>{{!empty($total_done_p1[0]->total) ? $total_done_p1[0]->total : 0}}</td>
            <td>{{!empty($total_done_p2[0]->total) ? $total_done_p2[0]->total : 0}}</td>
            <td>{{!empty($total_pending_p1) ?  $total_pending_p1 : 0    }}</td>
            <td>{{!empty($total_pending_p2) ? $total_pending_p2 : 0}}</td>
            <td>{{!empty($dm_task_p1[0]->ManagerReject) ? $dm_task_p1[0]->ManagerReject : '0'}}</td>
            <td>{{!empty($dm_task_p1[0]->ManagerVerified) ? $dm_task_p1[0]->ManagerVerified : '0'}}</td>
            <td>{{!empty($dm_task_p1[0]->QualityReject) ? $dm_task_p1[0]->QualityReject : '0'}}</td>
            <td>{{!empty($dm_task_p1[0]->QualityVerified) ? $dm_task_p1[0]->QualityVerified : '0'}}</td>
            <td >{{!empty($family_loan[0]->family_locked) ? $family_loan[0]->family_locked : '0'}}</td>
            <td >{{$Family_a[0]->green_analysis + $Family_a[0]->yellow_analysis}}</td>
            <td >{{!empty($family_loan[0]->family_verified) ? $family_loan[0]->family_verified : '0'}}</td>
            <td>{{!empty($family_loan[0]->family_get_loan) ? $family_loan[0]->family_get_loan : '0'}}</td>
            
        </tr>
            @endif
            @if($group !='FM')
            <tr style="height: 40px;text-align: center;">
                <td>Rating</td>
                <td>{{!empty($total_task_r[0]->total) ? $total_task_r[0]->total : '0'}}</td>
                <td>{{!empty($total_done_r[0]->total_done) ? $total_done_r[0]->total_done : '0'}}</td>
                <td>{{!empty($total_pending_r) ? $total_pending_r : '0'}}</td>
                <td>{{$dm_task_r[0]->ManagerReject_r ?? '0'}}</td>
                <td>{{$dm_task_r[0]->ManagerVerified_r ?? '0'}}</td>
                <td>{{$dm_task_r[0]->QualityReject_r ?? '0'}}</td>
                <td>{{$dm_task_r[0]->QualityVerified_r ?? '0'}}</td>
                <td></td>
                @if($group == 'FM')
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @endif
                
            </tr>
            @else
            <tr style="height: 40px;text-align: center;">
                <td>Rating</td>
                <td>{{!empty($total_task_r[0]->total) ? $total_task_r[0]->total : '0'}}</td>
                <td colspan="2">{{!empty($total_done_r[0]->total_done) ? $total_done_r[0]->total_done : '0'}}</td>
                <td colspan="2">{{!empty($total_pending_r) ? $total_pending_r : '0'}}</td>
                <td>{{!empty($dm_task_r[0]->ManagerReject_r) ? $dm_task[0]->ManagerReject_r : '0'}}</td>
                <td>{{!empty($dm_task_r[0]->ManagerVerified_r) ? $dm_task[0]->ManagerVerified_r : '0'}}</td>
                <td>{{!empty($dm_task_r[0]->QualityReject_r) ? $dm_task[0]->QualityReject_r : '0'}}</td>
                <td>{{!empty($dm_task_r[0]->QualityVerified_r) ? $dm_task[0]->QualityVerified_r : '0'}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                
            </tr>
            @endif


        </tbody>

    </table>

</body>

</html>