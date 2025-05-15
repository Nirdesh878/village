<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Details </title>
</head>


<!-- Favicon icon -->
<link rel="icon" href="<?php echo e(asset('assets\images\favicon.png')); ?>" type="image/x-icon">
<!-- Google font-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
<!-- Required Fremwork -->

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\icon\themify-icons\themify-icons.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\icon\font-awesome\css\font-awesome.min.css')); ?>">
<!-- feather Awesome -->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\icon\feather\css\feather.css')); ?>">
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\css\jquery.min.css')); ?>">

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\css\style.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\css\jquery.mCustomScrollbar.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\pages\advance-elements\css\bootstrap-datetimepicker.css')); ?>">
<!-- Date-range picker css  -->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\bootstrap-daterangepicker\css\daterangepicker.css')); ?>">

<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\pages\data-table\css\buttons.dataTables.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css')); ?>">

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\fullcalendar\css\fullcalendar.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\fullcalendar\css\fullcalendar.print.css')); ?>" media='print'>

<script type="text/javascript" src="<?php echo e(asset('bower_components\jquery\js\jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('bower_components\jquery-ui\js\jquery-ui.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets\js\bootbox.js')); ?>"></script>

<link rel="stylesheet" href="<?php echo e(asset('bower_components\select2\css\select2.min.css')); ?>">

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css')); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components/multiselect/css/multi-select.css')); ?>" />

<!-- Switch component css -->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\switchery\css\switchery.min.css')); ?>">

<!-- owl carousel css -->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\owl.carousel\css\owl.carousel.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\owl.carousel\css\owl.theme.default.css')); ?>">

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\ekko-lightbox\css\ekko-lightbox.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\lightbox2\css\lightbox.css')); ?>">
<script type="text/javascript" src="<?php echo e(asset('assets\js\charts.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets\js\chartjs-plugin-datalabels.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets\js\chartjs-plugin-doughnutlabel.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets\js\chartjs-plugin-labels.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>


