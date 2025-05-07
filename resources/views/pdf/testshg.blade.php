<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shg</title>
</head>


<!-- Favicon icon -->
<link rel="icon" href="{{ asset('assets\images\favicon.png') }}" type="image/x-icon">
<!-- Google font-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
<!-- Required Fremwork -->
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('bower_components\bootstrap\css\bootstrap.min.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets\icon\themify-icons\themify-icons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets\icon\font-awesome\css\font-awesome.min.css') }}">
<!-- feather Awesome -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets\icon\feather\css\feather.css') }}">
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets\css\jquery.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets\css\style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets\css\jquery.mCustomScrollbar.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets\pages\advance-elements\css\bootstrap-datetimepicker.css') }}">
<!-- Date-range picker css  -->
<link rel="stylesheet" type="text/css"
    href="{{ asset('bower_components\bootstrap-daterangepicker\css\daterangepicker.css') }}">

<!-- Data Table Css -->
<link rel="stylesheet" type="text/css"
    href="{{ asset('bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets\pages\data-table\css\buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\fullcalendar\css\fullcalendar.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\fullcalendar\css\fullcalendar.print.css') }}"
    media='print'>

<script type="text/javascript" src="{{ asset('bower_components\jquery\js\jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components\jquery-ui\js\jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets\js\bootbox.js') }}"></script>

<link rel="stylesheet" href="{{ asset('bower_components\select2\css\select2.min.css') }}">

<link rel="stylesheet" type="text/css"
    href="{{ asset('bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/multiselect/css/multi-select.css') }}" />

<!-- Switch component css -->
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\switchery\css\switchery.min.css') }}">

<!-- owl carousel css -->
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\owl.carousel\css\owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\owl.carousel\css\owl.theme.default.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\ekko-lightbox\css\ekko-lightbox.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\lightbox2\css\lightbox.css') }}">
<script type="text/javascript" src="{{ asset('assets\js\charts.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets\js\chartjs-plugin-datalabels.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets\js\chartjs-plugin-doughnutlabel.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets\js\chartjs-plugin-labels.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> --}}

<style>
    body {
        background-color: white;
        // padding:70px;
        // width:100%;
        font-family: "Didact Gothic", sans-serif;
    }


    table {
        border-collapse: collapse;
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        margin-bottom: 0;
        background-color: #F1F0F0;
        /* light grey */
        padding: .60rem;
        margin-right: 10px;
    }



    th {
        border: 2px solid #ddd;
        padding: 10px;

        height: 5px;
        font-size: 16px;
        font-weight: normal;


    }

    td {

        font-size: 16px;
        border: 2px solid #ddd;
        padding: 10px;

        font-size: 14px;
    }

    .style-center {
        text-align: center;
        width: 9%;
    }

    .style-side {
        text-align: left;

    }

    .style6 {
        text-align: center;
        width: 16.6%;
    }

    .page-break {
        page-break-before: always;
    }

    th {
        background-color: #CEA38B;
        /* Peach */

    }


    #grey,
    .cs td:nth-child(1),
    #cs {
        background-color: #D5D4D4;
    }

    #white {
        background-color: #FFFFFF;
    }

    #red {
        background-color: #F13223;
    }


    .table-container {


        display: flex;
        align-items: center;
        margin: 0 auto;
        padding-bottom: 10px;
        align-items: flex-start;

    }


    .table-container table {
        width: 100%;
        padding-bottom: 10px;
        align-items: flex-start;
        flex: 1;
        margin: 0 auto;
        margin-right: 10px;


    }

    h1 {
        font-family: "Cardo", serif;
        text-align: center;
        margin-bottom: 1cm;
        font-size: 40px;
        font-weight: bold;
    }

    h3 {
        font-family: "Cardo", serif;
        text-align: center;
        margin-bottom: 1cm;
        font-size: 30px;
        font-weight: bold;
    }

    h4 {
        font-weight: normal;
    }

    h2 {
        font-family: "Cardo", serif;
        font-weight: bold;
        margin-bottom: 1cm;
        border: none;
        font-size: 25px;
        text-align: center;
    }

    .corner-table {
        border-collapse: collapse;
        margin-right: 50cm;
        margin-left: 23cm;
        width: 20%;
        padding-bottom: 5px;


    }

    .corner-table td {
        padding-bottom: 5px;
        margin-right: 10cm;
        margin-left: 23cm;
        width: 20%;
    }

    .column {
        width: 20%;
    }

    #report {
        padding: 10px;
        position: absolute;
        right: 70px;
        width: 20%;
    }


    #aa {
        width: 100%;
    }

    #ab {
        width: 80%;
    }

    #ac {
        width: 20%;
    }
