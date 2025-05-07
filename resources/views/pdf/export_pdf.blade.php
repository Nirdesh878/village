<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Analytics/Initial Rating Results Report</title>

</head>

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:78%;top:-50px;font-size:20px;">Generated
        On- @php
            echo generated_date();
        @endphp
    </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Analytics/Initial
                    Rating</u>
                @php
                    $type = '';

                    if (!empty($session_data['group'])) {
                        if ($session_data['group'] == 'FD') {
                            echo '(Federation)';
                            $type = 'Federation';
                        }
                        if ($session_data['group'] == 'CL') {
                            echo '(Cluster)';
                            $type = 'Cluster';
                        }
                        if ($session_data['group'] == 'SH') {
                            echo '(SHG)';
                            $type = 'SHG';
                        }
                        if ($session_data['group'] == 'FM') {
                            echo '(Family)';
                            $type = 'Family';
                        }
                        if ($session_data['group'] == 'AG') {
                            echo '(Agency)';
                            $type = 'Agency';
                        }
                    }

                @endphp


            </h2>

        </div>
    </div>

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

        .table td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            text-align: center;
        }

        ;

        .table-primary,
        .table-primary>td,
        .table-primary>th {
            background-color: #01a9ac;
            color: #ffffff;
            text-align: center;
            font-size: 16px;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #e9ecef;
        }

        .status_analysis {

            width: 20px;
            height: 20px;
            border-radius: 10px;
        }

        .red_status {
            background-color: red !important;
        }

        .green {
            background-color: green !important;
        }

        .grey {
            background-color: grey !important;
        }

        .yellow {
            background-color: #ffeb3b !important;
        }

    </style>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac">Group Type</td>
                <td style="background-color:#01a9ac">Country</td>
                <td style="background-color:#01a9ac">State</td>
                <td style="background-color:#01a9ac">District</td>
                <td style="background-color:#01a9ac">Name</td>
            </tr>
        </thead>
        <tbody>
            @if (!empty($session_data))
                <tr>
                    <td>{{ $type }}</td>
                    <td>{{ getCountryByID($session_data['country']) }}</td>
                    <td>{{ getStateName($session_data['country'], $session_data['state']) }}</td>
                    <td>{{ getDistrictName($session_data['state'], $session_data['district']) }}</td>
                    <td>{{ $session_data['federation'] }}</td>
                </tr>
            @else
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            @endif
        </tbody>
    </table>
    <br>
    @if (!empty($session_data['group']) && empty($session_data['federation']))
        <table class="table table-bordered table-stripped" cellspacing="0" style="width: 100% !important">
            <thead>
                <tr class="table-primary">
                    <th style="background-color:#01a9ac">SN.</th>
                    <th style="width: 15px">Analytics/Rating done by</th>
                    @php echo !empty($session_data["group"]) && $session_data["group"]=='CL' ? "<th width='10px'>Cluster Name</th>" : (!empty($session_data["group"]) && $session_data["group"]=='SH' ? "<th width='10%'>SHG Name</th><th width='10px'>Cluster Name</th>" : "") @endphp
                    @php echo !empty($session_data["group"]) && $session_data["group"]=='FM' ? "<th width='10px'>SHG Member Name</th><th width='10%'>SHG Name</th><th width='10px'>Cluster Name</th>" : "" @endphp
                    @php echo !empty($session_data["group"]) && $session_data["group"]=='AG' ? "<th width='15%'>Agency Name</th><th width='15%'>SHG Member Name</th><th width='15%'>SHG Name</th><th width='15%'>Cluster Name</th>" : "" @endphp
                    <th>Federation Name</th>
                    @if (!empty($session_data))
                        @if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                            <th>District</th>
                            <th>State</th>
                        @elseif (!empty($session_data['country']) && !empty($session_data['state']) &&
                            empty($session_data['district']))
                            <th>District</th>
                        @endif

                    @else
                        <th>District</th>
                        <th>State</th>
                        <th>Country</th>
                    @endif
                    <th width="20px">Observations by faciliators</th>
                    <th>Initial Rating Score</th>
                    <th>Initial Rating Results</th>
                    <th>Verfieid By Manager</th>
                    <th>Verfieid By ViV staff</th>
                    <th>Locked</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1; @endphp
                @if (!@empty($res['data']))

                    @foreach ($res['data'] as $data)
                        @php
                            
                                $a = $data->observ_a;
                                $b = $data->observ_b;
                                $c = $data->observ_c;
                                $d = $data->observ_d;
                                $e = $data->observ_e;
                                $rr = '';
                                if ($a != '') {
                                    $rr .= $a . ',';
                                }
                                if ($b != '') {
                                    $rr .= $b . ',';
                                }
                                if ($c != '') {
                                    $rr .= $c . ',';
                                }
                                if ($d != '') {
                                    $rr .= $d . ',';
                                }
                                if ($e != '') {
                                    $rr .= $e;
                                }

                                if ($rr == '') {
                                    $row = '-';
                                } else {
                                    $row = rtrim($rr, ',');
                                }
                            
                            if ($data->analysis_rating != '') {
                                $x1 = ((float) $data->analysis_rating * 100) / 100;
                                $x2 = $x1 >= 90 ? 'green' : ($x1 >= 75 ? 'yellow' : ($x1 >= 60 ? 'grey' : 'red_status'));
                            } else {
                                $x1 = '-';
                                $x2 = '-';
                            }
                        @endphp
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $data->name }}</td>
                            @if ($session_data['group'] == 'AG')
                                <td>{{ $data->agency_name }}</td>
                                <td>{{ $data->fp_member_name }}</td>
                                <td>{{ $data->shgName }}</td>
                                <td>{{ $data->name_of_cluster }}</td>

                            @endif
                            @if ($session_data['group'] == 'FM')
                                <td>{{ $data->fp_member_name }}</td>
                                <td>{{ $data->shgName }}</td>
                                <td>{{ $data->name_of_cluster }}</td>
                            @endif
                            @if ($session_data['group'] == 'SH')
                                <td>{{ $data->shgName }}</td>
                                <td>{{ $data->name_of_cluster }}</td>
                            @endif
                            @if ($session_data['group'] == 'CL')
                                <td>{{ $data->name_of_cluster }}</td>
                            @endif
                            <td>{{ $data->name_of_federation }}</td>

                            @if (!empty($session_data))
                                @if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                                    <td>{{ $data->name_of_district }}</td>
                                    <td>{{ $data->name_of_state }}</td>
                                @elseif (!empty($session_data['country']) && !empty($session_data['state']) &&
                                    empty($session_data['district']))
                                    <td>{{ $data->name_of_district }}</td>
                                @endif

                            @else
                                <td>{{ $data->name_of_district }}</td>
                                <td>{{ $data->name_of_state }}</td>
                                <td>{{ $data->name_of_country }}</td>
                            @endif

                            <td>{{ $row }}</td>
                            {{-- <td>{{$x1}}</td> --}}
                            <td>{{ $data->analysis_rating }}</td>
                            <td>
                                <div class='status_analysis {{ $x2 }}' style="margin:auto"></div>
                            </td>
                            <td>{{ $data->dm_status == 'V' ? 'Yes' : 'No' }}</td>
                            <td>{{ $data->quality_status == 'V' ? 'Yes' : 'No' }}</td>
                            <td>{{ $data->locked == 1 ? 'Yes' : 'No' }}</td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                @endif

            </tbody>
        </table>
    @elseif(!empty($session_data['federation']) && !empty($session_data['group']))
        <table class="table table-bordered table-stripped" cellspacing="0" style="width: 100% !important">
            {{-- agency --}}
            @if($session_data['group'] == "AG" && !empty($session_data['federation']))
            <thead>
                <tr class="table-primary">
                    <th style="background-color:#01a9ac">SN.</th>
                    <th>Type</th>
                    <th>UIN</th>
                    <th>Analytics by</th>
                    <th>Family</th>
                    <th>SHG</th>
                    <th>Cluster</th>
                    <th>Federation</th>
                    {{-- <th>Agency</th> --}}
                    {{-- <th>District</th>
                    <th>State</th>
                    <th>Country</th> --}}
                    @if (!empty($session_data))
                        @if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                            <th>District</th>
                            <th>State</th>
                        @elseif (!empty($session_data['country']) && !empty($session_data['state']) &&
                            empty($session_data['district']))
                            <th>District</th>
                        @endif

                    @else
                        <th>District</th>
                        <th>State</th>
                        <th>Country</th>
                    @endif
                    <th>Observation</th>
                    <th>Score</th>
                    <th>Results</th>
                    <th width='10px'>Verfieid By Manager</th>
                    <th width='10px'>Verfieid By ViV staff</th>
                    <th>Locked</th>
                </tr>
            </thead>
            {{-- family --}}
            @elseif($session_data['group'] == "FM" && !empty($session_data['federation']))
            <thead>
                <tr class="table-primary">
                    <th style="background-color:#01a9ac">SN.</th>
                    <th>Type</th>
                    <th>Family-UIN</th>
                    <th>Analytics by</th>
                    {{-- <th>Family</th> --}}
                    <th>SHG</th>
                    <th>Cluster</th>
                    <th>Federation</th>
                    <th>Agency</th>
                    {{-- <th>District</th>
                    <th>State</th>
                    <th>Country</th> --}}
                    @if (!empty($session_data))
                        @if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                            <th>District</th>
                            <th>State</th>
                        @elseif (!empty($session_data['country']) && !empty($session_data['state']) &&
                            empty($session_data['district']))
                            <th>District</th>
                        @endif

                    @else
                        <th>District</th>
                        <th>State</th>
                        <th>Country</th>
                    @endif
                    <th>Observation</th>
                    <th>Score</th>
                    <th>Results</th>
                    <th width='10px'>Verfieid By Manager</th>
                    <th width='10px'>Verfieid By ViV staff</th>
                    <th>Locked</th>
                </tr>
            </thead>
            @elseif($session_data['group'] == "SH" && !empty($session_data['federation']))
            <thead>
                <tr class="table-primary">
                    <th style="background-color:#01a9ac">SN.</th>
                    <th>Type</th>
                    <th>SHG-UIN</th>
                    <th>Analytics by</th>
                    <th>Family</th>
                    {{-- <th>SHG</th> --}}
                    <th>Cluster</th>
                    <th>Federation</th>
                    <th>Agency</th>
                    {{-- <th>District</th>
                    <th>State</th>
                    <th>Country</th> --}}
                    @if (!empty($session_data))
                        @if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                            <th>District</th>
                            <th>State</th>
                        @elseif (!empty($session_data['country']) && !empty($session_data['state']) &&
                            empty($session_data['district']))
                            <th>District</th>
                        @endif

                    @else
                        <th>District</th>
                        <th>State</th>
                        <th>Country</th>
                    @endif
                    <th>Observation</th>
                    <th>Score</th>
                    <th>Results</th>
                    <th width='10px'>Verfieid By Manager</th>
                    <th width='10px'>Verfieid By ViV staff</th>
                    <th>Locked</th>
                </tr>
            </thead>
            @elseif($session_data['group'] == "CL" && !empty($session_data['federation']))
            <thead>
                <tr class="table-primary">
                    <th style="background-color:#01a9ac">SN.</th>
                    <th>Type</th>
                    <th>Cluster-UIN</th>
                    <th>Analytics by</th>
                    <th>Family</th>
                    <th>SHG</th>
                    {{-- <th>Cluster</th> --}}
                    <th>Federation</th>
                    <th>Agency</th>
                    {{-- <th>District</th>
                    <th>State</th>
                    <th>Country</th> --}}
                    @if (!empty($session_data))
                        @if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                            <th>District</th>
                            <th>State</th>
                        @elseif (!empty($session_data['country']) && !empty($session_data['state']) &&
                            empty($session_data['district']))
                            <th>District</th>
                        @endif

                    @else
                        <th>District</th>
                        <th>State</th>
                        <th>Country</th>
                    @endif
                    <th>Observation</th>
                    <th>Score</th>
                    <th>Results</th>
                    <th width='10px'>Verfieid By Manager</th>
                    <th width='10px'>Verfieid By ViV staff</th>
                    <th>Locked</th>
                </tr>
            </thead>
            @elseif($session_data['group'] == "FD" && !empty($session_data['federation']))
            <thead>
                <tr class="table-primary">
                    <th style="background-color:#01a9ac">SN.</th>
                    <th>Type</th>
                    <th>Federation-UIN</th>
                    <th>Analytics by</th>
                    <th>Family</th>
                    <th>SHG</th>
                    <th>Cluster</th>
                    {{-- <th>Federation</th> --}}
                    <th>Agency</th>
                    {{-- <th>District</th>
                    <th>State</th>
                    <th>Country</th> --}}
                    @if (!empty($session_data))
                        @if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                            <th>District</th>
                            <th>State</th>
                        @elseif (!empty($session_data['country']) && !empty($session_data['state']) &&
                            empty($session_data['district']))
                            <th>District</th>
                        @endif

                    @else
                        <th>District</th>
                        <th>State</th>
                        <th>Country</th>
                    @endif
                    <th>Observation</th>
                    <th>Score</th>
                    <th>Results</th>
                    <th width='10px'>Verfieid By Manager</th>
                    <th width='10px'>Verfieid By ViV staff</th>
                    <th>Locked</th>
                </tr>
            </thead>
            @endif
            <tbody>
                @php $i=1; @endphp
                @if (!@empty($res['data']))
                    @foreach ($res['data'] as $data)
                        @php
                            if ($data->analysis_rating != '') {
                                $x1 = ((float) $data->analysis_rating * 100) / 100;
                                $x2 = $x1 >= 90 ? 'green' : ($x1 >= 75 ? 'yellow' : ($x1 >= 60 ? 'grey' : 'red_status'));
                            } else {
                                $x1 = '-';
                                $x2 = '-';
                            }
                            $a = $data->observ_a;
                            $b = $data->observ_b;
                            $c = $data->observ_c;
                            $d = $data->observ_d;
                            $e = $data->observ_e;
                            $rr = '';
                            if ($a != '') {
                                $rr .= $a . ',';
                            }
                            if ($b != '') {
                                $rr .= $b . ',';
                            }
                            if ($c != '') {
                                $rr .= $c . ',';
                            }
                            if ($d != '') {
                                $rr .= $d . ',';
                            }
                            if ($e != '') {
                                $rr .= $e;
                            }

                            if ($rr == '') {
                                $rr = '-';
                            } else {
                                $rr = rtrim($rr, ',');
                            }
                        @endphp
                        <tr>
                           {{-- agency --}}
                            @if($session_data['group'] == "AG" && !empty($session_data['federation']))
                            <td>{{ $i }}</td>
                            <td>{{ $data->type }}</td>
                            <td>{{ $data->uin }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->fp_member_name }}</td>
                            <td>{{ $data->shgName }}</td>
                            <td>{{ $data->name_of_cluster }}</td>
                            <td>{{ $data->name_of_federation }}</td>
                            {{-- <td>{{ $data->agency_name }}</td> --}}
                            {{-- family --}}
                            @elseif($session_data['group'] == "FM" && !empty($session_data['federation']))
                            <td>{{ $i }}</td>
                            <td>{{ $data->type }}</td>
                            <td>{{ $data->uin }}</td>
                            <td>{{ $data->name }}</td>
                            {{-- <td>{{ $data->fp_member_name }}</td> --}}
                            <td>{{ $data->shgName }}</td>
                            <td>{{ $data->name_of_cluster }}</td>
                            <td>{{ $data->name_of_federation }}</td>
                            <td>{{ $data->agency_name }}</td>
                            {{-- shg --}}
                            @elseif($session_data['group'] == "SH" && !empty($session_data['federation']))
                            <td>{{ $i }}</td>
                            <td>{{ $data->type }}</td>
                            <td>{{ $data->uin }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->fp_member_name }}</td>
                            {{-- <td>{{ $data->shgName }}</td> --}}
                            <td>{{ $data->name_of_cluster }}</td>
                            <td>{{ $data->name_of_federation }}</td>
                            <td>{{ $data->agency_name }}</td>
                            {{-- cluster --}}
                            @elseif($session_data['group'] == "CL" && !empty($session_data['federation']))
                            <td>{{ $i }}</td>
                            <td>{{ $data->type }}</td>
                            <td>{{ $data->uin }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->fp_member_name }}</td>
                            <td>{{ $data->shgName }}</td>
                            {{-- <td>{{ $data->name_of_cluster }}</td> --}}
                            <td>{{ $data->name_of_federation }}</td>
                            <td>{{ $data->agency_name }}</td>
                            {{-- federation --}}
                            @elseif($session_data['group'] == "FD" && !empty($session_data['federation']))
                            <td>{{ $i }}</td>
                            <td>{{ $data->type }}</td>
                            <td>{{ $data->uin }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->fp_member_name }}</td>
                            <td>{{ $data->shgName }}</td>
                            <td>{{ $data->name_of_cluster }}</td>
                            {{-- <td>{{ $data->name_of_federation }}</td> --}}
                            <td>{{ $data->agency_name }}</td>
                            @else
                            <td>{{ $i }}</td>
                            <td>{{ $data->type }}</td>
                            <td>{{ $data->uin }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->fp_member_name }}</td>
                            <td>{{ $data->shgName }}</td>
                            <td>{{ $data->name_of_cluster }}</td>
                            <td>{{ $data->name_of_federation }}</td>
                            <td>{{ $data->agency_name }}</td>
                            @endif
                            
                            @if (!empty($session_data))
                                @if (!empty($session_data['country']) && empty($session_data['state']) && empty($session_data['district']))
                                    <td>{{ $data->name_of_district }}</td>
                                    <td>{{ $data->name_of_state }}</td>

                                @elseif (!empty($session_data['country']) && !empty($session_data['state']) &&
                                    empty($session_data['district']))
                                    <td>{{ $data->name_of_district }}</td>
                                @endif

                            @else
                                <td>{{ $data->name_of_district }}</td>
                                <td>{{ $data->name_of_state }}</td>
                                <td>{{ $data->name_of_country }}</td>
                            @endif
                            {{-- <td>{{ $data->name_of_district }}</td>
                            <td>{{ $data->name_of_state }}</td>
                            <td>{{ $data->name_of_country }}</td> --}}
                            <td>{{ $rr }}</td>
                            {{-- <td>{{ $data->agency_name }}</td> --}}
                            {{-- <td>{{$x1}}</td> --}}
                            <td>{{ $data->analysis_rating }}</td>
                            <td>
                                <div class='status_analysis {{ $x2 }}' style="margin:auto"></div>
                            </td>
                            <td>{{ $data->dm_status == 'V' ? 'Yes' : 'No' }}</td>
                            <td>{{ $data->quality_status == 'V' ? 'Yes' : 'No' }}</td>
                            <td>{{ $data->locked == 1 ? 'Yes' : 'No' }}</td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                @endif

            </tbody>
        </table>
    @endif
</body>

</html>
