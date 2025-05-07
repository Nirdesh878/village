

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
                            <li class="breadcrumb-item">Cummulative Report</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Cummulative Report</h4>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page-header end -->


            <!-- Page-body start -->
            <div class="page-body">
                <div class="row" id="all_tables">
                    <div class="row mb-5">
                        <div class="col-sm-8 mt-4">
                            <div class="col-sm-12">
                                <!-- Zero config.table start -->
                                <div class="card">
                                    <div class="card-block" id="table_fed1">
                                        <div class="w-box">
                                            <div class="w-heading d-flex">
                                                
                                                <div class="ml-auto">
                                                    
                                                    
                                                    <a href="<?php echo e(URL::to('/cummulative-report-pdf')); ?>"><img
                                                            src="<?php echo e(asset('assets\images\pdf.png')); ?>"
                                                            data-toggle="tooltip" title="PDF Download" alt="PDF Download"
                                                            title="PDF Download" class="lzy lazyload--done"
                                                            style="margin-right: 10px;margin-bottom: 2px;height: 35px;"></a>
                                                    <a href="javascript:;" id="excel_button"
                                                        onclick="ExportToExcel('xlsx')"
                                                        style="margin-bottom: 10px;padding-right: 10px; height: 35px;">
                                                        <img src="<?php echo e(asset('assets\images\excel.png')); ?>"
                                                            data-toggle="tooltip" title="Excel Export"
                                                            data-src="<?php echo e(asset('assets\images\excel.png')); ?>"
                                                            srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x"
                                                            alt="Excel Export" title="Excel" class="lzy lazyload--done"
                                                            style="height: 35px;">
                                                    </a>
                                                    <a href="#" 
                                                        style="margin-right: 10px;margin-bottom: 4px;"></a>

                                                </div>
                                            </div>
                                            <table style="display:none;font-weight:bold;">
                                                <thead>
                                                    <tr >
                                                        <td>Country</td>
                                                        <td><?php echo e(!empty($country_name[0]->name) ? $country_name[0]->name : 'India'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>State</td>
                                                        <td><?php echo e(!empty($state_name[0]->name) ? $state_name[0]->name : '-'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>District</td>
                                                        <td><?php echo e(!empty($district_name[0]->name) ? $district_name[0]->name : '-'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Agency</td>
                                                        <td><?php echo e(!empty($agency) ? $agency : '-'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>From</td>
                                                        <td><?php echo e(!empty($from) ? change_date_month_name_char(str_replace('/','-',$from)) : '-'); ?></td>
                                                    </tr> 
                                                    <tr>   
                                                        <td>To</td>
                                                        <td><?php echo e(!empty($to) ? change_date_month_name_char(str_replace('/','-',$to)) : '-'); ?></td>
                                                    </tr>
                                                    
                                                </thead>
                                            </table>
                                            <table >
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                            
                                            <table class="table text-center mytable" id="table_fed">
                                                
                                                <thead class="back-color">
                                                    <tr>
                                                        <th colspan="7"><h5>Federation</h5></th>
                                                        <th  class="btn btn-outline-primary btn-success">Total:<?php echo $Federation_a[0]->Federation_Total ; ?></th>
                                                    </tr>
                                                    <tr class= "table-height">
                                                        <th></th>
                                                        <th>Initiated</th>
                                                        <th>Completed</th>
                                                        <th>Pending</th>
                                                        <th class="text-nowrap">Minimal Risk</th>
                                                        <th class="text-nowrap">Low Risk</th>
                                                        <th class="text-nowrap">Moderate Risk</th>
                                                        <th class="text-nowrap">High Risk</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class= "table-height">
                                                        <td class="font-weight-bold">Analytics</td>
                                                        <td><?php echo $Federation_a[0]->Federation_Total; ?></td>
                                                        <td><?php echo $Federation_a[0]->Federation_Full_Analytics; ?></td>
                                                        <td><?php echo $Federation_a[0]->Federation_Total - $Federation_a[0]->Federation_Full_Analytics; ?></td>
                                                        <td class="green"><?php echo $Federation_a[0]->green_analysis; ?></td>
                                                        <td class="yellow"><?php echo $Federation_a[0]->yellow_analysis; ?></td>
                                                        <td class="grey"><?php echo $Federation_a[0]->grey_analysis; ?></td>
                                                        <td class="red_status"><?php echo $Federation_a[0]->red_analysis; ?></td>
                                                    </tr>
                                                    <tr class= "table-height">
                                                        <td class="font-weight-bold">Ratings</td>
                                                        <td><?php echo $Federation_r[0]->Federation_Total; ?></td>
                                                        <td><?php echo $Federation_r[0]->Federation_Full_Rating; ?></td>
                                                        <td><?php echo $Federation_r[0]->Federation_Total - $Federation_r[0]->Federation_Full_Rating; ?></td>

                                                        <td class="green"><?php echo $Federation_r[0]->green_rate; ?></td>
                                                        <td class="yellow"><?php echo $Federation_r[0]->yellow_rate; ?></td>
                                                        <td class="grey"><?php echo $Federation_r[0]->grey_rate; ?></td>
                                                        <td class="red_status"><?php echo $Federation_r[0]->red_rate; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="w-box mt-4">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <table class="table text-center mytable" id="table_cluster">
                                                <thead class="back-color">
                                                    <tr>
                                                        <th colspan="7"><h5>Cluster</h5></th>
                                                        <th  class="btn btn-outline-primary btn-success">Total:<?php echo $Cluster_a[0]->Cluster_Total ; ?></th>
                                                    </tr>
                                                    <tr class= "table-height">
                                                        <th></th>
                                                        <th>Initiated</th>
                                                        <th>Completed</th>
                                                        <th>Pending</th>
                                                        <th class="text-nowrap">Minimal Risk</th>
                                                        <th class="text-nowrap">Low Risk</th>
                                                        <th class="text-nowrap">Moderate Risk</th>
                                                        <th class="text-nowrap">High Risk</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class= "table-height">
                                                        <td class="font-weight-bold">Analytics</td>
                                                        <td><?php echo $Cluster_a[0]->Cluster_Total; ?></td>
                                                        <td><?php echo $Cluster_a[0]->Cluster_Full_Analytics; ?></td>
                                                        <td><?php echo $Cluster_a[0]->Cluster_Total - $Cluster_a[0]->Cluster_Full_Analytics; ?></td>
                                                        <td class="green"><?php echo $Cluster_a[0]->green_analysis; ?></td>
                                                        <td class="yellow"><?php echo $Cluster_a[0]->yellow_analysis; ?></td>
                                                        <td class="grey"><?php echo $Cluster_a[0]->grey_analysis; ?></td>
                                                        <td class="red_status"><?php echo $Cluster_a[0]->red_analysis; ?></td>
                                                    </tr>
                                                    <tr class= "table-height">
                                                        <td class="font-weight-bold">Ratings</td>
                                                        <td><?php echo $Cluster_r[0]->Cluster_Total; ?></td>
                                                        <td><?php echo $Cluster_r[0]->Cluster_Full_Rating; ?></td>
                                                        <td><?php echo $Cluster_r[0]->Cluster_Total - $Cluster_r[0]->Cluster_Full_Rating; ?></td>
                                                        <td class="green"><?php echo $Cluster_r[0]->green_rate; ?></td>
                                                        <td class="yellow"><?php echo $Cluster_r[0]->yellow_rate; ?></td>
                                                        <td class="grey"><?php echo $Cluster_r[0]->grey_rate; ?></td>
                                                        <td class="red_status"><?php echo $Cluster_r[0]->red_rate; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="w-box mt-4">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <table class="table text-center mytable" id="table_shg" style="font-weight: bold">
                                                <thead class="back-color">
                                                    <tr>
                                                        <th colspan="7"><h5>SHG</h5></th>
                                                        <th  class="btn btn-outline-primary btn-success">Total:<?php echo $Shg_a[0]->Shg_Total ; ?></th>
                                                    </tr>
                                                    <tr class= "table-height">
                                                        <th></th>
                                                        <th>Initiated</th>
                                                        <th>Completed</th>
                                                        <th>Pending</th>
                                                        <th class="text-nowrap">Minimal Risk</th>
                                                        <th class="text-nowrap">Low Risk</th>
                                                        <th class="text-nowrap">Moderate Risk</th>
                                                        <th class="text-nowrap">High Risk</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class= "table-height">
                                                        <td class="font-weight-bold">Analytics</td>
                                                        <td><?php echo $Shg_a[0]->Shg_Total; ?></td>
                                                        <td><?php echo $Shg_a[0]->Shg_Full_Analytics; ?></td>
                                                        <td><?php echo $Shg_a[0]->Shg_Total - $Shg_a[0]->Shg_Full_Analytics; ?></td>
                                                        <td class="green"><?php echo $Shg_a[0]->green_analysis; ?></td>
                                                        <td class="yellow"><?php echo $Shg_a[0]->yellow_analysis; ?></td>
                                                        <td class="grey"><?php echo $Shg_a[0]->grey_analysis; ?></td>
                                                        <td class="red_status"><?php echo $Shg_a[0]->red_analysis; ?></td>
                                                    </tr>
                                                    <tr class= "table-height">
                                                        <td class="font-weight-bold">Ratings</td>
                                                        <td><?php echo $Shg_r[0]->Shg_Total; ?></td>
                                                        <td><?php echo $Shg_r[0]->Shg_Full_Rating; ?></td>
                                                        <td><?php echo $Shg_r[0]->Shg_Total - $Shg_r[0]->Shg_Full_Rating; ?></td>
                                                        <td class="green"><?php echo $Shg_r[0]->green_rate; ?></td>
                                                        <td class="yellow"><?php echo $Shg_r[0]->yellow_rate; ?></td>
                                                        <td class="grey"><?php echo $Shg_r[0]->grey_rate; ?></td>
                                                        <td class="red_status"><?php echo $Shg_r[0]->red_rate; ?></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="w-box mt-4">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                            
                                            <table class="table text-center mytable" id="table_family">
                                                <thead class="back-color">
                                                    <tr>
                                                        <th colspan="7"><h5>Family</h5></th>
                                                        <th  class="btn btn-outline-primary btn-success">Total:<?php echo $Family_a[0]->Family_Total ; ?></th>
                                                    </tr>
                                                    <tr class= "table-height">
                                                        <th></th>
                                                        <th>Initiated</th>
                                                        <th>Completed</th>
                                                        <th>Pending</th>
                                                        <th class="text-nowrap">Minimal Risk</th>
                                                        <th class="text-nowrap">Low Risk</th>
                                                        <th class="text-nowrap">Moderate Risk</th>
                                                        <th class="text-nowrap">High Risk</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class= "table-height">
                                                        <td class="font-weight-bold">Analytics</td>
                                                        <td><?php echo $Family_a[0]->Family_Total; ?></td>
                                                        <td><?php echo $Family_a[0]->Fully_Completed; ?></td>
                                                        <td><?php echo $Family_a[0]->Family_Total - $Family_a[0]->Fully_Completed; ?></td>
                                                        <td class="green"><?php echo $Family_a[0]->green_analysis; ?></td>
                                                        <td class="yellow"><?php echo $Family_a[0]->yellow_analysis; ?></td>
                                                        <td class="grey"><?php echo $Family_a[0]->grey_analysis; ?></td>
                                                        <td class="red_status"><?php echo $Family_a[0]->red_analysis; ?></td>
                                                    </tr>
                                                    <tr class= "table-height">
                                                        <td class="font-weight-bold">Ratings</td>
                                                        <td><?php echo $Family_r[0]->Family_Total; ?></td>
                                                        <td><?php echo $Family_r[0]->Completed_Rating; ?></td>
                                                        <td><?php echo $Family_r[0]->Family_Total - $Family_r[0]->Completed_Rating; ?></td>

                                                        <td class="green"><?php echo $Family_r[0]->green_rate; ?></td>
                                                        <td class="yellow"><?php echo $Family_r[0]->yellow_rate; ?></td>
                                                        <td class="grey"><?php echo $Family_r[0]->grey_rate; ?></td>
                                                        <td class="red_status"><?php echo $Family_r[0]->red_rate; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="card">
                                <div class="card-block">
                                    <div class="w-box">
                                        <div class="w-heading d-flex mb-3 font-weight-bold">
                                            <h5>Search</h5>
                                        </div>

                                        <form class="container" autocomplete="off" method="GET"
                                            action="<?php echo e(url('CummulativeReport')); ?>" id="needs-validation">
                                            <?php echo csrf_field(); ?>
                                            <?php
                                                $session_data = Session::get('Cummulative_filter_session');
                                            ?>
                                            <div class="form-group">
                                                <label class="font-weight-bold"
                                                    for="exampleFormControlSelect1">Country</label>
                                                <select class="form-control" id="country" name="country">
                                                    <option value="">--Select--</option>
                                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($row->id); ?>" <?php echo e(((empty($session_data["country"]) || $session_data["country"]) && ($row->id == 101) ? "selected" : "")); ?>><?php echo e($row->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold"
                                                    for="exampleFormControlSelect1">State</label>
                                                <select class="form-control" id="state" name="state">
                                                    <option value="">--Select--</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold"
                                                    for="exampleFormControlSelect1">District</label>
                                                <select class="form-control" id="district" name="district">
                                                    <option value="">--Select--</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold"
                                                    for="exampleFormControlSelect1">Agency</label>
                                                <input type="text" name="agency" id="agency" class="form-control"
                                                    autocomplete="off">
                                                <div id="agencylist" style="position:absolute;top:59.5%;">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold">Date</label>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <input type="text" value="<?php if ($model['Q']['dt_from'] != '') {
                                                                echo $model['Q']['dt_from'];
                                                            } ?>" name="dt_from"
                                                            class="form-control datepicker" placeholder="From" id="dt_from">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" value="<?php if ($model['Q']['dt_to'] != '') {
                                                                echo $model['Q']['dt_to'];
                                                            } ?>" name="dt_to"
                                                            class="form-control datepicker" placeholder="To" id="dt_to">
                                                    </div>
                                                </div>
                                            </div>

                                            <label for="validationCustom02">&nbsp;</label>
                                            <input type="submit" class="btn btn-sm btn-success" name="ytsearch01"
                                                value="Search" style="float:left;margin-top: 2.5em;">
                                            <button class="btn  btn-sm btn-danger" name="clear" value="clear"
                                                style="float: left;;margin-top:2.5em;margin-left: 10px;">Clear</button>
                                    </div>



                                    </form>
                                </div>
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
    <script src="<?php echo e(asset('assets\js\table_excel.js')); ?>"></script>
    <script src="<?php echo e(asset('assets\pages\data-table\js\pdfmake.min.js')); ?>"></script>


    <script>
        $(document).on('click', function(e) {
            if ($(e.target).closest("#agencylist").length === 0) {
                $("#agencylist").hide();
            }
        });

        function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('table_fed1');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Cummulative_Report.' + (type || 'xlsx')));
    }


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
        function get_agency_suggestion() {

            var query = $(this).val();
            var country = $('#country').val();
            var state = $('#state').val();
            var district = $('#district').val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    type: 'get',
                    url: '/get_agency_suggestion',
                    data: {
                        query: query,
                        _token: _token,
                        country: country,
                        state: state,
                        district: district
                    },
                    success: function(data) {
                        $('#agencylist').fadeIn();
                        $('#agencylist').html(data);
                        <?php echo !empty($session_data["agency"]) && $session_data["agency"]>0 ? "$('#agency').val('".$session_data["agency"]."');" : "" ?>
                        $('#agency').trigger("change");
                    }
                });
            }
        }
         $(document).on('click', 'li', function() {
            var cls = $(this).find('a').attr('class');
            if (cls != 'norecord') {
                $('#agency').val($(this).text());
                $('#agencylist').fadeOut();
            }

        });
        $(document).ready(function() {
            var today = new Date();
            var tomorrow = new Date();
            
            $('#country').on('change', get_state_list);
            $('#state').on('change', get_district_list);
            $('#country').trigger('change');
            <?php echo !empty($session_data["group"])>0 ? "$('#group').val('".$session_data["group"]."');" : "" ?>
            <?php echo !empty($session_data["country"]) && $session_data["country"]>0 ? "$('#country').val('".$session_data["country"]."');$('#country').trigger('change');" : "" ?>
            $('#agency').on('keyup', get_agency_suggestion);
            <?php echo !empty($session_data["agency"])  ? "$('#agency').val('".$session_data["agency"]."');" : "" ?>
            
            
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                endDate: tomorrow,
                enableOnReadonly: false
            });

        });

        function printDiv() {
            $("#all_tables").printThis({
                importCSS: true
            });
        }


    </script>

<?php $__env->stopSection(); ?>
<!-- data-table js -->

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/CummulativeReport/list.blade.php ENDPATH**/ ?>