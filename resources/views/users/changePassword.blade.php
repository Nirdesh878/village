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
                            <li class="breadcrumb-item">Change Password</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Change Password</h4>
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
                                <form method="POST" action="{{ route('change.password') }}" autocomplete="off">
                                    @csrf
                                    @include('common.error')
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Current Password <span
                                                    class="red">*</span></label>
                                            <div class="input-group show_hide_password">
                                                <input id="password" type="password" class="form-control" name="current_password"
                                                    value="" autocomplete="off"
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
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">New Password <span
                                                    class="red">*</span></label>
                                            <div class="input-group show_hide_password">
                                                <input id="new_password" type="password" class="form-control" name="new_password"
                                                    value="" autocomplete="off"
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
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">New Confirm Password <span
                                                    class="red">*</span></label>
                                            <div class="input-group show_hide_password">
                                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password"
                                                    value="" autocomplete="off"
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
                                        <div class="col-md-6 mb-3 ">
                                            <button class="btn btn-sm btn-success" type="submit">Update Password</button>
                                            <a href="{{ url('home') }}" class="btn btn-sm btn-danger">Back</a>
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
@endsection