</style>


    {{-- page Body start --}}

    <body class="antialiased container mt-5">
        <div class="bar-wrp-m">
            <button class="btn btn-sm getPDFbtn" onclick="getPDF()">GET PDF</button>
        </div>

        <div class="canvas_all_pdf">
            <h1 style="font-size: 30px">SHG Profile</h1>
        </div>
        <table id="report">
            <tr>
                <th style="text-align:center; width:65%">Report Card</th>
                <td style="background-color: red; width: 35%;"></td>
            </tr>

        </table>
        <h3>ID UIN ***ID***********************</h3>
        <div>

        </div>
        <h2><u>BASIC INFORMATION</u></h2>


        <div class=table-container>

            <table>
                <tr>
                    <th colspan=2> Name & Other Details
                </tr>
                <tr>
                    <td style="width:50%">Name </td>
                    <td></td>
                </tr>
                <tr>
                    <td>District </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Cluster</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Village </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Federation</td>
                    <td></td>
                </tr>
                <tr>
                    <td>State</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Country </td>
                    <td></td>
                </tr>
                <tr>
                    <td>NRLM Code </td>
                    <td></td>
                </tr>
            </table>


            <table>
                <tr>
                    <th colspan=2> SHG Creation & Membership
                </tr>
                <tr>
                    <td style="width:50%">Date of Creation</td>
                    <td></td>
                </tr>
                <tr>
                    <td>No of Members at the time of Creation</td>
                    <td></td>
                </tr>
                <tr>
                    <td>No of current Members</td>
                    <td></td>
                </tr>
                <tr>
                    <td>No of members from same Neighborhood</td>
                    <td></td>
                </tr>
                <tr>
                    <td>No of members left since creation</td>
                    <td></td>
                </tr>
            </table>
        </div>

        <div class=table-container>
            <table>

                <tr>
                    <th colspan=2> Current Leadership Status
                </tr>
                <tr>
                    <td style="width:50%">President/Animator </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Secretary </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Cluster</td>
                    <td></td>
                </tr>

            </table>
            <table>

                <tr>
                    <th colspan=2> Current Book Keeper
                </tr>
                <tr>
                    <td style="width:50%">Name</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Date of Appointment </td>
                    <td></td>
                </tr>
        </div>
        </table>
        </div>

        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">

            <tr>
                <th colspan=4> Banking details
            </tr>
            <tr>
                <td>Account opening date</td>
                <td>MMM,DD YYYY</td>
                <td>Account number </td>
                <td></td>
            </tr>
            <tr>
                <td>Name of the bank </td>
                <td></td>
                <td>Name of the branch</td>
                <td></td>
            </tr>
        </table>

        <div class=table-container>
            <table>

                <tr>
                    <th> Agency That Formed SHG
                </tr>
                <tr>
                    <td>Testing Agency</td>
                </tr>

            </table>
            <table>
                <tr>
                    <th colspan=2> Whether SHG Has Been Restructured
                </tr>
                <tr>
                    <td>Whether SHG Has Been Restructured</td>
                    <td>Yes/No</td>
                </tr>
                <tr>
                    <td>Date of Restructuring</td>
                    <td></td>
                </tr>

            </table>
        </div>

        <h2><u>GOVERNANCE</u></h2>
        <div class=table-container>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th colspan=2> Adoption
                </tr>
                <tr>
                    <td>Adoption of Rules </td>
                    <td>Yes/No</td>
                </tr>
                <tr>
                    <td>Date of Adoption</td>
                    <td>MMM DD, YYYY</td>
                </tr>
                <tr>
                    <td>Written Rules</td>
                    <td>Yes/No</td>
                </tr>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th colspan=2> Details on Election
                </tr>
                <tr>
                    <td>Frequency as per norms</td>
                    <td>Yes/No</td>
                </tr>
                <tr>
                    <td>First Election /Selection Date</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Election/Selection conducted so far</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Last Election/Selection Date</td>
                    <td></td>
                </tr>
            </table>
        </div>


        <div class=table-container>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">

                <tr>
                    <th colspan=2> Meeting Details
                </tr>
                <tr>
                    <td>Frequency of Meetings</td>
                    <td>Twice a month</td>
                </tr>
                <tr>
                    <td>No. Of meetings in last 12 months</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>Average participation of members in 12 months</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>Meetings Recorded</td>
                    <td>0</td>
                </tr>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th colspan=2>Status Of Minutes During Last 12 Months
                </tr>
                <tr>
                    <td>Who writes the minutes?</td>
                    <td>Secretary</td>
                </tr>
                <tr>
                    <td>Name </td>
                    <td>If Other name here</td>
                </tr>
            </table>
        </div>

        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th colspan=2> Updating of Books of Accounts
            </tr>
            <tr>
                <td>How often books updated</td>
                <td>bimonthly</td>
            </tr>
            <tr>
                <td>Date of last update</td>
                <td>MMM DD, YYYY</td>
            </tr>
            <tr>
                <td>Updated Status</td>
                <td>0</td>
            </tr>
        </table>

        <div class=table-container>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th colspan=2> Bank Accounts In Regular Operation During last 12 months
                </tr>
                <tr>
                    <td>Bank accounts is regular operation during last 12 months</td>
                    <td id="grey">Yes</td>
                </tr>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th colspan=2> Grade
                </tr>
                <tr>
                    <td>Grade During Last 12 Months</td>
                    <td id="grey">A</td>
                </tr>
            </table>
        </div>

        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th style="width:33%"> Audit</th>
                <th style="width:33%"> Internal</th>
                <th style="width:33%">External </th>
            </tr>

            <tr>
                <td>Whether conducted (Y/N)</td>
                <td>Yes</td>
                <td>Yes</td>
            </tr>

            <tr>
                <td>Date of audit </td>
                <td>MMM DD, YYYY</td>
                <td>MMM DD, YYYY</td>
            </tr>
        </table>

        <h2><u>INCLUSION</u></h2>

        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th style="width:60%"> Wealth Ranking/Poverty Mapping</th>
                <th style="width:40%" id="grey"> Yes or No</th>
            </tr>
            <tr>
                <td>1st Poverty Mapping</td>
                <td>MMM DD, YYYY</td>
            </tr>
            <tr>
                <td>Last Update </td>
                <td>MMM DD, YYYY</td>
            </tr>
        </table>


        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th id="white"colspan=4>Visual Poverty Mapping
            </tr>
            <tr>
                <th style="width:25%">No of Poorest & Vulnerable</th>
                <th style="width:25%">No of Poor</th>
                <th style="width:25%">No of Medium Poor</th>
                <th style="width:25%">No of Rich</th>
            </tr>
            <tr>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
        </table>


        <table id="aa"class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th id="white"colspan=3>Caste Composition</th>
            </tr>
            <tr>
                <th style="width:33%"> No. Of SC/ST</th>
                <th style="width:33%">No Of OBC</th>
                <th style="width:33%">No of Medium Poor</th>
            </tr>
            <tr>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
        </table>



        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th id="white"colspan=11> No. of Loans and Amounts given to SHG Members During Last 12 Months</th>
            </tr>
            <tr>
                <td id="grey" colspan=3> Total Loans Disbursed (#)</td>
                <td colspan=2>0</td>
                <td id="grey" colspan=3>Total Amount Disbursed (INR)</td>
                <td colspan=3>0</td>
            </tr>
            <tr>
                <th rowspan=3 class="style-center">Category</th>
                <th colspan=2 rowspan=2 class="style-center">Internal Loans</th>
                <th colspan=4 class="style-center">External Loans</th>
                <th colspan=2 rowspan=2 class="style-center">Other Loans</th>
                <th colspan=2 rowspan=2 class="style-center">Total</th>
            </tr>

            <tr>
                <th colspan=2 class="style-center">Federation</th>
                <th colspan=2 class="style-center">Bank</th>>
            </tr>

            <tr>
                <td class="style-center">Loan Disbursed (#)</td>
                <td class="style-center">Amount Disbursed (INR)</td>
                <td class="style-center">Loan Disbursed (#)</td>
                <td class="style-center">Amount Disbursed (INR)</td>
                <td class="style-center">Loan Disbursed (#)</td>
                <td class="style-center">Amount Disbursed (INR)</td>
                <td class="style-center">Loan Disbursed (#)</td>
                <td class="style-center">Amount Disbursed (INR)</td>
                <td class="style-center">Loan Disbursed (#)</td>
                <td class="style-center">Amount Disbursed (INR)</td>
            </tr>


            <tr>
                <td>Very Poor & Vulnerable</td>
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
            <tr>
                <td>Poor</td>
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
            <tr>
                <td>Medium Poor</td>
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
            <tr>
                <td>Rich</td>
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
            <tr>
                <td id="grey">Total</td>
                <td id="grey">
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"> </td>
                <td id="grey"></td>
                <td id="grey"></td>
        </table>
        </div>

        <div>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">

                <tr>
                    <th id="white" colspan=6>No. Of HHs Benefited From All Loans During Last 12 Months</th>
                </tr>
                <tr>
                    <td id="grey" colspan=3> Total HHs</td>
                    <td colspan=3>0</td>
                </tr>
                <tr>
                    <th class="style6" rowspan=2>Category</th>
                    <th class="style6"rowspan=2>SHG member HHs</th>
                    <th class="style6" rowspan=2>Internal Loans</th>
                    <th colspan=2 class="style6">External Loans</th>
                    <th rowspan=2>Other Loans</th>
                </tr>
                <tr>
                    <th class="style6">Federation</th>
                    <th class="style6">Bank</th>

                <tr>
                    <td>Very Poor & Vulnerable</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr>
                    <td>Poor</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr>
                    <td>Medium Poor</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr>
                    <td>Rich</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr>
                    <td id="grey">Total</td>
                    <td id="grey">
                    <td id="grey"></td>
                    <td id="grey"></td>
                    <td id="grey"></td>
                    <td id="grey"></td>
            </table>
        </div>

        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">

            <tr>
                <th colspan=2 style="width:70%">No of poor and most poor in Leadership position</th>
                <td style="width:30%">Answer</td>
            </tr>
        </table>

        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">

            <tr>
                <th colspan=4> Special Products For the Poor/Vulnerable
            </tr>
            <tr>
                <td>Special Products for the poor/vulnerable</td>
                <td>Yes</td>
                <td>No of members benefited from it during last 12 months</td>
                <td>30</td>
            </tr>
            <tr>
                <td>Name of Product</td>
                <td>Special loan product</td>
                <td>Any impact/result</td>
                </td>
                <td>Answer</td>
            </tr>
        </table>

        <h2><u>EFFICIENCY</u></h2>


        <div class=table-container>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th colspan=2> Integrated Member Plan
                </tr>
                <tr>
                    <td>Integrated member Plan</td>
                    <td>Yes or No</td>
                </tr>
                <tr>
                    <td>Date of last report</td>
                    <td>MMM DD, YYYY</td>
                </tr>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th colspan=2> Income and Expenses During Last 12 Months
                </tr>
                <tr>
                    <td>Income from all sources</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>No of Leadership Poor</td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <td>Is it covering its operational costs</td>
                    <td>N/A</td>
                </tr>
            </table>
        </div>
        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th id="white" colspan=5>Training Details
            </tr>
            <tr>
                <th style="width:20%">Name of training</th>
                <th style="width:20%">Duration (days)</th>
                <th style="width:20%">Date</th>
                <th style="width:20%">Training Recipient</th>
                <th style="width:20%">Name of Trainer</th>
            </tr>
            <tr>
                <td>Answer here</td>
                <td>3</td>
                <td>"MMM DD, YYYY"</td>
                <td>answer here </td>
                <td>answer here </td>
            </tr>

        </table>
        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th id="white" colspan=4>Book-Keeper Training in last 12 months
            </tr>
            <tr>
                <th style="width:25%">Name of training</th>
                <th style="width:25%">Date of Training</th>
                <th style="width:25%">Duration in Days </th>
                <th style="width:25%">Bookkeeper Trained</th>
            </tr>
            <tr>
                <td>Answer here</td>
                <td>3</td>
                <td>MMM DD, YYYY</td>
                <td>answer here </td>
            </tr>
        </table>

        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th colspan=4> Approval Process
            </tr>
            <tr>
                <td>Days taken to approve loan</td>
                <td>20</td>
                <td>No of days from approval to cash in hand</td>
                <td>30</td>
            </tr>
        </table>

        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th style="width:50%"colspan=2> Monthly Report Submitted (Date of last submitted report)</th>
                <td style="width:25%">Yes or No</td>
                <td style="width:25%">MMM DD, YYYY</td>
            </tr>
        </table>


        <h2><u>CREDIT HISTORY</u></h2>

        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th colspan=4> Interest Rate Type
            </tr>
            <tr>
                <td>Interest rate type</td>
                <td>Answer here</td>
                <td>Interest rate charged %</td>
                <td>9%</td>
            </tr>
        </table>

        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">

            <tr>
                <th id="white" colspan=12>Cumulative No of Loans and Amounts disbursed During last 3 years</th>
            </tr>
            <tr>
                <th rowspan=3 class="style-center">Category</th>
                <th rowspan=2 colspan=2 class="style-center">Internal Loans</th>
                <th colspan=4 class="style-center">External Loans</th>
                <th rowspan=2 colspan=2 class="style-center">Other Loans</th>
                <th rowspan=2 colspan=2 class="style-center">Total</th>
            </tr>
            <tr>
                <th colspan=2 class="style-center">Federation</th>
                <th colspan=2 class="style-center">Bank</th>
            </tr>
            <tr>
                <td class="style-center">Loan Disbursed (#)</td>
                <td class="style-center">Amount Disbursed (INR)</td>
                <td class="style-center">Loan Disbursed (#)</td>
                <td class="style-center">Amount Disbursed (INR)</td>
                <td class="style-center">Loan Disbursed (#)</td>
                <td class="style-center">Amount Disbursed (INR)</td>
                <td class="style-center">Loan Disbursed (#)</td>
                <td class="style-center">Amount Disbursed (INR)</td>
                <td class="style-center">Loan Disbursed (#)</td>
                <td class="style-center">Amount Disbursed (INR)</td>
            </tr>
            <tr>
                <td>Poor</td>
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
            <tr>
                <td>Medium Poor</td>
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
            <tr>
                <td>Rich</td>
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
            <tr>
                <td id="grey">Total</td>
                <td id="grey">
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
        </table>


        <div class=table-container>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th id="white" colspan=3> Cumulative Interest Income Generated by SHG </th>
                </tr>
                <tr>
                    <th class="style-center">S.No.</th>
                    <th class="style-center">Institution</th>
                    <th class="style-center">Amount (INR)</th>
                <tr>
                <tr>
                    <td>1</td>
                    <td class="style-center">Internal</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="style-center">Federation</td>
                    <td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="style-center">Bank</td>
                    <td></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td class="style-center">Others</td>
                    <td></td>
                </tr>
                <tr>
                    <td id="grey"colspan=2 class="style-center">Total</td>
                    <td id="grey"></td>
                </tr>
            </table>


            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th id="white"colspan=6> Total No Of Member HHs Benefitted From All Loans During Last 3 years
                    </th>
                </tr>
                <tr>
                    <th class="style-center">Category</th>
                    <th class="style-center">SHG member HHs</th>
                    <th colspan=4 class="style-center">Received Loans</th>
                <tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="style-center">Internal</td>
                    <td class="style-center">Federation</td>
                    <td class="style-center">Bank</td>
                    <td class="style-center">Other</td>
                </tr>
                <tr>
                    <td>Very Poor & Vulnerable</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Poor</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Medium Poor</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Rich</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td id="grey">Total</td>
                    <td id="grey"></td>
                    <td id="grey"></td>
                    <td id="grey"></td>
                    <td id="grey"></td>
                    <td id="grey"></td>
                </tr>
            </table>
        </div>


        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th id="white"colspan=8> Demand Collection Balance (DCB) For repayment and Current Loan Outstanding
                </th>
            </tr>
            <tr>
                <th colspan=8>Total Loan Portfolio </th>
            <tr>
            <tr>
                <th>S. No.</th>
                <th>DCB</th>
                <th class="style-centre">Internal Loan</th>
                <th class="style-centre"> Cluster Loan</th>
                <th class="style-centre"> Federation Loan</th>
                <th class="style-centre">Bank Loan</th>
                <th class="style-centre">Other Loans</th>
                <th class="style-centre"> Total Loan Portfolio</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Total Loan Amount Given (INR)</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Total Demand upto last month for active loans (INR)</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Actual Amount Paid upto last month (INR)</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Overdue Amount (INR)</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Outstanding amount for active loans (INR)</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Repayment Ratio %</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tr>
        </table>


        <div class=table-container>
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <tr>
                    <th id="white"colspan=4> Loan Default </th>
                </tr>
                <tr>
                    <th>S.No.</th>
                    <th>Institution</th>
                    <th>No of Members</th>
                    <th>No of Loans</th>
                <tr>
                <tr>
                    <td>1</td>
                    <td class="style-center">Internal</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="style-center">Cluster</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="style-center">Federation</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td class="style-center">Bank</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td class="style-center">Others</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td id="grey"colspan=3>Total</td>
                    <td id="grey"></td>
                </tr>
            </table>

            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th id="white"colspan=3>PAR Status - 3 Months Overdue</th>
                </tr>
                <tr>
                    <th>S.No.</th>
                    <th>Loan Type</th>
                    <th>Amount (INR)</th>
                <tr>
                <tr>
                    <td>1</td>
                    <td>Internal</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>External</td>
                    <td></td>
                </tr>
            </table>
        </div>


        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th id="white" colspan=6> Purpose of External Loans During Last 12 Months </th>
            </tr>
            <tr>
                <th>S.No.</th>
                <th>Purpose</th>
                <th>Bank</th>
                <th>Federation</th>
                <th>Others</th>
                <th>Total</th>
            <tr>
            <tr>
                <td>1</td>
                <td>Productive</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Consumption</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Debt Swapping</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Actual Amount Paid upto last month (INR)</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Other</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Outstanding amount for active loans (INR)</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td id="grey"colspan=2>Total</td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
                <td id="grey"></td>
            </tr>
        </table>


        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th colspan=3> Average Loan Number And Amount During Last 12 Months</th>
                <td id="grey">333.33</td>
            </tr>
            <tr>
                <th colspan=4> Minimum and Maximum Loan Amounts During Last 12 Months</th>
            </tr>
            <tr>
                <td id="grey">Maximum Amount (INR)</td>
                <td>40000</td>
                <td id="grey">Minimum Amount (INR)</td>
                <td>2000</td>
            </tr>
            <tr>
                <th colspan=3> Members taken more than one Loan During Last 3 Years</th>
                <td id="grey">25</td>
            </tr>
        </table>


        <h2><u>SAVINGS</u></h2>


        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th id="white" colspan=4> Savings Details </th>
            </tr>
            <tr>
                <th>S.No.</th>
                <th>Savings Details</th>
                <th>Compulsory</th>
                <th>Voluntary</th>
            <tr>
            <tr>
                <td>1</td>
                <td>Date Savings started</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Amount of Savings per month(INR)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>No of Members saved during last 12 months</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Cumulative Savings to date since inception (INR)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Average Amount saved during last 12 months (INR)</td>
                <td></td>
                <td>
                </td>
            </tr>
        </table>


        <div class=table-container>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th colspan=2> Interest Paid To Members</th>
                </tr>
                <tr>
                    <td>Interest Paid to members </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Savings Rate (%) </td>
                    <td></td>
                </tr>
            </table>


            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <tr>
                    <th colspan=2> Are Savings Distributed To Members</th>
                </tr>
                <tr>
                    <td>Savings distributed to members</td>
                    <td>Yes or No</td>
                </tr>
                <tr>
                    <td>Date of last distribution</td>
                    <td>MMM DD, YYYY</td>
                </tr>
            </table>
        </div>


        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th colspan=2>Loan Security Fund (LSF)</th>
                <td id="grey"colspan=2>Yes or No</td>
            </tr>
            <tr>
                <td>No of Members contribute by LSF</td>
                <td></td>
                <td>No of Members benefitted by LSF</td>
                <td></td>
            </tr>
        </table>


        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th id="white" colspan=3> Savings Increasing Trend</th>
            </tr>
            <tr>
                <th>Trend</th>
                <th>Compulsory</th>
                <th>Voluntary</th>
            <tr>
            <tr>
                <td>Per Member Average Savings during previous year (before 12 months) ( INR)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Per member average savings during last 12 months (INR)</td>
                <td></td>
                <td></td>
            </tr>
        </table>


        <h2><u>CHALLENGES & ACTION PLAN</u></h2>
        <h4>
            <li>Challenge 1
        </h4>
        <h4>
            <li>Challenge 2
        </h4>
        <h4>
            <li>Challenge 3
        </h4>


        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th colspan=5>Action Plan To Address The Challenges</th>
            </tr>
            <tr>
                <th>S.No.</th>
                <th>Action Plan</th>
                <th>Challenge 1</th>
                <th>Challenge 2</th>
                <th>Challenge 3</th>
            <tr>
            <tr>
                <td>1</td>
                <td>Describe Action</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Person Responsible</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Completion Date</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Support needed from project office</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td>What kind of support?</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>


        <h2><u>OBSERVATIONS</u></h2>


        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th> S. No. </th>
                <th> Question </th>
                <th> Answer </th>
            </tr>
            <tr>
                <td>1</td>
                <td>Who attended the meeting?</td>
                <td>Chair, Secretary, Treasure, Others</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Did members understand the purpose of the meeting?</td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>What was quality of Discussion? Did everyone participate?</td>
                <td></td>
            </tr>
            <tr>
                <td>4a</td>
                <td>Were group members aware of their rules and norms? Did they understand vision of their group?</td>
                <td></td>
            </tr>
            <tr>
                <td>4b</td>
                <td>Do they understand benefits of being part of the group? </td>
                <td></td>
            </tr>
            <tr>
                <td>5a</td>
                <td>Important practices followed by the group. Do they have a set of important practices for repayment
                    and savings?</td>
                <td></td>
            </tr>
            <tr>
                <td>5b</td>
                <td>What are those practices?</td>
                <td></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Does this group include members who are the most poor and vulnerable, and if yes, what is their
                    policy to help them?</td>
                <td></td>
            </tr>
            <tr>
                <td>7a</td>
                <td>Are books of account managed by the bookkeeper only or are other office bearers aware of their
                    financial information?</td>
                <td></td>
            </tr>
            <tr>
                <td>7b</td>
                <td>Are all members aware of their savings, loans and group financial information?</td>
                <td></td>
            </tr>
            <tr>
                <td>8</td>
                <td>Are there any unique features of this group. Explain</td>
                <td></td>
            </tr>
        </table>


        <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
            <tr>
                <th> Summary of important 3- 5 highlights (positive and improvement points) about this Federation</th>
            </tr>
            <tr>
                <td>Point 1 answer here</td>
            </tr>
            <tr>
                <td>Point 2 answer here</td>
            </tr>
            <tr>
                <td>Point 3 answer here</td>
            </tr>
        </table>
    </body>

</html>
