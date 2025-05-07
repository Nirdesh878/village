<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CLUSTER Details </title>
</head>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="style_new.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

<style>
    .pdf-main {
        padding: 50px 0;
        background: #f1f0f0;
        position: relative;
    }

    .new-table-dg thead tr {
        background: #cea38b;
    }

    .new-table-dg {
        border-color: #fff !important;
    }


    .new-table-dg th,
    .new-table-dg td {
        border-color: #fff;
    }

    span.bg-edge {
        position: absolute;
        left: 0;
        top: 0;
    }

    .bg-edge img {
        width: 200px;
    }

    .bg-edge-bottom {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 200px;
    }

    .bg-edge-bottom img {
        width: 200px;
    }
</style>



{{-- page Body start --}}

<body >
    <div style="background: #f1f0f0;">
        <button class="btn btn-sm getPDFbtn" onclick="getPDF()" style="border: 1px black solid;width:6%;">GET PDF</button>
    </div>

    <div class="canvas_all_pdf">
        <div class="pdf-main">
            <span class="bg-edge"><img src="{{ public_path('images/bg-edge.png') }}" alt=""></span>

            <span class="bg-edge-bottom"><img src="{{ public_path('images/bg-edge-bottom.png') }}"
                    alt=""></span>

            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h3>CLUSTER PROFILE AND ASSESSMENT</h3>
                            {{-- <p><b>UIN ({{ $shg->uin }})</u>
                                    </h2></b></p> --}}
                            <h4><u>BASIC INFORMATION</u></h4>
                        </div>

                    </div>
                    <div style="display: flex;position:relative;left:75%;top:-86px;">
                        <div class="text-center"
                            style="border: 1px black solid;height:50px;width:100px;background: #cea38b;">
                            <h5>Report Card</h5>
                        </div>
                        <div style="border: 1px black solid;height:50px;width:100px;background:{{ $grdcolor }};">

                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-7">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Name & Other Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th width="25%">UIN</th>
                                    <td width="25%">{{ $cluster->uin}}</td>

                                    <th width="25%">Name</th>
                                    <td width="25%">{{ $profile[0]->name_of_cluster }}</td>
                                </tr>
                              
                                <tr>
                                    <th>Cluster office location</th>
                                    <td>
                                        {{ checkna($profile[0]->office_location) }} </td>

                                    <th>District</th>
                                    <td>{{ $profile[0]->name_of_district }}</td>
                                </tr>
                                    
                                <tr>
                                    <th>State</th>
                                    <td>{{ $profile[0]->name_of_state }}</td>

                                    <th>Country</th>
                                    <td>{{ $profile[0]->name_of_country }}</td>
                                </tr>

                                <tr>
                                    <th>NRLM Code</th>
                                    <td></td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5" >
                        <table class="table table-bordered  new-table-dg" style="border: 2px black solid;">
                            <thead>
                                <tr>
                                    <th colspan="2">Cluster Creation and Membership</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Date Cluster was formed</td>
                                    <td>{{  change_date_month_name_char(str_replace('/','-',$profile[0]->cluster_formed))}}</td>
                                </tr>
                                <tr>
                                    <td>No of Members at the time of Creation</td>
                                    <td>{{ checkZero($profile[0]->cluster_members_at_time_creation)  }}</td>
                                </tr>
                                <tr>
                                    <td>No of current Members</td>
                                    <td>{{ checkZero($profile[0]->total_members) }}</td>
                                </tr>
                                <tr>
                                    <td>No of SHGs at creation</td>
                                    <td>{{ $profile[0]->shg_at_time_creation }}</td>
                                </tr>
                                <tr>
                                    <td>No of current SHGs</td>
                                    <td>{{ checkZero($profile[0]->total_SHGs) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Current Leadership Status</th>
                                    <th colspan="2">Current Book Keeper</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>President/Animator</td>
                                    <td>{{ checkna($profile[0]->president) }}</td>
                                    <td>Name</td>
                                    <td>{{ checkna($profile[0]->book_keeper_name) }}</td>
                                </tr>
                                <tr>
                                    <td>Secretary</td>
                                    <td>{{ checkna($profile[0]->secretary) }}</td>
                                    <td>Date of Appointment</td>
                                    <td>{{ $profile[0]->date_of_appointment !='' ? change_date_month_name_char(str_replace('/','-',$profile[0]->date_of_appointment)) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Treasurer</td>
                                    <td>{{ checkna($profile[0]->treasure) }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Banking details</th>
                                    <th colspan="2">Contact Information</th>

                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Account opening date</td>
                                    <td>{{$profile[0]->account_opening_date !='' ?  change_date_month_name_char(str_replace('/','-',$profile[0]->account_opening_date)) : 'N/A' }}</td>

                                    <td>Name of Contact</td>
                                    <td>{{ checkna($profile[0]->name_of_the_contact_person) }}</td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td>{{ checkna($profile[0]->name_of_the_bank) }}</td>

                                    <td>Designation</td>
                                    <td>{{ checkna($profile[0]->designation) }}</td>
                                </tr>
                                <tr>
                                    <td>Branch</td>
                                    <td>{{ checkna($profile[0]->branch) }}</td>

                                    <td>Contact Number</td>
                                    <td>{{ checkna($profile[0]->contact_number) }}</td>
                                </tr>
                                <tr>
                                    <td>Acc. No.</td>
                                    <td>{{ checkna($profile[0]->account_number) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                 {{-- governance start --}}
                 <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>GOVERNANCE</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-6">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Rule</th>

                                </tr>

                            </thead>
                            <tbody>
                                <tr height="65px">
                                    <td>Adoption of Rules</td>
                                    <td>{{ checkna($governance[0]->adoption_of_rules) }}</td>
                                </tr>
                                <tr height="65px">
                                    <td>Date of Adoption</td>
                                    <td>{{$governance[0]->date_adoption !='' ?  change_date_month_name_char(str_replace('/','-',$governance[0]->date_adoption)) : 'N/A' }}</td>
                                </tr>
                                <tr height="65px">
                                    <td>Written Rules</td>
                                    <td>{{ checkna($governance[0]->written_norms) }}</td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Details on Election</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Frequency as per norms</td>
                                    <td>{{ checkna($governance[0]->frequency_per_norms) }}</td>
                                </tr>
                                <tr>
                                    <td>First Election Date</td>
                                    <td>{{$governance[0]->first_election_date !='' ?  change_date_month_name_char(str_replace('/','-',$governance[0]->first_election_date)) :'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Last Election Date</td>
                                    <td>{{  $governance[0]->date_last_election !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->date_last_election)) :'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Last 2 Election Conducted As Per Norms</td>
                                    <td>{{ checkna($governance[0]->last_two_election_conducted) }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Meeting Details</th>

                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>Frequency of Meetings</td>
                                    <td>{{ checkZero($governance[0]->frequency_of_meetings) }}</td>
                                </tr>
                                <tr>
                                    <td>No. Of meetings in last 12 months</td>
                                    <td>{{ checkZero($governance[0]->meetings_cluster_conducted) }}</td>
                                </tr>
                                <tr>
                                    <td>Average participation of members in<br>
                                        12 months</td>
                                    <td>{{ checkZero($governance[0]->participation_members) }}</td>
                                </tr>

                            </tbody>

                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Status Of Minutes During Last 12 Months</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Separate minute book</td>
                                    <td>{{ checkna($governance[0]->minute_book_to_record_minute) }}</td>
                                </tr>
                                <tr>
                                    <td>Who writes the minutes?</td>
                                    <td>{{ checkna($governance[0]->who_writes_minutes) }}</td>
                                </tr>
                                <tr>
                                    <td>Status of group meetings recorded</td>
                                    <td>{{ checkna($governance[0]->meetings_recorded) }}</td>
                                </tr>


                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2" style="width: 50%;">Bank Accounts Details</th>
                                    <th colspan="2">Grade</th>

                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>Bank accounts is regular operation during last 12 months</td>
                                    <td style="background: #ccc7c7">{{ checkna($governance[0]->accounts_regular) }}</td>

                                    <td>Grade During Last 12 Months</td>
                                    <td style="background: #ccc7c7">{{ checkna($governance[0]->grading_cluster) }}</td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                    <div class="col-md-12">
                            <table class="table table-bordered  new-table-dg">
                                <thead>
                                    <tr>
                                        <th colspan="4">Social Audit Committee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Whether Cluster has a SAC</td>
                                        <td>{{ checkna($governance[0]->social_audit_committee) }}</td>
                                        <td>SAC formation date</td>
                                        <td width="25%">{{ $governance[0]->sac_created !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->sac_created)) : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Functions of SAC(describe)</td>
                                        <td>{{ $governance[0]->function_sac_a . ',' . $governance[0]->function_sac_b . ',' . $governance[0]->function_sac_c . ',' . $governance[0]->function_sac_d }}</td>
                                        <td>How many SAC reports prepared and submitted during last 12 months</td>
                                        <td>{{ checkZero($governance[0]->sac_reports_submitted) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date Of report </td>
                                        <td width="25%">{{  $governance[0]->date_last_report !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->date_last_report)) :'N/A' }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
    
                            <table class="table table-bordered  new-table-dg">
                                <thead>
                                    <tr>
                                        <th>Audit</th>
                                        <th width="30%">Internal</th>
                                        <th width="30%">External</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Internal/External Audit</td>
                                        <td>{{ checkna($governance[0]->internal_audit) }}</td>
                                        <td>{{ checkna($governance[0]->external_audit) }}</td>
                                    </tr>
                                    <tr>
                                        <td>How Often</td>
                                        <td>{{ checkna($governance[0]->internal_how_often) }}</td>
                                        <td>{{ checkna($governance[0]->external_how_often) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of internal audit during last 12 months</td>
                                        <td>{{ $governance[0]->date_internal_audit !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->date_internal_audit)) : 'N/A' }}</td>
                                        <td>{{ $governance[0]->date_last_audit_conducted !='' ?  change_date_month_name_char(str_replace('/','-',$governance[0]->date_last_audit_conducted)) : 'N/A'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Issues and observations raised during last 12 months (Describe)</td>
                                        <td>{{ checkna($governance[0]->internal_observations_raised) }}</td>
                                        <td>{{ checkna($governance[0]->external_observations_raised) }}</td>
                                    </tr>
                                    <tr>
                                        <td>How many issues were resolved (describe)</td>
                                        <td>{{ checkna($governance[0]->internal_issues_resolved) }}</td>
                                        <td>{{ checkna($governance[0]->external_issues_resolved) }}</td>
                                    </tr>

                                </tbody>

                            </table>

                            <table class="table table-bordered  new-table-dg">
                                <thead>
                                    <tr>
                                        <th colspan="2">Social Audit Committee</th>
                                        <th colspan="2" style="background: #ccc7c7;">Yes( If No below table won't show)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Whether Cluster has a SAC</td>
                                        <td>{{ checkna($governance[0]->social_audit_committee) }}</td>
                                        <td>SAC formation date</td>
                                        <td width="25%">{{ $governance[0]->sac_created !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->sac_created)) : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Functions of SAC(describe)</td>
                                        <td>{{ $governance[0]->function_sac_a . ',' . $governance[0]->function_sac_b . ',' . $governance[0]->function_sac_c . ',' . $governance[0]->function_sac_d }}</td>
                                        <td>How many SAC reports prepared and submitted during last 12 months</td>
                                        <td>{{ checkZero($governance[0]->sac_reports_submitted) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date Of report </td>
                                        <td width="25%">{{  $governance[0]->date_last_report !='' ? change_date_month_name_char(str_replace('/','-',$governance[0]->date_last_report)) :'N/A' }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered  new-table-dg">
                                <thead>
                                    <tr>
                                        <th colspan="4">Defunct SHG Status</th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total SHGs formed in cluster</td>
                                        <td>{{ checkZero($governance[0]->total_shgs_formed) }}</td>
                                        <td>At Present no of SHGs defunct</td>
                                        <td width="25%">{{ checkZero($governance[0]->shgs_defunct) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Defunct SHGs (%)</td>
                                        <td>{{ checkZero($governance[0]->defunct_shgs_par) }}%</td>
                                        <td>Reasons for defunct</td>
                                        <td>{{ checkna($governance[0]->defunct_shgs_reasons) }}</td>
                                    </tr>
                                </tbody>
                            </table>
    
                        </div>

                    </div>

                    {{-- incusion start --}}
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="text-center">
                                <h4><u>INCLUSION</u></h4>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <table class="table table-bordered  new-table-dg">
                                <thead>
                                    <tr>
                                        <th>Wealth Ranking/Poverty Mapping</th>
                                        <th style="background: #ccc7c7;">{{ checkna($inclusion[0]->wealth_ranking) }}</th>

                                    </tr>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1st Poverty Mapping</td>
                                        <td width="20%">{{ $inclusion[0]->first_poverty_mapping !='' ? change_date_month_name_char(str_replace('/','-',$inclusion[0]->first_poverty_mapping)) : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Last Update</td>
                                        <td>{{  $inclusion[0]->last_update !='' ? change_date_month_name_char(str_replace('/','-',$inclusion[0]->last_update)) : 'N/A'}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-4">
                            {{-- <h4 class="bg-white p-3 mb-0">Visual Poverty Mapping</h4> --}}
    
                            <table class="table table-bordered  new-table-dg">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: center;">
                                            Visual Poverty Mapping
                                        </th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                    <tr>
                                        <th>No of Poorest &
                                            Vulnerable</th>
                                        <td width="20%">{{ checkZero($inclusion[0]->visual_poorest_category) }}</td>    
                                    </tr>
    
                                    <tr>
                                        <th>No of Poor</th>
                                        <td>{{ checkZero($inclusion[0]->visual_poor_category) }}</td>
                                    </tr>    
    
                                    <tr>
                                        <th>No of Medium Poor</th>
                                        <td>{{ checkZero($inclusion[0]->visual_medium_category) }}</td>
                                    </tr>
    
                                    <tr>
                                        <th>No of Rich</th>
                                        <td>{{ checkZero($inclusion[0]->visual_rich_category) }}</td>
                                    </tr>
    
                                </tbody>
                            </table>
    
                        </div>
    
                        <div class="col-md-4">
                            {{-- <h4 class="bg-white p-3 mb-0">Caste Composition</h4> --}}
    
                            <table class="table table-bordered  new-table-dg">
                                <thead>
                                    <tr>
                                        <th colspan="2"  style="text-align: center;">
                                            Caste Composition
                                        </th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                    <tr>
                                        <th>No. Of SC/ST</th>
                                        <td>{{ checkZero($inclusion[0]->sc_st_caste) }}</td>
                                    </tr>
    
                                    <tr>
                                        <th>No Of OBC</th>
                                        <td>{{ checkZero($inclusion[0]->obc_caste) }}</td>
                                    </tr>
    
                                    <tr>
                                        <th>No Of Others</th>
                                        <td>{{ checkZero($inclusion[0]->other_caste) }}</td>
                                    </tr>
                                </tbody>
                            </table>
    
                        </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Cumulative No of Loans and Amounts During Last 3 Years</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th colspan="4" style="border-bottom-color: #cea38b;"></th>
                                    <th colspan="2" style="background: #ccc7c7;border-bottom-color: #ccc7c7;" >Cluster Loans
                                    </th>

                                    {{-- <th colspan="4">External Loans</th> --}}
                                    <th colspan="2"  style="background: #ccc7c7;border-bottom-color: #ccc7c7;">External Loans
                                    </th>
                                    <th colspan="2"  style="background: #ccc7c7;border-bottom-color: #ccc7c7;">Other Loans
                                    </th>
                                    <th colspan="2"  style="background: #ccc7c7;border-bottom-color: #ccc7c7;">Total Loans</th>
                                </tr>
                                <tr>
                                    <th colspan="4" style="border-bottom-color:#cea38b ;">Category</th>
                                    <th style="background: #ccc7c7;" colspan="2"></th>

                                    <th style="background: #ccc7c7;" colspan="2"></th>
                                    <th style="background: #ccc7c7;" colspan="2"></th>
                                    <th style="background: #ccc7c7;" colspan="2"></th>

                                </tr>
                                <tr>
                                    <th colspan="4"></th>
                                    <th>Loan
                                        Disbursed
                                        (#)
                                    </th>
                                    <th>Amount
                                        Disbursed
                                        (INR)</th>
                                    <th>Loan
                                        Disbursed
                                        (#)</th>
                                    <th>Amount
                                        Disbursed
                                        (INR)
                                    </th>
                                    <th>Loan
                                        Disbursed
                                        (#)</th>
                                    <th>Amount
                                        Disbursed
                                        (INR)</th>
                                    <th>
                                        Loan
                                        Disbursed
                                        (#)
                                    </th>
                                    <th>Amount
                                        Disbursed
                                        (INR)
                                    </th>
                                    {{-- <th>
                                        Loan
                                        Disbursed
                                        (#)
                                    </th>
                                    <th>
                                        Amount
                                        Disbursed
                                        (INR)
                                    </th> --}}
                                </tr>
                            </thead>

                            <tbody style="text-align: center">
                                <tr>
                                    <td colspan="4">Very Poor
                                        &
                                        Vulnerable</td>
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
                                <tr>
                                    <td colspan="4">Poor</td>
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
                                <tr>
                                    <td colspan="4">Medium
                                        Poor</td>
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
                                <tr>
                                    <td colspan="4">Rich</td>
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
                                <tr style="background:#ccc7c7 ">
                                    <td colspan="4">Total</td>
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
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">No. Of HHs Benefited From All Loans During Last 12 Years </h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th colspan="3" style="border-bottom-color: #cea38b;">Category</th>
                                    <th colspan="3" style="background: #cea38b;border-bottom-color: #cea38b;" >Cluster <br> Member HHs (#) 
                                    </th>

                                    <th colspan="6">Received Loan (#)
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="3" style="border-bottom-color:#cea38b ;"></th>
                                    <th colspan="3" style="border-bottom-color:#cea38b ;"></th>
                                    <th colspan="2">Cluster Loan </th>

                                    <th colspan="2">External Loan </th>
                                    <th colspan="2">Other Loan </th>

                                </tr>
                            </thead>

                            <tbody style="text-align: center">
                                <tr>
                                    <td colspan="3" style="text-align: left;">Very Poor
                                        &
                                        Vulnerable</td>
                                    <td colspan="3">{{ checkzero($inclusion[0]->visual_poorest_category) }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->federation_poorest_category_recloan }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->external_poorest_category_recloan }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->vi_poorest_category_recloan }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: left;">Poor</td>
                                    <td colspan="3">{{ checkzero($inclusion[0]->visual_poor_category) }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->federation_poor_category_recloan }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->external_poor_category_recloan }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->vi_poor_category_recloan }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: left;">Medium
                                        Poor</td>
                                    <td colspan="3">{{ checkzero($inclusion[0]->visual_medium_category) }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->federation_medium_recloan }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->external_medium_recloan }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->vi_medium_recloan }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: left;">Rich</td>
                                    <td colspan="3">{{ checkzero($inclusion[0]->visual_rich_category) }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->federation_rich_recloan }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->external_rich_recloan }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->vi_rich_recloan }}</td>
                                </tr>
                                <tr style="background:#ccc7c7 ">
                                    <td colspan="3" style="text-align: left;">Total</td>
                                    <td colspan="3">{{(int)$inclusion[0]->visual_poorest_category+(int)$inclusion[0]->visual_poor_category+(int)$inclusion[0]->visual_medium_category+(int)$inclusion[0]->visual_rich_category}}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->federation_poorest_category_recloan + (int) $inclusion[0]->federation_poor_category_recloan + (int) $inclusion[0]->federation_medium_recloan + (int) $inclusion[0]->rich_members_benefited_cluster }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->external_poorest_category_recloan + (int) $inclusion[0]->external_poor_category_recloan + (int) $inclusion[0]->external_medium_recloan + (int) $inclusion[0]->external_rich_recloan }}</td>
                                    <td colspan="2">{{ (int) $inclusion[0]->vi_poorest_category_recloan + (int) $inclusion[0]->vi_poor_category_recloan + (int) $inclusion[0]->vi_medium_recloan + (int) $inclusion[0]->vi_rich_recloan }}</td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>No of poor and most poor in Leadership position</th>
                                    <td style="background:#f1f0f0; width:15%;">{{ checkZero((int) $inclusion[0]->poor_current_leadership) }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Board Constitution</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Cluster Board
                                        Constitution</th>
                                    <th>Total no of Board
                                        members</th>
                                    <th>No of members from the
                                        poorest and vulnerable</th>
                                    <th> No of members
                                        from the poor</th>
                                    <th> No of members from
                                        middle and rich category</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr style="text-align: center;">
                                    <td>{{ checkna($inclusion[0]->board_members_constitution) }}</td>
                                    <td>{{ checkna($inclusion[0]->total_board_members) }}</td>
                                    <td>{{ checkna($inclusion[0]->poorest_board_members) }}</td>
                                    <td>{{ checkna($inclusion[0]->poor_board_members) }}</td>
                                    <td>{{ checkna($inclusion[0]->rich_board_members) }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    
                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Coverage of Target Population</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr style="text-align: center;">
                                    <th> Total target poor in the cluster</th>
                                    <th>No of target poor mobilized in SHGs</th>
                                    <th> % of target poor mobilized in SHGs</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr style="text-align: center;">
                                    <td>{{ checkZero($inclusion[0]->total_target_poor) }}</td>
                                    <td>{{ checkZero($inclusion[0]->target_poor_mobilized) }}</td>
                                    <td>{{ checkZero($inclusion[0]->percentage_poor_mobilized) }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>

                 {{-- EFFICIENCY start --}}
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>EFFICIENCY</u></h4>
                        </div>
                    </div>
                </div>
            
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Integrated Credit Plan</th>
                                    <th style="background: #ccc7c7; width:60%;">Yes or No</th>

                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>Date of last plan approved by Cluster</td>
                                    <td>{{ $efficiency[0]->date_approved !='' ? change_date_month_name_char(str_replace('/','-',$efficiency[0]->date_approved)) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Date it was submitted to Federation/Partner</td>
                                    <td>{{  $efficiency[0]->date_submitted !='' ?  change_date_month_name_char(str_replace('/','-',$efficiency[0]->date_submitted)) : 'N/A'}}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Training Details</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Name of training</th>
                                    <th>Duration (days)</th>
                                    <th>Date</th>
                                    <th>Training Recipient</th>
                                    <th>Name of Trainer</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (!empty($efficiency_1))
                                @foreach ($efficiency_1 as $row)
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
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Income and Expenses During last 12 Months</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr style="text-align: center;">
                                    <th width="50%">Income from all sources (INR)</th>
                                    <th>Expenses (INR)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr style="text-align: center;">
                                    <td>{{ checkZero($efficiency[0]->total_income) }}</td>
                                    <td>{{ checkZero($efficiency[0]->expense) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Approval Process</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>No of days taken to approve loan
                                        application at Cluster</th>
                                    <th> Average Monthly loans during
                                        last 12 months</th>
                                    <th>Time taken from approval to
                                        cash in hand (days)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr style="text-align: center;">
                                    <td>{{ checkZero($efficiency[0]->time_taken_to_approve_loan) }}</td>
                                    <td>{{ checkZero($efficiency[0]->loans_approved) }}</td>
                                    <td>{{ checkZero($efficiency[0]->time_taken_to_give_loan) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="40%">Monthly Report Submitted (Date of
                                        last submitted report)</th>
                                    <td style="background:#f1f0f0; width:30%; ">Yes or No</td>
                                    <td style="background:#f1f0f0 ">{{ $efficiency[0]->last_report_submitted !='' ?  change_date_month_name_char(str_replace('/','-',$efficiency[0]->last_report_submitted)) : 'N/A'}}
                                    </td>

                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>

                {{-- CREDIT HISTORY start --}}
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>CREDIT HISTORY</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="80%">No of loan applications received at Cluster during last 12 months</th>
                                    <th style="background: #ccc7c7; width:60%;">{{ checkZero($creditrecovery[0]->applications_received_loans) }}</th>

                                </tr>
                                <tr>
                                    <th> No of loan applications approved during last 12 months</th>
                                    <th style="background: #ccc7c7; width:60%;">{{ checkZero( $creditrecovery[0]->approved_loan )}}</th>

                                </tr>
                                <tr>
                                    <th>Pending loan applications</th>
                                    <th style="background: #ccc7c7; width:60%;">{{ checkZero( $creditrecovery[0]->pending_loan_applications) }}</th>

                                </tr>

                            </thead>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">No of Cumulative Loans Disbursed to Members During Last 3 Years</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr style="text-align: center;">
                                    <th style="text-align: left; width:25%;">Category</th>
                                    <th width="15%"> Very Poor &
                                        Vulnerable</th>
                                    <th>Poor</th>
                                    <th>Medium Poor</th>
                                    <th>Rich</th>
                                    <th>Total Loans (#)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr style="text-align: center;">
                                    <td style="text-align: left; background-color:#ccc7c7;">Cluster Loans</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_cluster }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ai }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5aii }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5aiii }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_cluster + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ai + (int) $creditrecovery[0]->new_cluster_creditHistory_question5aii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5aiii }}</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td style="text-align: left; background-color:#ccc7c7;">Federation Loans</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_federation }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5bi }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5bii }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5biii }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_federation + (int) $creditrecovery[0]->new_cluster_creditHistory_question5bi + (int) $creditrecovery[0]->new_cluster_creditHistory_question5bii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5biii }}</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td style="text-align: left; background-color:#ccc7c7;">Bank Loans</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_bank }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ci }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5cii }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ciii }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_bank + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ci + (int) $creditrecovery[0]->new_cluster_creditHistory_question5cii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ciii }}</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td style="text-align: left; background-color:#ccc7c7;">Others</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_other }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ei }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5eii }}</td>
                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5eiii }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_other + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ei + (int) $creditrecovery[0]->new_cluster_creditHistory_question5eii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5eiii }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-5">
                        <h4 class="bg-white p-3 mb-0">Cumulative Loan Amount</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Institution
                                    </th>
                                    <th>Amount (INR)</th>

                                </tr>


                            </thead>

                            <tbody>
                                <tr>
                                    <td style="text-align: center;">1</td>
                                    <td>Internal</td>
                                    <td style="text-align: center;">{{ checkZero($creditrecovery[0]->cumulative_amount_cluster) }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">2</td>
                                    <td>Federation</td>
                                    <td style="text-align: center;">{{ checkZero($creditrecovery[0]->cumulative_amount_federation) }}</td>

                                </tr>
                                <tr>
                                    <td style="text-align: center;">3</td>
                                    <td>Bank</td>
                                    <td style="text-align: center;">{{ checkZero($creditrecovery[0]->cumulative_amount_bank) }}</td>

                                </tr>
                                <tr>
                                    <td style="text-align: center;">4</td>
                                    <td>Others</td>
                                    <td style="text-align: center;">{{ checkZero($creditrecovery[0]->cumulative_amount_other) }}</td>

                                </tr>

                                <tr style="background:#ccc7c7 ">
                                    <td colspan="2">Total</td>
                                    <td style="text-align: center;">{{ checkZero($creditrecovery[0]->total_cumulative_amount) }}</td>


                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-7">
                        <h4 class="bg-white p-3 mb-0">No of Member HHs Received Loans During Last 3 <br>
                            Years</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Institution</th>
                                    <th>Institution</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr style="text-align: center;">
                                    <td>1</td>
                                    <td>Cluster Loan</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_poor_members_cluster }}</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td>2</td>
                                    <td>Federation Loan</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_poor_members_federation }}</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td>3</td>
                                    <td>Bank Loan</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_poor_members_bank }}</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td>4</td>
                                    <td>Other Loan</td>
                                    <td>{{ (int) $creditrecovery[0]->cumulative_poor_members_other }}</td>
                                </tr>
                                <tr style="background:#ccc7c7; text-align:center">
                                    <td colspan="2">Total</td>
                                    <td>{{ (int) $creditrecovery[0]->total_cumulative_poor_members }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Demand Collection Balance (DCB) For repayment and Current Loan
                            Outstanding
                        </h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr style="text-align: center">
                                    <th>S. No.</th>
                                    <th>DCB</th>
                                    <th>Cluster Loan</th>
                                    <th>Federation Loan</th>
                                    <th>Bank Loan</th>
                                    <th>Other Loans</th>
                                    <th>Summary
                                        Loan
                                        Portfolio</th>
                                </tr>
                            </thead>

                            <tbody style="text-align:center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left">Total Loan Amount Given (INR)</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_loan_amount }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_loan_amount }}</td>
                                    <td>{{ (int) $creditrecovery[0]->bank_loan_amount }}</td>
                                    <td>{{ (int) $creditrecovery[0]->other_loan_amount }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_loan_amount + (int) $creditrecovery[0]->federation_loan_amount + (int) $creditrecovery[0]->bank_loan_amount + (int) $creditrecovery[0]->vi_loan_amount + (int) $creditrecovery[0]->other_loan_amount }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left">Total Demand upto last month
                                        for active loans (INR)</td>
                                    <td>{{ (int) $creditrecovery[0]->dcb_cluster }}</td>
                                    <td>{{ (int) $creditrecovery[0]->dcb_federation }}</td>
                                    <td>{{ (int) $creditrecovery[0]->dcb_bank }}</td>
                                    <td>{{ (int) $creditrecovery[0]->dcb_other }}</td>
                                    <td>{{ (int) $creditrecovery[0]->dcb_cluster + (int) $creditrecovery[0]->dcb_federation + (int) $creditrecovery[0]->dcb_bank + (int) $creditrecovery[0]->dcb_vi + (int) $creditrecovery[0]->dcb_other }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left">Actual Amount Paid upto last
                                        month (INR)</td>
                                    <td>{{ (int) $creditrecovery[0]->repaid_cluster }}</td>
                                    <td>{{ (int) $creditrecovery[0]->repaid_federation }}</td>
                                    <td>{{ (int) $creditrecovery[0]->repaid_bank }}</td>
                                    <td>{{ (int) $creditrecovery[0]->repaid_other }}</td>
                                    <td>{{ (int) $creditrecovery[0]->repaid_cluster + (int) $creditrecovery[0]->repaid_federation + (int) $creditrecovery[0]->repaid_bank + (int) $creditrecovery[0]->repaid_vi + (int) $creditrecovery[0]->repaid_other }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left">Overdue Amount (INR)</td>
                                    <td>{{ (int) $creditrecovery[0]->overdue_amount_cluster }}</td>
                                    <td>{{ (int) $creditrecovery[0]->overdue_amount_federation }}</td>
                                    <td>{{ (int) $creditrecovery[0]->overdue_amount_bank }}</td>
                                    <td>{{ (int) $creditrecovery[0]->overdue_amount_other }}</td>
                                    <td>{{ (int) $creditrecovery[0]->overdue_amount_cluster + (int) $creditrecovery[0]->overdue_amount_federation + (int) $creditrecovery[0]->overdue_amount_bank + (int) $creditrecovery[0]->overdue_amount_vi + (int) $creditrecovery[0]->overdue_amount_other }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td style="text-align: left">Outstanding amount for active
                                        loans (INR)</td>
                                    <td>{{ (int) $creditrecovery[0]->outstanding_amount_cluster }}</td>
                                    <td>{{ (int) $creditrecovery[0]->outstanding_amount_federation }}</td>
                                    <td>{{ (int) $creditrecovery[0]->outstanding_amount_bank }}</td>
                                    <td>{{ (int) $creditrecovery[0]->outstanding_amount_other }}</td>
                                    <td>{{ (int) $creditrecovery[0]->outstanding_amount_cluster + (int) $creditrecovery[0]->outstanding_amount_federation + (int) $creditrecovery[0]->outstanding_amount_bank + (int) $creditrecovery[0]->outstanding_amount_vi + (int) $creditrecovery[0]->outstanding_amount_other }}</td>
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
                                <tr>
                                    <td>6</td>
                                    <td style="text-align: left">Repayment Ratio %</td>
                                    <td>{{ Checkper($creditrecovery[0]->cluster_repayment_rate)."%" }}</td>
                                    <td>{{ Checkper($creditrecovery[0]->federation_repayment_rate)."%" }}</td>
                                    <td>{{ Checkper($creditrecovery[0]->bank_repayment_rate)."%" }}</td>
                                    <td>{{ Checkper($creditrecovery[0]->other_repayment_rate)."%" }}</td>
                                    <td>{{ $g . '%' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0"> No. of Members Not Received Even a Single Loan During Last 3 Years</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr style="text-align: center">
                                    <th width="6%">S. No.</th>
                                    <th width="25%" style="text-align: left">Loan Type</th>
                                    <th colspan="4" style="text-align: left">Wealth Ranking</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody style="text-align:center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left; background-color:#ccc7c7;">Cluster Loans</td>
                                    <td style="background-color:#ccc7c7; width:15%;">Very poor &
                                        vulnerable</td>
                                    <td style="background-color:#ccc7c7;">Poor</td>
                                    <td style="background-color:#ccc7c7;">Medium
                                        Poor</td>
                                    <td style="background-color:#ccc7c7;">Rich</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">Last 12 months</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_poorest_members_not_received_cluster_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_poor_members_not_received_cluster_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_medium_members_not_received_cluster_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_rich_members_not_received_cluster_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_total_members_not_received_cluster_loan_year1 }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">Year before last</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_poorest_members_not_received_cluster_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_poor_members_not_received_cluster_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_medium_members_not_received_cluster_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_rich_members_not_received_cluster_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_total_members_not_received_cluster_loan_year2 }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">2 Years before last</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_poorest_members_not_received_cluster_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_poor_members_not_received_cluster_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_medium_members_not_received_cluster_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_rich_members_not_received_cluster_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_total_members_not_received_cluster_loan_year3 }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left; background-color:#ccc7c7;">Federation Loans</td>
                                    <td style="background-color:#ccc7c7;">Very poor &
                                        vulnerable</td>
                                    <td style="background-color:#ccc7c7;">Poor</td>
                                    <td style="background-color:#ccc7c7;">Medium
                                        Poor</td>
                                    <td style="background-color:#ccc7c7;">Rich</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">Last 12 months</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_federation_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_federation_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_federation_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_federation_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_federation_loan_year1 }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">Year before last</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_federation_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_federation_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_federation_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_federation_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_federation_loan_year2 }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">2 Years before last</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_federation_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_federation_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_federation_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_federation_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_federation_loan_year3 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        {{-- <h4 class="bg-white p-3 mb-0"> No. of Members Not Received Even a Single Loan During Last 3 Years</h4> --}}

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr style="text-align: center">
                                    <th width="6%">S. No.</th>
                                    <th width="25%" style="text-align: left">Loan Type</th>
                                    <th colspan="4" style="text-align: left">Wealth Ranking</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody style="text-align:center">
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left; background-color:#ccc7c7;">Bank Loans</td>
                                    <td style="background-color:#ccc7c7; width:15%;">Very poor &
                                        vulnerable</td>
                                    <td style="background-color:#ccc7c7;">Poor</td>
                                    <td style="background-color:#ccc7c7;">Medium
                                        Poor</td>
                                    <td style="background-color:#ccc7c7;">Rich</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">Last 12 months</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_bank_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_bank_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_bank_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_bank_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_bank_loan_year1 }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">Year before last</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_bank_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_bank_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_bank_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_bank_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_bank_loan_year2 }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">2 Years before last</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_bank_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_bank_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_bank_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_bank_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_bank_loan_year3 }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left; background-color:#ccc7c7;">Other Loans</td>
                                    <td style="background-color:#ccc7c7;">Very poor &
                                        vulnerable</td>
                                    <td style="background-color:#ccc7c7;">Poor</td>
                                    <td style="background-color:#ccc7c7;">Medium
                                        Poor</td>
                                    <td style="background-color:#ccc7c7;">Rich</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">Last 12 months</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_other_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_other_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_other_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_other_loan_year1 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_other_loan_year1 }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">Year before last</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_other_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_other_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_other_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_other_loan_year2 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_other_loan_year2 }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left">2 Years before last</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_other_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_other_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_other_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_other_loan_year3 }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_other_loan_year3 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-5">
                        <h4 class="bg-white p-3 mb-0">Loan Default
                        </h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Institution
                                    </th>
                                    <th>No of
                                        Members</th>
                                    <th>No of
                                        Loans</th>

                                </tr>


                            </thead>

                            <tbody style="text-align: center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Cluster</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_loan_default_member }}</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_loan_default_no }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Federation</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_loan_default_member }}</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_loan_default_no }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">Bank</td>
                                    <td>{{ (int) $creditrecovery[0]->bank_loan_default_member }}</td>
                                    <td>{{ (int) $creditrecovery[0]->bank_loan_default_no }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">Other</td>
                                    <td>{{ (int) $creditrecovery[0]->other_loan_default_member }}</td>
                                    <td>{{ (int) $creditrecovery[0]->other_loan_default_no }}</td>
                                </tr>

                                <tr style="background:#ccc7c7 ">
                                    <td colspan="2">Total</td>
                                    <td>{{ (int) $creditrecovery[0]->other_loan_default_member + (int) $creditrecovery[0]->bank_loan_default_member + (int) $creditrecovery[0]->federation_loan_default_member + (int) $creditrecovery[0]->cluster_loan_default_member }}</td>
                                    <td>{{ (int) $creditrecovery[0]->other_loan_default_no + (int) $creditrecovery[0]->bank_loan_default_no + (int) $creditrecovery[0]->federation_loan_default_no + (int) $creditrecovery[0]->cluster_loan_default_no }}</td>

                                </tr>

                            </tbody>
                        </table>



                    </div>
                    <div class="col-md-7">
                        <h4 class="bg-white p-3 mb-0">PAR Status for more than 90 days in amount</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Loan Type
                                    </th>
                                    <th>Amount (INR)</th>
                                    <th>Percentage (%)</th>
                                </tr>


                            </thead>

                            <tbody style="text-align: center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Cluster</td>
                                    <td>{{ (int) $creditrecovery[0]->overdue_a }}</td>
                                    <td>{{ Checkper((float) $creditrecovery[0]->cluster_loan_par) }}%</td>

                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Federation</td>
                                    <td>{{ (int) $creditrecovery[0]->overdue_b }}</td>
                                    <td>{{ Checkper((float) $creditrecovery[0]->federation_loan_par) }}%</td>

                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">Bank</td>
                                    <td>{{ (int) $creditrecovery[0]->overdue_c }}</td>
                                    <td>{{ Checkper((float) $creditrecovery[0]->bank_loan_par) }}%</td>

                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">Other</td>
                                    <td>{{ (int) $creditrecovery[0]->overdue_e }}</td>
                                    <td>{{ Checkper((float) $creditrecovery[0]->other_loan_par) }}%</td>

                                </tr>

                                <tr style="background:#ccc7c7 ">
                                    <td colspan="2">Total</td>
                                    <td>{{ (int) $creditrecovery[0]->overdue_a + (int) $creditrecovery[0]->overdue_b + (int) $creditrecovery[0]->overdue_c + (int) $creditrecovery[0]->overdue_e }}</td>
                                    <td>{{ Checkper((float) $creditrecovery[0]->cluster_loan_par +(float) $creditrecovery[0]->federation_loan_par +(float) $creditrecovery[0]->bank_loan_par +(float) $creditrecovery[0]->vi_loan_par + (float) $creditrecovery[0]->other_loan_par)}}</td>

                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-5">
                        <h4 class="bg-white p-3 mb-0">Purpose of All Loans During Last 12
                            Months</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Purpose
                                    </th>
                                    <th>All loans (Cluster &
                                        External)</th>

                                </tr>


                            </thead>

                            <tbody>
                                <tr>
                                    <td style="text-align: center;">1</td>
                                    <td>Productive</td>
                                    <td style="text-align: center;">{{ (int) $creditrecovery[0]->productive }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">2</td>
                                    <td>Consumption</td>
                                    <td style="text-align: center;">{{ (int) $creditrecovery[0]->consumption }}</td>

                                </tr>
                                <tr>
                                    <td style="text-align: center;">3</td>
                                    <td>Debt
                                        Swapping</td>
                                    <td style="text-align: center;">{{ (int) $creditrecovery[0]->debt_swapping }}</td>

                                </tr>
                                <tr>
                                    <td style="text-align: center;">4</td>
                                    <td>Others</td>
                                    <td style="text-align: center;">{{ (int) $creditrecovery[0]->other_Purposes }}</td>

                                </tr>

                                <tr style="background:#ccc7c7; text-align: center;">
                                    <td colspan="2">Total</td>
                                    <td style="text-align: center;">{{ (int) $creditrecovery[0]->productive + (int) $creditrecovery[0]->consumption + (int) $creditrecovery[0]->debt_swapping + (int) $creditrecovery[0]->other_Purposes }}</td>


                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-7">
                        <h4 class="bg-white p-3 mb-0">Cumulative Interest Income</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Institution</th>
                                    <th>Income Generated
                                        Amount (INR)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr style="text-align: center;">
                                    <td>1</td>
                                    <td>Cluster</td>
                                    <td>{{ (int) $creditrecovery[0]->cluster_cumulative_interest }}</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td>2</td>
                                    <td>Federation</td>
                                    <td>{{ (int) $creditrecovery[0]->federation_cumulative_interest }}</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td>3</td>
                                    <td>Bank</td>
                                    <td>{{ (int) $creditrecovery[0]->vi_cumulative_interest }}</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td>4</td>
                                    <td>Other</td>
                                    <td>{{ (int) $creditrecovery[0]->other_cumulative_interest }}</td>
                                </tr>
                                <tr style="background:#ccc7c7; text-align:center">
                                    <td colspan="2">Total</td>
                                    <td>{{ (int) $creditrecovery[0]->total_cumulative_interest }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Average Loan Number And Amount During Last 12 Months</th>
                                    <td style="background: #ccc7c7; width:15%;  text-align:center;">{{ checkZero($creditrecovery[0]->average_loan_amount) }}</td>
                                </tr>
                            </thead>
                        </table>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Min and Max Loan Amounts During Last 12 Months
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="background: #ccc7c7;">Max Amount (INR)</td>
                                    <td style="text-align: center;  width:15%;">{{ checkZero((int) $creditrecovery[0]->minimum_amount) }}</td>
                                    <td style="background: #ccc7c7">Min Amount (INR)</td>
                                    <td style="text-align: center; width:15%;">{{ checkZero((int) $creditrecovery[0]->maximum_amount) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Members taken more than one Loan During Last 3 Years </th>
                                    <td style="background: #ccc7c7; width:30%; text-align:center;">{{ checkZero((int) $creditrecovery[0]->members_more_than_one) }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>

                {{-- SAVING start --}}
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>SAVING</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Compulsory Savings</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td width="30%">Compulsory Savings</td>
                                    <td>{{ checkZero($saving[0]->compulsory_savings) }}</td>
                                    <td width="30%">Amount of savings per month (INR)</td>
                                    <td>{{ checkZero($saving[0]->amount_of_compulsory) }}</td>
                                </tr>
                                <tr>
                                    <td>Average Monthly Savings during last 12
                                        months (INR)</td>
                                    <td>{{ checkZero($saving[0]->trend) }}</td>
                                    <td>Cumulative Savings since inception (INR)</td>
                                    <td>{{ checkZero($saving[0]->compulsory_savings_inception) }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Voluntary Savings</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td width="30%">Voluntary Savings</td>
                                    <td>{{ $saving[0]->voluntary_savings !='' ?  $saving[0]->voluntary_savings : 'N/A' }}</td>
                                    <td width="30%">Average Amount of Savings per
                                        month (INR)</td>
                                    <td>{{ $saving[0]->amount_of_voluntary }}</td>
                                </tr>
                                <tr>
                                    <td>Cumulative savings to-date inception
                                        (INR)</td>
                                    <td>{{ checkZero( $saving[0]->voluntary_savings_inception) }}</td>
                                    <td>Interest paid to members (Y/N)</td>
                                    <td>{{ checkZero(!empty($saving[0]->interest_paid)) }}</td>
                                </tr>
                                <tr>
                                    <td>No of members contribute to
                                        voluntary savings</td>
                                    <td>{{ checkZero(!empty($saving[0]->no_of_shg_member)) }}</td>
                                    <td>Are savings redistributed to
                                        members (Y/N)</td>
                                    <td>{{ checkna(!empty($saving[0]->savings_redistributed)) }}</td>
                                </tr>
                                <tr>
                                    <td> Date voluntary savings established</td>
                                    <td>{{ $saving[0]->date_voluntary_saving !='' ?  change_date_month_name_char(str_replace('/','-',$saving[0]->date_voluntary_saving)) : 'N/A'}}</td>
                                    <td> Date of last Redistribution</td>
                                    <td>{{$saving[0]->date_last_distribution !='' ?  change_date_month_name_char(str_replace('/','-',$saving[0]->date_last_distribution )) :'N/A' }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="3">Loan Security Fund (LSF)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Loan Security Fund (LSF)</td>
                                    <td width="30%">{{ checkna($saving[0]->loan_security_fund) }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Date it was established</td>
                                    <td>{{$saving[0]->date_established !='' ?  change_date_month_name_char(str_replace('/','-',$saving[0]->date_established )) :'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Amount available in LSF</td>
                                    <td>{{ checkZero($saving[0]->amount_available) }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>No of members contribute to LSF</td>
                                    <td>{{ checkZero($saving[0]->members) }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>No of members benefited from LSF</td>
                                    <td>{{ checkZero($saving[0]->members_benefitted) }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>

                 {{-- CHALLENGES & ACTION PLAN start --}}
                 <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>CHALLENGES & ACTION PLAN</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Action Plan To Address The Challenges</h4> 

                       <table class="table table-bordered  new-table-dg">
                            <thead>
                                @php
                                $count = count($challenges);
                                $i = 1;
                                @endphp
                                <tr class="text-center">
                                    <th>S. No</th>
                                    <th>Action Plan</th>
                                    {{-- <th>Challenge 1: Fill here</th>
                                    <th>Challenge 2: Fill here</th> --}}
                                    @if (!empty($challenges))
                                        @foreach ($challenges as $row)
                                            <th>Challenge {{ $i }} : {{ $row->challenge }}</th>
                                        @endforeach
                                    @endif
                                </tr>

                            </thead>

                            <tbody>
                                @if (!empty($challenges_actions))
                                    @foreach ($challenges_actions as $key => $row)
                                        <tr>
                                            <td style="text-align: center;">{{ $key + 1 }}</td>
                                            {{-- <td>Describe Action</td>
                                    <td></td>
                                    <td></td> --}}
                                            <td>{{ $row['name'] }}</td>
                                            @if (!empty($row['action']))
                                                @foreach ($row['action'] as $val)
                                                    <td>{{ $val != '' ? $val : 'N/A' }}</td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                                {{-- <tr>
                                    <td>2</td>
                                    <td>Person Responsible</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Completion Date</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Support needed from project office</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>What kind of support?</td>
                                    <td></td>
                                    <td></td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- OBSERVATIONS start --}}
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>OBSERVATIONS</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th class="text-center">S.No</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1a</td>
                                    <td>How many members attended the cluster
                                        meeting?</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_meeting) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1b</td>
                                    <td> Were all office bearers and leaders present?</td>
                                    <td> 
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
                                        {{ $strdesg }}</td>
                                    @endforeach
                                    @else
                                    <td>N/A</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Did Cluster leaders understand the Purpose of
                                        the meeting ? </td>
                                    <td>{{ checkna($observation[0]->cluster_observation_carried_out) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>What was quality of Discussion? Did everyone
                                        participate?</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_leaders_only) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">4a</td>
                                    <td>Where Cluster leaders aware of their rules and
                                        norms? Did they understand vision of their
                                        Cluster?</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_Cluster) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">4b</td>
                                    <td>Do they understand benefits of being part of the
                                        Cluster ? Explain</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_benefits) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">5a</td>
                                    <td>Do they have a set of important practices for
                                        repayment and savings?</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_paid_time) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">5b</td>
                                    <td>What are those practices?</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_practices) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">6a</td>
                                    <td>Does this Cluster include members who are the
                                        most poor and vulnerable? </td>
                                    <td>{{ checkna($observation[0]->cluster_observation_provided_them) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">6b</td>
                                    <td>What is their policy to help them?</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_policy_explain) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">7a</td>
                                    <td>Does Cluster have a satisfactory/weak or good
                                        system of reporting and updating of documents?</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_documents) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">7b</td>
                                    <td>Who writes these books and minutes of
                                        meetings?</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_minutes_meetings) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">8a</td>
                                    <td>Are books of account manages by the booker
                                        only or are other office bearers aware of their
                                        financial information</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_updated_records) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">8b</td>
                                    <td>Any highlights</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_leaders_office) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">9a</td>
                                    <td>Did you notice any unique features and
                                        practices that make it special ?</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_special) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">9b</td>
                                    <td>What are those special practices?</td>
                                    <td>{{ checkna($observation[0]->cluster_observation_support_groups) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Summary of important 3- 5 highlights (positive and improvement points) about
                                        this Federation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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
                    </div>
                </div>

                
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

            pdf.save("SHG-Profile.pdf");
        });
    };
   
</script>

