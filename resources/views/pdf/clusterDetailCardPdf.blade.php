<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Cluster Details</title>
</head>

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generate On- @php
        echo generated_date();
        @endphp
    </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Cluster Profile({{$cluster->uin}})</u>
            </h2>
        </div>

    </div>
    <style>
        .page-break {
                page-break-before: always;
                    } 
         .round{
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
            text-align: ;
        }
    
        ;
    
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
        .tdc{text-align: center;}
        th{text-align: start;}
        /* td{text-align: center;} */
    </style>
    <!-- cluster profile -->
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
                <td style="background-color:#01a9ac" colspan="4">Name & Others Details</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Name</th>
                <td width="25%" >{{ $profile[0]->name_of_cluster }}</td>
                <th width="25%">UIN</th>
                <td width="25%" >{{ $cluster->uin }}</td>
            </tr>
            <tr>
                <th width="25%">Cluster office location</th>
                <td width="25%" >{{ checkna($profile[0]->office_location) }}</td>
                <th width="25%">Federation</th>
                <td width="25%" >{{ $fed_profile[0]->name_of_federation }}</td>
            </tr>
            <tr>
                <th width="25%">District</th>
                <td width="25%" >{{ $profile[0]->name_of_district }}</td>
                <th width="25%">State</th>
                <td width="25%">{{ $profile[0]->name_of_state }}</td>
            </tr>
            <tr>
                <th width="25%">Country</th>
                <td width="25%">{{ $profile[0]->name_of_country }}</td>
                <th width="25%">NRLM Code</th>
                <td width="25%">{{ $profile[0]->vo_code }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Cluster Creation And Membership </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Date cluster was formed</th>
                <td width="25%" >{{  change_date_month_name_char(str_replace('/','-',$profile[0]->cluster_formed))}}</td>
                <th width="25%">No of SHGs at Creation</th>
                <td width="25%" >{{ $profile[0]->shg_at_time_creation }}</td>
            </tr>
            <tr>
                <th width="25%">No of members at creation</th>
                <td width="25%" >{{ checkZero($profile[0]->cluster_members_at_time_creation)  }}</td>
                <th width="25%">No of current SHGs</th>
                <td width="25%" >{{ checkZero($profile[0]->total_SHGs) }}</td>
            </tr>
            <tr>
                <th width="25%">No of current Members</th>
                <td width="25%">{{ checkZero($profile[0]->total_members) }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>

        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Current Leadership</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">President/Animator</th>
                <td width="25%" >{{ checkna($profile[0]->president) }}</td>
                <th width="25%">Secretary</th>
                <td width="25%" >{{ checkna($profile[0]->secretary) }}</td>
            </tr>
            <tr>
                <th width="25%">Treasurer</th>
                <td width="25%" >{{ checkna($profile[0]->treasure) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
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
                <td width="25%" >{{ checkna($profile[0]->book_keeper_name) }}</td>
                <th width="25%">Date of appointment</th>
                <td width="25%" >{{ $profile[0]->date_of_appointment !='' ? change_date_month_name_char(str_replace('/','-',$profile[0]->date_of_appointment)) : 'N/A' }}</td>

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
            <tr>Bank Accounts Details
                <th width="25%">Account opening date</th>
                <td width="25%" >{{$profile[0]->account_opening_date !='' ?  change_date_month_name_char(str_replace('/','-',$profile[0]->account_opening_date)) : 'N/A' }}</td>
                <th width="25%">Name of the bank</th>
                <td width="25%" >{{ checkna($profile[0]->name_of_the_bank) }}</td>
            </tr>
            <tr>
                <th width="25%">Name of Branch</th>
                <td width="25%" >{{ checkna($profile[0]->branch) }}</td>
                <th width="25%">Account no</th>
                <td width="25%" >{{ checkna($profile[0]->account_number) }}</td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Contact Information</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Name of contact</th>
                <td width="25%" >{{ checkna($profile[0]->name_of_the_contact_person) }}</td>
                <th width="25%">Designation</th>
                <td width="25%" >{{ checkna($profile[0]->designation) }}</td>
            </tr>
            <tr>
                <th width="25%">Contact Number</th>
                <td width="25%" >{{ checkna($profile[0]->contact_number) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
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
                <td style="background-color:#01a9ac" colspan="4">Rules </td>
            </tr>
        </thead>
       
        <tbody>
            <tr>
                <th width="25%">Adoption of Rules</th>
                <td width="25%" >{{ checkna($governance[0]->adoption_of_rules) }}</td>
                <th width="25%">Date of Adoption</th>
                <td width="25%" >{{$governance[0]->date_adoption !='' ?  change_date_month_name_char(str_replace('/','-',$governance[0]->date_adoption)) : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Written Rules</th>
                <td width="25%" >{{ checkna($governance[0]->written_norms) }}</td>
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
                <td width="25%" >{{ checkna($governance[0]->frequency_per_norms) }}</td>
                <th width="25%">1st election date</th>
                <td width="25%" >{{$governance[0]->first_election_date !='' ?  change_date_month_name_char(str_replace('/','-',$governance[0]->first_election_date)) :'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Date of Last Election</th>
                <td width="25%" >{{  $governance[0]->date_last_election !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->date_last_election)) :'N/A' }}</td>
                <th width="25%">Last 2 elections conducted as per norms</th>
                <td width="25%" > {{ checkna($governance[0]->last_two_election_conducted) }}</td>
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
                <td width="25%" >{{ checkZero($governance[0]->frequency_of_meetings) }}</td>
                <th width="25%">No of meetings conducted during last 12 months</th>
                <td width="25%" >{{ checkZero($governance[0]->meetings_cluster_conducted) }}</td>
            </tr>
            <tr>
                <th width="25%">Average Participation of Members during last 12 months</th>
                <td width="25%" >{{ checkZero($governance[0]->participation_members) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
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
                <th width="25%">Separate minute book</th>
                <td width="25%" >{{ checkna($governance[0]->minute_book_to_record_minute) }}</td>

                <th width="25%">Who writes the minutes</th>
                <td width="25%" >{{ checkna($governance[0]->who_writes_minutes) }}</td>
            </tr>
            
            <tr>
                
                <th width="25%">Status of group meetings recorded</th>
                <td width="25%" >{{ checkna($governance[0]->meetings_recorded) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
            
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Bank Accounts Details</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th width="25%">Bank accounts in regular operation during last 12 months</th>
                <td width="25%">{{ checkna($governance[0]->accounts_regular) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Grade</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th width="25%">Grade During Last 12 Months</th>
                <td width="25%" >{{ checkna($governance[0]->grading_cluster) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Social Audit Committees</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th width="25%">Whether Cluster Has A SAC</th>
                <td width="25%">{{ checkna($governance[0]->social_audit_committee) }}</td>
                <th width="25%">SAC creation date</th>
                <td width="25%">{{ $governance[0]->sac_created !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->sac_created)) : 'N/A' }}</td>
            </tr>

            <tr>
                <th width="25%">Functions of SAC (describe)</th>
                <td width="25%" >{{ $governance[0]->function_sac_a . ',' . $governance[0]->function_sac_b . ',' . $governance[0]->function_sac_c . ',' . $governance[0]->function_sac_d }}</td>
                <th width="25%">How many SAC reports prepared and submitted during last 12 months</th>
                <td width="25%" >{{ checkZero($governance[0]->sac_reports_submitted) }}</td>
            </tr>
            <tr>
                
                <th width="25%">Date of last report</th>
                <td width="25%" >{{  $governance[0]->date_last_report !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->date_last_report)) :'N/A' }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>

        </tbody>
    </table>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Internal Audit </td>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <th width="25%">Internal Audit</th>
                <td width="25%" >{{ checkna($governance[0]->internal_audit) }}</td>
                <th width="25%">How often</th>
                <td width="25%" >{{ checkna($governance[0]->internal_how_often) }}</td>
            </tr>

            <tr>
                <th width="25%">Date of internal audit during last 12 months</th>
                <td width="25%" >{{ $governance[0]->date_internal_audit !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->date_internal_audit)) : 'N/A' }}</td>
                <th width="25%">Issues and observations raised during last 12 months (Describe)</th>
                <td width="25%" >{{ checkna($governance[0]->internal_observations_raised) }}</td>
                
            </tr>

            <tr>
                
                <th width="25%">How many issues were resolved (describe)</th>
                <td width="25%" >{{ checkna($governance[0]->internal_issues_resolved) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
        </tbody>
        
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">External Audit </td>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <th width="25%">External Audit</th>
                <td width="25%" >{{ checkna($governance[0]->external_audit) }}</td>
                <th width="25%">How often</th>
                <td width="25%" >{{ checkna($governance[0]->external_how_often) }}</td>
            </tr>

            <tr>
                <th width="25%">Issues and observations raised during last 12 months (Describe)</th>
                <td width="25%" >{{ checkna($governance[0]->external_observations_raised) }}</td>
                <th width="25%">Date of external audit during last 112month</th>
                <td width="25%" >{{ $governance[0]->date_last_audit_conducted !='' ?  change_date_month_name_char(str_replace('/','-',$governance[0]->date_last_audit_conducted)) : 'N/A'}}</td>
            </tr>

            <tr>
                <th width="25%">How many issues were resolved (describe)</th>
                <td width="25%" >{{ checkna($governance[0]->external_issues_resolved) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
        </tbody>
        
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Committees </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th width="25%">Committee</th>
                <td width="25%" class="tdc">{{ checkna($governance[0]->cluster_sub_committees) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
            @if (!empty($governance_service))
            @foreach ($governance_service as $row)
            <tr>
                <th width="25%">Name of subcommittee</th>
                <td width="25%" class="tdc">{{ $row->name }}</td>
                <th width="25%">Purpose</th>
                <td width="25%" class="tdc">{{ $row->purpose }}</td>
            </tr>
            <tr>
                <th width="25%">Date formed </th>
                <td width="25%" class="tdc">{{ change_date_month_name_char(str_replace('/','-',$row->date_formed ))}}</td>
                <th width="25%">No of members </th>
                <td width="25%" class="tdc">{{ $row->members }}</td>
            </tr>
            @endforeach
            @endif
           
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Defunct SHG Status </td>
            </tr>
        </thead>

        <tbody>

            <tr>
                <th width="25%">Total SHGs formed in cluster</th>
                <td width="25%" >{{ checkZero($governance[0]->total_shgs_formed) }}</td>
                <th width="25%">At present no of SHGs defunct</th>
                <td width="25%" >{{ checkZero($governance[0]->shgs_defunct) }}</td>
            </tr>
            <tr>
                <th width="25%">Defunct SHGs (%)</th>
                <td width="25%" >{{ checkZero($governance[0]->defunct_shgs_par) }}%</td>
                <th width="25%">Reasons for defunct (explain)</th>
                <td width="25%" >{{ checkna($governance[0]->defunct_shgs_reasons) }}</td>
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
                <td style="background-color:#01a9ac" colspan="4">Wealth Ranking/Poverty Mapping</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th width="25%">Wealth Ranking/Poverty Mapping</th>
                <td width="25%" >{{ checkna($inclusion[0]->wealth_ranking) }}</td>
                <th width="25%">Date of 1st poverty mapping</th>
                <td width="25%" >{{ $inclusion[0]->first_poverty_mapping !='' ? change_date_month_name_char(str_replace('/','-',$inclusion[0]->first_poverty_mapping)) : 'N/A' }}</td>
            </tr>
            <tr>
                
                <th width="25%">Date of last update</th>
                <td width="25%" >{{  $inclusion[0]->last_update !='' ? change_date_month_name_char(str_replace('/','-',$inclusion[0]->last_update)) : 'N/A'}}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
            
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Visual Poverty Mapping</td>
            </tr>
        </thead>

        <tbody>

            <tr>
                <th width="25%">No of Poorest &amp; vulnerable</th>
                <td width="25%" >{{ checkZero($inclusion[0]->visual_poorest_category) }}</td>
                <th width="25%">No of Poor</th>
                <td width="25%" >{{ checkZero($inclusion[0]->visual_poor_category) }}</td>
            </tr>
            <tr>
                <th width="25%">No of Medium Poor</th>
                <td width="25%" >{{ checkZero($inclusion[0]->visual_medium_category) }}</td>
                <th width="25%">No of Rich</th>
                <td width="25%" >{{ checkZero($inclusion[0]->visual_rich_category) }}</td>
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
                <td width="25%" >{{ checkZero($inclusion[0]->sc_st_caste) }}</td>
                <th width="25%">No of OBC</th>
                <td width="25%" >{{ checkZero($inclusion[0]->obc_caste) }}</td>
            </tr>
            <tr>
                <th width="25%">No of others</th>
                <td width="25%" >{{ checkZero($inclusion[0]->other_caste) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>

        </tbody>
    </table>
<br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="9">Cumulative No. Of Loans And Amounts  During Last 3 Years</td>
            </tr>
            <tr>
                <th class="tdc">Category</th>
                <th class="tdc" colspan="2">Cluster Loans </th>
                <th class="tdc" colspan="2">External Loans</th>
                <th class="tdc" colspan="2">VI Loans </th>
                <th class="tdc" colspan="2">Total Loans </th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th></th>
                <th class="tdc">No. of loan disbursed </th>
                <th class="tdc">Amount disbursed (Rs.)</th>
                <th class="tdc">No. of loan disbursed </th>
                <th class="tdc">Amount disbursed (Rs.)</th>
                <th class="tdc">No. of loan disbursed </th>
                <th class="tdc">Amount disbursed (Rs.)</th>
                <th class="tdc">No. of loan disbursed </th>
                <th class="tdc">Amount disbursed (Rs.)</th>
            </tr>
            <tr style="text-align: center;">
                <td>Very Poor &amp; vulnerable</td>
                <td>{{ (int) $inclusion[0]->federation_poorest_category }}</td>
                <td>{{ (int) $inclusion[0]->federation_poorest_category_amount }}
                </td>
                <td>{{ (int) $inclusion[0]->external_poorest_category }}</td>
                <td>{{ (int) $inclusion[0]->external_poorest_category_amount }}</td>
                <td>{{ (int) $inclusion[0]->vi_poorest_category }}</td>
                <td>{{ (int) $inclusion[0]->vi_poorest_category_amount }}</td>
                <td>{{ (int) $inclusion[0]->federation_poorest_category + (int) $inclusion[0]->external_poorest_category + (int) $inclusion[0]->vi_poorest_category }}
                </td>
                <td>{{ (int) $inclusion[0]->federation_poorest_category_amount + (int) $inclusion[0]->external_poorest_category_amount + (int) $inclusion[0]->vi_poorest_category_amount }}
                </td>
            </tr>
            <tr style="text-align: center;">
                <td>Poor</td>
                <td>{{ (int) $inclusion[0]->federation_poor_category }}</td>
                <td>{{ (int) $inclusion[0]->federation_poor_category_amount }}</td>
                <td>{{ (int) $inclusion[0]->external_poor_category }}</td>
                <td>{{ (int) $inclusion[0]->external_poor_category_amount }}</td>
                <td>{{ (int) $inclusion[0]->vi_poor_category }}</td>
                <td>{{ (int) $inclusion[0]->vi_poor_category_amount }}</td>
                <td>{{ (int) $inclusion[0]->federation_poor_category + (int) $inclusion[0]->external_poor_category + (int) $inclusion[0]->vi_poor_category }}
                </td>
                <td>{{ (int) $inclusion[0]->federation_poor_category_amount + (int) $inclusion[0]->external_poor_category_amount + (int) $inclusion[0]->vi_poor_category_amount }}
                </td>
            </tr>
            <tr style="text-align: center;">
                <td>Medium poor</td>
                <td>{{ (int) $inclusion[0]->federation_medium }}</td>
                <td>{{ (int) $inclusion[0]->federation_medium_amount }}</td>
                <td>{{ (int) $inclusion[0]->external_medium }}</td>
                <td>{{ (int) $inclusion[0]->external_medium_amount }}</td>
                <td>{{ (int) $inclusion[0]->vi_medium }}</td>
                <td>{{ (int) $inclusion[0]->vi_medium_amount }}</td>
                <td>{{ (int) $inclusion[0]->federation_medium + (int) $inclusion[0]->external_medium + (int) $inclusion[0]->vi_medium }}
                </td>
                <td>{{ (int) $inclusion[0]->federation_medium_amount + (int) $inclusion[0]->external_medium_amount + (int) $inclusion[0]->vi_medium_amount }}
                </td>
            </tr>
            <tr style="text-align: center;">
                <td>Rich</td>
                <td>{{ (int) $inclusion[0]->federation_rich }}</td>
                <td>{{ (int) $inclusion[0]->federation_rich_amount }}</td>
                <td>{{ (int) $inclusion[0]->external_rich }}</td>
                <td>{{ (int) $inclusion[0]->external_rich_amount }}</td>
                <td>{{ (int) $inclusion[0]->vi_rich }}</td>
                <td>{{ (int) $inclusion[0]->vi_rich_amount }}</td>
                <td>{{ (int) $inclusion[0]->federation_rich + (int) $inclusion[0]->external_rich + (int) $inclusion[0]->vi_rich }}
                </td>
                <td>{{ (int) $inclusion[0]->federation_rich_amount + (int) $inclusion[0]->external_rich_amount + (int) $inclusion[0]->vi_rich_amount }}
                </td>
            </tr>
            <tr style="text-align: center;">
                <td>Total</td>
                <td>{{ (int) $inclusion[0]->federation_poorest_category + (int) $inclusion[0]->federation_poor_category + (int) $inclusion[0]->federation_medium + (int) $inclusion[0]->federation_rich }}
                </td>
                <td>{{ (int) $inclusion[0]->federation_poorest_category_amount + (int) $inclusion[0]->federation_poor_category_amount + (int) $inclusion[0]->federation_medium_amount + (int) $inclusion[0]->federation_rich_amount }}
                </td>
                <td>{{ (int) $inclusion[0]->external_poorest_category + (int) $inclusion[0]->external_poor_category + (int) $inclusion[0]->external_medium + (int) $inclusion[0]->external_rich }}
                </td>
                <td>{{ (int) $inclusion[0]->external_poorest_category_amount + (int) $inclusion[0]->external_poor_category_amount + (int) $inclusion[0]->external_medium_amount + (int) $inclusion[0]->external_rich_amount }}
                </td>
                <td>{{ (int) $inclusion[0]->vi_poorest_category + (int) $inclusion[0]->vi_poor_category + (int) $inclusion[0]->vi_medium + (int) $inclusion[0]->vi_rich }}
                </td>
                <td>{{ (int) $inclusion[0]->vi_poorest_category_amount + (int) $inclusion[0]->vi_poor_category_amount + (int) $inclusion[0]->vi_medium_amount + (int) $inclusion[0]->vi_rich_amount }}
                </td>
                <td>{{ (int) $inclusion[0]->federation_poorest_category + (int) $inclusion[0]->external_poorest_category + (int) $inclusion[0]->vi_poorest_category + (int) $inclusion[0]->federation_poor_category + (int) $inclusion[0]->external_poor_category + (int) $inclusion[0]->vi_poor_category + (int) $inclusion[0]->federation_medium + (int) $inclusion[0]->external_medium + (int) $inclusion[0]->vi_medium + (int) $inclusion[0]->federation_rich + (int) $inclusion[0]->external_rich + (int) $inclusion[0]->vi_rich }}
                </td>
                <td>{{ (int) $inclusion[0]->federation_poorest_category_amount + (int) $inclusion[0]->external_poorest_category_amount + (int) $inclusion[0]->vi_poorest_category_amount + (int) $inclusion[0]->federation_poor_category_amount + (int) $inclusion[0]->external_poor_category_amount + (int) $inclusion[0]->vi_poor_category_amount + (int) $inclusion[0]->federation_medium_amount + (int) $inclusion[0]->external_medium_amount + (int) $inclusion[0]->vi_medium_amount + (int) $inclusion[0]->federation_rich_amount + (int) $inclusion[0]->external_rich_amount + (int) $inclusion[0]->vi_rich_amount }}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 page-break" cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="5">No. Of HHs Benefitted From All Loans During Last 12 Months</td>
            </tr>
            <tr>
                <th rowspan="2">Category</th>
                <th rowspan="2" class="tdc">Cluster Member HHs (#)</th>
                <th colspan="3" class="tdc">Received Loan / Cluster Member HHs</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th class="tdc">Cluster Loan</th>
                <th class="tdc">External loan</th>
                <th class="tdc">VI Loan</th>
            </tr>

            <tr >
                <td>Very Poor &amp; vulnerable</td>
                <td class="tdc">{{ checkzero($inclusion[0]->visual_poorest_category) }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category_recloan }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->external_poorest_category_recloan }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_poorest_category_recloan }}</td>

            </tr>

            <tr>
                <td>Poor</td>
                <td class="tdc">{{ checkzero($inclusion[0]->visual_poor_category) }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poor_category_recloan }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_poor_category_recloan }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_poor_category_recloan }}</td>

            </tr>

            <tr>
                <td>Medium</td>
                <td class="tdc">{{ checkzero($inclusion[0]->visual_medium_category) }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_medium_recloan }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_medium_recloan }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_medium_recloan }}</td>

            </tr>

            <tr>
                <td>Rich</td>
                <td class="tdc">{{ checkzero($inclusion[0]->visual_rich_category) }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_rich_recloan }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_rich_recloan }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_rich_recloan }}</td>

            </tr>
            <tr>
                <td>Total</td>
                <td class="tdc">{{(int)$inclusion[0]->visual_poorest_category+(int)$inclusion[0]->visual_poor_category+(int)$inclusion[0]->visual_medium_category+(int)$inclusion[0]->visual_rich_category}}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category_recloan + (int) $inclusion[0]->federation_poor_category_recloan + (int) $inclusion[0]->federation_medium_recloan + (int) $inclusion[0]->rich_members_benefited_cluster }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->external_poorest_category_recloan + (int) $inclusion[0]->external_poor_category_recloan + (int) $inclusion[0]->external_medium_recloan + (int) $inclusion[0]->external_rich_recloan }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_poorest_category_recloan + (int) $inclusion[0]->vi_poor_category_recloan + (int) $inclusion[0]->vi_medium_recloan + (int) $inclusion[0]->vi_rich_recloan }}
                </td>

            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">No of poor and most poor in Leadership position </td>
            </tr>
        </thead>

        <tbody>

            <tr >
                <th width="50%">No of poor and most poor in Leadership position</th>
                <td width="50%">{{ checkZero((int) $inclusion[0]->poor_current_leadership) }}</td>
                <th width="50%"></th>
                <td width="50%"></td>
            </tr>

        </tbody>
    </table>
    <br>
   
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Board Constitution  </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th width="25%">Cluster Board Constitution</th>
                <td width="25%" >{{ checkna($inclusion[0]->board_members_constitution) }}</td>
                <th width="25%">No of members from the poor</th>
                <td width="25%" >{{ checkna($inclusion[0]->poor_board_members) }}</td>
            </tr>
            <tr>
                <th width="25%">Total no of Board members</th>
                <td width="25%" >{{ checkna($inclusion[0]->total_board_members) }}</td>
                <th width="25%">No of members from the poorest and vulnerable</th>
                <td width="25%" >{{ checkna($inclusion[0]->poorest_board_members) }}</td>
            </tr>
            <tr>
                <th width="25%">No of members from middle and rich category</th>
                <td width="25%" >{{ checkna($inclusion[0]->rich_board_members) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
            
        </tbody>
    </table>
    <br>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Coverage of Target Population</td>
            </tr>
        </thead>

        <tbody>

            <tr>
                <th width="25%">Total target poor in the cluster</th>
                <td width="25%" >{{ checkZero($inclusion[0]->total_target_poor) }}</td>
                <th width="25%">No of target poor mobilized in SHGs</th>
                <td width="25%" >{{ checkZero($inclusion[0]->target_poor_mobilized) }}</td>
            </tr>
            <tr>
                <th width="25%">% of target poor mobilized in SHGs</th>
                <td width="25%" >{{ checkZero($inclusion[0]->percentage_poor_mobilized) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
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
                <td style="background-color:#01a9ac" colspan="4">Integrated Member Plan  </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th width="25%">Cluster Integrated Member Plan Prepared</th>
                <td width="25%">{{ checkna($efficiency[0]->cluster_prepared) }}</td>
                <th width="25%">Date of last plan approved by Cluster</th>
                <td width="25%">{{ $efficiency[0]->date_approved !='' ? change_date_month_name_char(str_replace('/','-',$efficiency[0]->date_approved)) : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Date it was submitted to Federation/partner</th>
                <td width="25%">{{  $efficiency[0]->date_submitted !='' ?  change_date_month_name_char(str_replace('/','-',$efficiency[0]->date_submitted)) : 'N/A'}}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
            
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 page-break" cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="5">Training Details</td>
            </tr>
        </thead>
        <tr>
            <th>Name of training</th>
            <th>Duration</th>
            <th>Date</th>
            <th>Name of Training Recipient</th>
            <th>Name of Trainer</th>
        </tr>
        <tbody>
            @if (!empty($efficiency_1))
            @foreach ($efficiency_1 as $row)
            <tr>

                <td>{{ checkna($row->training_name) }}</td>
                <td>{{ checkna($row->duration) }}</td>
                <td>{{ $row->date_training !='' ? Change_date_month_name_char(str_replace('/', '-', $row->date_training)) :'N/A'}}</td>
                <td>
                    @php
                    $desg = [];
                    if ($row->who_received_sec == 1) {
                    $desg[] = 'Secretary';
                    }
                    if ($row->who_received_pres == 1) {
                    $desg[] = 'President';
                    }
                    if ($row->who_received_treas == 1) {
                    $desg[] = 'Treasurer';
                    }
                    if ($row->who_received_other == 1) {
                    $desg[] = 'Other';
                    }
                    $strdesg = implode(',', $desg);
                    @endphp
                    {{ $strdesg }}
                </td>
                <td >{{ checkna($row->training_name) }}</td>
            </tr>
            @endforeach
            @endif

            @if (!empty($efficiency_2))
            @foreach ($efficiency_2 as $row)
            <tr>
                {{-- <td>B</td>
                                                            <td>SAC members</td> --}}
                <td >{{ $row->training_name }}</td>
                <td >{{ $row->duration }}</td>
                <td >{{ $row->date_training }}</td>
                <td>
                    @php
                    $desg = [];
                    if ($row->who_received_sec == 1) {
                    $desg[] = 'Secretary';
                    }
                    if ($row->who_received_pres == 1) {
                    $desg[] = 'President';
                    }
                    if ($row->who_received_treas == 1) {
                    $desg[] = 'Treasurer';
                    }
                    if ($row->who_received_other == 1) {
                    $desg[] = 'Other';
                    }
                    $strdesg = implode(',', $desg);
                    @endphp
                    {{ $strdesg }}
                </td>
                <td >{{ $row->training_name }}</td>
            </tr>
            @endforeach
            @endif

            @if (!empty($efficiency_3))
            @foreach ($efficiency_3 as $row)
            <tr>
                {{-- <td>C</td>
                                                            <td>Other committee members</td> --}}
                <td >{{ $row->training_name }}</td>
                <td >{{ $row->duration }}</td>
                <td >{{ $row->date_training }}</td>
                <td>
                    @php
                    $desg = [];
                    if ($row->who_received_sec == 1) {
                    $desg[] = 'Secretary';
                    }
                    if ($row->who_received_pres == 1) {
                    $desg[] = 'President';
                    }
                    if ($row->who_received_treas == 1) {
                    $desg[] = 'Treasurer';
                    }
                    if ($row->who_received_other == 1) {
                    $desg[] = 'Other';
                    }
                    $strdesg = implode(',', $desg);
                    @endphp
                    {{ $strdesg }}
                </td>
                <td >{{ $row->training_name }}</td>
            </tr>
            @endforeach
            @endif

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Income And Expenses During last 12 Months</td>
            </tr>
        </thead>

        <tbody>

            <tr>
                <th width="25%">Income from all sources</th>
                <td width="25%">{{ checkZero($efficiency[0]->total_income) }}</td>
                <th width="25%">Expenses</th>
                <td width="25%">{{ checkZero($efficiency[0]->expense) }}</td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Approval Process</td>
            </tr>
        </thead>

        <tbody>

            <tr>
                <th width="25%">No of days taken to approve loan application at Cluster</th>
                <td width="25%">{{ checkZero($efficiency[0]->time_taken_to_approve_loan) }}</td>
                <th width="25%">Average Monthly loans during last 12 months</th>
                <td width="25%">{{ checkZero($efficiency[0]->loans_approved) }}</td>
            </tr>
            <tr>
                <th width="25%">Time taken from approval to cash in hand</th>
                <td width="25%">{{ checkZero($efficiency[0]->time_taken_to_give_loan) }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Monthly reports</td>
            </tr>
        </thead>

        <tbody>

            <tr>
                <th width="25%">Date of last report submitted</th>
                <td width="25%">{{ $efficiency[0]->last_report_submitted !='' ?  change_date_month_name_char(str_replace('/','-',$efficiency[0]->last_report_submitted)) : 'N/A'}}</td>
                <th></th>
                <td></td>

            </tr>


        </tbody>
    </table>
    <br>
    <!-- Credit History -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >CREDIT HISTORY</td>
            </tr>
        </thead>
    </table>
   <br>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        
        <tbody>
            <tr>
                <th width="25%">No of loan applications received at Cluster during last 12 months</th>
                <td width="25%" >{{ checkZero($creditrecovery[0]->applications_received_loans) }}</td>
                <th width="25%">No of loan applications approved during last 12 months</th>
                <td width="25%" >{{ checkZero( $creditrecovery[0]->approved_loan )}}</td>
            </tr>
            <tr>
                <th width="25%">Pending loan applications</th>
                <td width="25%" >{{ checkZero( $creditrecovery[0]->pending_loan_applications) }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
        </tbody>
    </table>
     <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">Cumulative Loan Amount</td>
            </tr>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th>Institution</th>
                <th>Amount (Rs)</th>
            </tr>
        </thead>
        <tbody>


        </tbody>
        <tbody>
            <tr>
                <td class="tdc">1</td>
                <td >Cluster</td>
                <td >{{ checkZero($creditrecovery[0]->cumulative_amount_cluster) }}</td>
            </tr>
            <tr>
                <td class="tdc">2</td>
                <td >Federation</td>
                <td >{{ checkZero($creditrecovery[0]->cumulative_amount_federation) }}</td>
            </tr>
            <tr>
                <td class="tdc">3</td>
                <td >Bank</td>
                <td >{{ checkZero($creditrecovery[0]->cumulative_amount_bank) }}</td>
            </tr>
            <tr>
                <td class="tdc">4</td>
                <td>VI</td>
                <td>{{ checkZero($creditrecovery[0]->cumulative_amount_vi) }}</td>
            </tr>
            <tr>
                <td class="tdc">5</td>
                <td>Other</td>
                <td>{{ checkZero($creditrecovery[0]->cumulative_amount_other) }}</td>
            </tr>
            <tr>
                <td class="tdc">6</td>
                <td>Total</td>
                <td>{{ checkZero($creditrecovery[0]->total_cumulative_amount) }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="7">No Of Cumulative Loans Disbursed To Members During Last 3 Years</td>
            </tr>
            <tr>
                <th>Category</th>
                <th class="tdc">Cluster Loans </th>
                <th class="tdc">Federation Loans </th>
                <th class="tdc">Bank loans </th>
                <th class="tdc">VI loans </th>
                <th class="tdc">Other Loans </th>
                <th class="tdc">Total No of Loans</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>(i)Very Poor &amp; vulnerable</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_cluster }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_federation }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_bank }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_vi }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_other }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_cluster + (int) $creditrecovery[0]->cumulative_members_federation + (int) $creditrecovery[0]->cumulative_members_bank + (int) $creditrecovery[0]->cumulative_members_vi + (int) $creditrecovery[0]->cumulative_members_other }}
                </td>
            </tr>
            <tr>
                <td>(ii) Poor</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ai }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5bi }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ci }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5di }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ei }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ai + (int) $creditrecovery[0]->new_cluster_creditHistory_question5bi + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ci + (int) $creditrecovery[0]->new_cluster_creditHistory_question5di + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ei }}
                </td>
            </tr>
            <tr>
                <td>(iii) Medium poor</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5aii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5bii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5cii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5dii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5eii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5aii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5bii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5cii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5dii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5eii }}
                </td>
            </tr>
            <tr>
                <td>(iv) Rich</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5aiii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5biii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ciii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5diii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5eiii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5aiii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5biii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ciii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5diii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5eiii }}
                </td>
            </tr>
            <tr>
                <td>(v) Total</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_cluster + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ai + (int) $creditrecovery[0]->new_cluster_creditHistory_question5aii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5aiii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_federation + (int) $creditrecovery[0]->new_cluster_creditHistory_question5bi + (int) $creditrecovery[0]->new_cluster_creditHistory_question5bii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5biii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_bank + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ci + (int) $creditrecovery[0]->new_cluster_creditHistory_question5cii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ciii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_vi + (int) $creditrecovery[0]->new_cluster_creditHistory_question5di + (int) $creditrecovery[0]->new_cluster_creditHistory_question5dii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5diii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_other + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ei + (int) $creditrecovery[0]->new_cluster_creditHistory_question5eii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5eiii }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cumulative_members_cluster +
                                                (int) $creditrecovery[0]->cumulative_members_federation +
                                                (int) $creditrecovery[0]->cumulative_members_bank +
                                                (int) $creditrecovery[0]->cumulative_members_vi +
                                                (int) $creditrecovery[0]->cumulative_members_other +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5ai +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5bi +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5ci +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5di +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5ei +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5aii +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5bii +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5cii +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5dii +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5eii +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5aiii +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5biii +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5ciii +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5diii +
                                                (int) $creditrecovery[0]->new_cluster_creditHistory_question5eiii }}
                </td>
            </tr>
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">No of member HHs Received Loans during last 3 years</td>
            </tr>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th width="48%">Institution</th>
                <th width="48%">No of HHS Received Loans</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tdc">1</td>
                <td>Cluster/Habitation/Neighbourhood Loan</td>
                <td >{{ (int) $creditrecovery[0]->cumulative_poor_members_cluster }}
                </td>
            </tr>
            <tr>
                <td class="tdc">2</td>
                <td>Federation Loan</td>
                <td >{{ (int) $creditrecovery[0]->cumulative_poor_members_federation }}
                </td>
            </tr>
            <tr>
                <td class="tdc">3</td>
                <td>Bank Loan</td>
                <td >{{ (int) $creditrecovery[0]->cumulative_poor_members_bank }}
                </td>
            </tr>
            <tr>
                <td class="tdc">4</td>
                <td>VI Loan</td>
                <td >{{ (int) $creditrecovery[0]->cumulative_poor_members_vi }}</td>
            </tr>
            <tr>
                <td class="tdc">5</td>
                <td>Other Loan</td>
                <td >{{ (int) $creditrecovery[0]->cumulative_poor_members_other }}
                </td>
            </tr>
            <tr>
                <td class="tdc">6</td>
                <td>Total</td>
                <td >{{ (int) $creditrecovery[0]->total_cumulative_poor_members }}
                </td>
            </tr>
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="8">Demand Collection Balance (DCB) for repayment and current Loan Outstanding</td>
            </tr>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th>DCB</th>
                <th class="tdc">Cluster  </th>
                <th class="tdc">Federation </th>
                <th class="tdc">Bank </th>
                <th class="tdc">VI </th>
                <th class="tdc">Other  </th>
                <th class="tdc">Summary Loan Portfolio </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tdc">i.</td>
                <td>Total Loan Amount Given (Rs.)</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_loan_amount }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_loan_amount }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->bank_loan_amount }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->vi_loan_amount }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->other_loan_amount }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_loan_amount + (int) $creditrecovery[0]->federation_loan_amount + (int) $creditrecovery[0]->bank_loan_amount + (int) $creditrecovery[0]->vi_loan_amount + (int) $creditrecovery[0]->other_loan_amount }}
                </td>
            </tr>
            <tr>
                <td class="tdc">ii.</td>
                <td>Total Demand upto last month for active loans</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->dcb_cluster }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->dcb_federation }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->dcb_bank }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->dcb_vi }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->dcb_other }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->dcb_cluster + (int) $creditrecovery[0]->dcb_federation + (int) $creditrecovery[0]->dcb_bank + (int) $creditrecovery[0]->dcb_vi + (int) $creditrecovery[0]->dcb_other }}
                </td>
            </tr>
            <tr>
                <td class="tdc">iii.</td>
                <td>Actual Amount Paid upto last month</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->repaid_cluster }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->repaid_federation }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->repaid_bank }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->repaid_vi }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->repaid_other }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->repaid_cluster + (int) $creditrecovery[0]->repaid_federation + (int) $creditrecovery[0]->repaid_bank + (int) $creditrecovery[0]->repaid_vi + (int) $creditrecovery[0]->repaid_other }}
                </td>
            </tr>
            <tr>
                <td class="tdc">iv.</td>
                <td>Overdue Amount</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_amount_cluster }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_amount_federation }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_amount_bank }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_amount_vi }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_amount_other }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_amount_cluster + (int) $creditrecovery[0]->overdue_amount_federation + (int) $creditrecovery[0]->overdue_amount_bank + (int) $creditrecovery[0]->overdue_amount_vi + (int) $creditrecovery[0]->overdue_amount_other }}
                </td>
            </tr>
            <tr>
                <td class="tdc">v.</td>
                <td>Outstanding amount for active loans</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->outstanding_amount_cluster }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->outstanding_amount_federation }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->outstanding_amount_bank }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->outstanding_amount_vi }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->outstanding_amount_other }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->outstanding_amount_cluster + (int) $creditrecovery[0]->outstanding_amount_federation + (int) $creditrecovery[0]->outstanding_amount_bank + (int) $creditrecovery[0]->outstanding_amount_vi + (int) $creditrecovery[0]->outstanding_amount_other }}
                </td>
            </tr>
            @php
            $num=0;
            if (!empty($creditrecovery[0]->cluster_repayment_rate)) {
                $num=$num +1;
            $a = (float) str_replace('%', '', $creditrecovery[0]->cluster_repayment_rate);
            } else {
            $a = 0;
            }
            if (!empty($creditrecovery[0]->federation_repayment_rate)) {
                $num=$num +1;
            $b = (float) str_replace('%', '', $creditrecovery[0]->federation_repayment_rate);
            } else {
            $b = 0;
            }
            if (!empty($creditrecovery[0]->bank_repayment_rate)) {
                $num=$num +1;
            $c = (float) str_replace('%', '', $creditrecovery[0]->bank_repayment_rate);
            } else {
            $c = 0;
            }
            if (!empty($creditrecovery[0]->vi_repayment_rate)) {
                $num=$num +1;
            $d = (float) str_replace('%', '', $creditrecovery[0]->vi_repayment_rate);
            } else {
            $d = 0;
            }
            if (!empty($creditrecovery[0]->other_repayment_rate)) {
                $num=$num +1;
            $e = (float) str_replace('%', '', $creditrecovery[0]->other_repayment_rate);
            } else {
            $e = 0;
            }
            if($num > 0)
            {
                $data = ($a + $b + $c + $d + $e) / $num;
                $g = number_format((float)$data, 2, '.', '');
            }
            else
            {$g=0;}
            @endphp
            <tr class="tdc">
                <td>vi.</td>
                <td>Repayment Ratio %</td>
                <td>{{ Checkper($creditrecovery[0]->cluster_repayment_rate)."%" }}</td>
                <td>{{ Checkper($creditrecovery[0]->federation_repayment_rate)."%" }}</td>
                <td>{{ Checkper($creditrecovery[0]->bank_repayment_rate)."%" }}</td>
                <td>{{ Checkper($creditrecovery[0]->vi_repayment_rate)."%" }}</td>
                <td>{{ Checkper($creditrecovery[0]->other_repayment_rate)."%" }}</td>
                <td>{{ $g . '%' }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 page-break" cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="7">No Of Members Not Received Even a Single Loan  During Last 3 Years</td>
            </tr>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th>Loan Type</th>
                <th colspan="4" class="tdc">Wealth Ranking</th>
                <th class="tdc">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr class="tdc">
                <td class="tdc">A</td>
                <th>Cluster Loan</th>
                <td>Poorest</td>
                <td>Poor</td>
                <td>Medium Poor</td>
                <td>Rich</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Last 12 months</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_poorest_members_not_received_cluster_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_poor_members_not_received_cluster_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_medium_members_not_received_cluster_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_rich_members_not_received_cluster_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_total_members_not_received_cluster_loan_year1 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>Year before last</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_poorest_members_not_received_cluster_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_poor_members_not_received_cluster_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_medium_members_not_received_cluster_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_rich_members_not_received_cluster_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_total_members_not_received_cluster_loan_year2 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>2 Years before last</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_poorest_members_not_received_cluster_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_poor_members_not_received_cluster_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_medium_members_not_received_cluster_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_rich_members_not_received_cluster_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_total_members_not_received_cluster_loan_year3 }}
                </td>
            </tr>

            <tr class="tdc">
                <td class="tdc">B</td>
                <th>Federation loan</th>
                <td>Poorest</td>
                <td>Poor</td>
                <td>Medium</td>
                <td>Rich</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Last 12 months</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_federation_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_federation_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_federation_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_federation_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_federation_loan_year1 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>Year before last</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_federation_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_federation_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_federation_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_federation_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_federation_loan_year2 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>2 Years before last</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_federation_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_federation_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_federation_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_federation_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_federation_loan_year3 }}
                </td>
            </tr>

            <tr class="tdc">
                <td class="tdc">C</td>
                <th>Bank loan</th>
                <td>Poorest</td>
                <td>Poor</td>
                <td>Medium</td>
                <td>Rich</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Last 12 months</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_bank_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_bank_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_bank_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_bank_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_bank_loan_year1 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>Year before last</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_bank_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_bank_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_bank_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_bank_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_bank_loan_year2 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>2 Years before last</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_bank_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_bank_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_bank_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_bank_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_bank_loan_year3 }}
                </td>
            </tr>

            <tr class="tdc">
                <td class="tdc">D</td>
                <th>VI Loan</th>
                <td>Poorest</td>
                <td>Poor</td>
                <td>Medium</td>
                <td>Rich</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Last 12 months</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_VI_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_VI_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_VI_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_VI_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_VI_loan_year1 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>Year before last</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_VI_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_VI_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_VI_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_VI_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_VI_loan_year2 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>2 Years before last</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_VI_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_VI_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_VI_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_VI_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_VI_loan_year3 }}
                </td>
            </tr>

            <tr class="tdc">
                <td class="tdc">E</td>
                <th>Other Loans</th>
                <td>Poorest</td>
                <td>Poor</td>
                <td>Medium</td>
                <td>Rich</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Last 12 months</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_other_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_other_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_other_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_other_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_other_loan_year1 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>Year before last</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_other_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_other_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_other_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_other_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_other_loan_year2 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>2 Years before last</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_other_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_poor_members_not_received_other_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_medium_members_not_received_other_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_rich_members_not_received_other_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_total_members_not_received_other_loan_year3 }}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Loan Default</td>
            </tr>
            <tr>
                <th width="4" class="tdc">S.No</th>
                <th>Name of Loan Insitution</th>
                <th class="tdc">No of Members</th>
                <th class="tdc">No of Loans</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tdc">A</td>
                <td>Cluster/Habitation</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_loan_default_member }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_loan_default_no }}</td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>Federation Loan</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_loan_default_member }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_loan_default_no }}</td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>Bank Loan</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->bank_loan_default_member }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->bank_loan_default_no }}</td>
            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>VI Loan</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->vi_loan_default_member }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->vi_loan_default_no }}</td>
            </tr>
            <tr>
                <td class="tdc">E</td>
                <td>Other Loan</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->other_loan_default_member }}</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->other_loan_default_no }}</td>
            </tr>
            <tr>
                <td></td>
                <td >Total</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->other_loan_default_member + (int) $creditrecovery[0]->vi_loan_default_member + (int) $creditrecovery[0]->bank_loan_default_member + (int) $creditrecovery[0]->federation_loan_default_member + (int) $creditrecovery[0]->cluster_loan_default_member }}
                </td>
                <td class="tdc">{{ (int) $creditrecovery[0]->other_loan_default_no + (int) $creditrecovery[0]->vi_loan_default_no + (int) $creditrecovery[0]->bank_loan_default_no + (int) $creditrecovery[0]->federation_loan_default_no + (int) $creditrecovery[0]->cluster_loan_default_no }}
                </td>
            </tr>
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">PAR Status More than 90 days in amount</td>
            </tr>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th>Loan type</th>
                <th class="tdc">Amount</th>
                <th class="tdc">Percentage</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tdc">A</td>
                <td>Cluster/Habitation</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_a }}</td>
                <td class="tdc">{{ Checkper((float) $creditrecovery[0]->cluster_loan_par) }}%</td>

            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>Federation Loan</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_b }}</td>
                <td class="tdc">{{ Checkper((float) $creditrecovery[0]->federation_loan_par) }}%</td>


            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>Bank Loan</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_c }}</td>
                <td class="tdc">{{ Checkper((float) $creditrecovery[0]->bank_loan_par) }}%</td>


            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>VI Loan</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_d }}</td>
                <td class="tdc">{{ Checkper((float) $creditrecovery[0]->vi_loan_par) }}%</td>

            </tr>
            <tr>
                <td class="tdc">E</td>
                <td>Other Loan</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_e }}</td>
                <td class="tdc">{{ Checkper((float) $creditrecovery[0]->other_loan_par) }}%</td>

            </tr>
            <tr>
                <td></td>
                <td>Total</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->overdue_a + (int) $creditrecovery[0]->overdue_b + (int) $creditrecovery[0]->overdue_c + (int) $creditrecovery[0]->overdue_d + (int) $creditrecovery[0]->overdue_e }}
                </td>
                <td class="tdc">{{ Checkper((float) $creditrecovery[0]->cluster_loan_par +(float) $creditrecovery[0]->federation_loan_par +(float) $creditrecovery[0]->bank_loan_par +(float) $creditrecovery[0]->vi_loan_par + (float) $creditrecovery[0]->other_loan_par)}}</td>
            </tr>
        </tbody>
    </table>
    <br>
    
    
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">Purpose of ALL Loans during last 12 months</td>
            </tr>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th>Purpose</th>
                <th class="tdc">All loans (Cluster and External)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tdc">A</td>
                <td>Productive</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->productive }}</td>

            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>Consumption</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->consumption }}</td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>Debt Swapping</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->debt_swapping }}</td>

            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>Other</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->other_Purposes }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Total</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->productive + (int) $creditrecovery[0]->consumption + (int) $creditrecovery[0]->debt_swapping + (int) $creditrecovery[0]->other_Purposes }}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Average Loan Amount during last 12 Months</td>
            </tr>
            <tr>
                <th>Average Loan Amount during last 12 Months</th>
                <td>{{ checkZero($creditrecovery[0]->average_loan_amount) }}</td>
                <th></th>
                <th></th>

            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Minimum and Maximum loan amounts during last 12 months</td>
            </tr>
            <tr>
                <th width="25%">Maximum Amount</th>
                <td width="25%" >{{ checkZero((int) $creditrecovery[0]->minimum_amount) }}</td>
                <th width="25%">Minimum Amount</th>
                <td width="25%" >{{ checkZero((int) $creditrecovery[0]->maximum_amount) }}</td>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Members Taken More Than One Loan During Last 3 Years</td>
            </tr>
            <tr>
                <th>Members Have Taken More Than One Loan During Last 3 Years</th>
                <td>{{ checkZero((int) $creditrecovery[0]->members_more_than_one) }}</td>
                <td></td>
                <td></td>

            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">Cumulative Interest Income </td>
            </tr>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th>Type of loan</th>
                <th class="tdc">Income Generated Amount</th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td class="tdc">A</td>
                <td >Cluster</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->cluster_cumulative_interest }}</td>

            </tr>
            <tr>
                <td class="tdc">B</td>
                <td >Federation</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->federation_cumulative_interest }}
                </td>

            </tr>
            <tr>
                <td class="tdc">C</td>
                <td >Bank</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->vi_cumulative_interest }}</td>

            </tr>
            <tr>
                <td class="tdc">D</td>
                <td >VI</td>
                <td class="tdc">{{ (int) $creditrecovery[0]->other_cumulative_interest }}</td>
            </tr>
           <tr>
            <td></td>
            <td>Total</td>
            <td class="tdc">{{ (int) $creditrecovery[0]->total_cumulative_interest }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <!-- Saving -->
    <table class="table table-bordered table-stripped table1 page-break" cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >SAVINGS</td>
            </tr>
        </thead>
    </table>
   <br>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Compulsory Savings</td>
            </tr>
        </thead>
        
        <tbody>
           
            
            <tr>
                <th width="25%">Compulsory Savings</th>
                <td width="25%">{{ checkZero($saving[0]->compulsory_savings) }}</td>
                <th width="25%">Amount of savings per month</th>
                <td width="25%">{{ checkZero($saving[0]->amount_of_compulsory) }}</td>
            </tr>
            
            <tr>
                <th>Average Monthly savings during last 12 months</th>
                <td>{{ checkZero($saving[0]->trend) }}</td>
                <th>Cumulative savings since inception</th>
                <td>{{ checkZero($saving[0]->compulsory_savings_inception) }}</td>
            </tr>

        </tbody>
        
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Voluntary Savings</td>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <th width="25%">Voluntary Savings</th>
                <td width="25%">{{ checkna(!empty($saving[0]->voluntary_savings)) }}</td>
                <th width="25%">Average Amount of Savings per month</th>
                <td width="25%">{{ checkZero(!empty($saving[0]->amount_of_voluntary)) }}</td>

            </tr>
            <tr>
                <th>Cumulative savings to-date since inception</th>
                <td>{{ checkZero( $saving[0]->voluntary_savings_inception) }}</td>
                <th>Date voluntary savings established</th>
                <td>{{ $saving[0]->date_voluntary_saving !='' ?  change_date_month_name_char(str_replace('/','-',$saving[0]->date_voluntary_saving)) : 'N/A'}}</td>
            </tr>
            
            <tr>
                <th>No of members contribute to voluntary savings</th>
                <td>{{ checkZero(!empty($saving[0]->no_of_shg_member)) }}</td>
                <th>Interest paid to members (Y/N)</th>
                <td>{{ checkZero(!empty($saving[0]->interest_paid)) }}</td>
            </tr>
           
            <tr>
                <th>Are savings redistributed to members (Y/N)</th>
                <td>{{ checkna(!empty($saving[0]->savings_redistributed)) }}</td>
                <th>Date of last Redistribution</th>
                <td>{{$saving[0]->date_last_distribution !='' ?  change_date_month_name_char(str_replace('/','-',$saving[0]->date_last_distribution )) :'N/A' }}</td>
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
                <th width="25%">Loan Security Fund (LSF)</th>
                <td width="25%">{{ checkna($saving[0]->loan_security_fund) }}</td>
                <th width="25%">Date it was established</th>
                <td width="25%">{{$saving[0]->date_established !='' ?  change_date_month_name_char(str_replace('/','-',$saving[0]->date_established )) :'N/A' }}</td>
            </tr>
            <tr>
                <th>Amount available in LSF</th>
                <td>{{ checkZero($saving[0]->amount_available) }}</td>
                <th>No of members contribute to LSF </th>
                <td>{{ checkZero($saving[0]->members) }}</td>
            </tr>
            <tr>
                
                <th>No of members benefitted from LSF</th>
                <td>{{ checkZero($saving[0]->members_benefitted) }}</td>
                <td></td>
                <td></td>

            </tr>
        </tbody>
        
    </table>
    <br>
    
    <!-- Challenges -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >CHALLENGES AND ACTION PLAN</td>
            </tr>
        </thead>
    </table>
    <br>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="2">Top Challenges</td>
            </tr>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th>Top Challenges</th>
            </tr>
        </thead>
        <tbody>
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
    <!-- Action Plan to address challenges -->
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">Action Plan</td>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <tbody width="100%">
            <tr>
                <th width="4%" class="tdc">S.No</th>
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
                <td class="tdc">{{ $key + 1 }}</td>
                <td>{{ $row['name'] }}</td>
                @if (!empty($row['action']))
                @foreach ($row['action'] as $val)
                <td>{{ $val }}</td>
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
        <thead>
            
            <tr style="background-color:#01a9ac">
                <th width="4%" class="tdc">S.No</th>
                <th>Questions</th>
                <th>Answers</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="tdc">A</th>
                <th>How many members attended the cluster meeting?</th>
                <td>{{ checkna($observation[0]->cluster_observation_meeting) }}</td>
            </tr>
            
            <tr>
                <th class="tdc">B</th>
                <th>Were all office bearers and leaders present? E.g chair, treasurer,
                    secretary, book-keeper, other,</th>
                    <td >
                        @if (!empty($observation))
                        @foreach ($observation as $row)
                        @php
                        $desg = [];
                        if ($row->cluster_observation_president == 1) {
                        $desg[] = 'President';
                        }
                        if ($row->cluster_observation_secretary == 1) {
                        $desg[] = 'Secretary';
                        }
                        if ($row->cluster_observation_bookkeeper == 1) {
                        $desg[] = 'Bookkeeeper';
                        }
                        if ($row->cluster_observation_treasure == 1) {
                        $desg[] = 'Treasure';
                        }
                        if ($row->cluster_observation_sub_commit == 1) {
                        $desg[] = 'Sub-commit Member';
                        }
                        if ($row->cluster_observation_other == 1) {
                        $desg[] = 'Other';
                        }
                        $strdesg = implode(',', $desg);
                        @endphp
                        {{ $strdesg }}
                        
                    </td>
                    @endforeach
                    @else
                    <td>N/A</td>
                     @endif

            </tr>
            
            


            <tr>
                <th class="tdc">2</th>
                <th>Did cluster leaders understand the Purpose of the meeting? Explain
                </th>
                <td>{{ checkna($observation[0]->cluster_observation_carried_out) }}</td>
            </tr>
           
            <tr>
                <th class="tdc">3</th>
                <th>What was quality of Discussion? Did everyone participate?</th>
                <td>{{ checkna($observation[0]->cluster_observation_leaders_only) }}</td>

            </tr>
            
            <tr>
                <td class="tdc">4</td>
                <th>Where cluster leaders aware of their rules and norms?</th>
                <td></td>
            </tr>
            <tr>
            <th class="tdc">A.</th>
            <th> Did they understand vision of their Cluster?</th>
            <td>{{ checkna($observation[0]->cluster_observation_Cluster) }}</td>
            </tr>
           
            <tr>
            
                <th class="tdc">B.</th>
                <th>Do they understand benefits of being part of the Cluster?</th>
                <td>{{ checkna($observation[0]->cluster_observation_benefits) }}</td>
                
            </tr>
            

            <tr>
                <th class="tdc">5</th>
                <th>Important practices followed by the group.</th>
                <td></td>
            </tr>

            <tr>
                <th class="tdc">A.</th>

                <th> Do they have a set of important practices for repayment and
                    savings?</th>
                <td >{{ checkna($observation[0]->cluster_observation_paid_time) }}</td>

            </tr>
           
            
            <tr>
                <td class="tdc">B.</td>
                <th> What are those practices?</th>
                <td>{{ checkna($observation[0]->cluster_observation_practices) }}</td>

            </tr>
            
            
            <tr>
                <th class="tdc">6</th>
                <th>What is Cluster’s policy on the most vulnerable members.</th>
                <td></td>
            </tr>
            <tr>
                <th class="tdc">A.</th>
                <th> Does this Cluster include members who are the most poor and
                    vulnerable, and if yes, </th>
                <td>{{ checkna($observation[0]->cluster_observation_provided_them) }}</td>

            </tr>
            
            <tr>
                <th class="tdc">B.</th>
                <th> what is their policy to help them</th>
                <td>{{ checkna($observation[0]->cluster_observation_policy_explain) }}
                </td>
            </tr>
            
            <tr>
                <th class="tdc">7</th>
                <th>Cluster’s Reporting and documentation</th>
                <td>
                </td>
            </tr>
            <tr>
                <th class="tdc">A.</th>
                <th> Does cluster have a satisfactory/weak or good system of reporting
                    and updating of documents?</th>
                <td>{{ checkna($observation[0]->cluster_observation_documents) }}</td>

            </tr>
            
            <tr>
                <td class="tdc">B.</td>
                <th>Who writes these books and minutes of meetings?</th>
                <td>{{ checkna($observation[0]->cluster_observation_minutes_meetings) }}</td>

            </tr>
            
            <tr>
                <th class="tdc">8</th>
                <th>Cluster’s financial information</th>
                <td></td>
            </tr>
            <tr>
                <th class="tdc">A.</th>
                <th>Are books of accounts managed by the booker only or are other office
                    bearers aware of their financial information
                </th>
                <td>{{ checkna($observation[0]->cluster_observation_updated_records) }}</td>
            </tr>
           
            <tr>
                <th class="tdc">B.</th>
                <th>Any highlights</th>
                <td>{{ checkna($observation[0]->cluster_observation_leaders_office) }}

            </tr>
            
            <tr>
                <th class="tdc">9</th>
                <th>Unique features of this Cluster</th>
                <td></td>
            </tr>
            <tr>
                <th class="tdc">A.</th>
                <th> Did you notice any unique features and practices that make it
                    special?</th>
                <td>{{ checkna($observation[0]->cluster_observation_special) }}</td>

            </tr>
            
            <tr>
                <th class="tdc">B.</th>
                <th> What are those special practices?</th>
                <td>{{ checkna($observation[0]->cluster_observation_support_groups) }}
                </td>
            </tr>
           
            <tr>
                <th class="tdc">10</th>
                <th>Summary of important 3- 5 highlights about this group? </th>
                <td>
                    <ul>
                        @if ($observation[0]->cluster_observation_highlights_a != '')
                        <li>{{ $observation[0]->cluster_observation_highlights_a }}</li>
                        @endif
                        @if ($observation[0]->cluster_observation_highlights_b != '')
                        <li>{{ $observation[0]->cluster_observation_highlights_b }}</li>
                        @endif
                        @if ($observation[0]->cluster_observation_highlights_c != '')
                        <li>{{ $observation[0]->cluster_observation_highlights_c }}</li>
                        @endif
                        @if ($observation[0]->cluster_observation_highlights_d != '')
                        <li>{{ $observation[0]->cluster_observation_highlights_d }}</li>
                        @endif
                        @if ($observation[0]->cluster_observation_highlights_e != '')
                        <li>{{ $observation[0]->cluster_observation_highlights_e }}</li>
                        @endif
                    </ul>
                </td>
            </tr>
           
        </tbody>
    </table>
    <br>

       {{-- Report Card--}}
   <table class="table table-bordered table-stripped table1 " cellspacing="0">
    <thead>
        <tr class="table-primary" >
            <td style="background-color:#01a9ac" colspan="4">Cluster Report Card </td>
        </tr>
    </thead>
    

</table>

<table class="table table-bordered table-stripped table1 " cellspacing="0">
    <thead class="back-color">
        <tr>
            <th width="450px">Cluster Indicators</th>
            <td colspan="4"></td>
            <th colspan="" style="text-align:center;"> Actual Score </th>
            <th colspan="" style="text-align:center;"> Expected Score</th>
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
                @if ($score >= 75 && $score <= 89) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="background-color: lightgrey;width:50px;">
                @if ($score >= 60 && $score <= 74) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="background-color: red;width:50px;">
                @if ($score <= 59) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="text-align: center;">{{ $total1 }}</td>
            <td style="text-align: center;">25</td>
            {{-- <td>{{$score}}</td> --}}
        </tr>
        <tr>
            <td>2 Inclusion</td>
            <td style="background-color: green;width:50px;">
                @if ($score1 >= 90)
                <span class="checkmark"></span>
                @endif
            </td>
            <td style="background-color: yellow;width:50px;">
                @if (round($score1) >= 75 && round($score1) <= 89) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="background-color: lightgrey;width:50px;">
                @if ($score1 >= 60 && $score1 <= 74) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="background-color: red;width:50px;">
                @if ($score1 <= 59) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="text-align: center;">{{ $total2 }}</td>
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
                @if ($score2 >= 75 && $score2 <= 89) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="background-color: lightgrey;width:50px;">
                @if ($score2 >= 60 && $score2 <= 74) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="background-color: red;width:50px;">
                @if ($score2 <= 59) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="text-align: center;">{{ $total3 }}</td>
            <td style="text-align: center;">15</td>
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
                @if ($score3 >= 75 && $score3 <= 89) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="background-color: lightgrey;width:50px;">
                @if ($score3 >= 60 && $score3 <= 74) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="background-color: red;width:50px;">
                @if ($score3 <= 59) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="text-align: center;">{{ $total4 }}</td>
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
                @if ($score4 >= 75 && $score4 <= 89) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="background-color: lightgrey;width:50px;">
                @if ($score4 >= 60 && $score4 <= 74) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="background-color: red;width:50px;">
                @if ($score4 <= 59) <span class="checkmark"></span>
                    @endif
            </td>
            <td style="text-align: center;">{{ $total5 }}</td>
            <td style="text-align: center;">15</td>
            {{-- <td>{{round($score4)}}</td> --}}
        </tr>
        <tr>
            @php
                if($grand_total  >=90)
                {
                   $color = 'green';
                }
                if($grand_total >= 75 && $grand_total <= 89)
                {
                   $color = 'yellow';
                }
                if($grand_total >= 60 && $grand_total <= 74)
                {
                   $color = 'lightgrey';
                }
                if($grand_total <= 59)
                {
                   $color = 'red';
                }
                
            @endphp
            <th width="450px">Total Score</th>
            <td colspan="4"></td>
            <td style="background-color:{{$color }};text-align:center;font-weight:bold;font-size:20px;">
                {{$grand_total }}</td>
                <td></td>

        </tr>

    </tbody>
</table>
</body>

</html>