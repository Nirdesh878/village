<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Details </title>
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets\pages\advance-elements\css\bootstrap-datetimepicker.css') }}">
<!-- Date-range picker css  -->
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\bootstrap-daterangepicker\css\daterangepicker.css') }}">

<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets\pages\data-table\css\buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\fullcalendar\css\fullcalendar.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components\fullcalendar\css\fullcalendar.print.css') }}" media='print'>

<script type="text/javascript" src="{{ asset('bower_components\jquery\js\jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components\jquery-ui\js\jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets\js\bootbox.js') }}"></script>

<link rel="stylesheet" href="{{ asset('bower_components\select2\css\select2.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" />
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
    .row-new {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    body {
        background-color: white;
    }

    .oval {
        width: 261px;
        height: 130px;
        background: red;
        border-radius: 130px / 65px;
    }

    .bar {
        width: 100%;
        height: 20px;
        margin-bottom: 5px;
    }

    .breakpoint {
        position: absolute;
        height: 100%;
        border-right: 2px dashed black;
    }

    .bar-chart {
        width: 500px;
        height: 30px;
        background-color: white;
        position: relative;
    }

    .upper-bar {
        width: 80%;
        height: 100%;
        background-color: green;
    }

    .lower-bar {
        width: 100%;
        height: 100%;
        background-color: red;
    }

    .chart-container {
        position: relative;
        width: 300px;
        height: 300px;
    }

    .chart-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-family: Arial, sans-serif;
        font-size: 20px;
        font-weight: bold;
        color: black;
    }

    .chart-container1 {
        position: relative;
        width: 300px;
        height: 300px;
    }

    .chart-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-family: Arial, sans-serif;
        font-size: 20px;
        font-weight: bold;
        color: black;
    }

    .family {
        text-align: center;
        margin: 0;
        padding: 9% 0;
        font-size: 24px;
        font-weight: bold;
    }

    .school {
        padding-left: 50px;
        padding-top: 10px;
    }

    canvas {
        display: block;
        margin: 0 auto;
    }

    .land {
        font-size: 25px;
        padding-left: 100px;
    }

    .goal {
        font-size: 25px;
        padding-left: 100px;
    }

    .house {
        font-size: 25px;
        padding-left: 100px;
    }

    .column {
        float: left;
        width: 33.33%;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .round {
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
        padding: .60rem;

    }

    .table td th {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;

    }



    .table-primary,
    .table-primary>td,
    .table-primary> {
        background-color: #D79477;
        color: black;
        font-size: 25px;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid white;
        background-color: #eeeeee;
    }

    .tdc {
        text-align: center;
    }

    .page-break {
        page-break-before: always;
    }

    th {
        text-align: left;
    }

    .row-news {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
        padding: 0;
    }

    .row-news .col-md-4 {
        padding: 0 15px;
        box-sizing: border-box;
    }

    .row-news .col-md-4 .table-responsive {
        height: 200px;
    }
</style>


{{-- page Body start --}}

<body class="antialiased container mt-5">
    <div class="bar-wrp-m">
        <button class="btn btn-sm getPDFbtn" onclick="getPDF()">GET PDF</button>
    </div>
    {{-- <div style="text-align: left;">
        <img src="{{ asset('assets\images\icons\logo.jpg') }}" alt="Logo"
    style="width: 200px; height: auto; display: inline-block;margin:auto 10px">
    </div> --}}
    <div class="canvas_all_pdf">
        <div class="row ">
            <div class="column" style="width: 660px;margin-left: 228px;position: relative;
            left: 94px;">
                <h1 style="font-size: 30px">Family Profile ({{ $family->uin }})</h1>
            </div>
            <div class="column">
                <div class="oval" style="position: relative;left: 126px;top: 26px;background-color:{{ $grdcolor }}">
                    <p class="family" style="text-transform:capitalize;">Family Wealth <br> Ranking <br>
                        @php
                            $WealthData = getMstCommonData(7,$family_profile[0]->fp_wealth_rank ?? null);
                        @endphp
                        {{ $WealthData[0]->common_values ?? 'N/A' }}
                    </p>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <td colspan="5" style="border: none;font-size:32px;font-weight:bold;text-decoration: underline;text-align:center;">
                            BASIC INFORMATION
                        </td>
                    </tr>
                </thead>
            </table>
            {{-- Name and other details --}}
            <table>
                <thead>
                    <tr>
                        <td colspan="5" style="border: none;font-size:25px;font-weight:bold;">NAME AND OTHER DETAILS
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477;text-align: left;font-size: 20px;" colspan="2">Member
                            Details</td>
                        <td style="background-color:#D79477;text-align: left;font-size: 20px;" colspan="2">Location
                            Details</td>
                    </tr>
                </thead>
                <thead>
                    <tr class="table-primary">
                        <th width="25%">UIN</th>
                        <td width="25%">{{ $family->uin }}</td>
                        <th width="25%"> Village</th>
                        <td width="25%">{{ $family_profile[0]->fp_village }}</td>
                    </tr>
                    <tr>

                        <th width="25%">Member Name</th>
                        <td width="25%">{{ $family_profile[0]->fp_member_name }}</td>
                        <th width="25%"> Name of SHG</th>
                        <td width="25%">{{ $shg_profile[0]->shgName }}</td>
                    </tr>
                    <tr>

                        <th width="25%">Gender</th>
                        @php
                            $GenderData = getMstCommonData(1,$family_profile[0]->fp_gender  ?? null);
                        @endphp
                        <td>{{ $GenderData[0]->common_values ?? 'N/A' }}</td>
                        <th width="25%"> Fedeartion</th>
                        <td width="25%">{{ $fed_profile[0]->name_of_federation }}</td>
                    </tr>

                    <tr>
                        <th width="25%">Age</th>
                        <td width="25%">{{ checkna($family_profile[0]->fp_age) }}</td>
                        <th width="25%">Cluster/Habitation Fedeartion</th>
                        <td width="25%">
                            {{ !empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th width="25%">Spouse Name</th>
                        <td width="25%">{{ checkna($family_profile[0]->fp_spouse_name) }}</td>
                        <th width="25%">Block</th>
                        <td width="25%">{{ checkna($family_profile[0]->fp_block) }}
                        </td>
                    </tr>
                    <tr>

                        <th width="25%"> Aadhar Number </th>
                        <td width="25%">{{ checkna(aadhar($family_profile[0]->fp_aadhar_no)) }}</td>
                        <th width="25%">District</th>
                        <td width="25%">{{ checkna($family_profile[0]->fp_district) }}</td>
                    </tr>

                    <tr>
                        <th width="25%">Pan</th>
                        <td width="25%">{{ checkna(pan($family_profile[0]->fp_pan)) }}</td>
                        <th width="25%">State</th>
                        <td width="25%">{{ checkna($family_profile[0]->fp_state) }}</td>
                    </tr>
                    <tr>
                        <th width="25%">Contact Number</th>
                        <td width="25%">{{ checkna($family_profile[0]->fp_contact_no) }}</td>
                        <th width="25%">Country</th>
                        <td width="25%">{{ $family_profile[0]->fp_country }}</td>
                    </tr>
                    <tr>

                        <th width="25%">Female Headed</th>
                        <td width="25%">
                            @php
                        $FemaleHeadedData = getMstCommonData(3,$family_profile[0]->fp_female_headed ?? null);
                    @endphp
                    {{ $FemaleHeadedData[0]->common_values ?? 'N/A' }}
                        </td>
                        <th>Caste</th>
                        @php
                            $CasteData = getMstCommonData(2,$family_profile[0]->fp_caste ?? null);
                        @endphp
                        <td>{{ $CasteData[0]->common_values ?? 'N/A' }}</td>
                    </tr>
                </thead>

            </table>
            <br>
            {{-- Bank details --}}
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;border:2px solid white">
                        <td style="border:1px solid white;background-color:#D79477;">Bank</td>
                        <td style="border:1px solid white;background-color:#D79477;">Account</td>
                        <td style="border:1px solid white;background-color:#D79477;">Account Number</td>
                        <td style="border:1px solid white;background-color:#D79477;">Account Holder</td>
                        <td style="border:1px solid white;background-color:#D79477;width:30%">Branch</td>

                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align: center;background-color: #eeeeee;">
                        <td style="border:1px solid white">{{ checkna($family_profile[0]->fp_bank) }}</td>
                        <td style="border:1px solid white">{{ checkna($family_profile[0]->fp_bank_account) }}</td>
                        <td style="border:1px solid white">{{ account($family_profile[0]->fp_account) }}</td>
                        <td style="border:1px solid white">{{ checkna($family_profile[0]->fp_account_holder) }}</td>
                        <td style="border:1px solid white">{{ checkna($family_profile[0]->fp_bank_branch) }}</td>
                    </tr>


            </table>
            <br>
            {{-- Family members  --}}
            <table>
                <thead>
                    <tr>
                        <td colspan="5" style="border: none;font-size:25px;font-weight:bold;">FAMILY MEMBERS</td>
                    </tr>
                </thead>
            </table>

            <table class="table table-stripped table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;border:2px solid white">
                        <td style="border:1px solid white;width:25%;background-color:#D79477;">Total</td>
                        <td style="border:1px solid white;width:25%;background-color:#D79477;">SHG Member & Spouse</td>
                        <td style="border:1px solid white;width:25%;background-color:#D79477;">Children</td>
                        <td style="border:1px solid white;width:25%;background-color:#D79477;">Others</td>
                    </tr>
                </thead>
                <thead>
                    <tr style="text-align: center;background-color: #eeeeee;">
                        <td style="border:1px solid white">{{ (int) (int) $family_profile[0]->fp_family_mambers_no }}
                        </td>
                        <td style="border:1px solid white">{{ (int) $family_profile[0]->shg_member_spouse }}</td>
                        <td style="border:1px solid white">{{ (int) $family_profile[0]->fp_children_no }}</td>
                        <td style="border:1px solid white">{{ (int) $family_profile[0]->fp_others_no }}</td>

                    </tr>

                </thead>

            </table>


            {{-- family member info --}}
            <table>
                <thead>
                    <tr>
                        <td colspan="5" style="border: none;font-size:25px;font-weight:bold;">FAMILY MEMBERS
                            INFORMATION</td>
                    </tr>
                </thead>
            </table>

            <table class="table table-stripped table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;border:2px solid white">
                        <td style="border:1px solid white;background-color:#D79477;width:20%;">Name</td>
                        <td style="border:1px solid white;background-color:#D79477;width:20%;">Age</td>
                        <td style="border:1px solid white;background-color:#D79477;width:20%;">Gender</td>
                        <td style="border:1px solid white;background-color:#D79477;width:20%;">Relation</td>
                        <td style="border:1px solid white;background-color:#D79477;width:20%;">Education</td>

                    </tr>
                </thead>
                <thead>
                    @foreach ($family_member_info as $res)
                    @php
                        $MGenderData = getMstCommonData(1,$res->gender  ?? null);
                    @endphp
                    @php
                        $MRelationData = getMstCommonData(5,$res->relation  ?? null);
                    @endphp
                    @php
                        $MeducationData = getMstCommonData(6,$res->education  ?? null);
                    @endphp
                    <tr style="text-align: center;background-color: #eeeeee;">
                        <td style="border:1px solid white;text-align:left;">{{ $res->name }}</td>
                        <td style="border:1px solid white">{{ $res->age }}</td>
                        <td style="border:1px solid white">{{ $MGenderData[0]->common_values ?? 'N/A' }}</td>
                        <td style="border:1px solid white">{{ $MRelationData[0]->common_values ?? 'N/A' }}</td>
                        <td style="border:1px solid white">{{ $MeducationData[0]->common_values ?? 'N/A' }}</td>
                    </tr>
                    @endforeach

                </thead>

            </table>
            <br>
            {{-- Children profile --}}
            <div class="row" style=" display:flex;">
                <div class="col-sm-6">
                    <div style="margin-right: 15px;right:300px;height:200px;border-radius: 90px;background-color: #ebe3e3;">
                        <div class="school">

                            <p style="font-weight:bold;font-size:20px;"> CHILDREN PROFILE Total :
                                {{ (int) $family_profile[0]->fp_total_children }}
                            </p>
                            <ul style="margin-left:28px;list-style-type: disc;">
                                @if ($family_profile[0]->non_school_children_no > 0)
                                <li><b>Non-School going :
                                        {{ (int) $family_profile[0]->non_school_children_no }}</b>
                                </li>
                                @else
                                <li>Non-School going : {{ (int) $family_profile[0]->non_school_children_no }}</li>
                                @endif

                                @if ($family_profile[0]->fp_children_no_in_primary_school > 0)
                                <li><b>Primary school going children :
                                        {{ (int) $family_profile[0]->fp_children_no_in_primary_school }}</b></li>
                                @else
                                <li>Primary school going children :
                                    {{ (int) $family_profile[0]->fp_children_no_in_primary_school }}
                                </li>
                                @endif

                                @if ($family_profile[0]->fp_children_no_in_secondary_higher > 0)
                                <li><b>Higher school going children
                                        : {{ (int) $family_profile[0]->fp_children_no_in_secondary_higher }}</b>
                                </li>
                                @else
                                <li>Higher school going children
                                    : {{ (int) $family_profile[0]->fp_children_no_in_secondary_higher }}</li>
                                @endif

                                @if ($family_profile[0]->fp_children_no_in_college > 0)
                                <li><b>College/Diploma going children
                                        : {{ (int) $family_profile[0]->fp_children_no_in_college }}</b>
                                </li>
                                @else
                                <li>College/Diploma going children
                                    : {{ (int) $family_profile[0]->fp_children_no_in_college }}
                                </li>
                                @endif

                                @if ($family_profile[0]->studiedat_home > 0)
                                <li><b>Studied and at home : {{ (int) $family_profile[0]->studiedat_home }}</b>
                                </li>
                                @else
                                <li>Studied and at home : {{ (int) $family_profile[0]->studiedat_home }}</li>
                                @endif

                                <!-- @if ($family_profile[0]->fp_employed > 0)
                                <li><b>Employed : {{ (int) $family_profile[0]->fp_employed }}</b></li>
                                @else
                                <li>Employed : {{ (int) $family_profile[0]->fp_employed }}</li>
                                @endif -->


                            </ul>
                        </div>

                    </div>
                </div>

                <div class="col-sm-6">
                    <div style="height:200px;border-radius: 90px;background-color: #ebe3e3;">
                        <div class="school" style="">
                            <p style="font-weight:bold;font-size:20px;">FAMILY PROFILE</p>
                            <ul style="margin-left:28px;list-style-type: disc;">

                                @if ($family_profile[0]->fp_family_mamber_over_60year > 0)
                                <li><b>Senior citizens : {{ $family_profile[0]->fp_family_mamber_over_60year }}</b>
                                </li>
                                @else
                                <li>Senior citizens : {{ $family_profile[0]->fp_family_mamber_over_60year }}
                                </li>
                                @endif


                                @if ($family_profile[0]->fp_family_mamber_medication > 0)
                                <li><b>Differently abled members :
                                        {{ $family_profile[0]->fp_family_mamber_medication }}</b>
                                </li>
                                @else
                                <li>Differently abled members :
                                    {{ $family_profile[0]->fp_family_mamber_medication }}
                                </li>
                                @endif

                                @if ($family_profile[0]->fp_vulnerable_people > 0)
                                <li><b>Vulnerable members :
                                        {{ (int) $family_profile[0]->fp_vulnerable_people }}</b>
                                </li>
                                @else
                                <li>Vulnerable members : {{ (int) $family_profile[0]->fp_vulnerable_people }}
                                </li>
                                @endif

                                @if ($family_profile[0]->fp_married_children_live_in > 0)
                                <li><b>Married son/daughter_in_lawliving in the house
                                        :
                                        {{ $family_profile[0]->fp_married_children_live_in != '' ? $family_profile[0]->fp_married_children_live_in : 0 }}</b>
                                </li>
                                @else
                                <li>Married son/daughter_in_lawliving in the house
                                    :
                                    {{ $family_profile[0]->fp_married_children_live_in != '' ? $family_profile[0]->fp_married_children_live_in : 0 }}
                                </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            {{-- Education --}}
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="2" style="background-color:#D79477;">Education</td>
                        <td style="text-align: center;background-color:#D79477;">Male</td>
                        <td style="text-align: center;background-color:#D79477;">Female</td>

                    </tr>
                </thead>
                <thead style="">
                    <tr>
                        <th style=" width:60%;">Family adult members not educated up to primary level</th>
                        @php
                            $NotEducatedData = getMstCommonData(3,$family_profile[0]->family_member_not_educated   ?? null);
                        @endphp
                        <td>{{ $NotEducatedData[0]->common_values ?? 'N/A' }}</td>
                        <td style="width:20%;text-align:center;">
                            {{ $family_profile[0]->family_member_not_educatedMale }}
                        </td>
                        <td style="width:20%;text-align:center;">
                            {{ $family_profile[0]->family_member_not_educatedaFemale }}
                        </td>

                    </tr>

                    <tr>
                        <th style=" width:60%;">Any children or adolescents up to age of 13 away from school or dropped
                            out?
                        </th>
                        @php
                            $childrenData = getMstCommonData(3,$family_profile[0]->children_or_adolescents_upto_age   ?? null);
                        @endphp
                        <td>{{ $childrenData[0]->common_values ?? 'N/A' }}</td>
                        <td style="width:20%;text-align:center;">
                            {{ $family_profile[0]->children_or_adolescents_uptoMale }}
                        </td>
                        <td style="width:20%;text-align:center;">
                            {{ $family_profile[0]->children_or_adolescents_uptoFemale }}
                        </td>

                    </tr>

                </thead>

            </table>
            <br>
            {{-- Family earning --}}
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;width:60%;">Total Family Members Earning
                        </td>
                        <td style="background-color:#ebe3e3;;text-align:left;width:40%;">
                            {{ (int) $family_profile[0]->fp_earning_an_income }}
                        </td>
                    </tr>
                </thead>
            </table>
            <div class="page-break"></div>
            <br>
            <br>
            {{-- NUTRITION AND MORTALITY --}}
            <table class="table table-bordered table-stripped table1 " cellspacing="0" ;style="width:100%">
                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477 ; text-align: center;" colspan="4"> Nutrition
                            and Mortality</td>

                        <td style="border:none;width:2%;background-color:white;"></td>
                        <td style="background-color:#D79477 ; text-align: center;width:40%" colspan="2">Standard of
                            living
                        </td>
                    </tr>
                </thead>
                <thead>
                    <tr style="text-align: center">
                        <th>Family member have access to all three <br>meals on a daily basis?</th>
                        @php
                            $NutritionMoralityData = getMstCommonData(3,$family_profile[0]->aNutritionMortality   ?? null);
                        @endphp
                        <td colspan="3">{{ $NutritionMoralityData[0]->common_values ?? 'N/A' }}</td>

                        <td style="border:none;width:2%;background-color:white;"></td>
                        <th>Sanitation
                        </th>
                        @php
                            $SanitizationData = getMstCommonData(8,$family_profile[0]->sanitation   ?? null);
                        @endphp 
                        <td>{{ $SanitizationData[0]->common_values ?? 'N/A' }}</td>
                    </tr>
                    <tr style="text-align: center">
                        <td colspan="2"></td>
                        <td style="background-color:#D79477 ; text-align: center;width:15%">Male</td>
                        <td style="background-color:#D79477 ; text-align: center;width:15%">Female</td>
                        <td style="border:none;width:2%;background-color:white;"></td>
                        <th>Electricity
                        </th>
                        @php
                            $ElectricityData = getMstCommonData(3,$family_profile[0]->sElectricity   ?? null);
                        @endphp
                        <td>{{ $ElectricityData[0]->common_values ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <th>Does any member suffer due <br>
                            malnutrition?
                        </th>
                        @php
                            $bNutritionMoralityData = getMstCommonData(3,$family_profile[0]->bNutritionMortality   ?? null);
                        @endphp
                        <td width="5%">{{ $bNutritionMoralityData[0]->common_values ?? 'N/A' }}</td>
                        <td>{{ $family_profile[0]->bNutritionMortalityMale }}</td>
                        <td>{{ $family_profile[0]->bNutritionMortalityFeMale }}</td>
                        <td style="border:none;width:2%;background-color:white;"></td>
                        <th>Drinking Water
                        </th>
                        @php
                            $DrinkingWaterData = getMstCommonData(9,$family_profile[0]->sDrinkingWater   ?? null);
                        @endphp
                        <td>{{ $DrinkingWaterData[0]->common_values ?? 'N/A' }}
                        </td>

                    </tr>
                    <tr style="text-align: center">
                        <th>Does any one of the
                            children/adolescents or adults appear
                            to be undernourished (stunted, wasted,
                            under-weight)?
                        </th>
                        @php
                            $cNutritionMoralityData = getMstCommonData(3,$family_profile[0]->cNutritionMortality   ?? null);
                        @endphp
                        <td>{{ $cNutritionMoralityData[0]->common_values ?? 'N/A' }}</td>
                        <td>{{ $family_profile[0]->cNutritionMortalityMale }}</td>
                        <td>{{ $family_profile[0]->cNutritionMortalityFeMale }}</td>
                        <td style="border:none;width:2%;background-color:white;"></td>
                        <th rowspan="2">Cooking
                            Fuel
                        </th>
                        @php
                            $CookingFuelData = getMstCommonData(10,$family_profile[0]->sCookingFuel   ?? null);
                        @endphp 
                        <td rowspan="2">{{ $CookingFuelData[0]->common_values ?? 'N/A' }}</td>

                    </tr>

                    <tr style="text-align: center">
                        <th>Have any children or adolescents died
                            below age 18?</th>
                            @php
                                $dNutritionMoralityData = getMstCommonData(3,$family_profile[0]->dNutritionMortality   ?? null);
                            @endphp
                        <td>{{ $dNutritionMoralityData[0]->common_values ?? 'N/A' }}</td>
                        <td>{{ $family_profile[0]->dNutritionMortalityMale }}</td>
                        <td>{{ $family_profile[0]->dNutritionMortalityFeMale }}</td>

                    </tr>

                </thead>

            </table>
            <br>

            {{-- Health status --}}
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td colspan="2" style="background-color:#D79477;text-align:left;width:75%">Health Status
                        </td>
                        @if ($family_profile[0]->sHealthIssues == 'Yes')
                        <td style="background-color:#D79477;width:12.5%">Male</td>
                        <td style="background-color:#D79477;width:12.5%">Female</td>
                        @endif

                    </tr>
                </thead>
                <thead style="">
                    <tr style="text-align: center;">
                        <th style=" width:60%">Any member with an illness in the last 2 years?</th>
                        <td>{{ $family_profile[0]->sHealthIssues }}</td>
                        @if ($family_profile[0]->sHealthIssues == 'Yes')
                        <td>{{ $family_profile[0]->sHealthIssuesMale }}</td>
                        <td>{{ $family_profile[0]->sHealthIssuesFeMale }}</td>
                        @endif
                    </tr>


                </thead>

            </table>
            <br>
            {{-- Family migration --}}
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;width:30%">Family Migration ( in the last 2
                            years)
                        </td>
                        @php
                    $MigratedData = getMstCommonData(12,$family_profile[0]->fp_family_migrated   ?? null);
                @endphp
                <td style="background-color:#ebe3e3;text-align:left;width:5%">{{ $MigratedData[0]->common_values ?? 'N/A' }}</td>
                        @if ($family_profile[0]->fp_family_migrated == 2)
                        <td style="text-align:left;width:65%">
                            {{ checkna($family_profile[0]->fp_family_reason_of_migration) }}
                        </td>
                        @endif

                    </tr>
                </thead>


            </table>
            <br>
            <br>
            <br>
            <br>
            <br>

            {{-- Family Govt. Program --}}
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;width:40%" colspan="2">Are you aware of
                            Govt. Livelihood Programs?
                        </td>
                        <td style="background-color:#ebe3e3;;text-align:left;width:60%">
                            @php
                                $Gov_liveilhoodData = getMstCommonData(3,$family_profile[0]->gov_liveilhood_program   ?? null);
                            @endphp
                        {{ $Gov_liveilhoodData[0]->common_values ?? 'N/A' }}
                        </td>
                    </tr>
                </thead>

                @if ($family_profile[0]->gov_liveilhood_program == 'Yes')
                <tbody>
                    <tr>
                        <td style="text-align:left; background-color:#D79477">Program</td>
                        <td style="text-align:left; background-color:#D79477">Benefits received</td>
                        <td style="text-align:left; background-color:#D79477">Benefits </td>
                    </tr>
                    @foreach ($gov_program as $res)
                    @php
                    $benefis = explode(',', $res->benefit_1);
                    $count = count($benefis);
                    @endphp
                    <tr>
                        <td>{{ $res->program_name }}</td>
                        <td>{{ $res->recived_benefit == 1 ? 'Yes' : 'No' }}
                        </td>
                        <td>
                            @for ($i = 0; $i <= $count - 1; $i++) <ul style="list-style-type:disc;margin-left:15px;">
                                <li>{{ $benefis[$i] }}</li>
                                </ul>
                                @endfor

                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @endif

            </table>
            <br>

            {{-- Family assets --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>FAMILY ASSETS</td>
                    </tr>
                </thead>
            </table>
            {{-- land --}}
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;" colspan="4">Land</td>
                    </tr>
                </thead>
                <thead style="">
                    <tr>
                        <td style="text-align:left;">Land Size</td>
                        <td style="text-align:left;">{{ checkna($assets[0]->fa_land_type) }}</td>
                        <td style="text-align:left;">Land Cultivated by Family</td>
                        <td style="text-align:left;">
                            {{ $assets[0]->fa_land_cultivated != '' ? sprintf('%.1f', $assets[0]->fa_land_cultivated) : '0.0' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:left;">Land owned but cultivated as sharecropping</td>
                        <td style="text-align:left;">
                            {{ $assets[0]->fa_mortagged_how_much_land != '' ? sprintf('%.1f', $assets[0]->fa_mortagged_how_much_land) : '0.0' }}
                        </td>
                        <td style="text-align:left;">Land not owned but cultivated as sharecropping</td>
                        <td style="text-align:left;">
                            {{ $assets[0]->fa_land_not_owned != '' ? $assets[0]->fa_land_not_owned : '0.0' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:left;"><b><u>Total land owned and cultivated by family</u></b></td>
                        <td style="text-align:left;">
                            <b>{{ $assets[0]->fa_total_land_owned != '' ? sprintf('%.2f', $assets[0]->fa_total_land_owned) : '0.0' }}</b>
                        </td>
                        <td style="text-align:left;">Land Mortgaged/ Lost to money Lender</td>
                        <td style="text-align:left;">
                            {{ $assets[0]->fa_land_mortgaged != '' ? $assets[0]->fa_land_mortgaged : 'N/A' }}
                        </td>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <td style="text-align:left;">Date of loss mortgage</td>
                        <td style="text-align:left;">
                            {{ change_date_new($assets[0]->fa_date_of_mortgage) }}
                        </td>
                        <td style="text-align:left;">How much Land? </td>
                        <td style="text-align:left;">
                            {{ $assets[0]->fa_total_land_owned != '' ? sprintf('%.2f', $assets[0]->fa_total_land_owned) : '0.0' }}
                        </td>
                    </tr>


                </thead>

            </table>
            <br>
            <br>
            {{-- housing unit --}}
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;" colspan="6">Housing Unit</td>
                    </tr>
                </thead>
                <thead style="">
                    <tr>
                        <th style="text-align:left;width:16.6%">House Ownership</th>
                        <td style="text-align:left;width:16.6%">{{ checkna($assets[0]->house_ownership) }}</td>
                        <th style="text-align:left;width:16.6%">Type</th>
                        <td style="text-align:left;width:16.6%">{{ checkna($assets[0]->fa_Pacca_Kaccha_house) }}</td>
                        <th style="text-align:left;width:16.6%">Animal Sheds</th>
                        <td style="text-align:left;width:16.6%">{{ checkna($assets[0]->fa_animalsheds) }}</td>
                    </tr>

                </thead>

            </table>
            <br>
            <br>

            <div class="row row-news">
                <div class="col-md-4">
                    <div class="table-responsive">

                        <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 50%; ">
                            <thead>
                                <tr style="text-align: center;background-color:white ;font-size:25px;border:none;font-weight:bold;text-decoration:underline;">
                                    <td colspan="3"> LIVESTOCK</td>
                                </tr>
                            </thead>


                            <thead>
                                <tr class="table-primary">
                                    <td style="background-color:#D79477 ; text-align: center">S.No</td>
                                    <td style="background-color:#D79477 ; text-align: center">Name of Animals
                                    </td>
                                    <td style="background-color:#D79477 ; text-align: center">No. of Animals</td>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @if (!empty($assets_live_stock))
                                @foreach ($assets_live_stock as $row)
                                <tr>
                                    <th style="text-align:center;">{{ $i }}</th>
                                    <th style="text-transform: capitalize;">{{ $row->animal_Types }}</th>
                                    <td style="text-align:center;">
                                        {{ $row->no_of_animals != '' ? $row->no_of_animals : 0 }}
                                    </td>
                                </tr>
                                @php
                                $i++;
                                @endphp
                                @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="table-responsive">

                        <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 50%; ">
                            <thead>
                                <tr style="text-align: center;background-color:white ;font-size:25px;border:none;font-weight:bold;text-decoration:underline;">
                                    <td colspan="3">VEHICLE TYPE</td>
                                </tr>
                            </thead>


                            <thead>
                                <tr class="table-primary">
                                    <td style="background-color:#D79477 ; text-align: center">S.No</td>
                                    <td style="background-color:#D79477 ; text-align: center">Name of Vehicle
                                    </td>
                                    <td style="background-color:#D79477 ; text-align: center">No. of Vehicle</td>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $a = 1;
                                @endphp
                                @if (!empty($assets_vehicle))
                                @foreach ($assets_vehicle as $row)
                                <tr>
                                    <th style="text-align:center;">{{ $a }}</th>
                                    <th style="text-transform: capitalize;">{{ $row->vehicle_Types }}</th>
                                    <td style="text-align:center;">
                                        {{ $row->no_of_vehicle != '' ? $row->no_of_vehicle : 0 }}
                                    </td>
                                </tr>
                                @php
                                $a++;
                                @endphp
                                @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="table-responsive">

                        <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 50%; ">
                            <thead>
                                <tr style="text-align: center;background-color:white ;font-size:25px;border:none;font-weight:bold;text-decoration:underline;">
                                    <td colspan="3">MACHINERY</td>
                                </tr>
                            </thead>


                            <thead>
                                <tr class="table-primary">
                                    <td style="background-color:#D79477 ; text-align: center">S.No</td>
                                    <td style="background-color:#D79477 ; text-align: center">Name of Machinery
                                    </td>
                                    <td style="background-color:#D79477 ; text-align: center">No. of Machinery</td>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $b = 1;
                                @endphp
                                @if (!empty($assets_machinery))
                                @foreach ($assets_machinery as $row)
                                <tr>
                                    <th style="text-align:center;">{{ $b }}</th>
                                    <th style="text-transform: capitalize;">{{ $row->machinery_Types }}</th>
                                    <td style="text-align:center;">
                                        {{ $row->no_of_machinery != '' ? $row->no_of_machinery : 0 }}
                                    </td>
                                </tr>
                                @php
                                $b++;
                                @endphp
                                @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>


            {{-- home equipent --}}
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="8" style="background-color:#D79477;text-align:left;width:100%"> Home
                            Gadgets/Equipment
                        </td>
                    </tr>
                </thead>
                <thead style="">
                    <tr style="text-align: center;">
                        <th style=" height:5%">Color TV</th>
                        <td style="font-weight:bold;font-size:20px;">
                            @if ($assets_gadgets[0]->fa_tvcolor == 1)
                            &#x2713;
                            @else
                            &#x2573;
                            @endif
                        </td>
                        <th style=" height:5%">B&W TV</th>
                        <td style="font-weight:bold;font-size:25px;">
                            @if ($assets_gadgets[0]->fa_tvblackwhite == 1)
                            &#x2713;
                            @else
                            &#x2573;
                            @endif
                        </td>

                        <th style="  height:5%;">Air Conditioner</th>
                        <td style="font-weight:bold;font-size:20px;"">
                            @if ($assets_gadgets[0]->fa_airconditioners == 1)
                                &#x2713;
                            @else
                                &#x2573;
                            @endif
                        </td>
                        <th style=" height:5%;">Coolers</th>
                        <td style="font-weight:bold;font-size:20px;">
                            @if ($assets_gadgets[0]->fa_coolers == 1)
                            &#x2713;
                            @else
                            &#x2573;
                            @endif
                        </td>
                    </tr>
                    <tr style="text-align: center;">
                        <th style="  height:5%;">Sewing Machine</th>
                        <td style="font-weight:bold;font-size:20px;">
                            @if ($assets_gadgets[0]->fa_sewingmachines == 1)
                            &#x2713;
                            @else
                            &#x2573;
                            @endif
                        </td>
                        <th style="  height:5%;"> Smartphone</th>
                        <td style="font-weight:bold;font-size:20px;">
                            @if ($assets_gadgets[0]->fa_smartphone == 1)
                            &#x2713;
                            @else
                            &#x2573;
                            @endif
                        </td>

                        <th style="  height:5%;"> Wet grinder</th>
                        <td style="font-weight:bold;font-size:20px;">
                            @if ($assets_gadgets[0]->wet_grinder == 1)
                            &#x2713;
                            @else
                            &#x2573;
                            @endif
                        </td>
                        <th style="  height:5%;"> Mixi</th>
                        <td style="font-weight:bold;font-size:20px;">
                            @if ($assets_gadgets[0]->mixi == 1)
                            &#x2713;
                            @else
                            &#x2573;
                            @endif
                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <th style="  height:5%;"> Washing Machines</th>
                        <td style="font-weight:bold;font-size:20px;">
                            @if ($assets_gadgets[0]->washing_machines == 1)
                            &#x2713;
                            @else
                            &#x2573;
                            @endif
                        </td>
                        <th style="  height:5%;"> Computer</th>
                        <td style="font-weight:bold;font-size:20px;">
                            @if ($assets_gadgets[0]->computer == 1)
                            &#x2713;
                            @else
                            &#x2573;
                            @endif
                        </td>

                        <th style="  height:5%;"> Refrigerator</th>
                        <td style="font-weight:bold;font-size:20px;">
                            @if ($assets_gadgets[0]->refrigerator == 1)
                            &#x2713;
                            @else
                            &#x2573;
                            @endif
                        </td>
                        <th style="  height:5%;">Other</th>
                        @if ($assets_gadgets[0]->fa_other == 1)
                        <td>{{ $assets_gadgets[0]->fa_other_choice }}</td>
                        @else
                        <td>N/A</td>
                        @endif
                    </tr>

                </thead>

            </table>
            <br>
            {{-- personol items --}}
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="2" style="background-color:#D79477;text-align:left;">Personal Items
                        </td>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <td style=" text-align: left;width:25%;height:10%">Does the family own any
                            jewellery? </td>
                        <td style=" text-align: left;height:10%">{{ checkna($assets[0]->fa_jewelry_yes_no) }}</td>
                    </tr>
                </thead>
            </table>

            <br>
            {{-- jwellery --}}
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="2" style="background-color:#D79477;text-align:center;width:25%">Jewellery</td>
                        <td style="background-color:#D79477;text-align:center;width:15%">Lender Type</td>
                        <td style="background-color:#D79477;text-align:center;width:15%">Amount (INR)</td>
                        <td style="background-color:#D79477;text-align:center;width:15%">Date</td>
                        <td style="background-color:#D79477;text-align:center;width:15%">Interest Rate</td>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <td style=" text-align: left;">Any jewellery pawned to take loan?</td>
                        <td style=" text-align: center;">{{ checkna($assets[0]->jewelry_pawned_take_loan_yesno) }}
                        </td>
                        @if ($assets[0]->jewelry_pawned_take_loan_yesno == 'Yes')
                        <td style="text-align: center;">{{ checkna($assets[0]->jewelry_pawned_lander_type) }}
                        </td>
                        <td style="text-align: center;">{{ checkna($assets[0]->jewelry_pawned_loan_amount) }}
                        </td>
                        <td style="text-align: center;">{{ checkna($assets[0]->jewelry_pawned_loan_when) }}</td>
                        @if ($assets[0]->jewelry_pawned_loan_interest != '')
                        <td style="text-align: center;">{{ $assets[0]->jewelry_pawned_loan_interest }}%</td>
                        @else
                        <td style="text-align: center;">N/A</td>
                        @endif
                        @else
                        <td colspan="4" style="text-align: center">N/A</td>
                        @endif




                    </tr>
                    <tr>
                        <td style=" text-align: left;">Any Jewellery pawned to take loan lost?</td>
                        <td style=" text-align: center;">{{ checkna($assets[0]->jewelry_pawned_lost_yesno) }}</td>
                        @if ($assets[0]->jewelry_pawned_lost_yesno == 'Yes')


                        <td style="text-align: center;">
                            {{ checkna($assets[0]->jewelry_pawned_lander_lost_type) }}
                        </td>
                        <td style="text-align: center;">
                            {{ (int) checkna($assets[0]->jewelry_pawned_loan_lost_amount) }}
                        </td>
                        <td style="text-align: center;">{{ checkna($assets[0]->jewelry_pawned_loan_lost_when) }}
                        </td>

                        @if ($assets[0]->jewelry_pawned_loan_lost_interest != '')
                        <td style="text-align: center;">{{ $assets[0]->jewelry_pawned_loan_lost_interest }}%
                        </td>
                        @else
                        <td style="text-align: center;">N/A</td>
                        @endif
                        @else
                        <td colspan="4" style="text-align: center;">N/A</td>
                        @endif

                    </tr>
                </thead>
            </table>
            <br>
            {{-- other assets --}}
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="2" style="background-color:#D79477;text-align:left;">Others</td>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <td style=" text-align: left;width:50%">Any other asset?</td>
                        <td style="text-align: left;width:50%">{{ checkna($assets[0]->fa_other_assets_A) }}</td>
                    </tr>
                </thead>
            </table>

            {{-- Advance Labour Sold --}}
            <br>
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <td colspan="6" style="background-color:#D79477;text-align:left;">Advance Labour Sold</td>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th style=" text-align: left;width:16.6%;">Family sold/advanced any labor in the last two
                            years?</th>
                        <td style="text-align: left;width:16.6%;">{{ checkna($assets[0]->fa_other_assets_B) }}</td>
                        <th style=" text-align: left;width:16.6%;">Purpose</th>
                        <td style="text-align: left;width:16.6%;">{{ checkna($assets[0]->fa_other_assets_C) }}</td>
                        <th style=" text-align: left;width:16.6%;">No. of labor days advanced or sold</th>
                        <td style="text-align: left;width:16.6%;">{{ checkZero($assets[0]->fa_other_assets_D) }}</td>
                    </tr>


                </thead>
            </table>
            <br>
            {{-- Goals --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>GOALS</td>
                    </tr>
                </thead>
            </table>
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">

                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477;text-align:left;width:10%">S.No.</td>
                        <td style="background-color:#D79477;text-align:left;width:90%">Description</td>
                    </tr>

                </thead>
                <thead>
                    <tr>
                        @php $i=1; @endphp
                        @if (!empty($goals))
                        @foreach ($goals as $row)
                    <tr>
                        <td style="text-align:left;">{{ $i++ }}</td>
                        <td style="text-align:left;">{{ $row->fg_goal }}</td>
                    </tr>
                    @endforeach
                    @endif



                </thead>
            </table>

            {{-- Aggreculture --}}
            <br>
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>AGRICULTURE & RELATED PRODUCTION</td>
                    </tr>
                </thead>
            </table>
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">

                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Type</td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Unit</td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Total Production Current
                            Year
                        </td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Total Consumption Current
                            Year
                        </td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Quantity Sold</td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Price per unit (INR)</td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Total Sale Amount Current
                            Year
                            (INR)
                        </td>
                        <td style="background-color:#D79477;text-align:center;width:12.5%">Total Sale Amount Forecast
                            Next
                            Year
                            (INR)</td>
                    </tr>

                </thead>
                {{-- Agriculture --}}
                <tbody>

                    <tr>
                        <td colspan="8" style="text-align:left;background-color: white;">Agricultural</td>
                    </tr>
                    @php
                    $sum = 0;
                    $sum_a = 0;
                    $sum_an = 0;
                    @endphp
                    @if (!empty($agriculture))

                    @foreach ($agriculture as $data)
                    @php
                    $sum += (float) $data->price_per_unit;
                    $sum_a += (float) $data->total_sale_value;
                    $sum_an += $data->total_next;
                    @endphp

                    <tr class="tdc">
                        <td style="text-align:left;">{{ $data->crop }}</td>
                        <td>{{ $data->production_quantity_type }}</td>
                        <td>{{ $data->production_per_year }}</td>
                        <td>{{ $data->consumption }}</td>
                        <td>{{ $data->sold_in_year }}</td>
                        <td>{{ $data->price_per_unit }}</td>
                        <td>{{ $data->total_sale_value }}</td>
                        <td>{{ $data->total_next != '' ? $data->total_next : 0 }}</td>
                    </tr>
                    @endforeach
                    <tr class="total">
                        <th colspan="5">Sub-Total Agriculture</th>
                        <th class="tdc"></th>
                        <th class="tdc" style="background-color:#c2b5b5;">{{ $sum_a }}</th>
                        <th class="tdc" style="background-color:#c2b5b5;">{{ $sum_an }}</th>
                    </tr>
                    @else
                    <tr class="tdc">
                        <td></td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>

                    </tr>
                    <tr class="total">
                        <th colspan="5">Sub-Total Agriculture</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                    </tr>
                    @endif


                </tbody>


                {{-- Horiculture --}}
                <tbody>

                    <tr>
                        <td colspan="8" style="text-align:left;background-color: white;">Horticulture</td>
                    </tr>
                    @php
                    $sum = 0;
                    $sum_h = 0;
                    $sum_hn = 0;
                    @endphp
                    @if (!empty($horticultural))

                    @foreach ($horticultural as $data)
                    @php
                    $sum += (float) $data->price_per_unit;
                    $sum_h += (float) $data->total_sale_value;
                    $sum_hn += $data->total_next;
                    @endphp

                    <tr class="tdc">
                        <td style="text-align:left;">{{ $data->crop }}</td>
                        <td>{{ $data->production_quantity_type }}</td>
                        <td>{{ $data->production_per_year }}</td>
                        <td>{{ $data->consumption }}</td>
                        <td>{{ $data->sold_in_year }}</td>
                        <td>{{ $data->price_per_unit }}</td>
                        <td>{{ $data->total_sale_value }}</td>
                        <td>{{ $data->total_next != '' ? $data->total_next : 0 }}</td>
                    </tr>
                    @endforeach
                    <tr class="total">
                        <th colspan="5">Sub-Total Horiculture</th>
                        <th class="tdc"></th>
                        <th class="tdc" style="background-color:#c2b5b5;">{{ $sum_h }}</th>
                        <th class="tdc" style="background-color:#c2b5b5;">{{ $sum_hn }}</th>
                    </tr>
                    @else
                    <tr class="tdc">
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                    </tr>
                    <tr class="total">
                        <th colspan="5">Sub-Total Horiculture</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                    </tr>
                    @endif



                </tbody>
                {{-- livelistock --}}
                <tbody>
                    <tr>
                        <td colspan="8" style="text-align:left;background-color: white;">Livestock </td>
                    </tr>
                    @php
                    $sum = 0;
                    $sum_li = 0;
                    $sum_ln = 0;
                    @endphp
                    @if (!empty($live))

                    @foreach ($live as $data)
                    @php
                    $sum += (float) $data->price_per_unit;
                    $sum_li += (float) $data->total_sale_value;
                    $sum_ln += $data->total_next;
                    @endphp

                    <tr class="tdc">

                        <td style="text-align:left;">{{ $data->production_sub_type }}
                            &nbsp;({{ $data->crop }})</td>
                        <td>{{ $data->production_quantity_type }}</td>
                        <td>{{ $data->production_per_year }}</td>
                        <td>{{ $data->consumption }}</td>
                        <td>{{ $data->sold_in_year }}</td>
                        <td>{{ $data->price_per_unit }}</td>
                        <td>{{ $data->total_sale_value }}</td>
                        <td>{{ $data->total_next != '' ? $data->total_next : 0 }}</td>

                    </tr>
                    @endforeach
                    <tr class="total">
                        <th colspan="5">Sub-Total Livestock</th>
                        <th class="tdc"></th>
                        <th class="tdc" style="background-color:#c2b5b5;">{{ $sum_li }}</th>
                        <th class="tdc" style="background-color:#c2b5b5;">{{ $sum_ln }}</th>
                    </tr>
                    @else
                    <tr class="tdc">
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>

                    </tr>
                    <tr class="total">
                        <th colspan="5">Sub-Total Livestock</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                        <th class="tdc">0</th>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="5">Grand Total </th>
                        <td colspan="" class="tdc"></td>
                        <th colspan="" class="tdc" style="background-color:#c2b5b5;">
                            {{ $sum_a + $sum_li + $sum_h }}
                        </th>
                        <th class="tdc" style="background-color:#c2b5b5;">{{ $sum_an + $sum_ln + $sum_hn }}</th>
                    </tr>
                </tbody>
            </table>

            <br>
            {{-- Savings --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>SAVINGS</td>
                    </tr>
                </thead>

            </table>
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr style="text-align: left;background-color:white ;font-size:20px;border:none;font-weight:bold;">
                        <td colspan="6">Type of Savings</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;background-color:#D79477 ;width:15%">Type</td>
                        <td style="text-align:center;background-color:#D79477 ;width:15%">Saving Regulary</td>
                        <td style="text-align:center;background-color:#D79477 ;width:15%">Date Savings Started</td>
                        <td style="text-align:center;background-color:#D79477 ;width:20%">Amount Saved Per Month (INR)
                        </td>
                        <td style="text-align:center;background-color:#D79477 ;width:20%">Saved During Last 12 Months
                            (INR)
                        </td>
                        <td style="text-align:center;background-color:#D79477 ;width:15%">Cumulative Savings (INR)</td>
                    </tr>

                    @if (!empty($savings_source))
                    @php
                    $sum = 0;
                    $sum1 = 0;
                    $sum2 = 0;
                    @endphp
                    @foreach ($savings_source as $row)
                    @php
                    $sum = $sum + (float) $row['s_total_saving'];
                    $sum1 = $sum1 + (float) $row['s_saving_per_month'];
                    $sum2 = $sum2 + (float) $row['s_last_saved_amt'];
                    @endphp
                    <tr>
                        <th style="text-align:left;">{{ $row['s_type'] }}</th>
                        <td style="text-align:left;">{{ $row['s_contribute_regular'] }}</td>
                        <td style="text-align:center;">{{ $row['s_started_from'] }}</td>
                        <td style="text-align:center;">{{ $row['s_saving_per_month'] }}</td>
                        <td style="text-align:center;">{{ $row['s_last_saved_amt'] }}</td>
                        <td style="text-align:center;">{{ $row['s_total_saving'] }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th style="text-align:center;background-color:#c2b5b5;">Total</th>
                        <td style="text-align:center;background-color:#c2b5b5;"></td>
                        <td style="text-align:center;background-color:#c2b5b5;"></td>
                        <th style="text-align:center;background-color:#c2b5b5;">{{ $sum1 }}</th>
                        <th style="text-align:center;background-color:#c2b5b5;">{{ $sum2 }}</th>
                        <th style="text-align:center;background-color:#c2b5b5;">{{ $sum }}</th>
                    </tr>
                    @endif

                </thead>
            </table>

            {{-- passbook --}}
            <br>
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>

                    <tr>
                        <td style="text-align:center;background-color:#D79477 ;font-weight:bold;width:30%">Passbook in
                            Possesion</td>
                        <td style="text-align:center;font-weight:bold;width:20%;">
                            {{ $savings[0]->s_passbook_physically == 1 ? 'Yes' : 'No' }}
                        </td>
                        <td style="text-align:center;background-color:#D79477 ;font-weight:bold;width:30%;">Passbook
                            Updated
                        </td>
                        <td style="text-align:center;font-weight:bold;width:20%;">
                            {{ $savings[0]->s_passbook_updated == 1 ? 'Yes' : 'No' }}
                        </td>
                    </tr>

                </thead>
            </table>
            <br>
            {{-- other savings --}}
            <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr style="text-align: left;background-color:white ;font-size:20px;border:none;font-weight:bold;">
                        <td colspan="6">Other Saving Source</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;background-color:#D79477 ;">Savings Product</td>
                        <td style="text-align:center;background-color:#D79477 ;">Date of Deposit</td>
                        <td style="text-align:center;background-color:#D79477 ;">Deposit Term Period</td>
                        <td style="text-align:center;background-color:#D79477 ;">Interest %</td>
                        <td style="text-align:center;background-color:#D79477 ;">Amount (INR)</td>

                    </tr>
                    @if (!empty($savings_source_other))
                    @php $sum=0; @endphp
                    @foreach ($savings_source_other as $row)
                    @php $sum=$sum+(float)$row->other_amount; @endphp
                    <tr>
                        <td class="tdc" style="text-align:left;">{{ $row->other_loan ?? '' }}</td>
                        <td class="tdc">{{ $row->other_where_fixed_deposit_made ?? '' }}</td>
                        <td class="tdc">
                            {{ change_date_month_name_char(str_replace('/', '-', $row->other_date_of_deposit)) ?? '' }}
                        </td>
                        <td class="tdc">{{ $row->other_interest ?? '' }}</td>
                        <td class="tdc">{{ $row->other_amount ?? '' }}</td>
                    </tr>
                    @endforeach

                    <tr class="total">
                        <td colspan="3"></td>
                        <th style="text-align:center;background-color:#c2b5b5;">Total</th>
                        <th style="text-align:center;background-color:#c2b5b5;">{{ $sum ?? 0 }}</th>
                    </tr>
                    @endif

                </thead>
            </table>
            <br>
            {{-- loan outstandings --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>FAMILY LOAN OUTSTANDING</td>
                    </tr>
                </thead>
                <br>

                <table class="table  table-bordered table-stripped table1 " cellspacing="0">
                    <thead>

                        <tr>
                            <td style="text-align:center;background-color:#D79477 ;width:16%"><b>Loan Type</b></td>
                            <td style="text-align:center;background-color:#D79477 ;width:16%">Principal Amount (INR)
                            </td>
                            <td style="text-align:center;background-color:#D79477 ;width:16%">Total Amount<br>
                                paid in 12<br>
                                months (INR)
                            </td>
                            <td style="text-align:center;background-color:#D79477 ;width:16%">Cumulative<br>
                                Amount paid<br>
                                (INR)
                            </td>
                            <td style="text-align:center;background-color:#D79477 ;width:16%">Overdue<br>
                                Amount (INR)
                            </td>
                            <td style="text-align:center;background-color:#D79477 ;width:16%">Next Year Loan<br>
                                Repayment<br>
                                Commitment (INR)

                            </td>
                        </tr>
                        <tr>
                            {{-- SHG LOAN --}}

                            @php
                                $shg_total = 0;
                                $shg_amount = 0;
                                $shg_overdue = 0;
                                $shg_cumulative = 0;
                                $shg_paid = 0;

                            @endphp
                            @if (!empty($Shg_loan))

                                @foreach ($Shg_loan as $res)
                                    @php
                                        $shg_total = $shg_total + checkZero($res->lo_next_year);
                                        $shg_amount = $shg_amount + checkZero($res->lo_principle_amount);
                                        $shg_overdue = $shg_overdue + checkZero($res->overdue);
                                        $shg_cumulative = $shg_cumulative + checkZero($res->total_paid_interest);
                                        $shg_paid = $shg_paid + checkZero($res->current_year_interest);

                                    @endphp

                        <tr>
                            <td style="text-align:left;">SHG Loan</td>
                            <td class="tdc">{{ $res->lo_principle_amount }}</td>
                            <td class="tdc">{{ $res->current_year_interest }}</td>
                            <td class="tdc">{{ $res->total_paid_interest }}</td>
                            <td class="tdc">{{ $res->overdue }}</td>
                            <td class="tdc">{{ $res->lo_next_year }}</td>
                        </tr>
                        @endforeach



                        @endif
                        </tr>
                        {{-- Money lender loan --}}
                        @php
                            $money_total = 0;
                            $money_amount = 0;
                            $money_overdue = 0;
                            $money_cumulative = 0;
                            $money_paid = 0;
                        @endphp
                        @if (!empty($money_loan))

                            @foreach ($money_loan as $res)
                                @php
                                    $money_total = $money_total + checkZero($res->lo_next_year);
                                    $money_amount = $money_amount + checkZero($res->lo_principle_amount);
                                    $money_overdue = $money_overdue + checkZero($res->overdue);
                                    $money_cumulative = $money_cumulative + checkZero($res->total_paid_interest);
                                    $money_paid = $money_paid + checkZero($res->current_year_interest);

                                @endphp
                                <tr>
                                    <td style="text-align:left;">Money lender loan</td>
                                    <td class="tdc">{{ $res->lo_principle_amount }}</td>
                                    <td class="tdc">{{ $res->current_year_interest }}</td>
                                    <td class="tdc">{{ $res->total_paid_interest }}</td>
                                    <td class="tdc">{{ $res->overdue }}</td>
                                    <td class="tdc">{{ $res->lo_next_year }}</td>
                                </tr>
                            @endforeach


                        @endif

                        {{-- Bank loan --}}
                        @php
                            $bank_total = 0;
                            $bank_amount = 0;
                            $bank_overdue = 0;
                            $bank_cumulative = 0;
                            $bank_paid = 0;
                        @endphp
                        @if (!empty($Bank_loan))

                            @foreach ($Bank_loan as $res)
                                @php
                                    $bank_total = $bank_total + checkZero($res->lo_next_year);
                                    $bank_amount = $bank_amount + checkZero($res->lo_principle_amount);
                                    $bank_overdue = $bank_overdue + checkZero($res->overdue);
                                    $bank_cumulative = $bank_cumulative + checkZero($res->total_paid_interest);
                                    $bank_paid = $bank_paid + checkZero($res->current_year_interest);

                                @endphp
                                <tr>
                                    <td style="text-align:left;"> Bank loan</td>
                                    <td class="tdc">{{ $res->lo_principle_amount }}</td>
                                    <td class="tdc">{{ $res->current_year_interest }}</td>
                                    <td class="tdc">{{ $res->total_paid_interest }}</td>
                                    <td class="tdc">{{ $res->overdue }}</td>
                                    <td class="tdc">{{ $res->lo_next_year }}</td>
                                </tr>
                            @endforeach


                        @endif
                        {{-- MFI LOAN --}}
                        @php
                            $mfi_total = 0;
                            $mfi_amount = 0;
                            $mfi_overdue = 0;
                            $mfi_cumulative = 0;
                            $mfi_paid = 0;
                        @endphp
                        @if (!empty($mfi_loan))

                            @foreach ($mfi_loan as $res)
                                @php
                                    $mfi_total = $mfi_total + checkZero($res->lo_next_year);
                                    $mfi_amount = $mfi_amount + checkZero($res->lo_principle_amount);
                                    $mfi_overdue = $mfi_overdue + checkZero($res->overdue);
                                    $mfi_cumulative = $mfi_cumulative + checkZero($res->total_paid_interest);
                                    $mfi_paid = $mfi_paid + checkZero($res->current_year_interest);

                                @endphp
                                <tr>
                                    <td style="text-align:left;">MFI loan</td>
                                    <td class="tdc">{{ $res->lo_principle_amount }}</td>
                                    <td class="tdc">{{ $res->current_year_interest }}</td>
                                    <td class="tdc">{{ $res->total_paid_interest }}</td>
                                    <td class="tdc">{{ $res->overdue }}</td>
                                    <td class="tdc">{{ $res->lo_next_year }}</td>
                                </tr>
                            @endforeach


                        @endif

                        {{-- CLUSTER LOAN --}}

                        @php
                            $cluster_total = 0;
                            $cluster_amount = 0;
                            $cluster_overdue = 0;
                            $cluster_cumulative = 0;
                            $cluster_paid = 0;
                        @endphp
                        @if (!empty($cluster_loan))

                            @foreach ($cluster_loan as $res)
                                @php
                                    $cluster_total = $cluster_total + checkZero($res->lo_next_year);
                                    $cluster_amount = $cluster_amount + checkZero($res->lo_principle_amount);
                                    $cluster_overdue = $cluster_overdue + checkZero($res->overdue);
                                    $cluster_cumulative = $cluster_cumulative + checkZero($res->total_paid_interest);
                                    $cluster_paid = $cluster_paid + checkZero($res->current_year_interest);

                                @endphp
                                <tr>
                                    <td style="text-align:left;">Cluster loan</td>
                                    <td class="tdc">{{ $res->lo_principle_amount }}</td>
                                    <td class="tdc">{{ $res->current_year_interest }}</td>
                                    <td class="tdc">{{ $res->total_paid_interest }}</td>
                                    <td class="tdc">{{ $res->overdue }}</td>
                                    <td class="tdc">{{ $res->lo_next_year }}</td>
                                </tr>
                            @endforeach


                        @endif
                        {{-- FEDERATION LOAN --}}

                        @php
                            $fed_total = 0;
                            $fed_amount = 0;
                            $fed_overdue = 0;
                            $fed_cumulative = 0;
                            $fed_paid = 0;
                        @endphp
                        @if (!empty($fed_loan))

                            @foreach ($fed_loan as $res)
                                @php
                                    $fed_total = $fed_total + checkZero($res->lo_next_year);
                                    $fed_amount = $fed_amount + checkZero($res->lo_principle_amount);
                                    $fed_overdue = $fed_overdue + checkZero($res->overdue);
                                    $fed_cumulative = $fed_cumulative + checkZero($res->total_paid_interest);
                                    $fed_paid = $fed_paid + checkZero($res->current_year_interest);

                                @endphp
                                <tr>
                                <tr>
                                    <td style="text-align:left;">Federation loan</td>
                                    <td class="tdc">{{ $res->lo_principle_amount }}</td>
                                    <td class="tdc">{{ $res->current_year_interest }}</td>
                                    <td class="tdc">{{ $res->total_paid_interest }}</td>
                                    <td class="tdc">{{ $res->overdue }}</td>
                                    <td class="tdc">{{ $res->lo_next_year }}</td>
                                </tr>
                            @endforeach


                        @endif
                        {{-- NBFSC LOAN --}}

                        @php
                            $nbfc_total = 0;
                            $nbfc_amount = 0;
                            $nbfc_overdue = 0;
                            $nbfc_cumulative = 0;
                            $nbfc_paid = 0;
                        @endphp
                        @if (!empty($nbfc_loan))

                            @foreach ($nbfc_loan as $res)
                                @php
                                    $nbfc_total = $nbfc_total + checkZero($res->lo_next_year);
                                    $nbfc_amount = $nbfc_amount + checkZero($res->lo_principle_amount);
                                    $nbfc_overdue = $nbfc_overdue + checkZero($res->overdue);
                                    $nbfc_cumulative = $nbfc_cumulative + checkZero($res->total_paid_interest);
                                    $nbfc_paid = $nbfc_paid + checkZero($res->current_year_interest);

                                @endphp
                                <tr>
                                <tr>
                                    <td style="text-align:left;">NBFC loan</td>
                                    <td class="tdc">{{ $res->lo_principle_amount }}</td>
                                    <td class="tdc">{{ $res->current_year_interest }}</td>
                                    <td class="tdc">{{ $res->total_paid_interest }}</td>
                                    <td class="tdc">{{ $res->overdue }}</td>
                                    <td class="tdc">{{ $res->lo_next_year }}</td>
                                </tr>
                            @endforeach


                        @endif
                        {{-- OTHER LOAN --}}

                        @php
                            $other_total = 0;
                            $other_amount = 0;
                            $other_overdue = 0;
                            $other_cumulative = 0;
                            $other_paid = 0;
                        @endphp
                        @if (!empty($other_loan))

                            @foreach ($other_loan as $res)
                                @php
                                    $other_total = $other_total + checkZero($res->lo_next_year);
                                    $other_amount = $other_amount + checkZero($res->lo_principle_amount);
                                    $other_overdue = $other_overdue + checkZero($res->overdue);
                                    $other_cumulative = $other_cumulative + checkZero($res->total_paid_interest);
                                    $other_paid = $other_paid + checkZero($res->current_year_interest);

                                @endphp
                                <tr>

                                    <td style="text-align:left;">Other loan</td>
                                    <td class="tdc">{{ $res->lo_principle_amount }}</td>
                                    <td class="tdc">{{ $res->current_year_interest }}</td>
                                    <td class="tdc">{{ $res->total_paid_interest }}</td>
                                    <td class="tdc">{{ $res->overdue }}</td>
                                    <td class="tdc">{{ $res->lo_next_year }}</td>
                                </tr>
                            @endforeach
                        @endif

                        <tr style="font-weight:bold">
                            <th class="tdc" style="background-color:#c2b5b5;">Total</th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                {{ $other_amount + $fed_amount + $cluster_amount + $bank_amount + $money_amount + $shg_amount + $mfi_amount + $nbfc_amount }}
                            </th>

                            <th class="tdc" style="background-color:#c2b5b5;">
                                {{ $other_paid + $fed_paid + $cluster_paid + $bank_paid + $money_paid + $shg_paid + $mfi_paid + $nbfc_paid}}
                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                {{ $other_cumulative + $fed_cumulative + $cluster_cumulative + $bank_cumulative + $money_cumulative + $shg_cumulative + $mfi_cumulative + $nbfc_cumulative }}
                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                {{ $other_overdue + $fed_overdue + $cluster_overdue + $bank_overdue + $money_overdue + $shg_overdue + $mfi_overdue + $nbfc_overdue }}
                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                {{ $other_total + $fed_total + $cluster_total + $bank_total + $money_total + $shg_total + $mfi_total + $nbfc_total}}
                            </th>
                        </tr>
                    </thead>
                </table>
            </table>
            {{-- family current and next year budget --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>FAMILY’S CURRENT AND NEXT YEAR BUDGET</td>
                    </tr>
                </thead>
            </table>

            <div class="row-new">
                <div class="col-sm-6 mt-2">
                    <div class="card">
                        <div class="card-block">
                            <div class="w-box">
                                <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 50%; ">


                                    <thead>
                                        <tr class="table-primary">
                                            <td style="background-color:#D79477 ; text-align: center">Income source
                                            </td>
                                            <td style="background-color:#D79477 ; text-align: center">Total Current
                                                Year (INR)
                                            </td>
                                            <td style="background-color:#D79477 ; text-align: center">Next Year
                                                Forecast (INR)
                                            </td>

                                        </tr>
                                    </thead>
                                    <thead>
                                        @if ($income_this_year[0]->agriculture > 0 || $income_next_year[0]->agriculture > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Agriculture </th>
                                            <td>{{ (int) $income_this_year[0]->agriculture }}
                                            </td>
                                            <td>{{ (int) $income_next_year[0]->agriculture }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if ($income_this_year[0]->livestock > 0 || $income_next_year[0]->livestock > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Livestock </th>
                                            <td>{{ (int) $income_this_year[0]->livestock }}
                                            </td>
                                            <td>{{ (int) $income_next_year[0]->livestock }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if ($income_this_year[0]->horticulture > 0 || $income_next_year[0]->horticulture > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Horticulture </th>
                                            <td>{{ (int) $income_this_year[0]->horticulture }}
                                            </td>
                                            <td>{{ (int) $income_next_year[0]->horticulture }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if ($income_this_year[0]->sale_of_livestock > 0 || $income_next_year[0]->sale_of_livestock > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Sale of Livestock </th>
                                            <td>{{ (int) $income_this_year[0]->sale_of_livestock }}
                                            </td>
                                            <td>{{ (int) $income_next_year[0]->sale_of_livestock }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if ($income_this_year[0]->money_lending > 0 || $income_next_year[0]->money_lending > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Money Lending </th>
                                            <td>{{ (int) $income_this_year[0]->money_lending }}
                                            </td>
                                            <td>{{ (int) $income_next_year[0]->money_lending }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if ($income_this_year[0]->fixed_income_amount > 0 || $income_next_year[0]->fixed_income_amount > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Fixed Income </th>
                                            <td>{{ (int) $income_this_year[0]->fixed_income_amount  }}
                                            </td>
                                            <td>{{ (int) $income_next_year[0]->fixed_income_amount  }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if ($income_this_year[0]->casual_income_amount > 0 || $income_next_year[0]->casual_income_amount > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Casual Income</th>
                                            <td>{{ (int) $income_this_year[0]->casual_income_amount  }}
                                            </td>
                                            <td>{{ (int) $income_next_year[0]->casual_income_amount  }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if ($income_this_year[0]->trade_income_amount > 0 || $income_next_year[0]->trade_income_amount > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Trade Income</th>
                                            <td>{{ (int) $income_this_year[0]->trade_income_amount  }}
                                            </td>
                                            <td>{{ (int) $income_next_year[0]->trade_income_amount  }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if ($income_this_year[0]->pension_income_monthly > 0 || $income_next_year[0]->pension_income_monthly > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Pension
                                                Income
                                            </th>
                                            {{-- <td>{{ (int) $income_this_year[0]->pension_income_monthly * 12 }}
                                            </td>
                                            <td>{{ (int) $income_next_year[0]->pension_income_monthly * 12 }}
                                            </td> --}}
                                            <td>{{ (int) $income_this_year[0]->pension_income_monthly  }}
                                            </td>
                                            <td>{{ (int) $income_next_year[0]->pension_income_monthly  }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if ($income_this_year[0]->other_income > 0 || $income_next_year[0]->other_income > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Other Income</th>
                                            <td>{{ (int) $income_this_year[0]->other_income  }}
                                            </td>
                                            <td>{{ (int) $income_next_year[0]->other_income  }}
                                            </td>
                                        </tr>
                                        @endif
                                        @php
                                        $total_income_this_year = (int) $income_this_year[0]->pension_income_monthly + (int) $income_this_year[0]->fixed_income_amount + (int) $income_this_year[0]->horticulture + (int) $income_this_year[0]->livestock + (int) $income_this_year[0]->agriculture + (int) $income_this_year[0]->sale_of_livestock + (int) $income_this_year[0]->money_lending + (int) $income_this_year[0]->casual_income_amount + (int) $income_this_year[0]->trade_income_amount + (int) $income_this_year[0]->other_income ;

                                        $total_income_next_year = (int) $income_next_year[0]->pension_income_monthly + (int) $income_next_year[0]->fixed_income_amount + (int) $income_next_year[0]->horticulture + (int) $income_next_year[0]->livestock + (int) $income_next_year[0]->agriculture +(int) $income_next_year[0]->sale_of_livestock + (int) $income_next_year[0]->money_lending + (int) $income_next_year[0]->casual_income_amount + (int) $income_next_year[0]->trade_income_amount + (int) $income_next_year[0]->other_income ;
                                        @endphp
                                        <tr style="text-align: center;">
                                            <th width="35%" style="background-color:#c2b5b5;">Total
                                                Income
                                            </th>
                                            <td style="background-color:#c2b5b5;">
                                                {{ $total_income_this_year }}
                                            </td>
                                            <td style="background-color:#c2b5b5;">
                                                {{ $total_income_next_year }}
                                            </td>
                                        </tr>

                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mt-2">
                    <div class="card">
                        <div class="card-block">
                            <div class="w-heading d-flex">
                                <span>
                                    <h5 style="text-align:center;">CURRENT YEAR INCOME </h5>
                                </span>
                            </div>
                            <div class="w-box">
                                {{-- <canvas id="myChart"></canvas> --}}
                                <div id="piechart" style="width: 500px; height: 300px;margin-left:114px;position:relative;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-new">
                <div class="col-sm-6 mt-2">
                    <div class="card">
                        <div class="card-block">

                            <div class="w-box">
                                <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 50%; ">


                                    <thead>
                                        <tr class="table-primary">
                                            <td style="background-color:#D79477 ; text-align: center">Expenditure type
                                            </td>
                                            <td style="background-color:#D79477 ; text-align: center">Total Current
                                                Year (INR)
                                            </td>
                                            <td style="background-color:#D79477 ; text-align: center">Next Year
                                                Forecast (INR)
                                            </td>

                                        </tr>
                                    </thead>
                                    <thead>
                                        @if ($this_year_normal[0]->total > 0 || $next_year_normal[0]->total > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Normal Expenditure</th>
                                            <td>{{ $this_year_normal[0]->total }}</td>
                                            <td>{{ $next_year_normal[0]->total }}</td>
                                        </tr>
                                        @endif


                                        @if ($this_year_Social[0]->total > 0 || $next_year_Social[0]->total > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Social Expenditure</th>
                                            <td>{{ $this_year_Social[0]->total }}</td>
                                            <td>{{ $next_year_Social[0]->total }}</td>
                                        </tr>
                                        @endif

                                        @if ($this_year_wasteful[0]->total > 0 || $next_year_wasteful[0]->total > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Wasteful Expenditure</th>
                                            <td>{{ $this_year_wasteful[0]->total }}</td>
                                            <td>{{ $next_year_wasteful[0]->total }}</td>
                                        </tr>
                                        @endif
                                        @if ($loan_expensture_total[0]->loan_this_year > 0 || $loan_expensture_total[0]->loan_next_year > 0)
                                        <tr style="text-align: center">
                                            <th width="35%">Loan Expenditure</th>
                                            <td>{{ $loan_expensture_total[0]->loan_this_year }}</td>
                                            <td>{{ $loan_expensture_total[0]->loan_next_year }}</td>
                                        </tr>
                                        @endif
                                        @php
                                        $total_expenditure_this_year = (int) $this_year_normal[0]->total + (int) $this_year_Social[0]->total + (int) $this_year_wasteful[0]->total + (int) $loan_expensture_total[0]->loan_this_year;

                                        $total_expenditure_next_year = (int) $next_year_normal[0]->total + (int) $next_year_Social[0]->total + (int) $next_year_wasteful[0]->total + (int) $loan_expensture_total[0]->loan_next_year;
                                        @endphp
                                        <tr style="text-align: center;">
                                            <th width="35%" style="background-color:#c2b5b5;">Total
                                                Expenditure
                                            </th>
                                            <td style="background-color:#c2b5b5;">
                                                {{ $total_expenditure_this_year }}
                                            </td>
                                            <td style="background-color:#c2b5b5;">
                                                {{ $total_expenditure_next_year }}
                                            </td>
                                        </tr>

                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mt-2">
                    <div class="card">
                        <div class="card-block">
                            <div class="w-heading d-flex">
                                <span>
                                    <h5 style="text-align:center;">CURRENT YEAR EXPENDITURE </h5>
                                </span>
                            </div>
                            <div class="w-box">
                                {{-- <canvas id="donutchart"></canvas> --}}
                                <div id="donutchart" style="width: 500px; height: 300px;margin-left:114px;position:relative;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mt-2">
                    <div class="card">
                        <div class="card-block">
                            <div class="w-heading d-flex">
                                <span>
                                    <h5 style="text-align:center;">INCOME VS EXPENDITURE</h5>
                                </span>
                            </div>
                            <div class="w-box">
                                {{-- <canvas id="expend"></canvas> --}}
                                <div id="top_x_div" style="width: 1000px; height: 200px;margin-left:114px;position:relative;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Chalenges & action plan --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white ;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>CHALLENGES & ACTION PLAN
                        </td>
                    </tr>
                </thead>
            </table>
            <br>
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: left;background-color:#eeeeee;font-size:20px;border:none;font-weight:bold;">
                        <td>Action Plan To Address The Challenges</td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">



                <tbody>
                    <tr>
                        <th style="background-color:#D79477 ; text-align: center;width:5%">S.No</th>
                        <th style="background-color:#D79477 ; text-align: center;width:20%">Action Plan</th>
                        @php
                        $no = 1;
                        @endphp
                        @if (!empty($challenges))
                        @foreach ($challenges as $row)
                        <th style="background-color:#D79477 ; text-align: center;">Challenge
                            {{ $no }} :
                            {{ $row->challenges }}
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
            <br>
            {{-- family business plan  --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center;background-color:white;font-size:30px;border:none;font-weight:bold;text-decoration:underline;">
                        <td>FAMILY BUSINESS PLAN</td>
                    </tr>
                </thead>
            </table>

            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary">
                        <th style="background-color:#D79477 ; text-align: left" colspan="4">Basic Details of
                            Investment plan
                        </th>
                    </tr>
                </thead>
                @if($business_investment_plan[0]->is_buisness_plan_avl == 'No')
                <tbody>
                    <tr style="text-align: center">
                        <th width="25%">Business Plan</th>
                        <td width="25%">{{ $business_investment_plan[0]->is_buisness_plan_avl }}</td>
                        <th width="25%">Business Sector</th>
                        <td width="25%">{{ $business_investment_plan[0]->comments }}</td>
                    </tr>

                </tbody>
                @else
                <tbody>
                    <tr style="text-align: center">
                        <th width="25%">Business Plan</th>
                        <td width="25%">{{ $business_investment_plan[0]->is_buisness_plan_avl }}</td>
                        <th width="25%">Type/Category</th>
                        <td width="25%">{{ $business_investment_plan[0]->type_of_category }}</td>

                    </tr>

                    <tr style="text-align: center">
                        <th width="25%">Business Sector</th>
                        <td width="25%">{{ $business_investment_plan[0]->type_of_business }}</td>
                        <th>New or Existing Business</th>
                        <td>{{ $business_investment_plan[0]->is_existing_business_plan }}</td>

                    </tr>
                    <tr style="text-align: center">
                        <th>Date of Business Plan</th>
                        <td>{{ change_date_month_name_char(str_replace('/', '-', $business_investment_plan[0]->date_of_business_plan)) }}
                        </td>
                        <th>Family member reponsible</th>
                        <td>{{ $business_investment_plan[0]->primarily_business }}</td>

                    </tr>
                    <tr style="text-align: center">
                        <th>Proposed Activity</th>
                        <td>{{ $business_investment_plan[0]->proposed_activity_existing }}</td>
                        <th></th>
                        <td></td>
                    </tr>

                </tbody>
                @endif

            </table>
            <br>
            @if ($business_investment_plan[0]->is_buisness_plan_avl != 'No')

            {{-- Total cost of the business --}}
            <table class="table  table-stripped table1 " style="border:none;" cellspacing="0">
                <thead>
                    <tr style="text-align: start;background-color:#eeeeee;font-size:20px;border:none;">
                        <td>Total Cost Of The Business ( One Time)
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                <thead>
                    <tr class="table-primary">
                        <td style=" background-color:#D79477 ;text-align: center;width:5%"> S No.</td>
                        <td style=" background-color:#D79477 ;text-align:center;width:23.75%"> Name of Items
                        </td>
                        <td style="background-color:#D79477 ; text-align: center;width:23.75%">Quantity </td>
                        <td style="background-color:#D79477 ; text-align: center;width:23.75%">Unit Price (INR)
                        </td>
                        <td style="background-color:#D79477 ; text-align: center;width:23.75%">Total Cost (INR)
                        </td>


                    </tr>


                </thead>
                <tbody>
                    @php
                    $i = 1;
                    $sum = 0;
                    $sum1 = 0;
                    @endphp
                    @if (!empty($fixed_investment))
                    @foreach ($fixed_investment as $row)
                    @php
                    $sum += (float) $row->amount;
                    $sum1 += (float) $row->totalamount;
                    @endphp
                    <tr>
                        <td width="25px" class="tdc">{{ $i }}</td>

                        <td style="text-align:left;">{{ $row->name_of_item }}
                        </td>
                        <td style=" text-align: center">{{ $row->no_of_quantity }}
                        </td>
                        <td style=" text-align: center">{{ $row->amount }}
                        </td style=" text-align: center">
                        <td style=" text-align: center">{{ $row->totalamount }}</td>
                    </tr>
                    @php $i++ ; @endphp
                    @endforeach
                    <tr>
                        <td colspan="3"></td>
                        <th style="background-color:#c2b5b5;text-align: center;">Total</th>
                        <th style=" text-align: center;background-color:#c2b5b5;">{{ $sum1 }}</th>
                    </tr>
                    @endif
                </tbody>

            </table>
            <br>
            {{-- Yearly Recurring Expenditure --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: start;background-color:#eeeeee ;font-size:20px;border:none;">
                        <td>Yearly Recurring Expenditure
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477 ; text-align: center;width:5%;">S. No.</td>
                        <td style="background-color:#D79477 ; text-align:center;">Name of Items</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 1 Expenses <br>(INR)</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 2 Expenses <br>(INR)</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 3 Expenses <br>(INR)</td>
                    </tr>
                </thead>
                <tbody>
                    @php

                    $sn = 1;
                    $count = 0;
                    $year = ['1st year expenses', '2nd year expenses', '3rd year expenses'];
                    @endphp

                    @for ($i = 0; $i < count($yearly_expenses); $i++) @php $expensesyear=explode(',', $yearly_expenses[$i]->expenses_type);
                        // print_r($yearly_expenses[$i]->expenses_type);
                        $expense = explode(',', $yearly_expenses[$i]->expenses);

                        @endphp
                        <tr>
                            <td width="25px" class="tdc">{{ $sn }}</td>
                            <td>{{ $yearly_expenses[$i]->name_of_item }}</td>
                            @foreach ($year as $curyear)
                            <td class="tdc">
                                @php

                                $key = array_search(trim($curyear), $expensesyear, false);
                                if ($key !== false) {
                                echo $expense[$key];
                                } else {
                                echo 'N/A';
                                }
                                @endphp
                            </td>
                            @endforeach
                        </tr>
                        @php
                        $sn++;
                        @endphp
                        @endfor



                        <tr>
                            <th></th>
                            <th style="background-color:#c2b5b5;">Total</th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                {{ checkZero($total_1st_year_expenses) }}
                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                {{ checkZero($total_2nd_year_expenses) }}
                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">
                                {{ checkZero($total_3rd_year_expenses) }}
                            </th>
                        </tr>
                </tbody>

            </table>
            <br>
            {{-- Income from business --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: start;background-color:#eeeeee ;font-size:20px;border:none;">
                        <td>Income from Business</td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">
                <thead>
                    <tr class="table-primary">
                        <td style="background-color:#D79477 ; text-align: center;width:5%;">S. No.</td>
                        <td style="background-color:#D79477 ; text-align:center;">Name of Items</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 1 Income <br>(INR)</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 2 Income <br>(INR)</td>
                        <td style="background-color:#D79477 ; text-align: center">Year 3 Income <br>(INR)</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                    //prd($income_business);
                    $sn = 1;
                    $count = 0;
                    $year = ['1st year income', '2nd year income', '3rd year income'];
                    @endphp

                    @for ($i = 0; $i < count($income_business); $i++) @php $incomeyear=explode(',', $income_business[$i]->income_type);
                        // print_r($income_business[$i]->income_type);
                        $income = explode(',', $income_business[$i]->income);

                        @endphp
                        <tr>
                            <td width="25px" class="tdc">{{ $sn }}</td>
                            <td>{{ $income_business[$i]->name_of_item }}</td>
                            @foreach ($year as $curyear)
                            <td class="tdc">
                                @php
                                // print_r($incomeyear);
                                $key = array_search(trim($curyear), $incomeyear, false);
                                if ($key !== false) {
                                echo $income[$key];
                                } else {
                                echo 'N/A';
                                }
                                @endphp
                            </td>
                            @endforeach
                        </tr>
                        @php
                        $sn++;
                        @endphp
                        @endfor


                        <tr>
                            <th></th>
                            <th style="background-color:#c2b5b5;">Total</th>
                            <th class="tdc" style="background-color:#c2b5b5;">{{ checkZero($total_1st_year_income) }}
                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">{{ checkZero($total_2nd_year_income) }}
                            </th>
                            <th class="tdc" style="background-color:#c2b5b5;">{{ checkZero($total_3rd_year_income) }}
                            </th>
                        </tr>
                </tbody>

            </table>
            <br>
            {{-- Profit/Loss --}}
            <table class="table table-bordered  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: start;background-color:#eeeeee ;font-size:20px;border:none;">
                        <td colspan="5">Profit/Loss
                        </td>
                    </tr>
                </thead>
                <tbody>

                    <tr class="table-primary">
                        <td style=" text-align: center;"> </td>

                        <td style="background-color:#D79477 ; text-align: center;">Year 1 (INR)</td>
                        <td style="background-color:#D79477 ; text-align: center;">Year 2 (INR)</td>
                        <td style="background-color:#D79477 ; text-align: center;">Year 3 (INR) </td>


                    </tr>
                    <tr>
                        <td>Operational Cost</td>
                        <td class="tdc">{{ (float) $first_year_total_salesamts }}</td>
                        <td class="tdc">{{ (float) $scnd_year_total_salesamts }}</td>
                        <td class="tdc">{{ (float) $trd_year_total_salesamts }}</td>
                    </tr>

                    <tr>
                        <td>Loan Repayment</td>
                        <td class="tdc">{{ (float) $first_year_total_loanamts_fyear }}</td>
                        <td class="tdc">{{ (float) $scnd_year_total_loanamts_fyear }}</td>
                        <td class="tdc">{{ (float) $trd_year_total_loanamts_fyear }}</td>
                    </tr>

                    <tr>
                        <td>Interest Repayment</td>
                        <td class="tdc">{{ (float) $first_year_total_interestamts_fyear }}</td>
                        <td class="tdc">{{ (float) $scnd_year_total_interestamts_fyear }}</td>
                        <td class="tdc">{{ (float) $trd_year_total_interestamts_fyear }}</td>
                    </tr>
                    <tr style="background-color:#FFC300;font-weight: bolder;font-size: medium;">
                        <td style="background-color:#FFC300;">Total</td>
                        <td class="tdc" style="background-color:#FFC300;">{{ (float) $first_year_expansesamt }}
                        </td>
                        <td class="tdc" style="background-color:#FFC300;">{{ (float) $scnd_year_expansesamt }}
                        </td>
                        <td class="tdc" style="background-color:#FFC300;">{{ (float) $trd_year_expansesamt }}
                        </td>
                    </tr>
                    <tr>
                        <th>Income</th>
                        <th class="tdc">{{ (float) $first_year_total_incomeamts }}</th>
                        <th class="tdc">{{ (float) $scnd_year_total_incomeamts }}</th>
                        <th class="tdc">{{ (float) $trd_year_total_incomeamts }}</th>
                    </tr>
                    <tr style="background-color: #b3aeae;font-weight: bolder;font-size: medium;">
                        <td style="background-color:#b3aeae;">Profit/Loss</td>
                        <td style="color:{{ $show1 }}; background-color:#b3aeae;" class="tdc">
                            {{ (float) $tv_1profit }}
                        </td>
                        <td style="color:{{ $show2 }}; background-color:#b3aeae;" class="tdc">
                            {{ (float) $tv_2profit }}
                        </td>
                        <td style="color:{{ $show3 }}; background-color:#b3aeae;" class="tdc">
                            {{ (float) $tv_3profit }}
                        </td>
                    </tr>
                    <br>
                    <tr>
                        <th style="text-align:center;" colspan="2">If loss, how will this gap be met</th>
                        <th style="text-align:center;" colspan="2">
                            {{ $business_investment_plan[0]->lossgap_type }}
                        </th>
                    </tr>

                </tbody>
            </table>



            <br>
            {{-- Loan Amount and Duration --}}
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">
                <thead>
                    <tr style="text-align: start;background-color:white ;font-size:20px;border:none;">
                        <td colspan="5">Loan Amount and Duration
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <tr class="table-primary">
                        <td style=" background-color:#D79477 ;text-align: center;width:4%"> S.No.</td>
                        <td style=" background-color:#D79477 ;text-align:center;width:24%"> Loan Amount
                        </td>
                        <td style="background-color:#D79477 ; text-align: center;width:24%">Interest Rate %
                        </td>
                        <td style="background-color:#D79477 ; text-align: center;width:24%">Interest Type </td>
                        <td style="background-color:#D79477 ; text-align: center;width:24%">Duration </td>


                    </tr>
                    <tr class="tdc">
                        <td>1</td>
                        <td>{{ checkna((int) $loan_repayment[0]->principal) }}</td>
                        @if ($loan_repayment[0]->interest != '')
                        <td>{{ (int) $loan_repayment[0]->interest }}%</td>
                        @else
                        <td>0.00%</td>
                        @endif
                        <td>{{ checkna($loan_repayment[0]->interest_type) }}</td>
                        @php
                        $duration = 'N/A';
                        if ($loan_repayment[0]->tenure_mode == 1) {
                        $duration = $loan_repayment[0]->loan_tenure . '-' . 'Year';
                        } elseif ($loan_repayment[0]->tenure_mode == 0) {
                        $duration = $loan_repayment[0]->loan_tenure . '-' . 'Month';
                        }
                        @endphp
                        <td class="tdc">{{ $duration }}</td>
                    </tr>
                </tbody>

            </table>
            <br>
            {{-- payment details --}}
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">
                <thead>
                    <tr style="text-align: left;background-color:white ;font-size:20px;border:none;">
                        <td colspan="5">Payment Details
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-primary">
                        <td width="5%"></td>
                        <td width="25%"></td>
                        <td style="background-color:#D79477 ;width:23.3% ;text-align: center">Year 1 (INR)</td>
                        <td style="background-color:#D79477 ;width:23.3% ;text-align: center">Year 2 (INR)</td>
                        <td style="background-color:#D79477 ;width:23.3% ;text-align: center">Year 3 (INR)</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Total Interest</td>

                        <td class="tdc">
                            {{ $loan_repayment[0]->total_interest_fyear != '' ? $loan_repayment[0]->total_interest_fyear : 0 }}
                        </td>
                        <td class="tdc">
                            {{ $loan_repayment[0]->total_interest_syear != '' ? $loan_repayment[0]->total_interest_syear : 0 }}
                        </td>
                        <td class="tdc">
                            {{ $loan_repayment[0]->total_interest_thyear != '' ? $loan_repayment[0]->total_interest_thyear : 0 }}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Total Principle</td>

                        <td class="tdc">
                            {{ $loan_repayment[0]->total_loan_fyear != '' ? $loan_repayment[0]->total_loan_fyear : 0 }}
                        </td>
                        <td class="tdc">
                            {{ $loan_repayment[0]->total_loan_syear != '' ? $loan_repayment[0]->total_loan_syear : 0 }}
                        </td>
                        <td class="tdc">
                            {{ $loan_repayment[0]->total_loan_thyear != '' ? $loan_repayment[0]->total_loan_thyear : 0 }}
                        </td>
                    </tr>
                    <tr>
                        @php
                        $total1 = (float) $loan_repayment[0]->total_interest_fyear + (float) $loan_repayment[0]->total_loan_fyear;
                        $total2 = (float) $loan_repayment[0]->total_interest_syear + (float) $loan_repayment[0]->total_loan_syear;
                        $total3 = (float) $loan_repayment[0]->total_interest_thyear + (float) $loan_repayment[0]->total_loan_thyear;
                        @endphp
                        <td></td>

                        <td>Payable amount</td>

                        <td class="tdc">{{ sprintf('%.1f', $total1) }}
                        </td>
                        <td class="tdc">{{ sprintf('%.1f', $total2) }}
                        </td>
                        <td class="tdc">{{ sprintf('%.1f', $total3) }}
                        </td>
                    </tr>
                </tbody>

            </table>


            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;width:60%;">Comments if any
                        </td>
                        <td style="background-color:#ebe3e3;;text-align:left;width:40%;"></td>
                    </tr>
                </thead>
            </table>

            @endif
            {{-- observation --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align: center ;font-size:30px;border:none;font-weight: bold;text-decoration:underline;">
                        <td>OBSERVATIONS
                        </td>
                    </tr>
                </thead>
            </table>

            {{-- first visit observation --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align:start;background-color:#eeeeee;font-size:20px;border:none;">
                        <td>First Visit Observation
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                <thead>
                    <tr class="table-primary">

                        <td style="background-color:#D79477 ; text-align: center;width: 5%">S.No. </td>
                        <td style="background-color:#D79477 ; text-align: center;width: 55%">Question</td>
                        <td style="background-color:#D79477 ; text-align: center;width: %">Answer </td>


                    </tr>
                </thead>

            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                {{-- <thead>
                    <tr style="text-align:start">
                        <td style="width: 5%;text-align:center;">1</td>
                        <td style="width: 55%;">Who participated in the family?</td>
                        <td style="width: 55%;">{{ $observation_this_year_member[0]->participate_family }}</td>


                    </tr>
                    <tr style="text-align:start">
                        <td style="width: 5%;text-align:center;">2</td>
                        <td style="width: 40%;">Was there active participation in<br>
                            the discussion?</td>
                        <td style="width: 55%;">{{ $observation_this_year[0]->fdip_observation_was }}</td>


                    </tr>
                    <tr style="text-align:start">
                        <td style="width: 5%;text-align:center;">3</td>
                        <td style="width: 40%;">Who was contributing mostly? </td>
                        <td style="width: 55%;">{{ $observation_this_year[0]->fdip_observation_who_was }}</td>


                    </tr>
                    <tr style="text-align:start">
                        <td style="width: 5%;text-align:center;">4</td>
                        <td style="width: 40%;">Describe it </td>
                        <td style="width: 55%;">{{ $observation_this_year[0]->fdip_observation_describe }}
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <td style="width: 5%;text-align:center;">5</td>
                        <td style="width: 40%;">Past Life </td>
                        <td style="width: 55%;">Husband died 6 years back.</td>


                    </tr>
                    <tr style="text-align:start">
                        <td style="width: 5%;text-align:center;">6</td>
                        <td style="width: 40%;">Daily Tradition (Things they enjoy<br>
                            and challenges on a daily basis)</td>
                        <td style="width: 55%;">{{ $observation_this_year[0]->fdip_observation_past_life }}
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <td style="width: 5%;text-align:center;">7</td>
                        <td style="width: 40%;">Key Achievements</td>

                        <td style="width: 55%;">
                            <ul style="list-style-type:disc;margin-left:15px;">
                                @if ($observation_this_year[0]->fdip_observation_highlights_a != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_a }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_b != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_b }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_c != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_c }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_d != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_d }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_e != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_e }}
                                </li>
                                @endif
                            </ul>
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <td style="width: 5%;text-align:center;">8</td>
                        <td style="width: 40%;">Vulnerabilities/ Potential Risk</td>
                        <td style="width: 55%;">
                            <p> <b>{{ $observation_this_year[0]->fdip_observation_vulnerabilities }}
                                </b></p>
                            <ul style="list-style-type:disc;margin-left:15px;">
                                @if ($observation_this_year[0]->fdip_observation_highlights_a_6 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_a_6 }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_b_6 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_b_6 }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_c_6 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_c_6 }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_d_6 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_d_6 }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_e_6 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_e_6 }}
                                </li>
                                @endif
                            </ul>
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <td style="width: 5%;text-align:center;">9</td>
                        <td style="width: 40%;">Does their SHG help them? </td>
                        <td style="width: 55%;">{{ $observation_this_year[0]->fdip_observation_how }}</td>


                    </tr>
                    <tr style="text-align:start">
                        <td style="width: 5%;text-align:center;">10</dh>
                        <td style="width: 40%;">Was there agreement among<br>
                            family members to address their<br>
                            challenges?
                        </td>
                        <td style="width: 55%;">{{ $observation_this_year[0]->fdip_observation_agreement }}</td>


                    </tr>
                    <tr style="text-align:start">
                        <td style="width: 5%;text-align:center;">11</dh>
                        <td style="width: 40%;">What makes this family unique?
                        </td>
                        <td style="width: 55%;">
                            <ul style="list-style-type:disc;margin-left:15px;">
                                @if ($observation_this_year[0]->fdip_observation_highlights_a_9 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_a_9 }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_b_9 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_b_9 }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_c_9 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_c_9 }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_d_9 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_d_9 }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_e_9 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_e_9 }}
                                </li>
                                @endif
                            </ul>
                        </td>


                    </tr>

                </thead> --}}
                <tbody >
                    <tr>
                        <th style="width: 5%;text-align:center;">1</th>
                        <th style="width: 55%;">Who participated in the family?</th>
                        <td style="width:40%;">
                            {{ $observation_this_year_member[0]->participate_family }}
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:center;">2</th>
                        <th>How long the family has been living in this house?</th>
                        <td>{{ $observation_this_year[0]->fdip_observation_past_life }}</td>
                    </tr>

                    <tr>
                        <th style="text-align:center;">3</th>
                        <th>Give a few highlights about this family (who they are? What they do for living? were they ready for discussion? whether they actively participated, etc) </th>
                        <td>{{ $observation_this_year[0]->fdip_observation_daily  }}</td>
                    </tr>
                    <tr>
                        <th style="text-align:center;">4</th>
                        <th>What is special that you observed about this family? What are the three things you would like to highlight for this family (e.g. Readiness or reluctance to change,  attitudes in goal setting, feelings about commitments to act and unity within family, and so on) </th>
                        <td>
                            <ol type="A" >
                                @if ($observation_this_year[0]->fdip_observation_highlights_a != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_a }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_b != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_b }}
                                </li>
                                @endif
                                @if ($observation_this_year[0]->fdip_observation_highlights_c != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_c }}
                                </li>
                                @endif
                                @if ($observation_this_year[0]->fdip_observation_highlights_d != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_d }}
                                </li>
                                @endif
                                @if ($observation_this_year[0]->fdip_observation_highlights_e != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_e }}
                                </li>
                                @endif
                           </ol>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">5</td>
                        <th>What is this family burdened with or worried about (things that bother them on a daily basis)?
                        </th>
                        <td>{{ $observation_this_year[0]->fdip_observation_vulnerabilities }}
                            @if ($observation_this_year[0]->fdip_observation_vulnerabilities == 'Yes')
                            <br>
                            <ol type="A">
                                @if ($observation_this_year[0]->fdip_observation_highlights_a_6 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_a_6 }}
                                </li>
                                @endif

                                @if ($observation_this_year[0]->fdip_observation_highlights_b_6 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_b_6 }}
                                </li>
                                @endif
                                @if ($observation_this_year[0]->fdip_observation_highlights_c_6 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_c_6 }}
                                </li>
                                @endif
                                @if ($observation_this_year[0]->fdip_observation_highlights_d_6 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_d_6 }}
                                </li>
                                @endif
                                @if ($observation_this_year[0]->fdip_observation_highlights_e_6 != '')
                                <li>{{ $observation_this_year[0]->fdip_observation_highlights_e_6 }}
                                </li>
                                @endif
                            </ol>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">6</td>
                        <th>In your assessment, what are key risks this family faces? Did this discussion help them understand their risks?”</th>
                        <td>{{ $observation_this_year[0]->fdip_risk_assesment }}</td>
                    </tr>

                    <tr>
                        <td style="text-align:center;">7</td>
                        <th>Does their SHG help them?</th>
                        <td>{{ $observation_this_year[0]->fdip_observation_how }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">8</td>
                        <th>What was this family’s feedback on FDIP (did this discussion help them, if yes, in what ways)</th>
                        <td>{{ $observation_this_year[0]->fdip_observation_agreement }}
                            @if ($observation_this_year[0]->fdip_observation_agreement == 'Yes')
                            <ol>
                                <li>{{ $observation_this_year[0]->fdip_observation_agreement_edittext }}</li>
                            </ol>

                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">9</td>
                        <th>Are there in any observations that you have captured in other sections (e.g. family profile, assets, income, expenditures, loans, savings) that you would want to describe here                                                </th>
                        <td>
                            <ol type="A">
                            @if ($observation_this_year[0]->fdip_observation_highlights_a_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_a_9 }}
                        </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_b_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_b_9 }}
                        </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_c_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_c_9 }}
                        </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_d_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_d_9 }}
                        </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_e_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_e_9 }}
                        </li>
                        @endif
                        @if ($observation_this_year[0]->fdip_observation_highlights_f_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_f_9 }}
                        </li>
                        @endif
                        @if ($observation_this_year[0]->fdip_observation_highlights_g_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_g_9 }}
                        </li>
                        @endif
                        @if ($observation_this_year[0]->fdip_observation_highlights_h_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_h_9 }}
                        </li>
                        @endif
                        @if ($observation_this_year[0]->fdip_observation_highlights_i_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_i_9 }}
                        </li>
                        @endif
                            </ol>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">10</td>
                        <th>Does this family want to take another loan for existing or new business (productive activities) – yes/no</th>
                        <td>{{ $observation_this_year[0]->loan_new_existing !='1' ? 'Yes' :'No' }}</td>
                    </tr>
                    @if ($observation_this_year[0]->loan_new_existing == 0)
                    <tr>
                        <td style="text-align:center;">10.a</td>
                        <th>Which trade they want to take loan for?</th>
                        <td>{{ $observation_this_year[0]->fdip_which_trade_loan }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">10.b</td>
                        <th>Is this trade feasible in your opinion?</th>
                        <td>{{ $observation_this_year[0]->fdip_which_trade_feasible }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">10.c</td>
                        <th>Who in the family will run this business?  </th>
                        <td>{{ $observation_this_year[0]->fdip_who_run_family_buisness }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">10.d</td>
                        <th>What is the amount of loan they want to take?</th>
                        <td>{{ $observation_this_year[0]->fdip_observation_amount_of_loan }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">10.e</td>
                        <th>When will they prepare the business plan?</th>
                        <td>{{ $observation_this_year[0]->fdip_when_will_prepare_buisness_plan }}</td>
                    </tr>
                    @elseif($observation_this_year[0]->loan_new_existing == 1)
                    <tr>
                        <td style="text-align:center;">10.a</td>
                        <th>Why this family has decided not to take another loan and start business/trade (state reasons for not preparing an investment plan)</th>
                        <td>{{ $observation_this_year[0]->fdip_why_family_decided_not_take_loan }}</td>
                    </tr>
                    @endif

                </tbody>
            </table>

            {{-- second visit observation --}}
            <table class="table  table-stripped table1 " style="border:none" cellspacing="0">
                <thead>
                    <tr style="text-align:start;background-color:white ;font-size:20px;border:none;">
                        <td>Second Visit Observation
                        </td>
                    </tr>
                </thead>
            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                <thead>
                    <tr class="table-primary">

                        <td style="background-color:#D79477 ; text-align: center;width: 5%">S.No. </td>
                        <td style="background-color:#D79477 ; text-align: center;width: 55%">Question</td>
                        <td style="background-color:#D79477 ; text-align: center;width: 40%">Answer </td>


                    </tr>
                </thead>

            </table>
            <table class="table table-bordered table-stripped table1 " cellspacing="0" style="width: 100%; ">


                <tbody>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">1</th>
                        <th style="width: 55%;">Has family revised challenges or actions<br>since the last
                            discussion?</th>
                        <td style="width:40%;">
                            <p> <b>{{ $observation_next_year[0]->fdip_observation_next_has }}
                                </b></p>
                            @if ($observation_next_year[0]->fdip_observation_next_describe != '')
                            <ul style="list-style-type:disc;margin-left:15px;">
                                <li>{{ $observation_next_year[0]->fdip_observation_next_describe }}
                                </li>
                            </ul>
                            @endif
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">2</th>
                        <th style="width: 55%;">Has family done some preparation work for<br>
                            planning of the next year production and
                            <br> budget?
                        </th>
                        <td style="width: 40%;">
                            <p> <b>{{ $observation_next_year[0]->fdip_observation_next_planning }}</b></p>
                            @if ($observation_next_year[0]->fdip_observation_next_describe2 != '')
                            <ul style="list-style-type:disc;margin-left:15px;">
                                <li>{{ $observation_next_year[0]->fdip_observation_next_describe2 }}
                                </li>
                            </ul>
                            @endif

                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">3</th>
                        <th style="width: 55%;">Has family prepared their business plan?<br>
                            Describe key highlights of the business
                            <br>plan?
                        </th>
                        <td style="width: 40%;">
                            <p> <b>{{ $observation_next_year[0]->fdip_observation_next_business }}</b></p>
                            <ul style="list-style-type:disc;margin-left:15px;">
                                @if ($observation_next_year[0]->fdip_observation_next_highlight != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_highlight }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_highlight_two != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_highlight_two }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_highlight_three != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_highlight_three }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_highlight_four != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_highlight_four }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_highlight_five != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_highlight_five }}
                                </li>
                                @endif
                            </ul>
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">4</th>
                        <th style="width: 55%;">What makes this family deserving to<br>
                            receive a loan? </th>
                        <td style="width: 40%;">
                            <ul style="list-style-type:disc;margin-left:15px;">
                                @if ($observation_next_year[0]->fdip_observation_next_what != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_what }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_what_b_4 != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_what_b_4 }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_what_c_4 != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_what_c_4 }}
                                </li>
                                @endif
                            </ul>
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">5</th>
                        <th style="width: 55%;">What do you think wold be biggest risk in<br>
                            lending to them?
                        </th>
                        <td style="width: 40%;">
                            <ul style="list-style-type:disc;margin-left:15px;">
                                @if ($observation_next_year[0]->fdip_observation_next_risk != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_risk }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_risk_b_5 != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_risk_b_5 }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_risk_c_5 != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_risk_c_5 }}
                                </li>
                                @endif
                            </ul>
                        </td>


                    </tr>
                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">6</th>
                        <th style="width: 55%;">How would VIV loan improve their life?</th>
                        <td style="width: 40%;">
                            <ul style="list-style-type:disc;margin-left:15px;">
                                @if ($observation_next_year[0]->fdip_observation_next_how != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_how }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_how_b_6 != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_how_b_6 }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_how_c_6 != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_how_c_6 }}
                                </li>
                                @endif
                            </ul>
                        </td>


                    </tr>

                    <tr style="text-align:start">
                        <th style="width: 5%;text-align:center;">7</th>
                        <th style="width: 55%;">Did you observe any change in the family<br>
                            from the 1st visit?, if yes describe</th>
                        <td style="width: 40%;">
                            <p> <b>{{ $observation_next_year[0]->fdip_observation_next_did }}
                                </b></p>
                            <ul style="list-style-type:disc;margin-left:15px;">

                                @if ($observation_next_year[0]->fdip_observation_next_any != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_any }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_any_two != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_any_two }}
                                </li>
                                @endif

                                @if ($observation_next_year[0]->fdip_observation_next_any_three != '')
                                <li>{{ $observation_next_year[0]->fdip_observation_next_any_three }}
                                </li>
                                @endif
                            </ul>
                        </td>

                </tbody>
            </table>
            <br>
            <table class="table table-bordered table-stripped table1 " cellspacing="0">
                <thead>
                    <tr class="table-primary" style="text-align: center;">
                        <td style="background-color:#D79477;text-align:left;width:60%;">Family/SHG Member Commitment
                        </td>
                        <td style="background-color:#ebe3e3;;text-align:left;width:40%;">
                            {{ $shgmember_commitment[0]->yo_member_aware_categories }}
                        </td>
                    </tr>
                </thead>
            </table>








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

            pdf.save("Family-Profile.pdf");
        });
    };
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    var a = 0;
    var b = 0;
    var c = 0;
    var d = 0;
    var e = 0;
    var f = 0;
    var g = 0;
    var h = 0;
    var i = 0;
    var j = 0;

    var agg = '{{ $income_this_year[0]->agriculture }}';
    if (agg != '') {
        a = '{{ $income_this_year[0]->agriculture }}';
    }
    var hor = '{{ $income_this_year[0]->horticulture }}';
    if (hor != '') {
        b = '{{ $income_this_year[0]->horticulture }}';
    }
    var live = '{{ $income_this_year[0]->livestock }}';
    if (live != '') {
        c = '{{ $income_this_year[0]->livestock }}';
    }
    var fixin = '{{ $income_this_year[0]->fixed_income_amount }}';
    if (fixin != '') {
        d = '{{ $income_this_year[0]->fixed_income_amount }}';
    }
    var pen = '{{ $income_this_year[0]->pension_income_monthly }}';
    if (pen != '') {
        e = '{{ $income_this_year[0]->pension_income_monthly }}';
    }

    var sale = '{{ $income_this_year[0]->sale_of_livestock }}';
    if (sale != '') {
        f = '{{ $income_this_year[0]->sale_of_livestock }}';
    }

    var money = '{{ $income_this_year[0]->money_lending }}';
    if (money != '') {
        g = '{{ $income_this_year[0]->money_lending }}';
    }

    var casual = '{{ $income_this_year[0]->casual_income_amount }}';
    if (casual != '') {
        h = '{{ $income_this_year[0]->casual_income_amount }}';
    }

    var trade = '{{ $income_this_year[0]->trade_income_amount }}';
    if (trade != '') {
        i = '{{ $income_this_year[0]->trade_income_amount }}';
    }

    var other = '{{ $income_this_year[0]->other_income }}';
    if (other != '') {
        j = '{{ $income_this_year[0]->other_income }}';
    }



    var total = parseFloat(a) + parseFloat(b) + parseFloat(c) + parseFloat(d) + parseFloat(e) + parseFloat(f) + parseFloat(g) + parseFloat(h) + parseFloat(i) + parseFloat(j);

    var agriculture = Math.round((a / total) * 100);
    var horticulture = Math.round((b / total) * 100);
    var livestock = Math.round((c / total) * 100);
    var fixed = Math.round((d / total) * 100);
    var pension = Math.round((e / total) * 100);
    var sales = Math.round((f / total) * 100);
    var money = Math.round((g / total) * 100);
    var casual = Math.round((h / total) * 100);
    var trade = Math.round((i / total) * 100);
    var other = Math.round((j / total) * 100);

    var n = 0;
    var s = 0;
    var w = 0;
    var l = 0;

    var nor = '{{ $this_year_normal[0]->total }}';
    if (nor != '') {
        n = '{{ $this_year_normal[0]->total }}';
    }
    var soc = '{{ $this_year_Social[0]->total }}';
    if (soc != '') {
        s = '{{ $this_year_Social[0]->total }}';
    }
    var wast = '{{ $this_year_wasteful[0]->total }}';
    if (wast != '') {
        w = '{{ $this_year_wasteful[0]->total }}';
    }
    var lon = '{{ $loan_expensture_total[0]->loan_this_year }}';
    if (lon != '') {
        l = '{{ $loan_expensture_total[0]->loan_this_year }}';
    }

    var e_total = parseFloat(n) + parseFloat(s) + parseFloat(w) + parseFloat(l);

    var normal = Math.round((n / e_total) * 100);
    var social = Math.round((s / e_total) * 100);
    var wasteful = Math.round((w / e_total) * 100);
    var loan = Math.round((l / e_total) * 100);

    var income_this = '{{ $total_income_this_year }}';
    var expenditure_this = '{{ $total_expenditure_this_year }}';
    var income_this_year = parseInt(income_this);
    var expenditure_this_year = parseInt(expenditure_this);





    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Agriculture', agriculture],
            ['Horticulture', horticulture],
            ['Livestock', livestock],
            ['Fixed Income', fixed],
            ['Pension Income', pension],
            ['Sale of livestock', sales],
            ['Money lending', money],
            ['Casual Income', casual],
            ['Trade Income', trade],
            ['Other Income', other]
        ]);

        var data2 = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Normal  Expenditure', normal],
            ['Social  Expenditure', social],
            ['Wateful  Expenditure', wasteful],
            ['Loan  Expenditure', loan]

        ]);



        var options = {
            title: '',

        };
        var options2 = {
            title: '',
            pieHole: 0.4,
        };


        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
        var chart2 = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart2.draw(data2, options2);

    }
    const maxValue = Math.max(income_this_year, expenditure_this_year);
    const increment = 100000;
    const resultArray = [];

    for (let value = increment; value <= maxValue + increment; value += increment) {
        resultArray.push(value);
    }

    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {

        var data = google.visualization.arrayToDataTable([
            ['', '', {
                role: 'style'
            }, {
                type: 'string',
                role: 'annotation'
            }],
            ['Income ', income_this_year, '  fill-color: #008000; ', income_this_year],
            ['Expenditure', expenditure_this_year, 'fill-color: #FF0000; ', expenditure_this_year]
        ]);

        var options = {
            title: '',

            chartArea: {
                width: '80%'
            },
            annotations: {
                alwaysOutside: true,
                textStyle: {
                    fontSize: 20,
                    auraColor: '',
                    color: '#000000'
                },
                boxStyle: {
                    stroke: '#ccc',
                    strokeWidth: 1,
                    gradient: {
                        color1: '#f3e5f5',
                        color2: '#f3e5f5',
                        x1: '0%',
                        y1: '0%',
                        x2: '100%',
                        y2: '100%'
                    }
                }

            },
            hAxis: {
                title: 'Values',
                format: '0', // Format the values without decimal places
                // Set the interval (step) you want for the axis
                ticks: resultArray,


            },
        };
        var chart = new google.visualization.BarChart(document.getElementById('top_x_div'));

        chart.draw(data, options);
    }
</script>