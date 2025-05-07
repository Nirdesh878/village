@extends('layouts.app')

@section('content')
<style>
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
                            <li class="breadcrumb-item">SHG Quality Assurance</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>SHG Quality Assurance</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-right">
                    {{-- <a href="{{ url('/shgtask') }}" class="btn cur-p btn-sm btn-success">Assign Task </a> --}}
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
                                            <option value="SH" selected>SHG</option>
                                            <option value="CL">Cluster</option>
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
                                            <th width="20%">SHG-UIN</th>
                                            <th width="20%">Name</th>
                                            <th width="20%">Cluster</th>
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
                                            <th width="20%">SHG-UIN</th>
                                            <th width="20%">Name</th>
                                            <th width="20%">Cluster</th>
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
                    "url": '{{ url('get_shg_list_qa') }}',
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
                    "url": '{{ url('get_shg_list_qa_shg') }}',
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

        function fn_delete(id) {
            bootbox.confirm({
                title: "",
                message: "Are you sure, you want to delete this Family?",
                callback: function(result) {
                    if (result) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var url = '{{ route('qualitycheck.destroy', ':id') }}';
                        url = url.replace(':id', id);

                        $.ajax({

                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    _method: "DELETE"
                                },
                                url: url,
                                dataType: 'JSON'

                            })
                            .done(function(response) {
                                bootbox.alert({
                                    title: "Deleted?",
                                    message: response.message
                                });
                                location.reload();
                            })
                            .fail(function(response) {
                                bootbox.alert({
                                    title: "Deleted?",
                                    message: 'Something Went Wrong..'
                                });
                            })
                    }
                }
            });
        }
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
