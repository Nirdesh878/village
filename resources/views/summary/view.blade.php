<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Summary Assessment Report </title>
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
        <button class="btn btn-sm getPDFbtn"  onclick="ExportToExcel('xlsx')" style="border: 1px black solid;width:6%;margin-top:10px;">GET
            PDF</button>
    </div>
    {{-- onclick="getPDF()" --}}



    <div class="canvas_all_pdf">
        <div class="pdf-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        {{-- <table class="table table-bordered  new-table-dg text-center" id="taskTable">
                            <thead >
                                <tr>
                                    <th>ID</th>
                                    <th>UIN</th>
                                    <th>Name</th>
                                    <th>SHG</th>
                                    <th>Cluster</th>
                                    <th>Federation</th>
                                    <th>Risk Raring</th>
                                    <th>Wealth Ranking</th>
                                    <th>Income -Expenditure Gap  during last 12 months</th>
                                    <th>Income and Expenditure ratio</th>
                                    <th>Regularity of Savings (compulsory savings during 12 months)</th>
                                    <th>Voluntary savings during last 12 months</th>
                                    <th>Other savings during 12 months</th>
                                    <th>Annual Savings to annual income</th>
                                    <th>Passbook in possession</th>
                                    <th>Annual Income and Loan Repayment Ratio</th>
                                    <th>Internal & External loan Overdue</th>
                                    <th>Debt-Service-Ratio</th>
                                    <th>Family Indebtedness</th>
                                    <th>Meeting Attendance</th>
                                    <th>Understanding of SHG Rules</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($family_assessment as $res)
                                <tr>
                                    <th>{{ $res['family_info']->id }}</th>
                                    <th>{{ $res['family_info']->UIN }}</th>
                                    <th>{{ $res['family_info']->Family_Name }}</th>
                                    <th>{{ $res['family_info']->SHG_Nmae }}</th>
                                    <th>{{ $res['family_info']->Cluster_Name }}</th>
                                    <th>{{ $res['family_info']->Fedeartion_Name }}</th>
                                    <th>{{ $res['family_info']->Rating_score }}</th>
                                    <th>{{ $res['family_info']->Wealth_Rank }}</th>
                                    <th>{{ $res['analysis_1_cy'] }}</th>
                                    <th>{{ $res['analysis_2_cy'] }}</th>
                                    <th>{{ $res['analysis_3_cy'] }}</th>
                                    <th>{{ $res['analysis_4_cy'] }}</th>
                                    <th>{{ $res['analysis_other'] }}</th>
                                    <th>{{ $res['analysis_5_cy'] }}</th>
                                    <th>{{ $res['analysis_6_cy'] }}</th>
                                    <th>{{ $res['analysis_7_cy'] }}</th>
                                    <th>{{ $res['analysis_10_cy'] }}</th>
                                    <th>{{ $res['analysis_8_cy'] }}</th>
                                    <th>{{ $res['analysis_11_cy'] }}</th>
                                    <th>{{ $res['analysis_12_ny'] }}</th>
                                    <th>{{ $res['analysis_13_ny'] }}</th>
                                </tr>
                                @endforeach



                            </tbody>
                        </table> --}}
                        <table class="table table-bordered  new-table-dg text-center" id="taskTable">
                            <thead >
                                <tr>
                                    <th>ID</th>
                                    <th>UIN</th>
                                    <th>Name of shg </th>
                                    <th>NRLM code </th>
                                    <th>Cluster</th>
                                    <th>Federation</th>
                                    <th>Village</th>
                                    <th>Name of training</th>
                                    <th>Duration</th>
                                    <th>Date</th>
                                    <th>Name of Trainer</th>
                                    <th>Name of Training Recipient</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shg_training as $value)
                                    @if (count($value->training_data) > 0)
                                        @foreach ($value->training_data as $res)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->uin }}</td>
                                            <td>{{ $value->shg_name }}</td>
                                            <td>{{ $value->NRLM_code }}</td>
                                            <td>{{ $value->cluster_name }}</td>
                                            <td>{{ $value->federation_name }}</td>
                                            <td>{{ $value->village }}</td>
                                            <td>{{ $res->training_name }}</td>
                                            <td>{{ $res->duration }}</td>
                                            <td>{{ $res->date_training }}</td>
                                            <td>{{ $res->who_received }}</td>
                                            <td>
                                                @php
                                                $desg = [];
                                                if ($res->secretary == 1) {
                                                    $desg[] = 'Secretary';
                                                }
                                                if ($res->president == 1) {
                                                    $desg[] = 'President';
                                                }
                                                if ($res->treasurer == 1) {
                                                    $desg[] = 'Treasurer';
                                                }
                                                if ($res->other == 1) {
                                                    $desg[] = 'Other: '.$res->other_value;
                                                }
                                                $strdesg = implode(', ', $desg);
                                                @endphp
                                                {{ $strdesg }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->uin }}</td>
                                        <td>{{ $value->shg_name }}</td>
                                        <td>{{ $value->NRLM_code }}</td>
                                        <td>{{ $value->cluster_name }}</td>
                                        <td>{{ $value->federation_name }}</td>
                                        <td>{{ $value->village }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>

                        </table>

                    </div>

                </div>
            </div>

        </div>
    </div>
        <div class="pdf-main">


            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <form class="container" method="GET" action="{{ url('summary') }}" id="needs-validation" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="validationCustom02">Agency</label>
                                    <select class="form-control" name="agency" id="agency_id">
                                        <option value="">--Select--</option>
                                        @foreach($agency as $row)
                                        <option value="{{ $row->agency_id }}">{{ $row->agency_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationCustom02">Federation<span class="red"></span></label>
                                    <select class="form-control " name="federation_id" id="federation_id">
                                        <option value="">--Select--</option>
                                    </select>
                                </div>


                                {{-- <div class="col-md-3 mb-3">
                                    <label for="validationCustom02">State</label>
                                    <select class="form-control" name="state" id="state">
                                        <option value="">--Select--</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationCustom02">District</label>
                                    <select class="form-control" name="district" id="district">
                                        <option value="">--Select--</option>
                                    </select>
                                </div> --}}
                                <div class="col-md-3 mb-3">
                                    <label for="validationCustom02">&nbsp;</label>
                                    <input type="submit" class="btn btn-sm btn-success" name="Search" value="Search" style="float:left;margin-top: 2.5em;">
                                    <button class="btn  btn-sm btn-danger" name="clear" value="clear" style="float: left;;margin-top:2.5em;margin-left: 10px;">Clear</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-center">
                            <h3>Summary Assessment Report</h3>
                            <h4><u>Name of Agency</u></h4>
                            <h4><u>Date Feb.13, 2024</u></h4>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>1. Basic Details</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg text-center">
                            <thead >
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">No of Federations</th>
                                    <th width="20">No of Habitations/Village Organizations</th>
                                    <th width="20">No of SHGs</th>
                                    <th width="20">No of Member Households</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td>{{ $fed_count }}</td>
                                    <td>{{ $cluster_count }}</td>
                                    <td>{{ $shg_count }}</td>
                                    <td>{{ $family[0]->count }}</td>
                                </tr> --}}

                            </tbody>
                        </table>

                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2. Part A: Institutional Assessment</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.1	Results in each Federation/VO//SHG </h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Risk Level</th>
                                    <th width="20" colspan="2">Federation (nos and % of total)</th>
                                    <th width="20" colspan="2">Federation (nos and % of total)</th>
                                    <th width="20" colspan="2">Village Organization (Nos and % of total)</th>
                                    <th width="20" colspan="2">SHGs (Nos and % of total)</th>
                                    <th width="20">Members HHS (Nos and % of total)</th>
                                    <th width="20"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Green (minimum Risk)</td>
                                    <td ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Yellow (low risk)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Grey (significant risk)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Red (high Risk)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                            </tbody>
                        </table>

                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.2 Federation Assessment - Strengths and Areas for Improvement<span style="color: red;"> - Add Overall</span></h4>

                        </div>
                    </div>
                </div>

                <div class="row align-items-center">

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Name</th>
                                    <th width="20">Governance</th>
                                    <th width="20">Efficiency</th>
                                    <th width="20">Inclusion</th>
                                    <th width="20">Credit Portfolio</th>
                                    <th width="20">Risk Mitigation</th>
                                    <th width="20">Sustainability</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Overall</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.2.1 Governance Indicators</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Adoption of Written Rules</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Regular elections/selection of leaders</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Meeting Attendance>Regularity of Meetings</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Updating of Books of Accounts and other ledgers</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Internal Audits</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>External Audit</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Training of office bearers</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.2.2 Inclusion Indicators</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Poverty Mapping updated (last 3 years)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Target Mobilized</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>% of Poor & Poorest in Leadership Position</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>% of Poor & Poorest benefitting from all loans (Internal& External) Loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>% of Poor & Poorest benefitting from external Loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.2.3 Efficiency Indicators</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>No of days taken to approve loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>No of days from loan approval to cash in hand</td>
                                    <td>- within 2 days=5 (green); within 3 days=4 (yellow); within 5 days=3 (grey);  more than 5 days=1 (red)</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Operating Expense Ratio</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Average Loan outstanding amount and active borrowers</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.2.4 Credit Portfolio Management</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>No and Amount of Loans disbursed during last 3 years</td>
                                    <td>NA</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>% of loan applications approved within 15 days</td>
                                    <td>NA</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>% of members benefited from All loans- above 80% benefitting=5; between 60 to 79% benefitting=4, between 50 to 59% benefitting=3, below 50% benefitting=1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>DCB -Repayment % of Federation Loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>DCB-Repayment % of all other loans (external)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>No and % of loan default</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>PAR 30 days & more (amount and %)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>PAR 60 days & More (amount and %)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>PAR 90 days & More (amount and %)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Loan Tracking System</td>
                                    <td>Y/N</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>% of loans for productive purposes</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>No & % of members received 1 or more loans during last 3 years</td>
                                    <td>Y/N</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.2.5 Sustainability & Risk Mitigation</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Federation Covering its costs (Y/N)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Loan Security Fund established (Y/N)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Life Insurance Coverage for all members</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Life Insurance coverage for Active Borrowers</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Asset Insurance coverage</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.3	Habitation/Village Organization Assessment-- Strengths and Areas for Improvement</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Name</th>
                                    <th width="20">Governance</th>
                                    <th width="20">Efficiency</th>
                                    <th width="20">Inclusion</th>
                                    <th width="20">Credit Portfolio</th>
                                    <th width="20">Risk Mitigation</th>
                                    <th width="20">Sustainability</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2 and so on</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Overall</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.3.1 Governance Indicators</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Adoption of Written Rules</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Regular elections/selection of leaders</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Meeting Attendance>Regularity of Meetings</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Updating of Books of Accounts and other ledgers</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Internal Audits</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>External Audit</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Training of office bearers</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.3.2 Inclusion Indicators</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Poverty Mapping updated (or update within last 3 years)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>% of Poor & Poorest in Leadership Position</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>% of Poor & Poorest benefitting from Internal Loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>% of Poor & Poorest benefitting from external Loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.3.3 Efficiency Indicators</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>No of days taken to approve loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>No of days from loan approval to cash in hand</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Cost Income Ratio</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Average Loan outstanding amount and active borrowers</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.3.4 Credit Portfolio Management</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>No and Amount of Loans disbursed during last 3 years</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>% of loan applications approved within 15 days</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Repayment % of all loans (VO/Cluster and others)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>No and % of loan default</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>PAR status 90 days & more (Amount & %)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Loan Tracking System (Y/N)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>% of loans for productive purposes</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>No & % of members received 1 ore more loans during last 3 years</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.3.5 Sustainability & Risk Mitigation </h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Expenses Covered (Y/N)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>No of VO/Cluster members having voluntary Savings</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>No of members contributing to Loan Security Fund</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.4 SHG Assessment-- Strengths and Areas for Improvement</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Name</th>
                                    <th width="20">Governance</th>
                                    <th width="20">Efficiency</th>
                                    <th width="20">Inclusion</th>
                                    <th width="20">Credit Portfolio</th>
                                    <th width="20">Risk Mitigation</th>
                                    <th width="20">Sustainability</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2 and so on</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Overall</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.4.1 Governance Indicators</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Adoption of Written Rules</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Regular elections/selection of leaders</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Meeting Attendance>Regularity of Meetings</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Updating of Books of Accounts and other ledgers regularly (all books on a monthly basis)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Internal Audits Y/N</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>External Audit Y/N</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Training of office bearers during last 3 years</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.4.2 Inclusion Indicators</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>% of Poor & Poorest in Leadership Position</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>% of Poor & Poorest benefitting from Internal Loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>% of Poor & Poorest benefitting from external Loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.4.3 Efficiency Indicators</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>No of days taken to approve loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>No of days from loan approval to cash in hand</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>SHG Covering its costs (Y/N)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>No & /% of families benefitted from all loans during last 3 years</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.4.4 Credit Portfolio Management</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td> No and Amount of Loans disbursed during last 3 years</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Repayment % of internal loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Repayment % of external loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>PAR status of internal loans more than 90 days</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>PAR status of external loans more than 90 days</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>% of loans for productive purposes</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.4.5 Savings Indicators</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Parameters</th>
                                    <th width="20">Risk Assessment</th>
                                    <th width="20">No</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Regularity of Normal/Compulsory Savings (all members saving per month)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Normal/compulsory savings trend</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Voluntary savings (Y/N)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Other savings (no & % of members who have other savings)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.5 Issues and challenges</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.6 </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>2.7 Areas that need improvement-</h4>
                        </div>
                    </div>
                </div>

                <!-- Part B  START -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3. Part B: Household (HH) Level Assessment</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.1 Basic profile of HHs</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.1.1 Age of SHG members</h4>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Age Group</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of Total</th>
                                    <th width="20">Average HH Members</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>30 Years & Below</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>31 to 40 Years</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>41 to 50 Years</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>51 to 60 Years</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>61-65 Years</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>66 and Above</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Cast Composition -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.1.2 Cast Composition</h4>
                        </div>
                    </div>
                </div>
                <!-- Cast Composition Table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Caste</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>OBC</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>SC/ST</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Others</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Cast Composition Table end -->

                <!-- Wealth Ranking -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.1.3 Wealth Ranking</h4>
                        </div>
                    </div>
                </div>
                <!-- Wealth ranking Table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Wealth/Poverty Ranking</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Very Poor (and vulnerable/also includes differently abled)</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Poor</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Medium Poor</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Rich</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- wealth ranking Table end -->

                <!-- Quality of Life Aspects -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.1.4 Quality of Life Aspects- Health, Nutrition and sanitation - by wealth rank</h4>
                        </div>
                    </div>
                </div>
                <!-- Quality of Life Aspects Table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Standard of Living/Quality of Life</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Number and % of HHs having access to all three meals on daily basis for members.
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>No and of HHs with malnourishment/undernourished</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>HHs with health issues</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>No and % of HHs having sanitary latrine within HH premises</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td> No and % of families having Drinking water within the house</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td> No and % of families having Electricity</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>No and % of families having Gas connection</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>No and % of HHs living in houses owned by family
                                        <ul>
                                            <li>Kacha House</li>
                                            <li>Pacca House</li>
                                            <li>Tiled House</li>
                                        </ul>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Quality of Life Aspects Table end -->

                <!-- Education Level of SHG members -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.1.5 Education Level of SHG members</h4>
                        </div>
                    </div>
                </div>
                <!-- Education Level of SHG members Table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Education Levels</th>
                                    <th width="20">No. of Members</th>
                                    <th width="20">% of Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Illiterate/school drop out - no education</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Upto 12<sup>th</sup> standard</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>College/UG</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Masters/PG and Technical</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Education Level of SHG members Table end -->

                <!--  3.2	Assets -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.2 Assets</h4>
                        </div>
                    </div>
                </div>
                <!-- 3.2.1 All Assets -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.2.1 All Assets</h4>
                        </div>
                    </div>
                </div>
                <!-- 3.2.1 All Assets table starts -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Assets</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>No and % of HHs own:
                                        <ol style="list-style-type: none; padding-left: 0;">
                                            <li>(a) Refrigerator</li>
                                            <li>(b) Air Conditioning</li>
                                            <li>(c) Smart Phone</li>
                                            <li>(d) Color TV</li>
                                        </ol>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>No and % of HHs own transportation:
                                        <ol style="list-style-type: none; padding-left: 0;">
                                            <li>(a) Motorbikes</li>
                                            <li>(b) Cycles</li>
                                            <li>(c) Cars/Trucks</li>
                                        </ol>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>No and % of HHs Own/lease and cultivate land</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Average extent of land cultivated by family, (owned or cultivated as share cropping),</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Number and % of HHs having livestock (cows, buffaloes, goats)</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>No and % of HHS own Machinery and equipment</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td> No & % of HHs own Jewelry</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- 3.2.1 All Assets table end -->

                <!-- 3.3 Family Income -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.3 Family Income</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.3.1 Family Income Levels:</h4>
                        </div>
                    </div>
                </div>
                <!-- 3.3 Family Income table start-->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Income Levels</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>100000 or under</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>100001 to 200000</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>200001 to 300000</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>300001 to 400000</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>400001 & above</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- 3.3 Family Income table end-->

                <!-- Sources of Family Income -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.3.2 Sources of Family Income</h4>
                        </div>
                    </div>
                </div>
                <!-- Sources of Family Income table start-->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Income Levels</th>
                                    <th width="20">Total Income</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of Average income</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Agriculture/Horticulture</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Livestock</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Fixed income (jobs/employed)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Daily Wage</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Trade</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Pension</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Other income</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Total Average Income</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Sources of Family Income table end-->

                <!-- 3.3.3	Average annual HH income by Poverty Category -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.3.3 Average annual HH income by Poverty Category</h4>
                        </div>
                    </div>
                </div>
                <!-- 3.3.3	Average annual HH income by Poverty Category table start-->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Poverty Category</th>
                                    <th width="20">Average annual income</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Very Poor</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Poor</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Medium</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Rich</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Overall</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- 3.3.3	Average annual HH income by Poverty Category table end-->

                <!-- Family Expenditures -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.4 Family Expenditures</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.4.1 Family Expenditure Pattern</h4>
                        </div>
                    </div>
                </div>
                <!-- Family Expenditures Table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Expenditure Category</th>
                                    <th width="20">Total Annual Expenditure</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of total expenditures</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Normal expenditures</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Social/cultural expenditures</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Wasteful expenditures</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Savings</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td> Loan Payments</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Average annual HH expenditure</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Family Expenditures Table end -->

                <!-- 3.5 Income -Expenditure Gap -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.5 Income -Expenditure Gap</h4>
                        </div>
                    </div>
                </div>
                <!-- 3.5 Income -Expenditure Gap table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Gap Level</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Less than 10% gap between Income & expenditure</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>10% to 25% gap between Income & expenditure</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>26 to 50% gap between Income & Expenditures</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>More than 50% gap between income and expenditures</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Number and % of HHs having deficit income (a) this year (b) next year</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Number and % of HHs having deficit income this year and surplus income next year
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- 3.5 Income -Expenditure Gap table end -->

                <!-- 3.6 Family Savings -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.6 Family Savings</h4>
                        </div>
                    </div>
                </div>
                <!-- 3.6 Family Savings table start-->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Savings Instrument</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Average HH savings (a) by Wealth Rank (b) Risk Assessment</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Compulsory/Normal group savings</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Voluntary savings in SHG</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Other savings ( banks, post office, etc)</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Families with more than 10% savings</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- 3.6 Family Savings table end-->

                <!-- 3.7 Family Loan Outstanding   -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.7 Family Loan Outstanding </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.7.1 Average Amount by Poverty Category</h4>
                        </div>
                    </div>
                </div>
                <!-- 3.7 Family Loan Outstanding table start-->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Indicator</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of total loan</th>
                                    <th width="20">Average Loan Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Poverty Category:
                                        <ol style="list-style-type: none; padding-left: 0;">
                                            <li>(a) Very Poor</li>
                                            <li>(b) Poor</li>
                                            <li>(c) Medium Poor</li>
                                            <li>(d) Rich</li>
                                        </ol>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Average loan size (amount)
                                        <ol style="list-style-type: none; padding-left: 0;">
                                            <li>(a) from SHG</li>
                                            <li>(b) from federation/cluster </li>
                                            <li>(c) from bank</li>
                                            <li>(d) from money lender</li>
                                            <li>(e) from NBFC/MFI</li>
                                            <li>(f) from private source</li>
                                        </ol>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Average annual interest for:
                                        <ol style="list-style-type: none; padding-left: 0;">
                                            <li>(a) from SHG</li>
                                            <li>(b) from federation/cluster </li>
                                            <li>(c) from bank</li>
                                            <li>(d) from money lender</li>
                                            <li>(e) from NBFC/MFI</li>
                                            <li>(f) from private source</li>
                                        </ol>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Number and %of HHs demanding a loan while having to pay one or more loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- 3.7 Family Loan Outstanding table end-->


                <!-- Purpose of Loans -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.7.2 Purpose of Loans</h4>
                        </div>
                    </div>
                </div>
                <!-- Purpose of Loans table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Purpose of Loans</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of total</th>
                                    <th width="20">Range of Amounts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Productive (business/agr/livestock, etc)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Family Expenses</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>House construction</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Education</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Weddings</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Social functions</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Health</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Other</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Purpose of Loans table end -->


                <!-- Number of Loans -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.7.3 Number of Loans</h4>
                        </div>
                    </div>
                </div>
                <!-- Number of Loans table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Number of Loans</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of total</th>
                                    <th width="20">Average Loan Amounts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>HHs with 1 loan</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>HHs with 2 loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>HHs with 3 loans </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>HHs with 4 or more loans</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Number of Loans table end -->

                <!-- Amount of Loans -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.7.4 Amount of Loans</h4>
                        </div>
                    </div>
                </div>
                <!-- Amount of Loans table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Amount of Loans</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of total</th>
                                    <th width="20">No & % of HHs with default</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Loans between Rs.5000 to 50000</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Loans between Rs. 50001 to 100000</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Loans between Rs. 100001 to Rs.200000</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Loans between Rs.200001 to 300000</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Loans between Rs.300001 to 400000</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Loans between Rs.400001 to 500000</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>More than Rs. 500001 </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Amount of Loans table end -->


                <!-- Sources of Loans and Default rates -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.7.5 Sources of Loans and Default rates</h4>
                        </div>
                    </div>
                </div>
                <!-- Sources of Loans and Default rates table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Source</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of total</th>
                                    <th width="20">No of HHs with default</th>
                                    <th width="20">No of HHs with default</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>SHG</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>VO/Federation</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Banks</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>NBFCs/MFI</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Moneylenders</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Private Informal sources (family etc)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Sources of Loans and Default rates table end -->


                <!-- Jewelry Loans -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>3.7.6 Jewelry Loans</h4>
                        </div>
                    </div>
                </div>
                <!-- Jewelry Loans table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Jewelry Loans</th>
                                    <th width="20">No. of HHs</th>
                                    <th width="20">% of total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Jewelry Loans between Rs.5000 to 50000</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jewelry Loans between Rs.50001 to Rs.1 lakh</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Jewelry Loans between Rs.1 to 2 lakhs</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Jewelry Loans between Rs.2 to 4 lakhs</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Jewelry Loans more than 4 lakhs</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Jewelry lost due to these loans (banks)</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Jewelry lost due to these loans (money lenders/private)</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Total Jewelry Loans</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Jewelry Loans table end-->


                <!-- Family Assessment Results -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>4. Family Assessment Results</h4>
                        </div>
                    </div>
                </div>
                <!-- Family Assessment Results table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Risk Assessment level</th>
                                    <th width="20">No. of Families</th>
                                    <th width="20">%of Total Families</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Green - Minimal Risk</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Yellow- Low Risk</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Grey - Significant Risk</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Red - High Risk</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Family Assessment Results table end -->


                <!-- Business Plans and Credit Requirements -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>5. Business Plans and Credit Requirements</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>5.1 Credit Requirements as per Risk Level</h4>
                        </div>
                    </div>
                </div>
                <!-- Business Plans and Credit Requirements table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Credit requirement as per Risk Level</th>
                                    <th width="20">No of Families with Business Plans</th>
                                    <th width="20">% of total Families with BPs</th>
                                    <th width="20">Credit Requirement (total)(Amount)</th>
                                    <th width="20">% of total (requirement)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Green - Minimal Risk</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Yellow - Low Risk</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Grey - Significant Risk</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Red - High Risk</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Total Credit requirement</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Business Plans and Credit Requirements table end -->


                <!-- 5.2 Purpose for Business Plans/Credit requirement -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>5.2 Purpose for Business Plans/Credit requirement</h4>
                        </div>
                    </div>
                </div>
                <!-- 5.2 Purpose for Business Plans/Credit requirement table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Purpose</th>
                                    <th width="20">Total HHs with Credit demand</th>
                                    <th width="20">Total Credit Requirement</th>
                                    <th width="20">% of Credit Requirement</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Income Increase in agri/horticulture</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Income increase in Livestock (dairy/fisheries)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Trade/Service</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Skill enhancement</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Education </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Asset Purchase (land)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>House construction </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Debt Swapping</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Others</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- 5.2 Purpose for Business Plans/Credit requirement table end -->


                <!-- Overall Status of Households -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>6. Overall Status of Households</h4>
                        </div>
                    </div>
                </div>
                <!-- Overall Status of Households table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Indicator</th>
                                    <th width="20">Risk Level (No of HHs) with colors</th>
                                    <th width="20">Risk Level (% of HHs) with colors</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Income -Expenditure Gap during last 12 months</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Regularity of Savings (compulsory savings during 12 months)</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Annual Savings to Annual Income Ratio</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Annual Income and Loan Repayment Ratio</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Internal & External loan Overdue </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Debt-Service-Ratio</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Family Indebtedness</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Meeting Attendance</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Understanding of SHG Rules</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Overall Status of Households table end -->


                <!-- Family Aspirations/Goals -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>7. Family Aspirations/Goals</h4>
                        </div>
                    </div>
                </div>
                <!-- Family Aspirations/Goals table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Goals/Aspirations</th>
                                    <th width="20">No of HHs</th>
                                    <th width="20">% of total </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>House Construction/Repair</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Starting a business/expansion of current business/income</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td> Education of Children</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Weddings</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td> Savings</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Others</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Family Aspirations/Goals table end -->


                <!-- Challenges to Achieve Aspirations -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>8. Challenges to Achieve Aspirations</h4>
                        </div>
                    </div>
                </div>
                <!-- Family Aspirations/Goals table start -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th width="5">Sr.No.</th>
                                    <th width="20">Top Challenges</th>
                                    <th width="20">No of HHs</th>
                                    <th width="20">% of total </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Health Issues</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Lack of land or opportunities</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Lack of information/Awareness</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Lack of Income</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td> Lack of Education</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Others</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Challenges to Achieve Aspirations table end -->






            </div>
        </div>
    {{-- </div> --}}
</body>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js">
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ asset('assets\js\table_excel.js') }}"></script>

<script>
     function ExportToExcel(type, fn, dl) {
        alert("kk");
       var elt = document.getElementById('taskTable');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Task_Assigend_Report.' + (type || 'xlsx')));
    }
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
        }).then(function (canvas) {
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

            pdf.save("Summary_Assessment_Report.pdf");
        });
    };
    $(document).ready(function () {
        $('#agency_id').on('change', get_federation_list);
    });

    function get_federation_list() {
        var obj = $(this);
        var agency_id = obj.val();
        if (agency_id > 0) {
            $.ajax({
                type: 'GET',
                url: '/get_federation_list',
                data: '_token = YMAm2JbX90BtPGxJtRiTEM8Pt7EDzxjuIrTkxrwI&agency_id=' + agency_id,
                success: function (data) {
                    if (data != '') {
                        $('#federation_id').html(data);
                        $('#federation_id').trigger("change");
                    }
                }
            });
        }
    }
</script>








