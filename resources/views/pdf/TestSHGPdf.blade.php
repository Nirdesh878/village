<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SHG Details </title>
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
                            <h3>SHG PROFILE AND ASSESSMENT</h3>
                            {{-- <p><b>UIN ({{ $shg->uin }})</u>
                                    </h2></b></p> --}}
                            <h4><u>BASIC INFORMATION</u></h4>
                        </div>

                    </div>
                    <div  style="display: flex;position:relative;left:75%;top:-86px;">
                        <div class="text-center" style="border: 1px black solid;height:50px;width:100px;background: #cea38b; margin-top: -10px; margin-left: 95px">
                            <h5>Report Card</h5>
                        </div>
                        <div style="border: 1px black solid;height:50px;width:70px;background:{{ $total_show }}; margin-top: -10px;">

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
                                    <td width="25%">{{ $shg->uin }}</td>

                                    <th width="25%">Name</th>
                                    <td width="25%">{{ $profile[0]->shgName }} </td>
                                </tr>
                              
                                <tr>
                                    <th>Cluster</th>
                                    <td>{{ !empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A' }}
                                    </td>

                                    <th>Federation</th>
                                    <td>{{ $fed_profile[0]->name_of_federation }} </td>
                                </tr>
                               
                                <tr>
                                    <th>Village</th>
                                    <td>{{ $profile[0]->village }} </td>

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
                                    <td>{{ $profile[0]->shg_code }}</td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5" >
                        <table class="table table-bordered  new-table-dg" style="border: 2px black solid;">
                            <thead>
                                <tr>
                                    <th colspan="2">SHG Creation & Membership</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Date of Creation</td>
                                    <td>{{ change_date_month_name_char(str_replace('/', '-', $profile[0]->formed)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>No of Members at the time of Creation</td>
                                    <td>{{ $profile[0]->members_at_creation }}</td>
                                </tr>
                                <tr>
                                    <td>No of current Members</td>
                                    <td>{{ $profile[0]->current_members }}</td>
                                </tr>
                                <tr>
                                    <td>No of members from same<br>
                                        Neighborhood</td>
                                    <td>{{ $profile[0]->members_neighborhood }}</td>
                                </tr>
                                <tr>
                                    <td>No of members left since creation</td>
                                    <td>{{ $profile[0]->members_left }}</td>
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
                                    <td>{{ $profile[0]->book_keeper_date != '' ? change_date_month_name_char(str_replace('/', '-', $profile[0]->book_keeper_date)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Treasurer</td>
                                    <td>{{ checkna($profile[0]->treasure) }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Banking details</th>

                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Account opening date</td>
                                    <td>{{ change_date_month_name_char(str_replace('/', '-', $profile[0]->bank_date)) }}
                                    </td>
                                    <td>Account number</td>
                                    <td>{{ checkna($profile[0]->bank_ac_no) }}</td>
                                </tr>
                                <tr>
                                    <td>Name of the bank</td>
                                    @if ($profile[0]->bank_name != 'Other')
                                        <td>{{ checkna($profile[0]->bank_name) }}</td>
                                    @else
                                        <td>{{ checkna($profile[0]->other_bank_name) }}</td>
                                    @endif
                                    <td>Name of the branch</td>
                                    <td>{{ checkna($profile[0]->bank_branch) }}</td>
                                </tr>
                            </tbody>
                        </table>


                        {{-- <h4 class="bg-white p-3 mb-0">Banking Details</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Account Head</th>
                                    <th>Type</th>
                                    <th>Opening date</th>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Acc. No.</th>
                                    <th>IFCS Code </th>
                                    <th>Regular Operation</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>President</td>
                                    <td>Name</td>
                                </tr>
                                <tr>
                                    <td>Secretary</td>
                                    <td>Date of Appointment</td>
                                </tr>
                            </tbody>
                        </table> --}}



                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-5" style="margin-top: -68px;">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Agency That Formed SHG</th>

                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <th>{{ checkna($agency_profile[0]->agency_name) }}</th>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="col-md-7">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Whether SHG Has Been Restructured</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Whether SHG Has Been<br>
                                        Restructured</td>
                                    <td>
                                        @if ($profile[0]->shg_basicProfile_restructured != '')
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
                                </tr>
                                <tr class="date_of_restructuring">
                                    <td>Date of Restructuring</td>
                                    <td>{{ $profile[0]->shg_basicProfile_restructured != '' ? change_date_month_name_char(str_replace('/', '-', $profile[0]->shg_basicProfile_restructured)) : 'N/A' }}
                                    </td>
                                </tr>

                            </tbody>
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
                                    <th colspan="2">SHG rule</th>

                                </tr>

                            </thead>
                            <tbody>
                                <tr height="65px">
                                    <td>Adoption of Rules</td>
                                    <td>{{ checkna($governance[0]->adoption_rules) }}</td>
                                </tr>
                                <tr height="65px">
                                    <td>Date of Adoption</td>
                                    <td>{{ $governance[0]->adoption_date != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->adoption_date)) : 'N/A' }}
                                    </td>
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
                                    <td>{{ checkna($governance[0]->election_frequency) }}</td>
                                </tr>
                                <tr>
                                    <td>First Election /Selection Date</td>
                                    <td>{{ $governance[0]->first_election_date != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->first_election_date)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Election/Selection conducted so far</td>
                                    <td>{{ checkna($governance[0]->no_of_election_conducted) }}</td>
                                </tr>
                                <tr>
                                    <td>Last Election/Selection Date</td>
                                    <td>{{ $governance[0]->last_election_date != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->last_election_date)) : 'N/A' }}
                                    </td>
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
                                    <td>{{ checkZero($governance[0]->meetings_frequency_spinner) }}</td>
                                </tr>
                                <tr>
                                    <td>No. Of meetings in last 12 months</td>
                                    <td>{{ checkZero($governance[0]->no_of_meeting_conducted) }}</td>
                                </tr>
                                <tr>
                                    <td>Average participation of members in<br>
                                        12 months</td>
                                    <td>{{ checkZero($governance[0]->average_participation) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Meetings Recorded</td>
                                    <td>{{ checkZero($governance[0]->meetings_recorded) }}
                                    </td>
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
                                    <td>Who writes the minutes?</td>
                                    <td>{{ $governance[0]->who_writes_minutes != '' ? $governance[0]->who_writes_minutes : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td>{{ $governance[0]->other_writes_minutes != '' ? $governance[0]->other_writes_minutes : 'N/A' }}
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Updating of Books of Accounts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="25%">How often books updated</td>
                                    <td>{{ checkna($governance[0]->how_book_updated) }}</td>
                                </tr>
                                <tr>
                                    <td>Date of last update</td>
                                    <td>{{ $governance[0]->date_last_update_book != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_last_update_book)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Updated Status</td>
                                    <td>{{ checkna($governance[0]->shg_updated_status) }}
                                    </td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Bank Accounts In Regular Operation During last 12 months</th>
                                    <th colspan="2">Grade</th>

                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>Bank accounts is regular operation during last 12 months</td>
                                    <td style="background: #ccc7c7">{{ checkna($governance[0]->passbook_updated) }}
                                    </td>

                                    <td>Grade During Last 12 Months</td>
                                    <td style="background: #ccc7c7">{{ checkna($governance[0]->grading) }}</td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Audit</th>
                                    <th>Internal</th>
                                    <th>External</th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>Whether conducted (Y/N)</td>
                                    <td>{{ checkna($governance[0]->internal_audit) }}</td>
                                    <td>{{ checkna($governance[0]->external_audit) }}</td>
                                </tr>
                                <tr class="audit_date">
                                    <td>Date of audit</td>
                                    <td>{{ $governance[0]->internal_audit_date != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->internal_audit_date)) : 'N/A' }}
                                    </td>
                                    <td>{{ $governance[0]->external_audit_date != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->external_audit_date)) : 'N/A' }}
                                    </td>
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
                                    <th style="background: #ccc7c7; width: 20%;">{{ $inclusion[0]->wealth_ranking }}</th>

                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>1st Poverty Mapping</td>
                                    <td width="20%">{{ $inclusion[0]->poverty_mapping_date != '' ? change_date_month_name_char(str_replace('/', '-', $inclusion[0]->poverty_mapping_date)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last Update</td>
                                    <td>{{ $inclusion[0]->wealth_last_update_date != '' ? change_date_month_name_char(str_replace('/', '-', $inclusion[0]->wealth_last_update_date)) : 'N/A' }}
                                    </td>
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
                                    <td width="20%">{{ checkZero($inclusion[0]->no_of_visual_poorest) }}</td>    
                                </tr>

                                <tr>
                                    <th>No of Poor</th>
                                    <td>{{ checkZero($inclusion[0]->no_of_visual_poor) }}</td>
                                </tr>    

                                <tr>
                                    <th>No of Medium Poor</th>
                                    <td>{{ checkZero($inclusion[0]->no_of_visual_medium_poor) }}</td>
                                </tr>

                                <tr>
                                    <th>No of Rich</th>
                                    <td>{{ checkZero($inclusion[0]->no_of_visual_rich) }}</td>
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
                                    <td>{{ $inclusion[0]->no_of_sc_caste != '' ? $inclusion[0]->no_of_sc_caste : 0 }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>No Of OBC</th>
                                    <td>{{ $inclusion[0]->no_of_obc_caste != '' ? $inclusion[0]->no_of_obc_caste : 0 }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>No Of Others</th>
                                    <td>{{ checkZero($inclusion[0]->no_of_other_caste) }}</td>
                                </tr>
                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">No. of Loans and Amounts given to SHG Members During Last 12
                            Months</h4>
                        <table class=" table-bordered  new-table-dg" width="100%">
                            <tr>
                                <th>Total Loans Disbursed (#)</th>
                                <th class="bg-white p-3 mb-0">
                                    {{ checkZero($inclusion[0]->no_of_total_members_benefited) }}</th>
                                <th>Total Amount Disbursed (INR)</th>
                                <th class="bg-white p-3 mb-0">
                                    {{ checkZero($inclusion[0]->no_of_total_members_benefited_amount) }}</th>
                            </tr>
                        </table>
                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th style="border-bottom-color: #cea38b;"></th>
                                    <th  colspan="2" style="border-bottom-color: #cea38b;" >Internal Loans
                                    </th>

                                    <th colspan="4">External Loans</th>
                                    <th colspan="2"  style="border-bottom-color: #cea38b;">Other Loans
                                    </th>
                                    <th colspan="2"  style="border-bottom-color: #cea38b;">Total</th>
                                </tr>
                                <tr>
                                    <th style="border-bottom-color:#cea38b ;">Category</th>
                                    <th colspan="2"></th>

                                    <th colspan="2">Federation</th>
                                    <th colspan="2">Bank</th>
                                    <th colspan="2"></th>
                                    <th colspan="2"></th>

                                </tr>
                                <tr>
                                    <th></th>
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
                                    <th>
                                        Loan
                                        Disbursed
                                        (#)
                                    </th>
                                    <th>
                                        Amount
                                        Disbursed
                                        (INR)
                                    </th>
                                </tr>
                            </thead>

                            <tbody style="text-align: center">
                                <tr>
                                    <td>Very Poor
                                        &
                                        Vulnerable</td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest_amount }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_external_poorest }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_external_poorest_amount }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poorest }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poorest_amount }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poorest }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poorest_amount }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest + (int) $inclusion[0]->no_of_external_poorest + (int) $inclusion[0]->no_of_bank_external_poorest + (int) $inclusion[0]->no_of_other_external_poorest }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest_amount + (int) $inclusion[0]->no_of_external_poorest_amount + (int) $inclusion[0]->no_of_bank_external_poorest_amount + (int) $inclusion[0]->no_of_other_external_poorest_amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Poor</td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_poor }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_poor_amount }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_external_poor }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_external_poor_amount }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poor }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poor_amount }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poor }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poor_amount }}
                                    </td>

                                    <td>
                                        {{ (int) $inclusion[0]->no_of_internal_poor + (int) $inclusion[0]->no_of_external_poor + (int) $inclusion[0]->no_of_bank_external_poor + (int) $inclusion[0]->no_of_other_external_poor }}
                                    </td>
                                    <td>
                                        {{ (int) $inclusion[0]->no_of_internal_poor_amount + (int) $inclusion[0]->no_of_external_poor_amount + (int) $inclusion[0]->no_of_bank_external_poor_amount + (int) $inclusion[0]->no_of_other_external_poor_amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Medium
                                        Poor</td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_medium }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_medium_amount }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_external_medium }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_external_medium_amount }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_medium }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_medium_amount }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->no_of_other_external_medium }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_other_external_medium_amount }}
                                    </td>

                                    <td>
                                        {{ (int) $inclusion[0]->no_of_internal_medium + (int) $inclusion[0]->no_of_external_medium + (int) $inclusion[0]->no_of_bank_external_medium + (int) $inclusion[0]->no_of_other_external_medium }}
                                    </td>
                                    <td>
                                        {{ (int) $inclusion[0]->no_of_internal_medium_amount + (int) $inclusion[0]->no_of_external_medium_amount + (int) $inclusion[0]->no_of_bank_external_medium_amount + (int) $inclusion[0]->no_of_other_external_medium_amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rich</td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_rich }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_rich_amount }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_external_rich }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_external_rich_amount }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_rich }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_rich_amount }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_other_external_rich }}</td>
                                    <td>{{ (int) $inclusion[0]->no_of_other_external_rich_amount }}
                                    </td>

                                    <td>
                                        {{ (int) $inclusion[0]->no_of_internal_rich + (int) $inclusion[0]->no_of_external_rich + (int) $inclusion[0]->no_of_bank_external_rich + (int) $inclusion[0]->no_of_other_external_rich }}
                                    </td>
                                    <td>
                                        {{ (int) $inclusion[0]->no_of_internal_rich_amount + (int) $inclusion[0]->no_of_external_rich_amount + (int) $inclusion[0]->no_of_bank_external_rich_amount + (int) $inclusion[0]->no_of_other_external_rich_amount }}
                                    </td>
                                </tr>
                                <tr style="background:#ccc7c7 ">
                                    <td>Total</td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest + (int) $inclusion[0]->no_of_internal_poor + (int) $inclusion[0]->no_of_internal_medium + (int) $inclusion[0]->no_of_internal_rich }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest_amount + (int) $inclusion[0]->no_of_internal_poor_amount + (int) $inclusion[0]->no_of_internal_medium_amount + (int) $inclusion[0]->no_of_internal_rich_amount }}
                                    </td>

                                    <td>{{ (int) $inclusion[0]->no_of_external_poorest + (int) $inclusion[0]->no_of_external_poor + (int) $inclusion[0]->no_of_external_medium + (int) $inclusion[0]->no_of_external_rich }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->no_of_external_poorest_amount + (int) $inclusion[0]->no_of_external_poor_amount + (int) $inclusion[0]->no_of_external_medium_amount + (int) $inclusion[0]->no_of_external_rich_amount }}
                                    </td>

                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poorest + (int) $inclusion[0]->no_of_bank_external_poor + (int) $inclusion[0]->no_of_bank_external_medium + (int) $inclusion[0]->no_of_bank_external_rich }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poorest_amount + (int) $inclusion[0]->no_of_bank_external_poor_amount + (int) $inclusion[0]->no_of_bank_external_medium_amount + (int) $inclusion[0]->no_of_bank_external_rich_amount }}
                                    </td>

                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poorest + (int) $inclusion[0]->no_of_other_external_poor + (int) $inclusion[0]->no_of_other_external_medium + (int) $inclusion[0]->no_of_other_external_rich }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poorest_amount + (int) $inclusion[0]->no_of_other_external_poor_amount + (int) $inclusion[0]->no_of_other_external_medium_amount + (int) $inclusion[0]->no_of_other_external_rich_amount }}
                                    </td>



                                    <td>{{ checkZero($inclusion[0]->no_of_total_members_benefited) }}</td>
                                    <td>{{ checkZero($inclusion[0]->no_of_total_members_benefited_amount) }}</td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">No. Of HHs Benefited From All Loans During Last 12 Months</h4>
                        <table class=" table-bordered  new-table-dg" width="100%">
                            <tr>
                                <th style="background: #ccc7c7;" class=" p-3 mb-0">Total HHs</th>
                                <th class=" p-3 mb-0">{{ $inclusion[0]->no_of_total_members_benefited_hhs }}</th>

                            </tr>
                        </table>
                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th style="border-top-color:#cea38b ;">Category</th>
                                    <th style="border-top-color:#cea38b ;">SHG member HHs</th>
                                    <th style="border-top-color:#cea38b ;">Internal Loans</th>
                                    <th colspan="2">External Loans</th>
                                    <th style="border-top-color:#cea38b ;">Other Loans</th>

                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Federation</th>
                                    <th>Bank</th>
                                    <th></th>
                                </tr>

                            </thead>

                            <tbody style="text-align: center;">
                                <tr>
                                    <td style="text-align: left;">Very Poor & Vulnerable</td>
                                    <td>{{ checkZero($inclusion[0]->no_of_internal_poorest_hhs) }}
                                    </td>
                                    <td>{{ checkZero($inclusion[0]->no_of_internal_poorest_recloan) }}
                                    </td>
                                    <td>{{ checkZero($inclusion[0]->no_of_external_poorest_recloan) }}
                                    </td>
                                    <td>
                                        {{ checkZero($inclusion[0]->no_of_bank_external_poorest_recloan) }}</td>
                                    <td>
                                        {{ checkZero($inclusion[0]->no_of_other_external_poorest_recloan) }}</td>
                                </tr>

                                <tr>
                                    <td style="text-align: left;">Poor</td>
                                    <td>{{ checkZero($inclusion[0]->no_of_internal_poor_hhs) }}</td>
                                    <td>{{ checkZero($inclusion[0]->no_of_internal_poor_recloan) }}
                                    </td>
                                    <td>{{ checkZero($inclusion[0]->no_of_external_poor_recloan) }}
                                    </td>
                                    <td>
                                        {{ checkZero($inclusion[0]->no_of_bank_external_poor_recloan) }}</td>
                                    <td>
                                        {{ checkZero($inclusion[0]->no_of_other_external_poor_recloan) }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Medium Poor</td>
                                    <td>{{ checkZero($inclusion[0]->no_of_internal_medium_hhs) }}</td>
                                    <td>{{ checkZero($inclusion[0]->no_of_internal_medium_recloan) }}
                                    </td>
                                    <td>{{ checkZero($inclusion[0]->no_of_external_medium_recloan) }}
                                    </td>
                                    <td>
                                        {{ checkZero($inclusion[0]->no_of_bank_external_medium_recloan) }}</td>
                                    <td>
                                        {{ checkZero($inclusion[0]->no_of_other_external_medium_recloan) }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Rich</td>
                                    <td>{{ checkZero($inclusion[0]->no_of_internal_rich_hhs) }}</td>
                                    <td>{{ checkZero($inclusion[0]->no_of_internal_rich_recloan) }}
                                    </td>
                                    <td>{{ checkZero($inclusion[0]->no_of_external_rich_recloan) }}
                                    </td>
                                    <td>
                                        {{ checkZero($inclusion[0]->no_of_bank_external_rich_recloan) }}</td>
                                    <td>
                                        {{ checkZero($inclusion[0]->no_of_other_external_rich_recloan) }}</td>
                                </tr>
                                <tr style="background: #ccc7c7">
                                    <td style="text-align: left;">Total</td>
                                    <td>
                                        {{ (int) $inclusion[0]->no_of_internal_poorest_hhs + (int) $inclusion[0]->no_of_internal_poor_hhs + (int) $inclusion[0]->no_of_internal_medium_hhs + (int) $inclusion[0]->no_of_internal_rich_hhs }}
                                    </td>
                                    <td>
                                        {{ (int) $inclusion[0]->no_of_internal_poorest_recloan + (int) $inclusion[0]->no_of_internal_poor_recloan + (int) $inclusion[0]->no_of_internal_medium_recloan + (int) $inclusion[0]->no_of_internal_rich_recloan }}
                                    </td>
                                    <td>
                                        {{ (int) $inclusion[0]->no_of_external_poorest_recloan + (int) $inclusion[0]->no_of_external_poor_recloan + (int) $inclusion[0]->no_of_external_medium_recloan + (int) $inclusion[0]->no_of_external_rich_recloan }}
                                    </td>
                                    <td>
                                        {{ (int) $inclusion[0]->no_of_bank_external_poorest_recloan + (int) $inclusion[0]->no_of_bank_external_poor_recloan + (int) $inclusion[0]->no_of_bank_external_medium_recloan + (int) $inclusion[0]->no_of_bank_external_rich_recloan }}
                                    </td>
                                    <td>
                                        {{ (int) $inclusion[0]->no_of_other_external_poorest_recloan + (int) $inclusion[0]->no_of_other_external_poor_recloan + (int) $inclusion[0]->no_of_other_external_medium_recloan + (int) $inclusion[0]->no_of_other_external_rich_recloan }}
                                    </td>

                                </tr>
                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>No of poor and most poor in Leadership position</th>
                                    <td style="background:#f1f0f0 ">
                                        {{ checkZero($inclusion[0]->no_of_leadership_poor) }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Special Products For the Poor/Vulnerable</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Special Products for the
                                        poor/vulnerable</td>
                                    <td>{{ checkZero($inclusion[0]->is_service_for_poor) }}</td>
                                    <td>No of members benefited
                                        from it during last 12 months</td>
                                    <td>{{ $inclusion[0]->no_of_member_benefited_service != '' ? $inclusion[0]->no_of_member_benefited_service : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Name of Product</td>
                                    <td>{{ $inclusion[0]->service_for_poor != '' ? $inclusion[0]->service_for_poor : 'N/A' }}
                                    </td>
                                    <td>Any impact/result</td>
                                    <td>{{ $inclusion[0]->result_of_service != '' ? $inclusion[0]->result_of_service : 'N/A' }}
                                    </td>
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
                    <div class="col-md-5">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Integrated Member Plan</th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>Integrated
                                        member Plan</td>
                                    <td>{{ checkna($efficiency[0]->integrated_family) }}</td>
                                </tr>
                                <tr>
                                    <td>Date of last
                                        report</td>
                                    <td>{{ $efficiency[0]->integrated_family_date != '' ? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->integrated_family_date)) : 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="col-md-7">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Income and Expenses During Last 12 Months</th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>Income from all sources</td>
                                    <td>{{ checkna($efficiency[0]->total_income) }}</td>
                                </tr>
                                <tr>
                                    <td>Expenses</td>
                                    <td>{{ checkna($efficiency[0]->expense) }}</td>
                                </tr>
                                <tr>
                                    <td>Is it covering its operational costs</td>
                                    <td>{{ checkna($efficiency[0]->covering_operational_cost) }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Training Details in last 12 months</h4>

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

                                @if (!empty($efficiency_details))
                                    @foreach ($efficiency_details as $row)
                                        <tr style="text-align: center;">
                                            <td>{{ $row->training_name }}</td>
                                            <td>{{ $row->duration }}</td>
                                            <td>{{ change_date_month_name_char(str_replace('/', '-', $row->date_training)) }}
                                            </td>
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
                                            <td>{{ $row->who_received }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Book-Keeper</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Name of Training</th>
                                    <th>Date of Training</th>
                                    <th>Duration in Days</th>
                                    <th>Bookkeeper Trained</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr style="text-align: center;">
                                    <td>{{ $efficiency[0]->name_training != '' ? $efficiency[0]->name_training : 'N/A' }}
                                    </td>
                                    <td>{{ $efficiency[0]->date_training != '' ? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->date_training)) : 'N/A' }}
                                    </td>
                                    <td>{{ $efficiency[0]->duration_training != '' ? $efficiency[0]->duration_training : 'N/A' }}
                                    </td>
                                    <td>{{ $efficiency[0]->bookkeeper_trained != '' ? $efficiency[0]->bookkeeper_trained : 'N/A' }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Approval Process</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Days taken to approve loan</td>
                                    <td>{{ checkZero($efficiency[0]->no_of_days_approve_loan) }}</td>
                                    <td>No of days from approval to cash in
                                        hand</td>
                                    <td>{{ checkna($efficiency[0]->no_of_days_cash_in_hand) }}</td>
                                </tr>

                            </tbody>
                        </table>



                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Monthly Report Submitted (Date of
                                        last submitted report)</th>
                                    <td style="background:#f1f0f0 ">
                                        {{ checkna($efficiency[0]->prepare_monthly_progress) }}</td>
                                    <td style="background:#f1f0f0 ">
                                        {{ $efficiency[0]->shg_last_submission_date != '' ? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->shg_last_submission_date)) : 'N/A' }}
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
                                    <th colspan="4">Interest Rate Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Interest rate type</td>
                                    <td width= "25%">{{ checkna($creditrecovery[0]->interest_charged) }}</td>
                                    <td>Interest rate charged %</td>
                                    <td>9%</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Cumulative No of Loans and Amounts disbursed During last 3 years
                        </h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th style="border-bottom-color: #cea38b;"></th>
                                    <th  colspan="2" style="border-bottom-color: #cea38b;" >Internal Loans
                                    </th>

                                    <th colspan="4">External Loans</th>
                                    <th colspan="2"  style="border-bottom-color: #cea38b;">Other Loans
                                    </th>
                                    <th colspan="2"  style="border-bottom-color: #cea38b;">Total</th>
                                </tr>
                                <tr>
                                    <th style="border-bottom-color:#cea38b ;">Category</th>
                                    <th colspan="2"></th>

                                    <th colspan="2">Federation</th>
                                    <th colspan="2">Bank</th>
                                    <th colspan="2"></th>
                                    <th colspan="2"></th>

                                </tr>
                                <tr>
                                    <th></th>
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
                                    <th>
                                        Loan
                                        Disbursed
                                        (#)
                                    </th>
                                    <th>
                                        Amount
                                        Disbursed
                                        (INR)
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr style="text-align: center;">
                                    <td>Very Poor
                                        &
                                        Vulnerable</td>
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

                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest + (int) $creditrecovery[0]->no_of_external_poorest + (int) $creditrecovery[0]->no_of_bank_external_poorest + (int) $creditrecovery[0]->no_of_other_external_poorest }}
                                    </td>
                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_amount + (int) $creditrecovery[0]->no_of_external_poorest_amount + (int) $creditrecovery[0]->no_of_bank_external_poorest_amount + (int) $creditrecovery[0]->no_of_other_external_poorest_amount }}
                                    </td>
                                </tr>
                                <tr style="text-align: center">
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

                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poor + (int) $creditrecovery[0]->no_of_external_poor + (int) $creditrecovery[0]->no_of_bank_external_poor + (int) $creditrecovery[0]->no_of_other_external_poor }}
                                    </td>
                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poor_amount + (int) $creditrecovery[0]->no_of_external_poor_amount + (int) $creditrecovery[0]->no_of_bank_external_poor_amount + (int) $creditrecovery[0]->no_of_other_external_poor_amount }}
                                    </td>
                                </tr>
                                <tr style="text-align: center">
                                    <td>Medium
                                        Poor</td>
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

                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_medium + (int) $creditrecovery[0]->no_of_external_medium + (int) $creditrecovery[0]->no_of_other_external_medium + (int) $creditrecovery[0]->no_of_bank_external_medium }}
                                    </td>
                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_medium_amount + (int) $creditrecovery[0]->no_of_external_medium_amount + (int) $creditrecovery[0]->no_of_other_external_medium_amount + (int) $creditrecovery[0]->no_of_bank_external_medium_amount }}
                                    </td>
                                </tr>
                                <tr style="text-align: center">
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

                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_rich + (int) $creditrecovery[0]->no_of_external_rich + (int) $creditrecovery[0]->no_of_other_external_rich + (int) $creditrecovery[0]->no_of_bank_external_rich }}
                                    </td>
                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_rich_amount + (int) $creditrecovery[0]->no_of_external_rich_amount + (int) $creditrecovery[0]->no_of_other_external_rich_amount + (int) $creditrecovery[0]->no_of_bank_external_rich_amount }}
                                    </td>
                                </tr>
                                <tr style="background:#ccc7c7 ;text-align:center">
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



                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest +
                                        (int) $creditrecovery[0]->no_of_external_poorest +
                                        (int) $creditrecovery[0]->no_of_bank_external_poorest +
                                        (int) $creditrecovery[0]->no_of_other_external_poorest +
                                        (int) $creditrecovery[0]->no_of_internal_poor +
                                        (int) $creditrecovery[0]->no_of_external_poor +
                                        (int) $creditrecovery[0]->no_of_bank_external_poor +
                                        (int) $creditrecovery[0]->no_of_other_external_poor +
                                        (int) $creditrecovery[0]->no_of_internal_medium +
                                        (int) $creditrecovery[0]->no_of_external_medium +
                                        (int) $creditrecovery[0]->no_of_other_external_medium +
                                        (int) $creditrecovery[0]->no_of_bank_external_medium +
                                        (int) $creditrecovery[0]->no_of_internal_rich +
                                        (int) $creditrecovery[0]->no_of_external_rich +
                                        (int) $creditrecovery[0]->no_of_other_external_rich +
                                        (int) $creditrecovery[0]->no_of_bank_external_rich }}
                                    </td>
                                    <td>
                                        {{ (int) $creditrecovery[0]->no_of_internal_poorest_amount +
                                            (int) $creditrecovery[0]->no_of_external_poorest_amount +
                                            (int) $creditrecovery[0]->no_of_bank_external_poorest_amount +
                                            (int) $creditrecovery[0]->no_of_other_external_poorest_amount +
                                            (int) $creditrecovery[0]->no_of_internal_poor_amount +
                                            (int) $creditrecovery[0]->no_of_external_poor_amount +
                                            (int) $creditrecovery[0]->no_of_bank_external_poor_amount +
                                            (int) $creditrecovery[0]->no_of_other_external_poor_amount +
                                            (int) $creditrecovery[0]->no_of_internal_medium_amount +
                                            (int) $creditrecovery[0]->no_of_external_medium_amount +
                                            (int) $creditrecovery[0]->no_of_other_external_medium_amount +
                                            (int) $creditrecovery[0]->no_of_bank_external_medium_amount +
                                            (int) $creditrecovery[0]->no_of_internal_rich_amount +
                                            (int) $creditrecovery[0]->no_of_external_rich_amount +
                                            (int) $creditrecovery[0]->no_of_other_external_rich_amount +
                                            (int) $creditrecovery[0]->no_of_bank_external_rich_amount }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-5">
                        <h4 class="bg-white p-3 mb-0">Cumulative Interest Income
                            Generated by SHG
                        </h4>

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
                                    <td>1</td>
                                    <td>Internal</td>
                                    <td style="text-align: center;">
                                        {{ checkZero($creditrecovery[0]->cumulative_internal_interest) }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Federation</td>
                                    <td style="text-align: center;">
                                        {{ checkZero($creditrecovery[0]->cumulative_federation_interest) }}</td>

                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Bank</td>
                                    <td style="text-align: center;">
                                        {{ checkZero($creditrecovery[0]->cumulative_vi_interest) }}</td>

                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Others</td>
                                    <td style="text-align: center;">
                                        {{ checkZero($creditrecovery[0]->cumulative_other_interest) }}</td>

                                </tr>

                                <tr style="background:#ccc7c7 ">
                                    <td colspan="2">Total</td>
                                    <td style="text-align: center;">
                                        {{ checkZero($creditrecovery[0]->total_cumulative_interest) }}</td>


                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-7">
                        <h4 class="bg-white p-3 mb-0">Total No Of Member HHs Benefitted From All Loans During
                            Last 3 Years
                        </h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>Category</th>
                                    <th>SHG member HHs</th>
                                    <th colspan="4">Received Loans</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Internal</td>
                                    <td>Federation</td>
                                    <td>Bank</td>
                                    <td>Other</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td style="text-align: left;">Very Poor & Vulnerable</td>
                                    <td>{{ $creditrecovery[0]->no_of_internal_poorest_hhs != '' ? $creditrecovery[0]->no_of_internal_poorest_hhs : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_internal_poorest_recloan != '' ? $creditrecovery[0]->no_of_internal_poorest_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_external_poorest_recloan != '' ? $creditrecovery[0]->no_of_external_poorest_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_bank_external_poorest_recloan != '' ? $creditrecovery[0]->no_of_bank_external_poorest_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_other_external_poorest_recloan != '' ? $creditrecovery[0]->no_of_other_external_poorest_recloan : 0 }}
                                    </td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td style="text-align: left;">Poor</td>
                                    <td>{{ $creditrecovery[0]->no_of_internal_poor_hhs != '' ? $creditrecovery[0]->no_of_internal_poor_hhs : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_internal_poor_recloan != '' ? $creditrecovery[0]->no_of_internal_poor_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_external_poor_recloan != '' ? $creditrecovery[0]->no_of_external_poor_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_bank_external_poor_recloan != '' ? $creditrecovery[0]->no_of_bank_external_poor_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_other_external_poor_recloan != '' ? $creditrecovery[0]->no_of_other_external_poor_recloan : 0 }}
                                    </td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td style="text-align: left;">Medium Poor</td>
                                    <td>{{ $creditrecovery[0]->no_of_internal_medium_hhs != '' ? $creditrecovery[0]->no_of_internal_medium_hhs : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_internal_medium_recloan != '' ? $creditrecovery[0]->no_of_internal_medium_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_external_medium_recloan != '' ? $creditrecovery[0]->no_of_external_medium_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_bank_external_medium_recloan != '' ? $creditrecovery[0]->no_of_bank_external_medium_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_other_external_medium_recloan != '' ? $creditrecovery[0]->no_of_other_external_medium_recloan : 0 }}
                                    </td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td style="text-align: left;">Rich</td>
                                    <td>{{ $creditrecovery[0]->no_of_internal_rich_hhs != '' ? $creditrecovery[0]->no_of_internal_rich_hhs : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_internal_rich_recloan != '' ? $creditrecovery[0]->no_of_internal_rich_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_external_rich_recloan != '' ? $creditrecovery[0]->no_of_external_rich_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_bank_external_rich_recloan != '' ? $creditrecovery[0]->no_of_bank_external_rich_recloan : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->no_of_other_external_rich_recloan != '' ? $creditrecovery[0]->no_of_other_external_rich_recloan : 0 }}
                                    </td>
                                </tr>

                                <tr style="background:#ccc7c7; text-align:center">
                                    <td>Total</td>
                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_hhs + (int) $creditrecovery[0]->no_of_internal_poor_hhs + (int) $creditrecovery[0]->no_of_internal_medium_hhs + (int) $creditrecovery[0]->no_of_internal_rich_hhs }}
                                    </td>
                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_recloan + (int) $creditrecovery[0]->no_of_internal_poor_recloan + (int) $creditrecovery[0]->no_of_internal_medium_recloan + (int) $creditrecovery[0]->no_of_internal_rich_recloan }}
                                    </td>
                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poorest_recloan + (int) $creditrecovery[0]->no_of_external_poor_recloan + (int) $creditrecovery[0]->no_of_external_medium_recloan + (int) $creditrecovery[0]->no_of_external_rich_recloan }}
                                    </td>
                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poorest_recloan + (int) $creditrecovery[0]->no_of_bank_external_poor_recloan + (int) $creditrecovery[0]->no_of_bank_external_medium_recloan + (int) $creditrecovery[0]->no_of_bank_external_rich_recloan }}
                                    </td>
                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poorest_recloan + (int) $creditrecovery[0]->no_of_other_external_poor_recloan + (int) $creditrecovery[0]->no_of_other_external_medium_recloan + (int) $creditrecovery[0]->no_of_other_external_rich_recloan }}
                                    </td>

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
                                <tr>
                                    <th colspan="8">Total Loan Portfolio</th>
                                </tr>
                                <tr style="text-align: center">
                                    <th>S. No.</th>
                                    <th>DCB</th>
                                    <th>Internal Loans</th>
                                    <th>Cluster Loan</th>
                                    <th>Federation Loan</th>
                                    <th>Bank Loan</th>
                                    <th>Other Loans</th>
                                    <th>Total Loan Portfolio</th>
                                </tr>
                            </thead>

                            <tbody style="text-align:center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left">Total Loan Amount Given (INR)</td>
                                    <td>
                                        {{ $creditrecovery[0]->internal_loan_amount != '' ? $creditrecovery[0]->internal_loan_amount : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->cluster_loan_amount != '' ? $creditrecovery[0]->cluster_loan_amount : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->federation_loan_amount != '' ? $creditrecovery[0]->federation_loan_amount : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->bank_loan_amount != '' ? $creditrecovery[0]->bank_loan_amount : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->other_loan_amount != '' ? $creditrecovery[0]->other_loan_amount : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->total_loan_amount != '' ? $creditrecovery[0]->total_loan_amount : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left">Total Demand upto last month
                                        for active loans (INR)</td>
                                    <td>
                                        {{ $creditrecovery[0]->dcb_internal != '' ? $creditrecovery[0]->dcb_internal : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->dcb_cluster != '' ? $creditrecovery[0]->dcb_cluster : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->dcb_federation != '' ? $creditrecovery[0]->dcb_federation : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->dcb_bank != '' ? $creditrecovery[0]->dcb_bank : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->dcb_other != '' ? $creditrecovery[0]->dcb_other : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->total_demand != '' ? $creditrecovery[0]->total_demand : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left">Actual Amount Paid upto last
                                        month (INR)</td>
                                    <td>
                                        {{ $creditrecovery[0]->repaid_internal != '' ? $creditrecovery[0]->repaid_internal : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->repaid_cluster != '' ? $creditrecovery[0]->repaid_cluster : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->repaid_federation != '' ? $creditrecovery[0]->repaid_federation : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->repaid_bank != '' ? $creditrecovery[0]->repaid_bank : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->repaid_other != '' ? $creditrecovery[0]->repaid_other : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->total_actual_repaid_amount != '' ? $creditrecovery[0]->total_actual_repaid_amount : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left">Overdue Amount (INR)</td>
                                    <td>
                                        {{ $creditrecovery[0]->overdue_internal != '' ? $creditrecovery[0]->overdue_internal : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->overdue_cluster != '' ? $creditrecovery[0]->overdue_cluster : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->overdue_federation != '' ? $creditrecovery[0]->overdue_federation : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->overdue_bank != '' ? $creditrecovery[0]->overdue_bank : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->overdue_other != '' ? $creditrecovery[0]->overdue_other : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->total_overdue != '' ? $creditrecovery[0]->total_overdue : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td style="text-align: left">Outstanding amount for active
                                        loans (INR)</td>
                                    <td>
                                        {{ $creditrecovery[0]->current_outstanding_internal != '' ? $creditrecovery[0]->current_outstanding_internal : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->current_outstanding_cluster != '' ? $creditrecovery[0]->current_outstanding_cluster : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->current_outstanding_federation != '' ? $creditrecovery[0]->current_outstanding_federation : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->current_outstanding_bank != '' ? $creditrecovery[0]->current_outstanding_bank : 0 }}
                                    </td>

                                    <td>
                                        {{ $creditrecovery[0]->current_outstanding_other != '' ? $creditrecovery[0]->current_outstanding_other : 0 }}
                                    </td>
                                    <td>
                                        {{ $creditrecovery[0]->total_outstanding_amount != '' ? $creditrecovery[0]->total_outstanding_amount : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td style="text-align: left">Repayment Ratio %</td>
                                    <td>{{ Checkper($creditrecovery[0]->repayment_internal) . '%' }}</td>
                                    <td>{{ Checkper($creditrecovery[0]->repayment_cluster) . '%' }}
                                    </td>
                                    <td>{{ Checkper($creditrecovery[0]->repayment_federation) . '%' }}
                                    </td>
                                    <td>{{ Checkper($creditrecovery[0]->repayment_bank) . '%' }}
                                    </td>
                                    </td>
                                    <td>{{ Checkper($creditrecovery[0]->repayment_other) . '%' }}
                                    </td>
                                    <td>{{ Checkper($creditrecovery[0]->total_repayment_ratio) . '%' }}</td>
                                </tr>
                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-7">
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
                                    <td>Internal loans</td>
                                    <td>{{ $creditrecovery[0]->default_internal_member != '' ? $creditrecovery[0]->default_internal_member : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->default_internal_loan != '' ? $creditrecovery[0]->default_internal_loan : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Cluster/Habitation</td>
                                    <td>{{ $creditrecovery[0]->default_cluster_member != '' ? $creditrecovery[0]->default_cluster_member : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->default_cluster_loan != '' ? $creditrecovery[0]->default_cluster_loan : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Federation Loan</td>
                                    <td>{{ $creditrecovery[0]->default_federation_member != '' ? $creditrecovery[0]->default_federation_member : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->default_federation_loan != '' ? $creditrecovery[0]->default_federation_loan : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Bank Loan</td>
                                    <td>{{ $creditrecovery[0]->default_bank_member != '' ? $creditrecovery[0]->default_bank_member : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->default_bank_loan != '' ? $creditrecovery[0]->default_bank_loan : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Other Loan</td>
                                    <td>{{ $creditrecovery[0]->default_other_member != '' ? $creditrecovery[0]->default_other_member : 0 }}
                                    </td>
                                    <td>{{ $creditrecovery[0]->default_other_loan != '' ? $creditrecovery[0]->default_other_loan : 0 }}
                                    </td>
                                </tr>

                                <tr style="background:#ccc7c7 ">
                                    <td colspan="2">Total</td>
                                    <td>
                                        {{ (int) $creditrecovery[0]->default_internal_member + (int) $creditrecovery[0]->default_cluster_member + (int) $creditrecovery[0]->default_bank_member + (int) $creditrecovery[0]->default_other_member + (int) $creditrecovery[0]->default_federation_member }}
                                    </td>
                                    <td>
                                        {{ (int) $creditrecovery[0]->default_internal_loan + (int) $creditrecovery[0]->default_cluster_loan + (int) $creditrecovery[0]->default_federation_loan + (int) $creditrecovery[0]->default_bank_loan + (int) $creditrecovery[0]->default_other_loan }}
                                    </td>

                                </tr>

                            </tbody>
                        </table>



                    </div>
                    <div class="col-md-5">
                        <h4 class="bg-white p-3 mb-0">PAR Status - 3 Months Overdue
                        </h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Loan Type
                                    </th>
                                    <th>Amount (INR)</th>
                                </tr>


                            </thead>

                            <tbody style="text-align: center">
                                <tr>
                                    <td>1</td>
                                    <td>Internal</td>
                                    <td>{{ checkZero($creditrecovery[0]->creditHistory_PAR_status_Internal) }}</td>

                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>External</td>
                                    <td>{{ checkZero($creditrecovery[0]->creditHistory_PAR_status_External) }}</td>

                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-6">
                        <h4 class="bg-white p-3 mb-0">Purpose of External Loans During Last 12 Months

                        </h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Purpose</th>
                                    <th>Bank/Others</th>
                                    <th>Federation</th>
                                    <th>Total</th>
                                </tr>


                            </thead>

                            <tbody style="text-align: center">
                                <tr>
                                    <td>1</td>
                                    <td>Productive</td>
                                    <td>{{ (int) $creditrecovery[0]->purposes_productive }}</td>
                                    <td>{{ (int) $creditrecovery[0]->purposes_productive_federation }}
                                    </td>
                                    <td>{{ (int) $creditrecovery[0]->purposes_productive + (int) $creditrecovery[0]->purposes_productive_federation }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Consumption</td>
                                    <td>{{ (int) $creditrecovery[0]->purposes_consumption }}</td>
                                    <td>
                                        {{ (int) $creditrecovery[0]->purposes_consumption_federation }}
                                    </td>
                                    <td>
                                        {{ (int) $creditrecovery[0]->purposes_consumption + (int) $creditrecovery[0]->purposes_consumption_federation }}
                                    </td>

                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Debt Swapping</td>
                                    <td>{{ (int) $creditrecovery[0]->purposes_debt_swapping }}</td>
                                    <td>
                                        {{ (int) $creditrecovery[0]->purposes_debt_swapping_federation }}
                                    </td>
                                    <td>
                                        {{ (int) $creditrecovery[0]->purposes_debt_swapping + (int) $creditrecovery[0]->purposes_debt_swapping_federation }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Other</td>
                                    <td>{{ (int) $creditrecovery[0]->purposes_other }}</td>
                                    <td>{{ (int) $creditrecovery[0]->purposes_other_federation }}</td>
                                    <td>
                                        {{ (int) $creditrecovery[0]->purposes_other + (int) $creditrecovery[0]->purposes_other_federation }}
                                    </td>
                                </tr>
                                <tr style="background: #ccc7c7">
                                    <td colspan="2">Total</td>
                                    <td>
                                        {{ (int) $creditrecovery[0]->purposes_productive + (int) $creditrecovery[0]->purposes_consumption + (int) $creditrecovery[0]->purposes_debt_swapping + (int) $creditrecovery[0]->purposes_other }}
                                    </td>
                                    <td>
                                        {{ (int) $creditrecovery[0]->purposes_productive_federation + (int) $creditrecovery[0]->purposes_consumption_federation + (int) $creditrecovery[0]->purposes_debt_swapping_federation + (int) $creditrecovery[0]->purposes_other_federation }}
                                    </td>

                                    <td>{{ (int) $creditrecovery[0]->purposes_productive + (int) $creditrecovery[0]->purposes_productive_federation + (int) $creditrecovery[0]->purposes_productive_vi + (int) $creditrecovery[0]->purposes_consumption + (int) $creditrecovery[0]->purposes_consumption_federation + (int) $creditrecovery[0]->purposes_consumption_vi + (int) $creditrecovery[0]->purposes_debt_swapping + (int) $creditrecovery[0]->purposes_debt_swapping_federation + (int) $creditrecovery[0]->purposes_debt_swapping_vi + (int) $creditrecovery[0]->purposes_other + (int) $creditrecovery[0]->purposes_other_federation + (int) $creditrecovery[0]->purposes_other_vi }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Average Loan Number And Amount During Last 12 Months</th>
                                    <td style="background: #ccc7c7; width:15%;  text-align:center;">
                                        {{ checkZero($creditrecovery[0]->average_loan_amount) }}</td>
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
                                    <td style="text-align: center;  width:15%;">
                                        {{ checkZero($creditrecovery[0]->maximum_amount) }}</td>
                                    <td style="background: #ccc7c7">Min Amount (INR)</td>
                                    <td style="text-align: center; width:15%;">
                                        {{ checkZero($creditrecovery[0]->minimum_amount) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Members taken more than one Loan During Last 3 Years </th>
                                    <td style="background: #ccc7c7; width:15%; text-align:center;">
                                        {{ checkZero($creditrecovery[0]->no_of_member_loan_more) }}</td>
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

                    <div class="col-md-7">
                        <h4 class="bg-white p-3 mb-0">Savings Details
                        </h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Savings Details</th>
                                    <th>Compulsory</th>
                                    <th>Voluntary</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center;">1</td>
                                    <td>Date Savings started</td>
                                    <td>{{ $saving[0]->date_savings_started != '' ? change_date_month_name_char(str_replace('/', '-', $saving[0]->date_savings_started)) : 'N/A' }}
                                    </td>
                                    <td>{{ $saving[0]->shg_voluntary_saving_started_date != '' ? change_date_month_name_char(str_replace('/', '-', $saving[0]->shg_voluntary_saving_started_date)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">2</td>
                                    <td>Amount of Savings per month(INR)</td>
                                    <td>{{ $saving[0]->compulsory_saving_amount != '' ? $saving[0]->compulsory_saving_amount : 0 }}
                                    </td>
                                    <td>{{ $saving[0]->shg_voluntary_saving_amount_per_month != '' ? $saving[0]->shg_voluntary_saving_amount_per_month : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">3</td>
                                    <td>No of Members saved during last
                                        12 months</td>
                                    <td>{{ $saving[0]->regular_saving_member != '' ? $saving[0]->regular_saving_member : 0 }}
                                    </td>
                                    <td>{{ $saving[0]->member_voluntary_saving != '' ? $saving[0]->member_voluntary_saving : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">4</td>
                                    <td>Cumulative Savings to date since
                                        inception (INR)
                                    </td>
                                    <td>{{ $saving[0]->cumulative_compulsory_saving != '' ? $saving[0]->cumulative_compulsory_saving : 0 }}
                                    </td>
                                    <td>{{ $saving[0]->cumulative_voluntary_saving != '' ? $saving[0]->cumulative_voluntary_saving : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">5</td>
                                    <td>Average Amount saved during last
                                        12 months (INR)
                                    </td>
                                    <td>{{ $saving[0]->shg_compulsory_average_amount_saving_1E != '' ? $saving[0]->shg_compulsory_average_amount_saving_1E : 0 }}
                                    </td>
                                    <td>{{ $saving[0]->shg_voluntary_saving_since_inception != '' ? $saving[0]->shg_voluntary_saving_since_inception : 0 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-5">
                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th colspan="2">Interest Paid To Members</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Interest Paid to members</td>
                                    <td>{{ $saving[0]->interest_paid != '' ? $saving[0]->interest_paid : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Savings Rate (%)</td>
                                    <td>{{ $saving[0]->saving_rate != '' ? round($saving[0]->saving_rate) : 'N/A' }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th colspan="2">Are Savings Distributed To Members</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Savings distributed to members</td>
                                    <td>{{ $saving[0]->saving_redistributed != '' ? $saving[0]->saving_redistributed : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date of last distribution</td>
                                    <td>{{ $saving[0]->last_distribution_date != '' ? change_date_month_name_char(str_replace('/', '-', $saving[0]->last_distribution_date)) : 'N/A' }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Loan Security Fund (LSF)</th>
                                    <td colspan="3" style="background: #ccc7c7;width:75%">Yes or No</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="25%">No of Members contribute by LSF</td>
                                    <td width="25%">
                                        {{ $saving[0]->members_contribute_LSF != '' ? $saving[0]->members_contribute_LSF : 'N/A' }}
                                    </td>
                                    <td width="25%">No of Members benefitted
                                        by LSF</td>
                                    <td width="25%">
                                        {{ $saving[0]->members_benefited_LSF != '' ? $saving[0]->members_benefited_LSF : 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Savings Increasing Trend
                        </h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead style="text-align: center;">
                                <tr>
                                    <th width="70%">Trend</th>
                                    <th width="15%">Compulsory</th>
                                    <th width="15%">Voluntary</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Per Member Average Savings during previous year (before 12
                                        months) ( INR)</td>
                                    <td>{{ $saving[0]->savingsMobilization_Last_year_per_member != '' ? $saving[0]->savingsMobilization_Last_year_per_member : 'N/A' }}
                                    </td>
                                    <td>{{ $saving[0]->savingsMobilization_Previous_year_per_member != '' ? $saving[0]->savingsMobilization_Previous_year_per_member : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Per member average savings during last 12 months (INR)</td>
                                    <td>{{ $saving[0]->savingsMobilization_Current_year_per_member != '' ? $saving[0]->savingsMobilization_Current_year_per_member : 'N/A' }}
                                    </td>
                                    <td>{{ $saving[0]->savingsMobilization_voluntary_saving != '' ? $saving[0]->savingsMobilization_voluntary_saving : 'N/A' }}
                                    </td>
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
                    <div class="col-md-12 mb-4">
                        <div class="" style="margin-left: 10px;">
                            {{-- <h4>CHALLENGES</h4> --}}
                        </div>
                    </div>

                    <div class="col-md-12">

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                @php
                                    $count = count($challenges);
                                    $i = 1;
                                @endphp
                                <tr>
                                    <th colspan="{{ $count + 2 }}">Action Plan To Address The Challenges</th>

                                </tr>

                                <tr style="text-align: center;">
                                    <th width="4%">S.No</th>
                                    <th>Action Plan</th>
                                    @if (!empty($challenges))
                                        @foreach ($challenges as $row)
                                            <th>Challenge {{ $i }} : {{ $row->challenge }}</th>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @if (!empty($challenges_actions))
                                    @foreach ($challenges_actions as $key => $row)
                                        <tr>
                                            <td class="tdc" style="text-align: center;">{{ $key + 1 }}</td>
                                            <td>{{ $row['name'] != '' ? $row['name'] : 'N/A' }}</td>
                                            @if (!empty($row['action']))
                                                @foreach ($row['action'] as $val)
                                                    <td>{{ $val != '' ? $val : 'N/A' }}</td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
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
                                    <td class="text-center">1</td>
                                    <td>Who attended the meeting?</td>
                                    <td>
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
                                    <td class="text-center">2</td>
                                    <td>Did members understand the purpose of the meeting?
                                    </td>
                                    <td>{{ checkna($observation[0]->shg_observation_Purpose_a) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>What was quality of Discussion? Did everyone participate?
                                    </td>
                                    <td>{{ checkna($observation[0]->shg_observation_discussion_a) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">4a</td>
                                    <td>Were group members aware of their rules and norms? Did they
                                        understand vision of their group?
                                    </td>
                                    <td>{{ checkna($observation[0]->shg_observation_norms_a) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">4b</td>
                                    <td>Do they understand benefits of being part of the group?
                                    </td>
                                    <td>{{ checkna($observation[0]->shg_observation_norms_b) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">5a</td>
                                    <td>Important practices followed by the group. Do they have a set of
                                        important practices for repayment and savings?

                                    </td>
                                    <td>{{ checkna($observation[0]->shg_observation_savings_a) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">5b</td>
                                    <td>What are those practices?
                                    </td>
                                    <td>{{ checkna($observation[0]->shg_observation_savings_b) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td>Does this group include members who are the most poor and vulnerable,
                                        and if yes, what is their policy to help them?
                                    </td>
                                    <td>{{ checkna($observation[0]->shg_observation_vulnerable_members) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">7a</td>
                                    <td>Are books of account managed by the bookkeeper only or are other office
                                        bearers aware of their financial information?
                                    </td>
                                    <td>{{ checkna($observation[0]->shg_observation_financial_information_a) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">7b</td>
                                    <td>Are all members aware of their savings, loans and group financial
                                        information?
                                    </td>
                                    <td>{{ checkna($observation[0]->shg_observation_financial_information_b) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">8</td>
                                    <td>Are there any unique features of this group. Explain
                                    </td>
                                    <td>{{ checkna($observation[0]->shg_observation_features_group_a) }}</td>
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
                    </div>
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

<script>
    $(document).ready(function(){

        var wheather_conducted_internal = '{{$governance[0]->internal_audit}}';
        var wheather_conducted_external = '{{$governance[0]->external_audit}}';

        // console.log(wheather_conducted);
        // alert(wheather_conducted_external);
        if(wheather_conducted_internal == "Yes" || wheather_conducted_external == "Yes"){
            $(".audit_date").show();
        }else{
            $(".audit_date").hide();

        }

        var wheather_shg_restructred = '{{$profile[0]->shg_basicProfile_restructured}}';

        // console.log(wheather_conducted);
        // alert(wheather_conducted_external);
        if(wheather_shg_restructred == "Yes"){
            $(".date_of_restructuring").show();
        }else{
            $(".date_of_restructuring").hide();

        }
    });
</script>
