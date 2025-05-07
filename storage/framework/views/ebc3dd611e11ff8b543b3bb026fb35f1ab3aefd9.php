<?php $__env->startSection('content'); ?>
<?php
    $user = Auth::user();
?>
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
                            <li class="breadcrumb-item">Dart Team</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Dart Team</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-right">
                    <a href="<?php echo e(url('users/create')); ?>" class="btn cur-p btn-sm btn-success">Create Users
                    </a>
                </div>
            </div>
        </div>

        <div class="page-body">

            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">
                            <form class="container" method="GET" action="<?php echo e(url('users')); ?>" id="needs-validation" autocomplete="off">
                                <?php echo csrf_field(); ?>
                                <?php $session_data = Session::get('user_filter_session'); ?>
                                <div class="form-group row">

                                    <label for="user_type" class="search_filter_div mb-3">User Type</label>
                                    <div class="col-md-2 col-sm-10">
                                        <select class="form-control" name="user_type" id="user_type">
                                            <option value="">--Select--</option>
                                            <option value="CEO">Super Admin</option>
                                            <option value="A">Admin</option>
                                            <option value="M">District Manager</option>
                                            <option value="QA">Quality Analyst</option>
                                            <option value="F">Facilitator</option>
                                        </select>
                                    </div>
                                    <div class="form-group row search_filter_div ml-2">
                                        <input type="submit" class="btn btn-sm btn-success" name="Search"
                                            value="Search">&nbsp;
                                        <button class="btn btn-sm btn-danger" name="clear" value="clear">Clear</button>
                                    </div>

                            </form>
                            <div class="col-md-2 mb-2" style="position: relative;left:35%;top:-15px;">

                                <div class="export_icon_css" style="top: 32%;">
                                    <a href="<?php echo e(url('export_user')); ?>" id="export">
                                        <img src="<?php echo e(asset('assets\images\excel.png')); ?>" data-toggle="tooltip" title="Excel Export" data-src="<?php echo e(asset('assets\images\excel.png')); ?>" srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x" alt="Excel Export" title="Excel" class="lzy lazyload--done" style="height: 35px;">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2" style="position: relative;left:25%;top:-15px;">
                                <div class="export_pdf_css" style="top:32%;margin-left:50px;">
                                    <a href="<?php echo e(URL::to('/usersPdf')); ?>">
                                        <img src="<?php echo e(asset('assets\images\pdf.png')); ?>" data-toggle="tooltip" title="PDF Download" alt="PDF Download" title="PDF Download" class="lzy lazyload--done" style="height: 35px;">
                                    </a>
                                </div>
                            </div>
                            <div class="dt-responsive table-responsive">
                                <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                       <tr>
                                            <th width="5%">S.No</th>
                                            <th width="15%">Name</th>
                                            <th width="15%">Email</th>
                                            <th width="10%">User Type</th>
                                            <?php if($user->u_type == 'CEO'): ?>
                                            <th width="10%">Password</th>
                                            <?php endif; ?>
                                            <th width="5%">Member Type</th>
                                            <th width="10%">Created At</th>
                                            <th width="10%">Last Upadate</th>
                                            <th width="10%">Status</th>
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
        $(function() {
            var table = $('#simpletable').DataTable({
                "processing": true,
                "serverSide": true, //Feature control DataTables' servermside processing mode.
                "bFilter": true,
                "bLengthChange": false,
                "ordering": false,
                "iDisplayLength": 10,
                "responsive": false,
                "ajax": {
                    "url": '<?php echo e(route('users.index')); ?>',
                    "type": "GET",
                    "dataType": "json",
                    "data": function(data) {
                        // manipulate data used in ajax request prior to server call
                        delete data.columns;
                    },
                    "dataSrc": function(jsonData) {
                        return jsonData.data;
                    }
                },
                //Set column definition initialisation properties.
                "columnDefs": [{
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                }, ],

            });
            // dataTable();
        });

        function fn_delete(id) {
            bootbox.confirm({
                title: "",
                message: "Are you sure, you want to delete this User?",
                callback: function(result) {
                    if (result) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var url = '<?php echo e(route('users.destroy', ':id')); ?>';
                        url = url.replace(':id', id);

                        $.ajax({

                                type: "POST",
                                data: {
                                    _token: "<?php echo e(csrf_token()); ?>",
                                    _method: "DELETE"
                                },
                                url: url,
                                dataType: 'JSON'

                            })
                            .done(function(response) {
                                bootbox.alert({
                                    title: "Deleted?",
                                    message: response.message
                                });
                                location.reload();
                            })
                            .fail(function(response) {
                                bootbox.alert({
                                    title: "Deleted?",
                                    message: 'Something Went Wrong..'
                                });
                            })
                    }
                }
            });
        }
        $(document).ready(function() {
            <?php echo !empty($session_data["user_type"]) && $session_data["user_type"]!='' ? "$('#user_type').val('".$session_data["user_type"]."');" : "" ?>
        });
    </script>

<?php $__env->stopSection(); ?>
<!-- data-table js -->

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/users/list.blade.php ENDPATH**/ ?>