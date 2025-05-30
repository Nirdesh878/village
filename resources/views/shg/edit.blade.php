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
                            <li class="breadcrumb-item">Update SHG</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Update SHG</h4>
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
                            <div class="mT-30">@include('common.error')
                                <form class="container" method="POST" action="{{ route('shg.update', $shg->id) }}" autocomplete="off">
                                    @method('PATCH')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ ( !empty($shg->id) ? $shg->id : '') }}">
                                    <input type="hidden" name="profile_id" value="{{ ( !empty($shg_profile[0]->profile_id) ? $shg_profile[0]->profile_id : '') }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Agency<span class="red">*</span></label>
                                            <select class="form-control agency_id" name="agency_id" id="agency_id" required>
                                                <option value="">--Select--</option>
                                                @foreach($agency as $row)
                                                    <option value="{{ $row->agency_id }}" <?php if ($shg->agency_id == $row->agency_id) {echo 'selected';} ?>>{{ $row->agency_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Federation<span class="red">*</span></label>
                                            <select class="form-control federation_id" name="federation_id" id="federation_id" required>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Cluster</label>
                                            <select class="form-control cluster_uin" name="cluster_uin" id="cluster_uin">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">SHG<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="shgName"  value="{{$shg_profile[0]->shgName }}" autocomplete="off" required>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Country<span class="red">*</span></label>
                                            <select class="form-control country" name="country" id="country" required>
                                                <option value="">--Select--</option>
                                                @foreach($countries as $row)
                                                    <option value="{{ $row->id }}" <?php if ($shg_profile[0]->country_id == $row->id) {echo 'selected';} ?>>{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">State<span class="red">*</span></label>
                                            <select class="form-control state" name="state" id="state" required>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">District</label>
                                            <select class="form-control district" name="district" id="district" required>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">NRLM<span class="red">*</span></label>
                                            <input type="text" class="form-control" id="nrlm_code" name="nrlm_code" value="{{ $shg_profile[0]->shg_code }}" autocomplete="off" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Month/Year it was formed <span class="red">*</span></label>
                                            <input type="text" id="formed" name="formed" title="Enter in dd/mm/yyyy format" class="form-control datepicker" value="{{ change_monthName_to_date($shg_profile[0]->formed)}}" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Village in SHG<span class="red">*</span></label>
                                            <input type="text" id="village" name="village" class="form-control village" value="{{$shg_profile[0]->village }}"  autocomplete="off" required>
                                        </div>

                                        {{-- <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">email</label>
                                            <input type="email" class="form-control" name="email"  value="{{ $shg_profile[0]->web_email }}" autocomplete="off">
                                        </div> --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Mobile</label>
                                            <input type="text" class="form-control phone" name="mobile" value="{{ $shg_profile[0]->web_mobile }}" autocomplete="off" minlength="8" maxlength="12" >

                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">No. of Members at the time of creation of SHG</label>
                                            <input type="number" id="members_at_creation" name="members_at_creation" class="form-control members_at_creation" value="{{$shg_profile[0]->members_at_creation }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">No. of current SHG members- link it with poverty category</label>
                                            <input type="number" id="current_members" class="form-control current_members" name="current_members" value="{{$shg_profile[0]->current_members }}" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">No. of members that have left SHG since creation</label>
                                            <input type="number" class="form-control" name="members_left" value="{{$shg_profile[0]->members_left }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">No. of SHG members from same neighborhood</label>
                                            <input type="number" class="form-control" name="members_neighborhood" value="{{$shg_profile[0]->members_neighborhood }}" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">President</label>
                                            <input type="text" class="form-control" name="president" value="{{$shg_profile[0]->president }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Secretary</label>
                                            <input type="text" class="form-control" name="secretary" value="{{$shg_profile[0]->secretary }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Treasurer</label>
                                            <input type="text" class="form-control" name="treasure" value="{{$shg_profile[0]->treasure }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Book keeper Name</label>
                                            <input type="text" class="form-control" name="book_keeper_name" value="{{$shg_profile[0]->book_keeper_name }}" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Book-keeper date</label>
                                            <input type="text" id="book_keeper_date" name="book_keeper_date" title="Enter in dd/mm/yyyy format" class="form-control datepicker" value="{{ change_monthName_to_date($shg_profile[0]->book_keeper_date)}}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Account opening date</label>
                                            <input type="text" id="bank_date" name="bank_date" title="Enter in dd/mm/yyyy format" class="form-control datepicker"  value="{{ change_monthName_to_date($shg_profile[0]->bank_date)}}" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Name of the Bank</label>
                                            <input type="text" class="form-control" name="bank_name" value="{{$shg_profile[0]->bank_name }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Branch</label>
                                            <input type="text" id="bank_branch" name="bank_branch" class="form-control" value="{{$shg_profile[0]->bank_branch }}" minlength="8" maxlength="15" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Account number</label>
                                            <input type="text" class="form-control phone" name="bank_ac_no" value="{{$shg_profile[0]->bank_ac_no }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Status<span class="red">*</span></label>
                                            <select class="form-control status" name="status" id="status" required>
                                                <option value="A" <?php echo $shg->status == 'A' ? 'selected' :'' ?> > Active</option>
                                                <option value="I" <?php echo $shg->status == 'I' ? 'selected' :'' ?> > Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('shg') }}" class="btn btn-sm btn-danger">Back</a>
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
        $(document).ready(function () {
            $('#agency_id').on('change', get_federation_list);
            $('#federation_id').on('change', get_cluster_list);
            $('#country').on('change', get_state_list);
            $('#state').on('change', get_district_list);
            $('#agency_id,#country,#federation_id').trigger("change");
            $('#country,#state,#agency_id,#nrlm_code').attr("readonly", "readonly");
            $("#country,#state,#agency_id,#nrlm_code").css("pointer-events", "none");
            $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            endDate: tomorrow,
            enableOnReadonly: false
        });
        });
        var today = new Date();
        var tomorrow = new Date();
        tomorrow.setDate(today.getDate() - 1);

        function get_state_list() {
            var obj = $(this);
            var country = obj.val();
            if (country > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_state',
                    data: '_token = <?php echo csrf_token() ?>&country=' + country,

                    success: function (data) {
                        if (data != '') {
                            $('#state').html(data);
                            $('#state').val("{{ $shg_profile[0]->state_id}}");
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

                    success: function (data) {
                        if (data != '') {
                            $('#district').html(data);
                            $('#district').val("{{ $shg_profile[0]->district_id}}");
                            $('#district').trigger("change");
                        }
                    }
                });
            }
        }
        function get_federation_list() {
            var obj = $(this);
            var agency_id = obj.val();
            if (agency_id > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_federation_list',
                    data: '_token = <?php echo csrf_token() ?>&agency_id=' + agency_id,

                    success: function (data) {
                        if (data != '') {
                            $('#federation_id').html(data);
                            $('#federation_id').val("{{ $shg->federation_uin}}");
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
                    data: '_token = <?php echo csrf_token() ?>&federation_id=' + federation_id,

                    success: function (data) {
                        if (data != '') {
                            $('#cluster_uin').html(data);
                            $('#cluster_uin').val("{{ $shg->cluster_uin}}");
                        }
                    }
                });
            }
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
          return /^-?\d*[.,]?\d{0,2}$/.test(value) && (value === "" || parseInt(value) <= 999999999999); });
    </script>
@endsection
