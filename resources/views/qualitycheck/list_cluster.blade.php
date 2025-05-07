@extends('layouts.app')

@section('content')
    <style type="text/css">
        .labelval,
        .label {
            color: black !important;
            font-size: 12px;
            font-weight: 700;
        }
        tr { height: 50px } 

    </style>
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
                            <li class="breadcrumb-item">Cluster Quality Assurance</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Cluster Quality Assurance</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-right">
                    {{-- <a href="{{ url('/clustertask') }}" class="btn cur-p btn-sm btn-success">Assign Task </a> --}}
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">
                            <form class="container" method="GET" action="{{ url('qualitycheck') }}"
                                id="needs-validation" autocomplete="off">
                                @csrf
                                <div class="row">

                                    <div class="col-md-5 mb-3" style="margin-left: -40px;">
                                        <label for="validationCustom02">Group Type</label>
                                        <select class="form-control" name="group" id="group">
                                            <option value="">--Select--</option>
                                            <option value="ALL">ALL</option>
                                            <option value="FM">Family</option>
                                            <option value="SH">SHG</option>
                                            <option value="CL" selected>Cluster</option>
                                            <option value="FD">Federation</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-3" >
                                        <label for="validationCustom02">&nbsp;</label>
                                        <input type="submit" class="btn btn-sm btn-success" name="Search" value="Search"
                                            style="float:left;margin-top: 2.5em;">
                                        

                                    </div>
                                </div>
                            </form>
                            <button class="btn btn-info " type="button" id="btn1" title="Pending"
                                style="width:150px;font-size:18px;">Pending</button>
                            <button class="btn btn-info" type="button" id="btn2" title="Complete"
                                style="width:140px;font-size:18px;">Complete</button>
                            <div class="dt-responsive table-responsive" id="table1">
                                @include('common.error')
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th width="20%">Cluster-UIN</th>
                                            <th width="10%">Name</th>
                                            <th width="10%">Federation</th>
                                            <th width="20%">Facilitator</th>
                                            <th width="20%">Task</th>
                                            <th width="10%">Manger Status</th>
                                            <th width="10%">Manager Update</th>
                                            <th width="10%">Quality Status</th>
                                            <th width="10%">Quality Update</th>
                                            {{-- <th width="20%">Update</th> --}}
                                            @if ($u_type == 'M' || $u_type == 'QA')
                                                <th width="10%">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="dt-responsive table-responsive" id="table2">
                                @include('common.error')
                                <table id="simpletable1" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th width="20%">Cluster-UIN</th>
                                            <th width="10%">Name</th>
                                            <th width="10%">Federation</th>
                                            <th width="20%">Facilitator</th>
                                            <th width="20%">Task</th>
                                            <th width="10%">Manger Status</th>
                                            <th width="10%">Manager Update</th>
                                            <th width="10%">Quality Status</th>
                                            <th width="10%">Quality Update</th>
                                            {{-- <th width="20%">Update</th> --}}
                                            @if ($u_type == 'M' || $u_type == 'QA')
                                                <th width="10%">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-wd-90" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> ☰ <span style="font-size: 17px;">Federation Track Record</span></h4>
                        <button type="button" onclick="return Close()" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group row">

                                <div class="col-md-3">

                                    <table class="table table-hover mb-0 hidden-sm-down">
                                        <tbody>
                                            <tr>
                                                <td style="border-top:0px; padding: 2px;">

                                                    <div class="text-muted">
                                                        <span class="badge badge-primary"
                                                            style="background: #2b6898;">Federation</span>
                                                        <span class="fed_name"
                                                            style="color:#000;float: right;"></span>

                                                    </div>

                                                    <div class="progress progress-xs" style=" height: 2px;">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: 5%" aria-valuenow="10" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>

                                                </td>
                                            </tr>


                                            <tr>
                                                <td style="padding: 2px;">

                                                    <div class="text-muted">
                                                        <span class="badge badge-primary"
                                                            style="background: #2b6898;">Agency</span>
                                                        <span class="agency_name"
                                                            style="color:#000;float: right;"></span>

                                                    </div>

                                                    <div class="progress progress-xs" style=" height: 2px;">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: 5%" aria-valuenow="10" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding: 2px;">

                                                    <div class="text-muted">
                                                        <span class="badge badge-primary"
                                                            style="background: #2b6898;">UIN</span>
                                                        <span class="uin"
                                                            style="color:#000;float: right;"></span>

                                                    </div>

                                                    <div class="progress progress-xs" style=" height: 2px;">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: 5%" aria-valuenow="10" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding: 2px;">

                                                    <div class="text-muted">
                                                        <span class="badge badge-primary"
                                                            style="background: #2b6898;">Number of Cluster</span>
                                                        <span class="number_of_cluster"
                                                            style="color:#000;float: right;"></span>

                                                    </div>

                                                    <div class="progress progress-xs" style=" height: 2px;">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: 5%" aria-valuenow="10" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td style="padding: 2px;">

                                                    <div class="text-muted">
                                                        <span class="badge badge-primary"
                                                            style="background: #2b6898;">Number of Shg</span>
                                                        <span class="number_of_shg"
                                                            style="color:#000;float: right;"></span>

                                                    </div>

                                                    <div class="progress progress-xs" style=" height: 2px;">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: 5%" aria-valuenow="10" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding: 2px;">

                                                    <div class="text-muted">
                                                        <span class="badge badge-primary"
                                                            style="background: #2b6898;">Number of Family</span>
                                                        <span class="number_of_family"
                                                            style="color:#000;float: right;"></span>

                                                    </div>

                                                    <div class="progress progress-xs" style=" height: 2px;">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: 5%" aria-valuenow="10" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>





                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-3">

                                    <table class="table table-hover mb-0 hidden-sm-down">
                                        <tbody>
                                            <tr>
                                                <td style="border-top:0px; padding: 2px;">

                                                    <div class="text-muted">
                                                        <span class="badge badge-primary">Rating</span>
                                                        <span class="rate"
                                                            style="color:#000;float: right;"><?php //echo $model['profile'][0]['rate'];
