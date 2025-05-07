@extends('layouts.app')

@section('content')

<style>

.agency-dp button.multiselect {
    width: 48.5%;
    text-align: left;
    background: #fff;
    border-radius: 2px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 13px;
}
.agency-dp .btn-group {
    width: 100%;
}

.agency-dp label.checkbox {
    margin: 0 !important;
    padding-left: 15px;
}
.agency-dp button.multiselect:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    border: 1px solid #fcaf17;
    box-shadow: none;
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
                            <li class="breadcrumb-item">Update Users</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Update Users</h4>
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
                                <form class="container" method="POST" action="{{ route('users.update', $user->id) }}"
                                    autocomplete="off">
                                    @method('PATCH')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ !empty($user->id) ? $user->id : '' }}">
                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Role<span class="red">*</span></label>
                                            <select class="form-control u_type" name="u_type" id="u_type" readonly>
                                                <option value="">--Select--</option>
                                                @foreach ($roles as $row)
                                                    <option value="{{ $row->roles_slug }}" <?php if ($user->u_type == $row->roles_slug) {
                                                        echo 'selected';
                                                    } ?>>
                                                        {{ $row->roles_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($family_pending_tasks[0]->family !=0 || $shg_pending_tasks[0]->shg !=0 || $clus_pending_tasks[0]->cluster !=0 || $fed_pending_tasks[0]->federation !=0)
                                            <div class="col-md-6 mb-3" id="div_module_id">
                                                <label for="validationCustom02">Assign To Agency<span
                                                        class="red">*</span></label>
                                                <select class=" form-control" name="agency_id[]" id="agency_id"
                                                    readonly="readonly" style="pointer-events: none;">
                                                    <option value="">--Select--</option>
                                                    @foreach ($agency as $row)
                                                        <option value="{{ $row->agency_id }}"
                                                            @if (in_array($row->agency_id, explode(',', $user->agency_id))) {{ 'selected' }} @endif>
                                                            {{ $row->agency_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="red">NOTE: Agency for this user cannot be change as there are pending tasks as metioned below.
                                                    <br>
                                                    Family - {{ $family_pending_tasks[0]->family ?? 0 }},
                                                    SHG - {{ $shg_pending_tasks[0]->shg ?? 0 }},
                                                    Cluster - {{ $clus_pending_tasks[0]->cluster ?? 0 }},
                                                    Federation - {{ $fed_pending_tasks[0]->federation ?? 0 }}.
                                                </span>
                                            </div>
                                        @else
                                            <div class="col-md-6 mb-3" id="div_module_id">
                                                <label for="validationCustom02">Assign To Agency<span
                                                        class="red">*</span></label>
                                                <select class=" form-control" name="agency_id[]" id="agency_id">
                                                    <option value="">--Select--</option>
                                                    @foreach ($agency as $row)
                                                        <option value="{{ $row->agency_id }}"
                                                            @if (in_array($row->agency_id, explode(',', $user->agency_id))) {{ 'selected' }} @endif>
                                                            {{ $row->agency_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        <div class="col-md-6 mb-3" id="div_module_country1">
                                            <label for="validationCustom02">Country<span class="red">*</span></label>
                                            <select class="form-control country" id="country" name="country" required>
                                                <option value="">--Select--</option>
                                                @foreach ($countries as $row)
                                                    <option value="{{ $row->id }}" <?php if ($users_mappings[0]->country_id == $row->id) {
                                                        echo 'selected';
                                                    } ?>>
                                                        {{ $row->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 form-group" id="div_module_country">
                                            <div class="table-responsive">
                                                <table id="facilitator_table"
                                                    class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th width="45%">State</th>
                                                            <th width="45%">District</th>
                                                            <th class="action">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @if (!empty($users_mappings))
                                                            @php $count = 0; @endphp
                                                            @foreach ($users_mappings as $users_mapping)
                                                                <tr>
                                                                    {{-- <td>
                                                                        <select class="form-control country" id="country"
                                                                            name="country[{{ $count }}]" >
                                                                            <option value="">--Select--</option>
                                                                            @foreach ($countries as $row)
                                                                                <option value="{{ $row->id }}"
                                                                                    <?php if ($users_mapping->country_id == $row->id) {
                                                                                        echo 'selected';
                                                                                    } ?>>{{ $row->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td> --}}
                                                                    <td>
                                                                        <select class="form-control state" id="state"
                                                                            name="state[{{ $count }}]">
                                                                            <option value="">--Select--</option>
                                                                            @foreach ($states as $row)
                                                                                <option value="{{ $row->id }}"
                                                                                    <?php if ($users_mapping->state_id == $row->id) {
                                                                                        echo 'selected';
                                                                                    } ?>>{{ $row->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span class="dis_span" style="display:none;"></span>

                                                                        <select
                                                                            class="js-example-basic-multiple form-control district"
                                                                            name="district[{{ $count }}][]"
                                                                            multiple="multiple" value="">

                                                                        </select>

                                                                    </td>
                                                                    <td class="action">
                                                                        <button class="btn btn-sm cur-p btn-dark add_faci"
                                                                            type="button" onclick="add_location(this);"
                                                                            title="Add Facilitators"><i
                                                                                class="c-white-500 ti-plus"></i></button>
                                                                        <button class="btn btn-sm cur-p btn-danger"
                                                                            type="button" onclick="delete_location(this);"
                                                                            title="Delete Facilitators"><i
                                                                                class="c-white-500 ti-minus"></i></button>
                                                                    </td>
                                                                </tr>
                                                                @php $count++; @endphp
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-3" id="div_agency_dm" style="display:none">
                                            <label for="validationCustom02">Agency<span class="red">*</span></label>

                                            {{-- <select class="js-example-basic-multiple form-control agency_dm mul-select"
                                                name="agency_dm[]" id="agency_dm" multiple="multiple">
                                                <option value="">--Select--</option>
                                                @foreach ($agency as $row)
                                                    <option value="{{ $row->agency_id }}"
                                                        @if (in_array($row->agency_id, explode(',', $user->agency_id))) {{ 'selected' }} @endif >
                                                        {{ $row->agency_name }}</option>
                                                @endforeach

                                            </select> --}}

                                            <div class="agency-dp">
                                            <input type="hidden" value="{{ $fac_agency[0]->agency }}" name="agency_hide_name">
                                            <select class="form-control col-md-12 mb-3" name="agency_dm[]" id="agency_dm"
                                                multiple="multiple">
                                                {{-- <option value="">--Select--</option> --}}
                                                @foreach ($agency as $row)
                                                    <option value="{{ $row->agency_id }}"
                                                        @if (in_array($row->agency_id, explode(',', $user->agency_id))) {{ 'selected' }} @endif>
                                                        {{ $row->agency_name }}</option>
                                                @endforeach

                                            </select>
                                        </div>


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
                                                value="{{ $user->name }}" autocomplete="off" required
                                                onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Gender<span class="red">*</span></label>
                                            <select id="gender" name="gender" class="form-control gender" required>
                                                <option value="">--Select--</option>
                                                @foreach ($gender as $row)
                                                    <option value="{{ $row->gender_short_name }}" <?php if ($user->gender_c == $row->id) {
                                                        echo 'selected';
                                                    } ?>>
                                                        {{ $row->gender_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Email<span class="red">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $user->email }}" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-6 mb-3" id="admin_country">
                                            <label for="validationCustom02">Country<span class="red">*</span></label>
                                            <select class="form-control " name="admin_country" id="select_admin_country">
                                                <option value="">--Select--</option>
                                                @foreach ($countries as $row)
                                                    <option value="{{ $row->id }}"<?php if ($users_mapping->country_id == $row->id) {
                                                        echo 'selected';
                                                    } ?>>
                                                        {{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02"
                                                style="position: relative;left:-68px;">Mobile<span
                                                    class="red">*</span></label>
                                            <span style="width: 15%;float: left;margin-top:26px;">

                                                <input class="form-control " type="text" value=""
                                                    id="tel" readonly>
                                            </span>
                                            <input type="text" class="form-control number"
                                                value="{{ $user->mobile }}" autocomplete="off" id="phone"
                                                name="mobile" style="width:85%;float: left;" required>
                                        </div>
                                        {{-- <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Mobile<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="mobile"
                                                value="{{ $user->mobile }}" autocomplete="off" minlength="10"
                                                maxlength="10" pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[6789]\d{9}$"
                                                title="Enter Valid mobile number 10 digit and start with 6789" required>
                                        </div> --}}
                                        <div class="col-md-6 mb-3" id="device">
                                            <label for="validationCustom02">Device id<span class="red"></span></label>
                                            <input type="text" class="form-control" name="device"
                                                value="{{ $user->device }}" autocomplete="off" >
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Adrress<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="adress"
                                                value="{{ $user->adress }}" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">City <span class="red">*</span></label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ $user->city }}" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Pincode<span class="red">*</span></label>
                                            <input type="text" class="form-control number" name="pincode"
                                                value="{{ $user->pincode }}" autocomplete="off" minlength="4"
                                                maxlength="8" required>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Internal/External<span
                                                    class="red">*</span></label>
                                            <select class="form-control status_inex" name="status_inex" id="status_inex">
                                                <option value="">--Select--</option>
                                                <option value="internal" <?php echo $user->status_inex == 'internal' ? 'selected' : ''; ?>> Internal</option>
                                                <option value="external" <?php echo $user->status_inex == 'external' ? 'selected' : ''; ?>> External</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3" id="delete_per">
                                            <label for="validationCustom02">Delete  Permission<span
                                                    class="red">*</span></label>
                                            <select class="form-control delete_inex" name="delete_inex" id="delete_inex"
                                                >
                                                <option value="">--Select--</option>
                                                <option value="A" <?php echo $user->delete_inex == 'A' ? 'selected' : ''; ?>> Allowed</option>
                                                <option value="D" <?php echo $user->delete_inex == 'D' ? 'selected' : ''; ?>> Denied</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Status<span class="red">*</span></label>
                                            <select class="form-control status" name="status" id="status" required>
                                                <option value="A" <?php echo $user->status == 'A' ? 'selected' : ''; ?>> Active</option>
                                                <option value="I" <?php echo $user->status == 'I' ? 'selected' : ''; ?>> Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Password<span class="red">*</span></label>
                                            <div class="input-group show_hide_password">
                                                <input type="password" class="form-control" name="password"
                                                    value="{{ $user->password_show }}" autocomplete="off" minlength="8"
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
                                                    value="{{ $user->password_show }}" autocomplete="off" required>
                                                <div class="input-group-addon"
                                                    style="background-color: #e9ecef;padding: .3rem .75rem !important;">
                                                    <a href="" class="eye_link"><i class="fa fa-eye-slash"
                                                            aria-hidden="true"></i></a>
                                                </div>
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
    <script src="/path/to/cdn/jquery.slim.min.js"></script>
    <script src="/path/to/src/jquery.multi-select.js"></script>
    <script>
        var district_arr_f = [];
        var state_arr_f = [];

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
            var parent_id = "{{ !empty($user->parent_id) ? $user->parent_id : '' }}";
            if (u_type == 'QA' || u_type == 'M' || u_type == 'A') {
                $.ajax({
                    type: 'GET',
                    url: '/get_partner_list',
                    data: '_token = <?php echo csrf_token(); ?>&role=' + role,
                    success: function(data) {
                        if (data != '') {
                            $('#parent_id').html(data);
                            $('#parent_id').val("{{ $user->parent_id }}");
                        }
                    }
                });
            } else {
                $('#parent_id').html('');
                $('#parent_id').val('');

            }
        }
        $('body').on('change', '#select_admin_country', function(e) {

            var country = $('#select_admin_country').val();
            // alert(country);
            if (country > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_phone_code',
                    data: '_token = <?php echo csrf_token(); ?>&country=' + country,

                    success: function(data) {
                        if (data != '') {
                            $('#tel').val(data);
                            //$('.state').html(data);

                        }
                    }
                });
            }
        });

        $('body').on('change', '.country', function(e) {
            var country = $(this).val();
            var index = $('.country').index(this);
            if ("{{ $users_mappings[0]->country_id }}" == country) {
                $.ajax({
                    type: 'GET',
                    url: "/get_state",
                    data: 'country=' + country,
                    success: function(data) {
                        // alert(data);
                        if (data != '') {
                            $('.state').eq(index).html(data);
                            $('.state').eq(index).val(state_arr_f[index]);
                            $('.state').trigger("change");
                        }
                    }
                });
            } else {
                $.ajax({
                    type: 'GET',
                    url: "/get_state",
                    data: 'country=' + country,
                    success: function(data) {
                        // alert(data);
                        if (data != '') {
                            $('.state').html(data);
                            $('.state').html(data);
                            //$('.state').eq(index).val(state_arr_f[index]);
                            $('.district').html("");
                        }
                    }
                });
            }
        });

        $('body').on('change', '.state', function(e) {
            var state = $(this).val();
            var index = $('.state').index(this);
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

                $(this).val('');
            } else if (state > 0 && flg == 0) {
                $.ajax({
                    type: 'GET',
                    url: "/get_district_user",
                    data: 'state=' + state,
                    success: function(data) {
                        //alert(district_arr_f[index]);
                        if (data != '') {
                            $('.district').eq(index).html(data);
                            var i = 0;
                            for (i - 0; i < district_arr_f[index].length; i++) {

                                $('.district').eq(index).val(district_arr_f[index][i]);
                            }

                        }
                    }
                });
            }
        });
        var location_counter = "{{ !empty($users_mappings) ? count($users_mappings) : '1' }}";

        function add_location(elem) {

            var cloned = $(elem).parents('tr').clone();
            var len = $(".add_faci").length;
            //alert(len);
            $(cloned).find('.country').attr('name', 'country[]').val('');
            $(cloned).find('.state').attr('name', 'state[]').attr('required', 'required').val('');
            $(cloned).find('.district').attr('name', 'district[][]').val('');
            $(cloned).find('.select2-container').remove();
            $(cloned).find('.district').remove();
            $('.state').unbind();
            $(cloned).find('.dis_span').parent().append(
                '<select class="js-example-basic-multiple form-control district" multiple="multiple" name="district[' +
                len + '][]" ></select>');
            $(cloned).appendTo('#facilitator_table');
            $('.country').unbind();
            $(".js-example-basic-multiple").select2();
            $('.country').on('change', get_state_list);
            $('.district').select2();
            $('.state').on('change', get_district_list);
            location_counter++;
        }

        function delete_location(elem) {
            if ($('#facilitator_table tbody tr').length > 1)
                $(elem).parents('tr').remove();
        }

        $(document).ready(function() {



            $('#agency_dm option').each(function() {
                var valuesToDisable = '{{ $fac_agency[0]->agency }}';
                // alert(valuesToDisable);
                var optionValue = $(this).val();
                if (valuesToDisable.includes(optionValue)) {

                    $(this).prop('disabled' , true);
                    // $(this).prop('readonly' , 'readonly');

                }

            });
            $('#agency_dm').multiselect();
            $('#u_type').on('change', get_partner_list);
            $('#agency_id').on('change', get_agency_demography, get_parents_demography);
            $('#select_admin_country').trigger("change");
            $('#u_type').trigger("change");

            var u_type = $('#u_type').val();
            if (u_type == 'F') {
                $('#agency_id').trigger("change");
            }




            @foreach ($users_mappings as $key => $value)
                district_arr_f.push([]);
                district_arr_f["{{ $key }}"].push([<?php foreach (explode(',', $value->district_id) as $value1) {
                    echo $value1 . ',';
                } ?>]);
                state_arr_f.push('{{ $value->state_id }}');
            @endforeach
            //console.log(district_arr_f);

            @if ($user->u_type == 'F')
                $('#div_module_id').show();
                $('#div_module_country').show();
                $('#div_module_country1').show();
                $('#admin_country,#div_agency_dm,#delete_per').hide();
                $('#admin_country,#div_agency_dm,#delete_per').attr('required', false);
                $('#div_module_id').attr('required', true);
                $('#country,#state,#parent_id,#agency_id').attr('required', true);
                $('#div_parent_id,#device').show();
                $('#div_parent_id').attr('required', true);
                $('.country').trigger("change");
                $('.action').hide();
                $('#country,.state').attr("readonly", "readonly");
                $("#country,.state").css("pointer-events", "none");
            @elseif ($user->u_type == 'M')
                $('#admin_country,#device').hide();
                $('#admin_country,#device').attr('required', false);
                $('#div_module_id').hide();
                $('#div_module_country,#delete_per').show();
                $('#div_module_country1').show();
                $('#div_parent_id,#div_agency_dm').show();
                $('#div_parent_id,#delete_per').attr('required', true);
                $('#country,#state,#parent_id,#div_agency_dm').attr('required', true);
                $('.country').trigger("change");
            @elseif ($user->u_type == 'QA')
                $('#admin_country').show();
                $('#admin_country,#parent_id,#select_admin_country,#device').attr('required', true);
                $('#div_parent_id').show();
                $('#div_parent_id').attr('required', true);
                $('#div_module_country,#device,#delete_per').hide();
                $('#div_module_country1').hide();
                $('#div_module_id,#div_agency_dm').hide();
                $('#div_module_id,#div_agency_dm,#delete_per').attr('required', false);
                $('#country').attr('required', false);
                $('#admin_country').trigger("change");
            @elseif ($user->u_type == 'A')
                $('#admin_country').show();
                $('#admin_country,#parent_id,#select_admin_country').attr('required', true);
                $('#div_parent_id').show();
                $('#div_parent_id').attr('required', true);
                $('#div_module_country,#div_agency_dm,#delete_per').hide();
                $('#div_module_country1').hide();
                $('#div_module_id,#device').hide();
                $('#div_module_id,#div_agency_dm,#device,#delete_per').attr('required', false);
                $('#country').attr('required', false);
                $('#admin_country').trigger("change");
            @else
                $('#div_module_id,#device').hide();
                $('#div_module_country').hide();
                $('#div_module_country1,#div_agency_dm,#delete_per').hide();
                $('#div_module_id,#div_agency_dm,#device,#delete_per').attr('required', false);
                $('#div_module_id1').attr('required', false);
                $('#country').attr('required', false);
                $('#admin_country').trigger("change");
            @endif


            //$('.state').trigger("change");
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
                            $('#parent_id').val("{{ $user->parent_id }}");
                        }
                    }
                });
            }
        }
    </script>
@endsection
