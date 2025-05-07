<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Federation Rating Card</title>
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
    .tdc{text-align: center;}
    
</style>

<body class="antialiased container mt-5">
<h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generate On- @php
                echo generated_date();
                @endphp
            </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;margin-top:-2px;"><u>Federation Rating card({{$federation->uin}})</u>
            </h2>
        </div>

    </div>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:#01a9ac" colspan="4">Federation Rating Card </td>
            </tr>
        </thead>
        <tbody>
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
        </tbody>

    </table>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead class="back-color">
            <tr>
                <th width="450px">Federation Indicators</th>
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
                <th width="450px">Total Score</th>
                <td style="background-color: green;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                    @if($analysis_final_total >=90)
                    {{$analysis_final_total }}
                    @endif
                </td>
                <td style="background-color: yellow;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                    @if($analysis_final_total >=75 && $analysis_final_total <=89) {{$analysis_final_total }} @endif </td>
    
    
                <td style="background-color: lightgrey;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                    @if($analysis_final_total >=60 && $analysis_final_total <=74) {{$analysis_final_total }} @endif </td>
    
                <td style="background-color: red;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                    @if($analysis_final_total <=59) {{$analysis_final_total }} @endif </td>
                    <td colspan="2"></td>
            </tr>

        </tbody>
    </table>
   
    
</body>

</html>