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
                            <li class="breadcrumb-item">Add Category</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Add Category</h4>
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
                                <form class="container" method="POST" action="{{ route('category.store') }}">
                                    @csrf

                                    <div class="row">
                                         <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Type<span class="red">*</span></label>
                                           <select class="form-control form-control-sm" name="mst_cat_type" id="mst_cat_type">
                                            <option value="I">Individual</option>
                                            <option value="S">Shg</option>
                                            <option value="C">Cluster</option>
                                            <option value="F">Federation</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Category Name<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="mst_cat_name"  value="{{ old('mst_cat_name') }}" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Description<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="mst_cat_description"  value="{{ old('mst_cat_description') }}" autocomplete="off" required>
                                        </div>
                                         <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Status<span class="red">*</span></label>
                                           <select class="form-control form-control-sm" name="mst_cat_status" id="mst_cat_status">
                                            <option value="A">Active</option>
                                            <option value="I">Inactive</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('category') }}" class="btn btn-sm btn-danger">Back</a>
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
