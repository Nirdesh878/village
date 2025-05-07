<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Federation Development Card</title>
</head>
<style>
    .table1 {
        width: 100%;
    }

    .table {
        border: none;
    }

    .table td,
    .table th {
        padding: .50rem;
        font-weight: bold;
    }


    .table td th {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
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
        width: 10px;
        height: 20px;
        border-right: 2px solid black;
        border-bottom: 2px solid black;
        transform: rotate(45deg);
    }
</style>

<body>


    <div style="text-align: left;">
        <img src="{{ public_path('images/logo1.jpg') }}" alt="Logo"
            style="width: 100px; height: 100px; display: inline-block;margin:auto 10px">
    </div>
    <div style="text-align: right;">
        <img src="{{ public_path('images/logo.jpg') }}" alt="Logo"
            style="width: 150px; height: auto; display: inline-block;margin-top:-80px;">
    </div>
    <div class="d-inline">
        <h3
            style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:28px;color:rgba(7, 83, 146, 0.726);position: relative;top:-120px;">
            FEDERATION INSTITUTIONAL DEVELOPMENT CARD
        </h3>
    </div>

    <table class="table table-bordered table-stripped table1 " cellspacing="0" style="margin-top: -120px;">

        <tbody>
            <tr>
                <th width="17%" style="text-align: left">Federation Name:</th>
                <td width="16%" style="text-align: left">{{ $profile[0]->name_of_federation}}</td>
                <td width="16%" style="text-align: left">UIN:</td>
                <td width="16%" style="text-align: left">{{ $federation->uin }}</td>
                <th width="16%" style="text-align: left">DATE:</th>
                <td width="26%" style="text-align: left">{{ change_date_month_name_char(str_replace('/', '-', $federation->created_at)) }}</td>
            </tr>
            <tr>
                <th width="17%" style="text-align: left">State:</th>
                <td width="16%" style="text-align: left">{{ $profile[0]->name_of_state }}</td>
                <td width="16%" style="text-align: left"> District:</td>
                <td width="16%" style="text-align: left">{{ $profile[0]->name_of_district }}</td>
                <th width="16%" style="text-align: left"> Block Name:</th>
                <td width="26%" style="text-align: left">{{ $profile[0]->block }}</td>
            </tr>
            {{-- <tr>
                <th width="17%"> Village Name:</th>
                <td width="16%"></td>
                <td width="16%"> </td>
                <td width="16%"></td>
                <th width="16%"></th>
                <td width="26%"></td>
            </tr> --}}

        </tbody>

    </table>
    <br>

    <div class="page-header-title" style="margin-top: -50px;">
        <div class="d-inline">
            <h3 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:40px;"
                style="margin:0px 0px">
                Federation Assessment:
            </h3>
        </div>
        <table class="table table-bordered table-stripped table1" cellspacing="20" style="width: 65%; margin: auto;margin-top:-40px;">
            <tbody>
                <tr style="margin-left: 20px;">
                    <td>1. Governance</td>
                    <td style="background-color: green; width: 20px; height: 10px;">
                        @if ($score >= 90)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: yellow; width: 20px; height: 10px;">
                        @if ($score >= 75 && $score <= 89)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: lightgrey; width: 20px; height: 10px;">
                        @if ($score >= 60 && $score <= 74)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: red; width: 20px; height: 10px;">
                        @if ($score <= 59)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>2. Inclusion</td>
                    <td style="background-color: green; width: 20px; height: 10px;">
                        @if ($score1 >= 90)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: yellow; width: 20px; height: 10px;">
                        @if ($score1 >= 75 && $score1 <= 89)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: lightgrey; width: 20px; height: 10px;">
                        @if ($score1 >= 60 && $score1 <= 74)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: red; width: 20px; height: 10px;">
                        @if ($score1 <= 59)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                </tr>
                
                <tr>
                    <td>3. Efficiency</td>
                    <td style="background-color: green; width: 20px; height: 10px;">
                        @if ($score2 >= 90)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: yellow; width: 20px; height: 10px;">
                        @if ($score2 >= 75 && $score2 <= 89)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: lightgrey; width: 20px; height: 10px;">
                        @if ($score2 >= 60 && $score2 <= 74)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: red; width: 20px; height: 10px;">
                        @if ($score2 <= 59)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                </tr>
                
                
                <tr>
                    <td>4. Credit History</td>
                    <td style="background-color: green; width: 20px; height: 10px;">
                        @if ($score3 >= 90)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: yellow; width: 20px; height: 10px;">
                        @if ($score3 >= 75 && $score3 <= 89)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: lightgrey; width: 20px; height: 10px;">
                        @if ($score3 >= 60 && $score3 <= 74)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: red; width: 20px; height: 10px;">
                        @if ($score3 <= 59)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>5. Sustainability</td>
                    <td style="background-color: green; width: 20px; height: 10px;">
                        @if ($score4 >= 90)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: yellow; width: 20px; height: 10px;">
                        @if ($score4 >= 75 && $score4 <= 89)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: lightgrey; width: 20px; height: 10px;">
                        @if ($score4 >= 60 && $score4 <= 74)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: red; width: 20px; height: 10px;">
                        @if ($score4 <= 59)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>5. Risk Management</td>
                    <td style="background-color: green; width: 20px; height: 10px;">
                        @if ($score5 >= 90)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: yellow; width: 20px; height: 10px;">
                        @if ($score5 >= 75 && $score5 <= 89)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: lightgrey; width: 20px; height: 10px;">
                        @if ($score5 >= 60 && $score5 <= 74)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                    <td style="background-color: red; width: 20px; height: 10px;">
                        @if ($score5 <= 59)
                            <span class="checkmark"></span>
                        @endif
                    </td>
                </tr>
                
            </tbody>
        </table>
        @php
            $color = '';
            if ($analysis_final_total >= 90) {
                $color = 'green';
            } elseif ($analysis_final_total >= 75 && $analysis_final_total <= 89) {
                $color = 'yellow';
            } elseif ($analysis_final_total >= 75 && $analysis_final_total <= 89) {
                $color = 'yellow';
            } elseif ($analysis_final_total >= 60 && $analysis_final_total <= 74) {
                $color = 'lightgrey';
            } elseif ($analysis_final_total <= 59) {
                $color = 'red';
            }
        @endphp
        <footer style="margin-left: 200px; width: 100%; font-size: 30px;">
            <b>Overall Rating</b>
            <div
                style="height: 35px; width: 250px; border: 1px solid black; display: inline-block; margin-top:10px;margin-left:200px;background-color:{{ $color }};text-align:center;">
                
            </div>
        </footer>
        <br>

    </div>
    <div style="text-align: left;">
        <img src="{{ public_path('images/logo1.jpg') }}" alt="Logo"
            style="width: 100px; height: 100px; display: inline-block;margin:auto 10px">
    </div>
    <div style="text-align: right;">
        <img src="{{ public_path('images/logo.jpg') }}" alt="Logo"
            style="width: 150px; height: auto; display: inline-block;margin-top:-80px;">
    </div>
    <div class="page-header-title">
        <div class="d-inline">
            <h3
                style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:26px;color:rgba(7, 83, 146, 0.726);position: relative;top:-100px;">
                FEDERATION GOALS, CHALLENGES & ACTION PLAN

            </h3>
        </div>


    </div>
    <div style="display: flex;position: relative;top:-100px;">
        <div style=" width:100%;">
            <div class="page-header-title">
                <div class="d-inline">
                    <h3 style="font-family: Arial, Helvetica, sans-serif;text-align:start;font-size:20px;"
                        style="margin:0px 0px">FEDERATION Name:&nbsp; {{ $profile[0]->name_of_federation }}
                    </h3>
                </div>
                <div class="d-inline" style="margin-left:700px;margin-top:-80px;">
                    <h3 style="font-family: Arial, Helvetica, sans-serif;text-align:start;font-size:20px;"
                        style="margin:0px 0px">UIN:&nbsp;{{ $federation->uin }}
                    </h3>
                </div>
            </div>
            
            <table style=" border-collapse: collapse;width:100%;">
                <tbody>
                    <tr>
                        <th
                            style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;">
                        </th>
                        <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd ">Federation
                            challenges</th>
                    </tr>
                    @php $i=1; @endphp
                    @if (!empty($challenges))
                        @foreach ($challenges as $row)
                            <tr>
                                <td
                                    style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;">
                                    {{ $i++ }}</td>

                                <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">
                                    {{ $row->challenge }}</td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>

            </table>
        </div>
        
    </div>

    <table style="width: 100%; border-collapse: collapse;margin-top:-60px;">
        <tbody>
            <tr>
                <th
                    style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;">
                </th>
                <th
                    style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;width:48%;">
                    Action Plan 
                </th>
                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;width:48%;">
                    Completion Date 
                </th>
            </tr>
            @php $i=1; @endphp
            @if (!empty($actions))
                @foreach ($actions as $row)
                    <tr>
                        <td
                            style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;">
                            {{ $i++ }}</td>
                        <td
                            style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;">
                            {{ $row->action }}</td>
                                <td
                                    style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;">
                                    {{ $row->complete_date }}</td>
                         
                    </tr>
                @endforeach
            @endif





        </tbody>

    </table>
    <br>
    <footer style="margin-left: 400px; width: 100%; font-size: 30px;">
        <b>Overall Rating</b>
        <div
                style="height: 35px; width: 250px; border: 1px solid black; display: inline-block; margin-top:10px;margin-left:200px;background-color:{{ $color }};text-align:center;">
                
            </div>
    </footer>
</body>

</html>
