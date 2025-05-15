<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Loan Details</title>
</head>

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generate On- <?php
        echo generated_date();
        ?>
    </h5>
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
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Family Loan(<?php echo e($family->uin); ?>)</u>
            </h2>
        </div>

    </div>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="5">1st Requested Loan</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th>Amount</th>
                <th>Purpose</th>
                <th>Mode</th>
                <th>Duration </th>
                <th>Installments </th>
            </tr>

            <?php
            if ($loan_repayment[0]->tenure_mode == 1) {
            $loan_tenure = 12 * $loan_repayment[0]->loan_tenure;
            } else {
            $loan_tenure = $loan_repayment[0]->loan_tenure;
            }
            $loan_duration = 'N/A';
            if($loan_repayment[0]->tenure_mode == 1)
            {
            $loan_duration = $loan_repayment[0]->loan_tenure.'- Year';
            }
            elseif($loan_repayment[0]->tenure_mode == 0)
            {
            $loan_duration = $loan_repayment[0]->loan_tenure.'- Month';
            }
            ?> 
            <tr >
                <td><?php echo e(checkna($loan_repayment[0]->principal)); ?></td>
                <td><?php echo e(checkna($business_investment_plan[0]->type_of_business)); ?></td>
                <td><?php echo e(($loan_repayment[0]->tenure_mode == 1 ? 'Yearly' : ($loan_repayment[0]->tenure_mode == 0 ? 'Monthly' : 'N/A'))); ?></td>
                <td><?php echo e(checkna($loan_duration)); ?></td>
                <td><?php echo e(checkna($loan_tenure)); ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="6">Updates/Changes to 1st loan- Verfication stage</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th>Reviewed/Verified </th>
                <th>Amount</th>
                <th>Purpose</th>
                <th>Mode</th>
                <th>Duration</th>
                <th>Installments</th>
            </tr>
            
            <tr >
                <td><?php echo e(checkna($loan_approvel[0]->get_verified)); ?></td>
                <td><?php echo e(checkna($loan_approvel[0]->uloan_amount)); ?></td>
                <td><?php echo e(checkna($loan_approvel[0]->uloan_purpose)); ?></td>
                <td><?php echo e(checkna($loan_approvel[0]->urepayment_mode)); ?></td>
                <?php
                $uduration = 'N/A';
                if($loan_approvel[0]->urepayment_mode == 'Monthly')
                {
                    $uduration = $loan_approvel[0]->uloan_duration.'- Month';
                }
                if($loan_approvel[0]->urepayment_mode == 'Yearly')
                {
                    $uduration = $loan_approvel[0]->uloan_duration.'- Year';
                }
            ?>
            <td><?php echo e($uduration); ?></td>
                <td><?php echo e(checkna($loan_approvel[0]->uloan_installments)); ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="4">Approved By District Manager</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th style="text-align: left;">Reviewed/Verified by</th>
                
                <td><?php echo e(( !empty($manager[0]->name) ? $manager[0]->name : 'N/A')); ?></td>
                <th style="text-align: left;">Date</th>
                <td><?php echo e($loan_approvel[0]->date !='' ? change_date_month_name_char(str_replace('/','-',$loan_approvel[0]->date)) : 'N/A'); ?></td>
            </tr>

            
        </tbody>
    </table>
            <br>
    <table class="table table-bordered table-stripped table1 page-break" cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="7">After Disbursement</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th>Get a loan? (Y/N)</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Purpose</th>
                <th>Mode</th>
                <th>Duration</th>
                <th>Installments</th>
            </tr>

            <tr >
                <td><?php echo e(checkna($loan_disbursement[0]->get_loan)); ?></td>
                <td><?php echo e($loan_disbursement[0]->disbursement_date !='' ? change_date_month_name_char(str_replace('/','-',$loan_disbursement[0]->disbursement_date)) : 'N/A'); ?></td>
                <td><?php echo e(checkna($loan_disbursement[0]->loan_amount)); ?></td>
                <td><?php echo e(checkna($loan_disbursement[0]->loan_purpose)); ?></td>
                <td><?php echo e(checkna($loan_disbursement[0]->repayment_mode)); ?></td>
                <?php
                $duration = 'N/A';
                    if($loan_disbursement[0]->repayment_mode == 'Monthly')
                    {
                        $duration = $loan_disbursement[0]->loan_duration.'- Month';
                    }
                    if($loan_disbursement[0]->repayment_mode == 'Yearly')
                    {
                        $duration = $loan_disbursement[0]->loan_duration.'- Year';
                    }
                ?>
                <td><?php echo e($duration); ?></td>
                <td><?php echo e(checkna($loan_disbursement[0]->no_installments)); ?></td>
                
            </tr>
        </tbody>
    </table>
    <br>









</body>

</html><?php /**PATH D:\xampp\htdocs\village\resources\views/pdf/familyloanPdf.blade.php ENDPATH**/ ?>