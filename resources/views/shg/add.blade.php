@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                            <li class="breadcrumb-item">Add Cluster</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Add SHG</h4>
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
                            <div class="mT-30">
                                <div class="row">
                                    <div class="col-md-5 mb-3" id="table" style="margin-top: -6px;">
                                        <table id="simpletable" class="table table-striped table-bordered nowrap"
                                            style="width: 100%;font-size:14px;">
                                            <thead>
                                                <tr>
                                                    <th width="5%">S.No</th>
                                                    <th width="30%">SHG</th>
                                                    <th width="30%">UIN</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-5 mb-3" id="table1" style="margin-top: -6px;">
                                        <table id="simpletable1" class="table table-striped table-bordered"
                                            style="width:100%" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th width="5%">S.No</th>
                                                    <th width="30%">SHG</th>
                                                    <th width="30%">UIN</th>

                                                </tr>
                                            </thead>

                                            <tbody style="font-size:14px;">
                                            </tbody>
                                        </table>
                                    </div>


                                    <div class="col-md-7 mb-3">
                                        <fieldset>
                                            @include('common.error')
                                            <form class="" method="POST" action="{{ route('shg.store') }}"
                                                autocomplete="off">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-3 mb-3">
                                                        <label for="validationCustom02">Agency<span
                                                                class="red">*</span></label>
                                                        <select class="form-control " name="agency_id" id="agency_id"
                                                            required>
                                                            <option value="">--Select--</option>
                                                            @foreach ($agency as $row)
                                                                <option value="{{ $row->agency_id }}">
                                                                    {{ $row->agency_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="validationCustom02">Country<span
                                                                class="red">*</span></label>
                                                        <select class="form-control " name="country" id="country"
                                                            required>
                                                            <option value="">--Select--</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="validationCustom02">State<span
                                                                class="red">*</span></label>
                                                        <select class="form-control " name="state" id="state"
                                                            required>
                                                            <option value="">--Select--</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label for="validationCustom02">District</span></label>
                                                        <select class="form-control " name="district" id="district"
                                                            required>
                                                            <option value="">--Select--</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="validationCustom02">Federation<span
                                                                class="red">*</span></label>
                                                        <select class="form-control " name="federation_id"
                                                            id="federation_id" required>
                                                            <option value="">--Select--</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label for="validationCustom02">Cluster</label>
                                                        <select class="form-control " name="cluster_uin" id="cluster_uin">
                                                            <option value="">--Select--</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <a class="btn btn-sm btn-success mt-4" style="color: white;"
                                                            id="search" value="search">Search</a>
                                                    </div>
                                                </div>
                                                <table id="shg_table" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>SHG Name</th>
                                                            <th>Name of Village</th>
                                                            <th>SHG Formed</th>
                                                            <th>NRLM</th>
                                                            <th width="200px">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control shgName "
                                                                    name="shgName[]" style="min-width: 120px;" required>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control village"
                                                                    name="village[]" style="min-width: 120px;" required>
                                                            </td>
                                                            <td>
                                                                <input type="text" title="Enter in dd/mm/yyyy format"
                                                                    class="form-control formed" name="formed[]"
                                                                    style="min-width: 120px;" required>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control nrlm_code"
                                                                    name="nrlm_code[]" style="min-width: 120px;" required>
                                                            </td>

                                                            <td>
                                                                <button class="btn btn-sm cur-p btn-primary add_faci"
                                                                    type="button" onclick="add_location(this);"><i
                                                                        class="c-white-500 ti-plus"></i></button>
                                                                <button class="btn btn-sm cur-p btn-danger" type="button"
                                                                    onclick="delete_location(this);"><i
                                                                        class="c-white-500 ti-minus"></i>
                                                                </button>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                                <div class="row">
                                                    <div class="col-md-12 mb-3 text-center">
                                                        <button class="btn btn-sm btn-success mt-4"
                                                            type="submit">Save</button>
                                                        <a href="{{ url('shg') }}"
                                                            class="btn btn-sm btn-danger mt-4">Back</a>
                                                    </div>
                                                </div>

                                            </form>
                                        </fieldset>
                                    </div>

                                </div>

                            </div>


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
        var Table = null;
        $(function() {
            var table = $('#simpletable').DataTable({
                "processing": true,
                "serverSide": true, //Feature control DataTables' servermside processing mode.
                "bFilter": false,
                "bLengthChange": false,
                "ordering": false,
                "iDisplayLength": 10,
                "responsive": false,
                "ajax": {
                    "url": '/shg_table',
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
            Table = $("#simpletable1").DataTable({
                "bPaginate": true,
                "sPaginationType": "full_numbers",
                "bLengthChange": false,
                "iDisplayLength": 10,
                data: [],
                rowCallback: function(row, data) {},
                columns: [{
                        "data": "sn"
                    },
                    {
                        "data": "shg_name"
                    },
                    {
                        "data": "uin"
                    },

                ],
                filter: false,
                info: false,
                ordering: false,
                processing: true,
                retrieve: true
            });
        });
        var today = new Date();
        var tomorrow = new Date();
        tomorrow.setDate(today.getDate() - 1);

        $(document).ready(function() {

            $('#table1').hide();
            $('#agency_id').on('change', get_agency_demography);
            $('#agency_id').on('change', get_federation_list);
            $('#federation_id').on('change', get_cluster_list, );

            $('.formed').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                endDate: tomorrow,
                enableOnReadonly: false
            });
            $('.formed').keypress(function(event) {
                event.preventDefault();
                return false;
            });

            $('#country,#state').attr("readonly", "readonly");
            $("#country,#state").css("pointer-events", "none");
            $('#search').on('click', function() {
                $('#table').hide();
                $('#table1').show();

                var agency_id = $('#agency_id').val();
                var country = $('#country').val();
                var state = $('#state').val();
                var district = $('#district').val();
                var federation_id = $('#federation_id').val();
                var cluster_id = $('#cluster_uin').val();



                $.ajax({

                    url: '/shg_table_two',
                    type: 'GET',
                    data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id + '&country=' +
                        country +
                        '&state=' + state +
                        '&district=' + district + '&federation_id=' + federation_id +
                        '&cluster_id=' + cluster_id,


                    //data:'_token = <?php echo csrf_token(); ?>&id=' + id ,\

                    success: function(response) {
                        console.log(response);
                        if (response != '') {
                            var result = JSON.parse(response);
                            //$('#simpletable1').html(response);
                            Table.clear().draw();
                            Table.rows.add(result).draw();

                        }
                    }
                });
            });
        });


        function get_federation_list() {
            var obj = $(this);
            var agency_id = obj.val();
            if (agency_id > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_federation_list',
                    data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
                    success: function(data) {
                        if (data != '') {
                            $('#federation_id').html(data);
                            $('#federation_id').trigger("change");
                        }
                    }
                });
            }
        }

        function get_cluster_list() {
            var obj = $(this);
            var federation_id = obj.val();
            if (federation_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_cluster_list',
                    data: '_token = <?php echo csrf_token(); ?>&federation_id=' + federation_id,
                    success: function(data) {
                        if (data != '') {
                            $('#cluster_uin').html(data);
                            $('#cluster_uin').trigger("change");
                        }
                    }
                });
            }
        }

        function get_agency_demography() {
            var obj = $(this);
            var agency_id = obj.val();
            //alert(agency_id);
            if (agency_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_agency_demography',
                    data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
                    success: function(data) {
                        if (data != '') {
                            $('#country').html(data.country_option);
                            $('#state').html(data.state_option);
                            $('#district').html(data.district_option);
                        }
                    }
                });
            }
        }
        var location_counter = 1;

        function add_location(elem) {
            var cloned = $(elem).parents('tbody').clone();
            var len = $(".add_faci").length;
            // alert(len);
            $(cloned).find('.shgName').attr('name', 'shgName[]').val('');
            $(cloned).find('.village').attr('name', 'village[]').val('');
            $(cloned).find('.nrlm_code').attr('name', 'nrlm_code[]').val('');
            $(cloned).find('.formed').attr('name', 'formed[]').val('').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                endDate: tomorrow,
                enableOnReadonly: false
            });
            $(cloned).find('.select2-container').remove();
            $(cloned).appendTo('#shg_table');
            location_counter++;
            $('.formed').keypress(function(event) {
                event.preventDefault();
                return false;
            });


        }

        function delete_location(elem) {
            if ($('#shg_table tbody tr').length > 1)
                $(elem).parents('tr').remove();
        }

        (function($) {
            $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    }
                });
            };
        }(jQuery));
        $(".phone").inputFilter(function(value) {
            return /^-?\d*[.,]?\d{0,2}$/.test(value) && (value === "" || parseInt(value) <= 999999999999);
        });

        $('body').on('focusout', '.nrlm_code', function(e) {
            var inputValue = $(this).val();
            var index1 = $(this).index('.nrlm_code');
            var obj = $(this);
            var nrlm_code = obj.val();
            var flg = 0;

            $('.nrlm_code').each(function(index) {
                if ($(this).val() == nrlm_code && (index != index1)) {
                    flg = 1;
                    return false;
                }
            });
            if (flg == 1) {
                bootbox.alert('<h3>Duplicate Entry</h3>');

                obj.val('');
            } else {

                $.ajax({
                    type: 'GET',
                    url: '/check_shg_nrlm_code',
                    data: '_token = <?php echo csrf_token(); ?>&inputValue=' + inputValue,
                    success: function(data) {
                        if (data != '') {
                            if (data == 1) {
                                alert("Shg is already Exist");
                                $('.nrlm_code').eq(index1).val('');

                            }

                        }
                    }
                });
            }

        });
    </script>
@endsection
