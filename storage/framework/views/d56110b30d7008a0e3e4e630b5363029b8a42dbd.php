<?php $__env->startSection('content'); ?>
<?php
$user = Auth::user();
?>

<div class="page-wrapper">
    <!-- Page-body start -->
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="head-pannel s-box">
                    <div class="d-flex">
                        <div class="count mt-1 ml-2">
                            <img src="<?php echo e(asset('assets\images\6.jpg')); ?>" width="70px" alt="admin@bootstrapmaster.com">
                        </div>
                        <div class="headerfont">
                            <h2><?php echo e($profile[0]->name_of_federation); ?></h2>
                            <div class="E-link d-flex">
                                <a href="#">
                                    <p><i class="las la-envelope"></i><?php echo e($profile[0]->web_email); ?></p>
                                </a>
                                <a href="#">
                                    <p><i class="las la-phone"></i> <?php echo e($profile[0]->web_mobile); ?></p>
                                </a>
                            </div>
                            <p>
                                <span style="padding: 0px 5px;"><?php echo e($profile[0]->name_of_district); ?>,</span>
                                <span style="padding: 0px 5px;"><?php echo e($profile[0]->name_of_state); ?></span>,
                                <span style="padding: 0px 5px;"><?php echo e($profile[0]->name_of_country); ?></span>
                            </p>
                        </div>
                        <div class="ml-auto d-flex">
                            <!-- <div class="rating-box s-box mr-4" style="background-color:#f443368c;">
                                    <h4>NRLM CODE</h4>
                                    <h3><?php echo e($profile[0]->clf_code); ?></h3>
                                    <p></p>
                                </div> -->
                            <div class="rating-box s-box mr-4 <?php echo e($show_final_total); ?>">
                                <h4>Analytics and Rating</h4>
                                <h3><?php echo e($analysis_final_total); ?></h3>
                                <p><?php echo e($show_final_status); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Zero config.table start -->

                <div class="row mt-30" style="margin-top:30px">

                    <div class="col-3 faily-tab">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <?php if($u_type == 'QA' || $u_type == 'CEO' || $u_type == 'A'): ?>
                            <a class="nav-link active" id="v-pills-quality-summary-tab" data-toggle="pill" href="#v-pills-quality-summary" role="tab" aria-controls="v-pills-quality-summary" aria-selected="true"><i class="las la-briefcase mr-2"></i>Summary</a>
                            <a class="nav-link " id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="false"><i class="las la-info-circle mr-2"></i>Basic Profile</a>
                            <?php else: ?>
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="las la-info-circle mr-2"></i>Basic Profile</a>
                            <?php endif; ?>
                            <?php if($user->u_type !='M'): ?>
                            <a class="nav-link " id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="true"><i class="las la-info-circle mr-2"></i>Reports</a>
                            <?php endif; ?>
                            <a class="nav-link " id="v-pills-Governance-and-Accountability-tab" data-toggle="pill" href="#v-pills-Governance-and-Accountability" role="tab" aria-controls="v-pills-Governance-and-Accountability" aria-selected="false"><i class="las la-hand-holding-usd mr-2"></i>Governance and Organizational
                                Effectiveness</a>
                            <a class="nav-link " id="v-pills-Inclusion-tab" data-toggle="pill" href="#v-pills-Inclusion" role="tab" aria-controls="v-pills-Inclusion" aria-selected="false"><i class="las la-briefcase mr-2"></i>Inclusion</a>
                            <a class="nav-link " id="v-pills-Efficiency-tab" data-toggle="pill" href="#v-pills-Efficiency" role="tab" aria-controls="v-pills-Efficiency" aria-selected="false"><i class="las la-briefcase mr-2"></i>Efficiency</a>
                            <a class="nav-link " id="v-pills-Credit-Recovery-tab" data-toggle="pill" href="#v-pills-Credit-Recovery" role="tab" aria-controls="v-pills-Credit-Recovery" aria-selected="false"><i class="las la-briefcase mr-2"></i>Credit History</a>
                            <a class="nav-link " id="v-pills-sustainability-tab" data-toggle="pill" href="#v-pills-sustainability" role="tab" aria-controls="v-pills-sustainability" aria-selected="false"><i class="las la-briefcase mr-2"></i>Sustainability</a>
                            <a class="nav-link " id="v-pills-Risk-Mitigation-tab" data-toggle="pill" href="#v-pills-Risk-Mitigation" role="tab" aria-controls="v-pills-Risk-Mitigation" aria-selected="false"><i class="las la-briefcase mr-2"></i>Risk Mitigation</a>
                            <?php if($user->u_type !='M'): ?>
                            <a class="nav-link " id="v-pills-analysis-tab" data-toggle="pill" href="#v-pills-analysis" role="tab" aria-controls="v-pills-analysis" aria-selected="false"><i class="las la-briefcase mr-2"></i>Analysis</a>
                            <?php endif; ?>
                            <a class="nav-link " id="v-pills-challenges-tab" data-toggle="pill" href="#v-pills-challenges" role="tab" aria-controls="v-pills-challenges" aria-selected="false"><i class="las la-briefcase mr-2"></i>Challenges</a>
                            <a class="nav-link " id="v-pills-action-tab" data-toggle="pill" href="#v-pills-action" role="tab" aria-controls="v-pills-action" aria-selected="false"><i class="las la-briefcase mr-2"></i>Action Plan to address challenges</a>
                            <a class="nav-link " id="v-pills-observations-tab" data-toggle="pill" href="#v-pills-observations" role="tab" aria-controls="v-pills-observations" aria-selected="false"><i class="las la-briefcase mr-2"></i>Observations</a>
                            <a class="nav-link " id="v-pills-Photos-Videos-tab" data-toggle="pill" href="#v-pills-Photos-Videos" role="tab" aria-controls="v-pills-Photos-Videos" aria-selected="false"><i class="las la-briefcase mr-2"></i>Photos/Videos</a>
                            <?php if($u_type !='M'): ?>
                            <a class="nav-link " id="v-pills-report-card-tab" data-toggle="pill" href="#v-pills-report-card" role="tab" aria-controls="v-pills-report-card" aria-selected="false"><i class="las la-briefcase mr-2"></i>Report Card</a>
                            <?php endif; ?>
                            <?php if($u_type == 'M'): ?>
                            <a class="nav-link " id="v-pills-quality-check-tab" data-toggle="pill" href="#v-pills-quality-check" role="tab" aria-controls="v-pills-quality-check" aria-selected="false"><i class="las la-briefcase mr-2"></i>Manager Check</a>
                            <?php elseif($u_type == 'QA'): ?>
                            <a class="nav-link " id="v-pills-quality-check-tab-qa" data-toggle="pill" href="#v-pills-quality-check-qa" role="tab" aria-controls="v-pills-quality-check-qa" aria-selected="false"><i class="las la-briefcase mr-2"></i>Quality Check</a>
                            <?php endif; ?>
                            <a class="nav-link " id="v-pills-remarks-tab" data-toggle="pill" href="#v-pills-remarks"
                                    role="tab" aria-controls="v-pills-remarks" aria-selected="false"><i
                                        class="las la-briefcase mr-2"></i>Remarks</a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <!---tab Reports --->

                            <div class="tab-pane fade" id="v-pills-reports" role="tabpanel" aria-labelledby="v-pills-reports-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Reports</h5>

                                    </div>
                                    <div class="card-box">
                                        <table class="table table-bordered mytable" colspan="2">
                                            <thead class="back-color">

                                            </thead>
                                            <tbody>

                                                <?php if($user->u_type !='M'): ?>
                                                <tr>
                                                    <th width="50%">Federation Profile </th>
                                                    <td><a href="<?php echo e(URL::to('/federationDetailsPdf/' . $federation_ids)); ?>" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a></td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <th>Federation Profile with Report Card </th>
                                                    <td><a href="<?php echo e(URL::to('/federationDetailsCardPdf/' . $federation_ids)); ?>" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <th>Federation Report Card </th>
                                                    <td><a href="<?php echo e(URL::to('/federationcardPdf/' . $federation_ids)); ?>" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a></td>
                                                </tr>


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <!-----tab-1---->
                            <?php if($u_type == 'QA' || $u_type == 'CEO' || $u_type == 'A'): ?>
                            <div class="tab-pane fade show active" id="v-pills-quality-summary" role="tabpanel" aria-labelledby="v-pills-quality-summary-tab">
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Summary </h5>

                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <center style="padding-bottom: 5px;">Rating Score</center>
                                                <div id="demo-pie-1" class="pie-title-center" style="height: 150px;width: 150px;">
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
                            <div class="tab-pane fade " id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Federation Details </h5>

                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Name</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->name_of_federation); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>UIN</strong></div>
                                                    <div class="col-6"><?php echo e($federation->uin); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>District</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->name_of_district != '' ? $profile[0]->name_of_district : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>State</strong></div>
                                                    <div class="col-6"><?php echo e($profile[0]->name_of_state); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Country</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->name_of_country); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>NRLM Code</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->clf_code); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Legal Status </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of
                                                            Registration</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->date_federation_was_found != ''? change_date_month_name_char(str_replace('/', '-', $profile[0]->date_federation_was_found)): 'N/A'); ?>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Legal/Registered
                                                            Status</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->legal_status != '' ? $profile[0]->legal_status : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Registration No</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->registration_no != '' ? $profile[0]->registration_no : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Federation Membership </h5>
                                    </div>
                                    <div class="card-box table-responsive">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Membership</th>
                                                    <th>At the time of Creation/formation</th>
                                                    <th>Current Membership</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A</td>
                                                    <td>No of clusters/habitations</td>
                                                    <td><?php echo e((int) $profile[0]->clusters_at_time_creation); ?></td>
                                                    <td><?php echo e((int) $profile[0]->total_clusters); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>No of SHGs</td>
                                                    <td><?php echo e((int) $profile[0]->shg_at_time_creation); ?></td>
                                                    <td><?php echo e((int) $profile[0]->total_SHGs); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>No of members</td>
                                                    <td><?php echo e((int) $profile[0]->members_at_time_creation); ?></td>
                                                    <td><?php echo e((int) $profile[0]->total_members); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Current Leadership Status </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>President</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->president != '' ? $profile[0]->president : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Secretary</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->secretary != '' ? $profile[0]->secretary : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Treasurer</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->Treasurer != '' ? $profile[0]->Treasurer : 'N/A'); ?>

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
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong> Name</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->book_keeper_name != '' ? $profile[0]->book_keeper_name : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong> Date of
                                                            appointment</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->date_of_appointment != ''? change_date_month_name_char(str_replace('/', '-', $profile[0]->date_of_appointment)): 'N/A'); ?>

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
                                    <?php if(!empty($profile_bank)): ?>
                                    <?php $__currentLoopData = $profile_bank; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Account
                                                            head</strong></div>
                                                    <div class="col-6"><?php echo e($row->account_head); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Account
                                                            type</strong></div>
                                                    <div class="col-6"><?php echo e($row->account_type); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Account opening
                                                            date</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($row->account_opening_date != ''? change_date_month_name_char(str_replace('/', '-', $row->account_opening_date)): 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Name of the
                                                            bank</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($row->name_of_the_bank); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Name of
                                                            Branch</strong></div>
                                                    <div class="col-6"><?php echo e($row->branch); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Account no</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($row->account_number); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>IFSC code</strong>
                                                    </div>
                                                    <div class="col-6"><?php echo e($row->account_ifsc); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Is bank account in
                                                            regular
                                                            operation</strong></div>
                                                    <div class="col-6"><?php echo e($row->updated); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="tab-pane fade " id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Federation Details </h5>

                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Name</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->name_of_federation); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>UIN</strong></div>
                                                    <div class="col-6"><?php echo e($federation->uin); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>District</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->name_of_district != '' ? $profile[0]->name_of_district : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>State</strong></div>
                                                    <div class="col-6"><?php echo e($profile[0]->name_of_state); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Country</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->name_of_country); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>NRLM Code</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->clf_code); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Legal Status </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of
                                                            Registration</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->date_federation_was_found != ''? change_date_month_name_char(str_replace('/', '-', $profile[0]->date_federation_was_found)): 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Legal/Registered
                                                            Status</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->legal_status != '' ? $profile[0]->legal_status : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Registration No</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->registration_no != '' ? $profile[0]->registration_no : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Federation Membership </h5>
                                    </div>
                                    <div class="card-box table-responsive">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Membership</th>
                                                    <th>At the time of Creation/formation</th>
                                                    <th>Current Membership</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>A</td>
                                                    <td>No of clusters/habitations</td>
                                                    <td><?php echo e((int) $profile[0]->clusters_at_time_creation); ?></td>
                                                    <td><?php echo e((int) $profile[0]->total_clusters); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>No of SHGs</td>
                                                    <td><?php echo e((int) $profile[0]->shg_at_time_creation); ?></td>
                                                    <td><?php echo e((int) $profile[0]->total_SHGs); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>No of members</td>
                                                    <td><?php echo e((int) $profile[0]->members_at_time_creation); ?></td>
                                                    <td><?php echo e((int) $profile[0]->total_members); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Current Leadership Status </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>President</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->president != '' ? $profile[0]->president : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Secretary</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->secretary != '' ? $profile[0]->secretary : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Treasurer</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->Treasurer != '' ? $profile[0]->Treasurer : 'N/A'); ?>

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
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong> Name</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->book_keeper_name != '' ? $profile[0]->book_keeper_name : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong> Date of
                                                            appointment</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($profile[0]->date_of_appointment != ''? change_date_month_name_char(str_replace('/', '-', $profile[0]->date_of_appointment)): 'N/A'); ?>

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
                                    <?php if(!empty($profile_bank)): ?>
                                    <?php $__currentLoopData = $profile_bank; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Account
                                                            head</strong></div>
                                                    <div class="col-6"><?php echo e($row->account_head); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Account
                                                            type</strong></div>
                                                    <div class="col-6"><?php echo e($row->account_type); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Account opening
                                                            date</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($row->account_opening_date != ''? change_date_month_name_char(str_replace('/', '-', $row->account_opening_date)): 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Name of the
                                                            bank</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($row->name_of_the_bank); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Name of
                                                            Branch</strong></div>
                                                    <div class="col-6"><?php echo e($row->branch); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Account no</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($row->account_number); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>IFSC code</strong>
                                                    </div>
                                                    <div class="col-6"><?php echo e($row->account_ifsc); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Is bank account in
                                                            regular
                                                            operation</strong></div>
                                                    <div class="col-6"><?php echo e($row->updated); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!----tab 2---->
                            <div class="tab-pane fade" id="v-pills-Governance-and-Accountability" role="tabpanel" aria-labelledby="v-pills-Governance-and-Accountability-tab">
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
                                                        <?php echo e(checkna($governance[0]->adoption_of_rules)); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($governance[0]->adoption_of_rules == 'Yes'): ?>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Written Rules</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->written_norms); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <?php if($governance[0]->written_norms == 'Yes'): ?>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of
                                                            Adoption</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->date_of_adoption != ''? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_adoption)): 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
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
                                                    <div class="col-6"><strong>Election or Selection</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->frequency_election != '' ? $governance[0]->frequency_election : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Frequency as per norms</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->frequency_as_per_norms != '' ? $governance[0]->frequency_as_per_norms : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>1st election date </strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->first_election_date != ''? change_date_month_name_char(str_replace('/', '-', $governance[0]->first_election_date)): 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of Elections conducted so
                                                            far</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->no_of_elections_conducted_so_far != ''? $governance[0]->no_of_elections_conducted_so_far: 0); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of Last Election</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->date_of_last_election_option != ''? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_last_election_option)): 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Last 3 elections conducted as
                                                            per
                                                            norms</strong></div>
                                                </div>
                                                <div class="row detail pl-2"><strong>1st :</strong><span style="margin-left: 8%;"><?php echo e(checkna($governance[0]->last_two_election_conducted)); ?></span>
                                                </div>
                                                <div class="row detail pl-2"><strong>2nd :</strong><span style="margin-left: 8%;"><?php echo e(checkna($governance[0]->last_two_election_conducted_2nd)); ?></span>
                                                </div>
                                                <div class="row detail pl-2"><strong>3rd :</strong><span style="margin-left: 8%;"><?php echo e(checkna($governance[0]->last_two_election_conducted_3rd)); ?></span>
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
                                                        <?php echo e($governance[0]->frequency_of_meetings_on_a_monthly_basis != ''? $governance[0]->frequency_of_meetings_on_a_monthly_basis: 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of meetings conducted during
                                                            last 12
                                                            months</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $governance[0]->meetings_federation_last_six_months); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Average Participation of
                                                            Members during
                                                            last 12 months</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $governance[0]->participation_members_last_six_months); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Total no of Board/EC
                                                            members</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $governance[0]->Total_board_members); ?>

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
                                                    <div class="col-6"><strong>Status of Minutes of Board
                                                            meetings
                                                            recorded</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->minutes_of_group_meetings_recorded != ''? $governance[0]->minutes_of_group_meetings_recorded: 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Who writes the minutes</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->who_writes_the_minutes != '' ? $governance[0]->who_writes_the_minutes : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>General Assembly/Body Meeting

                                        </h5>
                                    </div>


                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>General Assembly/Body Meeting</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->general_assembly != '' ? $governance[0]->general_assembly : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($governance[0]->general_assembly == 'Yes'): ?>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Frequency</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->frequency_assembly_meetings != '' ? $governance[0]->frequency_assembly_meetings : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of GA/GB
                                                            members</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $governance[0]->number_of_GA_members != '' ? (int) $governance[0]->number_of_GA_members : 0); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>No of meetings conducted
                                                            during last
                                                            12
                                                            months</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $governance[0]->federation_conducted_meetings != ''? (int) $governance[0]->federation_conducted_meetings: 0); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of last
                                                            meeting</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->date_of_last_metting != ''? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_last_metting)): 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Has last year annual plan
                                                            and budget
                                                            approved by GB</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->budget_approval_by_general_assembly != ''? $governance[0]->budget_approval_by_general_assembly: 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of last plan and
                                                            budget
                                                            approval</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->date_of_last_budget_and_annual_approval != ''? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_last_budget_and_annual_approval)): 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Are members aware of this
                                                            achievement</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->member_aware != '' ? $governance[0]->member_aware : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Achievement of last year
                                                            annual
                                                            plan</strong></div>
                                                    <div class="col-6"></div>
                                                    <div class="col-6"><strong>i. Financial (Y/N), if yes
                                                            specify</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->Annual_plan_Financial); ?> -
                                                        <?php echo e($governance[0]->Annual_plan_Financial_specify); ?>

                                                    </div>
                                                    <div class="col-6"><strong>ii. Livelihood (Y/N), if
                                                            yes,
                                                            specify</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->Annual_plan_Livelihood); ?> -
                                                        <?php echo e($governance[0]->Annual_plan_Livelihood_specify); ?>

                                                    </div>
                                                    <div class="col-6"><strong>iii. Social (Y/N), if yes,
                                                            specify</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->Annual_plan_Social); ?> -
                                                        <?php echo e($governance[0]->Annual_plan_Social_specify); ?>

                                                    </div>
                                                    <div class="col-6"><strong>iv. Convergence (Y/N), if
                                                            yes,
                                                            specify</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->Annual_plan_Convergence); ?>

                                                        -
                                                        <?php echo e($governance[0]->Annual_plan_Convergence_specify); ?>

                                                    </div>
                                                    <div class="col-6"><strong>v. Others (Y/N), if yes,
                                                            specify</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->Annual_plan_Others); ?> -
                                                        <?php echo e($governance[0]->Annual_plan_Others_specify); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
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
                                                        <?php echo e($governance[0]->how_often_are_books_updated != '' ? $governance[0]->how_often_are_books_updated : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Date of last update</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->date_of_last_updated_books != ''? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_last_updated_books)): 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Updated status</strong></div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->updated_status != '' ? $governance[0]->updated_status : 'N/A'); ?>

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
                                                        <strong><?php echo e($governance[0]->issues_highlighted_external_audit != ''? $governance[0]->issues_highlighted_external_audit: 'N/A'); ?></strong>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Grade of Federation during last 12 months</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6 table-padd">
                                                <div class="row detail">
                                                    <div class="col-6"><strong>Grade of Federation</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($governance[0]->grading_obtained != '' ? $governance[0]->grading_obtained : 'N/A'); ?>

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
                                        <div class="col-6"><strong>Social Audit Committee</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->federation_social_audit_committee != ''? $governance[0]->federation_social_audit_committee: 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <?php if($governance[0]->federation_social_audit_committee == 'Yes'): ?>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>SAC formation date</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->when_was_the_SAC_created != ''? change_date_month_name_char(str_replace('/', '-', $governance[0]->when_was_the_SAC_created)): 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Whether SAC functioned
                                                during last 12
                                                months (Y/N)</strong></div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->SAC_functioned); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Date of last report
                                                submitted by SAC
                                                to
                                                GB/GA</strong></div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->date_last_report_submitted != ''? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_last_report_submitted)): 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Issues highlighted by SAC
                                                (describe)</strong></div>
                                    </div>
                                    <?php
                                    $blank= '';

                                    ?>
                                    <?php if($governance[0]->issues_highlighted1 != ''): ?>
                                    <?php
                                    $blank= 1;
                                    ?>
                                    <div class="row detail pl-2"><strong>1st -
                                        </strong>&nbsp;&nbsp;<?php echo e($governance[0]->issues_highlighted1); ?>

                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->issues_highlighted2 != ''): ?>
                                    <?php
                                    $blank= 2;
                                    ?>
                                    <div class="row detail pl-2"><strong>2nd -
                                        </strong>&nbsp;&nbsp;<?php echo e($governance[0]->issues_highlighted2); ?>

                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->issues_highlighted3 != ''): ?>
                                    <?php
                                    $blank= 3;
                                    ?>
                                    <div class="row detail pl-2"><strong>3rd -
                                        </strong>&nbsp;&nbsp;<?php echo e($governance[0]->issues_highlighted3); ?>

                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->issues_highlighted4 != ''): ?>
                                    <?php
                                    $blank= 4;
                                    ?>
                                    <div class="row detail pl-2"><strong>4th -
                                        </strong>&nbsp;&nbsp;<?php echo e($governance[0]->issues_highlighted4); ?>

                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->issues_highlighted5 != ''): ?>
                                    <?php
                                    $blank= 5;
                                    ?>
                                    <div class="row detail pl-2"><strong>5th -
                                        </strong>&nbsp;&nbsp;<?php echo e($governance[0]->issues_highlighted5); ?>

                                    </div>
                                    <?php endif; ?>
                                    <?php if($blank == ''): ?>

                                    <div class="row detail pl-2"><strong>
                                        </strong>&nbsp;&nbsp;N/A</div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Any other Committee formed

                            </h5>
                        </div>

                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Any other Committee formed</strong></div>
                                        <div class="col-6"><strong><?php echo e($governance[0]->any_other_committee_formed != '' ? $governance[0]->any_other_committee_formed : 'N/A'); ?></strong></div>
                                    </div>


                                </div>
                                <?php if($governance[0]->any_other_committee_formed == 'Yes'): ?>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-12"><strong>Names of subcommittee and
                                                purpose</strong></div>
                                    </div>
                                    <?php if($governance[0]->please_mention_names_of_committee != ''): ?>
                                    <div class="row detail pl-2"><strong>1st -
                                        </strong>&nbsp;&nbsp;<?php echo e($governance[0]->please_mention_names_of_committee); ?>

                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->please_mention_names_of_committee2 != ''): ?>
                                    <div class="row detail pl-2"><strong>2nd -
                                        </strong>&nbsp;&nbsp;<?php echo e($governance[0]->please_mention_names_of_committee2); ?>

                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->please_mention_names_of_committee3 != ''): ?>
                                    <div class="row detail pl-2"><strong>3rd -
                                        </strong>&nbsp;&nbsp;<?php echo e($governance[0]->please_mention_names_of_committee3); ?>

                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
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
                                        <div class="col-6"><strong>Is Internal audit available
                                            </strong></div>
                                        <div class="col-6">
                                            <?php echo e(checkna($governance[0]->internal_audit)); ?>

                                        </div>
                                    </div>
                                </div>
                                <?php if($governance[0]->internal_audit == 'Yes'): ?>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Frequency during last 12
                                                months</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->frequency_internal_audit_conducted); ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Date of last internal
                                            </strong></div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->date_of_last_internal_audit != ''? change_date_month_name_char(str_replace('/', '-', $governance[0]->date_of_last_internal_audit)): 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>No of highlighted issues
                                                resolved by
                                                federation</strong></div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->Highlighted_issues_addressed); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Issues and observations
                                                raised during
                                                last 12 months (Y/N)</strong></div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->Issues_highlighted_by_internal_audit); ?>

                                        </div>
                                    </div>
                                    <?php if($governance[0]->Issues_highlighted_by_internal_audit == 'Yes'): ?>
                                    <?php if($governance[0]->internal_misappropriation_of_fund == '1'): ?>
                                    <div class="row detail pl-2">Misappropriation of fund</div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->internal_not_updation_of_books == '1'): ?>
                                    <div class="row detail pl-2">Not Updation of books of
                                        accounts
                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->internal_utilization == '1'): ?>
                                    <div class="row detail pl-2">Deviation of utilisation of
                                        loan
                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->internal_non_adherance == '1'): ?>
                                    <div class="row detail pl-2">Non internal_non_adherance of
                                        norms
                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->internal_others == '1'): ?>
                                    <div class="row detail pl-2">Other -
                                        <?php echo e($governance[0]->Issues_highlighted_by_internal_audit_other); ?>

                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>External Audit</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Is External audit available
                                            </strong></div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->external_audit != '' ? $governance[0]->external_audit : 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>

                                <?php if($governance[0]->external_audit == 'Yes'): ?>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Date of last external audit
                                            </strong></div>
                                        <div class="col-6">
                                            <?php echo e(Change_date_month_name_char(str_replace('/', '-', $governance[0]->date_external_audit_conducted))); ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>No of highlighted issues
                                                resolved by
                                                federation</strong></div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->issues_highlighted_resolved); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Issues and observations
                                                raised during
                                                last 12 months (Y/N)</strong></div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->issues_highlighted_external_audit); ?>

                                        </div>
                                    </div>
                                    <?php if($governance[0]->issues_highlighted_external_audit == 'Yes'): ?>
                                    <?php if($governance[0]->external_misappropriation_of_fund == '1'): ?>
                                    <div class="row detail pl-2">Misappropriation of fund</div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->external_not_updation_of_books == '1'): ?>
                                    <div class="row detail pl-2">Not Updation of books of
                                        accounts
                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->external_utilization == '1'): ?>
                                    <div class="row detail pl-2">Deviation of utilisation of
                                        loan
                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->external_non_adherance == '1'): ?>
                                    <div class="row detail pl-2">Non internal_non_adherance of
                                        norms
                                    </div>
                                    <?php endif; ?>
                                    <?php if($governance[0]->external_others == '1'): ?>
                                    <div class="row detail pl-2">Other -
                                        <?php echo e($governance[0]->issues_highlighted_external_audit_other); ?>

                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Training</h5>
                        </div>
                        <table class="table mytable table-responsive">
                            <thead class="back-color">
                                <tr>
                                    <th>SN</th>
                                    <th>Designation</th>
                                    <th>Name of Training</th>
                                    <th>Duration in days</th>
                                    <th>Date</th>
                                    <th>Name of Training Recipient</th>
                                    <th>Name of Trainer</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if(!empty($governance_6)): ?>
                                <?php $__currentLoopData = $governance_6; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>A</td>
                                    <td>Current Leaders (president/treasurer and secretary)</td>
                                    <td><?php echo e($row->training_name); ?></td>
                                    <td><?php echo e($row->duration); ?></td>
                                    <td><?php echo e($row->date_training != '' ? change_date_month_name_char(str_replace('/', '-', $row->date_training)) : 'N/A'); ?>

                                    </td>
                                    <td>
                                        <?php
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
                                        ?>
                                        <?php echo e($strdesg); ?>

                                    </td>
                                    <td><?php echo e($row->name); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr>
                                    <td>A</td>
                                    <td>Current Leaders (president/treasurer and secretary)</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                </tr>
                                <?php endif; ?>

                                <?php if(!empty($governance_7)): ?>
                                <?php $__currentLoopData = $governance_7; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>B</td>
                                    <td>SAC members</td>
                                    <td><?php echo e($row->training_name); ?></td>
                                    <td><?php echo e($row->duration); ?></td>
                                    <td><?php echo e($row->date_training != '' ? change_date_month_name_char(str_replace('/', '-', $row->date_training)) : 'N/A'); ?>

                                    </td>
                                    <td>
                                        <?php
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
                                        ?>
                                        <?php echo e($strdesg); ?>

                                    </td>
                                    <td><?php echo e($row->name); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr>
                                    <td>B</td>
                                    <td>SAC members</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                </tr>
                                <?php endif; ?>


                                <?php if(!empty($governance_8)): ?>
                                <?php $__currentLoopData = $governance_8; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>C</td>
                                    <td>Book-keeper</td>
                                    <td><?php echo e($row->training_name); ?></td>
                                    <td><?php echo e($row->duration); ?></td>
                                    <td><?php echo e($row->date_training != '' ? change_date_month_name_char(str_replace('/', '-', $row->date_training)) : 'N/A'); ?>

                                    </td>
                                    <td>
                                        <?php
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
                                        ?>
                                        <?php echo e($strdesg); ?>

                                    </td>
                                    <td><?php echo e($row->name); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr>
                                    <td>C</td>
                                    <td>Book-keeper</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                </tr>
                                <?php endif; ?>



                            </tbody>
                        </table>
                    </div>

                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Defunct SHG status in the Federation</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Total SHGs formed in
                                                federation</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e((int) $governance[0]->Total_SHGs_formed != '' ? (int) $governance[0]->Total_SHGs_formed : '0'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Current defunct SHGs</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->present_no_of_SHGs_defunct != '' ? $governance[0]->present_no_of_SHGs_defunct : '0'); ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Defunct SHGs (%)</strong></div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->Defunct_SHGs != '' ? $governance[0]->Defunct_SHGs : '0'); ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Reasons for defunct
                                                (explain)</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($governance[0]->Defunct_SHGs_reasons != '' ? $governance[0]->Defunct_SHGs_reasons : 'N/A'); ?>

                                        </div>
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
                                            <?php echo e($inclusion[0]->wealth_ranking_mapping != '' ? $inclusion[0]->wealth_ranking_mapping : 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <?php if($inclusion[0]->wealth_ranking_mapping == 'Yes'): ?>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Date of 1st poverty
                                                mapping</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($inclusion[0]->month_year_of_1st_poverty_mapping != ''? change_date_month_name_char(str_replace('/', '-', $inclusion[0]->month_year_of_1st_poverty_mapping)): 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Date of last
                                                update</strong></div>
                                        <div class="col-6">
                                            <?php echo e($inclusion[0]->month_year_of_last_update != ''? change_date_month_name_char(str_replace('/', '-', $inclusion[0]->month_year_of_last_update)): 'N/A'); ?>


                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Last Poverty Ranking Results</h5>
                        </div>
                        <table class="table mytable">
                            <thead class="back-color">
                                <tr>
                                    <th>SN</th>
                                    <th>Poverty Mappint</th>
                                    <th>Ineligible to get mobilized into SHG</th>
                                    <th>HHs organized into SHGs</th>
                                    <th>Total HHs member</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>Poorest and vulnerable</td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_poorest_and_most_vulnerable != ''? (int) $inclusion[0]->no_of_poorest_and_most_vulnerable: 0); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_poorest_and_most_vulnerable_mobilised != ''? (int) $inclusion[0]->no_of_poorest_and_most_vulnerable_mobilised: 0); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_poorest_and_most_vulnerable_hhm != ''? (int) $inclusion[0]->no_of_poorest_and_most_vulnerable_hhm: 0); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Poor</td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_poor_category != '' ? (int) $inclusion[0]->no_of_poor_category : 0); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_poor_category_mobilised != ''? (int) $inclusion[0]->no_of_poor_category_mobilised: 0); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_poor_category_hhm != '' ? (int) $inclusion[0]->no_of_poor_category_hhm : 0); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>Medium poor</td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_medium_poor != '' ? (int) $inclusion[0]->no_of_medium_poor : 0); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_medium_poor_mobilised != ''? (int) $inclusion[0]->no_of_medium_poor_mobilised: 0); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_medium_poor_hhm != '' ? (int) $inclusion[0]->no_of_medium_poor_hhm : 0); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>Rich</td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_rich != '' ? (int) $inclusion[0]->no_of_rich : 0); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_rich_mobilised != '' ? (int) $inclusion[0]->no_of_rich_mobilised : 0); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->no_of_rich_hhm != '' ? (int) $inclusion[0]->no_of_rich_hhm : 0); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Total</td>
                                    <td><?php echo e((int) $inclusion[0]->total_poverty_mapping_ineligible_mobilised != ''? (int) $inclusion[0]->total_poverty_mapping_ineligible_mobilised: 0); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->total_poverty_mapping_mobilised_member != ''? (int) $inclusion[0]->total_poverty_mapping_mobilised_member: 0); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->total_poverty_mapping_households != ''? (int) $inclusion[0]->total_poverty_mapping_households: 0); ?>

                                    </td>
                                </tr>

                            </tbody>
                        </table>
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
                                            <?php echo e((int) $inclusion[0]->no_of_SC_and_ST); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>No of OBC</strong></div>
                                        <div class="col-6">
                                            <?php echo e((int) $inclusion[0]->no_of_OBC); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>No of others</strong></div>
                                        <div class="col-6">
                                            <?php echo e((int) $inclusion[0]->no_of_others); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>No of loans disbursed under each sub-category of HHs </h5>
                        </div>
                        <table class="table mytable table-responsive">
                            <thead class="back-color">
                                <tr>
                                    <th>Category</th>
                                    <th class="table_th" colspan="2">Federation Loans</th>
                                    <th class="table_th" colspan="2">External Loans</th>
                                    <th class="table_th" colspan="2">VI Loans</th>
                                    <th class="table_th" colspan="2">Total Loans</th>
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
                                    <td><?php echo e((int) $inclusion[0]->federation_poorest_category); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poorest_category_amount); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->external_poorest_category); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->external_poorest_category_amount); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->vi_poorest_category); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->vi_poorest_category_amount); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poorest_category +(int) $inclusion[0]->external_poorest_category +(int) $inclusion[0]->vi_poorest_category); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poorest_category_amount +(int) $inclusion[0]->external_poorest_category_amount +(int) $inclusion[0]->vi_poorest_category_amount); ?>

                                    </td>

                                </tr>
                                <tr>
                                    <td>Poor</td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poor_category); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poor_category_amount); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->external_poor_category); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->external_poor_category_amount); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->vi_poor_category); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->vi_poor_category_amount); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poor_category +(int) $inclusion[0]->external_poor_category +(int) $inclusion[0]->vi_poor_category); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poor_category_amount +(int) $inclusion[0]->external_poor_category_amount +(int) $inclusion[0]->vi_poor_category_amount); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>Medium poor</td>
                                    <td><?php echo e((int) $inclusion[0]->federation_medium); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_medium_amount); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->external_medium); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->external_medium_amount); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->vi_medium); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->vi_medium_amount); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_medium +(int) $inclusion[0]->external_medium +(int) $inclusion[0]->vi_medium); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->federation_medium_amount +(int) $inclusion[0]->external_medium_amount +(int) $inclusion[0]->vi_medium_amount); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>Rich</td>
                                    <td><?php echo e((int) $inclusion[0]->federation_rich); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_rich_amount); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->external_rich); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->external_rich_amount); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->vi_rich); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->vi_rich_amount); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_rich + (int) $inclusion[0]->external_rich + (int) $inclusion[0]->vi_rich); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->federation_rich_amount +(int) $inclusion[0]->external_rich_amount +(int) $inclusion[0]->vi_rich_amount); ?>

                                    </td>

                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poorest_category +(int) $inclusion[0]->federation_poor_category +(int) $inclusion[0]->federation_medium +(int) $inclusion[0]->federation_rich); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poorest_category_amount +(int) $inclusion[0]->federation_poor_category_amount +(int) $inclusion[0]->federation_medium_amount +(int) $inclusion[0]->federation_rich_amount); ?>

                                    </td>

                                    <td><?php echo e((int) $inclusion[0]->external_poorest_category +(int) $inclusion[0]->external_poor_category +(int) $inclusion[0]->external_medium +(int) $inclusion[0]->external_rich); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->external_poorest_category_amount +(int) $inclusion[0]->external_poor_category_amount +(int) $inclusion[0]->external_medium_amount +(int) $inclusion[0]->external_rich_amount); ?>

                                    </td>

                                    <td><?php echo e((int) $inclusion[0]->vi_poorest_category +(int) $inclusion[0]->vi_poor_category +(int) $inclusion[0]->vi_medium +(int) $inclusion[0]->vi_rich); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->vi_poorest_category_amount +(int) $inclusion[0]->vi_poor_category_amount +(int) $inclusion[0]->vi_medium_amount +(int) $inclusion[0]->vi_rich_amount); ?>

                                    </td>

                                    <td><?php echo e((int) $inclusion[0]->federation_poorest_category +(int) $inclusion[0]->external_poorest_category +(int) $inclusion[0]->vi_poorest_category +(int) $inclusion[0]->federation_poor_category +(int) $inclusion[0]->external_poor_category +(int) $inclusion[0]->vi_poor_category +(int) $inclusion[0]->federation_rich +(int) $inclusion[0]->external_rich +(int) $inclusion[0]->vi_rich +(int) $inclusion[0]->federation_medium +(int) $inclusion[0]->external_medium +(int) $inclusion[0]->vi_medium); ?>

                                    </td>

                                    <td><?php echo e((int) $inclusion[0]->federation_rich_amount +(int) $inclusion[0]->external_rich_amount +(int) $inclusion[0]->vi_rich_amount +(int) $inclusion[0]->federation_poorest_category_amount +(int) $inclusion[0]->external_poorest_category_amount +(int) $inclusion[0]->vi_poorest_category_amount +(int) $inclusion[0]->federation_poor_category_amount +(int) $inclusion[0]->external_poor_category_amount +(int) $inclusion[0]->vi_poor_category_amount +(int) $inclusion[0]->federation_medium_amount +(int) $inclusion[0]->external_medium_amount +(int) $inclusion[0]->vi_medium_amount); ?>

                                    </td>

                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>No. of Federation HHs benefitted from all loans during last 3 years</h5>
                        </div>
                        <table class="table mytable">
                            <thead class="back-color">
                                <tr>
                                    <th rowspan="2">Category</th>
                                    <th rowspan="2">Total member HHs</th>
                                    <th colspan="5" class="text-center">Received Loan</th>
                                </tr>
                                <tr>
                                    <th>Federation Loan</th>
                                    <th>External loan</th>
                                    <th>VI Loan</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>Very Poor &amp; vulnerable</td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poorest_category_hhs); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poorest_category_recloan); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->external_poorest_category_recloan); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->vi_poorest_category_recloan); ?></td>
                                </tr>
                                <tr>
                                    <td>Poor</td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poor_category_hhs); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poor_category_recloan); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->external_poor_category_recloan); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->vi_poor_category_recloan); ?></td>
                                </tr>
                                <tr>
                                    <td>Medium</td>
                                    <td><?php echo e((int) $inclusion[0]->federation_medium_hhs); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_medium_recloan); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->external_medium_recloan); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->vi_medium_recloan); ?></td>
                                </tr>
                                <tr>
                                    <td>Rich</td>
                                    <td><?php echo e((int) $inclusion[0]->federation_rich_hhs); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_rich_recloan); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->external_rich_recloan); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->vi_rich_recloan); ?></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poorest_category_hhs +(int) $inclusion[0]->federation_poor_category_hhs +(int) $inclusion[0]->federation_medium_hhs +(int) $inclusion[0]->federation_rich_hhs); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->federation_poorest_category_recloan +(int) $inclusion[0]->federation_poor_category_recloan +(int) $inclusion[0]->federation_medium_recloan +(int) $inclusion[0]->federation_rich_recloan); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->external_poorest_category_recloan +(int) $inclusion[0]->external_poor_category_recloan +(int) $inclusion[0]->external_medium_recloan +(int) $inclusion[0]->external_rich_recloan); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->vi_poorest_category_recloan +(int) $inclusion[0]->vi_poor_category_recloan +(int) $inclusion[0]->vi_medium_recloan +(int) $inclusion[0]->vi_rich_recloan); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Board and Office Bearer Membership in Federation </h5>
                        </div>
                        <table class="table mytable">
                            <thead class="back-color">
                                <tr>
                                    <th>SN</th>
                                    <th></th>
                                    <th>Board membership</th>
                                    <th>Office bearers/leaders</th>
                                </tr>
                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>Total Members</td>
                                    <td><?php echo e((int) $inclusion[0]->total_board_members_cluster); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_inclusion_poor_members +(int) $inclusion[0]->federation_inclusion_poor1_members +(int) $inclusion[0]->federation_inclusion_rich_members); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>No of members from the poorest and vulberale</td>
                                    <td><?php echo e((int) $inclusion[0]->members_from_poorest_category); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_inclusion_poor_members); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>No of members from the poor</td>
                                    <td><?php echo e((int) $inclusion[0]->members_from_poor_category); ?></td>
                                    <td><?php echo e((int) $inclusion[0]->federation_inclusion_poor1_members); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>No of members from middle and rich category</td>
                                    <td><?php echo e((int) $inclusion[0]->members_from_middle_and_rich_category); ?>

                                    </td>
                                    <td><?php echo e((int) $inclusion[0]->federation_inclusion_rich_members); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Special Goals of the federation for current year - Describe each</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <?php if($inclusion[0]->federation_social_goal_a != ''): ?>
                                    <div class="row detail">
                                        <div class="col-6">
                                            <strong><?php echo e($inclusion[0]->federation_social_goal_a); ?></strong>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($inclusion[0]->federation_social_goal_b != ''): ?>
                                    <div class="row detail">
                                        <div class="col-6">
                                            <strong><?php echo e($inclusion[0]->federation_social_goal_b); ?></strong>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($inclusion[0]->federation_social_goal_c != ''): ?>
                                    <div class="row detail">
                                        <div class="col-6">
                                            <strong><?php echo e($inclusion[0]->federation_social_goal_c); ?></strong>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----tab-4----->
                <div class="tab-pane fade" id="v-pills-Efficiency" role="tabpane" aria-labelledby="v-pills-Efficiency-tab">
                    <div class="family-box">
                        <div class="w-heading d-flex">
                            <h5>Federation Integrated Credit Plan </h5>

                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Has Federation Prepared
                                                integrated credit
                                                plan (Y/N)</strong></div>
                                        <div class="col-6">
                                            <?php echo e(checkna($efficiency[0]->integrated_Federation_plan)); ?>

                                        </div>
                                    </div>
                                </div>
                                <?php if($efficiency[0]->integrated_Federation_plan == 'Yes'): ?>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Date of last plan approved
                                                by
                                                Federation</strong></div>
                                        <div class="col-6">
                                            <?php echo e($efficiency[0]->date_federation_plan_approved != ''? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->date_federation_plan_approved)): 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Date it was submitted to
                                                Partner</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($efficiency[0]->date_federation_plan_submitted != ''? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->date_federation_plan_submitted)): 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="family-box">
                        <div class="w-heading d-flex">
                            <h5>Approval Process</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>No of days taken to approve
                                                loan
                                                application</strong></div>
                                        <div class="col-6">
                                            <?php echo e((int) $efficiency[0]->time_taken_to_approve_loan); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Average Monthly loans during
                                                last 12
                                                months</strong></div>
                                        <div class="col-6">
                                            <?php echo e((int) $efficiency[0]->loans_per_month_approved); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Time taken from approval to
                                                cash in hand
                                            </strong></div>
                                        <div class="col-6">
                                            <?php echo e((int) $efficiency[0]->time_taken_to_give_money_from_approval); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-box">
                        <div class="w-heading d-flex">
                            <h5>How many new members mobilized during last 12 months</h5>
                        </div>
                        <div class="card-box">
                            <div class="row detail">
                                <div class="col-6"><strong>How many new members mobilized during
                                        last 12 months
                                    </strong></div>
                                <div class="col-6">
                                    <?php echo e((int) $efficiency[0]->members_mobilized != '' ? (int) $efficiency[0]->members_mobilized : 0); ?>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="family-box">
                        <div class="w-heading d-flex">
                            <h5>Cost Ratio per client </h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Cost per Client</strong></div>
                                        <div class="col-6">
                                            <?php echo e($efficiency[0]->cost_ratio_per_active_client != '' ? $efficiency[0]->cost_ratio_per_active_client : 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Average operating
                                                expense</strong></div>
                                        <div class="col-6">
                                            <?php echo e($efficiency[0]->operating_expenes != '' ? $efficiency[0]->operating_expenes : 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Average no of clients</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($efficiency[0]->average_no != '' ? $efficiency[0]->average_no : 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-box">
                        <div class="w-heading d-flex">
                            <h5>Federation Operation Expense Ratio </h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Operation Expense
                                                Ratio</strong></div>
                                        <div class="col-6">
                                            <?php echo e($efficiency[0]->federation_operation_expense_ratio != ''? $efficiency[0]->federation_operation_expense_ratio: 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Average operating
                                                expense</strong></div>
                                        <div class="col-6">
                                            <?php echo e($efficiency[0]->operation_expense != '' ? $efficiency[0]->operation_expense : 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Average gross portfolio
                                            </strong></div>
                                        <div class="col-6">
                                            <?php echo e($efficiency[0]->avg_gross_portfolio != '' ? $efficiency[0]->avg_gross_portfolio : 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Cost Income Ratio for last 3 years</h5>
                        </div>
                        <table class="table mytable">
                            <thead class="back-color">
                                <tr>
                                    <th>SN</th>
                                    <th>Time-period</th>
                                    <th>Cost Income Ratio (%)</th>
                                    <th>Operating Income (a)</th>
                                    <th>Operating Expense (b)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Last 12 Months</td>
                                    <td><?php echo e($efficiency[0]->cost_income_ratio_year1 != '' ? $efficiency[0]->cost_income_ratio_year1 : 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->operating_income_year1 != '' ? $efficiency[0]->operating_income_year1 : 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->operating_expenses_year1 != '' ? $efficiency[0]->operating_expenses_year1 : 0); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>1 Year before last year</td>
                                    <td><?php echo e($efficiency[0]->cost_income_ratio_year2 != '' ? $efficiency[0]->cost_income_ratio_year2 : 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->operating_income_year2 != '' ? $efficiency[0]->operating_income_year2 : 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->operating_expenses_year2 != '' ? $efficiency[0]->operating_expenses_year2 : 0); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>2 years before last year</td>
                                    <td><?php echo e($efficiency[0]->cost_income_ratio_year3 != '' ? $efficiency[0]->cost_income_ratio_year3 : 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->operating_income_year3 != '' ? $efficiency[0]->operating_income_year3 : 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->operating_expenses_year3 != '' ? $efficiency[0]->operating_expenses_year3 : 0); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Average Outstanding Loan Size and active Borrowers during last 3 years</h5>
                        </div>
                        <table class="table mytable">
                            <thead class="back-color">
                                <tr>
                                    <th>SN</th>
                                    <th>Time-period</th>
                                    <th>Average Outstanding loan size</th>
                                    <th>Loan outstanding Amount (a)</th>
                                    <th>Active Borrowers (b)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Last 12 Months</td>
                                    <td><?php echo e($efficiency[0]->outstanding_loan_ratio_year1 != ''? (float) $efficiency[0]->outstanding_loan_ratio_year1: 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->outstanding_loan_year1 != '' ? $efficiency[0]->outstanding_loan_year1 : 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->active_borrower_year1 != '' ? $efficiency[0]->active_borrower_year1 : 0); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>1 Year before last year</td>
                                    <td><?php echo e($efficiency[0]->outstanding_loan_ratio_year2 != ''? (float) $efficiency[0]->outstanding_loan_ratio_year2: 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->outstanding_loan_year2 != '' ? $efficiency[0]->outstanding_loan_year2 : 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->active_borrower_year2 != '' ? $efficiency[0]->active_borrower_year2 : 0); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>2 years before last year</td>
                                    <td><?php echo e($efficiency[0]->outstanding_loan_ratio_year3 != ''? (float) $efficiency[0]->outstanding_loan_ratio_year3: 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->outstanding_loan_year3 != '' ? $efficiency[0]->outstanding_loan_year3 : 0); ?>

                                    </td>
                                    <td><?php echo e($efficiency[0]->active_borrower_year3 != '' ? $efficiency[0]->active_borrower_year3 : 0); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box">
                        <div class="w-heading d-flex">
                            <h5>Monthly Progress Reports</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Does it prepare a report ?
                                                Y/N</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e(checkna($efficiency[0]->integrated_credit_plan_approved)); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Date of last report
                                                submitted</strong>
                                        </div>

                                        <div class="col-6">

                                            <?php echo e($efficiency[0]->date_last_report_submitted != ''? change_date_month_name_char(str_replace('/', '-', $efficiency[0]->date_last_report_submitted)): 'N/A'); ?>


                                        </div>

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

                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Loan Approvals at the Federation During last 12 Months</h5>
                        </div>
                        <table class="table mytable">
                            <thead class="back-color">
                                <tr>
                                    <th>SN</th>
                                    <th>Details</th>
                                    <th>Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>No of loan applications received </td>
                                    <td><?php echo e($credithistory[0]->applications_received_for_loans != ''? $credithistory[0]->applications_received_for_loans: 0); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>No of loan applications approved</td>
                                    <td><?php echo e((int) $credithistory[0]->no_of_loans_approved); ?></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Pending loan applications</td>
                                    <td><?php echo e((int) $credithistory[0]->pending_loan_applications); ?></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>No of Loans Approved within 15 days</td>
                                    <td><?php echo e((int) $credithistory[0]->no_of_loans_approved_within_15_days); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>No of loans approved within 16 to 30 days</td>
                                    <td><?php echo e((int) $credithistory[0]->no_of_loans_sanctioned_within_15_days); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>No of loans approved in more than 30 days</td>
                                    <td><?php echo e((int) $credithistory[0]->no_of_loans_sanctioned_between_1_3_months); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Cumulative Loan Amount at Federation</h5>
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
                                    <td>Federation</td>
                                    <td><?php echo e((int) $credithistory[0]->cumulative_amount_federation_loan); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Bank</td>
                                    <td><?php echo e((int) $credithistory[0]->cumulative_amount_bank_loan); ?></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>VI</td>
                                    <td><?php echo e((int) $credithistory[0]->cumulative_amount_vi_loan); ?></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Other</td>
                                    <td><?php echo e((int) $credithistory[0]->cumulative_amount_other_loan); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Total</td>
                                    <td><?php echo e((int) $credithistory[0]->cumulative_amount); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>No of Members Not received even a single loan from during last 3 years</h5>
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
                                    <th>Federation Loan</th>
                                    <td>Poorest</td>
                                    <td>Poor</td>
                                    <td>Medium Poor</td>
                                    <td>Rich</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Last 12 months</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_federation_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_federation_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_federation_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_federation_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_federation_loan_year1); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td>Year before last</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_federation_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_federation_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_federation_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_federation_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_federation_loan_year2); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td>2 Years before last</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_federation_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_federation_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_federation_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_federation_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_federation_loan_year3); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td rowspan="4">B</td>
                                    <th>Bank loan</th>
                                    <td>----</td>
                                    <td>----</td>
                                    <td>----</td>
                                    <td>----</td>
                                    <td>----</td>
                                </tr>
                                <tr>
                                    <td>Last 12 months</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_bank_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_bank_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_bank_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_bank_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_bank_loan_year1); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td>Year before last</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_bank_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_bank_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_bank_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_bank_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_bank_loan_year2); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td>2 Years before last</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_bank_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_bank_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_bank_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_bank_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_bank_loan_year3); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td rowspan="4">C</td>
                                    <th>VI Loan</th>
                                    <td>----</td>
                                    <td>----</td>
                                    <td>----</td>
                                    <td>----</td>
                                    <td>----</td>
                                </tr>
                                <tr>
                                    <td>Last 12 months</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_VI_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_VI_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_VI_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_VI_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_VI_loan_year1); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td>Year before last</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_VI_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_VI_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_VI_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_VI_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_VI_loan_year2); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td>2 Years before last</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_VI_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_VI_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_VI_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_VI_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_VI_loan_year3); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td rowspan="4">D</td>
                                    <th>Other Loans</th>
                                    <td>----</td>
                                    <td>----</td>
                                    <td>----</td>
                                    <td>----</td>
                                    <td>----</td>
                                </tr>
                                <tr>
                                    <td>Last 12 months</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_other_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_other_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_other_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_other_loan_year1); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_other_loan_year1); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td>Year before last</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_other_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_other_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_other_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_other_loan_year2); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_other_loan_year2); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td>2 Years before last</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poorest_members_not_received_other_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_poor_members_not_received_other_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_medium_members_not_received_other_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_rich_members_not_received_other_loan_year3); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->federation_total_members_not_received_other_loan_year3); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>How many members have taken more than one loan during last 3 years</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>How many members have taken
                                                more than one loan during last 3 years</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e((int) $credithistory[0]->members_have_taken_more_than_one_loan); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Loan Repayment Performance of SHG Members</h5>
                        </div>
                        <table class="table mytable table-responsive">
                            <thead class="back-color">
                                <tr>
                                    <th>SN.</th>
                                    <th>DCB</th>
                                    <th>Federation Loans (A)</th>
                                    <th>Bank Loans (B)</th>
                                    <th>VI Loan (C)</th>
                                    <th>Other Loans (D)</th>
                                    <th>Summary Loan Portfolio (E)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>i.</td>
                                    <td>No of Active loans</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_loan_active); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->bank_loan_active); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->vi_loan_active); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->other_loan_active); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->federation_loan_active +(int) $credithistory[0]->bank_loan_active +(int) $credithistory[0]->vi_loan_active +(int) $credithistory[0]->other_loan_active); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>ii.</td>
                                    <td>Total Loan Amount Given (Rs.)</td>
                                    <td><?php echo e((int) $credithistory[0]->federation_loan_amount); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->bank_loan_amount); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->vi_loan_amount); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->other_loan_amount); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->federation_loan_amount +(int) $credithistory[0]->bank_loan_amount +(int) $credithistory[0]->vi_loan_amount +(int) $credithistory[0]->other_loan_amount); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>iii.</td>
                                    <td>Total Demand upto last month for active loans</td>
                                    <td><?php echo e((int) $credithistory[0]->dcb_federation); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->dcb_bank); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->dcb_vi); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->dcb_other); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->dcb_federation +(int) $credithistory[0]->dcb_bank +(int) $credithistory[0]->dcb_vi +(int) $credithistory[0]->dcb_other); ?>

                                    </td>

                                </tr>
                                <tr>
                                    <td>iv.</td>
                                    <td>Actual Amount Paid upto last month </td>
                                    <td><?php echo e((int) $credithistory[0]->repaid_federation); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->repaid_bank); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->repaid_vi); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->repaid_other); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->repaid_federation +(int) $credithistory[0]->repaid_bank +(int) $credithistory[0]->repaid_vi +(int) $credithistory[0]->repaid_other); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>v.</td>
                                    <td>Overdue Amount</td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_amount_federation); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_amount_bank); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_amount_vi); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_amount_other); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_amount_federation +(int) $credithistory[0]->overdue_amount_bank +(int) $credithistory[0]->overdue_amount_vi +(int) $credithistory[0]->overdue_amount_other); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>vi.</td>
                                    <td>Outstanding amount for active loans</td>
                                    <td><?php echo e((int) $credithistory[0]->loan_outstanding_federation); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->loan_outstanding_bank); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->loan_outstanding_vi); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->loan_outstanding_other); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->loan_outstanding_federation +(int) $credithistory[0]->loan_outstanding_bank +(int) $credithistory[0]->loan_outstanding_vi +(int) $credithistory[0]->loan_outstanding_other); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>vii.</td>
                                    <td>Repayment Ratio %</td>
                                    <td><?php echo e(Checkper((float) $credithistory[0]->repayment_rate_federation_loans) . '%'); ?>

                                    </td>
                                    <td><?php echo e(Checkper((float) $credithistory[0]->repayment_rate_bank_loans) . '%'); ?>

                                    </td>
                                    <td><?php echo e(Checkper((float) $credithistory[0]->repayment_rate_vi_loans) . '%'); ?>

                                    </td>
                                    <td><?php echo e(Checkper((float) $credithistory[0]->repayment_rate_other_loans) . '%'); ?>

                                    </td>
                                    <?php
                                    $num = 0;
                                    $e = 0;
                                    if (!empty($credithistory[0]->repayment_rate_federation_loans)) {
                                    $num = $num + 1;
                                    $a = (float) str_replace('%', '', $credithistory[0]->repayment_rate_federation_loans);
                                    } else {
                                    $a = 0;
                                    }
                                    if (!empty($credithistory[0]->repayment_rate_bank_loans)) {
                                    $num = $num + 1;
                                    $b = (float) str_replace('%', '', $credithistory[0]->repayment_rate_bank_loans);
                                    } else {
                                    $b = 0;
                                    }
                                    if (!empty($credithistory[0]->repayment_rate_vi_loans)) {
                                    $num = $num + 1;
                                    $c = (float) str_replace('%', '', $credithistory[0]->repayment_rate_vi_loans);
                                    } else {
                                    $c = 0;
                                    }
                                    if (!empty($credithistory[0]->repayment_rate_other_loans)) {
                                    $num = $num + 1;
                                    $d = (float) str_replace('%', '', $credithistory[0]->repayment_rate_other_loans);
                                    } else {
                                    $d = 0;
                                    }
                                    if ($num != 0) {
                                    $data = ($a + $b + $c + $d) / $num;
                                    $e = number_format((float) $data, 2, '.', '');
                                    }
                                    ?>
                                    <td><?php echo e($e . '%'); ?></td>
                                    
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
                                    <td>Federation loans</td>
                                    <td><?php echo e((int) $credithistory[0]->loan_default_federation_members); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->default_federation_no_of_loans); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Bank Loans</td>
                                    <td><?php echo e((int) $credithistory[0]->loan_default_bank_members); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->default_bank_no_of_loans); ?></td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>VI Loans</td>
                                    <td><?php echo e((int) $credithistory[0]->loan_default_vi_members); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->default_vi_no_of_loans); ?></td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>Other Loans</td>
                                    <td><?php echo e((int) $credithistory[0]->loan_default_other_members); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->default_other_no_of_loans); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Total</td>
                                    <td><?php echo e((!empty($credithistory[0]->loan_default_federation_members)? $credithistory[0]->loan_default_federation_members: '0') +(!empty($credithistory[0]->loan_default_bank_members) ? $credithistory[0]->loan_default_bank_members : '0') +(!empty($credithistory[0]->loan_default_vi_members) ? $credithistory[0]->loan_default_vi_members : '0') +(!empty($credithistory[0]->loan_default_other_members) ? $credithistory[0]->loan_default_other_members : '0')); ?>

                                    </td>
                                    <td><?php echo e((!empty($credithistory[0]->default_federation_no_of_loans)? $credithistory[0]->default_federation_no_of_loans: '0') +(!empty($credithistory[0]->default_bank_no_of_loans) ? $credithistory[0]->default_bank_no_of_loans : '0') +(!empty($credithistory[0]->default_vi_no_of_loans) ? $credithistory[0]->default_vi_no_of_loans : '0') +(!empty($credithistory[0]->default_other_no_of_loans) ? $credithistory[0]->default_other_no_of_loans : '0')); ?>

                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Portfolio at Risk (PAR) Amount details</h5>
                        </div>
                        <table class="table mytable table-responsive">
                            <thead class="back-color">
                                <tr>
                                    <th>SN.</th>
                                    <th>Institution</th>
                                    <th>Defaulted loans for 30 days (Rs)</th>
                                    <th>Defaulted loans for 60 days (Rs)</th>
                                    <th>Defaulted loans for more than 90 days (Rs)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>Federation loans</td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_1_months_Federation); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_2_months_Federation); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_3_months_Federation); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Bank Loans</td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_1_months_Bank); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_2_months_Bank); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_3_months_Bank); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>VI Loans</td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_1_months_VI); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_2_months_VI); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_3_months_VI); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>Other Loans</td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_1_months_other); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_2_months_other); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->overdue_More_than_3_months_other); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>PAR Status %</h5>
                        </div>
                        <table class="table mytable table-responsive">
                            <thead class="back-color">
                                <tr>
                                    <th>SN.</th>
                                    <th>Institution</th>
                                    <th>Defaulted loans for 30 days (%)</th>
                                    <th>Defaulted loans for 60 days (%)</th>
                                    <th>Defaulted loans for more than 90 days (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>Federation loans</td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_30_days_Federation)); ?>

                                    </td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_60_days_Federation)); ?>

                                    </td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_90_days_Federation)); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Bank Loans</td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_30_days_Bank)); ?>

                                    </td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_60_days_Bank)); ?>

                                    </td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_90_days_Bank)); ?>

                                    </td>

                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>VI Loans</td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_30_days_VI)); ?>

                                    </td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_60_days_VI)); ?>

                                    </td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_90_days_VI)); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>Other Loans</td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_30_days_other)); ?>

                                    </td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_60_days_other)); ?>

                                    </td>
                                    <td><?php echo e(Checkper($credithistory[0]->percentage_More_than_90_days_other)); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Does Federation have a loan tracking system</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>loan tracking system</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($credithistory[0]->does_Federation_loan_tracking_system != ''? $credithistory[0]->does_Federation_loan_tracking_system: 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <?php if($credithistory[0]->does_Federation_loan_tracking_system == 'Yes'): ?>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>When was it established
                                                (Date)</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($credithistory[0]->when_was_it_established != ''? change_date_month_name_char(str_replace('/', '-', $credithistory[0]->when_was_it_established)): 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>What is the frequency of
                                                loan
                                                tracking</strong></div>
                                        <div class="col-6">
                                            <?php echo e($credithistory[0]->frequency_of_loan_tracking); ?>

                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
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
                                    <th class="table_th" colspan="2">All loans (Cluster and External)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>No of loans</th>
                                    <th>Amount (Rs)</th>
                                </tr>
                                <tr>
                                    <td>A</td>
                                    <td>Productive</td>
                                    <td><?php echo e((int) $credithistory[0]->productive); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->productive_amount); ?></td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Consumption</td>
                                    <td><?php echo e((int) $credithistory[0]->consumption); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->consumption_amount); ?></td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>Debt Swapping</td>
                                    <td><?php echo e((int) $credithistory[0]->debt_swapping); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->debt_swapping_amount); ?></td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>Education</td>
                                    <td><?php echo e((int) $credithistory[0]->education); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->education_amount); ?></td>
                                </tr>
                                <tr>
                                    <td>E</td>
                                    <td>Health</td>
                                    <td><?php echo e((int) $credithistory[0]->health); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->health_amount); ?></td>
                                </tr>
                                <tr>
                                    <td>F</td>
                                    <td>Other</td>
                                    <td><?php echo e((int) $credithistory[0]->Other); ?></td>
                                    <td><?php echo e((int) $credithistory[0]->Other_amount); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Total</td>
                                    <td><?php echo e((int) $credithistory[0]->productive +(int) $credithistory[0]->consumption +(int) $credithistory[0]->debt_swapping +(int) $credithistory[0]->education +(int) $credithistory[0]->health +(int) $credithistory[0]->Other); ?>

                                    </td>
                                    <td><?php echo e((int) $credithistory[0]->productive_amount +(int) $credithistory[0]->consumption_amount +(int) $credithistory[0]->debt_swapping_amount +(int) $credithistory[0]->education_amount +(int) $credithistory[0]->health_amount +(int) $credithistory[0]->Other_amount); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Average Loan amount and No during last 12 months</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Average no of loans</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e(checkzero($credithistory[0]->average_loan)); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Average Loan amount</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e(checkzero($credithistory[0]->average_loan_amount)); ?>

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
                                            <?php echo e(checkzero($credithistory[0]->maximum_amount)); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Minimum Amount</strong></div>
                                        <div class="col-6">
                                            <?php echo e(checkzero($credithistory[0]->minimum_amount)); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Interest Rate Details</h5>
                        </div>
                        <table class="table mytable">
                            <thead class="back-color">
                                <tr>
                                    <th>SN.</th>
                                    <th>Insitution</th>
                                    <th>Type (declining, flat)</th>
                                    <th>% charged</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>Federation</td>
                                    <td><?php echo e(checkna($credithistory[0]->declining_or_flat)); ?></td>
                                    <td><?php echo e(checkzero($credithistory[0]->percent_charged)); ?></td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Bank</td>
                                    <td><?php echo e(checkna($credithistory[0]->declining_or_flat_bank)); ?></td>
                                    <td><?php echo e(checkzero($credithistory[0]->percent_charged_bank)); ?></td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>VI</td>
                                    <td><?php echo e(checkna($credithistory[0]->declining_or_flat_vi)); ?></td>
                                    <td><?php echo e(checkzero($credithistory[0]->percent_charged_vi)); ?></td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>Other</td>
                                    <td><?php echo e(checkna($credithistory[0]->declining_or_flat_other)); ?></td>
                                    <td><?php echo e(checkzero($credithistory[0]->percent_charged_other)); ?></td>
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
                                    <th>SN.</th>
                                    <th>Type of Loans</th>
                                    <th>Income Generated Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>Federation</td>
                                    <td><?php echo e((int) $credithistory[0]->cumulative_interest_federation_loans); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Bank</td>
                                    <td><?php echo e((int) $credithistory[0]->cumulative_interest_bank_loans); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>VI</td>
                                    <td><?php echo e((int) $credithistory[0]->cumulative_interest_vi_loans); ?></td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>Other Loans</td>
                                    <td><?php echo e((int) $credithistory[0]->cumulative_interest_other_loans); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Total</td>
                                    <td><?php echo e((int) $credithistory[0]->cumulative_interest_federation_loans +(int) $credithistory[0]->cumulative_interest_bank_loans +(int) $credithistory[0]->cumulative_interest_vi_loans +(int) $credithistory[0]->cumulative_interest_other_loans); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Action Taken During last 12 months to Address Loan Default</h5>
                        </div>
                        <table class="table mytable">
                            <thead class="back-color">
                                <tr>
                                    <th>SN.</th>
                                    <th>Describe Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($credithistory[0]->actions_previous_year_defaults_a != ''): ?>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo e($credithistory[0]->actions_previous_year_defaults_a); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($credithistory[0]->actions_previous_year_defaults_b != ''): ?>
                                <tr>
                                    <td>2</td>
                                    <td><?php echo e($credithistory[0]->actions_previous_year_defaults_b); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($credithistory[0]->actions_previous_year_defaults_c != ''): ?>
                                <tr>
                                    <td>3</td>
                                    <td><?php echo e($credithistory[0]->actions_previous_year_defaults_c); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($credithistory[0]->actions_previous_year_defaults_d != ''): ?>
                                <tr>
                                    <td>4</td>
                                    <td><?php echo e($credithistory[0]->actions_previous_year_defaults_d); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($credithistory[0]->actions_previous_year_defaults_e != ''): ?>
                                <tr>
                                    <td>5</td>
                                    <td><?php echo e($credithistory[0]->actions_previous_year_defaults_e); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Rotation of Funds in the Federation and VI (velocity)</h5>
                        </div>
                        <table class="table mytable">
                            <thead class="back-color">
                                <tr>
                                    <th>SN.</th>
                                    <th>Heading</th>
                                    <th>Federation</th>
                                    <th>VI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>Total corpus funds received (RS)</td>
                                    <td><?php echo e(checkzero($credithistory[0]->Total_corpus_fund_received)); ?>

                                    </td>
                                    <td><?php echo e(checkzero($credithistory[0]->Total_corpus_fund_received_vi)); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Total federation loan disbursed (Rs)</td>
                                    <td><?php echo e(checkzero($credithistory[0]->Total_loan_given)); ?></td>
                                    <td><?php echo e(checkzero($credithistory[0]->Total_loan_given_vi)); ?></td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>No of years completed since receipt of funds (#)</td>
                                    <td><?php echo e(checkzero($credithistory[0]->completed_received_corpus_fund)); ?>

                                    </td>
                                    <td><?php echo e(checkzero($credithistory[0]->completed_received_corpus_fund_vi)); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>Yearly rotation Ratio</td>
                                    <td><?php echo e(checkzero($credithistory[0]->Yearly_rotation_ratio)); ?></td>
                                    <td><?php echo e(checkzero($credithistory[0]->Yearly_rotation_ratio_vi)); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!----tab-6----->
                <div class="tab-pane fade" id="v-pills-sustainability" role="tabpane" aria-labelledby="v-pills-sustainability-tab">
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Sustainability</h5>

                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Income and Expenditure during last 12 Months</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Total Income</strong></div>
                                        <div class="col-6">
                                            <?php echo e(checkzero($sustainability[0]->total_income_of_the_federation)); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Total Expenses</strong></div>
                                        <div class="col-6">
                                            <?php echo e(checkzero($sustainability[0]->expense_of_the_federation)); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Coverage of Operational costs
                                                (Y/N)</strong></div>
                                        <div class="col-6">
                                            <?php echo e(checkzero($sustainability[0]->federation_covering_operational_cost)); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Loan Security Fund (LSF) </h5>
                        </div>
                        <table class="table mytable">
                            <thead class="back-color">

                                <div class="card-box">
                                    <div class="row alldetail">
                                        <div class="col-md-6 table-padd">
                                            <div class="row detail">
                                                <div class="col-6"><strong>Loan Security Fund (LSF)</strong></div>
                                                <div class="col-6">
                                                    <?php echo e(checkna($sustainability[0]->have_loan_security_fund)); ?>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </thead>
                            <tbody>
                                <?php if($sustainability[0]->have_loan_security_fund == 'Yes'): ?>
                                <tr>
                                    <td>A</td>
                                    <td>Whether LSF is in operation</td>
                                    <td><?php echo e($sustainability[0]->have_loan_security_fund); ?></td>
                                </tr>

                                <tr>
                                    <td>B</td>
                                    <td>Date established/Verified</td>
                                    <td><?php echo e($sustainability[0]->date_it_was_established !='' ? change_date_month_name_char(str_replace('/', '-', $sustainability[0]->date_it_was_established )) : 'N/A'); ?></td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>No of members contribute to LSF</td>
                                    <td><?php echo e($sustainability[0]->members_contribute_LSF); ?></td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>Amount available in LSF</td>
                                    <td><?php echo e($sustainability[0]->amount_available_security_fund); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>E</td>
                                    <td>No of members benefitted from LSF</td>
                                    <td><?php echo e($sustainability[0]->members_benefited_by_LSF); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if($sustainability[0]->have_loan_security_fund == 'No'): ?>
                                <tr>
                                    <td></td>
                                    <td>Reason member do not contribute</td>
                                    <td><?php echo e($sustainability[0]->reason_members_do_not_contribute); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Savings of Member SHGs</h5>
                        </div>
                        <table class="table mytable">
                            <thead class="back-color">
                                <tr>
                                    <th>SN.</th>
                                    <th>Details</th>
                                    <th>Compulsory savings</th>
                                    <th>Voluntary savings</th>
                                    <th>Other savings</th>
                                    <th>Total savings</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>i.</td>
                                    <td>Cumulative savings of all SHGs upto date</td>
                                    <td><?php echo e($sustainability[0]->cumulative_savings_compulsory != ''? $sustainability[0]->cumulative_savings_compulsory: 0); ?>

                                    </td>
                                    <td><?php echo e($sustainability[0]->cumulative_savings_voluntary != ''? $sustainability[0]->cumulative_savings_voluntary: 0); ?>

                                    </td>
                                    <td><?php echo e($sustainability[0]->cumulative_savings_other != '' ? $sustainability[0]->cumulative_savings_other : 0); ?>

                                    </td>
                                    <td><?php echo e((int) $sustainability[0]->cumulative_savings_compulsory +(int) $sustainability[0]->cumulative_savings_voluntary +(int) $sustainability[0]->cumulative_savings_other); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>ii.</td>
                                    <td>Amount saved during last 12 months</td>
                                    <td><?php echo e($sustainability[0]->amount_saved_compulsory != '' ? $sustainability[0]->amount_saved_compulsory : 0); ?>

                                    </td>
                                    <td><?php echo e(checkzero($sustainability[0]->amount_saved_voluntary)); ?></td>
                                    <td><?php echo e(checkzero($sustainability[0]->amount_saved_other)); ?></td>
                                    <td><?php echo e((int) $sustainability[0]->amount_saved_compulsory +(int) $sustainability[0]->amount_saved_voluntary +(int) $sustainability[0]->amount_saved_other); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Other services Provided by Federation
                            </h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Other services Provided by
                                                Federation</strong></div>
                                        <div class="col-6">
                                            <?php echo e($sustainability[0]->provide_any_other_Service != '' ? $sustainability[0]->provide_any_other_Service : 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if($sustainability[0]->provide_any_other_Service == 'Yes'): ?>
                        <table class="table mytable">
                            <thead class="back-color">
                                <tr>
                                    <th>SN.</th>
                                    <th>Name of the Service</th>
                                    <th>Date Established</th>
                                    <th>No of Members benefit from the service</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                <?php if(!empty($sustainability_service)): ?>
                                <?php $__currentLoopData = $sustainability_service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($i++); ?></td>
                                    <td><?php echo e($row->service_name); ?></td>
                                    <td><?php echo e($row->date != '' ? change_date_month_name_char(str_replace('/', '-', $row->date)) : 'N/A'); ?>

                                    </td>
                                    <td><?php echo e($row->members); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
                <!----tab-7----->
                <div class="tab-pane fade" id="v-pills-Risk-Mitigation" role="tabpane" aria-labelledby="v-pills-Risk-Mitigation-tab">
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Risk Mitigation</h5>

                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Total Members</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Total Members</strong></div>
                                        <div class="col-6">
                                            <strong><?php echo e($risk_mitigation[0]->total_general_assembly_members != ''? $risk_mitigation[0]->total_general_assembly_members: 0); ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Life Insurance Coverage for total members</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>No of members
                                                covered</strong></div>
                                        <div class="col-6">
                                            <?php echo e((float) $risk_mitigation[0]->members_covered_under_life_insurance != ''? (float) $risk_mitigation[0]->members_covered_under_life_insurance: 0); ?>

                                        </div>
                                    </div>
                                </div>
                                <?php
                                $a = (float) $risk_mitigation[0]->members_covered_under_life_insurance;
                                $b = (float) $risk_mitigation[0]->total_general_assembly_members;
                                $value = 0;
                                $c = 0;
                                if ($risk_mitigation[0]->total_general_assembly_members > 0) {
                                $value = ((float) $risk_mitigation[0]->members_covered_under_life_insurance * 100) / (float) $risk_mitigation[0]->total_general_assembly_members;
                                $c = round($value, 2);
                                }
                                ?>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Coverage (%)</strong></div>
                                        <?php if($risk_mitigation[0]->par_covered_under_life_insurance == 0): ?>
                                        <div class="col-6">

                                            <?php echo e($risk_mitigation[0]->par_covered_under_life_insurance); ?>%
                                        </div>
                                        <?php elseif($risk_mitigation[0]->par_covered_under_life_insurance == ''): ?>
                                        <div class="col-6">

                                            0%
                                        </div>
                                        <?php else: ?>
                                        <div class="col-6">

                                            <?php echo e($risk_mitigation[0]->par_covered_under_life_insurance); ?>

                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Life Insurance Coverage for Active Borrowers during last 3 years</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>No of active
                                                borrowers</strong></div>
                                        <div class="col-6">
                                            <?php echo e($risk_mitigation[0]->availed_members_covered_under_loan_insurance != ''? $risk_mitigation[0]->availed_members_covered_under_loan_insurance: 0); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>No of active borrowers
                                                covered</strong></div>
                                        <div class="col-6">
                                            <?php echo e($risk_mitigation[0]->par_availed_members_covered_under_loan_insurance != ''? $risk_mitigation[0]->par_availed_members_covered_under_loan_insurance: 0); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Coverage (%)</strong></div>
                                        <?php if($risk_mitigation[0]->availed_members_covered_under_loan_insurance > 0 && $risk_mitigation[0]->par_availed_members_covered_under_loan_insurance > 0): ?>
                                        <div class="col-6">
                                            <?php echo e(round(($risk_mitigation[0]->par_availed_members_covered_under_loan_insurance  * 100) /$risk_mitigation[0]->availed_members_covered_under_loan_insurance)); ?>%
                                        </div>
                                        <?php else: ?>
                                        <div class="col-6">0%</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Asset Insurance for Livestock during last 3 years</h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>No of asset/animals
                                                purchased</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($risk_mitigation[0]->animal_purchased_during_last_one_year != ''? $risk_mitigation[0]->animal_purchased_during_last_one_year: 0); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>No of asset/animals
                                                insured</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($risk_mitigation[0]->animal_insured_last_one_year != ''? $risk_mitigation[0]->animal_insured_last_one_year: 0); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Coverage (%)</strong></div>
                                        <?php if($risk_mitigation[0]->animal_purchased_during_last_one_year > 0): ?>
                                        <div class="col-6">
                                            <?php echo e(round(($risk_mitigation[0]->animal_insured_last_one_year * 100) /$risk_mitigation[0]->animal_purchased_during_last_one_year)); ?>%
                                        </div>
                                        <?php else: ?>
                                        <div class="col-6">0%</div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-box mt-3">
                        <div class="w-heading d-flex">
                            <h5>Benefits Claimed under Life Insurance </h5>
                        </div>
                        <div class="card-box">
                            <div class="row alldetail">
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>No of claims
                                                submitted</strong></div>
                                        <div class="col-6">
                                            <?php echo e($risk_mitigation[0]->No_of_claim_received != '' ? $risk_mitigation[0]->No_of_claim_received : 0); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Total Claim amount
                                                (Rs)</strong></div>
                                        <div class="col-6">
                                            <?php echo e($risk_mitigation[0]->Total_claim_amount_requested != ''? $risk_mitigation[0]->Total_claim_amount_requested: 0); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Total No of claims
                                                settled</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($risk_mitigation[0]->No_of_person_claim_setteled != ''? $risk_mitigation[0]->No_of_person_claim_setteled: 0); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Total Claim amount
                                                settled</strong>
                                        </div>
                                        <div class="col-6">
                                            <?php echo e($risk_mitigation[0]->Total_claim_amount_setteled != ''? $risk_mitigation[0]->Total_claim_amount_setteled: 0); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Settlement done (in No)</strong>
                                        </div>

                                        <div class="col-6">
                                            <?php echo e(checkZero($risk_mitigation[0]->settlement_claimed_insurance_no)); ?>

                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-6 table-padd">
                                    <div class="row detail">
                                        <div class="col-6"><strong>Settlement done (in %)</strong>
                                        </div>

                                        <div class="col-6">
                                            <?php echo e($risk_mitigation[0]->settlement_claimed_insurance_per !='' ? $risk_mitigation[0]->settlement_claimed_insurance_per : '0%'); ?>

                                        </div>


                                    </div>
                                </div>
                                
                </div>
            </div>
        </div>
        <div class="family-box mt-3">
            <div class="w-heading d-flex">
                <h5>Benefits Claimed under Livestock during last 12 months</h5>
            </div>
            <div class="card-box">
                <div class="row alldetail">
                    <div class="col-md-6 table-padd">
                        <div class="row detail">
                            <div class="col-6"><strong>No of animal death claims
                                    submitted</strong></div>
                            <div class="col-6">
                                <?php echo e((int) $risk_mitigation[0]->death_claim_requested); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 table-padd">
                        <div class="row detail">
                            <div class="col-6"><strong>Total amount of Claims
                                    submitted
                                    (Rs)</strong></div>
                            <div class="col-6">
                                <?php echo e((int) $risk_mitigation[0]->Total_claim_amount_requested_animal_death); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 table-padd">
                        <div class="row detail">
                            <div class="col-6"><strong>Total No of claims
                                    settled</strong>
                            </div>
                            <div class="col-6">
                                <?php echo e((int) $risk_mitigation[0]->animal_claim_setteled); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 table-padd">
                        <div class="row detail">
                            <div class="col-6"><strong>Total Claim amount
                                    settled</strong>
                            </div>
                            <div class="col-6">
                                <?php echo e((int) $risk_mitigation[0]->Total_claim_amount_setteled_for_animal_death); ?>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 table-padd">
                        <div class="row detail">
                            <div class="col-6"><strong>Settlement done (in No)</strong>
                            </div>


                            <div class="col-6">
                                <?php echo e($risk_mitigation[0]->settlement_asset_insurance_no !='' ? $risk_mitigation[0]->settlement_asset_insurance_no : 0); ?>

                            </div>


                        </div>
                    </div>
                    <div class="col-md-6 table-padd">
                        <div class="row detail">
                            <div class="col-6"><strong>Settlement done (in %)</strong>
                            </div>

                            <div class="col-6">

                                <?php echo e($risk_mitigation[0]->settlement_asset_insurance_per !='' ? $risk_mitigation[0]->settlement_asset_insurance_per : '0%'); ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----tab-8----->
    <div class="tab-pane fade" id="v-pills-analysis" role="tabpane" aria-labelledby="v-pills-analysis-tab">
        <div class="family-box mt-3">
            <div class="w-heading d-flex">
                <h5>Analysis</h5>

            </div>
        </div>
        <div class="family-box mt-3">
            <div class="w-heading d-flex">
                <h5>Savings of Member SHGs</h5>
            </div>
            <table class="table mytable table-responsive">
                <thead class="back-color">
                    <tr>
                        <th>SN.</th>
                        <th>Objective</th>
                        <th>Indicators</th>
                        <th>Total Score per objective</th>
                        <th>Score Obtained</th>
                        <th>Risk Level (green, yellow, grey or red)</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>A.</td>
                        <td colspan="2">Governance</td>
                        <td>30</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td></td>
                        <td>Rotation of Board members </td>
                        <td>4</td>
                        <td><?php echo e($analysis_1); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show1); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td></td>
                        <td>Average meeting attendance during last 12 months</td>
                        <td>5</td>
                        <td><?php echo e($analysis_2); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show2); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td></td>
                        <td>Federation books Updated (all books)</td>
                        <td>8</td>
                        <td><?php echo e($analysis_3); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show3); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td></td>
                        <td>Annual Plan and budget approved by General Assembly</td>
                        <td>3</td>
                        <td><?php echo e($analysis_4); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show4); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td></td>
                        <td>Achievement of last year annual plan</td>
                        <td>2</td>
                        <td><?php echo e($analysis_5); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show5); ?> '></div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>6</td>
                        <td></td>
                        <td>% of defunct SHGs</td>
                        <td>3</td>
                        <td><?php echo e($analysis_7); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show7); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td></td>
                        <td>Last year External audit carried out</td>
                        <td>5</td>
                        <td><?php echo e($analysis_8); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show8); ?> '></div>
                        </td>
                    </tr>

                    <tr>
                        <td>B.</td>
                        <td colspan="2">Inclusion</td>
                        <td>15</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td></td>
                        <td>Coverage of target mobilized</td>
                        <td>5</td>
                        <td><?php echo e($analysis_9); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show9); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td></td>
                        <td>Poorest benefitting from all federation and external loans</td>
                        <td>5</td>
                        <td><?php echo e($analysis_10); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show10); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td></td>
                        <td>Poorest/poor in leadership position</td>
                        <td>5</td>
                        <td><?php echo e($analysis_11); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show11); ?> '></div>
                        </td>
                    </tr>

                    <tr>
                        <td>C.</td>
                        <td colspan="2">Efficiency</td>
                        <td>15</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td></td>
                        <td>Time taken to approve loan</td>
                        <td>4</td>
                        <td><?php echo e($analysis_12); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show12); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td></td>
                        <td>Cost per active client</td>
                        <td>3</td>
                        <td><?php echo e($analysis_13); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show13); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>13</td>
                        <td></td>
                        <td>Time taken to disburse loan to the member - from approval to cash in hand</td>
                        <td>3</td>
                        <td><?php echo e($analysis_26); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show25); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>14</td>
                        <td></td>
                        <td>Operating expense Ratio</td>
                        <td>5</td>
                        <td><?php echo e($analysis_14); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show14); ?> '></div>
                        </td>
                    </tr>

                    <tr>
                        <td>D.</td>
                        <td colspan="2">Credit History</td>
                        <td>25</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>15</td>
                        <td></td>
                        <td>Members benefitted from Federation and External loans</td>
                        <td>5</td>
                        <td><?php echo e($analysis_15); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show15); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>16</td>
                        <td></td>
                        
                        <td>Repayment rate of all loans (federation/bank/VI &others) during during last 12 months</td>
                        <td>10</td>
                        <td><?php echo e($analysis_16); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show16); ?> '></div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>17</td>
                        <td></td>
                        <td>Federation Loan PAR status – 90 days</td>
                        <td>5</td>
                        <td><?php echo e($analysis_18); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show18); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>18</td>
                        <td></td>
                        <td> % of productive loans (from all loans) during last 12 months</td>
                        <td>3</td>
                        <td><?php echo e($analysis_19); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show19); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>19</td>
                        <td></td>
                        <td>Yearly rotation of funds in Federation</td>
                        <td>2</td>
                        <td><?php echo e($analysis_20); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show20); ?> '></div>
                        </td>
                    </tr>

                    <tr>
                        <td>E.</td>
                        <td colspan="2">Sustainability</td>
                        <td>6</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>20</td>
                        <td></td>
                        <td>Does federation cover its costs</td>
                        <td>3</td>
                        <td><?php echo e($analysis_21); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show21); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>21</td>
                        <td></td>
                        <td>Loan security fund established</td>
                        <td>3</td>
                        <td><?php echo e($analysis_22); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show22); ?> '></div>
                        </td>
                    </tr>

                    <tr>
                        <td>F.</td>
                        <td colspan="2">Risk Mitigation</td>
                        <td>9</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>22</td>
                        <td></td>
                        <td>% of members covered under life insurance</td>
                        <td>3</td>
                        <td><?php echo e($analysis_23); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show23); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>23</td>
                        <td></td>
                        <td>% of active borrowers covered under life insurance</td>
                        <td>3</td>
                        <td><?php echo e($analysis_24); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show24); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td>24</td>
                        <td></td>
                        <td>% of assets/animals insured</td>
                        <td>3</td>
                        <td><?php echo e($analysis_25); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show25); ?> '></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Total</td>
                        <td></td>
                        <td>100</td>
                        <td><?php echo e($analysis_final_total); ?></td>
                        <td>
                            <div class='status_analysis <?php echo e($show_final_total); ?> '></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!----tab-9----->
    <div class="tab-pane fade" id="v-pills-challenges" role="tabpane" aria-labelledby="v-pills-challenges-tab">
        <div class="family-box mt-3">
            <div class="w-heading d-flex">
                <h5>Challenges</h5>

            </div>
        </div>
        <div class="family-box mt-3">

            <table class="table mytable">
                <thead class="back-color">
                    <tr>
                        <th>SN.</th>
                        <th>Top Challenges</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    <?php if(count($challenges) > 0): ?>

                    <?php $__currentLoopData = $challenges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($i++); ?></td>
                        <td><?php echo e($row->challenge); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
    <!----tab-10----->
    <div class="tab-pane fade" id="v-pills-action" role="tabpane" aria-labelledby="v-pills-action-tab">
        <div class="family-box mt-3">
            <div class="w-heading d-flex">
                <h5>Action Plan to address challenges</h5>

            </div>
            <table class="table mytable">
                <thead class="back-color">
                    <tr>
                        <th>SN.</th>
                        <th>Action Plan</th>
                        <?php if(!empty($challenges)): ?>
                        <?php $__currentLoopData = $challenges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e($row->challenge); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($challenges_action)): ?>
                    <?php $__currentLoopData = $challenges_action; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td><?php echo e($row['name']); ?></td>
                        <?php if(!empty($row['action'])): ?>
                        <?php $__currentLoopData = $row['action']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td><?php echo e($val != '' ? $val : 'N/A'); ?></td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!----tab-11----->
    <div class="tab-pane fade" id="v-pills-observations" role="tabpane" aria-labelledby="v-pills-observations-tab">
        <div class="family-box mt-3">
            <div class="w-heading d-flex">
                <h5>Observations</h5>

            </div>
            <table class="table mytable">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Questions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1A.</td>
                        <td><b>How many members attended the cluster meeting?</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationMeeting)); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>1B.</td>
                        <td><b>Were all office bearers and leaders present? E.g President,
                                treasurer, secretary, book-keeper, other,</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <?php
                        $desg = [];
                        if ($observation[0]->federation_observation_president == 1) {
                        $desg[] = 'President';
                        }
                        if ($observation[0]->federation_observation_bookkeeper == 1) {
                        $desg[] = 'Book-Keeper';
                        }
                        if ($observation[0]->federation_observation_secretary == 1) {
                        $desg[] = 'Secretary';
                        }
                        if ($observation[0]->federation_observation_treasure == 1) {
                        $desg[] = 'Treasurer';
                        }
                        if ($observation[0]->federation_observation_sub_commit == 1) {
                        $desg[] = 'Sub-Commitee Members';
                        }
                        if ($observation[0]->federation_observation_other == 1) {
                        $desg[] = 'Other';
                        }
                        $strdesg = implode(',', $desg);
                        ?>
                        <td><?php echo e(checkna($strdesg)); ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><b>Did Federation leaders understand the Purpose of the meeting?
                                Explain</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationCarriedOut)); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><b>What was quality of Discussion? Did everyone participate?</b>
                        </td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationLeadersOnly)); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><b>Where Federation leaders aware of their rules and norms?</b></td>
                    </tr>
                    <tr>
                        <td>A.</td>
                        <td><b>Did they understand vision of their Federation?</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationNormsHave)); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>B.</td>
                        <td><b>Do they understand benefits of being part of the Federation?</b>
                        </td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        
                        <td>NA</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td><b>Important practices followed by the Federation.</b></td>
                    </tr>
                    <tr>
                        <td>A.</td>
                        <td><b>Do they have a set of important practices for repayment and
                                savings?</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationDefaults)); ?>

                        </td>
                    </tr>

                    <tr>
                        <td>B.</td>
                        <td><b>What are those practices?</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationPractices)); ?>

                        </td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td><b>What is Federation’s policy on the most vulnerable members</b>
                        </td>
                    </tr>
                    <tr>
                        <td>A.</td>
                        <td><b>Does this Cluster include members who are the most poor and
                                vulnerable, and if yes,</b></td>
                    </tr>

                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationProvidedThem)); ?>

                        </td>
                    </tr>

                    <tr>
                        <td>B.</td>
                        <td><b>What is their policy to help them</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federation_observation_policy_explain)); ?>

                        </td>
                    </tr>

                    <tr>
                        <td>7</td>
                        <td><b>Federation’s Reporting and documentation</b></td>
                    </tr>
                    <tr>
                        <td>A.</td>
                        <td><b>Does Federation have a satisfactory/weak or good system of
                                reporting and updating of documents?</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationDocuments)); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>B.</td>
                        <td><b>Any highlights</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federation_observation_any_highlighted)); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>C.</td>
                        <td><b>Who writes these books and minutes of meetings?</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationMinutesMeetings)); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td><b>Federation’s financial information</b></td>
                    </tr>
                    <tr>
                        <td>A.</td>
                        <td><b>Are books of accounts managed by the bookkeeper or others?
                                Explain</b>
                        </td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationUpdatedRecords)); ?>

                        </td>
                    </tr>

                    <tr>
                        <td>B.</td>
                        <td><b>Any highlights</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federation_observation_leaders_office)); ?>

                        </td>
                    </tr>

                    <tr>
                        <td>9</td>
                        <td><b>Impression about Social Audit committee</b></td>
                    </tr>

                    <tr>
                        <td>A.</td>
                        <td><b>Does it work?</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationWork)); ?></td>
                    </tr>

                    <tr>
                        <td>B.</td>
                        <td><b>Are office bearers of SA aware of their roles and reporting
                                system?</b>
                        </td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationReportingSystem)); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td><b>Unique features of this Federation</b></td>
                    </tr>
                    <tr>
                        <td>A.</td>
                        <td><b>Did you notice any unique features and practices that make it
                                special?</b></td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationFederationSpecial)); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>B.</td>
                        <td><b>How do they manage and support their groups and clusters?</b>
                        </td>
                    </tr>
                    <tr>
                        <td>Answer</td>
                        <td><?php echo e(checkna($observation[0]->federationObservationClusterFederations)); ?>

                        </td>
                    </tr>
                    
                    <tr>
                        <td>11</td>
                        <td><b>Summary of important 3- 5 highlights (positive and negative)
                                about this Federation</b></td>
                    </tr>
                    <?php
                    $na = '';
                    ?>
                    <?php if($observation[0]->federationObserHighlightsA != ''): ?>
                    <?php
                    $na = 1;
                    ?>
                    <tr>
                        <td>A.</td>
                        <td><?php echo e(checkna($observation[0]->federationObserHighlightsA)); ?>

                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if($observation[0]->federationObserHighlightsB != ''): ?>
                    <?php
                    $na = 2;
                    ?>
                    <tr>
                        <td>B.</td>
                        <td><?php echo e($observation[0]->federationObserHighlightsB); ?></td>
                    </tr>
                    <?php endif; ?>

                    <?php if($observation[0]->federationObserHighlightsC != ''): ?>
                    <?php
                    $na = 3;
                    ?>
                    <tr>
                        <td>C.</td>
                        <td><?php echo e($observation[0]->federationObserHighlightsC); ?></td>
                    </tr>
                    <?php endif; ?>

                    <?php if($observation[0]->federationObserHighlightsD != ''): ?>
                    <?php
                    $na = 4;
                    ?>
                    <tr>
                        <td>D.</td>
                        <td><?php echo e($observation[0]->federationObserHighlightsD); ?></td>
                    </tr>
                    <?php endif; ?>

                    <?php if($observation[0]->federationObserHighlightsE != ''): ?>
                    <?php
                    $na = 5;
                    ?>
                    <tr>
                        <td>E.</td>
                        <td><?php echo e($observation[0]->federationObserHighlightsE); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if($na == ''): ?>

                    <tr>

                        <td>Answer</td>
                        <td>N/A</td>
                    </tr>
                    <?php endif; ?>

                </tbody>
            </table>

        </div>
    </div>
    <!----tab-12----->
    <div class="tab-pane fade" id="v-pills-Photos-Videos" role="tabpanel" aria-labelledby="v-pills-Photos-Videos-tab">

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
                            <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image_first_year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($image_first_year->imagename != ''): ?>
                            <tr class="text-center">
                                <th><img src="/assets/uploads/<?php echo e($image_first_year->imagename); ?>" height="100" width="100"></th>
                            </tr>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!----report card----->
    <div class="tab-pane fade" id="v-pills-report-card" role="tabpanel" aria-labelledby="v-pills-report-card-tab">

        <div class="family-box">
            <div class="w-heading d-flex">
                <h5>Federation Rating Card</h5>

            </div>
            <div class="card-box">
                <table class="table table-bordered mytable" colspan="2">
                    <thead class="back-color">

                    </thead>
                    <tbody>
                        <tr>
                            <th width="50%">Name</th>
                            <td width="50%"><?php echo e($profile[0]->name_of_federation); ?></td>
                        </tr>
                        <tr>
                            <th width="50%">UIN</th>
                            <td width="50%"><?php echo e($federation->uin); ?></td>
                        </tr>
                        <tr>
                            <th width="50%">State Name</th>
                            <td width="50%"><?php echo e($profile[0]->name_of_state); ?></td>
                        </tr>

                        <tr>
                            <th>District Name</th>
                            <td><?php echo e($profile[0]->name_of_district); ?></td>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <td><?php echo e(change_date_month_name_char(str_replace('/', '-', $federation->created_at))); ?>

                            </td>

                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered mytable" colspan="2">
                    <thead class="back-color">
                        <tr>
                            <th width="35%">Federation Indicators</th>
                            <td colspan="4"></td>
                            <th style="text-align:center;">Actual </th>
                            <th style="text-align:center;">Expected</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1 Governance</td>
                            <td style="background-color: green;width:50px;">
                                <?php if($score >= 90): ?>
                                <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                <?php endif; ?>
                            </td>
                            <td style="background-color: yellow;width:50px;">
                                <?php if($score >= 75 && $score <= 89): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: lightgrey;width:50px;">
                                <?php if($score >= 60 && $score <= 74): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: red;width:50px;">
                                <?php if($score <= 59): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td width="10px" style="text-align: center"><?php echo e($total_1to8); ?>

                            </td>
                            <td width="10px" style="text-align: center">30</td>
                            
                        </tr>
                        <tr>
                            <td>2 Inclusion</td>
                            <td style="background-color: green;width:50px;">
                                <?php if($score1 >= 90): ?>
                                <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                <?php endif; ?>
                            </td>
                            <td style="background-color: yellow;width:50px;">
                                <?php if($score1 >= 75 && $score1 <= 89): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: lightgrey;width:50px;">
                                <?php if($score1 >= 60 && $score1 <= 74): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: red;width:50px;">
                                <?php if($score1 <= 59): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="text-align: center"><?php echo e($total_9to11); ?></td>
                            <td style="text-align: center">15</td>
                            
                        </tr>
                        <tr>
                            <td>3 Efficiency</td>
                            <td style="background-color: green;width:50px;">
                                <?php if($score2 >= 90): ?>
                                <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                <?php endif; ?>
                            </td>
                            <td style="background-color: yellow;width:50px;">
                                <?php if($score2 >= 75 && $score2 <= 89): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: lightgrey;width:50px;">
                                <?php if($score2 >= 60 && $score2 <= 74): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: red;width:50px;">
                                <?php if($score2 <= 59): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="text-align: center"><?php echo e($total_12to14); ?></td>
                            <td style="text-align: center">15</td>
                            
                        </tr>
                        <tr>
                            <td>4 Credit Recovery</td>
                            <td style="background-color: green;width:50px;">
                                <?php if($score3 >= 90): ?>
                                <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                <?php endif; ?>
                            </td>
                            <td style="background-color: yellow;width:50px;">
                                <?php if($score3 >= 75 && $score3 <= 89): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: lightgrey;width:50px;">
                                <?php if($score3 >= 60 && $score3 <= 74): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: red;width:50px;">
                                <?php if($score3 <= 59): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="text-align: center"><?php echo e($total_15to20); ?></td>
                            <td style="text-align: center">25</td>
                            
                        </tr>
                        <tr>
                            <td>5 Sustainability</td>
                            <td style="background-color: green;width:50px;">
                                <?php if($score4 >= 90): ?>
                                <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                <?php endif; ?>
                            </td>
                            <td style="background-color: yellow;width:50px;">
                                <?php if($score4 >= 75 && $score4 <= 89): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: lightgrey;width:50px;">
                                <?php if($score4 >= 60 && $score4 <= 74): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: red;width:50px;">
                                <?php if($score4 <= 59): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="text-align: center"><?php echo e($total_21to22); ?></td>
                            <td style="text-align: center">6</td>
                            
                        </tr>
                        <tr>
                            <td>6 Risk Manegement</td>
                            <td style="background-color: green;width:50px;">
                                <?php if($score5 >= 90): ?>
                                <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                <?php endif; ?>
                            </td>
                            <td style="background-color: yellow;width:50px;">
                                <?php if($score5 >= 75 && $score5 <= 89): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: lightgrey;width:50px;">
                                <?php if($score5 >= 60 && $score5 <= 74): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="background-color: red;width:50px;">
                                <?php if($score5 <= 59): ?> <i class="c-black-500 ti-check" style="font-size:25px;font-weight:bold;"></i>
                                    <?php endif; ?>
                            </td>
                            <td style="text-align: center"><?php echo e($total_23to25); ?></td>
                            <td style="text-align: center">9</td>
                            
                        </tr>

                    </tbody>

                </table>
                <table class="table  mytable">

                    <tr>
                        <th style="width: 35%;">Total Score</th>

                        <td style="background-color: green;text-align:center;font-weight:bold;font-size:20px;width:9.9%;">
                            <?php if($analysis_final_total >= 90): ?>
                            <?php echo e($analysis_final_total); ?>

                            <?php endif; ?>
                        </td>


                        <td style="background-color: yellow;text-align:center;font-weight:bold;font-size:20px;width:9.66%;">
                            <?php if($analysis_final_total >= 75 && $analysis_final_total <= 89): ?> <?php echo e($analysis_final_total); ?> <?php endif; ?> </td>


                        <td style="background-color: lightgrey;text-align:center;font-weight:bold;font-size:20px;width:10%;">
                            <?php if($analysis_final_total >= 60 && $analysis_final_total <= 74): ?> <?php echo e($analysis_final_total); ?> <?php endif; ?> </td>


                        <td style="background-color: red;text-align:center;font-weight:bold;font-size:20px;width:10%;">
                            <?php if($analysis_final_total <= 59): ?> <?php echo e($analysis_final_total); ?> <?php endif; ?> </td>
                        <td colspan="2" style="width:28%;"></td>

                    </tr>


                </table>
            </div>
        </div>
    </div>
    <?php if($u_type == 'M'): ?>
                                    <div class="tab-pane fade" id="v-pills-quality-check" role="tabpanel"
                                        aria-labelledby="v-pills-quality-check-tab">
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>District Manager - Take Action </h5>

                                            </div>
                                            <div class="card-box">
                                                <?php if($quality_status != 'P'): ?>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <div class="col-md-8">
                                                                <label class="form-control-label" for="input-small"
                                                                    style="font-weight: bold;">Quality Action :
                                                                </label>
                                                                <?php if($quality_status == 'V'): ?>
                                                                    <span>Verified</span>
                                                                <?php elseif($quality_status == 'R'): ?>
                                                                    <span>Rejected</span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-control-label" for="input-small"
                                                                    style="font-weight: bold;">Updated at:
                                                                </label>
                                                                <span><?php echo e($quality_date); ?></span>
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
                                                <?php endif; ?>
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
                                                            class="required form-control-label ml-3 mb-2"> Facilitator
                                                        </label>
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
                                                        value="<?php echo e($task_id); ?>">
                                                    <input type="hidden" name="agency_id" id="agency_id"
                                                        value="<?php echo e($agency_id); ?>">
                                                    <input type="hidden" name="facilitator" id="facilitator"
                                                        value="<?php echo e($user_id); ?>">
                                                    <input type="hidden" name="dm_id" id="dm_id"
                                                        value="<?php echo e($dm_id); ?>">
                                                    <input type="hidden" name="task" id="task">
                                                    <?php if($qa_status == 'P' || $quality_status == 'R'): ?>
                                                        <button type="button" id="save"
                                                            class="btn btn-sm btn-success "
                                                            onclick="return submitAction()">Save</button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif($u_type == 'QA'): ?>
                                    <div class="tab-pane fade" id="v-pills-quality-check-qa" role="tabpanel"
                                        aria-labelledby="v-pills-quality-check-tab-qa">
                                        <div class="family-box mt-3">
                                            <div class="w-heading d-flex">
                                                <h5>Quality Check - Take Action </h5>

                                            </div>
                                            <?php if($manager_status == 'Verify'): ?>
                                                <div class="card-box">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <div class="col-md-8">
                                                                <label class="form-control-label" for="input-small"
                                                                    style="font-weight: bold;">Manger Action :
                                                                </label>
                                                                <?php if($qa_status == 'V'): ?>
                                                                    <span>Verified</span>
                                                                <?php elseif($qa_status == 'R'): ?>
                                                                    <span>Rejected</span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-control-label" for="input-small"
                                                                    style="font-weight: bold;">Updated at:
                                                                </label>
                                                                <span><?php echo e($manager_date); ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 mb-3" style="margin-top: -17px;">
                                                            <div class="col-md-12" id="remark_txt11">
                                                                <label for="TaskQaAssignment_remark22" class="required"
                                                                    style="font-weight: bold;">Manager Remark :
                                                                </label>
                                                                <span><?php echo $qa_remark ; ?></span>

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
                                                                    id="TaskQaAssignment_status1" <?php echo e($qa_readonly1); ?>>
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
                                                                    <?php echo e($qa_readonly1); ?>></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8 text-center">
                                                        <input type="hidden" name="task_id" id="task_id1"
                                                            value="<?php echo e($task_id); ?>">
                                                        <input type="hidden" name="agency_id" id="agency_id1"
                                                            value="<?php echo e($agency_id); ?>">
                                                        <input type="hidden" name="facilitator" id="facilitator1"
                                                            value="<?php echo e($user_id); ?>">
                                                        <input type="hidden" name="task" id="task">
                                                        <?php if($quality_status == 'P'): ?>
                                                            <button type="button" id="save1"
                                                                class="btn btn-sm btn-success "
                                                                onclick="return submitAction1()">Save</button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
    
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
                                                        <th>Fedeartion Name</th>
                                                        <th>DM Status</th>
                                                        <th>QA Status</th>
                                                        <th>Date</th>
                                                        <th>DM Remarks</th>
                                                        <th>QA Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php $__currentLoopData = $remarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
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
                                                    ?>
                                                    <tr>
                                                        <td><?php echo e($res->name); ?></td>
                                                        <td><?php echo e($res->name_of_federation); ?></td>
                                                        <td><?php echo e($status); ?></td>
                                                        <td><?php echo e($qa_status); ?></td>
                                                        <td><?php echo e(change_date_month_name_char(str_replace('/','-',$res->updated_at))); ?></td>

                                                        <td><a data-toggle="modal" data-id="<?php echo e($res->id); ?>"
                                                                href="#remarks_m" data-type="M"
                                                                class="btn btn-success btn-link btn-sm"
                                                                data-target="#remarks_m"><i
                                                                    class="c-white-500 ti-eye"></i></a>
                                                        </td>
                                                        <td><a data-toggle="modal" data-id="<?php echo e($res->id); ?>"
                                                            href="#remarks_q" data-type="QA"
                                                            class="btn btn-success btn-link btn-sm"
                                                            data-target="#remarks_q"><i
                                                                class="c-white-500 ti-eye"></i></a>
                                                        </td>

                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



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
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

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
        background: #F1F5FA !important;
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
        var type = $(event.relatedTarget).data('type');
        $.ajax({
            type: 'GET',
            url: '/get_fed_remarks',
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
        var type = $(event.relatedTarget).data('type');
        $.ajax({
            type: 'GET',
            url: '/get_fed_remarks',
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
        var user_id = $('#user_id').val();
        var editor = CKEDITOR.instances['TaskQaAssignment_remark'];
        var remark = editor.getData();

        var rmk = encodeURIComponent(remark);
    if(user_id == null && sts == 'R')
    {
        alert("Please select the Facilitator first");
    }else{
        bootbox.confirm({
            title: "Save Manager Action ?",
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
                            data: {
                                    _token: csrfToken, // Use the dynamically retrieved CSRF token
                                    id: id,
                                    sts: sts,
                                    rmk: rmk,
                                    assignment_type: "FD",
                                    user_id: user_id
                                },
                        success: function(response) {
                            data = JSON.parse(response);
                            if (data.result == 1) {
                                if ("<?php echo e($quality_check); ?>" == '0' ||
                                    "<?php echo e($quality_check); ?>" == 0) {
                                    location.reload();

                                } else {
                                    window.location.href =
                                        "<?php echo e(url('qualitycheck')); ?>";
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
        var remark = editor.getData();
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
                                    assignment_type: "FD"
                                },
                        success: function(response) {
                            data = JSON.parse(response);
                            if (data.result == 1) {
                                if ("<?php echo e($quality_check); ?>" == '0' ||
                                    "<?php echo e($quality_check); ?>" == 0) {
                                    location.reload();

                                } else {
                                    window.location.href =
                                        "<?php echo e(url('qualitycheck')); ?>";
                                }

                            }
                        }
                    });
                }
            }
        });

    }

    <?php if($u_type == 'QA' || $u_type == 'CEO' || $u_type == 'A'): ?>
    $(document).ready(function() {
        $("#v-pills-quality-summary-tab .active").trigger('click');

        var ctx = document.getElementById("raating_d_chart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Rating", ""],
                datasets: [{
                    data: ['<?php echo e($analysis_final_total); ?>',
                        '<?php echo e(100 - $analysis_final_total); ?>'
                    ],
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


    //$(this.element).find('.pie-value').text(Math.round(percent) + '%');

    var config = {
        type: 'line',
        data: {
            labels: ['2020', '2021', '2022'],
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
    <?php endif; ?>

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
    // function get_facilitator_list() {
    //     $.ajax({
    //         type: 'GET',
    //         url: '/get_facilitator_list_task',
    //         data: '_token = <?php echo csrf_token(); ?>',
    //         success: function(data) {
    //             if (data != '') {
    //                 $('#user_id').html(data);
    //                 $('#user_id').val($('#facilitator').val());
    //                 $('#user_id').trigger("change");
    //             }
    //         }
    //     });

    // }

    function set_facilitator() {
        var flg = $('#TaskQaAssignment_status').val();
        var flg1 = $('#TaskQaAssignment_status11').val();
        var dm_id = $('#dm_id').val();
        if (flg == 'R' || flg1 == 'R') {
            $('.show_div').show();
            <?php if($qa_status == 'P' || $quality_status == 'R'): ?>
            $('.show_div select').attr('required', 'required');
            <?php endif; ?>
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
        $('#TaskQaAssignment_status11').on('change', set_facilitator);

        $('#TaskQaAssignment_status').trigger('change');
        $('#TaskQaAssignment_status11').trigger('change');
        <?php if($qa_status == 'R' || $qa_status == 'V'): ?>
        $('#TaskQaAssignment_status').val("<?php echo e($qa_status); ?>");
        $('#TaskQaAssignment_remark').val("<?php echo e($qa_remark); ?>");
        <?php endif; ?>
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/federation/view.blade.php ENDPATH**/ ?>