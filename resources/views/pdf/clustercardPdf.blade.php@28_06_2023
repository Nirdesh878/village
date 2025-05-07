<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cluster Rating Card</title>
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
    .tdc{text-align: center;}
</style>

<body class="antialiased container mt-5">
<h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generated On- @php
                echo generated_date();
                @endphp
            </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Cluster Rating Card({{ $cluster->uin }})<u> 
            </h2>
        </div>

    </div>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:#01a9ac" colspan="4">Cluster Rating Card </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Name</th>
                <td width="25%">{{ $profile[0]->name_of_cluster }}</td>
                <th width="25%">Federation Name</th>
                <td width="25%">{{ $fed_profile[0]->name_of_federation }}</td>
            </tr>
            <tr>
                <th width="25%">UIN</th>
                <td width="25%">{{ $cluster->uin }}</td>
                <th width="25%">State Name</th>
                <td width="25%">{{ $profile[0]->name_of_state }}</td>
            </tr>
            <tr>
                <th width="25%">District Name</th>
                <td width="25%">{{ $profile[0]->name_of_district }}</td>
                <th width="25%">Date</th>
                <td width="25%">{{ change_date_month_name_char  ($cluster->created_at) }}</td>
            </tr>
        </tbody>

    </table>
    
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead class="back-color">
            <tr>
                <th width="450px">Cluster Indicators</th>
                <td colspan="4"></td>
                <th colspan="" style="text-align:center;"> Actual Score </th>
                <th colspan="" style="text-align:center;"> Expected Score</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1 Governance</td>
                <td style="background-color: green;width:50px;">
                    @if ($score >= 90)
                    <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;">
                    @if ($score >= 75 && $score <= 89) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: lightgrey;width:50px;">
                    @if ($score >= 60 && $score <= 74) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: red;width:50px;">
                    @if ($score <= 59) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="text-align: center;">{{ $total1 }}</td>
                <td style="text-align: center;">25</td>
                {{-- <td>{{$score}}</td> --}}
            </tr>
            <tr>
                <td>2 Inclusion</td>
                <td style="background-color: green;width:50px;">
                    @if ($score1 >= 90)
                    <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;">
                    @if (round($score1) >= 75 && round($score1) <= 89) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: lightgrey;width:50px;">
                    @if ($score1 >= 60 && $score1 <= 74) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: red;width:50px;">
                    @if ($score1 <= 59) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="text-align: center;">{{ $total2 }}</td>
                <td style="text-align: center;">15</td>
                {{-- <td>{{round($score1)}}</td> --}}
            </tr>
            <tr>
                <td>3 Efficiency</td>
                <td style="background-color: green;width:50px;">
                    @if ($score2 >= 90)
                    <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;">
                    @if ($score2 >= 75 && $score2 <= 89) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: lightgrey;width:50px;">
                    @if ($score2 >= 60 && $score2 <= 74) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: red;width:50px;">
                    @if ($score2 <= 59) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="text-align: center;">{{ $total3 }}</td>
                <td style="text-align: center;">15</td>
                {{-- <td>{{round($score2)}}</td> --}}
            </tr>
            <tr>
                <td>4 Credit history</td>
                <td style="background-color: green;width:50px;">
                    @if ($score3 >= 90)
                    <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;">
                    @if ($score3 >= 75 && $score3 <= 89) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: lightgrey;width:50px;">
                    @if ($score3 >= 60 && $score3 <= 74) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: red;width:50px;">
                    @if ($score3 <= 59) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="text-align: center;">{{ $total4 }}</td>
                <td style="text-align: center;">30</td>
                {{-- <td>{{round($score3)}}</td> --}}
            </tr>

            <tr>
                <td>5 Saving</td>
                <td style="background-color: green;width:50px;">
                    @if ($score4 >= 90)
                    <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;">
                    @if ($score4 >= 75 && $score4 <= 89) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: lightgrey;width:50px;">
                    @if ($score4 >= 60 && $score4 <= 74) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="background-color: red;width:50px;">
                    @if ($score4 <= 59) <span class="checkmark"></span>
                        @endif
                </td>
                <td style="text-align: center;">{{ $total5 }}</td>
                <td style="text-align: center;">15</td>
                {{-- <td>{{round($score4)}}</td> --}}
            </tr>

        </tbody>
    </table>
   
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <tr>
            <th width="450px">Total Score</th>

            <td style="background-color: green;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                @if ($grand_total >= 90)
                {{ $grand_total }}
                @endif
            </td>


            <td style="background-color: yellow;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                @if ($grand_total >= 75 && $grand_total <= 89) {{ $grand_total }} @endif </td>
            </td>


            <td style="background-color: lightgrey;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                @if ($grand_total >= 60 && $grand_total <= 74) {{ $grand_total }} @endif </td>



            <td style="background-color: red;text-align:center;font-weight:bold;font-size:20px;width:50px;">
                @if ($grand_total <= 59) {{ $grand_total }} @endif </td>
                <td colspan="2"></td>

        </tr>
        

    </table>



    




</body>

</html>