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
                            <li class="breadcrumb-item">Add Sub Category</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Add Sub Category</h4>
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
                                <form class="container" method="POST" action="{{ route('subcategory.store') }}" autocomplete="off">
                                    @csrf

                                    <div class="row">
                                         <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Category<span class="red">*</span></label>
                                           <select class="form-control form-control-sm" name="mst_category_id" id="mst_category_id">
                                            @foreach($category as $value)
                                            <option value="{{$value->mst_id}}">{{$value->mst_cat_name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Sub Category Name<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="mst_subcat_name"  value="{{ old('mst_subcat_name') }}" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Description<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="mst_subcat_description"  value="{{ old('mst_subcat_description') }}" autocomplete="off" required>
                                        </div>
                                         <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Status<span class="red">*</span></label>
                                           <select class="form-control form-control-sm" name="mst_subcat_status" id="mst_subcat_status">
                                            <option value="A">Active</option>
                                            <option value="I">Inactive</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('subcategory') }}" class="btn btn-sm btn-danger">Back</a>
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
