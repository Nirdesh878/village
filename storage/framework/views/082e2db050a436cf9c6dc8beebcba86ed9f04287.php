

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
                            <li class="breadcrumb-item">Family Pre-Assignment</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Family Pre-Assignment</h4>
                        </div>
                    </div>
                </div>
                <div class="export_icon_css" style="margin-top: -32px;">
                    <a href="<?php echo e(url('FamilyTasklist')); ?>" id="export">
                        <img src="<?php echo e(asset('assets\images\excel.png')); ?>" data-toggle="tooltip" title="Excel Export"
                            data-src="<?php echo e(asset('assets\images\excel.png')); ?>"
                            srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x" alt="Excel Export"
                            title="Excel" class="lzy lazyload--done" style="height: 35px;">
                    </a>
                </div>
                <div class="export_pdf_css" style="margin-top: -32px;">
                    <a href="<?php echo e(URL::to('/familyTasklistPdf')); ?>">
                        <img src="<?php echo e(asset('assets\images\pdf.png')); ?>" data-toggle="tooltip" title="PDF Download"
                            alt="PDF Download" title="PDF Download" class="lzy lazyload--done" style="height: 35px;">
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
                            <button class="btn btn-info " type="button" id="btn1" title="Pending"
                                style="width:150px;font-size:18px;">Pending</button>
                            <button class="btn btn-info" type="button" id="btn2" title="Complete"
                                style="width:140px;font-size:18px;">Complete</button>
                            <a href="<?php echo e(url('/preanalytics_task')); ?>"><button class="btn btn-success" type="button"
                                    title="Assign Task" style="width:140px;font-size:18px;">Assign Task </button></a>
                            <div class="dt-responsive table-responsive" id="table1">
                                <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th width="20%">Family-UIN</th>
                                            <th width="15%">Name</th>
                                            <th width="10%">SHG</th>
                                            <th width="10%">Facilitator</th>
                                            <th width="10%">Task</th>
                                            <th width="10%">Status</th>
                                            <th width="15%">Created At</th>
                                            <th width="15%">Update At</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="dt-responsive table-responsive" id="table2">
                                <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <table id="simpletable1" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th width="20%">Family-UIN</th>
                                            <th width="15%">Name</th>
                                            <th width="10%">SHG</th>
                                            <th width="10%">Facilitator</th>

                                            <th width="10%">Task</th>
                                            <th width="10%">Status</th>
                                            <th width="15%">Created At</th>
                                            <th width="15%">Update At</th>
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
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="resp">
                    <div class="form-group row">
                        <label class="col-md-3 offset-md-1 form-control-label" for="input-small">Action </label>
                        <div class="col-md-6">
                            <select class="form-control form-control-sm" name="TaskAssignment_status"
                                id="TaskAssignment_status">
                                <option value="R">Reject</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 offset-md-1 form-control-label" for="input-small">
                            <label for="TaskAssignment_remark" class="required">Remark </label></label>
                        <div class="col-md-6" id="remark_txt">
                            <textarea class="form-control form-control-sm" name="TaskAssignment_remark" id="TaskAssignment_remark"
                                autocomplete="off"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="task_id" value="" id="task_id">
                    <span style="font-size:12px; color: red;margin-left: 39px;"><i>Note : The task will rejected completely
                            and will not be accepted in the future.</i></span>
                    </p>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="return submitAction()">Save</button>
                </div>
            </div>

        </div>
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
                    "url": '<?php echo e(route('preanalytics.create')); ?>',
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
        $(function() {
            var table = $('#simpletable1').DataTable({
                "processing": true,
                "serverSide": true, //Feature control DataTables' servermside processing mode.
                "bFilter": true,
                "bLengthChange": false,
                "ordering": false,
                "iDisplayLength": 10,
                "responsive": false,
                "ajax": {
                    "url": '<?php echo e(url('family_pre_task')); ?>',
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
            //alert(id);
            bootbox.confirm({
                title: "",
                message: "Are you sure, you want to delete this Task?",
                callback: function(result) {
                    if (result) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var url = '<?php echo e(route('preanalytics.destroy', ':id')); ?>';
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

        function Close() {
            $('#task_id').val('');
            return true;
        }

        function append_id($id) {
            $('#task_id').val($id);
        }

        function submitAction() {
            var id = $('#task_id').val();

            var sts = $('#TaskAssignment_status').val();
            var rmk = $('#TaskAssignment_remark').val();
            $.ajax({
                url: '/change_task_status_fed',
                type: 'GET',
                data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts + '&rmk=' + rmk,
                success: function(response) {
                    data = JSON.parse(response);
                    if (data.result == 1) {
                        window.location.href = "<?php echo e(url('preanalytics/create')); ?>";
                    }
                }
            });

        }
        $(document).ready(function() {
            $('#table2').hide();
            $('#btn2').css({
                "background-color": "",
                "opacity": "0.5"
            });
        });
        $('#btn1').on('click', function(e) {
            $('#table2').hide();
            $('#table1').show();
            $('#btn2').css({
                "background-color": "",
                "opacity": "0.5"
            });
            $('#btn1').css({
                "background-color": "",
                "opacity": "1"
            });
        });
        $('#btn2').on('click', function(e) {
            $('#table1').hide();
            $('#table2').show();
            $('#btn1').css({
                "background-color": "",
                "opacity": "0.5"
            });
            $('#btn2').css({
                "background-color": "",
                "opacity": "1"
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<!-- data-table js -->

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/preanalytics/add.blade.php ENDPATH**/ ?>