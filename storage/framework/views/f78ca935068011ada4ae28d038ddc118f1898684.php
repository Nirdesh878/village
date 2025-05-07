

<?php $__env->startSection('content'); ?>
<?php $user = \Illuminate\Support\Facades\Auth::user(); ?>
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
                        <li class="breadcrumb-item">Pre Assignment</li>
                    </ul>
                </div>
                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Pre Assignment</h4>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Page-header end -->

    <!-- Page-body start -->
    <div class="page-body">




    <?php if($user->u_type == 'CEO' || $user->u_type == 'A'): ?>
        <div class="row pb-4">
            <div class="col-sm">
                <a href="<?php echo e(url('preanalytics/create')); ?>">
                <div class="w-box1 s-box " style="background-color: antiquewhite;">
                    <div class="d-flex">
                        <div class="count"><h4>Pre Assignment</h4><h3>FAMILY</h3></div>
                    </div>
                </div></a>
            </div>
            <div class="col-sm">
                <a href="<?php echo e(url('shg_task')); ?>">
                <div class="w-box2 s-box" style="background-color: antiquewhite;">
                    <div class="d-flex">
                        <div class="count"><h4>Pre Assignment</h4><h3>SHG</h3></div>
                    </div>
                </div></a>
            </div>
            <div class="col-sm">
                <a href="<?php echo e(url('cluster_task')); ?>">
                <div class="w-box3 s-box" style="background-color: antiquewhite;">
                    <div class="d-flex">
                        <div class="count"><h4>Pre Assignment</h4><h3>CLUSTER</h3></a></div>
                    </div>
                </div></a>
            </div>
            <div class="col-sm">
                <a href="<?php echo e(url('federation_task')); ?>">
                <div class="w-box4 s-box" style="background-color: antiquewhite;">
                    <div class="d-flex">
                        <div class="count"><h4>Pre Assignment</h4><h3>FEDERATION</h3></a></div>
                    </div>
                </div></a>
            </div>
        </div>
        <?php endif; ?>
        <hr>
        <div class="page-header-title">
                    <div class="d-inline">
                        <span><h4>Task Assignment</h4></span><span style="color:black;"><h6> (For All Groups)</h6></span>
                    </div>
                </div>
                <br>
                <br>
        <div class=" pb-4">
            <div class="col-sm" style="width:300px;margin-left:-15px;">
                <a href="<?php echo e(url('/preanalytics_task')); ?>">
                <div class="w-box2 s-box " style="background-color: antiquewhite;">
                    <div >
                        <div class="count" ><h4></h4><h3>Assign Task</h3></div>
                    </div>
                </div></a>
            </div>
        </div>
        <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
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
        "url": '<?php echo e(route('preanalytics.index')); ?>',
        "type": "GET",
        "dataType": "json",
        "data": function(data) {
            // manipulate data used in ajax request prior to server call
            delete data.columns;
        },
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
            message: "Are you sure, you want to delete this Partner/Organization?",
            callback: function (result) {
                if(result)
                {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var url = '<?php echo e(route("preanalytics.destroy", ":id")); ?>';
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/preanalytics/list.blade.php ENDPATH**/ ?>