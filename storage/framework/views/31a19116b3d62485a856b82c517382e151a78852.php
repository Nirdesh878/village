<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Business Plan</title>
</head>

<body class="antialiased container mt-5">
<h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generate On- <?php
                echo generated_date();
                ?>
            </h5>
    <div class="page-header-title"> 
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Family Business Plan ( <?php echo e($family->uin); ?> )</u>
            </h2>
        </div>

    </div>
    <style>
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
            padding: .50rem;
    
        }
    
        .table td th {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
    
        }
    
    
    
        .table-primary,
        .table-primary>td,
        .table-primary> {
            background-color: #01a9ac;
            color: black;
            font-size: 25px;
        }
    
        .table-bordered td,
        .table-bordered th {
            border: 1px solid #e9ecef;
        }
    
        .tdc {
            text-align: center;
        }
    
        .page-break {
            page-break-before: always;
        }
    
        th {
            text-align: start;
        }
    
        .checkmark {
            display: inline-block;
            transform: rotate(45deg);
            height: 25px;
            width: 12px;
            margin-left: 60%;
            border-bottom: 7px solid black;
            border-right: 7px solid black;
            margin-left: ;
        }
    
    </style>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="3">Basic Details Of Investment Plan</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="left" width="50%" style="text-align: left;">UIN</th>
                <td width="50%" class="left"><?php echo e($family->uin); ?></td> 
            </tr>
            <tr>
                <th class="left" style="text-align: left;">Member name</th>
                <td class="left"><?php echo e($family_profile[0]->fp_member_name); ?></td>
            </tr>
            <tr>
                <th class="left" style="text-align: left;">Name of SHG</th>
                <td class="left"><?php echo e($shg_profile[0]->shgName); ?></td>
            </tr>
            <tr>
                <th class="left" style="text-align: left;">Aadhar Card No</th>
                <?php if($family_profile[0]->fp_aadhar_no !=''): ?>
                <td class="left"><?php echo e(checkna(aadhar($family_profile[0]->fp_aadhar_no))); ?></td>
                <?php else: ?>
                <td class="left">N/A</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th class="left" style="text-align: left;">Husband Name</th>
                <td class="left"><?php echo e($family_profile[0]->fp_spouse_name); ?></td>
            </tr>
            <tr>
                <th class="left" style="text-align: left;">Mobile Number</th>
                <td class="left"><?php echo e((int) $family_profile[0]->fp_contact_no); ?></td>
            </tr>
            <tr>
                <th class="left" style="text-align: left;">Name of Cluster</th>
                <td class="left"><?php echo e((!empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A')); ?></td>
            </tr>
            <tr>
                <th class="left" style="text-align: left;">Name of Federation</th>
                <td class="left"><?php echo e((!empty($fed_profile[0]->name_of_federation) ? $fed_profile[0]->name_of_federation : 'N/A')); ?></td>
            </tr>
            
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="3">Business Investment Plan</td>

            </tr>
        </thead>
        <thead class="back-color">
            <tr>
                <th width="5%">S.No</th>
                <th class="left" width="45%" style="text-align: left;">Business Plan Details</th>
                <th width="50%"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <th class="left" style="text-align: left;">Business Type/category</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->type_of_category)); ?></td>
            </tr>
            <tr>
                <th scope="row">1.a</th>
                <th class="left" style="text-align: left;">Business sector</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->type_of_business)); ?></td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <th class="left" style="text-align: left;">New or Existing Business</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->is_existing_business_plan)); ?>

                </td>
            </tr>
           
            
            <?php if($business_investment_plan[0]->is_existing_business_plan == 'Existing'): ?>
            <tr>
                <th scope="row">2.a</th>
                <th class="left" style="text-align: left;">Improving on exixting business or adding to the current
                    business</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->current_business)); ?>

                </td>
            </tr>
            <tr>
                <th scope="row">2.b</th>
                <th class="left" style="text-align: left;">No of Years in Existing Business</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->how_long_family_business)); ?>

                </td>
            </tr>
            <tr>
                <th scope="row">2.c</th>
                <th class="left" style="text-align: left;">Reason for expension</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->reasons_expansion)); ?>

                </td>
            </tr>
            <tr>
                <th scope="row">2.d</th>
                <th class="left" style="text-align: left;">Proposed activity</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->proposed_activity_existing)); ?>

                </td>
            </tr>
            <tr>
                <th scope="row">2.e</th>
                <th class="left" style="text-align: left;">Do you know where you would be selling your product</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->selling_product)); ?></td>
            </tr>
            <?php if($business_investment_plan[0]->selling_product == 'Yes'): ?>
            <tr>
                <th scope="row">2.f</th>
                <th class="left" style="text-align: left;">Marketing details</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->if_yes_specify)); ?>

                </td>
            </tr>
            <?php endif; ?>
            <?php endif; ?>
            <?php if($business_investment_plan[0]->is_existing_business_plan == 'New Business'): ?>
            <tr>
                <th scope="row">2.g</th>
                <th class="left" style="text-align: left;">Improving on exixting business or adding to the current
                    business</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->current_business)); ?>

                </td>
            </tr>
            <tr>
                <th scope="row">2.h</th>
                <th class="left" style="text-align: left;">Friend/Relative in this new business</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->friend_relative_new_business)); ?>

                </td>
            </tr>
            <tr>
                <th scope="row">2.i</th>
                <th class="left" style="text-align: left;">Market demand for this business</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->market_demand_business)); ?>

                </td>
            </tr>
            <tr>
                <th scope="row">2.j</th>
                <th class="left" style="text-align: left;">Proposed activity</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->proposed_activity_new)); ?>

                </td>
            </tr>
            <tr>
                <th scope="row">2.k</th>
                <th class="left" style="text-align: left;">Identified your competitors</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->have_competitors)); ?>

                </td>
            </tr>
            <?php endif; ?>
            <?php if($business_investment_plan[0]->have_competitors == 'Yes'): ?>
            <tr>
                <th scope="row">2.l</th>
                <th class="left" style="text-align: left;">Specify</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->if_yes_specify_competitors)); ?>

                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th scope="row">3</th>
                <th class="left" style="text-align: left;">Date of Business Plan</th>
                <td class="left"><?php echo e($business_investment_plan[0]->date_of_business_plan !='' ?  change_date_month_name_char(str_replace('/','-',$business_investment_plan[0]->date_of_business_plan)) : 'N/A'); ?>

                </td>
            </tr>
            <tr>
                <th scope="row">4</th>
                <th class="left" style="text-align: left;">Family Member responsible for business</th>
                <td class="left"><?php echo e(checkna($business_investment_plan[0]->primarily_business)); ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="13">Total Cost Of The Business (One Time)</td>

            </tr>
        </thead>
        <thead class="back-color">
            <tr>
                <th width="25px">S.No</th>
                <th colspan="3">Name of items</th>
                <th colspan="3">Quantity</th>
                <th colspan="3">Unit Cost</th>
                <th colspan="3">Total Cost</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sum = 0;
            $sum1 = 0;
            
            ?>
            
            <?php if(!empty($fixed_investment[0]->name_of_item)): ?>
            <?php $__currentLoopData = $fixed_investment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $sum += (float) $row->amount;
            $sum1 += (float) $row->totalamount;
            ?>
            <tr>
                <td width="25px"><?php echo e($i); ?></td>

                <td colspan="3"><?php echo e(checkna($row->name_of_item)); ?>

                </td>
                <td colspan="3"><?php echo e(checkna($row->no_of_quantity)); ?>

                </td>
                <td colspan="3"><?php echo e(checkna($row->amount)); ?>

                </td>
                <td colspan="3"><?php echo e(checkna($row->totalamount)); ?></td>
            </tr>
            <?php $i++ ; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr class="total">
                
                <td>Total</td>
                <td colspan="3"></td>
                <td colspan="3"></td>
                <td colspan="3"></td>
                <td colspan="3"><?php echo e($sum1); ?></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead class="back-color">

            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="5">Yearly Recurrent cost/operational expenses</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="tdc" width="4%">S.No</th>
                <th>Item</th>
                <th>Year 1 Expenses</th>
                <th>Year 2 Expenses</th>
                <th>Year 3 Expenses</th>
            </tr>
            <?php
                $sum = 0;
                $sum1 = 0;
                $sum2 = 0;
                $sni=1;
            ?>
            <?php $__currentLoopData = $yearly_expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $total = explode(',', $result->totalamount);
                    $expenses_type = explode(',', $result->expenses_type);
                    
                    $i1 = 0;
                    $i2 = 0;
                    $i3 = 0;
                ?>
                 <?php 
                 if (!empty($expenses_type[0]) > 0) {
                         if ($expenses_type[0] == '1st year expenses') {
                             $i1 = $total[0];
                         }
                         if ($expenses_type[0] == '2nd year expenses') {
                             $i2 = $total[0];
                         }
                         if ($expenses_type[0] == '3rd year expenses') {
                             $i3 = $total[0];
                         }
                     } 
                     if (!empty($expenses_type[1]) > 0) {
                         if ($expenses_type[1] == '1st year expenses') {
                             $i1 = $total[1];
                         }
                         if ($expenses_type[1] == '2nd year expenses') {
                             $i2 = $total[1];
                         }
                         if ($expenses_type[1] == '3rd year expenses') {
                             $i3 = $total[1];
                         }
                     } 
                     if (!empty($expenses_type[2]) > 0) {
                         if ($expenses_type[2] == '1st year expenses') {
                             $i1 = $total[2];
                         }
                         if ($expenses_type[2] == '2nd year expenses') {
                             $i2 = $total[2];
                         }
                         if ($expenses_type[2] == '3rd year expenses') {
                             $i3 = $total[2];
                         }
                     }
                     
                 ?>
                <tr>
                    <td style="text-align: center;"><?php echo e($sni); ?></td>
                    <td><?php echo e($result->name_of_item); ?></td>
                    <td><?php echo $i1 ; ?></td>
                    <td><?php echo $i2 ; ?></td>
                    <td><?php echo $i3 ; ?></td>
                </tr>
                <?php
                    $sum += $i1 ?? 0;
                    $sum1 += $i2 ?? 0;
                    $sum2 += $i3 ?? 0;
                    $sni++;
                    ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <tr>
                <th></th>
                <th>Total</th>
                <td><?php echo e($sum); ?></td>
                <td><?php echo e($sum1); ?></td>
                <td><?php echo e($sum2); ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead class="back-color">
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="5">Income From The Business</td>
            </tr>
        </thead>
         <tbody>
            <tr>
                <th class="tdc" width="4%">S.No</th>
                <th>Item</th>
                <th>Year 1 Income</th>
                <th>Year 2 Income</th>
                <th>Year 3 Income</th>
            </tr>
            <?php
                $sum = 0;
                $sum1 = 0;
                $sum2 = 0;
            ?>
            <?php $__currentLoopData = $income_business; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    
                    $total = explode(',', $result->totalamount);
                    $income_year = explode(',', $result->income_type);
                    
                    $i1 = 0;
                    $i2 = 0;
                    $i3 = 0;
                    $sn=1;
                ?>
                <?php 
                if (!empty($income_year[0]) > 0) {
                        if ($income_year[0] == '1st year income') {
                            $i1 = $total[0];
                        }
                        if ($income_year[0] == '2nd year income') {
                            $i2 = $total[0];
                        }
                        if ($income_year[0] == '3rd year income') {
                            $i3 = $total[0];
                        }
                    } 
                    if (!empty($income_year[1]) > 0) {
                        if ($income_year[1] == '1st year income') {
                            $i1 = $total[1];
                        }
                        if ($income_year[1] == '2nd year income') {
                            $i2 = $total[1];
                        }
                        if ($income_year[1] == '3rd year income') {
                            $i3 = $total[1];
                        }
                    } 
                    if (!empty($income_year[2]) > 0) {
                        if ($income_year[2] == '1st year income') {
                            $i1 = $total[2];
                        }
                        if ($income_year[2] == '2nd year income') {
                            $i2 = $total[2];
                        }
                        if ($income_year[2] == '3rd year income') {
                            $i3 = $total[2];
                        }
                    }
                    
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo e($sn); ?></td>
                    <td><?php echo e($result->name_of_item); ?></td>
                    <td><?php echo $i1 ; ?></td>
                    <td><?php echo $i2 ; ?></td>
                    <td><?php echo $i3 ; ?></td>
                </tr>
                <?php
                    $sum += $i1 ?? 0;
                    $sum1 += $i2 ?? 0;
                    $sum2 += $i3 ?? 0;
                    $sn++;
                    ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th></th>
                <th>Total</th>
                <td><?php echo e($sum); ?></td>
                <td><?php echo e($sum1); ?></td>
                <td><?php echo e($sum2); ?></td>
            </tr>
        </tbody>
       
        
    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="4">Loan Amount And Duration</td>

            </tr>
            <tr>
                <th>Loan Amount</th>
                <th>Interest rate %</th>
                <th>Interest type</th>
                <th>Duration</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><?php echo e(checkna($loan_repayment[0]->principal)); ?></td>
                <td><?php echo e(checkna($loan_repayment[0]->interest)); ?></td>
                <td><?php echo e(checkna($loan_repayment[0]->interest_type)); ?></td>
                
                <td ><?php echo e(($loan_repayment[0]->tenure_mode == 1 ? $loan_repayment[0]->loan_tenure.'-'.'Year' :($loan_repayment[0]->tenure_mode == 0 ? $loan_repayment[0]->loan_tenure.'-'.'Month' : 'N/A') )); ?></td>
            </tr>
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="4">Payment Details </td>

            </tr>
        </thead>
        <thead class="back-color">
            <tr>
                <th width="25%"></th>
                <th >Year 1</th>
                <th >Year 2</th>
                <th >Year 3</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th style="text-align: left;">Total Interest</th>
                <td ><?php echo e((float)$loan_repayment[0]->total_interest_fyear); ?></td>
                <td ><?php echo e((float)$loan_repayment[0]->total_interest_syear); ?></td>
                <td ><?php echo e((float)$loan_repayment[0]->total_interest_thyear); ?></td>
            </tr>
            <tr>
                <th style="text-align: left;">Total Principle</th>
                <td ><?php echo e((float)$loan_repayment[0]->total_loan_fyear); ?></td>
                <td ><?php echo e((float)$loan_repayment[0]->total_loan_syear); ?></td>
                <td ><?php echo e((float)$loan_repayment[0]->total_loan_thyear); ?></td>
            </tr>
            <tr>
                <th style="text-align: left;">Payable amount</th>
                <td ><?php echo e((float) $loan_repayment[0]->total_interest_fyear + (float) $loan_repayment[0]->total_loan_fyear); ?>

                </td>
                <td><?php echo e((float) $loan_repayment[0]->total_interest_syear + (float) $loan_repayment[0]->total_loan_syear); ?>

                </td>
                <td><?php echo e((float) $loan_repayment[0]->total_interest_thyear + (float) $loan_repayment[0]->total_loan_thyear); ?>

                </td>
            </tr>
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="4">PROFIT/LOSS</td>

            </tr>
            <tr>
                <th></th>
                <th class="tdc">Year 1 Expenses</th>
                <th class="tdc">Year 2 Expenses</th>
                <th class="tdc">Year 3 Expenses</th>
            </tr>
        </thead>

        <tbody>
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
            <tr style="background-color: orange;color: #1630e2;font-weight: bolder;font-size: medium;">
                <td>Total</td>
                <td class="tdc"><?php echo e((float) $first_year_expansesamt); ?></td>
                <td class="tdc"><?php echo e((float) $scnd_year_expansesamt); ?></td>
                <td class="tdc"><?php echo e((float) $trd_year_expansesamt); ?></td>
            </tr>
            <tr>
                <td>Income</td>
                <td class="tdc"><?php echo e((float) $first_year_total_incomeamts); ?></td>
                <td class="tdc"><?php echo e((float) $scnd_year_total_incomeamts); ?></td>
                <td class="tdc"><?php echo e((float) $trd_year_total_incomeamts); ?></td>
            </tr>
            <tr style="background-color: #b3aeae;color: #1630e2;font-weight: bolder;font-size: medium;">
                <td>Profit/Loss</td>
                <td style="color:<?php echo e($show1); ?>; " class="tdc"><?php echo e((float) $tv_1profit); ?></td>
                <td style="color:<?php echo e($show2); ?>; " class="tdc"><?php echo e((float) $tv_2profit); ?></td>
                <td style="color:<?php echo e($show3); ?>; " class="tdc"><?php echo e((float) $tv_3profit); ?></td>
            </tr>

        </tbody>

    </table>
    <br>
<table class="table table-bordered table-stripped table1" cellspacing="0">
    <thead>
        <tr class="table-primary" >
            <td style="background-color:#cea38b" colspan="2">Facilitator comment</td>
        </tr>
    </thead>
    <tbody >
        <tr>
            <th>If loss, how will this gap be met</th>
            <th>Comments & Observations</th>
        </tr>
        <tr>
            <td><?php echo e($business_investment_plan[0]->lossgap_type); ?></td>
            <td><?php echo e($business_investment_plan[0]->comments); ?></td>
        </tr>
    </tbody>
</table>


</body>

</html><?php /**PATH D:\xampp\htdocs\village\resources\views/pdf/familyBusinessplanPdf.blade.php ENDPATH**/ ?>