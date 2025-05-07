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
                            <li class="breadcrumb-item">Federation Quality Assurance</li>
                        </ul>
                    </div>
                    @php $session_data = Session::get('quality_filter_session'); @endphp
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Federation Quality Assurance</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-right">
                    {{-- <a href="{{ url('/federationtask') }}" class="btn cur-p btn-sm btn-success">Assign Task </a> --}}
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
                                            <option value="CL">Cluster</option>
                                            <option value="FD" selected>Federation</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-3" >
                                        <label for="validationCustom02">&nbsp;</label>
                                        <input type="submit" class="btn btn-sm btn-success" name="Search" value="Search"
                                            style="float:left;margin-top: 2.5em;">
                                        

                                    </div>
                                </div>
                            </form>
                        <div>
                            <button class="btn btn-info "  type="button" id="btn1" title="Pending" style="width:150px;font-size:18px;" >Pending</button>
                        <button class="btn btn-info" type="button" id="btn2" title="Complete" style="width:140px;font-size:18px;">Complete</button>
                        </div>
                            <div class="dt-responsive table-responsive" id="table1" >
                                @include('common.error')
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th width="10%">Federation-UIN</th>
                                            <th width="15%">Name</th>
                                            <th width="15%">Facilitator</th>
                                            <th width="10%">Task</th>
                                            <th width="10%">Manger Status</th>
                                            <th width="10%">Manager Update</th>
                                            <th width="10%">Quality Status</th>
                                            <th width="10%">Quality Update</th>
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
                                            <th width="10%">Federation-UIN</th>
                                            <th width="15%">Name</th>
                                            <th width="15%">Facilitator</th>
                                            <th width="10%">Task</th>
                                            <th width="10%">Manger Status</th>
                                            <th width="10%">Manager Update</th>
                                            <th width="10%">Quality Status</th>
                                            <th width="10%">Quality Update</th>
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
                    "url": '{{ url('federation_task_qa') }}',
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
                    "url": '{{ url('federation_task_qa_fed') }}',
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

        function Close() {
            $('#task_id').val('');
            $('#task_id').val('');
            $('#task_id').val('');
            return true;
        }

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
        function get_profile_data(id, agency_id, user_id, task) {
            $('.checkboxes').prop('checked', false);
            $('#task_id').val(id);
            $('#task').val(task);
            $('#agency_id').val(agency_id);
            $('#facilitator').val(user_id);
            if ($('#task').val() == 'A') {
                $('.rating_question_div').hide();
            } else {
                $('.rating_question_div').show();
            }
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

        function get_facilitator_list(agency_id) {
            if (agency_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_facilitator_list_task',
                    data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
                    success: function(data) {
                        if (data != '') {
                            $('#user_id').html(data);
                            $('#user_id').val($('#facilitator').val());
                            $('#user_id').trigger("change");
                        }
                    }
                });
            }
        }

        function set_facilitator() {
            var flg = $('#TaskQaAssignment_status').val();
            var agency_id = $('#agency_id').val();
            if (flg == 'R') {
                $('.show_div').show();
                $('.show_div select').attr('required', 'required');
                get_facilitator_list(agency_id);
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
        $('#btn1').on('click', function(e) {
            $('#table2').hide();
            $('#table1').show();
            $('#btn2').css({
                "background-color": "",
                "opacity": "0.5"
            });
            $('#btn1').css({
                "background-color": "",
                "opacity": "1"
            });
        });
        $('#btn2').on('click', function(e) {
            $('#table1').hide();
            $('#table2').show();
            $('#btn1').css({
                "background-color": "",
                "opacity": "0.5"
            });
            $('#btn2').css({
                "background-color": "",
                "opacity": "1"
            });
        });
     
    </script>

@endsection
<!-- data-table js -->
