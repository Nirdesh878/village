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
                            <li class="breadcrumb-item">MAP</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @php $session_data = Session::get('app_label_filters'); @endphp
        <div class="page-body" style="margin-top: 10px">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">
                            <form class="container" method="GET" action="{{ url('applabel') }}" id="needs-validation"
                                autocomplete="off">
                                @csrf
                                <div class="row">

                                    {{-- <div class="col-md-2 mb-3">
                                        <label for="validationCustom02">Language</label>
                                        <select class="form-control" name="language_id" id="language_id">
                                            <option value="">--Select--</option>
                                            @foreach ($language as $res)
                                                <option value="{{ $res->language_id }}">{{ $res->language_name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-md-2 mb-3">
                                        <label for="validationCustom02">Modules</label>
                                        <select class="form-control" name="module_id" id="module_id">
                                            <option value="">--Select--</option>
                                            @foreach ($module as $res)
                                                <option value="{{ $res->module_id }} " {{ (!empty($session_data['module_id']) && $session_data['module_id'] == $res->module_id) ? 'selected' : '' }}>{{ $res->module_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="validationCustom02">Section</label>
                                        <select class="form-control" name="section_id" id="section_id">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="validationCustom02">Sub Section</label>
                                        <select class="form-control" name="sub_section_id" id="sub_section_id">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="validationCustom02">App labels</label>

                                        <select class="form-control" name="app_label_id" id="app_label_id">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="validationCustom02">&nbsp;</label>
                                        <input type="submit" class="btn btn-sm btn-success" name="Search" value="Search"
                                            style="float:left;margin-top: 2.5em;">
                                        <button class="btn  btn-sm btn-danger" name="clear" value="clear"
                                            style="float: left;;margin-top:2.5em;margin-left: 10px;">Clear</button>

                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                @include('common.error')
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th width="5%">S.No</th>
                                            <!-- <th>Language</th> -->
                                            <th>Module</th>
                                            <th>Section</th>
                                            <th>Sub Section</th>
                                            <th>App Labels</th>
                                            <th>Action</th>
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
                    "url": '{{ route('applabel.index') }}',
                    "type": "GET",
                    "dataType": "json",
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

        $(document).ready(function() {
            var lang = $('#language_id').val();
            $('#language_id').on('change', get_mst_module);
            $('#module_id').on('change', get_mst_section);
            $('#module_id').trigger("change");
            $('#section_id').on('change', get_mst_sub_section);
            $('#section_id').on('change', get_mst_app_label);
            $('#sub_section_id').on('change', get_mst_app_label);
            $('#language_id').on('change', function() {
                var obj = $(this);
                var language_id = obj.val();
                if (language_id != 1) {
                    $('#sub_section_id').css('pointer-event', 'none');
                    $('#sub_section_id').css('opacity', 0.5);
                } else {
                    $('#sub_section_id').css('pointer-event', 'auto');
                    $('#sub_section_id').css('opacity', 1);
                }

            });
        });

        function get_mst_module() {
            var obj = $(this);
            var lang_id = obj.val();
            //alert(lang_id);
            if (lang_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_mst_module',
                    data: '_token = <?php echo csrf_token(); ?>&lang_id=' + lang_id,
                    success: function(data) {
                        if (data != '') {
                            $('#module_id').html(data);
                        }
                    }
                });
            }
        }

        function get_mst_section() {
            var obj = $(this);
            var module_id = obj.val();
            var lang_id = 1;
            if (module_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_mst_section',
                    data: '_token = <?php echo csrf_token(); ?>&module_id=' + module_id + '&lang_id=' + lang_id,
                    success: function(data) {
                        if (data != '') {
                            $('#section_id').html(data);
                            @php echo !empty($session_data["section_id"]) && $session_data["section_id"]>0 ? "$('#section_id').val('".$session_data["section_id"]."');" : "" @endphp
                            $('#section_id').trigger("change");
                        }
                    }
                });
            }
        }

        function get_mst_sub_section() {
            var obj = $(this);
            var section_id = obj.val();
            var lang_id = 1;
            var module_id = $('#module_id').val();
            if (module_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_mst_sub_section',
                    data: '_token = <?php echo csrf_token(); ?>&module_id=' + module_id + '&lang_id=' + lang_id +
                        '&section_id=' + section_id,
                    success: function(data) {
                        if (data != '') {
                            $('#sub_section_id').html(data);
                            @php echo !empty($session_data["sub_section_id"]) && $session_data["sub_section_id"]>0 ? "$('#sub_section_id').val('".$session_data["sub_section_id"]."');" : "" @endphp
                            $('#sub_section_id').trigger("change");
                        }
                    }
                });
            }
        }

        function get_mst_app_label() {
            var obj = $(this);
            var sub_section_id = obj.val();
            var lang_id = 1;
            var module_id = $('#module_id').val();
            var section_id = $('#section_id').val();
            if (module_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_mst_app_label',
                    data: '_token = <?php echo csrf_token(); ?>&module_id=' + module_id + '&lang_id=' + lang_id +
                        '&section_id=' + section_id + '&sub_section_id=' + sub_section_id,
                    success: function(data) {
                        if (data != '') {
                            $('#app_label_id').html(data);
                            @php echo !empty($session_data["app_label_id"]) && $session_data["app_label_id"]>0 ? "$('#app_label_id').val('".$session_data["app_label_id"]."');" : "" @endphp

                        }
                    }
                });
            }
        }
    </script>
@endsection

