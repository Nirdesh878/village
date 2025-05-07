@extends('layouts.app')

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item">Process Steps Tracking Report</li>
                    </ul>
                </div>
                @php $session_data = Session::get('process_filter_session'); @endphp
                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>
                            Process Steps Tracking Report 
                        </h4>
                    </div>




                    <div class="pull-right">
                        <div class="export_icon_css">
                            <a href="javascript:void(0)" id="export" onclick="ExportToExcel('xlsx')">
                                <img src="{{ asset('assets\images\excel.png') }}" data-toggle="tooltip" title="Excel Export" data-src="{{ asset('assets\images\excel.png') }}" srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x" alt="Excel Export" title="Excel" class="lzy lazyload--done" style="height: 35px;">
                            </a>
                        </div>
                        <div class="export_pdf_css">
                            <a href="{{ URL::to('processStepPdf') }}"><img src="{{ asset('assets\images\pdf.png') }}" data-toggle="tooltip" title="PDF Download" alt="PDF Download" title="PDF Download" class="lzy lazyload--done" style="height: 35px;"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-header end -->


        <!-- Page-body start -->
        <div class="page-body" style="margin-top: 10px">

            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">
                            <form class="container" method="GET" action="#" id="needs-validation" autocomplete="off">
                                @csrf
                                <div class="row">

                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom02">Group Type</label>
                                        <select class="form-control" name="group" id="group" >
                                            <option value="">--Select--</option>
                                            <option value="AG">Agency</option>
                                            <option value="FD">Federation</option>
                                            <option value="CL">Cluster</option>
                                            <option value="SH">SHG</option>
                                            <option value="FM">Family</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3" id="agency_div">
                                        <label for="validationCustom02">Agency<span
                                                class="red">*</span></label>
                                        <select class="form-control " name="agency_id" id="agency_id"
                                            required>
                                            <option value="">--Select--</option>
                                            @foreach ($agency as $row)
                                                <option value="{{ $row->agency_id }}"  >
                                                    {{ $row->agency_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-2 mb-3">
                                        <label for="validationCustom02">&nbsp;</label>
                                        <input type="submit" class="btn btn-sm btn-success" id="search" name="Search" value="Search" style="float:left;margin-top: 2.5em;">
                                        <button class="btn  btn-sm btn-danger" name="clear" value="clear" style="float: left;;margin-top:2.5em;margin-left: 10px;">Clear</button>

                                    </div>
                                </div>
                            </form>
                         @if(!empty($session_data['group']))
                            <div class="dt-responsive table-responsive">
                                @include('common.error')
                                <table id="simpletable" class="table table-striped table-bordered nowrap" style="width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="text-align: center;text-transform: capitalize;font-size:20px;">{{$task}}@if($session_data['group'] == 'AG'){{'-'.$agency_name[0]->agency_name}}@endif</th>
                                            
                                            <th></th>
                                            @if($session_data['group'] == 'FM')
                                            <th colspan="5"></th>
                                            @endif
                                            <th></th>
                                        </tr>
                                        @if($session_data['group'] !='FM')
                                        <tr>
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
                                            <th width="10%">No of Task Locked</th>
                                           
                                            <th width="10%">Action</th>

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
                                            <th width="10%">Action</th>

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
                                                2nd visits</th>
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
                                            <th width="10%"></th>
                                        </tr>
                                        @endif
                                    </thead>
                                    <tbody>
                                        @php
                                        $r='R';
                                        $a='A';
                                            @endphp

                                    @if( $session_data["group"] != 'FM' )
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
                                            <td><a><button data-toggle="modal" data-id=""href="#exampleModalCenter2" style="border:none;:pointer" class="task" value="A" ><span class="badge badge-warning task" >View Task</span></button></a>
                                            </td>

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
                                            <td><a><button data-toggle="modal" data-id=""href="#exampleModalCenter2" style="border:none;:pointer" class="task" value="P1" ><span class="badge badge-warning task" >View Task</span></button></a>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($session_data['group'] !='FM')
                                        <tr style="height: 40px;text-align: center;">
                                            <td>Rating </td>
                                            <td>{{!empty($total_task_r[0]->total) ? $total_task_r[0]->total : '0'}}</td>
                                            <td>{{!empty($total_done_r[0]->total_done) ? $total_done_r[0]->total_done : '0'}}</td>
                                            <td>{{!empty($total_pending_r) ? $total_pending_r : '0'}}</td>
                                            <td>{{$dm_task_r[0]->ManagerReject_r ?? '0'}}</td>
                                            <td>{{$dm_task_r[0]->ManagerVerified_r ?? '0'}}</td>
                                            <td>{{!empty($dm_task_r[0]->QualityReject_r) ? $dm_task[0]->QualityReject_r : '0'}}</td>
                                            <td>{{$dm_task_r[0]->QualityVerified_r ?? '0'}}</td>
                                            <td></td>
                                           <!--  @if($session_data['group'] == 'FM')
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            @endif -->
                                            <td><a><button data-toggle="modal" data-id=""href="#exampleModalCenter2" style="border:none;:pointer" class="task" value="R" ><span class="badge badge-warning task" >View Task</span></button></a>
                                            </td>
                                        </tr>
                                        @else
                                        <tr style="height: 40px;text-align: center;">
                                            <td>Rating</td>
                                            <td>{{!empty($total_task_r[0]->total) ? $total_task_r[0]->total : '0'}}</td>
                                            <td colspan="2">{{!empty($total_done_r[0]->total_done) ? $total_done_r[0]->total_done : '0'}}</td>
                                            <td colspan="2">{{!empty($total_pending_r) ? $total_pending_r : '0'}}</td>
                                            <td>{{!empty($dm_task_r[0]->ManagerReject_r) ? $dm_task_r[0]->ManagerReject_r : '0'}}</td>
                                            <td>{{!empty($dm_task_r[0]->ManagerVerified_r) ? $dm_task_r[0]->ManagerVerified_r : '0'}}</td>
                                            <td>{{!empty($dm_task_r[0]->QualityReject_r) ? $dm_task_r[0]->QualityReject_r : '0'}}</td>
                                            <td>{{!empty($dm_task_r[0]->QualityVerified_r) ? $dm_task_r[0]->QualityVerified_r : '0'}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><a><button data-toggle="modal" data-id=""href="#exampleModalCenter2" style="border:none;:pointer" class="task" value="R" ><span class="badge badge-warning task" >View Task</span></button></a>
                                            </td>
                                        </tr>
                                        @endif


                                    </tbody>

                                </table>
                            </div>
                        @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog">
            <div class="modal-dialog mw-100 w-75" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header-full-width   modal-header ">
                        <h4 class="modal-title" style="position:relative;left:40%;"> Process step Report</h4>

                        <button type="button" class="close" data-dismiss="modal" style="font-size: 50px;">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body" id="tasktable">
                        @include('common.error')
                        <table id="taskTable" class="table table-striped table-bordered nowrap" style="width:100%;">

                        </table>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
    <style>
        .export_icon_css {
            position: absolute !important;
            z-index: 1 !important;
            left: 125% !important;
            top: -40% !important;
        }

        .export_pdf_css {
            position: absolute !important;
            z-index: 1 !important;
            left: 133% !important;
            top: -46% !important;
        }

    </style>

    <script src="{{ asset('bower_components\datatables.net\js\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components\datatables.net-buttons\js\dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets\pages\data-table\js\jszip.min.js') }}"></script>
    <script src="{{ asset('assets\pages\data-table\js\pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets\pages\data-table\js\vfs_fonts.js') }}"></script>
    <script src="{{ asset('bower_components\datatables.net-buttons\js\buttons.print.min.js') }}"></script>
    <script src="{{ asset('bower_components\datatables.net-buttons\js\buttons.html5.min.js') }}"></script>
    <script src="{{ asset('bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets\js\table_excel.js') }}"></script>
    <script>
          function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('simpletable');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Process_Step_Report.' + (type || 'xlsx')));
    }






        $(document).ready(function() {

            @php echo!empty($session_data["group"]) > 0 ? "$('#group').val('".$session_data["group"].
            "');": ""
            @endphp

            // // $('#agency_id').attr('disabled', true);



            @php echo!empty($session_data["agency_id"]) > 0 ? "$('#agency_id').val('".$session_data["agency_id"].
            "');": ""

            @endphp
            $('#group').trigger("change");
            $('#agency_div').hide();
        });

        $('.task').on('click',get_tasks_list);

        $('body').on('change','#group', function() {
            var obj = $(this);
            var type = obj.val();
            var group = $('#group').val();
            // alert(group);

            if(group == 'AG')
            {
                $('#agency_div').show();
                $('#agency_id').attr('disabled', false);
                $('#group').trigger();
            }
            else{
                $('#agency_div').hide();
                $('#agency_id').attr('disabled', true);
                $('#group').trigger();
            }



        });


        function get_tasks_list() {

            // alert("hhh");
            var obj = $(this);
            var type = obj.val();
            var group = $('#group').val();
            var agency = $('#agency_id').val();
            // alert(agency_id);

            if (type != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_tasks_list',
                    data: '_token = <?php echo csrf_token(); ?>&type=' + type +  '&group=' + group + '&agency=' + agency,
                    success: function(data) {
                        $('#tasktable').html(data);

                    }
                });
            }
        }
    </script>

    @endsection
    <!-- data-table js -->
