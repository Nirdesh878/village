@extends('layouts.app')

@section('content')
<script>
</script>    
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
                            <li class="breadcrumb-item">Add Agency</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Add Agency</h4>
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
                                <form class="container" method="POST" action="{{ route('agency.store') }}"
                                    autocomplete="off">
                                    @csrf
                                    @include('common.error')
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Partner<span
                                                    class="red">*</span></label>
                                            <select class="form-control community_or_local_partners"
                                                name="community_or_local_partners" id="community_or_local_partners"
                                                required>
                                                <option value="">--Select--</option>
                                                @foreach ($partners_list as $row)
                                                    <option value="{{ $row->id }}"@if (old('community_or_local_partners') == $row->id) {{ 'selected' }} @endif>
                                                        {{ $row->partners_name . ' (' . $row->partners_id . ')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Agency Name<span
                                                    class="red">*</span></label>
                                            <input type="text" class="form-control" name="agency_name"
                                                value="{{ old('agency_name') }}" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Country<span
                                                    class="red">*</span></label>
                                            <select class="form-control country" name="country" id="country" required>
                                                <option value="">--Select--</option>
                                                @foreach ($countries as $row)
                                                    <option value="{{ $row->id }}" @if (old('country') == $row->id) {{ 'selected' }} @endif>{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">State<span
                                                    class="red">*</span></label>
                                            <select class="form-control" name="state" id="state" required>
                                                        <option value="">--Select--</option>
                                                           
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">District</label>
                                            <select class="form-control district" name="district" id="district" >
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                      
                                       
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Contact Name<span
                                                    class="red">*</span></label>
                                            <input type="text" class="form-control" name="contact_name" value="{{ old('contact_name') }}"
                                                autocomplete="off" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Contact Email<span
                                                    class="red">*</span></label>
                                            <input type="email" class="form-control" value="{{ old('contact_email') }}" name="contact_email" pautocomplete="off" required>
                                        </div>
                                       
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02" style="position: relative;left:-68px;">Contact Number<span class="red" >*</span></label>
                                            <span style="width: 15%;float: left;margin-top:26px;" id="phone_code"   >
                                                
                                                <input class="form-control " type="text" value="{{ old('tel') }}" id="tel" name="tel" readonly>
                                            </span>
                                            <input type="tel" class="form-control number" 
                                                value="{{ old('contact_number') }}" autocomplete="off" 
                                                id="phone" name="contact_number" 
                                                 style="width:85%;float: left;" minlength="8" maxlength="12" required>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Contact Address<span
                                                    class="red">*</span></label>
                                            <input type="text" class="form-control" name="contact_address" value="{{ old('contact_address') }}"
                                                autocomplete="off" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Status<span
                                                    class="red">*</span></label>
                                            <select class="form-control status" name="status" id="status" required>
                                                <option value="A" @if (old('status') == 'A') {{ 'selected' }} @endif>Active</option>
                                                <option value="I" @if (old('status') == 'I') {{ 'selected' }} @endif>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('agency') }}" class="btn btn-sm btn-danger">Back</a>
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
            $('#community_or_local_partners').on('change', get_partner_demography);
            $('#country').on('change', get_state_list);
            $('#country').on('change', get_phone_code);
            $('#country').attr("readonly", "readonly");
            $("#country").css("pointer-events", "none");
            $('#state').on('change', get_district_list);
            $('#country').trigger("change");
            $('#district').val("{{ old('district')}}");
            // $('#district').on('change', get_block_list);
            // $('#country').trigger("change");
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
                            $("#state").val("{{ old('state') }}");
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
                            $("#district").val("{{ old('district') }}");
                            $('#district').trigger("change");
                        }
                    }
                });
            }
        }
        function get_partner_demography() {
            var obj = $(this);
            var partners_id = obj.val();
            //alert(partners_id);
            if (partners_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_partner_demography',
                    data: '_token = <?php echo csrf_token() ?>&partners_id=' + partners_id,
                    success: function (data) {
                        if (data != '') {
                           
                            $('#country').html(data.country_option);
                            $('#country').trigger("change");
                            
                        }
                    }
                });
            }
        }
        function get_phone_code() {
            
            var country = $('#country').val();
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
      $(".number").inputFilter(function(value) {
          return /^-?\d*[.,]?\d{0,2}$/.test(value) && (value === "" || parseInt(value) <= 999999999999); });
    </script>
@endsection
