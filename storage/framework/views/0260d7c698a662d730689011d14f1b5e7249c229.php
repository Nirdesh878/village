

<?php $__env->startSection('content'); ?>

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
                        <li class="breadcrumb-item">Category</li>
                    </ul>
                </div>
                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Categories</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-right">
                    <a href="<?php echo e(url('category/create')); ?>" class="btn cur-p btn-sm btn-success">Create Category</a>
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
                        <div class="dt-responsive table-responsive">
                        <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                                <thead>
                                <tr>
                                    <th width="2%">S.No</th>
                                    <th width="20%">Category Name</th>
                                    <th width="20%">Description</th>
                                    <th width="20%">Status</th>
                                    <th width="20%">Created At</th>
                                    <th width="20%">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>

<script src="<?php echo e(asset('bower_components\datatables.net\js\jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-buttons\js\dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets\pages\data-table\js\jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets\pages\data-table\js\pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets\pages\data-table\js\vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-buttons\js\buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-buttons\js\buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-responsive\js\dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js')); ?>"></script>
<script>
    $(function(){
        var table = $('#simpletable').DataTable({
        "processing":true,
        "serverSide": true, //Feature control DataTables' servermside processing mode.
        "bFilter" : true,
        "bLengthChange": false,
        "ordering"  : false,
        "iDisplayLength" : 10,
        "responsive"  :false,
        "ajax": {
        "url": '<?php echo e(route('category.index')); ?>',
        "type": "GET",
        "dataType": "json",
        "dataSrc": function (jsonData) {
        return jsonData.data;
      }
    },
    //Set column definition initialisation properties.
    "columnDefs": [
    {
        "targets": [ 0 ], //first column / numbering column
        "orderable": false, //set not orderable
      },
      ],

    });
        // dataTable();
    });
    function fn_delete(id)
    {
        bootbox.confirm({
            title: "",
            message: "Are you sure, you want to delete this Category?",
            callback: function (result) {
                if(result)
                {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var url = '<?php echo e(route("category.destroy", ":id")); ?>';
                    url = url.replace(':id', id);

                    $.ajax({

                        type: "POST",
                        data:{
                            _token: "<?php echo e(csrf_token()); ?>",
                            _method:"DELETE"
                        },
                        url: url,
                        dataType: 'JSON'

                    })
                    .done(function(response){
                        bootbox.alert({title: "Deleted?", message: response.message});
                        location.reload();
                    })
                    .fail(function(response){
                        bootbox.alert({title: "Deleted?",
                            message: 'Something Went Wrong..'});
                    })
                }
            }
        });
    }

</script>

<?php $__env->stopSection(); ?>
<!-- data-table js -->

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/category/list.blade.php ENDPATH**/ ?>