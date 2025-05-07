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
            style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:40px;color:rgba(7, 83, 146, 0.726);position: relative;top:-120px;">
            FAMILY DEVELOPMENT CARD
        </h3>
    </div>

    <table class="table table-bordered table-stripped table1 " cellspacing="0" style="margin-top: -120px;">

        <tbody>
            <tr >
                <th width="17%" style="text-align: left">Member Name:</th>
                <td width="16%" style="text-align: left">{{ $family_profile[0]->fp_member_name }}</td>
                <td width="16%" style="text-align: left">UIN:</td>
                <td width="16%" style="text-align: left">{{ $family->uin }}</td>
                <th width="16%" style="text-align: left">DATE:</th>
                <td width="26%" style="text-align: left">{{ change_date_month_name_char(str_replace('/', '-', $family_sub_mst[0]->updated_at)) }}</td>
            </tr>


            <tr>
                <th width="17%" style="text-align: left">SHG Name:</th>
                <td width="16%" style="text-align: left">{{ checkna($shg_profile[0]->shgName) }}</td>
                <td width="16%" style="text-align: left"> Cluster Name:</td>
                <td width="16%" style="text-align: left">
                    {{ !empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A' }}
                </td>
                <th width="16%" style="text-align: left">District:</th>
                <td width="26%" style="text-align: left">{{ checkna($family_profile[0]->fp_district) }}</td>
            </tr>
            <tr>
                <th width="17%" style="text-align: left">Village Name:</th>
                <td width="16%" style="text-align: left">{{ checkna($family_profile[0]->fp_village) }}</td>
                <td width="16%" style="text-align: left"> Federation Name: </td>
                <td width="16%" style="text-align: left">{{ checkna($fed_profile[0]->name_of_federation) }}</td>
                <th width="16%" style="text-align: left">State:</th>
                <td width="26%" style="text-align: left">{{ checkna($family_profile[0]->fp_state) }}</td>
            </tr>

        </tbody>

    </table>
    <br>

    <div class="page-header-title" style="margin-top: -50px;">
        <div class="d-inline">
            <h3 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:40px;"
                style="margin:0px 0px">
                Family Assessment:
            </h3>
        </div>
        <table class="table table-bordered table-stripped table1" cellspacing="20" style="width: 65%; margin: auto;">
            <tbody>
                <tr style="margin-left: 20px;">
                    <td>1. Budget</td>
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
                    <td>2. Savings</td>
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
                </tr>
                <tr>
                    <td>3. Credit Plan</td>
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
                </tr>
                <tr>
                    <td>4. Commitment to SHG Rules</td>
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
                </tr>
            </tbody>
        </table>
        @php
            $color = '';
            if ($grand_total_cy >= 90) {
                $color = 'green';
            } elseif ($grand_total_cy >= 75 && $grand_total_cy <= 89) {
                $color = 'yellow';
            } elseif ($grand_total_cy >= 75 && $grand_total_cy <= 89) {
                $color = 'yellow';
            } elseif ($grand_total_cy >= 60 && $grand_total_cy <= 74) {
                $color = 'lightgrey';
            } elseif ($grand_total_cy <= 59) {
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
                style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;color:rgba(7, 83, 146, 0.726);position: relative;top:-100px;">
                FAMILY GOALS, CHALLENGES & ACTION PLAN

            </h3>
        </div>


    </div>
    <div style="display: flex;position: relative;top:-100px;">
        <div style=" width:50%;">
            <div class="page-header-title">
                <div class="d-inline">
                    <h3 style="font-family: Arial, Helvetica, sans-serif;text-align:start;font-size:20px;"
                        style="margin:0px 0px">Member Name:&nbsp; {{ $family_profile[0]->fp_member_name }}
                    </h3>
                </div>
            </div>
            <table style=" border-collapse: collapse;width:100%">
                <tbody>
                    <tr>
                        <th
                            style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;">
                        </th>
                        <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Family Goals
                           </th>
                    </tr>


                    @php $i=1; @endphp
                    @if (!empty($goals))
                        @foreach ($goals as $row)
                            <tr>
                                <td
                                    style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;">
                                    {{ $i++ }}</td>

                                <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">
                                    {{ $row->fg_goal }}</td>
                            </tr>
                        @endforeach
                    @endif


                </tbody>

            </table>
        </div>
        <div style="width:50%;margin-left: 51%;margin-top:-50%">
            <div class="page-header-title">
                <div class="d-inline">
                    <h3 style="font-family: Arial, Helvetica, sans-serif;text-align:start;font-size:20px;"
                        style="margin:0px 0px">UIN:&nbsp; {{ $family->uin }}
                    </h3>
                </div>
            </div>

            <table style=" border-collapse: collapse;width:100%">
                <tbody>
                    <tr>
                        <th
                            style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;">
                        </th>
                        <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Family
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
                                    {{ $row->challenges }}</td>
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
                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;border-right:1px solid  #ddd;width:4%;">
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
                            </td>
                            {{ $i++ }}
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
