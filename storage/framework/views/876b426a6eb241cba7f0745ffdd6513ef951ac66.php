

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
                        <li class="breadcrumb-item">Analytics/Initial Rating Results Report</li>
                    </ul>
                </div>
                <?php $session_data = Session::get('facilitator_filter_session'); ?>
                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Facilitator Wise Report</h4>
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
                            <form class="container" method="GET" action="<?php echo e(url('FacilitatorWiseReport')); ?>" id="needs-validation" autocomplete="off">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">Country</label>
                                        <select class="form-control" name="country" id="country">
                                            <option value="">--Select--</option>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($row->id); ?>" <?php echo e(((empty($session_data["country"]) || $session_data["country"]) && ($row->id == 101) ? "selected" : "")); ?>><?php echo e($row->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">State</label>
                                        <select class="form-control" name="state" id="state">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">District</label>
                                        <select class="form-control" name="district" id="district">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">Facilitator</label>
                                        <input type="text" name="facilitator" id="facilitator" class="form-control" autocomplete="off">
                                        <div id="fedlist" style="position:absolute;top:0px; margin-top:21px;max-height:50px"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Date</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="text" value="" name="dt_from" class="form-control datepicker" placeholder="From" id="dt_from">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" value="" name="dt_to" class="form-control datepicker" placeholder="To" id="dt_to">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">&nbsp;</label>
                                        <input type="submit" class="btn btn-sm btn-success" name="Search" value="Search" style="float:left;margin-top: 2.5em;">
                                        <button class="btn  btn-sm btn-danger" name="clear" value="clear" style="float: left;;margin-top:2.5em;margin-left: 10px;">Clear</button>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="export_icon_css" style="top: 32%">
                                            <a href="<?php echo e(url('export_facilitator')); ?>" id="export">
                                                <img src="<?php echo e(asset('assets\images\excel.png')); ?>" data-toggle="tooltip" title="Excel Export" data-src="<?php echo e(asset('assets\images\excel.png')); ?>" srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x" alt="Excel Export" title="Excel" class="lzy lazyload--done" style="height: 35px;">
                                            </a>
                                        </div>
                                        <div class="export_pdf_css" style="top: 32%;right: 12% !important;">
                                            <a href="<?php echo e(URL::to('/facilitatorWiseReportPdf')); ?>">
                                                <img src="<?php echo e(asset('assets\images\pdf.png')); ?>" data-toggle="tooltip" title="PDF Download" alt="PDF Download" title="PDF Download" class="lzy lazyload--done" style="height: 35px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="dt-responsive table-responsive">
                                <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th width="15%">Country</th>
                                            <th width="15%">State</th>
                                            <th width="15%">Facilitator Name</th>
                                            <th width="10%">Total Task Assigned</th>
                                            <th width="10%">Total Task Completed</th>
                                            <th width="10%">Total Task Pending</th>
                                            <th width="10%">Action</th>
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
        <!-- Modal -->
        <div class="modal fade right" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
            <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
                <div class="modal-content-full-width modal-content ">
                    <div class=" modal-header-full-width   modal-header text-center">
                        <h5 class="modal-title w-100" id="exampleModalPreviewLabel" style="position: relative;left:30%;">Task Assigned</h5>

                        <div class="col-md-7 mb-4" ">
                            <div class="export_icon_css">
                                <a href="javascript:void(0)" id="export" onclick="ExportToExcel('xlsx')">
                                    <img src="<?php echo e(asset('assets\images\excel.png')); ?>" data-toggle="tooltip" title="Excel Export" data-src="<?php echo e(asset('assets\images\excel.png')); ?>" srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x" alt="Excel Export" title="Excel" class="lzy lazyload--done" style="height: 35px;">
                                </a>
                            </div>
                            <div class="export_pdf_css" style="top:32%;">
                                <a href="<?php echo e(URL::to('/taskassignedReportPdf')); ?>" id="abc">
                                    <img src="<?php echo e(asset('assets\images\pdf.png')); ?>" data-toggle="tooltip" title="PDF Download" alt="PDF Download" title="PDF Download" class="lzy lazyload--done" style="height: 35px;">
                                </a>
                            </div>
                        </div>
                        <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                            <span style="font-size: 1.3em;" aria-hidden="true" style="font-size: 50px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <table id="taskTable" class="table table-striped table-bordered nowrap" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Assignment Type</th>
                                    <th>Task</th>
                                    <th>Assign Date</th>
                                    <th>Completed Date</th>
                                    <th>Task Status </th>
                                    <th>Manager Status</th>
                                    <th>Manager Submitted</th>
                                    <th>Dart Team Status</th>
                                    <th>Dart Team Status</th>
                                </tr>
                            </thead>

                        </table>

                    </div>
                    <div class="modal-footer-full-width  modal-footer">
                        <button type="button" class="btn btn-danger btn-md btn-rounded" data-dismiss="modal">Close</button>

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
    <script src="<?php echo e(asset('assets\js\table_excel.js')); ?>"></script>

    <script>
        function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('taskTable');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Task_Assigend_Report.' + (type || 'xlsx')));
    }
        $(document).on('click', function(e) {
            if ($(e.target).closest("#fedlist").length === 0) {
                $("#fedlist").hide();
            }
        });
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
                    "url": '<?php echo e(route("FacilitatorWiseReport.index")); ?>',
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

        function get_state_list() {
            var obj = $(this);
            var country = obj.val();
            if (country > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_state',
                    data: '_token = <?php echo csrf_token(); ?>&country=' + country,

                    success: function(data) {
                        if (data != '') {
                            $('#state').html(data);
                            <?php echo!empty($session_data["state"]) && $session_data["state"] > 0 ? "$('#state').val('".$session_data["state"].
                            "');": ""
                            ?>
                            $('#state').trigger("change");

                        }
                    }
                });
            }
        }

        function get_district_list() {
            var obj = $(this);
            var state = obj.val();
            if (state > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_district',
                    data: '_token = <?php echo csrf_token(); ?>&state=' + state,

                    success: function(data) {
                        if (data != '') {
                            $('#district').html(data);
                            <?php echo!empty($session_data["district"]) && $session_data["district"] > 0 ? "$('#district').val('".$session_data["district"].
                            "');": ""
                            ?>
                            $('#district').trigger("change");
                        }
                    }
                });
            }
        }

        function get_fed_suggestion() {
            var query = $(this).val();
            var country = $('#country').val();
            var state = $('#state').val();
            var district = $('#district').val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    type: 'get',
                    url: '/get_facilitator_suggestion',
                    data: {
                        query: query,
                        _token: _token,
                        country: country,
                        state: state,
                        district: district
                    },
                    success: function(data) {
                        $('#fedlist').fadeIn();
                        $('#fedlist').html(data);
                        <?php echo!empty($session_data["facilitator"]) && $session_data["facilitator"] > 0 ? "$('#facilitator').val('".$session_data["facilitator"].
                        "');": ""
                        ?>
                        $('#facilitator').trigger("change");
                    }
                });
            }


        }
        $(document).on('click', 'li', function() {
            var cls = $(this).find('a').attr('class');
            if (cls != 'norecord') {
                $('#facilitator').val($(this).text());
                $('#fedlist').fadeOut();
            }

        });
        $(document).ready(function() {
            var today = new Date();
            var tomorrow = new Date();
            tomorrow.setDate(today.getDate() - 1);

            $('#country').on('change', get_state_list);
            $('#state').on('change', get_district_list);
            $('#country').trigger('change');
            <?php echo!empty($session_data["country"]) && $session_data["country"] > 0 ? "$('#country').val('".$session_data["country"].
            "');$('#country').trigger('change');": ""
            ?>
            $('#facilitator').on('keyup', get_fed_suggestion);
            <?php echo!empty($session_data["facilitator"]) ? "$('#facilitator').val('".$session_data["facilitator"].
            "');": ""
            ?>
            <?php echo!empty($session_data["dt_from"]) && $session_data["dt_from"] > 0 ? "$('#dt_from').val('".$session_data["dt_from"].
            "');": ""
            ?>
            <?php echo!empty($session_data["dt_to"]) && $session_data["dt_to"] > 0 ? "$('#dt_to').val('".$session_data["dt_to"].
            "');": ""
            ?>
            

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                endDate: tomorrow,
                enableOnReadonly: false
            });
        });


        function getTaskDetails(userID,state_id) {

            $('#myModal').modal('show');
            if (userID != '') {
                $.ajax({
                    type: 'get',
                    url: '/get_task_assignment_details',
                    data: '_token = <?php echo csrf_token(); ?>&userID=' + userID + '&state_id=' + state_id,
                    success: function(data) {
                        $('#taskTable').html(data);
                        $('#abc').attr('href', "<?php echo e(URL::to('/taskassignedReportPdf')); ?>?" + 'userID=' + userID +'&'+ 'state_id=' + state_id);
                    }
                });
            }
        }
    </script>

    <?php $__env->stopSection(); ?>
    <!-- data-table js -->

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/facilitatorWiseReport/list.blade.php ENDPATH**/ ?>