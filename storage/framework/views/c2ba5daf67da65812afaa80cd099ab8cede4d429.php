

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
                        <li class="breadcrumb-item">Family</li>
                    </ul>
                </div>
                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Family</h4>
                    </div>
                </div>
            </div>
            <div class="export_icon_css" style="margin-top: -32px;">
                <a href="<?php echo e(url('FamilyExport')); ?>" id="export">
                    <img src="<?php echo e(asset('assets\images\excel.png')); ?>" data-toggle="tooltip" title="Excel Export" data-src="<?php echo e(asset('assets\images\excel.png')); ?>" srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x" alt="Excel Export" title="Excel" class="lzy lazyload--done" style="height: 35px;">
                </a>
            </div>
            <div class="export_pdf_css" style="margin-top: -32px;  !important;">
                <a href="<?php echo e(URL::to('/familyPDF')); ?>">
                    <img src="<?php echo e(asset('assets\images\pdf.png')); ?>" data-toggle="tooltip" title="PDF Download" alt="PDF Download" title="PDF Download" class="lzy lazyload--done" style="height: 35px;">
                </a>
            </div>
            
                <div class="col-lg-4 text-right">
                    <a href="<?php echo e(url('family/create')); ?>" class="btn cur-p btn-sm btn-success">Create Family
                    </a>
                </div>
          
        </div>
    </div>

    <div class="page-body">
        <?php if($user->u_type == 'CEO' || $user->u_type == 'A'): ?>
            <div class="row pb-4">
            <!-- task, page, download counter  start -->
            <div class="col-sm">
                <div class="w-box1 s-box">
                    <div class="d-flex">
                        <div class="count"><h4>Onboarded Family</h4><h3><?php echo e(getCount('family_mst')); ?></h3></div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="w-box2 s-box">
                    <div class="d-flex">
                        <div class="count"><h4>Onboarded SHG</h4><h3><?php echo e(getCount('shg_mst')); ?></h3></div>

                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="w-box3 s-box">
                    <div class="d-flex">
                        <div class="count"><h4>Onboarded Cluster</h4><h3><?php echo e(getCount('cluster_mst')); ?></h3></div>

                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="w-box4 s-box">
                    <div class="d-flex">
                        <div class="count"><h4>Onboarded Federation</h4><h3><?php echo e(getCount('federation_mst')); ?></h3></div>

                    </div>
                </div>
            </div>

        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <table id="simpletable" class="table table-striped table-bordered nowrap" style="width: auto">
                                <thead>
                                    <tr>
                                        <th width="2%">S.No</th>
                                        <th width="5%">UIN</th>
                                        <th width="10%">SHG Member Name</th>
                                        <th width="10%">SHG</th>
                                        <th width="10%">Cluster</th>
                                        <th width="10%">Federation</th>
                                        <th width="10%">Task Status</th>
                                        <th width="8%">Created At</th>
                                        <th width="8%">Last Update</th>
                                        <th widyh="7%">Locked</th>
                                        <th widyh="8%">Status</th>
                                        <th width="15%">Action</th>
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
        "url": '<?php echo e(route('family.index')); ?>',
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
            message: "Are you sure, you want to delete this Family?",
            callback: function (result) {
                if(result)
                {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var url = '<?php echo e(route("family.destroy", ":id")); ?>';
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/family/list.blade.php ENDPATH**/ ?>