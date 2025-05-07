

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
                            <li class="breadcrumb-item">Quality Wise Report</li>
                        </ul>
                    </div>
                    <?php $session_data = Session::get('quality_filter_session'); ?>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Quality Wise Report</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="export_icon_css" style="margin-top: -32px;">
                        <a href="<?php echo e(url('export_quality')); ?>" id="export">
                            <img src="<?php echo e(asset('assets\images\excel.png')); ?>" data-toggle="tooltip"
                                title="Excel Export" data-src="<?php echo e(asset('assets\images\excel.png')); ?>"
                                srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x" alt="Excel Export"
                                title="Excel" class="lzy lazyload--done" style="height: 35px;">
                        </a>
                    </div>
                    <div class="export_pdf_css" style="margin-top: -32px; right: 11% !important;">
                        <a href="<?php echo e(URL::to('/qualityWiseReportPdf')); ?>">
                            <img src="<?php echo e(asset('assets\images\pdf.png')); ?>" data-toggle="tooltip" title="PDF Download"
                                alt="PDF Download" title="PDF Download" class="lzy lazyload--done" style="height: 35px;">
                        </a>
                    </div>
                </div>
            </div>
            <!-- Page-header end -->
            <!-- Page-body start -->
            <div class="page-body" style="margin-top: 10px">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Zero config.table start -->
                        <div class="card">
                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <table id="simpletable" class="table table-striped table-bordered nowrap"
                                        style="width: 100% !important;">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>

                                                <th>Quality</th>
                                                <th>Total Task Assigned</th>
                                                <th>Total Task Completed</th>
                                                <th>Total Task Pending</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page-body end -->
        </div>

        <style>
            .modal-dialog-full-width {
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: none !important;

            }

            .modal-content-full-width {
                height: auto !important;
                min-height: 100% !important;
                border-radius: 0 !important;
                background-color: #ececec !important
            }

            .modal-header-full-width {
                border-bottom: 1px solid #9ea2a2 !important;
            }

            .modal-footer-full-width {
                border-top: 1px solid #9ea2a2 !important;
            }

        </style>

         <!-- model -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog mw-100 w-75" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header-full-width   modal-header ">
                    <h4 class="modal-title" style="position:relative;left:40%;">Quality Wise Report</h4>
                    <div class="col-md-7 mb-4">
                        <div class=" export_pdf_css" style="position:relative;left:10%;top:15px;">
                            <a href="<?php echo e(URL::to('/qualityTaskAssignmentPdf')); ?>" id="abc">
                                <img src="<?php echo e(asset('assets\images\pdf.png')); ?>" data-toggle="tooltip" title="PDF Download" alt="PDF Download" title="PDF Download" class="lzy lazyload--done" style="height: 35px;">
                            </a>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <table id="taskTable" class="table table-striped table-bordered nowrap" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>UIN</th>
                                <th>Assignment Type</th>
                                <th>Task</th>
                                <th>Manager Status</th>
                                <th>Manager Submitted</th>
                            </tr>
                        </thead>

                    </table>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
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
            //$("#taskTable").DataTable();
            var table = $('#simpletable').DataTable({
                "sDom": "rtipl",
                "processing": true,
                "serverSide": true, //Feature control DataTables' servermside processing mode.
                "bFilter": true,
                "bLengthChange": false,
                "ordering": false,
                "iDisplayLength": 10,
                "responsive": false,
                "ajax": {
                    "url": '<?php echo e(route('QualityWiseReport.index')); ?>',
                    "type": "GET",
                    "dataType": "json",
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

        function getTaskDetails(userID) {
            $('#myModal').modal('show');
            if (userID != '') {
                $.ajax({
                    type: 'get',
                    url: '/get_quality_task_assignment_details',
                    data: '_token = <?php echo csrf_token(); ?>&userID=' + userID,
                    success: function(data) {
                        $('#taskTable').html(data);
                        $('#abc').attr('href', "<?php echo e(URL::to('/qualityTaskAssignmentPdf')); ?>?" + 'userID=' +
                            userID);
                    }
                });
            }
        }
    </script>

<?php $__env->stopSection(); ?>
<!-- data-table js -->

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/QualityWiseReport/list.blade.php ENDPATH**/ ?>