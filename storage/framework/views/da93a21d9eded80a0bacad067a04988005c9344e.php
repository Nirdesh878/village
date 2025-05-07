

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
                    <?php $session_data = Session::get('fed_filter_session'); ?>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Analytics/Initial Rating Results Report
                                <?php
                                    //prd($countries);
                                    if (!empty($session_data['group'])) {
                                        if ($session_data['group'] == 'FD') {
                                            echo '(Federation)';
                                        }
                                        if ($session_data['group'] == 'CL') {
                                            echo '(Cluster)';
                                        }
                                        if ($session_data['group'] == 'SH') {
                                            echo '(SHG)';
                                        }
                                        // if($session_data['group'] == 'FM')
                                        // {
                                        //     echo "(Family)";
                                        // }
                                    }
                                ?>
                            </h4>
                        </div>
                        <div class="pull-right">
                            <div class="export_icon_css">
                                <a href="<?php echo e(url('export_fedreport')); ?>" id="export">
                                    <img src="<?php echo e(asset('assets\images\excel.png')); ?>" data-toggle="tooltip"
                                        title="Excel Export"
                                        data-src="<?php echo e(asset('assets\images\excel.png')); ?>"
                                        alt="Excel Export" title="Excel" class="lzy lazyload--done" style="height: 35px;">
                                </a>
                            </div>
                            <div class="export_pdf_css">
                                <a href="<?php echo e(URL::to('/products/create-pdf')); ?>"><img
                                        src="<?php echo e(asset('assets\images\pdf.png')); ?>" data-toggle="tooltip"
                                        title="PDF Download" alt="PDF Download" title="PDF Download"
                                        class="lzy lazyload--done" style="height: 35px;"></a>
                            </div>
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
                                <form class="container" method="GET" action="<?php echo e(url('fedreports')); ?>"
                                    id="needs-validation" autocomplete="off">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">

                                        <div class="col-md-2 mb-3">
                                            <label for="validationCustom02">Group Type</label>
                                            <select class="form-control" name="group" id="group">
                                                <option value="">--Select--</option>
                                                <option value="AG">Agency</option>
                                                <option value="FM">Family</option>
                                                <option value="SH">SHG</option>
                                                <option value="CL">Cluster</option>
                                                <option value="FD">Federation</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationCustom02">Country</label>
                                            <select class="form-control" name="country" id="country">
                                                <option value="">--Select--</option>
                                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($row->id); ?>"
                                                        <?php echo e((empty($session_data['country']) || $session_data['country']) && $row->id == 101 ? 'selected' : ''); ?>>
                                                        <?php echo e($row->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationCustom02">State</label>
                                            <select class="form-control" name="state" id="state">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationCustom02">District</label>
                                            <select class="form-control" name="district" id="district">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationCustom02">Name</label>
                                            <input type="text" name="federation" id="federation" class="form-control"
                                                value="" autocomplete="off">
                                            <div id="fedlist"
                                                style="position:absolute;top:0px; margin-top:21px;max-height:50px"></div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationCustom02">&nbsp;</label>
                                            <input type="submit" class="btn btn-sm btn-success" name="Search" value="Search"
                                                style="float:left;margin-top: 2.5em;">
                                            <button class="btn  btn-sm btn-danger" name="clear" value="clear"
                                                style="float: left;;margin-top:2.5em;margin-left: 10px;">Clear</button>

                                        </div>
                                    </div>
                                </form>

                                <div class="dt-responsive table-responsive">
                                    <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php if(!empty($session_data['country'])): ?>
                                        <table class="table table-striped table-bordered"
                                            style="margin-bottom: 0rem; !important;">
                                            <thead>
                                                <th>Country : <?php echo e(getCountryByID($session_data['country'])); ?></th>
                                            </thead>
                                        </table>

                                    <?php endif; ?>
                                    <table id="simpletable" class="table table-striped table-bordered nowrap"
                                        style="width: 100% !important;">
                                        <thead>
                                            <tr>

                                                <?php if(!empty($session_data['group']) && empty($session_data['federation'])): ?>
                                                    <th>S.No</th>
                                                    <th width="10%">Analytics/Initial Rating done by</th>
                                                    <?php echo !empty($session_data["group"]) && $session_data["group"]=='CL' ? "<th width='15%'>Cluster Name</th>" : (!empty($session_data["group"]) && $session_data["group"]=='SH' ? "<th width='15%'>SHG Name</th><th width='15%'>Cluster Name</th>" : "") ?>
                                                    <?php echo !empty($session_data["group"]) && $session_data["group"]=='FM' ? "<th width='15%'>SHG Member Name</th><th width='15%'>SHG Name</th><th width='15%'>Cluster Name</th>" : "" ?>
                                                    <?php echo !empty($session_data["group"]) && $session_data["group"]=='AG' ? "<th width='15%'>Agency Name</th><th width='15%'>SHG Member Name</th><th width='15%'>SHG Name</th><th width='15%'>Cluster Name</th>" : "" ?>
                                                    <th width="15%">Federation Name</th>
                                                    <?php if(!empty($session_data)): ?>
                                                        <?php if(!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                            <th width="10%">State</th>
                                                        <?php elseif(!empty($session_data['country']) &&
                                                            !empty($session_data['state']) &&
                                                            empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                        <?php endif; ?>

                                                    <?php else: ?>
                                                        <th width="10%">District</th>
                                                        <th width="10%">State</th>
                                                    <?php endif; ?>

                                                    <th width="10%">Observations by field faciliators</th>
                                                    <th width="10%">Initial Rating Score </th>
                                                    <th width="10%">Initial Rating Results </th>
                                                    <th width="10%">Verfieid By District Manager </th>
                                                    <th width="15%">Verfieid By ViV staff </th>
                                                    <th width="5%">Locked </th>
                                                <?php elseif(!empty($session_data['federation']) &&
                                                    !empty($session_data['group'])): ?>
                                                    
                                                    <?php if($session_data['group'] == "AG" && !empty($session_data['federation'])): ?>
                                                    <th>S.No</th>
                                                    <th>Group Type</th>
                                                    <th>UIN</th>
                                                    <th width="10%">Analytics/Initial Rating done by</th>
                                                    <th width='15%'>SHG Member Name</th>
                                                    <th width='15%'>SHG Name</th>
                                                    <th width='15%'>Cluster Name</th>
                                                    <th width="15%">Federation Name</th>
                                                    <?php if(!empty($session_data)): ?>
                                                        <?php if(!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                            <th width="10%">State</th>
                                                        <?php elseif(!empty($session_data['country']) &&
                                                            !empty($session_data['state']) &&
                                                            empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                        <?php endif; ?>

                                                    <?php else: ?>
                                                        <th width="10%">District</th>
                                                        <th width="10%">State</th>
                                                    <?php endif; ?>
                                                    <th width="10%">Observations by field faciliators</th>
                                                    <th width="10%">Initial Rating Score </th>
                                                    <th width="10%">Initial Rating Results </th>
                                                    <th width="10%">Verfieid By District Manager </th>
                                                    <th width="15%">Verfieid By ViV staff </th>
                                                    <th width="5%">Locked </th>
                                                    
                                                    <?php elseif($session_data['group'] == "FM" && !empty($session_data['federation'])): ?>
                                                    <th>S.No</th>
                                                    <th>Group Type</th>
                                                    <th>Family-UIN</th>
                                                    <th width="10%">Analytics/Initial Rating done by</th>
                                                    <th width='15%'>Agency Name</th>
                                                    
                                                    <th width='15%'>SHG Name</th>
                                                    <th width='15%'>Cluster Name</th>
                                                    <th width="15%">Federation Name</th>
                                                    <?php if(!empty($session_data)): ?>
                                                        <?php if(!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                            <th width="10%">State</th>
                                                        <?php elseif(!empty($session_data['country']) &&
                                                            !empty($session_data['state']) &&
                                                            empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                        <?php endif; ?>

                                                    <?php else: ?>
                                                        <th width="10%">District</th>
                                                        <th width="10%">State</th>
                                                    <?php endif; ?>
                                                    <th width="10%">Observations by field faciliators</th>
                                                    <th width="10%">Initial Rating Score </th>
                                                    <th width="10%">Initial Rating Results </th>
                                                    <th width="10%">Verfieid By District Manager </th>
                                                    <th width="15%">Verfieid By ViV staff </th>
                                                    <th width="5%">Locked </th>
                                                    
                                                    
                                                    <?php elseif($session_data['group'] == "SH" && !empty($session_data['federation'])): ?>
                                                    <th>S.No</th>
                                                    <th>Group Type</th>
                                                    <th>SHG-UIN</th>
                                                    <th width="10%">Analytics/Initial Rating done by</th>
                                                    <th width='15%'>Agency Name</th>
                                                    <th width='15%'>SHG Member Name</th>
                                                    <th width='15%'>Cluster Name</th>
                                                    <th width="15%">Federation Name</th>
                                                    <?php if(!empty($session_data)): ?>
                                                        <?php if(!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                            <th width="10%">State</th>
                                                        <?php elseif(!empty($session_data['country']) &&
                                                            !empty($session_data['state']) &&
                                                            empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                        <?php endif; ?>

                                                    <?php else: ?>
                                                        <th width="10%">District</th>
                                                        <th width="10%">State</th>
                                                    <?php endif; ?>
                                                    <th width="10%">Observations by field faciliators</th>
                                                    <th width="10%">Initial Rating Score </th>
                                                    <th width="10%">Initial Rating Results </th>
                                                    <th width="10%">Verfieid By District Manager </th>
                                                    <th width="15%">Verfieid By ViV staff </th>
                                                    <th width="5%">Locked </th>
                                                    
                                                    <?php elseif($session_data['group'] == "CL" && !empty($session_data['federation'])): ?>
                                                    <th>S.No</th>
                                                    <th>Group Type</th>
                                                    <th>Cluster-UIN</th>
                                                    <th width="10%">Analytics/Initial Rating done by</th>
                                                    <th width='15%'>Agency Name</th>
                                                    <th width='15%'>SHG Member Name</th>
                                                    <th width='15%'>SHG Name</th>
                                                    <th width="15%">Federation Name</th>
                                                    <?php if(!empty($session_data)): ?>
                                                        <?php if(!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                            <th width="10%">State</th>
                                                        <?php elseif(!empty($session_data['country']) &&
                                                            !empty($session_data['state']) &&
                                                            empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                        <?php endif; ?>

                                                    <?php else: ?>
                                                        <th width="10%">District</th>
                                                        <th width="10%">State</th>
                                                    <?php endif; ?>
                                                    <th width="10%">Observations by field faciliators</th>
                                                    <th width="10%">Initial Rating Score </th>
                                                    <th width="10%">Initial Rating Results </th>
                                                    <th width="10%">Verfieid By District Manager </th>
                                                    <th width="15%">Verfieid By ViV staff </th>
                                                    <th width="5%">Locked </th>
                                                    
                                                    <?php elseif($session_data['group'] == "FD" && !empty($session_data['federation'])): ?>
                                                    <th>S.No</th>
                                                    <th>Group Type</th>
                                                    <th>Federation-UIN</th>
                                                    <th width="10%">Analytics/Initial Rating done by</th>
                                                    <th width='15%'>Agency Name</th>
                                                    <th width='15%'>SHG Member Name</th>
                                                    <th width='15%'>SHG Name</th>
                                                    <th width="15%">cluster Name</th>
                                                    <?php if(!empty($session_data)): ?>
                                                        <?php if(!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                            <th width="10%">State</th>
                                                        <?php elseif(!empty($session_data['country']) &&
                                                            !empty($session_data['state']) &&
                                                            empty($session_data['district'])): ?>
                                                            <th width="10%">District</th>
                                                        <?php endif; ?>

                                                    <?php else: ?>
                                                        <th width="10%">District</th>
                                                        <th width="10%">State</th>
                                                    <?php endif; ?>
                                                    <th width="10%">Observations by field faciliators</th>
                                                    <th width="10%">Initial Rating Score </th>
                                                    <th width="10%">Initial Rating Results </th>
                                                    <th width="10%">Verfieid By District Manager </th>
                                                    <th width="15%">Verfieid By ViV staff </th>
                                                    <th width="5%">Locked </th>
                                                    <?php endif; ?>
                                                <?php endif; ?>
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
            $(document).on('click', function(e) {
                if ($(e.target).closest("#fedlist").length === 0) {
                    $("#fedlist").hide();
                }
            });
            $(function() {
                var table = $('#simpletable').DataTable({
                    "processing": true,
                    "serverSide": true, //Feature control DataTables' servermside processing mode.
                    "bFilter": false,
                    "bLengthChange": false,
                    "ordering": false,
                    "iDisplayLength": 10,
                    "responsive": false,
                    "ajax": {
                        "url": '<?php echo e(route('fedreports.index')); ?>',
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
                                <?php echo !empty($session_data["state"]) && $session_data["state"]>0 ? "$('#state').val('".$session_data["state"]."');" : "" ?>
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
                                <?php echo !empty($session_data["district"]) && $session_data["district"]>0 ? "$('#district').val('".$session_data["district"]."');" : "" ?>
                                $('#district').trigger("change");
                            }
                        }
                    });
                }
            }

            function get_fed_suggestion() {
                var query = $(this).val();
                var group = $('#group').val();
                var country = $('#country').val();
                var state = $('#state').val();
                var district = $('#district').val();

                if (query != '') {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        type: 'get',
                        url: '/get_fed_suggestion',
                        data: {
                            query: query,
                            _token: _token,
                            country: country,
                            state: state,
                            district: district,
                            group: group
                        },
                        success: function(data) {
                            $('#fedlist').fadeIn();
                            $('#fedlist').html(data);
                            <?php echo !empty($session_data["federation"]) && $session_data["federation"]>0 ? "$('#federation').val('".$session_data["federation"]."');" : "" ?>
                            $('#federation').trigger("change");
                        }
                    });
                }


            }
            $(document).on('click', 'li', function() {
                var cls = $(this).find('a').attr('class');
                if (cls != 'norecord') {
                    $('#federation').val($(this).text());
                    $('#fedlist').fadeOut();
                }

            });

            $(document).ready(function() {

                $('#country').on('change', get_state_list);
                $('#state').on('change', get_district_list);
                $('#country').trigger('change');
                <?php echo !empty($session_data["group"])>0 ? "$('#group').val('".$session_data["group"]."');" : "" ?>
                <?php echo !empty($session_data["country"]) && $session_data["country"]>0 ? "$('#country').val('".$session_data["country"]."');$('#country').trigger('change');" : "" ?>
                $('#federation').on('keyup', get_fed_suggestion);
                <?php echo !empty($session_data["federation"]) ? "$('#federation').val('".$session_data["federation"]."');" : "" ?>



            });
        </script>

    <?php $__env->stopSection(); ?>
    <!-- data-table js -->

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/fedreports/list.blade.php ENDPATH**/ ?>