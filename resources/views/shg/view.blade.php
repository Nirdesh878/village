@extends('layouts.app')

@section('content')
    @php
        $user = Auth::user();
    @endphp
    <div class="page-wrapper">
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="head-pannel s-box">
                        <div class="d-flex">
                            <div class="count mt-1 ml-2">
                                <img src="{{ asset('assets\images\6.jpg') }}" width="70px" alt="admin@bootstrapmaster.com">
                            </div>
                            <div class="headerfont">
                                <h2>{{ $profile[0]->shgName }}</h2>
                                <div class="E-link d-flex">
                                    <a href="#">
                                        <p><i class="las la-envelope"></i>{{ $profile[0]->web_email }}</p>
                                    </a>
                                    <a href="#">
                                        <p><i class="las la-phone"></i> {{ $profile[0]->web_mobile }}</p>
                                    </a>
                                </div>
                                <p>
                                    <span style="padding: 0px 5px;"></span>
                                    <span style="padding: 0px 5px;">{{ $profile[0]->name_of_district }}</span>,
                                    <span style="padding: 0px 5px;">{{ $profile[0]->name_of_state }}</span>,
                                    <span style="padding: 0px 5px;">{{ $profile[0]->name_of_country }}</span>
                                </p>
                            </div>
                            <div class="ml-auto d-flex">
                                {{-- <div class="rating-box s-box mr-4" style="background-color:#f443368c;">
                                    <h4>SHG CODE</h4>
                                    <h3>{{ $profile[0]->shg_code }}</h3>
                                    <p></p>
                                </div> --}}
                                <div class="rating-box s-box mr-4 {{ $total_show }}">
                                    <h4>Analytics and Rating</h4>
                                    <h3>{{ $grd_total }}</h3>
                                    <p>{{ $show_final_status }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row mt-3" style="margin-top:30px">
                        <div class="col-3 faily-tab">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                @if ($u_type == 'QA' || $u_type == 'CEO' || $u_type == 'A')
                                    <a class="nav-link active" id="v-pills-quality-summary-tab" data-toggle="pill"
                                        href="#v-pills-quality-summary" role="tab"
                                        aria-controls="v-pills-quality-summary" aria-selected="true"><i
                                            class="las la-briefcase mr-2"></i>Summary</a>
                                    <a class="nav-link " id="v-pills-Basic-Profile-tab" data-toggle="pill"
                                        href="#v-pills-Basic-Profile" role="tab" aria-controls="v-pills-Basic-Profile"
                                        aria-selected="false"><i class="las la-info-circle mr-2"></i>Basic Profile</a>
                                @else
                                    <a class="nav-link active" id="v-pills-Basic-Profile-tab" data-toggle="pill"
                                        href="#v-pills-Basic-Profile" role="tab" aria-controls="v-pills-Basic-Profile"
                                        aria-selected="true"><i class="las la-info-circle mr-2"></i>Basic Profile</a>
                                @endif
                                @if ($user->u_type != 'M')
                                    <a class="nav-link " id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports"
                                        role="tab" aria-controls="v-pills-reports" aria-selected="true"><i
                                            class="las la-info-circle mr-2"></i>Reports</a>
                                @endif
                                <a class="nav-link " id="v-pills-Governance-and-Accountability-tab" data-toggle="pill"
                                    href="#v-pills-Governance-and-Accountability" role="tab"
                                    aria-controls="v-pills-Governance-and-Accountability" aria-selected="false"><i
                                        class="las la-hand-holding-usd mr-2"></i>Governance and Accountability</a>
                                <a class="nav-link " id="v-pills-Inclusion-tab" data-toggle="pill" href="#v-pills-Inclusion"
                                    role="tab" aria-controls="v-pills-Inclusion" aria-selected="false"><i
                                        class="las la-briefcase mr-2"></i>Inclusion</a>
                                <a class="nav-link " id="v-pills-Efficiency-tab" data-toggle="pill"
                                    href="#v-pills-Efficiency" role="tab" aria-controls="v-pills-Efficiency"
                                    aria-selected="false"><i class="las la-briefcase mr-2"></i>Efficiency</a>
                                <a class="nav-link " id="v-pills-Credit-Recovery-tab" data-toggle="pill"
                                    href="#v-pills-Credit-Recovery" role="tab" aria-controls="v-pills-Credit-Recovery"
                                    aria-selected="false"><i class="las la-briefcase mr-2"></i>Credit History</a>
                                <a class="nav-link " id="v-pills-Saving-tab" data-toggle="pill" href="#v-pills-Saving"
                                    role="tab" aria-controls="v-pills-Saving" aria-selected="false"><i
                                        class="las la-briefcase mr-2"></i>Saving</a>
                                @if ($user->u_type != 'M')
                                    <a class="nav-link " id="v-pills-Analysis-tab" data-toggle="pill"
                                        href="#v-pills-Analysis" role="tab" aria-controls="v-pills-Analysis"
                                        aria-selected="false"><i class="las la-briefcase mr-2"></i>Analysis and Scores</a>
                                @endif
                                <a class="nav-link " id="v-pills-Challenges-tab" data-toggle="pill"
                                    href="#v-pills-Challenges" role="tab" aria-controls="v-pills-Challenges"
                                    aria-selected="false"><i class="las la-briefcase mr-2"></i>Challenges</a>
                                <a class="nav-link " id="v-pills-Action-Plan-tab" data-toggle="pill"
                                    href="#v-pills-Action-Plan" role="tab" aria-controls="v-pills-Action-Plan"
                                    aria-selected="false"><i class="las la-briefcase mr-2"></i>Action Plan</a>
                                <a class="nav-link " id="v-pills-Observations-tab" data-toggle="pill"
                                    href="#v-pills-Observations" role="tab" aria-controls="v-pills-Observations"
                                    aria-selected="false"><i class="las la-briefcase mr-2"></i>Observations</a>
                                <a class="nav-link " id="v-pills-Photos-Videos-tab" data-toggle="pill"
                                    href="#v-pills-Photos-Videos" role="tab" aria-controls="v-pills-Photos-Videos"
                                    aria-selected="false"><i class="las la-briefcase mr-2"></i>Photos/Videos</a>
                                @if ($user->u_type != 'M')
                                    <a class="nav-link " id="v-pills-report-card-tab" data-toggle="pill"
                                        href="#v-pills-report-card" role="tab" aria-controls="v-pills-report-card"
                                        aria-selected="false"><i class="las la-briefcase mr-2"></i>Report Card</a>
                                @endif
                                @if ($u_type == 'QA')
                                    <a class="nav-link " id="v-pills-quality-check-tab-qa" data-toggle="pill"
                                        href="#v-pills-quality-check-qa" role="tab"
                                        aria-controls="v-pills-quality-check-qa" aria-selected="false"><i
                                            class="las la-briefcase mr-2"></i>Quality Check</a>
                                @elseif($u_type == 'M')
                                    <a class="nav-link " id="v-pills-quality-check-tab" data-toggle="pill"
                                        href="#v-pills-quality-check" role="tab"
                                        aria-controls="v-pills-quality-check" aria-selected="false"><i
                                            class="las la-briefcase mr-2"></i>Manager Check</a>
                                @endif
                                <a class="nav-link " id="v-pills-remarks-tab" data-toggle="pill" href="#v-pills-remarks"
                                    role="tab" aria-controls="v-pills-remarks" aria-selected="false"><i
                                        class="las la-briefcase mr-2"></i>Remarks</a>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <!---tab Reports --->

                                <div class="tab-pane fade" id="v-pills-reports" role="tabpanel"
                                    aria-labelledby="v-pills-reports-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Reports</h5>

                                        </div>
                                        <div class="card-box">
                                            <table class="table table-bordered mytable" colspan="2">
                                                <thead class="back-color">

                                                </thead>
                                                <tbody>
                                                    @if ($user->u_type != 'M')
                                                        <tr>
                                                            <th width="50%">SHG Profile </th>
                                                            <td><a href="{{ URL::to('/shgDetailsPdf/' . $shg_ids) }}"
                                                                    class="btn iconbtn btn-success ml-2">
                                                                    <i class="las ti-download"></i></a></td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <th width="50%">SHG Profile with Report Card</th>
                                                        <td><a href="{{ URL::to('/shgDetailscardPdf/' . $shg_ids) }}"
                                                                class="btn iconbtn btn-success ml-2">
                                                                <i class="las ti-download"></i></a></td>
                                                    </tr>
                                                    <tr>
                                                        <th>SHG Report Card </th>
                                                        <td><a href="{{ URL::to('/shgcardPdf/' . $shg_ids) }}"
                                                                class="btn iconbtn btn-success ml-2"><i
                                                                    class="las ti-download"></i></a></td>
                                                    </tr>


                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <!-----tab-1---->
                                @if ($u_type == 'QA' || $u_type == 'CEO' || $u_type == 'A')
                                    <div class="tab-pane fade show active" id="v-pills-quality-summary" role="tabpanel"
                                        aria-labelledby="v-pills-quality-summary-tab">
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Summary </h5>

                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6">
                                                        <center style="padding-bottom: 5px;">Rating Score</center>
                                                        <div id="demo-pie-1" class="pie-title-center"
                                                            style="height: 150px;width: 150px;">
                                                            <canvas id="raating_d_chart"></canvas>
                                                            <span class="pie-value"></span>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div id="container11111" style="height: 200px;width: 100%;">
                                                            <canvas id="rate_line"></canvas>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="v-pills-Basic-Profile" role="tabpanel"
                                        aria-labelledby="v-pills-Basic-Profile-tab">
                                        <div class="family-box">
                                            <div class="w-heading d-flex">
                                                <h5>Basic Profile</h5>

                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name</strong></div>
                                                            <div class="col-6">{{ $profile[0]->shgName }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>UIN</strong></div>
                                                            <div class="col-6">{{ $shg->uin }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Cluster</strong></div>
                                                            <div class="col-6">
                                                                {{ !empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Federation</strong></div>
                                                            <div class="col-6">
                                                                {{ $fed_profile[0]->name_of_federation }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Village</strong></div>
                                                            <div class="col-6">{{ $profile[0]->village }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>District</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_district }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>State</strong></div>
                                                            <div class="col-6">{{ $profile[0]->name_of_state }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Country</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_country }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>NRLM Code</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->shg_code }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>SHG Creation and Membership</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of creation</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ change_date_month_name_char(str_replace('/', '-', $profile[0]->formed)) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of current
                                                                    Members</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->current_members }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of Members at the time
                                                                    of
                                                                    Creation</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->members_at_creation }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of members left since
                                                                    creation</strong></div>
                                                            <div class="col-6">{{ $profile[0]->members_left }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of members from same
                                                                    neighborhood</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->members_neighborhood }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Current Leadership Names</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>President/Animator</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->president != '' ? $profile[0]->president : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Secretary</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->secretary != '' ? $profile[0]->secretary : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Treasurer</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->treasure != '' ? $profile[0]->treasure : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Current Book Keeper</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name</strong></div>
                                                            <div class="col-6">
                                                                {{ checkna($profile[0]->book_keeper_name) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of
                                                                    appointment</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->book_keeper_date != '' ? change_date_month_name_char(str_replace('/', '-', $profile[0]->book_keeper_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Bank Account details</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Account opening
                                                                    date</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->bank_date != '' ? change_date_month_name_char(str_replace('/', '-', $profile[0]->bank_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name of the bank</strong>
                                                            </div>
                                                            @if ($profile[0]->bank_name != 'Other')
                                                                <div class="col-6">
                                                                    {{ $profile[0]->bank_name != '' ? $profile[0]->bank_name : 'N/A' }}
                                                                </div>
                                                            @else
                                                                <div class="col-6">
                                                                    {{ $profile[0]->other_bank_name != '' ? $profile[0]->other_bank_name : 'N/A' }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name of Branch</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->bank_branch != '' ? $profile[0]->bank_branch : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Account no</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->bank_ac_no != '' ? $profile[0]->bank_ac_no : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Whether SHG has been restructured, if yes</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of
                                                                    restructuring</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->shg_basicProfile_restructured != '' ? change_date_month_name_char(str_replace('/', '-', $profile[0]->shg_basicProfile_restructured)) : 'N/A' }}

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Agency that formed SHG</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Agency Name</strong></div>
                                                            <div class="col-6">
                                                                <strong>{{ $agency_profile[0]->agency_name }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="tab-pane fade " id="v-pills-Basic-Profile" role="tabpanel"
                                        aria-labelledby="v-pills-Basic-Profile-tab">
                                        <div class="family-box">
                                            <div class="w-heading d-flex">
                                                <h5>Basic Profile</h5>

                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name</strong></div>
                                                            <div class="col-6">{{ $profile[0]->shgName }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>UIN</strong></div>
                                                            <div class="col-6">{{ $shg->uin }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Cluster</strong></div>
                                                            <div class="col-6">
                                                                {{ !empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Federation</strong></div>
                                                            <div class="col-6">
                                                                {{ $fed_profile[0]->name_of_federation }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Village</strong></div>
                                                            <div class="col-6">{{ $profile[0]->village }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>District</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_district }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>State</strong></div>
                                                            <div class="col-6">{{ $profile[0]->name_of_state }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Country</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_country }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>NRLM Code</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->shg_code }}</div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>SHG Creation and Membership</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of creation</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ change_date_month_name_char(str_replace('/', '-', $profile[0]->formed)) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of current
                                                                    Members</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->current_members }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of Members at the time
                                                                    of
                                                                    Creation</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->members_at_creation }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of members left since
                                                                    creation</strong></div>
                                                            <div class="col-6">{{ $profile[0]->members_left }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of members from same
                                                                    neighborhood</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->members_neighborhood }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Current Leadership Names</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>President/Animator</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->president != '' ? $profile[0]->president : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Secretary</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->secretary != '' ? $profile[0]->secretary : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Treasurer</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->treasure != '' ? $profile[0]->treasure : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Current Book Keeper</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name</strong></div>
                                                            <div class="col-6">
                                                                {{ checkna($profile[0]->book_keeper_name) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of
                                                                    appointment</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->book_keeper_date != '' ? $profile[0]->book_keeper_date : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Bank Account details</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Account opening
                                                                    date</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->bank_date != '' ? change_date_month_name_char(str_replace('/', '-', $profile[0]->bank_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name of the bank</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->bank_name != '' ? $profile[0]->bank_name : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name of Branch</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->bank_branch != '' ? $profile[0]->bank_branch : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Account no</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->bank_ac_no != '' ? $profile[0]->bank_ac_no : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Whether SHG has been restructured, if yes</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of
                                                                    restructuring</strong></div>
                                                            <div class="col-6">
                                                                {{ change_date_month_name_char(str_replace('/', '-', $profile[0]->shg_basicProfile_restructured)) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Agency that formed SHG</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Agency Name</strong></div>
                                                            <div class="col-6">
                                                                <strong>{{ $agency_profile[0]->agency_name }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="tab-pane fade " id="v-pills-Basic-Profile" role="tabpanel"
                                    aria-labelledby="v-pills-Basic-Profile-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Basic Profile</h5>

                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Name</strong></div>
                                                        <div class="col-6">{{ $profile[0]->shgName }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>UIN</strong></div>
                                                        <div class="col-6">{{ $shg->uin }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Cluster</strong></div>
                                                        <div class="col-6">
                                                            {{ !empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Federation</strong></div>
                                                        <div class="col-6">
                                                            {{ $fed_profile[0]->name_of_federation }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Village</strong></div>
                                                        <div class="col-6">{{ $profile[0]->village }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>District</strong></div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->name_of_district }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>State</strong></div>
                                                        <div class="col-6">{{ $profile[0]->name_of_state }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Country</strong></div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->name_of_country }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>SHG Creation and Membership</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Date of creation</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ change_date_month_name_char(str_replace('/', '-', $profile[0]->formed)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of current
                                                                Members</strong></div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->current_members }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of Members at the time
                                                                of
                                                                Creation</strong></div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->members_at_creation }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of members left since
                                                                creation</strong></div>
                                                        <div class="col-6">{{ $profile[0]->members_left }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of members from same
                                                                neighborhood</strong></div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->members_neighborhood }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Current Leadership Names</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>President/Animator</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->president != '' ? $profile[0]->president : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Secretary</strong></div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->secretary != '' ? $profile[0]->secretary : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Treasurer</strong></div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->treasure != '' ? $profile[0]->treasure : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Current Book Keeper</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Name</strong></div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->book_keeper_name }}

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Date of
                                                                appointment</strong></div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->book_keeper_date != '' ? change_date_month_name_char(str_replace('/', '-', $profile[0]->book_keeper_date)) : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Bank Account details</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Account opening
                                                                date</strong></div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->bank_date != '' ? change_date_month_name_char(str_replace('/', '-', $profile[0]->bank_date)) : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Name of the bank</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->bank_name != '' ? $profile[0]->bank_name : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Name of Branch</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->bank_branch != '' ? $profile[0]->bank_branch : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Account no</strong></div>
                                                        <div class="col-6">
                                                            {{ $profile[0]->bank_ac_no != '' ? $profile[0]->bank_ac_no : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Whether SHG has been restructured, if yes</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Date of
                                                                restructuring</strong></div>
                                                        <div class="col-6">
                                                            {{ change_date_month_name_char(str_replace('/', '-', $profile[0]->shg_basicProfile_restructured)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Agency that formed SHG</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Agency Name</strong></div>
                                                        <div class="col-6">
                                                            <strong>{{ $agency_profile[0]->agency_name }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!----tab 2---->
                                <div class="tab-pane fade" id="v-pills-Governance-and-Accountability" role="tabpanel"
                                    aria-labelledby="v-pills-Governance-and-Accountability-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Adoption of Rules</h5>

                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Adoption Rules</strong></div>
                                                        <div class="col-6">{{ checkna($governance[0]->adoption_rules) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($governance[0]->adoption_rules == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Written Rules</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->written_norms }}</div>
                                                        </div>
                                                    </div>
                                                    @if ($governance[0]->written_norms == 'Yes')
                                                        <div class="col-md-6 table-padd">
                                                            <div class="row detail">
                                                                <div class="col-6"><strong>Date of
                                                                        Adoption</strong></div>
                                                                <div class="col-6">
                                                                    {{ change_date_month_name_char(str_replace('/', '-', $governance[0]->adoption_date)) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Details on Election</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Frequency as per norms</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->election_frequency != '' ? $governance[0]->election_frequency : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>1st election date </strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->first_election_date != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->first_election_date)) : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of Elections conducted so
                                                                far</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->no_of_election_conducted != '' ? $governance[0]->no_of_election_conducted : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Date of Last Election</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->last_election_date != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->last_election_date)) : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Meeting Details</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Frequency of Meetings </strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->meetings_frequency_spinner != '' ? $governance[0]->meetings_frequency_spinner : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of meetings conducted during
                                                                last 12
                                                                months</strong></div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->no_of_meeting_conducted != '' ? $governance[0]->no_of_meeting_conducted : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Average Participation of
                                                                Members during
                                                                last 12 months</strong></div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->average_participation != '' ? $governance[0]->average_participation : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Meetings Recorded</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->meetings_recorded != '' ? $governance[0]->meetings_recorded : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Status of Minutes During last 12 months</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Who writes the minutes</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->who_writes_minutes != '' ? $governance[0]->who_writes_minutes : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Other Writes the Minutes</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->other_writes_minutes != '' ? $governance[0]->other_writes_minutes : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Updating of Books of Accounts</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>How often books
                                                                updated</strong></div>
                                                        <div class="col-6">
                                                            {{ checkna($governance[0]->how_book_updated) }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Date of last update</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->date_last_update_book != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_last_update_book)) : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Updated status</strong></div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->shg_updated_status != '' ? $governance[0]->shg_updated_status : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Are Bank accounts in regular operation during last 12 months</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6">
                                                            <strong>{{ checkna($governance[0]->passbook_updated) }}</strong>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Grade of SHG during last 12 months</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Grade</strong></div>
                                                        <div class="col-6">{{ checkna($governance[0]->grading) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Internal Audit</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>whether conducted
                                                                (Y/N)</strong></div>
                                                        <div class="col-6">
                                                            {{ checkna($governance[0]->internal_audit) }}</div>
                                                    </div>
                                                </div>
                                                @if ($governance[0]->internal_audit == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of audit</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->internal_audit_date != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->internal_audit_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>External Audit </h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>whether conducted
                                                                (Y/N)</strong></div>
                                                        <div class="col-6">
                                                            {{ checkna($governance[0]->external_audit) }}</div>
                                                    </div>
                                                </div>
                                                @if ($governance[0]->external_audit_date != '')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of audit</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->external_audit_date != '' ? change_date_month_name_char(str_replace('/', '-', $governance[0]->external_audit_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!----tab-3----->
                                <div class="tab-pane fade" id="v-pills-Inclusion" role="tabpanel"
                                    aria-labelledby="v-pills-Inclusion-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Wealth Ranking</h5>

                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Wealth Ranking</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ checkna($inclusion[0]->wealth_ranking) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($inclusion[0]->wealth_ranking == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of 1st poverty
                                                                    mapping</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $inclusion[0]->poverty_mapping_date != '' ? change_date_month_name_char(str_replace('/', '-', $inclusion[0]->poverty_mapping_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of last update during
                                                                    last 12
                                                                    months</strong></div>
                                                            <div class="col-6">
                                                                {{ $inclusion[0]->wealth_last_update_date != '' ? change_date_month_name_char(str_replace('/', '-', $inclusion[0]->wealth_last_update_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Visual Poverty Ranking</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of Poorest &amp;
                                                                vulnerable</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->no_of_visual_poorest != '' ? $inclusion[0]->no_of_visual_poorest : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of Poor</strong></div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->no_of_visual_poor != '' ? $inclusion[0]->no_of_visual_poor : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of Medium Poor</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->no_of_visual_medium_poor != '' ? $inclusion[0]->no_of_visual_medium_poor : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of Rich</strong></div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->no_of_visual_rich != '' ? $inclusion[0]->no_of_visual_rich : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Caste Composition</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of SC, ST</strong></div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->no_of_sc_caste != '' ? $inclusion[0]->no_of_sc_caste : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of OBC</strong></div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->no_of_obc_caste != '' ? $inclusion[0]->no_of_obc_caste : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of others</strong></div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->no_of_other_caste != '' ? $inclusion[0]->no_of_other_caste : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>No. of loans and amounts given to SHG members during last 12 months</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Total Loans Disbursed</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->no_of_total_members_benefited != '' ? $inclusion[0]->no_of_total_members_benefited : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Total Amount Disbursed</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->no_of_total_members_benefited_amount != '' ? $inclusion[0]->no_of_total_members_benefited_amount : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br>
                                        <table class="table mytable table-responsive">
                                            <thead class="back-color">
                                                <tr>
                                                    <th class="table_th">Category</th>
                                                    <th class="table_th" colspan="2">Internal Loans</th>
                                                    <th class="table_th" colspan="8"
                                                        style="border-left:1px white solid;border-right:1px white solid;">
                                                        External Loans</th>
                                                    <th class="table_th" colspan="2"></th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th class="table_th" colspan="2">Internal Loans</th>
                                                    <th class="table_th" colspan="2"
                                                        style="border-left:1px white solid;">Federation Loans</th>
                                                    <th class="table_th" colspan="2">Bank Loans</th>
                                                    <th class="table_th" colspan="2">Other Loans</th>
                                                    <th class="table_th" colspan="2"
                                                        style="border-right:1px white solid;">VI Loans </th>
                                                    <th class="table_th" colspan="2">Total Loans </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th></th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed (#)</th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                </tr>
                                                <tr>
                                                    <td>Very Poor &amp; vulnerable</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_external_poorest }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_external_poorest_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poorest }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poorest_amount }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poorest }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poorest_amount }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_vi_poorest }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_vi_poorest_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest + (int) $inclusion[0]->no_of_external_poorest + (int) $inclusion[0]->no_of_vi_poorest + (int) $inclusion[0]->no_of_bank_external_poorest + (int) $inclusion[0]->no_of_other_external_poorest }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest_amount + (int) $inclusion[0]->no_of_vi_poorest_amount + (int) $inclusion[0]->no_of_external_poorest_amount + (int) $inclusion[0]->no_of_bank_external_poorest_amount + (int) $inclusion[0]->no_of_other_external_poorest_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Poor</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_poor }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_poor_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_external_poor }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_external_poor_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poor }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poor_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poor }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poor_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_vi_poor }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_vi_poor_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_poor + (int) $inclusion[0]->no_of_external_poor + (int) $inclusion[0]->no_of_vi_poor + (int) $inclusion[0]->no_of_bank_external_poor + (int) $inclusion[0]->no_of_other_external_poor }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_poor_amount + (int) $inclusion[0]->no_of_vi_poor_amount + (int) $inclusion[0]->no_of_external_poor_amount + (int) $inclusion[0]->no_of_bank_external_poor_amount + (int) $inclusion[0]->no_of_other_external_poor_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Medium poor</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_medium }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_medium_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_external_medium }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_external_medium_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_medium }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_medium_amount }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_other_external_medium }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_other_external_medium_amount }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_vi_medium }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_vi_medium_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_medium + (int) $inclusion[0]->no_of_external_medium + (int) $inclusion[0]->no_of_vi_medium + (int) $inclusion[0]->no_of_bank_external_medium + (int) $inclusion[0]->no_of_other_external_medium }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_medium_amount + (int) $inclusion[0]->no_of_external_medium_amount + (int) $inclusion[0]->no_of_vi_medium_amount + (int) $inclusion[0]->no_of_bank_external_medium_amount + (int) $inclusion[0]->no_of_other_external_medium_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Rich</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_rich }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_rich_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_external_rich }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_external_rich_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_rich }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_rich_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_other_external_rich }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_other_external_rich_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_vi_rich }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_vi_rich_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_rich + (int) $inclusion[0]->no_of_external_rich + (int) $inclusion[0]->no_of_vi_rich + (int) $inclusion[0]->no_of_bank_external_rich + (int) $inclusion[0]->no_of_other_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_rich_amount + (int) $inclusion[0]->no_of_external_rich_amount + (int) $inclusion[0]->no_of_vi_rich_amount + (int) $inclusion[0]->no_of_bank_external_rich_amount + (int) $inclusion[0]->no_of_other_external_rich_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest + (int) $inclusion[0]->no_of_internal_poor + (int) $inclusion[0]->no_of_internal_medium + (int) $inclusion[0]->no_of_internal_rich }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest_amount + (int) $inclusion[0]->no_of_internal_poor_amount + (int) $inclusion[0]->no_of_internal_medium_amount + (int) $inclusion[0]->no_of_internal_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $inclusion[0]->no_of_external_poorest + (int) $inclusion[0]->no_of_external_poor + (int) $inclusion[0]->no_of_external_medium + (int) $inclusion[0]->no_of_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_external_poorest_amount + (int) $inclusion[0]->no_of_external_poor_amount + (int) $inclusion[0]->no_of_external_medium_amount + (int) $inclusion[0]->no_of_external_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poorest + (int) $inclusion[0]->no_of_bank_external_poor + (int) $inclusion[0]->no_of_bank_external_medium + (int) $inclusion[0]->no_of_bank_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poorest_amount + (int) $inclusion[0]->no_of_bank_external_poor_amount + (int) $inclusion[0]->no_of_bank_external_medium_amount + (int) $inclusion[0]->no_of_bank_external_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poorest + (int) $inclusion[0]->no_of_other_external_poor + (int) $inclusion[0]->no_of_other_external_medium + (int) $inclusion[0]->no_of_other_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poorest_amount + (int) $inclusion[0]->no_of_other_external_poor_amount + (int) $inclusion[0]->no_of_other_external_medium_amount + (int) $inclusion[0]->no_of_other_external_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $inclusion[0]->no_of_vi_poorest + (int) $inclusion[0]->no_of_vi_poor + (int) $inclusion[0]->no_of_vi_medium + (int) $inclusion[0]->no_of_vi_rich }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_vi_poorest_amount + (int) $inclusion[0]->no_of_vi_poor_amount + (int) $inclusion[0]->no_of_vi_medium_amount + (int) $inclusion[0]->no_of_vi_rich_amount }}
                                                    </td>

                                                    <td>{{ $inclusion[0]->no_of_total_members_benefited }}</td>
                                                    <td>{{ $inclusion[0]->no_of_total_members_benefited_amount }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>No. of households benefitted from all loans during last 12 months</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Total HHs</strong></div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->no_of_total_members_benefited_hhs != '' ? $inclusion[0]->no_of_total_members_benefited_hhs : 0 }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <br>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Category</th>
                                                    <th>SHG member HHs</th>
                                                    <th class="table_th" colspan="5">External Loans</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Internal</th>
                                                    <th>Fed</th>
                                                    <th>Bank</th>
                                                    <th>Other</th>
                                                    <th>VI</th>
                                                </tr>
                                                <tr>
                                                    <td>Very Poor &amp; vulnerable</td>
                                                    <td>{{ $inclusion[0]->no_of_internal_poorest_hhs != '' ? $inclusion[0]->no_of_internal_poorest_hhs : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_internal_poorest_recloan != '' ? $inclusion[0]->no_of_internal_poorest_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_external_poorest_recloan != '' ? $inclusion[0]->no_of_external_poorest_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_bank_external_poorest_recloan != '' ? $inclusion[0]->no_of_bank_external_poorest_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_other_external_poorest_recloan != '' ? $inclusion[0]->no_of_other_external_poorest_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_vi_poorest_recloan != '' ? $inclusion[0]->no_of_vi_poorest_recloan : 0 }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Poor</td>
                                                    <td>{{ $inclusion[0]->no_of_internal_poor_hhs != '' ? $inclusion[0]->no_of_internal_poor_hhs : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_internal_poor_recloan != '' ? $inclusion[0]->no_of_internal_poor_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_external_poor_recloan != '' ? $inclusion[0]->no_of_external_poor_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_bank_external_poor_recloan != '' ? $inclusion[0]->no_of_bank_external_poor_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_other_external_poor_recloan != '' ? $inclusion[0]->no_of_other_external_poor_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_vi_poor_recloan != '' ? $inclusion[0]->no_of_vi_poor_recloan : 0 }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Medium poor</td>
                                                    <td>{{ $inclusion[0]->no_of_internal_medium_hhs != '' ? $inclusion[0]->no_of_internal_medium_hhs : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_internal_medium_recloan != '' ? $inclusion[0]->no_of_internal_medium_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_external_medium_recloan != '' ? $inclusion[0]->no_of_external_medium_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_bank_external_medium_recloan != '' ? $inclusion[0]->no_of_bank_external_medium_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_other_external_medium_recloan != '' ? $inclusion[0]->no_of_other_external_medium_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_vi_medium_recloan != '' ? $inclusion[0]->no_of_vi_medium_recloan : 0 }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Rich</td>
                                                    <td>{{ $inclusion[0]->no_of_internal_rich_hhs != '' ? $inclusion[0]->no_of_internal_rich_hhs : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_internal_rich_recloan != '' ? $inclusion[0]->no_of_internal_rich_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_external_rich_recloan != '' ? $inclusion[0]->no_of_external_rich_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_bank_external_rich_recloan != '' ? $inclusion[0]->no_of_bank_external_rich_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_other_external_rich_recloan != '' ? $inclusion[0]->no_of_other_external_rich_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $inclusion[0]->no_of_vi_rich_recloan != 0 ? $inclusion[0]->no_of_vi_rich_recloan : 0 }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <td>{{ ($inclusion[0]->no_of_internal_rich_hhs != '' ? $inclusion[0]->no_of_internal_rich_hhs : 0) + ($inclusion[0]->no_of_internal_medium_hhs != '' ? $inclusion[0]->no_of_internal_medium_hhs : 0) + ($inclusion[0]->no_of_internal_poor_hhs != '' ? $inclusion[0]->no_of_internal_poor_hhs : 0) + ($inclusion[0]->no_of_internal_poorest_hhs != '' ? $inclusion[0]->no_of_internal_poorest_hhs : 0) }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_internal_poorest_recloan + (int) $inclusion[0]->no_of_internal_poor_recloan + (int) $inclusion[0]->no_of_internal_medium_recloan + (int) $inclusion[0]->no_of_internal_rich_recloan }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_external_poorest_recloan + (int) $inclusion[0]->no_of_external_poor_recloan + (int) $inclusion[0]->no_of_external_medium_recloan + (int) $inclusion[0]->no_of_external_rich_recloan }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_bank_external_poorest_recloan + (int) $inclusion[0]->no_of_bank_external_poor_recloan + (int) $inclusion[0]->no_of_bank_external_medium_recloan + (int) $inclusion[0]->no_of_bank_external_rich_recloan }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_other_external_poorest_recloan + (int) $inclusion[0]->no_of_other_external_poor_recloan + (int) $inclusion[0]->no_of_other_external_medium_recloan + (int) $inclusion[0]->no_of_other_external_rich_recloan }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->no_of_vi_poorest_recloan + (int) $inclusion[0]->no_of_vi_poor_recloan + (int) $inclusion[0]->no_of_vi_medium_recloan + (int) $inclusion[0]->no_of_vi_rich_recloan }}
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>No of poor and most poor in Leadership position</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of Leadership Poor</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ checkna($inclusion[0]->no_of_leadership_poor) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Special products for the poor/vulnerable
                                            </h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Special products for the
                                                                poor/vulnerable</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ checkna($inclusion[0]->is_service_for_poor) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($inclusion[0]->is_service_for_poor == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name of product</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $inclusion[0]->service_for_poor }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Any impact/result</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $inclusion[0]->result_of_service }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of members benefited
                                                                    from it
                                                                    during
                                                                    last 12 months</strong></div>
                                                            <div class="col-6">
                                                                {{ $inclusion[0]->no_of_member_benefited_service }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!----tab-4----->
                                <div class="tab-pane fade" id="v-pills-Efficiency" role="tabpane"
                                    aria-labelledby="v-pills-Efficiency-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Integrated Member Plan </h5>

                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Integrated Member Plan</strong></div>
                                                        <div class="col-6">
                                                            {{ $efficiency[0]->integrated_family }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($efficiency[0]->integrated_family == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of last
                                                                    report</strong></div>
                                                            <div class="col-6">
                                                                {{ $efficiency[0]->integrated_family_date != '' ? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->integrated_family_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Income and Expenses during last 12 months </h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Income from all
                                                                sources</strong></div>
                                                        <div class="col-6">
                                                            {{ $efficiency[0]->total_income != '' ? $efficiency[0]->total_income : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Expenses </strong></div>
                                                        <div class="col-6">
                                                            {{ $efficiency[0]->expense != '' ? $efficiency[0]->expense : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Is it covering its operational
                                                                costs</strong></div>
                                                        <div class="col-6">
                                                            {{ $efficiency[0]->covering_operational_cost != '' ? $efficiency[0]->covering_operational_cost : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Training Received during last 12 Months</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Name of Training</th>
                                                    <th>Date of Training</th>
                                                    <th>Duration of Ttraining</th>
                                                    <th>Bookkeeper Trained</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ checkna($efficiency[0]->name_training) }}</td>
                                                    <td>{{ $efficiency[0]->date_training != '' ? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->date_training)) : 'N/A' }}
                                                    </td>
                                                    <td>{{ checkna($efficiency[0]->duration_training) }}</td>
                                                    <td>{{ checkna($efficiency[0]->bookkeeper_trained) }}</td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Training Details</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN</th>
                                                    {{-- <th>Designation</th> --}}
                                                    <th>Name of training</th>
                                                    <th>Duration</th>
                                                    <th>Date</th>
                                                    <th>Name of Training Recipient</th>
                                                    <th>Name of Trainer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1; @endphp
                                                @if (!empty($efficiency_details))
                                                    @foreach ($efficiency_details as $row)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $row->training_name }}</td>
                                                            <td>{{ $row->duration }}</td>
                                                            <td>{{ $row->date_training != '' ? change_date_month_name_char(str_replace('/', '-', $row->date_training)) : 'N/A' }}
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $desg = [];
                                                                    if ($row->secretary == 1) {
                                                                        $desg[] = 'Secretary';
                                                                    }
                                                                    if ($row->president == 1) {
                                                                        $desg[] = 'President';
                                                                    }
                                                                    if ($row->treasurer == 1) {
                                                                        $desg[] = 'Treasurer';
                                                                    }
                                                                    if ($row->other == 1) {
                                                                        $desg[] = 'Other';
                                                                    }
                                                                    $strdesg = implode(',', $desg);
                                                                @endphp
                                                                {{ $strdesg }}</td>
                                                            <td>{{ $row->who_received }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>No of days taken to approve loan</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6">
                                                            Days taken to approve loan
                                                        </div>
                                                        <div class="col-6">
                                                            {{ checkna($efficiency[0]->no_of_days_approve_loan) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>No of days from approval to cash in hand</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6">
                                                            No of days from approval to cash in hand
                                                        </div>
                                                        <div class="col-6">
                                                            {{ checkna($efficiency[0]->no_of_days_cash_in_hand) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Monthly Reports

                                            </h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">

                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Monthly reports</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ checkna($efficiency[0]->prepare_monthly_progress) }}
                                                        </div>
                                                    </div>
                                                    @if ($efficiency[0]->prepare_monthly_progress == 'Yes')
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of last report
                                                                    submitted</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $efficiency[0]->shg_last_submission_date != '' ? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->shg_last_submission_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!----tab-5----->
                                <div class="tab-pane fade" id="v-pills-Credit-Recovery" role="tabpane"
                                    aria-labelledby="v-pills-Credit-Recovery-tab">
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Interest rate type
                                            </h5>

                                        </div>
                                        <div class="card-box">

                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Interest rate type</strong></div>
                                                        <div class="col-6">
                                                            {{ checkna($creditrecovery[0]->interest_charged) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>% interest rate
                                                                charged</strong></div>
                                                        <div class="col-6">
                                                            {{ $creditrecovery[0]->percent_charged != '' ? $creditrecovery[0]->percent_charged : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Cumulative No of Loans and Amounts disbursed During last 3 years</h5>
                                        </div>
                                        <table class="table mytable table-responsive">
                                            <thead class="back-color">
                                                <tr>
                                                    <th class="table_th">Category</th>
                                                    <th class="table_th" colspan="2">Internal Loans</th>
                                                    <th class="table_th" colspan="8"
                                                        style="border-left:1px white solid;border-right:1px white solid;">
                                                        External Loans</th>
                                                    <th class="table_th" colspan="2"></th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th class="table_th" colspan="2">Internal Loans</th>
                                                    <th class="table_th" colspan="2"
                                                        style="border-left:1px white solid;">Federation Loans</th>
                                                    <th class="table_th" colspan="2">Bank Loans</th>
                                                    <th class="table_th" colspan="2">Other Loans</th>
                                                    <th class="table_th" colspan="2"
                                                        style="border-right:1px white solid;">VI Loans </th>
                                                    <th class="table_th" colspan="2">Total Loans </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th></th>
                                                    <th>No. of loan disbursed </th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed </th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed </th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed </th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed </th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                    <th>No. of loan disbursed </th>
                                                    <th>Amount disbursed (Rs.)</th>
                                                </tr>
                                                <tr>
                                                    <td>Very Poor &amp; vulnerable</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poorest }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poorest_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poorest }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poorest_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poorest }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poorest_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poorest }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poorest_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest + (int) $creditrecovery[0]->no_of_external_poorest + (int) $creditrecovery[0]->no_of_vi_poorest + (int) $creditrecovery[0]->no_of_bank_external_poorest + (int) $creditrecovery[0]->no_of_other_external_poorest }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_amount + (int) $creditrecovery[0]->no_of_external_poorest_amount + (int) $creditrecovery[0]->no_of_vi_poorest_amount + (int) $creditrecovery[0]->no_of_bank_external_poorest_amount + (int) $creditrecovery[0]->no_of_other_external_poorest_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Poor</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poor }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poor_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poor }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poor_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poor }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poor_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poor }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poor_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poor }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poor_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poor + (int) $creditrecovery[0]->no_of_external_poor + (int) $creditrecovery[0]->no_of_vi_poor + (int) $creditrecovery[0]->no_of_bank_external_poor + (int) $creditrecovery[0]->no_of_other_external_poor }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poor_amount + (int) $creditrecovery[0]->no_of_external_poor_amount + (int) $creditrecovery[0]->no_of_vi_poor_amount + (int) $creditrecovery[0]->no_of_bank_external_poor_amount + (int) $creditrecovery[0]->no_of_other_external_poor_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Medium poor</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_medium }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_medium_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_medium }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_medium_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_medium }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_medium_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_medium }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_medium_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_medium }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_medium_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_medium + (int) $creditrecovery[0]->no_of_external_medium + (int) $creditrecovery[0]->no_of_vi_medium + (int) $creditrecovery[0]->no_of_other_external_medium + (int) $creditrecovery[0]->no_of_bank_external_medium }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_medium_amount + (int) $creditrecovery[0]->no_of_external_medium_amount + (int) $creditrecovery[0]->no_of_vi_medium_amount + (int) $creditrecovery[0]->no_of_other_external_medium_amount + (int) $creditrecovery[0]->no_of_bank_external_medium_amount }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Rich</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_rich }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_rich_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_rich }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_rich_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_rich }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_rich_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_rich }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_rich_amount }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_rich }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_rich_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_rich + (int) $creditrecovery[0]->no_of_external_rich + (int) $creditrecovery[0]->no_of_vi_rich + (int) $creditrecovery[0]->no_of_other_external_rich + (int) $creditrecovery[0]->no_of_bank_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_rich_amount + (int) $creditrecovery[0]->no_of_external_rich_amount + (int) $creditrecovery[0]->no_of_vi_rich_amount + (int) $creditrecovery[0]->no_of_other_external_rich_amount + (int) $creditrecovery[0]->no_of_bank_external_rich_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest + (int) $creditrecovery[0]->no_of_internal_poor + (int) $creditrecovery[0]->no_of_internal_medium + (int) $creditrecovery[0]->no_of_internal_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_amount + (int) $creditrecovery[0]->no_of_internal_poor_amount + (int) $creditrecovery[0]->no_of_internal_medium_amount + (int) $creditrecovery[0]->no_of_internal_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poorest + (int) $creditrecovery[0]->no_of_external_poor + (int) $creditrecovery[0]->no_of_external_medium + (int) $creditrecovery[0]->no_of_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poorest_amount + (int) $creditrecovery[0]->no_of_external_poor_amount + (int) $creditrecovery[0]->no_of_external_medium_amount + (int) $creditrecovery[0]->no_of_external_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poorest + (int) $creditrecovery[0]->no_of_bank_external_poor + (int) $creditrecovery[0]->no_of_bank_external_medium + (int) $creditrecovery[0]->no_of_bank_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poorest_amount + (int) $creditrecovery[0]->no_of_bank_external_poor_amount + (int) $creditrecovery[0]->no_of_bank_external_medium_amount + (int) $creditrecovery[0]->no_of_bank_external_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poorest + (int) $creditrecovery[0]->no_of_other_external_poor + (int) $creditrecovery[0]->no_of_other_external_medium + (int) $creditrecovery[0]->no_of_other_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poorest_amount + (int) $creditrecovery[0]->no_of_other_external_poor_amount + (int) $creditrecovery[0]->no_of_other_external_medium_amount + (int) $creditrecovery[0]->no_of_other_external_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poorest + (int) $creditrecovery[0]->no_of_vi_poor + (int) $creditrecovery[0]->no_of_vi_medium + (int) $creditrecovery[0]->no_of_vi_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poorest_amount + (int) $creditrecovery[0]->no_of_vi_poor_amount + (int) $creditrecovery[0]->no_of_vi_medium_amount + (int) $creditrecovery[0]->no_of_vi_rich_amount }}
                                                    </td>

                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest +
                                                        (int) $creditrecovery[0]->no_of_external_poorest +
                                                        (int) $creditrecovery[0]->no_of_vi_poorest +
                                                        (int) $creditrecovery[0]->no_of_bank_external_poorest +
                                                        (int) $creditrecovery[0]->no_of_other_external_poorest +
                                                        (int) $creditrecovery[0]->no_of_internal_poor +
                                                        (int) $creditrecovery[0]->no_of_external_poor +
                                                        (int) $creditrecovery[0]->no_of_vi_poor +
                                                        (int) $creditrecovery[0]->no_of_bank_external_poor +
                                                        (int) $creditrecovery[0]->no_of_other_external_poor +
                                                        (int) $creditrecovery[0]->no_of_internal_medium +
                                                        (int) $creditrecovery[0]->no_of_external_medium +
                                                        (int) $creditrecovery[0]->no_of_vi_medium +
                                                        (int) $creditrecovery[0]->no_of_other_external_medium +
                                                        (int) $creditrecovery[0]->no_of_bank_external_medium +
                                                        (int) $creditrecovery[0]->no_of_internal_rich +
                                                        (int) $creditrecovery[0]->no_of_external_rich +
                                                        (int) $creditrecovery[0]->no_of_vi_rich +
                                                        (int) $creditrecovery[0]->no_of_other_external_rich +
                                                        (int) $creditrecovery[0]->no_of_bank_external_rich }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_amount +
                                                        (int) $creditrecovery[0]->no_of_external_poorest_amount +
                                                        (int) $creditrecovery[0]->no_of_vi_poorest_amount +
                                                        (int) $creditrecovery[0]->no_of_bank_external_poorest_amount +
                                                        (int) $creditrecovery[0]->no_of_other_external_poorest_amount +
                                                        (int) $creditrecovery[0]->no_of_internal_poor_amount +
                                                        (int) $creditrecovery[0]->no_of_external_poor_amount +
                                                        (int) $creditrecovery[0]->no_of_vi_poor_amount +
                                                        (int) $creditrecovery[0]->no_of_bank_external_poor_amount +
                                                        (int) $creditrecovery[0]->no_of_other_external_poor_amount +
                                                        (int) $creditrecovery[0]->no_of_internal_medium_amount +
                                                        (int) $creditrecovery[0]->no_of_external_medium_amount +
                                                        (int) $creditrecovery[0]->no_of_vi_medium_amount +
                                                        (int) $creditrecovery[0]->no_of_other_external_medium_amount +
                                                        (int) $creditrecovery[0]->no_of_bank_external_medium_amount +
                                                        (int) $creditrecovery[0]->no_of_internal_rich_amount +
                                                        (int) $creditrecovery[0]->no_of_external_rich_amount +
                                                        (int) $creditrecovery[0]->no_of_vi_rich_amount +
                                                        (int) $creditrecovery[0]->no_of_other_external_rich_amount +
                                                        (int) $creditrecovery[0]->no_of_bank_external_rich_amount }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Cumulative Interest Income Through</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Type of loan</th>
                                                    <th>Income Generated Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Internal</td>
                                                    <td>{{ $creditrecovery[0]->cumulative_internal_interest != '' ? $creditrecovery[0]->cumulative_internal_interest : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Federation</td>
                                                    <td>{{ $creditrecovery[0]->cumulative_federation_interest != '' ? $creditrecovery[0]->cumulative_federation_interest : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Bank</td>
                                                    <td>{{ $creditrecovery[0]->cumulative_bank_interest != '' ? $creditrecovery[0]->cumulative_bank_interest : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>VI</td>
                                                    <td>{{ $creditrecovery[0]->cumulative_vi_interest != '' ? $creditrecovery[0]->cumulative_vi_interest : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Other</td>
                                                    <td>{{ $creditrecovery[0]->cumulative_other_interest != '' ? $creditrecovery[0]->cumulative_other_interest : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Total</td>
                                                    <td>{{ checkZero($creditrecovery[0]->total_cumulative_interest) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Total no of member HHs benefitted from all Loans during last 3 years</h5>
                                        </div>

                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Category</th>
                                                    {{-- <th class="table_th" colspan="5">Received Loans / SHG member HHs</th> --}}
                                                    <th>SHG member HHs</th>
                                                    <th class="table_th" colspan="5">Received Loans</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Internal</th>
                                                    <th>Fed</th>
                                                    <th>Bank</th>
                                                    <th>Other</th>
                                                    <th>VI</th>
                                                </tr>
                                                <tr>
                                                    <td>Very Poor &amp; vulnerable</td>
                                                    <td>{{ $creditrecovery[0]->no_of_internal_poorest_hhs != '' ? $creditrecovery[0]->no_of_internal_poorest_hhs : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_internal_poorest_recloan != '' ? $creditrecovery[0]->no_of_internal_poorest_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_external_poorest_recloan != '' ? $creditrecovery[0]->no_of_external_poorest_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_bank_external_poorest_recloan != '' ? $creditrecovery[0]->no_of_bank_external_poorest_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_other_external_poorest_recloan != '' ? $creditrecovery[0]->no_of_other_external_poorest_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_vi_poorest_recloan != '' ? $creditrecovery[0]->no_of_vi_poorest_recloan : 0 }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Poor</td>
                                                    <td>{{ $creditrecovery[0]->no_of_internal_poor_hhs != '' ? $creditrecovery[0]->no_of_internal_poor_hhs : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_internal_poor_recloan != '' ? $creditrecovery[0]->no_of_internal_poor_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_external_poor_recloan != '' ? $creditrecovery[0]->no_of_external_poor_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_bank_external_poor_recloan != '' ? $creditrecovery[0]->no_of_bank_external_poor_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_other_external_poor_recloan != '' ? $creditrecovery[0]->no_of_other_external_poor_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_vi_poor_recloan != '' ? $creditrecovery[0]->no_of_vi_poor_recloan : 0 }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Medium poor</td>
                                                    <td>{{ $creditrecovery[0]->no_of_internal_medium_hhs != '' ? $creditrecovery[0]->no_of_internal_medium_hhs : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_internal_medium_recloan != '' ? $creditrecovery[0]->no_of_internal_medium_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_external_medium_recloan != '' ? $creditrecovery[0]->no_of_external_medium_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_bank_external_medium_recloan != '' ? $creditrecovery[0]->no_of_bank_external_medium_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_other_external_medium_recloan != '' ? $creditrecovery[0]->no_of_other_external_medium_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_vi_medium_recloan != '' ? $creditrecovery[0]->no_of_vi_medium_recloan : 0 }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Rich</td>
                                                    <td>{{ $creditrecovery[0]->no_of_internal_rich_hhs != '' ? $creditrecovery[0]->no_of_internal_rich_hhs : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_internal_rich_recloan != '' ? $creditrecovery[0]->no_of_internal_rich_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_external_rich_recloan != '' ? $creditrecovery[0]->no_of_external_rich_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_bank_external_rich_recloan != '' ? $creditrecovery[0]->no_of_bank_external_rich_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_other_external_rich_recloan != '' ? $creditrecovery[0]->no_of_other_external_rich_recloan : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->no_of_vi_rich_recloan != '' ? $creditrecovery[0]->no_of_vi_rich_recloan : 0 }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Total</td>

                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_hhs + (int) $creditrecovery[0]->no_of_internal_poor_hhs + (int) $creditrecovery[0]->no_of_internal_medium_hhs + (int) $creditrecovery[0]->no_of_internal_rich_hhs }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_internal_poorest_recloan + (int) $creditrecovery[0]->no_of_internal_poor_recloan + (int) $creditrecovery[0]->no_of_internal_medium_recloan + (int) $creditrecovery[0]->no_of_internal_rich_recloan }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_external_poorest_recloan + (int) $creditrecovery[0]->no_of_external_poor_recloan + (int) $creditrecovery[0]->no_of_external_medium_recloan + (int) $creditrecovery[0]->no_of_external_rich_recloan }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_bank_external_poorest_recloan + (int) $creditrecovery[0]->no_of_bank_external_poor_recloan + (int) $creditrecovery[0]->no_of_bank_external_medium_recloan + (int) $creditrecovery[0]->no_of_bank_external_rich_recloan }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_other_external_poorest_recloan + (int) $creditrecovery[0]->no_of_other_external_poor_recloan + (int) $creditrecovery[0]->no_of_other_external_medium_recloan + (int) $creditrecovery[0]->no_of_other_external_rich_recloan }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->no_of_vi_poorest_recloan + (int) $creditrecovery[0]->no_of_vi_poor_recloan + (int) $creditrecovery[0]->no_of_vi_medium_recloan + (int) $creditrecovery[0]->no_of_vi_rich_recloan }}
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Demand Collection Balance (DCB) for repayment and current Loan Outstanding
                                            </h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Total Loan Portfolio</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ checkna($creditrecovery[0]->total_loan_amount) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Total Outstanding
                                                                Amount</strong></div>
                                                        <div class="col-6">
                                                            {{ checkna($creditrecovery[0]->total_outstanding_amount) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br>
                                        <table class="table mytable table-responsive">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>DCB</th>
                                                    <th>Internal Loans </th>
                                                    <th>Cluster/habitation/Neighborhood Loan </th>
                                                    <th>FederationLoan </th>
                                                    <th>Bank Loan </th>
                                                    <th>VI Loan E</th>
                                                    <th>Other Loan F</th>
                                                    <th>Total Loan Portfolio </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Total Loan Amount Given (Rs.)</td>
                                                    <td>{{ $creditrecovery[0]->internal_loan_amount != '' ? $creditrecovery[0]->internal_loan_amount : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->cluster_loan_amount != '' ? $creditrecovery[0]->cluster_loan_amount : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->federation_loan_amount != '' ? $creditrecovery[0]->federation_loan_amount : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->bank_loan_amount != '' ? $creditrecovery[0]->bank_loan_amount : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->vi_loan_amount != '' ? $creditrecovery[0]->vi_loan_amount : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->other_loan_amount != '' ? $creditrecovery[0]->other_loan_amount : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->total_loan_amount != '' ? $creditrecovery[0]->total_loan_amount : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Total Demand upto last month for active loans</td>
                                                    <td>{{ $creditrecovery[0]->dcb_internal != '' ? $creditrecovery[0]->dcb_internal : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->dcb_cluster != '' ? $creditrecovery[0]->dcb_cluster : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->dcb_federation != '' ? $creditrecovery[0]->dcb_federation : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->dcb_bank != '' ? $creditrecovery[0]->dcb_bank : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->dcb_vi != '' ? $creditrecovery[0]->dcb_vi : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->dcb_other != '' ? $creditrecovery[0]->dcb_other : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->total_demand != '' ? $creditrecovery[0]->total_demand : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Actual Amount Paid upto last month</td>
                                                    <td>{{ $creditrecovery[0]->repaid_internal != '' ? $creditrecovery[0]->repaid_internal : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->repaid_cluster != '' ? $creditrecovery[0]->repaid_cluster : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->repaid_federation != '' ? $creditrecovery[0]->repaid_federation : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->repaid_bank != '' ? $creditrecovery[0]->repaid_bank : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->repaid_vi != '' ? $creditrecovery[0]->repaid_vi : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->repaid_other != '' ? $creditrecovery[0]->repaid_other : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->total_actual_repaid_amount != '' ? $creditrecovery[0]->total_actual_repaid_amount : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Overdue Amount</td>
                                                    <td>{{ $creditrecovery[0]->overdue_internal != '' ? $creditrecovery[0]->overdue_internal : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->overdue_cluster != '' ? $creditrecovery[0]->overdue_cluster : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->overdue_federation != '' ? $creditrecovery[0]->overdue_federation : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->overdue_bank != '' ? $creditrecovery[0]->overdue_bank : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->overdue_vi != '' ? $creditrecovery[0]->overdue_vi : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->overdue_other != '' ? $creditrecovery[0]->overdue_other : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->total_overdue != '' ? $creditrecovery[0]->total_overdue : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Outstanding amount for active loans</td>
                                                    <td>{{ $creditrecovery[0]->current_outstanding_internal != '' ? $creditrecovery[0]->current_outstanding_internal : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->current_outstanding_cluster != '' ? $creditrecovery[0]->current_outstanding_cluster : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->current_outstanding_federation != '' ? $creditrecovery[0]->current_outstanding_federation : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->current_outstanding_bank != '' ? $creditrecovery[0]->current_outstanding_bank : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->current_outstanding_vi != '' ? $creditrecovery[0]->current_outstanding_vi : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->current_outstanding_other != '' ? $creditrecovery[0]->current_outstanding_other : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->total_outstanding_amount != '' ? $creditrecovery[0]->total_outstanding_amount : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Repayment Ratio %</td>
                                                    <td>{{ Checkper($creditrecovery[0]->repayment_internal) . '%' }}</td>
                                                    <td>{{ Checkper($creditrecovery[0]->repayment_cluster) . '%' }}
                                                    </td>
                                                    <td>{{ Checkper($creditrecovery[0]->repayment_federation) . '%' }}
                                                    </td>
                                                    <td>{{ Checkper($creditrecovery[0]->repayment_bank) . '%' }}
                                                    </td>
                                                    <td>{{ Checkper($creditrecovery[0]->repayment_vi) . '%' }}
                                                    </td>
                                                    <td>{{ Checkper($creditrecovery[0]->repayment_other) . '%' }}
                                                    </td>
                                                    <td>{{ Checkper($creditrecovery[0]->total_repayment_ratio) . '%' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Loan Default</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Name of Loan Insitution</th>
                                                    <th>No of Members</th>
                                                    <th>No of Loans</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A</td>
                                                    <td>Internal loans</td>
                                                    <td>{{ $creditrecovery[0]->default_internal_member != '' ? $creditrecovery[0]->default_internal_member : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->default_internal_loan != '' ? $creditrecovery[0]->default_internal_loan : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Cluster/Habitation</td>
                                                    <td>{{ $creditrecovery[0]->default_cluster_member != '' ? $creditrecovery[0]->default_cluster_member : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->default_cluster_loan != '' ? $creditrecovery[0]->default_cluster_loan : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Federation Loan</td>
                                                    <td>{{ $creditrecovery[0]->default_federation_member != '' ? $creditrecovery[0]->default_federation_member : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->default_federation_loan != '' ? $creditrecovery[0]->default_federation_loan : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>Bank Loan</td>
                                                    <td>{{ $creditrecovery[0]->default_bank_member != '' ? $creditrecovery[0]->default_bank_member : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->default_bank_loan != '' ? $creditrecovery[0]->default_bank_loan : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>E</td>
                                                    <td>VI Loan</td>
                                                    <td>{{ $creditrecovery[0]->default_vi_member != '' ? $creditrecovery[0]->default_vi_member : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->default_vi_loan != '' ? $creditrecovery[0]->default_vi_loan : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>F</td>
                                                    <td>Other Loan</td>
                                                    <td>{{ $creditrecovery[0]->default_other_member != '' ? $creditrecovery[0]->default_other_member : 0 }}
                                                    </td>
                                                    <td>{{ $creditrecovery[0]->default_other_loan != '' ? $creditrecovery[0]->default_other_loan : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td>{{ (int) $creditrecovery[0]->default_internal_member + (int) $creditrecovery[0]->default_cluster_member + (int) $creditrecovery[0]->default_bank_member + (int) $creditrecovery[0]->default_vi_member + (int) $creditrecovery[0]->default_other_member + (int) $creditrecovery[0]->default_federation_member }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->default_internal_loan + (int) $creditrecovery[0]->default_cluster_loan + (int) $creditrecovery[0]->default_federation_loan + (int) $creditrecovery[0]->default_bank_loan + (int) $creditrecovery[0]->default_vi_loan + (int) $creditrecovery[0]->default_other_loan }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>PAR status- 3 Months overdue</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Loan type</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A</td>
                                                    <td>Internal</td>
                                                    <td>{{ checkZero($creditrecovery[0]->creditHistory_PAR_status_Internal) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>External</td>
                                                    <td>{{ checkZero($creditrecovery[0]->creditHistory_PAR_status_External) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Purpose of External Loans during last 12 months</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Purpose</th>
                                                    <th>Bank/Other</th>
                                                    <th>Federation/cluster</th>
                                                    <th>VI</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A</td>
                                                    <td>Productive</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_productive }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_productive_federation }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_productive_vi }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_productive + (int) $creditrecovery[0]->purposes_productive_federation + (int) $creditrecovery[0]->purposes_productive_vi }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Consumption</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_consumption }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_consumption_federation }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_consumption_vi }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_consumption + (int) $creditrecovery[0]->purposes_consumption_federation + (int) $creditrecovery[0]->purposes_consumption_vi }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Debt Swapping</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_debt_swapping }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_debt_swapping_federation }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_debt_swapping_vi }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_debt_swapping + (int) $creditrecovery[0]->purposes_debt_swapping_federation + (int) $creditrecovery[0]->purposes_debt_swapping_vi }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>Other</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_other }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_other_federation }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_other_vi }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_other + (int) $creditrecovery[0]->purposes_other_federation + (int) $creditrecovery[0]->purposes_other_vi }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_productive + (int) $creditrecovery[0]->purposes_consumption + (int) $creditrecovery[0]->purposes_debt_swapping + (int) $creditrecovery[0]->purposes_other }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_productive_federation + (int) $creditrecovery[0]->purposes_consumption_federation + (int) $creditrecovery[0]->purposes_debt_swapping_federation + (int) $creditrecovery[0]->purposes_other_federation }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_productive_vi + (int) $creditrecovery[0]->purposes_consumption_vi + (int) $creditrecovery[0]->purposes_debt_swapping_vi + (int) $creditrecovery[0]->purposes_other_vi }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->purposes_productive + (int) $creditrecovery[0]->purposes_productive_federation + (int) $creditrecovery[0]->purposes_productive_vi + (int) $creditrecovery[0]->purposes_consumption + (int) $creditrecovery[0]->purposes_consumption_federation + (int) $creditrecovery[0]->purposes_consumption_vi + (int) $creditrecovery[0]->purposes_debt_swapping + (int) $creditrecovery[0]->purposes_debt_swapping_federation + (int) $creditrecovery[0]->purposes_debt_swapping_vi + (int) $creditrecovery[0]->purposes_other + (int) $creditrecovery[0]->purposes_other_federation + (int) $creditrecovery[0]->purposes_other_vi }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Average Loan Amount during last 12 Months</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Loan Amount</strong></div>
                                                        <div class="col-6">
                                                            {{ checkZero($creditrecovery[0]->average_loan_amount) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Loan Amount During Last 12 Months</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Maximum Amount</strong></div>
                                                        <div class="col-6">
                                                            {{ checkZero($creditrecovery[0]->maximum_amount) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Minimum Amount</strong></div>
                                                        <div class="col-6">
                                                            {{ checkZero($creditrecovery[0]->minimum_amount) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>No of Members taken more than 1 loan during last 3 years</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Members taken more than 1
                                                                loan</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ checkZero($creditrecovery[0]->no_of_member_loan_more) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!----tab-6----->
                                <div class="tab-pane fade" id="v-pills-Saving" role="tabpane"
                                    aria-labelledby="v-pills-Saving-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Savings Details</h5>

                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Sn</th>
                                                    <th></th>
                                                    <th>Compulsory</th>
                                                    <th>Voluntary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A</td>
                                                    <td>Date Savings started</td>
                                                    <td>{{ $saving[0]->date_savings_started != '' ? change_date_month_name_char(str_replace('/', '-', $saving[0]->date_savings_started)) : 'N/A' }}
                                                    </td>
                                                    <td>{{ $saving[0]->shg_voluntary_saving_started_date != '' ? change_date_month_name_char(str_replace('/', '-', $saving[0]->shg_voluntary_saving_started_date)) : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Amount of Savings per month</td>
                                                    <td>{{ $saving[0]->compulsory_saving_amount != '' ? $saving[0]->compulsory_saving_amount : 0 }}
                                                    </td>
                                                    <td>{{ $saving[0]->shg_voluntary_saving_amount_per_month != '' ? $saving[0]->shg_voluntary_saving_amount_per_month : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>No of Members saved during last 12 months</td>
                                                    <td>{{ $saving[0]->regular_saving_member != '' ? $saving[0]->regular_saving_member : 0 }}
                                                    </td>
                                                    <td>{{ $saving[0]->member_voluntary_saving != '' ? $saving[0]->member_voluntary_saving : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>Cumulative savings to-date since inception</td>
                                                    <td>{{ $saving[0]->cumulative_compulsory_saving != '' ? $saving[0]->cumulative_compulsory_saving : 0 }}
                                                    </td>
                                                    <td>{{ $saving[0]->cumulative_voluntary_saving != '' ? $saving[0]->cumulative_voluntary_saving : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>E</td>
                                                    <td>Average Amount saved during last 12 months</td>
                                                    <td>{{ $saving[0]->shg_compulsory_average_amount_saving_1E != '' ? $saving[0]->shg_compulsory_average_amount_saving_1E : 0 }}
                                                    </td>
                                                    <td>{{ $saving[0]->shg_voluntary_saving_since_inception != '' ? $saving[0]->shg_voluntary_saving_since_inception : 0 }}
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Interest paid to members </h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Interest paid to members</strong>
                                                        </div>
                                                        <div class="col-6">{{ checkna($saving[0]->interest_paid) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($saving[0]->interest_paid == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Savings rate</strong></div>
                                                            <div class="col-6">
                                                                {{ $saving[0]->saving_rate != '' ? round($saving[0]->saving_rate) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Are savings distributed to members
                                            </h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Are savings distributed to
                                                                members</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ checkna($saving[0]->saving_redistributed) }}
                                                        </div>
                                                    </div>
                                                    @if ($saving[0]->saving_redistributed == 'Yes')
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of last
                                                                    distribution</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $saving[0]->last_distribution_date != '' ? change_date_month_name_char(str_replace('/', '-', $saving[0]->last_distribution_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Loan Security Fund (LSF)</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>LSF Participate</strong></div>
                                                        <div class="col-6">{{ checkna($saving[0]->LSF_participate) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($saving[0]->LSF_participate == 'Yes')
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of Members contribute by
                                                                    LSF</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $saving[0]->members_contribute_LSF }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of Members benefitted by
                                                                    LSF</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $saving[0]->members_benefited_LSF }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($saving[0]->LSF_participate == 'No')
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Reason members do not
                                                                    contribute
                                                                </strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $saving[0]->no_LSF_reasons }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        {{-- <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of LSF Reasons</strong></div>
                                                    <div class="col-6">{{$saving[0]->no_LSF_reasons}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    </div>
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Savings Increasing Trend</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Trend</th>
                                                    <th>Compulsory</th>
                                                    <th>Voluntary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Per member average savings during previous year (before 12 months)
                                                    </td>
                                                    <td>{{ checkZero($saving[0]->savingsMobilization_Last_year_per_member) }}
                                                    </td>
                                                    <td>{{ checkZero($saving[0]->savingsMobilization_Previous_year_per_member) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Per member average savings during last 12 months</td>
                                                    <td>{{ checkZero($saving[0]->savingsMobilization_Current_year_per_member) }}
                                                    </td>
                                                    <td>{{ checkZero($saving[0]->savingsMobilization_voluntary_saving) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!----tab-7----->
                                <div class="tab-pane fade" id="v-pills-Analysis" role="tabpane"
                                    aria-labelledby="v-pills-Analysis-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Analysis</h5>

                                        </div>
                                        <table class="table mytable table-responsive">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Objective</th>
                                                    <th>Indicators</th>
                                                    <th>Total Score per objective</th>
                                                    <th>Score Obtained</th>
                                                    <th>Risk Level (green, yellow, grey or red)</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th colspan="2">Governance</th>
                                                    <th>21</th>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Average Participation of Members</td>
                                                    <td>10</td>
                                                    <td>{{ $analysis_data['Average_participation_of'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color1'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Updating of Books</td>
                                                    <td>10</td>
                                                    {{-- <td>{{$analysis_data['shg_book_updation']. ' ('  .$analysis[0]->shg_book_updation. ')'}}</td> --}}
                                                    <td>{{ $analysis_data['shg_book_updation'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color2'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Grading Status</td>
                                                    <td>1</td>
                                                    {{-- <td>{{$analysis_data['shg_grading_status']. ' ('  .$analysis[0]->shg_grading_status. ')'}}</td> --}}
                                                    <td>{{ $analysis_data['shg_grading_status'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color4'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th colspan="2">Inclusion</th>
                                                    <th>13</th>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Poorest/poor benefitting from Internal loans</td>
                                                    <td>4</td>
                                                    <td>{{ $analysis_data['shg_percent_of_poorest_internal'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color6'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Poorest/poor benefitting from External loans</td>
                                                    <td>4</td>
                                                    <td>{{ $analysis_data['shg_percent_of_poorest_other'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color16'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Number of poor/vulnerable and poor families in leadership position
                                                    </td>
                                                    <td>5</td>
                                                    <td>{{ $analysis_data['no_of_leadership_poor'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color66'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="2">Efficiency</th>
                                                    <th>10</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>Coverage of costs</td>
                                                    <td>5</td>
                                                    <td>{{ $analysis_data['shg_operational_cost'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color8'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>Time taken to disburse loans</td>
                                                    <td>5</td>
                                                    <td>{{ $analysis_data['shg_time_taken_loan_disburse'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color3'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th colspan="2">Credit History</th>
                                                    <th>36</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>Internal loan repayment</td>
                                                    <td>12</td>
                                                    {{-- <td>{{$analysis_data['shg_repayment_internal']. '( ' .(str_replace('%','',$analysis[0]->shg_repayment_internal)). ' )'}}</td> --}}
                                                    <td>{{ $analysis_data['shg_repayment_internal'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color5'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>External loan repayment</td>
                                                    <td>12</td>
                                                    <td>{{ $analysis_data['shg_repayment_other'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color7'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>11</td>
                                                    <td>PAR status of Internal loans </td>
                                                    <td>6</td>
                                                    <td>{{ $analysis_data['shg_PAR_status_internal_loan'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color9'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>12</td>
                                                    <td>PAR status of Other all loans </td>
                                                    <td>6</td>
                                                    <td>{{ $analysis_data['shg_PAR_status_other_loan'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color19'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>

                                                {{-- <tr>
                                                    <th colspan="2">Savings</th>
                                                    <th>20</th>
                                                    <th>{{ $total_5 }}</th>
                                                    <th>
                                                        <div class='status_analysis {{ $show5 }} '></div>
                                                    </th>
                                                </tr> --}}
                                                <tr>
                                                    <th colspan="2">Savings</th>
                                                    <th>20</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td>13</td>
                                                    <td>Member savings regularity</td>
                                                    <td>10</td>
                                                    <td>{{ $analysis_data['shg_regularity_savings'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color11'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>14</td>
                                                    <td>Compulsory savings trend</td>
                                                    <td>5</td>
                                                    <td>{{ $analysis_data['shg_compulsory_savings'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color18'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>15</td>
                                                    <td>Voluntary savings Trend</td>
                                                    <td>5</td>
                                                    <td>{{ $analysis_data['shg_voluntary_savings'] }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color81'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th>Total</th>
                                                    <th></th>
                                                    <th>100</th>
                                                    <th>{{ $grd_total }}</th>
                                                    <th>
                                                        <div class='status_analysis {{ $total_show }} '></div>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!----tab-8----->
                                <div class="tab-pane fade" id="v-pills-Challenges" role="tabpane"
                                    aria-labelledby="v-pills-Challenges-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Challenges</h5>

                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Top Challenges</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1; @endphp
                                                @if (!empty($challenges))
                                                    @foreach ($challenges as $row)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $row->challenge }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!----tab-9----->
                                <div class="tab-pane fade" id="v-pills-Action-Plan" role="tabpanel"
                                    aria-labelledby="v-pills-Action-Plan-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Action Plan to address challenges</h5>

                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Action Plan</th>
                                                    @if (!empty($challenges))
                                                        @foreach ($challenges as $row)
                                                            <th>{{ $row->challenge }}</th>
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($challenges_action))
                                                    @foreach ($challenges_action as $key => $row)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $row['name'] }}</td>
                                                            @if (!empty($row['action']))
                                                                @foreach ($row['action'] as $val)
                                                                    <td>{{ $val }}</td>
                                                                @endforeach
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!----tab-10----->
                                <div class="tab-pane fade" id="v-pills-Observations" role="tabpanel"
                                    aria-labelledby="v-pills-Observations-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Observations</h5>

                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="25px">SN</th>
                                                    <th>Questions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td>1</td>
                                                    <td><b>Who attended the meeting? E.g chair, treasurer, secretary,
                                                            book-keeper, other,</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>


                                                    <td>
                                                        @if (!empty($observation))
                                                            @foreach ($observation as $row)
                                                                @php
                                                                    $desg = [];
                                                                    if ($row->shg_observation_chair == 1) {
                                                                        $desg[] = 'Chair';
                                                                    }
                                                                    if ($row->shg_observation_secretary == 1) {
                                                                        $desg[] = 'Secretary';
                                                                    }
                                                                    if ($row->shg_observation_bookkeeper == 1) {
                                                                        $desg[] = 'Bookkeeeper';
                                                                    }
                                                                    if ($row->shg_observation_treasure == 1) {
                                                                        $desg[] = 'Treasure';
                                                                    }
                                                                    if ($row->shg_observation_other == 1) {
                                                                        $desg[] = 'Other';
                                                                    }
                                                                    $strdesg = implode(',', $desg);
                                                                @endphp
                                                                {{ checkna($strdesg) }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif


                                                <tr>
                                                    <td>2</td>
                                                    <td><b>Did members understand the Purpose of the meeting?</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>
                                                    <td>{{ checkna($observation[0]->shg_observation_Purpose_a) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td><b>What was quality of Discussion? Did every one participate?</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>
                                                    <td>{{ checkna($observation[0]->shg_observation_discussion_a) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <th><b>Were group members aware of their rules and norms?</b></th>
                                                </tr>
                                                <tr>
                                                    <td>A.</td>
                                                    <td><b>Did they understand vision of their group?</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>
                                                    <td>{{ checkna($observation[0]->shg_observation_norms_a) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>B.</td>
                                                    <td><b>Do they understand benefits of being part of the group?</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>
                                                    <td>{{ checkna($observation[0]->shg_observation_norms_b) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <th><b>Important practices followed by the group.</b></th>
                                                </tr>
                                                <tr>
                                                    <td>A.</td>
                                                    <td><b>Do they have a set of important practices for repayment and
                                                            savings?</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>
                                                    <td>{{ checkna($observation[0]->shg_observation_savings_a) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>B.</td>
                                                    <td><b>What are those practices?</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>
                                                    <td>{{ checkna($observation[0]->shg_observation_savings_b) }}</td>
                                                </tr>

                                                <tr>
                                                    <td>6</td>
                                                    <th>A. Does this group include members who are the most poor and
                                                        vulnerable, and if yes, what is their policy to help them</th>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>
                                                    <td>{{ checkna($observation[0]->shg_observation_vulnerable_members) }}
                                                    </td>
                                                </tr>
                                                {{-- <tr>
                                                    <td>Group’s policy on the most vulnerable members.</td>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>
                                                    <td>{{$observation[0]->shg_observation_vulnerable_members}}</td>
                                                </tr> --}}
                                                <tr>
                                                    <td>7</td>
                                                    <th>Group’s Awareness about their financial information.</th>
                                                </tr>

                                                <tr>
                                                    <td>A.</td>
                                                    <th>Are books of account managed by the bookkeeper only or are other
                                                        office bearers aware of their financial information?</th>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>
                                                    <td>{{ checkna($observation[0]->shg_observation_financial_information_a) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>B.</td>
                                                    <th>Are all members aware of their savings, loans and group financial
                                                        information?</th>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>
                                                    <td>{{ checkna($observation[0]->shg_observation_financial_information_b) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <th> Are there any unique features of this group. Explain</th>
                                                </tr>
                                                <tr>
                                                    <td>Answer</td>
                                                    <td>{{ checkna($observation[0]->shg_observation_features_group_a) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <th>Summary of important 3- 5 highlights about this group?</th>
                                                </tr>
                                                @if ($observation[0]->shg_observation_highlights_a != '')
                                                    <tr class="last-row">
                                                        <td>A.</td>
                                                        <td>{{ checkna($observation[0]->shg_observation_highlights_a) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($observation[0]->shg_observation_highlights_b != '')
                                                    <tr>
                                                        <td>B.</td>
                                                        <td>{{ $observation[0]->shg_observation_highlights_b }}</td>
                                                    </tr>
                                                @endif
                                                @if ($observation[0]->shg_observation_highlights_c != '')
                                                    <tr>
                                                        <td>C.</td>
                                                        <td>{{ $observation[0]->shg_observation_highlights_c }}</td>
                                                    </tr>
                                                @endif
                                                @if ($observation[0]->shg_observation_highlights_d != '')
                                                    <tr>
                                                        <td>D.</td>
                                                        <td>{{ $observation[0]->shg_observation_highlights_d }}</td>
                                                    </tr>
                                                @endif
                                                @if ($observation[0]->shg_observation_highlights_e != '')
                                                    <tr>
                                                        <td>E.</td>
                                                        <td>{{ $observation[0]->shg_observation_highlights_e }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!----tab-11----->
                                <div class="tab-pane fade" id="v-pills-Photos-Videos" role="tabpanel"
                                    aria-labelledby="v-pills-Photos-Videos-tab">

                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Photos/Videos</h5>

                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Photo</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($photos as $image_first_year)
                                                    @if ($image_first_year->imagename != '')
                                                        <tr class="text-center">
                                                            <th><img src="/assets/uploads/{{ $image_first_year->imagename }}"
                                                                    height="100" width="100"></th>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!----tab-12----->
                                <div class="tab-pane fade" id="v-pills-report-card" role="tabpanel"
                                    aria-labelledby="v-pills-report-card-tab">

                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Shg Rating Card</h5>

                                        </div>
                                        <div class="card-box">
                                            <table class="table table-bordered mytable" colspan="2">
                                                <thead class="back-color">

                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th width="50%">Name</th>
                                                        <td width="50%">{{ $profile[0]->shgName }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Federation Name</th>
                                                        <td>{{ $fed_profile[0]->name_of_federation }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Cluster Name</th>
                                                        <td>{{ !empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>UIN</th>
                                                        <td>{{ $shg->uin }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>State Name</th>
                                                        <td>{{ checkna($profile[0]->name_of_state) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>District Name</th>
                                                        <td>{{ checkna($profile[0]->name_of_district) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Village</th>
                                                        <td>{{ checkna($profile[0]->village) }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Date</th>
                                                        <td>{{ $shg->created_at != '' ? change_date_month_name_char(str_replace('/', '-', $shg->created_at)) : 'N/A' }}
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mytable" colspan="2">
                                                <thead class="back-color">
                                                    <tr>
                                                        <th width="35%">Shg Indicators</th>
                                                        <td colspan="4"></td>
                                                        <th style="text-align:center;">Actual </th>
                                                        <th style="text-align:center;">Expected</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1 Governance</td>
                                                        <td style="background-color: green;width:50px;">
                                                            @if ($score >= 90)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            @if ($score >= 75 && $score <= 89)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            @if ($score >= 60 && $score <= 74)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            @if ($score <= 59)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td width="10px" style="text-align: center">
                                                            {{ $total_1 }}
                                                        </td>
                                                        <td width="10px" style="text-align: center">21</td>
                                                        {{-- <td>{{round($score)}}</td> --}}
                                                    </tr>
                                                    <tr>
                                                        <td>2 Inclusion</td>
                                                        <td style="background-color: green;width:50px;">
                                                            @if ($score1 >= 90)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            @if ($score1 >= 75 && $score1 <= 89)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            @if ($score1 >= 60 && $score1 <= 74)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            @if ($score1 <= 59)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        <td style="text-align: center">{{ $total_2 }}</td>
                                                        <td style="text-align: center">13</td>
                                                        {{-- <td>{{round($score1)}}</td> --}}
                                                    </tr>
                                                    <tr>
                                                        <td>3 Efficiency</td>
                                                        <td style="background-color: green;width:50px;">
                                                            @if ($score2 >= 90)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            @if ($score2 >= 75 && $score2 <= 89)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            @if ($score2 >= 60 && $score2 <= 74)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            @if ($score2 <= 59)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        <td style="text-align: center">{{ $total_3 }}</td>
                                                        <td style="text-align: center">10</td>
                                                        {{-- <td>{{round($score2)}}</td> --}}
                                                    </tr>
                                                    <tr>
                                                        <td>4 Credit history</td>
                                                        <td style="background-color: green;width:50px;">
                                                            @if ($score3 >= 90)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            @if ($score3 >= 75 && $score3 <= 89)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            @if ($score3 >= 60 && $score3 <= 74)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            @if ($score3 <= 59)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        <td style="text-align: center">{{ $total_4 }}</td>
                                                        <td style="text-align: center">36</td>
                                                        {{-- <td>{{round($score3)}}</td> --}}
                                                    </tr>

                                                    <tr>
                                                        <td>5 Saving</td>
                                                        <td style="background-color: green;width:50px;">
                                                            @if ($score4 >= 90)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            @if ($score4 >= 75 && $score4 <= 89)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            @if ($score4 >= 60 && $score4 <= 47)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            @if ($score4 <= 59)
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        <td style="text-align: center">{{ $total_5 }}</td>
                                                        <td style="text-align: center">20</td>
                                                        {{-- <td>{{round($score4 )}}</td> --}}
                                                    </tr>

                                                </tbody>

                                            </table>
                                            <table class="table  mytable">

                                                <tr>
                                                    <th style="width: 35%;">Total Score</th>

                                                    <td
                                                        style="background-color: green;text-align:center;font-weight:bold;font-size:20px;width:9.9%;">
                                                        @if ($grd_total >= 90)
                                                            {{ $grd_total }}
                                                        @endif
                                                    </td>


                                                    <td
                                                        style="background-color: yellow;text-align:center;font-weight:bold;font-size:20px;width:9.66%;">
                                                        @if ($grd_total >= 75 && $grd_total <= 89)
                                                            {{ $grd_total }}
                                                        @endif
                                                    </td>


                                                    <td
                                                        style="background-color: lightgrey;text-align:center;font-weight:bold;font-size:20px;width:10%;">
                                                        @if ($grd_total >= 60 && $grd_total <= 74)
                                                            {{ $grd_total }}
                                                        @endif
                                                    </td>



                                                    <td
                                                        style="background-color: red;text-align:center;font-weight:bold;font-size:20px;width:10%;">
                                                        @if ($grd_total <= 59)
                                                            {{ $grd_total }}
                                                        @endif
                                                    </td>
                                                    <td colspan="2" style="width:28%;"></td>

                                                </tr>


                                            </table>



                                        </div>


                                    </div>
                                </div>
                                @if ($u_type == 'M')
                                    <div class="tab-pane fade" id="v-pills-quality-check" role="tabpanel"
                                        aria-labelledby="v-pills-quality-check-tab">
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>District Manager - Take Action </h5>

                                            </div>

                                            <div class="card-box">
                                                @if ($quality_status != 'P')
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <div class="col-md-8">
                                                                <label class="form-control-label" for="input-small"
                                                                    style="font-weight: bold;">Quality Action :
                                                                </label>
                                                                @if ($quality_status == 'V')
                                                                    <span>Verified</span>
                                                                @elseif ($quality_status == 'R')
                                                                    <span>Rejected</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-control-label" for="input-small"
                                                                    style="font-weight: bold;">Updated at:
                                                                </label>
                                                                <span>{{ $quality_date }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 mb-3" style="margin-top: -17px;">
                                                            <div class="col-md-12" id="remark_txt11">
                                                                <label for="TaskQaAssignment_remark11" class="required"
                                                                    style="font-weight: bold;">Quality Remark :
                                                                </label>
                                                                <span><?php echo $quality_remark ; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <div class="col-md-8">
                                                            <label class="form-control-label" for="input-small">Action
                                                            </label>
                                                            <select class="form-control" name="TaskQaAssignment_status"
                                                                id="TaskQaAssignment_status">
                                                                <option value="V">Verify</option>
                                                                <option value="R">Reject</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 show_div mb-3">
                                                        <label for="TaskQaAssignment_remark"
                                                            class="required form-control-label ml-3 mb-2">
                                                            Facilitator</label>
                                                        <div class="col-md-8">
                                                            <select class="form-control user_id" name="user_id"
                                                                id="user_id" required>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 mb-3">
                                                        <div class="col-md-8" id="remark_txt">
                                                            <label for="TaskQaAssignment_remark" class="required">Remark
                                                            </label>
                                                            <textarea class="form-control form-control-sm" name="TTaskQaAssignment_remark" id="TaskQaAssignment_remark"></textarea>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-8 text-center">
                                                    <input type="hidden" name="task_id" id="task_id"
                                                        value="{{ $task_id }}">
                                                    <input type="hidden" name="agency_id" id="agency_id"
                                                        value="{{ $agency_id }}">
                                                    <input type="hidden" name="facilitator" id="facilitator"
                                                        value="{{ $user_id }}">
                                                    <input type="hidden" name="dm_id" id="dm_id"
                                                        value="{{ $dm_id }}">
                                                    <input type="hidden" name="task" id="task">
                                                    @if ($qa_status == 'P' || $quality_status == 'R')
                                                        <button type="button" id="save"
                                                            class="btn btn-sm btn-success "
                                                            onclick="return submitAction()">Save</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($u_type == 'QA')
                                    <div class="tab-pane fade" id="v-pills-quality-check-qa" role="tabpanel"
                                        aria-labelledby="v-pills-quality-check-tab-qa">
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Quality Check - Take Action </h5>
                                                <!-- <div class="ml-auto">
                                                    <a href="{{ URL::to('/shgDetailsPdf/' . $shg_ids) }}"
                                                        class="btn iconbtn btn-success ml-2">
                                                        <i class="las ti-download"></i></a>

                                                </div> -->
                                            </div>
                                            @if ($manager_status == 'Verify')
                                                <div class="card-box">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <div class="col-md-8">
                                                                <label class="form-control-label" for="input-small"
                                                                    style="font-weight: bold;">Manger Action :
                                                                </label>
                                                                @if ($qa_status == 'V')
                                                                    <span>Verified</span>
                                                                @elseif ($qa_status == 'R')
                                                                    <span>Rejected</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-control-label" for="input-small"
                                                                    style="font-weight: bold;">Updated at:
                                                                </label>
                                                                <span>{{ $manager_date }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 mb-3" style="margin-top: -17px;">
                                                            <div class="col-md-12" id="remark_txt11">
                                                                <label for="TaskQaAssignment_remark22" class="required"
                                                                    style="font-weight: bold;">Manager Remark :
                                                                </label>
                                                                <span><?php echo $qa_remark; ?></span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <div class="col-md-8">
                                                                <label class="form-control-label"
                                                                    for="input-small">Quality
                                                                    Action
                                                                </label>
                                                                <select class="form-control"
                                                                    name="TaskQaAssignment_status1"
                                                                    id="TaskQaAssignment_status1" {{ $qa_readonly1 }}>
                                                                    <option value="V">Verify</option>
                                                                    <option value="R">Reject</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 mb-3">
                                                            <div class="col-md-8" id="remark_txt11">
                                                                <label for="TaskQaAssignment_remark1"
                                                                    class="required">Remark
                                                                </label>
                                                                <textarea class="form-control form-control-sm" name="TTaskQaAssignment_remark1" id="TaskQaAssignment_remark1"
                                                                    {{ $qa_readonly1 }}></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8 text-center">
                                                        <input type="hidden" name="task_id" id="task_id1"
                                                            value="{{ $task_id }}">
                                                        <input type="hidden" name="agency_id" id="agency_id1"
                                                            value="{{ $agency_id }}">
                                                        <input type="hidden" name="facilitator" id="facilitator1"
                                                            value="{{ $user_id }}">
                                                        <input type="hidden" name="task" id="task">
                                                        @if ($quality_status == 'P')
                                                            <button type="button" id="save1"
                                                                class="btn btn-sm btn-success "
                                                                onclick="return submitAction1()">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                {{-- tab 20 remark  --}}
                                <div class="tab-pane fade" id="v-pills-remarks" role="tabpanel"
                                    aria-labelledby="v-pills-reports-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Remarks</h5>

                                        </div>
                                        <div class="card-box">
                                            <table class="table mytable">
                                                <thead class="back-color">
                                                    <tr>
                                                        <th>Facilitator</th>
                                                        <th>SHG Name</th>
                                                        <th>DM Status</th>
                                                        <th>QA Status</th>
                                                        <th>Date</th>
                                                        <th>DM Remarks</th>
                                                        <th>QA Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($remarks as $res)
                                                    @php
                                                        $status = '';
                                                        $qa_status = 'Pending';
                                                        if($res->dm_status == 'V'){
                                                            $status = 'Verified';
                                                        }
                                                        else if (($res->dm_status == 'R')) {
                                                            $status = ' Rejected';
                                                        }
                                                        if($res->qa_status == 'V'){
                                                            $qa_status = 'Verified';
                                                        }
                                                        else if ($res->qa_status == 'R') {
                                                            $qa_status = ' Rejected';
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $res->name }}</td>
                                                        <td>{{ $res->shgName }}</td>
                                                        <td>{{ $status }}</td>
                                                        <td>{{ $qa_status }}</td>
                                                        <td>{{change_date_month_name_char(str_replace('/','-',$res->updated_at))  }}</td>

                                                        <td><a data-toggle="modal" data-id="{{ $res->id }}"
                                                                href="#remarks_m" data-type="M"
                                                                class="btn btn-success btn-link btn-sm"
                                                                data-target="#remarks_m"><i
                                                                    class="c-white-500 ti-eye"></i></a>
                                                        </td>
                                                        <td><a data-toggle="modal" data-id="{{ $res->id }}"
                                                            href="#remarks_q" data-type="QA"
                                                            class="btn btn-success btn-link btn-sm"
                                                            data-target="#remarks_q"><i
                                                                class="c-white-500 ti-eye"></i></a>
                                                        </td>

                                                    </tr>
                                                    @endforeach



                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- remarks DM --}}
    <div class="modal fade" id="remarks_m" tabindex="-1" role="dialog">
        <div class="modal-dialog mw-100 w-75" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Remarks
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="modal-body10" style="overflow-y: scroll; height:400px;">
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- remarks QA --}}
    <div class="modal fade" id="remarks_q" tabindex="-1" role="dialog">
        <div class="modal-dialog mw-100 w-75" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Remarks
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="modal-body11" style="overflow-y: scroll; height:400px;">
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
           .red{
        background-color: red !important;
    }
        .head-pannel {
            background: #ffffff;
            padding: 15px;
            margin: -18px -27px;
        }

        .d-flex {
            display: flex !important;
        }

        .rating-box {
            background: #6BC561;
            border-radius: 5px;
            padding: 10px;
            color: #ffffff;
            width: 190px;
        }

        .rating-box2 {
            background: #FF4141;
            border-radius: 5px;
            padding: 10px;
            color: #ffffff;
            width: 190px;
        }

        .headerfont h2 {
            font-size: 20px;
            margin-left: 18px;
        }

        .headerfont p {
            font-size: 14px;
            margin-left: 18px;
            margin-bottom: 4px;
        }

        .s-box h4 {
            font-size: 14px;
            font-weight: normal;
        }

        .faily-tab .nav-link {
            box-shadow: 0 3px 6px rgb(31 30 47 / 3%);
            background: #ffffff !important;
            border-radius: 48px;
            padding: 15px;
            border: 1px solid #ECEFF5 !important;
            margin-left: 20px;
            font-size: 14px;
            color: #000000 !important;
            margin-top: 15px;
            text-align: center !important;
        }

        .faily-tab .nav-link.active {
            box-shadow: 0 3px 6px rgb(31 30 47 / 3%);
            background: #1F2837 !important;
            border-radius: 48px;
            padding: 15px;
            border: 1px solid #ECEFF5 !important;
            margin-left: 20px;
            font-size: 14px;
            color: #ffffff !important;
            margin-top: 15px;
        }

        .family-box {
            box-shadow: 0 3px 6px rgb(31 30 47 / 3%);
            background: #ffffff;
            border-radius: 5px;
            padding: 15px;
            border: 1px solid #ECEFF5;
        }

        .w-heading {
            padding: 15px;
            margin: -15px -15px 15px;
            border-bottom: 1px solid #ECEFF5;
            font-size: 16px;
            font-weight: 600;
        }

        .w-heading h5 {
            margin: 0;
        }

        .w-heading .btn {
            margin: -5px 0;
        }

        .alldetail .col-md-6:nth-last-of-type(4n-3) .detail,
        .alldetail .col-md-6:nth-last-of-type(4n-2) .detail {
            background: #f9f9f9;
        }

        .detail {
            padding: 10px 0;
            margin: 0;
            border: 1px solid #eeeeee;
            border-collapse: collapse;
            border-bottom: 0px;
            font-size: 12px;
            border-bottom: 0px;
        }

        .mytable {
            border: 1px solid #EFF3F9;
        }

        .back-color {
            background: #F1F5FA !important;
            color: #475479 !important;
        }

        .table thead th {
            vertical-align: bottom;
            background: transparent !important;
            border-bottom: 2px solid #cfd8dc !important;
            color: #475479 !important;
        }

        .mytable thead th {
            border-bottom: 1px solid #EFF3F9 !important;
            border-top: 1px solid #EFF3F9 !important;
        }

        .mytable td {
            border-top: 1px solid #EFF3F9 !important;
            padding: 0.75rem !important;
        }
        .cke_notification_warning {
        display:none;
    }
    </style>
    <script src="//cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {

            CKEDITOR.replace('TaskQaAssignment_remark', {

                toolbarGroups: [{
                        "name": "basicstyles",
                        "groups": ["basicstyles"]
                    },
                    {
                        "name": "links",
                        "groups": ["links"]
                    },
                    {
                        "name": "paragraph",
                        "groups": ["list", "blocks"]
                    },
                    {
                        "name": 'insert',
                        "groups": ['Image']
                    },
                    {
                        "name": "styles",
                        "groups": ["styles"]
                    }
                ],

                removeButtons: 'Strike,Subscript,Superscript,Anchor,Styles,Specialchar,source'
            });
            CKEDITOR.replace('TTaskQaAssignment_remark1', {

                toolbarGroups: [{
                        "name": "basicstyles",
                        "groups": ["basicstyles"]
                    },
                    {
                        "name": "links",
                        "groups": ["links"]
                    },
                    {
                        "name": "paragraph",
                        "groups": ["list", "blocks"]
                    },
                    {
                        "name": 'insert',
                        "groups": ['Image']
                    },
                    {
                        "name": "styles",
                        "groups": ["styles"]
                    }
                ],

                removeButtons: 'Strike,Subscript,Superscript,Anchor,Styles,Specialchar,source'
            });
        });
        $('#remarks_m').on('show.bs.modal', function(event) {
            var myVal = $(event.relatedTarget).data('id');
            var type =  $(event.relatedTarget).data('type');
            $.ajax({
                type: 'GET',
                url: '/get_shg_remarks',
                data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal + '&type=' + type,
                success: function(response) {
                    if (response != '') {
                        $('#modal-body10').html(response);
                    }
                }
            });
        });
        $('#remarks_q').on('show.bs.modal', function(event) {
            var myVal = $(event.relatedTarget).data('id');
            var type =  $(event.relatedTarget).data('type');
            $.ajax({
                type: 'GET',
                url: '/get_shg_remarks',
                data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal + '&type=' + type,
                success: function(response) {
                    if (response != '') {
                        $('#modal-body11').html(response);
                    }
                }
            });
        });

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        function submitAction() {


            var id = $('#task_id').val();
            var sts = $('#TaskQaAssignment_status').val();
            // var rmk = $('#TaskQaAssignment_remark').val();
            //var qrmk = $('#TaskQaAssignment_status11').val();
            var user_id = $('#user_id').val();
            var editor = CKEDITOR.instances['TaskQaAssignment_remark'];
            var remark =  editor.getData();

            var rmk = encodeURIComponent(remark);
    if(user_id == null && sts == 'R')
    {
        alert("Please select the Facilitator first");
    }else{
        
            bootbox.confirm({
                title: "Save Manager Action?",
                message: "Are you sure that you want to Save this record?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function(result) {
                    if (result) {
                        $('#save').prop('disabled', true);
                        $('#save').css('opacity', '0.4');
                        $.ajax({
                            url: '/change_qa_status_fed',
                            type: 'POST',
                            // data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts + '&rmk=' +
                            //     rmk + '&assignment_type="SH"&user_id=' + user_id,
                                data: {
                                    _token: csrfToken, // Use the dynamically retrieved CSRF token
                                    id: id,
                                    sts: sts,
                                    rmk: rmk,
                                    assignment_type: "SH",
                                    user_id: user_id
                                },

                            success: function(response) {
                                data = JSON.parse(response);
                                if (data.result == 1) {
                                    if ("{{ $quality_check }}" == '0' ||
                                        "{{ $quality_check }}" == 0) {
                                        location.reload();

                                    } else {
                                        window.location.href =
                                            "{{ url('qualitycheck') }}";
                                    }

                                }
                            }
                        });
                    }
                }
            });
        }  
    } 
        

        function submitAction1() {


            var id = $('#task_id1').val();
            var sts = $('#TaskQaAssignment_status1').val();
            // var rmk = $('#TaskQaAssignment_remark1').val();

            var editor = CKEDITOR.instances['TaskQaAssignment_remark1'];
            var remark =  editor.getData();

            var rmk = encodeURIComponent(remark);

            bootbox.confirm({
                title: "Save Quality Check?",
                message: "Are you sure that you want to Save this record?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function(result) {
                    if (result) {
                        $('#save1').prop('disabled', true);
                        $('#save1').css('opacity', '0.4');
                        $.ajax({
                            url: '/change_qa_status_fed1',
                            type: 'POST',
                            
                            data: {
                                    _token: csrfToken, // Use the dynamically retrieved CSRF token
                                    id: id,
                                    sts: sts,
                                    rmk: rmk,
                                    assignment_type: "SH"
                                },
                            success: function(response) {
                                data = JSON.parse(response);
                                if (data.result == 1) {
                                    if ("{{ $quality_check }}" == '0' ||
                                        "{{ $quality_check }}" == 0) {
                                        location.reload();

                                    } else {
                                        window.location.href =
                                            "{{ url('qualitycheck') }}";
                                    }

                                }
                            }
                        });
                    }
                }
            });

        }
        @if ($u_type == 'QA' || $u_type == 'CEO' || $u_type == 'A')
            $(document).ready(function() {
                var ctx = document.getElementById("raating_d_chart").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ["Rating", ""],
                        datasets: [{
                            data: ['{{ $grd_total }}', '{{ 100 - $grd_total }}'],
                            borderColor: ['#2196f38c', '#f443368c'],
                            backgroundColor: ['#2196f38c', '#f443368c'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        cutoutPercentage: 80,
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                    }
                });
            });
        @endif

        @if ($u_type == 'QA' || $u_type == 'CEO' || $u_type == 'A')
            var config = {
                type: 'line',
                data: {
                    labels: ['2021', '2022', '2023'],
                    datasets: [{
                        label: 'rating',
                        backgroundColor: 'blue',
                        borderColor: 'blue',
                        fill: false,
                        data: [1, 1, 1],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    title: {
                        display: false,
                        text: 'Chart.js Line Chart - Logarithmic'
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Year'
                            },
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Index Returns'
                            },
                            ticks: {
                                min: 0,
                                // forces step size to be 5 units
                                stepSize: 0.5
                            }
                        }]
                    }
                }
            };


            var ctx1 = document.getElementById('rate_line').getContext('2d');
            window.myLine = new Chart(ctx1, config);
        @endif

        function get_facilitator_list(dm_id) {
        var agency_id  = $('#agency_id').val();
        // alert(dm_id);
        // alert(agency_id);
        if (dm_id != '') {
            $.ajax({
                type: 'GET',
                url: '/get_facilitator_list_task',
                data: '_token = <?php echo csrf_token(); ?>&dm_id=' + dm_id + '&agency_id=' + agency_id,
                success: function(data) {
                    if (data != '') {
                        $('#user_id').html(data);
                        $('#user_id').val($('#facilitator').val());
                        $('#user_id').trigger("change");
                    }
                }
            });
        }
    }


        function set_facilitator() {
            var flg = $('#TaskQaAssignment_status').val();
            var flg1 = $('#TaskQaAssignment_status11').val();
            var dm_id = $('#dm_id').val();
            if (flg == 'R' || flg1 == 'R') {
                $('.show_div').show();
                @if ($qa_status == 'P' || $quality_status == 'R')
                    $('.show_div select').attr('required', 'required');
                @endif
                get_facilitator_list(dm_id);

                //get_facilitator_list();
            } else {
                //alert('ddd');
                $('.show_div').hide();
                $('.show_div select').removeAttr('required');
            }
        }

        $(document).ready(function() {
            $('#dm_id').on('change', get_facilitator_list);
            $('#TaskQaAssignment_status').on('change', set_facilitator);
            $('#TaskQaAssignment_status').trigger('change');
            $('#TaskQaAssignment_status11').on('change', set_facilitator);
            $('#TaskQaAssignment_status11').trigger('change');
            @if ($qa_status == 'R' || $qa_status == 'V')
                $('#TaskQaAssignment_status').val('{{ $qa_status }}');

            @endif
        });
    </script>
@endsection
