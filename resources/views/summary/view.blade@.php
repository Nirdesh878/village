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
        <button class="btn btn-sm getPDFbtn" onclick="getPDF()" style="border: 1px black solid;width:6%;margin-top:10px;">GET
            PDF</button>
    </div>



    <div class="canvas_all_pdf">
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
                            <h4><u>Date Feb.7, 2024</u></h4>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="text-start">
                            <h4>1.Basic Details</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg text-center">
                            <thead >
                                <tr>
                                    <th>No of Federations</th>
                                    <th>No of Habitations/Village Organizations</th>
                                    <th>No of SHGs</th>
                                    <th>No of Member Households</th>
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
                            <h4>2.Part A: Institutional Assessment</h4>
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
                                    <th>S.no</th>
                                    <th>Risk Level</th>
                                    <th>Federation (nos and % of total)</th>
                                    <th>Village Organization (Nos and % of total)</th>
                                    <th>SHGs (Nos and % of total)</th>
                                    <th>Members HHS  (Nos and % of total)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Green (minimum Risk)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Yellow (low risk)</td>
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
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Red (high Risk)</td>
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
                            <h4>2.2	Federation Assessment- Strengths and Areas for Improvement</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">

                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Governance</th>
                                    <th>Efficiency</th>
                                    <th>Inclusion</th>
                                    <th>Credit Portfolio</th>
                                    <th>Risk Mitigation</th>
                                    <th>Sustainability</th>
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
                                    <th>SN</th>
                                    <th>Parameters</th>
                                    <th>Risk Assessment</th>
                                    <th>No</th>
                                    <th>%</th>
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
                                    <th>SN</th>
                                    <th>Parameters</th>
                                    <th>Risk Assessment</th>
                                    <th>No</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Poverty Mapping updated</td>
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
                                    <td>% of Poor & Poorest benefitting from</td>
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
                            <h4>2.2.3 Efficiency Indicators</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Parameters</th>
                                    <th>Risk Assessment</th>
                                    <th>No</th>
                                    <th>%</th>
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
                            <h4>2.2.4 Credit Portfolio Management</h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Parameters</th>
                                    <th>Risk Assessment</th>
                                    <th>No</th>
                                    <th>%</th>
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
                                    <td>DCB -Repayment %</td>
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
                                    <td>PAR 30 days & more</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>PAR 60 days & More</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>PAR 90 days & More</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Loan Tracking System</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>% of loans for productive purposes</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>10</td>
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
                            <h4>2.2.5 Sustainability & Risk Mitigation </h4>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <table class="table table-bordered  new-table-dg">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Parameters</th>
                                    <th>Risk Assessment</th>
                                    <th>No</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Income/Expense Ration (Expenses Covered)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Cumulative Savings increasing Trend</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Loan Security Fund</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Life Insurance coverage for Active members</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Life insurance claimed %</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Asset Insurance</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Asset insurance Claimed</td>
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
                                    <th>Name</th>
                                    <th>Governance</th>
                                    <th>Efficiency</th>
                                    <th>Inclusion</th>
                                    <th>Credit Portfolio</th>
                                    <th>Risk Mitigation</th>
                                    <th>Sustainability</th>
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
                                    <th>SN</th>
                                    <th>Parameters</th>
                                    <th>Risk Assessment</th>
                                    <th>No</th>
                                    <th>%</th>
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
                                    <th>SN</th>
                                    <th>Parameters</th>
                                    <th>Risk Assessment</th>
                                    <th>No</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Poverty Mapping updated</td>
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



            </div>
        </div>
    </div>
</body>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js">
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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








