<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cluster Profile</title>
    <link href='https://fonts.googleapis.com/css?family=Didact Gothic' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Cardo' rel='stylesheet'>
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
        @page {
            size: A4;
            margin: 0;
        }
      
        body {
           
            padding: 70px; 
            font-family: 'Didact Gothic';
        }
        @media (max-width: 500px)
         {
            .table-container table, .table-containers table
             {
                width: 100%;
                font-size:15px;
            }
        }
        .table-container{
            display: flex;
            
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
        
        
        }
        .table-containers{
            display: flex;
            width: 100%;
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
        }
       

        
        
        h3,h1,h5{ text-align: center; font-family: 'Cardo';}

        #report{ padding: 10px;
            position: absolute;
             right: 70px;
             width: 20%;
             }

        .table-container table {
            flex: 1;
            margin-right:15px;
        
           
           
        }
        .table-containers table {
            flex: 1;
            margin-right:15px;
           
        
            
        }

        .round
        {
        border-radius: 85%;
        width: 35px;
        height: 35px;
        }

        * {
            background-color: #f1f0f0;
           
        }

        th {
            background-color: #cea38b;
            font-weight: normal;

        }

        th, td {
            border: 2px solid #ffffff;
            text-align: left;
            padding: 8px;
            width: fit-content;
        }

        .table-container td:nth-child(1) {
            background-color: #f5f6f7;
        }

        #grey , #cs td:nth-child(1) {
            background-color: #d5d4d4;
        }

        #white {
            background-color: #ffffff;
        }

        #ep{ width: 80%;}
        #sp{ width: 60%;}
        #sep{ width: 70%;}
        #qp{ width:25%;}
        #fp{ width:40%;}
        #hp{ width:50%;}
        #tp{ width: 30%;}
        #thp{ width: 15%;}
        #yp{ width: 5cm;}

       

        #LSF td:nth-child(2){ width: 30%;}
        #LSF td:nth-child(1){ width: 5%;}

        #ICP td:nth-child(1){ width: 50%;}
        #TD td {height: 0.5cm;}

        .table-container #mm td:nth-child(odd)
        { width: 25%;}

        .savings{  display: flex;
            width: 100%;
            align-items: center;
            text-align: center;
            margin-bottom: 20px;}

        .savings table{ flex: 1; }

        .savings td:nth-child(odd)  {
            background-color: #f5f6f7;
            width: 30%;
        }
        #DSS td:nth-child(odd), #CLB td:nth-child(odd),#BC td:nth-child(odd), #SAC td:nth-child(odd),#C td:nth-child(odd){
            background-color: #f5f6f7; 
        }

        
        #challenge td:nth-child(2){ width:25%  }
        #challenge td:nth-child(1){ width:5%}

        #observation td:nth-child(2){ width:40%}
        #observation td:nth-child(1){ width:5%}

        #summary td{height: 2cm;}

        .page-break 
        {
             page-break-before: always;
        }
            

    </style>
