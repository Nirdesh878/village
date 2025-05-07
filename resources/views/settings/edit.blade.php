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
                            <li class="breadcrumb-item">Update Settings</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Update Settings</h4>
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

                                <form class="container" method="POST" action="{{ route('settings.update', $setting->id) }}" autocomplete="off">
                                    @method('PATCH')
                                    @csrf
                                    @include('common.error')
                                    <input type="hidden" name="id" value="{{ !empty($setting->id) ? $setting->id : '' }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Name<span
                                                    class="red">*</span></label>
                                            <input type="text" class="form-control" name="name" value="{{ $setting->name }}" autocomplete="off" required readonly>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Value<span class="red">*</span></label>
                                            <input type="number" class="form-control" name="value" value="{{ $setting->value }}" autocomplete="off" required>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('settings') }}" class="btn btn-sm btn-danger">Back</a>
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
