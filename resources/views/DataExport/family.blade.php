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
                            <li class="breadcrumb-item">Family Export</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Family Export</h4>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        @php         $session_data = Session::get('family_export_session');      @endphp
        <div class="page-body">

            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">
                            <form class="container" method="GET" action="{{ url('family_export_filter') }}"
                                id="needs-validation" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">Agency<span
                                                class="red">*</span></label>
                                        <select class="form-control " name="agency" id="agency"
                                            required>
                                            <option value="">--Select--</option>
                                            @foreach ($agency as $row)
                                                <option value="{{ $row->agency_id }}">
                                                    {{ $row->agency_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">Federation</label>
                                        <select class="form-control" name="federation" id="federation">
                                            <option value="">--Select--</option>
                                            @foreach ($federation as $row)
                                                <option value="{{ $row->uin }}"
                                                    {{ !empty($session_data['federation']) && $session_data['federation'] == $row->uin ? 'selected' : '' }}>
                                                    {{ $row->name_of_federation }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">Federation</label>
                                        <select class="form-control" name="federation" id="federation">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">Cluster</label>
                                        <select class="form-control" name="cluster" id="cluster">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">SHG</label>
                                        <select class="form-control" name="shg" id="shg">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">Family</label>
                                        <select class="form-control" name="family" id="family">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>


                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">&nbsp;</label>
                                        <input type="submit" class="btn btn-sm btn-success" name="Search" value="Search"
                                            style="float:left;margin-top: 2.5em;">
                                        <button class="btn  btn-sm btn-danger" name="clear" value="clear"
                                            style="float: left;;margin-top:2.5em;margin-left: 10px;">Clear</button>

                                    </div>

                                    {{-- <div class="col-md-3 mb-3">
                                        <div class="export_icon_css" style="margin-left:-50px;margin-top:50px;">
                                            <a href="{{ url('export_credit') }}" id="export">
                                                <img src="{{ asset('assets\images\excel.png') }}" data-toggle="tooltip"
                                                    title="Excel Export" data-src="{{ asset('assets\images\excel.png') }}"
                                                    srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                    alt="Excel Export" title="Excel" class="lzy lazyload--done"
                                                    style="height: 35px;">
                                            </a>
                                        </div>
                                    </div> --}}
                                </div>
                            </form>

                            @include('common.error')

                        </div>
                        @if (!empty($session_data))
                            <div class="card-block">
                                <div class="col-md-12 ">
                                    <div class="row ">
                                        <div class="col-xl-4 col-lg-6">
                                            <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                <div class="card-statistic-3 p-4">
                                                    <div class="mb-4">
                                                        <h5 class="card-title mb-0">Families Basic Profile</h5>
                                                    </div>
                                                    <div class="row align-items-center mb-2 d-flex">
                                                        <div class="col-8">
                                                            <a href="{{ url('Family_basic_profile') }}" id="export">
                                                                <img src="{{ asset('assets\images\excel.png') }}"
                                                                    data-toggle="tooltip" title="Excel Export"
                                                                    data-src="{{ asset('assets\images\excel.png') }}"
                                                                    srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                    alt="Excel Export" title="Excel"
                                                                    class="lzy lazyload--done" style="height: 35px;">
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                                <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                    <div class="card-statistic-3 p-4">
                                                        <div class="mb-4">
                                                            <h5 class="card-title mb-0">Families Assests</h5>
                                                        </div>
                                                        <div class="row align-items-center mb-2 d-flex">
                                                            <div class="col-8">
                                                                <a href="{{ url('Family_assests') }}" id="export">
                                                                    <img src="{{ asset('assets\images\excel.png') }}"
                                                                        data-toggle="tooltip" title="Excel Export"
                                                                        data-src="{{ asset('assets\images\excel.png') }}"
                                                                        srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                        alt="Excel Export" title="Excel"
                                                                        class="lzy lazyload--done" style="height: 35px;">
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                                <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                    <div class="card-statistic-3 p-4">
                                                        <div class="mb-4">
                                                            <h5 class="card-title mb-0">Families Goals</h5>
                                                        </div>
                                                        <div class="row align-items-center mb-2 d-flex">
                                                            <div class="col-8">
                                                                <a href="{{ url('Family_goals') }}" id="export">
                                                                    <img src="{{ asset('assets\images\excel.png') }}"
                                                                        data-toggle="tooltip" title="Excel Export"
                                                                        data-src="{{ asset('assets\images\excel.png') }}"
                                                                        srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                        alt="Excel Export" title="Excel"
                                                                        class="lzy lazyload--done" style="height: 35px;">
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="card-block">
                                <div class="col-md-12 ">
                                    <div class="row ">
                                        <div class="col-xl-4 col-lg-6">
                                            <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                <div class="card-statistic-3 p-4">
                                                    <div class="mb-4">
                                                        <h5 class="card-title mb-0">Families Agriculture Production (P1)
                                                        </h5>
                                                    </div>
                                                    <div class="row align-items-center mb-2 d-flex">
                                                        <div class="col-8">
                                                            <a href="{{ url('Family_Agriculture') }}" id="export"> 
                                                                <img src="{{ asset('assets\images\excel.png') }}"
                                                                    data-toggle="tooltip" title="Excel Export"
                                                                    data-src="{{ asset('assets\images\excel.png') }}"
                                                                    srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                    alt="Excel Export" title="Excel"
                                                                    class="lzy lazyload--done" style="height: 35px;">
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                                <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                    <div class="card-statistic-3 p-4">
                                                        <div class="mb-4">
                                                            <h5 class="card-title mb-0">Families Horticulture Production
                                                                (P1)</h5>
                                                        </div>
                                                        <div class="row align-items-center mb-2 d-flex">
                                                            <div class="col-8">
                                                                <a href="{{ url('Family_Horticulture') }}" id="export">
                                                                    <img src="{{ asset('assets\images\excel.png') }}"
                                                                        data-toggle="tooltip" title="Excel Export"
                                                                        data-src="{{ asset('assets\images\excel.png') }}"
                                                                        srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                        alt="Excel Export" title="Excel"
                                                                        class="lzy lazyload--done" style="height: 35px;">
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                                <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                    <div class="card-statistic-3 p-4">
                                                        <div class="mb-4">
                                                            <h5 class="card-title mb-0">Families Livestock Production (P1)
                                                            </h5>
                                                        </div>
                                                        <div class="row align-items-center mb-2 d-flex"> 
                                                            <div class="col-8">
                                                                <a href="{{ url('Family_LiveStock') }}" id="export">
                                                                    <img src="{{ asset('assets\images\excel.png') }}"
                                                                        data-toggle="tooltip" title="Excel Export"
                                                                        data-src="{{ asset('assets\images\excel.png') }}"
                                                                        srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                        alt="Excel Export" title="Excel"
                                                                        class="lzy lazyload--done" style="height: 35px;">
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="card-block">
                                <div class="col-md-12 ">
                                    <div class="row ">
                                        <div class="col-xl-4 col-lg-6">
                                            <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                <div class="card-statistic-3 p-4">
                                                    <div class="mb-4">
                                                        <h5 class="card-title mb-0">Families Savings</h5>
                                                    </div>
                                                    <div class="row align-items-center mb-2 d-flex">
                                                        <div class="col-8">
                                                            <a href="{{ url('Family_Savings') }}" id="export">
                                                                <img src="{{ asset('assets\images\excel.png') }}"
                                                                    data-toggle="tooltip" title="Excel Export"
                                                                    data-src="{{ asset('assets\images\excel.png') }}"
                                                                    srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                    alt="Excel Export" title="Excel"
                                                                    class="lzy lazyload--done" style="height: 35px;">
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                                <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                    <div class="card-statistic-3 p-4">
                                                        <div class="mb-4">
                                                            <h5 class="card-title mb-0">Families Loan Outstanding</h5>
                                                        </div>
                                                        <div class="row align-items-center mb-2 d-flex">
                                                            <div class="col-8">
                                                                <a href="{{ url('Family_Loans') }}" id="export">
                                                                    <img src="{{ asset('assets\images\excel.png') }}"
                                                                        data-toggle="tooltip" title="Excel Export"
                                                                        data-src="{{ asset('assets\images\excel.png') }}"
                                                                        srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                        alt="Excel Export" title="Excel"
                                                                        class="lzy lazyload--done" style="height: 35px;">
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                                <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                    <div class="card-statistic-3 p-4">
                                                        <div class="mb-4">
                                                            <h5 class="card-title mb-0">Families Income (P1)</h5>
                                                        </div>
                                                        <div class="row align-items-center mb-2 d-flex">
                                                            <div class="col-8">
                                                                <a href="{{ url('Family_income') }}" id="export">
                                                                    <img src="{{ asset('assets\images\excel.png') }}"
                                                                        data-toggle="tooltip" title="Excel Export"
                                                                        data-src="{{ asset('assets\images\excel.png') }}"
                                                                        srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                        alt="Excel Export" title="Excel"
                                                                        class="lzy lazyload--done" style="height: 35px;">
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="card-block">
                                <div class="col-md-12 ">
                                    <div class="row ">
                                        <div class="col-xl-4 col-lg-6">
                                            <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                <div class="card-statistic-3 p-4">
                                                    <div class="mb-4">
                                                        <h5 class="card-title mb-0">Families Expenditure</h5>
                                                    </div>
                                                    <div class="row align-items-center mb-2 d-flex">
                                                        <div class="col-8">
                                                            <a href="{{ url('Family_Expenditure') }}" id="export">
                                                                <img src="{{ asset('assets\images\excel.png') }}"
                                                                    data-toggle="tooltip" title="Excel Export"
                                                                    data-src="{{ asset('assets\images\excel.png') }}"
                                                                    srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                    alt="Excel Export" title="Excel"
                                                                    class="lzy lazyload--done" style="height: 35px;">
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                                <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                    <div class="card-statistic-3 p-4">
                                                        <div class="mb-4">
                                                            <h5 class="card-title mb-0">Families Challenges</h5>
                                                        </div>
                                                        <div class="row align-items-center mb-2 d-flex">
                                                            <div class="col-8">
                                                                <a href="{{ url('Family_Challenges') }}" id="export">
                                                                    <img src="{{ asset('assets\images\excel.png') }}"
                                                                        data-toggle="tooltip" title="Excel Export"
                                                                        data-src="{{ asset('assets\images\excel.png') }}"
                                                                        srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                        alt="Excel Export" title="Excel"
                                                                        class="lzy lazyload--done" style="height: 35px;">
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                                <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                    <div class="card-statistic-3 p-4">
                                                        <div class="mb-4">
                                                            <h5 class="card-title mb-0">Families Observations</h5>
                                                        </div>
                                                        <div class="row align-items-center mb-2 d-flex">
                                                            <div class="col-8">
                                                                <a href="{{ url('Family_Observation') }}" id="export">
                                                                    <img src="{{ asset('assets\images\excel.png') }}"
                                                                        data-toggle="tooltip" title="Excel Export"
                                                                        data-src="{{ asset('assets\images\excel.png') }}"
                                                                        srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                        alt="Excel Export" title="Excel"
                                                                        class="lzy lazyload--done" style="height: 35px;">
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="card-block">
                                <div class="col-md-12 ">
                                    <div class="row ">
                                        <div class="col-xl-4 col-lg-6">
                                            <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                <div class="card-statistic-3 p-4">
                                                    <div class="mb-4">
                                                        <h5 class="card-title mb-0">Families Analysis</h5>
                                                    </div>
                                                    <div class="row align-items-center mb-2 d-flex">
                                                        <div class="col-8">
                                                            <a href="{{ url('Family_analysis') }}" id="export">
                                                                <img src="{{ asset('assets\images\excel.png') }}"
                                                                    data-toggle="tooltip" title="Excel Export"
                                                                    data-src="{{ asset('assets\images\excel.png') }}"
                                                                    srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                    alt="Excel Export" title="Excel"
                                                                    class="lzy lazyload--done" style="height: 35px;">
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                                <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                    <div class="card-statistic-3 p-4">
                                                        <div class="mb-4">
                                                            <h5 class="card-title mb-0">Families Business Plan</h5>
                                                        </div>
                                                        <div class="row align-items-center mb-2 d-flex">
                                                            <div class="col-8">
                                                                <a href="{{ url('Family_Business') }}" id="export">
                                                                    <img src="{{ asset('assets\images\excel.png') }}"
                                                                        data-toggle="tooltip" title="Excel Export"
                                                                        data-src="{{ asset('assets\images\excel.png') }}"
                                                                        srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                        alt="Excel Export" title="Excel"
                                                                        class="lzy lazyload--done" style="height: 35px;">
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                                <div class="card l-bg-cherry" style="background-color: #f3f3f3">
                                                    <div class="card-statistic-3 p-4">
                                                        <div class="mb-4">
                                                            <h5 class="card-title mb-0">Families SHG member commitment</h5>
                                                        </div>
                                                        <div class="row align-items-center mb-2 d-flex">
                                                            <div class="col-8">
                                                                <a href="{{ url('Family_Commitment') }}" id="export">
                                                                    <img src="{{ asset('assets\images\excel.png') }}"
                                                                        data-toggle="tooltip" title="Excel Export"
                                                                        data-src="{{ asset('assets\images\excel.png') }}"
                                                                        srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                                        alt="Excel Export" title="Excel"
                                                                        class="lzy lazyload--done" style="height: 35px;">
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        @endif

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
                $(document).ready(function() {

                    $('#agency').on('change', get_federation_list);
                    $('#federation').on('change', get_cluster_list);
                    $('#federation').on('change', get_shg_list2);
                    $('#cluster').on('change', get_shg_list);
                    $('#shg').on('change', get_family_lists);
                    @php echo !empty($session_data["agency"]) && $session_data["agency"]>0 ? "$('#agency').val('".$session_data["agency"]."');$('#agency').trigger('change');" : "" @endphp
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
                                    $('#federation').html(data);
                                    @php echo !empty($session_data["federation"]) ? "$('#federation').val('".$session_data["federation"]."');" : "" @endphp 
                                    $('#federation').trigger("change");
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
                                    $('#cluster').html(data);
                                    @php echo !empty($session_data["cluster"]) ? "$('#cluster').val('".$session_data["cluster"]."');" : "" @endphp
                                    $('#cluster').trigger("change");
                                }
                            }
                        });
                    }
                }

                function get_shg_list() {
                    var obj = $(this);
                    var cluster_id = obj.val();
                    if (cluster_id != '') {
                        $.ajax({
                            type: 'GET',
                            url: '/get_shg_list',
                            data: '_token = <?php echo csrf_token(); ?>&cluster_id=' + cluster_id,
                            success: function(data) {
                                if (data != '') {
                                    $('#shg').html(data);
                                    @php echo !empty($session_data["shg"]) ? "$('#shg').val('".$session_data["shg"]."');" : "" @endphp
                                    $('#shg').trigger("change");
                                }
                            }
                        });
                    }
                }

                function get_shg_list2() {
                    var obj = $(this);
                    var federation_id = obj.val();
                    if (federation_id != '') {
                        $.ajax({
                            type: 'GET',
                            url: '/get_shg_list2',
                            data: '_token = <?php echo csrf_token(); ?>&federation_id=' + federation_id,
                            success: function(data) {
                                if (data != '') {
                                    $('#shg').html(data);
                                    $('.shg_uin2').html(data);
                                    $('#shg').trigger("change");
                                }
                            }
                        });
                    }
                }

                function get_family_lists() {
                    var obj = $(this);
                    var shg_id = obj.val();
                    if (shg_id != '') {
                        $.ajax({
                            type: 'GET',
                            url: '/get_family_lists',
                            data: '_token = <?php echo csrf_token(); ?>&shg_id=' + shg_id,
                            success: function(data) {
                                if (data != '') {
                                    $('#family').html(data);
                                    @php echo !empty($session_data["family"]) ? "$('#family').val('".$session_data["family"]."');" : "" @endphp

                                    // $('#family').trigger("change");
                                }
                            }
                        });
                    }
                }
            </script>
        @endsection
        <!-- data-table js -->
