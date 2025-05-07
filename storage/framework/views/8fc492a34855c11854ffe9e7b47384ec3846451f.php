

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
                            <li class="breadcrumb-item">My Facilitator</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>My Facilitator</h4>
                        </div>
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
                                                <th width="40%">Name</th>
                                                <th width="20%">UIN</th>
                                                <th width="20%">E-Mail</th>
                                                <th width="20%">Contact</th>
                                                
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
        </div>
    </div>



    <!-- Page-body end -->
    </div>



    <style>
        .export_icon_css {
            position: absolute !important;
            z-index: 1 !important;
            left: 125% !important;
            top: -40% !important;
        }

        .export_pdf_css {
            position: absolute !important;
            z-index: 1 !important;
            left: 133% !important;
            top: -46% !important;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            border: none;
            position: relative;
            margin-bottom: 30px;
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
        }

        .l-bg-cherry {
            background: linear-gradient(to right, #493240, #f09) !important;
            color: #fff;
        }

        .l-bg-blue-dark {
            background: linear-gradient(to right, #373b44, #4286f4) !important;
            color: #fff;
        }

        .l-bg-green-dark {
            background: linear-gradient(to right, #0a504a, #38ef7d) !important;
            color: #fff;
        }

        .l-bg-orange-dark {
            background: linear-gradient(to right, #a86008, #ffba56) !important;
            color: #fff;
        }

        .card .card-statistic-3 .card-icon-large .fas,
        .card .card-statistic-3 .card-icon-large .far,
        .card .card-statistic-3 .card-icon-large .fab,
        .card .card-statistic-3 .card-icon-large .fal {
            font-size: 110px;
        }

        .card .card-statistic-3 .card-icon {
            text-align: center;
            line-height: 50px;
            margin-left: 15px;
            color: #000;
            position: absolute;
            right: -5px;
            top: 20px;
            opacity: 0.1;
        }

        .l-bg-cyan {
            background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
            color: #fff;
        }

        .l-bg-green {
            background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
            color: #fff;
        }

        .l-bg-orange {
            background: linear-gradient(to right, #f9900e, #ffba56) !important;
            color: #fff;
        }

        .l-bg-cyan {
            background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
            color: #fff;
        }

    </style>

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
                
                "processing": true,
                "serverSide": true, //Feature control DataTables' servermside processing mode.
                "bFilter": true,
                "bLengthChange": false,
                "ordering": false,
                "iDisplayLength": 10,
                "responsive": false,
                "ajax": {
                    "url": '<?php echo e(route('facilitator.index')); ?>',
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
    </script>

<?php $__env->stopSection(); ?>
<!-- data-table js -->

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/Facilitator/list.blade.php ENDPATH**/ ?>