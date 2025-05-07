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
                            <li class="breadcrumb-item">Assign Task</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Assign Task</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-header end -->

        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">
                            <div class="mT-30">@include('common.error')
                                <form class="container" method="POST" action="{{ url('store_task') }}"
                                    autocomplete="off" id="task_form" onsubmit="return validateForm()" name="myForm">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Facilitator<span
                                                    class="red">*</span></label>
                                            <select class="form-control user_id" name="user_id" id="user_id" required>
                                                <option value="">--Select--</option>
                                                @foreach ($facilitator_list as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Agency Assign To<span
                                                    class="red">*</span></label>
                                            <select class="form-control agency_id" name="agency_id" id="agency_id" required>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom02">Remarks <span
                                                    class="red">*</span></label>
                                            <textarea class="form-control" id="remark" name="remark" rows="2" cols="2" autocomplete="off" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Task</label>
                                            <select class="form-control task_fd" name="task_fd" id="task_fd"
                                                gtype="federation">
                                                <option value="">--Select--</option>
                                                <option value="A">Analysis</option>
                                                <option value="R">Rating</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label for="validationCustom02">Federation</label>
                                            <span id="count_fd" style="color: red;float: right;"></span>
                                            <select class="js-example-basic-multiple form-control" name="federation_id[]"
                                                id="federation_id" multiple="multiple">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Task</label>
                                            <select class="form-control task_cl" name="task_cl" id="task_cl"
                                                gtype="cluster">
                                                <option value="">--Select--</option>
                                                <option value="A">Analysis</option>
                                                <option value="R">Rating</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label for="validationCustom02">Cluster</label>
                                            <span id="count_cl" style="color: red;float: right;"></span>
                                            <select class="js-example-basic-multiple form-control" name="cluster_id[]"
                                                id="cluster_id" multiple="multiple">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Task</label>
                                            <select class="form-control task_sh" name="task_sh" id="task_sh" gtype="shg">
                                                <option value="">--Select--</option>
                                                <option value="A">Analysis</option>
                                                <option value="R">Rating</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label for="validationCustom02">SHG</label>
                                            <span id="count_sh" style="color: red;float: right;"></span>
                                            <select class="js-example-basic-multiple form-control" name="shg_id[]"
                                                id="shg_id" multiple="multiple">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Family </label>

                                            <select class="form-control task_fm" name="task_fm1" id="task_fm1" gtype="family">
                                                <option value="">--Select--</option>
                                                <option value="A">Analysis</option>
                                                <option value="R">Rating</option>
                                                
                                            </select>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label for="validationCustom02">Family </label>
                                            <span id="count_fm1" style="color: red;float: right;"></span>
                                            <select class="js-example-basic-multiple form-control" name="family_id_p1[]"
                                                id="family_id_p1" multiple="multiple">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    

                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success"  id="save"
                                                type="submit">Save</button>
                                            <a href="{{ url('preanalytics') }}" class="btn btn-sm btn-danger">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
    <script>
         $(function() {
            $("form").submit(function(e) {
                $('#save').prop('disabled', true);
                $('#save').css('opacity', '0.4');
                return true;
            });
        });
        $(document).ready(function() {
            $("#federation_id,#cluster_id,#shg_id,#family_id_p1,#family_id_p2,#family_id_r").prop("disabled", true);
            // $("#federation_id,#cluster_id,#shg_id,#family_id").css("pointer-events", "none"); 
            $('#task_fd,#task_cl,#task_sh,#task_fm_r,#task_fm1').on('change', get_family_list);
            
            $('#user_id').on('change', get_agency_list);
        });
        $('#task_fd').change(function() {

            $('#federation_id').prop("disabled", false);
        });
        $('#task_cl').change(function() {

            $('#cluster_id').prop("disabled", false);
        });
        $('#task_sh').change(function() {

            $('#shg_id').prop("disabled", false);
        });
        $('#task_fm1').change(function() {

            $('#family_id_p1').prop("disabled", false);
        });
        $('#task_fm2').change(function() {

            $('#family_id_p2').prop("disabled", false);
        });
        $('#task_fm_r').change(function() {

         $('#family_id_r').prop("disabled", false);
        });

        

        function validateForm() {
            let a = document.forms["myForm"]["federation_id"].value;
            let b = document.forms["myForm"]["cluster_id"].value;
            let c = document.forms["myForm"]["shg_id"].value;
            let d = document.forms["myForm"]["family_id_p1"].value;
            let e = document.forms["myForm"]["family_id_p2"].value;
            let f = document.forms["myForm"]["family_id_r"].value;
            if (a == "" && b == "" && c == "" && d == "" && e == "" && f == ""  ) {
                bootbox.alert({
                                    title: "Warning?",
                                    message:"<h4>Atleast fill one task</h4>" ,
                                    
                                });
                
                return false;
            }
            else
            {
                $('#save').prop('disabled', true);
                $('#save').css('opacity', '0.4');
            }
        }

        function get_agency_list() {
            var obj = $(this);
            var user_id = obj.val();
            if (user_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_agency_list',
                    data: '_token = <?php echo csrf_token(); ?>&user_id=' + user_id,
                    success: function(data) {
                        if (data != '') {
                            $('#agency_id').html(data);
                            $('#agency_id').trigger("change");
                        }
                    }
                });
            }
        }

        function get_family_list() {
            var obj = $(this);
            var task_fd = obj.val();
            var agency_id = $("#agency_id").val();
            var gtype = $(this).attr('gtype');
            var Tasktype = $(this).attr('gtype');
            // alert(Tasktype);
            
            if (task_fd != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_family_list',
                    data: '_token = <?php echo csrf_token(); ?>&task_fd=' + task_fd + '&agency_id=' + agency_id +
                        '&gtype=' + gtype,
                    success: function(response) {

                        if (response != '') {
                            if (Tasktype == 'federation') {
                                $('#federation_id').html(response.option_list);
                                $('#count_fd').html(response.list);
                            }
                            if (Tasktype == 'cluster') {
                                $('#cluster_id').html(response.option_list);
                                $('#count_cl').html(response.list);
                            }
                            if (Tasktype == 'shg') {
                                $('#shg_id').html(response.option_list);
                                $('#count_sh').html(response.list);
                            }
                            if (Tasktype == 'family') {
                                $('#family_id_p1').html(response.option_list);
                                $('#count_fm1').html(response.list);
                            }
                            

                        }
                    }
                });
            }
        }
    </script>
@endsection
