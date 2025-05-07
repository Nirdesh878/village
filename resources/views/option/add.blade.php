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
                            <li class="breadcrumb-item">Add Option</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Add Option</h4>
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
                                <form class="container" method="POST" action="{{ route('option.store') }}">
                                    @csrf

                                    <div class="row">
                                         <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Category<span class="red">*</span></label>
                                           <select class="form-control form-control-sm" name="mst_category_id" id="mst_category_id" required>
                                            <option value="">--Select--</option>
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
                                            <div class="col-md-12 mb-3">
                                            <label for="validationCustom02">Question<span class="red">*</span></label>
                                           <select class="form-control form-control-sm" name="mst_ques_id" id="mst_ques_id" required>
                                            <option value="">--Select--</option>
                                            </select>
                                        </div>
                                         </div>
                                         <div class="row">
                                        <div class="col-md-12 mb-3">
                                              <label for="validationCustom02">Description<span class="red">*</span></label>
                                            <input type="text" class="form-control" name="mst_description" id="mst_description" required>
                                        </div>
                                    </div>
                                    <div class="row"><h5>Manage Options</h5></div>
                                    <div class="row">
                                        <table class="table" id="option_table">
                                            <tbody>
                                                <thead>
                                                <th>#</th>
                                                <th width="60%">Option</th>
                                                <th  width="10%">Marks</th>
                                                <th  width="15%">Status</th>
                                                <th width="15%">Action</th>
                                                </thead>
                                       <tbody>     
                                    @php for($i=0;$i<7;$i++){ @endphp
                                    <tr>
                                    <td><span class="sn">{{$i+1}}</span></td>
                                    <td><input type="text" name="mst_ans_name[]" class="mst_ans_name form-control"></td>
                                    <td><input type="text" name="mst_point[]" class="mst_point form-control"></td>
                                    <td><select name="mst_status[]" class="form-control mst_status"><option value="A">Active</option>
                                    <option value="I" selected="">Inactive</option></select></td>
                                    <td>
                                        <button class="btn btn-primary btn-link btn-sm add_option" type="button" onclick="add_option(this);" title="Add Option"><i class="c-white-500 ti-plus"></i></button>
                                        <button class="btn btn-danger btn-link btn-sm delete_option"  type="button" onclick="delete_option(this);" title="Delete Option"><i class="c-white-500 ti-minus"></i></button>
                                    </td>
                                    </tr>
                                    
                               @php } @endphp
                                      </tbody>
                                        </table>  
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('option') }}" class="btn btn-sm btn-danger">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

                        }
                    }
                });
            });
             $('#mst_sub_category_id').on('change',function(event){
                var mst_category_id=$('#mst_category_id').val();
                var mst_sub_category_id=$('#mst_sub_category_id').val();
                 $.ajax({
                type: 'GET',
                url: "/get_questions",
                data: 'mst_category_id=' + mst_category_id+'&mst_sub_category_id='+mst_sub_category_id,
                success: function (data) {
                        // alert(data);
                        if (data != '') {
                            $('#mst_ques_id').html(data);

                        }
                    }
                });
            });
function delete_option(elem){             
             if ($('.delete_option').length > 7)
                      bootbox.confirm({
                        title: "Option Deleted",
                        message: "Are you sure, you want to delete the Option ?",
                        callback: function (result) {
                            if(result){
                $(elem).parents('tr').remove();
                $('.sn').each(function( index ) {
                var val=$(this).index('.sn');
                $(this).text(val+1);
            });
            }
        }
    });
              }
function add_option(elem) {
            var cloned = $(elem).parents('tr').clone(true);
            $(cloned).find('input').val('');
            $(cloned).find('select').val('I');
            $(cloned).find('.sn').text($('.sn').length+1);
            $(cloned).insertAfter($('#option_table tbody tr:last'));
            $('.sn').each(function( index ) {
                var val=$(this).index('.sn');
                $(this).text(val+1);
            });
        }  
 $('.mst_status').on('change',function(){
            var index=$(this).index('.mst_status');
            var value=$(this).val();
            if (value=='A') {
                $('.mst_point').eq(index).attr('required','required');
            }
            else{
                 $('.mst_point').eq(index).removeAttr('required');
            }

        });                   
        </script>
        <!-- Page-body end -->
    </div>

@endsection
