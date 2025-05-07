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
                            <li class="breadcrumb-item">Update Question</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Update Question</h4>
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
                                <form class="container" method="POST" action="{{ route('questions.update',$question->mst_id)}}" autocomplete="off">
                                    @method('PATCH')
                                    @csrf
                                    <input type="hidden" name="mst_id" value="{{ ( !empty($question->mst_id) ? $question->mst_id : '') }}">

                                    <div class="row">
                                         <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Category<span class="red">*</span></label>
                                           <select class="form-control form-control-sm" name="mst_category_id" id="mst_category_id">
                                            <option>--Select--</option>
                                            @foreach($category as $value)
                                            <option value="{{$value->mst_id}}">{{$value->mst_cat_name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Sub Category<span class="red">*</span></label>
                                           <select class="form-control form-control-sm" name="mst_sub_category_id" id="mst_sub_category_id" required>
                                            <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Question Name<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="mst_ques_name"  value="{{$question->mst_ques_name}}" autocomplete="off" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Description<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="mst_ques_description"  value="{{$question->mst_ques_description}}" autocomplete="off" required>
                                        </div>
                                        </div>
                                    <div class="row">
                                         <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Status<span class="red">*</span></label>
                                           <select class="form-control form-control-sm" name="mst_ques_status" id="mst_ques_status">
                                            <option value="A">Active</option>
                                            <option value="I">Inactive</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('questions') }}" class="btn btn-sm btn-danger">Back</a>
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
        <script type="text/javascript">
            $('#mst_category_id').on('change',function(event){
                var mst_category_id=$('#mst_category_id').val();
                 $.ajax({
                type: 'GET',
                url: "/get_subcategory",
                data: 'mst_category_id=' + mst_category_id,
                success: function (data) {
                        // alert(data);
                        if (data != '') {
                            $('#mst_sub_category_id').html(data);
                            $('#mst_sub_category_id').val("{{( !empty($question->mst_sub_category_id) ? $question->mst_sub_category_id : '')}}");
                        }
                    }
                });
            });
        </script>
        <script type="text/javascript">
        $( document ).ready(function() {
    $('#mst_ques_status').val("{{( !empty($question->mst_ques_status) ? $question->mst_ques_status : '')}}");
    $('#mst_category_id').val("{{( !empty($question->mst_category_id) ? $question->mst_category_id : '')}}");
    $('#mst_category_id').trigger('change');
});
</script>

    </div>

@endsection
