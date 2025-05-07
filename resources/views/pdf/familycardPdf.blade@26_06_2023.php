<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Development Card</title>
</head>
<style>
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
        color: #ffffff;

        font-size: 16px;
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
</style>

<body class="antialiased container mt-5">
<h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generate On- @php
                echo generated_date();
                @endphp
            </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Family Development Card({{$family->uin}})</u>
            </h2>
        </div>

    </div>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:#01a9ac" colspan="4">Family Development Card </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Name of Member</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_member_name) }}</td>
                <th width="25%">Aadhar No</th>
                <td width="25%">{{ checkna(aadhar($family_profile[0]->fp_aadhar_no)) }}</td>
            </tr>
            <tr>
                <th width="25%">UIN</th>
                <td width="25%">{{ $family->uin }}</td>
                <th width="25%">Shg Name</th>
                <td width="25%">{{ checkna($shg_profile[0]->shgName) }}</td>
            </tr>
            <tr>
                <th width="25%">Cluster Name</th>
                <td width="25%">{{ (!empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A' ) }}</td>
                <th width="25%">Federation Name</th>
                <td width="25%">{{ checkna($fed_profile[0]->name_of_federation) }}</td>
            </tr>
            <tr>
                <th width="25%">State Name</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_state) }}</td>
                <th width="25%">District Name</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_district) }}</td>
            </tr>
            <tr>
                <th width="25%">Village Name</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_village) }}</td>
                <th width="25%">Date</th>
                <td width="25%">{{change_date_month_name_char(str_replace('/','-',$family->created_at))}}</td>
            </tr>

        </tbody>

    </table>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead class="back-color">
            <tr>
                <th width="450px">FDP Indicators</th>
                <td colspan="4"></td>
                <th colspan="" style="text-align:center;"> Actual Score </th>
                <th colspan="" style="text-align:center;"> Expected Score</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1 Family Budget</td>
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
                <td style="text-align: center;">{{$total_cy1}}</td>
                <td style="text-align: center;">20</td>
                {{--<td>{{round($score)}}</td>--}}
            </tr>
            <tr>
                <td>2 Family Saving</td>
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
                <td style="text-align: center;">{{$total_cy2}}</td>
                <td style="text-align: center;">25</td>
                {{--<td>{{round($score1)}}</td>--}}
            </tr>
            <tr>
                <td>3 Family Credit History</td>
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
                <td style="text-align: center;">{{$total_cy3}}</td>
                <td style="text-align: center;">40</td>
                {{--<td>{{round($score2)}}</td>--}}
            </tr>
            
            <tr>
                <td>4 Family Commitment to Group Rules</td>
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
                <td style="text-align: center;">{{$total_ny4}}</td>
                <td style="text-align: center;">15</td>
                {{--<td>{{round($score3)}}</td>--}}
            </tr>
        </tbody>
    </table>
    

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <tr>
            <th width="450px">Total Score</th>

            <td style="background-color: green;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                @if($grand_total_cy >=90)
                {{$grand_total_cy }}
                @endif
            </td>


            <td style="background-color: yellow;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                @if($grand_total_cy >=75 && $grand_total_cy <=89) {{$grand_total_cy }} @endif </td>


            <td style="background-color: lightgrey;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                @if($grand_total_cy >=60 && $grand_total_cy <=74) {{$grand_total_cy }} @endif </td>


            <td style="background-color: red;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                @if($grand_total_cy <=59) {{$grand_total_cy }} @endif </td>
            <td colspan="2"></td>
        </tr>
        

    </table>



   




</body>

</html>