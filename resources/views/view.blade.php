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
                                <img src="{{ asset('assets\images\6.jpg') }}" width="70px"
                                    alt="admin@bootstrapmaster.com">
                            </div>
                            <div class="headerfont">
                                <h2>{{ $profile[0]->name_of_cluster }}</h2>
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
                                    <span style="padding: 0px 5px;">{{ $profile[0]->name_of_district }}</span>,
                                    <span style="padding: 0px 5px;">{{ $profile[0]->name_of_country }}</span>
                                </p>
                            </div>
                            <div class="ml-auto d-flex">
                                {{-- <div class="rating-box s-box mr-4" style="background-color:#f443368c;">
                                    <h4>VO CODE</h4>
                                    <h3>{{ $profile[0]->vo_code }}</h3>
                                    <p></p>
                                </div> --}}
                                <div class="rating-box s-box mr-4 {{ $grdcolor }}">
                                    <h4>Analytics and Rating</h4>
                                    <h3>{{ $grand_total }}</h3>
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
                                        href="#v-pills-quality-summary" role="tab" aria-controls="v-pills-quality-summary"
                                        aria-selected="true"><i class="las la-briefcase mr-2"></i>Summary</a>
                                    <a class="nav-link " id="v-pills-Basic-Profile-tab" data-toggle="pill"
                                        href="#v-pills-Basic-Profile" role="tab" aria-controls="v-pills-Basic-Profile"
                                        aria-selected="false"><i class="las la-info-circle mr-2"></i>Basic Profile</a>
                                @else
                                    <a class="nav-link active" id="v-pills-Basic-Profile-tab" data-toggle="pill"
                                        href="#v-pills-Basic-Profile" role="tab" aria-controls="v-pills-Basic-Profile"
                                        aria-selected="true"><i class="las la-info-circle mr-2"></i>Basic Profile</a>
                                @endif
                                @if($user->u_type !='M')
                                <a class="nav-link " id="v-pills-reports-tab" data-toggle="pill"
                                    href="#v-pills-reports" role="tab" aria-controls="v-pills-reports"
                                    aria-selected="true"><i class="las la-info-circle mr-2"></i>Reports</a>
                                @endif
                                <a class="nav-link " id="v-pills-Governance-and-Accountability-tab" data-toggle="pill"
                                    href="#v-pills-Governance-and-Accountability" role="tab"
                                    aria-controls="v-pills-Governance-and-Accountability" aria-selected="false"><i
                                        class="las la-hand-holding-usd mr-2"></i>Governance and Accountability</a>
                                <a class="nav-link " id="v-pills-Inclusion-tab" data-toggle="pill"
                                    href="#v-pills-Inclusion" role="tab" aria-controls="v-pills-Inclusion"
                                    aria-selected="false"><i class="las la-briefcase mr-2"></i>Inclusion</a>
                                <a class="nav-link " id="v-pills-Efficiency-tab" data-toggle="pill"
                                    href="#v-pills-Efficiency" role="tab" aria-controls="v-pills-Efficiency"
                                    aria-selected="false"><i class="las la-briefcase mr-2"></i>Efficiency</a>
                                <a class="nav-link " id="v-pills-Credit-Recovery-tab" data-toggle="pill"
                                    href="#v-pills-Credit-Recovery" role="tab" aria-controls="v-pills-Credit-Recovery"
                                    aria-selected="false"><i class="las la-briefcase mr-2"></i>Credit History</a>
                                <a class="nav-link " id="v-pills-Saving-tab" data-toggle="pill" href="#v-pills-Saving"
                                    role="tab" aria-controls="v-pills-Saving" aria-selected="false"><i
                                        class="las la-briefcase mr-2"></i>Saving</a>
                                @if($user->u_type !='M')        
                                <a class="nav-link " id="v-pills-Analysis-and-Scores-tab" data-toggle="pill"
                                    href="#v-pills-Analysis-and-Scores" role="tab"
                                    aria-controls="v-pills-Analysis-and-Scores" aria-selected="false"><i
                                        class="las la-briefcase mr-2"></i>Analysis and Scores</a>
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
                                @if($user->u_type !='M')    
                                <a class="nav-link " id="v-pills-report-card-tab" data-toggle="pill"
                                    href="#v-pills-report-card" role="tab" aria-controls="v-pills-report-card"
                                    aria-selected="false"><i class="las la-briefcase mr-2"></i>Report Card</a>
                                @endif     
                                @if ($u_type == 'QA')
                                    <a class="nav-link " id="v-pills-quality-check-tab-qa" data-toggle="pill"
                                        href="#v-pills-quality-check-qa" role="tab" aria-controls="v-pills-quality-check-qa"
                                        aria-selected="false"><i class="las la-briefcase mr-2"></i>Quality Check</a>
                                @elseif($u_type == 'M')
                                    <a class="nav-link " id="v-pills-quality-check-tab" data-toggle="pill"
                                        href="#v-pills-quality-check" role="tab" aria-controls="v-pills-quality-check"
                                        aria-selected="false"><i class="las la-briefcase mr-2"></i>Manager Check</a>
                                @endif
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
                                                    @if($user->u_type !='M')
                                                    <tr>
                                                        <th width="50%">Cluster Profile </th>
                                                        <td><a href="{{ URL::to('/clusterDetailsPdf/' . $cluster_ids) }}"
                                                                class="btn iconbtn btn-success ml-2"><i
                                                                    class="las ti-download"></i></a></td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <th>Cluster Report Card </th>
                                                        <td><a href="{{ URL::to('/clustercardPdf/' . $cluster_ids) }}"
                                                                class="btn iconbtn btn-success ml-2"><i
                                                                    class="las ti-download"></i></a></td>
                                                    </tr>
                                                    <tr>
                                                        <th width="50%">Cluster Profile with Report Card </th>
                                                        <td><a href="{{ URL::to('/clusterDetailsCardPdf/' . $cluster_ids) }}"
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
                                                <h5>Cluster Details</h5>
                                                
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_cluster }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>UIN</strong></div>
                                                            <div class="col-6">{{ $cluster->uin }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Cluster office
                                                                    location</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->office_location != '' ? $profile[0]->office_location : 'N/A' }}
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
                                                            <div class="col-6"><strong>District</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_district != '' ? $profile[0]->name_of_district : 'N/A' }}
                                                            </div>
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
                                                            <div class="col-6"><strong>Nrlm Code</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->vo_code }}</div>
                                                        </div>
                                                    </div>
                                          
                                                </div>
                                            </div>
                                        </div>

                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Cluster Creation and Membership </h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date cluster was
                                                                    formed</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->cluster_formed != '' ? change_date_month_name_char(str_replace('/','-',$profile[0]->cluster_formed)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of SHGs at
                                                                    Creation</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->shg_at_time_creation != '' ? $profile[0]->shg_at_time_creation : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of members at
                                                                    creation</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->cluster_members_at_time_creation != '' ? $profile[0]->cluster_members_at_time_creation : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of current SHGs</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->total_SHGs != '' ? $profile[0]->total_SHGs : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of current
                                                                    Members</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->total_members != '' ? $profile[0]->total_members : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Current Leadership </h5>
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
                                                                {{ checkna($profile[0]->book_keeper_name) }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of
                                                                    appointment</strong></div>
                                                            <div class="col-6">
                                                               
                                                                {{ $profile[0]->date_of_appointment != '' ? change_date_month_name_char(str_replace('/','-',$profile[0]->date_of_appointment)) : 'N/A' }}
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
                                                                
                                                                {{ $profile[0]->account_opening_date != '' ? change_date_month_name_char(str_replace('/','-',$profile[0]->account_opening_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name of the bank</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_the_bank != '' ? $profile[0]->name_of_the_bank : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name of Branch</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->branch != '' ? $profile[0]->branch : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Account no</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->account_number != '' ? $profile[0]->account_number : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Contact Information</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name of contact</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_the_contact_person != '' ? $profile[0]->name_of_the_contact_person : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Designation</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->designation != '' ? $profile[0]->designation : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Contact Number</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->contact_number != '' ? $profile[0]->contact_number : 0 }}
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
                                                <h5>Cluster Details</h5>
                                                
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_cluster }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>UIN</strong></div>
                                                            <div class="col-6">{{ $cluster->uin }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Cluster office
                                                                    location</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->office_location != '' ? $profile[0]->office_location : 'N/A' }}
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
                                                            <div class="col-6"><strong>District</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_district != '' ? $profile[0]->name_of_district : 'N/A' }}
                                                            </div>
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
                                                                {{ $profile[0]->vo_code }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Cluster Creation and Membership </h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date cluster was
                                                                    formed</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->cluster_formed != '' ? $profile[0]->cluster_formed : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of SHGs at
                                                                    Creation</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->shg_at_time_creation != '' ? $profile[0]->shg_at_time_creation : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of members at
                                                                    creation</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->cluster_members_at_time_creation != '' ? $profile[0]->cluster_members_at_time_creation : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of current SHGs</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->total_SHGs != '' ? $profile[0]->total_SHGs : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of current
                                                                    Members</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->total_members != '' ? $profile[0]->total_members : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Current Leadership </h5>
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
                                                                {{ $profile[0]->book_keeper_name }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of
                                                                    appointment</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->date_of_appointment != '' ? $profile[0]->date_of_appointment : 'N/A' }}
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
                                                                {{ $profile[0]->account_opening_date != '' ? $profile[0]->account_opening_date : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name of the bank</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_the_bank != '' ? $profile[0]->name_of_the_bank : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name of Branch</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->branch != '' ? $profile[0]->branch : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Account no</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->account_number != '' ? $profile[0]->account_number : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Contact Information</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Name of contact</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->name_of_the_contact_person != '' ? $profile[0]->name_of_the_contact_person : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Designation</strong></div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->designation != '' ? $profile[0]->designation : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Contact Number</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $profile[0]->contact_number != '' ? $profile[0]->contact_number : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                                <!----tab 2---->
                                <div class="tab-pane fade" id="v-pills-Governance-and-Accountability" role="tabpanel"
                                    aria-labelledby="v-pills-Governance-and-Accountability-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Adoption of Rules </h5>
                                        </div>
                                        
                                        
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Adoption of Rules</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ checkna($governance[0]->adoption_of_rules) }}</div>
                                                        </div>
                                                    </div>
                                                    @if ($governance[0]->adoption_of_rules == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Written Rules</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->written_norms }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of Adoption</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->date_adoption !='' ? Change_date_month_name_char(str_replace('/', '-', $governance[0]->date_adoption)) : 'N/A' }}
                                                                </div>
                                                                
                                                        </div>
                                                    </div>
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
                                                            {{ $governance[0]->frequency_per_norms !='' ? $governance[0]->frequency_per_norms  : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>1st election date </strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->first_election_date !='' ? Change_date_month_name_char(str_replace('/', '-', $governance[0]->first_election_date)) :'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of Elections conducted so
                                                                far</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->elections_conducted !=''? $governance[0]->elections_conducted : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Date of Last Election</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->date_last_election !='' ? Change_date_month_name_char(str_replace('/', '-', $governance[0]->date_last_election))  : 'N/A' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Last 2 elections conducted as
                                                                per
                                                                norms</strong></div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->last_two_election_conducted !='' ? $governance[0]->last_two_election_conducted : 'N/A' }}</div>
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
                                                            {{ $governance[0]->frequency_of_meetings !='' ? $governance[0]->frequency_of_meetings : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of meetings conducted during
                                                                last 12
                                                                months</strong></div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->meetings_cluster_conducted !='' ? $governance[0]->meetings_cluster_conducted : 0}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Average Participation of
                                                                Members during
                                                                last 12 months</strong></div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->participation_members !='' ? $governance[0]->participation_members : 0 }}
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
                                                        <div class="col-6"><strong>Separate minute book</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ checkna($governance[0]->minute_book_to_record_minute) }}</div>
                                                    </div>
                                                </div>
                                                @if ($governance[0]->minute_book_to_record_minute == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Status of group meetings
                                                                    recorded</strong></div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->meetings_recorded }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Who writes the
                                                                    minutes</strong></div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->who_writes_minutes }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Book Updated</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>How Often are book updated</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->books_updated !='' ? $governance[0]->books_updated : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Date of last update</strong></div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->date_last_updated !='' ? change_date_month_name_char($governance[0]->date_last_updated) : 0}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Updated Status</strong></div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->updated_status !='' ? $governance[0]->updated_status : 0 }}
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
                                                            <strong>Bank accounts in regular operation during last 12 months</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>{{ $governance[0]->accounts_regular != ''? $governance[0]->accounts_regular: 'N/A' }}</strong>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Grade of Cluster during last 12 months</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6">
                                                            <strong>Grade of Cluster</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>{{ $governance[0]->grading_cluster !='' ?  $governance[0]->grading_cluster : 'N/A' }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Social Audit Committee</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Whether cluster has a
                                                                SAC</strong></div>
                                                        <div class="col-6">
                                                            {{ checkna($governance[0]->social_audit_committee) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($governance[0]->social_audit_committee == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>SAC creation date</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->sac_created !='' ? Change_date_month_name_char(str_replace('/', '-', $governance[0]->sac_created)) : 'N/A'}}</div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Functions of SAC
                                                                (describe)</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->function_sac_a . ',' . $governance[0]->function_sac_b . ',' . $governance[0]->function_sac_c . ',' . $governance[0]->function_sac_d }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>How many SAC reports prepared
                                                                and
                                                                submitted during last 12 months</strong></div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->sac_reports_submitted !='' ? $governance[0]->sac_reports_submitted : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Date of last report</strong>
                                                        </div>
                                                        
                                                            <div class="col-6">
                                                                {{ $governance[0]->date_last_report !='' ? Change_date_month_name_char(str_replace('/', '-', $governance[0]->date_last_report)) : 'N/A' }}
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Internal Audit  </h5>
                                        </div>
                                       
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Is Internal audit available
                                                                    </strong></div>
                                                            <div class="col-6">
                                                                {{ checkna($governance[0]->internal_audit) }}</div>
                                                        </div>
                                                    </div>
                                                    @if ($governance[0]->internal_audit == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>How often</strong></div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->internal_how_often }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of internal audit
                                                                    during last 12
                                                                    months</strong></div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->date_internal_audit !='' ? Change_date_month_name_char(str_replace('/', '-', $governance[0]->date_internal_audit)) : 'N/A'}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Issues and observations
                                                                    raised during
                                                                    last 12 months (Describe)</strong></div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->internal_observations_raised }}</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>How many issues were
                                                                    resolved
                                                                    (describe)</strong></div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->internal_issues_resolved }}
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->issues_highlighted_by_internal_audit_other }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>External Audit  </h5>
                                        </div>
                                        
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Is External audit available
                                                                    </strong></div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->external_audit != '' ? $governance[0]->external_audit : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($governance[0]->external_audit == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>How often</strong></div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->external_how_often }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of internal audit
                                                                    during last 12
                                                                    months</strong></div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->date_last_audit_conducted !='' ? Change_date_month_name_char(str_replace('/', '-', $governance[0]->date_last_audit_conducted)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Issues and observations
                                                                    raised during
                                                                    last 12 months (Describe)</strong></div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->external_observations_raised }}</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>How many issues were
                                                                    resolved
                                                                    (describe)</strong></div>
                                                            <div class="col-6">
                                                                {{ $governance[0]->external_issues_resolved }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                       
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Committees  </h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    
                                                    <th>Committees</th>
                                                    <th>  {{ $governance[0]->cluster_sub_committees !='' ?  $governance[0]->cluster_sub_committees : 'N/A' }}</th>
                                                </tr>
                                            </thead>
                                            
                                        </table>
                                        @if ($governance[0]->cluster_sub_committees == 'Yes')
                                            @if (!empty($governance_service))
                                                @foreach ($governance_service as $row)
                                                    <div class="card-box">
                                                        <div class="row alldetail">
                                                            <div class="col-md-6">
                                                                <div class="row detail">
                                                                    <div class="col-6"><strong>Name of
                                                                            subcommittee</strong>
                                                                    </div>
                                                                    <div class="col-6">{{ $row->name }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row detail">
                                                                    <div class="col-6"><strong>Purpose</strong>
                                                                    </div>
                                                                    <div class="col-6">{{ $row->purpose }}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="row detail">
                                                                    <div class="col-6"><strong>Date formed
                                                                        </strong></div>
                                                                    <div class="col-6">{{ $row->date_formed }}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="row detail">
                                                                    <div class="col-6"><strong>No of members
                                                                        </strong></div>
                                                                    <div class="col-6">{{ $row->members }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Defunct SHG status in the Cluster</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Total SHGs formed in
                                                                cluster</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->total_shgs_formed !='' ? $governance[0]->total_shgs_formed : 0}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>At present no of SHGs
                                                                defunct</strong>
                                                        </div>
                                                        <div class="col-6">{{ $governance[0]->shgs_defunct !='' ? $governance[0]->shgs_defunct : 0 }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Defunct SHGs (%)</strong></div>
                                                        @if ($governance[0]->defunct_shgs_par == '')
                                                        <div class="col-6">
                                                            {{ $governance[0]->defunct_shgs_par !='' ? $governance[0]->defunct_shgs_par : 0}}%</div>  
                                                        @elseif($governance[0]->defunct_shgs_par == 0)
                                                        {{ $governance[0]->defunct_shgs_par}}%</div>  
                                                        @else
                                                        {{ $governance[0]->defunct_shgs_par}}</div>
                                                        @endif
                                                        
                                                    </div>
                                                </div>

                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Reasons for defunct
                                                                (explain)</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $governance[0]->defunct_shgs_reasons !='' ? $governance[0]->defunct_shgs_reasons : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!----tab-3----->
                                <div class="tab-pane fade" id="v-pills-Inclusion" role="tabpanel"
                                    aria-labelledby="v-pills-Inclusion-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Wealth Ranking/Poverty Mapping  
                                                </h5>
                                            
                                        </div>
                                        
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Wealth Ranking/Poverty Mapping</strong>
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
                                                                {{ $inclusion[0]->first_poverty_mapping !='' ?  Change_date_month_name_char(str_replace('/', '-', $inclusion[0]->first_poverty_mapping)) : 'N/A'  }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of last
                                                                    update</strong></div>
                                                            <div class="col-6">
                                                                {{ $inclusion[0]->last_update !='' ? Change_date_month_name_char(str_replace('/', '-', $inclusion[0]->last_update)) : 'N/A'}}</div>
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
                                                            {{ $inclusion[0]->visual_poorest_category != '' ? $inclusion[0]->visual_poorest_category : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of Poor</strong></div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->visual_poor_category != '' ? $inclusion[0]->visual_poor_category : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of Medium Poor</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->visual_medium_category != '' ? $inclusion[0]->visual_medium_category : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of Rich</strong></div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->visual_rich_category != '' ? $inclusion[0]->visual_rich_category : 0 }}
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
                                                            {{ $inclusion[0]->sc_st_caste != '' ? $inclusion[0]->sc_st_caste : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of OBC</strong></div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->obc_caste != '' ? $inclusion[0]->obc_caste : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of others</strong></div>
                                                        <div class="col-6">
                                                            {{ $inclusion[0]->other_caste != '' ? $inclusion[0]->other_caste : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Cumulative No. of loans and amounts at Cluster level during last 3 years
                                            </h5>
                                        </div>
                                        <table class="table mytable table-responsive">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Category</th>
                                                    <th class="table_th" colspan="2">Cluster Loans (i)</th>
                                                    <th class="table_th" colspan="2">External Loans</th>
                                                    <th class="table_th" colspan="2">VI Loans (iii)</th>
                                                    <th class="table_th" colspan="2">Total Loans (i+ii+iii)</th>
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
                                                </tr>
                                                <tr>
                                                    <td>Very Poor &amp; vulnerable</td>
                                                    <td>{{ (int) $inclusion[0]->federation_poorest_category }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_poorest_category_amount }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->external_poorest_category }}</td>
                                                    <td>{{ (int) $inclusion[0]->external_poorest_category_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_poorest_category }}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_poorest_category_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_poorest_category + (int) $inclusion[0]->external_poorest_category + (int) $inclusion[0]->vi_poorest_category }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->federation_poorest_category_amount + (int) $inclusion[0]->external_poorest_category_amount + (int) $inclusion[0]->vi_poorest_category_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Poor</td>
                                                    <td>{{ (int) $inclusion[0]->federation_poor_category }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_poor_category_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->external_poor_category }}</td>
                                                    <td>{{ (int) $inclusion[0]->external_poor_category_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_poor_category }}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_poor_category_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_poor_category + (int) $inclusion[0]->external_poor_category + (int) $inclusion[0]->vi_poor_category }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->federation_poor_category_amount + (int) $inclusion[0]->external_poor_category_amount + (int) $inclusion[0]->vi_poor_category_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Medium poor</td>
                                                    <td>{{ (int) $inclusion[0]->federation_medium }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_medium_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->external_medium }}</td>
                                                    <td>{{ (int) $inclusion[0]->external_medium_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_medium }}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_medium_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_medium + (int) $inclusion[0]->external_medium + (int) $inclusion[0]->vi_medium }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->federation_medium_amount + (int) $inclusion[0]->external_medium_amount + (int) $inclusion[0]->vi_medium_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Rich</td>
                                                    <td>{{ (int) $inclusion[0]->federation_rich }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_rich_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->external_rich }}</td>
                                                    <td>{{ (int) $inclusion[0]->external_rich_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_rich }}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_rich_amount }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_rich + (int) $inclusion[0]->external_rich + (int) $inclusion[0]->vi_rich }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->federation_rich_amount + (int) $inclusion[0]->external_rich_amount + (int) $inclusion[0]->vi_rich_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <td>{{ (int) $inclusion[0]->federation_poorest_category + (int) $inclusion[0]->federation_poor_category + (int) $inclusion[0]->federation_medium + (int) $inclusion[0]->federation_rich }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->federation_poorest_category_amount + (int) $inclusion[0]->federation_poor_category_amount + (int) $inclusion[0]->federation_medium_amount + (int) $inclusion[0]->federation_rich_amount }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->external_poorest_category + (int) $inclusion[0]->external_poor_category + (int) $inclusion[0]->external_medium + (int) $inclusion[0]->external_rich }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->external_poorest_category_amount + (int) $inclusion[0]->external_poor_category_amount + (int) $inclusion[0]->external_medium_amount + (int) $inclusion[0]->external_rich_amount }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->vi_poorest_category + (int) $inclusion[0]->vi_poor_category + (int) $inclusion[0]->vi_medium + (int) $inclusion[0]->vi_rich }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->vi_poorest_category_amount + (int) $inclusion[0]->vi_poor_category_amount + (int) $inclusion[0]->vi_medium_amount + (int) $inclusion[0]->vi_rich_amount }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->federation_poorest_category + (int) $inclusion[0]->external_poorest_category + (int) $inclusion[0]->vi_poorest_category + (int) $inclusion[0]->federation_poor_category + (int) $inclusion[0]->external_poor_category + (int) $inclusion[0]->vi_poor_category + (int) $inclusion[0]->federation_medium + (int) $inclusion[0]->external_medium + (int) $inclusion[0]->vi_medium + (int) $inclusion[0]->federation_rich + (int) $inclusion[0]->external_rich + (int) $inclusion[0]->vi_rich }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->federation_poorest_category_amount + (int) $inclusion[0]->external_poorest_category_amount + (int) $inclusion[0]->vi_poorest_category_amount + (int) $inclusion[0]->federation_poor_category_amount + (int) $inclusion[0]->external_poor_category_amount + (int) $inclusion[0]->vi_poor_category_amount + (int) $inclusion[0]->federation_medium_amount + (int) $inclusion[0]->external_medium_amount + (int) $inclusion[0]->vi_medium_amount + (int) $inclusion[0]->federation_rich_amount + (int) $inclusion[0]->external_rich_amount + (int) $inclusion[0]->vi_rich_amount }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>No. of Cluster HHs benefitted from all loans during last 12 months</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th rowspan="2">Category(a)</th>
                                                    <th rowspan="2">Cluster Member HHs (#)</th>
                                                    <th colspan="5" class="text-center">Received Loan / Clustermember
                                                        HHs
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Cluster Loan</th>
                                                    <th>External loan</th>
                                                    <th>VI Loan</th>

                                                </tr>

                                                <tr>
                                                    <td>Very Poor &amp; vulnerable</td>
                                                    <td>{{ (int)$inclusion[0]->visual_poorest_category }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_poorest_category_recloan }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->external_poorest_category_recloan }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->vi_poorest_category_recloan }}</td>
                                                    {{-- <td>{{ (int) $inclusion[0]->federation_poorest_category_recloan . '/' .$inclusion[0]->visual_poorest_category}}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->external_poorest_category_recloan . '/' .$inclusion[0]->visual_poorest_category}}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->vi_poorest_category_recloan . '/' .$inclusion[0]->visual_poorest_category}}</td> --}}
                                                </tr>

                                                <tr>
                                                    <td>Poor</td>
                                                    <td>{{ (int) $inclusion[0]->visual_poor_category }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_poor_category_recloan }}</td>
                                                    <td>{{ (int) $inclusion[0]->external_poor_category_recloan }}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_poor_category_recloan }}</td>
                                                    {{-- <td>{{ (int) $inclusion[0]->federation_poor_category_recloan . '/' .$inclusion[0]->visual_poor_category}}</td>
                                                    <td>{{ (int) $inclusion[0]->external_poor_category_recloan . '/' .$inclusion[0]->visual_poor_category}}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_poor_category_recloan . '/' .$inclusion[0]->visual_poor_category}}</td> --}}
                                                </tr>

                                                <tr>
                                                    <td>Medium</td>
                                                    <td>{{  (int)$inclusion[0]->visual_medium_category }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_medium_recloan }}</td>
                                                    <td>{{ (int) $inclusion[0]->external_medium_recloan }}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_medium_recloan }}</td>
                                                    {{-- <td>{{ (int) $inclusion[0]->federation_medium_recloan . '/' .$inclusion[0]->visual_medium_category}}</td>
                                                    <td>{{ (int) $inclusion[0]->external_medium_recloan . '/' .$inclusion[0]->visual_medium_category}}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_medium_recloan . '/' .$inclusion[0]->visual_medium_category}}</td> --}}
                                                </tr>

                                                <tr>
                                                    <td>Rich</td>
                                                    <td>{{ (int)$inclusion[0]->visual_rich_category }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_rich_recloan }}</td>
                                                    <td>{{ (int) $inclusion[0]->external_rich_recloan }}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_rich_recloan }}</td>
                                                    {{-- <td>{{ (int) $inclusion[0]->federation_rich_recloan . '/' .$inclusion[0]->visual_rich_category}}</td>
                                                    <td>{{ (int) $inclusion[0]->external_rich_recloan . '/' .$inclusion[0]->visual_rich_category}}</td>
                                                    <td>{{ (int) $inclusion[0]->vi_rich_recloan . '/' .$inclusion[0]->visual_rich_category}}</td> --}}
                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <td>{{(int)$inclusion[0]->visual_poorest_category+(int) $inclusion[0]->visual_poor_category + (int)$inclusion[0]->visual_medium_category +  (int)$inclusion[0]->visual_rich_category }}</td>
                                                    <td>{{ (int) $inclusion[0]->federation_poorest_category_recloan + (int) $inclusion[0]->federation_poor_category_recloan + (int) $inclusion[0]->federation_medium_recloan + (int) $inclusion[0]->rich_members_benefited_cluster }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->external_poorest_category_recloan + (int) $inclusion[0]->external_poor_category_recloan + (int) $inclusion[0]->external_medium_recloan + (int) $inclusion[0]->external_rich_recloan }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->vi_poorest_category_recloan + (int) $inclusion[0]->vi_poor_category_recloan + (int) $inclusion[0]->vi_medium_recloan + (int) $inclusion[0]->vi_rich_recloan }}
                                                    </td>
                                                    {{-- <td>{{ (int) $inclusion[0]->federation_poorest_category_recloan + (int) $inclusion[0]->federation_poor_category_recloan + (int) $inclusion[0]->federation_medium_recloan + (int) $inclusion[0]->rich_members_benefited_cluster .'/' .((int)$inclusion[0]->visual_rich_category + (int)$inclusion[0]->visual_medium_category + (int)$inclusion[0]->visual_poor_category + (int)$inclusion[0]->visual_poorest_category ) }}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->external_poorest_category_recloan + (int) $inclusion[0]->external_poor_category_recloan + (int) $inclusion[0]->external_medium_recloan + (int) $inclusion[0]->external_rich_recloan .'/' .((int)$inclusion[0]->visual_rich_category + (int)$inclusion[0]->visual_medium_category +(int)$inclusion[0]->visual_poor_category +(int)$inclusion[0]->visual_poorest_category )}}
                                                    </td>
                                                    <td>{{ (int) $inclusion[0]->vi_poorest_category_recloan + (int) $inclusion[0]->vi_poor_category_recloan + (int) $inclusion[0]->vi_medium_recloan + (int) $inclusion[0]->vi_rich_recloan .'/' .((int)$inclusion[0]->visual_rich_category + (int)$inclusion[0]->visual_medium_category +(int)$inclusion[0]->visual_poor_category +(int)$inclusion[0]->visual_poorest_category ) }}
                                                    </td> --}}
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>No of poor and most poor in Leadership position </h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6">
                                                            <strong>No of poor and most poor in Leadership position</strong>
                                                            
                                                        </div>
                                                        <div class="col-6">
                                                            <strong>{{ (int) $inclusion[0]->poor_current_leadership }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Cluster Board Constitution </h5>
                                            </div>
                                            
                                                <div class="card-box">
                                                    <div class="row alldetail">
                                                        <div class="col-md-6 table-padd">
                                                            <div class="row detail">
                                                                <div class="col-6"><strong>Cluster Board Constitution</strong>
                                                                </div>
                                                                <div class="col-6">
                                                                    {{ $inclusion[0]->board_members_constitution !='' ?  $inclusion[0]->board_members_constitution : 'N/A' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($inclusion[0]->board_members_constitution == 'Yes')
                                                        <div class="col-md-6 table-padd">
                                                            <div class="row detail">
                                                                <div class="col-6"><strong>Total no of Board
                                                                        members</strong>
                                                                </div>
                                                                <div class="col-6">
                                                                    {{ $inclusion[0]->total_board_members }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 table-padd">
                                                            <div class="row detail">
                                                                <div class="col-6"><strong>No of members from the
                                                                        poorest
                                                                        and
                                                                        vulnerable</strong></div>
                                                                <div class="col-6">
                                                                    {{ $inclusion[0]->poorest_board_members }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 table-padd">
                                                            <div class="row detail">
                                                                <div class="col-6"><strong>No of members from the
                                                                        poor</strong>
                                                                </div>
                                                                <div class="col-6">
                                                                    {{ $inclusion[0]->poor_board_members }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 table-padd">
                                                            <div class="row detail">
                                                                <div class="col-6"><strong>No of members from
                                                                        middle and
                                                                        rich
                                                                        category</strong></div>
                                                                <div class="col-6">
                                                                    {{ $inclusion[0]->rich_board_members }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            
                                        </div>

                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Coverage of target mobilization</h5>
                                            </div>
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Total target poor in the
                                                                    cluster</strong></div>
                                                            <div class="col-6">
                                                                {{ $inclusion[0]->total_target_poor != '' ? $inclusion[0]->total_target_poor : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>No of target poor mobilized
                                                                    in
                                                                    SHGs</strong></div>
                                                            <div class="col-6">
                                                                {{ $inclusion[0]->target_poor_mobilized != '' ? $inclusion[0]->target_poor_mobilized : 0 }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>% of target poor mobilized
                                                                    in
                                                                    SHGs</strong></div>
                                                            <div class="col-6">
                                                                {{ $inclusion[0]->percentage_poor_mobilized != '' ? $inclusion[0]->percentage_poor_mobilized : '0%' }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!----tab-4----->
                                <div class="tab-pane fade" id="v-pills-Efficiency" role="tabpane"
                                    aria-labelledby="v-pills-Efficiency-tab">
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Cluster Integrated Member Plan Prepared  
                                                </h5>
                                            
                                        </div>
                                        
                                            <div class="card-box">
                                                <div class="row alldetail">
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Integrated Member Plan Prepared</strong></div>
                                                            <div class="col-6">
                                                                {{ $efficiency[0]->cluster_prepared !='' ?  $efficiency[0]->cluster_prepared : 'N/A' }}</div>
                                                        </div>
                                                    </div>
                                                    @if ($efficiency[0]->cluster_prepared == 'Yes')
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date of last plan approved
                                                                    by
                                                                    Cluster</strong></div>
                                                            <div class="col-6">
                                                                {{ $efficiency[0]->date_approved !='' ? Change_date_month_name_char(str_replace('/', '-', $efficiency[0]->date_approved)) : 'N/A' }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 table-padd">
                                                        <div class="row detail">
                                                            <div class="col-6"><strong>Date it was submitted to
                                                                    Federation/partner</strong></div>
                                                            <div class="col-6">
                                                                {{ $efficiency[0]->date_submitted !='' ? Change_date_month_name_char(str_replace('/', '-', $efficiency[0]->date_submitted)) : 'N/A'}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Capacity Building of Current committee members/leaders</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    {{-- <th>SN</th>
                                                    <th>Designation</th> --}}
                                                    <th>Name of training</th>
                                                    <th>Duration</th>
                                                    <th>Date</th>
                                                    <th>Name of Training Recipient</th>
                                                    <th>Name of Trainer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($efficiency_1))
                                                    @foreach ($efficiency_1 as $row)
                                                        <tr>
                                                            {{-- <td>A</td>
                                                            <td>Current Leaders (president/animator, treasurer and
                                                                secretary)</td> --}}
                                                            <td>{{ $row->training_name }}</td>
                                                            <td>{{ $row->duration }}</td>
                                                            <td>{{ $row->date_training }}</td>
                                                            <td>
                                                                @php
                                                                    $desg = [];
                                                                    if ($row->who_received_sec == 1) {
                                                                        $desg[] = 'Secretary';
                                                                    }
                                                                    if ($row->who_received_pres == 1) {
                                                                        $desg[] = 'President';
                                                                    }
                                                                    if ($row->who_received_treas == 1) {
                                                                        $desg[] = 'Treasurer';
                                                                    }
                                                                    if ($row->who_received_other == 1) {
                                                                        $desg[] = 'Other';
                                                                    }
                                                                    $strdesg = implode(',', $desg);
                                                                @endphp
                                                                {{ $strdesg }}</td>
                                                            <td>{{ $row->training_name }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                @if (!empty($efficiency_2))
                                                    @foreach ($efficiency_2 as $row)
                                                        <tr>
                                                            {{-- <td>B</td>
                                                            <td>SAC members</td> --}}
                                                            <td>{{ $row->training_name }}</td>
                                                            <td>{{ $row->duration }}</td>
                                                            <td>{{ $row->date_training }}</td>
                                                            <td>
                                                                @php
                                                                    $desg = [];
                                                                    if ($row->who_received_sec == 1) {
                                                                        $desg[] = 'Secretary';
                                                                    }
                                                                    if ($row->who_received_pres == 1) {
                                                                        $desg[] = 'President';
                                                                    }
                                                                    if ($row->who_received_treas == 1) {
                                                                        $desg[] = 'Treasurer';
                                                                    }
                                                                    if ($row->who_received_other == 1) {
                                                                        $desg[] = 'Other';
                                                                    }
                                                                    $strdesg = implode(',', $desg);
                                                                @endphp
                                                                {{ $strdesg }}</td>
                                                            <td>{{ $row->training_name }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                {{-- @if (!empty($efficiency_3))
                                                    @foreach ($efficiency_3 as $row)
                                                        <tr>

                                                            <td>{{ $row->training_name }}</td>
                                                            <td>{{ $row->duration }}</td>
                                                            <td>{{ $row->date_training }}</td>
                                                            <td>
                                                                @php
                                                                    $desg = [];
                                                                    if ($row->who_received_sec == 1) {
                                                                        $desg[] = 'Secretary';
                                                                    }
                                                                    if ($row->who_received_pres == 1) {
                                                                        $desg[] = 'President';
                                                                    }
                                                                    if ($row->who_received_treas == 1) {
                                                                        $desg[] = 'Treasurer';
                                                                    }
                                                                    if ($row->who_received_other == 1) {
                                                                        $desg[] = 'Other';
                                                                    }
                                                                    $strdesg = implode(',', $desg);
                                                                @endphp
                                                                {{ $strdesg }}</td>
                                                            <td>{{ $row->training_name }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif --}}

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Has SAC members recived training</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    {{-- <th>SN</th>
                                                    <th>Designation</th> --}}
                                                    <th>Name of training</th>
                                                    <th>Duration</th>
                                                    <th>Date</th>
                                                    <th>Name of Training Recipient</th>
                                                    <th>Name of Trainer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                

                                                @if (!empty($efficiency_2))
                                                    @foreach ($efficiency_2 as $row)
                                                        <tr>
                                                            {{-- <td>B</td>
                                                            <td>SAC members</td> --}}
                                                            <td>{{ $row->training_name }}</td>
                                                            <td>{{ $row->duration }}</td>
                                                            <td>{{ $row->date_training }}</td>
                                                            <td>
                                                                @php
                                                                    $desg = [];
                                                                    if ($row->who_received_sec == 1) {
                                                                        $desg[] = 'Secretary';
                                                                    }
                                                                    if ($row->who_received_pres == 1) {
                                                                        $desg[] = 'President';
                                                                    }
                                                                    if ($row->who_received_treas == 1) {
                                                                        $desg[] = 'Treasurer';
                                                                    }
                                                                    if ($row->who_received_other == 1) {
                                                                        $desg[] = 'Other';
                                                                    }
                                                                    $strdesg = implode(',', $desg);
                                                                @endphp
                                                                {{ $strdesg }}</td>
                                                            <td>{{ $row->training_name }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Cluster Income and Expenses during last 12 months </h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Income from all
                                                                sources</strong></div>
                                                        <div class="col-6">{{ $efficiency[0]->total_income !='' ? $efficiency[0]->total_income : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Expenses </strong></div>
                                                        <div class="col-6">{{ $efficiency[0]->expense !='' ? $efficiency[0]->expense  : 'N/A' }}</div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Approval Process </h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of days taken to approve
                                                                loan
                                                                application at Cluster </strong></div>
                                                        <div class="col-6">
                                                            {{ $efficiency[0]->time_taken_to_approve_loan !='' ? $efficiency[0]->time_taken_to_approve_loan : 'N/A' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Average Monthly loans during
                                                                last 12
                                                                months</strong></div>
                                                        <div class="col-6">
                                                            {{ $efficiency[0]->loans_approved !='' ? $efficiency[0]->loans_approved : 'N/A' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Time taken from approval to
                                                                cash in hand
                                                            </strong></div>
                                                        <div class="col-6">
                                                            {{ $efficiency[0]->time_taken_to_give_loan !='' ? $efficiency[0]->time_taken_to_give_loan : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Monthly reports </h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">

                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Date of last report
                                                                submitted</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            {{ $efficiency[0]->last_report_submitted !='' ? Change_date_month_name_char(str_replace('/', '-', $efficiency[0]->last_report_submitted)) : 'N/A'}}
                                                        </div>
                                                    </div>
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
                                            <h5>Credit History</h5>
                                            
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of loan applications
                                                                received at
                                                                Cluster during last 12 months</strong></div>
                                                        <div class="col-6">
                                                            {{ $creditrecovery[0]->applications_received_loans != '' ? $creditrecovery[0]->applications_received_loans : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>No of loan applications
                                                                approved during
                                                                last 12 months</strong></div>
                                                        <div class="col-6">
                                                            {{ $creditrecovery[0]->approved_loan != '' ? $creditrecovery[0]->approved_loan : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Pending loan
                                                                applications</strong></div>
                                                        <div class="col-6">
                                                            {{ $creditrecovery[0]->pending_loan_applications != '' ? $creditrecovery[0]->pending_loan_applications : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Cumulative Loan Amount at Cluster</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Institution</th>
                                                    <th>Amount (Rs)</th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Cluster</td>
                                                    <td>{{ $creditrecovery[0]->cumulative_amount_cluster != '' ? $creditrecovery[0]->cumulative_amount_cluster : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Federation</td>
                                                    <td>{{ $creditrecovery[0]->cumulative_amount_federation != '' ? $creditrecovery[0]->cumulative_amount_federation : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Bank</td>
                                                    <td>{{ $creditrecovery[0]->cumulative_amount_bank != '' ? $creditrecovery[0]->cumulative_amount_bank : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>VI</td>
                                                    <td>{{ $creditrecovery[0]->cumulative_amount_vi != '' ? $creditrecovery[0]->cumulative_amount_vi : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Other</td>
                                                    <td>{{ $creditrecovery[0]->cumulative_amount_other != '' ? $creditrecovery[0]->cumulative_amount_other : 0 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Total</td>
                                                    <td>{{ $creditrecovery[0]->total_cumulative_amount != '' ? $creditrecovery[0]->total_cumulative_amount : 0 }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>No of Cumulative Loans disbursed to members during last 3 years</h5>
                                        </div>
                                        <table class="table mytable table-responsive">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Cluster Loans # (A)</th>
                                                    <th>Federation Loans # (B)</th>
                                                    <th>Bank loans # (C)</th>
                                                    <th>VI loans # (D)</th>
                                                    <th>Other Loans #(E)</th>
                                                    <th>Total No of Loans</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>(i)Very Poor &amp; vulnerable</td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_cluster }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_federation }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_bank }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_vi }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_other }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_cluster + (int) $creditrecovery[0]->cumulative_members_federation + (int) $creditrecovery[0]->cumulative_members_bank + (int) $creditrecovery[0]->cumulative_members_vi + (int) $creditrecovery[0]->cumulative_members_other }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>(ii) Poor</td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ai }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5bi }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ci }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5di }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ei }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ai + (int) $creditrecovery[0]->new_cluster_creditHistory_question5bi + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ci + (int) $creditrecovery[0]->new_cluster_creditHistory_question5di + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ei }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>(iii) Medium poor</td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5aii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5bii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5cii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5dii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5eii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5aii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5bii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5cii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5dii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5eii }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>(iv) Rich</td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5aiii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5biii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5ciii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5diii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5eiii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->new_cluster_creditHistory_question5aiii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5biii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ciii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5diii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5eiii }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>(v) Total</td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_cluster + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ai + (int) $creditrecovery[0]->new_cluster_creditHistory_question5aii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5aiii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_federation + (int) $creditrecovery[0]->new_cluster_creditHistory_question5bi + (int) $creditrecovery[0]->new_cluster_creditHistory_question5bii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5biii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_bank + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ci + (int) $creditrecovery[0]->new_cluster_creditHistory_question5cii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ciii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_vi + (int) $creditrecovery[0]->new_cluster_creditHistory_question5di + (int) $creditrecovery[0]->new_cluster_creditHistory_question5dii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5diii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_other + (int) $creditrecovery[0]->new_cluster_creditHistory_question5ei + (int) $creditrecovery[0]->new_cluster_creditHistory_question5eii + (int) $creditrecovery[0]->new_cluster_creditHistory_question5eiii }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_members_cluster +
                                            (int) $creditrecovery[0]->cumulative_members_federation +
                                            (int) $creditrecovery[0]->cumulative_members_bank +
                                            (int) $creditrecovery[0]->cumulative_members_vi +
                                            (int) $creditrecovery[0]->cumulative_members_other +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5ai +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5bi +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5ci +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5di +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5ei +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5aii +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5bii +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5cii +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5dii +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5eii +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5aiii +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5biii +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5ciii +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5diii +
                                            (int) $creditrecovery[0]->new_cluster_creditHistory_question5eiii }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>No of member HHs Received Loans during last 3 years</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Institution</th>
                                                    <th>No of HHS Received Loans</th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Cluster/Habitation/Neighbourhood Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_poor_members_cluster }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Federation Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_poor_members_federation }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Bank Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_poor_members_bank }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>VI Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_poor_members_vi }}</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Other Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->cumulative_poor_members_other }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Total</td>
                                                    <td>{{ (int) $creditrecovery[0]->total_cumulative_poor_members }}
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
                                        <table class="table mytable table-responsive">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>DCB</th>
                                                    <th>Cluster Loans (A)</th>
                                                    <th>FederationLoan (C)</th>
                                                    <th>Bank Loan (D)</th>
                                                    <th>VI Loan E</th>
                                                    <th>Other Loans E </th>
                                                    <th>Summary Loan Portfolio </th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>i.</td>
                                                    <td>Total Loan Amount Given (Rs.)</td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_loan_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_loan_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->bank_loan_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->vi_loan_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->other_loan_amount }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_loan_amount + (int) $creditrecovery[0]->federation_loan_amount + (int) $creditrecovery[0]->bank_loan_amount + (int) $creditrecovery[0]->vi_loan_amount + (int) $creditrecovery[0]->other_loan_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii.</td>
                                                    <td>Total Demand upto last month for active loans</td>
                                                    <td>{{ (int) $creditrecovery[0]->dcb_cluster }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->dcb_federation }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->dcb_bank }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->dcb_vi }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->dcb_other }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->dcb_cluster + (int) $creditrecovery[0]->dcb_federation + (int) $creditrecovery[0]->dcb_bank + (int) $creditrecovery[0]->dcb_vi + (int) $creditrecovery[0]->dcb_other }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii.</td>
                                                    <td>Actual Amount Paid upto last month</td>
                                                    <td>{{ (int) $creditrecovery[0]->repaid_cluster }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->repaid_federation }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->repaid_bank }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->repaid_vi }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->repaid_other }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->repaid_cluster + (int) $creditrecovery[0]->repaid_federation + (int) $creditrecovery[0]->repaid_bank + (int) $creditrecovery[0]->repaid_vi + (int) $creditrecovery[0]->repaid_other }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iv.</td>
                                                    <td>Overdue Amount</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_amount_cluster }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_amount_federation }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_amount_bank }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_amount_vi }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_amount_other }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_amount_cluster + (int) $creditrecovery[0]->overdue_amount_federation + (int) $creditrecovery[0]->overdue_amount_bank + (int) $creditrecovery[0]->overdue_amount_vi + (int) $creditrecovery[0]->overdue_amount_other }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>v.</td>
                                                    <td>Outstanding amount for active loans</td>
                                                    <td>{{ (int) $creditrecovery[0]->outstanding_amount_cluster }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->outstanding_amount_federation }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->outstanding_amount_bank }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->outstanding_amount_vi }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->outstanding_amount_other }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->outstanding_amount_cluster + (int) $creditrecovery[0]->outstanding_amount_federation + (int) $creditrecovery[0]->outstanding_amount_bank + (int) $creditrecovery[0]->outstanding_amount_vi + (int) $creditrecovery[0]->outstanding_amount_other }}
                                                    </td>
                                                </tr>
                                                @php
                                                $num=0;
                                                    if (!empty($creditrecovery[0]->cluster_repayment_rate)) {
                                                        $a = (float) str_replace('%', '', $creditrecovery[0]->cluster_repayment_rate);
                                                        $num=1;
                                                    } else {
                                                        $a = 0;
                                                    }
                                                    if (!empty($creditrecovery[0]->federation_repayment_rate)) {
                                                        $b = (float) str_replace('%', '', $creditrecovery[0]->federation_repayment_rate);
                                                        $num = $num+1;
                                                    } else {
                                                        $b = 0;
                                                    }
                                                    if (!empty($creditrecovery[0]->bank_repayment_rate)) {
                                                        $c = (float) str_replace('%', '', $creditrecovery[0]->bank_repayment_rate);
                                                        $num = $num+1;
                                                    } else {
                                                        $c = 0;
                                                    }
                                                    if (!empty($creditrecovery[0]->vi_repayment_rate)) {
                                                        $d = (float) str_replace('%', '', $creditrecovery[0]->vi_repayment_rate);
                                                        $num = $num+1;
                                                    } else {
                                                        $d = 0;
                                                    }
                                                    if (!empty($creditrecovery[0]->other_repayment_rate)) {
                                                        $e = (float) str_replace('%', '', $creditrecovery[0]->other_repayment_rate);
                                                        $num = $num+1;
                                                    } else {
                                                        $e = 0;
                                                    }
                                                    $g=0;
                                                    
                                                    if($num >0)
                                                    {
                                                        $data = ($a + $b + $c + $d + $e) / $num;
                                                     $g = number_format((float)$data, 2, '.', '');
                                                    }
                                                    
                                                    
                                                @endphp
                                                <tr>
                                                    <td>vi.</td>
                                                    <td>Repayment Ratio %</td>
                                                    <td>{{ Checkper($creditrecovery[0]->cluster_repayment_rate)."%" }}</td>
                                                    <td>{{ Checkper($creditrecovery[0]->federation_repayment_rate)."%" }}</td>
                                                    <td>{{ Checkper($creditrecovery[0]->bank_repayment_rate)."%" }}</td>
                                                    <td>{{ Checkper($creditrecovery[0]->vi_repayment_rate)."%" }}</td>
                                                    <td>{{ Checkper($creditrecovery[0]->other_repayment_rate)."%" }}</td>
                                                    <td>{{ $g . '%' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>No of Members Not received even a single loan from Cluster and External
                                                sources during last 3 years</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th></th>
                                                    <th>Loan Type</th>
                                                    <th colspan="4" class="text-center">Wealth Ranking</th>
                                                    <th class="table_th">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td rowspan="4">A</td>
                                                    <th>Cluster Loan</th>
                                                    <td>Poorest</td>
                                                    <td>Poor</td>
                                                    <td>Medium Poor</td>
                                                    <td>Rich</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Last 12 months</td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_poorest_members_not_received_cluster_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_poor_members_not_received_cluster_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_medium_members_not_received_cluster_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_rich_members_not_received_cluster_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_total_members_not_received_cluster_loan_year1 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Year before last</td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_poorest_members_not_received_cluster_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_poor_members_not_received_cluster_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_medium_members_not_received_cluster_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_rich_members_not_received_cluster_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_total_members_not_received_cluster_loan_year2 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>2 Years before last</td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_poorest_members_not_received_cluster_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_poor_members_not_received_cluster_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_medium_members_not_received_cluster_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_rich_members_not_received_cluster_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_total_members_not_received_cluster_loan_year3 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="4">B</td>
                                                    <th>Federation loan</th>
                                                    <td>Poorest</td>
                                                    <td>Poor</td>
                                                    <td>Medium</td>
                                                    <td>Rich</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Last 12 months</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_federation_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_federation_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_federation_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_federation_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_federation_loan_year1 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Year before last</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_federation_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_federation_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_federation_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_federation_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_federation_loan_year2 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>2 Years before last</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_federation_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_federation_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_federation_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_federation_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_federation_loan_year3 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="4">C</td>
                                                    <th>Bank loan</th>
                                                    <td>Poorest</td>
                                                    <td>Poor</td>
                                                    <td>Medium</td>
                                                    <td>Rich</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Last 12 months</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_bank_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_bank_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_bank_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_bank_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_bank_loan_year1 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Year before last</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_bank_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_bank_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_bank_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_bank_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_bank_loan_year2 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>2 Years before last</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_bank_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_bank_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_bank_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_bank_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_bank_loan_year3 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="4">D</td>
                                                    <th>VI Loan</th>
                                                    <td>Poorest</td>
                                                    <td>Poor</td>
                                                    <td>Medium</td>
                                                    <td>Rich</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Last 12 months</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_VI_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_VI_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_VI_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_VI_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_VI_loan_year1 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Year before last</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_VI_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_VI_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_VI_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_VI_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_VI_loan_year2 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>2 Years before last</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_VI_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_VI_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_VI_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_VI_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_VI_loan_year3 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="4">E</td>
                                                    <th>Other Loans</th>
                                                    <td>Poorest</td>
                                                    <td>Poor</td>
                                                    <td>Medium</td>
                                                    <td>Rich</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Last 12 months</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_other_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_other_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_other_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_other_loan_year1 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_other_loan_year1 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Year before last</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_other_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_other_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_other_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_other_loan_year2 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_other_loan_year2 }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>2 Years before last</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poorest_members_not_received_other_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_poor_members_not_received_other_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_medium_members_not_received_other_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_rich_members_not_received_other_loan_year3 }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_total_members_not_received_other_loan_year3 }}
                                                    </td>
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
                                                    <td>Cluster/Habitation</td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_loan_default_member }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_loan_default_no }}</td>
                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Federation Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_loan_default_member }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_loan_default_no }}</td>
                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Bank Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->bank_loan_default_member }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->bank_loan_default_no }}</td>
                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>VI Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->vi_loan_default_member }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->vi_loan_default_no }}</td>
                                                </tr>
                                                <tr>
                                                    <td>E</td>
                                                    <td>Other Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->other_loan_default_member }}</td>
                                                    <td>{{ (int) $creditrecovery[0]->other_loan_default_no }}</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td>{{ (int) $creditrecovery[0]->other_loan_default_member + (int) $creditrecovery[0]->vi_loan_default_member + (int) $creditrecovery[0]->bank_loan_default_member + (int) $creditrecovery[0]->federation_loan_default_member + (int) $creditrecovery[0]->cluster_loan_default_member }}
                                                    </td>
                                                    <td>{{ (int) $creditrecovery[0]->other_loan_default_no + (int) $creditrecovery[0]->vi_loan_default_no + (int) $creditrecovery[0]->bank_loan_default_no + (int) $creditrecovery[0]->federation_loan_default_no + (int) $creditrecovery[0]->cluster_loan_default_no }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>More than 3 Months overdue accounts loan outstanding amount</h5>
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
                                                    <td>Cluster/Habitation</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_a }}</td>

                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Federation Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_b }}</td>

                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Bank Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_c }}</td>

                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>VI Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_d }}</td>
                                                </tr>
                                                <tr>
                                                    <td>E</td>
                                                    <td>Other Loan</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_e }}</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td>{{ (int) $creditrecovery[0]->overdue_a + (int) $creditrecovery[0]->overdue_b + (int) $creditrecovery[0]->overdue_c + (int) $creditrecovery[0]->overdue_d + (int) $creditrecovery[0]->overdue_e }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>PAR Status More than 90 days</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Loan type</th>
                                                    <th>Par status in %</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A</td>
                                                    <td>Cluster/Habitation</td>
                                                    <td>{{ Checkper($creditrecovery[0]->cluster_loan_par) }}%</td>

                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Federation Loan</td>
                                                    <td>{{ Checkper($creditrecovery[0]->federation_loan_par) }}%</td>

                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Bank Loan</td>
                                                    <td>{{ Checkper($creditrecovery[0]->bank_loan_par) }}%</td>

                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>VI Loan</td>
                                                    <td>{{ Checkper($creditrecovery[0]->vi_loan_par) }}%</td>
                                                </tr>
                                                <tr>
                                                    <td>E</td>
                                                    <td>Other Loan</td>
                                                    <td>{{ Checkper($creditrecovery[0]->other_loan_par) }}%</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Purpose of ALL Loans during last 12 months</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Purpose</th>
                                                    <th>All loans (Cluster and External)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A</td>
                                                    <td>Productive</td>
                                                    <td>{{ (int) $creditrecovery[0]->productive }}</td>

                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Consumption</td>
                                                    <td>{{ (int) $creditrecovery[0]->consumption }}</td>
                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Debt Swapping</td>
                                                    <td>{{ (int) $creditrecovery[0]->debt_swapping }}</td>

                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>Other</td>
                                                    <td>{{ (int) $creditrecovery[0]->other_Purposes }}</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td>{{ (int) $creditrecovery[0]->productive + (int) $creditrecovery[0]->consumption + (int) $creditrecovery[0]->debt_swapping + (int) $creditrecovery[0]->other_Purposes }}
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
                                                        <div class="col-6">
                                                            <strong>{{ $creditrecovery[0]->average_loan_amount }}</strong>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Minimum and Maximum loan amounts during last 12 months</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Maximum Amount</strong></div>
                                                        <div class="col-6">
                                                            {{ (int) $creditrecovery[0]->minimum_amount }}
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Minimum Amount</strong></div>
                                                        <div class="col-6">
                                                            {{ (int) $creditrecovery[0]->maximum_amount }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>How many members have taken more than one loan during last 3 years</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6">
                                                            <strong>{{ (int) $creditrecovery[0]->members_more_than_one }}</strong>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Rate of Interest charged by Cluster</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Type (declining or
                                                                flat)</strong></div>
                                                        <div class="col-6">
                                                            {{ $creditrecovery[0]->interest_type !='' ? $creditrecovery[0]->interest_type : 'N/A' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 table-padd">
                                                    <div class="row detail">
                                                        <div class="col-6"><strong>Percent charged</strong></div>
                                                        <div class="col-6">
                                                            {{ $creditrecovery[0]->interest_rate !='' ? $creditrecovery[0]->interest_rate : 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Cumulative Interest Income Through</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Type of loan</th>
                                                    <th>Income Generated Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A</td>
                                                    <td>Cluster</td>
                                                    <td>{{ (int) $creditrecovery[0]->cluster_cumulative_interest }}</td>

                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Federation</td>
                                                    <td>{{ (int) $creditrecovery[0]->federation_cumulative_interest }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Bank</td>
                                                    <td>{{ (int) $creditrecovery[0]->vi_cumulative_interest }}</td>

                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>VI</td>
                                                    <td>{{ (int) $creditrecovery[0]->other_cumulative_interest }}</td>
                                                </tr>
                                                <!-- <tr>
                                                                                <td>E</td>
                                                                                <td>Other</td>
                                                                                <td>{{ (int) $creditrecovery[0]->other_loan_amount }}</td>
                                                                            </tr>
                                                                            <tr> -->
                                                <td></td>
                                                <td>Total</td>
                                                <td>{{ (int) $creditrecovery[0]->total_cumulative_interest }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!----tab-6----->
                                <div class="tab-pane fade" id="v-pills-Saving" role="tabpane"
                                    aria-labelledby="v-pills-Saving-tab">

                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Compulsory Savings </h5>
                                            
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    
                                                    <th>Compulsory Savings</th>
                                                    <th> {{ $saving[0]->compulsory_savings !='' ?  $saving[0]->compulsory_savings : 'N/A'  }}</th>
                                                </tr>
                                            </thead>
                                            
                                        </table>
                                        @if ($saving[0]->compulsory_savings == 'Yes')
                                            <table class="table mytable">
                                                <thead class="back-color">
                                                    <tr>
                                                        <th>Sn</th>
                                                        <th>Details</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>A</td>
                                                        <td>Amount of savings per month</td>
                                                        <td>{{ $saving[0]->amount_of_compulsory }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td>B</td>
                                                        <td>Average Monthly savings during last 12 months</td>
                                                        <td>{{ $saving[0]->trend }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td>C</td>
                                                        <td>Cumulative savings since inception</td>
                                                        <td>{{ $saving[0]->compulsory_savings_inception }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Voluntary Savings </h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    
                                                    <th>Voluntary Savings</th>
                                                    <th>  {{ $saving[0]->voluntary_savings !='' ?  $saving[0]->voluntary_savings : 'N/A' }}</th>
                                                </tr>
                                            </thead>
                                            
                                        </table>
                                        @if ($saving[0]->voluntary_savings == 'Yes')
                                            <table class="table mytable">
                                                <thead class="back-color">
                                                    <tr>
                                                        <th>SN</th>
                                                        <th></th>
                                                        <th> Amount </th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>A</td>
                                                        <td>Average Amount of Savings per month</td>
                                                        <td>{{ checkna($saving[0]->amount_of_voluntary) }}</td>

                                                    </tr>
                                                    <tr>

                                                        <td>B</td>
                                                        <td>Cumulative savings to-date since inception</td>
                                                        <td>{{ checkna($saving[0]->voluntary_savings_inception) }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td>C</td>
                                                        <td>Date voluntary savings established</td>
                                                        <td>{{ $saving[0]->date_voluntary_saving !='' ?  Change_date_month_name_char(str_replace('/', '-', $saving[0]->date_voluntary_saving)) : 'N/A' }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td>D</td>
                                                        <td>No of members contribute to voluntary savings</td>
                                                        <td>{{ checkZero(!empty($saving[0]->no_of_shg_member)) }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td>E</td>
                                                        <td>Interest paid to members (Y/N)</td>
                                                        <td>{{ checkna(!empty($saving[0]->interest_paid)) }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td>F</td>
                                                        <td>Are savings redistributed to members (Y/N)</td>
                                                        <td>{{ checkna(!empty($saving[0]->savings_redistributed)) }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td>G</td>
                                                        <td>Date of last Redistribution</td>
                                                        <td>{{$saving[0]->date_last_distribution !='' ?   
                                                        Change_date_month_name_char(str_replace('/', '-', $saving[0]->date_last_distribution)) : 'N/A'}}</td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>

                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Loan Security Fund (LSF) </h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    
                                                    <th>Loan Security Fund</th>
                                                    <th>{{ $saving[0]->loan_security_fund !='' ?  $saving[0]->loan_security_fund :'N/A'  }}</th>
                                                </tr>
                                            </thead>
                                            
                                        </table>
                                        @if ($saving[0]->loan_security_fund == 'Yes')
                                            <table class="table mytable">
                                                <tbody>
                                                    <tr>
                                                        <td>A</td>
                                                        <td>Date it was established</td>
                                                        <td>{{$saving[0]->date_established !='' ?  Change_date_month_name_char(str_replace('/', '-', $saving[0]->date_established)) : 'N/A'}}</td>
                                                    </tr>
                                                    <tr>

                                                        <td>B</td>
                                                        <td>No of members contribute to LSF </td>
                                                        <td>{{ checkna($saving[0]->members) }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td>C</td>
                                                        <td>Amount available in LSF</td>
                                                        <td>{{ checkna($saving[0]->amount_available) }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td>D</td>
                                                        <td>No of members benefitted from LSF</td>
                                                        <td>{{ checkna($saving[0]->members_benefitted) }}</td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                                <!----tab-7----->
                                <div class="tab-pane fade" id="v-pills-Analysis-and-Scores" role="tabpane"
                                    aria-labelledby="v-pills-Analysis-and-Scores-tab">
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
                                                {{-- <tr>
                                                    <th colspan="2">Governance</th>
                                                    <th>25</th>
                                                    <th>{{ $total1 }}</th>
                                                    <th>
                                                        <div class='status_analysis {{ $tcolor1 }} '></div>
                                                    </th>
                                                </tr> --}}
                                                <tr>
                                                    <th colspan="2">Governance</th>
                                                    <th>25</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Rotation of Board members as per norms</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_1) ? $analysis_1 : 0 }}</td>
                                                    <td>
                                                        <div class='status_analysis {{ $show1 }} '></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Average Participation of Members during last 12 months</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['Average_participation_of']) ? $analysis_data['Average_participation_of'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color1'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Cluster books Updated (all books)</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['Cluster_Book_updation']) ? $analysis_data['Cluster_Book_updation'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color2'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>% of defunct SHGs</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['Percentage_of_Defunct']) ? $analysis_data['Percentage_of_Defunct'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color3'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>External audit carried out during last 12 months</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['External_audit_completed']) ? $analysis_data['External_audit_completed'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color4'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- <tr>
                                                    <th colspan="2">Inclusion</th>
                                                    <th>15</th>
                                                    <th>{{ $total2 }}</th>
                                                    <th>
                                                        <div class='status_analysis {{ $tcolor2 }} '></div>
                                                    </th>
                                                </tr> --}}
                                                <tr>
                                                    <th colspan="2">Inclusion</th>
                                                    <th>15</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Coverage of poorest and poor as cluster members</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['Representation_of_Poorest']) ? $analysis_data['Representation_of_Poorest'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color55'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>Poorest/poor benefitting from Internal loans </td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['Coverage_of_target']) ? $analysis_data['Coverage_of_target'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color5'] }} '>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>Poorest and Poor benefitting from all loans</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['Percentage_of_poorest_benefiting_from_all_loans']) ? $analysis_data['Percentage_of_poorest_benefiting_from_all_loans'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color6'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- <tr>
                                                    <th colspan="2">Efficiency</th>
                                                    <th>15</th>
                                                    <th>{{ $total3 }}</th>
                                                    <th>
                                                        <div class='status_analysis {{ $tcolor3 }} '></div>
                                                    </th>
                                                </tr> --}}
                                                <tr>
                                                    <th colspan="2">Efficiency</th>
                                                    <th>15</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>Coverage of costs</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['Cluster_is_covering_its']) ? $analysis_data['Cluster_is_covering_its'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color7'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>Time taken to disburse loans (from approval to cash in hand</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['Time_taken_to_disburse']) ? $analysis_data['Time_taken_to_disburse'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color8'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>11</td>
                                                    <td>Consolidated cluster plans prepared and submitted</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['group_prepare']) ? $analysis_data['group_prepare'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color1111'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- <tr>
                                                    <th colspan="2">Credit History</th>
                                                    <th>30</th>
                                                    <th>{{ $total4 }}</th>
                                                    <th>
                                                        <div class='status_analysis {{ $tcolor4 }} '></div>
                                                    </th>
                                                </tr> --}}
                                                <tr>
                                                    <th colspan="2">Credit History</th>
                                                    <th>30</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td>12</td>
                                                    <td>Cluster loan repayment %</td>
                                                    <td>10</td>
                                                    <td>{{ !empty($analysis_data['Repayment_rate_of_cluster_loan']) ? $analysis_data['Repayment_rate_of_cluster_loan'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color9'] }}'>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>13</td>
                                                    <td>PAR status of all loans (cluster and external)</td>
                                                    <td>10</td>
                                                    <td>{{ !empty($analysis_data['Cluster_loan_PAR']) ? $analysis_data['Cluster_loan_PAR'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color10'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>14</td>
                                                    <td>% of members received more than one loan during last 3 years</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['Percentage_members_assisted_more_than_one']) ? $analysis_data['Percentage_members_assisted_more_than_one'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color11'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>15</td>
                                                    <td>% of productive loans (out of total loans)</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['Percentage_Livelihood_purposes']) ? $analysis_data['Percentage_Livelihood_purposes'] : 0 }}
                                                    </td>
                                                    <td>
                                                        <div class='status_analysis {{ $analysis_data['color12'] }} '>
                                                        </div>
                                                    </td>
                                                </tr>
                                                {{-- <tr>
                                                    <td rowspan="3"></td>
                                                    <th>Savings</th>
                                                    <th>15</th>
                                                    <th>{{ $total5 }}</th>
                                                    <th>
                                                        <div class='status_analysis {{ $tcolor5 }} '></div>
                                                    </th>

                                                </tr> --}}
                                                <tr>
                                                    <th colspan="2">Savings</th>
                                                    <th>15</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td>16</td>
                                                    <td>% of Cluster members having voluntary savings</td>
                                                    <td>10</td>
                                                    <td>{{ !empty($analysis_data['Percentage_of_the_cluster']) ? $analysis_data['Percentage_of_the_cluster'] : 0 }}
                                                    </td>
                                                    <td>
                                                    <div class='status_analysis {{ $analysis_data['color111']}}'
                                                        ></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>17</td>
                                                    <td>No of Members contribute to LSF</td>
                                                    <td>5</td>
                                                    <td>{{ !empty($analysis_data['compulsory_savings']) ? $analysis_data['compulsory_savings'] : 0 }}
                                                    </td>
                                                    <td>
                                                    <div class='status_analysis {{ $analysis_data['color112']}}'>
                                                        </div>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <th>Total</th>
                                                    <th></th>
                                                    <th>100</th>
                                                    <th>{{ !empty($grand_total) ? $grand_total : 0 }}</th>
                                                    <th>
                                                        <div class='status_analysis {{ $grdcolor }} '></div>
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
                                            <h5>Challenges ( there should be space to show each challenge)</h5>
                                            
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Top Challenges</th>
                                                    {{-- <th>Explain/Answer</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1; @endphp
                                                @if (count($challenges) > 0)
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
                                    <div class="family-box mt-3">
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
                                                                    <td>{{ checkna($val) }}</td>
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
                                                    <td>A1</td>
                                                    <td>How many members attended the cluster meeting?</td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>{{ checkna($observation[0]->cluster_observation_meeting) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>B1</td>
                                                    <td>Were all office bearers and leaders present? E.g chair, treasurer,
                                                        secretary, book-keeper, other,</td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>
                                                        @if (!empty($observation))
                                                            @foreach ($observation as $row)


                                                                @php
                                                                    $desg = [];
                                                                    if ($row->cluster_observation_president == 1) {
                                                                        $desg[] = 'President';
                                                                    }
                                                                    if ($row->cluster_observation_secretary == 1) {
                                                                        $desg[] = 'Secretary';
                                                                    }
                                                                    if ($row->cluster_observation_bookkeeper == 1) {
                                                                        $desg[] = 'Bookkeeeper';
                                                                    }
                                                                    if ($row->cluster_observation_treasure == 1) {
                                                                        $desg[] = 'Treasure';
                                                                    }
                                                                    if ($row->cluster_observation_sub_commit == 1) {
                                                                        $desg[] = 'Sub-commit Member';
                                                                    }
                                                                    if ($row->cluster_observation_other == 1) {
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
                                                    <td>Did cluster leaders understand the Purpose of the meeting? Explain
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>{{ checkna($observation[0]->cluster_observation_carried_out) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>What was quality of Discussion? Did everyone participate?</td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>{{ checkna($observation[0]->cluster_observation_leaders_only) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <th>Where cluster leaders aware of their rules and norms?</th>
                                                </tr>

                                                <td>A. </td>

                                                <td> Did they understand vision of their Cluster?</td>

                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>{{ checkna($observation[0]->cluster_observation_Cluster) }}</td>
                                                </tr>
                                                <tr>

                                                <tr>
                                                    <td>B. </td>
                                                    <td>Do they understand benefits of being part of the Cluster?</td>

                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>{{ checkna($observation[0]->cluster_observation_benefits) }}</td>
                                                </tr>

                                                <tr>
                                                    <td>5</td>
                                                    <th>Important practices followed by the group.</th>
                                                </tr>

                                                <tr>
                                                    <td>A.</td>

                                                    <td> Do they have a set of important practices for repayment and
                                                        savings?</td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>{{ checkna($observation[0]->cluster_observation_paid_time) }}</td>
                                                </tr>
                                                @if ($observation[0]->cluster_observation_paid_time == 'Yes')
                                                    <tr>
                                                        <td>B.</td>
                                                        <td> What are those practices?</td>

                                                    </tr>
                                                    <tr>
                                                        <td>Explain/Answer</td>
                                                        <td>{{ $observation[0]->cluster_observation_practices }}</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>6</td>
                                                    <th>What is Cluster’s policy on the most vulnerable members.</th>
                                                </tr>
                                                <tr>
                                                    <td>A.</td>
                                                    <td> Does this Cluster include members who are the most poor and
                                                        vulnerable, and if yes, </td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>{{ checkna($observation[0]->cluster_observation_provided_them) }}</td>
                                                </tr>
                                                @if ($observation[0]->cluster_observation_provided_them == 'Yes')
                                                    <tr>
                                                        <td>B.</td>
                                                        <td> what is their policy to help them</td>

                                                    </tr>
                                                    <tr>
                                                        <td>Explain/Answer</td>
                                                        <td>{{ checkna($observation[0]->cluster_observation_policy_explain) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>7</td>
                                                    <th>Cluster’s Reporting and documentation</th>
                                                </tr>
                                                <tr>
                                                    <td>A.</td>
                                                    <td> Does cluster have a satisfactory/weak or good system of reporting
                                                        and updating of documents?</td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>{{ checkna($observation[0]->cluster_observation_documents) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>B.</td>
                                                    <td>Who writes these books and minutes of meetings?</td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>{{ checkna($observation[0]->cluster_observation_minutes_meetings) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <th>Cluster’s financial information</th>
                                                </tr>
                                                <tr>
                                                    <td>A.</td>
                                                    <td>Are books of accounts managed by the booker only or are other office
                                                        bearers aware of their financial information
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>{{ checkna($observation[0]->cluster_observation_updated_records) }}</td>
                                                </tr>
                                                @if ($observation[0]->cluster_observation_updated_records == 'Yes')
                                                    <tr>
                                                        <td>B.</td>
                                                        <td>Any highlights</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Explain/Answer</td>
                                                        <td>{{ checkna($observation[0]->cluster_observation_leaders_office) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>9</td>
                                                    <th>Unique features of this Cluster</th>
                                                </tr>
                                                <tr>
                                                    <td>A.</td>
                                                    <td> Did you notice any unique features and practices that make it
                                                        special?</td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>{{ checkna($observation[0]->cluster_observation_special) }}</td>
                                                </tr>
                                                @if ($observation[0]->cluster_observation_special == 'Yes')
                                                    <tr>
                                                        <td>B.</td>
                                                        <td> What are those special practices?</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Explain/Answer</td>
                                                        <td>{{ checkna($observation[0]->cluster_observation_support_groups) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>10</td>
                                                    <th>Summary of important 3- 5 highlights about this group? </th>
                                                </tr>
                                                @if ($observation[0]->cluster_observation_highlights_a != '')
                                                    <tr>
                                                        <td>A</td>
                                                        <td>{{ $observation[0]->cluster_observation_highlights_a }}</td>
                                                    </tr>
                                                @endif
                                                @if ($observation[0]->cluster_observation_highlights_b != '')
                                                    <tr>
                                                        <td>B.</td>
                                                        <td>{{ $observation[0]->cluster_observation_highlights_b }}</td>
                                                    </tr>
                                                @endif
                                                @if ($observation[0]->cluster_observation_highlights_c != '')
                                                    <tr>
                                                        <td>C.</td>
                                                        <td>{{ $observation[0]->cluster_observation_highlights_c }}</td>
                                                    </tr>
                                                @endif
                                                @if ($observation[0]->cluster_observation_highlights_d != '')
                                                    <tr>
                                                        <td>D.</td>
                                                        <td>{{ $observation[0]->cluster_observation_highlights_d }}</td>
                                                    </tr>
                                                @endif
                                                @if ($observation[0]->cluster_observation_highlights_e != '')
                                                    <tr>
                                                        <td>E.</td>
                                                        <td>{{ $observation[0]->cluster_observation_highlights_e }}</td>
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
                                        <div class="card-box">
                                            <div class="row alldetail">
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
                                    </div>
                                </div>
                                <!----tab-12----->
                                <div class="tab-pane fade" id="v-pills-report-card" role="tabpanel"
                                    aria-labelledby="v-pills-report-card-tab">

                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Cluster Rating Card</h5>
                                            
                                        </div>
                                        <div class="card-box">
                                            <table class="table table-bordered mytable" colspan="2">
                                                <thead class="back-color">

                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th width="50%">Name</th>
                                                        <td width="50%">{{ $profile[0]->name_of_cluster }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Federation Name</th>
                                                        <td>{{ $fed_profile[0]->name_of_federation }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>UIN</th>
                                                        <td>{{ $cluster->uin }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>State Name</th>
                                                        <td>{{ $profile[0]->name_of_state }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>District Name</th>
                                                        <td>{{ $profile[0]->name_of_district }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Date</th>
                                                        <td>{{ change_date_month_name_char(str_replace('/','-',$cluster->created_at)) }}</td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mytable" colspan="2">
                                                <thead class="back-color">
                                                    <tr>
                                                        <th width="35%">Cluster Indicators</th>
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
                                                            @if ($score >= 75 && $score <= 89) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            @if ($score >= 60 && $score <= 74) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            @if ($score <= 59) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td width="10px" style="text-align: center;">{{ $total1 }}
                                                        </td>
                                                        <td width="10px" style="text-align: center;">25</td>
                                                        {{-- <td>{{$score}}</td> --}}
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
                                                            @if (round($score1) >= 75 && round($score1) <= 89) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            @if ($score1 >= 60 && $score1 <= 74) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            @if ($score1 <= 59) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
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
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            @if ($score2 >= 75 && $score2 <= 89) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            @if ($score2 >= 60 && $score2 <= 74) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            @if ($score2 <= 59) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
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
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            @if ($score3 >= 75 && $score3 <= 89) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            @if ($score3 >= 60 && $score3 <= 74) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            @if ($score3 <= 59) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
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
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            @if ($score4 >= 75 && $score4 <= 89) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            @if ($score4 >= 60 && $score4 <= 74) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            @if ($score4 <= 59) <i
                                                                    class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            @endif
                                                        </td>
                                                        <td style="text-align: center;">{{ $total5 }}</td>
                                                        <td style="text-align: center;">15</td>
                                                        {{-- <td>{{round($score4)}}</td> --}}
                                                    </tr>

                                                </tbody>

                                            </table>
                                            <table class="table  mytable">

                                                <tr>
                                                    <th style="width: 35%;">Total Score</th>

                                                    <td
                                                        style="background-color: green;text-align:center;font-weight:bold;font-size:20px;width:9.9%;">
                                                        @if ($grand_total >= 90)
                                                            {{ $grand_total }}
                                                        @endif
                                                    </td>


                                                    <td
                                                        style="background-color: yellow;text-align:center;font-weight:bold;font-size:20px;width:9.66%;">
                                                        @if ($grand_total >= 75 && $grand_total <= 89)
                                                            {{ $grand_total }} @endif
                                                    </td>
                                                    </td>


                                                    <td
                                                        style="background-color: lightgrey;text-align:center;font-weight:bold;font-size:20px;width:10%;">
                                                        @if ($grand_total >= 60 && $grand_total <= 74)
                                                            {{ $grand_total }} @endif
                                                    </td>



                                                    <td
                                                        style="background-color: red;text-align:center;font-weight:bold;font-size:20px;width:10%;">
                                                        @if ($grand_total <= 59)
                                                            {{ $grand_total }} @endif
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
                                                                <label for="TaskQaAssignment_remark11"
                                                                    class="required"
                                                                    style="font-weight: bold;">Quality Remark :
                                                                </label>
                                                                <span>{{ $quality_remark }}</span>
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
                                                                <option value="">--Select--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 mb-3">
                                                        <div class="col-md-8" id="remark_txt">
                                                            <label for="TaskQaAssignment_remark"
                                                                class="required">Remark
                                                            </label>
                                                            <textarea class="form-control form-control-sm"
                                                                name="TTaskQaAssignment_remark"
                                                                id="TaskQaAssignment_remark"></textarea>
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
                                                        <button type="button" id="save" class="btn btn-sm btn-success "
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
                                                                <label for="TaskQaAssignment_remark22"
                                                                    class="required"
                                                                    style="font-weight: bold;">Manager Remark :
                                                                </label>
                                                                <span>{{ $qa_remark }}</span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <div class="col-md-8">
                                                                <label class="form-control-label" for="input-small">Quality
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
                                                                <textarea class="form-control form-control-sm"
                                                                    name="TTaskQaAssignment_remark1"
                                                                    id="TaskQaAssignment_remark1"
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
                                                            <button type="button" id="save1" class="btn btn-sm btn-success "
                                                                onclick="return submitAction1()">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
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

    </style>
    <script>
        function submitAction() {
            $('#save').prop('disabled', true); 
            $('#save').css('opacity', '0.4'); 
            var id = $('#task_id').val();
            var sts = $('#TaskQaAssignment_status').val();
            var rmk = $('#TaskQaAssignment_remark').val();
            //var qrmk = $('#TaskQaAssignment_status11').val();
            var user_id = $('#user_id').val();

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
                        $.ajax({
                            url: '/change_qa_status_fed',
                            type: 'GET',
                            data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts + '&rmk=' +
                                rmk + '&assignment_type="CL"&user_id=' + user_id,
                            // data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts +
                            //     '&rmk=' + rmk +
                            //     '&assignment_type="CL"&user_id=' + user_id,
                            //data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts +
                            //'&rmk=' + rmk + '&assignment_type="CL"',
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

        function submitAction1() {

            $('#save1').prop('disabled', true); 
            $('#save1').css('opacity', '0.4'); 
            var id = $('#task_id1').val();
            var sts = $('#TaskQaAssignment_status1').val();
            var rmk = $('#TaskQaAssignment_remark1').val();

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
                        $.ajax({
                            url: '/change_qa_status_fed1',
                            type: 'GET',
                            //data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts + '&rmk=' + rmk + '&assignment_type="FD"&user_id=' + user_id,
                            data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts + '&rmk=' +
                                rmk + '&assignment_type="FD"',
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
    </script>
    <script>
        function get_facilitator_list(dm_id) {

            if (dm_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_facilitator_list_task',
                    data: '_token = <?php echo csrf_token(); ?>&dm_id=' + dm_id,
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
        // function set_facilitator() {
        //     var flg = $('#TaskQaAssignment_status').val();
        //     var agency_id = $('#agency_id').val();
        //     if (flg == 'R') {
        //         $('.show_div').show();
        @if ($qa_status == 'P')
            // $('.show_div select').attr('required','required');
            // @endif
        //         get_facilitator_list(agency_id);
        //     } else {
        //         $('.show_div').hide();
        //         $('.show_div select').removeAttr('required');
        //     }
        // }
        $(document).ready(function() {
            $('#dm_id').on('change', get_facilitator_list);
            $('#TaskQaAssignment_status').on('change', set_facilitator);
            $('#TaskQaAssignment_status11').on('change', set_facilitator);

            $('#TaskQaAssignment_status').trigger('change');
            $('#TaskQaAssignment_status11').trigger('change');

            @if ($qa_status == 'R' || $qa_status == 'V')
                $('#TaskQaAssignment_status').val("{{ $qa_status }}");
                $('#TaskQaAssignment_remark').val("{{ $qa_remark }}");
            @endif
        });
        @if ($u_type == 'QA' || $u_type == 'CEO' || $u_type == 'A')
            $(document).ready(function() {
            var ctx = document.getElementById("raating_d_chart").getContext('2d');
            var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
            labels: ["Rating", ""],
            datasets: [{
            data: ['{{ $grand_total }}', '{{ 100 - $grand_total }}'],
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
    </script>

@endsection
