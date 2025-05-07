

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
                        <li class="breadcrumb-item">Credit Loan Report</li>
                    </ul>
                </div>
                <?php $session_data = Session::get('credit_loan_filter_session'); ?>
                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Credit Loan Report
                        </h4>
                    </div>
                </div>
                <div class="export_icon_css" >
                    <a href="<?php echo e(url('credit_loan')); ?>" id="export">
                        <img src="<?php echo e(asset('assets\images\excel.png')); ?>" data-toggle="tooltip" title="Excel Export" data-src="<?php echo e(asset('assets\images\excel.png')); ?>" srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x" alt="Excel Export" title="Excel" class="lzy lazyload--done" style="height: 35px;">
                    </a>
                </div>
                <div class="export_pdf_css" style="margin-top: ;  !important;">
                    <a href="<?php echo e(URL::to('/credit_loan_report')); ?>">
                        <img src="<?php echo e(asset('assets\images\pdf.png')); ?>" data-toggle="tooltip" title="PDF Download" alt="PDF Download" title="PDF Download" class="lzy lazyload--done" style="height: 35px;">
                    </a>
                </div>
            </div>
        </div>
        <!-- Page-header end -->

        <!-- Page-body start -->
        <div class="page-body" style="margin-top: 10px;">

            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-block">
                            <form class="container" method="GET" action="#" id="needs-validation" autocomplete="off">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <label for="validationCustom02">Country</label>
                                        <select class="form-control" name="country" id="country">
                                            <option value="">--Select--</option>

                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($row->id); ?>" <?php echo e(((empty($session_data["country"]) || $session_data["country"]) && ($row->id == 101) ? "selected" : "")); ?>><?php echo e($row->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="validationCustom02">State</label>
                                        <select class="form-control" name="state" id="state">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="validationCustom02">District</label>
                                        <select class="form-control" name="district" id="district">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-4">
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
                                    <div class="col-md-4 mb-4">
                                        <label for="validationCustom02">Name</label>
                                        <input type="text" name="federation" id="federation" class="form-control"
                                            value="">

                                        <div id="fedlist"
                                            style="position:absolute;top:0px; margin-top:21px;max-height:50px"></div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">&nbsp;</label>
                                        <input type="submit" class="btn btn-sm btn-success" name="Search" value="Search" style="float:left;margin-top: 2.5em;">
                                        <button class="btn  btn-sm btn-danger" name="clear" value="clear" style="float: left;;margin-top:2.5em;margin-left: 10px;">Clear</button>

                                    </div>

                                    
                    </div>
                    </form>

                    <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                </div>
            </div>


            <div class="col-md-12 ">
                <div class="row ">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card l-bg-cherry">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Total Loan Demand</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                        <?php echo e(!empty($loans[0]->loan_demand) ? '₹ '.$loans[0]->loan_demand : '₹ 0'); ?>

                                        </h2>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="card l-bg-blue-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Total Loan Approved</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            <?php echo e(!empty($loans[0]->loan_approved) ? '₹ '.$loans[0]->loan_approved : '₹ 0'); ?>


                                        </h2>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="card l-bg-green-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Total Loan Disbursed</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            <?php echo e(!empty($loans[0]->loan_disbursed) ? '₹ '.$loans[0]->loan_disbursed : '₹ 0'); ?>


                                        </h2>
                                    </div>

                                </div>

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
    box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
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

.card .card-statistic-3 .card-icon-large .fas, .card .card-statistic-3 .card-icon-large .far, .card .card-statistic-3 .card-icon-large .fab, .card .card-statistic-3 .card-icon-large .fal {
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
    $(document).on('click', function(e) {
                if ($(e.target).closest("#fedlist").length === 0) {
                    $("#fedlist").hide();
                }
            });
    function get_state_list() {
        var obj = $(this);
        var country = obj.val();
        if (country > 0) {
            $.ajax({
                type: 'GET',
                url: '/get_state',
                data: '_token = <?php echo csrf_token() ?>&country=' + country,

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
                data: '_token = <?php echo csrf_token() ?>&state=' + state,

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
    
    function get_credit_suggestion(){
            var query    = $(this).val();
            var group    = $('#group').val();
            var country  = $('#country').val();
            var state    = $('#state').val();
            var district = $('#district').val();

            if(query !=''){
                var _token= $('input[name="_token"]').val();
                  $.ajax({
                    type:'get',
                    url: '/get_credit_suggestion',
                    data:{query:query, _token:_token,country:country,state:state,district:district,group:group},
                    success:function(data)
                    {
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
                $('#federation').on('keyup', get_credit_suggestion);
                <?php echo !empty($session_data["federation"]) ? "$('#federation').val('".$session_data["federation"]."');" : "" ?>
    });
</script>

<?php $__env->stopSection(); ?>
<!-- data-table js -->

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/creditloanreport/list.blade.php ENDPATH**/ ?>