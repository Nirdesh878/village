<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SHG</title>
</head>

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generated On- @php
        echo generated_date();
        @endphp
    </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>SHG Profile({{$shg->uin}})</u>
            </h2>
        </div>

    </div>
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
        .round{
                   border-radius: 85%;
                    width: 35px;
                    height: 35px;
        }
        th{text-align: start;}
        .tdc{text-align: center;}
        .tds{text-align: start;}

       .page-break {
                page-break-before: always;
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
    
    <!-- Shg Profile -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >BASIC INFORMATION</td>
            </tr>
        </thead>
    </table>
    <br>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td  colspan="4">Name & Other Details</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Name</th>
                <td width="25%">{{ $profile[0]->shgName }} </td>
                <th width="25%">UIN</th>
                <td width="25%">{{ $shg->uin }}</td>
            </tr>
            <tr>
                <th width="25%">Cluster</th>
                <td width="25%">{{ (!empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A' )  }}</td>
                <th width="25%">Federation</th>
                <td width="25%">{{ $fed_profile[0]->name_of_federation }}</td>
            </tr>
            <tr>
                <th width="25%">Village</th>
                <td width="25%">{{ $profile[0]->village }}</td>
                <th width="25%">District</th>
                <td width="25%">{{ $profile[0]->name_of_district }}</td>
            </tr>
            <tr>
                <th width="25%">State</th>
                <td width="25%">{{ $profile[0]->name_of_state }}</td>
                <th width="25%">Country</th>
                <td width="25%">{{ $profile[0]->name_of_country }}</td>
            </tr>
            <tr>
                <th width="25%">NRLM Code</th>
                <td width="25%">{{ $profile[0]->shg_code }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">SHG Creation And Membership</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Date of creation</th>
                <td width="25%" style="text-align: start;">{{ change_date_month_name_char(str_replace('/','-',$profile[0]->formed)) }} </td>
                <th width="25%">No of current Members</th>
                <td width="25%" style="text-align: start;">{{ $profile[0]->current_members }}</td>
            </tr>
            <tr>
                <th width="25%">No of Members at the time of Creation</th>
                <td width="25%" style="text-align: start;">{{ $profile[0]->members_at_creation }}</td>
                <th width="25%">No of members left since creation</th>
                <td width="25%" style="text-align: start;">{{ $profile[0]->members_left }}</td>
            </tr>
            <tr>
                <th width="25%">No of members from same neighborhood</th>
                <td width="25%" style="text-align: start;">{{ $profile[0]->members_neighborhood }}</td>
                <th width="25%"></th>
                <td width="25%" style="text-align: start;"></td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Current Leadership Names</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">President/Animator</th>
                <td width="25%" style="text-align: start;">{{ checkna($profile[0]->president) }}</td>
                <th width="25%">Secretary</th>
                <td width="25%" style="text-align: start;">{{ checkna($profile[0]->secretary) }}</td>
            </tr>
            <tr>
                <th width="25%">Treasurer</th>
                <td width="25%" style="text-align: start;">{{ checkna($profile[0]->treasure) }}</td>
                <th width="25%"></th>
                <td width="25%" style="text-align: start;"></td>
            </tr>


        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Current Book Keeper</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Name</th>
                <td width="25%" style="text-align: start;">{{ checkna($profile[0]->book_keeper_name) }}</td>
                <th width="25%">Date of appointment</th>
                <td width="25%" style="text-align: start;">{{$profile[0]->book_keeper_date !='' ? change_date_month_name_char(str_replace('/','-',$profile[0]->book_keeper_date)) : 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Bank Account Details</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Account opening date</th>
                <td width="25%" style="text-align: start;">{{  change_date_month_name_char(str_replace('/','-',$profile[0]->bank_date)) }}</td>
                <th width="25%">Name of the bank</th>
                @if($profile[0]->bank_name !='Other')
                <td width="25%" style="text-align: start;">{{ checkna($profile[0]->bank_name) }}</td>
                @else   
                <td width="25%" style="text-align: start;">{{ checkna($profile[0]->other_bank_name) }}</td>
                @endif
            </tr>
            <tr>
                <th width="25%">Name of Branch</th>
                <td width="25%" style="text-align: start;">{{ checkna($profile[0]->bank_branch) }}</td>
                <th width="25%">Account no</th>
                <td width="25%" style="text-align: start;">{{ checkna($profile[0]->bank_ac_no) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="page-break"></div>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Agency That Formed SHG</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Agency Name</th>
                <td width="25%">{{ checkna($agency_profile[0]->agency_name) }}</td>
                <td width="25%"></td>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table><br>

    <table class="table table-bordered table-stripped table1 "cellspacing="0" >
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Whether SHG Has Been Restructured</td>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <th width="25%">Whether SHG has been restructured</th>
                <td width="25%">@if($profile[0]->shg_basicProfile_restructured !='')  Yes @else No @endif</td>
                <th width="25%">Date of restructuring</th>
                <td width="25%">{{ $profile[0]->shg_basicProfile_restructured !='' ? change_date_month_name_char(str_replace('/','-',$profile[0]->shg_basicProfile_restructured)) : 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
    <br>

    
    <!-- Governance -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >GOVERNANCE</td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Adoption</td>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th width="25%">Adoption of Rules</th>
                <td width="25%" >{{ checkna($governance[0]->adoption_rules) }}</td>
                <th width="25%">Written Rules</th>
                <td width="25%" >{{ checkna($governance[0]->written_norms) }}</td>
            </tr>
            <tr>
                
                <th width="25%">Date of Adoption</th>
                <td width="25%" >{{ $governance[0]->adoption_date !='' ?  change_date_month_name_char(str_replace('/','-',$governance[0]->adoption_date)) : 'N/A' }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
            

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Details On Election</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Frequency as per norms</th>
                <td width="25%" >{{ checkna($governance[0]->election_frequency) }}</td>
                <th width="25%">1st election date</th>
                <td width="25%" >{{  $governance[0]->first_election_date !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->first_election_date)) : 'N/A'}}</td>
            </tr>
            <tr>
                <th width="25%">No of Elections conducted so far</th>
                <td width="25%" >{{ checkna($governance[0]->no_of_election_conducted) }}</td>
                <th width="25%">Date of Last Election</th>
                <td width="25%" >{{ $governance[0]->last_election_date !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->last_election_date)):'N/A' }}</td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Meeting Details</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Frequency of Meetings</th>
                <td width="25%" >{{ checkZero($governance[0]->meetings_frequency_spinner) }}</td>
                <th width="25%">No of meetings conducted during last 12 months</th>
                <td width="25%" >{{ checkZero($governance[0]->no_of_meeting_conducted) }}</td>
            </tr>
            <tr>
                <th width="25%">Average Participation of Members during last 12 months</th>
                <td width="25%" >{{ checkZero($governance[0]->average_participation) }}</td>
                <th width="25%">Meetings Recorded</th>
                <td width="25%" >{{ checkZero($governance[0]->meetings_recorded) }}</td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Status Of Minutes During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Who writes the minutes</th>
                <td width="25%" >{{ $governance[0]->who_writes_minutes !='' ? $governance[0]->who_writes_minutes : 'N/A' }}</td>
                <th width="25%">Other Writes the Minutes</th>
                <td width="25%" >{{$governance[0]->other_writes_minutes !='' ? $governance[0]->other_writes_minutes : 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Updating Of Books Of Accounts</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">How often books updated</th>
                <td width="25%" >{{ checkna($governance[0]->how_book_updated) }}</td>
                <th width="25%">Date of last update</th>
                <td width="25%" >{{ $governance[0]->date_last_update_book !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->date_last_update_book)) :'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Updated status</th>
                <td width="25%" >{{ checkna($governance[0]->shg_updated_status) }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4" >Bank Accounts In Regular Operation During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Bank accounts in regular operation during last 12 months</th>
                <td width="25%">{{ checkna($governance[0]->passbook_updated) }}</td>
                <td width="25%"></td>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Grade During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Grade</th>
                <td width="25%">{{ checkna($governance[0]->grading) }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <!-- <div class="page-break"></div> -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Internal Audit</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Whether conducted (Y/N)</th>
                <td width="25%" >{{ checkna($governance[0]->internal_audit) }}</td>
                <th width="25%">Date of audit</th>
                <td width="25%" >{{ $governance[0]->internal_audit_date !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->internal_audit_date)):'N/A' }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">External Audit</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Whether conducted</th>
                <td width="25%" >{{ checkna($governance[0]->external_audit) }}</td>
                <th width="25%">Date of audit</th>
                <td width="25%" >{{ $governance[0]->external_audit_date !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->external_audit_date)):'N/A' }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <!-- inclusion -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >INCLUSION</td>
            </tr>
        </thead>
    </table>
   <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Wealth Ranking({{ $inclusion[0]->wealth_ranking }})</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Date of 1st poverty mapping</th>
                <td width="25%" >{{ $inclusion[0]->poverty_mapping_date !='' ?  change_date_month_name_char(str_replace('/','-',$inclusion[0]->poverty_mapping_date )) : 'N/A' }}</td>
                <th width="25%">Date of last update during last 12 months</th>
                <td width="25%" >{{  $inclusion[0]->wealth_last_update_date !='' ?  change_date_month_name_char(str_replace('/','-',$inclusion[0]->wealth_last_update_date)) :'N/A' }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Visual Poverty Ranking</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">No of Poorest &amp; vulnerable</th>
                <td width="25%" >{{ checkZero($inclusion[0]->no_of_visual_poorest) }}</td>
                <th width="25%">No of Poor</th>
                <td width="25%" >{{ checkZero($inclusion[0]->no_of_visual_poor) }}</td>
            </tr>
            <tr>
                <th width="25%">No of Medium Poor</th>
                <td width="25%" >{{ checkZero($inclusion[0]->no_of_visual_medium_poor) }}</td>
                <th width="25%">No of Rich</th>
                <td width="25%" >{{ checkZero($inclusion[0]->no_of_visual_rich) }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Caste Composition</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">No of SC, ST</th>
                <td width="25%" >{{ $inclusion[0]->no_of_sc_caste !='' ? $inclusion[0]->no_of_sc_caste : 0 }}</td>
                <th width="25%">No of OBC</th>
                <td width="25%" >{{ $inclusion[0]->no_of_obc_caste !='' ? $inclusion[0]->no_of_obc_caste : 0  }}</td>
            </tr>
            <tr>
                <th width="25%">No of others</th>
                <td width="25%" >{{ checkZero($inclusion[0]->no_of_other_caste) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="13">No. Of Loans And Amounts Given To SHG Members During Last 12 Months</td>
            </tr>
            
            <tr>
                <th colspan="3" class="tdc">Total Loans Disbursed</th>
                <td colspan="3" class="tdc">{{ checkZero($inclusion[0]->no_of_total_members_benefited) }}</td>
                <th colspan="3" class="tdc">Total Amount Disbursed</th>
                <td colspan="4" class="tdc">{{ checkZero($inclusion[0]->no_of_total_members_benefited_amount) }}</td>
            </tr>
            <tr>
                <th></th>
                <th colspan="2" class="tdc">Internal Loans</th>
                <th colspan="6" class="tdc">External Loans</th>
                <th colspan="2" class="tdc">VI Loans</th>
                <th colspan="2" class="tdc"></th>
            </tr>
            <tr>
                <th>Category</th>
                <th class="table_th tdc" colspan="2">Internal </th>
                <th class="table_th tdc" colspan="2">Federation </th>
                <th class="table_th tdc" colspan="2">Bank </th>
                <th class="table_th tdc" colspan="2">Other </th>
                <th class="table_th tdc" colspan="2">VI </th>
                <th class="table_th tdc" colspan="2">Total</th>

            </tr>
        </thead>

        <tbody>
            <tr>
                <th></th>
                <th class="tdc">No. of loan disbursed (#)</th>
                <th class="tdc">Amount disbursed (Rs.)</th>
                <th class="tdc">No. of loan disbursed (#)</th>
                <th class="tdc">Amount disbursed (Rs.)</th>
                <th class="tdc">No. of loan disbursed (#)</th>
                <th class="tdc">Amount disbursed (Rs.)</th>
                <th class="tdc">No. of loan disbursed (#)</th>
                <th class="tdc">Amount disbursed (Rs.)</th>
                <th class="tdc">No. of loan disbursed (#)</th>
                <th class="tdc">Amount disbursed (Rs.)</th>
                <th class="tdc">No. of loan disbursed (#)</th>
                <th class="tdc">Amount disbursed (Rs.)</th>
            </tr>
            <tr>
                <td>Very Poor &amp; vulnerable</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_poorest }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_poorest_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_external_poorest }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_external_poorest_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_bank_external_poorest }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_bank_external_poorest_amount }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_other_external_poorest }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_other_external_poorest_amount }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_vi_poorest }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_vi_poorest_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_poorest + (int) $inclusion[0]->no_of_external_poorest + (int) $inclusion[0]->no_of_vi_poorest + (int) $inclusion[0]->no_of_bank_external_poorest + (int) $inclusion[0]->no_of_other_external_poorest }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_poorest_amount + (int) $inclusion[0]->no_of_vi_poorest_amount + (int) $inclusion[0]->no_of_external_poorest_amount + (int) $inclusion[0]->no_of_bank_external_poorest_amount + (int) $inclusion[0]->no_of_other_external_poorest_amount }}
                </td>
            </tr>
            <tr>
                <td>Poor</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_poor }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_poor_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_external_poor }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_external_poor_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_bank_external_poor }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_bank_external_poor_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_other_external_poor }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_other_external_poor_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_vi_poor }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_vi_poor_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_poor + (int) $inclusion[0]->no_of_external_poor + (int) $inclusion[0]->no_of_vi_poor + (int) $inclusion[0]->no_of_bank_external_poor + (int) $inclusion[0]->no_of_other_external_poor }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_poor_amount + (int) $inclusion[0]->no_of_vi_poor_amount + (int) $inclusion[0]->no_of_external_poor_amount + (int) $inclusion[0]->no_of_bank_external_poor_amount + (int) $inclusion[0]->no_of_other_external_poor_amount }}
                </td>
            </tr>
            <tr>
                <td>Medium poor</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_medium }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_medium_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_external_medium }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_external_medium_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_bank_external_medium }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_bank_external_medium_amount }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_other_external_medium }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_other_external_medium_amount }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_vi_medium }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_vi_medium_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_medium + (int) $inclusion[0]->no_of_external_medium + (int) $inclusion[0]->no_of_vi_medium + (int) $inclusion[0]->no_of_bank_external_medium + (int) $inclusion[0]->no_of_other_external_medium }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_medium_amount + (int) $inclusion[0]->no_of_external_medium_amount + (int) $inclusion[0]->no_of_vi_medium_amount + (int) $inclusion[0]->no_of_bank_external_medium_amount + (int) $inclusion[0]->no_of_other_external_medium_amount }}
                </td>
            </tr>
            <tr>
                <td>Rich</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_rich }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_rich_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_external_rich }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_external_rich_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_bank_external_rich }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_bank_external_rich_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_other_external_rich }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_other_external_rich_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_vi_rich }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_vi_rich_amount }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_rich + (int) $inclusion[0]->no_of_external_rich + (int) $inclusion[0]->no_of_vi_rich + (int) $inclusion[0]->no_of_bank_external_rich + (int) $inclusion[0]->no_of_other_external_rich }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_rich_amount + (int) $inclusion[0]->no_of_external_rich_amount + (int) $inclusion[0]->no_of_vi_rich_amount + (int) $inclusion[0]->no_of_bank_external_rich_amount + (int) $inclusion[0]->no_of_other_external_rich_amount }}
                </td>
            </tr>
            <tr>
                <td>Total</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_poorest + (int) $inclusion[0]->no_of_internal_poor + (int) $inclusion[0]->no_of_internal_medium + (int) $inclusion[0]->no_of_internal_rich }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_poorest_amount + (int) $inclusion[0]->no_of_internal_poor_amount + (int) $inclusion[0]->no_of_internal_medium_amount + (int) $inclusion[0]->no_of_internal_rich_amount }}
                </td>

                <td class="tdc">{{ (int) $inclusion[0]->no_of_external_poorest + (int) $inclusion[0]->no_of_external_poor + (int) $inclusion[0]->no_of_external_medium + (int) $inclusion[0]->no_of_external_rich }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_external_poorest_amount + (int) $inclusion[0]->no_of_external_poor_amount + (int) $inclusion[0]->no_of_external_medium_amount + (int) $inclusion[0]->no_of_external_rich_amount }}
                </td>

                <td class="tdc">{{ (int) $inclusion[0]->no_of_bank_external_poorest + (int) $inclusion[0]->no_of_bank_external_poor + (int) $inclusion[0]->no_of_bank_external_medium + (int) $inclusion[0]->no_of_bank_external_rich }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_bank_external_poorest_amount + (int) $inclusion[0]->no_of_bank_external_poor_amount + (int) $inclusion[0]->no_of_bank_external_medium_amount + (int) $inclusion[0]->no_of_bank_external_rich_amount }}
                </td>

                <td class="tdc">{{ (int) $inclusion[0]->no_of_other_external_poorest + (int) $inclusion[0]->no_of_other_external_poor + (int) $inclusion[0]->no_of_other_external_medium + (int) $inclusion[0]->no_of_other_external_rich }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_other_external_poorest_amount + (int) $inclusion[0]->no_of_other_external_poor_amount + (int) $inclusion[0]->no_of_other_external_medium_amount + (int) $inclusion[0]->no_of_other_external_rich_amount }}
                </td>

                <td class="tdc">{{ (int) $inclusion[0]->no_of_vi_poorest + (int) $inclusion[0]->no_of_vi_poor + (int) $inclusion[0]->no_of_vi_medium + (int) $inclusion[0]->no_of_vi_rich }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_vi_poorest_amount + (int) $inclusion[0]->no_of_vi_poor_amount + (int) $inclusion[0]->no_of_vi_medium_amount + (int) $inclusion[0]->no_of_vi_rich_amount }}
                </td>

                <td class="tdc">{{ checkZero($inclusion[0]->no_of_total_members_benefited) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_total_members_benefited_amount) }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="7">No. Of Households Benefitted From All Loans During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th >Total HHs</th>
                <td class="tdc">{{ $inclusion[0]->no_of_total_members_benefited_hhs }}</td>
                <th ></th>
                <td colspan="4"></td>
            </tr>
            <tr>
                <th>Category</th>
                <th class="tdc">SHG member HHs</th>
                <th class="table_th tdc" >Internal Loans</th>
                <th class="table_th tdc" colspan="3">External Loans</th>
                <th class="table_th tdc" >VI Loans</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th class="tdc">Internal</th>
                <th class="tdc">Fed</th>
                <th class="tdc">Bank</th>
                <th class="tdc">Other</th>
                <th class="tdc">VI</th>
            </tr>
            <tr>
                <td>Very Poor &amp; vulnerable</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_internal_poorest_hhs) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_internal_poorest_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_external_poorest_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_bank_external_poorest_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_other_external_poorest_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_vi_poorest_recloan) }}</td>
               
            </tr>
            <tr>
                <td>Poor</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_internal_poor_hhs) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_internal_poor_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_external_poor_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_bank_external_poor_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_other_external_poor_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_vi_poor_recloan) }}</td>
                
            </tr>
            <tr>
                <td>Medium poor</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_internal_medium_hhs) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_internal_medium_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_external_medium_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_bank_external_medium_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_other_external_medium_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_vi_medium_recloan) }}</td>
               
            </tr>
            <tr>
                <td>Rich</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_internal_rich_hhs) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_internal_rich_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_external_rich_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_bank_external_rich_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_other_external_rich_recloan) }}</td>
                <td class="tdc">{{ checkZero($inclusion[0]->no_of_vi_rich_recloan) }}</td>
               
            </tr>
            <tr>
                <td>Total</td>
                <td class="tdc">{{(int)$inclusion[0]->no_of_internal_poorest_hhs+(int)$inclusion[0]->no_of_internal_poor_hhs+(int)$inclusion[0]->no_of_internal_medium_hhs+(int)$inclusion[0]->no_of_internal_rich_hhs}}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_internal_poorest_recloan + (int) $inclusion[0]->no_of_internal_poor_recloan + (int) $inclusion[0]->no_of_internal_medium_recloan + (int) $inclusion[0]->no_of_internal_rich_recloan }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_external_poorest_recloan + (int) $inclusion[0]->no_of_external_poor_recloan + (int) $inclusion[0]->no_of_external_medium_recloan + (int) $inclusion[0]->no_of_external_rich_recloan }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_bank_external_poorest_recloan + (int) $inclusion[0]->no_of_bank_external_poor_recloan + (int) $inclusion[0]->no_of_bank_external_medium_recloan + (int) $inclusion[0]->no_of_bank_external_rich_recloan }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_other_external_poorest_recloan + (int) $inclusion[0]->no_of_other_external_poor_recloan + (int) $inclusion[0]->no_of_other_external_medium_recloan + (int) $inclusion[0]->no_of_other_external_rich_recloan }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_vi_poorest_recloan + (int) $inclusion[0]->no_of_vi_poor_recloan + (int) $inclusion[0]->no_of_vi_medium_recloan + (int) $inclusion[0]->no_of_vi_rich_recloan }}
                </td>
                
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">No Of Poor And Most Poor In Leadership Position</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">No of Leadership Poor</th>
                <td width="25%">{{ checkZero($inclusion[0]->no_of_leadership_poor) }}</td>
                <th width="25%"></th>
                <td width="25%"></td>

            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Special Products For The Poor/Vulnerable
                    </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Special products for the poor/vulnerable</th>
                <td width="25%" >{{ checkZero($inclusion[0]->is_service_for_poor) }}</td>
                <th width="25%">Name of product</th>
                <td width="25%" >{{ $inclusion[0]->service_for_poor !='' ? $inclusion[0]->service_for_poor : 'N/A' }}</td>
                
            </tr>
            <tr>
                <th width="25%">No of members benefited from it during last 12 months</th>
                <td width="25%" >{{ $inclusion[0]->no_of_member_benefited_service !='' ? $inclusion[0]->no_of_member_benefited_service : 0 }}</td>
                
                <th width="25%">Any impact/result</th>
                <td width="25%" >{{ $inclusion[0]->result_of_service !='' ? $inclusion[0]->result_of_service : 'N/A' }}</td>
            </tr>

        </tbody>
    </table>
    <br>
    <!-- Efficiency -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >EFFICIENCY</td>
            </tr>
        </thead>
    </table>
   <br>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Integrated Member Plan</td>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <th width="25%">Integrated Member Plan</th>
                <td width="25%" >{{ checkna($efficiency[0]->integrated_family) }}</td>
                <th width="25%">Date of last report</th>
                <td width="25%">{{ $efficiency[0]->integrated_family_date !='' ? change_date_month_name_char(str_replace('/','-',$efficiency[0]->integrated_family_date)) :'N/A' }}</td>
            </tr>
            


        </tbody>
    </table>
    <br>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Income And Expenses During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Income from all sources</th>
                <td width="25%">{{ checkna($efficiency[0]->total_income) }}</td>
                <th width="25%"><b>Expenses</th>
                <td width="25%">{{ checkna($efficiency[0]->expense) }}</td>
            </tr>
            <tr>
                <th width="25%">Is it covering its operational costs</th>
                <td width="25%">{{ checkna($efficiency[0]->covering_operational_cost) }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Training Received During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th class="tdc">Name of Training</th>
                <th class="tdc">Date of Training</th>
                <th class="tdc">Duration of Training</th>
                <th class="tdc">Bookkeeper Trained</th>

            </tr>
            <tr>
                <td class="tdc">{{ $efficiency[0]->name_training !='' ? $efficiency[0]->name_training : 'N/A' }}</td>
                <td class="tdc">{{ $efficiency[0]->date_training !='' ? change_date_month_name_char(str_replace('/','-',$efficiency[0]->date_training)) : 'N/A' }}</td>
                <td class="tdc">{{ $efficiency[0]->duration_training !='' ? $efficiency[0]->duration_training : 'N/A' }}</td>
                <td class="tdc">{{ $efficiency[0]->bookkeeper_trained !='' ? $efficiency[0]->bookkeeper_trained : 'N/A' }}</td>

            </tr>



        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="6">Training Details</td>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th width="50px" class="tdc">S.No</th>
                <th class="tdc">Name of training</th>
                <th class="tdc">Duration</th>
                <th class="tdc">Date</th>
                <th class="tdc">Name of Training Recipient</th>
                <th class="tdc">Name of Trainer</th>
            </tr>

            @php $i=1; @endphp
            @if (!empty($efficiency_details))
            @foreach ($efficiency_details as $row)
            <tr>
                <td class="tdc">{{ $i++ }}</td>
                <td class="tdc">{{ $row->training_name }}</td>
                <td class="tdc">{{ $row->duration }}</td>
                <td class="tdc">{{  change_date_month_name_char(str_replace('/','-',$row->date_training)) }}</td>
                <td>
                    @php
                    $desg = [];
                    if ($row->secretary == 1) {
                    $desg[] = 'Secretary';
                    }
                    if ($row->president == 1){
                    $desg[] = 'President';
                    }
                    if ($row->treasurer == 1) {
                    $desg[] = 'Treasurer';
                    }
                    if ($row->other == 1) {
                    $desg[] = 'Other';
                    }
                    $strdesg = implode(',', $desg);
                    @endphp
                    {{ $strdesg }}
                </td>
                <td class="tdc">{{ $row->who_received }}</td>
            </tr>
            @endforeach
            @endif

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">No Of Days Taken To Approve Loan</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="50%">Days taken to approve loan</th>
                <td width="50%">{{ checkZero($efficiency[0]->no_of_days_approve_loan) }}</td>
                
                
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">No Of Days From Approval To Cash In Hand</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="50%">No of days from approval to cash in hand</th>
                <td width="50%">{{ checkna($efficiency[0]->no_of_days_cash_in_hand) }}</td>
            </tr>
        </tbody>
    </table>
    <br>
   
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Monthly Reports </td>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <th width="25%">Monthly reports</th>
                <td width="25%">{{ checkna($efficiency[0]->prepare_monthly_progress) }}</td>
                <th width="25%">Date of last report submitted</th>
                <th width="25%" >{{ $efficiency[0]->shg_last_submission_date !='' ? change_date_month_name_char(str_replace('/','-',$efficiency[0]->shg_last_submission_date)):'N/A'}}</th>
            </tr>
           
        </tbody>
    </table>
    <br>
    <br>
    <!--Credit History -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >CREDIT HISTORY</td>
            </tr>
        </thead>
    </table>
   <br>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Interest rate type </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Interest rate type</th>
                <td width="25%">{{ checkZero($creditrecovery[0]->interest_charged) }}</td>
                <th width="25%">% interest rate charged</th>
                <td width="25%">{{ checkZero($creditrecovery[0]->percent_charged) }}</td>
            </tr>
            
        </tbody>
    </table>
    <div class="page-break"></div>
   
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="13"> Cumulative No of Loans and Amounts disbursed During last 3 years</td>
            </tr>
            <tr>
                <th class="table_th" ></th>
                <th class="table_th tdc" colspan="2">Internal Loans </th>
                <th class="table_th tdc" colspan="6">External Loans </th>
                <th class="table_th tdc" colspan="2">VI Loans </th>
                <th class="table_th tdc" colspan="2"></th>
            </tr>
            <tr>
                <th>Category</th>
                <th class="table_th tdc" colspan="2">Internal </th>
                <th class="table_th tdc" colspan="2">Federation </th>
                <th class="table_th tdc" colspan="2">Bank </th>
                <th class="table_th tdc" colspan="2">Other </th>
                <th class="table_th tdc" colspan="2">VI  </th>
                <th class="table_th tdc" colspan="2">Total  </th>
            </tr>
        </thead>
        <tbody>
                                                <tr class="tdc">
                                                    <th></th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                </tr>
                                                <tr class="tdc">
                                                    <td>Very Poor &amp; vulnerable</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poorest }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poorest_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poorest }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poorest_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poorest }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poorest_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poorest }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poorest_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest + (int) $creditrecovery[0]->no_of_external_poorest + (int) $creditrecovery[0]->no_of_vi_poorest + (int) $creditrecovery[0]->no_of_bank_external_poorest + (int) $creditrecovery[0]->no_of_other_external_poorest }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_amount + (int) $creditrecovery[0]->no_of_external_poorest_amount + (int) $creditrecovery[0]->no_of_vi_poorest_amount + (int) $creditrecovery[0]->no_of_bank_external_poorest_amount + (int) $creditrecovery[0]->no_of_other_external_poorest_amount }}
                                                    </td>
                                                </tr>
                                                <tr class="tdc">
                                                    <td>Poor</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poor }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poor_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poor }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poor_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poor }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poor_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poor }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poor_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poor }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poor_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poor + (int) $creditrecovery[0]->no_of_external_poor + (int) $creditrecovery[0]->no_of_vi_poor + (int) $creditrecovery[0]->no_of_bank_external_poor + (int) $creditrecovery[0]->no_of_other_external_poor }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poor_amount + (int) $creditrecovery[0]->no_of_external_poor_amount + (int) $creditrecovery[0]->no_of_vi_poor_amount + (int) $creditrecovery[0]->no_of_bank_external_poor_amount + (int) $creditrecovery[0]->no_of_other_external_poor_amount }}
                                                    </td>
                                                </tr>
                                                <tr class="tdc">
                                                    <td>Medium poor</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_medium }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_medium_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_medium }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_medium_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_medium }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_medium_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_medium }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_medium_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_medium }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_medium_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_medium + (int) $creditrecovery[0]->no_of_external_medium + (int) $creditrecovery[0]->no_of_vi_medium + (int) $creditrecovery[0]->no_of_other_external_medium + (int) $creditrecovery[0]->no_of_bank_external_medium }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_medium_amount + (int) $creditrecovery[0]->no_of_external_medium_amount + (int) $creditrecovery[0]->no_of_vi_medium_amount + (int) $creditrecovery[0]->no_of_other_external_medium_amount + (int) $creditrecovery[0]->no_of_bank_external_medium_amount }}
                                                    </td>
                                                </tr>

                                                <tr class="tdc">
                                                    <td>Rich</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_rich }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_rich_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_rich }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_rich_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_rich }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_rich_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_rich }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_rich_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_rich }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_rich_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_rich + (int) $creditrecovery[0]->no_of_external_rich + (int) $creditrecovery[0]->no_of_vi_rich + (int) $creditrecovery[0]->no_of_other_external_rich + (int) $creditrecovery[0]->no_of_bank_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_rich_amount + (int) $creditrecovery[0]->no_of_external_rich_amount + (int) $creditrecovery[0]->no_of_vi_rich_amount + (int) $creditrecovery[0]->no_of_other_external_rich_amount + (int) $creditrecovery[0]->no_of_bank_external_rich_amount }}
                                                    </td>
                                                </tr>
                                                <tr class="tdc">
                                                    <td>Total</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest + (int) $creditrecovery[0]->no_of_internal_poor + (int) $creditrecovery[0]->no_of_internal_medium + (int) $creditrecovery[0]->no_of_internal_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_amount + (int) $creditrecovery[0]->no_of_internal_poor_amount + (int) $creditrecovery[0]->no_of_internal_medium_amount + (int) $creditrecovery[0]->no_of_internal_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poorest + (int) $creditrecovery[0]->no_of_external_poor + (int) $creditrecovery[0]->no_of_external_medium + (int) $creditrecovery[0]->no_of_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poorest_amount + (int) $creditrecovery[0]->no_of_external_poor_amount + (int) $creditrecovery[0]->no_of_external_medium_amount + (int) $creditrecovery[0]->no_of_external_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poorest + (int) $creditrecovery[0]->no_of_bank_external_poor + (int) $creditrecovery[0]->no_of_bank_external_medium + (int) $creditrecovery[0]->no_of_bank_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poorest_amount + (int) $creditrecovery[0]->no_of_bank_external_poor_amount + (int) $creditrecovery[0]->no_of_bank_external_medium_amount + (int) $creditrecovery[0]->no_of_bank_external_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poorest + (int) $creditrecovery[0]->no_of_other_external_poor + (int) $creditrecovery[0]->no_of_other_external_medium + (int) $creditrecovery[0]->no_of_other_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poorest_amount + (int) $creditrecovery[0]->no_of_other_external_poor_amount + (int) $creditrecovery[0]->no_of_other_external_medium_amount + (int) $creditrecovery[0]->no_of_other_external_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poorest + (int) $creditrecovery[0]->no_of_vi_poor + (int) $creditrecovery[0]->no_of_vi_medium + (int) $creditrecovery[0]->no_of_vi_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poorest_amount + (int) $creditrecovery[0]->no_of_vi_poor_amount + (int) $creditrecovery[0]->no_of_vi_medium_amount + (int) $creditrecovery[0]->no_of_vi_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest +
                                                            (int) $creditrecovery[0]->no_of_external_poorest +
                                                            (int) $creditrecovery[0]->no_of_vi_poorest +
                                                            (int) $creditrecovery[0]->no_of_bank_external_poorest +
                                                            (int) $creditrecovery[0]->no_of_other_external_poorest +
                                                            (int) $creditrecovery[0]->no_of_internal_poor +
                                                            (int) $creditrecovery[0]->no_of_external_poor +
                                                            (int) $creditrecovery[0]->no_of_vi_poor +
                                                            (int) $creditrecovery[0]->no_of_bank_external_poor +
                                                            (int) $creditrecovery[0]->no_of_other_external_poor +
                                                            (int) $creditrecovery[0]->no_of_internal_medium +
                                                            (int) $creditrecovery[0]->no_of_external_medium +
                                                            (int) $creditrecovery[0]->no_of_vi_medium +
                                                            (int) $creditrecovery[0]->no_of_other_external_medium +
                                                            (int) $creditrecovery[0]->no_of_bank_external_medium +
                                                            (int) $creditrecovery[0]->no_of_internal_rich +
                                                            (int) $creditrecovery[0]->no_of_external_rich +
                                                            (int) $creditrecovery[0]->no_of_vi_rich +
                                                            (int) $creditrecovery[0]->no_of_other_external_rich +
                                                            (int) $creditrecovery[0]->no_of_bank_external_rich }}
                                                    </td>
                                                    <td>
                    {{ (int) $creditrecovery[0]->no_of_internal_poorest_amount +
                    (int) $creditrecovery[0]->no_of_external_poorest_amount +
                    (int) $creditrecovery[0]->no_of_vi_poorest_amount +
                    (int) $creditrecovery[0]->no_of_bank_external_poorest_amount +
                    (int) $creditrecovery[0]->no_of_other_external_poorest_amount +
                    (int) $creditrecovery[0]->no_of_internal_poor_amount +
                    (int) $creditrecovery[0]->no_of_external_poor_amount +
                    (int) $creditrecovery[0]->no_of_vi_poor_amount +
                    (int) $creditrecovery[0]->no_of_bank_external_poor_amount +
                    (int) $creditrecovery[0]->no_of_other_external_poor_amount +
                    (int) $creditrecovery[0]->no_of_internal_medium_amount +
                    (int) $creditrecovery[0]->no_of_external_medium_amount +
                    (int) $creditrecovery[0]->no_of_vi_medium_amount +
                    (int) $creditrecovery[0]->no_of_other_external_medium_amount +
                    (int) $creditrecovery[0]->no_of_bank_external_medium_amount+
                    (int) $creditrecovery[0]->no_of_internal_rich_amount +
                    (int) $creditrecovery[0]->no_of_external_rich_amount +
                    (int) $creditrecovery[0]->no_of_vi_rich_amount +
                    (int) $creditrecovery[0]->no_of_other_external_rich_amount +
                    (int) $creditrecovery[0]->no_of_bank_external_rich_amount }}
                </td>
                                                </tr>
                                            </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">Cumulative Interest Income Through</td>
            </tr>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th width="48%">Type of loan</th>
                <th width="48%">Income Generated Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tdc">1</td>
                <td>Internal</td>
                <td >{{ checkZero($creditrecovery[0]->cumulative_internal_interest) }}</td>
            </tr>
            <tr>
                <td class="tdc">2</td>
                <td>Federation</td>
                <td >{{ checkZero($creditrecovery[0]->cumulative_federation_interest) }}</td>
            </tr>
            <tr>
                <td class="tdc">3</td>
                <td>Bank</td>
                <td >{{ checkZero($creditrecovery[0]->cumulative_vi_interest) }}</td>
            </tr>
            <tr>
                <td class="tdc">4</td>
                <td>VI</td>
                <td>0</td>
            </tr>
            <tr>
                <td class="tdc">5</td>
                <td>Other</td>
                <td >{{ checkZero($creditrecovery[0]->cumulative_other_interest) }}</td>
            </tr>
            <tr>
                <td class="tdc">6</td>
                <td>Total</td>
                <td >{{ checkZero($creditrecovery[0]->total_cumulative_interest) }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="7">Total No Of Member HHs Benefitted From All Loans During Last 3 Years</td>
            </tr>
            <tr>
                <th>Category</th>
                <th class="tdc">SHG member HHs</th>
                <th class="table_th tdc" colspan="5">Received Loans</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th></th>
                <th></th>
                <th class="tdc">Internal</th>
                <th class="tdc">Fed</th>
                <th class="tdc">Bank</th>
                <th class="tdc">Other</th>
                <th class="tdc">VI</th>
                
            </tr>
            <tr>
                <td>Very Poor &amp; vulnerable</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_internal_poorest_hhs !='' ? $creditrecovery[0]->no_of_internal_poorest_hhs : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_internal_poorest_recloan !='' ? $creditrecovery[0]->no_of_internal_poorest_recloan :0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_external_poorest_recloan !='' ? $creditrecovery[0]->no_of_external_poorest_recloan : 0}}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_bank_external_poorest_recloan !='' ? $creditrecovery[0]->no_of_bank_external_poorest_recloan : 0 }}
                </td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_other_external_poorest_recloan !='' ? $creditrecovery[0]->no_of_other_external_poorest_recloan : 0 }}
                </td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_vi_poorest_recloan !='' ? $creditrecovery[0]->no_of_vi_poorest_recloan : 0 }}</td>
            </tr>
            <tr>
                <td>Poor</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_internal_poor_hhs !='' ? $creditrecovery[0]->no_of_internal_poor_hhs : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_internal_poor_recloan !='' ? $creditrecovery[0]->no_of_internal_poor_recloan : 0}}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_external_poor_recloan !='' ? $creditrecovery[0]->no_of_external_poor_recloan : 0}}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_bank_external_poor_recloan !='' ? $creditrecovery[0]->no_of_bank_external_poor_recloan : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_other_external_poor_recloan !='' ? $creditrecovery[0]->no_of_other_external_poor_recloan : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_vi_poor_recloan !='' ? $creditrecovery[0]->no_of_vi_poor_recloan : 0}}</td>
            </tr>
            <tr>
                <td>Medium poor</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_internal_medium_hhs !='' ? $creditrecovery[0]->no_of_internal_medium_hhs : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_internal_medium_recloan !='' ? $creditrecovery[0]->no_of_internal_medium_recloan : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_external_medium_recloan !='' ? $creditrecovery[0]->no_of_external_medium_recloan : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_bank_external_medium_recloan !='' ? $creditrecovery[0]->no_of_bank_external_medium_recloan : 0 }}
                </td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_other_external_medium_recloan !='' ? $creditrecovery[0]->no_of_other_external_medium_recloan : 0 }}
                </td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_vi_medium_recloan !='' ? $creditrecovery[0]->no_of_vi_medium_recloan : 0 }}</td>
            </tr>
            <tr>
                <td>Rich</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_internal_rich_hhs !='' ? $creditrecovery[0]->no_of_internal_rich_hhs : 0}}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_internal_rich_recloan !='' ? $creditrecovery[0]->no_of_internal_rich_recloan : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_external_rich_recloan !='' ? $creditrecovery[0]->no_of_external_rich_recloan : 0}}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_bank_external_rich_recloan !='' ? $creditrecovery[0]->no_of_bank_external_rich_recloan : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_other_external_rich_recloan !='' ? $creditrecovery[0]->no_of_other_external_rich_recloan : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->no_of_vi_rich_recloan !='' ? $creditrecovery[0]->no_of_vi_rich_recloan : 0}}</td>
            </tr>
            <tr>
                <td>Total</td>

                <td class="tdc">{{ (int) $creditrecovery[0]->no_of_internal_poorest_hhs + (int) $creditrecovery[0]->no_of_internal_poor_hhs + (int) $creditrecovery[0]->no_of_internal_medium_hhs + (int) $creditrecovery[0]->no_of_internal_rich_hhs }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->no_of_internal_poorest_recloan + (int) $creditrecovery[0]->no_of_internal_poor_recloan + (int) $creditrecovery[0]->no_of_internal_medium_recloan + (int) $creditrecovery[0]->no_of_internal_rich_recloan }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->no_of_external_poorest_recloan + (int) $creditrecovery[0]->no_of_external_poor_recloan + (int) $creditrecovery[0]->no_of_external_medium_recloan + (int) $creditrecovery[0]->no_of_external_rich_recloan }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->no_of_bank_external_poorest_recloan + (int) $creditrecovery[0]->no_of_bank_external_poor_recloan + (int) $creditrecovery[0]->no_of_bank_external_medium_recloan + (int) $creditrecovery[0]->no_of_bank_external_rich_recloan }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->no_of_other_external_poorest_recloan + (int) $creditrecovery[0]->no_of_other_external_poor_recloan + (int) $creditrecovery[0]->no_of_other_external_medium_recloan + (int) $creditrecovery[0]->no_of_other_external_rich_recloan }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->no_of_vi_poorest_recloan + (int) $creditrecovery[0]->no_of_vi_poor_recloan + (int) $creditrecovery[0]->no_of_vi_medium_recloan + (int) $creditrecovery[0]->no_of_vi_rich_recloan }}
                </td>
                
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="9">Demand Collection Balance (DCB) For Repayment And Current Loan Outstanding</td>
            </tr>
            <tr>
                <th colspan="2" class="tdc">Total Loan Portfolio</th>
                <td colspan="2" class="tdc">{{ $creditrecovery[0]->total_loan_amount }}</td>
                <th colspan="2" class="tdc"></th>
                <td colspan="3" class="tdc"></td>
            </tr>
            <tr>
                <th class="tdc" width="4%">S.No</th>
                <th class="tdc" width="12%">DCB</th>
                <th class="tdc" width="12%">Internal Loans </th>
                <th class="tdc" width="12%">Cluster Loan </th>
                <th class="tdc" width="12%">FederationLoan </th>
                <th class="tdc" width="12%">Bank Loan </th>
                <th class="tdc" width="12%">VI Loan </th>
                <th class="tdc" width="12%">Other Loan </th>
                <th class="tdc" width="12%">Total Loan Portfolio </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tdc">1</td>
                <td>Total Loan Amount Given (Rs.)</td>
                <td class="tdc">{{ $creditrecovery[0]->internal_loan_amount !='' ? $creditrecovery[0]->internal_loan_amount  : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->cluster_loan_amount !='' ? $creditrecovery[0]->cluster_loan_amount : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->federation_loan_amount !='' ? $creditrecovery[0]->federation_loan_amount : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->bank_loan_amount !='' ? $creditrecovery[0]->bank_loan_amount : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->vi_loan_amount !='' ? $creditrecovery[0]->vi_loan_amount : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->other_loan_amount !='' ? $creditrecovery[0]->other_loan_amount : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->total_loan_amount !='' ? $creditrecovery[0]->total_loan_amount : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">2</td>
                <td>Total Demand upto last month for active loans</td>
                <td class="tdc">{{ $creditrecovery[0]->dcb_internal !='' ? $creditrecovery[0]->dcb_internal : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->dcb_cluster !='' ? $creditrecovery[0]->dcb_cluster : 0}}</td>
                <td class="tdc">{{ $creditrecovery[0]->dcb_federation !='' ? $creditrecovery[0]->dcb_federation : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->dcb_bank !='' ? $creditrecovery[0]->dcb_bank: 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->dcb_vi !='' ? $creditrecovery[0]->dcb_vi : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->dcb_other !='' ? $creditrecovery[0]->dcb_other: 0  }}</td>
                <td class="tdc">{{ $creditrecovery[0]->total_demand !='' ? $creditrecovery[0]->total_demand : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">3</td>
                <td>Actual Amount Paid upto last month</td>
                <td class="tdc">{{ $creditrecovery[0]->repaid_internal !='' ? $creditrecovery[0]->repaid_internal : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->repaid_cluster !='' ? $creditrecovery[0]->repaid_cluster : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->repaid_federation !='' ? $creditrecovery[0]->repaid_federation : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->repaid_bank !='' ? $creditrecovery[0]->repaid_bank : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->repaid_vi !='' ? $creditrecovery[0]->repaid_vi : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->repaid_other !='' ? $creditrecovery[0]->repaid_other : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->total_actual_repaid_amount !='' ? $creditrecovery[0]->total_actual_repaid_amount : 0}}</td>
            </tr>
            <tr>
                <td class="tdc">4</td>
                <td>Overdue Amount</td>
                <td class="tdc">{{ $creditrecovery[0]->overdue_internal !='' ? $creditrecovery[0]->overdue_internal : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->overdue_cluster !='' ? $creditrecovery[0]->overdue_cluster : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->overdue_federation !='' ? $creditrecovery[0]->overdue_federation : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->overdue_bank !='' ? $creditrecovery[0]->overdue_bank : 0  }}</td>
                <td class="tdc">{{ $creditrecovery[0]->overdue_vi !='' ? $creditrecovery[0]->overdue_vi : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->overdue_other !='' ? $creditrecovery[0]->overdue_other : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->total_overdue !='' ? $creditrecovery[0]->total_overdue : 0  }}</td>
            </tr>
            <tr>
                <td class="tdc">5</td>
                <td>Outstanding amount for active loans</td>
                <td class="tdc">{{ $creditrecovery[0]->current_outstanding_internal !='' ? $creditrecovery[0]->current_outstanding_internal : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->current_outstanding_cluster !='' ? $creditrecovery[0]->current_outstanding_cluster : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->current_outstanding_federation !='' ? $creditrecovery[0]->current_outstanding_federation : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->current_outstanding_bank !='' ? $creditrecovery[0]->current_outstanding_bank : 0  }}</td>
                <td class="tdc">{{ $creditrecovery[0]->current_outstanding_vi !='' ? $creditrecovery[0]->current_outstanding_vi : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->current_outstanding_other !='' ?$creditrecovery[0]->current_outstanding_other :0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->total_outstanding_amount !='' ? $creditrecovery[0]->total_outstanding_amount : 0 }}</td>
            </tr>
            <tr class="tdc">
                <td>6</td>
                <td>Repayment Ratio %</td>
                <td>{{ Checkper($creditrecovery[0]->repayment_internal)."%" }}</td>
                <td>{{ Checkper($creditrecovery[0]->repayment_cluster)."%"}}
                </td>
                <td>{{ Checkper($creditrecovery[0]->repayment_federation)."%"}}
                </td>
                <td>{{ Checkper($creditrecovery[0]->repayment_bank)."%"}}
                </td>
                <td>{{ Checkper($creditrecovery[0]->repayment_vi)."%" }}
                </td>
                <td>{{ Checkper($creditrecovery[0]->repayment_other)."%"}}
                </td>
                <td>{{ Checkper($creditrecovery[0]->total_repayment_ratio)."%" }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Loan Default</td>
            </tr>

        </thead>
        <tbody>
            <tr>
                <th width="50px" class="tdc">S.No</th>
                <th>Name of Loan Insitution</th>
                <th class="tdc">No of Members</th>
                <th class="tdc">No of Loans</th>
            </tr>
            <tr>
                <td class="tdc">A</td>
                <td>Internal loans</td>
                <td class="tdc">{{ $creditrecovery[0]->default_internal_member !='' ? $creditrecovery[0]->default_internal_member : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->default_internal_loan !='' ? $creditrecovery[0]->default_internal_loan : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>Cluster/Habitation</td>
                <td class="tdc">{{ $creditrecovery[0]->default_cluster_member !='' ? $creditrecovery[0]->default_cluster_member : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->default_cluster_loan !='' ? $creditrecovery[0]->default_cluster_loan : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>Federation Loan</td>
                <td class="tdc">{{ $creditrecovery[0]->default_federation_member !='' ? $creditrecovery[0]->default_federation_member :0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->default_federation_loan !='' ? $creditrecovery[0]->default_federation_loan : 0}}</td>
            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>Bank Loan</td>
                <td class="tdc">{{ $creditrecovery[0]->default_bank_member !='' ?  $creditrecovery[0]->default_bank_member : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->default_bank_loan !='' ? $creditrecovery[0]->default_bank_loan : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">E</td>
                <td>VI Loan</td>
                <td class="tdc">{{ $creditrecovery[0]->default_vi_member !='' ? $creditrecovery[0]->default_vi_member : 0 }}</td>
                <td class="tdc">{{ $creditrecovery[0]->default_vi_loan !='' ? $creditrecovery[0]->default_vi_loan : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">F</td>
                <td>Other Loan</td>
                <td class="tdc">{{ $creditrecovery[0]->default_other_member !='' ? $creditrecovery[0]->default_other_member : 0  }}</td>
                <td class="tdc">{{ $creditrecovery[0]->default_other_loan !='' ? $creditrecovery[0]->default_other_loan : 0 }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Total</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->default_internal_member + (int) $creditrecovery[0]->default_cluster_member + (int) $creditrecovery[0]->default_bank_member + (int) $creditrecovery[0]->default_vi_member + (int) $creditrecovery[0]->default_other_member + (int) $creditrecovery[0]->default_federation_member }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->default_internal_loan + (int) $creditrecovery[0]->default_cluster_loan + (int) $creditrecovery[0]->default_federation_loan + (int) $creditrecovery[0]->default_bank_loan + (int) $creditrecovery[0]->default_vi_loan + (int) $creditrecovery[0]->default_other_loan }}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="page-break"></div>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">PAR Status- 3 Months Overdue</td>
            </tr>

        </thead>
        <tbody>
            <tr>
                <th class="tdc" width="4%">S.No</th>
                <th width="47%">Loan type</th>
                <th width="47%">Amount</th>
            </tr>
            <tr>
                <td class="tdc">A</td>
                <td>Internal</td>
                <td >{{ checkZero($creditrecovery[0]->creditHistory_PAR_status_Internal) }}</td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>External</td>
                <td >{{ checkZero($creditrecovery[0]->creditHistory_PAR_status_External) }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="6">Purpose Of External Loans During Last 12 Months</td>
            </tr>

        </thead>
        <tbody>
            <tr>
                <th class="tdc" width="4%">S.No</th>
                <th>Purpose</th>
                <th class="tdc">Bank</th>
                <th class="tdc">Federation</th>
                <th class="tdc">VI</th>
                <th class="tdc">Total</th>
            </tr>

            <tr>
                <td class="tdc">A</td>
                <td>Productive</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_productive }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_productive_federation }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_productive_vi }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_productive + (int) $creditrecovery[0]->purposes_productive_federation + (int) $creditrecovery[0]->purposes_productive_vi }}
                </td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>Consumption</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_consumption }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_consumption_federation }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_consumption_vi }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_consumption + (int) $creditrecovery[0]->purposes_consumption_federation + (int) $creditrecovery[0]->purposes_consumption_vi }}
                </td>

            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>Debt Swapping</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_debt_swapping }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_debt_swapping_federation }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_debt_swapping_vi }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_debt_swapping + (int) $creditrecovery[0]->purposes_debt_swapping_federation + (int) $creditrecovery[0]->purposes_debt_swapping_vi }}
                </td>
            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>Other</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_other }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_other_federation }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_other_vi }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_other + (int) $creditrecovery[0]->purposes_other_federation + (int) $creditrecovery[0]->purposes_other_vi }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>Total</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_productive + (int) $creditrecovery[0]->purposes_consumption + (int) $creditrecovery[0]->purposes_debt_swapping + (int) $creditrecovery[0]->purposes_other }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_productive_federation + (int) $creditrecovery[0]->purposes_consumption_federation + (int) $creditrecovery[0]->purposes_debt_swapping_federation + (int) $creditrecovery[0]->purposes_other_federation }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_productive_vi + (int) $creditrecovery[0]->purposes_consumption_vi + (int) $creditrecovery[0]->purposes_debt_swapping_vi + (int) $creditrecovery[0]->purposes_other_vi }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->purposes_productive + (int) $creditrecovery[0]->purposes_productive_federation + (int) $creditrecovery[0]->purposes_productive_vi + (int) $creditrecovery[0]->purposes_consumption + (int) $creditrecovery[0]->purposes_consumption_federation + (int) $creditrecovery[0]->purposes_consumption_vi + (int) $creditrecovery[0]->purposes_debt_swapping + (int) $creditrecovery[0]->purposes_debt_swapping_federation + (int) $creditrecovery[0]->purposes_debt_swapping_vi + (int) $creditrecovery[0]->purposes_other + (int) $creditrecovery[0]->purposes_other_federation + (int) $creditrecovery[0]->purposes_other_vi }}
                </td>
            </tr>
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Average Loan Amount During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
            <th width="25%">Loan Amount</th>
            <td width="25%">{{ checkZero($creditrecovery[0]->average_loan_amount) }}</td>
            <th width="25%"></th>
            <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Loan Amount During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
            <th width="25%">Maximum Amount</th>
            <td width="25%">{{ checkZero($creditrecovery[0]->maximum_amount) }}</td>
            <th width="25%">Minimum Amount</th>
            <td width="25%">{{ checkZero($creditrecovery[0]->minimum_amount) }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">No Of Members Taken More Than 1 Loan During Last 3 Years</td>
            </tr>
        </thead>
        <tbody>
            <tr>
            <th width="25%">Members taken more than 1 loan</th>
            <td width="25%">{{ checkZero($creditrecovery[0]->no_of_member_loan_more) }}</td>
            <th width="25%"></th>
            <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <!-- Saving -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >SAVING</td>
            </tr>
        </thead>
    </table>
   <br>
   
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Savings Details</td>
            </tr>
        </thead>
        
            <thead class="back-color">
                <tr>
                    <th class="tdc" width="4%">S.No</th>
                    <th width="32%">Savings Details</th>
                    <th width="32%">Compulsory</th>
                    <th width="32%">Voluntary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tdc">A</td>
                    <td>Date Savings started</td>
                    <td >{{$saving[0]->date_savings_started !='' ? change_date_month_name_char(str_replace('/','-',$saving[0]->date_savings_started)) :'N/A'}} 
                    </td>
                    <td >{{$saving[0]->shg_voluntary_saving_started_date !='' ? change_date_month_name_char(str_replace('/','-',$saving[0]->shg_voluntary_saving_started_date)):'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td class="tdc">B</td>
                    <td>Amount of Savings per month</td>
                    <td >{{ $saving[0]->compulsory_saving_amount != '' ? $saving[0]->compulsory_saving_amount : 0 }}
                    </td>
                    <td >{{ $saving[0]->shg_voluntary_saving_amount_per_month != '' ? $saving[0]->shg_voluntary_saving_amount_per_month : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="tdc">C</td>
                    <td>No of Members saved during last 12 months</td>
                    <td >{{ $saving[0]->regular_saving_member != '' ? $saving[0]->regular_saving_member : 0 }}
                    </td>
                    <td >{{ $saving[0]->member_voluntary_saving != '' ? $saving[0]->member_voluntary_saving : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="tdc">D</td>
                    <td>Cumulative savings to-date since inception</td>
                    <td >{{ $saving[0]->cumulative_compulsory_saving != '' ? $saving[0]->cumulative_compulsory_saving : 0 }}
                    </td>
                    <td >{{ $saving[0]->cumulative_voluntary_saving != '' ? $saving[0]->cumulative_voluntary_saving : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="tdc">E</td>
                    <td>Average Amount saved during last 12 months</td>
                    <td >{{ $saving[0]->shg_compulsory_average_amount_saving_1E != '' ? $saving[0]->shg_compulsory_average_amount_saving_1E : 0 }}
                    </td>
                    <td >{{ $saving[0]->shg_voluntary_saving_since_inception != '' ? $saving[0]->shg_voluntary_saving_since_inception : 0 }}
                    </td>
                </tr>

            </tbody>
        
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Interest Paid To Members </td>
            </tr>
        </thead>
        <tbody>
           
            <tr>
                <th width="25%">Interest paid to members</th>
                <td width="25%" >{{ $saving[0]->interest_paid !='' ? $saving[0]->interest_paid : 'N/A' }}</td>
                <th width="25%">Savings rate</th>
                <td width="25%" >{{ $saving[0]->saving_rate !='' ? round($saving[0]->saving_rate) : 'N/A' }}</td>
            </tr>
        </tbody>
        

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Are Savings Distributed To Members </td>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <th width="25%">Savings distributed to members</th>
                <td width="25%" >{{  $saving[0]->saving_redistributed !='' ? $saving[0]->saving_redistributed : 'N/A'  }}</td>
                <th width="25%">Date of last distribution</th>
                <td width="25%" >{{ $saving[0]->last_distribution_date !='' ? change_date_month_name_char(str_replace('/','-',$saving[0]->last_distribution_date)) : 'N/A' }}</td>
            </tr>
        </tbody>
        

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Loan Security Fund (LSF)</td>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th width="25%">LSF Participate</th>
                <td width="25%" >{{ $saving[0]->LSF_participate !='' ? $saving[0]->LSF_participate : 'N/A' }}</td>
                <th width="25%">No of Members benefitted by LSF</th>
                <td width="25%" >{{ $saving[0]->members_benefited_LSF !='' ? $saving[0]->members_benefited_LSF : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">No of Members contribute by LSF</th>
                <td width="25%" class="tc">{{ $saving[0]->members_contribute_LSF !='' ? $saving[0]->members_contribute_LSF : 'N/A' }}</td>
                <th width="25%">Reason members do not contribute</th>
                <td width="25%" >{{ $saving[0]->no_LSF_reasons !='' ? $saving[0]->no_LSF_reasons : 'N/A' }}</td>
            </tr>
        </tbody>


    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">Savings Increasing Trend</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="40%">Trend</th>
                <th width="30%">Compulsory</th>
                <th width="30%">Voluntary</th>
            </tr>

            <tr>
                <td>Per member average savings during previous year (before 12 months)
                </td>
                <td >{{ $saving[0]->savingsMobilization_Last_year_per_member !='' ? $saving[0]->savingsMobilization_Last_year_per_member : 'N/A' }}</td>
                <td >{{ $saving[0]->savingsMobilization_Previous_year_per_member !='' ? $saving[0]->savingsMobilization_Previous_year_per_member : 'N/A' }}
                </td>
            </tr>
            <tr>
                <td>Per member average savings during last 12 months</td>
                <td >{{ $saving[0]->savingsMobilization_Current_year_per_member !='' ? $saving[0]->savingsMobilization_Current_year_per_member : 'N/A' }}
                </td>
                <td >{{ $saving[0]->savingsMobilization_voluntary_saving !='' ? $saving[0]->savingsMobilization_voluntary_saving : 'N/A' }}</td>
            </tr>
        </tbody>


    </table>
    <br>
    <br>
  
    <!-- Challenges -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >CHALLENGES ACTION PLAN</td>
            </tr>
        </thead>
    </table>
   <br>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="2">Top Challenges</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="50px">S.No</th>
                <th >Top Challenges</th>
            </tr>
            @php $i=1; @endphp
            @if (!empty($challenges))
            @foreach ($challenges as $row)
            <tr>
                <td >{{ $i++ }}</td>
                <td >{{ $row->challenge }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <br>
    <!-- Action Plan -->
   
   
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" width="100%">Action Plan To Address Challenges</td>
            </tr>
        </thead>
    </table>
    
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <tbody>
            <tr>
                <th width="4%">S.No</th>
                <th>Action Plan</th>
                @if (!empty($challenges))
                @foreach ($challenges as $row)
                <th>{{ $row->challenge }}</th>
                @endforeach
                @endif
            </tr>
            @if (!empty($challenges_action))
            @foreach ($challenges_action as $key => $row)
            <tr>
                <td class="tdc">{{ $key + 1  }}</td>
                <td >{{ $row['name'] !='' ? $row['name'] : 'N/A' }}</td>
                @if (!empty($row['action']))
                @foreach ($row['action'] as $val)
                <td >{{ $val != '' ? $val : 'N/A' }}</td>
                @endforeach
                @endif
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <br>
    <!-- Observation -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >OBSERVATIONS</td>
            </tr>
        </thead>
    </table>
   <br>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
       
        <tbody>
            <tr style="background-color:#01a9ac">
                <th width="4%" class="tdc">S.No</th>
                <th>Questions</th>
                <th>Answers</th>
            </tr>


            <tr>
                <td class="tdc">1</td>
                <th style="text-align: start;">Who attended the meeting? E.g chair, treasurer, secretary,
                    book-keeper, other,</th>
                    <td style="text-align: start;">
                        @if (!empty($observation))
                        @foreach ($observation as $row)
                        @php
                        $desg = [];
                        if ($row->shg_observation_chair == 1) {
                        $desg[] = 'Chair';
                        }
                        if ($row->shg_observation_secretary == 1) {
                        $desg[] = 'Secretary';
                        }
                        if ($row->shg_observation_bookkeeper == 1) {
                        $desg[] = 'Bookkeeeper';
                        }
                        if ($row->shg_observation_treasure == 1) {
                        $desg[] = 'Treasure';
                        }
                        if ($row->shg_observation_other == 1) {
                        $desg[] = 'Other';
                        }
                        $strdesg = implode(',', $desg);
                        @endphp
                        {{ checkna($strdesg) }}
                        @endforeach
                        @endif
                    </td>
            </tr>
            
            


            <tr>
                <td class="tdc">2</td>
                <th style="text-align: start;">Did members understand the Purpose of the meeting?</th>
                <td style="text-align: start;">{{ checkna($observation[0]->shg_observation_Purpose_a) }}</td>
            </tr>
            
            <tr>
                <td class="tdc">3</td>
                <th style="text-align: start;">What was quality of Discussion? Did every one participate?</th>
                <td style="text-align: start;">{{ checkna($observation[0]->shg_observation_discussion_a) }}</td>
            </tr>
            
            <tr>
                <td class="tdc">4</td>
                <th style="text-align: start;">Were group members aware of their rules and norms?</th>
                <td></td>
            </tr>
            <tr>
                <td class="tdc">A.</td>
                <th style="text-align: start;">Did they understand vision of their group?</th>
                <td style="text-align: start;">{{ checkna($observation[0]->shg_observation_norms_a) }}</td>
            </tr>
            
            <tr>
                <td class="tdc">B.</td>
                <th style="text-align: start;">Do they understand benefits of being part of the group?</th>
                <td style="text-align: start;">{{ checkna($observation[0]->shg_observation_norms_b) }}</td>
            </tr>
            
            <tr>
                <td class="tdc">5</td>
                <th style="text-align: start;">Important practices followed by the group.</th>
                <td></td>
            </tr>
            <tr>
                <td class="tdc">A.</td>
                <th style="text-align: start;"> Do they have a set of important practices for repayment and
                    savings?</th>
                    <td style="text-align: start;">{{ checkna($observation[0]->shg_observation_savings_a) }}</td>
            </tr>
           
            <tr>
                <td class="tdc">B.</td>
                <th style="text-align: start;">What are those practices?</th>
                <td style="text-align: start;">{{ checkna($observation[0]->shg_observation_savings_b) }}</td>
            </tr>
           

            <tr>
                <td class="tdc">6</td>
                <th style="text-align: start;">Does this group include members who are the most poor and
                    vulnerable, and if yes, what is their policy to help them</th>
                    <td style="text-align: start;">{{ checkna($observation[0]->shg_observation_vulnerable_members) }}</td>
            </tr>
            
          
            <tr>
                <td class="tdc">7</td>
                <th style="text-align: start;">Group’s Awareness about their financial information.</th>
                <td></td>
            </tr>

            <tr>
                <td class="tdc">A.</td>
                <th style="text-align: start;">Are books of account managed by the bookkeeper only or are other
                    office bearers aware of their financial information?</th>
                    <td style="text-align: start;">{{ checkna($observation[0]->shg_observation_financial_information_a) }}
                    </td>
            </tr>
           
            <tr>
                <td class="tdc">B.</td>
                <th style="text-align: start;">Are all members aware of their savings, loans and group financial
                    information?</th>
                    <td style="text-align: start;">{{ checkna($observation[0]->shg_observation_financial_information_b) }}
                    </td>
            </tr>
           
            <tr>
                <td class="tdc">8</td>
                <th style="text-align: start;"> Are there any unique features of this group. Explain</th>
                <td style="text-align: start;">{{ checkna($observation[0]->shg_observation_features_group_a) }}</td>
            </tr>
            
            <tr>
                <td class="tdc">9</td>
                <th style="text-align: start;">Summary of important 3- 5 highlights about this group?</th>
                <td>
                    @if ($observation[0]->shg_observation_highlights_a != '')
            
                    <li style="text-align: start;margin-left:10px;">{{ $observation[0]->shg_observation_highlights_a }}</li>
                
                @endif
                @if ($observation[0]->shg_observation_highlights_b != '')
                
                   
                    <li style="text-align: start;margin-left:10px;">{{ $observation[0]->shg_observation_highlights_b }}</li>
                
                @endif
                @if ($observation[0]->shg_observation_highlights_c != '')
               
                   
                    <li style="text-align: start;margin-left:10px;">{{ $observation[0]->shg_observation_highlights_c }}</li>
                
                @endif
                @if ($observation[0]->shg_observation_highlights_d != '')
                
                    
                    <li style="text-align: start;margin-left:10px;">{{ $observation[0]->shg_observation_highlights_d }}</li>
                
                @endif
                @if ($observation[0]->shg_observation_highlights_e != '')
                
                    
                    <li style="text-align: start;margin-left:10px;">{{ $observation[0]->shg_observation_highlights_e }}</li>
                
                @endif
                </td>
            </tr>
         
        </tbody>
        
    </table>
    <br>
    <!-- Rating Card -->
<table class="table table-bordered table-stripped table1 " cellspacing="0">
    <thead>
        <tr class="table-primary" style="text-align: center;">
            <td style="background-color:black;color:white">REPORT CARD</td>
        </tr>
    </thead>
</table>
<br>
<table class="table table-bordered table-stripped table1 " cellspacing="0">
    <thead class="back-color">
        <tr>
            <th width="450px">SHG Indicators</th>
            <td colspan="4"></td>
            <th colspan="" style="text-align:center;">Actual Score</th>
            <th colspan="" style="text-align:center;">Expected Score</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1 Governance</td>
            <td style="background-color: green;width:50px;">
                @if ($score >= 90)
                    <span class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: yellow;width:50px;">
                @if ($score >= 75 && $score <= 89) <span
                        class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: lightgrey;width:50px;">
                @if ($score >= 60 && $score <= 74) <span
                        class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: red;width:50px;">
                @if ($score <= 59) <span class="checkmark"></span>
                @endif
            </td>
            <td style="text-align: center;">{{ $total_1 }}</td>
            <td style="text-align: center;">25</td>
            {{-- <td>{{round($score)}}</td> --}}
        </tr>
        <tr>
            <td>2 Inclusion</td>
            <td style="background-color: green;width:50px;">
                @if ($score1 >= 90)
                    <span class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: yellow;width:50px;">
                @if ($score1 >= 75 && $score1 <= 89) <span
                        class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: lightgrey;width:50px;">
                @if ($score1 >= 60 && $score1 <= 74) <span
                        class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: red;width:50px;">
                @if ($score1 <= 59) <span class="checkmark"></span>
                @endif
            <td style="text-align: center;">{{ $total_2 }}</td>
            <td style="text-align: center;">15</td>
            {{-- <td>{{round($score1)}}</td> --}}
        </tr>
        <tr>
            <td>3 Efficiency</td>
            <td style="background-color: green;width:50px;">
                @if ($score2 >= 90)
                    <span class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: yellow;width:50px;">
                @if ($score2 >= 75 && $score2 <= 89) <span
                        class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: lightgrey;width:50px;">
                @if ($score2 >= 60 && $score2 <= 74) <span
                        class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: red;width:50px;">
                @if ($score2 <= 59) <span class="checkmark"></span>
                @endif
            <td style="text-align: center;">{{ $total_3 }}</td>
            <td style="text-align: center;">10</td>
            {{-- <td>{{round($score2)}}</td> --}}
        </tr>
        <tr>
            <td>4 Credit history</td>
            <td style="background-color: green;width:50px;">
                @if ($score3 >= 90)
                    <span class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: yellow;width:50px;">
                @if ($score3 >= 75 && $score3 <= 89) <span
                        class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: lightgrey;width:50px;">
                @if ($score3 >= 60 && $score3 <= 74) <span
                        class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: red;width:50px;">
                @if ($score3 <= 59) <span class="checkmark"></span>
                @endif
            <td style="text-align: center;">{{ $total_4 }}</td>
            <td style="text-align: center;">30</td>
            {{-- <td>{{round($score3)}}</td> --}}
        </tr>

        <tr>
            <td>5 Saving</td>
            <td style="background-color: green;width:50px;">
                @if ($score4 >= 90)
                    <span class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: yellow;width:50px;">
                @if ($score4 >= 75 && $score4 <= 89) <span
                        class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: lightgrey;width:50px;">
                @if ($score4 >= 60 && $score4 <= 74) <span
                        class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: red;width:50px;">
                @if ($score4 <= 59) <span class="checkmark"></span>
                @endif
            <td style="text-align: center;">{{ $total_5 }}</td>
            <td style="text-align: center;">20</td>
            {{-- <td>{{round($score4 )}}</td> --}}
        </tr>
        <tr>

            @php
                if ($grd_total >= 90) {
                    $color = 'green';
                }
                if ($grd_total >= 75 && $grd_total <= 89) {
                    $color = 'yellow';
                }
                if ($grd_total >= 60 && $grd_total <= 74) {
                    $color = 'lightgrey';
                }
                if ($grd_total <= 59) {
                    $color = 'red';
                }
                
            @endphp



            <th width="450px">Total Score</th>
            <td colspan="4"></td>
            <td style="background-color:{{ $color }};text-align:center;font-weight:bold;font-size:20px;">
                {{ $grd_total }}</td>


            <td></td>
    </tbody>
</table>
<br>



</body>

</html>