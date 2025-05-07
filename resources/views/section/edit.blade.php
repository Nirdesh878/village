@extends('layouts.app')

@section('content')
    <style>


        .head-pannel {
            background: #ffffff;
            padding: 15px;
            margin: -18px -27px;
        }

        .d-flex {
            display: flex !important;
        }

        .rating-box {
            background: #6BC561;
            border-radius: 5px;
            padding: 10px;
            color: #ffffff;
            width: 190px;
        }

        .rating-box2 {
            background: #FF4141;
            border-radius: 5px;
            padding: 10px;
            color: #ffffff;
            width: 190px;
        }

        .headerfont h2 {
            font-size: 20px;
            margin-left: 18px;
        }

        .headerfont p {
            font-size: 14px;
            margin-left: 18px;
            margin-bottom: 4px;
        }

        .s-box h4 {
            font-size: 14px;
            font-weight: normal;
        }

        .faily-tab .nav-link {
            box-shadow: 0 3px 6px rgb(31 30 47 / 3%);
            background: #ffffff !important;
            border-radius: 48px;
            padding: 15px;
            border: 1px solid #ECEFF5 !important;
            margin-left: 20px;
            font-size: 14px;
            color: #000000 !important;
            margin-top: 15px;
            text-align: center !important;
        }

        .faily-tab .nav-link.active {
            box-shadow: 0 3px 6px rgb(31 30 47 / 3%);
            background: #1F2837 !important;
            border-radius: 48px;
            padding: 15px;
            border: 1px solid #ECEFF5 !important;
            margin-left: 20px;
            font-size: 14px;
            color: #ffffff !important;
            margin-top: 15px;
        }

        .family-box {
            box-shadow: 0 3px 6px rgb(31 30 47 / 3%);
            background: #ffffff;
            border-radius: 5px;
            padding: 15px;
            border: 1px solid #ECEFF5;
        }

        .w-heading {
            padding: 15px;
            margin: -15px -15px 15px;
            border-bottom: 1px solid #ECEFF5;
            font-size: 16px;
            font-weight: 600;
        }

        .w-heading h5 {
            margin: 0;
        }

        .w-heading .btn {
            margin: -5px 0;
        }

        .alldetail .col-md-6:nth-last-of-type(4n-3) .detail,
        .alldetail .col-md-6:nth-last-of-type(4n-2) .detail {
            background: #f9f9f9;
        }

        .detail {
            padding: 10px 0;
            margin: 0;
            border: 1px solid #eeeeee;
            border-collapse: collapse;
            border-bottom: 0px;
            font-size: 12px;
            border-bottom: 0px;
        }

        .mytable {
            border: 1px solid #EFF3F9;
        }

        .back-color {
            background: #F1F5FA !important;
            color: #475479 !important;
        }

        .table thead th {
            vertical-align: bottom;
            background: transparent !important;
            border-bottom: 2px solid #cfd8dc !important;
            color: #475479 !important;
        }

        .mytable thead th {
            border-bottom: 1px solid #EFF3F9 !important;
            border-top: 1px solid #EFF3F9 !important;
        }

        .mytable td {
            border-top: 1px solid #EFF3F9 !important;
            padding: 0.75rem !important;
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
                            <li class="breadcrumb-item">Update App Labels</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Update App Labels</h4>
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
                    <div >
                        <div class="card-block">
                            <div class="mT-30">
                                @include('common.error')
                                <form class="container" autocomplete="off" method="POST"
                                    action="{{ route('section.store') }}">
                                    @csrf
                                    {{-- <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Module Name</h5>

                                        </div>
                                        <div class="row">

                                            @foreach ($module as $res)
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom02">{{ language($res->language_id) }}<span
                                                            class="red">*</span></label>
                                                    <input type="text" class="form-control " name="module_name[]"
                                                        value="{{ $res->module_name }}" required>
                                                    <input type="hidden" value="{{ $res->id }}" name="module_ids[]">
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                    <br> --}}


                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Section Name</h5>

                                        </div>
                                        <div class="row">

                                            @foreach ($section as $res)
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom02">{{ language($res->language_id) }}<span
                                                            class="red">*</span></label>
                                                    <input type="text" class="form-control " name="section_name[]"
                                                        value="{{ $res->section_name }}" required>
                                                    <input type="hidden" value="{{ $res->id }}" name="section_ids[]">
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                    <br>

                                    {{-- <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Sub Section Name</h5>

                                        </div>
                                        <div class="row">

                                            @foreach ($sub_section as $res)
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom02">{{ language($res->language_id) }}<span
                                                            class="red">*</span></label>
                                                    <input type="text" class="form-control " name="sub_section_name[]"
                                                        value="{{ $res->sub_section_name }}" required>
                                                    <input type="hidden" value="{{ $res->id }}" name="sub_section_ids[]">
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                    <br> --}}


                                    {{-- <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>App Labels Name</h5>

                                        </div>
                                        <div class="row">
                                            @foreach ($app_label as $res)
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">{{ language($res->language_id) }}<span
                                                        class="red">*</span></label>
                                                <input type="text" class="form-control " name="app_label_name[]"
                                                    value="{{ $res->app_label_text }}" required>
                                                <input type="hidden" value="{{ $res->id }}" name="app_label_ids[]">
                                            </div>
                                        @endforeach

                                        @foreach ($app_label_language as $res)
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">{{ language($res->language_id) }}<span
                                                        class="red">*</span></label>
                                                <input type="text" class="form-control " name="app_label_text[]"
                                                    value="{{ $res->app_label_text }}" required>
                                                <input type="hidden" value="{{ $res->id }}"
                                                    name="app_label_lang_ids[]">
                                            </div>
                                        @endforeach

                                        </div>
                                    </div> --}}
                                     <br>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('section') }}" class="btn btn-sm btn-danger">Back</a>
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

        });
    </script>
@endsection
