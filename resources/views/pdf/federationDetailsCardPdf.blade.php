
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Federation Details</title>
</head>
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

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generate On- @php
        echo generated_date();
        @endphp
    </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Federation Profile({{$federation->uin}})</u>
            </h2>
        </div>

    </div>
    <!-- federeation profile -->
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
                <td width="25%" >{{ $profile[0]->name_of_federation }}</td>
                <th width="25%">UIN</th>
                <td width="25%" >{{ $federation->uin }}</td>
            </tr>
            <tr>
                <th width="25%">District</th>
                <td width="25%" >{{ $profile[0]->name_of_district }}</td>
                <th width="25%">State</th>
                <td width="25%" >{{ $profile[0]->name_of_state }}</td>
            </tr>
            <tr>
                <th width="25%">Country</th>
                <td width="25%" >{{ $profile[0]->name_of_country }}</td>
                <th width="25%">NRLM Code</th>
                <td width="25%">{{ $profile[0]->clf_code }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Legal Status</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Date of Registration</th>
                <td width="25%" >{{$profile[0]->date_federation_was_found !='' ? change_date_month_name_char(str_replace('/','-',$profile[0]->date_federation_was_found)) : 'N/A'}}</td>
                <th width="25%">Legal/Registered Status</th>
                <td width="25%" >{{ $profile[0]->legal_status !='' ? $profile[0]->legal_status : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Registration No</th>
                <td width="25%" >{{ (int) $profile[0]->registration_no !='' ? (int) $profile[0]->registration_no : 0  }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Membership</td>
            </tr>
        </thead>
        <tbody>
            <tr class="tdc">
                <th class="tdc" width="4%">S.No</th>
                <th >Membership</th>
                <th class="tdc">At the time of Creation/formation</th>
                <th class="tdc">Current Membership</th>
            </tr>
            <tr>
                <td class="tdc">A</td>
                <td >No of clusters/habitations</td>
                <td class="tdc">{{ (int) $profile[0]->clusters_at_time_creation !='' ? (int) $profile[0]->clusters_at_time_creation : 0 }}</td>
                <td class="tdc">{{ (int) $profile[0]->total_clusters !='' ? (int) $profile[0]->total_clusters : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td >No of SHGs</td>
                <td class="tdc">{{ (int) $profile[0]->shg_at_time_creation !='' ? (int) $profile[0]->shg_at_time_creation : 0 }}</td>
                <td class="tdc">{{ (int) $profile[0]->total_SHGs !='' ? (int) $profile[0]->total_SHGs : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td >No of members</td>
                <td class="tdc">{{ (int) $profile[0]->members_at_time_creation !='' ? (int) $profile[0]->members_at_time_creation : 0 }}</td>
                <td class="tdc">{{ (int) $profile[0]->total_members !='' ? (int) $profile[0]->total_members : 0  }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Current Leadership Status</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">President</th>
                <td width="25%" >{{ $profile[0]->president !='' ? $profile[0]->president : 'N/A'  }}</td>
                <th width="25%">Secretary</th>
                <td width="25%" >{{ $profile[0]->secretary !='' ? $profile[0]->secretary : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Treasurer</th>
                <td width="25%" >{{ $profile[0]->Treasurer !='' ? $profile[0]->Treasurer : 'N/A' }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
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
                <td width="25%" >{{ $profile[0]->book_keeper_name !='' ?   $profile[0]->book_keeper_name : 'N/A'}}</td>
                <th width="25%">Date of appointment</th>
                <td width="25%" >{{ $profile[0]->date_of_appointment !='' ? change_date_month_name_char(str_replace('/','-',$profile[0]->date_of_appointment)) : 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="2">Bank Account Details</td>
            </tr>
        </thead>
        <tbody>
            @if(!empty($profile_bank))
            @foreach ($profile_bank as $row)
            <tr>
                <th width="50%">Account head</th>
                <td width="50%" >{{ $row->account_head }}</td>
            </tr>
            <tr>
                <th width="50%">Account type</th>
                <td width="50%" >{{ $row->account_type }}</td>
            </tr>
            <tr>
                <th width="50%">Account opening date</th>
                <td width="50%" >{{ $row->account_opening_date !='' ? change_date_month_name_char(str_replace('/','-',$row->account_opening_date)) : 'N/A'}}</td>
            </tr>
            <tr>
                <th width="50%">Name of the bank</th>
                <td width="50%" >{{ $row->name_of_the_bank }}</td>
            </tr>
            <tr>
                <th width="50%">Name of Branch</th>
                <td width="50%" >{{ $row->branch }}</td>
            </tr>
            <tr>
                <th width="50%">Account no</th>
                <td width="50%" >{{ $row->account_number }}</td>
            </tr>
            <tr>
                <th width="50%">IFSC code</th>
                <td width="50%" >{{ $row->account_ifsc }}</td>
            </tr>
            <tr>
                <th width="50%">Is bank account in regular operation</th>
                <td width="50%" >{{ $row->updated }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <th width="50%">Account head</th>
                <td width="50%" >N/A</td>
            </tr>
            <tr>
                <th width="50%">Account type</th>
                <td width="50%" >N/A</td>
            </tr>
            <tr>
                <th width="50%">Account opening date</th>
                <td width="50%" >N/A</td>
            </tr>
            <tr>
                <th width="50%">Name of the bank</th>
                <td width="50%" >N/A</td>
            </tr>
            <tr>
                <th width="50%">Name of Branch</th>
                <td width="50%" >N/A</td>
            </tr>
            <tr>
                <th width="50%">Account no</th>
                <td width="50%" >N/A</td>
            </tr>
            <tr>
                <th width="50%">IFSC code</th>
                <td width="50%" >N/A</td>
            </tr>
            <tr>
                <th width="50%">Is bank account in regular operation</th>
                <td width="50%" >N/A</td>
            </tr>
            @endif
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
                <td style="background-color:#01a9ac" colspan="4">Adoption </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Adoption of Rules</th>
                <td width="25%" >{{ $governance[0]->adoption_of_rules !='' ? $governance[0]->adoption_of_rules  : 'N/A' }}</td>
                <th width="25%">Date of Adoption</th>
                <td width="25%" >{{$governance[0]->date_of_adoption !='' ?  change_date_month_name_char(str_replace('/','-',$governance[0]->date_of_adoption)) : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Written Rules</th>
                <td width="25%" >{{ $governance[0]->written_norms !='' ? $governance[0]->written_norms : 'N/A' }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
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
                <th width="25%">Election or Selection</th>
                <td width="25%" >{{ $governance[0]->frequency_election !='' ?  $governance[0]->frequency_election  : 'N/A' }}</td>
                <th width="25%">Frequency as per norms</th>
                <td width="25%" >{{ $governance[0]->frequency_as_per_norms !='' ?  $governance[0]->frequency_as_per_norms  : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">1st election date</th>
                <td width="25%">{{ $governance[0]->first_election_date !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->first_election_date )) : 'N/A' }}</td>
                <th width="25%">No of Elections conducted so far</th>
                <td width="25%" >{{ $governance[0]->no_of_elections_conducted_so_far !='' ?  $governance[0]->no_of_elections_conducted_so_far  : 0 }}</td>
                
            </tr>
            <tr>
                <th width="25%">Date of Last Election</th>
                <td width="25%" >{{ $governance[0]->date_of_last_election_option !='' ?  change_date_month_name_char(str_replace('/','-',$governance[0]->date_of_last_election_option )) : 'N/A' }}
                </td>
                <th width="25%">Last 3 elections conducted as per norms</th>
                <td width="25%">
                    <ul style="list-style:none;">
                        <li>1st : {{ $governance[0]->last_two_election_conducted }}</li>
                        <li>2st : {{ $governance[0]->last_two_election_conducted_2nd }}</li>
                        <li>3st : {{ $governance[0]->last_two_election_conducted_3rd }}</li>
                    </ul>
                </td>
                
            </tr>


        </tbody>
    </table>
    <br>
    <br>
    <br>
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
                <td width="25%" >{{ $governance[0]->frequency_of_meetings_on_a_monthly_basis !='' ? $governance[0]->frequency_of_meetings_on_a_monthly_basis : 'N/A' }}</td>
                <th width="25%">No of meetings conducted during last 12 months</th>
                <td width="25%" >{{ (int) $governance[0]->meetings_federation_last_six_months !='' ? (int) $governance[0]->meetings_federation_last_six_months : 0 }}</td>
            </tr>
            <tr>
                <th width="25%">Average Participation of Members during last 12 months</th>
                <td width="25%" >{{ (int) $governance[0]->participation_members_last_six_months !='' ? (int) $governance[0]->participation_members_last_six_months : 0 }}</td>
                <th width="25%">Total no of Board/EC members</th>
                <td width="25%" >{{ (int) $governance[0]->Total_board_members !='' ? (int) $governance[0]->Total_board_members : 0 }}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Status Of Minutes During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Status of Minutes of Board meetings recorded</th>
                <td width="25%" >{{ $governance[0]->minutes_of_group_meetings_recorded !='' ? $governance[0]->minutes_of_group_meetings_recorded : 'N/A' }}</td>
                <th width="25%">Who writes the minutes</th>
                <td width="25%" >{{ $governance[0]->who_writes_the_minutes !='' ? $governance[0]->who_writes_the_minutes : 'N/A' }}</td>
            </tr>
            



        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">General Assembly/Body Meeting</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">General Assembly/Body Meeting</th>
                <td width="25%" >{{$governance[0]->general_assembly !='' ? $governance[0]->general_assembly : 'N/A'}}</td>
                <th width="25%">Are members aware of there achievement</th>
                <td width="25%">{{ checkna($governance[0]->member_aware) }}</td>
            </tr>
            
            <tr>
                
                <th width="25%">Frequency</th>
                <td width="25%" >{{ $governance[0]->frequency_assembly_meetings !='' ? $governance[0]->frequency_assembly_meetings : 'N/A'  }}</td>
                <th width="25%">No of GA/GB members</th>
                <td width="25%" >{{ (int) $governance[0]->number_of_GA_members !='' ? (int) $governance[0]->number_of_GA_members : 0 }}</td>
            </tr>
            <tr>
                <th width="25%">No of meetings conducted during last 12 months</th>
                <td width="25%" >{{ (int) $governance[0]->federation_conducted_meetings !='' ? (int) $governance[0]->federation_conducted_meetings : 0 }}</td>
                <th width="25%">Date of last meeting</th>
                <td width="25%" >{{ $governance[0]->date_of_last_metting !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->date_of_last_metting)) : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Has last year annual plan and budget approved by GB</th>
                <td width="25%" >{{ $governance[0]->budget_approval_by_general_assembly !='' ? $governance[0]->budget_approval_by_general_assembly : 'N/A' }}</td>
                <th width="25%">Date of last plan and budget approval</th>
                <td width="25%" >{{ $governance[0]->date_of_last_budget_and_annual_approval !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->date_of_last_budget_and_annual_approval)) : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%" >Achievement of last year annual plan</th>
                
                <td width="25%">
                    <ul>
                        <li>i. Financial (Y/N), if yes specify</li>
                        <li>ii. Livelihood (Y/N), if yes, specify</li>
                        <li>iii. Social (Y/N), if yes, specify</li>
                        <li>iv. Convergence (Y/N), if yes, specify</li>
                        <li>v. Others (Y/N), if yes, specify</li>
                    </ul>
                </td>
                <td width="25%">
                    <ul>
                        <li>{{ $governance[0]->Annual_plan_Financial }} -
                            {{ $governance[0]->Annual_plan_Financial_specify }}
                        </li>
                        <li>{{ $governance[0]->Annual_plan_Livelihood }} -
                            {{ $governance[0]->Annual_plan_Livelihood_specify }}
                        </li>
                        <li>{{ $governance[0]->Annual_plan_Social }} -
                            {{ $governance[0]->Annual_plan_Social_specify }}
                        </li>
                        <li>{{ $governance[0]->Annual_plan_Convergence }}
                            -
                            {{ $governance[0]->Annual_plan_Convergence_specify }}
                        </li>
                        <li>{{ $governance[0]->Annual_plan_Others }} -
                            {{ $governance[0]->Annual_plan_Others_specify }}
                        </li>
                    </ul>
                </td>
                <td width="25%"></td>
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
                <td width="25%" >{{ $governance[0]->how_often_are_books_updated !='' ? $governance[0]->how_often_are_books_updated : 'N/A'  }}</td>
                <th width="25%">Date of last update</th>
                <td width="25%" >{{$governance[0]->date_of_last_updated_books !='' ?  change_date_month_name_char(str_replace('/','-',$governance[0]->date_of_last_updated_books)) : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Updated status</th>
                <td width="25%" >{{ $governance[0]->updated_status !='' ? $governance[0]->updated_status : 'N/A'  }}</td>
                <th width="25%"></th>
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
                <th width="50%">Grade of Federation </th>
                <td width="50%">{{ $governance[0]->grading_obtained !='' ? $governance[0]->grading_obtained : 'N/A' }}</td>
                <th width="50%"></th>
                <td width="50%"></td>
            </tr>

        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Social Audit Committee</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Formal of SAC (y/n)</th>
                <td width="25%" >{{ $governance[0]->federation_social_audit_committee !='' ?  $governance[0]->federation_social_audit_committee : 'N/A'  }}</td>
                <th width="25%">SAC formation date</th>
                <td width="25%" >{{ $governance[0]->when_was_the_SAC_created !='' ?  change_date_month_name_char(str_replace('/','-',$governance[0]->when_was_the_SAC_created)) :'N/A' }}</td> 
            </tr>
            <tr>
                <th width="25%">Whether SAC functioned during last 12 months (Y/N)</th>
                <td width="25%" >{{ $governance[0]->SAC_functioned !='' ? $governance[0]->SAC_functioned : 'N/A'}}</td>
                <th width="25%">Date of last report submitted by SAC to GN</th>
                <td width="25%" >{{ $governance[0]->date_last_report_submitted !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->date_last_report_submitted)) : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Issues highlighted by SAC (describe)</th>
                <td width="25%">
                    @if($governance[0]->issues_highlighted1 != '' || $governance[0]->issues_highlighted2 !='' || $governance[0]->issues_highlighted3 !='' ||  $governance[0]->issues_highlighted4 !='' || $governance[0]->issues_highlighted5 !='' )
                    <ul>@if($governance[0]->issues_highlighted1 != '')
                        <li>{{ $governance[0]->issues_highlighted1 }}</li>
                        @endif
                        @if($governance[0]->issues_highlighted2 !='')
                        <li>{{ $governance[0]->issues_highlighted2 }}</li>
                        @endif
                        @if($governance[0]->issues_highlighted3 != '')
                        <li>{{ $governance[0]->issues_highlighted3 }}</li>
                        @endif
                        @if($governance[0]->issues_highlighted4 != '')
                        <li>{{ $governance[0]->issues_highlighted4 }}</li>
                        @endif
                        @if($governance[0]->issues_highlighted5 != '')
                        <li>{{ $governance[0]->issues_highlighted5 }}</li>
                        @endif
                    </ul>
                    @else
                    N/A
                    @endif
                </td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>

        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Others Committees</td>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <th width="25%">Any other Committee formed</th>
                <td width="25%">{{ $governance[0]->any_other_committee_formed !='' ? $governance[0]->any_other_committee_formed : 'N/A'}}</td>
                <th width="25%">Names of subcommittee and purpose</th>
                <td width="25%">
                    @if ($governance[0]->any_other_committee_formed == 'Yes')
                    <ul>
                        
                        <li>1st - {{ $governance[0]->please_mention_names_of_committee }}</li>
                        
                        
                        <li>2st -{{ $governance[0]->please_mention_names_of_committee2 }}</li>
                        
                        
                        <li>3st -{{ $governance[0]->please_mention_names_of_committee3 }}</li>
                        
                    </ul> 
                    @else
                    N/A
                    @endif
                    
                </td>
                
            </tr>
            



        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Internal Audit</td>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th width="25%">Is Internal audit available (Y/N)</th>
                <td width="25%" >{{ $governance[0]->internal_audit !='' ? $governance[0]->internal_audit : 'N/A'  }}</td>
                <th width="25%">Frequency during last 12 months</th>
                <td width="25%" >{{ $governance[0]->frequency_internal_audit_conducted !='' ? $governance[0]->frequency_internal_audit_conducted  : 'N/A' }}</td>
                
            </tr>
            <tr>
                <th width="25%">Date of last internal</th>
                <td width="25%" >{{ $governance[0]->date_of_last_internal_audit !='' ? Change_date_month_name_char(str_replace('/','-',$governance[0]->date_of_last_internal_audit)) : 'N/A' }}</td>
                <th width="25%">No of highlighted issues
                    resolved by
                    federation</th>
                <td width="25%" >{{ $governance[0]->Highlighted_issues_addressed !='' ? $governance[0]->Highlighted_issues_addressed : 'N/A' }}</td>
            </tr>                
            
            <tr>
                <th width="25%">Issues and observations
                    raised during
                    last 12 months (Y/N)</th>
                <td width="25%" >{{ $governance[0]->Issues_highlighted_by_internal_audit }}</td>
                <th width="25%"></th>
                @if ($governance[0]->Issues_highlighted_by_internal_audit == 'Yes')
                <td width="25%">
                    
                    <ul>
                        @if ($governance[0]->internal_misappropriation_of_fund == '1')
                        <li>Misappropriation of fund</li>
                        @endif
                        @if ($governance[0]->internal_not_updation_of_books == '1')
                        <li>Not Updation of books of accounts</li>
                        @endif
                        @if ($governance[0]->internal_utilization == '1')
                        <li>Deviation of utilisation of loan</li>
                        @endif
                        @if ($governance[0]->internal_non_adherance == '1')
                        <li>Non internal_non_adherance of norms</li>
                        @endif
                        @if ($governance[0]->internal_others == '1')
                        <li>Other -{{ $governance[0]->Issues_highlighted_by_internal_audit_other }}</li>
                        @endif
                    </ul>
                    
                </td>
                @else
                <td></td>
                @endif
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
                <th width="25%">Is External audit available (Y/N)</th>
                <td width="25%" >{{ $governance[0]->external_audit !='' ? $governance[0]->external_audit : 'N/A'  }}</td>
                <th width="25%">Date of last external audit</th>
                <td width="25%" >{{ $governance[0]->date_external_audit_conducted !='' ? Change_date_month_name_char(str_replace('/','-',$governance[0]->date_external_audit_conducted)) : 'N/A' }}</td>
                
            </tr>
            <tr>
                <th width="25%">No of highlighted issues resolved by federation</th>
                <td width="25%" >{{ $governance[0]->issues_highlighted_resolved !='' ? $governance[0]->issues_highlighted_resolved : 'N/A' }}</td>
                <th width="25%">Issues and observations raised during last 12 months (Y/N)</th>
                <td width="25%" >{{ $governance[0]->issues_highlighted_external_audit !='' ? $governance[0]->issues_highlighted_external_audit : 'N/A' }}</td>
            </tr>
            @if ($governance[0]->issues_highlighted_external_audit == 'Yes')
            <tr>
                <th width="25%"></th>
                <td width="25%" ></td>
                <th width="25%"></th>
                <td width="25%">
                    
                    <ul>
                        @if ($governance[0]->external_misappropriation_of_fund == '1')
                        <li>Misappropriation of fund</li>
                        @endif
                        @if ($governance[0]->external_not_updation_of_books == '1')
                        <li>Not Updation of books of accounts</li>
                        @endif
                        @if ($governance[0]->external_utilization == '1')
                        <li>Deviation of utilisation of loan</li>
                        @endif
                        @if ($governance[0]->external_non_adherance == '1')
                        <li>Non internal_non_adherance of norms</li>
                        @endif
                        @if ($governance[0]->external_others == '1')
                        <li>Other -{{ $governance[0]->Issues_highlighted_by_internal_audit_other }}</li>
                        @endif
                    </ul>
                    
                </td>
            </tr>
            @endif
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="7">Training Details</td>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th class="tdc">S.No</th>
                <th class="tdc">Designation</th>
                <th class="tdc">Name of Training</th>
                <th class="tdc">Duration in days</th>
                <th class="tdc">Date</th>
                <th class="tdc">Name of Training Recipient</th>
                <th class="tdc">Name of Trainer</th>
            </tr>

            @if (!empty($governance_6))
            @foreach ($governance_6 as $row)
            @php 
            $i = 1;
            @endphp
            <tr>
                <td class="tdc">{{$i + 1 }}</td>
                <td>Current Leaders (president/treasurer/secretary and other)</td>
                <td class="tdc">{{ $row->training_name }}</td>
                <td class="tdc">{{ $row->duration }}</td>
                <td class="tdc">{{  change_date_month_name_char(str_replace('/','-',$row->date_training )) }}</td>
                <td>
                    @php
                    $desg = [];
                    if ($row->secretary == 1) {
                    $desg[] = 'Secretary';
                    }
                    if ($row->president == 1) {
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
                <td class="tdc">{{ $row->name }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="tdc">A</td>
                <td>Current Leaders (president/treasurer/secretary and other)</td>
                <td class="tdc">N/A</td>
                <td class="tdc">N/A</td>
                <td class="tdc">N/A</td>
                <td class="tdc">N/A</td>
                <td class="tdc">N/A</td>
            </tr>
            @endif

            @if (!empty($governance_7))
            @foreach ($governance_7 as $row)
            <tr>
                <td class="tdc">B</td>
                <td>SAC members</td>
                <td class="tdc">{{ $row->training_name }}</td>
                <td class="tdc">{{ $row->duration }}</td>
                <td class="tdc">{{ change_date_month_name_char(str_replace('/','-',$row->date_training )) }}</td>
                <td>
                    @php
                    $desg = [];
                    if ($row->secretary == 1) {
                    $desg[] = 'Secretary';
                    }
                    if ($row->president == 1) {
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
                <td class="tdc">{{ $row->name }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="tdc">B</td>
                <td>SAC members</td>
                <td class="tdc">N/A</td>
                <td class="tdc">N/A</td>
                <td class="tdc">N/A</td>
                <td class="tdc">N/A</td>
                <td class="tdc">N/A</td>
            </tr>
         @endif


            @if (!empty($governance_8))
            @foreach ($governance_8 as $row)
            <tr>
                <td class="tdc">C</td>
                <td>Book-keeper</td>
                <td class="tdc">{{ $row->training_name }}</td>
                <td class="tdc">{{ $row->duration }}</td>
                <td class="tdc">{{ change_date_month_name_char(str_replace('/','-',$row->date_training )) }}</td>
                <td>
                    @php
                    $desg = [];
                    if ($row->secretary == 1) {
                    $desg[] = 'Secretary';
                    }
                    if ($row->president == 1) {
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
                <td class="tdc">{{ $row->name }}</td>
            </tr>
            @endforeach
            @else
                    <tr>
                        <td class="tdc">C</td>
                        <td>Book-keeper</td>
                        <td class="tdc">N/A</td>
                        <td class="tdc">N/A</td>
                        <td class="tdc">N/A</td>
                        <td class="tdc">N/A</td>
                        <td class="tdc">N/A</td>
                    </tr>
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
                <th width="25%">Total SHGs formed in federation</th>
                <td width="25%" >{{ (int) $governance[0]->Total_SHGs_formed !='' ? (int) $governance[0]->Total_SHGs_formed : 0 }}</td>
                <th width="25%">Current defunct SHGs</th>
                <td width="25%" >{{ $governance[0]->present_no_of_SHGs_defunct !='' ? $governance[0]->present_no_of_SHGs_defunct : 0 }}</td>
            </tr>
            <tr>
                <th width="25%">Defunct SHGs (%)</th>
                <td width="25%" >{{ $governance[0]->Defunct_SHGs !='' ? $governance[0]->Defunct_SHGs : 0 }}</td>
                <th width="25%">Reasons for defunct (explain)</th>
                <td width="25%" >{{ $governance[0]->Defunct_SHGs_reasons !='' ? $governance[0]->Defunct_SHGs_reasons : 'N/A' }}</td>
            </tr>

        </tbody>

    </table>
    <br>
    <!-- Inclusion -->
    <table class="table table-bordered table-stripped table1 page-break" cellspacing="0">
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
                <td style="background-color:#01a9ac" colspan="4">Wealth Ranking/Poverty Mapping </td>
            </tr>   
        </thead>
        <tbody>
            
            <tr>
                <th width="25%">Wealth Ranking/Poverty Mapping</th>
                <td width="25%">{{ $inclusion[0]->wealth_ranking_mapping !='' ? $inclusion[0]->wealth_ranking_mapping : 'N/A'  }}</td>
                <th width="25%">Date of 1st poverty mapping</th>
                <td width="25%" >{{$inclusion[0]->month_year_of_1st_poverty_mapping !='' ? change_date_month_name_char(str_replace('/','-',$inclusion[0]->month_year_of_1st_poverty_mapping)) : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Date of last update</th>
                <td width="25%" >{{$inclusion[0]->month_year_of_last_update !='' ? change_date_month_name_char(str_replace('/','-',$inclusion[0]->month_year_of_last_update)) : 'N/A' }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
            
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="5">Last Poverty Mapping Results</td>
            </tr>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th >Poverty Mappint</th>
                <th class="tdc">Ineligible to get mobilized into SHG</th>
                <th class="tdc">HHs organized into SHGs</th>
                <th class="tdc">Total HHs member</th>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <td class="tdc">A</td>
                <td >Poorest and vulnerable</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_poorest_and_most_vulnerable !='' ? (int) $inclusion[0]->no_of_poorest_and_most_vulnerable : 0 }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_poorest_and_most_vulnerable_mobilised !='' ? (int) $inclusion[0]->no_of_poorest_and_most_vulnerable_mobilised : 0 }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_poorest_and_most_vulnerable_hhm !='' ? (int) $inclusion[0]->no_of_poorest_and_most_vulnerable_hhm : 0 }}
                </td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td >Poor</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_poor_category !='' ? (int) $inclusion[0]->no_of_poor_category : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_poor_category_mobilised !='' ? (int) $inclusion[0]->no_of_poor_category_mobilised : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_poor_category_hhm !='' ? (int) $inclusion[0]->no_of_poor_category_hhm : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td >Medium poor</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_medium_poor !='' ? (int) $inclusion[0]->no_of_medium_poor : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_medium_poor_mobilised !='' ? (int) $inclusion[0]->no_of_medium_poor_mobilised : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_medium_poor_hhm !='' ? (int) $inclusion[0]->no_of_medium_poor_hhm: 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">D</td>
                <td >Rich</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_rich !='' ? (int) $inclusion[0]->no_of_rich : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_rich_mobilised !='' ? (int) $inclusion[0]->no_of_rich_mobilised : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->no_of_rich_hhm !='' ? (int) $inclusion[0]->no_of_rich_hhm : 0 }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Total</td>
                <td class="tdc">{{ (int) $inclusion[0]->total_poverty_mapping_ineligible_mobilised !='' ? (int) $inclusion[0]->total_poverty_mapping_ineligible_mobilised : 0 }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->total_poverty_mapping_mobilised_member !='' ? (int) $inclusion[0]->total_poverty_mapping_mobilised_member : 0 }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->total_poverty_mapping_households !='' ? (int) $inclusion[0]->total_poverty_mapping_households : 0 }}</td>
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
                <td width="25%" >{{ (int) $inclusion[0]->no_of_SC_and_ST !='' ? (int) $inclusion[0]->no_of_SC_and_ST : 0 }}</td>
                <th width="25%">No of OBC</th>
                <td width="25%" >{{ (int) $inclusion[0]->no_of_OBC !='' ? (int) $inclusion[0]->no_of_OBC : 0 }}</td>
            </tr>
            <tr>
                <th width="25%">No of others</th>
                <td width="25%" >{{ (int) $inclusion[0]->no_of_others !='' ? (int) $inclusion[0]->no_of_others : 0 }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="9">No Of Loans Disbursed Under Each  Category</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Category</th>
                <th class="table_th tdc" colspan="2">Federation Loans </th>
                <th class="table_th tdc" colspan="2">External Loans </th>
                <th class="table_th tdc" colspan="2">VI Loans </th>
                <th class="table_th tdc" colspan="2">Total Loans </th>
            </tr>

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
            </tr>
            <tr>
                <td>Very Poor &amp; vulnerable</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category !='' ? (int) $inclusion[0]->federation_poorest_category : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category_amount !='' ? (int) $inclusion[0]->federation_poorest_category_amount : 0 }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->external_poorest_category  !='' ? (int) $inclusion[0]->external_poorest_category : 0  }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_poorest_category_amount !='' ? (int) $inclusion[0]->external_poorest_category_amount : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_poorest_category  !='' ? (int) $inclusion[0]->vi_poorest_category : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_poorest_category_amount !='' ? (int) $inclusion[0]->vi_poorest_category_amount : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category + (int) $inclusion[0]->external_poorest_category + (int) $inclusion[0]->vi_poorest_category }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category_amount + (int) $inclusion[0]->external_poorest_category_amount + (int) $inclusion[0]->vi_poorest_category_amount }}
                </td>

            </tr>
            <tr>
                <td>Poor</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poor_category !='' ? (int) $inclusion[0]->federation_poor_category : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poor_category_amount !='' ? (int) $inclusion[0]->federation_poor_category_amount : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_poor_category  !='' ? (int) $inclusion[0]->external_poor_category : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_poor_category_amount !='' ? (int) $inclusion[0]->external_poor_category_amount : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_poor_category  !='' ? (int) $inclusion[0]->vi_poor_category : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_poor_category_amount  !='' ? (int) $inclusion[0]->vi_poor_category_amount : 0  }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poor_category + (int) $inclusion[0]->external_poor_category + (int) $inclusion[0]->vi_poor_category }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poor_category_amount + (int) $inclusion[0]->external_poor_category_amount + (int) $inclusion[0]->vi_poor_category_amount }}
                </td>
            </tr>
            <tr>
                <td>Medium poor</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_medium !='' ? (int) $inclusion[0]->federation_medium : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_medium_amount !='' ? (int) $inclusion[0]->federation_medium_amount : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_medium !='' ? (int) $inclusion[0]->external_medium : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_medium_amount !='' ? (int) $inclusion[0]->external_medium_amount : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_medium !='' ? (int) $inclusion[0]->vi_medium : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_medium_amount !='' ? (int) $inclusion[0]->vi_medium_amount : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_medium + (int) $inclusion[0]->external_medium + (int) $inclusion[0]->vi_medium }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_medium_amount + (int) $inclusion[0]->external_medium_amount + (int) $inclusion[0]->vi_medium_amount }}
                </td>
            </tr>
            <tr>
                <td>Rich</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_rich !='' ? (int) $inclusion[0]->federation_rich : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_rich_amount !='' ? (int) $inclusion[0]->federation_rich_amount : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_rich !='' ? (int) $inclusion[0]->external_rich : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_rich_amount !='' ? (int) $inclusion[0]->external_rich_amount : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_rich !='' ? (int) $inclusion[0]->vi_rich : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_rich_amount !='' ? (int) $inclusion[0]->vi_rich_amount : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_rich + (int) $inclusion[0]->external_rich + (int) $inclusion[0]->vi_rich }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_rich_amount + (int) $inclusion[0]->external_rich_amount + (int) $inclusion[0]->vi_rich_amount }}
                </td>

            </tr>
            <tr>
                <td>Total</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category + (int) $inclusion[0]->federation_poor_category + (int) $inclusion[0]->federation_medium + (int) $inclusion[0]->federation_rich }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category_amount + (int) $inclusion[0]->federation_poor_category_amount + (int) $inclusion[0]->federation_medium_amount + (int) $inclusion[0]->federation_rich_amount }}
                </td>

                <td class="tdc">{{ (int) $inclusion[0]->external_poorest_category + (int) $inclusion[0]->external_poor_category + (int) $inclusion[0]->external_medium + (int) $inclusion[0]->external_rich }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->external_poorest_category_amount + (int) $inclusion[0]->external_poor_category_amount + (int) $inclusion[0]->external_medium_amount + (int) $inclusion[0]->external_rich_amount }}
                </td>

                <td class="tdc">{{ (int) $inclusion[0]->vi_poorest_category + (int) $inclusion[0]->vi_poor_category + (int) $inclusion[0]->vi_medium + (int) $inclusion[0]->vi_rich }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_poorest_category_amount + (int) $inclusion[0]->vi_poor_category_amount + (int) $inclusion[0]->vi_medium_amount + (int) $inclusion[0]->vi_rich_amount }}
                </td>

                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category + (int) $inclusion[0]->external_poorest_category + (int) $inclusion[0]->vi_poorest_category + (int) $inclusion[0]->federation_poor_category + (int) $inclusion[0]->external_poor_category + (int) $inclusion[0]->vi_poor_category + (int) $inclusion[0]->federation_rich + (int) $inclusion[0]->external_rich + (int) $inclusion[0]->vi_rich + (int) $inclusion[0]->federation_medium + (int) $inclusion[0]->external_medium + (int) $inclusion[0]->vi_medium }}
                </td>

                <td class="tdc">{{ (int) $inclusion[0]->federation_rich_amount + (int) $inclusion[0]->external_rich_amount + (int) $inclusion[0]->vi_rich_amount + (int) $inclusion[0]->federation_poorest_category_amount + (int) $inclusion[0]->external_poorest_category_amount + (int) $inclusion[0]->vi_poorest_category_amount + (int) $inclusion[0]->federation_poor_category_amount + (int) $inclusion[0]->external_poor_category_amount + (int) $inclusion[0]->vi_poor_category_amount + (int) $inclusion[0]->federation_medium_amount + (int) $inclusion[0]->external_medium_amount + (int) $inclusion[0]->vi_medium_amount }}
                </td>


        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="5">No.  HHs Benefitted From All Loans During Last 3 Years</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th rowspan="2" >Category</th>
                <th rowspan="2" class="tdc">Total member HHs (#) </th>
                <th colspan="3" class="tdc">Received Loan (#)</th>
            </tr>
            <tr>
                <th class="tdc">Federation Loan </th>
                <th class="tdc">External loan </th>
                <th class="tdc">VI Loan </th>
            </tr>
            <tr>
                <td>Very Poor &amp; vulnerable</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category_hhs !='' ? (int) $inclusion[0]->federation_poorest_category_hhs : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category_recloan !='' ? (int) $inclusion[0]->federation_poorest_category_recloan : 0 }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->external_poorest_category_recloan !='' ? (int) $inclusion[0]->external_poorest_category_recloan : 0 }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_poorest_category_recloan !='' ? (int) $inclusion[0]->vi_poorest_category_recloan : 0 }}</td>
            </tr>
            <tr>
                <td>Poor</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poor_category_hhs !='' ? (int) $inclusion[0]->federation_poor_category_hhs : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poor_category_recloan !='' ? (int) $inclusion[0]->federation_poor_category_recloan : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_poor_category_recloan !='' ? (int) $inclusion[0]->external_poor_category_recloan : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_poor_category_recloan !='' ? (int) $inclusion[0]->vi_poor_category_recloan : 0 }}</td>
            </tr>
            <tr>
                <td>Medium</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_medium_hhs !='' ? (int) $inclusion[0]->federation_medium_hhs : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_medium_recloan !='' ? (int) $inclusion[0]->federation_medium_recloan : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_medium_recloan !='' ? (int) $inclusion[0]->external_medium_recloan : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_medium_recloan !='' ? (int) $inclusion[0]->vi_medium_recloan : 0 }}</td>
            </tr>
            <tr>
                <td>Rich</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_rich_hhs !='' ? (int) $inclusion[0]->federation_rich_hhs :  0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_rich_recloan !='' ? (int) $inclusion[0]->federation_rich_recloan : 0  }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->external_rich_recloan !='' ? (int) $inclusion[0]->external_rich_recloan : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_rich_recloan !='' ? (int) $inclusion[0]->vi_rich_recloan : 0 }}</td>

            </tr>
            <tr>
                <td>Total</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category_hhs + (int) $inclusion[0]->federation_poor_category_hhs + (int) $inclusion[0]->federation_medium_hhs + (int) $inclusion[0]->federation_rich_hhs }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_poorest_category_recloan + (int) $inclusion[0]->federation_poor_category_recloan + (int) $inclusion[0]->federation_medium_recloan + (int) $inclusion[0]->federation_rich_recloan }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->external_poorest_category_recloan + (int) $inclusion[0]->external_poor_category_recloan + (int) $inclusion[0]->external_medium_recloan + (int) $inclusion[0]->external_rich_recloan }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->vi_poorest_category_recloan + (int) $inclusion[0]->vi_poor_category_recloan + (int) $inclusion[0]->vi_medium_recloan + (int) $inclusion[0]->vi_rich_recloan }}
                </td >

                
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Board And Office Bearer Membership </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <td width="32%"></td>
                <th width="32%" class="tdc">Board membership</th>
                <th width="32%" class="tdc">Office bearers/leaders</th>
            </tr>

            <tr>
                <td class="tdc">A</td>
                <td>Total Members</td>
                <td class="tdc">{{ (int) $inclusion[0]->total_board_members_cluster !='' ?(int) $inclusion[0]->total_board_members_cluster : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_inclusion_poor_members + (int) $inclusion[0]->federation_inclusion_poor1_members + (int) $inclusion[0]->federation_inclusion_rich_members }}
                </td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>No of members from the poorest and vulberale</td>
                <td class="tdc">{{ (int) $inclusion[0]->members_from_poorest_category !='' ? (int) $inclusion[0]->members_from_poorest_category : 0}}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_inclusion_poor_members !='' ? (int) $inclusion[0]->federation_inclusion_poor_members : 0 }}
                </td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>No of members from the poor</td>
                <td class="tdc">{{ (int) $inclusion[0]->members_from_poor_category !='' ? (int) $inclusion[0]->members_from_poor_category : 0 }}</td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_inclusion_poor1_members !='' ? (int) $inclusion[0]->federation_inclusion_poor1_members : 0 }}
                </td>
            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>No of members from middle and rich category</td>
                <td class="tdc">{{ (int) $inclusion[0]->members_from_middle_and_rich_category !='' ? (int) $inclusion[0]->members_from_middle_and_rich_category : 0 }}
                </td>
                <td class="tdc">{{ (int) $inclusion[0]->federation_inclusion_rich_members !='' ? (int) $inclusion[0]->federation_inclusion_rich_members : 0 }}
                </td>
            </tr>

        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" >Special Goals OF The Federation For Current Year </td>
            </tr>
        </thead>
        <tbody>
            @if($inclusion[0]->federation_social_goal_a != '')
            <tr>
            <td>{{ $inclusion[0]->federation_social_goal_a }}</td>
            </tr>
            @endif
            @if($inclusion[0]->federation_social_goal_b != '')
            <tr>
             <td>{{ $inclusion[0]->federation_social_goal_b }}</td>
            </tr>
            @endif
            @if($inclusion[0]->federation_social_goal_c != '')
            <tr>
            <td>{{ $inclusion[0]->federation_social_goal_c }}</td>
            </tr>
            @endif   
            
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
                <td style="background-color:#01a9ac" colspan="4">Integrated Credit Plan</td>
            </tr>
        <tbody>
            <tr>
                <th width="25%">Has Federation Prepared integrated credit plan </th>
                <td width="25%" >{{ $efficiency[0]->integrated_Federation_plan !='' ? $efficiency[0]->integrated_Federation_plan : 'N/A' }}</td>
                <th width="25%">Date of last plan approved by Federation</th>
                <td width="25%" >{{ $efficiency[0]->date_federation_plan_approved !='' ?  change_date_month_name_char(str_replace('/','-',$efficiency[0]->date_federation_plan_approved)) : 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%">Date it was submitted to Partner</th>
                <td width="25%" >{{  $efficiency[0]->date_federation_plan_submitted !='' ?   change_date_month_name_char(str_replace('/','-',$efficiency[0]->date_federation_plan_submitted)) : 'N/A'}}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Approval Process</td>
            </tr>
        <tbody>
            <tr>
                <th width="25%">No of days taken to approve loan application </th>
                <td width="25%" >{{ (int) $efficiency[0]->time_taken_to_approve_loan !='' ?(int) $efficiency[0]->time_taken_to_approve_loan : 0 }}</td>
                <th width="25%">Average Monthly loans during last 12 months </th>
                <td width="25%" >{{ (int) $efficiency[0]->loans_per_month_approved !='' ? (int) $efficiency[0]->loans_per_month_approved : 0 }}</td>
            </tr>
            <tr>
                <th width="25%">Time taken from approval to cash in hand </th>
                <td width="25%" >{{ (int) $efficiency[0]->time_taken_to_give_money_from_approval !='' ? (int) $efficiency[0]->time_taken_to_give_money_from_approval : 0 }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">New Members Mobilized During Last 12 Months</td>
            </tr>
        <tbody>
            <tr>
                <th width="25%">How many new members mobilized during last 12 months</th>
                <th width="25%">{{ (int) $efficiency[0]->members_mobilized !='' ? (int) $efficiency[0]->members_mobilized : 0 }}</th>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>

        </tbody>
        </thead>
    </table>
    <br>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Cost Ratio Per client</td>
            </tr>
        <tbody>
            <tr>
                <th width="25%">Cost per Client</th>
                <td width="25%" >{{ $efficiency[0]->cost_ratio_per_active_client !='' ? $efficiency[0]->cost_ratio_per_active_client : 0 }}</td>
                <th width="25%">Average operating expense</th>
                <td width="25%" >{{ $efficiency[0]->operating_expenes !='' ? $efficiency[0]->operating_expenes : 0 }}</td>

            </tr>
            <tr>
                <th width="25%">Average no of clients</th>
                <td width="25%" >{{ $efficiency[0]->average_no !='' ? $efficiency[0]->average_no : 0 }}</td>
                <th width="25%"></th>
                <td width="25%"></td>

            </tr>

        </tbody>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="5">Operation Expense Ratio</td>
            </tr>
        <tbody>
            <tr>
                <th width="25%">Operation Expense Ratio</th>
                <td width="25%" >{{ $efficiency[0]->federation_operation_expense_ratio !='' ? $efficiency[0]->federation_operation_expense_ratio : 0 }}</td>
                <th width="25%">Average operating expense</th>
                <td width="25%" >{{ $efficiency[0]->operating_expenes !='' ? $efficiency[0]->operating_expenes : 0 }}</td>

            </tr>
            <tr>
                <th width="25%">Average gross portfolio</th>
                <td width="25%" >{{ $efficiency[0]->avg_gross_portfolio !='' ? $efficiency[0]->avg_gross_portfolio : 0 }}</td>
                <th width="25%"></th>
                <td width="25%"></td>

            </tr>

        </tbody>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="5">Cost Income Ratio For Last 3 Years</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th>Time-period</th>
                <th class="tdc">Cost Income Ratio (%)</th>
                <th class="tdc">Operating Income </th>
                <th class="tdc">Operating Expense </th>
            </tr>

            <tr>
                <td class="tdc">1</td>
                <td>Last 12 Months</td>
                <td class="tdc">{{ $efficiency[0]->cost_income_ratio_year1 !='' ? $efficiency[0]->cost_income_ratio_year1 : 0 }}</td>
                <td class="tdc">{{ $efficiency[0]->operating_income_year1 !='' ? $efficiency[0]->operating_income_year1 : 0}}</td>
                <td class="tdc">{{ $efficiency[0]->operating_expenses_year1 !='' ? $efficiency[0]->operating_expenses_year1 : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">2</td>
                <td>1 Year before last year</td>
                <td class="tdc">{{ $efficiency[0]->cost_income_ratio_year2 !='' ? $efficiency[0]->cost_income_ratio_year2 : 0 }}</td>
                <td class="tdc">{{ $efficiency[0]->operating_income_year2 !='' ? $efficiency[0]->operating_income_year2 : 0 }}</td>
                <td class="tdc">{{ $efficiency[0]->operating_expenses_year2 !='' ? $efficiency[0]->operating_expenses_year2 : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">3</td>
                <td>2 years before last year</td>
                <td class="tdc">{{ $efficiency[0]->cost_income_ratio_year3 !='' ? $efficiency[0]->cost_income_ratio_year3 : 0 }}</td>
                <td class="tdc">{{ $efficiency[0]->operating_income_year3 !='' ? $efficiency[0]->operating_income_year3 : 0 }}</td>
                <td class="tdc">{{ $efficiency[0]->operating_expenses_year3 !='' ? $efficiency[0]->operating_expenses_year3 : 0 }}</td>
            </tr>
        </tbody>

        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1  " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="5">Average Outstanding Loan Size And Active Borrowers During Last 3 Years</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="tdc" width="4%">S.No</th>
                <th >Time-period</th>
                <th class="tdc">Average Outstanding loan size</th>
                <th class="tdc">Loan outstanding Amount </th>
                <th class="tdc">Active Borrowers </th>
            </tr>


            <tr>
                <td class="tdc">1</td>
                <td>Last 12 Months</td>
                <td class="tdc">{{ (float)$efficiency[0]->outstanding_loan_ratio_year1 !='' ? (float)$efficiency[0]->outstanding_loan_ratio_year1 : 0 }}</td>
                <td class="tdc">{{ $efficiency[0]->outstanding_loan_year1 !='' ? $efficiency[0]->outstanding_loan_year1 : 0 }}</td>
                <td class="tdc">{{ $efficiency[0]->active_borrower_year1 !='' ? $efficiency[0]->active_borrower_year1 : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">2</td>
                <td>1 Year before last year</td>
                <td class="tdc">{{ (float)$efficiency[0]->outstanding_loan_ratio_year2 !='' ? (float)$efficiency[0]->outstanding_loan_ratio_year2 : 0 }}</td>
                <td class="tdc">{{ $efficiency[0]->outstanding_loan_year2 !='' ? $efficiency[0]->outstanding_loan_year2 : 0 }}</td>
                <td class="tdc">{{ $efficiency[0]->active_borrower_year2 !='' ? $efficiency[0]->active_borrower_year2 : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">3</td>
                <td>2 years before last year</td>
                <td class="tdc">{{ (float)$efficiency[0]->outstanding_loan_ratio_year3 !='' ? (float)$efficiency[0]->outstanding_loan_ratio_year3 : 0 }}</td>
                <td class="tdc">{{ $efficiency[0]->outstanding_loan_year3 !='' ? $efficiency[0]->outstanding_loan_year3 : 0 }}</td>
                <td class="tdc">{{ $efficiency[0]->active_borrower_year3 !='' ?  $efficiency[0]->active_borrower_year3 : 0 }}</td>
            </tr>

        </tbody>

        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Monthly Progress Reports</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Does it prepare a report ?</th>
                <td width="25%" >{{ $efficiency[0]->integrated_credit_plan_approved !='' ? $efficiency[0]->integrated_credit_plan_approved : 'N/A' }}</td>
                <th width="25%">Last report submitted</th>
                <td width="25%" >
                    
                    {{$efficiency[0]->date_last_report_submitted !='' ? change_date_month_name_char(str_replace('/','-',$efficiency[0]->date_last_report_submitted)) : 0 }}
                    
                </td>
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
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">Loan Approvals During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th >Details</th>
                <th class="tdc">Answer</th>
            </tr>

            <tr>
                <td class="tdc">1</td>
                <td>No of loan applications received </td>
                <td class="tdc">{{ $credithistory[0]->applications_received_for_loans !='' ? $credithistory[0]->applications_received_for_loans : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">2</td>
                <td>No of loan applications approved</td>
                <td class="tdc">{{ (int) $credithistory[0]->no_of_loans_approved !='' ? (int) $credithistory[0]->no_of_loans_approved : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">3</td>
                <td>Pending loan applications</td>
                <td class="tdc">{{ (int) $credithistory[0]->pending_loan_applications !='' ? (int) $credithistory[0]->pending_loan_applications : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">4</td>
                <td>No of Loans Approved within 15 days</td>
                <td class="tdc">{{ (int) $credithistory[0]->no_of_loans_approved_within_15_days !='' ? (int) $credithistory[0]->no_of_loans_approved_within_15_days : 0 }}
                </td>
            </tr>
            <tr>
                <td class="tdc">5</td>
                <td>No of loans approved within 16 to 30 days</td>
                <td class="tdc">{{ (int) $credithistory[0]->no_of_loans_sanctioned_within_15_days !='' ? (int) $credithistory[0]->no_of_loans_sanctioned_within_15_days : 0 }}
                </td>
            </tr>
            <tr>
                <td class="tdc">6</td>
                <td>No of loans approved in more than 30 days</td>
                <td class="tdc">{{ (int) $credithistory[0]->no_of_loans_sanctioned_between_1_3_months !='' ? (int) $credithistory[0]->no_of_loans_sanctioned_between_1_3_months : 0 }}
                </td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">Cumulative Loan Amount  </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th >Institution</th>
                <th class="tdc">Amount (Rs)</th>
            </tr>


            <tr>
                <td class="tdc">1</td>
                <td>Federation</td>
                <td class="tdc">{{ (int) $credithistory[0]->cumulative_amount_federation_loan }}
                </td>
            </tr>
            <tr>
                <td class="tdc">2</td>
                <td>Bank</td>
                <td class="tdc">{{ (int) $credithistory[0]->cumulative_amount_bank_loan }}</td>
            </tr>
            <tr>
                <td class="tdc">3</td>
                <td>VI</td>
                <td class="tdc">{{ (int) $credithistory[0]->cumulative_amount_vi_loan }}</td>
            </tr>
            <tr>
                <td class="tdc">4</td>
                <td>Other</td>
                <td class="tdc">{{ (int) $credithistory[0]->cumulative_amount_other_loan }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Total </td>
                <td class="tdc">{{ (int) $credithistory[0]->cumulative_amount }}</td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="7">No Of Members Not Received Even A Single Loan During Last 3 Years </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th >Loan Type</th>
                <th colspan="4" class="tdc">Members Not received even a single loan during last 3 years</th>
                <th class="tdc">Total</th>
            </tr>
            <tr>
                <th class="tdc">A</th>
                <th>Federation Loan</th>
                <td class="tdc">Poorest</td>
                <td class="tdc">Poor</td>
                <td class="tdc">Medium Poor</td>
                <td class="tdc">Rich</td>
                <td ></td>
            </tr>
            <tr>
                <td></td>
                <td>Last 12 months</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_federation_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_federation_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_federation_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_federation_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_federation_loan_year1 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>Year before last</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_federation_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_federation_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_federation_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_federation_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_federation_loan_year2 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>2 Years before last</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_federation_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_federation_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_federation_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_federation_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_federation_loan_year3 }}
                </td>
            </tr>

            <tr>
                <th class="tdc">B</th>
                <th>Bank loan</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Last 12 months</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_bank_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_bank_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_bank_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_bank_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_bank_loan_year1 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>Year before last</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_bank_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_bank_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_bank_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_bank_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_bank_loan_year2 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>2 Years before last</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_bank_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_bank_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_bank_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_bank_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_bank_loan_year3 }}
                </td>
            </tr>

            <tr>
                <th class="tdc">C</th>
                <th>VI Loan</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Last 12 months</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_VI_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_VI_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_VI_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_VI_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_VI_loan_year1 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>Year before last</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_VI_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_VI_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_VI_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_VI_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_VI_loan_year2 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>2 Years before last</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_VI_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_VI_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_VI_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_VI_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_VI_loan_year3 }}
                </td>
            </tr>

            <tr>
                <th class="tdc">D</th>
                <th>Other Loans</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Last 12 months</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_other_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_other_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_other_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_other_loan_year1 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_other_loan_year1 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>Year before last</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_other_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_other_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_other_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_other_loan_year2 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_other_loan_year2 }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>2 Years before last</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poorest_members_not_received_other_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_poor_members_not_received_other_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_medium_members_not_received_other_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_rich_members_not_received_other_loan_year3 }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_total_members_not_received_other_loan_year3 }}
                </td>
            </tr>
        </tbody>


    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">No Of Members Taken More Than One Loan During Last 3 Years </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">How many members have taken more than one loan during last 3 years</th>
                <th width="25%">{{ (int) $credithistory[0]->members_have_taken_more_than_one_loan }}</th>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="7">Loan Repayment Performance (DCB Report)</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th class="tdc">DCB</th>
                <th class="tdc">Federation Loans </th>
                <th class="tdc">Bank Loans </th>
                <th class="tdc">VI Loan </th>
                <th class="tdc">Other Loans </th>
                <th class="tdc">Summary Loan Portfolio</th>
            </tr>

            <tr>
                <td class="tdc">i.</td>
                <td>No of Active loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_loan_active }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->bank_loan_active }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->vi_loan_active }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->other_loan_active }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_loan_active + (int) $credithistory[0]->bank_loan_active + (int) $credithistory[0]->vi_loan_active + (int) $credithistory[0]->other_loan_active }}
                </td>
            </tr>
            <tr>
                <td class="tdc">ii.</td>
                <td>Total Loan Amount Given (Rs.)</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_loan_amount }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->bank_loan_amount }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->vi_loan_amount }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->other_loan_amount }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->federation_loan_amount + (int) $credithistory[0]->bank_loan_amount + (int) $credithistory[0]->vi_loan_amount + (int) $credithistory[0]->other_loan_amount }}
                </td>
            </tr>
            <tr>
                <td class="tdc">iii.</td>
                <td>Total Demand upto last month for active loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->dcb_federation }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->dcb_bank }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->dcb_vi }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->dcb_other }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->dcb_federation + (int) $credithistory[0]->dcb_bank + (int) $credithistory[0]->dcb_vi + (int) $credithistory[0]->dcb_other }}
                </td>

            </tr>
            <tr>
                <td class="tdc">iv.</td>
                <td>Actual Amount Paid upto last month </td>
                <td class="tdc">{{ (int) $credithistory[0]->repaid_federation }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->repaid_bank }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->repaid_vi }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->repaid_other }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->repaid_federation + (int) $credithistory[0]->repaid_bank + (int) $credithistory[0]->repaid_vi + (int) $credithistory[0]->repaid_other }}
                </td>
            </tr>
            <tr>
                <td class="tdc">v.</td>
                <td>Overdue Amount</td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_amount_federation }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_amount_bank }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_amount_vi }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_amount_other }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_amount_federation + (int) $credithistory[0]->overdue_amount_bank + (int) $credithistory[0]->overdue_amount_vi + (int) $credithistory[0]->overdue_amount_other }}
                </td>
            </tr>
            <tr>
                <td class="tdc">vi.</td>
                <td>Outstanding amount for active loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->loan_outstanding_federation }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->loan_outstanding_bank }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->loan_outstanding_vi }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->loan_outstanding_other }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->loan_outstanding_federation + (int) $credithistory[0]->loan_outstanding_bank + (int) $credithistory[0]->loan_outstanding_vi + (int) $credithistory[0]->loan_outstanding_other }}
                </td>
            </tr>
            <tr class="tdc">
                <td class="tdc">vii.</td>
                <td>Repayment Ratio %</td>
                <td>{{ Checkper((float)$credithistory[0]->repayment_rate_federation_loans)."%"}}</td>
                <td>{{ Checkper((float)$credithistory[0]->repayment_rate_bank_loans)."%"}}</td>
                <td>{{ Checkper((float)$credithistory[0]->repayment_rate_vi_loans)."%"}}</td>
                <td>{{ Checkper((float)$credithistory[0]->repayment_rate_other_loans)."%"}}</td>
                @php
                $num = 0 ;
                if(!empty($credithistory[0]->repayment_rate_federation_loans))
                {
                    $num = $num + 1;
                $a = (float)(str_replace('%','',$credithistory[0]->repayment_rate_federation_loans)) ;
                }
                else {
                $a =0;
                }
                if(!empty($credithistory[0]->repayment_rate_bank_loans))
                {
                    $num = $num + 1;
                $b = (float)(str_replace('%','',$credithistory[0]->repayment_rate_bank_loans)) ;

                }
                else {
                $b =0;
                }
                if(!empty($credithistory[0]->repayment_rate_vi_loans))
                {
                    $num = $num + 1;
                $c = (float)(str_replace('%','',$credithistory[0]->repayment_rate_vi_loans)) ;

                }
                else {
                $c =0;
                }
                if(!empty($credithistory[0]->repayment_rate_other_loans))
                {
                    $num = $num + 1;
                $d = (float)(str_replace('%','',$credithistory[0]->repayment_rate_other_loans)) ;

                }
                else {
                $d =0;
                }
                if($num > 0)
                {
                    $data = ($a+$b+$c+$d)/$num;
                    $e = number_format((float)$data, 2, '.', '');

                }
                else{
                    $e = 0 ;
                }
                @endphp
                <td class="tdc">{{$e .'%'}}</td>
                
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Loan Default Check</td>
            </tr>
        </thead>

        <tr>
            <th width="4%" class="tdc">S.No</th>
            <th >Name of Loan Insitution</th>
            <th class="tdc">No of Members</th>
            <th class="tdc">No of Loans</th>
        </tr>
        <tbody>
            <tr>
                <td class="tdc">A</td>
                <td>Federation loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->loan_default_federation_members }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->default_federation_no_of_loans }}
                </td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>Bank Loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->loan_default_bank_members }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->default_bank_no_of_loans }}</td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>VI Loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->loan_default_vi_members }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->default_vi_no_of_loans }}</td>
            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>Other Loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->loan_default_other_members }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->default_other_no_of_loans }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Total</td>
                <td class="tdc">{{ (!empty($credithistory[0]->loan_default_federation_members) ? $credithistory[0]->loan_default_federation_members : 0) + (!empty($credithistory[0]->loan_default_bank_members) ? $credithistory[0]->loan_default_bank_members : 0) + (!empty($credithistory[0]->loan_default_vi_members) ? $credithistory[0]->loan_default_vi_members : 0) + (!empty($credithistory[0]->loan_default_other_members) ? $credithistory[0]->loan_default_other_members : 0) }}
                </td>
                <td class="tdc">{{ (!empty($credithistory[0]->default_federation_no_of_loans) ? $credithistory[0]->default_federation_no_of_loans :0) + (!empty($credithistory[0]->default_bank_no_of_loans) ? $credithistory[0]->default_bank_no_of_loans : 0) + (!empty($credithistory[0]->default_vi_no_of_loans) ? $credithistory[0]->default_vi_no_of_loans : 0) + (!empty($credithistory[0]->default_other_no_of_loans) ? $credithistory[0]->default_other_no_of_loans : 0) }}
                </td>

            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="5">Portfolio At Risk (PAR) Amount Details</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th >Institution</th>
                <th class="tdc">Defaulted loans for 30 days (Rs) </th>
                <th class="tdc">Defaulted loans for 60 days (Rs) </th>
                <th class="tdc">Defaulted loans for more than 90 days (Rs) </th>
            </tr>

            <tr>
                <td class="tdc">A</td>
                <td>Federation loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_1_months_Federation }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_2_months_Federation }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_3_months_Federation }}
                </td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>Bank Loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_1_months_Bank }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_2_months_Bank }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_3_months_Bank }}
                </td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>VI Loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_1_months_VI }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_2_months_VI }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_3_months_VI }}
                </td>
            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>Other Loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_1_months_other }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_2_months_other }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->overdue_More_than_3_months_other }}
                </td>
            </tr>
        </tbody>
    </table>
    <br> 
   
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="5">PAR Status %</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th >Institution</th>
                <th class="tdc">Defaulted loans for 30 days (%) </th>
                <th class="tdc">Defaulted loans for 60 days (%) </th>
                <th class="tdc">Defaulted loans for more than 90 days (%) </th>
            </tr>

            <tr class="tdc">
                <td>A</td>
                <td>Federation loans</td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_30_days_Federation) }}
                </td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_60_days_Federation) }}
                </td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_90_days_Federation)  }}
                </td>
            </tr>
            <tr class="tdc">
                <td>B</td>
                <td>Bank Loans</td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_30_days_Bank)}}</td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_60_days_Bank) }}</td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_90_days_Bank )}}</td>

            </tr>
            <tr class="tdc">
                <td>C</td>
                <td>VI Loans</td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_30_days_VI)}}</td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_60_days_VI)}}</td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_90_days_VI)}}</td>
            </tr>
            <tr class="tdc">
                <td>D</td>
                <td>Other Loans</td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_30_days_other)}}</td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_60_days_other)}}</td>
                <td>{{ Checkper($credithistory[0]->percentage_More_than_90_days_other)}}</td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Does Federation Have A Loan Tracking System</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">loan tracking system</th>
                <td width="25%" >{{ $credithistory[0]->does_Federation_loan_tracking_system !='' ? $credithistory[0]->does_Federation_loan_tracking_system : 'N/A' }}</td>
                <th width="25%">Date is was Established</th>
                <td width="25%" >{{ $credithistory[0]->when_was_it_established !='' ? Change_date_month_name_char(str_replace('/','-',$credithistory[0]->when_was_it_established)) : 'N/A'}}</td>
               
            </tr>
            <tr>
                <th width="25%">What is the frequency of loan tracking</th>
                <td width="25%" >{{ $credithistory[0]->frequency_of_loan_tracking !='' ? $credithistory[0]->frequency_of_loan_tracking : 'N/A' }}</td>
                <th width="25%"></th>
                <td width="25%" ></td>
            </tr>
        </tbody>
    </table>
    <br>
   
    <table class="table table-bordered table-stripped table1 page-break" cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Purpose Of ALL Loans During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc" >S.No</th>
                <th >Purpose</th>
                <th class="tdc">No of loans</th>
                <th class="tdc">Amount (Rs)</th>
                
            </tr>
            
            <tr>
                <td class="tdc">A</td>
                <td>Productive</td>
                <td class="tdc">{{ (int) $credithistory[0]->productive }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->productive_amount }}</td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>Consumption</td>
                <td class="tdc">{{ (int) $credithistory[0]->consumption }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->consumption_amount }}</td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>Debt Swapping</td>
                <td class="tdc">{{ (int) $credithistory[0]->debt_swapping }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->debt_swapping_amount }}</td>
            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>Education</td>
                <td class="tdc">{{ (int) $credithistory[0]->education }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->education_amount }}</td>
            </tr>
            <tr>
                <td class="tdc">E</td>
                <td>Health</td>
                <td class="tdc">{{ (int) $credithistory[0]->health }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->health_amount }}</td>
            </tr>
            <tr>
                <td class="tdc">F</td>
                <td>Other</td>
                <td class="tdc">{{ (int) $credithistory[0]->Other }}</td>
                <td class="tdc">{{ (int) $credithistory[0]->Other_amount }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Total</td>
                <td class="tdc">{{ (int) $credithistory[0]->productive + (int) $credithistory[0]->consumption + (int) $credithistory[0]->debt_swapping + (int) $credithistory[0]->education + (int) $credithistory[0]->health + (int) $credithistory[0]->Other }}
                </td>
                <td class="tdc">{{ (int) $credithistory[0]->productive_amount + (int) $credithistory[0]->consumption_amount + (int) $credithistory[0]->debt_swapping_amount + (int) $credithistory[0]->education_amount + (int) $credithistory[0]->health_amount + (int) $credithistory[0]->Other_amount }}
                </td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Average Loan Number And Amount During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Average no of loans</th>
                <td width="25%" >{{ $credithistory[0]->average_loan !='' ? $credithistory[0]->average_loan  : 0}}</td>
                <th width="25%">Average Loan amount</th>
                <td width="25%" >{{ $credithistory[0]->average_loan_amount !='' ? $credithistory[0]->average_loan_amount : 0 }}</td>
            </tr>
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Minimum And Maximum Loan Amounts During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Maximum Amount</th>
                <td width="25%" >{{ $credithistory[0]->maximum_amount !='' ? $credithistory[0]->maximum_amount : 0 }}</td>
                <th width="25%">Minimum Amount</th>
                <td width="25%" >{{ $credithistory[0]->minimum_amount !='' ? $credithistory[0]->minimum_amount : 0 }}</td>
            </tr>
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Interest Rate Details</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th >Insitution</th>
                <th>Type</th>
                <th class="tdc">% charged</th>
            </tr>

            <tr>
                <td class="tdc">A</td>
                <td>Federation</td>
                <td >{{ $credithistory[0]->declining_or_flat !='' ? $credithistory[0]->declining_or_flat : 'N/A' }}</td>
                <td class="tdc">{{ $credithistory[0]->percent_charged !='' ? $credithistory[0]->percent_charged : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>Bank</td>
                <td >{{ $credithistory[0]->declining_or_flat_bank !='' ?  $credithistory[0]->declining_or_flat_bank  : 'N/A' }}</td>
                <td class="tdc">{{ $credithistory[0]->percent_charged_bank !='' ? $credithistory[0]->percent_charged_bank : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>VI</td>
                <td >{{ $credithistory[0]->declining_or_flat_vi !='' ? $credithistory[0]->declining_or_flat_vi : 'N/A' }}</td>
                <td class="tdc">{{ $credithistory[0]->percent_charged_vi !='' ? $credithistory[0]->percent_charged_vi : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>Other</td>
                <td >{{ $credithistory[0]->declining_or_flat_other !='' ? $credithistory[0]->declining_or_flat_other : 'N/A' }}</td>
                <td class="tdc">{{ $credithistory[0]->percent_charged_other !='' ? $credithistory[0]->percent_charged_other : 0 }}</td>
            </tr>
        </tbody>

    </table>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">Cumulative Interest Income </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th width="48%">Institution</th>
                <th width="48%" class="tdc">Income Generated Amount</th>
            </tr>


        <tbody>
            <tr>
                <td class="tdc">A</td>
                <td>Federation</td>
                <td class="tdc">{{ (int) $credithistory[0]->cumulative_interest_federation_loans }}
                </td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>Bank</td>
                <td class="tdc">{{ (int) $credithistory[0]->cumulative_interest_bank_loans }}
                </td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>VI</td>
                <td class="tdc">{{ (int) $credithistory[0]->cumulative_interest_vi_loans }}</td>
            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>Other Loans</td>
                <td class="tdc">{{ (int) $credithistory[0]->cumulative_interest_other_loans }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>Total</td>
                <td class="tdc">{{ (int) $credithistory[0]->cumulative_interest_federation_loans + (int) $credithistory[0]->cumulative_interest_bank_loans + (int) $credithistory[0]->cumulative_interest_vi_loans + (int) $credithistory[0]->cumulative_interest_other_loans }}
                </td>
            </tr>
        </tbody>

    </table>
    <br>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="2">Action Taken During Last 12 Months To Address Loan Default</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th >Describe Action</th>
            </tr>

            @if($credithistory[0]->actions_previous_year_defaults_a !='')
            <tr>
                <td class="tdc">1</td>
                <td >{{ $credithistory[0]->actions_previous_year_defaults_a }}</td>
            </tr>
            @endif

            @if($credithistory[0]->actions_previous_year_defaults_b !='')
            <tr>
                <td class="tdc">2</td>
                <td >{{ $credithistory[0]->actions_previous_year_defaults_b }}</td>
            </tr>
            @endif

            @if($credithistory[0]->actions_previous_year_defaults_c !='')
            <tr>
                <td class="tdc">3</td>
                <td >{{ $credithistory[0]->actions_previous_year_defaults_c }}</td>
            </tr>
            @endif

            @if($credithistory[0]->actions_previous_year_defaults_d !='')
            <tr>
                <td class="tdc">4</td>
                <td >{{ $credithistory[0]->actions_previous_year_defaults_d }}</td>
            </tr>
            @endif

            @if($credithistory[0]->actions_previous_year_defaults_e !='')
            <tr>
                <td class="tdc">5</td>
                <td >{{ $credithistory[0]->actions_previous_year_defaults_e }}</td>
            </tr>
            @endif

        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Rotation Of Funds (velocity)</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th >Heading</th>
                <th class="tdc">Federation</th>
                <th class="tdc">VI</th>
            </tr>
            <tr>
                <td class="tdc">A</td>
                <td>Total corpus funds received (RS)</td>
                <td class="tdc">{{ $credithistory[0]->Total_corpus_fund_received !='' ? $credithistory[0]->Total_corpus_fund_received : 0 }}</td>
                <td class="tdc">{{ $credithistory[0]->Total_corpus_fund_received_vi !='' ? $credithistory[0]->Total_corpus_fund_received_vi : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">B</td>
                <td>Total federation loan disbursed (Rs)</td>
                <td class="tdc">{{ $credithistory[0]->Total_loan_given !='' ?$credithistory[0]->Total_loan_given : 0 }}</td>
                <td class="tdc">{{ $credithistory[0]->Total_loan_given_vi !='' ? $credithistory[0]->Total_loan_given_vi : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">C</td>
                <td>No of years completed since receipt of funds (#)</td>
                <td class="tdc">{{ $credithistory[0]->completed_received_corpus_fund !='' ? $credithistory[0]->completed_received_corpus_fund : 0 }}</td>
                <td class="tdc">{{ $credithistory[0]->completed_received_corpus_fund_vi !='' ?  $credithistory[0]->completed_received_corpus_fund_vi : 0 }}</td>
            </tr>
            <tr>
                <td class="tdc">D</td>
                <td>Yearly rotation Ratio</td>
                <td class="tdc">{{ $credithistory[0]->Yearly_rotation_ratio !='' ? $credithistory[0]->Yearly_rotation_ratio : 0 }}</td>
                <td class="tdc">{{ $credithistory[0]->Yearly_rotation_ratio_vi !='' ? $credithistory[0]->Yearly_rotation_ratio_vi : 0 }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <!-- Sustainability -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >SUSTAINABILITY</td>
            </tr>
        </thead>
    </table>
   <br>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Income And Expenditure During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Total Income</th>
                <td width="25%" >{{ $sustainability[0]->total_income_of_the_federation !='' ? $sustainability[0]->total_income_of_the_federation : 0 }}</td>
                <th width="25%">Total Expenses</th>
                <td width="25%" >{{ $sustainability[0]->expense_of_the_federation !='' ? $sustainability[0]->expense_of_the_federation : 0 }}</td>
            </tr>
            <tr>
                <th width="25%">Coverage of Operational costs </th>
                <td width="25%" >{{ $sustainability[0]->federation_covering_operational_cost !='' ? $sustainability[0]->federation_covering_operational_cost : 0 }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">Loan Security Fund (LSF)</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="4%" class="tdc">A</td>
                <td>Whether LSF is in operation</td>
                <td class="tdc">{{ $sustainability[0]->have_loan_security_fund !='' ? $sustainability[0]->have_loan_security_fund : 'N/A' }}</td>
            </tr>
            
            <tr>
                <td width="4%" class="tdc">B</td>
                <td>Date established/Verified</td>
                <td class="tdc">{{ $sustainability[0]->date_it_was_established !='' ? change_date_month_name_char(str_replace('/','-',$sustainability[0]->date_it_was_established)) : 'N/A' }}</td>
            </tr>
            <tr>
                <td width="4%" class="tdc">C</td>
                <td>No of members contribute to LSF</td>
                <td class="tdc">{{ $sustainability[0]->members_contribute_LSF !='' ? $sustainability[0]->members_contribute_LSF : 0 }}</td>
            </tr>
            <tr>
                <td width="4%" class="tdc">D</td>
                <td>Amount available in LSF</td>
                <td class="tdc">{{ $sustainability[0]->amount_available_security_fund  !='' ? $sustainability[0]->amount_available_security_fund : 0}}</td>
            </tr>
            <tr>
                <td width="4%" class="tdc">E</td>
                <td>No of members benefitted from LSF</td>
                <td class="tdc">{{ $sustainability[0]->members_benefited_by_LSF !='' ? $sustainability[0]->members_benefited_by_LSF : 0 }}</td>
            </tr>
            
            
            <tr>
                <td width="4%" class="tdc">F</td>
                <td>Reason member do not contribute</td>
                <td class="tdc">{{$sustainability[0]->reason_members_do_not_contribute !='' ? $sustainability[0]->reason_members_do_not_contribute : 'N/A'}}</td>
            </tr>
            
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="6">Savings Of Member SHGs</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th >Details</th>
                <th class="tdc">Compulsory savings </th>
                <th class="tdc">Voluntary savings </th>
                <th class="tdc">Other savings </th>
                <th class="tdc">Total savings</th>
            </tr>

            <tr>
                <td>i.</td>
                <td>Cumulative savings of all SHGs upto date</td>
                <td class="tdc">{{ $sustainability[0]->cumulative_savings_compulsory !='' ? $sustainability[0]->cumulative_savings_compulsory : 0 }}</td>
                <td class="tdc">{{ $sustainability[0]->cumulative_savings_voluntary }}</td>
                <td class="tdc">{{ $sustainability[0]->cumulative_savings_other }}</td>
                <td class="tdc">{{ (int) $sustainability[0]->cumulative_savings_compulsory + (int) $sustainability[0]->cumulative_savings_voluntary + (int) $sustainability[0]->cumulative_savings_other }}
                </td>
            </tr>
            <tr>
                <td>ii.</td>
                <td>Amount saved during last 12 months</td>
                <td class="tdc">{{ $sustainability[0]->amount_saved_compulsory !='' ? $sustainability[0]->amount_saved_compulsory : 0 }}</td>
                <td class="tdc">{{ $sustainability[0]->amount_saved_voluntary }}</td>
                <td class="tdc">{{ $sustainability[0]->amount_saved_other }}</td>
                <td class="tdc">{{ (int) $sustainability[0]->amount_saved_compulsory + (int) $sustainability[0]->amount_saved_voluntary + (int) $sustainability[0]->amount_saved_other }}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Other Services Provided By Federation </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th >Name of the Service</th>
                <th class="tdc">Date Established</th>
                <th class="tdc">No of Members benefit from the service</th>
            </tr>

            @php $i=1; @endphp
            @if (!empty($sustainability_service))
            @foreach ($sustainability_service as $row)
            <tr>
                <td class="tdc">{{ $i++ }}</td>
                <td >{{ $row->service_name }}</td>
                <td class="tdc">{{ $row->date !='' ? change_date_month_name_char(str_replace('/','-',$row->date)) : 'N/A'  }}</td>
                <td class="tdc">{{ $row->members !='' ? $row->members : 0  }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <br>
    
    <!-- Risk Mitigation -->
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >RISK MITIGATION</td>
            </tr>
        </thead>
    </table>
   <br>
    
     
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Total Members</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Total Members</th>
                <td width="25%">{{ $risk_mitigation[0]->total_general_assembly_members !='' ? $risk_mitigation[0]->total_general_assembly_members : 0 }}</td>
                <td width="25%"></td>
                <td width="25%"></td>

            </tr>


        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Life Insurance Coverage For Total Members</td>
            </tr>
        </thead>
        <tbody>
            @php
            $a = (float)$risk_mitigation[0]->members_covered_under_life_insurance;
            $b = (float)$risk_mitigation[0]->total_general_assembly_members;
            $c = 0;
            if (($risk_mitigation[0]->total_general_assembly_members) > 0)
            {
            $value = ($risk_mitigation[0]->members_covered_under_life_insurance *100)/ $risk_mitigation[0]->total_general_assembly_members;
            $c = round($value,2);
            }
            @endphp
            <tr>
                <th wiidth="25%">No of members covered</th>
                <td width="25%" >{{ $risk_mitigation[0]->members_covered_under_life_insurance !='' ? $risk_mitigation[0]->members_covered_under_life_insurance : 0 }}</td>
                <th wiidth="25%">Coverage (%)</th>
                @if($risk_mitigation[0]->par_covered_under_life_insurance == 0)
                <td width="25%" >{{ $risk_mitigation[0]->par_covered_under_life_insurance }}%</td>
            @elseif ($risk_mitigation[0]->par_covered_under_life_insurance == '')
                <td>0%</td>
            @else
            <td width="25%" >{{ $risk_mitigation[0]->par_covered_under_life_insurance }}</td>
            @endif
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Life Insurance Coverage For Active Borrowers During Last 3 Years</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th wiidth="25%">No of active borrowers</th>
                <td width="25%" >{{ $risk_mitigation[0]->availed_members_covered_under_loan_insurance !='' ? $risk_mitigation[0]->availed_members_covered_under_loan_insurance : 0 }}</td>
                <th wiidth="25%">No of active borrowers covered</th>
                <td width="25%" >{{ $risk_mitigation[0]->par_availed_members_covered_under_loan_insurance !='' ? $risk_mitigation[0]->par_availed_members_covered_under_loan_insurance : 0  }}</td>
                
                
            </tr>
            <tr>
                <th wiidth="25%">Coverage (%)</th>
                @if ($risk_mitigation[0]->availed_members_covered_under_loan_insurance > 0)
                <td width="25%" >
                {{ ($risk_mitigation[0]->par_availed_members_covered_under_loan_insurance * 100) / $risk_mitigation[0]->availed_members_covered_under_loan_insurance }}
                </td>
                @else
                <td width="25%" >0%</td>
                @endif
                <td></td>
                <td></td>
            </tr>
            
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Asset Insurance For Livestock During Last 3 Years</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th wiidth="25%"> No of asset/animals purchased</th>
                <td width="25%" >{{ checkZero($risk_mitigation[0]->animal_purchased_during_last_one_year) }}</td>
                <th wiidth="25%">No of asset/animals insured</th>
                <td width="25%" >{{ checkZero($risk_mitigation[0]->animal_insured_last_one_year) }}</td>
            </tr>
            <tr>
                <th wiidth="25%">Coverage (%)</th>
                
                    @if ($risk_mitigation[0]->animal_purchased_during_last_one_year > 0)
                    <td width="25%" >
                    {{ round(($risk_mitigation[0]->animal_insured_last_one_year * 100) / $risk_mitigation[0]->animal_purchased_during_last_one_year) }}%
                    </td>
                    @else
                    <td width="25%" >
                        0%
                    </td>
                    @endif
                <th wiidth="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Benefits Claimed Under Life Insurance</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th wiidth="25%">No of claims submitted</th>
                <td width="25%" >{{ $risk_mitigation[0]->No_of_claim_received !='' ? $risk_mitigation[0]->No_of_claim_received : 0 }}</td>
                <th wiidth="25%">Total Claim amount (Rs)</th>
                <td width="25%" >{{ $risk_mitigation[0]->Total_claim_amount_requested !='' ? $risk_mitigation[0]->Total_claim_amount_requested : 0 }}</td>
            </tr>
            <tr>
                <th wiidth="25%">Total No of claims settled</th>
                <td width="25%" >{{ $risk_mitigation[0]->No_of_person_claim_setteled !='' ? $risk_mitigation[0]->No_of_person_claim_setteled : 0 }}</td>
                <th wiidth="25%">Total Claim amount settled</th>
                <td width="25%" >{{ $risk_mitigation[0]->Total_claim_amount_setteled !='' ? $risk_mitigation[0]->Total_claim_amount_setteled : 0 }}</td>
            </tr>
            <tr>
                <th wiidth="25%">Settlement (in No)</th>
                <td width="25%" >
                    {{ checkZero($risk_mitigation[0]->settlement_claimed_insurance_no) }}
                </td>
                <th wiidth="25%">Settlement done (in %)</th>
                <td width="25%">{{ $risk_mitigation[0]->settlement_claimed_insurance_per !='' ? $risk_mitigation[0]->settlement_claimed_insurance_per : '0%'  }}</td>

            </tr>
            
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Benefits Claimed Under Livestock During Last 12 Months</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th wiidth="25%">No of animal death claims submitted</th>
                <td width="25%" >{{ checkZero($risk_mitigation[0]->death_claim_requested) }}</td>
                <th wiidth="25%">Total amount of Claims submitted (Rs)</th>
                <td width="25%" >{{  checkZero($risk_mitigation[0]->Total_claim_amount_requested_animal_death) }}</td>
            </tr>
            <tr>
                <th wiidth="25%">Total No of claims settled</th>
                <td width="25%" >{{  checkZero($risk_mitigation[0]->animal_claim_setteled) }}</td>
                <th wiidth="25%">Total Claim amount settled</th>
                <td width="25%" >{{  checkZero($risk_mitigation[0]->Total_claim_amount_setteled_for_animal_death) }}</td>
            </tr>
            <tr>
                <th wiidth="25%">Settlement (in No)</th>
                <td width="25%" >
                    {{ checkZero($risk_mitigation[0]->settlement_asset_insurance_no) }}
                </td>
                <th wiidth="25%">Settlement done (in %)</th>
                <td width="25%">{{ $risk_mitigation[0]->settlement_asset_insurance_per !='' ? $risk_mitigation[0]->settlement_asset_insurance_per : '0%'  }}</td>

            </tr>
        </tbody>
    </table>
    <br>


  
    <!-- Challenges -->
    <table class="table table-bordered table-stripped table1 page-break" cellspacing="0">
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
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th ></th>
                
            </tr>
            @php $i=1; @endphp
            @if (count($challenges) > 1)
            @foreach ($challenges as $row)
            <tr>
                <td class="tdc">{{ $i++ }}</td>
                <td >{{ $row->challenge }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <br>
    <!-- Action  -->
  
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="3">Action Plan to address challenges</td>
            </tr>
        </thead>
        <tbody>
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
                <td >{{ $row['name'] }}</td>
                @if (!empty($row['action']))
                @foreach ($row['action'] as $val)
                <td >{{ $val !='' ? $val : 'N/A'  }}</td>
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
       
        <tbody style="text-align: start;">
            <tr style="background-color:#01a9ac ">
                <th width="4%" class="tdc">S.No</th>
                <th>Questions</th>
                <th>Answers</th>
            </tr>

            <tr>
                <td class="tdc">1a.</td>
                <th >How many members attended the cluster meeting?</th>
                <td >{{ $observation[0]->federationObservationMeeting !='' ? $observation[0]->federationObservationMeeting : 0 }}</td>
            </tr>
            
            <tr>
                <td class="tdc">1b.</td>
                <th>Were all office bearers and leaders present? E.g President,
                    treasurer, secretary, book-keeper, other,</th>
                    @php
                $desg = [];
                if ($observation[0]->federation_observation_president == 1) {
                $desg[] = 'President';
                }
                if ($observation[0]->federation_observation_bookkeeper == 1) {
                $desg[] = 'Book-Keeper';
                }
                if ($observation[0]->federation_observation_secretary == 1) {
                $desg[] = 'Secretary';
                }
                if ($observation[0]->federation_observation_treasure == 1) {
                $desg[] = 'Treasurer';
                }
                if ($observation[0]->federation_observation_sub_commit == 1) {
                $desg[] = 'Sub-Commitee Members';
                }
                if ($observation[0]->federation_observation_other == 1) {
                $desg[] = 'Other';
                }
                $strdesg = implode(',', $desg);
                @endphp
                @if(!empty($strdesg))
                <td >{{ $strdesg }}</td>
                @else
                <td>N/A</td>
                @endif
            </tr>
           
            <tr>
                <td class="tdc">2</td>
                <th >Did Federation leaders understand the Purpose of the meeting?Explain</th>
                <td >{{ $observation[0]->federationObservationCarriedOut !='' ? $observation[0]->federationObservationCarriedOut : 'N/A' }}</td>
            </tr>
            
            <tr>
                <td class="tdc">3</td>
                <th>What was quality of Discussion? Did everyone participate?</th>
                <td >{{ $observation[0]->federationObservationLeadersOnly !='' ? $observation[0]->federationObservationLeadersOnly : 'N/A' }}</td>
            </tr>
           
            <tr>
                <td class="tdc">4</td>
                <th>Where Federation leaders aware of their rules and norms?</th>
                <td></td>
            </tr>
            <tr>
                <td class="tdc">A.</td>
                <th> Did they understand vision of their Federation?</th>
                <td>{{ $observation[0]->federationObservationNormsHave !='' ? $observation[0]->federationObservationNormsHave : 'N/A' }}</td>
            </tr>
            
            <tr>
                <td class="tdc">B.</td>
                <th>Do they understand benefits of being part of the Federation?</th>
                <td>N/A</td>
            </tr>
            
            <tr>
                <td class="tdc">5</td>
                <th>Important practices followed by the Federation.</th>
                <td></td>
            </tr>
            <tr>
                <td class="tdc">A.</td>
                <th> Do they have a set of important practices for repayment and savings?</th>
                <td >{{ $observation[0]->federationObservationDefaults !='' ? $observation[0]->federationObservationDefaults : 'N/A' }}</td>
            </tr>
            
            
            <tr>
                <td class="tdc">B.</td>
                <th >What are those practices?</th>
                <td >{{ $observation[0]->federationObservationPractices !='' ? $observation[0]->federationObservationPractices : 'N/A' }}</td>
            </tr>
            
            
            <tr>
                <td class="tdc">6</td>
                <th>What is Federation’s policy on the most vulnerable members</th>
                <td></td>
            </tr>
            <tr>
                <td class="tdc">A.</td>
                <th>Does this Cluster include members who are the most poor and vulnerable, and if yes, </th>
                <td>{{ $observation[0]->federationObservationProvidedThem !='' ? $observation[0]->federationObservationProvidedThem : 'N/A' }}</td>
            </tr>

            
            
            <tr>
                <td class="tdc">B.</td>
                <th >What is their policy to help them</th>
                <td >{{ $observation[0]->federation_observation_policy_explain !='' ? $observation[0]->federation_observation_policy_explain : 'N/A' }}</td>
            </tr>
            
           
            <tr>
                <td class="tdc">7</td>
                <th>Federation’s Reporting and documentation</th>
                <td></td>
            </tr>
            <tr>
                <td class="tdc">A.</td>
                <th >Does Federation have a satisfactory/weak or good system of
                    reporting and updating of documents? </th>
                <td>{{ $observation[0]->federationObservationDocuments !='' ? $observation[0]->federationObservationDocuments : 'N/A' }}</td>
            </tr>
            
            <tr>
                <td class="tdc">B.</td>
                <th>Any highlights</th>
                <td>{{ $observation[0]->federation_observation_any_highlighted !='' ? $observation[0]->federation_observation_any_highlighted :'N/A' }}</td>
            </tr>
            
            <tr>
                <td class="tdc">C.</td>
                <th>Who writes these books and minutes of meetings?</th>
                <td>{{ $observation[0]->federationObservationMinutesMeetings !='' ? $observation[0]->federationObservationMinutesMeetings : 'N/A' }}</td>
            </tr>
            
            <tr>
                <td class="tdc">8</td>
                <th>Federation’s financial information</th>
                <td></td>
            </tr>
            <tr>
                <td class="tdc">A.</td>
                <th>Are books of accounts managed by the bookkeeper or others? Explain
                </th>
                <td >{{ $observation[0]->federationObservationUpdatedRecords !='' ? $observation[0]->federationObservationUpdatedRecords :'N/A' }}</td>
            </tr>
            
           
            <tr>
                <td class="tdc">B.</td>
                <th> Any highlights</th>
                <td >{{ $observation[0]->federation_observation_leaders_office !='' ? $observation[0]->federation_observation_leaders_office : 'N/A' }}</td>
            </tr>
           
            
            <tr>
                <td class="tdc">9</td>
                <th>Impression about Social Audit committee</th>
                <td></td>
            </tr>

            <tr>
                <td class="tdc">A.</td>
                <th>Does it work?</th>
                <td>{{ $observation[0]->federationObservationWork !='' ? $observation[0]->federationObservationWork :'N/A' }}</td>
            </tr>
           

            <tr>
                <td class="tdc">B.</td>
                <th>Are office bearers of SA aware of their roles and reporting system?
                </th>
                <td>{{ $observation[0]->federationObservationReportingSystem !='' ? $observation[0]->federationObservationReportingSystem :'N/A' }}</td>
            </tr>
            
            <tr>
                <td class="tdc">10</td>
                <th>Unique features of this Federation</th>
                <td></td>
            </tr>
            <tr>
                <td class="tdc">A.</td>
                <th>Did you notice any unique features and practices that make it
                    special?</th>
                <td>{{ $observation[0]->federationObservationFederationSpecial !='' ? $observation[0]->federationObservationFederationSpecial :'N/A' }}
                </td>  
            </tr>
            
            <tr>
                <td class="tdc">B.</td>
                <th >How do they manage and support their groups and clusters?</th>
                <td >{{ $observation[0]->federationObservationClusterFederations !='' ? $observation[0]->federationObservationClusterFederations : 'N/A' }}
                </td>
            </tr>
            <tr>
                <td class="tdc">11</td>
                <th>Summary of important 3- 5 highlights (positive and negative)
                        about this Federation</th>
                        <td>
                            <ul>
                            @if ($observation[0]->federationObserHighlightsA !='')
                            <li>{{ $observation[0]->federationObserHighlightsA }}</li>
                            @endif    
                            @if ($observation[0]->federationObserHighlightsB !='')
                            <li>{{ $observation[0]->federationObserHighlightsB }}</li>   
                            @endif
                            @if ($observation[0]->federationObserHighlightsC !='')
                            <li>{{ $observation[0]->federationObserHighlightsC }}</li>   
                            @endif
                            @if ($observation[0]->federationObserHighlightsD !='')
                            <li>{{ $observation[0]->federationObserHighlightsD }}</li>  
                            @endif
                            @if ($observation[0]->federationObserHighlightsE !='')
                            <li>{{ $observation[0]->federationObserHighlightsE }}</li>
                            @endif
                            
                            </ul>
                        </td>
            </tr>
            
            
        
        </tbody>
    </table>
    <br>

         <!-- Rating Card -->
     <table class="table table-bordered table-stripped table1 page-break" cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white" >REPORT CARD</td>
            </tr>
        </thead>
    </table>
    <br>
    
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" >
                <td style="background-color:#01a9ac" colspan="4">Federation Report Card </td>
            </tr>
        </thead>
        {{-- <tbody>
            <tr>
                <th width="25%">Name</th>
                <td width="25%">{{ !empty($profile[0]->name_of_federation) ? $profile[0]->name_of_federation : '--'  }}</td>
                <th width="25%">UIN</th>
                <td width="25%">{{ $federation->uin }}</td>
            </tr>
            <tr>
                <th width="25%">State Name</th>
                <td width="25%">{{ $profile[0]->name_of_state }}</td>
                <th width="25%">District Name</th>
                <td width="25%">{{ $profile[0]->name_of_district }}</td>
            </tr>
            <tr>
                <th width="25%">Date</th>
                <td width="25%">{{change_date_month_name_char(str_replace('/','-',$federation->created_at))}}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody> --}}
    
    </table>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead class="back-color">
            <tr>
                <th width="450px"> Indicators</th>
                <td colspan="4"></td>
                <th colspan="" style="text-align:center;"> Actual Score </th>
                <th colspan="" style="text-align:center;"> Expected Score</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1 Governance</td>
                <td style="background-color: green;width:50px;">
                
                    @if($score >=90 )
                    <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;">
                    @if($score >=75 && $score <=89) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: lightgrey;width:50px;">
                    @if($score >=60 && $score <=74) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: red;width:50px;">
                    @if($score <=59) <span class="checkmark"></span>
                        @endif
                </td>
                <td class="tdc">{{$total_1to8}}</td>
                <td class="tdc">30</td>
                {{--<td>{{round($score)}}</td>--}}
            </tr>
            <tr>
                <td>2 Inclusion</td>
                <td style="background-color: green;width:50px;">
                    @if($score1 >=90 )
                    <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;">
                    @if($score1 >=75 && $score1 <=89) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: lightgrey;width:50px;">
                    @if($score1 >=60 && $score1 <=74) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: red;width:50px;">
                    @if($score1 <=59) <span class="checkmark"></span>
                        @endif
                </td>
                <td class="tdc">{{$total_9to11}}</td>
                <td class="tdc">15</td>
                {{--<td>{{round($score1)}}</td>--}}
            </tr>
            <tr>
                <td>3 Efficiency</td>
                <td style="background-color: green;width:50px;">
                    @if($score2 >=90 )
                    <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;">
                    @if($score2 >=75 && $score2 <=89) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: lightgrey;width:50px;">
                    @if($score2 >=60 && $score2 <=74) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: red;width:50px;">
                    @if($score2 <=59) <span class="checkmark"></span>
                        @endif
                </td>
                <td class="tdc">{{$total_12to14}}</td>
                <td class="tdc">15</td>
                {{--<td>{{round($score2)}}</td>--}}
            </tr>
            <tr>
                <td>4 Credit Recovery</td>
                <td style="background-color: green;width:50px;">
                    @if($score3 >=90 )
                    <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;">
                    @if($score3 >=75 && $score3 <=89) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: lightgrey;width:50px;">
                    @if($score3 >=60 && $score3 <=74) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: red;width:50px;">
                    @if($score3 <=59) <span class="checkmark"></span>
                        @endif
                </td>
                <td class="tdc">{{$total_15to20}}</td>
                <td class="tdc">25</td>
                {{--<td>{{round($score3)}}</td>--}}
            </tr>
            <tr>
                <td>5 Sustainability</td>
                <td style="background-color: green;width:50px;">
                    @if($score4 >=90 )
                    <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;">
                    @if($score4 >=75 && $score4 <=89) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: lightgrey;width:50px;">
                    @if($score4 >=60 && $score4 <=74) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: red;width:50px;">
                    @if($score4 <=59) <span class="checkmark"></span>
                        @endif
                </td>
                <td class="tdc">{{$total_21to22}}</td>
                <td class="tdc">6</td>
                {{--<td>{{round($score4)}}</td>--}}
            </tr>
            <tr>
                <td>6 Risk Manegement</td>
                <td style="background-color: green;width:50px;">
                    @if($score5 >=90 )
                    <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;">
                    @if($score5 >=75 && $score5 <=89) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: lightgrey;width:50px;">
                    @if($score5 >=60 && $score5 <=74) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: red;width:50px;">
                    @if($score5 <=59) <span class="checkmark"></span>
                        @endif
                </td>
                <td class="tdc">{{$total_23to25}}</td>
                <td class="tdc">9</td>
                {{--<td>{{round($score5)}}</td>--}}
            </tr>
            <tr>
                @php
                    if($analysis_final_total >=90)
                    {
                       $color = 'green';
                    }
                    if($analysis_final_total >=75 && $analysis_final_total <=89)
                    {
                       $color = 'yellow';
                    }
                    if($analysis_final_total >=60 && $analysis_final_total <=74)
                    {
                       $color = 'lightgrey';
                    }
                    if($analysis_final_total <=59)
                    {
                       $color = 'red';
                    }
                    
                @endphp
                <th width="450px">Total Score</th>
                <td colspan="4"></td>
                <td style="background-color:{{$color }};text-align:center;font-weight:bold;font-size:20px;">
                    {{$analysis_final_total }}</td>
    
    
                <td></td>
    
                
            </tr>
    
        </tbody>
    </table>
    <br>

      
</body>

</html>