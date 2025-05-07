@extends('layouts.app')

@section('content')
    <style>
        // workaround
        .intl-tel-input {
            display: table-cell;
        }

        .intl-tel-input .selected-flag {
            z-index: 4;
        }

        .intl-tel-input .country-list {
            z-index: 5;
        }

        .input-group .intl-tel-input .form-control {
            border-top-left-radius: 4px;
            border-top-right-radius: 0;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 0;
        }
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
                            <li class="breadcrumb-item">Create Users</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Create Users</h4>
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
                                @include('common.error')
                                <form class="container" method="POST" action="{{ route('users.store') }}"
                                    autocomplete="off">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Role<span class="red">*</span></label>
                                            <select class="form-control u_type" name="u_type" id="u_type" required>
                                                <option value="">--Select--</option>
                                                @foreach ($roles as $row)
                                                    <option value="{{ $row->roles_slug }}"
                                                        @if (old('u_type') == $row->roles_slug) {{ 'selected' }} @endif>
                                                        {{ $row->roles_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @php
                                            $select_arr[] = '';
                                            if (old('agency_id')) {
                                                // pr(old('agency_id.0'));
                                                for ($i = 0; $i < count(old('agency_id')); $i++) {
                                                    $select_arr[] = old("agency_id.$i");
                                                }
                                            }

                                        @endphp




                                        <div class="col-md-6 mb-3" id="div_module_id" style="display:none">
                                            <label for="validationCustom02">Assign To Agency<span
                                                    class="red">*</span></label>
                                            <select class="js-example-basic-multiple form-control" name="agency_id[]"
                                                id="agency_id">
                                                <option value="">--Select--</option>
                                                @foreach ($agency as $row)
                                                    <option value="{{ $row->agency_id }}"
                                                        @if (in_array($row->agency_id, $select_arr)) ) {{ 'selected' }} @endif>
                                                        {{ $row->agency_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3" id="div_module_country1">
                                            <label for="validationCustom02">Country<span class="red">*</span></label>
                                            <select class="form-control country" id="country" name="country">
                                                <option value="">--Select--</option>
                                                @foreach ($countries as $row)
                                                    <option value="{{ $row->id }}"
                                                        @if (old('country') == $row->id) {{ 'selected' }} @endif>
                                                        {{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12 form-group" id="div_module_country" style="display:none">
                                            <div class="table-responsive">
                                                <table id="facilitator_table"
                                                    class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 40%;">State</th>
                                                            <th style="width: 40%;">District</th>
                                                            <th class="action">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <select class="form-control state" id="state"
                                                                    name="state[]">
                                                                    <option value="">--Select--</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <span class="dis_span" style="display:none;"></span>
                                                                <select
                                                                    class="js-example-basic-multiple form-control district"
                                                                    name="district[0][]" multiple="multiple">
                                                                </select>
                                                            </td>
                                                            <td class="action">
                                                                <button class="btn btn-sm cur-p btn-dark add_faci"
                                                                    type="button" onclick="add_location(this);"
                                                                    title="Add Facilitators"><i
                                                                        class="c-white-500 ti-plus"></i></button>
                                                                <button class="btn btn-sm cur-p btn-danger" type="button"
                                                                    onclick="delete_location(this);"
                                                                    title="Delete Facilitators"><i
                                                                        class="c-white-500 ti-minus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3" id="div_agency_dm" style="display:none">
                                            <label for="validationCustom02">Agency<span class="red">*</span></label>

                                            <select class="js-example-basic-multiple form-control agency_dm mul-select" name="agency_dm[]" id="agency_dm"
                                                multiple="multiple">
                                                <option value="">--Select--</option>
                                                @foreach ($agency as $row)
                                                    <option value="{{ $row->agency_id }}"
                                                        @if (in_array($row->agency_id, $select_arr)) ) {{ 'selected' }} @endif>
                                                        {{ $row->agency_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3" id="div_parent_id" style="display:none">
                                            <label for="validationCustom02">Parent<span class="red">*</span></label>
                                            <select class="form-control parent_id" name="parent_id" id="parent_id">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Name<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}" autocomplete="off"
                                                onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Gender<span class="red">*</span></label>
                                            <select id="gender" name="gender" class="form-control gender" required>
                                                <option value="">--Select--</option>
                                                @foreach ($gender as $row)
                                                    <option value="{{ $row->gender_short_name }}"
                                                        @if (old('gender') == $row->gender_short_name) {{ 'selected' }} @endif>
                                                        {{ $row->gender_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3" id="admin_country">
                                            <label for="validationCustom02">Country<span class="red">*</span></label>
                                            <select class="form-control " name="admin_country" id="select_admin_country">
                                                <option value="">--Select--</option>
                                                @foreach ($countries as $row)
                                                    <option value="{{ $row->id }}"
                                                        @if (old('admin_country') == $row->id) {{ 'selected' }} @endif>
                                                        {{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Email<span class="red">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email') }}" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02"
                                                style="position: relative;left:-68px;">Mobile<span
                                                    class="red">*</span></label>
                                            <span style="width: 15%;float: left;margin-top:26px;">

                                                <input class="form-control " type="text" value="{{ old('tel') }}"
                                                    id="tel" name="tel" readonly>
                                            </span>
                                            <input type="text" class="form-control number"
                                                value="{{ old('mobile') }}" autocomplete="off" id="phone"
                                                name="mobile" style="width:85%;float: left;" required>
                                        </div>



                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Address<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ old('address') }}" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">City <span class="red">*</span></label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ old('city') }}" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Pincode<span class="red">*</span></label>
                                            <input type="text" class="form-control number" name="pincode"
                                                value="{{ old('pincode') }}" autocomplete="off" minlength="4"
                                                maxlength="8" required>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Internal/External<span
                                                    class="red">*</span></label>
                                            <select class="form-control status_inex" name="status_inex" id="status_inex"
                                                required>
                                                <option value="">--Select--</option>
                                                <option value="internal"
                                                    @if (old('status_inex') == 'internal') {{ 'selected' }} @endif>Internal
                                                </option>
                                                <option value="external"
                                                    @if (old('status_inex') == 'external') {{ 'selected' }} @endif>External
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3" id="delete_per">
                                            <label for="validationCustom02">Delete  Permission<span
                                                    class="red">*</span></label>
                                            <select class="form-control delete_inex" name="delete_inex" id="delete_inex"
                                                required>
                                                <option value="">--Select--</option>
                                                <option value="A"
                                                    @if (old('delete_inex') == 'A') {{ 'selected' }} @endif>Allowed
                                                </option>
                                                <option value="D"
                                                    @if (old('delete_inex') == 'D') {{ 'selected' }} @endif selected>Denied
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Status<span class="red">*</span></label>
                                            <select class="form-control status" name="status" id="status" required>
                                                <option value="">--Select--</option>
                                                <option value="A"
                                                    @if (old('status') == 'A') {{ 'selected' }} @endif>Active
                                                </option>
                                                <option value="I"
                                                    @if (old('status') == 'I') {{ 'selected' }} @endif>Inactive
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Password<span class="red">*</span></label>
                                            <div class="input-group show_hide_password">
                                                <input type="password" class="form-control" name="password"
                                                    value="{{ old('password') }}" autocomplete="off" minlength="8"
                                                    maxlength="12" required>
                                                <div class="input-group-addon"
                                                    style="background-color: #e9ecef;padding: .3rem .75rem !important;">
                                                    <a href="" class="eye_link"><i class="fa fa-eye-slash"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Confirm Password <span
                                                    class="red">*</span></label>
                                            <div class="input-group show_hide_password">
                                                <input type="password" class="form-control" name="password_confirmation"
                                                    value="{{ old('password_confirmation') }}" autocomplete="off"
                                                    required>
                                                <div class="input-group-addon"
                                                    style="background-color: #e9ecef;padding: .3rem .75rem !important;">
                                                    <a href="" class="eye_link"><i class="fa fa-eye-slash"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('users') }}" class="btn btn-sm btn-danger">Back</a>
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
        $(document).ready(function() {

            $('#admin_country').hide();
            $('#admin_country').attr('required', false);
            $('#select_admin_country').on('change', get_phone_code);
            $('#country').on('change', get_phone_code);
            $('#u_type').on('change', get_partner_list);
            $('#agency_id').on('change', get_parents_demography);
            $('#u_type').trigger("change");
            $('.country').on('change', get_state_list);
            $('.state').on('change', get_district_list);
            $('#agency_id').on('change', get_agency_demography);
            $(".mul-select").select2({
                placeholder: "select",
                tags: true,
                tokenSeparators: ['/', ',', ',', " "]
            });



        });


        $('#u_type').change(function() {
            var status = $(this).val();
            if (status == 'F') {
                $('#div_module_id').show();
                $('#div_module_country').show();
                $('#div_module_country1').show();
                $('#admin_country,#delete_per').hide();
                $('#admin_country,#delete_per,#delete_inex').attr('required', false);
                $('#div_agency_dm').attr('required', false);
                $('#div_agency_dm').hide();
                $('#div_module_id').attr('required', true);
                $('#country,#state,#parent_id,#agency_id').attr('required', true);
                $('#div_parent_id').show();
                $('#div_parent_id').attr('required', true);
                $('.action').hide();
                $('#phone').on('click', get_phone_code);
                $('#parent_id').val('');
            } else if (status == 'M') {
                $('#country').trigger("change");
                $('#admin_country').hide();
                $('#admin_country').attr('required', false);
                $('#div_module_id').hide();
                $('#div_module_country,#delete_per').show();
                $('#div_module_country1').show();
                $('#div_parent_id,#div_agency_dm').show();
                $('#div_parent_id,#delete_per,#delete_inex').attr('required', true);
                $('#country,#state,#parent_id,#div_agency_dm').attr('required', true);
            } else if (status == 'QA') {
                $('#admin_country').show();
                $('#admin_country').attr('required', true);
                $('#div_parent_id').show();
                $('#div_parent_id').attr('required', true);
                $('#div_module_country,#delete_per').hide();
                $('#div_module_country1').hide();
                $('#div_module_id').hide();
                $("#parent_id").attr('required', true);
                $('#div_module_id,#delete_per,#delete_inex').attr('required', false);
                $('#country').attr('required', false);
                $('#div_agency_dm').attr('required', false);
                $('#div_agency_dm').hide();
            } else if (status == 'A') {
                $('#admin_country').show();
                $('#admin_country').attr('required', true);
                $('#div_parent_id').show();
                $('#div_parent_id').attr('required', true);
                $('#div_module_country,#delete_per').hide();
                $('#div_module_country1').hide();
                $('#div_module_id').hide();
                $("#parent_id,#select_admin_country").attr('required', true);
                $('#div_module_id,#delete_per,#delete_inex').attr('required', false);
                $('#div_agency_dm').attr('required', false);
                $('#div_agency_dm').hide();

            } else if (status == 'CEO') {
                $('#admin_country').show();
                $('#admin_country').attr('required', true);
                $('#div_parent_id,#delete_per').hide();
                $('#div_parent_id,#delete_per,#delete_inex').attr('required', false);
                $('#div_module_country').hide();
                $('#div_module_country1').hide();
                $('#div_module_id').hide();
                $('#div_module_id').attr('required', false);
                $('#country').attr('required', false);
                $('#div_agency_dm').attr('required', false);
                $('#div_agency_dm').hide();
            } else {
                $('#div_module_id,#delete_per').hide();
                $('#div_module_country').hide();
                $('#div_module_country1').hide();
                $('#div_module_id,#delete_per,#delete_inex').attr('required', false);
                $('#div_module_id1').attr('required', false);
                $('#country').attr('required', false);
                $('#div_agency_dm').attr('required', false);
                $('#div_agency_dm').hide();
            }
        });

        function get_partner_list() {
            var obj = $(this);
            var u_type = obj.val();
            if (u_type == 'F') {
                var role = 'M';
            }
            if (u_type == 'M') {
                var role = 'QA';
            }
            if (u_type == 'QA') {
                var role = 'A';
            }
            if (u_type == 'A') {
                var role = 'CEO';
            }

            if ( u_type == 'QA' || u_type == 'M' || u_type == 'A') {
                $.ajax({
                    type: 'GET',
                    url: '/get_partner_list',
                    data: '_token = <?php echo csrf_token(); ?>&role=' + role,
                    success: function(data) {
                        if (data != '') {
                            $('#parent_id').html(data);
                            $('#parent_id').val("{{ old('parent_id') }}");
                        }
                    }
                });
            }
            else{
                $('#parent_id').html('');
                $('#parent_id').val('');
            }

        }

        function get_agency_demography() {
            var obj = $(this);
            var agency_id = obj.val();
            //alert(agency_id);
            if (agency_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_user_agency_demography',
                    data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
                    success: function(data) {
                        if (data != '') {
                            $('#country').html(data.country_option);

                            $('.state').html(data.state_option);
                            // $('.state').trigger('change');
                            $('.district').html(data.district_option);
                            // $('#country').trigger('change');
                            $('#country,.state').attr("readonly", "readonly");
                            $("#country,.state").css("pointer-events", "none");
                        }
                    }
                });
            }
        }

        function get_parents_demography() {
            var obj = $(this);
            var agency_id = obj.val();
            var role = 'M';
            if (agency_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_partner_list',
                    data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id + '&role=' + role,
                    success: function(data) {
                        if (data != '') {
                            $('#parent_id').html(data);
                            $('#parent_id').val("{{ old('parent_id') }}");
                        }
                    }
                });
            }
        }


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
                            obj.parents('tr').find('.state').html(data);

                        }
                    }
                });
            }
        }

        function get_phone_code() {
            var u_type = $('#u_type').val();
            if (u_type == 'A' || u_type == 'QA' || u_type == 'CEO') {
                var country = $('#select_admin_country').val();
            }
            if (u_type == 'F' || u_type == 'M') {
                var country = $('#country').val();
            }



            if (country > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_phone_code',
                    data: '_token = <?php echo csrf_token(); ?>&country=' + country,

                    success: function(data) {
                        if (data != '') {
                            $('#tel').val(data);


                        }
                    }
                });
            }
        }

        function get_district_list() {
            var obj = $(this);
            var state = obj.val();
            var flg = 0;
            var index1 = $(this).index('.state');
            $('.state').each(function(index) {
                if ($(this).val() == state && (index != index1)) {
                    flg = 1;
                    return false;
                }
            });
            if (flg == 1) {
                bootbox.alert('<h3>Duplicate Entry</h3>');

                obj.val('');
            } else if (state > 0 && flg == 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_district_user',
                    data: '_token = <?php echo csrf_token(); ?>&state=' + state ,

                    success: function(data) {
                        if (data != '') {
                            obj.parents('tr').find('.district').html(data);
                            //$('.district').html(data);

                        }
                    }
                });
            }
        }

        var location_counter = 1;

        function add_location(elem) {

            var cloned = $(elem).parents('tr').clone();
            var len = $(".add_faci").length;
            //alert(len);
            //$(cloned).find('.country').attr('name', 'country[]').val('');
            $(cloned).find('.state').attr('name', 'state[]').attr('required', 'required').val('');
            $(cloned).find('.district').attr('name', 'district[][]').val('');
            $(cloned).find('.select2-container').remove();
            $(cloned).find('.district').remove();
            $('.state').unbind();
            $(cloned).find('.dis_span').parent().append(
                '<select class="form-control district" multiple="multiple" name="district[' + len +
                '][]" style="z-index: 9999;"></select>');
            $(cloned).appendTo('#facilitator_table');
            //$('.country').unbind();
            $('.country').on('change', get_state_list);
            $('.district').select2();
            $('.state').on('change', get_district_list);
            location_counter++;
        }

        function delete_location(elem) {
            if ($('#facilitator_table tbody tr').length > 1)
                $(elem).parents('tr').remove();
        }
        $('.country').change(function() {
            var obj = $(this);
            var country = obj.val();
            if (country > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_state',
                    data: '_token = <?php echo csrf_token(); ?>&country=' + country,

                    success: function(data) {
                        if (data != '') {
                            //obj.parents('tr').find('.state').html(data);
                            $('.state').html(data);

                        }
                    }
                });
            }
            if (country > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_phone_code',
                    data: '_token = <?php echo csrf_token(); ?>&country=' + country,

                    success: function(data) {
                        if (data != '') {
                            $('#phone_code').html(data);
                            //$('.state').html(data);

                        }
                    }
                });
            }
        });
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
        $(".number").inputFilter(function(value) {
            return /^-?\d*[.,]?\d{0,2}$/.test(value) && (value === "" || parseInt(value) <= 999999999999);
        });
    </script>
@endsection