<style>
    .row-new {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    body {
        background-color: white;
    }

    .oval {
        width: 261px;
        height: 130px;
        background: red;
        border-radius: 130px / 65px;
    }

    .bar {
        width: 100%;
        height: 20px;
        margin-bottom: 5px;
    }

    .breakpoint {
        position: absolute;
        height: 100%;
        border-right: 2px dashed black;
    }

    .bar-chart {
        width: 500px;
        height: 30px;
        background-color: white;
        position: relative;
    }

    .upper-bar {
        width: 80%;
        height: 100%;
        background-color: green;
    }

    .lower-bar {
        width: 100%;
        height: 100%;
        background-color: red;
    }

    .chart-container {
        position: relative;
        width: 300px;
        height: 300px;
    }

    .chart-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-family: Arial, sans-serif;
        font-size: 20px;
        font-weight: bold;
        color: black;
    }

    .chart-container1 {
        position: relative;
        width: 300px;
        height: 300px;
    }

    .chart-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-family: Arial, sans-serif;
        font-size: 20px;
        font-weight: bold;
        color: black;
    }

    .family {
        text-align: center;
        margin: 0;
        padding: 9% 0;
        font-size: 24px;
        font-weight: bold;
    }

    .school {
        padding-left: 50px;
        padding-top: 10px;
    }

    canvas {
        display: block;
        margin: 0 auto;
    }

    .land {
        font-size: 25px;
        padding-left: 100px;
    }

    .goal {
        font-size: 25px;
        padding-left: 100px;
    }

    .house {
        font-size: 25px;
        padding-left: 100px;
    }

    .column {
        float: left;
        width: 33.33%;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .round {
        border-radius: 85%;
        width: 35px;
        height: 35px;
    }

    .table1 {
        width: 100%;
    }

    .table {
        border: 1px solid #e9ecef;
    }

    .table td,
    .table th {
        padding: .60rem;

    }

    .table td th {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;

    }



    .table-primary,
    .table-primary>td,
    .table-primary> {
        background-color: #D79477;
        color: black;
        font-size: 25px;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid white;
        background-color: #eeeeee;
    }

    .tdc {
        text-align: center;
    }

    .page-break {
        page-break-before: always;
    }

    th {
        text-align: left;
    }

    .row-news {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
        padding: 0;
    }

    .row-news .col-md-4 {
        padding: 0 15px;
        box-sizing: border-box;
    }

    .row-news .col-md-4 .table-responsive {
        height: 200px;
    }
</style>




<body class="antialiased container mt-5">
    <div class="bar-wrp-m">
        <button class="btn btn-sm getPDFbtn" onclick="getPDF()">GET PDF</button>
    </div>
    
    <div class="canvas_all_pdf">
        <div class="row ">
            <div class="column" style="width: 660px;margin-left: 228px;position: relative;
            left: 94px;">
                <h1 style="font-size: 30px">Family Profile (<?php echo e($family->uin); ?>)</h1>
            </div>
            <div class="column">
                <div class="oval" style="position: relative;left: 126px;top: 26px;background-color:<?php echo e($grdcolor); ?>">
                    <p class="family" style="text-transform:capitalize;">Family Wealth <br> Ranking <br>
                        <?php
                            $WealthData = getMstCommonData(7,$family_profile[0]->fp_wealth_rank ?? null);
                        ?>
                        <?php echo e($WealthData[0]->common_values ?? 'N/A'); ?>

                    </p>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <td colspan="5" style="border: none;font-size:32px;font-weight:bold;text-decoration: underline;text-align:center;">
                            BASIC INFORMATION
                        </td>
                    </tr>
                </thead>
            </table>
            
            <table>
                <thead>
                    <tr>
                        <td colspan="5" style="border: none;font-size:25px;font-weight:bold;">NAME AND OTHER DETAILS
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477;text-align: left;font-size: 20px;" colspan="2">Member
                            Details</td>
                        <td style="background-color:#D79477;text-align: left;font-size: 20px;" colspan="2">Location
                            Details</td>
                    </tr>
                </thead>
                <thead>
                    <tr class="table-primary">
                        <th width="25%">UIN</th>
                        <td width="25%"><?php echo e($family->uin); ?></td>
                        <th width="25%"> Village</th>
                        <td width="25%"><?php echo e($family_profile[0]->fp_village); ?></td>
                    </tr>
                    <tr>

                        <th width="25%">Member Name</th>
                        <td width="25%"><?php echo e($family_profile[0]->fp_member_name); ?></td>
                        <th width="25%"> Name of SHG</th>
                        <td width="25%"><?php echo e($shg_profile[0]->shgName); ?></td>
                    </tr>
                    <tr>

                        <th width="25%">Gender</th>
                        <?php
                            $GenderData = getMstCommonData(1,$family_profile[0]->fp_gender  ?? null);
                        ?>
                        <td><?php echo e($GenderData[0]->common_values ?? 'N/A'); ?></td>
                        <th width="25%"> Fedeartion</th>
                        <td width="25%"><?php echo e($fed_profile[0]->name_of_federation); ?></td>
                    </tr>

                    <tr>
                        <th width="25%">Age</th>
                        <td width="25%"><?php echo e(checkna($family_profile[0]->fp_age)); ?></td>
                        <th width="25%">Cluster/Habitation Fedeartion</th>
                        <td width="25%">
                            <?php echo e(!empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A'); ?>

                        </td>
                    </tr>
                    <tr>
                        <th width="25%">Spouse Name</th>
                        <td width="25%"><?php echo e(checkna($family_profile[0]->fp_spouse_name)); ?></td>
                        <th width="25%">Block</th>
                        <td width="25%"><?php echo e(checkna($family_profile[0]->fp_block)); ?>

                        </td>
                    </tr>
                    <tr>

                        <th width="25%"> Aadhar Number </th>
                        <td width="25%"><?php echo e(checkna(aadhar($family_profile[0]->fp_aadhar_no))); ?></td>
                        <th width="25%">District</th>
                        <td width="25%"><?php echo e(checkna($family_profile[0]->fp_district)); ?></td>
                    </tr>

                    <tr>
                        <th width="25%">Pan</th>
                        <td width="25%"><?php echo e(checkna(pan($family_profile[0]->fp_pan))); ?></td>
                        <th width="25%">State</th>
                        <td width="25%"><?php echo e(checkna($family_profile[0]->fp_state)); ?></td>
                    </tr>
                    <tr>
                        <th width="25%">Contact Number</th>
                        <td width="25%"><?php echo e(checkna($family_profile[0]->fp_contact_no)); ?></td>
                        <th width="25%">Country</th>
                        <td width="25%"><?php echo e($family_profile[0]->fp_country); ?></td>
                    </tr>
                    <tr>

                        <th width="25%">Female Headed</th>
                        <td width="25%">
                            <?php
                        $FemaleHeadedData = getMstCommonData(3,$family_profile[0]->fp_female_headed ?? null);
                    ?>
                    <?php echo e($FemaleHeadedData[0]->common_values ?? 'N/A'); ?>

                        </td>
                        <th>Caste</th>
                        <?php
                            $CasteData = getMstCommonData(2,$family_profile[0]->fp_caste ?? null);
                        ?>
                        <td><?php echo e($CasteData[0]->common_values ?? 'N/A'); ?></td>
                    </tr>
                </thead>

            </table>
            <br>
            
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;border:2px solid white">
                        <td style="border:1px solid white;background-color:#D79477;">Bank</td>
                        <td style="border:1px solid white;background-color:#D79477;">Account</td>
                        <td style="border:1px solid white;background-color:#D79477;">Account Number</td>
                        <td style="border:1px solid white;background-color:#D79477;">Account Holder</td>
                        <td style="border:1px solid white;background-color:#D79477;width:30%">Branch</td>

                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align: center;background-color: #eeeeee;">
                        <td style="border:1px solid white"><?php echo e(checkna($family_profile[0]->fp_bank)); ?></td>
                        <td style="border:1px solid white"><?php echo e(checkna($family_profile[0]->fp_bank_account)); ?></td>
                        <td style="border:1px solid white"><?php echo e(account($family_profile[0]->fp_account)); ?></td>
                        <td style="border:1px solid white"><?php echo e(checkna($family_profile[0]->fp_account_holder)); ?></td>
                        <td style="border:1px solid white"><?php echo e(checkna($family_profile[0]->fp_bank_branch)); ?></td>
                    </tr>


            </table>
            <br>
            
            <table>
                <thead>
                    <tr>
                        <td colspan="5" style="border: none;font-size:25px;font-weight:bold;">FAMILY MEMBERS</td>
                    </tr>
                </thead>
            </table>

            <table class="table table-stripped table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;border:2px solid white">
                        <td style="border:1px solid white;width:25%;background-color:#D79477;">Total</td>
                        <td style="border:1px solid white;width:25%;background-color:#D79477;">SHG Member & Spouse</td>
                        <td style="border:1px solid white;width:25%;background-color:#D79477;">Children</td>
                        <td style="border:1px solid white;width:25%;background-color:#D79477;">Others</td>
                    </tr>
                </thead>
                <thead>
                    <tr style="text-align: center;background-color: #eeeeee;">
                        <td style="border:1px solid white"><?php echo e((int) (int) $family_profile[0]->fp_family_mambers_no); ?>

                        </td>
                        <td style="border:1px solid white"><?php echo e((int) $family_profile[0]->shg_member_spouse); ?></td>
                        <td style="border:1px solid white"><?php echo e((int) $family_profile[0]->fp_children_no); ?></td>
                        <td style="border:1px solid white"><?php echo e((int) $family_profile[0]->fp_others_no); ?></td>

                    </tr>

                </thead>

            </table>


            
            <table>
                <thead>
                    <tr>
                        <td colspan="5" style="border: none;font-size:25px;font-weight:bold;">FAMILY MEMBERS
                            INFORMATION</td>
                    </tr>
                </thead>
            </table>

            <table class="table table-stripped table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;border:2px solid white">
                        <td style="border:1px solid white;background-color:#D79477;width:20%;">Name</td>
                        <td style="border:1px solid white;background-color:#D79477;width:20%;">Age</td>
                        <td style="border:1px solid white;background-color:#D79477;width:20%;">Gender</td>
                        <td style="border:1px solid white;background-color:#D79477;width:20%;">Relation</td>
                        <td style="border:1px solid white;background-color:#D79477;width:20%;">Education</td>

                    </tr>
                </thead>
                <thead>
                    <?php $__currentLoopData = $family_member_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $MGenderData = getMstCommonData(1,$res->gender  ?? null);
                    ?>
                    <?php
                        $MRelationData = getMstCommonData(5,$res->relation  ?? null);
                    ?>
                    <?php
                        $MeducationData = getMstCommonData(6,$res->education  ?? null);
                    ?>
                    <tr style="text-align: center;background-color: #eeeeee;">
                        <td style="border:1px solid white;text-align:left;"><?php echo e($res->name); ?></td>
                        <td style="border:1px solid white"><?php echo e($res->age); ?></td>
                        <td style="border:1px solid white"><?php echo e($MGenderData[0]->common_values ?? 'N/A'); ?></td>
                        <td style="border:1px solid white"><?php echo e($MRelationData[0]->common_values ?? 'N/A'); ?></td>
                        <td style="border:1px solid white"><?php echo e($MeducationData[0]->common_values ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </thead>

            </table>
            <br>
            
            <div class="row" style=" display:flex;">
                <div class="col-sm-6">
                    <div style="margin-right: 15px;right:300px;height:200px;border-radius: 90px;background-color: #ebe3e3;">
                        <div class="school">

                            <p style="font-weight:bold;font-size:20px;"> CHILDREN PROFILE Total :
                                <?php echo e((int) $family_profile[0]->fp_total_children); ?>

                            </p>
                            <ul style="margin-left:28px;list-style-type: disc;">
                                <?php if($family_profile[0]->non_school_children_no > 0): ?>
                                <li><b>Non-School going :
                                        <?php echo e((int) $family_profile[0]->non_school_children_no); ?></b>
                                </li>
                                <?php else: ?>
                                <li>Non-School going : <?php echo e((int) $family_profile[0]->non_school_children_no); ?></li>
                                <?php endif; ?>

                                <?php if($family_profile[0]->fp_children_no_in_primary_school > 0): ?>
                                <li><b>Primary school going children :
                                        <?php echo e((int) $family_profile[0]->fp_children_no_in_primary_school); ?></b></li>
                                <?php else: ?>
                                <li>Primary school going children :
                                    <?php echo e((int) $family_profile[0]->fp_children_no_in_primary_school); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($family_profile[0]->fp_children_no_in_secondary_higher > 0): ?>
                                <li><b>Higher school going children
                                        : <?php echo e((int) $family_profile[0]->fp_children_no_in_secondary_higher); ?></b>
                                </li>
                                <?php else: ?>
                                <li>Higher school going children
                                    : <?php echo e((int) $family_profile[0]->fp_children_no_in_secondary_higher); ?></li>
                                <?php endif; ?>

                                <?php if($family_profile[0]->fp_children_no_in_college > 0): ?>
                                <li><b>College/Diploma going children
                                        : <?php echo e((int) $family_profile[0]->fp_children_no_in_college); ?></b>
                                </li>
                                <?php else: ?>
                                <li>College/Diploma going children
                                    : <?php echo e((int) $family_profile[0]->fp_children_no_in_college); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($family_profile[0]->studiedat_home > 0): ?>
                                <li><b>Studied and at home : <?php echo e((int) $family_profile[0]->studiedat_home); ?></b>
                                </li>
                                <?php else: ?>
                                <li>Studied and at home : <?php echo e((int) $family_profile[0]->studiedat_home); ?></li>
                                <?php endif; ?>

                                <!-- <?php if($family_profile[0]->fp_employed > 0): ?>
                                <li><b>Employed : <?php echo e((int) $family_profile[0]->fp_employed); ?></b></li>
                                <?php else: ?>
                                <li>Employed : <?php echo e((int) $family_profile[0]->fp_employed); ?></li>
                                <?php endif; ?> -->


                            </ul>
                        </div>

                    </div>
                </div>

                <div class="col-sm-6">
                    <div style="height:200px;border-radius: 90px;background-color: #ebe3e3;">
                        <div class="school" style="">
                            <p style="font-weight:bold;font-size:20px;">FAMILY PROFILE</p>
                            <ul style="margin-left:28px;list-style-type: disc;">

                                <?php if($family_profile[0]->fp_family_mamber_over_60year > 0): ?>
                                <li><b>Senior citizens : <?php echo e($family_profile[0]->fp_family_mamber_over_60year); ?></b>
                                </li>
                                <?php else: ?>
                                <li>Senior citizens : <?php echo e($family_profile[0]->fp_family_mamber_over_60year); ?>

                                </li>
                                <?php endif; ?>


                                <?php if($family_profile[0]->fp_family_mamber_medication > 0): ?>
                                <li><b>Differently abled members :
                                        <?php echo e($family_profile[0]->fp_family_mamber_medication); ?></b>
                                </li>
                                <?php else: ?>
                                <li>Differently abled members :
                                    <?php echo e($family_profile[0]->fp_family_mamber_medication); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($family_profile[0]->fp_vulnerable_people > 0): ?>
                                <li><b>Vulnerable members :
                                        <?php echo e((int) $family_profile[0]->fp_vulnerable_people); ?></b>
                                </li>
                                <?php else: ?>
                                <li>Vulnerable members : <?php echo e((int) $family_profile[0]->fp_vulnerable_people); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($family_profile[0]->fp_married_children_live_in > 0): ?>
                                <li><b>Married son/daughter_in_lawliving in the house
                                        :
                                        <?php echo e($family_profile[0]->fp_married_children_live_in != '' ? $family_profile[0]->fp_married_children_live_in : 0); ?></b>
                                </li>
                                <?php else: ?>
                                <li>Married son/daughter_in_lawliving in the house
                                    :
                                    <?php echo e($family_profile[0]->fp_married_children_live_in != '' ? $family_profile[0]->fp_married_children_live_in : 0); ?>

                                </li>
                                <?php endif; ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="2" style="background-color:#D79477;">Education</td>
                        <td style="text-align: center;background-color:#D79477;">Male</td>
                        <td style="text-align: center;background-color:#D79477;">Female</td>

                    </tr>
                </thead>
                <thead style="">
                    <tr>
                        <th style=" width:60%;">Family adult members not educated up to primary level</th>
                        <?php
                            $NotEducatedData = getMstCommonData(3,$family_profile[0]->family_member_not_educated   ?? null);
                        ?>
                        <td><?php echo e($NotEducatedData[0]->common_values ?? 'N/A'); ?></td>
                        <td style="width:20%;text-align:center;">
                            <?php echo e($family_profile[0]->family_member_not_educatedMale); ?>

                        </td>
                        <td style="width:20%;text-align:center;">
                            <?php echo e($family_profile[0]->family_member_not_educatedaFemale); ?>

                        </td>

                    </tr>

                    <tr>
                        <th style=" width:60%;">Any children or adolescents up to age of 13 away from school or dropped
                            out?
                        </th>
                        <?php
                            $childrenData = getMstCommonData(3,$family_profile[0]->children_or_adolescents_upto_age   ?? null);
                        ?>
                        <td><?php echo e($childrenData[0]->common_values ?? 'N/A'); ?></td>
                        <td style="width:20%;text-align:center;">
                            <?php echo e($family_profile[0]->children_or_adolescents_uptoMale); ?>

                        </td>
                        <td style="width:20%;text-align:center;">
                            <?php echo e($family_profile[0]->children_or_adolescents_uptoFemale); ?>

                        </td>

                    </tr>

                </thead>

            </table>
            <br>
            
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;width:60%;">Total Family Members Earning
                        </td>
                        <td style="background-color:#ebe3e3;;text-align:left;width:40%;">
                            <?php echo e((int) $family_profile[0]->fp_earning_an_income); ?>

                        </td>
                    </tr>
                </thead>
            </table>
            <div class="page-break"></div>
            <br>
            <br>
            
            <table class="table table-bordered table-stripped table1 " cellspacing="0" ;style="width:100%">
                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477 ; text-align: center;" colspan="4"> Nutrition
                            and Mortality</td>

                        <td style="border:none;width:2%;background-color:white;"></td>
                        <td style="background-color:#D79477 ; text-align: center;width:40%" colspan="2">Standard of
                            living
                        </td>
                    </tr>
                </thead>
                <thead>
                    <tr style="text-align: center">
                        <th>Family member have access to all three <br>meals on a daily basis?</th>
                        <?php
                            $NutritionMoralityData = getMstCommonData(3,$family_profile[0]->aNutritionMortality   ?? null);
                        ?>
                        <td colspan="3"><?php echo e($NutritionMoralityData[0]->common_values ?? 'N/A'); ?></td>

                        <td style="border:none;width:2%;background-color:white;"></td>
                        <th>Sanitation
                        </th>
                        <?php
                            $SanitizationData = getMstCommonData(8,$family_profile[0]->sanitation   ?? null);
                        ?> 
                        <td><?php echo e($SanitizationData[0]->common_values ?? 'N/A'); ?></td>
                    </tr>
                    <tr style="text-align: center">
                        <td colspan="2"></td>
                        <td style="background-color:#D79477 ; text-align: center;width:15%">Male</td>
                        <td style="background-color:#D79477 ; text-align: center;width:15%">Female</td>
                        <td style="border:none;width:2%;background-color:white;"></td>
                        <th>Electricity
                        </th>
                        <?php
                            $ElectricityData = getMstCommonData(3,$family_profile[0]->sElectricity   ?? null);
                        ?>
                        <td><?php echo e($ElectricityData[0]->common_values ?? 'N/A'); ?>

                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <th>Does any member suffer due <br>
                            malnutrition?
                        </th>
                        <?php
                            $bNutritionMoralityData = getMstCommonData(3,$family_profile[0]->bNutritionMortality   ?? null);
                        ?>
                        <td width="5%"><?php echo e($bNutritionMoralityData[0]->common_values ?? 'N/A'); ?></td>
                        <td><?php echo e($family_profile[0]->bNutritionMortalityMale); ?></td>
                        <td><?php echo e($family_profile[0]->bNutritionMortalityFeMale); ?></td>
                        <td style="border:none;width:2%;background-color:white;"></td>
                        <th>Drinking Water
                        </th>
                        <?php
                            $DrinkingWaterData = getMstCommonData(9,$family_profile[0]->sDrinkingWater   ?? null);
                        ?>
                        <td><?php echo e($DrinkingWaterData[0]->common_values ?? 'N/A'); ?>

                        </td>

                    </tr>
                    <tr style="text-align: center">
                        <th>Does any one of the
                            children/adolescents or adults appear
                            to be undernourished (stunted, wasted,
                            under-weight)?
                        </th>
                        <?php
                            $cNutritionMoralityData = getMstCommonData(3,$family_profile[0]->cNutritionMortality   ?? null);
                        ?>
                        <td><?php echo e($cNutritionMoralityData[0]->common_values ?? 'N/A'); ?></td>
                        <td><?php echo e($family_profile[0]->cNutritionMortalityMale); ?></td>
                        <td><?php echo e($family_profile[0]->cNutritionMortalityFeMale); ?></td>
                        <td style="border:none;width:2%;background-color:white;"></td>
                        <th rowspan="2">Cooking
                            Fuel
                        </th>
                        <?php
                            $CookingFuelData = getMstCommonData(10,$family_profile[0]->sCookingFuel   ?? null);
                        ?> 
                        <td rowspan="2"><?php echo e($CookingFuelData[0]->common_values ?? 'N/A'); ?></td>

                    </tr>

                    <tr style="text-align: center">
                        <th>Have any children or adolescents died
                            below age 18?</th>
                            <?php
                                $dNutritionMoralityData = getMstCommonData(3,$family_profile[0]->dNutritionMortality   ?? null);
                            ?>
                        <td><?php echo e($dNutritionMoralityData[0]->common_values ?? 'N/A'); ?></td>
                        <td><?php echo e($family_profile[0]->dNutritionMortalityMale); ?></td>
                        <td><?php echo e($family_profile[0]->dNutritionMortalityFeMale); ?></td>

                    </tr>

                </thead>

            </table>
            <br>

            
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td colspan="2" style="background-color:#D79477;text-align:left;width:75%">Health Status
                        </td>
                        <?php if($family_profile[0]->sHealthIssues == 'Yes'): ?>
                        <td style="background-color:#D79477;width:12.5%">Male</td>
                        <td style="background-color:#D79477;width:12.5%">Female</td>
                        <?php endif; ?>

                    </tr>
                </thead>
                <thead style="">
                    <tr style="text-align: center;">
                        <th style=" width:60%">Any member with an illness in the last 2 years?</th>
                        <td><?php echo e($family_profile[0]->sHealthIssues); ?></td>
                        <?php if($family_profile[0]->sHealthIssues == 'Yes'): ?>
                        <td><?php echo e($family_profile[0]->sHealthIssuesMale); ?></td>
                        <td><?php echo e($family_profile[0]->sHealthIssuesFeMale); ?></td>
                        <?php endif; ?>
                    </tr>


                </thead>

            </table>
            <br>
            
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;width:30%">Family Migration ( in the last 2
                            years)
                        </td>
                        <?php
                    $MigratedData = getMstCommonData(12,$family_profile[0]->fp_family_migrated   ?? null);
                ?>
                <td style="background-color:#ebe3e3;text-align:left;width:5%"><?php echo e($MigratedData[0]->common_values ?? 'N/A'); ?></td>
                        <?php if($family_profile[0]->fp_family_migrated == 2): ?>
                        <td style="text-align:left;width:65%">
                            <?php echo e(checkna($family_profile[0]->fp_family_reason_of_migration)); ?>

                        </td>
                        <?php endif; ?>

                    </tr>
                </thead>


            </table>
            <br>
            <br>
            <br>
            <br>
            <br>

            
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;width:40%" colspan="2">Are you aware of
                            Govt. Livelihood Programs?
                        </td>
                        <td style="background-color:#ebe3e3;;text-align:left;width:60%">
                            <?php
                                $Gov_liveilhoodData = getMstCommonData(3,$family_profile[0]->gov_liveilhood_program   ?? null);
                            ?>
                        <?php echo e($Gov_liveilhoodData[0]->common_values ?? 'N/A'); ?>

                        </td>
                    </tr>
                </thead>

                <?php if($family_profile[0]->gov_liveilhood_program == 'Yes'): ?>
                <tbody>
                    <tr>
                        <td style="text-align:left; background-color:#D79477">Program</td>
                        <td style="text-align:left; background-color:#D79477">Benefits received</td>
                        <td style="text-align:left; background-color:#D79477">Benefits </td>
                    </tr>
                    <?php $__currentLoopData = $gov_program; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $benefis = explode(',', $res->benefit_1);
                    $count = count($benefis);
                    ?>
                    <tr>
                        <td><?php echo e($res->program_name); ?></td>
                        <td><?php echo e($res->recived_benefit == 1 ? 'Yes' : 'No'); ?>

                        </td>
                        <td>
                            <?php for($i = 0; $i <= $count - 1; $i++): ?> <ul style="list-style-type:disc;margin-left:15px;">
                                <li><?php echo e($benefis[$i]); ?></li>
                                </ul>
                                <?php endfor; ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <?php endif; ?>

            </table>
            <br>

            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>FAMILY ASSETS</td>
                    </tr>
                </thead>
            </table>
            
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;" colspan="4">Land</td>
                    </tr>
                </thead>
                <thead style="">
                    <tr>
                        <td style="text-align:left;">Land Size</td>
                        <td style="text-align:left;"><?php echo e(checkna($assets[0]->fa_land_type)); ?></td>
                        <td style="text-align:left;">Land Cultivated by Family</td>
                        <td style="text-align:left;">
                            <?php echo e($assets[0]->fa_land_cultivated != '' ? sprintf('%.1f', $assets[0]->fa_land_cultivated) : '0.0'); ?>

                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:left;">Land owned but cultivated as sharecropping</td>
                        <td style="text-align:left;">
                            <?php echo e($assets[0]->fa_mortagged_how_much_land != '' ? sprintf('%.1f', $assets[0]->fa_mortagged_how_much_land) : '0.0'); ?>

                        </td>
                        <td style="text-align:left;">Land not owned but cultivated as sharecropping</td>
                        <td style="text-align:left;">
                            <?php echo e($assets[0]->fa_land_not_owned != '' ? $assets[0]->fa_land_not_owned : '0.0'); ?>

                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:left;"><b><u>Total land owned and cultivated by family</u></b></td>
                        <td style="text-align:left;">
                            <b><?php echo e($assets[0]->fa_total_land_owned != '' ? sprintf('%.2f', $assets[0]->fa_total_land_owned) : '0.0'); ?></b>
                        </td>
                        <td style="text-align:left;">Land Mortgaged/ Lost to money Lender</td>
                        <td style="text-align:left;">
                            <?php echo e($assets[0]->fa_land_mortgaged != '' ? $assets[0]->fa_land_mortgaged : 'N/A'); ?>

                        </td>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <td style="text-align:left;">Date of loss mortgage</td>
                        <td style="text-align:left;">
                            <?php echo e(change_date_new($assets[0]->fa_date_of_mortgage)); ?>

                        </td>
                        <td style="text-align:left;">How much Land? </td>
                        <td style="text-align:left;">
                            <?php echo e($assets[0]->fa_total_land_owned != '' ? sprintf('%.2f', $assets[0]->fa_total_land_owned) : '0.0'); ?>

                        </td>
                    </tr>


                </thead>

            </table>
            <br>
            <br>
            
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;" colspan="6">Housing Unit</td>
                    </tr>
                </thead>
                <thead style="">
                    <tr>
                        <th style="text-align:left;width:16.6%">House Ownership</th>
                        <td style="text-align:left;width:16.6%"><?php echo e(checkna($assets[0]->house_ownership)); ?></td>
                        <th style="text-align:left;width:16.6%">Type</th>
                        <td style="text-align:left;width:16.6%"><?php echo e(checkna($assets[0]->fa_Pacca_Kaccha_house)); ?></td>
                        <th style="text-align:left;width:16.6%">Animal Sheds</th>
                        <td style="text-align:left;width:16.6%"><?php echo e(checkna($assets[0]->fa_animalsheds)); ?></td>
                    </tr>

                </thead>

            </table>
            <br>
            <br>

            <div class="row row-news">
                <div class="col-md-4">
                    <div class="table-responsive">

                        <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 50%; ">
                            <thead>
                                <tr style="text-align: center;background-color:white ;font-size:25px;border:none;font-weight:bold;text-decoration:underline;">
                                    <td colspan="3"> LIVESTOCK</td>
                                </tr>
                            </thead>


                            <thead>
                                <tr class="table-primary">
                                    <td style="background-color:#D79477 ; text-align: center">S.No</td>
                                    <td style="background-color:#D79477 ; text-align: center">Name of Animals
                                    </td>
                                    <td style="background-color:#D79477 ; text-align: center">No. of Animals</td>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                ?>
                                <?php if(!empty($assets_live_stock)): ?>
                                <?php $__currentLoopData = $assets_live_stock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th style="text-align:center;"><?php echo e($i); ?></th>
                                    <th style="text-transform: capitalize;"><?php echo e($row->animal_Types); ?></th>
                                    <td style="text-align:center;">
                                        <?php echo e($row->no_of_animals != '' ? $row->no_of_animals : 0); ?>

                                    </td>
                                </tr>
                                <?php
                                $i++;
                                ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="table-responsive">

                        <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 50%; ">
                            <thead>
                                <tr style="text-align: center;background-color:white ;font-size:25px;border:none;font-weight:bold;text-decoration:underline;">
                                    <td colspan="3">VEHICLE TYPE</td>
                                </tr>
                            </thead>


                            <thead>
                                <tr class="table-primary">
                                    <td style="background-color:#D79477 ; text-align: center">S.No</td>
                                    <td style="background-color:#D79477 ; text-align: center">Name of Vehicle
                                    </td>
                                    <td style="background-color:#D79477 ; text-align: center">No. of Vehicle</td>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $a = 1;
                                ?>
                                <?php if(!empty($assets_vehicle)): ?>
                                <?php $__currentLoopData = $assets_vehicle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th style="text-align:center;"><?php echo e($a); ?></th>
                                    <th style="text-transform: capitalize;"><?php echo e($row->vehicle_Types); ?></th>
                                    <td style="text-align:center;">
                                        <?php echo e($row->no_of_vehicle != '' ? $row->no_of_vehicle : 0); ?>

                                    </td>
                                </tr>
                                <?php
                                $a++;
                                ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="table-responsive">

                        <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 50%; ">
                            <thead>
                                <tr style="text-align: center;background-color:white ;font-size:25px;border:none;font-weight:bold;text-decoration:underline;">
                                    <td colspan="3">MACHINERY</td>
                                </tr>
                            </thead>


                            <thead>
                                <tr class="table-primary">
                                    <td style="background-color:#D79477 ; text-align: center">S.No</td>
                                    <td style="background-color:#D79477 ; text-align: center">Name of Machinery
                                    </td>
                                    <td style="background-color:#D79477 ; text-align: center">No. of Machinery</td>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $b = 1;
                                ?>
                                <?php if(!empty($assets_machinery)): ?>
                                <?php $__currentLoopData = $assets_machinery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th style="text-align:center;"><?php echo e($b); ?></th>
                                    <th style="text-transform: capitalize;"><?php echo e($row->machinery_Types); ?></th>
                                    <td style="text-align:center;">
                                        <?php echo e($row->no_of_machinery != '' ? $row->no_of_machinery : 0); ?>

                                    </td>
                                </tr>
                                <?php
                                $b++;
                                ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>


            
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="8" style="background-color:#D79477;text-align:left;width:100%"> Home
                            Gadgets/Equipment
                        </td>
                    </tr>
                </thead>
                <thead style="">
                    <tr style="text-align: center;">
                        <th style=" height:5%">Color TV</th>
                        <td style="font-weight:bold;font-size:20px;">
                            <?php if($assets_gadgets[0]->fa_tvcolor == 1): ?>
                            &#x2713;
                            <?php else: ?>
                            &#x2573;
                            <?php endif; ?>
                        </td>
                        <th style=" height:5%">B&W TV</th>
                        <td style="font-weight:bold;font-size:25px;">
                            <?php if($assets_gadgets[0]->fa_tvblackwhite == 1): ?>
                            &#x2713;
                            <?php else: ?>
                            &#x2573;
                            <?php endif; ?>
                        </td>

                        <th style="  height:5%;">Air Conditioner</th>
                        <td style="font-weight:bold;font-size:20px;"">
                            <?php if($assets_gadgets[0]->fa_airconditioners == 1): ?>
                                &#x2713;
                            <?php else: ?>
                                &#x2573;
                            <?php endif; ?>
                        </td>
                        <th style=" height:5%;">Coolers</th>
                        <td style="font-weight:bold;font-size:20px;">
                            <?php if($assets_gadgets[0]->fa_coolers == 1): ?>
                            &#x2713;
                            <?php else: ?>
                            &#x2573;
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr style="text-align: center;">
                        <th style="  height:5%;">Sewing Machine</th>
                        <td style="font-weight:bold;font-size:20px;">
                            <?php if($assets_gadgets[0]->fa_sewingmachines == 1): ?>
                            &#x2713;
                            <?php else: ?>
                            &#x2573;
                            <?php endif; ?>
                        </td>
                        <th style="  height:5%;"> Smartphone</th>
                        <td style="font-weight:bold;font-size:20px;">
                            <?php if($assets_gadgets[0]->fa_smartphone == 1): ?>
                            &#x2713;
                            <?php else: ?>
                            &#x2573;
                            <?php endif; ?>
                        </td>

                        <th style="  height:5%;"> Wet grinder</th>
                        <td style="font-weight:bold;font-size:20px;">
                            <?php if($assets_gadgets[0]->wet_grinder == 1): ?>
                            &#x2713;
                            <?php else: ?>
                            &#x2573;
                            <?php endif; ?>
                        </td>
                        <th style="  height:5%;"> Mixi</th>
                        <td style="font-weight:bold;font-size:20px;">
                            <?php if($assets_gadgets[0]->mixi == 1): ?>
                            &#x2713;
                            <?php else: ?>
                            &#x2573;
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <th style="  height:5%;"> Washing Machines</th>
                        <td style="font-weight:bold;font-size:20px;">
                            <?php if($assets_gadgets[0]->washing_machines == 1): ?>
                            &#x2713;
                            <?php else: ?>
                            &#x2573;
                            <?php endif; ?>
                        </td>
                        <th style="  height:5%;"> Computer</th>
                        <td style="font-weight:bold;font-size:20px;">
                            <?php if($assets_gadgets[0]->computer == 1): ?>
                            &#x2713;
                            <?php else: ?>
                            &#x2573;
                            <?php endif; ?>
                        </td>

                        <th style="  height:5%;"> Refrigerator</th>
                        <td style="font-weight:bold;font-size:20px;">
                            <?php if($assets_gadgets[0]->refrigerator == 1): ?>
                            &#x2713;
                            <?php else: ?>
                            &#x2573;
                            <?php endif; ?>
                        </td>
                        <th style="  height:5%;">Other</th>
                        <?php if($assets_gadgets[0]->fa_other == 1): ?>
                        <td><?php echo e($assets_gadgets[0]->fa_other_choice); ?></td>
                        <?php else: ?>
                        <td>N/A</td>
                        <?php endif; ?>
                    </tr>

                </thead>

            </table>
            <br>
            
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="2" style="background-color:#D79477;text-align:left;">Personal Items
                        </td>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <td style=" text-align: left;width:25%;height:10%">Does the family own any
                            jewellery? </td>
                        <td style=" text-align: left;height:10%"><?php echo e(checkna($assets[0]->fa_jewelry_yes_no)); ?></td>
                    </tr>
                </thead>
            </table>

            <br>
            
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="2" style="background-color:#D79477;text-align:center;width:25%">Jewellery</td>
                        <td style="background-color:#D79477;text-align:center;width:15%">Lender Type</td>
                        <td style="background-color:#D79477;text-align:center;width:15%">Amount (INR)</td>
                        <td style="background-color:#D79477;text-align:center;width:15%">Date</td>
                        <td style="background-color:#D79477;text-align:center;width:15%">Interest Rate</td>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <td style=" text-align: left;">Any jewellery pawned to take loan?</td>
                        <td style=" text-align: center;"><?php echo e(checkna($assets[0]->jewelry_pawned_take_loan_yesno)); ?>

                        </td>
                        <?php if($assets[0]->jewelry_pawned_take_loan_yesno == 'Yes'): ?>
                        <td style="text-align: center;"><?php echo e(checkna($assets[0]->jewelry_pawned_lander_type)); ?>

                        </td>
                        <td style="text-align: center;"><?php echo e(checkna($assets[0]->jewelry_pawned_loan_amount)); ?>

                        </td>
                        <td style="text-align: center;"><?php echo e(checkna($assets[0]->jewelry_pawned_loan_when)); ?></td>
                        <?php if($assets[0]->jewelry_pawned_loan_interest != ''): ?>
                        <td style="text-align: center;"><?php echo e($assets[0]->jewelry_pawned_loan_interest); ?>%</td>
                        <?php else: ?>
                        <td style="text-align: center;">N/A</td>
                        <?php endif; ?>
                        <?php else: ?>
                        <td colspan="4" style="text-align: center">N/A</td>
                        <?php endif; ?>




                    </tr>
                    <tr>
                        <td style=" text-align: left;">Any Jewellery pawned to take loan lost?</td>
                        <td style=" text-align: center;"><?php echo e(checkna($assets[0]->jewelry_pawned_lost_yesno)); ?></td>
                        <?php if($assets[0]->jewelry_pawned_lost_yesno == 'Yes'): ?>


                        <td style="text-align: center;">
                            <?php echo e(checkna($assets[0]->jewelry_pawned_lander_lost_type)); ?>

                        </td>
                        <td style="text-align: center;">
                            <?php echo e((int) checkna($assets[0]->jewelry_pawned_loan_lost_amount)); ?>

                        </td>
                        <td style="text-align: center;"><?php echo e(checkna($assets[0]->jewelry_pawned_loan_lost_when)); ?>

                        </td>

                        <?php if($assets[0]->jewelry_pawned_loan_lost_interest != ''): ?>
                        <td style="text-align: center;"><?php echo e($assets[0]->jewelry_pawned_loan_lost_interest); ?>%
                        </td>
                        <?php else: ?>
                        <td style="text-align: center;">N/A</td>
                        <?php endif; ?>
                        <?php else: ?>
                        <td colspan="4" style="text-align: center;">N/A</td>
                        <?php endif; ?>

                    </tr>
                </thead>
            </table>
            <br>
            
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="2" style="background-color:#D79477;text-align:left;">Others</td>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <td style=" text-align: left;width:50%">Any other asset?</td>
                        <td style="text-align: left;width:50%"><?php echo e(checkna($assets[0]->fa_other_assets_A)); ?></td>
                    </tr>
                </thead>
            </table>

            
            <br>
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="6" style="background-color:#D79477;text-align:left;">Advance Labour Sold</td>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th style=" text-align: left;width:16.6%;">Family sold/advanced any labor in the last two
                            years?</th>
                        <td style="text-align: left;width:16.6%;"><?php echo e(checkna($assets[0]->fa_other_assets_B)); ?></td>
                        <th style=" text-align: left;width:16.6%;">Purpose</th>
                        <td style="text-align: left;width:16.6%;"><?php echo e(checkna($assets[0]->fa_other_assets_C)); ?></td>
                        <th style=" text-align: left;width:16.6%;">No. of labor days advanced or sold</th>
                        <td style="text-align: left;width:16.6%;"><?php echo e(checkZero($assets[0]->fa_other_assets_D)); ?></td>
                    </tr>


                </thead>
            </table>
            <br>
            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>GOALS</td>
                    </tr>
                </thead>
            </table>
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">

                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477;text-align:left;width:10%">S.No.</td>
                        <td style="background-color:#D79477;text-align:left;width:90%">Description</td>
                    </tr>

                </thead>
                <thead>
                    <tr>
                        <?php $i=1; ?>
                        <?php if(!empty($goals)): ?>
                        <?php $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="text-align:left;"><?php echo e($i++); ?></td>
                        <td style="text-align:left;"><?php echo e($row->fg_goal); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>



                </thead>
            </table>

            
            <br>
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>AGRICULTURE & RELATED PRODUCTION</td>
                    </tr>
                </thead>
            </table>
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">

                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Type</td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Unit</td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Total Production Current
                            Year
                        </td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Total Consumption Current
                            Year
                        </td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Quantity Sold</td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Price per unit (INR)</td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Total Sale Amount Current
                            Year
                            (INR)
                        </td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Total Sale Amount Forecast
                            Next
                            Year
                            (INR)</td>
                    </tr>

                </thead>
                
                <tbody>

                    <tr>
                        <td colspan="8" style="text-align:left;background-color: white;">Agricultural</td>
                    </tr>
                    <?php
                    $sum = 0;
                    $sum_a = 0;
                    $sum_an = 0;
                    ?>
                    <?php if(!empty($agriculture)): ?>

                    <?php $__currentLoopData = $agriculture; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $sum += (float) $data->price_per_unit;
                    $sum_a += (float) $data->total_sale_value;
                    $sum_an += $data->total_next;
                    ?>

                    <tr class="tdc">
                        <td style="text-align:left;"><?php echo e($data->crop); ?></td>
                        <td><?php echo e($data->production_quantity_type); ?></td>
                        <td><?php echo e($data->production_per_year); ?></td>
                        <td><?php echo e($data->consumption); ?></td>
                        <td><?php echo e($data->sold_in_year); ?></td>
                        <td><?php echo e($data->price_per_unit); ?></td>
                        <td><?php echo e($data->total_sale_value); ?></td>
                        <td><?php echo e($data->total_next != '' ? $data->total_next : 0); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total">
                        <th colspan="5">Sub-Total Agriculture</th>
                        <th class="tdc"></th>
                        <th class="tdc" style="background-color:#c2b5b5;"><?php echo e($sum_a); ?></th>
                        <th class="tdc" style="background-color:#c2b5b5;"><?php echo e($sum_an); ?></th>
                    </tr>
                    <?php else: ?>
                    <tr class="tdc">
                        <td></td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>

                    </tr>
                    <tr class="total">
                        <th colspan="5">Sub-Total Agriculture</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                    </tr>
                    <?php endif; ?>


                </tbody>


                
                <tbody>

                    <tr>
                        <td colspan="8" style="text-align:left;background-color: white;">Horticulture</td>
                    </tr>
                    <?php
                    $sum = 0;
                    $sum_h = 0;
                    $sum_hn = 0;
                    ?>
                    <?php if(!empty($horticultural)): ?>

                    <?php $__currentLoopData = $horticultural; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $sum += (float) $data->price_per_unit;
                    $sum_h += (float) $data->total_sale_value;
                    $sum_hn += $data->total_next;
                    ?>

                    <tr class="tdc">
                        <td style="text-align:left;"><?php echo e($data->crop); ?></td>
                        <td><?php echo e($data->production_quantity_type); ?></td>
                        <td><?php echo e($data->production_per_year); ?></td>
                        <td><?php echo e($data->consumption); ?></td>
                        <td><?php echo e($data->sold_in_year); ?></td>
                        <td><?php echo e($data->price_per_unit); ?></td>
                        <td><?php echo e($data->total_sale_value); ?></td>
                        <td><?php echo e($data->total_next != '' ? $data->total_next : 0); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total">
                        <th colspan="5">Sub-Total Horiculture</th>
                        <th class="tdc"></th>
                        <th class="tdc" style="background-color:#c2b5b5;"><?php echo e($sum_h); ?></th>
                        <th class="tdc" style="background-color:#c2b5b5;"><?php echo e($sum_hn); ?></th>
                    </tr>
                    <?php else: ?>
                    <tr class="tdc">
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                    </tr>
                    <tr class="total">
                        <th colspan="5">Sub-Total Horiculture</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                    </tr>
                    <?php endif; ?>



                </tbody>
                
                <tbody>
                    <tr>
                        <td colspan="8" style="text-align:left;background-color: white;">Livestock </td>
                    </tr>
                    <?php
                    $sum = 0;
                    $sum_li = 0;
                    $sum_ln = 0;
                    ?>
                    <?php if(!empty($live)): ?>

                    <?php $__currentLoopData = $live; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $sum += (float) $data->price_per_unit;
                    $sum_li += (float) $data->total_sale_value;
                    $sum_ln += $data->total_next;
                    ?>

                    <tr class="tdc">

                        <td style="text-align:left;"><?php echo e($data->production_sub_type); ?>

                            &nbsp;(<?php echo e($data->crop); ?>)</td>
                        <td><?php echo e($data->production_quantity_type); ?></td>
                        <td><?php echo e($data->production_per_year); ?></td>
                        <td><?php echo e($data->consumption); ?></td>
                        <td><?php echo e($data->sold_in_year); ?></td>
                        <td><?php echo e($data->price_per_unit); ?></td>
                        <td><?php echo e($data->total_sale_value); ?></td>
                        <td><?php echo e($data->total_next != '' ? $data->total_next : 0); ?></td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total">
                        <th colspan="5">Sub-Total Livestock</th>
                        <th class="tdc"></th>
                        <th class="tdc" style="background-color:#c2b5b5;"><?php echo e($sum_li); ?></th>
                        <th class="tdc" style="background-color:#c2b5b5;"><?php echo e($sum_ln); ?></th>
                    </tr>
                    <?php else: ?>
                    <tr class="tdc">
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>

                    </tr>
                    <tr class="total">
                        <th colspan="5">Sub-Total Livestock</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th colspan="5">Grand Total </th>
                        <td colspan="" class="tdc"></td>
                        <th colspan="" class="tdc" style="background-color:#c2b5b5;">
                            <?php echo e($sum_a + $sum_li + $sum_h); ?>

                        </th>
                        <th class="tdc" style="background-color:#c2b5b5;"><?php echo e($sum_an + $sum_ln + $sum_hn); ?></th>
                    </tr>
                </tbody>
            </table>

            <br>
            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>SAVINGS</td>
                    </tr>
                </thead>

            </table>
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr style="text-align: left;background-color:white ;font-size:20px;border:none;font-weight:bold;">
                        <td colspan="6">Type of Savings</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;background-color:#D79477 ;width:15%">Type</td>
                        <td style="text-align:center;background-color:#D79477 ;width:15%">Saving Regulary</td>
                        <td style="text-align:center;background-color:#D79477 ;width:15%">Date Savings Started</td>
                        <td style="text-align:center;background-color:#D79477 ;width:20%">Amount Saved Per Month (INR)
                        </td>
                        <td style="text-align:center;background-color:#D79477 ;width:20%">Saved During Last 12 Months
                            (INR)
                        </td>
                        <td style="text-align:center;background-color:#D79477 ;width:15%">Cumulative Savings (INR)</td>
                    </tr>

                    <?php if(!empty($savings_source)): ?>
                    <?php
                    $sum = 0;
                    $sum1 = 0;
                    $sum2 = 0;
                    ?>
                    <?php $__currentLoopData = $savings_source; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $sum = $sum + (float) $row['s_total_saving'];
                    $sum1 = $sum1 + (float) $row['s_saving_per_month'];
                    $sum2 = $sum2 + (float) $row['s_last_saved_amt'];
                    ?>
                    <tr>
                        <th style="text-align:left;"><?php echo e($row['s_type']); ?></th>
                        <td style="text-align:left;"><?php echo e($row['s_contribute_regular']); ?></td>
                        <td style="text-align:center;"><?php echo e($row['s_started_from']); ?></td>
                        <td style="text-align:center;"><?php echo e($row['s_saving_per_month']); ?></td>
                        <td style="text-align:center;"><?php echo e($row['s_last_saved_amt']); ?></td>
                        <td style="text-align:center;"><?php echo e($row['s_total_saving']); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th style="text-align:center;background-color:#c2b5b5;">Total</th>
                        <td style="text-align:center;background-color:#c2b5b5;"></td>
                        <td style="text-align:center;background-color:#c2b5b5;"></td>
                        <th style="text-align:center;background-color:#c2b5b5;"><?php echo e($sum1); ?></th>
                        <th style="text-align:center;background-color:#c2b5b5;"><?php echo e($sum2); ?></th>
                        <th style="text-align:center;background-color:#c2b5b5;"><?php echo e($sum); ?></th>
                    </tr>
                    <?php endif; ?>

                </thead>
            </table>

            
            <br>
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>

                    <tr>
                        <td style="text-align:center;background-color:#D79477 ;font-weight:bold;width:30%">Passbook in
                            Possesion</td>
                        <td style="text-align:center;font-weight:bold;width:20%;">
                            <?php echo e($savings[0]->s_passbook_physically == 1 ? 'Yes' : 'No'); ?>

                        </td>
                        <td style="text-align:center;background-color:#D79477 ;font-weight:bold;width:30%;">Passbook
                            Updated
                        </td>
                        <td style="text-align:center;font-weight:bold;width:20%;">
                            <?php echo e($savings[0]->s_passbook_updated == 1 ? 'Yes' : 'No'); ?>

                        </td>
                    </tr>

                </thead>
            </table>
            <br>
            
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr style="text-align: left;background-color:white ;font-size:20px;border:none;font-weight:bold;">
                        <td colspan="6">Other Saving Source</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;background-color:#D79477 ;">Savings Product</td>
                        <td style="text-align:center;background-color:#D79477 ;">Date of Deposit</td>
                        <td style="text-align:center;background-color:#D79477 ;">Deposit Term Period</td>
                        <td style="text-align:center;background-color:#D79477 ;">Interest %</td>
                        <td style="text-align:center;background-color:#D79477 ;">Amount (INR)</td>

                    </tr>
                    <?php if(!empty($savings_source_other)): ?>
                    <?php $sum=0; ?>
                    <?php $__currentLoopData = $savings_source_other; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $sum=$sum+(float)$row->other_amount; ?>
                    <tr>
                        <td class="tdc" style="text-align:left;"><?php echo e($row->other_loan ?? ''); ?></td>
                        <td class="tdc"><?php echo e($row->other_where_fixed_deposit_made ?? ''); ?></td>
                        <td class="tdc">
                            <?php echo e(change_date_month_name_char(str_replace('/', '-', $row->other_date_of_deposit)) ?? ''); ?>

                        </td>
                        <td class="tdc"><?php echo e($row->other_interest ?? ''); ?></td>
                        <td class="tdc"><?php echo e($row->other_amount ?? ''); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <tr class="total">
                        <td colspan="3"></td>
                        <th style="text-align:center;background-color:#c2b5b5;">Total</th>
                        <th style="text-align:center;background-color:#c2b5b5;"><?php echo e($sum ?? 0); ?></th>
                    </tr>
                    <?php endif; ?>

                </thead>
            </table>
            <br>
            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>FAMILY LOAN OUTSTANDING</td>
                    </tr>
                </thead>
                <br>

                <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                    <thead>

                        <tr>
                            <td style="text-align:center;background-color:#D79477 ;width:16%"><b>Loan Type</b></td>
                            <td style="text-align:center;background-color:#D79477 ;width:16%">Principal Amount (INR)
                            </td>
                            <td style="text-align:center;background-color:#D79477 ;width:16%">Total Amount<br>
                                paid in 12<br>
                                months (INR)
                            </td>
                            <td style="text-align:center;background-color:#D79477 ;width:16%">Cumulative<br>
                                Amount paid<br>
                                (INR)
                            </td>
                            <td style="text-align:center;background-color:#D79477 ;width:16%">Overdue<br>
                                Amount (INR)
                            </td>
                            <td style="text-align:center;background-color:#D79477 ;width:16%">Next Year Loan<br>
                                Repayment<br>
                                Commitment (INR)

                            </td>
                        </tr>
                        <tr>
                            

                            <?php
                                $shg_total = 0;
                                $shg_amount = 0;
                                $shg_overdue = 0;
                                $shg_cumulative = 0;
                                $shg_paid = 0;

                            ?>
                            <?php if(!empty($Shg_loan)): ?>

                                <?php $__currentLoopData = $Shg_loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $shg_total = $shg_total + checkZero($res->lo_next_year);
                                        $shg_amount = $shg_amount + checkZero($res->lo_principle_amount);
                                        $shg_overdue = $shg_overdue + checkZero($res->overdue);
                                        $shg_cumulative = $shg_cumulative + checkZero($res->total_paid_interest);
                                        $shg_paid = $shg_paid + checkZero($res->current_year_interest);

                                    ?>

                        <tr>
                            <td style="text-align:left;">SHG Loan</td>
                            <td class="tdc"><?php echo e($res->lo_principle_amount); ?></td>
                            <td class="tdc"><?php echo e($res->current_year_interest); ?></td>
                            <td class="tdc"><?php echo e($res->total_paid_interest); ?></td>
                            <td class="tdc"><?php echo e($res->overdue); ?></td>
                            <td class="tdc"><?php echo e($res->lo_next_year); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                        <?php endif; ?>
                        </tr>
                        
                        <?php
                            $money_total = 0;
                            $money_amount = 0;
                            $money_overdue = 0;
                            $money_cumulative = 0;
                            $money_paid = 0;
                        ?>
                        <?php if(!empty($money_loan)): ?>

                            <?php $__currentLoopData = $money_loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $money_total = $money_total + checkZero($res->lo_next_year);
                                    $money_amount = $money_amount + checkZero($res->lo_principle_amount);
                                    $money_overdue = $money_overdue + checkZero($res->overdue);
                                    $money_cumulative = $money_cumulative + checkZero($res->total_paid_interest);
                                    $money_paid = $money_paid + checkZero($res->current_year_interest);

                                ?>
                                <tr>
                                    <td style="text-align:left;">Money lender loan</td>
                                    <td class="tdc"><?php echo e($res->lo_principle_amount); ?></td>
                                    <td class="tdc"><?php echo e($res->current_year_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->total_paid_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->overdue); ?></td>
                                    <td class="tdc"><?php echo e($res->lo_next_year); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php endif; ?>

                        
                        <?php
                            $bank_total = 0;
                            $bank_amount = 0;
                            $bank_overdue = 0;
                            $bank_cumulative = 0;
                            $bank_paid = 0;
                        ?>
                        <?php if(!empty($Bank_loan)): ?>

                            <?php $__currentLoopData = $Bank_loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $bank_total = $bank_total + checkZero($res->lo_next_year);
                                    $bank_amount = $bank_amount + checkZero($res->lo_principle_amount);
                                    $bank_overdue = $bank_overdue + checkZero($res->overdue);
                                    $bank_cumulative = $bank_cumulative + checkZero($res->total_paid_interest);
                                    $bank_paid = $bank_paid + checkZero($res->current_year_interest);

                                ?>
                                <tr>
                                    <td style="text-align:left;"> Bank loan</td>
                                    <td class="tdc"><?php echo e($res->lo_principle_amount); ?></td>
                                    <td class="tdc"><?php echo e($res->current_year_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->total_paid_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->overdue); ?></td>
                                    <td class="tdc"><?php echo e($res->lo_next_year); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php endif; ?>
                        
                        <?php
                            $mfi_total = 0;
                            $mfi_amount = 0;
                            $mfi_overdue = 0;
                            $mfi_cumulative = 0;
                            $mfi_paid = 0;
                        ?>
                        <?php if(!empty($mfi_loan)): ?>

                            <?php $__currentLoopData = $mfi_loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $mfi_total = $mfi_total + checkZero($res->lo_next_year);
                                    $mfi_amount = $mfi_amount + checkZero($res->lo_principle_amount);
                                    $mfi_overdue = $mfi_overdue + checkZero($res->overdue);
                                    $mfi_cumulative = $mfi_cumulative + checkZero($res->total_paid_interest);
                                    $mfi_paid = $mfi_paid + checkZero($res->current_year_interest);

                                ?>
                                <tr>
                                    <td style="text-align:left;">MFI loan</td>
                                    <td class="tdc"><?php echo e($res->lo_principle_amount); ?></td>
                                    <td class="tdc"><?php echo e($res->current_year_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->total_paid_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->overdue); ?></td>
                                    <td class="tdc"><?php echo e($res->lo_next_year); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php endif; ?>

                        

                        <?php
                            $cluster_total = 0;
                            $cluster_amount = 0;
                            $cluster_overdue = 0;
                            $cluster_cumulative = 0;
                            $cluster_paid = 0;
                        ?>
                        <?php if(!empty($cluster_loan)): ?>

                            <?php $__currentLoopData = $cluster_loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $cluster_total = $cluster_total + checkZero($res->lo_next_year);
                                    $cluster_amount = $cluster_amount + checkZero($res->lo_principle_amount);
                                    $cluster_overdue = $cluster_overdue + checkZero($res->overdue);
                                    $cluster_cumulative = $cluster_cumulative + checkZero($res->total_paid_interest);
                                    $cluster_paid = $cluster_paid + checkZero($res->current_year_interest);

                                ?>
                                <tr>
                                    <td style="text-align:left;">Cluster loan</td>
                                    <td class="tdc"><?php echo e($res->lo_principle_amount); ?></td>
                                    <td class="tdc"><?php echo e($res->current_year_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->total_paid_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->overdue); ?></td>
                                    <td class="tdc"><?php echo e($res->lo_next_year); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php endif; ?>
                        

                        <?php
                            $fed_total = 0;
                            $fed_amount = 0;
                            $fed_overdue = 0;
                            $fed_cumulative = 0;
                            $fed_paid = 0;
                        ?>
                        <?php if(!empty($fed_loan)): ?>

                            <?php $__currentLoopData = $fed_loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $fed_total = $fed_total + checkZero($res->lo_next_year);
                                    $fed_amount = $fed_amount + checkZero($res->lo_principle_amount);
                                    $fed_overdue = $fed_overdue + checkZero($res->overdue);
                                    $fed_cumulative = $fed_cumulative + checkZero($res->total_paid_interest);
                                    $fed_paid = $fed_paid + checkZero($res->current_year_interest);

                                ?>
                                <tr>
                                <tr>
                                    <td style="text-align:left;">Federation loan</td>
                                    <td class="tdc"><?php echo e($res->lo_principle_amount); ?></td>
                                    <td class="tdc"><?php echo e($res->current_year_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->total_paid_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->overdue); ?></td>
                                    <td class="tdc"><?php echo e($res->lo_next_year); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php endif; ?>
                        

                        <?php
                            $nbfc_total = 0;
                            $nbfc_amount = 0;
                            $nbfc_overdue = 0;
                            $nbfc_cumulative = 0;
                            $nbfc_paid = 0;
                        ?>
                        <?php if(!empty($nbfc_loan)): ?>

                            <?php $__currentLoopData = $nbfc_loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $nbfc_total = $nbfc_total + checkZero($res->lo_next_year);
                                    $nbfc_amount = $nbfc_amount + checkZero($res->lo_principle_amount);
                                    $nbfc_overdue = $nbfc_overdue + checkZero($res->overdue);
                                    $nbfc_cumulative = $nbfc_cumulative + checkZero($res->total_paid_interest);
                                    $nbfc_paid = $nbfc_paid + checkZero($res->current_year_interest);

                                ?>
                                <tr>
                                <tr>
                                    <td style="text-align:left;">NBFC loan</td>
                                    <td class="tdc"><?php echo e($res->lo_principle_amount); ?></td>
                                    <td class="tdc"><?php echo e($res->current_year_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->total_paid_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->overdue); ?></td>
                                    <td class="tdc"><?php echo e($res->lo_next_year); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php endif; ?>
                        

                        <?php
                            $other_total = 0;
                            $other_amount = 0;
                            $other_overdue = 0;
                            $other_cumulative = 0;
                            $other_paid = 0;
                        ?>
                        <?php if(!empty($other_loan)): ?>

                            <?php $__currentLoopData = $other_loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $other_total = $other_total + checkZero($res->lo_next_year);
                                    $other_amount = $other_amount + checkZero($res->lo_principle_amount);
                                    $other_overdue = $other_overdue + checkZero($res->overdue);
                                    $other_cumulative = $other_cumulative + checkZero($res->total_paid_interest);
                                    $other_paid = $other_paid + checkZero($res->current_year_interest);

                                ?>
                                <tr>

                                    <td style="text-align:left;">Other loan</td>
                                    <td class="tdc"><?php echo e($res->lo_principle_amount); ?></td>
                                    <td class="tdc"><?php echo e($res->current_year_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->total_paid_interest); ?></td>
                                    <td class="tdc"><?php echo e($res->overdue); ?></td>
                                    <td class="tdc"><?php echo e($res->lo_next_year); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <tr style="font-weight:bold">
                            <th class="tdc" style="background-color:#c2b5b5;">Total</th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                <?php echo e($other_amount + $fed_amount + $cluster_amount + $bank_amount + $money_amount + $shg_amount + $mfi_amount + $nbfc_amount); ?>

                            </th>

                            <th class="tdc" style="background-color:#c2b5b5;">
                                <?php echo e($other_paid + $fed_paid + $cluster_paid + $bank_paid + $money_paid + $shg_paid + $mfi_paid + $nbfc_paid); ?>

                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                <?php echo e($other_cumulative + $fed_cumulative + $cluster_cumulative + $bank_cumulative + $money_cumulative + $shg_cumulative + $mfi_cumulative + $nbfc_cumulative); ?>

                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                <?php echo e($other_overdue + $fed_overdue + $cluster_overdue + $bank_overdue + $money_overdue + $shg_overdue + $mfi_overdue + $nbfc_overdue); ?>

                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                <?php echo e($other_total + $fed_total + $cluster_total + $bank_total + $money_total + $shg_total + $mfi_total + $nbfc_total); ?>

                            </th>
                        </tr>
                    </thead>
                </table>
            </table>
            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>FAMILY’S CURRENT AND NEXT YEAR BUDGET</td>
                    </tr>
                </thead>
            </table>

            <div class="row-new">
                <div class="col-sm-6 mt-2">
                    <div class="card">
                        <div class="card-block">
                            <div class="w-box">
                                <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 50%; ">


                                    <thead>
                                        <tr class="table-primary">
                                            <td style="background-color:#D79477 ; text-align: center">Income source
                                            </td>
                                            <td style="background-color:#D79477 ; text-align: center">Total Current
                                                Year (INR)
                                            </td>
                                            <td style="background-color:#D79477 ; text-align: center">Next Year
                                                Forecast (INR)
                                            </td>

                                        </tr>
                                    </thead>
                                    <thead>
                                        <?php if($income_this_year[0]->agriculture > 0 || $income_next_year[0]->agriculture > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Agriculture </th>
                                            <td><?php echo e((int) $income_this_year[0]->agriculture); ?>

                                            </td>
                                            <td><?php echo e((int) $income_next_year[0]->agriculture); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($income_this_year[0]->livestock > 0 || $income_next_year[0]->livestock > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Livestock </th>
                                            <td><?php echo e((int) $income_this_year[0]->livestock); ?>

                                            </td>
                                            <td><?php echo e((int) $income_next_year[0]->livestock); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($income_this_year[0]->horticulture > 0 || $income_next_year[0]->horticulture > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Horticulture </th>
                                            <td><?php echo e((int) $income_this_year[0]->horticulture); ?>

                                            </td>
                                            <td><?php echo e((int) $income_next_year[0]->horticulture); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($income_this_year[0]->sale_of_livestock > 0 || $income_next_year[0]->sale_of_livestock > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Sale of Livestock </th>
                                            <td><?php echo e((int) $income_this_year[0]->sale_of_livestock); ?>

                                            </td>
                                            <td><?php echo e((int) $income_next_year[0]->sale_of_livestock); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($income_this_year[0]->money_lending > 0 || $income_next_year[0]->money_lending > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Money Lending </th>
                                            <td><?php echo e((int) $income_this_year[0]->money_lending); ?>

                                            </td>
                                            <td><?php echo e((int) $income_next_year[0]->money_lending); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($income_this_year[0]->fixed_income_amount > 0 || $income_next_year[0]->fixed_income_amount > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Fixed Income </th>
                                            <td><?php echo e((int) $income_this_year[0]->fixed_income_amount); ?>

                                            </td>
                                            <td><?php echo e((int) $income_next_year[0]->fixed_income_amount); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($income_this_year[0]->casual_income_amount > 0 || $income_next_year[0]->casual_income_amount > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Casual Income</th>
                                            <td><?php echo e((int) $income_this_year[0]->casual_income_amount); ?>

                                            </td>
                                            <td><?php echo e((int) $income_next_year[0]->casual_income_amount); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($income_this_year[0]->trade_income_amount > 0 || $income_next_year[0]->trade_income_amount > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Trade Income</th>
                                            <td><?php echo e((int) $income_this_year[0]->trade_income_amount); ?>

                                            </td>
                                            <td><?php echo e((int) $income_next_year[0]->trade_income_amount); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($income_this_year[0]->pension_income_monthly > 0 || $income_next_year[0]->pension_income_monthly > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Pension
                                                Income
                                            </th>
                                            
                                            <td><?php echo e((int) $income_this_year[0]->pension_income_monthly); ?>

                                            </td>
                                            <td><?php echo e((int) $income_next_year[0]->pension_income_monthly); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($income_this_year[0]->other_income > 0 || $income_next_year[0]->other_income > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Other Income</th>
                                            <td><?php echo e((int) $income_this_year[0]->other_income); ?>

                                            </td>
                                            <td><?php echo e((int) $income_next_year[0]->other_income); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php
                                        $total_income_this_year = (int) $income_this_year[0]->pension_income_monthly + (int) $income_this_year[0]->fixed_income_amount + (int) $income_this_year[0]->horticulture + (int) $income_this_year[0]->livestock + (int) $income_this_year[0]->agriculture + (int) $income_this_year[0]->sale_of_livestock + (int) $income_this_year[0]->money_lending + (int) $income_this_year[0]->casual_income_amount + (int) $income_this_year[0]->trade_income_amount + (int) $income_this_year[0]->other_income ;

                                        $total_income_next_year = (int) $income_next_year[0]->pension_income_monthly + (int) $income_next_year[0]->fixed_income_amount + (int) $income_next_year[0]->horticulture + (int) $income_next_year[0]->livestock + (int) $income_next_year[0]->agriculture +(int) $income_next_year[0]->sale_of_livestock + (int) $income_next_year[0]->money_lending + (int) $income_next_year[0]->casual_income_amount + (int) $income_next_year[0]->trade_income_amount + (int) $income_next_year[0]->other_income ;
                                        ?>
                                        <tr style="text-align: center;">
                                            <th width="35%" style="background-color:#c2b5b5;">Total
                                                Income
                                            </th>
                                            <td style="background-color:#c2b5b5;">
                                                <?php echo e($total_income_this_year); ?>

                                            </td>
                                            <td style="background-color:#c2b5b5;">
                                                <?php echo e($total_income_next_year); ?>

                                            </td>
                                        </tr>

                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mt-2">
                    <div class="card">
                        <div class="card-block">
                            <div class="w-heading d-flex">
                                <span>
                                    <h5 style="text-align:center;">CURRENT YEAR INCOME </h5>
                                </span>
                            </div>
                            <div class="w-box">
                                
                                <div id="piechart" style="width: 500px; height: 300px;margin-left:114px;position:relative;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-new">
                <div class="col-sm-6 mt-2">
                    <div class="card">
                        <div class="card-block">

                            <div class="w-box">
                                <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 50%; ">


                                    <thead>
                                        <tr class="table-primary">
                                            <td style="background-color:#D79477 ; text-align: center">Expenditure type
                                            </td>
                                            <td style="background-color:#D79477 ; text-align: center">Total Current
                                                Year (INR)
                                            </td>
                                            <td style="background-color:#D79477 ; text-align: center">Next Year
                                                Forecast (INR)
                                            </td>

                                        </tr>
                                    </thead>
                                    <thead>
                                        <?php if($this_year_normal[0]->total > 0 || $next_year_normal[0]->total > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Normal Expenditure</th>
                                            <td><?php echo e($this_year_normal[0]->total); ?></td>
                                            <td><?php echo e($next_year_normal[0]->total); ?></td>
                                        </tr>
                                        <?php endif; ?>


                                        <?php if($this_year_Social[0]->total > 0 || $next_year_Social[0]->total > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Social Expenditure</th>
                                            <td><?php echo e($this_year_Social[0]->total); ?></td>
                                            <td><?php echo e($next_year_Social[0]->total); ?></td>
                                        </tr>
                                        <?php endif; ?>

                                        <?php if($this_year_wasteful[0]->total > 0 || $next_year_wasteful[0]->total > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Wasteful Expenditure</th>
                                            <td><?php echo e($this_year_wasteful[0]->total); ?></td>
                                            <td><?php echo e($next_year_wasteful[0]->total); ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($loan_expensture_total[0]->loan_this_year > 0 || $loan_expensture_total[0]->loan_next_year > 0): ?>
                                        <tr style="text-align: center">
                                            <th width="35%">Loan Expenditure</th>
                                            <td><?php echo e($loan_expensture_total[0]->loan_this_year); ?></td>
                                            <td><?php echo e($loan_expensture_total[0]->loan_next_year); ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php
                                        $total_expenditure_this_year = (int) $this_year_normal[0]->total + (int) $this_year_Social[0]->total + (int) $this_year_wasteful[0]->total + (int) $loan_expensture_total[0]->loan_this_year;

                                        $total_expenditure_next_year = (int) $next_year_normal[0]->total + (int) $next_year_Social[0]->total + (int) $next_year_wasteful[0]->total + (int) $loan_expensture_total[0]->loan_next_year;
                                        ?>
                                        <tr style="text-align: center;">
                                            <th width="35%" style="background-color:#c2b5b5;">Total
                                                Expenditure
                                            </th>
                                            <td style="background-color:#c2b5b5;">
                                                <?php echo e($total_expenditure_this_year); ?>

                                            </td>
                                            <td style="background-color:#c2b5b5;">
                                                <?php echo e($total_expenditure_next_year); ?>

                                            </td>
                                        </tr>

                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mt-2">
                    <div class="card">
                        <div class="card-block">
                            <div class="w-heading d-flex">
                                <span>
                                    <h5 style="text-align:center;">CURRENT YEAR EXPENDITURE </h5>
                                </span>
                            </div>
                            <div class="w-box">
                                
                                <div id="donutchart" style="width: 500px; height: 300px;margin-left:114px;position:relative;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mt-2">
                    <div class="card">
                        <div class="card-block">
                            <div class="w-heading d-flex">
                                <span>
                                    <h5 style="text-align:center;">INCOME VS EXPENDITURE</h5>
                                </span>
                            </div>
                            <div class="w-box">
                                
                                <div id="top_x_div" style="width: 1000px; height: 200px;margin-left:114px;position:relative;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>CHALLENGES & ACTION PLAN
                        </td>
                    </tr>
                </thead>
            </table>
            <br>
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: left;background-color:#eeeeee;font-size:20px;border:none;font-weight:bold;">
                        <td>Action Plan To Address The Challenges</td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">



                <tbody>
                    <tr>
                        <th style="background-color:#D79477 ; text-align: center;width:5%">S.No</th>
                        <th style="background-color:#D79477 ; text-align: center;width:20%">Action Plan</th>
                        <?php
                        $no = 1;
                        ?>
                        <?php if(!empty($challenges)): ?>
                        <?php $__currentLoopData = $challenges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th style="background-color:#D79477 ; text-align: center;">Challenge
                            <?php echo e($no); ?> :
                            <?php echo e($row->challenges); ?>

                        </th>
                        <?php
                        $no++;
                        ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tr>
                    <?php if(!empty($challenges_actions_new)): ?>
                    <?php $__currentLoopData = $challenges_actions_new; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="tdc"><?php echo e($key + 1); ?></td>
                        <td><?php echo e($row['name']); ?></td>
                        <?php if(!empty($row['ch_actions'])): ?>
                        <?php $__currentLoopData = $row['ch_actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td><?php echo e($val != '' ? $val : 'N/A'); ?></td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </tbody>

            </table>
            <br>
            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>FAMILY BUSINESS PLAN</td>
                    </tr>
                </thead>
            </table>

            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <th style="background-color:#D79477 ; text-align: left" colspan="4">Basic Details of
                            Investment plan
                        </th>
                    </tr>
                </thead>
                <?php if($business_investment_plan[0]->is_buisness_plan_avl == 'No'): ?>
                <tbody>
                    <tr style="text-align: center">
                        <th width="25%">Business Plan</th>
                        <td width="25%"><?php echo e($business_investment_plan[0]->is_buisness_plan_avl); ?></td>
                        <th width="25%">Business Sector</th>
                        <td width="25%"><?php echo e($business_investment_plan[0]->comments); ?></td>
                    </tr>

                </tbody>
                <?php else: ?>
                <tbody>
                    <tr style="text-align: center">
                        <th width="25%">Business Plan</th>
                        <td width="25%"><?php echo e($business_investment_plan[0]->is_buisness_plan_avl); ?></td>
                        <th width="25%">Type/Category</th>
                        <td width="25%"><?php echo e($business_investment_plan[0]->type_of_category); ?></td>

                    </tr>

                    <tr style="text-align: center">
                        <th width="25%">Business Sector</th>
                        <td width="25%"><?php echo e($business_investment_plan[0]->type_of_business); ?></td>
                        <th>New or Existing Business</th>
                        <td><?php echo e($business_investment_plan[0]->is_existing_business_plan); ?></td>

                    </tr>
                    <tr style="text-align: center">
                        <th>Date of Business Plan</th>
                        <td><?php echo e(change_date_month_name_char(str_replace('/', '-', $business_investment_plan[0]->date_of_business_plan))); ?>

                        </td>
                        <th>Family member reponsible</th>
                        <td><?php echo e($business_investment_plan[0]->primarily_business); ?></td>

                    </tr>
                    <tr style="text-align: center">
                        <th>Proposed Activity</th>
                        <td><?php echo e($business_investment_plan[0]->proposed_activity_existing); ?></td>
                        <th></th>
                        <td></td>
                    </tr>

                </tbody>
                <?php endif; ?>

            </table>
            <br>
            <?php if($business_investment_plan[0]->is_buisness_plan_avl != 'No'): ?>

            
            <table class="table  table-stripped table1 " style="border:none;" cellspacing="0">
                <thead>
                    <tr style="text-align: start;background-color:#eeeeee;font-size:20px;border:none;">
                        <td>Total Cost Of The Business ( One Time)
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                <thead>
                    <tr class="table-primary">
                        <td style=" background-color:#D79477 ;text-align: center;width:5%"> S No.</td>
                        <td style=" background-color:#D79477 ;text-align:center;width:23.75%"> Name of Items
                        </td>
                        <td style="background-color:#D79477 ; text-align: center;width:23.75%">Quantity </td>
                        <td style="background-color:#D79477 ; text-align: center;width:23.75%">Unit Price (INR)
                        </td>
                        <td style="background-color:#D79477 ; text-align: center;width:23.75%">Total Cost (INR)
                        </td>


                    </tr>


                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $sum = 0;
                    $sum1 = 0;
                    ?>
                    <?php if(!empty($fixed_investment)): ?>
                    <?php $__currentLoopData = $fixed_investment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $sum += (float) $row->amount;
                    $sum1 += (float) $row->totalamount;
                    ?>
                    <tr>
                        <td width="25px" class="tdc"><?php echo e($i); ?></td>

                        <td style="text-align:left;"><?php echo e($row->name_of_item); ?>

                        </td>
                        <td style=" text-align: center"><?php echo e($row->no_of_quantity); ?>

                        </td>
                        <td style=" text-align: center"><?php echo e($row->amount); ?>

                        </td style=" text-align: center">
                        <td style=" text-align: center"><?php echo e($row->totalamount); ?></td>
                    </tr>
                    <?php $i++ ; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td colspan="3"></td>
                        <th style="background-color:#c2b5b5;text-align: center;">Total</th>
                        <th style=" text-align: center;background-color:#c2b5b5;"><?php echo e($sum1); ?></th>
                    </tr>
                    <?php endif; ?>
                </tbody>

            </table>
            <br>
            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: start;background-color:#eeeeee ;font-size:20px;border:none;">
                        <td>Yearly Recurring Expenditure
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477 ; text-align: center;width:5%;">S. No.</td>
                        <td style="background-color:#D79477 ; text-align:center;">Name of Items</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 1 Expenses <br>(INR)</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 2 Expenses <br>(INR)</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 3 Expenses <br>(INR)</td>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sn = 1;
                    $count = 0;
                    $year = ['1st year expenses', '2nd year expenses', '3rd year expenses'];
                    ?>

                    <?php for($i = 0; $i < count($yearly_expenses); $i++): ?> <?php $expensesyear=explode(',', $yearly_expenses[$i]->expenses_type);
                        // print_r($yearly_expenses[$i]->expenses_type);
                        $expense = explode(',', $yearly_expenses[$i]->expenses);

                        ?>
                        <tr>
                            <td width="25px" class="tdc"><?php echo e($sn); ?></td>
                            <td><?php echo e($yearly_expenses[$i]->name_of_item); ?></td>
                            <?php $__currentLoopData = $year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curyear): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td class="tdc">
                                <?php

                                $key = array_search(trim($curyear), $expensesyear, false);
                                if ($key !== false) {
                                echo $expense[$key];
                                } else {
                                echo 'N/A';
                                }
                                ?>
                            </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <?php
                        $sn++;
                        ?>
                        <?php endfor; ?>



                        <tr>
                            <th></th>
                            <th style="background-color:#c2b5b5;">Total</th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                <?php echo e(checkZero($total_1st_year_expenses)); ?>

                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                <?php echo e(checkZero($total_2nd_year_expenses)); ?>

                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                <?php echo e(checkZero($total_3rd_year_expenses)); ?>

                            </th>
                        </tr>
                </tbody>

            </table>
            <br>
            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: start;background-color:#eeeeee ;font-size:20px;border:none;">
                        <td>Income from Business</td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">
                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477 ; text-align: center;width:5%;">S. No.</td>
                        <td style="background-color:#D79477 ; text-align:center;">Name of Items</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 1 Income <br>(INR)</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 2 Income <br>(INR)</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 3 Income <br>(INR)</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //prd($income_business);
                    $sn = 1;
                    $count = 0;
                    $year = ['1st year income', '2nd year income', '3rd year income'];
                    ?>

                    <?php for($i = 0; $i < count($income_business); $i++): ?> <?php $incomeyear=explode(',', $income_business[$i]->income_type);
                        // print_r($income_business[$i]->income_type);
                        $income = explode(',', $income_business[$i]->income);

                        ?>
                        <tr>
                            <td width="25px" class="tdc"><?php echo e($sn); ?></td>
                            <td><?php echo e($income_business[$i]->name_of_item); ?></td>
                            <?php $__currentLoopData = $year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curyear): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td class="tdc">
                                <?php
                                // print_r($incomeyear);
                                $key = array_search(trim($curyear), $incomeyear, false);
                                if ($key !== false) {
                                echo $income[$key];
                                } else {
                                echo 'N/A';
                                }
                                ?>
                            </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <?php
                        $sn++;
                        ?>
                        <?php endfor; ?>


                        <tr>
                            <th></th>
                            <th style="background-color:#c2b5b5;">Total</th>
                            <th class="tdc" style="background-color:#c2b5b5;"><?php echo e(checkZero($total_1st_year_income)); ?>

                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;"><?php echo e(checkZero($total_2nd_year_income)); ?>

                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;"><?php echo e(checkZero($total_3rd_year_income)); ?>

                            </th>
                        </tr>
                </tbody>

            </table>
            <br>
            
            <table class="table table-bordered  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: start;background-color:#eeeeee ;font-size:20px;border:none;">
                        <td colspan="5">Profit/Loss
                        </td>
                    </tr>
                </thead>
                <tbody>

                    <tr class="table-primary">
                        <td style=" text-align: center;"> </td>

                        <td style="background-color:#D79477 ; text-align: center;">Year 1 (INR)</td>
                        <td style="background-color:#D79477 ; text-align: center;">Year 2 (INR)</td>
                        <td style="background-color:#D79477 ; text-align: center;">Year 3 (INR) </td>


                    </tr>
                    <tr>
                        <td>Operational Cost</td>
                        <td class="tdc"><?php echo e((float) $first_year_total_salesamts); ?></td>
                        <td class="tdc"><?php echo e((float) $scnd_year_total_salesamts); ?></td>
                        <td class="tdc"><?php echo e((float) $trd_year_total_salesamts); ?></td>
                    </tr>

                    <tr>
                        <td>Loan Repayment</td>
                        <td class="tdc"><?php echo e((float) $first_year_total_loanamts_fyear); ?></td>
                        <td class="tdc"><?php echo e((float) $scnd_year_total_loanamts_fyear); ?></td>
                        <td class="tdc"><?php echo e((float) $trd_year_total_loanamts_fyear); ?></td>
                    </tr>

                    <tr>
                        <td>Interest Repayment</td>
                        <td class="tdc"><?php echo e((float) $first_year_total_interestamts_fyear); ?></td>
                        <td class="tdc"><?php echo e((float) $scnd_year_total_interestamts_fyear); ?></td>
                        <td class="tdc"><?php echo e((float) $trd_year_total_interestamts_fyear); ?></td>
                    </tr>
                    <tr style="background-color:#FFC300;font-weight: bolder;font-size: medium;">
                        <td style="background-color:#FFC300;">Total</td>
                        <td class="tdc" style="background-color:#FFC300;"><?php echo e((float) $first_year_expansesamt); ?>

                        </td>
                        <td class="tdc" style="background-color:#FFC300;"><?php echo e((float) $scnd_year_expansesamt); ?>

                        </td>
                        <td class="tdc" style="background-color:#FFC300;"><?php echo e((float) $trd_year_expansesamt); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>Income</th>
                        <th class="tdc"><?php echo e((float) $first_year_total_incomeamts); ?></th>
                        <th class="tdc"><?php echo e((float) $scnd_year_total_incomeamts); ?></th>
                        <th class="tdc"><?php echo e((float) $trd_year_total_incomeamts); ?></th>
                    </tr>
                    <tr style="background-color: #b3aeae;font-weight: bolder;font-size: medium;">
                        <td style="background-color:#b3aeae;">Profit/Loss</td>
                        <td style="color:<?php echo e($show1); ?>; background-color:#b3aeae;" class="tdc">
                            <?php echo e((float) $tv_1profit); ?>

                        </td>
                        <td style="color:<?php echo e($show2); ?>; background-color:#b3aeae;" class="tdc">
                            <?php echo e((float) $tv_2profit); ?>

                        </td>
                        <td style="color:<?php echo e($show3); ?>; background-color:#b3aeae;" class="tdc">
                            <?php echo e((float) $tv_3profit); ?>

                        </td>
                    </tr>
                    <br>
                    <tr>
                        <th style="text-align:center;" colspan="2">If loss, how will this gap be met</th>
                        <th style="text-align:center;" colspan="2">
                            <?php echo e($business_investment_plan[0]->lossgap_type); ?>

                        </th>
                    </tr>

                </tbody>
            </table>



            <br>
            
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">
                <thead>
                    <tr style="text-align: start;background-color:white ;font-size:20px;border:none;">
                        <td colspan="5">Loan Amount and Duration
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <tr class="table-primary">
                        <td style=" background-color:#D79477 ;text-align: center;width:4%"> S.No.</td>
                        <td style=" background-color:#D79477 ;text-align:center;width:24%"> Loan Amount
                        </td>
                        <td style="background-color:#D79477 ; text-align: center;width:24%">Interest Rate %
                        </td>
                        <td style="background-color:#D79477 ; text-align: center;width:24%">Interest Type </td>
                        <td style="background-color:#D79477 ; text-align: center;width:24%">Duration </td>


                    </tr>
                    <tr class="tdc">
                        <td>1</td>
                        <td><?php echo e(checkna((int) $loan_repayment[0]->principal)); ?></td>
                        <?php if($loan_repayment[0]->interest != ''): ?>
                        <td><?php echo e((int) $loan_repayment[0]->interest); ?>%</td>
                        <?php else: ?>
                        <td>0.00%</td>
                        <?php endif; ?>
                        <td><?php echo e(checkna($loan_repayment[0]->interest_type)); ?></td>
                        <?php
                        $duration = 'N/A';
                        if ($loan_repayment[0]->tenure_mode == 1) {
                        $duration = $loan_repayment[0]->loan_tenure . '-' . 'Year';
                        } elseif ($loan_repayment[0]->tenure_mode == 0) {
                        $duration = $loan_repayment[0]->loan_tenure . '-' . 'Month';
                        }
                        ?>
                        <td class="tdc"><?php echo e($duration); ?></td>
                    </tr>
                </tbody>

            </table>
            <br>
            
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">
                <thead>
                    <tr style="text-align: left;background-color:white ;font-size:20px;border:none;">
                        <td colspan="5">Payment Details
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-primary">
                        <td width="5%"></td>
                        <td width="25%"></td>
                        <td style="background-color:#D79477 ;width:23.3% ;text-align: center">Year 1 (INR)</td>
                        <td style="background-color:#D79477 ;width:23.3% ;text-align: center">Year 2 (INR)</td>
                        <td style="background-color:#D79477 ;width:23.3% ;text-align: center">Year 3 (INR)</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Total Interest</td>

                        <td class="tdc">
                            <?php echo e($loan_repayment[0]->total_interest_fyear != '' ? $loan_repayment[0]->total_interest_fyear : 0); ?>

                        </td>
                        <td class="tdc">
                            <?php echo e($loan_repayment[0]->total_interest_syear != '' ? $loan_repayment[0]->total_interest_syear : 0); ?>

                        </td>
                        <td class="tdc">
                            <?php echo e($loan_repayment[0]->total_interest_thyear != '' ? $loan_repayment[0]->total_interest_thyear : 0); ?>

                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Total Principle</td>

                        <td class="tdc">
                            <?php echo e($loan_repayment[0]->total_loan_fyear != '' ? $loan_repayment[0]->total_loan_fyear : 0); ?>

                        </td>
                        <td class="tdc">
                            <?php echo e($loan_repayment[0]->total_loan_syear != '' ? $loan_repayment[0]->total_loan_syear : 0); ?>

                        </td>
                        <td class="tdc">
                            <?php echo e($loan_repayment[0]->total_loan_thyear != '' ? $loan_repayment[0]->total_loan_thyear : 0); ?>

                        </td>
                    </tr>
                    <tr>
                        <?php
                        $total1 = (float) $loan_repayment[0]->total_interest_fyear + (float) $loan_repayment[0]->total_loan_fyear;
                        $total2 = (float) $loan_repayment[0]->total_interest_syear + (float) $loan_repayment[0]->total_loan_syear;
                        $total3 = (float) $loan_repayment[0]->total_interest_thyear + (float) $loan_repayment[0]->total_loan_thyear;
                        ?>
                        <td></td>

                        <td>Payable amount</td>

                        <td class="tdc"><?php echo e(sprintf('%.1f', $total1)); ?>

                        </td>
                        <td class="tdc"><?php echo e(sprintf('%.1f', $total2)); ?>

                        </td>
                        <td class="tdc"><?php echo e(sprintf('%.1f', $total3)); ?>

                        </td>
                    </tr>
                </tbody>

            </table>


            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;width:60%;">Comments if any
                        </td>
                        <td style="background-color:#ebe3e3;;text-align:left;width:40%;"></td>
                    </tr>
                </thead>
            </table>

            <?php endif; ?>
            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center ;font-size:30px;border:none;font-weight: bold;text-decoration:underline;">
                        <td>OBSERVATIONS
                        </td>
                    </tr>
                </thead>
            </table>

            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align:start;background-color:#eeeeee;font-size:20px;border:none;">
                        <td>First Visit Observation
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                <thead>
                    <tr class="table-primary">

                        <td style="background-color:#D79477 ; text-align: center;width: 5%">S.No. </td>
                        <td style="background-color:#D79477 ; text-align: center;width: 55%">Question</td>
                        <td style="background-color:#D79477 ; text-align: center;width: %">Answer </td>


                    </tr>
                </thead>

            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                
                <tbody >
                    <tr>
                        <th style="width: 5%;text-align:center;">1</th>
                        <th style="width: 55%;">Who participated in the family?</th>
                        <td style="width:40%;">
                            <?php echo e($observation_this_year_member[0]->participate_family); ?>

                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:center;">2</th>
                        <th>How long the family has been living in this house?</th>
                        <td><?php echo e($observation_this_year[0]->fdip_observation_past_life); ?></td>
                    </tr>

                    <tr>
                        <th style="text-align:center;">3</th>
                        <th>Give a few highlights about this family (who they are? What they do for living? were they ready for discussion? whether they actively participated, etc) </th>
                        <td><?php echo e($observation_this_year[0]->fdip_observation_daily); ?></td>
                    </tr>
                    <tr>
                        <th style="text-align:center;">4</th>
                        <th>What is special that you observed about this family? What are the three things you would like to highlight for this family (e.g. Readiness or reluctance to change,  attitudes in goal setting, feelings about commitments to act and unity within family, and so on) </th>
                        <td>
                            <ol type="A" >
                                <?php if($observation_this_year[0]->fdip_observation_highlights_a != ''): ?>
                                <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_a); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_this_year[0]->fdip_observation_highlights_b != ''): ?>
                                <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_b); ?>

                                </li>
                                <?php endif; ?>
                                <?php if($observation_this_year[0]->fdip_observation_highlights_c != ''): ?>
                                <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_c); ?>

                                </li>
                                <?php endif; ?>
                                <?php if($observation_this_year[0]->fdip_observation_highlights_d != ''): ?>
                                <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_d); ?>

                                </li>
                                <?php endif; ?>
                                <?php if($observation_this_year[0]->fdip_observation_highlights_e != ''): ?>
                                <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_e); ?>

                                </li>
                                <?php endif; ?>
                           </ol>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">5</td>
                        <th>What is this family burdened with or worried about (things that bother them on a daily basis)?
                        </th>
                        <td><?php echo e($observation_this_year[0]->fdip_observation_vulnerabilities); ?>

                            <?php if($observation_this_year[0]->fdip_observation_vulnerabilities == 'Yes'): ?>
                            <br>
                            <ol type="A">
                                <?php if($observation_this_year[0]->fdip_observation_highlights_a_6 != ''): ?>
                                <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_a_6); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_this_year[0]->fdip_observation_highlights_b_6 != ''): ?>
                                <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_b_6); ?>

                                </li>
                                <?php endif; ?>
                                <?php if($observation_this_year[0]->fdip_observation_highlights_c_6 != ''): ?>
                                <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_c_6); ?>

                                </li>
                                <?php endif; ?>
                                <?php if($observation_this_year[0]->fdip_observation_highlights_d_6 != ''): ?>
                                <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_d_6); ?>

                                </li>
                                <?php endif; ?>
                                <?php if($observation_this_year[0]->fdip_observation_highlights_e_6 != ''): ?>
                                <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_e_6); ?>

                                </li>
                                <?php endif; ?>
                            </ol>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">6</td>
                        <th>In your assessment, what are key risks this family faces? Did this discussion help them understand their risks?”</th>
                        <td><?php echo e($observation_this_year[0]->fdip_risk_assesment); ?></td>
                    </tr>

                    <tr>
                        <td style="text-align:center;">7</td>
                        <th>Does their SHG help them?</th>
                        <td><?php echo e($observation_this_year[0]->fdip_observation_how); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">8</td>
                        <th>What was this family’s feedback on FDIP (did this discussion help them, if yes, in what ways)</th>
                        <td><?php echo e($observation_this_year[0]->fdip_observation_agreement); ?>

                            <?php if($observation_this_year[0]->fdip_observation_agreement == 'Yes'): ?>
                            <ol>
                                <li><?php echo e($observation_this_year[0]->fdip_observation_agreement_edittext); ?></li>
                            </ol>

                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">9</td>
                        <th>Are there in any observations that you have captured in other sections (e.g. family profile, assets, income, expenditures, loans, savings) that you would want to describe here                                                </th>
                        <td>
                            <ol type="A">
                            <?php if($observation_this_year[0]->fdip_observation_highlights_a_9 != ''): ?>
                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_a_9); ?>

                        </li>
                        <?php endif; ?>

                        <?php if($observation_this_year[0]->fdip_observation_highlights_b_9 != ''): ?>
                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_b_9); ?>

                        </li>
                        <?php endif; ?>

                        <?php if($observation_this_year[0]->fdip_observation_highlights_c_9 != ''): ?>
                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_c_9); ?>

                        </li>
                        <?php endif; ?>

                        <?php if($observation_this_year[0]->fdip_observation_highlights_d_9 != ''): ?>
                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_d_9); ?>

                        </li>
                        <?php endif; ?>

                        <?php if($observation_this_year[0]->fdip_observation_highlights_e_9 != ''): ?>
                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_e_9); ?>

                        </li>
                        <?php endif; ?>
                        <?php if($observation_this_year[0]->fdip_observation_highlights_f_9 != ''): ?>
                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_f_9); ?>

                        </li>
                        <?php endif; ?>
                        <?php if($observation_this_year[0]->fdip_observation_highlights_g_9 != ''): ?>
                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_g_9); ?>

                        </li>
                        <?php endif; ?>
                        <?php if($observation_this_year[0]->fdip_observation_highlights_h_9 != ''): ?>
                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_h_9); ?>

                        </li>
                        <?php endif; ?>
                        <?php if($observation_this_year[0]->fdip_observation_highlights_i_9 != ''): ?>
                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_i_9); ?>

                        </li>
                        <?php endif; ?>
                            </ol>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">10</td>
                        <th>Does this family want to take another loan for existing or new business (productive activities) – yes/no</th>
                        <td><?php echo e($observation_this_year[0]->loan_new_existing !='1' ? 'Yes' :'No'); ?></td>
                    </tr>
                    <?php if($observation_this_year[0]->loan_new_existing == 0): ?>
                    <tr>
                        <td style="text-align:center;">10.a</td>
                        <th>Which trade they want to take loan for?</th>
                        <td><?php echo e($observation_this_year[0]->fdip_which_trade_loan); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">10.b</td>
                        <th>Is this trade feasible in your opinion?</th>
                        <td><?php echo e($observation_this_year[0]->fdip_which_trade_feasible); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">10.c</td>
                        <th>Who in the family will run this business?  </th>
                        <td><?php echo e($observation_this_year[0]->fdip_who_run_family_buisness); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">10.d</td>
                        <th>What is the amount of loan they want to take?</th>
                        <td><?php echo e($observation_this_year[0]->fdip_observation_amount_of_loan); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">10.e</td>
                        <th>When will they prepare the business plan?</th>
                        <td><?php echo e($observation_this_year[0]->fdip_when_will_prepare_buisness_plan); ?></td>
                    </tr>
                    <?php elseif($observation_this_year[0]->loan_new_existing == 1): ?>
                    <tr>
                        <td style="text-align:center;">10.a</td>
                        <th>Why this family has decided not to take another loan and start business/trade (state reasons for not preparing an investment plan)</th>
                        <td><?php echo e($observation_this_year[0]->fdip_why_family_decided_not_take_loan); ?></td>
                    </tr>
                    <?php endif; ?>

                </tbody>
            </table>

            
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align:start;background-color:white ;font-size:20px;border:none;">
                        <td>Second Visit Observation
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                <thead>
                    <tr class="table-primary">

                        <td style="background-color:#D79477 ; text-align: center;width: 5%">S.No. </td>
                        <td style="background-color:#D79477 ; text-align: center;width: 55%">Question</td>
                        <td style="background-color:#D79477 ; text-align: center;width: 40%">Answer </td>


                    </tr>
                </thead>

            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                <tbody>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">1</th>
                        <th style="width: 55%;">Has family revised challenges or actions<br>since the last
                            discussion?</th>
                        <td style="width:40%;">
                            <p> <b><?php echo e($observation_next_year[0]->fdip_observation_next_has); ?>

                                </b></p>
                            <?php if($observation_next_year[0]->fdip_observation_next_describe != ''): ?>
                            <ul style="list-style-type:disc;margin-left:15px;">
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_describe); ?>

                                </li>
                            </ul>
                            <?php endif; ?>
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">2</th>
                        <th style="width: 55%;">Has family done some preparation work for<br>
                            planning of the next year production and
                            <br> budget?
                        </th>
                        <td style="width: 40%;">
                            <p> <b><?php echo e($observation_next_year[0]->fdip_observation_next_planning); ?></b></p>
                            <?php if($observation_next_year[0]->fdip_observation_next_describe2 != ''): ?>
                            <ul style="list-style-type:disc;margin-left:15px;">
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_describe2); ?>

                                </li>
                            </ul>
                            <?php endif; ?>

                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">3</th>
                        <th style="width: 55%;">Has family prepared their business plan?<br>
                            Describe key highlights of the business
                            <br>plan?
                        </th>
                        <td style="width: 40%;">
                            <p> <b><?php echo e($observation_next_year[0]->fdip_observation_next_business); ?></b></p>
                            <ul style="list-style-type:disc;margin-left:15px;">
                                <?php if($observation_next_year[0]->fdip_observation_next_highlight != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_highlight); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_highlight_two != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_highlight_two); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_highlight_three != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_highlight_three); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_highlight_four != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_highlight_four); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_highlight_five != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_highlight_five); ?>

                                </li>
                                <?php endif; ?>
                            </ul>
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">4</th>
                        <th style="width: 55%;">What makes this family deserving to<br>
                            receive a loan? </th>
                        <td style="width: 40%;">
                            <ul style="list-style-type:disc;margin-left:15px;">
                                <?php if($observation_next_year[0]->fdip_observation_next_what != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_what); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_what_b_4 != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_what_b_4); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_what_c_4 != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_what_c_4); ?>

                                </li>
                                <?php endif; ?>
                            </ul>
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">5</th>
                        <th style="width: 55%;">What do you think wold be biggest risk in<br>
                            lending to them?
                        </th>
                        <td style="width: 40%;">
                            <ul style="list-style-type:disc;margin-left:15px;">
                                <?php if($observation_next_year[0]->fdip_observation_next_risk != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_risk); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_risk_b_5 != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_risk_b_5); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_risk_c_5 != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_risk_c_5); ?>

                                </li>
                                <?php endif; ?>
                            </ul>
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">6</th>
                        <th style="width: 55%;">How would VIV loan improve their life?</th>
                        <td style="width: 40%;">
                            <ul style="list-style-type:disc;margin-left:15px;">
                                <?php if($observation_next_year[0]->fdip_observation_next_how != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_how); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_how_b_6 != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_how_b_6); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_how_c_6 != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_how_c_6); ?>

                                </li>
                                <?php endif; ?>
                            </ul>
                        </td>


                    </tr>

                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">7</th>
                        <th style="width: 55%;">Did you observe any change in the family<br>
                            from the 1st visit?, if yes describe</th>
                        <td style="width: 40%;">
                            <p> <b><?php echo e($observation_next_year[0]->fdip_observation_next_did); ?>

                                </b></p>
                            <ul style="list-style-type:disc;margin-left:15px;">

                                <?php if($observation_next_year[0]->fdip_observation_next_any != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_any); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_any_two != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_any_two); ?>

                                </li>
                                <?php endif; ?>

                                <?php if($observation_next_year[0]->fdip_observation_next_any_three != ''): ?>
                                <li><?php echo e($observation_next_year[0]->fdip_observation_next_any_three); ?>

                                </li>
                                <?php endif; ?>
                            </ul>
                        </td>

                </tbody>
            </table>
            <br>
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;width:60%;">Family/SHG Member Commitment
                        </td>
                        <td style="background-color:#ebe3e3;;text-align:left;width:40%;">
                            <?php echo e($shgmember_commitment[0]->yo_member_aware_categories); ?>

                        </td>
                    </tr>
                </thead>
            </table>








        </div>
    </div>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

