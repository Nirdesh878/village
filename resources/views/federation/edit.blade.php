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
                            <li class="breadcrumb-item">Update Federation</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Update Federation</h4>
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
                                <form class="container" method="POST" action="{{ route('federation.update', $federation->id) }}" autocomplete="off">
                                    @method('PATCH')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ ( !empty($federation->id) ? $federation->id : '') }}">
                                    <input type="hidden" name="profile_id" value="{{ ( !empty($federation_profile[0]->profile_id) ? $federation_profile[0]->profile_id : '') }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Agency<span class="red">*</span></label>
                                            <select class="form-control agency_id" name="agency_id" id="agency_id" required>
                                                <option value="">--Select--</option>
                                                @foreach($agency as $row)
                                                    <option value="{{ $row->agency_id }}" <?php if ($federation->agency_id == $row->agency_id) {echo 'selected';} ?>>{{ $row->agency_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Name of Federation<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="name_of_federation"  value="{{$federation_profile[0]->name_of_federation }}" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Date federation was formed<span class="red">*</span></label>
                                            <input type="text" pattern="\d{1,2}/\d{1,2}/\d{4}" id="date_federation_was_found" name="date_federation_was_found" title="Enter in dd/mm/yyyy format" class="form-control datepicker" autocomplete="off" value="{{ $federation_profile[0]->date_federation_was_found}}" readonly>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Country<span class="red">*</span></label>
                                            <select class="form-control country" name="country" id="country" required>
                                                <option value="">--Select--</option>
                                                @foreach($countries as $row)
                                                    <option value="{{ $row->id }}" <?php if ($federation_profile[0]->country_id == $row->id) {echo 'selected';} ?>>{{ $row->name }}</option>
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
                                            <label for="validationCustom02">Block<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="block" value="{{ $federation_profile[0]->block }}" autocomplete="off" title="Enter Block">

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">NRLM<span class="red">*</span></label>
                                            <input type="text" class="form-control" id="nrlm_code" name="nrlm_code" value="{{ $federation_profile[0]->clf_code }}" autocomplete="off" required>
                                        </div>
                                         <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Contact Name<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="contact_name" value="{{ $federation_profile[0]->contact_name }}" autocomplete="off" title="Enter Contact Name">

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Contact Email<span class="red">*</span></label>
                                            <input type="email" class="form-control" name="email"  value="{{ $federation_profile[0]->web_email }}" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Contact Number<span class="red">*</span></label>
                                            <input type="text" class="form-control number" name="mobile" value="{{ $federation_profile[0]->web_mobile }}" autocomplete="off" minlength="8" maxlength="12" required>

                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Registration no.</label>
                                            <input type="text" class="form-control number" name="registration_no" value="{{ $federation_profile[0]->registration_no }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Total no. of Clusters at the time of formation</label>
                                            <input type="number" class="form-control" name="clusters_at_time_creation" value="{{ $federation_profile[0]->clusters_at_time_creation }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Total no. of SHGs at the time of formation</label>
                                            <input type="number" class="form-control" name="shg_at_time_creation" value="{{ $federation_profile[0]->shg_at_time_creation }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Total no. of Members at the time of formation</label>
                                            <input type="number" class="form-control" name="members_at_time_creation" value="{{ $federation_profile[0]->members_at_time_creation }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Total no. of Clusters</label>
                                            <input type="number" class="form-control" name="total_clusters" value="{{ $federation_profile[0]->total_clusters }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Total no. of SHGs</label>
                                            <input type="number" class="form-control" name="total_SHGs" value="{{ $federation_profile[0]->total_SHGs }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Total no. of Members</label>
                                            <input type="number" class="form-control" name="total_members" value="{{ $federation_profile[0]->total_members }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">President</label>
                                            <input type="text" class="form-control" name="president" value="{{ $federation_profile[0]->president }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Secretary</label>
                                            <input type="text" class="form-control" name="secretary" value="{{ $federation_profile[0]->secretary }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Treasurer</label>
                                            <input type="text" class="form-control" name="Treasurer" value="{{ $federation_profile[0]->Treasurer }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Book keeper Name</label>
                                            <input type="text" class="form-control" name="book_keeper_name" value="{{ $federation_profile[0]->book_keeper_name }}" autocomplete="off">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Status<span class="red">*</span></label>
                                            <select class="form-control status" name="status" id="status" required>
                                                <option value="A" <?php echo $federation->status == 'A' ? 'selected' :'' ?> > Active</option>
                                                <option value="I" <?php echo $federation->status == 'I' ? 'selected' :'' ?> > Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('federation') }}" class="btn btn-sm btn-danger">Back</a>
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
        $(function () {
            $('#mobile-collapse').trigger('click');
        })
    </script>

    <script>
        $(document).ready(function () {
            $('#country').on('change', get_state_list);
            $('#state').on('change', get_district_list);
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
                            $('#state').val("{{ $federation_profile[0]->state_id}}");
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
                            $('#district').val("{{ $federation_profile[0]->district_id}}");
                            $('#district').trigger("change");
                        }
                    }
                });
            }
        }
        $('#nrlm_code').on('focusout', function() {
            var inputValue = $(this).val();
            if (inputValue != '') {
                $.ajax({
                    type: 'GET',
                    url: '/check_nrlm_code',
                    data: '_token = <?php echo csrf_token(); ?>&inputValue=' + inputValue,
                    success: function(data) {
                        if (data != '') {
                            if (data == 1) {
                                alert("Fedeartion is already Exist");
                                $('#nrlm_code').val('');

                            }

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
          return /^-?\d*[.,]?\d{0,2}$/.test(value) && (value === "" || parseInt(value) <= 999999999999); });
    </script>
@endsection