?></span>

                                                    </div>
                                                    <div class="progress progress-xs" style=" height: 5px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding: 2px;">

                                                    <div class="text-muted">
                                                        <span class="badge badge-success">Add Date</span>
                                                        <span class="created_at"
                                                            style="color:#000;float: right;"></span>

                                                    </div>

                                                    <div class="progress progress-xs" style=" height: 5px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: 50%" aria-valuenow="10" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td style="padding: 2px;">

                                                    <div class="text-muted">
                                                        <span class="badge badge-success">Last Update</span>
                                                        <span class="updated_at"
                                                            style="color:#000;float: right;"></span>

                                                    </div>

                                                    <div class="progress progress-xs" style=" height: 5px;">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: 50%" aria-valuenow="10" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>



                                </div>



                                <div class="col-md-2">
                                    <center style="padding-bottom: 5px;">Rating Score</center>
                                    <div id="demo-pie-1" class="pie-title-center" style="height: 150px;width: 150px;">
                                        <canvas id="raating_d_chart"></canvas>
                                        <span class="pie-value"></span>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div id="container11111" style="height: 200px;width: 100%;">
                                        <canvas id="rate_line"></canvas>
                                    </div>

                                </div>

                            </div>



                            <div class="form-group row">
                                <div class="col-md-12" style="padding-bottom: 10px;">
                                    <div class="text-muted">
                                        <span class="badge badge-success">Profile Details</span>
                                    </div>
                                    <div class="progress progress-xs" style=" height: 1px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"
                                            aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>


                                <div class="col-md-12" style="padding-bottom: 10px;">
                                    <div class="text-muted">
                                        <span class="badge badge-info">Basic Profile</span>
                                    </div>
                                    <div class="progress progress-xs" style=" height: 1px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 30%"
                                            aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>


                                <div class="col-md-2 label">Federation Name</div>
                                <div class="col-md-2 labelval fed_name"></div>
                                <div class="col-md-2 label">District</div>
                                <div class="col-md-2 labelval name_of_district"></div>
                                <div class="col-md-2 label">State</div>
                                <div class="col-md-1 labelval name_of_state"></div>

                            </div>


                            <div class="form-group row">

                                <div class="col-md-2 label">Country</div>
                                <div class="col-md-2 labelval name_of_country"></div>
                                <div class="col-md-2 label">Found Date</div>
                                <div class="col-md-2 labelval date_federation_was_found"></div>
                                <div class="col-md-2 label">Legal Status</div>
                                <div class="col-md-1 labelval legal_status"></div>

                            </div>


                            <div class="form-group row">

                                <div class="col-md-2 label">Registration No.</div>
                                <div class="col-md-2 labelval registration_no"></div>
                                <div class="col-md-2 label">Clusters at time creation</div>
                                <div class="col-md-2 labelval clusters_at_time_creation"></div>
                                <div class="col-md-2 label ">Shg at time creation</div>
                                <div class="col-md-1 labelval shg_at_time_creation"></div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-2 label">Members at time creation</div>
                                <div class="col-md-2 labelval members_at_time_creation"></div>
                                <div class="col-md-2 label">Total Cluster</div>
                                <div class="col-md-2 labelval total_clusters"></div>
                                <div class="col-md-2 label">Total Shg</div>
                                <div class="col-md-1 labelval total_SHGs"></div>

                            </div>




                            <div class="form-group row">

                                <div class="col-md-2 label">Total Members</div>
                                <div class="col-md-2 labelval total_members"></div>
                                <div class="col-md-2 label">President</div>
                                <div class="col-md-2 labelval president"></div>
                                <div class="col-md-2 label">Secretary</div>
                                <div class="col-md-1 labelval secretary"></div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-2 label">Treasurer</div>
                                <div class="col-md-2 labelval Treasurer"></div>
                                <div class="col-md-2 label">Book Keeper Name</div>
                                <div class="col-md-2 labelval book_keeper_name"></div>
                                <div class="col-md-2 label">Date of Appointment</div>
                                <div class="col-md-1 labelval date_of_appointment"></div>

                            </div>

                            <div class="form-group row">
                                <div class="col-md-12" style="padding-bottom: 10px;">
                                    <div class="text-muted">
                                        <span class="badge badge-info">Rating </span>
                                    </div>
                                    <div class="progress progress-xs" style=" height: 1px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 30%"
                                            aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                @php $i=0; @endphp
                                @if (!empty($rating_question))
                                    @foreach ($rating_question as $subcategory)
                                        <div class="form-group row">
                                            <div class="col-md-12 label" style="font-size:12px;">
                                                {{ $subcategory->mst_subcat_name }}</div>
                                        </div>

                                        @foreach ($subcategory->question as $questions)
                                            <div class="form-group row">
                                                <div class="col-md-12 label">

                                                    <span>Q{{ ++$i }} - </span>{{ $questions->mst_ques_name }}
                                                </div>
                                            </div>
                                            @foreach ($questions->ans as $answer)
                                                <div class="form-group row">
                                                    <div class="col-md-12 labelval">
                                                        <input type="radio" value="{{ $answer->mst_id }}"
                                                            name="{{ $answer->mst_ques_id }}"
                                                            id="ans_{{ $answer->mst_id }}"> {{ $answer->mst_ans_name }}
                                                    </div>
                                                </div>
                                            @endforeach

                                        @endforeach
                                    @endforeach
                            </div>
                        @else


                            <div class="form-group row">

                                <div class="col-md-2 label">no data found!</div>
                            </div>

                            @endif
                            <hr>
                        </div>
                        <p id="resp" style="box-shadow: -2px 4px 10px;">
                        <div class="form-group row">
                            <label class="col-md-3 offset-md-1 form-control-label" for="input-small">Action </label>
                            <div class="col-md-6">
                                <select class="form-control form-control-sm" name="TaskQaAssignment_status"
                                    id="TaskQaAssignment_status">
                                    <option value="V">Verify</option>
                                    <option value="R">Reject</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row show_div">
                            <label class="col-md-3 offset-md-1 form-control-label" for="input-small">
                                <label for="TaskQaAssignment_remark" class="required">Agency </label></label>
                            <div class="col-md-6" id="remark_txt">
                                <select class="form-control agency_id" name="agency_id" id="agency_id" required>
                                    <option value="">--Select--</option>
                                    @foreach ($agency as $row)
                                        <option value="{{ $row->agency_id }}">{{ $row->agency_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row show_div">
                            <label class="col-md-3 offset-md-1 form-control-label" for="input-small">
                                <label for="TaskQaAssignment_remark" class="required">Facilitator </label></label>
                            <div class="col-md-6" id="remark_txt">
                                <select class="form-control user_id" name="user_id" id="user_id" required>
                                    <option value="">--Select--</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 offset-md-1 form-control-label" for="input-small">
                                <label for="TaskQaAssignment_remark" class="required">Remark </label></label>
                            <div class="col-md-6" id="remark_txt">
                                <textarea class="form-control form-control-sm" name="TTaskQaAssignment_remark"
                                    id="TaskQaAssignment_remark"></textarea>
                            </div>
                        </div>
                        <span style="font-size:12px; color: red;margin-left: 39px;"><i>Note: This action considered as
                                complete / close.</i></span>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="task_id" id="task_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="return Close()">Close</button>
                        <button type="button" class="btn btn-primary" onclick="return submitAction()">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>

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
    <script>
        $(function() {
            var table = $('#simpletable').DataTable({
                "processing": true,
                "serverSide": true, //Feature control DataTables' servermside processing mode.
                "bFilter": true,
                "bLengthChange": false,
                "ordering": false,
                "iDisplayLength": 10,
                "responsive": false,
                "ajax": {
                    "url": '{{ url('cluster_task_qa') }}',
                    "type": "GET",
                    "dataType": "json",
                    "data": function(data) {
                        // manipulate data used in ajax request prior to server call
                        delete data.columns;
                    },
                    "dataSrc": function(jsonData) {
                        return jsonData.data;
                    }
                },
                //Set column definition initialisation properties.
                "columnDefs": [{
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                }, ],

            });
            // dataTable();
        });

        $(function() {
            var table = $('#simpletable1').DataTable({
                "processing": true,
                "serverSide": true, //Feature control DataTables' servermside processing mode.
                "bFilter": true,
                "bLengthChange": false,
                "ordering": false,
                "iDisplayLength": 10,
                "responsive": false,
                "ajax": {
                    "url": '{{ url('cluster_task_qa_clus') }}',
                    "type": "GET",
                    "dataType": "json",
                    "data": function(data) {
                        // manipulate data used in ajax request prior to server call
                        delete data.columns;
                    },
                    "dataSrc": function(jsonData) {
                        return jsonData.data;
                    }
                },
                //Set column definition initialisation properties.
                "columnDefs": [{
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                }, ],

            });
            // dataTable();
        });

        function submitAction() {
            var id = $('#task_id').val();
            var sts = $('#TaskQaAssignment_status').val();
            var rmk = $('#TaskQaAssignment_remark').val();
            var user_id = $('#user_id').val();
            $.ajax({
                url: '/change_qa_status_fed',
                type: 'GET',
                data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts + '&rmk=' + rmk +
                    '&assignment_type="FD"&user_id=' + user_id,
                success: function(response) {
                    data = JSON.parse(response);
                    if (data.result == 1) {
                        window.location.href = "{{ url('federation_task_qa') }}";
                    }
                }
            });

        }

        $(document).ready(function() {
            var ctx = document.getElementById("raating_d_chart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Rating", ""],
                    datasets: [{
                        data: [20, 80, ],

                        borderColor: ['#2196f38c', '#f443368c'],
                        backgroundColor: ['#2196f38c', '#f443368c'],
                        borderWidth: 1
                    }]
                },
                options: {
                    cutoutPercentage: 80,
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                }
            });

        });

        $(document).ready(function() {
            $('#table2').hide();

        });
        $('#btn1').on('click', function(e) {
            $('#table2').hide();
            $('#table1').show();
        });
        $('#btn2').on('click', function(e) {
            $('#table1').hide();
            $('#table2').show();
        });
        //$(this.element).find('.pie-value').text(Math.round(percent) + '%');
    </script>
    <script>
        var config = {
            type: 'line',
            data: {
                labels: ['2018', '2019', '2020'],
                datasets: [{
                    label: 'rating',
                    backgroundColor: 'blue',
                    borderColor: 'blue',
                    fill: false,
                    data: [1, 1, 1],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: 'Chart.js Line Chart - Logarithmic'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Year'
                        },

                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false,
                            labelString: 'Index Returns'
                        },
                        ticks: {
                            min: 0,
                            // forces step size to be 5 units
                            stepSize: 0.5
                        }
                    }]
                }
            }
        };


        var ctx1 = document.getElementById('rate_line').getContext('2d');
        window.myLine = new Chart(ctx1, config);
    </script>
    <script>
        function get_profile_data(id) {
            $('#task_id').val(id);
            $.ajax({
                type: 'GET',
                url: '/get_profile_data',
                data: '_token = <?php echo csrf_token(); ?>&qa_task_id=' + id,
                success: function(data) {
                    if (data != '') {
                        $('.fed_name').html(data[0].name_of_federation);
                        $('.agency_name').html(data[0].agency_name);
                        $('.uin').html(data[0].uin);
                        $('.number_of_cluster').html(data[0].number_of_cluster);
                        $('.number_of_shg').html(data[0].number_of_shg);
                        $('.number_of_family').html(data[0].number_of_family);
                        $('.name_of_country').html(data[0].name_of_country);
                        $('.name_of_state').html(data[0].name_of_state);
                        $('.name_of_district').html(data[0].name_of_district);
                        $('.members_at_time_creation').html(data[0].members_at_time_creation);
                        $('.total_clusters').html(data[0].total_clusters);
                        $('.total_SHGs').html(data[0].total_SHGs);
                        $('.total_members').html(data[0].total_members);
                        $('.book_keeper_name').html(data[0].book_keeper_name);
                        $('.president').html(data[0].president);
                        $('.secretary').html(data[0].secretary);
                        $('.Treasurer').html(data[0].Treasurer);
                        $('.registration_no').html(data[0].registration_no);
                        $('.date_federation_was_found').html(data[0].date_federation_was_found);
                        $('.legal_status').html(data[0].legal_status);
                        $('.date_of_appointment').html(data[0].date_of_appointment);
                        $('.rate').html(data[0].rate);
                        $('.shg_at_time_creation').html(data[0].shg_at_time_creation);
                        $('.clusters_at_time_creation').html(data[0].clusters_at_time_creation);
                        var rating = JSON.parse(data[0].rating);
                        for (var i = 0; i < rating.length; i++) {
                            $("#ans_" + (rating[i]) + "").prop('checked', true);
                            // $("#ans_443").prop('checked',true);

                        }
                    }
                }
            });
        }

        function get_facilitator_list() {
            var obj = $(this);
            var agency_id = obj.val();
            if (agency_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_facilitator_list_task',
                    data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
                    success: function(data) {
                        if (data != '') {
                            $('#user_id').html(data);
                            $('#user_id').trigger("change");
                        }
                    }
                });
            }
        }

        function set_facilitator() {
            var flg = $('#TaskQaAssignment_status').val();
            if (flg == 'R') {
                $('.show_div').show();
                $('.show_div select').attr('required', 'required');
            } else {
                $('.show_div').hide();
                $('.show_div select').removeAttr('required');
            }
        }
        $(document).ready(function() {
            $('#agency_id').on('change', get_facilitator_list);
            $('#TaskQaAssignment_status').on('change', set_facilitator);
            $('#TaskQaAssignment_status').trigger('change');
        });

        $(document).ready(function() {
            $('#table2').hide();
            $('#btn2').css({
                "background-color": "",
                "opacity": "0.5"
            });
        });

        $('#btn2').on('click', function(e) {
            $('#btn1').css({
                "background-color": "",
                "opacity": "0.5"
            });
            $('#btn2').css({
                "background-color": "",
                "opacity": "1"
            });
        });
        $('#btn1').on('click', function(e) {
            $('#btn2').css({
                "background-color": "",
                "opacity": "0.5"
            });
            $('#btn1').css({
                "background-color": "",
                "opacity": "1"
            });
        });
    </script>

@endsection
<!-- data-table js -->