<script>
    function getPDF() {
        var HTML_Width = $(".canvas_all_pdf").width();
        var HTML_Height = $(".canvas_all_pdf").height();
        var top_left_margin = 15;
        var PDF_Width = HTML_Width + (top_left_margin * 2);
        var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
        var canvas_image_width = HTML_Width;
        var canvas_image_height = HTML_Height;

        var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;


        html2canvas($(".canvas_all_pdf")[0], {
            allowTaint: true
        }).then(function(canvas) {
            canvas.getContext('2d');

            // console.log(canvas.height+"  "+canvas.width);


            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
            pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width,
                canvas_image_height);


            for (var i = 1; i <= totalPDFPages; i++) {
                pdf.addPage(PDF_Width, PDF_Height);
                pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin * 4),
                    canvas_image_width, canvas_image_height);
            }

            pdf.save("Family-Profile.pdf");
        });
    };
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    var a = 0;
    var b = 0;
    var c = 0;
    var d = 0;
    var e = 0;
    var f = 0;
    var g = 0;
    var h = 0;
    var i = 0;
    var j = 0;

    var agg = '<?php echo e($income_this_year[0]->agriculture); ?>';
    if (agg != '') {
        a = '<?php echo e($income_this_year[0]->agriculture); ?>';
    }
    var hor = '<?php echo e($income_this_year[0]->horticulture); ?>';
    if (hor != '') {
        b = '<?php echo e($income_this_year[0]->horticulture); ?>';
    }
    var live = '<?php echo e($income_this_year[0]->livestock); ?>';
    if (live != '') {
        c = '<?php echo e($income_this_year[0]->livestock); ?>';
    }
    var fixin = '<?php echo e($income_this_year[0]->fixed_income_amount); ?>';
    if (fixin != '') {
        d = '<?php echo e($income_this_year[0]->fixed_income_amount); ?>';
    }
    var pen = '<?php echo e($income_this_year[0]->pension_income_monthly); ?>';
    if (pen != '') {
        e = '<?php echo e($income_this_year[0]->pension_income_monthly); ?>';
    }

    var sale = '<?php echo e($income_this_year[0]->sale_of_livestock); ?>';
    if (sale != '') {
        f = '<?php echo e($income_this_year[0]->sale_of_livestock); ?>';
    }

    var money = '<?php echo e($income_this_year[0]->money_lending); ?>';
    if (money != '') {
        g = '<?php echo e($income_this_year[0]->money_lending); ?>';
    }

    var casual = '<?php echo e($income_this_year[0]->casual_income_amount); ?>';
    if (casual != '') {
        h = '<?php echo e($income_this_year[0]->casual_income_amount); ?>';
    }

    var trade = '<?php echo e($income_this_year[0]->trade_income_amount); ?>';
    if (trade != '') {
        i = '<?php echo e($income_this_year[0]->trade_income_amount); ?>';
    }

    var other = '<?php echo e($income_this_year[0]->other_income); ?>';
    if (other != '') {
        j = '<?php echo e($income_this_year[0]->other_income); ?>';
    }



    var total = parseFloat(a) + parseFloat(b) + parseFloat(c) + parseFloat(d) + parseFloat(e) + parseFloat(f) + parseFloat(g) + parseFloat(h) + parseFloat(i) + parseFloat(j);

    var agriculture = Math.round((a / total) * 100);
    var horticulture = Math.round((b / total) * 100);
    var livestock = Math.round((c / total) * 100);
    var fixed = Math.round((d / total) * 100);
    var pension = Math.round((e / total) * 100);
    var sales = Math.round((f / total) * 100);
    var money = Math.round((g / total) * 100);
    var casual = Math.round((h / total) * 100);
    var trade = Math.round((i / total) * 100);
    var other = Math.round((j / total) * 100);

    var n = 0;
    var s = 0;
    var w = 0;
    var l = 0;

    var nor = '<?php echo e($this_year_normal[0]->total); ?>';
    if (nor != '') {
        n = '<?php echo e($this_year_normal[0]->total); ?>';
    }
    var soc = '<?php echo e($this_year_Social[0]->total); ?>';
    if (soc != '') {
        s = '<?php echo e($this_year_Social[0]->total); ?>';
    }
    var wast = '<?php echo e($this_year_wasteful[0]->total); ?>';
    if (wast != '') {
        w = '<?php echo e($this_year_wasteful[0]->total); ?>';
    }
    var lon = '<?php echo e($loan_expensture_total[0]->loan_this_year); ?>';
    if (lon != '') {
        l = '<?php echo e($loan_expensture_total[0]->loan_this_year); ?>';
    }

    var e_total = parseFloat(n) + parseFloat(s) + parseFloat(w) + parseFloat(l);

    var normal = Math.round((n / e_total) * 100);
    var social = Math.round((s / e_total) * 100);
    var wasteful = Math.round((w / e_total) * 100);
    var loan = Math.round((l / e_total) * 100);

    var income_this = '<?php echo e($total_income_this_year); ?>';
    var expenditure_this = '<?php echo e($total_expenditure_this_year); ?>';
    var income_this_year = parseInt(income_this);
    var expenditure_this_year = parseInt(expenditure_this);





    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Agriculture', agriculture],
            ['Horticulture', horticulture],
            ['Livestock', livestock],
            ['Fixed Income', fixed],
            ['Pension Income', pension],
            ['Sale of livestock', sales],
            ['Money lending', money],
            ['Casual Income', casual],
            ['Trade Income', trade],
            ['Other Income', other]
        ]);

        var data2 = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Normal  Expenditure', normal],
            ['Social  Expenditure', social],
            ['Wateful  Expenditure', wasteful],
            ['Loan  Expenditure', loan]

        ]);



        var options = {
            title: '',

        };
        var options2 = {
            title: '',
            pieHole: 0.4,
        };


        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
        var chart2 = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart2.draw(data2, options2);

    }
    const maxValue = Math.max(income_this_year, expenditure_this_year);
    const increment = 100000;
    const resultArray = [];

    for (let value = increment; value <= maxValue + increment; value += increment) {
        resultArray.push(value);
    }

    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {

        var data = google.visualization.arrayToDataTable([
            ['', '', {
                role: 'style'
            }, {
                type: 'string',
                role: 'annotation'
            }],
            ['Income ', income_this_year, '  fill-color: #008000; ', income_this_year],
            ['Expenditure', expenditure_this_year, 'fill-color: #FF0000; ', expenditure_this_year]
        ]);

        var options = {
            title: '',

            chartArea: {
                width: '80%'
            },
            annotations: {
                alwaysOutside: true,
                textStyle: {
                    fontSize: 20,
                    auraColor: '',
                    color: '#000000'
                },
                boxStyle: {
                    stroke: '#ccc',
                    strokeWidth: 1,
                    gradient: {
                        color1: '#f3e5f5',
                        color2: '#f3e5f5',
                        x1: '0%',
                        y1: '0%',
                        x2: '100%',
                        y2: '100%'
                    }
                }

            },
            hAxis: {
                title: 'Values',
                format: '0', // Format the values without decimal places
                // Set the interval (step) you want for the axis
                ticks: resultArray,


            },
        };
        var chart = new google.visualization.BarChart(document.getElementById('top_x_div'));

        chart.draw(data, options);
    }
</script><?php /**PATH D:\xampp\htdocs\village\resources\views/pdf/FamilyDetailsCardsPDF.blade.php ENDPATH**/ ?>