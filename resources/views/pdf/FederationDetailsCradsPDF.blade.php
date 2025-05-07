<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fedeartion Details </title>
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
<script type="text/javascript" src="{{ asset('assets\js\charts.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets\js\chartjs-plugin-datalabels.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets\js\chartjs-plugin-doughnutlabel.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets\js\chartjs-plugin-labels.js') }}"></script>

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

<body>
    <div style="background: #f1f0f0;">
        <button class="btn btn-sm getPDFbtn" onclick="getPDF()" style="border: 1px black solid;width:6%;">GET
            PDF</button>
    </div>

    <div class="canvas_all_pdf">
        <div class="pdf-main">
            {{-- <span class="bg-edge"><img src="{{ public_path('images/bg-edge.png') }}" alt=""></span>

            <span class="bg-edge-bottom"><img src="{{ public_path('images/bg-edge-bottom.png') }}"
                    alt=""></span> --}}

            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h3>FEDERATION PROFILE AND ASSESSMENT</h3>

                            <h4><u>BASIC INFORMATION</u></h4>
                        </div>

                    </div>
                    <div style="display: flex;position:relative;left:75%;top:-86px;">
                        <div class="text-center"
                            style="border: 1px black solid;height:50px;width:100px;background: #cea38b;">
                            <h5>Report Card</h5>
                        </div>
                        <div style="border: 1px black solid;height:50px;width:100px;background:{{ $show_final_total }};">

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
                                    <td width="25%">{{ $federation->uin }}</td>

                                    <th width="25%">Name</th>
                                    <td width="25%">{{ $profile[0]->name_of_federation }}</td>
                                </tr>

                                <tr>
                                    <th width="25%">District</th>
                                    <td width="25%">{{ $profile[0]->name_of_district }}</td>

                                    <th width="25%">State</th>
                                    <td width="25%">{{ $profile[0]->name_of_state }}</td>
                                </tr>

                                <tr>
                                    <th width="25%">Country</th>
                                    <td width="25%">{{ $profile[0]->name_of_country }}</td>

                                    <th width="25%">NRLM Code</th>
                                    <td width="25%">{{ $profile[0]->clf_code }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5">
                        <table class="table table-bordered  new-table-dg" style="border: 2px black solid;">
                            <thead>
                                <tr>
                                    <th colspan="2">Legal Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Date of Registration</td>
                                    <td>{{ $profile[0]->date_federation_was_found != '' ? change_date_month_name_char(str_replace('/', '-', $profile[0]->date_federation_was_found)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Legal/Registered
                                        Status</td>
                                    <td>{{ $profile[0]->legal_status != '' ? $profile[0]->legal_status : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Registration Number</td>
                                    <td>{{ (int) $profile[0]->registration_no != '' ? (int) $profile[0]->registration_no : 0 }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th style="width:32%;">Membership</th>
                                    <th style="text-align: center; width:35%;">At the time of Creation</th>
                                    <th style="text-align: center;">Current</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>No. of clusters/habitations</td>
                                    <td style="text-align: center;">{{ (int) $profile[0]->clusters_at_time_creation != '' ? (int) $profile[0]->clusters_at_time_creation : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $profile[0]->total_clusters != '' ? (int) $profile[0]->total_clusters : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>No. of SHGs</td>
                                    <td style="text-align: center;">{{ (int) $profile[0]->shg_at_time_creation != '' ? (int) $profile[0]->shg_at_time_creation : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $profile[0]->total_SHGs != '' ? (int) $profile[0]->total_SHGs : 0 }}
                                    </td>

                                </tr>
                                <tr>
                                    <td>No. of members </td>
                                    <td style="text-align: center;">{{ (int) $profile[0]->members_at_time_creation != '' ? (int) $profile[0]->members_at_time_creation : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $profile[0]->total_members != '' ? (int) $profile[0]->total_members : 0 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

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
                                    <td style="width:10%;">President</td>
                                    <td>{{ $profile[0]->president != '' ? $profile[0]->president : 'N/A' }}</td>
                                    <td style="width:20%;">Name</td>
                                    <td>{{ $profile[0]->book_keeper_name != '' ? $profile[0]->book_keeper_name : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Secretary</td>
                                    <td>{{ $profile[0]->secretary != '' ? $profile[0]->secretary : 'N/A' }}</td>
                                    <td>Date of Appointment</td>
                                    <td>{{ $profile[0]->date_of_appointment != '' ? change_date_month_name_char(str_replace('/', '-', $profile[0]->date_of_appointment)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Treasurer</td>
                                    <td>{{ $profile[0]->Treasurer != '' ? $profile[0]->Treasurer : 'N/A' }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Banking Details</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Account Head</th>
                                    <th>Type</th>
                                    <th>Opening date</th>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Acc. No. </th>
                                    <th>IFCS Code</th>
                                    <th>Regular Operation</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (!empty($profile_bank))
                                    @foreach ($profile_bank as $row)
                                        <tr style="text-align: center;">
                                            <td>{{ $row->account_head }}</td>
                                            <td>{{ $row->account_type }}</td>
                                            <td>{{ $row->account_opening_date != '' ? change_date_month_name_char(str_replace('/', '-', $row->account_opening_date)) : 'N/A' }}
                                            </td>
                                            <td>{{ $row->name_of_the_bank }}</td>
                                            <td>{{ $row->branch }}</td>
                                            <td>{{ $row->account_number }}</td>
                                            <td>{{ $row->account_ifsc }}</td>
                                            <td>{{ $row->updated }}</td>
                                        </tr>
                                    @endforeach
                                @endif


                            </tbody>
                        </table>



                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>GOVERNANCE</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-5">
                        <table class="table table-bordered  new-table-dg" style="margin-bottom: 7rem!important;">
                            <thead>
                                <tr>
                                    <th colspan="2">Adoption</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th style="width:50%;">Adoption of Rules</th>
                                    <th>{{ $governance[0]->adoption_of_rules != '' ? $governance[0]->adoption_of_rules : 'N/A' }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>Date of Adoption</th>
                                    <th>{{ $governance[0]->date_of_adoption != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_adoption)) : 'N/A' }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>Written Rules</th>
                                    <th>{{ $governance[0]->written_norms != '' ? $governance[0]->written_norms : 'N/A' }}
                                    </th>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="col-md-7">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Details on Election</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Election or Selection</td>
                                    <td style="width: 25%;">{{ $governance[0]->frequency_election != '' ? $governance[0]->frequency_election : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Frequency as per norms</td>
                                    <td>{{ $governance[0]->frequency_as_per_norms != '' ? $governance[0]->frequency_as_per_norms : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>First Election /Selection Date</td>
                                    <td>{{ $governance[0]->first_election_date != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->first_election_date)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Election/Selection conducted so far</td>
                                    <td>{{ $governance[0]->no_of_elections_conducted_so_far != '' ? $governance[0]->no_of_elections_conducted_so_far : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last Election/Selection Date</td>
                                    <td>{{ $governance[0]->date_of_last_election_option != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_last_election_option)) : 'N/A' }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <tbody>
                                <tr style="text-align: center;">
                                    <th style="text-align: left;background:#ccc7c7">Last 3 Elections/Selections
                                        conducted as per norms</th>
                                    <th
                                        style="width:15%; background: {{ $governance[0]->last_two_election_conducted != 'Yes' ? 'red' : 'green' }}">
                                        {{ $governance[0]->last_two_election_conducted }}</th>
                                    <th
                                        style="width:15%; background: {{ $governance[0]->last_two_election_conducted_2nd != 'Yes' ? 'red' : 'green' }}">
                                        {{ $governance[0]->last_two_election_conducted_2nd }}</th>
                                    <th
                                        style="width:15%; background: {{ $governance[0]->last_two_election_conducted_3rd != 'Yes' ? 'red' : 'green' }}">
                                        {{ $governance[0]->last_two_election_conducted_3rd }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Meeting Details</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Frequency of Meetings</td>
                                    <td class="text-center">
                                        {{ $governance[0]->frequency_of_meetings_on_a_monthly_basis != '' ? $governance[0]->frequency_of_meetings_on_a_monthly_basis : 'N/A' }}
                                    </td>
                                    <td style="width:45%;">Average participation of members in 12 months</td>
                                    <td class="text-center" style="width: 6%;">
                                        {{ (int) $governance[0]->participation_members_last_six_months != '' ? (int) $governance[0]->participation_members_last_six_months : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>No. Of meetings in last 12 months</td>
                                    <td class="text-center">
                                        {{ (int) $governance[0]->meetings_federation_last_six_months != '' ? (int) $governance[0]->meetings_federation_last_six_months : 0 }}
                                    </td>
                                    <td>Total Board/EC Members</td>
                                    <td class="text-center">
                                        {{ (int) $governance[0]->Total_board_members != '' ? (int) $governance[0]->Total_board_members : 0 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="50%">Status Of Minutes During Last 12 Months</th>
                                    <th style="background: #ccc7c7">
                                        {{ $governance[0]->minutes_of_group_meetings_recorded != '' ? $governance[0]->minutes_of_group_meetings_recorded : 'N/A' }}
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Who writes the minutes?</td>
                                    <td>{{ $governance[0]->who_writes_the_minutes != '' ? $governance[0]->who_writes_the_minutes : 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="50%" colspan="2">General Assembly/Body Meeting</th>
                                    <th style="background: #ccc7c7" colspan="2">
                                        {{ $governance[0]->general_assembly != '' ? $governance[0]->general_assembly : 'N/A' }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width:25%;">Frequency </td>
                                    <td>{{ $governance[0]->frequency_assembly_meetings != '' ? $governance[0]->frequency_assembly_meetings : 'N/A' }}
                                    </td>
                                    <td style="width:25%;">No.of GA/GB members</td>
                                    <td>{{ (int) $governance[0]->number_of_GA_members != '' ? (int) $governance[0]->number_of_GA_members : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Meetings conducted ( last 12 months) </td>
                                    <td>{{ (int) $governance[0]->federation_conducted_meetings != '' ? (int) $governance[0]->federation_conducted_meetings : 0 }}
                                    </td>
                                    <td>Date of Last Meeting</td>
                                    <td>{{ $governance[0]->date_of_last_metting != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_last_metting)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last year Annual Plan and
                                        Budget approved by GB </td>
                                    <td>{{ $governance[0]->budget_approval_by_general_assembly != '' ? $governance[0]->budget_approval_by_general_assembly : 'N/A' }}
                                    </td>
                                    <td>Date Of last plan and
                                        budget approval</td>
                                    <td>{{ $governance[0]->date_of_last_budget_and_annual_approval != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_last_budget_and_annual_approval)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="background:#ccc7c7 ">Achievement of last year annual plan
                                    </td>
                                </tr>
                                <tr>
                                    <td>Financial </td>
                                    <td>{{ $governance[0]->Annual_plan_Financial }} -
                                        {{ $governance[0]->Annual_plan_Financial_specify }}</td>
                                    <td>Social</td>
                                    <td>{{ $governance[0]->Annual_plan_Social }} -
                                        {{ $governance[0]->Annual_plan_Social_specify }}</td>
                                </tr>
                                <tr>
                                    <td>Livelihood </td>
                                    <td>{{ $governance[0]->Annual_plan_Livelihood }} -
                                        {{ $governance[0]->Annual_plan_Livelihood_specify }}</td>
                                    <td>Convergence</td>
                                    <td>{{ $governance[0]->Annual_plan_Convergence }}
                                        -
                                        {{ $governance[0]->Annual_plan_Convergence_specify }}</td>
                                </tr>
                                <tr>
                                    <td>Others </td>
                                    <td>{{ $governance[0]->Annual_plan_Others }} -
                                        {{ $governance[0]->Annual_plan_Others_specify }}</td>
                                    <td>Are members
                                        aware of
                                        achievements?</td>
                                    <td>{{ checkna($governance[0]->member_aware) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Update of Books of Accounts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 60%;">How often books updated? </td>
                                    <td>{{ $governance[0]->how_often_are_books_updated != '' ? $governance[0]->how_often_are_books_updated : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date of last Update </td>
                                    <td>{{ $governance[0]->date_of_last_updated_books != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_last_updated_books)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Updated Status </td>
                                    <td>{{ $governance[0]->updated_status != '' ? $governance[0]->updated_status : 'N/A' }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Grade During Last 12 months
                                        (Grade of Federation)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="text-align: center;background:#ccc7c7">
                                    <td>{{ $governance[0]->grading_obtained != '' ? $governance[0]->grading_obtained : 'N/A' }}
                                    </td>
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
                                    <td style="width: 30%;">Formal of SAC </td>
                                    <td>{{ $governance[0]->federation_social_audit_committee != '' ? $governance[0]->federation_social_audit_committee : 'N/A' }}
                                    </td>
                                    <td style="width: 30%;">SAC formation date</td>
                                    <td>{{ $governance[0]->when_was_the_SAC_created != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->when_was_the_SAC_created)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Functioning during last 12 months</td>
                                    <td>{{ $governance[0]->SAC_functioned != '' ? $governance[0]->SAC_functioned : 'N/A' }}
                                    </td>
                                    <td>Date of last report submitted by SAC to GB/GA</td>
                                    <td>{{ $governance[0]->date_last_report_submitted != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_last_report_submitted)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Issues highlighted</td>
                                    <td colspan="3">

                                        @if (
                                            $governance[0]->issues_highlighted1 != '' ||
                                                $governance[0]->issues_highlighted2 != '' ||
                                                $governance[0]->issues_highlighted3 != '' ||
                                                $governance[0]->issues_highlighted4 != '' ||
                                                $governance[0]->issues_highlighted5 != '')
                                            <ul>
                                                @if ($governance[0]->issues_highlighted1 != '')
                                                    <li>{{ $governance[0]->issues_highlighted1 }}</li>
                                                @endif
                                                @if ($governance[0]->issues_highlighted2 != '')
                                                    <li>{{ $governance[0]->issues_highlighted2 }}</li>
                                                @endif
                                                @if ($governance[0]->issues_highlighted3 != '')
                                                    <li>{{ $governance[0]->issues_highlighted3 }}</li>
                                                @endif
                                                @if ($governance[0]->issues_highlighted4 != '')
                                                    <li>{{ $governance[0]->issues_highlighted4 }}</li>
                                                @endif
                                                @if ($governance[0]->issues_highlighted5 != '')
                                                    <li>{{ $governance[0]->issues_highlighted5 }}</li>
                                                @endif
                                            </ul>

                                        @endif
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th style="width:40%">Any Other committee Formed?</th>
                                    <th style="background:#ccc7c7 ">
                                        {{ $governance[0]->any_other_committee_formed != '' ? $governance[0]->any_other_committee_formed : 'N/A' }}<br>
                                        @if ($governance[0]->any_other_committee_formed == 'Yes')
                                            <ul>

                                                <li>1st - {{ $governance[0]->please_mention_names_of_committee }}</li>


                                                <li>2st -{{ $governance[0]->please_mention_names_of_committee2 }}</li>


                                                <li>3st -{{ $governance[0]->please_mention_names_of_committee3 }}</li>

                                            </ul>
                                        @endif

                                    </th>
                                </tr>
                            </thead>

                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th style="width:35%;">Audit</th>
                                    <th>Internal</th>
                                    <th>External</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Is audit available?</td>
                                    <td>{{ $governance[0]->internal_audit != '' ? $governance[0]->internal_audit : 'N/A' }}
                                    </td>
                                    <td>{{ $governance[0]->external_audit != '' ? $governance[0]->external_audit : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Frequency (last 12 months)</td>
                                    <td>{{ $governance[0]->frequency_internal_audit_conducted != '' ? $governance[0]->frequency_internal_audit_conducted : 'N/A' }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Date of last audit</td>
                                    <td>{{ $governance[0]->date_of_last_internal_audit != '' ? Change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_last_internal_audit)) : 'N/A' }}
                                    </td>
                                    <td>{{ $governance[0]->date_external_audit_conducted != '' ? Change_date_month_name_char(str_replace('/', '-', $governance[0]->date_external_audit_conducted)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Issues resolved by federation</td>
                                    <td>{{ $governance[0]->Highlighted_issues_addressed != '' ? $governance[0]->Highlighted_issues_addressed : 'N/A' }}
                                    </td>
                                    <td>{{ $governance[0]->issues_highlighted_resolved ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Issues raised during 12 months
                                        ?</td>
                                    <td>{{ $governance[0]->Issues_highlighted_by_internal_audit }}</td>
                                    <td>{{ $governance[0]->issues_highlighted_external_audit }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Training Details</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <!-- <th>S.no</th> -->
                                    <th>Designation</th>
                                    <th>Name of training</th>
                                    <th>Duration (days)</th>
                                    <th>Date</th>
                                    <th>Recipient</th>
                                    <th>Trainer Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($governance_6) || !empty($governance_7) || !empty($governance_8))


                                @if (!empty($governance_6))
                                    @foreach ($governance_6 as $row)
                                        @php
                                            $i = 1;
                                        @endphp
                                        <tr>
                                            <!-- <td style="text-align: center;">{{ $i + 1 }}</td> -->
                                            <td>Current Leaders</td>
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
                                            <td>{{ $row->name }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                                @if (!empty($governance_7))
                                    @foreach ($governance_7 as $row)
                                        <tr>
                                            <!-- <td>2</td> -->
                                            <td>SAC members</td>
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
                                            <td>{{ $row->name }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                                @if (!empty($governance_8))
                                    @foreach ($governance_8 as $row)
                                        <tr>
                                            <!-- <td>3</td> -->
                                            <td>Book-keeper</td>
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
                                            <td>{{ $row->name }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                @else
                                <tr>
                                    <td style="text-align: center" colspan="6">None</td>
                                </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Defunct SHG Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 35%;">Total SHGs formed in federation</td>
                                    <td style="width: 15%;">{{ (int) $governance[0]->Total_SHGs_formed != '' ? (int) $governance[0]->Total_SHGs_formed : 0 }}
                                    </td>
                                    <td style="width: 35%;">Current defunct SHGs</td>
                                    <td style="width: 15%;">{{ $governance[0]->present_no_of_SHGs_defunct != '' ? $governance[0]->present_no_of_SHGs_defunct : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Defunct SHGs (%)</td>
                                    <td>{{ $governance[0]->Defunct_SHGs != '' ? $governance[0]->Defunct_SHGs : 0 }}
                                    </td>
                                    <td>Reasons for defunct</td>
                                    <td>{{ $governance[0]->Defunct_SHGs_reasons != '' ? $governance[0]->Defunct_SHGs_reasons : 'N/A' }}
                                    </td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>INCLUSION</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Wealth Ranking/Poverty Mapping</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="50%">Wealth Ranking/Poverty Mapping</td>
                                    <td>{{ $inclusion[0]->wealth_ranking_mapping }}</td>
                                </tr>
                                <tr>
                                    <td>1st Poverty Mapping</td>
                                    <td>{{ change_date_month_name_char(str_replace('/', '-', $inclusion[0]->month_year_of_1st_poverty_mapping)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last Update</td>
                                    <td>{{ change_date_month_name_char(str_replace('/', '-', $inclusion[0]->month_year_of_last_update)) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">Last Poverty Mapping Results</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center" >
                                    <th>S. No</th>
                                    <th>Poverty Mapping</th>
                                    <th>Ineligible to get mobilized into SHGs</th>
                                    <th>HHs organized into SHGs</th>
                                    <th>Total HH member</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Poorest & Vulnerable</td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_poorest_and_most_vulnerable != '' ? (int) $inclusion[0]->no_of_poorest_and_most_vulnerable : 0 }}
                                    </td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_poorest_and_most_vulnerable_mobilised != '' ? (int) $inclusion[0]->no_of_poorest_and_most_vulnerable_mobilised : 0 }}
                                    </td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_poorest_and_most_vulnerable_hhm != '' ? (int) $inclusion[0]->no_of_poorest_and_most_vulnerable_hhm : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Poor</td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_poor_category != '' ? (int) $inclusion[0]->no_of_poor_category : 0 }}
                                    </td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_poor_category_mobilised != '' ? (int) $inclusion[0]->no_of_poor_category_mobilised : 0 }}
                                    </td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_poor_category_hhm != '' ? (int) $inclusion[0]->no_of_poor_category_hhm : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Medium Poor</td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_medium_poor != '' ? (int) $inclusion[0]->no_of_medium_poor : 0 }}
                                    </td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_medium_poor_mobilised != '' ? (int) $inclusion[0]->no_of_medium_poor_mobilised : 0 }}
                                    </td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_medium_poor_hhm != '' ? (int) $inclusion[0]->no_of_medium_poor_hhm : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td>Rich</td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_rich != '' ? (int) $inclusion[0]->no_of_rich : 0 }}
                                    </td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_rich_mobilised != '' ? (int) $inclusion[0]->no_of_rich_mobilised : 0 }}
                                    </td>
                                    <td class="text-center">{{ (int) $inclusion[0]->no_of_rich_hhm != '' ? (int) $inclusion[0]->no_of_rich_hhm : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center" colspan="2" style="background: #ccc7c7">Total</td>
                                    <td class="text-center" style="background: #ccc7c7">{{ (int) $inclusion[0]->total_poverty_mapping_ineligible_mobilised != '' ? (int) $inclusion[0]->total_poverty_mapping_ineligible_mobilised : 0 }}
                                    </td>
                                    <td class="text-center" style="background: #ccc7c7">{{ (int) $inclusion[0]->total_poverty_mapping_mobilised_member != '' ? (int) $inclusion[0]->total_poverty_mapping_mobilised_member : 0 }}
                                    </td>
                                    <td class="text-center" style="background: #ccc7c7">{{ (int) $inclusion[0]->total_poverty_mapping_households != '' ? (int) $inclusion[0]->total_poverty_mapping_households : 0 }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">Caste Composition</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>No. Of SC/ST</th>
                                    <th>No Of OBC</th>
                                    <th>No Of Others</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="text-center">
                                    <td>{{ (int) $inclusion[0]->no_of_SC_and_ST != '' ? (int) $inclusion[0]->no_of_SC_and_ST : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->no_of_OBC != '' ? (int) $inclusion[0]->no_of_OBC : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->no_of_others != '' ? (int) $inclusion[0]->no_of_others : 0 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">No. of Loans Disbursed Under Each Category</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>Category</th>
                                    <th>Loan
                                        Disbursed
                                        (#)
                                    </th>
                                    <th>Amount
                                        Disbursed
                                        (INR)</th>
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
                                        (INR)</th>
                                    <th>Loan
                                        Disbursed
                                        (#)</th>
                                    <th>Amount
                                        Disbursed
                                        (INR)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="text-center">
                                    <td></td>
                                    <td colspan="2" style="background: #ccc7c7">Federation Loans</td>
                                    <td colspan="2" style="background: #ccc7c7">External Loans</td>
                                    <td colspan="2" style="background: #ccc7c7">Other Loans</td>
                                    <td colspan="2" style="background: #ccc7c7">Total Loans</td>
                                </tr>
                                <tr class="text-center">
                                    <td style="text-align: left;">Poorest &
                                        Vulnerable</td>
                                    <td>{{ (int) $inclusion[0]->federation_poorest_category != '' ? (int) $inclusion[0]->federation_poorest_category : 0 }}
                                    </td>
                                    <td>{{ (int)  $inclusion[0]->federation_poorest_category_amount != '' ? (int) $inclusion[0]->federation_poorest_category_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->external_poorest_category != '' ? (int) $inclusion[0]->external_poorest_category : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->external_poorest_category_amount != '' ? (int) $inclusion[0]->external_poorest_category_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->vi_poorest_category != '' ? (int) $inclusion[0]->vi_poorest_category : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->vi_poorest_category_amount != '' ? (int) $inclusion[0]->vi_poorest_category_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_poorest_category + (int) $inclusion[0]->external_poorest_category + (int) $inclusion[0]->vi_poorest_category }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_poorest_category_amount + (int) $inclusion[0]->external_poorest_category_amount + (int) $inclusion[0]->vi_poorest_category_amount }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td style="text-align: left;">Poor</td>
                                    <td>{{ (int) $inclusion[0]->federation_poor_category != '' ? (int) $inclusion[0]->federation_poor_category : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_poor_category_amount != '' ? (int) $inclusion[0]->federation_poor_category_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->external_poor_category != '' ? (int) $inclusion[0]->external_poor_category : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->external_poor_category_amount != '' ? (int) $inclusion[0]->external_poor_category_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->vi_poor_category != '' ? (int) $inclusion[0]->vi_poor_category : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->vi_poor_category_amount != '' ? (int) $inclusion[0]->vi_poor_category_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_poor_category + (int) $inclusion[0]->external_poor_category + (int) $inclusion[0]->vi_poor_category }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_poor_category_amount + (int) $inclusion[0]->external_poor_category_amount + (int) $inclusion[0]->vi_poor_category_amount }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td style="text-align: left;">Medium
                                        Poor</td>
                                    <td>{{ (int) $inclusion[0]->federation_medium != '' ? (int) $inclusion[0]->federation_medium : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_medium_amount != '' ? (int) $inclusion[0]->federation_medium_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->external_medium != '' ? (int) $inclusion[0]->external_medium : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->external_medium_amount != '' ? (int) $inclusion[0]->external_medium_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->vi_medium != '' ? (int) $inclusion[0]->vi_medium : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->vi_medium_amount != '' ? (int) $inclusion[0]->vi_medium_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_medium + (int) $inclusion[0]->external_medium + (int) $inclusion[0]->vi_medium }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_medium_amount + (int) $inclusion[0]->external_medium_amount + (int) $inclusion[0]->vi_medium_amount }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td style="text-align: left;">Rich</td>
                                    <td>{{ (int) $inclusion[0]->federation_rich != '' ? (int) $inclusion[0]->federation_rich : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_rich_amount != '' ? (int) $inclusion[0]->federation_rich_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->external_rich != '' ? (int) $inclusion[0]->external_rich : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->external_rich_amount != '' ? (int) $inclusion[0]->external_rich_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->vi_rich != '' ? (int) $inclusion[0]->vi_rich : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->vi_rich_amount != '' ? (int) $inclusion[0]->vi_rich_amount : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_rich + (int) $inclusion[0]->external_rich + (int) $inclusion[0]->vi_rich }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_rich_amount + (int) $inclusion[0]->external_rich_amount + (int) $inclusion[0]->vi_rich_amount }}
                                    </td>
                                </tr>
                                <tr class="text-center" style="background: #ccc7c7">
                                    <td style="text-align: left;">Total</td>
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
                                    <td>{{ (int) $inclusion[0]->federation_poorest_category + (int) $inclusion[0]->external_poorest_category + (int) $inclusion[0]->vi_poorest_category + (int) $inclusion[0]->federation_poor_category + (int) $inclusion[0]->external_poor_category + (int) $inclusion[0]->vi_poor_category + (int) $inclusion[0]->federation_rich + (int) $inclusion[0]->external_rich + (int) $inclusion[0]->vi_rich + (int) $inclusion[0]->federation_medium + (int) $inclusion[0]->external_medium + (int) $inclusion[0]->vi_medium }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_rich_amount + (int) $inclusion[0]->external_rich_amount + (int) $inclusion[0]->vi_rich_amount + (int) $inclusion[0]->federation_poorest_category_amount + (int) $inclusion[0]->external_poorest_category_amount + (int) $inclusion[0]->vi_poorest_category_amount + (int) $inclusion[0]->federation_poor_category_amount + (int) $inclusion[0]->external_poor_category_amount + (int) $inclusion[0]->vi_poor_category_amount + (int) $inclusion[0]->federation_medium_amount + (int) $inclusion[0]->external_medium_amount + (int) $inclusion[0]->vi_medium_amount }}
                                    </td>
                                </tr>


                            </tbody>
                        </table>



                    </div>

                    {{-- <div class="col-md-6">
                        <h4 class="bg-white p-3 mb-0">Graph1</h4>
                    </div> --}}

                    <div class="col-md-6 ">

                        <div class="card">
                            <div class="card-block">
                                <div class="w-heading d-flex">
                                    <span>
                                        <h5>No of loan Disbursed</h5>
                                    </span>
                                </div>
                                <div class="w-box">
                                    <canvas id="loans" style="height: 236px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="card">
                            <div class="card-block">
                                <div class="w-heading d-flex">
                                    <span>
                                        <h5>No of loan Amount Disbursed</h5>
                                    </span>
                                </div>
                                <div class="w-box">
                                    <canvas id="type_loans" style="height: 236px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>




                    {{-- <div class="col-md-6">
                            <h4 class="bg-white p-3 mb-0">Graph2</h4>
                        </div> --}}


                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">No. Of HHs Benefited From All Loans During Last 3 Years</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th style="border-bottom-color:#cea38b;">Category</th>
                                    <th style="border-bottom-color:#cea38b; width:20%;">Total Member
                                        HHs (#)</th>
                                    <th colspan="3">Received Loan (#)</th>

                                </tr>
                                <tr class="text-center">
                                    <th></th>
                                    <th></th>
                                    <th>Federation Loan</th>
                                    <th>External Loan</th>
                                    <th>Other Loan</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Poorest & Vulnerable</td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_poorest_category_hhs != '' ? (int) $inclusion[0]->federation_poorest_category_hhs : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_poorest_category_recloan != '' ? (int) $inclusion[0]->federation_poorest_category_recloan : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->external_poorest_category_recloan != '' ? (int) $inclusion[0]->external_poorest_category_recloan : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->vi_poorest_category_recloan != '' ? (int) $inclusion[0]->vi_poorest_category_recloan : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Poor</td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_poor_category_hhs != '' ? (int) $inclusion[0]->federation_poor_category_hhs : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_poor_category_recloan != '' ? (int) $inclusion[0]->federation_poor_category_recloan : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->external_poor_category_recloan != '' ? (int) $inclusion[0]->external_poor_category_recloan : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->vi_poor_category_recloan != '' ? (int) $inclusion[0]->vi_poor_category_recloan : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Medium Poor</td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_medium_hhs != '' ? (int) $inclusion[0]->federation_medium_hhs : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_medium_recloan != '' ? (int) $inclusion[0]->federation_medium_recloan : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->external_medium_recloan != '' ? (int) $inclusion[0]->external_medium_recloan : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->vi_medium_recloan != '' ? (int) $inclusion[0]->vi_medium_recloan : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rich</td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_rich_hhs != '' ? (int) $inclusion[0]->federation_rich_hhs : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_rich_recloan != '' ? (int) $inclusion[0]->federation_rich_recloan : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->external_rich_recloan != '' ? (int) $inclusion[0]->external_rich_recloan : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->vi_rich_recloan != '' ? (int) $inclusion[0]->vi_rich_recloan : 0 }}
                                    </td>
                                </tr>
                                <tr style="text-align: center;background:#ccc7c7;">
                                    <td style="text-align:left">Total</td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_poorest_category_hhs + (int) $inclusion[0]->federation_poor_category_hhs + (int) $inclusion[0]->federation_medium_hhs + (int) $inclusion[0]->federation_rich_hhs }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_poorest_category_recloan + (int) $inclusion[0]->federation_poor_category_recloan + (int) $inclusion[0]->federation_medium_recloan + (int) $inclusion[0]->federation_rich_recloan }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->external_poorest_category_recloan + (int) $inclusion[0]->external_poor_category_recloan + (int) $inclusion[0]->external_medium_recloan + (int) $inclusion[0]->external_rich_recloan }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->vi_poorest_category_recloan + (int) $inclusion[0]->vi_poor_category_recloan + (int) $inclusion[0]->vi_medium_recloan + (int) $inclusion[0]->vi_rich_recloan }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-7">

                        <h4 class="bg-white p-3 mb-0">Board & Office Bearer Membership</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>No. Of Members</th>
                                    <th>Board
                                        Membership</th>
                                    <th>Office
                                        Bearers/Leaders</th>

                                </tr>

                            </thead>

                            <tbody>
                                <tr>
                                    <td>Very poor & vulnerable</td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->members_from_poorest_category != '' ? (int) $inclusion[0]->members_from_poorest_category : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_inclusion_poor_members != '' ? (int) $inclusion[0]->federation_inclusion_poor_members : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Poor</td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->members_from_poor_category != '' ? (int) $inclusion[0]->members_from_poor_category : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_inclusion_poor1_members != '' ? (int) $inclusion[0]->federation_inclusion_poor1_members : 0 }}
                                    </td>

                                </tr>
                                <tr>
                                    <td>Medium Poor & Rich</td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->members_from_middle_and_rich_category != '' ? (int) $inclusion[0]->members_from_middle_and_rich_category : 0 }}
                                    </td>
                                    <td style="text-align: center;">{{ (int) $inclusion[0]->federation_inclusion_rich_members != '' ? (int) $inclusion[0]->federation_inclusion_rich_members : 0 }}
                                    </td>
                                </tr>

                                <tr style="text-align: center;background:#ccc7c7;">
                                    <td style="text-align:left">Total members</td>
                                    <td>{{ (int) $inclusion[0]->total_board_members_cluster != '' ? (int) $inclusion[0]->total_board_members_cluster : 0 }}
                                    </td>
                                    <td>{{ (int) $inclusion[0]->federation_inclusion_poor_members + (int) $inclusion[0]->federation_inclusion_poor1_members + (int) $inclusion[0]->federation_inclusion_rich_members }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-5">

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>Special Goals of the
                                        Federation for Curent Year</th>
                                </tr>

                            </thead>

                            <tbody>
                                @if ($inclusion[0]->federation_social_goal_a != '')
                                    <tr>
                                        <td>{{ $inclusion[0]->federation_social_goal_a }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($inclusion[0]->federation_social_goal_b != '')
                                    <tr>
                                        <td>{{ $inclusion[0]->federation_social_goal_b }}
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>



                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>EFFICIENCY</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">

                    <div class="col-md-7">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Integrated Credit Plan</th>
                                </tr>

                            </thead>

                            <tbody>
                                <tr>
                                    <td style="width: 70%;">Has Federation prepared integrated
                                        credit plan</td>
                                    <td>{{ $efficiency[0]->integrated_Federation_plan != '' ? $efficiency[0]->integrated_Federation_plan : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date of last plan approved by
                                        Federation</td>
                                    <td>{{ $efficiency[0]->date_federation_plan_approved != '' ? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->date_federation_plan_approved)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date it was submitted to Partner</td>
                                    <td>{{ $efficiency[0]->date_federation_plan_submitted != '' ? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->date_federation_plan_submitted)) : 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-5">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Approval Process</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>No of days taken to approve loan
                                        application</td>
                                    <td style="width: 20%;">{{ (int) $efficiency[0]->time_taken_to_approve_loan != '' ? (int) $efficiency[0]->time_taken_to_approve_loan : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Average Monthly loans during last 12
                                        months
                                    </td>
                                    <td>{{ (int) $efficiency[0]->loans_per_month_approved != '' ? (int) $efficiency[0]->loans_per_month_approved : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Time taken from approval to cash in
                                        hand</td>
                                    <td>{{ (int) $efficiency[0]->time_taken_to_give_money_from_approval != '' ? (int) $efficiency[0]->time_taken_to_give_money_from_approval : 0 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>New Members Mobilized During Last 12 Months</th>
                                    <th style="background: #ccc7c7">
                                        {{ (int) $efficiency[0]->members_mobilized != '' ? (int) $efficiency[0]->members_mobilized : 0 }}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">Cost Ratio Per Client</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>Cost Per Client (INR)</th>
                                    <th>Average Operating Expense (INR)</th>
                                    <th>Average No. of Clients</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>{{ $efficiency[0]->cost_ratio_per_active_client != '' ? $efficiency[0]->cost_ratio_per_active_client : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->operating_expenes != '' ? $efficiency[0]->operating_expenes : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->average_no != '' ? $efficiency[0]->average_no : 0 }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">Operation Expense Ratio</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>Operation Expense Ratio</th>
                                    <th>Average Operating Expense (INR)</th>
                                    <th>Average Gross Portfolio</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>{{ $efficiency[0]->federation_operation_expense_ratio != '' ? $efficiency[0]->federation_operation_expense_ratio : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->operating_expenes != '' ? $efficiency[0]->operating_expenes : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->avg_gross_portfolio != '' ? $efficiency[0]->avg_gross_portfolio : 0 }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">Cost Income Ratio for Last 3 Years</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>S. No. </th>
                                    <th>Time Period</th>
                                    <th>Cost - Income Ratio(%)</th>
                                    <th>Operating Income</th>
                                    <th>Operating
                                        Expense</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td>Last 12 months</td>
                                    <td>{{ $efficiency[0]->cost_income_ratio_year1 != '' ? $efficiency[0]->cost_income_ratio_year1 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->operating_income_year1 != '' ? $efficiency[0]->operating_income_year1 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->operating_expenses_year1 != '' ? $efficiency[0]->operating_expenses_year1 : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>1 year before last year</td>
                                    <td>{{ $efficiency[0]->cost_income_ratio_year2 != '' ? $efficiency[0]->cost_income_ratio_year2 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->operating_income_year2 != '' ? $efficiency[0]->operating_income_year2 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->operating_expenses_year2 != '' ? $efficiency[0]->operating_expenses_year2 : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>2 years before last year</td>
                                    <td>{{ $efficiency[0]->cost_income_ratio_year3 != '' ? $efficiency[0]->cost_income_ratio_year3 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->operating_income_year3 != '' ? $efficiency[0]->operating_income_year3 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->operating_expenses_year3 != '' ? $efficiency[0]->operating_expenses_year3 : 0 }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    {{-- <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">Axis Chart </h4>
                    </div> --}}

                    <div class="col-md-6" style="margin-left: 333px;">
                        <div class="card">
                            <div class="card-block">
                                <div class="w-heading d-flex">
                                    <span >
                                        <h5 >Cost Income Ratio for Last 3 Years</h5>
                                    </span>
                                </div>
                                <div class="w-box">
                                    {{-- <div id="axis"></div> --}}
                                    <canvas id="axis"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">Average Outstanding Loan Size and Active Borrowers During Last 3
                            Years</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>S. No. </th>
                                    <th>Time Period</th>
                                    <th>Average Outstanding
                                        Loan Size (INR)</th>
                                    <th>Loan Outstanding
                                        Amount (INR)
                                    </th>
                                    <th>Active Borrowers</th>

                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td>Last 12 months</td>
                                    <td>{{ (float) $efficiency[0]->outstanding_loan_ratio_year1 != '' ? (float) $efficiency[0]->outstanding_loan_ratio_year1 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->outstanding_loan_year1 != '' ? $efficiency[0]->outstanding_loan_year1 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->active_borrower_year1 != '' ? $efficiency[0]->active_borrower_year1 : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>1 year before last year</td>
                                    <td>{{ (float) $efficiency[0]->outstanding_loan_ratio_year2 != '' ? (float) $efficiency[0]->outstanding_loan_ratio_year2 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->outstanding_loan_year2 != '' ? $efficiency[0]->outstanding_loan_year2 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->active_borrower_year2 != '' ? $efficiency[0]->active_borrower_year2 : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>2 years before last year</td>
                                    <td>{{ (float) $efficiency[0]->outstanding_loan_ratio_year3 != '' ? (float) $efficiency[0]->outstanding_loan_ratio_year3 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->outstanding_loan_year3 != '' ? $efficiency[0]->outstanding_loan_year3 : 0 }}
                                    </td>
                                    <td>{{ $efficiency[0]->active_borrower_year3 != '' ? $efficiency[0]->active_borrower_year3 : 0 }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    {{-- <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">Axis Chart </h4>
                    </div> --}}

                    <div class="col-md-6" style="margin-left: 333px;">
                        <div class="card">
                            <div class="card-block">
                                <div class="w-heading d-flex">
                                    <span>
                                        <h5>Average Outstanding Loan Size</h5>
                                    </span>
                                </div>
                                <div class="w-box">
                                    {{-- <div id="axis"></div> --}}
                                    <canvas id="axis_chart" style="height: 236px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Monthly Progress Reports
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td style="width: 25%;">Does federation prepare a report?</td>
                                    <td style="width: 25%;">{{ $efficiency[0]->integrated_credit_plan_approved != '' ? $efficiency[0]->integrated_credit_plan_approved : 'N/A' }}
                                    </td>
                                    <td style="width: 25%;">Last report submitted</td>
                                    <td style="width: 25%;">{{ $efficiency[0]->date_last_report_submitted != '' ? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->date_last_report_submitted)) : 0 }}
                                    </td>
                                </tr>


                            </tbody>
                        </table>



                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>CREDIT HISTORY</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-7">

                        {{-- <h4 class="bg-white p-3 mb-0">Cost Ratio Per Client</h4> --}}
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="3">Loan Approvals During Last 12 Months</th>
                                </tr>
                                <tr class="text-center">
                                    <th>S. No.</th>
                                    <th>Details</th>
                                    <th>Number</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align:left;">No of loan applications received</td>
                                    <td>{{ $credithistory[0]->applications_received_for_loans != '' ? $credithistory[0]->applications_received_for_loans : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align:left;">No of loan applications approved</td>
                                    <td>{{ (int) $credithistory[0]->no_of_loans_approved != '' ? (int) $credithistory[0]->no_of_loans_approved : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align:left;">Pending loan applications</td>
                                    <td>{{ (int) $credithistory[0]->pending_loan_applications != '' ? (int) $credithistory[0]->pending_loan_applications : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align:left;">No of Loans Approved within 15 days</td>
                                    <td>{{ (int) $credithistory[0]->no_of_loans_approved_within_15_days != '' ? (int) $credithistory[0]->no_of_loans_approved_within_15_days : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td style="text-align:left;">No of loans approved within 16 to 30 days</td>
                                    <td>{{ (int) $credithistory[0]->no_of_loans_sanctioned_within_15_days != '' ? (int) $credithistory[0]->no_of_loans_sanctioned_within_15_days : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td style="text-align:left;">No of loans approved in more than 30 days</td>
                                    <td>{{ (int) $credithistory[0]->no_of_loans_sanctioned_between_1_3_months != '' ? (int) $credithistory[0]->no_of_loans_sanctioned_between_1_3_months : 0 }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-5">

                        {{-- <h4 class="bg-white p-3 mb-0">Cost Ratio Per Client</h4> --}}
                        <table class="table table-bordered  new-table-dg" style="margin-bottom: 7rem;">
                            <thead>
                                <tr>
                                    <th colspan="3">Cumulative Loan Amount</th>
                                </tr>
                                <tr class="text-center">
                                    <th>S. No.</th>
                                    <th>Institution</th>
                                    <th>Amount (INR)</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td>Federation</td>
                                    <td>{{ (int) $credithistory[0]->cumulative_amount_federation_loan }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>External</td>
                                    <td>{{ (int) $credithistory[0]->cumulative_amount_bank_loan }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Other</td>
                                    <td>{{ (int) $credithistory[0]->cumulative_amount_other_loan }}</td>
                                </tr>
                                <tr style="background: #ccc7c7">
                                    <td colspan="2"> Total</td>
                                    <td>{{ (int) $credithistory[0]->cumulative_amount }}</td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">No. of Members Not Received Even a Single Loan During Last 3
                            Years</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>S. No.</th>
                                    <th>Loan Type</th>
                                    <th colspan="4">Members not received even a single loan during last 3 years</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr style="background: #ccc7c7">
                                    <td width="10%">1</td>
                                    <td width="20%">Federation Loans</td>
                                    <td width="15%">Poorest & Vulnerable</td>
                                    <td width="15%">Poor</td>
                                    <td width="15%">Medium Poor</td>
                                    <td width="15%">Rich</td>
                                    <td></td>
                                </tr>
                                <tr class="text-center">
                                    <td></td>
                                    <td>Last 12 months</td>
                                    <td>{{ (int) $credithistory[0]->federation_poorest_members_not_received_federation_loan_year1 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_poor_members_not_received_federation_loan_year1 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_medium_members_not_received_federation_loan_year1 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_rich_members_not_received_federation_loan_year1 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_total_members_not_received_federation_loan_year1 }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td></td>
                                    <td>Year before last</td>
                                    <td>{{ (int) $credithistory[0]->federation_poorest_members_not_received_federation_loan_year2 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_poor_members_not_received_federation_loan_year2 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_medium_members_not_received_federation_loan_year2 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_rich_members_not_received_federation_loan_year2 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_total_members_not_received_federation_loan_year2 }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td></td>
                                    <td>2 Years before last</td>
                                    <td>{{ (int) $credithistory[0]->federation_poorest_members_not_received_federation_loan_year3 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_poor_members_not_received_federation_loan_year3 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_medium_members_not_received_federation_loan_year3 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_rich_members_not_received_federation_loan_year3 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_total_members_not_received_federation_loan_year3 }}
                                    </td>
                                </tr>
                                <tr style="background: #ccc7c7">
                                    <td>2</td>
                                    <td>External Loans</td>
                                    <td>Poorest & Vulnerable</td>
                                    <td>Poor</td>
                                    <td>Medium Poor</td>
                                    <td>Rich</td>
                                    <td></td>
                                </tr>
                                <tr class="text-center">
                                    <td></td>
                                    <td>Last 12 months</td>
                                    <td>20</td>
                                    <td>20</td>
                                    <td>20</td>
                                    <td>20</td>
                                    <td>80</td>
                                </tr>
                                <tr class="text-center">
                                    <td></td>
                                    <td>Year before last</td>
                                    <td>20</td>
                                    <td>20</td>
                                    <td>20</td>
                                    <td>20</td>
                                    <td>80</td>
                                </tr>
                                <tr class="text-center">
                                    <td></td>
                                    <td>2 Years before last</td>
                                    <td>20</td>
                                    <td>20</td>
                                    <td>20</td>
                                    <td>20</td>
                                    <td>80</td>
                                </tr>

                                <tr style="background: #ccc7c7">
                                    <td>3</td>
                                    <td>Other Loans</td>
                                    <td>Poorest & Vulnerable</td>
                                    <td>Poor</td>
                                    <td>Medium Poor</td>
                                    <td>Rich</td>
                                    <td></td>
                                </tr>
                                <tr class="text-center">
                                    <td></td>
                                    <td>Last 12 months</td>
                                    <td>{{ (int) $credithistory[0]->federation_poorest_members_not_received_other_loan_year1 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_poor_members_not_received_other_loan_year1 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_medium_members_not_received_other_loan_year1 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_rich_members_not_received_other_loan_year1 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_total_members_not_received_other_loan_year1 }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td></td>
                                    <td>Year before last</td>
                                    <td>{{ (int) $credithistory[0]->federation_poorest_members_not_received_other_loan_year2 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_poor_members_not_received_other_loan_year2 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_medium_members_not_received_other_loan_year2 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_rich_members_not_received_other_loan_year2 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_total_members_not_received_other_loan_year2 }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td></td>
                                    <td>2 Years before last</td>
                                    <td>{{ (int) $credithistory[0]->federation_poorest_members_not_received_other_loan_year3 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_poor_members_not_received_other_loan_year3 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_medium_members_not_received_other_loan_year3 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_rich_members_not_received_other_loan_year3 }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->federation_total_members_not_received_other_loan_year3 }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>No. of Members Taken More Than One Loan During Last 3 Years</th>
                                    <th style="background: #ccc7c7; width:10%;">
                                        {{ (int) $credithistory[0]->members_have_taken_more_than_one_loan }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">Loan Repayment Performance (DCB Report)</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>S. No.</th>
                                    <th>DCB</th>
                                    <th>Federation Loans</th>
                                    <th>Bank Loans</th>
                                    <th>Other Loans</th>
                                    <th>Summary Loan Portfolio</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left">No. of Active Loans</td>
                                    <td>{{ (int) $credithistory[0]->federation_loan_active }}</td>
                                    <td>{{ (int) $credithistory[0]->bank_loan_active }}</td>
                                    <td>{{ (int) $credithistory[0]->other_loan_active }}</td>
                                    <td>{{ (int) $credithistory[0]->federation_loan_active + (int) $credithistory[0]->bank_loan_active + (int) $credithistory[0]->vi_loan_active + (int) $credithistory[0]->other_loan_active }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left">Total Loan Amount Given (INR)</td>
                                    <td>{{ (int) $credithistory[0]->federation_loan_amount }}</td>
                                    <td>{{ (int) $credithistory[0]->bank_loan_amount }}</td>
                                    <td>{{ (int) $credithistory[0]->other_loan_amount }}</td>
                                    <td>{{ (int) $credithistory[0]->federation_loan_amount + (int) $credithistory[0]->bank_loan_amount + (int) $credithistory[0]->vi_loan_amount + (int) $credithistory[0]->other_loan_amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left">Total Demand upto last month for
                                        active loans (INR)</td>
                                    <td>{{ (int) $credithistory[0]->dcb_federation }}</td>
                                    <td>{{ (int) $credithistory[0]->dcb_bank }}</td>
                                    <td>{{ (int) $credithistory[0]->dcb_other }}</td>
                                    <td>{{ (int) $credithistory[0]->dcb_federation + (int) $credithistory[0]->dcb_bank + (int) $credithistory[0]->dcb_vi + (int) $credithistory[0]->dcb_other }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left">Actual Amount Paid upto last month
                                        (INR)</td>
                                    <td>{{ (int) $credithistory[0]->repaid_federation }}</td>
                                    <td>{{ (int) $credithistory[0]->repaid_bank }}</td>
                                    <td>{{ (int) $credithistory[0]->repaid_other }}</td>
                                    <td>{{ (int) $credithistory[0]->repaid_federation + (int) $credithistory[0]->repaid_bank + (int) $credithistory[0]->repaid_vi + (int) $credithistory[0]->repaid_other }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td style="text-align: left">Overdue Amount (INR)</td>
                                    <td>{{ (int) $credithistory[0]->overdue_amount_federation }}</td>
                                    <td>{{ (int) $credithistory[0]->overdue_amount_bank }}</td>
                                    <td>{{ (int) $credithistory[0]->overdue_amount_other }}</td>
                                    <td>{{ (int) $credithistory[0]->overdue_amount_federation + (int) $credithistory[0]->overdue_amount_bank + (int) $credithistory[0]->overdue_amount_vi + (int) $credithistory[0]->overdue_amount_other }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td style="text-align: left">Outstanding amount for active loans
                                        (INR)</td>
                                    <td>{{ (int) $credithistory[0]->loan_outstanding_federation }}</td>
                                    <td>{{ (int) $credithistory[0]->loan_outstanding_bank }}</td>
                                    <td>{{ (int) $credithistory[0]->loan_outstanding_other }}</td>
                                    <td>{{ (int) $credithistory[0]->loan_outstanding_federation + (int) $credithistory[0]->loan_outstanding_bank + (int) $credithistory[0]->loan_outstanding_vi + (int) $credithistory[0]->loan_outstanding_other }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td style="text-align: left">Repayment Ratio %</td>
                                    <td>{{ Checkper((float) $credithistory[0]->repayment_rate_federation_loans) . '%' }}
                                    </td>
                                    <td>{{ Checkper((float) $credithistory[0]->repayment_rate_bank_loans) . '%' }}</td>
                                    <td>{{ Checkper((float) $credithistory[0]->repayment_rate_other_loans) . '%' }}</td>
                                    @php
                                        $num = 0;
                                        if (!empty($credithistory[0]->repayment_rate_federation_loans)) {
                                            $num = $num + 1;
                                            $a = (float) str_replace('%', '', $credithistory[0]->repayment_rate_federation_loans);
                                        } else {
                                            $a = 0;
                                        }
                                        if (!empty($credithistory[0]->repayment_rate_bank_loans)) {
                                            $num = $num + 1;
                                            $b = (float) str_replace('%', '', $credithistory[0]->repayment_rate_bank_loans);
                                        } else {
                                            $b = 0;
                                        }
                                        if (!empty($credithistory[0]->repayment_rate_vi_loans)) {
                                            $num = $num + 1;
                                            $c = (float) str_replace('%', '', $credithistory[0]->repayment_rate_vi_loans);
                                        } else {
                                            $c = 0;
                                        }
                                        if (!empty($credithistory[0]->repayment_rate_other_loans)) {
                                            $num = $num + 1;
                                            $d = (float) str_replace('%', '', $credithistory[0]->repayment_rate_other_loans);
                                        } else {
                                            $d = 0;
                                        }
                                        if ($num > 0) {
                                            $data = ($a + $b + $c + $d) / $num;
                                            $e = number_format((float) $data, 2, '.', '');
                                        } else {
                                            $e = 0;
                                        }
                                    @endphp
                                    <td>{{ $e . '%' }}</td>
                                </tr>


                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">Loan Default Check</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>S. No.</th>
                                    <th>Name of Loan Institution</th>
                                    <th>No. of Members</th>
                                    <th>No. of Loans</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left">Federation Loans</td>
                                    <td>{{ (int) $credithistory[0]->loan_default_federation_members }}</td>
                                    <td>{{ (int) $credithistory[0]->default_federation_no_of_loans }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left">External Loans</td>
                                    <td>{{ (int) $credithistory[0]->loan_default_bank_members }}</td>
                                    <td>{{ (int) $credithistory[0]->default_bank_no_of_loans }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left">Other Loans</td>
                                    <td>{{ (int) $credithistory[0]->loan_default_other_members }}</td>
                                    <td>{{ (int) $credithistory[0]->default_other_no_of_loans }}</td>
                                </tr>
                                <tr>
                                    <td style="background: #ccc7c7;" colspan="2">Total</td>
                                    <td style="background: #ccc7c7;">{{ (!empty($credithistory[0]->loan_default_federation_members) ? $credithistory[0]->loan_default_federation_members : 0) + (!empty($credithistory[0]->loan_default_bank_members) ? $credithistory[0]->loan_default_bank_members : 0) + (!empty($credithistory[0]->loan_default_vi_members) ? $credithistory[0]->loan_default_vi_members : 0) + (!empty($credithistory[0]->loan_default_other_members) ? $credithistory[0]->loan_default_other_members : 0) }}
                                    </td>
                                    <td style="background: #ccc7c7;">{{ (!empty($credithistory[0]->default_federation_no_of_loans) ? $credithistory[0]->default_federation_no_of_loans : 0) + (!empty($credithistory[0]->default_bank_no_of_loans) ? $credithistory[0]->default_bank_no_of_loans : 0) + (!empty($credithistory[0]->default_vi_no_of_loans) ? $credithistory[0]->default_vi_no_of_loans : 0) + (!empty($credithistory[0]->default_other_no_of_loans) ? $credithistory[0]->default_other_no_of_loans : 0) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">Portfolio At Risk (PAR) Amount Details</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>S. No.</th>
                                    <th>Institution</th>
                                    <th>Defaulted loans for 30 days (INR)</th>
                                    <th>Defaulted loans for 30 days (INR)</th>
                                    <th>Defaulted loans for 90 days (INR)</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left">Federation Loans</td>
                                    <td>{{ (int) $credithistory[0]->overdue_More_than_1_months_Federation }}</td>
                                    <td>{{ (int) $credithistory[0]->overdue_More_than_2_months_Federation }}</td>
                                    <td>{{ (int) $credithistory[0]->overdue_More_than_3_months_Federation }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left">External Loans</td>
                                    <td>{{ (int) $credithistory[0]->overdue_More_than_1_months_Bank }}</td>
                                    <td>{{ (int) $credithistory[0]->overdue_More_than_2_months_Bank }}</td>
                                    <td>{{ (int) $credithistory[0]->overdue_More_than_3_months_Bank }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left">Other Loans</td>
                                    <td>{{ (int) $credithistory[0]->overdue_More_than_1_months_other }}</td>
                                    <td>{{ (int) $credithistory[0]->overdue_More_than_2_months_other }}</td>
                                    <td>{{ (int) $credithistory[0]->overdue_More_than_3_months_other }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td>{{ (!empty($credithistory[0]->overdue_More_than_1_months_Federation) ? $credithistory[0]->overdue_More_than_1_months_Federation : 0) + (!empty($credithistory[0]->overdue_More_than_1_months_Bank) ? $credithistory[0]->overdue_More_than_1_months_Bank : 0) + (!empty($credithistory[0]->overdue_More_than_1_months_other) ? $credithistory[0]->overdue_More_than_1_months_other : 0) }}
                                    </td>
                                    <td>{{ (!empty($credithistory[0]->overdue_More_than_2_months_Federation) ? $credithistory[0]->overdue_More_than_2_months_Federation : 0) + (!empty($credithistory[0]->overdue_More_than_2_months_Bank) ? $credithistory[0]->overdue_More_than_2_months_Bank : 0) + (!empty($credithistory[0]->overdue_More_than_2_months_other) ? $credithistory[0]->overdue_More_than_2_months_other : 0) }}
                                    </td>
                                    <td>{{ (!empty($credithistory[0]->overdue_More_than_3_months_Federation) ? $credithistory[0]->overdue_More_than_3_months_Federation : 0) + (!empty($credithistory[0]->overdue_More_than_3_months_Bank) ? $credithistory[0]->overdue_More_than_3_months_Bank : 0) + (!empty($credithistory[0]->overdue_More_than_3_months_other) ? $credithistory[0]->overdue_More_than_3_months_other : 0) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">

                        <h4 class="bg-white p-3 mb-0">PAR Status (in %)</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>S. No.</th>
                                    <th>Institution</th>
                                    <th>Defaulted loans for 30days (%)</th>
                                    <th>Defaulted loans for 60days (%)</th>
                                    <th>Defaulted loans for 90days (%)</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left">Federation Loans</td>
                                    <td>{{ Checkper($credithistory[0]->percentage_More_than_30_days_Federation) }}
                                    </td>
                                    <td>{{ Checkper($credithistory[0]->percentage_More_than_60_days_Federation) }}
                                    </td>
                                    <td>{{ Checkper($credithistory[0]->percentage_More_than_90_days_Federation) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left">External Loans</td>
                                    <td>{{ Checkper($credithistory[0]->percentage_More_than_30_days_Bank) }}</td>
                                    <td>{{ Checkper($credithistory[0]->percentage_More_than_60_days_Bank) }}</td>
                                    <td>{{ Checkper($credithistory[0]->percentage_More_than_90_days_Bank) }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left">Other Loans</td>
                                    <td>{{ Checkper($credithistory[0]->percentage_More_than_30_days_other) }}</td>
                                    <td>{{ Checkper($credithistory[0]->percentage_More_than_60_days_other) }}</td>
                                    <td>{{ Checkper($credithistory[0]->percentage_More_than_90_days_other) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td>{{ (!empty($credithistory[0]->percentage_More_than_30_days_Federation) ? $credithistory[0]->percentage_More_than_30_days_Federation : 0) + (!empty($credithistory[0]->percentage_More_than_30_days_Bank) ? $credithistory[0]->percentage_More_than_30_days_Bank : 0) + (!empty($credithistory[0]->loan_default_vi_members) ? $credithistory[0]->loan_default_vi_members : 0) + (!empty($credithistory[0]->percentage_More_than_30_days_other) ? $credithistory[0]->percentage_More_than_30_days_other : 0) }}
                                    </td>
                                    <td>{{ (!empty($credithistory[0]->percentage_More_than_60_days_Federation) ? $credithistory[0]->percentage_More_than_60_days_Federation : 0) + (!empty($credithistory[0]->percentage_More_than_60_days_Bank) ? $credithistory[0]->percentage_More_than_60_days_Bank : 0) + (!empty($credithistory[0]->loan_default_vi_members) ? $credithistory[0]->loan_default_vi_members : 0) + (!empty($credithistory[0]->percentage_More_than_60_days_other) ? $credithistory[0]->percentage_More_than_60_days_other : 0) }}
                                    </td>
                                    <td>{{ (!empty($credithistory[0]->percentage_More_than_90_days_Federation) ? $credithistory[0]->percentage_More_than_90_days_Federation : 0) + (!empty($credithistory[0]->percentage_More_than_90_days_Bank) ? $credithistory[0]->percentage_More_than_90_days_Bank : 0) + (!empty($credithistory[0]->loan_default_vi_members) ? $credithistory[0]->loan_default_vi_members : 0) + (!empty($credithistory[0]->percentage_More_than_90_days_other) ? $credithistory[0]->percentage_More_than_90_days_other : 0) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-12">

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th colspan="6">Does federation Have a Loan Tracking System</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td style="background: #ccc7c7; width:20%;">Loan Tracking System</td>
                                    <td>{{ $credithistory[0]->does_Federation_loan_tracking_system != '' ? $credithistory[0]->does_Federation_loan_tracking_system : 'N/A' }}
                                    </td>
                                    <td style="background: #ccc7c7; width:20%;">Date it was Established</td>
                                    <td width="20%">{{ $credithistory[0]->when_was_it_established != '' ? Change_date_month_name_char(str_replace('/', '-', $credithistory[0]->when_was_it_established)) : 'N/A' }}
                                    </td>
                                    <td style="background: #ccc7c7; width:20%;">What is the frequency of loan tracking</td>
                                    <td>{{ $credithistory[0]->frequency_of_loan_tracking != '' ? $credithistory[0]->frequency_of_loan_tracking : 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>



                    </div>

                    <div class="col-md-6">
                        <h4 class="bg-white p-3 mb-0">Purpose of All Loans During Last 12 Months</h4>

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>S. No. </th>
                                    <th>Purpose</th>
                                    <th>No of Loans</th>
                                    <th>Amount (INR)</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td>Productive</td>
                                    <td>{{ (int) $credithistory[0]->productive }}</td>
                                    <td>{{ (int) $credithistory[0]->productive_amount }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Consumption</td>
                                    <td>{{ (int) $credithistory[0]->consumption }}</td>
                                    <td>{{ (int) $credithistory[0]->consumption_amount }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Debt Swapping</td>
                                    <td>{{ (int) $credithistory[0]->debt_swapping }}</td>
                                    <td>{{ (int) $credithistory[0]->debt_swapping_amount }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Education</td>
                                    <td>{{ (int) $credithistory[0]->education }}</td>
                                    <td>{{ (int) $credithistory[0]->education_amount }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Health</td>
                                    <td>{{ (int) $credithistory[0]->health }}</td>
                                    <td>{{ (int) $credithistory[0]->health_amount }}</td>
                                </tr>
                                <tr style="background: #ccc7c7">
                                    <td></td>
                                    <td>Total</td>
                                    <td>{{ (int) $credithistory[0]->productive + (int) $credithistory[0]->consumption + (int) $credithistory[0]->debt_swapping + (int) $credithistory[0]->education + (int) $credithistory[0]->health }}
                                    </td>
                                    <td>{{ (int) $credithistory[0]->productive_amount + (int) $credithistory[0]->consumption_amount + (int) $credithistory[0]->debt_swapping_amount + (int) $credithistory[0]->education_amount + (int) $credithistory[0]->health_amount }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>



                    </div>

                    {{-- <div class="col-md-5">
                        <h4 class="bg-white p-3 mb-0">pie chart</h4>
                    </div> --}}

                    <div class="col-md-6">
                        {{-- <div class="card"> --}}
                        <div class="card-block">
                            <div class="w-heading d-flex">
                                <span>
                                    {{-- <h5>Axis chart</h5> --}}
                                </span>
                            </div>
                            <div class="w-box">
                                <div id="piechart" style="width: 800px; height: 300px;" ></div>
                                {{-- <canvas id="pie"></canvas> --}}
                            </div>
                        </div>
                        {{-- </div> --}}
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Average Loan Number And Amount During Last 12 Months</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td style="background: #ccc7c7; width:25%;">Average no of loans</td>
                                    <td>{{ $credithistory[0]->average_loan != '' ? $credithistory[0]->average_loan : 0 }}
                                    </td>
                                    <td style="background: #ccc7c7; width:25%;">Average Loan Amount (INR)</td>
                                    <td>{{ $credithistory[0]->average_loan_amount != '' ? $credithistory[0]->average_loan_amount : 0 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Minimum and Maximum Loan Amounts During Last 12 Months</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td style="background: #ccc7c7; width:25%;">Maximum Amount (INR)</td>
                                    <td>{{ $credithistory[0]->maximum_amount != '' ? $credithistory[0]->maximum_amount : 0 }}
                                    </td>
                                    <td style="background: #ccc7c7; width:25%;">Minimum Amount (INR)</td>
                                    <td>{{ $credithistory[0]->minimum_amount != '' ? $credithistory[0]->minimum_amount : 0 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-7" style="margin-bottom:6rem;">
                        <h4 class="bg-white p-3 mb-0">Interest Rate Details</h4>
                        <table class="table table-bordered  new-table-dg" >
                            <thead>
                                <tr class="text-center">
                                    <th>S. No.</th>
                                    <th>Institution</th>
                                    <th>Type</th>
                                    <th>% Charged</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td>Federation Loans</td>
                                    <td>{{ $credithistory[0]->declining_or_flat != '' ? $credithistory[0]->declining_or_flat : 'N/A' }}
                                    </td>
                                    <td>{{ $credithistory[0]->percent_charged != '' ? $credithistory[0]->percent_charged : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Bank Loans</td>
                                    <td>{{ $credithistory[0]->declining_or_flat_bank != '' ? $credithistory[0]->declining_or_flat_bank : 'N/A' }}
                                    </td>
                                    <td>{{ $credithistory[0]->percent_charged_bank != '' ? $credithistory[0]->percent_charged_bank : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Other Loans</td>
                                    <td>{{ $credithistory[0]->declining_or_flat_other != '' ? $credithistory[0]->declining_or_flat_other : 'N/A' }}
                                    </td>
                                    <td>{{ $credithistory[0]->percent_charged_other != '' ? $credithistory[0]->percent_charged_other : 0 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-5">
                        <h4 class="bg-white p-3 mb-0">Cumulative Interest Income</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th width="20%">S. No.</th>
                                    <th>Institution</th>
                                    <th>Income Generated Amount (INR)</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td>Federation Loans</td>
                                    <td>{{ (int) $credithistory[0]->cumulative_interest_federation_loans }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Bank Loans</td>
                                    <td>{{ (int) $credithistory[0]->cumulative_interest_bank_loans }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Other Loans</td>
                                    <td>{{ (int) $credithistory[0]->cumulative_interest_other_loans }}</td>
                                </tr>
                                <tr style="background: #ccc7c7">
                                    <td></td>
                                    <td>Total</td>
                                    <td>{{ (int) $credithistory[0]->cumulative_interest_federation_loans + (int) $credithistory[0]->cumulative_interest_bank_loans + (int) $credithistory[0]->cumulative_interest_vi_loans + (int) $credithistory[0]->cumulative_interest_other_loans }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Actions Taken During Last 12 Months To Address Loan Default</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>S. No.</th>
                                    <th>Describe Action</th>
                                </tr>
                            </thead>

                            <tbody class="text-left">

                                @if ($credithistory[0]->actions_previous_year_defaults_a != '')
                                    <tr>
                                        <td>1</td>
                                        {{-- <td>Action one will be written over here</td> --}}
                                        <td>{{ $credithistory[0]->actions_previous_year_defaults_a }}</td>
                                    </tr>
                                @endif
                                @if ($credithistory[0]->actions_previous_year_defaults_b != '')
                                    <tr>
                                        <td>2</td>
                                        {{-- <td>Action one will be written over here</td> --}}
                                        <td>{{ $credithistory[0]->actions_previous_year_defaults_b }}</td>
                                    </tr>
                                @endif
                                @if ($credithistory[0]->actions_previous_year_defaults_c != '')
                                    <tr>
                                        <td>3</td>
                                        {{-- <td>Action one will be written over here</td> --}}
                                        <td>{{ $credithistory[0]->actions_previous_year_defaults_c }}</td>
                                    </tr>
                                @endif
                                @if ($credithistory[0]->actions_previous_year_defaults_d != '')
                                    <tr>
                                        <td>4</td>
                                        {{-- <td>Action one will be written over here</td> --}}
                                        <td>{{ $credithistory[0]->actions_previous_year_defaults_d }}</td>
                                    </tr>
                                @endif
                                @if ($credithistory[0]->actions_previous_year_defaults_e != '')
                                    <tr>
                                        <td>5</td>
                                        {{-- <td>Action one will be written over here</td> --}}
                                        <td>{{ $credithistory[0]->actions_previous_year_defaults_e }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Rotation of Funds (Velocity)</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>S. No.</th>
                                    <th>Heading</th>
                                    <th>Federation</th>
                                    <th>Others</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Total corpus funds received (INR)</td>
                                    <td>{{ $credithistory[0]->Total_corpus_fund_received != '' ? $credithistory[0]->Total_corpus_fund_received : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left;">Total federation loan disbursed (INR)</td>
                                    <td>{{ $credithistory[0]->Total_loan_given != '' ? $credithistory[0]->Total_loan_given : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left;">No of years completed since receipt of
                                        funds(#)</td>
                                    <td>{{ $credithistory[0]->completed_received_corpus_fund != '' ? $credithistory[0]->completed_received_corpus_fund : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left;">Yearly Rotation Ratio</td>
                                    <td>{{ $credithistory[0]->Yearly_rotation_ratio != '' ? $credithistory[0]->Yearly_rotation_ratio : 0 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>SUSTAINABILITY</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="6">Income and Expenditure During Last 12 Months</th>
                                </tr>

                            </thead>

                            <tbody>
                                <tr class="text-center">
                                    <td style="background: #ccc7c7; width:20%;">Total Income (INR)</td>
                                    <td width="20%">{{ $sustainability[0]->total_income_of_the_federation != '' ? $sustainability[0]->total_income_of_the_federation : 0 }}
                                    </td>
                                    <td style="background: #ccc7c7; width:20%;">Total Expenses (INR)</td>
                                    <td>{{ $sustainability[0]->expense_of_the_federation != '' ? $sustainability[0]->expense_of_the_federation : 0 }}
                                    </td>
                                    <td style="background: #ccc7c7; width:20%;">Coverage of Operational Costs</td>
                                    <td>{{ $sustainability[0]->federation_covering_operational_cost != '' ? $sustainability[0]->federation_covering_operational_cost : 0 }}
                                    </td>
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
                                    <td style="text-align: center;">1</td>
                                    <td>Whether LSF is in operation</td>
                                    <td>{{ $sustainability[0]->have_loan_security_fund != '' ? $sustainability[0]->have_loan_security_fund : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">2</td>
                                    <td>Date established/Verified</td>
                                    <td>{{ $sustainability[0]->date_it_was_established != '' ? change_date_month_name_char(str_replace('/', '-', $sustainability[0]->date_it_was_established)) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">3</td>
                                    <td>No of members contribute to LSF</td>
                                    <td>{{ $sustainability[0]->members_contribute_LSF != '' ? $sustainability[0]->members_contribute_LSF : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">4</td>
                                    <td>Amount available in LSF</td>
                                    <td>{{ $sustainability[0]->amount_available_security_fund != '' ? $sustainability[0]->amount_available_security_fund : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">5</td>
                                    <td>No of members benefitted from LSF</td>
                                    <td>{{ $sustainability[0]->members_benefited_by_LSF != '' ? $sustainability[0]->members_benefited_by_LSF : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">6</td>
                                    <td>Reason member do not contribute</td>
                                    <td>{{ $sustainability[0]->reason_members_do_not_contribute != '' ? $sustainability[0]->reason_members_do_not_contribute : 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>

                        </table>



                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Savings of Member SHGs</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th width="10%">S. No.</th>
                                    <th>Details</th>
                                    <th>Compulsory
                                        Savings (INR)</th>
                                    <th>Voluntary
                                        Savings (INR)</th>
                                    <th>Other savings
                                        (INR)</th>
                                    <th>Total savings
                                        (INR)
                                    </th>
                                </tr>

                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left;">Cumulative savings of all SHGs upto date</td>
                                    <td>{{ $sustainability[0]->cumulative_savings_compulsory != '' ? $sustainability[0]->cumulative_savings_compulsory : 0 }}
                                    </td>
                                    <td>{{ $sustainability[0]->cumulative_savings_voluntary != '' ? $sustainability[0]->cumulative_savings_voluntary : 0  }}</td>
                                    <td>{{ $sustainability[0]->cumulative_savings_other != '' ? $sustainability[0]->cumulative_savings_other : 0 }}</td>
                                    <td>{{ (int) $sustainability[0]->cumulative_savings_compulsory + (int) $sustainability[0]->cumulative_savings_voluntary + (int) $sustainability[0]->cumulative_savings_other }}
                                    </td>
                                </tr>
                                <tr>
                                    <td >2</td>
                                    <td style="text-align: left;">Amount saved during last 12 months</td>
                                    <td>{{ $sustainability[0]->amount_saved_compulsory != '' ? $sustainability[0]->amount_saved_compulsory : 0 }}
                                    </td>
                                    <td>{{ $sustainability[0]->amount_saved_voluntary != '' ? $sustainability[0]->amount_saved_voluntary : 0}}</td>
                                    <td>{{ $sustainability[0]->amount_saved_other != '' ? $sustainability[0]->amount_saved_other : 0}}</td>
                                    <td>{{ (int) $sustainability[0]->amount_saved_compulsory + (int) $sustainability[0]->amount_saved_voluntary + (int) $sustainability[0]->amount_saved_other }}
                                    </td>
                                </tr>
                            </tbody>

                        </table>



                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Other Services Provided By Federation</h4>
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr class="text-center">
                                    <th>S. No.</th>
                                    <th>Name of the Service</th>
                                    <th>Date Established</th>
                                    <th>Members Benefiting</th>
                                </tr>

                            </thead>

                            <tbody class="text-center">
                                @php $i=1; @endphp
                                @if (!empty($sustainability_service))
                                    @foreach ($sustainability_service as $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->service_name }}</td>
                                            <td>{{ $row->date !='' ?
                                                change_date_month_name_char(str_replace('/','-',$row->date)) : 'N/A'
                                                }}</td>
                                            <td>{{ $row->members != '' ? $row->members : 0 }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                        </table>



                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>RISK MITIGATION</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Total Members</th>
                                    <th style="background: #ccc7c7; width:80%;">
                                        {{ $risk_mitigation[0]->total_general_assembly_members != '' ? $risk_mitigation[0]->total_general_assembly_members : 0 }}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="4">Life Insurance Coverage For Total Members</th>
                                </tr>

                            </thead>

                            <tbody>
                                @php
                                    $a = (float) $risk_mitigation[0]->members_covered_under_life_insurance;
                                    $b = (float) $risk_mitigation[0]->total_general_assembly_members;
                                    $c = 0;
                                    if ($risk_mitigation[0]->total_general_assembly_members > 0) {
                                        $value = ($risk_mitigation[0]->members_covered_under_life_insurance * 100) / $risk_mitigation[0]->total_general_assembly_members;
                                        $c = round($value, 2);
                                    }
                                @endphp
                                <tr>
                                    <td style="background: #ccc7c7; width:25%;">No of active borrowers</td>
                                    <td>{{ $risk_mitigation[0]->members_covered_under_life_insurance != '' ? $risk_mitigation[0]->members_covered_under_life_insurance : 0 }}
                                    </td>
                                    <td style="background: #ccc7c7; width:25%;">Coverage(%)</td>
                                    @if ($risk_mitigation[0]->par_covered_under_life_insurance == 0)
                                        <td width="25%">
                                            {{ $risk_mitigation[0]->par_covered_under_life_insurance }}%</td>
                                    @elseif ($risk_mitigation[0]->par_covered_under_life_insurance == '')
                                        <td>0%</td>
                                    @else
                                        <td width="25%">{{ $risk_mitigation[0]->par_covered_under_life_insurance }}</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="6">Life Insurance Coverage For Active Borrowers During Last 3 Years
                                    </th>
                                </tr>

                            </thead>

                            <tbody>
                                <tr>
                                    <td style="background: #ccc7c7">No of active borrowers</td>
                                    <td>{{ $risk_mitigation[0]->availed_members_covered_under_loan_insurance != '' ? $risk_mitigation[0]->availed_members_covered_under_loan_insurance : 0 }}
                                    </td>
                                    <td style="background: #ccc7c7">No of active borrowers covered</td>
                                    <td>{{ $risk_mitigation[0]->par_availed_members_covered_under_loan_insurance != '' ? $risk_mitigation[0]->par_availed_members_covered_under_loan_insurance : 0 }}
                                    </td>
                                    <td style="background: #ccc7c7">Coverage(%)</td>

                                    @if ($risk_mitigation[0]->availed_members_covered_under_loan_insurance > 0)
                                        <td>{{ ((int)$risk_mitigation[0]->par_availed_members_covered_under_loan_insurance * 100) / $risk_mitigation[0]->availed_members_covered_under_loan_insurance }}%
                                        </td>
                                    @else
                                        <td>0%</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="6">Asset Insurance For Livestock During Last 3 Years</th>
                                </tr>

                            </thead>

                            <tbody>
                                <tr>
                                    <td style="background: #ccc7c7">No of asset/animals
                                        purchased</td>
                                    <td>{{ checkZero($risk_mitigation[0]->animal_purchased_during_last_one_year) }}
                                    </td>
                                    <td style="background: #ccc7c7">No of asset/animals insured</td>
                                    <td>{{ checkZero($risk_mitigation[0]->animal_insured_last_one_year) }}</td>
                                    <td style="background: #ccc7c7">Coverage(%)</td>

                                    @if ($risk_mitigation[0]->animal_purchased_during_last_one_year > 0)
                                        <td> {{ round(($risk_mitigation[0]->animal_insured_last_one_year * 100) / $risk_mitigation[0]->animal_purchased_during_last_one_year) }}%
                                        </td>
                                    @else
                                        <td>0%</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Benefits Claimed Under Life Insurance</th>
                                </tr>

                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td style="text-align: left;">No of claims submitted</td>
                                    <td>{{ $risk_mitigation[0]->No_of_claim_received != '' ? $risk_mitigation[0]->No_of_claim_received : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Total Claim Amount (INR)</td>
                                    <td>{{ $risk_mitigation[0]->Total_claim_amount_requested != '' ? $risk_mitigation[0]->Total_claim_amount_requested : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Total No of claims settled</td>
                                    <td>{{ $risk_mitigation[0]->No_of_person_claim_setteled != '' ? $risk_mitigation[0]->No_of_person_claim_setteled : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Total Claim amount settled (INR)</td>
                                    <td>{{ $risk_mitigation[0]->Total_claim_amount_setteled != '' ? $risk_mitigation[0]->Total_claim_amount_setteled : 0 }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Settlement (in No)</td>
                                    <td> {{ checkZero($risk_mitigation[0]->settlement_claimed_insurance_no) }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Settlement done (in %)</td>
                                    <td>{{ $risk_mitigation[0]->settlement_claimed_insurance_per != '' ? $risk_mitigation[0]->settlement_claimed_insurance_per : '0%' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th colspan="2">Benefits Claimed Under Livestock During Last 12
                                        Months</th>
                                </tr>

                            </thead>

                            <tbody class="text-center">
                                <tr>
                                    <td style="text-align: left;">No of animal death claims submitted</td>
                                    <td>{{ checkZero($risk_mitigation[0]->death_claim_requested) }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Total amount of claims submitted (INR</td>
                                    <td>{{ checkZero($risk_mitigation[0]->Total_claim_amount_requested_animal_death) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Total No of claims settled</td>
                                    <td>{{ checkZero($risk_mitigation[0]->animal_claim_setteled) }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Total Claim amount settled (INR)</td>
                                    <td>{{ checkZero($risk_mitigation[0]->Total_claim_amount_setteled_for_animal_death) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Settlement (in No)</td>
                                    <td> {{ checkZero($risk_mitigation[0]->settlement_asset_insurance_no) }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Settlement done (in %)</td>
                                    <td>{{ $risk_mitigation[0]->settlement_asset_insurance_per != '' ? $risk_mitigation[0]->settlement_asset_insurance_per : '0%' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>CHALLENGES & ACTION PLAN</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                @php
                                $count = count($challenges);
                                $i = 1;
                                @endphp
                                <tr>
                                    <th colspan="{{ $count + 2 }}">TOP CHALLENGES</th>
                                </tr>

                            </thead>

                            <tbody>
                                @php $i=1; @endphp
                                @if (count($challenges) > 1)
                                    @foreach ($challenges as $row)
                                        <tr>
                                            <td style="text-align: center; width:6.5%;">{{ $i++ }}</td>
                                            <td>{{ $row->challenge }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 class="bg-white p-3 mb-0">Action Plan To Address The Challenges</h4>

                        <table class="table table-bordered  new-table-dg"  >
                            <tbody>
                                <tr>
                                    <th style="background-color:#D79477 ; text-align: center;width:5%">S.No</th>
                                    <th style="background-color:#D79477 ; text-align: center;width:95%">Action Plan</th>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @if (!empty($challenges))
                                    @foreach ($challenges as $row)
                                    <th style="background-color:#D79477 ; text-align: center;">Challenge
                                        {{ $no }} :
                                        {{ $row->challenge }}
                                    </th>
                                    @php
                                    $no++;
                                    @endphp
                                    @endforeach
                                    @endif
                                </tr>
                                @if (!empty($challenges_actions_new))
                                @foreach ($challenges_actions_new as $key => $row)
                                <tr>
                                    <td class="tdc">{{ $key + 1 }}</td>
                                    <td>{{ $row['name'] }}</td>
                                    @if (!empty($row['ch_actions']))
                                    @foreach ($row['ch_actions'] as $val)
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

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h4><u>OBSERVATIONS</u></h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        {{-- <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                </tr>

                            </thead>

                            <tbody>
                                <tr>
                                    <td style="text-align: center;">1a</td>
                                    <td>How many members attended the federation meeting?</td>
                                    <td>{{ checkna($observation[0]->federationObservationMeeting) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">1b</td>
                                    <td>Were all office bearers and leaders present?</td>
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
                                    @if (!empty($strdesg))
                                        <td>{{ $strdesg }}</td>
                                    @else
                                        <td>N/A</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td style="text-align: center;">2</td>
                                    <td>Did Federation leaders understand the Purpose of
                                        the meeting?Explain</td>
                                    <td>{{ checkna($observation[0]->federationObservationCarriedOut) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">3</td>
                                    <td>What was quality of Discussion? Did everyone
                                        participate?</td>
                                    <td>{{ checkna($observation[0]->federationObservationLeadersOnly) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">4a</td>
                                    <td>Where Federation leaders aware of their rules and
                                        norms? Did they understand vision of their
                                        Federation?
                                    </td>
                                    <td>{{ checkna($observation[0]->federationObservationNormsHave) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">4b</td>
                                    <td>Do they understand benefits of being part of the
                                        Federation? Explain</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">5</td>
                                    <td>Does the federation have innovative repayment
                                        practices? If yes, What are those practices?</td>
                                    <td>{{ $observation[0]->federationObservationDefaults != '' ? $observation[0]->federationObservationDefaults : 'N/A' }}

                                        {{ $observation[0]->federationObservationPractices != '' ? $observation[0]->federationObservationPractices : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">6</td>
                                    <td>Does this Federation include members who are the
                                        most vulnerable? If yes, What is their policy to help
                                        them?</td>
                                    <td>{{ $observation[0]->federationObservationProvidedThem != '' ? $observation[0]->federationObservationProvidedThem : 'N/A' }}
                                        +
                                        {{ $observation[0]->federation_observation_policy_explain != '' ? $observation[0]->federation_observation_policy_explain : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">6a</td>
                                    <td>Does Federation have a satisfactory/weak or good
                                        system of reporting and updating of documents?</td>
                                    <td>{{ $observation[0]->federationObservationDocuments != '' ? $observation[0]->federationObservationDocuments : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">6b</td>
                                    <td>Any highlights</td>
                                    <td>{{ $observation[0]->federation_observation_any_highlighted != '' ? $observation[0]->federation_observation_any_highlighted : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">6c</td>
                                    <td>Who writes these books and minutes of meetings?</td>
                                    <td>{{ $observation[0]->federationObservationMinutesMeetings != '' ? $observation[0]->federationObservationMinutesMeetings : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">7</td>
                                    <td>Does this Federation include members who are the
                                        most vulnerable? If yes, What is their policy to help
                                        them?</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">7a</td>
                                    <td>Does Federation have a satisfactory/weak or good
                                        system of reporting and updating of documents?</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">8a</td>
                                    <td>Federation’s financial information: Are books of
                                        accounts managed by the bookkeeper or others?</td>
                                    <td>{{ $observation[0]->federationObservationUpdatedRecords != '' ? $observation[0]->federationObservationUpdatedRecords : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">8b</td>
                                    <td>Any highlights</td>
                                    <td>{{ $observation[0]->federation_observation_leaders_office != '' ? $observation[0]->federation_observation_leaders_office : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">9a</td>
                                    <td>Impression about Social Audit committee: Does it
                                        work?</td>
                                    <td>{{ $observation[0]->federationObservationWork != '' ? $observation[0]->federationObservationWork : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">9b</td>
                                    <td>Are office bearers of SA aware of their roles and
                                        reporting system?</td>
                                    <td>{{ $observation[0]->federationObservationReportingSystem != '' ? $observation[0]->federationObservationReportingSystem : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">10a</td>
                                    <td>Did you notice any unique features and practices
                                        that make the federation special?</td>
                                    <td>{{ $observation[0]->federationObservationFederationSpecial != '' ? $observation[0]->federationObservationFederationSpecial : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">10b</td>
                                    <td>How do they manage and support their groups and
                                        cluster federations? Explain</td>
                                    <td>{{ $observation[0]->federationObservationClusterFederations != '' ? $observation[0]->federationObservationClusterFederations : 'N/A' }}
                                    </td>
                                </tr>

                            </tbody>
                        </table> --}}

                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Questions</th>
                                    <th>Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1A.</td>
                                    <td><b>How many members attended the cluster meeting?</b></td>
                                    <td>{{ checkna($observation[0]->federationObservationMeeting) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>1B.</td>
                                    <td><b>Were all office bearers and leaders present? E.g President,
                                            treasurer, secretary, book-keeper, other,</b></td>
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
                                    <td>{{ checkna($strdesg) }}</td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td><b>Did Federation leaders understand the Purpose of the meeting?
                                            Explain</b></td>
                                            <td>{{ checkna($observation[0]->federationObservationCarriedOut) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td><b>What was quality of Discussion? Did everyone participate?</b>
                                    </td>
                                    <td>{{ checkna($observation[0]->federationObservationLeadersOnly) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td><b>Where Federation leaders aware of their rules and norms?</b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>A.</td>
                                    <td><b>Did they understand vision of their Federation?</b></td>
                                    <td>{{ checkna($observation[0]->federationObservationNormsHave) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>B.</td>
                                    <td><b>Do they understand benefits of being part of the Federation?</b>
                                    </td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td><b>Important practices followed by the Federation.</b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>A.</td>
                                    <td><b>Do they have a set of important practices for repayment and
                                            savings?</b></td>
                                    <td>{{ checkna($observation[0]->federationObservationDefaults) }}
                                    </td>
                                </tr>


                                <tr>
                                    <td>B.</td>
                                    <td><b>What are those practices?</b></td>
                                    <td>{{ checkna($observation[0]->federationObservationPractices) }}
                                    </td>
                                </tr>


                                <tr>
                                    <td>6</td>
                                    <td><b>What is Federation’s policy on the most vulnerable members</b>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>A.</td>
                                    <td><b>Does this Cluster include members who are the most poor and
                                            vulnerable, and if yes,</b></td>
                                    <td>{{ checkna($observation[0]->federationObservationProvidedThem) }}
                                    </td>
                                </tr>



                                <tr>
                                    <td>B.</td>
                                    <td><b>What is their policy to help them</b></td>
                                    <td>{{ checkna($observation[0]->federation_observation_policy_explain) }}
                                    </td>
                                </tr>


                                <tr>
                                    <td>7</td>
                                    <td><b>Federation’s Reporting and documentation</b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>A.</td>
                                    <td><b>Does Federation have a satisfactory/weak or good system of
                                            reporting and updating of documents?</b></td>
                                    <td>{{ checkna($observation[0]->federationObservationDocuments) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>B.</td>
                                    <td><b>Any highlights</b></td>
                                    <td>{{ checkna($observation[0]->federation_observation_any_highlighted) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>C.</td>
                                    <td><b>Who writes these books and minutes of meetings?</b></td>
                                    <td>{{ checkna($observation[0]->federationObservationMinutesMeetings) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>8</td>
                                    <td><b>Federation’s financial information</b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>A.</td>
                                    <td><b>Are books of accounts managed by the bookkeeper or others?
                                            Explain</b>
                                    </td>
                                    <td>{{ checkna($observation[0]->federationObservationUpdatedRecords) }}
                                    </td>
                                </tr>


                                <tr>
                                    <td>B.</td>
                                    <td><b>Any highlights</b></td>
                                    <td>{{ checkna($observation[0]->federation_observation_leaders_office) }}
                                    </td>
                                </tr>


                                <tr>
                                    <td>9</td>
                                    <td><b>Impression about Social Audit committee</b></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td>A.</td>
                                    <td><b>Does it work?</b></td>
                                    <td>{{ checkna($observation[0]->federationObservationWork) }}</td>
                                </tr>


                                <tr>
                                    <td>B.</td>
                                    <td><b>Are office bearers of SA aware of their roles and reporting
                                            system?</b>
                                    </td>
                                     <td>{{ checkna($observation[0]->federationObservationReportingSystem) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>10</td>
                                    <td><b>Unique features of this Federation</b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>A.</td>
                                    <td><b>Did you notice any unique features and practices that make it
                                            special?</b></td>
                                    <td>{{ checkna($observation[0]->federationObservationFederationSpecial) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>B.</td>
                                    <td><b>How do they manage and support their groups and clusters?</b>
                                    </td>
                                    <td>{{ checkna($observation[0]->federationObservationClusterFederations) }}
                                    </td>
                                </tr>

                                {{-- <tr>
                                                                    <td>C.</td>
                                                                    <td>What are those special practices?</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Answer</td>
                                                                    <td>----</td>
                                                                </tr> --}}
                                <tr>
                                    <td>11</td>
                                    <td colspan="2"><b>Summary of important 3- 5 highlights (positive and negative)
                                            about this Federation</b></td>
                                </tr>
                                @php
                                $na = '';
                                @endphp
                                @if ($observation[0]->federationObserHighlightsA != '')
                                @php
                                $na = 1;
                                @endphp
                                <tr>
                                    <td>A.</td>
                                    <td colspan="2">{{ checkna($observation[0]->federationObserHighlightsA) }}
                                    </td>
                                </tr>
                                @endif

                                @if ($observation[0]->federationObserHighlightsB != '')
                                @php
                                $na = 2;
                                @endphp
                                <tr>
                                    <td>B.</td>
                                    <td colspan="2">{{ $observation[0]->federationObserHighlightsB }}</td>
                                </tr>
                                @endif

                                @if ($observation[0]->federationObserHighlightsC != '')
                                @php
                                $na = 3;
                                @endphp
                                <tr>
                                    <td>C.</td>
                                    <td colspan="2">{{ $observation[0]->federationObserHighlightsC }}</td>
                                </tr>
                                @endif

                                @if ($observation[0]->federationObserHighlightsD != '')
                                @php
                                $na = 4;
                                @endphp
                                <tr>
                                    <td>D.</td>
                                    <td colspan="2">{{ $observation[0]->federationObserHighlightsD }}</td>
                                </tr>
                                @endif

                                @if ($observation[0]->federationObserHighlightsE != '')
                                @php
                                $na = 5;
                                @endphp
                                <tr>
                                    <td>E.</td>
                                    <td colspan="2">{{ $observation[0]->federationObserHighlightsE }}</td>
                                </tr>
                                @endif
                                @if ($na == '')

                                <tr>

                                    <td>Answer</td>
                                    <td>N/A</td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Summary of important 3- 5 highlights (positive and improvement points) about
                                        this Federation</th>

                                </tr>

                            </thead>

                            <tbody>
                                <tr>

                                 @if ($observation[0]->federationObserHighlightsA != '')
                                 <tr>
                                    <td>1</td>
                                      <td>{{ $observation[0]->federationObserHighlightsA }}</td>
                                 </tr>

                                @endif
                                @if ($observation[0]->federationObserHighlightsB != '')
                                <tr>
                                    <td>2</td>
                                 <td>{{ $observation[0]->federationObserHighlightsB }}</td>
                                </tr>
                                 @endif
                                 @if ($observation[0]->federationObserHighlightsC != '')
                                <tr>
                                    <td>3</td>
                                 <td>{{ $observation[0]->federationObserHighlightsC }}</td>
                                </tr>
                                 @endif
                                 @if ($observation[0]->federationObserHighlightsD != '')
                                <tr>
                                    <td>4</td>
                                 <td>{{ $observation[0]->federationObserHighlightsD }}</td>
                                </tr>
                                 @endif
                                 @if ($observation[0]->federationObserHighlightsE != '')
                                <tr>
                                    <td>5</td>
                                 <td>{{ $observation[0]->federationObserHighlightsE }}</td>
                                </tr>
                                 @endif
                            </tbody>
                        </table>
                    </div>
                </div>









            </div>
        </div>
    </div>
</body>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>  --}}
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js">
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{{-- <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script> --}}

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

            pdf.save("Federationn_Profile.pdf");
        });
    };
</script>

<script type="text/javascript">
    var chartData1 = {
        labels: ['Federation', 'External', 'Other'],
        datasets: [{
                label: 'Poorest & Vulnerable',
                backgroundColor: 'rgb(252, 143, 60)',
                data: [<?php echo $inclusion[0]->federation_poorest_category . ',' . $inclusion[0]->external_poorest_category . ',' . $inclusion[0]->vi_poorest_category; ?>],
                barThickness: 50,

            },
            {
                label: 'Poor',
                backgroundColor: 'rgb(146, 243, 0)',
                data: [<?php echo $inclusion[0]->federation_poor_category . ',' . $inclusion[0]->external_poor_category . ',' . $inclusion[0]->vi_poor_category; ?>],
                barThickness: 50,

            },
            {
                label: 'Medium Poor',
                backgroundColor: 'rgb(255, 255, 0)',
                data: [<?php echo $inclusion[0]->federation_medium . ',' . $inclusion[0]->external_medium . ',' . $inclusion[0]->vi_medium; ?>],
                barThickness: 50,

            },
            {
                label: 'Rich',
                backgroundColor: 'rgb(80, 157, 205)',
                data: [<?php echo $inclusion[0]->federation_rich . ',' . $inclusion[0]->external_rich . ',' . $inclusion[0]->vi_rich; ?>],
                barThickness: 50,

            },
        ],
    };

    $(document).ready(function() {
        var ctx = document.getElementById('loans').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: chartData1,
            options: {
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom",
                    },
                    datalabels: {
                    anchor: 'end',
                    align: 'bottom',

                    font: {
                        weight: 'bold', // Set font weight to bold
                    },
                },
            },
        },
            plugins: [ChartDataLabels]

        });
    });

    var chartData2 = {
        labels: ['Federation', 'External', 'Other'],
        datasets: [{
                label: 'Poorest & Vulnerable',
                backgroundColor: 'rgb(252, 143, 60)',
                data: [<?php echo $inclusion[0]->federation_poorest_category_amount . ',' . $inclusion[0]->external_poorest_category_amount . ',' . $inclusion[0]->vi_poorest_category_amount; ?>],
                barThickness: 50,

            },
            {
                label: 'Poor',
                backgroundColor: 'rgb(146, 243, 0)',
                data: [<?php echo $inclusion[0]->federation_poor_category_amount . ',' . $inclusion[0]->external_poor_category_amount . ',' . $inclusion[0]->vi_poor_category_amount; ?>],
                barThickness: 50,

            },
            {
                label: 'Medium Poor',
                backgroundColor: 'rgb(255, 255, 0)',
                data: [<?php echo $inclusion[0]->federation_medium_amount . ',' . $inclusion[0]->external_medium_amount . ',' . $inclusion[0]->vi_medium_amount; ?>],
                barThickness: 50,

            },
            {
                label: 'Rich',
                backgroundColor: 'rgb(80, 157, 205)',
                data: [<?php echo $inclusion[0]->federation_rich_amount . ',' . $inclusion[0]->external_rich_amount . ',' . $inclusion[0]->vi_rich_amount; ?>],
                barThickness: 50,


            },
        ],
    };

    $(document).ready(function() {
        var ctx = document.getElementById('type_loans').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: chartData2,
            options: {
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom",
                    },
                    datalabels: {
                    anchor: 'end',
                    align: 'bottom',

                    font: {
                        weight: 'bold', // Set font weight to bold
                    },
                },
            },
        },
            plugins: [ChartDataLabels]

        });
    });

    var chartData = {
        labels: ['Last 12 Months', '1 Year Before last year', '2 Years Before last year'],
        datasets: [{
            label: 'Average Outstanding loan',
            backgroundColor: 'rgb(255, 128, 0)',
            data: [<?php echo $efficiency[0]->outstanding_loan_ratio_year1 . ',' . $efficiency[0]->outstanding_loan_ratio_year2 . ',' . $efficiency[0]->outstanding_loan_ratio_year3; ?>],
            barThickness: 50,

        }, ],
    };

    $(document).ready(function() {
        var ctx = document.getElementById('axis_chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                scales: {
                    x: {
                        stacked: false,

                    },
                    y: {
                        stacked: false,
                        beginAtZero: true,
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                    },
                    // datalabels: {
                    //   anchor: 'end',
                    //   align: 'top',
                    //   formatter: function(value, context) {
                    //     var sum = 0;
                    //     context.dataset.data.forEach(function(data) {
                    //       sum += data;
                    //     });
                    //     return sum;
                    //   },
                    // },
                },
            },
            plugins: [ChartDataLabels]

        });
    });

    var n = 0;
    var s = 0;
    var w = 0;
    var l = 0;
    var h = 0;

    var nor = '{{ $credithistory[0]->productive }}';
    if (nor != '') {
        n = '{{ $credithistory[0]->productive }}';
    }
    var soc = '{{ $credithistory[0]->consumption }}';
    if (soc != '') {
        s = '{{ $credithistory[0]->consumption }}';
    }
    var wast = '{{ $credithistory[0]->debt_swapping }}';
    if (wast != '') {
        w = '{{ $credithistory[0]->debt_swapping }}';
    }
    var lon = '{{ $credithistory[0]->education }}';
    if (lon != '') {
        l = '{{ $credithistory[0]->education }}';
    }
    var heal = '{{ $credithistory[0]->health }}';
    if (heal != '') {
        h = '{{ $credithistory[0]->health }}';
    }

    var e_total = parseFloat(n) + parseFloat(s) + parseFloat(w) + parseFloat(l) + parseFloat(h);

    var normal = Math.round((n / e_total) * 100);
    var social = Math.round((s / e_total) * 100);
    var wasteful = Math.round((w / e_total) * 100);
    var loan = Math.round((l / e_total) * 100);
    var health = Math.round((h / e_total) * 100);

    var chartData4 = {
        labels: ['Last 12 Months', '1 Year Before last year', '2 Years Before last year'],
        datasets: [{
            label: 'Average Outstanding loan',
            backgroundColor: 'rgb(255, 128, 0)',
            data: [normal, social, wasteful, loan, health]
        }, ],
    };

    $(document).ready(function() {
        var ctx = document.getElementById('pie').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: chartData4,
            options: {
                scales: {
                    x: {
                        display: false,
                        stacked: false,
                    },
                    y: {
                        display: false,
                        stacked: false,
                        beginAtZero: true,
                    },
                },
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom',
                    },
                    // datalabels: {
                    //   anchor: 'end',
                    //   align: 'top',
                    //   formatter: function(value, context) {
                    //     var sum = 0;
                    //     context.dataset.data.forEach(function(data) {
                    //       sum += data;
                    //     });
                    //     return sum;
                    //   },
                    // },
                },
            },
            plugins: [ChartDataLabels]

        });
    });


    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Productive', normal],
            ['Consumption', social],
            ['Debt Swapping', wasteful],
            ['Education', loan],
            ['Health', health]
        ]);

        var options = {
            title: '',

        };




        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);

    }
</script>

<script type="text/javascript">
    // setup
    const data = {
        labels: ['Last 12 Months', '1 Year Before last year', '2 Years Before last year'],
        datasets: [{
                label: 'Operating Income (INR)',
                data: [<?php echo $efficiency[0]->operating_income_year1 . ',' . $efficiency[0]->operating_income_year2 . ',' . $efficiency[0]->operating_income_year3; ?>],
                backgroundColor: [
                    'rgb(146, 243, 0)',
                    'rgb(146, 243, 0)',
                    'rgb(146, 243, 0)',
                ],
                borderColor: [
                    'rgba(255, 26, 104, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1,
                barThickness: 50,
            },
            {
                label: 'Operating Expence',
                data: [<?php echo $efficiency[0]->operating_expenses_year1 . ',' . $efficiency[0]->operating_expenses_year2 . ',' . $efficiency[0]->operating_expenses_year3; ?>],
                backgroundColor: [
                    'rgb(252, 143, 60)',
                    'rgb(252, 143, 60)',
                    'rgb(252, 143, 60)',
                ],
                borderColor: [
                    'rgba(255, 26, 104, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1,
                barThickness: 50,
            },
        ]
    };

    // config
    const config = {
        type: 'bar',
        data,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMin: 0,
                    suggestedMax: 200000,
                    maxTicksLimit: 10,
                    // ticks: {
                    //     stepSize: 20, // Set the interval to 20
                    // }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                },
                // datalabels: {
                //   anchor: 'end',
                //   align: 'top',
                //   formatter: function(value, context) {
                //     var sum = 0;
                //     context.dataset.data.forEach(function(data) {
                //       sum += data;
                //     });
                //     return sum;
                //   },
                // },
            },
        },
        plugins: [ChartDataLabels]

    };

    // render init block
    const myChart4 = new Chart(
        document.getElementById('axis'),
        config
    );

    // Instantly assign Chart.js version
    const chartVersion = document.getElementById('axis');
    chartVersion.innerText = Chart.version;
</script>



