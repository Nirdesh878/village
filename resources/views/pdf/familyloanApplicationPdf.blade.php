<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Loan Application </title>
</head>
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
<body class="antialiased container mt-5">
<h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generate On- @php
                echo generated_date();
                @endphp
            </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Family Loan Application ({{$family->uin}})</u> 
                
            </h2>
        </div>

    </div>
    {{-- family profile --}}
    <table class="table table1 " cellspacing="0" style="border: none;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white; color:black;"><u>BASIC INFORMATION</u></td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="4">Name & Other Details</td>

            </tr>
        </thead>
        <thead>
            <tr>
                <th width="25%" style="text-align: left;">Member name</th>
                <td width="25%">{{ $family_profile[0]->fp_member_name }}</td>
                <th width="25%">UIN</th>
                <td width="25%">{{ $family->uin }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Name of SHG</th>
                <td width="25%">{{ $shg_profile[0]->shgName }}</td>
                <th width="25%" style="text-align: left;">Gender</th>
                @php
                    $GenderData = getMstCommonData(1,$family_profile[0]->fp_gender  ?? null);
                @endphp
                <td>{{ $GenderData[0]->common_values ?? 'N/A' }}</td>
            </tr>
            
            <tr>
                <th width="25%" style="text-align: left;">No of Children</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_children_no !='' ? (int) $family_profile[0]->fp_children_no : 0 }}</td>
                <th width="25%" style="text-align: left;">Aadhar No</th>
                <td width="25%">{{ checkna(aadhar($family_profile[0]->fp_aadhar_no)) }}</td>
            </tr>
            
            <tr>
                <th width="25%" style="text-align: left;">Village</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_village) }}</td>
                <th width="25%" style="text-align: left;">Cluster/Habitation Federation </th>
                <td width="25%">{{ ( !empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A') }}</td>
                
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Federation</th>
                <td width="25%">{{ $fed_profile[0]->name_of_federation }}</td>
                <th width="25%" style="text-align: left;">Spouse Name</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_spouse_name) }}</td>
            </tr>
            
           
        </thead>

    </table>
    <br>
     {{-- family assets --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="4">Family Assets</td>
            </tr>
        </thead>
    
    
    
        <tbody>
            <tr>
                <th width="25%" style="text-align: left;">Land Owned</th>
                <td width="25%">{{ (int) $assets[0]->fa_total_land_owned !='' ? (int) $assets[0]->fa_total_land_owned : 0 }}</td>
                <th width="25%" style="text-align: left;">Animal Sheds</th>
                <td width="25%">{{ checkna($assets[0]->fa_animalsheds) }}</td>

            </tr>
            
            <tr>
                <th width="25%" style="text-align: left;">House Ownership</th>
                <td width="25%">{{ checkna($assets[0]->house_ownership) }}</td>
                <th width="25%" style="text-align: left;">Pacca Kaccha House</th>
                <td width="25%">{{ checkna($assets[0]->fa_Pacca_Kaccha_house) }}</td>

            </tr>
        </tbody>
    </table>
    <br>
    {{-- Vehicle --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b;" colspan="4">Vehicle</td>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <th colspan="2" style="text-align: left;">Name of Vehicle</th>
                <th colspan="2" style="text-align: left;">No. of Vehicle</th>
            </tr>
            @if (!empty($assets_vehicle))
            @foreach ($assets_vehicle as $row)
            <tr>
                <td colspan="2" >{{ $row->vehicle_Types }}</td>
                <td colspan="2" >{{ $row->no_of_vehicle }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <br>
    {{-- Machinery --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">  
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b;" colspan="4">Machinery</td>
            </tr>
        </thead>          
        <tbody>    

            <tr>
                <th colspan="2" style="text-align: left;">Name of Machinery</th>
                <th colspan="2" style="text-align: left;">No. of Machinery</th>
            </tr>
            @if (!empty($assets_machinery))
            @foreach ($assets_machinery as $row)
            <tr>
                <td colspan="2" >{{ $row->machinery_Types }}</td>
                <td colspan="2" >{{ $row->no_of_machinery }}</td>
            </tr>
            @endforeach
            @endif
            
            
           
        </tbody>
    </table>
    <br>
    {{-- Other --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="3">Other</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>A.</td>
                <td width="60%" style="font-weight: bold;"> Any other asset not shown above (specify)</td>
                <td width="40%">{{ checkna($assets[0]->fa_other_assets_A) }}</td>
            </tr>
            <tr>
                <td>B.</td>
                <td  style="font-weight: bold;"> Has your family sold any labor on advance during last two years – yes/no</td>
                <td>{{ checkna($assets[0]->fa_other_assets_B) }}</td>
            </tr>
            @if ($assets[0]->fa_other_assets_B == 'Yes')
            <tr>
                <td>C.</td>
                <td  style="font-weight: bold;"> Explain Purpose</td>
                <td>{{ checkna($assets[0]->fa_other_assets_C) }}</td>
            </tr>
            <tr>
                <td>D.</td>
                <td  style="font-weight: bold;">No of labor days/sold/advanced</td>
                <td>{{ checkna($assets[0]->fa_other_assets_D) }}</td>
            </tr>
            @endif
        </tbody>
    </table>
    <br>
    {{-- Livestock /Animals --}}
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">  
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b;" colspan="2">Livestock </td>
            </tr>
        </thead>          
        <tbody>    
            
            
            <tr>
                <th width="50%" style="text-align: left;">Name of Animal</th>
                <th width="50%" style="text-align: left;">No. of Animal</th>
            </tr>
            @if (!empty($assets_live_stock))
            @foreach ($assets_live_stock as $row)
            <tr>
                <td width="50%" >{{ $row->animal_Types }}</td>
                <td width="50%" >{{ $row->no_of_animals }}</td>
            </tr>
            @endforeach
           @endif
           
            
           
        </tbody>
    </table>
    <br>
    
    {{-- Family Goal --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="2">Family Goal</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">
                    S.No
                </th>
                <th >
                    Name of Goal
                </th>
            </tr>
            @php $i=1; @endphp
            @if (!empty($goals))
            @foreach ($goals as $row)
            <tr>
                <td  class="tdc">{{ $i++ }}</td>
                <td  >{{ $row->fg_goal }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <br>
   
    {{-- Income --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="4">Income  
                </td>
            </tr>
        </thead>
        <tbody >
            <tr>
                <th width="25%">Income From All Sources </th>
                <th width="25%">1st Year Income</th>
                <th width="25%">2nd Year Income</th>
                <th width="25%">Total</th>
            </tr>
            <tr>
                <td>Income From Agriculture</td>
                <td >{{(int)$income_this_year[0]->agriculture}}</td>
                <td >{{(int)$income_next_year[0]->agriculture}}</td>
                <td>{{(int)$income_this_year[0]->agriculture + (int)$income_next_year[0]->agriculture}}</td>
            </tr>
            <tr>
                <td>Income From Horticulture</td>
                <td >{{(int)$income_this_year[0]->horticulture}}</td>
                <td>{{(int)$income_next_year[0]->horticulture}}</td>
                <td>{{(int)$income_this_year[0]->horticulture + (int)$income_next_year[0]->horticulture}}</td>
            </tr>
            <tr>
                <td>Income from livestock</td>
                <td >{{(int)$income_this_year[0]->livestock}}</td>
                <td>{{(int)$income_next_year[0]->livestock}}</td>
                <td>{{(int)$income_this_year[0]->livestock + (int)$income_next_year[0]->livestock}}</td>
            </tr>
            <tr>
                <td>Other Sources of Income</td>
                <td >{{(int)$income_this_year[0]->other_income}}</td>
                <td>{{(int)$income_next_year[0]->other_income}}</td>
                <td>{{(int)$income_this_year[0]->other_income + (int)$income_next_year[0]->other_income}}</td>
            </tr>
            <tr>
                <th>Total Income</th>
                <th>{{(int)$income_this_year[0]->agriculture + (int)$income_this_year[0]->horticulture + (int)$income_this_year[0]->livestock + (int)$income_this_year[0]->other_income}}</th>
                <th>{{(int)$income_next_year[0]->agriculture + (int)$income_next_year[0]->horticulture + (int)$income_next_year[0]->livestock + (int)$income_next_year[0]->other_income}}</th>
                <th>{{(int)$income_this_year[0]->agriculture + (int)$income_next_year[0]->agriculture + (int)$income_this_year[0]->horticulture + (int)$income_next_year[0]->horticulture + (int)$income_this_year[0]->livestock + (int)$income_next_year[0]->livestock + (int)$income_this_year[0]->other_income + (int)$income_next_year[0]->other_income}}</th>
            </tr>
            
        </tbody>
    </table>
    <br>
    {{-- Expenditure --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="4">Expenditure  
                </td>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <th width="25%">Expenditure</th>
                <th width="25%">This Year </th>
                <th width="25%">Next Year </th>
                <th width="25%">Total</th>
            </tr>
           
            <tr>
                <td>Normal Expenditure</td>
                <td>{{checkZero($normal_expenditure[0]->e_total_amount)}}</td>
                <td>{{checkZero($normal_expenditure_next[0]->e_total_amount)}}</td>
                <td>{{$normal_expenditure[0]->e_total_amount + $normal_expenditure_next[0]->e_total_amount}}</td>
            </tr>
            <tr>
                <td>Social Expenditure</td>
                <td>{{checkZero($social_expenditure[0]->e_total_amount)}}</td>
                <td>{{checkZero($social_expenditure_next[0]->e_total_amount)}}</td>
                <td>{{$social_expenditure[0]->e_total_amount + $social_expenditure_next[0]->e_total_amount}}</td>
            </tr>
            <tr>
                <td>Wasteful Expenditure</td>
                <td>{{checkZero($wasteful_expenditure[0]->e_total_amount)}}</td>
                <td>{{checkZero($wasteful_expenditure_next[0]->e_total_amount)}}</td>
                <td>{{$wasteful_expenditure[0]->e_total_amount + $wasteful_expenditure_next[0]->e_total_amount}}</td>

            </tr>
            <tr>
                <td>Loan Expenditure</td>
                <td>{{checkZero($loan_expenditure[0]->this_year)}}</td>
                <td>{{checkZero($loan_expenditure[0]->next_year)}}</td>
                <td>{{$loan_expenditure[0]->this_year + $loan_expenditure[0]->next_year}}</td>
            </tr>
            <tr>
                <th>Total Expenditure</th>
                <th>{{$normal_expenditure[0]->e_total_amount + $social_expenditure[0]->e_total_amount + $wasteful_expenditure[0]->e_total_amount + $loan_expenditure[0]->this_year}}</th>
                <th>{{$normal_expenditure_next[0]->e_total_amount + $social_expenditure_next[0]->e_total_amount + $wasteful_expenditure_next[0]->e_total_amount }}</th>
                <th>{{$normal_expenditure[0]->e_total_amount + $normal_expenditure_next[0]->e_total_amount + $social_expenditure[0]->e_total_amount + $social_expenditure_next[0]->e_total_amount + $wasteful_expenditure[0]->e_total_amount + $wasteful_expenditure_next[0]->e_total_amount + $loan_expenditure[0]->next_year}}</th>
            </tr>
            
        </tbody>
    </table>
    <br>
   
    {{-- Saving --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="4">Saving  
                </td>
            </tr>
        </thead >
        
            <thead class="back-color" >
                <tr>
                    <th>Type</th>
                    <th>Amount Saved Per Month</th>
                    <th>Saved During Last 12 Months</th>
                    <th>Total Saving</th>
                    
                </tr>
            </thead>
            <tbody >
                @if (!empty($savings_source))
                    @php
                        $sum = 0;
                        $sum1 = 0;
                        $sum2 = 0;
                    @endphp
                    @foreach ($savings_source as $row)
                        @php
                            $sum = $sum + (float) $row->s_total_saving;
                            $sum1 = $sum1 + (float) $row->s_saving_per_month;
                            $sum2 = $sum2 + (float) $row->s_last_saved_amt;
                        @endphp
                        <tr>
                            <td>{{ $row->s_type }}</td>
                            <td>{{ $row->s_saving_per_month }}</td>
                            <td>{{ $row->s_last_saved_amt }}</td>
                            <td>{{ $row->s_total_saving }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr class="total">
                    <th >Total</th>
                    <th>{{ $sum1 ?? 0 }}</th>
                    <th>{{ $sum2 ?? 0 }}</th>
                    <th>{{ $sum ?? 0 }}</th>
                </tr>
            </tbody>
        
    </table>
    <div class="page-break"></div>
    <br>
    
    {{-- other saving --}}
    @if (!empty($savings_source_other))
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="4">Other Saving  
                </td>
            </tr>
        </thead >
                <tbody >
                    <tr>
                        <th width="25%">Loan</th>
                        <th width="25%">Fixed Deposit Term Period</th>
                        <th width="25%">Interest</th>
                        <th width="25%">Amount</th>
                    </tr>
                   
                        @php $sum=0; @endphp
                        @foreach ($savings_source_other as $row)
                            @php $sum=$sum+(float)$row->other_amount; @endphp
                            <tr>
                                <td>{{ $row->other_loan ?? '' }}</td>
                                
                                <td>{{ $row->other_fixed_deposit_term_period ?? '' }}</td>
                                <td>{{ $row->other_interest ?? '' }}</td>
                                <td>{{ $row->other_amount ?? '' }}</td>
                            </tr>
                        @endforeach
                   
                    <tr class="total">
                        <th colspan="">Total</th>
                        <td></td>
                        <td></td>
                        <th>{{ $sum ?? 0 }}</th>
                    </tr>
                </tbody>
            
        
    </table>
    <br>
    @endif
    {{-- Loan outstanding --}}
    <table class="table table1 " cellspacing="0" style="border: none;">
        <thead>
            <tr class="" >
                <td style="background-color:white;color:black;text-align:center;" colspan="10"><u>LOAN OUTSTANDING</u> 
  
                </td>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead class="back-color" style="border-bottom: 1.5px grey solid;">

           
            <tr>
                <th width="10%">Loan Type</th>
                <th>Loan Amount</th>
                <th>Purpose</th>
                <th>Interest type</th>
                <th>Annual interest rate (%)</th>
                <th>Loan tenure</th>
                <th>Repayment start date</th>
                <th>Last repayment date</th>
                <th>Data collection date</th>
                <th>No of EMIs paid during last 12 months</th>
                <th>Total amount paid during last 12 months</th>
                <th>No of cumulative EMIs repaid</th>
                <th>Cumulative amount paid</th>
                <th>Overdue amount</th>
                <th>Next year loan repayment commitment</th>
            </tr>
        </thead>
        <tbody>
            {{-- SHG LOAN --}}
            <tr >
                <td colspan="15" style="font-weight: bold;">
                    SHG LOAN
                </td>
            </tr>
            @php
            $shg_total=0;
            $shg_amount=0;
            @endphp
            @if (!empty($Shg_loan))
            
                @foreach ($Shg_loan as $res)
                     @php 
                     $shg_total = $shg_total+$res->lo_next_year;
                     $shg_amount = $shg_amount+$res->lo_principle_amount; 
                     $loan_tenure = '';
                     if($res->lo_tenure_mode == 0)
                     {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Month';
                     }
                     elseif ($res->lo_tenure_mode == 1) {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Year';
                     }
                     @endphp
                    
                    <tr>
                        <th ></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $shg_amount }}</td>
                    <th colspan="12"></th>
                    <td>{{ $shg_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- MONEY LENDER LOAN --}}
            <tr>
                <td colspan="15" style="font-weight: bold;">
                    MONEY LENDER LOAN
                </td>
            </tr>
            @php
            $money_total=0;
            $money_amount=0;
            @endphp
            @if (!empty($money_loan))
            
                @foreach ($money_loan as $res)
                @php 
                $money_total = $money_total+$res->lo_next_year;
                $money_amount = $money_amount+$res->lo_principle_amount; 
                $loan_tenure = '';
                     if($res->lo_tenure_mode == 0)
                     {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Month';
                     }
                     elseif ($res->lo_tenure_mode == 1) {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Year';
                     }
                @endphp
                    <tr>
                        <th></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $money_amount }}</td>
                    <td colspan="12"></td>
                    <td>{{ $money_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- BANK LOAN --}}
            <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    BANK LOAN
                </td>
            </tr>
            @php
            $bank_total=0;
            $bank_amount=0;
            @endphp
            @if (!empty($Bank_loan))
            
                @foreach ($Bank_loan as $res)
                @php 
                $bank_total = $bank_total+$res->lo_next_year;
                $bank_amount = $bank_amount+$res->lo_principle_amount; 
                $loan_tenure = '';
                     if($res->lo_tenure_mode == 0)
                     {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Month';
                     }
                     elseif ($res->lo_tenure_mode == 1) {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Year';
                     }
                @endphp
                    <tr>
                        <th></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $bank_amount }}</td>
                    <th colspan="12"></th>
                    <td>{{ $bank_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- VI LOAN --}}
            <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    VI LOAN
                </td>
            </tr>
            @php
            $vi_total=0;
            $vi_amount=0;
            @endphp
            @if (!empty($vi_loan))
            
                @foreach ($vi_loan as $res)
                @php 
                $vi_total = $vi_total+$res->lo_next_year;
                $vi_amount = $vi_amount+$res->lo_principle_amount; 
                $loan_tenure = '';
                     if($res->lo_tenure_mode == 0)
                     {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Month';
                     }
                     elseif ($res->lo_tenure_mode == 1) {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Year';
                     }
                @endphp
                    <tr>
                        <th width="10%"></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $vi_amount }}</td>
                    <td colspan="12"></td>
                    <td>{{ $vi_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- CLUSTER LOAN --}}
            <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    CLUSTER LOAN
                </td>
            </tr>
            @php
            $cluster_total=0;
            $cluster_amount=0;
            @endphp
            @if (!empty($cluster_loan))
            
                @foreach ($cluster_loan as $res)
                @php 
                $cluster_total = $cluster_total+$res->lo_next_year;
                $cluster_amount = $cluster_amount+$res->lo_principle_amount; 
                $loan_tenure = '';
                     if($res->lo_tenure_mode == 0)
                     {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Month';
                     }
                     elseif ($res->lo_tenure_mode == 1) {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Year';
                     }
                @endphp
                    <tr>
                        <th width="10%"></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $cluster_amount }}</td>
                    <td colspan="12"></td>
                    <td>{{ $cluster_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- FEDERATION LOAN --}}
            <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    FEDERATION LOAN
                </td>
            </tr>
            @php
            $fed_total=0;
            $fed_amount=0;
            @endphp
            @if (!empty($fed_loan))
            
                @foreach ($fed_loan as $res)
                @php 
                $fed_total = $fed_total+$res->lo_next_year;
                $fed_amount = $fed_amount+$res->lo_principle_amount; 
                $loan_tenure = '';
                     if($res->lo_tenure_mode == 0)
                     {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Month';
                     }
                     elseif ($res->lo_tenure_mode == 1) {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Year';
                     }
                @endphp
                    <tr>
                        <th width="10%"></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $fed_amount }}</td>
                    <td colspan="12"></td>
                    <td>{{ $fed_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- OTHER LOAN --}}
            <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    OTHER LOAN
                </td>
            </tr>
            @php
            $other_total=0;
            $other_amount=0;
            @endphp
            @if (!empty($other_loan))
            
                @foreach ($other_loan as $res)
                @php 
                $other_total = $other_total+$res->lo_next_year;
                $other_amount = $other_amount+$res->lo_principle_amount; 
                $loan_tenure = '';
                     if($res->lo_tenure_mode == 0)
                     {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Month';
                     }
                     elseif ($res->lo_tenure_mode == 1) {
                        $loan_tenure = $res->lo_no_of_tenure.'-'.'Year';
                     }
                @endphp
                    <tr>
                        <th width="10%"></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $other_amount }}</td>
                    <td colspan="12"></td>
                    <td>{{ $other_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            <tr style="font-weight:bold">
                <th width="10%">Grand Total</th>
                <td>{{ $other_amount  + $fed_amount  + $cluster_amount  +$bank_amount  + $money_amount  + $shg_amount +$vi_amount   }}</td>
                <td colspan="12"></td>
                <td>{{ $other_total  + $fed_total  + $cluster_total  +$bank_total  + $money_total   + $shg_total  +$vi_total  }}</td>
            </tr>
            
        </tbody>
    </table>
    <br>
    {{-- <table class="table table-bordered table-stripped table1 " cellspacing="0">

        <tbody>
            <tr style="background-color:#01a9ac">
                <th class="tdc" width="4%">S.No</th>
                <th width="24%">Loan Details</th>
                <th width="9%">Loan 1 Moneylender</th>
                <th width="9%">Loan 2 Bank</th>
                <th width="9%">Loan 3 SHG</th>
                <th width="9%">Loan 4 Cluster</th>
                <th width="9%">Loan 5 Federation</th>
                <th width="9%">Loan 6 Other</th>
                <th width="9%">Loan 7 VI</th>
                <th width="9%">Total</th>
            </tr>

            <tr>
                <td class="tdc">1</td>
                <td>Loan Amount</td>
                @php
                    echo implode($loan_outstanding_pivot[0]);
                @endphp
                <td>{{ $sum_1 ?? 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">2</td>
                <td>Purpose</td>
                @php
                    echo implode($loan_outstanding_pivot[1]);
                @endphp
                <td>N/A</td>
            </tr>
            <tr>
                <td class="tdc">3</td>
                <td>Interest type</td>
                @php
                    echo implode($loan_outstanding_pivot[2]);
                @endphp
                <td>N/A</td>
            </tr>
            <tr>
                <td class="tdc">4</td>
                <td>Annual interest rate (%)</td>
                @php
                    echo implode($loan_outstanding_pivot[3]);
                @endphp
                <td>N/A</td>
            </tr>
            <tr>
                <td class="tdc">5</td>
                <td>Loan tenure</td>
                @foreach ($loan_mode as $row)
                    <td>{{ $row }}</td>
                @endforeach

                <td>N/A</td>
            </tr>
            <tr>
                <td class="tdc">6</td>
                <td>Repayment start date</td>
                @php
                    echo implode($loan_outstanding_pivot[5]);
                @endphp
                <td>N/A</td>
            </tr>
            <tr>
                <td class="tdc">7</td>
                <td>Last repayment date</td>
                @php
                    echo implode($loan_outstanding_pivot[6]);
                @endphp
                <td>N/A</td>
            </tr>
            <tr>
                <td class="tdc">8</td>
                <td>Data collection date</td>
                @php
                    echo implode($loan_outstanding_pivot[7]);
                @endphp
                <td>N/A</td>
            </tr>
            <tr>
                <td class="tdc">9</td>
                <td>No of EMIs paid during last 12 months</td>
                @php
                    echo implode($loan_outstanding_pivot[8]);
                @endphp
                <td>{{ $sum_2 ?? '' }}</td>
            </tr>
            <tr>
                <td class="tdc">10</td>
                <td>Total amount paid during last 12 months</td>
                @php
                    echo implode($loan_outstanding_pivot[9]);
                @endphp
                <td>{{ $sum_3 ?? '' }}</td>
            </tr>
            <tr>
                <td class="tdc">11</td>
                <td>No of cumulative EMIs repaid</td>
                @php
                    echo implode($loan_outstanding_pivot[10]);
                @endphp
                <td>{{ $sum_10 ?? '' }}</td>
            </tr>
            <tr>
                <td class="tdc">12</td>
                <td>Cumulative amount paid</td>
                @php
                    echo implode($loan_outstanding_pivot[11]);
                @endphp
                <td>{{ $sum_11 ?? '' }}</td>
            </tr>
            <tr>
                <td class="tdc">13</td>
                <td>Overdue amount</td>
                @php
                    echo implode($loan_outstanding_pivot[12]);
                @endphp
                <td>{{ $sum_12 ?? '' }}</td>
            </tr>
            <tr>
                <td class="tdc">14</td>
                <td>Next year loan repayment commitment</td>
                @php
                    echo implode($loan_outstanding_pivot[13]);
                @endphp
                <td>{{ $sum_13 ?? '' }}</td>
            </tr>


        </tbody>
    </table> --}}
    <br>
    {{-- Required Investments/Loan  --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="5">Required Investments/Loan  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>                    
                <th>Requested Loan Amount</th>
                <th>Purpose</th>
                <th>Repayment mode</th>
                <th>Loan duration </th>
                <th>Number installments </th>
            </tr>

            @php
            $loan_duration='';
            $loan_tenure='';
            if($loan_repayment[0]->tenure_mode !='')
            {
            if ($loan_repayment[0]->tenure_mode == 1) {
            $loan_tenure = 12 * $loan_repayment[0]->loan_tenure;
            } else {
            $loan_tenure = $loan_repayment[0]->loan_tenure;
            }
            $loan_duration ='';
            if($loan_repayment[0]->tenure_mode == 1)
            {
            $loan_duration = $loan_repayment[0]->loan_tenure.' - Year';
            }
            elseif(($loan_repayment[0]->tenure_mode == 0))
            {
            $loan_duration = $loan_repayment[0]->loan_tenure.' - Month';
            }
            }
            @endphp 
            <tr >
                <td>{{$loan_repayment[0]->principal }}</td>
                <td>{{$business_investment_plan[0]->type_of_business}}</td>
                @if($loan_repayment[0]->tenure_mode == 1)
                <td>Yearly</td>
                @elseif($loan_repayment[0]->tenure_mode == 0)
                <td>Monthly</td>
                @else
                <td></td>
                @endif
                <td>{{$loan_duration}}</td>
                <td>{{$loan_tenure}}</td>
            </tr>
        </tbody>
    </table>
    <br>
    {{-- Analysis --}}
    <table class="table table1 " cellspacing="0" style="border: none;">
        <thead>
            <tr class="" style="text-align: center;">
                <td style="background-color:white; color:black;"><u>FAMILY ANALYSIS</u></td>
            </tr>
        </thead>
    </table>
    <br>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="4">Analysis & Score</td>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <th style="text-align: left;">Final Risk Assessment Score</th>
                <td>{{ $grand_total_cy }}</td>
                <th style="text-align: left;">Color</th>
                <td>
                    <div class="round" style="background:{{ $grdcolor }} ;margin-left:45%; "></div>
                </td>
               

            </tr>
         
           
        </tbody>
    </table>
   
    <br>
    {{-- Challenges --}}
    
    {{-- observation --}}
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#cea38b" colspan="3">Key Highlights and Observations about the Family</td>

            </tr>
        </thead>
        <thead class="back-color">
            <tr>
                <th width="4%">S.No</th>
                <th >Questions</th>
                <th >Answers</th>
            </tr>
        </thead>
        <tbody >
           
            <tr>
                <td scope="row">1</td>
                <th style="text-align: left;">Does this family have some vulnerabilities or potential risks that
                    need to be highlighted?</th>
                <td>{{ $observation_this_year[0]->fdip_observation_vulnerabilities }}
                    <ol type="A">
                        @if ($observation_this_year[0]->fdip_observation_highlights_a_6 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_a_6 }}
                        </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_b_6 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_b_6 }}
                        </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_c_6 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_c_6 }}
                        </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_d_6 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_d_6 }}
                        </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_e_6 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_e_6 }}
                        </li>
                        @endif
                    </ol>
                </td>
            </tr>
           
            <tr>
                <td scope="row">2</td>
                <th style="text-align: left;">What makes this family deserving to receive a loan?</th>
                <td>
                    <ol type="A">
                        @if ($observation_next_year[0]->fdip_observation_next_what != '')
                        <li>{{ $observation_next_year[0]->fdip_observation_next_what }}
                        </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_what_b_4 != '')
                        <li>{{ $observation_next_year[0]->fdip_observation_next_what_b_4 }}
                        </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_what_c_4 != '')
                        <li>{{ $observation_next_year[0]->fdip_observation_next_what_c_4 }}
                        </li>
                        @endif
                    </ol>
                </td>
            </tr>
            <tr>
                <td scope="row">3</td>
                <th style="text-align: left;">What do you think wold be biggest risk in lending to them?</th>
                <td>
                    <ol type="A">
                        @if ($observation_next_year[0]->fdip_observation_next_risk != '')
                        <li>{{ $observation_next_year[0]->fdip_observation_next_risk }}
                        </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_risk_b_5 != '')
                        <li>{{ $observation_next_year[0]->fdip_observation_next_risk_b_5 }}
                        </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_risk_c_5 != '')
                        <li>{{ $observation_next_year[0]->fdip_observation_next_risk_c_5 }}
                        </li>
                        @endif
                    </ol>
                </td>
            </tr>
            
           
        </tbody>

    </table>
    <br>
    <br>
   
    {{-- manger  --}}
    <table class="table table1 " cellspacing="0" style="border: none;">
        <thead>
            <tr class="" style="text-align: center;">
                <td style="background-color:white;color:black"><u>DISTRICT MANAGER VERIFICATION/COMMENTS</u></td>
            </tr>
        </thead>
    </table>
    @if (!empty($t_q_a))
            <table class="table table-bordered table-stripped table1" cellspacing="0">
                <thead>
                    <tr class="" style="background-color:#cea38b">
                        <td style="text-align: left;">Verification</td>
                        <td style="text-align: left;">Comments</td>
                        <td style="text-align: left;">Date</td>
                    </tr>
                </thead>
                <tbody class="back-color">
                    
                    @foreach ( $t_q_a as $res)
                    @if($res->qa_status !='P')
                    @php
                    $status='';
                        if($res->qa_status == 'V')
                        {
                          $status='Verified';
                        }
                        elseif ($res->qa_status == 'R') {
                            $status='Rejected';
                        }
                        else {
                            $status='N/A';
                        }
                    @endphp
                    <tr>
                        <td>{{$status}}</td>
                        <td><span><?php echo $res->remark; ?></span></td>
                        <td>{{change_date_month_name_char(str_replace('/','-',$res->created_at)) ?? 'N/A' }}</td>
                    </tr>
                    @endif
                    
                    @endforeach
                    
                    

                </tbody>

            </table>
        @endif
      


</body>
</html>