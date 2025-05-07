<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Credit Loan Report</title>
</head>
<style>
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
        text-align: ;
    }

    ;

    .table-primary,
    .table-primary>td,
    .table-primary> {
        background-color: #01a9ac;
        color: #ffffff;

        font-size: 16px;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #e9ecef;
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
@php $session_data = Session::get('credit_loan_filter_session'); @endphp
<body class="antialiased container mt-5">
<h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:70%;top:-50px;font-size:20px; ">Generated On- @php
                echo generated_date();
                @endphp
            </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Credit Loan Report<u> 
            </h2>
        </div>

    </div>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:#01a9ac" colspan="5">Credit Loan </td>
                
            </tr>
          
        
        
    </thead>
        <tbody>
            @php 

              if($session_data !='')
              {
                  if($session_data['group'] == 'AG')
                  {
                      $group = 'Agency';
                  }
                  if($session_data['group'] == 'FM')
                  {
                      $group = 'Family';
                  }
                  if($session_data['group'] == 'FD')
                  {
                      $group = 'Federation';
                  }
                  if($session_data['group'] == 'CL')
                  {
                      $group = 'Cluster';
                  }
                  if($session_data['group'] == 'SH')
                  {
                      $group = 'SHG';
                  }
              }
            @endphp
           
            <tr>
                <th width="20%">Country</th>
                <th>State</th>
                <th>District</th>
                <th>Group Type</th>
                <th>Name</th>

                
                    </tr> 
                    <tr style="text-align: center;">@if(!empty($session_data['country']))
                    <td>{{getCountryByID($session_data['country'])}}</td>
                    <td>{{getStateName($session_data['country'],$session_data['state'])}}</td>
                    <td>{{getDistrictName($session_data['state'],$session_data['district'])}}</td>
                    <td>{{!empty($group) ? $group : '-'}}</td>
                        <td>{{!empty($session_data['federation']) ? $session_data['federation'] : '-'}}</td>
                    @else
                    <td>{{getCountryByID(101)}}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    
                    @endif
                    <!-- <tr style="text-align: center;">
                        <td>{{!empty($country[0]->name) ? $country[0]->name : '-'}}</td>
                        <td>{{!empty($state[0]->name) ? $state[0]->name : '-'}}</td>
                        <td>{{!empty($district[0]->name) ? $district[0]->name : '-'}}</td>
                        <td>{{!empty($group) ? $group : '-'}}</td>
                        <td>{{!empty($session_data['federation']) ? $session_data['federation'] : '-'}}</td> -->
                        
                    </tr>
            <tr>
                <th>Total Loan Demand</th>
                <th></th>
                <th>Total Loan Approved</th>
                <th></th>
                <th>Total Loan Disbursed</th>
                
                    </tr>
            <tr style="text-align: center;">
                <td>{{!empty($loans[0]->loan_demand) ? $loans[0]->loan_demand : ' 0'}}</td>
                <td></td>
                <td>{{!empty($loans[0]->loan_approved) ? $loans[0]->loan_approved : ' 0'}}</td>
                <td></td>
                <td>{{!empty($loans[0]->loan_disbursed) ? $loans[0]->loan_disbursed : '0'}}</td>
                
            </tr>
            
            
        </tbody>

    </table>
    
   
</body>

</html>