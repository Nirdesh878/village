@extends('layouts.app')

@section('content')
    @php $user = \Illuminate\Support\Facades\Auth::user(); @endphp
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
                            <li class="breadcrumb-item">Logs Details</li>
                        </ul>
                        @php $session_data = Session::get('logs_filter_session'); @endphp
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Logs Details</h4>
                        </div>
                    </div>
                </div>
                {{-- <div class="export_icon_css" style="margin-top: -32px;">
                <a href="{{ url('FamilyExport') }}" id="export">
                    <img src="{{ asset('assets\images\excel.png') }}" data-toggle="tooltip" title="Excel Export" data-src="{{ asset('assets\images\excel.png') }}" srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x" alt="Excel Export" title="Excel" class="lzy lazyload--done" style="height: 35px;">
                </a>
            </div>
            <div class="export_pdf_css" style="margin-top: -32px;  !important;">
                <a href="{{ URL::to('/familyPDF') }}">
                    <img src="{{ asset('assets\images\pdf.png') }}" data-toggle="tooltip" title="PDF Download" alt="PDF Download" title="PDF Download" class="lzy lazyload--done" style="height: 35px;">
                </a>
            </div> --}}

            </div>
        </div>

        <div class="page-body">
            
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">
                            <form class="container" method="GET" action="#" id="needs-validation" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">Country</label>
                                        <select class="form-control" name="country" id="country">
                                            <option value="">--Select--</option>

                                            @foreach($countries as $row)
                                            <option value="{{ $row->id }}" {{((empty($session_data["country"]) || $session_data["country"]) && ($row->id == 101) ? "selected" : "")}}>{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">State</label>
                                        <select class="form-control" name="state" id="state">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">District</label>
                                        <select class="form-control" name="district" id="district">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">User Type</label>
                                        <select class="form-control" name="group" id="group">
                                            <option value="">--Select--</option>
                                                <option value="CEO">CEO</option>
                                                <option value="A">Admin</option>
                                                <option value="QA">Quality</option>
                                                <option value="M">Manager</option>
                                                <option value="F">Facilitator</option>
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-4 mb-4">
                                        <label for="validationCustom02">Name</label>
                                        <input type="text" name="federation" id="federation" class="form-control"
                                            value="">

                                        <div id="fedlist"
                                            style="position:absolute;top:0px; margin-top:21px;max-height:50px"></div>
                                    </div> --}}

                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">&nbsp;</label>
                                        <input type="submit" class="btn btn-sm btn-success" name="Search" value="Search" style="float:left;margin-top: 2.5em;">
                                        <button class="btn  btn-sm btn-danger" name="clear" value="clear" style="float: left;;margin-top:2.5em;margin-left: 10px;">Clear</button>

                                    </div>

                                    {{--<div class="col-md-3 mb-3">
                                        <div class="export_icon_css" style="margin-left:-50px;margin-top:50px;">
                                            <a href="{{url('export_credit')}}" id="export">
                                    <img src="{{ asset('assets\images\excel.png') }}" data-toggle="tooltip" title="Excel Export" data-src="{{ asset('assets\images\excel.png') }}" srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x" alt="Excel Export" title="Excel" class="lzy lazyload--done" style="height: 35px;">
                                    </a>
                                </div>
                        </div>--}}
                    </div>
                    </form>

                    @include('common.error')

                </div>
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                @include('common.error')
                                <table id="simpletable" class="table table-striped table-bordered nowrap"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>User Type</th>
                                            <th>User IP</th>
                                            <th>Country</th>
                                            <th>State</th>
                                            <th>District</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Activity</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px;">
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
                "bFilter": false,
                "bLengthChange": false,
                "ordering": false,
                "iDisplayLength": 30,
                "responsive": false,
                "ajax": {
                    "url": '{{ route('logs.index') }}',
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
        function get_state_list() {
        var obj = $(this);
        var country = obj.val();
        if (country > 0) {
            $.ajax({
                type: 'GET',
                url: '/get_state',
                data: '_token = <?php echo csrf_token() ?>&country=' + country,

                success: function(data) {
                    if (data != '') {
                        $('#state').html(data);
                        @php echo!empty($session_data["state"])  ? "$('#state').val('".$session_data["state"].
                        "');": ""
                        @endphp
                        $('#state').trigger("change");

                    }
                }
            });
        }
    }

    function get_district_list() {
        var obj = $(this);
        var state = obj.val();
        if (state > 0) {
            $.ajax({
                type: 'GET',
                url: '/get_district',
                data: '_token = <?php echo csrf_token() ?>&state=' + state,

                success: function(data) {
                    if (data != '') {
                        $('#district').html(data);
                        @php echo!empty($session_data["district"])  ? "$('#district').val('".$session_data["district"].
                        "');": ""
                        @endphp
                        $('#district').trigger("change");
                    }
                }
            });
        }
    }
    $(document).ready(function() {
        $('#country').on('change', get_state_list);
                $('#state').on('change', get_district_list);
                $('#country').trigger('change');
                @php echo !empty($session_data["group"])>0 ? "$('#group').val('".$session_data["group"]."');" : "" @endphp
                @php echo !empty($session_data["country"])  ? "$('#country').val('".$session_data["country"]."');$('#country').trigger('change');" : "" @endphp
                
    })
       
    </script>
@endsection
<!-- data-table js -->
