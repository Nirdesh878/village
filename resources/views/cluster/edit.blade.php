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
                            <li class="breadcrumb-item">Update Cluster</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Update Cluster</h4>
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
                                <form class="container" autocomplete="off" method="POST" action="{{ route('cluster.update', $cluster->id) }}">
                                    @method('PATCH')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ ( !empty($cluster->id) ? $cluster->id : '') }}">
                                    <input type="hidden" name="profile_id" value="{{ ( !empty($cluster_profile[0]->profile_id) ? $cluster_profile[0]->profile_id : '') }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Agency<span class="red">*</span></label>
                                            <select class="form-control agency_id" name="agency_id" id="agency_id" required>
                                                <option value="">--Select--</option>
                                                @foreach($agency as $row)
                                                    <option value="{{ $row->agency_id }}" <?php if ($cluster->agency_id == $row->agency_id) {echo 'selected';} ?>>{{ $row->agency_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Federation<span class="red">*</span></label>
                                            <select class="form-control federation_id" name="federation_id" id="federation_id" required>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Name of Cluster<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="name_of_cluster" autocomplete="off" value="{{$cluster_profile[0]->name_of_cluster }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Country<span class="red">*</span></label>
                                            <select class="form-control country" name="country" id="country" required>
                                                <option value="">--Select--</option>
                                                @foreach($countries as $row)
                                                    <option value="{{ $row->id }}" <?php if ($cluster_profile[0]->country_id == $row->id) {echo 'selected';} ?>>{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">State<span class="red">*</span></label>
                                            <select class="form-control state" name="state" id="state" required>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">District</label>
                                            <select class="form-control district" name="district" id="district" required>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                                        <label for="validationCustom02">Block<span
                                                                class="red">*</span></label>
                                                       <input type="text" class="form-control block" name="block" value="{{$cluster_profile[0]->block}}" readonly="">
                                                    </div>
                                                                                <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Cluster was formed<span class="red">*</span></label>
                                            <input type="text" id="cluster_formed" name="cluster_formed" title="Enter in dd/mm/yyyy format" class="form-control datepicker" value="{{ change_date_month_name_char(str_replace('/','-',$cluster_profile[0]->cluster_formed))}}" autocomplete="off" required>
                                        </div>

                                         <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Contact Name<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="contact_name" value="{{ $cluster_profile[0]->contact_name }}" autocomplete="off" title="Enter Contact Name" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Contact Email<span class="red">*</span></label>
                                            <input type="email" class="form-control" name="email"  value="{{ $cluster_profile[0]->web_email }}" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Contact Number<span class="red">*</span></label>
                                            <input type="number" class="form-control phone" name="mobile" value="{{ $cluster_profile[0]->web_mobile }}" autocomplete="off" minlength="8" maxlength="12" required>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">NRLM<span class="red">*</span></label>
                                            <input type="text" class="form-control" id="nrlm_code" name="nrlm_code" value="{{ $cluster_profile[0]->vo_code }}" autocomplete="off" readonly>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">No. of SHGs in Cluster</label>
                                            <input type="number" id="no_of_of_shg_in_cluster" name="no_of_of_shg_in_cluster" class="form-control no_of_of_shg_in_cluster" value="{{$cluster_profile[0]->no_of_of_shg_in_cluster }}" autocomplete="off">
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Cluster office location</label>
                                            <input type="text" class="form-control" name="office_location" value="{{$cluster_profile[0]->office_location }}"autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">No. of SHGs at the time of creation of cluster</label>
                                            <input type="number" class="form-control" name="shg_at_time_creation" value="{{$cluster_profile[0]->shg_at_time_creation }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">No. of members at the time of creation of cluster</label>
                                            <input type="number" class="form-control" name="cluster_members_at_time_creation" value="{{$cluster_profile[0]->cluster_members_at_time_creation }}" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Total SHGs</label>
                                            <input type="number" class="form-control" name="total_SHGs" value="{{$cluster_profile[0]->total_SHGs }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Total Members</label>
                                            <input type="number" class="form-control" name="total_members" value="{{$cluster_profile[0]->total_members }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">President</label>
                                            <input type="text" class="form-control" name="president" value="{{$cluster_profile[0]->president }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Secretary</label>
                                            <input type="text" class="form-control" name="secretary" value="{{$cluster_profile[0]->secretary }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Treasurer</label>
                                            <input type="text" class="form-control" name="Treasurer" value="{{$cluster_profile[0]->treasure }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Book keeper Name</label>
                                            <input type="text" class="form-control" name="book_keeper_name" value="{{$cluster_profile[0]->book_keeper_name }}" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Contact number</label>
                                            <input type="number" class="form-control phone" name="contact_number" value="{{$cluster_profile[0]->contact_number }}" autocomplete="off"  pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[6789]\d{9}$" title="Enter Valid mobile number 10 digit and start with 6789">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Status</label>
                                            <select class="form-control status" name="status" id="status" required>
                                                <option value="A" <?php echo $cluster->status == 'A' ? 'selected' :'' ?> > Active</option>
                                                <option value="I" <?php echo $cluster->status == 'I' ? 'selected' :'' ?> > Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('cluster') }}" class="btn btn-sm btn-danger">Back</a>
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
            $('#country').on('change', get_state_list);
            $('#state').on('change', get_district_list);
            $('#agency_id').trigger("change");
            $('#country').trigger("change");
            $('#state').trigger("change");
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
                            $('#state').val("{{ $cluster_profile[0]->state_id}}");
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
                            $('#district').val("{{ $cluster_profile[0]->district_id}}");
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
                            $('#federation_id').val("{{ $cluster->federation_uin}}");
                            $('#federation_id').trigger("change");
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
