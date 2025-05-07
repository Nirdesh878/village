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
                            <li class="breadcrumb-item">Family Wealth Ranking Report </li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Family Wealth Ranking Report </h4>

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
                                <form class="container" method="GET" action="{{ url('FamilyWealthReport') }}"
                                    id="needs-validation" autocomplete="off">
                                    @csrf
                                    <div class="row">
                                        @php $session_data = Session::get('fam_filter_session'); @endphp

                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom02">Country</label>
                                            <select class="form-control" name="country" id="country">
                                                <option value="">--Select--</option>
                                                @foreach ($countries as $row)
                                                    <option value="{{ $row->id }}"
                                                        {{ (empty($session_data['country']) || $session_data['country']) && $row->id == 101 ? 'selected' : '' }}>
                                                        {{ $row->name }}</option>
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
                                            <label for="validationCustom02">Group Type</label>
                                            <select class="form-control" name="group" id="group">
                                                <option value="">--Select--</option>
                                                <option value="AG">Agency</option>
                                                <option value="FM">Family</option>
                                                <option value="SH">SHG</option>
                                                <option value="CL">Cluster</option>
                                                <option value="FD">Federation</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom02">Name</label>
                                            <input type="text" name="federation" id="federation" class="form-control">
                                            <div id="fedlist"
                                                style="position:absolute;top:0px; margin-top:21px;max-height:50px"></div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom02">Date</label>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="text" value="" name="dt_from"
                                                        class="form-control datepicker" placeholder="From" id="dt_from">

                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" value="" name="dt_to" class="form-control datepicker"
                                                        placeholder="To" id="dt_to">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom02">&nbsp;</label>
                                            <input type="submit" class="btn btn-sm btn-success" name="Search" value="Search"
                                                style="float:left;margin-top: 2.5em;">
                                            <button class="btn  btn-sm btn-danger" name="clear" value="clear"
                                                style="float: left;;margin-top:2.5em;margin-left: 10px;">Clear</button>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="export_icon_css" style="top: 32%">
                                                <a href="{{ url('export_family') }}" id="export">
                                                    <img src="{{ asset('assets\images\excel.png') }}"
                                                        data-toggle="tooltip" title="Excel Export"
                                                        data-src="{{ asset('assets\images\excel.png') }}"
                                                        
                                                        alt="Excel Export" title="Excel" class="lzy lazyload--done"
                                                        style="height: 35px;">
                                                </a>
                                            </div>
                                            <div class="export_pdf_css" style="top: 32%;right: 0% !important;">
                                                <a href="{{ URL::to('/wealth-report-pdf') }}"><img
                                                        src="{{ asset('assets\images\pdf.png') }}" data-toggle="tooltip"
                                                        title="PDF Download" alt="PDF Download" title="PDF Download"
                                                        class="lzy lazyload--done" style="height: 35px;"></a>
                                            </div>
                                        </div>

                                    </div>
                                </form>

                                <table class="table  mytable table-bordered"
                                    style="font-size: 15px;font-weight: bold;text-align:center;">
                                    <thead class="back-color">
                                        <tr class="table-height">
                                            <th width="20%" style="text-align: center;">Wealth Ranking</th>
                                            <th width="15%" style="text-align: center;">Total</th>
                                            <th colspan="4" style="text-align: center;">Rating</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table-height">
                                            <td>Very poor</td>
                                            <td>{{ $vpoor[0]->total }}</td>
                                            <td class="green">{{ $vpoor[0]->Rich }}</td>
                                            <td class="yellow">{{ $vpoor[0]->MPoor }}</td>
                                            <td class="grey">{{ $vpoor[0]->Poor }}</td>
                                            <td class="red_status">{{ $vpoor[0]->VPoor }}</td>
                                        </tr>
                                        <tr class="table-height">
                                            <td>Poor</td>
                                            <td>{{ $poor[0]->total }}</td>
                                            <td class="green">{{ $poor[0]->Rich }}</td>
                                            <td class="yellow">{{ $poor[0]->MPoor }}</td>
                                            <td class="grey">{{ $poor[0]->Poor }}</td>
                                            <td class="red_status">{{ $poor[0]->VPoor }}</td>
                                        </tr>
                                        <tr class="table-height">
                                            <td>Medium Poor</td>
                                            <td>{{ $mediumpoor[0]->total }}</td>
                                            <td class="green">{{ $mediumpoor[0]->Rich }}</td>
                                            <td class="yellow">{{ $mediumpoor[0]->MPoor }}</td>
                                            <td class="grey">{{ $mediumpoor[0]->Poor }}</td>
                                            <td class="red_status">{{ $mediumpoor[0]->VPoor }}</td>
                                        </tr>
                                        <tr class="table-height">
                                            <td>Rich</td>
                                            <td>{{ $medium_rich[0]->total }}</td>
                                            <td class="green">{{ $medium_rich[0]->Rich }}</td>
                                            <td class="yellow">{{ $medium_rich[0]->MPoor }}</td>
                                            <td class="grey">{{ $medium_rich[0]->Poor }}</td>
                                            <td class="red_status">{{ $medium_rich[0]->VPoor }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if (!empty($session_data['country']))
                                    <table class="table table-striped table-bordered"
                                        style="margin-bottom: 0rem; !important;">
                                        <thead>
                                            <th>Country : {{ getCountryByID($session_data['country']) }}</th>
                                        </thead>
                                    </table>
                                @else
                                    <table class="table table-striped table-bordered"
                                        style="margin-bottom: 0rem; !important;">
                                        <thead>
                                            <th>Country : India</th>
                                        </thead>
                                    </table>
                                @endif
                                <div class="dt-responsive table-responsive">
                                    @include('common.error')
                                    <table id="simpletable" class="table table-striped table-bordered nowrap"
                                        style="width: 100% !important;">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th width="15%">UIN</th>
                                                @if (!empty($session_data))
                                                    @if (!empty($session_data['group']) && !empty($session_data['federation'])) 
                                                        @if ($session_data['group'] == "FM" )
                                                            <th width="10%">Husband's name</th>
                                                            <th width="15%">Adhar Card No</th>
                                                            <th width="10%">SHG Name</th>
                                                            <th width="10%">Cluster Name</th>
                                                            <th width="10%">Federation Name</th>
                                                            <th width="10%">Agency Name</th>
                                                        @elseif ($session_data['group'] == "AG" )
                                                            <th width="10%">SHG Member Name</th>
                                                            <th width="10%">Husband's name</th>
                                                            <th width="15%">Adhar Card No</th>
                                                            <th width="10%">SHG Name</th>
                                                            <th width="10%">Cluster Name</th>
                                                            <th width="10%">Federation Name</th>
                                                        @elseif ($session_data['group'] == "FD" )
                                                            <th width="10%">SHG Member Name</th>
                                                            <th width="10%">Husband's name</th>
                                                            <th width="15%">Adhar Card No</th>
                                                            <th width="10%">SHG Name</th>
                                                            <th width="10%">Cluster Name</th>
                                                            <th width="10%">Agency Name</th>
                                                        @elseif ($session_data['group'] == "CL" )
                                                            <th width="10%">SHG Member Name</th>
                                                            <th width="10%">Husband's name</th>
                                                            <th width="15%">Adhar Card No</th>
                                                            <th width="10%">SHG Name</th>
                                                            <th width="10%">Federation Name</th>
                                                            <th width="10%">Agency Name</th>
                                                        @elseif ($session_data['group'] == "SH" )
                                                            <th width="10%">SHG Member Name</th>
                                                            <th width="10%">Husband's name</th>
                                                            <th width="15%">Adhar Card No</th>
                                                            <th width="10%">Cluster Name</th>
                                                            <th width="10%">Federation Name</th>
                                                            <th width="10%">Agency Name</th>
                                                        @endif
                                                      
                                                    @elseif(!empty($session_data['group']) && empty($session_data['federation']))
                                                        @if ($session_data['group'] == "FM" )
                                                            <th width="10%">SHG Member name</th>
                                                            <th width="10%">Husband's name</th>
                                                            <th width="15%">Adhar Card No</th>
                                                            <th width="10%">SHG Name</th>
                                                            <th width="10%">Cluster Name</th>
                                                            <th width="10%">Federation Name</th>
                                                            <th width="10%">Agency Name</th>
                                                        @elseif ($session_data['group'] == "AG" )
                                                            <th width="10%">SHG Member name</th>
                                                            <th width="10%">Husband's name</th>
                                                            <th width="15%">Adhar Card No</th>
                                                            <th width="10%">SHG Name</th>
                                                            <th width="10%">Cluster Name</th>
                                                            <th width="10%">Federation Name</th>
                                                            <th width="10%">Agency Name</th>
                                                        @elseif ($session_data['group'] == "FD" )
                                                            <th width="10%">SHG Member name</th>
                                                            <th width="10%">Husband's name</th>
                                                            <th width="15%">Adhar Card No</th>
                                                            <th width="10%">SHG Name</th>
                                                            <th width="10%">Cluster Name</th>
                                                            <th width="10%">Federation Name</th>
                                                            <th width="10%">Agency Name</th>
                                                        @elseif ($session_data['group'] == "CL" )
                                                            <th width="10%">SHG Member name</th>
                                                            <th width="10%">Husband's name</th>
                                                            <th width="15%">Adhar Card No</th>
                                                            <th width="10%">SHG Name</th>
                                                            <th width="10%">Cluster Name</th>
                                                            <th width="10%">Federation Name</th>
                                                            <th width="10%">Agency Name</th>
                                                        @elseif ($session_data['group'] == "SH" )
                                                            <th width="10%">SHG Member name</th>
                                                            <th width="10%">Husband's name</th>
                                                            <th width="15%">Adhar Card No</th>
                                                            <th width="10%">SHG Name</th>
                                                            <th width="10%">Cluster Name</th>
                                                            <th width="10%">Federation Name</th>
                                                            <th width="10%">Agency Name</th>
                                                        @endif    
                                                    @elseif(empty($session_data['group']) && empty($session_data['federation']))
                                                           <th width="10%">SHG Member name</th>
                                                            <th width="10%">Husband's name</th>
                                                            <th width="15%">Adhar Card No</th>
                                                            <th width="10%">SHG Name</th>
                                                            <th width="10%">Cluster Name</th>
                                                            <th width="10%">Federation Name</th>
                                                            <th width="10%">Agency Name</th>
                                                    @endif    
                                                        @if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                                                            <th width="10%">District</th>
                                                            <th width="10%">State</th>
                                                        @elseif (!empty($session_data['country']) &&
                                                            !empty($session_data['state']) &&
                                                            empty($session_data['district']))
                                                            <th width="10%">District</th>
                                                        @endif
                                                @else
                                                        <th width="10%">SHG Member Name</th>
                                                        <th width="10%">Husband's name</th>
                                                        <th width="15%">Adhar Card No</th>
                                                        <th width="10%">SHG Name</th>
                                                        <th width="10%">Cluster Name</th>
                                                        <th width="10%">Federation Name</th>
                                                        <th width="10%">Agency Name</th>
                                                        <th width="10%">District</th>
                                                        <th width="10%">State</th>
                                                @endif
                                                <th width="10%">Wealth Rank</th>
                                                <th width="10%">Score</th>
                                                <th width="10%">Color</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
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
            $(document).on('click', function(e) {
                if ($(e.target).closest("#fedlist").length === 0) {
                    $("#fedlist").hide();
                }
            });
            $(function() {
                var table = $('#simpletable').DataTable({
                    "sDom": "rtipl",
                    "processing": true,
                    "serverSide": true, //Feature control DataTables' servermside processing mode.
                    "bFilter": true,
                    "bLengthChange": false,
                    "ordering": false,
                    "iDisplayLength": 10,
                    "responsive": false,
                    "ajax": {
                        "url": '{{ route('FamilyWealthReport.index') }}',
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

            function get_state_list() {
                var obj = $(this);
                var country = obj.val();
                if (country > 0) {
                    $.ajax({
                        type: 'GET',
                        url: '/get_state',
                        data: '_token = <?php echo csrf_token(); ?>&country=' + country,

                        success: function(data) {
                            if (data != '') {
                                $('#state').html(data);
                                @php echo !empty($session_data['state']) && $session_data['state'] > 0 ? "$('#state').val('" . $session_data['state'] . "');" : '';
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
                        data: '_token = <?php echo csrf_token(); ?>&state=' + state,

                        success: function(data) {
                            if (data != '') {
                                $('#district').html(data);
                                @php echo !empty($session_data['district']) && $session_data['district'] > 0 ? "$('#district').val('" . $session_data['district'] . "');" : '';
                                @endphp
                                $('#district').trigger("change");
                            }
                        }
                    });
                }
            }

            function get_fed_suggestion() {
                var query = $(this).val();
                var group = $('#group').val();
                var country = $('#country').val();
                var state = $('#state').val();
                var district = $('#district').val();

                if (query != '') {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        type: 'get',
                        url: '/get_fed_suggestion',
                        data: {
                            query: query,
                            _token: _token,
                            country: country,
                            state: state,
                            district: district,
                            group: group
                        },
                        success: function(data) {
                            $('#fedlist').fadeIn();
                            $('#fedlist').html(data);
                            @php echo !empty($session_data["federation"]) && $session_data["federation"]>0 ? "$('#federation').val('".$session_data["federation"]."');" : "" @endphp
                            $('#federation').trigger("change");
                        }
                    });
                }


            }
            $(document).on('click', 'li', function() {
                var cls = $(this).find('a').attr('class');
                if (cls != 'norecord') {
                    $('#federation').val($(this).text());
                    $('#fedlist').fadeOut();
                }

            });
            $(document).ready(function() {
               
                var today = new Date();
                var tomorrow = new Date();
                tomorrow.setDate(today.getDate() - 1);

                $('#country').on('change', get_state_list);
                $('#state').on('change', get_district_list);
                $('#country').trigger('change');
                @php echo !empty($session_data["group"])>0 ? "$('#group').val('".$session_data["group"]."');" : "" @endphp
                @php echo !empty($session_data['country']) && $session_data['country'] > 0 ? "$('#country').val('" . $session_data['country'] . "');$('#country').trigger('change');" : '';
                @endphp
                $('#federation').on('keyup', get_fed_suggestion);
                @php echo !empty($session_data['federation']) ? "$('#federation').val('" . $session_data['federation'] . "');" : '';
                @endphp
                @php echo !empty($session_data['dt_from']) && $session_data['dt_from'] > 0 ? "$('#dt_from').val('" . $session_data['dt_from'] . "');" : '';
                @endphp
                @php echo !empty($session_data['dt_to']) && $session_data['dt_to'] > 0 ? "$('#dt_to').val('" . $session_data['dt_to'] . "');" : '';
                @endphp
                {{-- $('#federation').val('{{$session_data["federation"]}}'); --}}


                $('.datepicker').datepicker({
                    format: 'dd/mm/yyyy',
                    autoclose: true,
                    endDate: tomorrow,
                    enableOnReadonly: false
                });
            });
           
        </script>

    @endsection
    <!-- data-table js -->
