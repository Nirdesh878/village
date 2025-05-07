@extends('layouts.app')

@section('content')
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
                            <h2>Test TN cluster</h2>
                            <div class="E-link d-flex">
                                <a href="#"><p><i class="las la-envelope"></i>----------</p></a>
                                <a href="#"><p><i class="las la-phone"></i> </p></a>
                            </div>
                              <p>
                                <span style="padding: 0px 5px;"></span>
                                <span style="padding: 0px 5px;">New Delhi</span>,
                                <span style="padding: 0px 5px;">Delhi</span>,
                                <span style="padding: 0px 5px;">India</span>
                               </p>
                        </div>
                        <div class="ml-auto d-flex">
                            <div class="rating-box s-box mr-4" style="background: #FF4141">
                                <h4>Analytics and Rating</h4><h3>0</h3>
                                <p>High Risk</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" style="margin-top:30px">
                    <div class="col-3 faily-tab">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-Basic-Profile-tab" data-toggle="pill" href="#v-pills-Basic-Profile" role="tab" aria-controls="v-pills-Basic-Profile" aria-selected="true"><i class="las la-info-circle mr-2"></i>Basic Profile</a>
                            <a class="nav-link " id="v-pills-Governance-and-Accountability-tab" data-toggle="pill" href="#v-pills-Governance-and-Accountability" role="tab" aria-controls="v-pills-Governance-and-Accountability" aria-selected="false"><i class="las la-hand-holding-usd mr-2"></i>Governance and Accountability</a>
                            <a class="nav-link " id="v-pills-Inclusion-tab" data-toggle="pill" href="#v-pills-Inclusion" role="tab" aria-controls="v-pills-Inclusion" aria-selected="false"><i class="las la-briefcase mr-2"></i>Inclusion</a>
                            <a class="nav-link " id="v-pills-Efficiency-tab" data-toggle="pill" href="#v-pills-Efficiency" role="tab" aria-controls="v-pills-Efficiency" aria-selected="false"><i class="las la-briefcase mr-2"></i>Efficiency</a>
                            <a class="nav-link " id="v-pills-Credit-Recovery-tab" data-toggle="pill" href="#v-pills-Credit-Recovery" role="tab" aria-controls="v-pills-Credit-Recovery" aria-selected="false"><i class="las la-briefcase mr-2"></i>Credit History</a>
                            <a class="nav-link " id="v-pills-Saving-tab" data-toggle="pill" href="#v-pills-Saving" role="tab" aria-controls="v-pills-Saving" aria-selected="false"><i class="las la-briefcase mr-2"></i>Saving</a>
                            <a class="nav-link " id="v-pills-Analysis-and-Scores-tab" data-toggle="pill" href="#v-pills-Analysis-and-Scores" role="tab" aria-controls="v-pills-Analysis-and-Scores" aria-selected="false"><i class="las la-briefcase mr-2"></i>Analysis and Scores</a>
                            <a class="nav-link " id="v-pills-Challenges-tab" data-toggle="pill" href="#v-pills-Challenges" role="tab" aria-controls="v-pills-Challenges" aria-selected="false"><i class="las la-briefcase mr-2"></i>Challenges</a>
                            <a class="nav-link " id="v-pills-Action-Plan-tab" data-toggle="pill" href="#v-pills-Action-Plan" role="tab" aria-controls="v-pills-Action-Plan" aria-selected="false"><i class="las la-briefcase mr-2"></i>Action Plan</a>
                            <a class="nav-link " id="v-pills-Observations-tab" data-toggle="pill" href="#v-pills-Observations" role="tab" aria-controls="v-pills-Observations" aria-selected="false"><i class="las la-briefcase mr-2"></i>Observations</a>
                            <a class="nav-link " id="v-pills-Photos-Videos-tab" data-toggle="pill" href="#v-pills-Photos-Videos" role="tab" aria-controls="v-pills-Photos-Videos" aria-selected="false"><i class="las la-briefcase mr-2"></i>Photos/Videos</a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <!-----tab-1---->
                            <div class="tab-pane fade show active" id="v-pills-Basic-Profile" role="tabpanel" aria-labelledby="v-pills-Basic-Profile-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Cluster Details</h5>
                                        <div class="ml-auto">
                                            <a href="javascript:;" onclick="downloadClusterdtl(2)" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Name</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>UNI</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Cluster  office location</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Federation</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>District</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>State</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Country</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>Date cluster was formed</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of SHGs at Creation</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of members at creation</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of current SHGs</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of current Members</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of members left since creation</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>President/Animator</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Secretary</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Treasurer</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of appointment</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>Account opening date</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Name of the bank</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Name of Branch</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Account no</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>Name of contact</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Designation</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Contact Number</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!----tab 2---->
                            <div class="tab-pane fade" id="v-pills-Governance-and-Accountability" role="tabpanel" aria-labelledby="v-pills-Governance-and-Accountability-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Adoption of Rules</h5>
                                        <div class="ml-auto">
                                            <a href="javascript:;" onclick="downloadClusterdtl(3)" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a>

                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Written Rules</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of Adoption</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
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
                                                    <div class="col-6"><strong>Frequency as per norms</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>1st election date </strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of Elections conducted so far</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of Last Election</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Last 2 elections conducted as per norms</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>Frequency of Meetings </strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of meetings conducted during last 12 months</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Average Participation of Members during last 12 months</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>Separate minute book</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Status of group meetings recorded</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Who writes the minutes</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>---------</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>----------</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>Whether cluster has a SAC</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>SAC creation date</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Functions of SAC (describe)</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>How many SAC reports prepared and submitted during last 12 months</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of last report</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>How often</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of internal audit during last 12 months</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Issues and observations raised during last 12 months (Describe)</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>How many issues were resolved (describe)</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

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
                                                    <div class="col-6"><strong>How often</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of internal audit during last 12 months</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Issues and observations raised during last 12 months (Describe)</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>How many issues were resolved (describe)</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Committees</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Name of subcommittee</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Purpose</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date formed </strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of members </strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Defunct SHG status in the Cluster</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Total SHGs formed in cluster</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>At present no of SHGs defunct</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Defunct SHGs (%)</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Reasons for defunct (explain)</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!----tab-3----->
                            <div class="tab-pane fade" id="v-pills-Inclusion" role="tabpanel" aria-labelledby="v-pills-Inclusion-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Wealth Ranking/Poverty Mapping (Y/N)</h5>
                                        <div class="ml-auto">
                                            <a href="javascript:;" onclick="downloadClusterdtl(4)" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a>

                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of 1st poverty mapping</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of last update</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
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
                                                    <div class="col-6"><strong>No of Poorest &amp; vulnerable</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of Poor</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of Medium Poor</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of Rich</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of OBC</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of others</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Cumulative No. of loans and amounts at Cluster level during last 3 years</h5>

                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>Category</th>
                                                    <th colspan="2">Cluster Loans (i)</th>
                                                    <th colspan="2">External Loans</th>
                                                    <th colspan="2">VI Loans (iii)</th>
                                                    <th colspan="2">Total Loans (i+ii+iii)</th>
                                                </tr>
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
                                                    <td>Very Poor &amp;  vulnerable</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>
                                                <tr>
                                                    <td>Poor</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>
                                                <tr>
                                                    <td>Medium poor</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>No. of Cluster HHs benefitted from all loans during last 12 months</h5>

                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">

                                            <table class="table table-striped">

                                                <tbody><tr>
                                                    <th rowspan="2">Category(a)</th>
                                                    <th rowspan="2">Clustermember HHs (#)</th>
                                                    <th colspan="5" class="text-center">Received Loan (#)</th>

                                                </tr>

                                                <tr>

                                                    <th>Cluster Loan 4b.i</th>
                                                    <th>External loan 4b.ii</th>
                                                    <th>VI Loan 4b.iii</th>

                                                </tr>

                                                <tr>
                                                    <td>Very Poor &amp;  vulnerable</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>

                                                <tr>
                                                    <td>Poor</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>

                                                <tr>
                                                    <td>Medium</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>

                                                <tr>
                                                    <td>Rich</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>No of poor and most poor in Leadership position </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>----------</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Cluster Board Constitution</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Total no of Board members</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of members from the poorest and vulnerable</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of members from the poor</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of members from middle and rich category</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
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
                                                    <div class="col-6"><strong>Total target poor in the cluster</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of target poor mobilized in SHGs</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>% of target poor mobilized in SHGs</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!----tab-4----->
                            <div class="tab-pane fade" id="v-pills-Efficiency" role="tabpane" aria-labelledby="v-pills-Efficiency-tab">


                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Cluster Integrated Member Plan Prepared (Y/N)</h5>
                                        <div class="ml-auto">
                                            <a href="javascript:;" onclick="downloadClusterdtl(5)" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of last plan approved by Cluster</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date it was submitted to Federation/partner</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Capacity Building of Current committee members/leaders</h5>

                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>SN</th>
                                                    <th>Designation</th>
                                                    <th>Name of training</th>
                                                    <th>Duration</th>
                                                    <th>Date</th>
                                                    <th>Name of Training Recipient</th>
                                                    <th>Name of Trainer</th>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Current Leaders (president/animator, treasurer and secretary)</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Book-keeper</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>SAC members</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Other committee members</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                    <td>-----</td>
                                                </tr>

                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>


                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Cluster Income and Expenses during last 12 months </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>AIncome from all sources</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Expenses </strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Is it covering its operational costs</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Approval Process  </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of days taken to approve loan application at Cluster </strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Average Monthly loans during last 12 months</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Time taken from approval to cash in hand </strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Monthly reports (Y/N)</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">

                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of last report submitted</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>
                            <!----tab-5----->
                            <div class="tab-pane fade" id="v-pills-Credit-Recovery" role="tabpane" aria-labelledby="v-pills-Credit-Recovery-tab">

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Credit History</h5>
                                        <div class="ml-auto">
                                            <a href="javascript:;" onclick="downloadClusterdtl(6)" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of loan applications received at Cluster during last 12 months</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of loan applications approved during last 12 months</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Pending loan applications</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Cumulative Loan Amount at Cluster</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>SN</th>
                                                    <th>Institution</th>
                                                    <th>Amount (Rs)</th>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Cluster</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Federation</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Bank</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>VI</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Other</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Total</td>
                                                    <td>----</td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>No of Cumulative Loans disbursed to members during last 3 years</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>Category</th>
                                                    <th>Cluster Loans # (A)</th>
                                                    <th>Federation Loans # (B)</th>
                                                    <th>Bank loans # (C)</th>
                                                    <th>VI loans # (D)</th>
                                                    <th>Other Loans #(E)</th>
                                                    <th>Total No of Loans</th>
                                                </tr>
                                                <tr>
                                                    <td>(i)Very Poor &amp;  vulnerable</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>(ii) Poor</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>(iii) Medium poor</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>(iv) Rich</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>(v) Total</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>

                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>No of member HHs Received Loans during last 3 years </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th rowspan="2">Category(a)</th>
                                                    <th rowspan="2">Clustermember HHs (#)(b)</th>
                                                    <th colspan="5" class="text-center">Received Loan (#)</th>
                                                    <th></th>

                                                </tr>
                                                <tr>

                                                    <th>Cluster</th>
                                                    <th>Federation 5.2</th>
                                                    <th>Bank 5.3</th>
                                                    <th>Other 5.4</th>
                                                    <th>VI 5.5</th>
                                                    <th>total</th>
                                                </tr>
                                                <tr>
                                                    <td>(i) Very Poor &amp;  vulnerable</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>(ii) Poor</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>(iii) Medium poor</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>(iv) Rich</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>(v) Total</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Demand Collection Balance (DCB) for repayment and current Loan Outstanding</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>SN.</th>
                                                    <th>DCB</th>
                                                    <th>Cluster Loans (A)</th>
                                                    <th>FederationLoan (C)</th>
                                                    <th>Bank Loan (D)</th>
                                                    <th>VI Loan E</th>
                                                    <th>Other Loans E </th>
                                                    <th>Summary Loan Portfolio </th>
                                                </tr>
                                                <tr>
                                                    <td>i.</td>
                                                    <td>Total Loan Amount Given (Rs.)</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>ii.</td>
                                                    <td>Total Demand upto last month for active loans</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>iii.</td>
                                                    <td>Actual Amount Paid upto last month</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>iv.</td>
                                                    <td>Overdue Amount</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>v.</td>
                                                    <td>Outstanding amount for active loans</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Repayment Ratio %</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>




                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>No of Members Not received even a single loan from Cluster and External sources during last 3 years</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th></th>
                                                    <th>Loan Type </th>
                                                    <th colspan="4" class="text-center">Wealth Ranking</th>
                                                </tr>

                                                <tr>
                                                    <td rowspan="4">A</td>
                                                    <th>Cluster Loan</th>
                                                    <td>Poorest</td>
                                                    <td>Poor</td>
                                                    <td>Medium Poor</td>
                                                    <td>Rich</td>

                                                </tr>
                                                <tr>
                                                    <td>Last 12 months</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Year before last</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>2 Years before last</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="4">B</td>
                                                    <th>Federation loan</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>

                                                </tr>
                                                <tr>
                                                    <td>Last 12 months</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Year before last</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>2 Years before last</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="4">D</td>
                                                    <th>VI Loan</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>

                                                </tr>
                                                <tr>
                                                    <td>Last 12 months</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Year before last</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>2 Years before last</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="4">E</td>
                                                    <th>Other Loans</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>

                                                </tr>
                                                <tr>
                                                    <td>Last 12 months</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>Year before last</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td>2 Years before last</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>


                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>





                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Loan Default</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>SN.</th>
                                                    <th>Name of Loan Insitution</th>
                                                    <th>No of Members</th>
                                                    <th>No of Loans</th>
                                                </tr>

                                                <tr>
                                                    <td>A</td>
                                                    <td>Cluster/Habitation</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Federation Loan</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Bank Loan</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>VI Loan</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>E</td>
                                                    <td>Other Loan</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>More than 3 Months overdue accounts loan outstanding amount</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>SN.</th>
                                                    <th>Loan type</th>
                                                    <th>Amount</th>
                                                </tr>

                                                <tr>
                                                    <td>A</td>
                                                    <td>Cluster/Habitation</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Federation Loan</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Bank Loan</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>VI Loan</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>E</td>
                                                    <td>Other Loan</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td>----</td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>PAR Status More than 90 days</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>SN.</th>
                                                    <th>Loan type</th>
                                                    <th>Amount</th>
                                                </tr>

                                                <tr>
                                                    <td>A</td>
                                                    <td>Cluster/Habitation</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Federation Loan</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Bank Loan</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>VI Loan</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>E</td>
                                                    <td>Other Loan</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td>----</td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Purpose of ALL Loans during last 12 months</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>SN.</th>
                                                    <th>Purpose</th>
                                                    <th>All loans (Cluster and External)</th>
                                                </tr>
                                                <tr>
                                                    <td>A</td>
                                                    <td>Productive</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Consumption</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Debt Swapping</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>Other</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td>----</td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Average Loan Amount during last 12 Months</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>----------</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Minimum Amount</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>----------</strong></div>
                                                    <div class="col-6">----------</div>
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
                                                    <div class="col-6"><strong>Type (declining or flat)</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Percent charged</strong></div>
                                                    <div class="col-6">----------</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Cumulative Interest Income Through</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>SN.</th>
                                                    <th>Type of loan</th>
                                                    <th>Income Generated Amount</th>
                                                </tr>

                                                <tr>
                                                    <td>A</td>
                                                    <td>Cluster</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Federation</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Bank</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>VI</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>E</td>
                                                    <td>Other</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td>----</td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!----tab-6----->
                            <div class="tab-pane fade" id="v-pills-Saving" role="tabpane" aria-labelledby="v-pills-Saving-tab">

                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Compulsory Savings (Y/N)</h5>
                                        <div class="ml-auto">
                                            <a href="javascript:;" onclick="downloadClusterdtl(3)" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>Sn</th>
                                                    <th>Details</th>
                                                    <th>Amount</th>
                                                </tr>

                                                <tr>
                                                    <td>A</td>
                                                    <td>Amount of savings per month</td>
                                                    <td></td>

                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>Average Monthly savings during last 12 months</td>
                                                    <td></td>

                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Cumulative savings since inception</td>
                                                    <td></td>
                                                </tr>

                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>


                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Voluntary savings (Y/N</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>SN</th>
                                                    <th></th>
                                                    <th> Amount </th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td>A</td>
                                                    <td>Average Amount of Savings per month</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>

                                                    <td>B</td>
                                                    <td>Cumulative savings to-date since inception</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Date voluntary savings established</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>No of members contribute to voluntary savings</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>E</td>
                                                    <td>Interest paid to members (Y/N)</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>F</td>
                                                    <td>Are savings redistributed to members (Y/N)</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>
                                                    <td>G</td>
                                                    <td>Date of last Redistribution</td>
                                                    <td>----</td>
                                                    <td>----</td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>


                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Loan Security Fund (LSF)  Y/N)</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">

                                                <tbody><tr>
                                                    <td>A</td>
                                                    <td>Date it was established</td>
                                                    <td>----</td>
                                                </tr>
                                                <tr>

                                                    <td>B</td>
                                                    <td>No of members contribute to LSF </td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>Amount available in LSF</td>
                                                    <td>----</td>

                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>No of members benefitted from LSF</td>
                                                    <td>----</td>

                                                </tr>


                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!----tab-7----->
                            <div class="tab-pane fade" id="v-pills-Analysis-and-Scores" role="tabpane" aria-labelledby="v-pills-Analysis-and-Scores-tab">

                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Analysis</h5>
                                        <div class="ml-auto">
                                        <a href="javascript:;" onclick="downloadClusterdtl(3)" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>Objective</th>
                                                    <th>Indicators</th>
                                                    <th>Total Score per objective</th>
                                                    <th>Score Obtained</th>
                                                    <th>Risk Level (green, yellow, grey or red)</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Governance</th>
                                                    <th>25</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td rowspan="5"></td>
                                                    <td>Rotation of Board members as per norms</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td>Average Participation of Members during last 12 months</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td>Cluster books Updated (all books)</td>
                                                    <td></td><td></td><td></td>
                                                </tr><tr>
                                                    <td>% of defunct SHGs</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td>External audit carried out during last 12 months</td>
                                                    <td></td><td></td><td></td>
                                                </tr>

                                                <tr>
                                                    <th colspan="2">Inclusion</th>
                                                    <th>15</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3"></td>
                                                    <td>Coverage of poorest and poor as cluster members</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td>Poorest/poor benefitting from Internal loans </td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td>Poorest/poor in leadership position</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Efficiency</th>
                                                    <th>15</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3"></td>
                                                    <td>Coverage of costs</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td>Time taken to disburse loans (from approval to cash in hand</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td>Consolidated cluster plans prepared and submitted</td>
                                                    <td></td><td></td><td></td>
                                                </tr>

                                                <tr>
                                                    <th colspan="2">Credit History</th>
                                                    <th>30</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td rowspan="4"></td>
                                                    <td>Cluster loan repayment %</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td>PAR status of all loans (cluster and external)</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td>% of members received more than one loan during last 3 years</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td>% of productive loans (out of total loans)</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3"></td>
                                                    <th>Savings</th>
                                                    <th>15</th>
                                                    <th></th>
                                                    <th></th>

                                                </tr>
                                                <tr>
                                                    <td>Compulsory savings Member regularity</td>
                                                    <td></td><td></td><td></td>
                                                </tr>
                                                <tr>
                                                    <td>Voluntary saving member regularity</td>
                                                    <td></td><td></td><td></td>
                                                </tr>


                                                <tr>
                                                    <th>Total</th>
                                                    <th></th>
                                                    <th>100</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----tab-8----->
                            <div class="tab-pane fade" id="v-pills-Challenges" role="tabpane" aria-labelledby="v-pills-Challenges-tab">

                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Challenges ( there should be space to show each challenge)</h5>
                                        <div class="ml-auto">
                                        <a href="javascript:;" onclick="downloadClusterdtl(3)" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                    <th>SN</th>
                                                    <th>Top Challenges</th>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Challenge # 1</td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>-------------------</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Challenge # 2</td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>-------------------</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Challenge # 3</td>
                                                </tr>
                                                <tr>
                                                    <td>Explain/Answer</td>
                                                    <td>-------------------</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!----tab-9----->
                            <div class="tab-pane fade" id="v-pills-Action-Plan" role="tabpanel" aria-labelledby="v-pills-Action-Plan-tab">

                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Action Plan to address challenges</h5>
                                        <div class="ml-auto">
                                        <a href="javascript:;" onclick="downloadClusterdtl(3)" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped">
                                                <tbody><tr>
                                                    <th>SN</th>
                                                    <th>Action Plan</th>
                                                    <th>Challenge # 1</th>
                                                    <th>Challenge # 2</th>
                                                    <th>Challenge # 3</th>
                                                </tr>
                                                <tr>
                                                    <th>1</th>
                                                    <td>Describe Action to addressthe challenge</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>2</th>
                                                    <td>Who would be responsiblefor action</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>3</th>
                                                    <td>When would action becompleted (date)</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>4</th>
                                                    <td>Is there any support fromfederation/project officeneeded to complete action</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>5</th>
                                                    <td>What kind of support isneeded</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>6</th>
                                                    <td>Was action completed byexpected date (Y/N/NA)</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>7</th>
                                                    <td>Has action beenchanged/revised during lastvisit (Y/N)</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>8</th>
                                                    <td>Facilitator to fill which is the revised/changed action</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----tab-10----->
                            <div class="tab-pane fade" id="v-pills-Observations" role="tabpanel" aria-labelledby="v-pills-Observations-tab">

                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Observations</h5>
                                        <div class="ml-auto">
                                        <a href="javascript:;" onclick="downloadClusterdtl(3)" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <table class="table table-striped  ">
                                                <tbody><tr>
                                                    <th width="25px">SN</th>
                                                    <th>Questions</th>
                                                    <th>Answer</th>
                                                </tr>
                                                <tr>
                                                    <td>A1</td>
                                                    <td>How many members attended the cluster meeting?</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>B1</td>
                                                    <td>Were all office bearers and leaders present?  E.g chair, treasurer, secretary, book-keeper, other,</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Did cluster leaders understand the Purpose of the meeting? Explain</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>What was quality of Discussion? Did everyone participate?</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <th colspan="2">Where cluster leaders aware of their rules and norms?</th>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2">
                                                        <table width="100%" class="table-border">
                                                            <tbody><tr>
                                                                <td>A.  Did they understand vision of their Cluster?</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>B.  Do they understand benefits of being part of the Cluster?</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <th colspan="2">Important practices followed by the group.</th>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2">
                                                        <table width="100%" class="table-border">
                                                            <tbody><tr>
                                                                <td>A. Do they have a set of important practices for repayment and savings?</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>B.  What are those practices?</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <th colspan="2">What is Cluster’s policy on the most vulnerable members.</th>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2">
                                                        <table width="100%" class="table-border">
                                                            <tbody><tr>
                                                                <td>A.  Does this Cluster include members who are the most poor and vulnerable, and if yes, </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>B.  what is their policy to help them</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <th colspan="2">Cluster’s Reporting and documentation</th>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2">
                                                        <table width="100%" class="table-border">
                                                            <tbody><tr>
                                                                <td>A.  Does cluster have a satisfactory/weak or good system of reporting and updating of documents?</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>B.  Who writes these books and minutes of meetings?</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <th colspan="2">Cluster’s financial information</th>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2">
                                                        <table width="100%" class="table-border">
                                                            <tbody><tr>
                                                                <td>A.  Are books of accounts managed by the bookkeeper or others? Explain</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>B.  Any highlights</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <th colspan="2">Unique features of this Cluster</th>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2">
                                                        <table width="100%" class="table-border">
                                                            <tbody><tr>
                                                                <td>A.  Did you notice any unique features and practices that make it special?</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>B.  What are those special practices?</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <th colspan="2">Summary of important 3- 5 highlights about this group? </th>
                                                </tr>
                                                <tr class="last-row">
                                                    <td></td>
                                                    <td colspan="2">
                                                        <table width="100%" class="table-border">
                                                            <tbody><tr>
                                                                <td>A</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>B.</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>C.</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>D.</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>E.</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----tab-11----->
                            <div class="tab-pane fade" id="v-pills-Photos-Videos" role="tabpanel" aria-labelledby="v-pills-Photos-Videos-tab">

                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Photos/Videos</h5>
                                        <div class="ml-auto">
                                        <a href="javascript:;" onclick="downloadClusterdtl(3)" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">

                                            <table class="table table-striped">


                                                <tbody><tr class="text-center">
                                                    <th>Name</th>
                                                    <th>Photo</th>
                                                    <th>Detail</th>
                                                </tr>

                                                <tr class="text-center">
                                                    <th>Vinod</th>
                                                    <th><img src="assets/html/profile-pictures.png" width="100px"></th>
                                                    <th> -------</th>
                                                </tr>

                                                <tr class="text-center">
                                                    <th>Ajay</th>
                                                    <th><img src="assets/html/profile-pictures.png" width="100px"></th>
                                                    <th> -------</th>
                                                </tr>
                                            </tbody></table>
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
        text-align:center  !important;
    }

    .faily-tab .nav-link.active {
        box-shadow: 0 3px 6px rgb(31 30 47 / 3%);
        background: #1F2837  !important;
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
    .alldetail .col-md-6:nth-last-of-type(4n-3) .detail, .alldetail .col-md-6:nth-last-of-type(4n-2) .detail {
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
        background:transparent !important;
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
@endsection