</head>
<body class="antialiased container mt-5">
    <div class="bar-wrp-m">
        <button class="btn btn-sm getPDFbtn" onclick="getPDF()">GET PDF</button>
    </div>
    <h1 style="font-size:40px" >CLUSTER PROFILE</h1>
    <table id="report">
        <tr>
            <th style="text-align:center;">Report Card</th>
            <td style="background-color: red; width: 35%;"></td>
        </tr>
    </table>
    <br>
    <div class="canvas_all_pdf">
        <h5 style="font-size:28px">ID UIN ***ID******************</h5>
        <div class="basic-information">
                
                                <h3 style="font-size:32px"><u>BASIC INFORMATION</u></h3>
                
            <div class="table-container" >
                
                    <table class="table table-bordered table-stripped table-responsive table1 " cellspacing="0" width="100%">
                        <tr>
                            <th colspan="2">Name & Other Details</th>
                        </tr>
                        <tr>
                            <td id="tp">UIN</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cluster Office Location</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>District</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>NRLM Code</td>
                            <td></td>
                        </tr>
                    </table>

                    <table class="table table-bordered table-stripped table1 " cellspacing="0" width="100%">
                        <tr>
                            <th colspan="2">Cluster Creation and Membership</th>
                        </tr>
                        <tr>
                            <td id="fp">Date Cluster was formed</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No of members at creation</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No of Current Members</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No of SHGs at creation</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No of current SHGs</td>
                            <td></td>
                        </tr>
                    </table>
                
            </div>

            <div class="table-container">
                    <table class="table table-bordered table-stripped table1 "  id="CLB" cellspacing="0" width="100%">
                        <tr>
                            <th colspan="2">Current Leadership Status</th>
                            <th colspan="2">Current Book Keeper</th>
                        </tr>
                        <tr>
                            <td id="qp">President/Animator</td>
                            <td id="qp"></td>
                            <td id="qp">Name</td>
                            <td id="qp"></td>
                        </tr>
                        <tr>
                            <td>Secretary</td>
                            <td></td>
                            <td>Date of Appointment</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Treasurer</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        

            <div class="table-container">
                
                    <table class="table table-bordered table-stripped table1 " id="BC" cellspacing="0" width="100%">
                        <tr>
                            <th colspan="2">Banking Details</th>
                            <th colspan="2">Contact Information</th>
                        </tr>
                        <tr>
                            <td id="qp">Account opening Date</td>
                            <td></td>
                            <td id="qp">Name of Contact</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td></td>
                            <td>Designation</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Branch</td>
                            <td></td>
                            <td>Contact Number</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Acc.No.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                    
                        </tr>
                    </table>
                </div>
            </div>

            <div class="page-break"></div>

            
            <h3 style="font-size:32px"><u>GOVERNANCE</u></h3>
            <div class="governance">
                <div class="table-container">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0" id="Adoption">
                        <tr>
                            <th colspan="2">Adoption</th>
                        </tr>
                        <tr> 
                            <td id="fp"> Adoption of Rules</td>
                            <td> </td>
                            </tr>
                        <tr> 
                            <td> Date of Adoption</td> 
                            <td> </td> 
                        </tr>
                        <tr> 
                            <td> Written Rules </td> 
                            <td> </td> 
                        </tr>
                    </table>
                    <table class="table table-bordered table-stripped table1 " id="DOE" cellspacing="0">
                        <tr>
                            <th colspan="2">Details on Election</th>
                        </tr>
                        <tr> 
                            <td id="sep"> Frequency as per norms</td> 
                            <td> </td> 
                        </tr>
                        <tr> 
                            <td> First Election date</td> 
                            <td> </td> 
                        </tr>
                        <tr> 
                            <td> Last Election date </td> 
                            <td> </td> 
                        </tr>
                        <tr> 
                            <td> No of Election Conducted so far</td> 
                            <td> </td> 
                        </tr>
                        <tr> 
                            <td> Last 2 Election As per Norms</td> 
                            <td> </td> 
                        </tr>
                    </table>
                </div>
                <div class="table-container">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="2">Meeting Details</th>
                        </tr>
                        <tr> 
                            <td id="sep">Frequency of Meetings</td> 
                            <td> </td>
                        </tr>
                        <tr> 
                            <td>No of meetings in last 12 months</td> 
                            <td> </td>
                        </tr>
                        <tr> 
                            <td>Average participation of members in 12 months</td> 
                            <td> </td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="2">Status Of Minutes During Last 12 Months</th>
                        </tr>
                        <tr> 
                            <td id="sep">Seprate minute book</td> 
                            <td> </td>
                        </tr>
                        <tr> 
                            <td>who writes the minutes</td> 
                            <td> </td>
                        </tr>
                        <tr> 
                            <td>Status of group meetings recorded</td> 
                            <td> </td>
                        </tr>
                    </table>
                </div>
                <div class="table-container">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="2" id="hp">Bank Accounts Details</th>
                            <th colspan="2">Grade</th>
                        </tr>
                        <tr> 
                            <td id="fp"> Bank accounts is regular operation during last 12 months</td>
                            <td id="grey"></td>
                            <td id="fp" > Grade During Last 12 Months</td> <td id="grey"></td></tr>
                    </table>
                </div>
                <div class="table-container">
                    <table id="SAC" class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="4">Social Audit Committee</th>
                        </tr>
                        <tr> 
                            <td id="qp"> Whether Cluster has a SAC</td>   
                            <td></td> <td id="qp"> SAC formation date</td> 
                            <td></td>
                        </tr>
                        <tr> 
                            <td> Function of SAC (describe)</td>   
                            <td></td> <td> <p>How many SAC reports prepared and submitted during last 12 months</p> </td> 
                            <td></td>
                        </tr>
                        <tr> 
                            <td> Date Of Report</td>   
                            <td></td> 
                            <td> </td> 
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="table-container">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th id="fp"> Audit</th> 
                            <th>Internal</th> 
                            <th>External</th>   
                        </tr>
                        <tr> 
                            <td> Internal/External Audit</td> 
                            <td></td> 
                            <td></td>   
                        </tr>
                        <tr> 
                            <td> How Often</td> 
                            <td></td> 
                            <td></td>   
                        </tr>
                        <tr> 
                            <td> Date of internal audit during last 12 months(Describe)</td> 
                            <td></td> 
                            <td></td>   
                        </tr>
                        <tr> 
                            <td> How many issues were resolved (Describe)</td> 
                            <td></td> 
                            <td></td>   
                        </tr>
                    </table>
                </div>

                <div class="page-break"></div>

                <div class="table-container">
                    
                    <table id="C" class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="2" style="width: 50%;"> Committees</th>
                            <td id="grey" colspan="2"></td>
                        </tr>
                        <tr> 
                            <td style="width: 25%;">Name </td> 
                            <td>    </td> 
                            <td style="width: 25%;"> Date Formed</td> 
                            <td></td>
                        </tr>
                        <tr> 
                            <td>Purpose</td>
                            <td> </td>
                            <td>No. Of Members</td>
                            <td> </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="table-container">
                    <table id="DSS" class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="4" > Defunct SHG Status</th>
                        </tr>
                        <tr> 
                            <td style="width: 30%;">Total SHGs formed in cluster </td> 
                            <td>    </td> 
                            <td style="width: 30%;"> At Present no of SHGs defunct</td>
                            <td></td>
                        </tr>
                        <tr> 
                            <td>Defunct SHGs (%)</td>
                            <td> </td>
                            <td>Reasons for defunct</td>
                            <td> </td></tr>
                    </table>
                </div>
            </div>
            <h3><u>INCLUSION</u></h3>
            <div class="inclusion">
                <div class="table-container">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th > Wealthy Ranking/Poverty Mapping </th>  
                            <td  style="background-color: #d5d4d4;"> </td>  
                        </tr>
                        <tr> 
                            <td id="hp">1st Poverty Mapping </td> 
                            <td> </td>
                        </tr>
                        <tr> 
                            <td>Last Update</td> 
                            <td> </td>
                        </tr>
                    </table>
                </div>
                <div class="table-containers" id="TD">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0" >
                        <tr>
                            <th colspan="4" id="white">Visual Povert Mapping</th>
                        </tr>
                        <tr> 
                            <th style="text-align:center"> No of Poorest & Vulnerable </th> 
                            <th style="text-align:center">No of poor </th> <th>No of Medium Poor</th> 
                            <th style="text-align:center">No of Rich</th>  
                        </tr>
                        <tr> 
                            <td style="text-align:center"> </td> 
                            <td style="text-align:center"> </td> 
                            <td style="text-align:center"> </td> 
                            <td style="text-align:center"> </td>
                        </tr>
                    </table>
                </div>
                <div class="table-containers" id="TD">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr>
                            <th colspan="3" id="white">Caste  Composition</th>
                        </tr>
                        <tr> 
                            <th style="text-align:center"> No of SC/ST </th> 
                            <th style="text-align:center">No of OBC </th> 
                            <th style="text-align:center">No of Others</th>   
                        </tr>
                        <tr> 
                            <td style="text-align:center"> </td> 
                            <td style="text-align:center"> </td> 
                            <td style="text-align:center"> </td> 
                        </tr>
                    </table>
                </div>

                <div class="page-break"></div>

                <div class="table-containers">
                    <table  class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="9" id="white"> Cumulative No of Loans and Amounts During Last 3 Years </th>
                        </tr>
                        <tr> 
                            <th rowspan="2"> Category </th> 
                            <th colspan="2" id="grey" style="text-align:center"> Cluster Loans</th> 
                            <th colspan="2" id="grey" style="text-align:center">External Loans</th>
                            <th colspan="2" id="grey" style="text-align:center">Other Loans</th>
                            <th colspan="2" id="grey" style="text-align:center">Total Loans</th>
                        </tr>
                        <tr> 
                            <th style="text-align:center">Loan Disbursed (#) </th> 
                            <th style="text-align:center"> Amount Disbursed (INR) </th> 
                            <th style="text-align:center">Loan Disbursed (#) </th> 
                            <th style="text-align:center"> Amount Disbursed (INR) </th> 
                            <th style="text-align:center">Loan Disbursed (#) </th> 
                            <th style="text-align:center"> Amount Disbursed (INR) </th>  
                            <th style="text-align:center">Loan Disbursed (#) </th> 
                            <th style="text-align:center"> Amount Disbursed (INR) </th>
                        </tr>
                        <tr> 
                            <td> Very poor & vulnerable</td> 
                            <td> </td> 
                            <td> </td> 
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr> 
                            <td> Poor </td> 
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr> 
                            <td> Medium Poor </td> 
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr> 
                            <td> Rich</td> 
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr> 
                            <td id="grey"> Total (INR)</td>
                            <td id="grey"> </td>
                            <td id="grey"> </td>
                            <td id="grey"> </td>
                            <td id="grey"> </td>
                            <td id="grey"> </td>
                            <td id="grey"> </td>
                            <td id="grey"> </td>
                            <td id="grey"> </td>
                        </tr>
                    </table >
                </div>
                <div class="table-containers">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="5" id="white"> No. Of HHs Benefited From All Loans During Last 12 Years  </th>
                        </tr>
                        <tr> 
                            <th rowspan="2" style="text-align:center"> Category </th> 
                            <th rowspan="2" style="text-align:center"> Cluster Member HHs</th> 
                            <th colspan="3" style="text-align:center">Recieved Loan(#)</th>
                        </tr>
                        <tr> 
                            <th style="text-align:center">Cluster Loan </th> 
                            <th style="text-align:center"> External Loan</th> 
                            <th style="text-align:center">Other Loan </th>
                        </tr>
                        <tr> 
                            <td> Very poor & vulnerable</td> 
                            <td> </td> 
                            <td> </td> 
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr> 
                            <td> Poor </td> 
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr> 
                            <td> Medium Poor </td> 
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr> 
                            <td> Rich</td> 
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr> 
                            <td id="grey"> Total (INR)</td>
                            <td id="grey"> </td>
                            <td id="grey"> </td>
                            <td id="grey"> </td>
                            <td id="grey"></td>
                        </tr>
                    </table>
                </div>
                <div class="table-container">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th> No of poor and most poor in Leadership Position</th> 
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="table-containers" id="TD">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr>
                            <th colspan="5" id="white" >Board Constitution</th>
                        </tr>
                        <tr>
                            <th style="text-align:center">Cluster Board Constitution</th>
                            <th style="text-align:center">Total no of Board members </th>
                            <th style="text-align:center">No of members from the poorest and vulnerable</th>
                            <th style="text-align:center">No of members from the poor</th>
                            <th style="text-align:center">No of members from middle and rich category</th>
                        </tr>
                        <tr>
                            <td style="text-align:center"> </td>
                            <td style="text-align:center"> </td>
                            <td style="text-align:center"> </td>
                            <td style="text-align:center"> </td>
                            <td style="text-align:center"> </td>
                        </tr>
                    </table>
                </div>

                <div class="page-break"></div>

                <div class="table-containers" id="TD">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr>
                            <th colspan="3" id="white" >Coverage of Target Population</th>
                        </tr>
                        <tr>
                            <th style="text-align:center">Total target poor in the cluster</th>
                            <th style="text-align:center">No of target poor mobilized in SHGs </th>
                            <th style="text-align:center">% of target poor mobilized in SHGs</th>
                        </tr>
                        <tr>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <h3 style="font-size:32px"><u>EFFICIENCY</u></h3>
            <div class="efficiency"> 
                <div class="table-container" id="ICP">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th> Integrated Credit Plan </th> 
                            <th style="background-color: #d5d4d4;"></th>
                        </tr>
                        <tr> 
                            <td> Date of Last Plan approved by Cluster</td>
                            <td></td>
                        </tr>
                        <tr> 
                            <td> Date it was submitted to Federation/Partner</td> 
                            <td> </td>
                        </tr>
                    </table>
                </div>
                <div class="table-containers" id="TD">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="5" id="white">Training Details</th>
                        </tr>
                        <tr> 
                            <th id="qp" style="text-align:center">Name of training </th> 
                            <th id="yp" style="text-align:center">Duration (days)</th>
                            <th style="text-align:center">Date</th>
                            <th style="text-align:center">Training recipient</th>
                            <th style="text-align:center">Name of Trainer</th>
                        </tr>
                        <tr>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td>
                        </tr>
                    </table>
                </div>
                <div class="table-containers" id="TD">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr>
                            <th colspan="2" id="white">Income and Expenses Duirng last 12 Months</th>
                        </tr>
                        <tr>
                            <th style="text-align:center">Income from all sources (INR) </th> 
                            <th style="text-align:center">Expenses (INR) </th>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> </td> 
                            <td style="text-align:center"> </td>
                        </tr>
                    </table>
                </div>
                <div class="table-containers" id="TD">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr>
                            <th colspan="3" id="white">Approval Process</th>
                        </tr>
                        <tr>
                            <th>No of days taken to approve loan application at cluster  </th> 
                            <th>Average Monthly loans during last 12 months </th> 
                            <th> Time taken from approval to cash in hand (days)</th>
                        </tr>
                        <tr> 
                            <td> </td> 
                            <td> </td> 
                            <td> </td>
                        </tr>
                    </table>
                </div>
                <div class="table-containers">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th id="sp"> Monthly report submitted (Date of last submittied report) </th> 
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="page-break"></div>

            <h3 style="font-size:32px"><u>CREDIT HISTORY</u></h3>
            <div class="credit_history">
                <div class="table-container">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th id="ep"> No of loan application recieved at Cluster duirng last 12 months </th> 
                            <td id="grey"> </td>
                        </tr>
                        <tr> 
                            <th > No of loan applications approved duirng last 12 months</th> 
                            <td id="grey"> </td>
                        </tr>
                        <tr> 
                            <th > Pending loan applications </th> 
                            <td id="grey"></td>
                        </tr>
                    </table>
                </div>
                <div class="table-container" id="cs">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                            <tr> 
                                <th id="white" colspan="6">No of Cumulative Loans Disbursed to Members During Last 3 Years </th>
                            </tr>
                            <tr> 
                                <th> Category</th> 
                                <th style="width: 15%; text-align:center ;"> Very Poor & Vulnerable</th> 
                                <th id="thp" style="text-align:center"> poor </th> 
                                <th id="thp" style="text-align:center"> Medium Poor </th> 
                                <th id="thp" style="text-align:center"> Rich </th> 
                                <th style="width:15% ; text-align:center"> Total Loans(#)</th>
                            </tr>
                            <tr> 
                                <td> Cluster Loans</td> 
                                <td style="text-align:center"> </td> 
                                <td style="text-align:center"></td> 
                                <td style="text-align:center"></td>
                                <td style="text-align:center"></td>
                                <td style="text-align:center"></td> 
                            </tr>
                            <tr>  
                                <td> Federation Loans</td> 
                                <td style="text-align:center"></td> 
                                <td style="text-align:center"></td> 
                                <td style="text-align:center"></td> 
                                <td style="text-align:center"></td> 
                                <td style="text-align:center"></td>  
                            </tr>
                            <tr>  
                                <td> Bank Loans</td> 
                                <td style="text-align:center"> </td> 
                                <td style="text-align:center"> </td> 
                                <td style="text-align:center"> </td> 
                                <td style="text-align:center"> </td> 
                                <td style="text-align:center"> </td>
                            </tr>
                            <tr>   
                                <td>Others</td> 
                                <td style="text-align:center"> </td> 
                                <td style="text-align:center"> </td> 
                                <td style="text-align:center"> </td> 
                                <td style="text-align:center"> </td> 
                                <td style="text-align:center"> </td> 
                            </tr>
                    </table>
                </div>
                <div class="table-containers">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="3" id="white" > Cummlative Loan Ammount</th>
                        </tr>
                        <tr> 
                            <th style="text-align:center">S.No </th> 
                            <th style="text-align:center">Institution</th> 
                            <th style="text-align:center"> Amount(INR)</th>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 1 </td> 
                            <td > Cluster </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 2 </td> 
                            <td> Federation </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 3 </td> 
                            <td> Bank </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 4 </td> 
                            <td> Other </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr > 
                            <td id="grey" colspan="2" style="text-align:center">Total</td>
                            <td id="grey" style="text-align:center"></td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-stripped table1 " cellspacing="0" style="margin-right:5px">
                        <tr> 
                            <th colspan="3" id="white" > No of Members HHs Received Loans During Last 3 Years</th>
                        </tr>
                        <tr> 
                            <th style="text-align:center" >S.No </th> 
                            <th style="text-align:center">Institution</th> 
                            <th style="text-align:center"> No of HHs Received Loans</th>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 1 </td> 
                            <td > Cluster Loan </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 2 </td> 
                            <td> Federation Loan </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 3 </td> 
                            <td> Bank Loan</td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 4 </td> 
                            <td> Other Loan </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> <td id="grey" colspan="2" style="text-align:center">Total</td>
                        <td id="grey" style="text-align:center"></td></tr>
                    </table>
                </div>

                <div class="page-break"></div>

                <div class="table-containers">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="7" id="white" > Demand Collection Balance (DCB) for repayment and current Loan Outstanding </th>
                        </tr>
                        <tr> 
                            <th style="text-align:center" >S.No </th> 
                            <th style="text-align:center">DCB</th> 
                            <th style="text-align:center"> Cluster Loans</th> 
                            <th style="text-align:center">Federation Loans</th> 
                            <th style="text-align:center"> Bank Loans</th> 
                            <th style="text-align:center"> Other Loans</th> 
                            <th style="text-align:center"> Summary Loan Portfolio</th>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 1 </td> 
                            <td> Total Loan Amount Given (INR) </td> 
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 2 </td> 
                            <td> Total Demand upto last month for active loans (INR) </td> 
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                        </tr>
                        
                        <tr> 
                            <td style="text-align:center"> 3 </td> 
                            <td> Actual Amount Paid upto last Month (INR) </td> 
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 4 </td> 
                            <td> Overdue Amount (INR)</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 5 </td> 
                            <td> Outstanding amount for active loans (INR)</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 6 </td> 
                            <td> Payment Ratio % </td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                        </tr>
                    </table>
                </div>
                <div class="table-containers">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0" >
                        <tr>
                            <th colspan="7" id="white">No. of Members Not Received Even a Single Loan During Last 3 Years</th>
                        </tr>
                        <tr> 
                            <th style="text-align:center"> S.No.</th> 
                            <th> Loan Type</th> 
                            <th colspan="4">Wealth Ranking</th> 
                            <th style="text-align:center">Total</th>
                        </tr>
                        <tr> 
                            <td rowspan="4" style="text-align:center">1</td> 
                            <td id="grey" style="text-align:center">Cluster Loans</td> 
                            <td id="grey" style="text-align:center"> Very poor & vulnerable </td> 
                            <td id="grey" style="text-align:center"> Poor </td> 
                            <td id="grey" style="text-align:center"> Medium Poor </td> 
                            <td id="grey" style="text-align:center"> Rich </td> 
                            <td > </td></tr>
                        <tr> 
                            <td> Last 12 months</td> 
                            <td id="thp"></td> 
                            <td id="thp"></td> 
                            <td id="thp"></td> 
                            <td id="thp"></td> 
                            <td id="thp"></td> 
                        </tr>
                        <tr> 
                            <td> Year before last</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                        </tr>
                        <tr> 
                            <td> 2 Year before last</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td  style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                        </tr>
                        <tr> 
                            <td rowspan="4">2</td> 
                            <td id="grey">Federation Loans</td> 
                            <td id="grey" style="text-align:center"> Very poor & vulnerable </td> 
                            <td id="grey" style="text-align:center"> Poor </td> 
                            <td id="grey" style="text-align:center"> Medium Poor </td> 
                            <td id="grey" style="text-align:center"> Rich </td> 
                            <td > </td>
                        </tr>
                        <tr> 
                            <td> Last 12 months</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                        </tr>
                        <tr> 
                            <td> Year before last</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"> </td> 
                            <td style="text-align:center"> </td> 
                        </tr>
                        <tr>
                            <td> 2 Year before last</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                        </tr>

                        <div class="page-break"></div>

                        <tr> 
                            <td rowspan="4">3</td> 
                            <td id="grey" style="text-align:center">Bank Loans</td> 
                            <td id="grey" style="text-align:center"> Very poor & vulnerable </td> 
                            <td id="grey" style="text-align:center"> Poor </td> 
                            <td id="grey" style="text-align:center"> Medium Poor </td> 
                            <td id="grey" style="text-align:center"> Rich </td> 
                            <td > </td>
                        </tr>
                        <tr> 
                            <td> Last 12 months</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> </tr>
                        <tr> 
                            <td> Year before last</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                        </tr>
                        <tr> 
                            <td> 2 Year before last</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                        </tr>
                        <tr> 
                            <td rowspan="4">4</td> 
                            <td id="grey" style="text-align:center">Other Loans</td> 
                            <td id="grey" style="text-align:center"> Very poor & vulnerable </td> 
                            <td id="grey" style="text-align:center"> Poor </td> 
                            <td id="grey" style="text-align:center"> Medium Poor </td> 
                            <td id="grey" style="text-align:center"> Rich </td> 
                            <td > </td>
                        </tr>
                        <tr> 
                            <td> Last 12 months</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                        </tr>
                        <tr> 
                            <td> Year before last</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                        </tr>
                        <tr> 
                            <td> 2 Year before last</td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                        </tr>
                    </table>
                </div>
                <div class="table-containers">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="4" id="white" >Loan Default</th>
                        </tr>
                        <tr> 
                            <th style="text-align:center">S.No </th> 
                            <th style="text-align:center">Institution</th> 
                            <th style="text-align:center"> No of Members</th> 
                            <th style="text-align:center">No of Loans</th>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 1 </td> 
                            <td> Cluster </td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 2 </td> 
                            <td> Federation </td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 3 </td> 
                            <td> Bank </td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 4 </td> 
                            <td> Other </td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td id="grey" colspan="2" style="text-align:center">Total</td>
                            <td id="grey" style="text-align:center"></td> 
                            <td id="grey" style="text-align:center"></td> 
                        </tr>
                    </table>
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="4" id="white" > PAR Status for more than 90 days in amount  </th>
                        </tr>
                        <tr> 
                            <th style="text-align:center">S.No </th> 
                            <th style="text-align:center">Loan Type</th> 
                            <th style="text-align:center"> Amount (INR) </th>
                            <th style="text-align:center"> Percentage (%)</th>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 1 </td> 
                            <td > Cluster </td> 
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 2 </td> 
                            <td> Federation </td> 
                            <td style="text-align:center"></td>  
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 3 </td> 
                            <td> Bank </td> 
                            <td style="text-align:center"></td>  
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 4 </td> 
                            <td> Other </td>  
                            <td style="text-align:center"></td> 
                            <td style="text-align:center"></td> 
                        </tr>
                        <tr > 
                            <td id="grey" colspan="2" style="text-align:center">Total</td>
                            <td id="grey" style="text-align:center"></td>
                            <td id="grey" style="text-align:center"></td>
                        </tr>
                    </table>
                </div>
                <div class="table-containers">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="3" id="white" > Purpose of All Loans During Last 12 Months</th>
                        </tr>
                        <tr> 
                            <th style="text-align:center" >S.No </th> 
                            <th style="text-align:center">Purpose</th> 
                            <th style="text-align:center"> All Loans (Cluste & External)</th>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 1 </td> 
                            <td> Productive </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 2 </td> 
                            <td> Consumption </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 3 </td> 
                            <td> Debt Swapping </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 4 </td> 
                            <td> Other </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td id="grey" colspan="2" style="text-align:center">Total</td>
                            <td id="grey" style="text-align:center"></td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="3" id="white" > Cummulative Interest Income </th>
                        </tr>
                        <tr> 
                            <th style="text-align:center" >S.No </th> 
                            <th style="text-align:center">Institution</th> 
                            <th style="text-align:center"> Income Generated Amount (INR)</th>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 1 </td> 
                            <td> Cluster </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 2 </td> 
                            <td> Federation </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 3 </td> 
                            <td> Bank </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 4 </td> 
                            <td> Other </td> 
                            <td style="text-align:center"></td>
                        </tr>
                        <tr > 
                            <td id="grey" colspan="2" style="text-align:center">Total</td>
                            <td id="grey" style="text-align:center"></td>
                        </tr>
                    </table>
                </div>

                <div class="page-break"></div>

                <div class="table-containers">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th id="ep"> Average Loan Number And Amount During Last 12 Months</th> 
                            <th id="grey"></th>
                        </tr>
                    </table>
                </div>
                <div class="table-containers">
                    <table id="mm" class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="4"> Minimum and Maximum Loan Amount During Last 12 Months</th> 
                        </tr>
                        <tr> 
                            <td id="grey" > Maximum Amount</td> 
                            <td style="text-align:center"></td> 
                            <td id="grey"> Maximum Amount</td> 
                            <td style="text-align:center"></td> 
                        </tr>
                    </table>
                </div>
                <div class="table-containers">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0" >
                        <tr> 
                            <th id="ep"> Members taken more than one Loan During Last 3 Years</th> 
                            <th id="grey"></th>
                        </tr>
                    </table>
                </div>
            </div>
            <h3 style="font-size:32px"><u>SAVINGS</u></h3>
            <div >
                <div class="savings">
                    <table  class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr> 
                            <th colspan="4"> Compulsory Savings</th>
                        </tr>
                        <tr> 
                            <td> Compulsory Savings </td> 
                            <td> </td> 
                            <td>Amount of Savings per month (INR) </td> 
                            <td></td>
                        </tr>
                        <tr> 
                            <td> Average Monthly Savings during last 12 months(INR) </td> 
                            <td> </td> 
                            <td>Cummlative Savings since inception (INR) </td> 
                            <td> </td>
                        </tr>
                    </table>
                </div>
                <div class="savings">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr>
                            <th colspan="4">Voluntary Savings</th>
                        </tr>
                        <tr>
                            <td>Voluntary Savings </td> 
                            <td></td>  
                            <td>Average Amount of Savings per month (INR) </td> 
                            <td> </td>
                        </tr>
                        <tr>
                            <td>Cumulative savings to-date inception (INR) </td> 
                            <td></td> 
                            <td>Interest paid to members (Y/N)</td> 
                            <td> </td>
                        </tr>
                        <tr>
                            <td>No of members contribute to voluntary savings </td> 
                            <td></td> 
                            <td>Are savings redistributed to members (Y/N)</td> 
                            <td> </td>
                        </tr>
                        <tr>
                            <td> Date voluntary savings established</td> 
                            <td></td> 
                            <td>Date of last Redistribution</td> 
                            <td> </td>
                        </tr>
                    </table> 
                </div>
                <div class="table-containers" id="LSF">
                    <table class="table table-bordered table-stripped table1" cellspacing="0">
                        <tr> 
                            <th colspan="3">Loan Security Fund(LSF) </th>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 1 </td> 
                            <td> Loan Security Fund (LSF)</td> 
                            <td></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 2 </td> 
                            <td> Date it was established </td> 
                            <td></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 3 </td> 
                            <td> Amount available in LSF </td> 
                            <td></td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 4 </td> 
                            <td> No of members contribute to LSF</td> 
                            <td> </td>
                        </tr>
                        <tr> 
                            <td style="text-align:center"> 5 </td> 
                            <td> No of members benefited from LSF</td> 
                            <td> </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="page-break"></div>

            <h3 style="font-size:32px"><u>CHALLENGES & ACTION PLAN</u></h3>
            <div class="row" style="display:flex width:100% ; ">
                <div class="col-sm-6">
                    <div style=" width:100%; height:200px;border-radius: 90px; background-color: #d5d4d4;">
            
                    </div>
                </div>
            </div>
            
            <br>
            <div class="table-containers" id="challenge">
                <table class="table table-bordered table-stripped table1 " cellspacing="0">
                    <tr> 
                        <th colspan="4" id="white">Action Plan To Address The Challenges</th>
                    </tr>
                    <tr> 
                        <th> S.No </th> 
                        <th> Action Plan </th> 
                        <th> Challenge 1 </th> 
                        <th> challenge 2</th>
                    </tr>
                    <tr> 
                        <td> 1 </td>
                        <td>Describe Action </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                    <tr> 
                        <td> 2 </td>
                        <td>Person Responsible </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                    <tr> 
                        <td> 3 </td>
                        <td> Completion Date</td>
                        <td> </td>
                        <td> </td>
                    </tr>

                    <div class="page-break"></div>

                    <tr> 
                        <td> 4 </td>
                        <td>Support needed from project office </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                    <tr> 
                        <td> 5 </td>
                        <td>What kind of support? </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                </table>
            </div>
            <h3 style="font-size:32px"><u>OBSERVATIONS</u></h3>
            <div class="observation">
                <div class="table-containers" id="observation">
                <table class="table table-bordered table-stripped table1 " cellspacing="0">
                    <tr> 
                        <th   style="text-align:center">S.No</th>
                        <th  style="text-align:center">Question</th>
                        <th  style="text-align:center">Answer</th>
                    </tr>
                    <tr> <td>1a</td> <td>How many members attended the cluster meeting?  </td> <td> </td></tr>
                    <tr> <td>1b </td> <td> Were all office bearers and leaders present?   </td> <td> </td></tr>
                    <tr> <td> 2</td> <td> Did Cluster leaders understand the Purpose of the meeting ? </td> <td> </td></tr>
                    <tr> <td> 3</td> <td>What was quality of Discussion? Did everyone participate? </td> <td> </td></tr>
                    <tr> <td> 4a</td> <td>Where Cluster leaders aware of their rules and norms? Did they understand vision of their Cluster? </td> <td> </td></tr>
                    <tr> <td> 4b</td> <td>Do they understand benefits of being part of the Cluster ? Explain  </td> <td> </td></tr>
                    <tr> <td> 5a</td> <td>Do they have a set of important practices for repayment and savings? </td> <td> </td></tr>
                    <tr> <td>5b </td> <td>What are those practices? </td> <td> </td></tr>
                    <tr> <td>6a </td> <td>Does this Cluster include members who are the most poor and vulnerable?  </td> <td> </td></tr>
                    <tr> <td>6b </td> <td>What is their policy to help them? </td> <td> </td></tr>
                    <tr> <td>7a </td> <td> Does Cluster have a satisfactory/weak or good system of reporting and updating of documents?</td> <td> </td></tr>
                    <tr> <td>7b </td> <td> Who writes these books and minutes of meetings?</td> <td> </td></tr>
                    <tr> <td>8a</td> <td>Are books of account manages by the booker only or are other office bearers aware of their financial information </td> <td> </td></tr>
                    <tr> <td>8b </td> <td>Any highlights </td> <td> </td></tr>
                    <tr> <td>9a </td> <td>Did you notice any unique features and practices that make it special ? </td> <td> </td></tr>
                    <tr> <td>9b </td> <td>What are those special practices? </td> <td> </td></tr>
                </table>
                </div>
                <div class="table-container" id="summary">
                    <table class="table table-bordered table-stripped table1 " cellspacing="0">
                        <tr><th>Summary of important 3- 5 highlights (positive and improvement points) about this Federation</th></tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>
                    </table>
                </div>
            </div>
        </div>
</body>
</html>