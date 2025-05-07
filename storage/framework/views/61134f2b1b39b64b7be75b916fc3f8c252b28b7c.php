<?php $__env->startSection('content'); ?>
<?php
$user = Auth::user();
?>
<style>
    .red{
        background-color: red !important;
    }
    .total {
        color: #ffffff;
        background-color: #1761FD;
        font-weight: bold;
    }

    .box {
        background: #D3FBCF;
        border-radius: 5px;
        padding: 10px;
        color: #6BC561;
        width: 190px;
    }

    .mr-4 {
        margin-right: 1.5rem !important;
    }

    .box2 {
        background: #FDDCDF;
        border-radius: 5px;
        padding: 10px;
        color: #F64E68;
        width: 190px;
    }

    .red_text {
        color: red;
    }

    .green_text {
        color: #046d08;
    }

    .sub_tot_color {
        color: black;
        background-color: #D3D3D3;
        font-weight: bold;

    }
    .cke_notification_warning {
        display:none;
    }
</style>
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

                            <h2><?php echo e($family_profile[0]->fp_member_name); ?></h2>

                            <div class="E-link d-flex">
                                <a href="#">
                                    <p><i class="las la-phone"><?php echo e($family_profile[0]->fp_contact_no); ?></i> </p>
                                </a>
                            </div>
                            <p>
                                <span style="padding: 0px 5px;"></span>
                                <span style="padding: 0px 5px;"><?php echo e($family_profile[0]->fp_district); ?></span>,
                                <span style="padding: 0px 5px;"><?php echo e($family_profile[0]->fp_state); ?></span>,
                                <span style="padding: 0px 5px;"><?php echo e($family_profile[0]->fp_country); ?></span>
                            </p>
                        </div>
                        <div class="ml-auto d-flex">
                            <div class="rating-box2 s-box mr-4 <?php echo e($grdcolor); ?>">
                                <h4>Analytics and Rating</h4>
                                <h3><?php echo e($grand_total_cy); ?></h3>
                                <p><?php echo e($show_final_status); ?></p>
                            </div>
                            <div class="rating-box2 s-box">
                                <h4>Poverty Ranking</h4>
                                <h3><?php echo e($family_profile[0]->fp_wealth_rank); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" style="margin-top:30px">
                    <div class="col-3 faily-tab">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <?php if($u_type == 'QA' || $u_type == 'CEO' || $u_type == 'A'): ?>
                            <a class="nav-link active" id="v-pills-quality-summary-tab" data-toggle="pill" href="#v-pills-quality-summary" role="tab" aria-controls="v-pills-quality-summary" aria-selected="true"><i class="las la-briefcase mr-2"></i>Summary</a>
                            <a class="nav-link " id="v-pills-Basic-Profile-tab" data-toggle="pill" href="#v-pills-Basic-Profile" role="tab" aria-controls="v-pills-Basic-Profile" aria-selected="false"><i class="las la-info-circle mr-2"></i>Basic Profile</a>
                            <?php else: ?>
                            <a class="nav-link active" id="v-pills-Basic-Profile-tab" data-toggle="pill" href="#v-pills-Basic-Profile" role="tab" aria-controls="v-pills-Basic-Profile" aria-selected="true"><i class="las la-info-circle mr-2"></i>Basic Profile</a>
                            <?php endif; ?>
                            <?php if($user->u_type !='M'): ?>
                            <a class="nav-link " id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="true"><i class="las la-info-circle mr-2"></i>Reports</a>
                            <?php endif; ?>
                            <a class="nav-link " id="v-pills-Assets-tab" data-toggle="pill" href="#v-pills-Assets" role="tab" aria-controls="v-pills-Assets" aria-selected="false"><i class="las la-hand-holding-usd mr-2"></i>Assets</a>
                            <a class="nav-link " id="v-pills-Goals-tab" data-toggle="pill" href="#v-pills-Goals" role="tab" aria-controls="v-pills-Goals" aria-selected="false"><i class="las la-briefcase mr-2"></i>Goals</a>
                            <a class="nav-link " id="v-pills-Agricultural-tab" data-toggle="pill" href="#v-pills-Agricultural" role="tab" aria-controls="v-pills-Agricultural" aria-selected="false"><i class="las la-briefcase mr-2"></i>Agricultural Production </a>
                            <a class="nav-link " id="v-pills-Savings-tab" data-toggle="pill" href="#v-pills-Savings" role="tab" aria-controls="v-pills-Savings" aria-selected="false"><i class="las la-briefcase mr-2"></i>Savings</a>
                            <a class="nav-link " id="v-pills-Loan-tab" data-toggle="pill" href="#v-pills-Loan" role="tab" aria-controls="v-pills-Loan" aria-selected="false"><i class="las la-briefcase mr-2"></i>Loan Outstanding</a>
                            <a class="nav-link " id="v-pills-Budget-tab" data-toggle="pill" href="#v-pills-Budget" role="tab" aria-controls="v-pills-Budget" aria-selected="false"><i class="las la-briefcase mr-2"></i>Budget</a>
                            <?php if($user->u_type != 'M'): ?>
                            <a class="nav-link " id="v-pills-Analysis-tab" data-toggle="pill" href="#v-pills-Analysis" role="tab" aria-controls="v-pills-Analysis" aria-selected="false"><i class="las la-briefcase mr-2"></i>Analysis and Scores</a>
                            <?php endif; ?>
                            <a class="nav-link " id="v-pills-Challenges-tab" data-toggle="pill" href="#v-pills-Challenges" role="tab" aria-controls="v-pills-Challenges" aria-selected="false"><i class="las la-briefcase mr-2"></i>Challenges</a>
                            <a class="nav-link " id="v-pills-Action-Plan-tab" data-toggle="pill" href="#v-pills-Action-Plan" role="tab" aria-controls="v-pills-Action-Plan" aria-selected="false"><i class="las la-briefcase mr-2"></i>Action Plan</a>
                            <a class="nav-link " id="v-pills-Business-Plan-tab" data-toggle="pill" href="#v-pills-Business-Plan" role="tab" aria-controls="v-pills-Business-Plan" aria-selected="false"><i class="las la-briefcase mr-2"></i>Business Plan</a>
                            <a class="nav-link " id="v-pills-commitment-tab" data-toggle="pill" href="#v-pills-commitment" role="tab" aria-controls="v-pills-commitment" aria-selected="false"><i class="las la-briefcase mr-2"></i>Commitment</a>
                            <a class="nav-link " id="v-pills-Observations-tab" data-toggle="pill" href="#v-pills-Observations" role="tab" aria-controls="v-pills-Observations" aria-selected="false"><i class="las la-briefcase mr-2"></i>Observations</a>
                            <a class="nav-link " id="v-pills-Photos-Videos-tab" data-toggle="pill" href="#v-pills-Photos-Videos" role="tab" aria-controls="v-pills-Photos-Videos" aria-selected="false"><i class="las la-briefcase mr-2"></i>Photos/Videos</a>
                            <a class="nav-link " id="v-pills-consent-tab" data-toggle="pill" href="#v-pills-consent" role="tab" aria-controls="v-pills-consent" aria-selected="false"><i class="las la-briefcase mr-2"></i>Consent Form</a>
                            <?php if($user->u_type !='M'): ?>
                            <a class="nav-link " id="v-pills-report-card-tab" data-toggle="pill" href="#v-pills-report-card" role="tab" aria-controls="v-pills-report-card" aria-selected="false"><i class="las la-briefcase mr-2"></i>Report Card</a>
                            <?php endif; ?>
                            <a class="nav-link " id="v-pills-consent-tab" data-toggle="pill" href="#v-pills-loan-approvel" role="tab" aria-controls="v-pills-consent" aria-selected="false"><i class="las la-briefcase mr-2"></i>Loan Approval</a>
                            <a class="nav-link " id="v-pills-consent-tab" data-toggle="pill" href="#v-pills-loan-approved" role="tab" aria-controls="v-pills-consent" aria-selected="false"><i class="las la-briefcase mr-2"></i>Loan Disbursement</a>
                            <?php if($u_type == 'M'): ?>
                            <a class="nav-link " id="v-pills-quality-check-tab" data-toggle="pill" href="#v-pills-quality-check" role="tab" aria-controls="v-pills-quality-check" aria-selected="false"><i class="las la-briefcase mr-2"></i>Manager Check</a>

                            <?php elseif($u_type == 'QA'): ?>
                            <a class="nav-link " id="v-pills-quality-check-tab-qa" data-toggle="pill" href="#v-pills-quality-check-qa" role="tab" aria-controls="v-pills-quality-check-qa" aria-selected="false"><i class="las la-briefcase mr-2"></i>Quality Check</a>
                            <?php endif; ?>
                            <a class="nav-link " id="v-pills-remarks-tab" data-toggle="pill" href="#v-pills-remarks" role="tab" aria-controls="v-pills-remarks" aria-selected="false"><i class="las la-briefcase mr-2"></i>Remarks</a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="v-pills-tabContent">
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
                            <div class="tab-pane fade " id="v-pills-Basic-Profile" role="tabpanel" aria-labelledby="v-pills-Basic-Profile-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Family Profile</h5>

                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Member Name</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_member_name); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">UIN</div>
                                                    <div class="col-6"><?php echo e($family->uin); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Gender</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_gender != '' ? $family_profile[0]->fp_gender : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Caste</div>
                                                    <div class="col-6">
                                                        <?php echo e($caste_name ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Age</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_age != '' ? $family_profile[0]->fp_age : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Contact No</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_contact_no != '' ? $family_profile[0]->fp_contact_no : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Aadhar No</div>
                                                    <div class="col-6">

                                                        <?php echo e($family_profile[0]->fp_aadhar_no != '' ? aadhar($family_profile[0]->fp_aadhar_no) : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Pan</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_pan != '' ? pan($family_profile[0]->fp_pan) : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Name of SHG</div>
                                                    <div class="col-6"><?php echo e($shg_profile[0]->shgName); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Village</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_village); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Cluster/Habitation Federation
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e(!empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Federation </div>
                                                    <div class="col-6">
                                                        <?php echo e($fed_profile[0]->name_of_federation); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Block</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_block != '' ? $family_profile[0]->fp_block : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">District</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_district != '' ? $family_profile[0]->fp_district : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">State</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_state); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Country</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_country); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Bank Account</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_bank_account != '' ? $family_profile[0]->fp_bank_account : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Bank</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_bank != '' ? $family_profile[0]->fp_bank : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Account Holder</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_account_holder != '' ? $family_profile[0]->fp_account_holder : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Account</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_account != '' ? account($family_profile[0]->fp_account) : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Bank Branch</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_bank_branch != '' ? $family_profile[0]->fp_bank_branch : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Spouse Name</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_spouse_name != '' ? $family_profile[0]->fp_spouse_name : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Female Headed</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_female_headed != '' ? $family_profile[0]->fp_female_headed : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--start family members -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Family Members </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Shg Member Spouse</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->shg_member_spouse); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Children No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_children_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Daughter In Law No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_doughterinlay_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Parent In Laws No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_parentinlaws_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Family Member Over 60year</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_family_mamber_over_60year); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">No of Differently abled family
                                                        members</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_family_mamber_medication); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Vulnerable People</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_vulnerable_people); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Married Children Live In</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_married_children_live_in != '' ? $family_profile[0]->fp_married_children_live_in : 0); ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Others No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_others_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Family Members No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) (int) $family_profile[0]->fp_family_mambers_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end family members -->

                                <!--start childern details-->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Children Profile </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Non School Children No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->non_school_children_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Children No In Primary School</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_children_no_in_primary_school); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Children No In Secondary Higher
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_children_no_in_secondary_higher); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Children No In College</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_children_no_in_college); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Studied at Home</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->studiedat_home); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Total Children</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_total_children); ?>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end children deatails -->

                                <!-- family earning -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Family Earnings</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">

                                            <!-- <div class="col-md-6">
                                                        <div class="row detail">
                                                            <div class="col-6">Member No Earn Fixed Income</div>
                                                            <div class="col-6">
                                                                <?php echo e((int) $family_profile[0]->fp_mamber_no_earn_fixed_income); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row detail">
                                                            <div class="col-6">Member No Earn Seasonal Income
                                                            </div>
                                                            <div class="col-6">
                                                                <?php echo e((int) $family_profile[0]->fp_mamber_no_earn_seasonal_income); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row detail">
                                                            <div class="col-6">Member No Earn Daily Income</div>
                                                            <div class="col-6">
                                                                <?php echo e((int) $family_profile[0]->fp_mamber_no_earn_daily_income); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row detail">
                                                            <div class="col-6">Pension Member</div>
                                                            <div class="col-6">
                                                                <?php echo e((int) $family_profile[0]->fp_pension_member); ?>

                                                            </div>
                                                        </div>
                                                    </div> -->
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Total Family Members Earning</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_earning_an_income); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- end family earning -->

                                
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Family Members Info </h5>
                                    </div>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>DOB</th>
                                                    <th>Age</th>
                                                    <th>Gender</th>
                                                    <th>Relation</th>
                                                    <th>Education</th>
                                                    <th>Marital Status</th>
                                                    <th>Differently Abled</th>
                                                    <th>Earning Income</th>
                                                    <th>Earning Description</th>
                                                    <th>Malnutritions</th>
                                                    <th>Undernourished</th>
                                                    <th>Vulnerable</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $__currentLoopData = $family_member_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($res->name); ?></td>
                                                    <td><?php echo e($res->dob); ?></td>
                                                    <td><?php echo e($res->age); ?></td>
                                                    <td><?php echo e($res->gender); ?></td>
                                                    <td><?php echo e($res->relation); ?></td>
                                                    <td><?php echo e($res->education); ?></td>
                                                    <td><?php echo e($res->maritalStatus); ?></td>
                                                    <td><?php echo e($res->differentlyAbled != 0 ? 'Yes' : 'No'); ?></td>
                                                    <td><?php echo e($res->employed != 0 ? 'Yes' : 'No'); ?></td>
                                                    <td><?php echo e($res->earning_description); ?></td>
                                                    <?php if($res->age >=15): ?>
                                                    <td><?php echo e($res->malnutritions != 0 ? 'Yes' : 'No'); ?></td>
                                                        <?php else: ?>
                                                        <td>N/A</td>
                                                    <?php endif; ?>
                                                    <?php if($res->age < 15): ?>
                                                    <td><?php echo e($res->undernourished != 0 ? 'Yes' : 'No'); ?></td>
                                                        <?php else: ?>
                                                        <td>N/A</td>
                                                    <?php endif; ?>
                                                    <td><?php echo e($res->vulnerable != 0 ? 'Yes' : 'No'); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                

                                
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Govt. Livelihood Programs</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th colspan="2">Are you aware of Govt. Livelihood Programs?
                                                    </th>
                                                    <th><?php echo e($family_profile[0]->gov_liveilhood_program); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->gov_liveilhood_program == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <th>Programs</th>
                                                    <th>Benifits recived</th>
                                                    <th>Benifits</th>
                                                </tr>
                                                <?php $__currentLoopData = $gov_program; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $benefis = explode(',', $res->benefit_1);
                                                $count = count($benefis);
                                                ?>
                                                <tr>
                                                    <td><?php echo e($res->program_name); ?></td>
                                                    <td><?php echo e($res->recived_benefit == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                    <td>
                                                        <?php for($i = 0; $i <= $count - 1; $i++): ?> <ul style="list-style-type:disc;">
                                                            <li><?php echo e($benefis[$i]); ?></li>
                                                            </ul>
                                                            <?php endfor; ?>

                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                            </tbody>
                                            <?php endif; ?>

                                        </table>



                                    </div>
                                </div>
                                

                                <!--family not educated -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Education</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">A. Family not educated up to at least six
                                                        years of
                                                        schooling?</th>
                                                    <th><?php echo e($family_profile[0]->family_member_not_educated); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->family_member_not_educated == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->family_member_not_educatedMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->family_member_not_educatedaFemale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->family_member_not_educatedaTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">B. Any children or adolescents up to age of
                                                        13 away from
                                                        school or dropped out?</th>
                                                    <th><?php echo e($family_profile[0]->children_or_adolescents_upto_age); ?>

                                                    </th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->children_or_adolescents_upto_age == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->children_or_adolescents_uptoMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->children_or_adolescents_uptoFemale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->children_or_adolescents_uptoTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>


                                    </div>
                                </div>

                                <!--Nutrition and Mortality -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Nutrition and Mortality</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">A. Family member have access to all three
                                                        meals on a daily
                                                        basis?</th>
                                                    <th><?php echo e($family_profile[0]->aNutritionMortality); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->aNutritionMortality == 'No'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->aNutritionMortalityMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->aNutritionMortalityFeMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->aNutritionMortalityTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">B.Does any member suffer due to
                                                        malnutrition?</th>
                                                    <th><?php echo e($family_profile[0]->bNutritionMortality); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->bNutritionMortality == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->bNutritionMortalityMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->bNutritionMortalityFeMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->bNutritionMortalityTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">C.Does any one of the children/adolescents
                                                        or adults appear
                                                        to be undernourished (stunted,wasted,under-weight)?</th>
                                                    <th><?php echo e($family_profile[0]->cNutritionMortality); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->cNutritionMortality == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->cNutritionMortalityMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->cNutritionMortalityFeMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->cNutritionMortalityTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">D.Have any children or adolescents died
                                                        below age 18?</th>
                                                    <th><?php echo e($family_profile[0]->dNutritionMortality); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->dNutritionMortality == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->dNutritionMortalityMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->dNutritionMortalityFeMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->dNutritionMortalityTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>


                                    </div>
                                </div>

                                <!-- family living -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Standard of Living</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">A.Sanitation Does the family</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->sanitation); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">B.Electricity Does the house they
                                                        live in have electercity?</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->sElectricity); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">C.Drinking water Do they fetch
                                                        water for drinking from
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->sDrinkingWater); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">D.Cooking Fuel What is the method
                                                        used by family</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->sCookingFuel); ?>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Health Status</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>E.Health Issues Any member in the house having illness
                                                        during last 2 years</th>
                                                    <th><?php echo e($family_profile[0]->sHealthIssues); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->sHealthIssues == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->sHealthIssuesMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->sHealthIssuesFeMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->sHealthIssuesTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>
                                    </div>
                                </div>





                                <!-- family migrate -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Family Migration

                                        </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Family Migration
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e(checkna($family_profile[0]->fp_family_migrated)); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($family_profile[0]->fp_family_migrated == 'Yes'): ?>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Member Reason Of Migration
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_family_reason_of_migration); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- end family migrate -->

                                <!--start wealth rank -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Wealth Rank </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Wealth Rank</div>
                                                    <div class="col-6">
                                                        <?php echo e(checkna($family_profile[0]->fp_wealth_rank)); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end wealth rank -->
                            </div>
                            <?php else: ?>
                            <div class="tab-pane fade " id="v-pills-Basic-Profile" role="tabpanel" aria-labelledby="v-pills-Basic-Profile-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Family Profile</h5>

                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Member Name</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_member_name); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">UIN</div>
                                                    <div class="col-6"><?php echo e($family->uin); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Gender</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_gender != '' ? $family_profile[0]->fp_gender : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Caste</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_caste != '' ? $family_profile[0]->fp_caste : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Age</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_age != '' ? $family_profile[0]->fp_age : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Contact No</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_contact_no != '' ? $family_profile[0]->fp_contact_no : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Aadhar No</div>
                                                    <div class="col-6">

                                                        <?php echo e($family_profile[0]->fp_aadhar_no != '' ? aadhar($family_profile[0]->fp_aadhar_no) : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Pan</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_pan != '' ? pan($family_profile[0]->fp_pan) : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Name of SHG</div>
                                                    <div class="col-6"><?php echo e($shg_profile[0]->shgName); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Village</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_village); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Cluster/Habitation Federation
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e(!empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Federation </div>
                                                    <div class="col-6">
                                                        <?php echo e($fed_profile[0]->name_of_federation); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Block</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_block != '' ? $family_profile[0]->fp_block : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">District</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_district != '' ? $family_profile[0]->fp_district : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">State</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_state); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Country</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_country); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Bank Account</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_bank_account != '' ? $family_profile[0]->fp_bank_account : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Bank</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_bank != '' ? $family_profile[0]->fp_bank : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Account Holder</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_account_holder != '' ? $family_profile[0]->fp_account_holder : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Account</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_account != '' ? account($family_profile[0]->fp_account) : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Bank Branch</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_bank_branch != '' ? $family_profile[0]->fp_bank_branch : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Spouse Name</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_spouse_name != '' ? $family_profile[0]->fp_spouse_name : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Female Headed</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_female_headed != '' ? $family_profile[0]->fp_female_headed : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--start family members -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Family Members </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Shg Member Spouse</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->shg_member_spouse); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Children No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_children_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Daughter In Law No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_doughterinlay_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Parent In Laws No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_parentinlaws_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Family Member Over 60year</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_family_mamber_over_60year); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">No of Differently abled family
                                                        members</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_family_mamber_medication); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Vulnerable People</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_vulnerable_people); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Married Children Live In</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_married_children_live_in != '' ? $family_profile[0]->fp_married_children_live_in : 0); ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Others No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_others_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Family Members No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) (int) $family_profile[0]->fp_family_mambers_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end family members -->

                                <!--start childern details-->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Children Profile </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Non School Children No</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->non_school_children_no); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Children No In Primary School</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_children_no_in_primary_school); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Children No In Secondary Higher
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_children_no_in_secondary_higher); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Children No In College</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_children_no_in_college); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Studied at Home</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->studiedat_home); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Total Children</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_total_children); ?>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end children deatails -->

                                <!-- family earning -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Family Earnings</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">

                                            <!-- <div class="col-md-6">
                                                        <div class="row detail">
                                                            <div class="col-6">Member No Earn Fixed Income</div>
                                                            <div class="col-6">
                                                                <?php echo e((int) $family_profile[0]->fp_mamber_no_earn_fixed_income); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row detail">
                                                            <div class="col-6">Member No Earn Seasonal Income
                                                            </div>
                                                            <div class="col-6">
                                                                <?php echo e((int) $family_profile[0]->fp_mamber_no_earn_seasonal_income); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row detail">
                                                            <div class="col-6">Member No Earn Daily Income</div>
                                                            <div class="col-6">
                                                                <?php echo e((int) $family_profile[0]->fp_mamber_no_earn_daily_income); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row detail">
                                                            <div class="col-6">Pension Member</div>
                                                            <div class="col-6">
                                                                <?php echo e((int) $family_profile[0]->fp_pension_member); ?>

                                                            </div>
                                                        </div>
                                                    </div> -->
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Total Family Members Earning</div>
                                                    <div class="col-6">
                                                        <?php echo e((int) $family_profile[0]->fp_earning_an_income); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- end family earning -->

                                
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Family Members Info </h5>
                                    </div>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>DOB</th>
                                                    <th>Age</th>
                                                    <th>Gender</th>
                                                    <th>Relation</th>
                                                    <th>Education</th>
                                                    <th>Marital Status</th>
                                                    <th>Differently Abled</th>
                                                    <th>Earning Income</th>
                                                    <th>Earning Description</th>
                                                    <th>Malnutritions</th>
                                                    <th>Undernourished</th>
                                                    <th>Vulnerable</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $__currentLoopData = $family_member_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($res->name); ?></td>
                                                    <td><?php echo e($res->dob); ?></td>
                                                    <td><?php echo e($res->age); ?></td>
                                                    <td><?php echo e($res->gender); ?></td>
                                                    <td><?php echo e($res->relation); ?></td>
                                                    <td><?php echo e($res->education); ?></td>
                                                    <td><?php echo e($res->maritalStatus); ?></td>
                                                    <td><?php echo e($res->differentlyAbled != 0 ? 'Yes' : 'No'); ?></td>
                                                    <td><?php echo e($res->employed != 0 ? 'Yes' : 'No'); ?></td>
                                                    <td><?php echo e($res->earning_description); ?></td>
                                                    <?php if($res->age >=15): ?>
                                                    <td><?php echo e($res->malnutritions != 0 ? 'Yes' : 'No'); ?></td>
                                                        <?php else: ?>
                                                        <td>N/A</td>
                                                    <?php endif; ?>
                                                    <?php if($res->age < 15): ?>
                                                    <td><?php echo e($res->undernourished != 0 ? 'Yes' : 'No'); ?></td>
                                                        <?php else: ?>
                                                        <td>N/A</td>
                                                    <?php endif; ?>
                                                    <td><?php echo e($res->vulnerable != 0 ? 'Yes' : 'No'); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                

                                
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Govt. Livelihood Programs</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th colspan="2">Are you aware of Govt. Livelihood Programs?
                                                    </th>
                                                    <th><?php echo e($family_profile[0]->gov_liveilhood_program); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->gov_liveilhood_program == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <th>Programs</th>
                                                    <th>Benifits recived</th>
                                                    <th>Benifits</th>
                                                </tr>
                                                <?php $__currentLoopData = $gov_program; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $benefis = explode(',', $res->benefit_1);
                                                $count = count($benefis);
                                                ?>
                                                <tr>
                                                    <td><?php echo e($res->program_name); ?></td>
                                                    <td><?php echo e($res->recived_benefit == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                    <td>
                                                        <?php for($i = 0; $i <= $count - 1; $i++): ?> <ul style="list-style-type:disc;">
                                                            <li><?php echo e($benefis[$i]); ?></li>
                                                            </ul>
                                                            <?php endfor; ?>

                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                            </tbody>
                                            <?php endif; ?>

                                        </table>



                                    </div>
                                </div>
                                

                                <!--family not educated -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Education</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">A. Family not educated up to at least six
                                                        years of
                                                        schooling?</th>
                                                    <th><?php echo e($family_profile[0]->family_member_not_educated); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->family_member_not_educated == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->family_member_not_educatedMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->family_member_not_educatedaFemale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->family_member_not_educatedaTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">B. Any children or adolescents up to age of
                                                        13 away from
                                                        school or dropped out?</th>
                                                    <th><?php echo e($family_profile[0]->children_or_adolescents_upto_age); ?>

                                                    </th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->children_or_adolescents_upto_age == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->children_or_adolescents_uptoMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->children_or_adolescents_uptoFemale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->children_or_adolescents_uptoTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>


                                    </div>
                                </div>

                                <!--Nutrition and Mortality -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Nutrition and Mortality</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">A. Family member have access to all three
                                                        meals on a daily
                                                        basis?</th>
                                                    <th><?php echo e($family_profile[0]->aNutritionMortality); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->aNutritionMortality == 'No'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->aNutritionMortalityMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->aNutritionMortalityFeMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->aNutritionMortalityTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">B.Does any member suffer due to
                                                        malnutrition?</th>
                                                    <th><?php echo e($family_profile[0]->bNutritionMortality); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->bNutritionMortality == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->bNutritionMortalityMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->bNutritionMortalityFeMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->bNutritionMortalityTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">C.Does any one of the children/adolescents
                                                        or adults appear
                                                        to be undernourished (stunted,wasted,under-weight)?</th>
                                                    <th><?php echo e($family_profile[0]->cNutritionMortality); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->cNutritionMortality == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->cNutritionMortalityMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->cNutritionMortalityFeMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->cNutritionMortalityTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="100%">D.Have any children or adolescents died
                                                        below age 18?</th>
                                                    <th><?php echo e($family_profile[0]->dNutritionMortality); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->dNutritionMortality == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->dNutritionMortalityMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->dNutritionMortalityFeMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->dNutritionMortalityTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>


                                    </div>
                                </div>

                                <!-- family living -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Standard of Living</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">A.Sanitation Does the family</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->sanitation); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">B.Electricity Does the house they
                                                        live in have electercity?</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->sElectricity); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">C.Drinking water Do they fetch
                                                        water for drinking from
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->sDrinkingWater); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">D.Cooking Fuel What is the method
                                                        used by family</div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->sCookingFuel); ?>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Health Status</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>E.Health Issues Any member in the house having illness
                                                        during last 2 years</th>
                                                    <th><?php echo e($family_profile[0]->sHealthIssues); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($family_profile[0]->sHealthIssues == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Male</td>
                                                    <td><?php echo e($family_profile[0]->sHealthIssuesMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Female</td>
                                                    <td><?php echo e($family_profile[0]->sHealthIssuesFeMale); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. Total</td>
                                                    <td><?php echo e($family_profile[0]->sHealthIssuesTotal); ?>

                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php endif; ?>

                                        </table>
                                    </div>
                                </div>





                                <!-- family migrate -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Family Migration

                                        </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Family Migration
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e(checkna($family_profile[0]->fp_family_migrated)); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($family_profile[0]->fp_family_migrated == 'Yes'): ?>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Member Reason Of Migration
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e($family_profile[0]->fp_family_reason_of_migration); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- end family migrate -->

                                <!--start wealth rank -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Wealth Rank </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Wealth Rank</div>
                                                    <div class="col-6">
                                                        <?php echo e(checkna($family_profile[0]->fp_wealth_rank)); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end wealth rank -->
                            </div>
                            <?php endif; ?>
                            <!----tab-2---->
                            <div class="tab-pane fade" id="v-pills-Assets" role="tabpanel" aria-labelledby="v-pills-Assets-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Family Assets</h5>

                                    </div>
                                </div>

                                <!-- start land -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Land </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Land Size</div>
                                                    <div class="col-6">
                                                        <?php echo e(checkna($assets[0]->fa_land_type)); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Land Cultivated By Family</div>
                                                    <div class="col-6">
                                                        <?php echo e($assets[0]->fa_land_cultivated != '' ? number_format( $assets[0]->fa_land_cultivated,2) : '0.00'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Land Mortgaged</div>
                                                    <div class="col-6">
                                                        <?php echo e($assets[0]->fa_land_mortgaged != '' ? $assets[0]->fa_land_mortgaged : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($assets[0]->fa_land_mortgaged == 'Yes'): ?>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">How much land</div>
                                                    <div class="col-6">
                                                        <?php echo e($assets[0]->fa_mortagged_how_much_land != '' ? number_format($assets[0]->fa_mortagged_how_much_land,2) : '0.00'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Date of loss mortgage</div>
                                                    <div class="col-6">
                                                        <?php echo e(change_date_new($assets[0]->fa_date_of_mortgage)); ?>

                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Land Owned but cultivated as sharecroping</div>
                                                    <div class="col-6">
                                                        <?php echo e($assets[0]->fa_land_owned != '' ? number_format($assets[0]->fa_land_owned,2) : '0.00'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Land Not Owned but cultivated as sharecroping</div>
                                                    <div class="col-6">
                                                        <?php echo e($assets[0]->fa_land_not_owned != '' ? number_format($assets[0]->fa_land_not_owned,2) : '0.00'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Total Land Owned and Cultivated by Family</div>
                                                    <div class="col-6">
                                                        <?php echo e($assets[0]->fa_total_land_owned != '' ? number_format($assets[0]->fa_total_land_owned,2) : '0.00'); ?>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end land -->

                                <!-- start house unit -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Housing Unit, Animal shed, Vehicles, and machinery/equipment </h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">House Ownership</div>
                                                    <div class="col-6">
                                                        <?php echo e($assets[0]->house_ownership != '' ? $assets[0]->house_ownership : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Pacca Kaccha House</div>
                                                    <div class="col-6">
                                                        <?php echo e($assets[0]->fa_Pacca_Kaccha_house != '' ? $assets[0]->fa_Pacca_Kaccha_house : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Animalsheds</div>
                                                    <div class="col-6">
                                                        <?php echo e($assets[0]->fa_animalsheds != '' ? $assets[0]->fa_animalsheds : 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Assets Vehicle</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Name of Vehicle</th>
                                                    <th>No. of Vehicle</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($assets_vehicle)): ?>
                                                <?php $__currentLoopData = $assets_vehicle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e(checkna($row->vehicle_Types)); ?></td>
                                                    <td><?php echo e($row->no_of_vehicle != '' ? $row->no_of_vehicle : 0); ?>

                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Assets Machinery</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Name of Machinery</th>
                                                    <th>No. of Machinery</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($assets_machinery)): ?>
                                                <?php $__currentLoopData = $assets_machinery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e(checkna($row->machinery_Types)); ?></td>
                                                    <td><?php echo e($row->no_of_machinery != '' ? $row->no_of_machinery : 0); ?>

                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Assets Live Stock</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Name of Animal</th>
                                                    <th>No. of Animal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($assets_live_stock)): ?>
                                                <?php $__currentLoopData = $assets_live_stock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($row->animal_Types); ?></td>
                                                    <td><?php echo e($row->no_of_animals != '' ? $row->no_of_animals : 0); ?>

                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- start home gadget -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Home Gadgets/Equipment </h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Name of Gadgets</th>
                                                    <th>No. of Gadgets</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($assets_gadgets)): ?>
                                                <tr>
                                                    <td>Tv color</td>
                                                    <td><?php echo e((int) $assets_gadgets[0]->fa_tvcolor == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tv black/white</td>
                                                    <td><?php echo e((int) $assets_gadgets[0]->fa_tvblackwhite == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Air conditioners</td>
                                                    <td><?php echo e((int) $assets_gadgets[0]->fa_airconditioners == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Coolers</td>
                                                    <td><?php echo e((int) $assets_gadgets[0]->fa_coolers == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Sewing Machines</td>
                                                    <td><?php echo e((int) $assets_gadgets[0]->fa_sewingmachines == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Smartphone</td>
                                                    <td><?php echo e((int) $assets_gadgets[0]->fa_smartphone == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Wet Grinder</td>
                                                    <td><?php echo e((int) $assets_gadgets[0]->wet_grinder == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Mixi</td>
                                                    <td><?php echo e((int) $assets_gadgets[0]->mixi == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Washing Machines</td>
                                                    <td><?php echo e((int) $assets_gadgets[0]->washing_machines == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Computer</td>
                                                    <td><?php echo e((int) $assets_gadgets[0]->computer == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Refrigerator</td>
                                                    <td><?php echo e((int) $assets_gadgets[0]->refrigerator == 1 ? 'Yes' : 'No'); ?>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Other</td>

                                                    <?php if($assets_gadgets[0]->fa_other == 1): ?>
                                                    <td><?php echo e($assets_gadgets[0]->fa_other_choice); ?></td>
                                                    <?php else: ?>
                                                    <td>No</td>
                                                    <?php endif; ?>


                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end home gadget -->

                                <!--start Personal Items -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Personal Items</h5>
                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="70%">A. Does the family own any jewelry</th>
                                                    <th><?php echo e(checkna($assets[0]->fa_jewelry_yes_no)); ?></th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="70%">B. Jewelry Pawned Take Loan </th>
                                                    <th><?php echo e(checkna($assets[0]->jewelry_pawned_take_loan_yesno)); ?>

                                                    </th>
                                                </tr>
                                            </thead>
                                            <?php if($assets[0]->jewelry_pawned_take_loan_yesno == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Lender Type</td>
                                                    <td><?php echo e(checkna($assets[0]->jewelry_pawned_lander_type)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Amount</td>
                                                    <td><?php echo e((float) $assets[0]->jewelry_pawned_loan_amount != '' ? (float) $assets[0]->jewelry_pawned_loan_amount : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. When/date</td>
                                                    <td><?php echo e($assets[0]->jewelry_pawned_loan_when != '' ?  $assets[0]->jewelry_pawned_loan_when : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iv. Interest rate</td>
                                                    <td><?php echo e($assets[0]->jewelry_pawned_loan_interest != '' ? $assets[0]->jewelry_pawned_loan_interest : 0); ?>

                                                    </td>
                                                </tr>
                                            </tbody>
                                            <?php endif; ?>
                                        </table>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="70%">C. Any jewelry pawned to take loan got lost</th>
                                                    <th><?php echo e(checkna($assets[0]->jewelry_pawned_lost_yesno)); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if($assets[0]->jewelry_pawned_lost_yesno == 'Yes'): ?>
                                            <tbody>
                                                <tr>
                                                    <td>i. Lender Type</td>
                                                    <td><?php echo e($assets[0]->jewelry_pawned_lander_lost_type); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>ii. Amount</td>
                                                    <td><?php echo e((int) $assets[0]->jewelry_pawned_loan_lost_amount != '' ? (int) $assets[0]->jewelry_pawned_loan_lost_amount : 0); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iii. When/date</td>
                                                    <td><?php echo e($assets[0]->jewelry_pawned_loan_lost_when); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>iv. Interest rate</td>
                                                    <td><?php echo e($assets[0]->jewelry_pawned_loan_lost_interest != '' ? $assets[0]->jewelry_pawned_loan_lost_interest : 0); ?>

                                                    </td>
                                                </tr>
                                            </tbody>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                                <!-- end personal items -->
                                <!--start other  -->
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Other</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">A. Any other asset not shown above
                                                        (specify)
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e(checkna($assets[0]->fa_other_assets_A)); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">B. Has your family sold any labor on
                                                        advance
                                                        during last two years – yes/no</div>
                                                    <div class="col-6">
                                                        <?php echo e(checkna($assets[0]->fa_other_assets_B)); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($assets[0]->fa_other_assets_B == 'Yes'): ?>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">C. Explain Purpose</div>
                                                    <div class="col-6">
                                                        <?php echo e(checkna($assets[0]->fa_other_assets_C )); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">D. No of labor days/sold/advanced
                                                    </div>
                                                    <div class="col-6">
                                                        <?php echo e(checkZero($assets[0]->fa_other_assets_D)); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- end other -->
                                <!-- end house unit -->
                            </div>
                            <!----tab-3----->
                            <div class="tab-pane fade" id="v-pills-Goals" role="tabpanel" aria-labelledby="v-pills-Goals-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Goal</h5>

                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>#No.</th>
                                                    <th>Name of Goal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php $i=1; ?>
                                                    <?php if(!empty($goals)): ?>
                                                    <?php $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($i++); ?></td>
                                                    <td><?php echo e($row->fg_goal); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!----tab-4----->
                            <div class="tab-pane fade" id="v-pills-Agricultural" role="tabpane" aria-labelledby="v-pills-Agricultural-tab">
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Agriculture & Production</h5>

                                    </div>

                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th width="40%">Production Type</th>
                                                <th width="30%" colspan="2" style="text-align: center;">This
                                                    Year</th>
                                                <th width="30%" colspan="2" style="text-align: center;">Next
                                                    Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th></th>
                                                <th>Total</th>
                                                <th>View</th>
                                                <th>Total</th>
                                                <th>View</th>
                                            </tr>

                                            <tr>
                                                <td>Agriculture</td>
                                                <td><?php echo e($aggriculture_this[0]->cy_total); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($aggriculture_this[0]->id ?? 0); ?>" href="#exampleModalCenter2" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter2"><i class="c-white-500 ti-eye"></i></a></td>
                                                <td><?php echo e($aggriculture_next[0]->ny_total); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($aggriculture_next[0]->id ?? 0); ?>" href="#exampleModalCenter3" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter3"><i class="c-white-500 ti-eye"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>Live Stock</td>
                                                <td><?php echo e($live_this[0]->cy_total); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($live_this[0]->id ?? 0); ?>" href="#exampleModalCenter2" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter2"><i class="c-white-500 ti-eye"></i></a></td>
                                                <td><?php echo e($live_next[0]->ny_total); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($live_next[0]->id ?? 0); ?>" href="#exampleModalCenter3" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter3"><i class="c-white-500 ti-eye"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>Horticultural </td>
                                                <td><?php echo e($Horticultural_this[0]->cy_total); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($Horticultural_this[0]->id ?? 0); ?>" href="#exampleModalCenter2" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter2"><i class="c-white-500 ti-eye"></i></a></td>
                                                <td><?php echo e($Horticultural_next[0]->ny_total); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($Horticultural_next[0]->id ?? 0); ?>" href="#exampleModalCenter3" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter3"><i class="c-white-500 ti-eye"></i></a></td>
                                            </tr>

                                            <tr class="total">
                                                <td colspan="1">Total</td>
                                                <td><?php echo e((int) $aggriculture_this[0]->cy_total + (int) $live_this[0]->cy_total + (int) $Horticultural_this[0]->cy_total); ?>

                                                </td>
                                                <td></td>
                                                <td><?php echo e((int) $aggriculture_next[0]->ny_total + (int) $live_next[0]->ny_total + (int) $Horticultural_next[0]->ny_total); ?>

                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!----tab-5----->
                            <div class="tab-pane fade" id="v-pills-Savings" role="tabpane" aria-labelledby="v-pills-Savings-tab">
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Saving</h5>

                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th>Passbook Physically</th>
                                                <th>Passbook Updated</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo e($savings[0]->s_passbook_physically == 1 ? 'Yes' : 'No'); ?>

                                                </td>
                                                <td><?php echo e($savings[0]->s_passbook_updated == 1 ? 'Yes' : 'No'); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Saving Source</h5>
                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th>Type</th>
                                                <th>Saving Regularly</th>
                                                <th>Date Savings Started</th>
                                                <th>Amount Saved Per Month</th>
                                                <th>Saved During Last 12 Months</th>
                                                <th>Total Saving</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php if(!empty($savings_source)): ?>
                                            <?php
                                            $sum = 0;
                                            $sum1 = 0;
                                            $sum2 = 0;
                                            ?>
                                            <?php $__currentLoopData = $savings_source; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $sum = $sum + (float) $row['s_total_saving'];
                                            $sum1 = $sum1 + (float) $row['s_saving_per_month'];
                                            $sum2 = $sum2 + (float) $row['s_last_saved_amt'];
                                            ?>
                                            <tr>
                                                <td><?php echo e($row['s_type']); ?></td>
                                                <td><?php echo e($row['s_contribute_regular']); ?>

                                                </td>
                                                <td><?php echo e($row['s_started_from']); ?>

                                                </td>
                                                <td><?php echo e($row['s_saving_per_month']); ?></td>
                                                <td><?php echo e($row['s_last_saved_amt']); ?></td>
                                                <td><?php echo e($row['s_total_saving']); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>

                                        </tbody>

                                    </table>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Other Savings Source</h5>
                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th>Loan</th>
                                                <th>Where Fixed Deposit Made</th>
                                                <th>Date of Deposit</th>
                                                <th>Fixed Deposit Term Period</th>
                                                <th>Interest</th>
                                                <th>Saved During Last 12 Months</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($savings_source_other)): ?>
                                            <?php $sum_a=0; ?>
                                            <?php $__currentLoopData = $savings_source_other; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $sum_a=$sum_a+(float)$row->other_amount; ?>
                                            <tr>
                                                <td><?php echo e(checkna($row->other_loan)); ?></td>
                                                <td><?php echo e(checkna($row->other_where_fixed_deposit_made)); ?></td>
                                                <td><?php echo e($row->other_date_of_deposit != '' ? change_date_month_name_char(str_replace('/', '-', $row->other_date_of_deposit)) : 'N/A'); ?>

                                                </td>
                                                <td><?php echo e($row->other_fixed_deposit_term_period != '' ? $row->other_fixed_deposit_term_period : 0); ?>

                                                </td>
                                                <td><?php echo e($row->other_interest != '' ? $row->other_interest : 0); ?>

                                                </td>
                                                <td><?php echo e($row->last_saved_amt); ?>

                                                </td>
                                                <td><?php echo e($row->other_amount != '' ? $row->other_amount : 0); ?>

                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            <tr class="total">
                                                <td colspan="6">Total</td>
                                                <td><?php echo e($sum_a ?? 0); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!----tab-6----->

                            <div class="tab-pane fade" id="v-pills-Loan" role="tabpane" aria-labelledby="v-pills-Loan-tab">
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Family Loan Outstanding </h5>

                                    </div>
                                    <div class="accordion" id="accordionExample">

                                        <div class="table-responsive " id="headingTwo">
                                            <table class="table mytable">
                                                <thead class="back-color">
                                                    <tr>
                                                        <th style="padding-right: 10%">Loan Type</th>
                                                        <th>Principle Amount</th>
                                                        <th>Amount paid during last 12 months</th>
                                                        <th>Cumulative amount paid</th>
                                                        <th>Overdue Amount</th>
                                                        <th>Next Year loan Repayment</th>
                                                        <th>View</th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>

                                        

                                        <div class="table-responsive text-nowrap" id="headingOne">
                                            <table class="table mytable">

                                                <tbody>
                                                    <tr>
                                                        <th>SHG Loan</th>
                                                        <th><?php echo e($Shg_loan[0]->total_principle); ?></th>
                                                        <th><?php echo e($Shg_loan[0]->total_paid); ?></th>
                                                        <th><?php echo e($Shg_loan[0]->cumulative); ?></th>
                                                        <th><?php echo e($Shg_loan[0]->overdue); ?></th>
                                                        <th><?php echo e($Shg_loan[0]->loan_next); ?></th>
                                                        <th><button data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                <i class="c-white-500 ti-eye"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table mytable">
                                                    <thead class="back-color">
                                                        <tr>
                                                            <th>Loan Amount</th>
                                                            <th>Purpose</th>
                                                            <th>Specify</th>
                                                            <th>Interest type</th>
                                                            <th>Annual interest rate (%)</th>
                                                            <th>Loan tenure</th>
                                                            <th>Repayment start date</th>
                                                            <th>Last repayment date</th>
                                                            <th>Data collection date</th>
                                                            <th>No of EMIs paid during last 12 months</th>
                                                            <th>Total amount paid during last 12 months</th>
                                                            <th>No of cumulative EMIs repaid</th>
                                                            <th>Cumulative amount paid</th>
                                                            <th>Overdue amount</th>
                                                            <th>Next year loan repayment commitment</th>
                                                            <th>Additional Payment</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $sum = 0;
                                                    $sum1 = 0;
                                                    $sum2 = 0;
                                                    $sum3 = 0;
                                                    $sum4 = 0;
                                                    $sum5 = 0;
                                                    ?>
                                                    <tbody>
                                                        <?php $__currentLoopData = $Shg_loan_de; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                        $loan_tenure = '';
                                                        if ($res->lo_tenure_mode == 0) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                                                        } elseif ($res->lo_tenure_mode == 1) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                                                        }
                                                        $sum += checkZero($res->current_year_interest);
                                                        $sum1 += checkZero($res->lo_principle_amount);
                                                        $sum2 += checkZero($res->overdue);
                                                        $sum3 += checkZero($res->lo_next_year);
                                                        $sum4 += checkZero($res->total_paid_interest);
                                                        $sum5 += checkZero($res->addition_amount);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo e($res->lo_principle_amount); ?></td>
                                                            <td><?php echo e($res->lo_purpose); ?></td>
                                                            <td><?php echo e($res->cate_specify); ?></td>
                                                            <td><?php echo e($res->lo_interest_type); ?></td>
                                                            <td><?php echo e($res->lo_interest_rate); ?></td>
                                                            <td><?php echo e($loan_tenure); ?></td>
                                                            <td><?php echo e($res->lo_start_date); ?></td>
                                                            <td><?php echo e($res->lo_last_Repayment_to_paid); ?></td>
                                                            <td><?php echo e($res->lo_data_collection_date); ?></td>
                                                            <td><?php echo e($res->current_year_principal); ?></td>
                                                            <td><?php echo e($res->current_year_interest); ?></td>
                                                            <td><?php echo e($res->total_paid_principal); ?></td>
                                                            <td><?php echo e($res->total_paid_interest); ?></td>
                                                            <td><?php echo e($res->overdue); ?></td>
                                                            <td><?php echo e($res->lo_next_year); ?></td>
                                                            <td><?php echo e($res->addition_amount); ?></td>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="total">
                                                            <td><?php echo e($sum1); ?></td>
                                                            <td colspan="9"></td>
                                                            <td colspan=""><?php echo e($sum); ?></td>
                                                            <td colspan=""></td>
                                                            <td colspan=""><?php echo e($sum4); ?></td>
                                                            <td colspan=""><?php echo e($sum2); ?></td>
                                                            <td colspan=""><?php echo e($sum3); ?></td>
                                                            <td><?php echo e($sum5); ?> </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        

                                        <div class="table-responsive text-nowrap" id="headingTwo">
                                            <table class="table mytable">
                                                <thead>
                                                    <tr>
                                                        <th>MONEY LENDER LOAN</th>
                                                        <th><?php echo e($money_loan[0]->total_principle); ?></th>
                                                        <th><?php echo e($money_loan[0]->total_paid); ?></th>
                                                        <th><?php echo e($money_loan[0]->cumulative); ?></th>
                                                        <th><?php echo e($money_loan[0]->overdue); ?></th>
                                                        <th><?php echo e($money_loan[0]->loan_next); ?></th>
                                                        <th><button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                                <i class="c-white-500 ti-eye"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table mytable">
                                                    <thead class="back-color">
                                                        <tr>
                                                            <th>Loan Amount</th>
                                                            <th>Purpose</th>
                                                            <th>Specify</th>
                                                            <th>Interest type</th>
                                                            <th>Annual interest rate (%)</th>
                                                            <th>Loan tenure</th>
                                                            <th>Repayment start date</th>
                                                            <th>Last repayment date</th>
                                                            <th>Data collection date</th>
                                                            <th>No of EMIs paid during last 12 months</th>
                                                            <th>Total amount paid during last 12 months</th>
                                                            <th>No of cumulative EMIs repaid</th>
                                                            <th>Cumulative amount paid</th>
                                                            <th>Overdue amount</th>
                                                            <th>Next year loan repayment commitment</th>
                                                            <th>Additional Payment</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $sum_m = 0;
                                                    $sum_m1 = 0;
                                                    $sum_m2 = 0;
                                                    $sum_m3 = 0;
                                                    $sum_m4 = 0;
                                                    $sum_m5 = 0;
                                                    ?>
                                                    <tbody>
                                                        <?php $__currentLoopData = $money_loan_de; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                        $loan_tenure = '';
                                                        if ($res->lo_tenure_mode == 0) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                                                        } elseif ($res->lo_tenure_mode == 1) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                                                        }
                                                        $sum_m += checkZero($res->total_paid_interest);
                                                        $sum_m1 += checkZero($res->lo_principle_amount);
                                                        $sum_m2 += checkZero($res->overdue);
                                                        $sum_m3 += checkZero($res->lo_next_year);
                                                        $sum_m4 += checkZero($res->current_year_interest);
                                                        $sum_m5 += checkZero($res->addition_amount);

                                                        ?>
                                                        <tr>
                                                            <td><?php echo e($res->lo_principle_amount); ?></td>
                                                            <td><?php echo e($res->lo_purpose); ?></td>
                                                            <td><?php echo e($res->cate_specify); ?></td>
                                                            <td><?php echo e($res->lo_interest_type); ?></td>
                                                            <td><?php echo e($res->lo_interest_rate); ?></td>
                                                            <td><?php echo e($loan_tenure); ?></td>
                                                            <td><?php echo e($res->lo_start_date); ?></td>
                                                            <td><?php echo e($res->lo_last_Repayment_to_paid); ?></td>
                                                            <td><?php echo e($res->lo_data_collection_date); ?></td>
                                                            <td><?php echo e($res->current_year_principal); ?></td>
                                                            <td><?php echo e($res->current_year_interest); ?></td>
                                                            <td><?php echo e($res->total_paid_principal); ?></td>
                                                            <td><?php echo e($res->total_paid_interest); ?></td>
                                                            <td><?php echo e($res->overdue); ?></td>
                                                            <td><?php echo e($res->lo_next_year); ?></td>
                                                            <td><?php echo e($res->addition_amount); ?></td>

                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="total">
                                                            <td><?php echo e($sum_m1); ?></td>
                                                            <td colspan="9"></td>

                                                            <td colspan=""><?php echo e($sum_m4); ?></td>
                                                            <td colspan=""></td>
                                                            <td colspan=""><?php echo e($sum_m); ?></td>
                                                            <td colspan=""><?php echo e($sum_m2); ?></td>
                                                            <td colspan=""><?php echo e($sum_m3); ?></td>
                                                            <td><?php echo e($sum_m5); ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        

                                        <div class="table-responsive text-nowrap" id="headingThree">
                                            <table class="table mytable">
                                                <thead>
                                                    <tr>
                                                        <th>BANK LOAN</th>
                                                        <th><?php echo e($bank_loan[0]->total_principle); ?></th>
                                                        <th><?php echo e($bank_loan[0]->total_paid); ?></th>
                                                        <th><?php echo e($bank_loan[0]->cumulative); ?></th>
                                                        <th><?php echo e($bank_loan[0]->overdue); ?></th>
                                                        <th><?php echo e($bank_loan[0]->loan_next); ?></th>
                                                        <th><button data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                                <i class="c-white-500 ti-eye"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table mytable">
                                                    <thead class="back-color">
                                                        <tr>
                                                            <th>Loan Amount</th>
                                                            <th>Purpose</th>
                                                            <th>Specify</th>
                                                            <th>Interest type</th>
                                                            <th>Annual interest rate (%)</th>
                                                            <th>Loan tenure</th>
                                                            <th>Repayment start date</th>
                                                            <th>Last repayment date</th>
                                                            <th>Data collection date</th>
                                                            <th>No of EMIs paid during last 12 months</th>
                                                            <th>Total amount paid during last 12 months</th>
                                                            <th>No of cumulative EMIs repaid</th>
                                                            <th>Cumulative amount paid</th>
                                                            <th>Overdue amount</th>
                                                            <th>Next year loan repayment commitment</th>
                                                            <th>Additional Payment</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $sum_b = 0;
                                                    $sum_b1 = 0;
                                                    $sum_b2 = 0;
                                                    $sum_b3 = 0;
                                                    $sum_b4 = 0;
                                                    $sum_b5 = 0;

                                                    ?>
                                                    <tbody>
                                                        <?php $__currentLoopData = $bank_loan_de; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                        $loan_tenure = '';
                                                        if ($res->lo_tenure_mode == 0) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                                                        } elseif ($res->lo_tenure_mode == 1) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                                                        }
                                                        $sum_b += checkZero($res->total_paid_interest);
                                                        $sum_b1 += checkZero($res->lo_principle_amount);
                                                        $sum_b2 += checkZero($res->overdue);
                                                        $sum_b3 += checkZero($res->lo_next_year);
                                                        $sum_b4 += checkZero($res->current_year_interest) ;
                                                        $sum_b5 += checkZero($res->addition_amount);


                                                        ?>
                                                        <tr>
                                                            <td><?php echo e($res->lo_principle_amount); ?></td>
                                                            <td><?php echo e($res->lo_purpose); ?></td>
                                                            <td><?php echo e($res->cate_specify); ?></td>
                                                            <td><?php echo e($res->lo_interest_type); ?></td>
                                                            <td><?php echo e($res->lo_interest_rate); ?></td>
                                                            <td><?php echo e($loan_tenure); ?></td>
                                                            <td><?php echo e($res->lo_start_date); ?></td>
                                                            <td><?php echo e($res->lo_last_Repayment_to_paid); ?></td>
                                                            <td><?php echo e($res->lo_data_collection_date); ?></td>
                                                            <td><?php echo e($res->current_year_principal); ?></td>
                                                            <td><?php echo e($res->current_year_interest); ?></td>
                                                            <td><?php echo e($res->total_paid_principal); ?></td>
                                                            <td><?php echo e($res->total_paid_interest); ?></td>
                                                            <td><?php echo e($res->overdue); ?></td>
                                                            <td><?php echo e($res->lo_next_year); ?></td>
                                                            <td><?php echo e($res->addition_amount); ?></td>

                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="total">
                                                            <td><?php echo e($sum_b1); ?></td>
                                                            <td colspan="9"></td>
                                                            <td colspan=""><?php echo e($sum_b4); ?></td>
                                                            <td colspan=""></td>
                                                            <td colspan=""><?php echo e($sum_b); ?></td>
                                                            <td colspan=""><?php echo e($sum_b2); ?></td>
                                                            <td colspan=""><?php echo e($sum_b3); ?></td>
                                                            <td><?php echo e($sum_b5); ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        

                                        <div class="table-responsive text-nowrap" id="headingFour">
                                            <table class="table mytable">
                                                <thead>
                                                    <tr>
                                                        <th>NBFC LOAN</th>
                                                        <th><?php echo e($nbfc_loan[0]->total_principle); ?></th>
                                                        <th><?php echo e($nbfc_loan[0]->total_paid); ?></th>
                                                        <th><?php echo e($nbfc_loan[0]->cumulative); ?></th>
                                                        <th><?php echo e($nbfc_loan[0]->overdue); ?></th>
                                                        <th><?php echo e($nbfc_loan[0]->loan_next); ?></th>
                                                        <th><button data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                                <i class="c-white-500 ti-eye"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table mytable">
                                                    <thead class="back-color">
                                                        <tr>
                                                            <th>Loan Amount</th>
                                                            <th>Purpose</th>
                                                            <th>Specify</th>
                                                            <th>Interest type</th>
                                                            <th>Annual interest rate (%)</th>
                                                            <th>Loan tenure</th>
                                                            <th>Repayment start date</th>
                                                            <th>Last repayment date</th>
                                                            <th>Data collection date</th>
                                                            <th>No of EMIs paid during last 12 months</th>
                                                            <th>Total amount paid during last 12 months</th>
                                                            <th>No of cumulative EMIs repaid</th>
                                                            <th>Cumulative amount paid</th>
                                                            <th>Overdue amount</th>
                                                            <th>Next year loan repayment commitment</th>
                                                            <th>Additional Payment</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $sum_v = 0;
                                                    $sum_v1 = 0;
                                                    $sum_v2 = 0;
                                                    $sum_v3 = 0;
                                                    $sum_v4 = 0;
                                                    $sum_v5 = 0;


                                                    ?>
                                                    <tbody>
                                                        <?php $__currentLoopData = $nbfc_loan_de; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                        $loan_tenure = '';
                                                        if ($res->lo_tenure_mode == 0) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                                                        } elseif ($res->lo_tenure_mode == 1) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                                                        }
                                                        $sum_v += checkZero($res->total_paid_interest);
                                                        $sum_v1 += checkZero($res->lo_principle_amount);
                                                        $sum_v2 += checkZero($res->overdue);
                                                        $sum_v3 += checkZero($res->lo_next_year);
                                                        $sum_v4 += checkZero($res->current_year_interest);
                                                        $sum_v5 += checkZero($res->addition_amount);



                                                        ?>
                                                        <tr>
                                                            <td><?php echo e($res->lo_principle_amount); ?></td>
                                                            <td><?php echo e($res->lo_purpose); ?></td>
                                                            <td><?php echo e($res->cate_specify); ?></td>
                                                            <td><?php echo e($res->lo_interest_type); ?></td>
                                                            <td><?php echo e($res->lo_interest_rate); ?></td>
                                                            <td><?php echo e($loan_tenure); ?></td>
                                                            <td><?php echo e($res->lo_start_date); ?></td>
                                                            <td><?php echo e($res->lo_last_Repayment_to_paid); ?></td>
                                                            <td><?php echo e($res->lo_data_collection_date); ?></td>
                                                            <td><?php echo e($res->current_year_principal); ?></td>
                                                            <td><?php echo e($res->current_year_interest); ?></td>
                                                            <td><?php echo e($res->total_paid_principal); ?></td>
                                                            <td><?php echo e($res->total_paid_interest); ?></td>
                                                            <td><?php echo e($res->overdue); ?></td>
                                                            <td><?php echo e($res->lo_next_year); ?></td>
                                                            <td><?php echo e($res->addition_amount); ?></td>

                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="total">
                                                            <td><?php echo e($sum_v1); ?></td>
                                                            <td colspan="9"></td>
                                                            <td colspan=""><?php echo e($sum_v4); ?></td>
                                                            <td colspan=""></td>
                                                            <td colspan=""><?php echo e($sum_v); ?></td>
                                                            <td colspan=""><?php echo e($sum_v2); ?></td>
                                                            <td colspan=""><?php echo e($sum_v3); ?></td>
                                                            <td><?php echo e($sum_v5); ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        

                                        <div class="table-responsive text-nowrap" id="headingFive">
                                            <table class="table mytable">
                                                <thead>
                                                    <tr>
                                                        <th>CLUSTER LOAN</th>
                                                        <th><?php echo e($cluster_loan[0]->total_principle); ?></th>
                                                        <th><?php echo e($cluster_loan[0]->total_paid); ?></th>
                                                        <th><?php echo e($cluster_loan[0]->cumulative); ?></th>
                                                        <th><?php echo e($cluster_loan[0]->overdue); ?></th>
                                                        <th><?php echo e($cluster_loan[0]->loan_next); ?></th>
                                                        <th><button data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                                                <i class="c-white-500 ti-eye"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table mytable">
                                                    <thead class="back-color">
                                                        <tr>
                                                            <th>Loan Amount</th>
                                                            <th>Purpose</th>
                                                            <th>Specify</th>
                                                            <th>Interest type</th>
                                                            <th>Annual interest rate (%)</th>
                                                            <th>Loan tenure</th>
                                                            <th>Repayment start date</th>
                                                            <th>Last repayment date</th>
                                                            <th>Data collection date</th>
                                                            <th>No of EMIs paid during last 12 months</th>
                                                            <th>Total amount paid during last 12 months</th>
                                                            <th>No of cumulative EMIs repaid</th>
                                                            <th>Cumulative amount paid</th>
                                                            <th>Overdue amount</th>
                                                            <th>Next year loan repayment commitment</th>
                                                            <th>Additional Payment</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $sum_c = 0;
                                                    $sum_c1 = 0;
                                                    $sum_c2 = 0;
                                                    $sum_c3 = 0;
                                                    $sum_c4 = 0;
                                                    $sum_c5 = 0;


                                                    ?>
                                                    <tbody>
                                                        <?php $__currentLoopData = $cluster_loan_de; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                        $loan_tenure = '';
                                                        if ($res->lo_tenure_mode == 0) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                                                        } elseif ($res->lo_tenure_mode == 1) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                                                        }
                                                        $sum_c += checkZero($res->total_paid_interest);
                                                        $sum_c1 += checkZero($res->lo_principle_amount);
                                                        $sum_c2 += checkZero($res->overdue);
                                                        $sum_c3 += checkZero($res->lo_next_year);
                                                        $sum_c4 += checkZero($res->current_year_interest);
                                                        $sum_c5 += checkZero($res->addition_amount);


                                                        ?>
                                                        <tr>
                                                            <td><?php echo e($res->lo_principle_amount); ?></td>
                                                            <td><?php echo e($res->lo_purpose); ?></td>
                                                            <td><?php echo e($res->cate_specify); ?></td>
                                                            <td><?php echo e($res->lo_interest_type); ?></td>
                                                            <td><?php echo e($res->lo_interest_rate); ?></td>
                                                            <td><?php echo e($loan_tenure); ?></td>
                                                            <td><?php echo e($res->lo_start_date); ?></td>
                                                            <td><?php echo e($res->lo_last_Repayment_to_paid); ?></td>
                                                            <td><?php echo e($res->lo_data_collection_date); ?></td>
                                                            <td><?php echo e($res->current_year_principal); ?></td>
                                                            <td><?php echo e($res->current_year_interest); ?></td>
                                                            <td><?php echo e($res->total_paid_principal); ?></td>
                                                            <td><?php echo e($res->total_paid_interest); ?></td>
                                                            <td><?php echo e($res->overdue); ?></td>
                                                            <td><?php echo e($res->lo_next_year); ?></td>
                                                            <td><?php echo e($res->addition_amount); ?></td>

                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="total">
                                                            <td><?php echo e($sum_c1); ?></td>
                                                            <td colspan="9"></td>
                                                            <td colspan=""><?php echo e($sum_c4); ?></td>
                                                            <td colspan=""></td>
                                                            <td colspan=""><?php echo e($sum_c); ?></td>
                                                            <td colspan=""><?php echo e($sum_c2); ?></td>
                                                            <td colspan=""><?php echo e($sum_c3); ?></td>
                                                            <td><?php echo e($sum_c5); ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        

                                        <div class="table-responsive text-nowrap" id="headingSix">
                                            <table class="table mytable">
                                                <thead>
                                                    <tr>
                                                        <th>FEDERATION LOAN</th>
                                                        <th><?php echo e($fed_loan[0]->total_principle); ?></th>
                                                        <th><?php echo e($fed_loan[0]->total_paid); ?></th>
                                                        <th><?php echo e($fed_loan[0]->cumulative); ?></th>
                                                        <th><?php echo e($fed_loan[0]->overdue); ?></th>
                                                        <th><?php echo e($fed_loan[0]->loan_next); ?></th>
                                                        <th><button data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                                                <i class="c-white-500 ti-eye"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table mytable">
                                                    <thead class="back-color">
                                                        <tr>
                                                            <th>Loan Amount</th>
                                                            <th>Purpose</th>
                                                            <th>Specify</th>
                                                            <th>Interest type</th>
                                                            <th>Annual interest rate (%)</th>
                                                            <th>Loan tenure</th>
                                                            <th>Repayment start date</th>
                                                            <th>Last repayment date</th>
                                                            <th>Data collection date</th>
                                                            <th>No of EMIs paid during last 12 months</th>
                                                            <th>Total amount paid during last 12 months</th>
                                                            <th>No of cumulative EMIs repaid</th>
                                                            <th>Cumulative amount paid</th>
                                                            <th>Overdue amount</th>
                                                            <th>Next year loan repayment commitment</th>
                                                            <th>Additional Payment</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $sum_f = 0;
                                                    $sum_f1 = 0;
                                                    $sum_f2 = 0;
                                                    $sum_f3 = 0;
                                                    $sum_f4 = 0;
                                                    $sum_f5 = 0;


                                                    ?>
                                                    <tbody>
                                                        <?php $__currentLoopData = $fed_loan_de; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                        $loan_tenure = '';
                                                        if ($res->lo_tenure_mode == 0) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                                                        } elseif ($res->lo_tenure_mode == 1) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                                                        }
                                                        $sum_f += checkZero($res->total_paid_interest);
                                                        $sum_f1 += checkZero($res->lo_principle_amount);
                                                        $sum_f2 += checkZero($res->overdue);
                                                        $sum_f3 += checkZero($res->lo_next_year);
                                                        $sum_f4 += checkZero($res->current_year_interest);
                                                        $sum_f5 += checkZero($res->addition_amount);


                                                        ?>
                                                        <tr>
                                                            <td><?php echo e($res->lo_principle_amount); ?></td>
                                                            <td><?php echo e($res->lo_purpose); ?></td>
                                                            <td><?php echo e($res->cate_specify); ?></td>
                                                            <td><?php echo e($res->lo_interest_type); ?></td>
                                                            <td><?php echo e($res->lo_interest_rate); ?></td>
                                                            <td><?php echo e($loan_tenure); ?></td>
                                                            <td><?php echo e($res->lo_start_date); ?></td>
                                                            <td><?php echo e($res->lo_last_Repayment_to_paid); ?></td>
                                                            <td><?php echo e($res->lo_data_collection_date); ?></td>
                                                            <td><?php echo e($res->current_year_principal); ?></td>
                                                            <td><?php echo e($res->current_year_interest); ?></td>
                                                            <td><?php echo e($res->total_paid_principal); ?></td>
                                                            <td><?php echo e($res->total_paid_interest); ?></td>
                                                            <td><?php echo e($res->overdue); ?></td>
                                                            <td><?php echo e($res->lo_next_year); ?></td>
                                                            <td><?php echo e($res->addition_amount); ?></td>

                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="total">
                                                            <td><?php echo e($sum_f1); ?></td>
                                                            <td colspan="9"></td>
                                                            <td colspan=""><?php echo e($sum_f4); ?></td>
                                                            <td colspan=""></td>
                                                            <td colspan=""><?php echo e($sum_f); ?></td>
                                                            <td colspan=""><?php echo e($sum_f2); ?></td>
                                                            <td colspan=""><?php echo e($sum_f3); ?></td>
                                                            <td><?php echo e($sum_f5); ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        

                                        <div class="table-responsive text-nowrap" id="headingSix">
                                            <table class="table mytable">
                                                <thead>
                                                    <tr>
                                                        <th>MFI LOAN</th>
                                                        <th><?php echo e($mfi_loan[0]->total_principle); ?></th>
                                                        <th><?php echo e($mfi_loan[0]->total_paid); ?></th>
                                                        <th><?php echo e($mfi_loan[0]->cumulative); ?></th>
                                                        <th><?php echo e($mfi_loan[0]->overdue); ?></th>
                                                        <th><?php echo e($mfi_loan[0]->loan_next); ?></th>
                                                        <th><button data-toggle="collapse" data-target="#collapseeight" aria-expanded="true" aria-controls="collapseeight">
                                                                <i class="c-white-500 ti-eye"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                        <div id="collapseeight" class="collapse" aria-labelledby="headingeight" data-parent="#accordionExample">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table mytable">
                                                    <thead class="back-color">
                                                        <tr>
                                                            <th>Loan Amount</th>
                                                            <th>Purpose</th>
                                                            <th>Specify</th>
                                                            <th>Interest type</th>
                                                            <th>Annual interest rate (%)</th>
                                                            <th>Loan tenure</th>
                                                            <th>Repayment start date</th>
                                                            <th>Last repayment date</th>
                                                            <th>Data collection date</th>
                                                            <th>No of EMIs paid during last 12 months</th>
                                                            <th>Total amount paid during last 12 months</th>
                                                            <th>No of cumulative EMIs repaid</th>
                                                            <th>Cumulative amount paid</th>
                                                            <th>Overdue amount</th>
                                                            <th>Next year loan repayment commitment</th>
                                                            <th>Additional Payment</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $sum_mf = 0;
                                                    $sum_mf1 = 0;
                                                    $sum_mf2 = 0;
                                                    $sum_mf3 = 0;
                                                    $sum_mf4 = 0;
                                                    $sum_mf5 = 0;


                                                    ?>
                                                    <tbody>
                                                        <?php $__currentLoopData = $mfi_loan_de; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                        $loan_tenure = '';
                                                        if ($res->lo_tenure_mode == 0) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                                                        } elseif ($res->lo_tenure_mode == 1) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                                                        }
                                                        $sum_mf += checkZero($res->total_paid_interest);
                                                        $sum_mf1 += checkZero($res->lo_principle_amount);
                                                        $sum_mf2 += checkZero($res->overdue);
                                                        $sum_mf3 += checkZero($res->lo_next_year);
                                                        $sum_mf4 += checkZero($res->current_year_interest);
                                                        $sum_mf5 += checkZero($res->addition_amount);


                                                        ?>
                                                        <tr>
                                                            <td><?php echo e($res->lo_principle_amount); ?></td>
                                                            <td><?php echo e($res->lo_purpose); ?></td>
                                                            <td><?php echo e($res->cate_specify); ?></td>
                                                            <td><?php echo e($res->lo_interest_type); ?></td>
                                                            <td><?php echo e($res->lo_interest_rate); ?></td>
                                                            <td><?php echo e($loan_tenure); ?></td>
                                                            <td><?php echo e($res->lo_start_date); ?></td>
                                                            <td><?php echo e($res->lo_last_Repayment_to_paid); ?></td>
                                                            <td><?php echo e($res->lo_data_collection_date); ?></td>
                                                            <td><?php echo e($res->current_year_principal); ?></td>
                                                            <td><?php echo e($res->current_year_interest); ?></td>
                                                            <td><?php echo e($res->total_paid_principal); ?></td>
                                                            <td><?php echo e($res->total_paid_interest); ?></td>
                                                            <td><?php echo e($res->overdue); ?></td>
                                                            <td><?php echo e($res->lo_next_year); ?></td>
                                                            <td><?php echo e($res->addition_amount); ?></td>

                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="total">
                                                            <td><?php echo e($sum_mf1); ?></td>
                                                            <td colspan="9"></td>
                                                            <td colspan=""><?php echo e($sum_mf4); ?></td>
                                                            <td colspan=""></td>
                                                            <td colspan=""><?php echo e($sum_mf); ?></td>
                                                            <td colspan=""><?php echo e($sum_mf2); ?></td>
                                                            <td colspan=""><?php echo e($sum_mf3); ?></td>
                                                            <td><?php echo e($sum_mf5); ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        

                                        <div class="table-responsive text-nowrap" id="headingSeven">
                                            <table class="table mytable">
                                                <thead>
                                                    <tr>
                                                        <th>OTHER LOAN</th>
                                                        <th><?php echo e($other_loan[0]->total_principle); ?></th>
                                                        <th><?php echo e($other_loan[0]->total_paid); ?></th>
                                                        <th><?php echo e($other_loan[0]->cumulative); ?></th>
                                                        <th><?php echo e($other_loan[0]->overdue); ?></th>
                                                        <th><?php echo e($other_loan[0]->loan_next); ?></th>
                                                        <th><button data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                                                <i class="c-white-500 ti-eye"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table mytable">
                                                    <thead class="back-color">
                                                        <tr>
                                                            <th>Loan Amount</th>
                                                            <th>Purpose</th>
                                                            <th>Source Of loan</th>
                                                            <th>Interest type</th>
                                                            <th>Annual interest rate (%)</th>
                                                            <th>Loan tenure</th>
                                                            <th>Repayment start date</th>
                                                            <th>Last repayment date</th>
                                                            <th>Data collection date</th>
                                                            <th>No of EMIs paid during last 12 months</th>
                                                            <th>Total amount paid during last 12 months</th>
                                                            <th>No of cumulative EMIs repaid</th>
                                                            <th>Cumulative amount paid</th>
                                                            <th>Overdue amount</th>
                                                            <th>Next year loan repayment commitment</th>
                                                            <th>Additional Payment</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $sum_o = 0;
                                                    $sum_o1 = 0;
                                                    $sum_o2 = 0;
                                                    $sum_o3 = 0;
                                                    $sum_o4 = 0;
                                                    $sum_o5 = 0;

                                                    ?>
                                                    <tbody>
                                                        <?php $__currentLoopData = $other_loan_de; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                        $loan_tenure = '';
                                                        if ($res->lo_tenure_mode == 0) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                                                        } elseif ($res->lo_tenure_mode == 1) {
                                                        $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                                                        }
                                                        $sum_o += checkZero($res->total_paid_interest);
                                                        $sum_o1 += checkZero($res->lo_principle_amount);
                                                        $sum_o2 += checkZero($res->overdue);
                                                        $sum_o3 += checkZero($res->lo_next_year);
                                                        $sum_o4 += checkZero($res->current_year_interest);
                                                        $sum_o5 += checkZero($res->addition_amount);


                                                        ?>
                                                        <tr>
                                                            <td><?php echo e($res->lo_principle_amount); ?></td>
                                                            <td><?php echo e($res->lo_purpose); ?></td>
                                                            <td><?php echo e($res->cate_specify); ?></td>
                                                            <td><?php echo e($res->lo_interest_type); ?></td>
                                                            <td><?php echo e($res->lo_interest_rate); ?></td>
                                                            <td><?php echo e($loan_tenure); ?></td>
                                                            <td><?php echo e($res->lo_start_date); ?></td>
                                                            <td><?php echo e($res->lo_last_Repayment_to_paid); ?></td>
                                                            <td><?php echo e($res->lo_data_collection_date); ?></td>
                                                            <td><?php echo e($res->current_year_principal); ?></td>
                                                            <td><?php echo e($res->current_year_interest); ?></td>
                                                            <td><?php echo e($res->total_paid_principal); ?></td>
                                                            <td><?php echo e($res->total_paid_interest); ?></td>
                                                            <td><?php echo e($res->overdue); ?></td>
                                                            <td><?php echo e($res->lo_next_year); ?></td>
                                                            <td><?php echo e($res->addition_amount); ?></td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="total">
                                                            <td><?php echo e($sum_o1); ?></td>
                                                            <td colspan="9"></td>
                                                            <td colspan=""><?php echo e($sum_o4); ?></td>
                                                            <td colspan=""></td>
                                                            <td colspan=""><?php echo e($sum_o); ?></td>
                                                            <td colspan=""><?php echo e($sum_o2); ?></td>
                                                            <td colspan=""><?php echo e($sum_o3); ?></td>
                                                            <td><?php echo e($sum_o5); ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        
                                        <div class="table-responsive text-nowrap" id="headingSeven">
                                            <table class="table mytable">
                                                <thead>
                                                    <tr class="total">
                                                        <td>Total</td>
                                                        <td><?php echo e($loan_total[0]->principle); ?></td>
                                                        <td><?php echo e($loan_total[0]->total_paid); ?></td>
                                                        <td><?php echo e($loan_total[0]->cumulative); ?></td>
                                                        <td><?php echo e($loan_total[0]->overdue); ?></td>
                                                        <td><?php echo e($loan_total[0]->next); ?></td>
                                                        <td></td>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>

                                    </div>









                                </div>
                            </div>

                            <!----tab-7----->
                            <div class="tab-pane fade" id="v-pills-Budget" role="tabpane" aria-labelledby="v-pills-Budget-tab">
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Family’s Current and Next Year Budget </h5>

                                    </div>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Income </h5>
                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th>Income Source</th>
                                                <th>This Year</th>
                                                <th>View</th>
                                                <th>Next Year</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Agriculture</td>
                                                <td><?php echo e(!empty($income_this_year[0]->agriculture) ? (int) $income_this_year[0]->agriculture : 0); ?>

                                                </td>
                                                <td></td>
                                                <td><?php echo e(!empty($income_next_year[0]->agriculture) ? (int) $income_next_year[0]->agriculture : 0); ?>

                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Livestock</td>
                                                <td><?php echo e(!empty($income_this_year[0]->livestock) ? (int) $income_this_year[0]->livestock : 0); ?>

                                                </td>
                                                <td></td>
                                                <td><?php echo e(!empty($income_next_year[0]->livestock) ? (int) $income_next_year[0]->livestock : 0); ?>

                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Horticulture</td>
                                                <td><?php echo e(!empty($income_this_year[0]->horticulture) ? (int) $income_this_year[0]->horticulture : 0); ?>

                                                </td>
                                                <td></td>
                                                <td><?php echo e(!empty($income_next_year[0]->horticulture) ? (int) $income_next_year[0]->horticulture : 0); ?>

                                                </td>
                                                <td></td>
                                            </tr>


                                            <tr>
                                                <td>Sale of Livestock</td>
                                                <td><?php echo e(!empty($income_this_year[0]->sale_of_livestock) ? (int) $income_this_year[0]->sale_of_livestock : 0); ?>

                                                </td>
                                                <td></td>
                                                <td><?php echo e(!empty($income_next_year[0]->sale_of_livestock) ? (int) $income_next_year[0]->sale_of_livestock : 0); ?>

                                                </td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>Money Lending</td>
                                                <td><?php echo e(!empty($income_this_year[0]->money_lending) ? (int) $income_this_year[0]->money_lending : 0); ?>

                                                </td>
                                                <td></td>
                                                <td><?php echo e(!empty($income_next_year[0]->money_lending) ? (int) $income_next_year[0]->money_lending : 0); ?>

                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Fixed Income</td>
                                                <td><?php echo e(!empty($income_this_year[0]->fixed_income_amount) ? (int) $income_this_year[0]->fixed_income_amount : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($fixed_income[0]->ids ?? 0); ?>" data-val="1" href="#exampleModalCenter9" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter9"><i class="c-white-500 ti-eye"></i></a>
                                                </td>
                                                <td><?php echo e(!empty($income_next_year[0]->fixed_income_amount) ? (int) $income_next_year[0]->fixed_income_amount  : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($fixed_income_next[0]->ids ?? 0); ?>" data-val="2" href="#exampleModalCenter9" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter9"><i class="c-white-500 ti-eye"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Casual Income</td>
                                                <td><?php echo e(!empty($income_this_year[0]->casual_income_amount) ? (int) $income_this_year[0]->casual_income_amount  : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($casual_income[0]->ids ?? 0); ?>" data-val="1" href="#exampleModalCenter9" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter9"><i class="c-white-500 ti-eye"></i></a>
                                                </td>
                                                <td><?php echo e(!empty($income_next_year[0]->casual_income_amount) ? (int) $income_next_year[0]->casual_income_amount  : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($casual_income_next[0]->ids ?? 0); ?>" data-val="2" href="#exampleModalCenter9" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter9"><i class="c-white-500 ti-eye"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Trade Income</td>
                                                <td><?php echo e(!empty($income_this_year[0]->trade_income_amount) ? (int) $income_this_year[0]->trade_income_amount  : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($trade_income[0]->ids ?? 0); ?>" data-val="1" href="#exampleModalCenter9" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter9"><i class="c-white-500 ti-eye"></i></a>
                                                </td>
                                                <td><?php echo e(!empty($income_next_year[0]->trade_income_amount) ? (int) $income_next_year[0]->trade_income_amount  : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($trade_income_next[0]->ids ?? 0); ?>" data-val="2" href="#exampleModalCenter9" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter9"><i class="c-white-500 ti-eye"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pension Income </td>
                                                <td><?php echo e(!empty($income_this_year[0]->pension_income_monthly) ? (int) $income_this_year[0]->pension_income_monthly : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($pension_income[0]->ids ?? 0); ?>" data-val="1" href="#exampleModalCenter9" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter9"><i class="c-white-500 ti-eye"></i></a>
                                                </td>
                                                <td><?php echo e(!empty($income_next_year[0]->pension_income_monthly) ? (int) $income_next_year[0]->pension_income_monthly : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($pension_income_next[0]->ids ?? 0); ?>" data-val="2" href="#exampleModalCenter9" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter9"><i class="c-white-500 ti-eye"></i></a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Other Income</td>
                                                <td><?php echo e(!empty($income_this_year[0]->other_income) ? (int) $income_this_year[0]->other_income : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($other_income[0]->ids ?? 0); ?>" data-val="1" href="#exampleModalCenter9" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter9"><i class="c-white-500 ti-eye"></i></a>
                                                </td>
                                                <td><?php echo e(!empty($income_next_year[0]->other_income) ? (int) $income_next_year[0]->other_income : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($other_income_next[0]->ids ?? 0); ?>" data-val="2" href="#exampleModalCenter9" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter9"><i class="c-white-500 ti-eye"></i></a>
                                                </td>
                                            </tr>
                                            <tr class="total">
                                                <td colspan="">Total</td>
                                                <td><?php echo e((int) $income_this_year[0]->e_total_amount); ?></td>
                                                <td></td>
                                                <td><?php echo e((int) $income_next_year[0]->e_total_amount); ?></td>
                                                <td></td>
                                            </tr>
                                            <!-- <tr class="total">
                                        <td colspan="">Total</td>
                                        <td><?php echo e((!empty($income_this_year[0]->agriculture) ? (int) $income_this_year[0]->agriculture : 0) + (!empty($income_this_year[0]->livestock) ? (int) $income_this_year[0]->livestock : 0) + (!empty($income_this_year[0]->horticulture) ? (int) $income_this_year[0]->horticulture : 0) + (!empty($income_this_year[0]->fixed_income_amount) ? (int) $income_this_year[0]->fixed_income_amount * (int) $income_this_year[0]->fixed_month : 0) + (!empty($income_this_year[0]->casual_days) ? (int) $income_this_year[0]->casual_days * (int) $income_this_year[0]->casual_income_amount : 0) + (!empty($income_this_year[0]->sale_of_livestock) ? (int) $income_this_year[0]->sale_of_livestock : 0) + (!empty($income_this_year[0]->trade_income_amount) ? (int) $income_this_year[0]->trade_income_amount * (int) $income_this_year[0]->trade_month : 0) + (!empty($income_this_year[0]->money_lending) ? (int) $income_this_year[0]->money_lending : 0) + (!empty($income_this_year[0]->pension_income_monthly) ? (int) $income_this_year[0]->pension_income_monthly * 12 : 0)); ?></td>

                                        <td><?php echo e((!empty($income_next_year[0]->agriculture) ? (int) $income_next_year[0]->agriculture : 0)+ (!empty($income_next_year[0]->livestock) ? (int) $income_next_year[0]->livestock : 0) + (!empty($income_next_year[0]->horticulture) ? (int) $income_next_year[0]->horticulture : 0) + (!empty($income_next_year[0]->fixed_income_amount) ? (int) $income_next_year[0]->fixed_income_amount * (int) $income_next_year[0]->fixed_month : 0) + (!empty($income_next_year[0]->casual_days) ? (int) $income_next_year[0]->casual_days * (int) $income_next_year[0]->casual_income_amount : 0) + (!empty($income_next_year[0]->sale_of_livestock) ? (int) $income_next_year[0]->sale_of_livestock : 0) + (!empty($income_next_year[0]->trade_income_amount) ? (int) $income_next_year[0]->trade_income_amount * (int) $income_next_year[0]->trade_month : 0) + (!empty($income_next_year[0]->money_lending) ? (int) $income_next_year[0]->money_lending : 0) + (!empty($income_next_year[0]->pension_income_monthly) ? (int) $income_next_year[0]->pension_income_monthly * 12 : 0)); ?></td>
                                    </tr> -->
                                        </tbody>
                                    </table>
                                </div>



                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Expenditure This Year and Next Year</h5>
                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th width="40%">Category</th>
                                                <th width="30%" colspan="2" style="text-align: center;">This
                                                    Year</th>
                                                <th width="30%" colspan="2" style="text-align: center;">Next
                                                    Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th></th>
                                                <th>Total</th>
                                                <th>View</th>
                                                <th>Total</th>
                                                <th>View</th>
                                            </tr>

                                            <tr>
                                                <td>Normal Expenditure</td>
                                                <td><?php echo e($normal_exp_this[0]->cy_total); ?></td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($normal_exp_this[0]->id); ?>" href="#exampleModalCenter4" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter4"><i class="c-white-500 ti-eye"></i></a></td>
                                                <td><?php echo e($normal_exp_next[0]->ny_total); ?></td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($normal_exp_next[0]->id); ?>" href="#exampleModalCenter5" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter5"><i class="c-white-500 ti-eye"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>Social Expenditure</td>
                                                <td><?php echo e($social_exp_this[0]->cy_total); ?></td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($social_exp_this[0]->id); ?>" href="#exampleModalCenter4" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter4"><i class="c-white-500 ti-eye"></i></a></td>
                                                <td><?php echo e($social_exp_next[0]->ny_total); ?></td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($social_exp_next[0]->id); ?>" href="#exampleModalCenter5" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter5"><i class="c-white-500 ti-eye"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>Wasteful Expenditure</td>
                                                <td><?php echo e($waste_exp_this[0]->cy_total); ?></td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($waste_exp_this[0]->id); ?>" href="#exampleModalCenter4" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter4"><i class="c-white-500 ti-eye"></i></a></td>
                                                <td><?php echo e($waste_exp_next[0]->ny_total); ?></td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($waste_exp_next[0]->id); ?>" href="#exampleModalCenter5" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter5"><i class="c-white-500 ti-eye"></i></a></td>
                                            </tr>

                                            <tr>
                                                <td>Production/Business Expenses</td>
                                                <td><?php echo e($prod_exp_this[0]->cy_total); ?></td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($prod_exp_this[0]->id); ?>" href="#exampleModalCenter4" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter4"><i class="c-white-500 ti-eye"></i></a></td>
                                                <td><?php echo e($prod_exp_next[0]->ny_total); ?></td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($prod_exp_next[0]->id); ?>" href="#exampleModalCenter5" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter5"><i class="c-white-500 ti-eye"></i></a></td>
                                            </tr>

                                            <tr>
                                                <td>Loan Expenditure</td>
                                                <td><?php echo e(!empty($loan_outstanding_budget[0]->cy_value) ? $loan_outstanding_budget[0]->cy_value : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($loan_outstanding_budget[0]->id); ?>" href="#exampleModalCenter6" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter6"><i class="c-white-500 ti-eye"></i></a></td>
                                                <td><?php echo e(!empty($loan_outstanding_budget[0]->ny_value) ? $loan_outstanding_budget[0]->ny_value : 0); ?>

                                                </td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($loan_outstanding_budget[0]->id); ?>" href="#exampleModalCenter7" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter7"><i class="c-white-500 ti-eye"></i></a></td>
                                            </tr>

                                            <tr>
                                                <td>Savings</td>
                                                <td><?php echo e($saving_total[0]->saving_total); ?></td>
                                                <td><a data-toggle="modal" data-id="" href="#Savings_expenditure" class="btn btn-success btn-link btn-sm" data-target="#Savings_expenditure"><i class="c-white-500 ti-eye"></i></a></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr class="total">
                                                <td colspan="1">Total</td>
                                                <td><?php echo e((!empty($loan_outstanding_budget[0]->cy_value) ? $loan_outstanding_budget[0]->cy_value : 0) +
                                                        $normal_exp_this[0]->cy_total +
                                                        $social_exp_this[0]->cy_total +
                                                        $waste_exp_this[0]->cy_total +
                                                         $prod_exp_this[0]->cy_total +
                                                         $saving_total[0]->saving_total); ?>

                                                </td>
                                                <td></td>
                                                <td><?php echo e((!empty($loan_outstanding_budget[0]->ny_value) ? $loan_outstanding_budget[0]->ny_value : 0) +
                                                        $normal_exp_next[0]->ny_total +
                                                        $social_exp_next[0]->ny_total +
                                                        $waste_exp_next[0]->ny_total +
                                                        $prod_exp_next[0]->ny_total); ?>

                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!----tab-8----->
                            <div class="tab-pane fade" id="v-pills-Analysis" role="tabpane" aria-labelledby="v-pills-Analysis-tab">
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Family’s Current Year Analysis </h5>

                                    </div>
                                    <table class="table mytable table-responsive">
                                        <thead class="back-color">
                                            <tr>
                                                <th>SN</th>
                                                <th>Objective</th>
                                                <th>Indicators</th>
                                                <th>Total Score per objective</th>
                                                <th colspan="2">Current Year</th>
                                                <th colspan="2">Next Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td colspan="2"></td>
                                                <td></td>
                                                <td>Score</td>
                                                <td>Risk Level</td>
                                                <td>Score</td>
                                                <td>Risk Level</td>
                                            </tr>
                                            <tr>
                                                <td>A</td>
                                                <td colspan="2">Family Budget</td>
                                                <td>15</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td rowspan="2"></td>
                                                <td>Income and expenditure gap</td>
                                                <td>5</td>
                                                <td><?php echo e($analysis_1_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show1_cy); ?> '></div>
                                                </td>
                                                <td><?php echo e($analysis_1_ny); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show1_ny); ?> '></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Income and expenditure ratio</td>
                                                <td>10</td>
                                                <td><?php echo e($analysis_2_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show2_cy); ?> '></div>
                                                </td>
                                                <td><?php echo e($analysis_2_ny); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show2_ny); ?> '></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>B</td>
                                                <td colspan="2">Family Savings</td>
                                                <td>23</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td></td>
                                                <td>Compulsory savings contributed during last 12 months</td>
                                                <td>10</td>
                                                <td><?php echo e($analysis_3_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show3_cy); ?> '></div>
                                                </td>
                                                <td><?php echo e($analysis_3_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show3_cy); ?> '></div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td></td>
                                                <td>Voluntary savings contributed during last 12 months</td>
                                                <td>2</td>
                                                <td><?php echo e($analysis_4_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show4_cy); ?> '></div>
                                                </td>
                                                <td><?php echo e($analysis_4_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show4_cy); ?> '></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td></td>
                                                <td>Other Saving Source</td>
                                                <td>2</td>
                                                <td><?php echo e($analysis_other); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show_other); ?> '></div>
                                                </td>
                                                <td><?php echo e($analysis_other); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show_other); ?> '></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td></td>
                                                <td>Annual Savings to annual income ratio</td>
                                                <td>8</td>
                                                <td><?php echo e($analysis_5_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show5_cy); ?> '></div>
                                                </td>
                                                <td><?php echo e($analysis_5_ny); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show5_ny); ?> '></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td></td>
                                                <td>Updated passbook in possession of family</td>
                                                <td>1</td>
                                                <td><?php echo e($analysis_6_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show6_cy); ?> '></div>
                                                </td>
                                                <td><?php echo e($analysis_6_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show6_cy); ?> '></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>C</td>
                                                <td colspan="2">Family Credit History</td>
                                                <td>50</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td></td>
                                                <td>Annual Loan repayment and income ratio</td>
                                                <td>10</td>
                                                <td><?php echo e($analysis_7_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show7_cy); ?> '></div>
                                                </td>
                                                <td><?php echo e($analysis_7_ny); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show7_ny); ?> '></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>9</td>
                                                <td></td>
                                                <td>Debt service ratio</td>
                                                <td>10</td>
                                                <td><?php echo e($analysis_8_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show8_cy); ?> '></div>
                                                </td>
                                                <td><?php echo e($analysis_8_ny); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show8_ny); ?> '></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>10</td>
                                                <td></td>
                                                <td>Internal & External loan overdue </td>
                                                <td>20</td>

                                                <td><?php echo e($analysis_10_cy); ?></td>

                                                <td>
                                                    <div class='status_analysis <?php echo e($show10_cy); ?> '></div>
                                                </td>

                                                <td>N/A</td>
                                                <td>N/A</td>
                                            </tr>
                                            
                                            <tr>
                                                <td>11</td>
                                                <td></td>
                                                <td>Family Indebtedness</td>
                                                <td>10</td>
                                                <td><?php echo e($analysis_11_cy); ?></td>

                                                <td>
                                                    <div class='status_analysis <?php echo e($show11_cy); ?> '></div>
                                                </td>

                                                <td>N/A</td>
                                                <td>N/A</td>

                                            </tr>
                                            <tr>
                                                <td>D</td>
                                                <td colspan="2">Family Commitment to Group Rules</td>
                                                <td>12</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                            <tr>
                                                <td>12</td>
                                                <td></td>
                                                <td>Meeting attendance during last 12 months</td>
                                                <td>10</td>
                                                <td><?php echo e($analysis_12_ny); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show12_ny); ?> '></div>
                                                </td>
                                                <td><?php echo e($analysis_12_ny); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show12_ny); ?> '></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>13</td>
                                                <td></td>
                                                <td>Understanding of Group rules</td>
                                                <td>2</td>
                                                <td><?php echo e($analysis_13_ny); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show13_ny); ?> '></div>
                                                </td>
                                                <td><?php echo e($analysis_13_ny); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($show13_ny); ?> '></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="2">Total</td>
                                                <td>100</td>
                                                <td><?php echo e($grand_total_cy); ?></td>
                                                <td>
                                                    <div class='status_analysis <?php echo e($grdcolor); ?> '></div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!----tab-9----->
                            <div class="tab-pane fade" id="v-pills-Challenges" role="tabpane" aria-labelledby="v-pills-Challenges-tab">
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
                                            <?php $i=1; ?>
                                            <?php if(!empty($challenges)): ?>
                                            <?php $__currentLoopData = $challenges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($i++); ?></td>
                                                <td><?php echo e($row->challenges); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!----tab-10----->
                            <div class="tab-pane fade" id="v-pills-Action-Plan" role="tabpanel" aria-labelledby="v-pills-Action-Plan-tab">
                                <div class="family-box">
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
                                                <th><?php echo e($row->challenges); ?></th>
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
                                                <?php if(!empty($row['ch_actions'])): ?>
                                                <?php $__currentLoopData = $row['ch_actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                            <div class="tab-pane fade" id="v-pills-Business-Plan" role="tabpanel" aria-labelledby="v-pills-Business-Plan-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Family Business Plan </h5>

                                    </div>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="card-box">
                                        <table class="table table-bordered  mytable">
                                            <tr>
                                                <th>Member name</th>
                                                <td><?php echo e($family_profile[0]->fp_member_name); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Name of SHG</th>
                                                <td><?php echo e($shg_profile[0]->shgName); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Aadhar Card No</th>
                                                <td><?php echo e(aadhar($family_profile[0]->fp_aadhar_no)); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Husband Name</th>
                                                <td><?php echo e($family_profile[0]->fp_spouse_name); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Mobile Number</th>
                                                <td><?php echo e((int) $family_profile[0]->fp_contact_no); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Name of Cluster/Federation</th>
                                                <td><?php echo e(!empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A'); ?>

                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>


                                <div class="family-box mt-3">

                                    <div class="card-box">
                                        <div class="w-heading d-flex">
                                            <h5>BUSINESS INVESTMENT PLAN</h5>
                                        </div>
                                        <div class="card-box">
                                            <div class="row alldetail">
                                                <div class="col-md-6">
                                                    <div class="row detail">
                                                        <div class="col-6"><h6>Business Plan</h6>
                                                        </div>
                                                        <div class="col-6">
                                                            <?php echo e($business_investment_plan[0]->is_buisness_plan_avl); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if($business_investment_plan[0]->is_buisness_plan_avl == 'No'): ?>
                                                <div class="col-md-6">
                                                    <div class="row detail">
                                                        <div class="col-6">Comment
                                                        </div>
                                                        <div class="col-6">
                                                            <?php echo e($business_investment_plan[0]->comments); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                        <br>
                                        <?php if($business_investment_plan[0]->is_buisness_plan_avl != 'No'): ?>
                                        <table class="table mytable">

                                            <thead class="back-color">
                                                <tr>
                                                    <th width="25px">SN</th>
                                                    <th colspan="2">Type of category</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <th>Business Type/category</th>
                                                    <td><?php echo e($business_investment_plan[0]->type_of_category != '' ? $business_investment_plan[0]->type_of_category : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">A</th>
                                                    <th>Business sector</th>
                                                    <td><?php echo e($business_investment_plan[0]->type_of_business != '' ? $business_investment_plan[0]->type_of_business : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <th>New or Existing Business</th>
                                                    <td><?php echo e($business_investment_plan[0]->is_existing_business_plan != '' ? $business_investment_plan[0]->is_existing_business_plan : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <?php if($business_investment_plan[0]->is_existing_business_plan == 'New Business'): ?>
                                                <tr>
                                                    <th scope="row">A</th>
                                                    <th>Improving on exixting business or adding to the current
                                                        business</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->current_business)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">B</th>
                                                    <th>Friend/Relative in this new business</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->friend_relative_new_business)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">C</th>
                                                    <th>Market demand for this business</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->market_demand_business)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">D</th>
                                                    <th>Proposed activity</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->proposed_activity_new)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">E</th>
                                                    <th>Identified your competitors</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->have_competitors)); ?>

                                                    </td>
                                                </tr>
                                                <?php if($business_investment_plan[0]->have_competitors == 'Yes'): ?>
                                                <tr>
                                                    <th scope="row">F</th>
                                                    <th>Specify</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->if_yes_specify_competitors)); ?>

                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if($business_investment_plan[0]->is_existing_business_plan == 'Existing'): ?>
                                                <tr>
                                                    <th scope="row">A</th>
                                                    <th>Improving on exixting business or adding to the current
                                                        business</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->current_business)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">B</th>
                                                    <th>No of Years in Existing Business</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->how_long_family_business)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">C</th>
                                                    <th>Reason for expnsion</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->reasons_expansion)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">D</th>
                                                    <th>Proposed activity</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->proposed_activity_existing)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">E</th>
                                                    <th>Do you know where you would be selling your product</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->selling_product)); ?>

                                                    </td>
                                                </tr>
                                                <?php if($business_investment_plan[0]->selling_product == 'Yes'): ?>
                                                <tr>
                                                    <th scope="row">F</th>
                                                    <th>Marketing details</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->if_yes_specify)); ?>

                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <th>Date of Business Plan</th>
                                                    <td><?php echo e($business_investment_plan[0]->date_of_business_plan != '' ? change_date_month_name_char(str_replace('/', '-', $business_investment_plan[0]->date_of_business_plan)) : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">4</th>
                                                    <th>Family Member responsible for business</th>
                                                    <td><?php echo e(checkna($business_investment_plan[0]->primarily_business)); ?>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <?php if($business_investment_plan[0]->is_buisness_plan_avl != 'No'): ?>
                                <div div class="family-box mt-3">

                                    <div class="w-heading d-flex">
                                        <h5>TOTAL COST OF THE BUSINESS (ONE TIME)</h5>
                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th>S. No</th>

                                                <th>Name of items</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $sum = 0;
                                            $sum1 = 0;
                                            ?>
                                            <?php if(!empty($fixed_investment)): ?>
                                            <?php $__currentLoopData = $fixed_investment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $sum += (float) $row->amount;
                                            $sum1 += (float) $row->totalamount;
                                            ?>
                                            <tr>
                                                <td><?php echo e($i); ?></td>

                                                <td><?php echo e($row->name_of_item); ?>

                                                </td>
                                                <td><?php echo e($row->no_of_quantity); ?>

                                                </td>
                                                <td><?php echo e($row->amount); ?>

                                                </td>
                                                <td><?php echo e($row->totalamount); ?></td>
                                            </tr>
                                            <?php $i++ ; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="total">
                                                <td></td>
                                                <td colspan="2">Total</td>
                                                <td></td>
                                                <td><?php echo e($sum1); ?></td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr colspan="6">
                                                <th width="500px">Yearly Recurrent cost/operational expenses</th>
                                                <th>Total</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($yearly_operational_expenses[0]->expenses_type)): ?>
                                            <?php $__currentLoopData = $yearly_operational_expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($row->expenses_type); ?></td>
                                                <td><?php echo e($row->YearExpense); ?></td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($row->id); ?>" href="#exampleModalCenter" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter"><i class="c-white-500 ti-eye"></i></a></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr colspan="6">
                                                <th width="500px">INCOME FROM THE BUSINESS</th>
                                                <th>Total</th>
                                                <th>View</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($income_from_business[0]->income_type)): ?>
                                            <?php $__currentLoopData = $income_from_business; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($row->income_type); ?></td>
                                                <td><?php echo e($row->YearIncome); ?></td>
                                                <td><a data-toggle="modal" data-id="<?php echo e($row->id); ?>" href="#exampleModalCenter1" class="btn btn-success btn-link btn-sm" data-target="#exampleModalCenter1"><i class="c-white-500 ti-eye"></i></a></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>PROFIT/LOSS</h5>
                                    </div>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-12">
                                                <div class="row detail">
                                                    <div class="col-6">Fixed Assets</div>
                                                    <div class="col-6"><?php echo e((int) $fixed_assets); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th></th>
                                                <th>Year 1 Expenses</th>
                                                <th>Year 2 Expenses</th>
                                                <th>Year 3 Expenses</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Operational Cost</td>
                                                <td><?php echo e((float) $first_year_total_salesamts); ?></td>
                                                <td><?php echo e((float) $scnd_year_total_salesamts); ?></td>
                                                <td><?php echo e((float) $trd_year_total_salesamts); ?></td>
                                            </tr>

                                            <tr>
                                                <td>Loan Repayment</td>
                                                <td><?php echo e((float) $first_year_total_loanamts_fyear); ?></td>
                                                <td><?php echo e((float) $scnd_year_total_loanamts_fyear); ?></td>
                                                <td><?php echo e((float) $trd_year_total_loanamts_fyear); ?></td>
                                            </tr>

                                            <tr>
                                                <td>Interest Repayment</td>
                                                <td><?php echo e((float) $first_year_total_interestamts_fyear); ?></td>
                                                <td><?php echo e((float) $scnd_year_total_interestamts_fyear); ?></td>
                                                <td><?php echo e((float) $trd_year_total_interestamts_fyear); ?></td>
                                            </tr>
                                            <tr style="background-color: orange;color: #1630e2;font-weight: bolder;font-size: medium;">
                                                <td>Total</td>
                                                <td><?php echo e((float) $first_year_expansesamt); ?></td>
                                                <td><?php echo e((float) $scnd_year_expansesamt); ?></td>
                                                <td><?php echo e((float) $trd_year_expansesamt); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Income</td>
                                                <td><?php echo e((float) $first_year_total_incomeamts); ?></td>
                                                <td><?php echo e((float) $scnd_year_total_incomeamts); ?></td>
                                                <td><?php echo e((float) $trd_year_total_incomeamts); ?></td>
                                            </tr>
                                            <tr style="background-color: #b3aeae;color: #1630e2;font-weight: bolder;font-size: medium;">
                                                <td>Profit/Loss</td>
                                                <td class="<?php echo e($show1); ?>"><?php echo e((float) $tv_1profit); ?></td>
                                                <td class="<?php echo e($show2); ?>"><?php echo e((float) $tv_2profit); ?></td>
                                                <td class="<?php echo e($show3); ?>"><?php echo e((float) $tv_3profit); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="card-box">
                                        <div class="row alldetail">
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">if loss, how will this gap be met</div>
                                                    <div class="col-6">
                                                        <?php echo e($business_investment_plan[0]->lossgap_type); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row detail">
                                                    <div class="col-6">Comments</div>
                                                    <div class="col-6">
                                                        <?php echo e($business_investment_plan[0]->comments); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Loan amount and Duration</h5>
                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th>Loan Amount</th>
                                                <th>Interest rate%</th>
                                                <th>Interest type</th>
                                                <th>Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($loan_repayment)): ?>
                                            <tr class="tdc">
                                                <td><?php echo e(checkna((int) $loan_repayment[0]->principal)); ?></td>
                                                <?php if($loan_repayment[0]->interest != ''): ?>
                                                <td><?php echo e(checkper($loan_repayment[0]->interest)); ?>%</td>
                                                <?php else: ?>
                                                <td>0.00%</td>
                                                <?php endif; ?>
                                                <td><?php echo e(checkna($loan_repayment[0]->interest_type)); ?></td>
                                                <?php
                                                $duration = 'N/A';
                                                if ($loan_repayment[0]->tenure_mode == 1) {
                                                $duration = $loan_repayment[0]->loan_tenure . '-' . 'Year';
                                                } elseif ($loan_repayment[0]->tenure_mode == 0) {
                                                $duration = $loan_repayment[0]->loan_tenure . '-' . 'Month';
                                                }
                                                ?>
                                                <td class="tdc"><?php echo e($duration); ?></td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Payment Details </h5>
                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th></th>
                                                <th>Year 1</th>
                                                <th>Year 2</th>
                                                <th>Year 3</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($loan_repayment)): ?>
                                            <tr>
                                                <td>Total Interest</td>
                                                <td><?php echo e($loan_repayment[0]->total_interest_fyear != '' ? $loan_repayment[0]->total_interest_fyear : 0); ?>

                                                </td>
                                                <td><?php echo e($loan_repayment[0]->total_interest_syear != '' ? $loan_repayment[0]->total_interest_syear : 0); ?>

                                                </td>
                                                <td><?php echo e($loan_repayment[0]->total_interest_thyear != '' ? $loan_repayment[0]->total_interest_thyear : 0); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total Principle</td>
                                                <td><?php echo e($loan_repayment[0]->total_loan_fyear != '' ? $loan_repayment[0]->total_loan_fyear : 0); ?>

                                                </td>
                                                <td><?php echo e($loan_repayment[0]->total_loan_syear != '' ? $loan_repayment[0]->total_loan_syear : 0); ?>

                                                </td>
                                                <td><?php echo e($loan_repayment[0]->total_loan_thyear != '' ? $loan_repayment[0]->total_loan_thyear : 0); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <?php
                                                $total1 = (float) $loan_repayment[0]->total_interest_fyear + (float) $loan_repayment[0]->total_loan_fyear;
                                                $total2 = (float) $loan_repayment[0]->total_interest_syear + (float) $loan_repayment[0]->total_loan_syear;
                                                $total3 = (float) $loan_repayment[0]->total_interest_thyear + (float) $loan_repayment[0]->total_loan_thyear;
                                                ?>
                                                <td>Payable amount</td>
                                                <td class="tdc"><?php echo e(sprintf('%.1f', $total1)); ?>

                                                </td>
                                                <td class="tdc"><?php echo e(sprintf('%.1f', $total2)); ?>

                                                </td>
                                                <td class="tdc"><?php echo e(sprintf('%.1f', $total3)); ?>

                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php endif; ?>
                            </div>
                            <!----tab-12----->
                            <div class="tab-pane fade" id="v-pills-commitment" role="tabpanel" aria-labelledby="v-pills-commitment-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Family/SHG Member commitment </h5>

                                    </div>
                                    <table class="table table-bordered  mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th width="25px">SN</th>
                                                <th width="400px" scope="col">Question</th>
                                                <th scope="col">Answers</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <th>Does member attend meetings regularly?</th>
                                                <td><?php echo e(checkna($shgmember_commitment[0]->yo_meeting_yes_no)); ?></td>
                                            </tr>
                                            <?php if($shgmember_commitment[0]->yo_meeting_yes_no == 'Yes'): ?>
                                            <tr>
                                                <th scope="row"></th>
                                                <th>No. of meetings attended during last 12 months ?</th>
                                                <td><?php echo e(checkna($shgmember_commitment[0]->yo_meeting_attend)); ?>

                                                </td>
                                            </tr>
                                            <?php else: ?>
                                            <tr>
                                                <th scope="row"></th>
                                                <th>Reasons for not attending some meetings ?</th>
                                                <td><?php echo e(checkna($shgmember_commitment[0]->yo_metting_not_attend)); ?>

                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <th scope="row">2</th>
                                                <th>What is her understanding of rules of her group ?</th>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <?php if($shgmember_commitment[0]->yo_frequency_metting == 1): ?>
                                                            <?php echo "Frequency of meetting"; ?>
                                                            <?php endif; ?>
                                                        </li>
                                                        <li>
                                                            <?php if($shgmember_commitment[0]->yo_interest_rates == 1): ?>
                                                            <?php echo "Interest Rate "; ?>
                                                            <?php endif; ?>
                                                        </li>

                                                        <li>
                                                            <?php if($shgmember_commitment[0]->yo_receive_loan == 1): ?>
                                                            <?php echo "Receive a Loan"; ?>
                                                            <?php endif; ?>
                                                        </li>

                                                        <li>
                                                            <?php if($shgmember_commitment[0]->yo_max_loan_amount == 1): ?>
                                                            <?php echo "Maximum Loan Amount"; ?>
                                                            <?php endif; ?>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"></th>
                                                <th>If the member is aware of all categories ?</th>
                                                <td><?php echo e(checkna($shgmember_commitment[0]->yo_member_aware_categories)); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <th>Does member and family participate in the community development
                                                    activities ?</th>
                                                <td><?php echo e(checkna($shgmember_commitment[0]->yo_somewhat_yes_no)); ?></td>
                                            </tr>
                                            <?php if($shgmember_commitment[0]->yo_somewhat_yes_no != 'No'): ?>
                                            <tr>
                                                <th scope="row"></th>
                                                <th>Specify which activities member has participated during last 12
                                                    months ?</th>
                                                <td><?php echo e(checkna($shgmember_commitment[0]->yo_family_member_participate)); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"></th>
                                                <th>Number of activities member has participates ?</th>
                                                <td><?php echo e(checkna($shgmember_commitment[0]->yo_family_member_participate_no_of_activity)); ?>

                                                </td>
                                            </tr>
                                            <?php else: ?>
                                            <tr>
                                                <th scope="row"></th>
                                                <th>Reason for not participating ?</th>
                                                <td><?php echo e(checkna($shgmember_commitment[0]->yo_family_member_not_participate)); ?>

                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!----tab-13----->
                            <div class="tab-pane fade" id="v-pills-Observations" role="tabpanel" aria-labelledby="v-pills-Observations-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Key Highlights and Observations about the Family</h5>

                                    </div>
                                    <table class="table table-bordered  mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th width="25px">SN</th>
                                                <th width="400px" scope="col">1nd Visit Observation</th>
                                                <th scope="col">Answers</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <th>Who participated in the family?</th>
                                                <td colspan="2">
                                                    <?php echo e($observation_this_year_member[0]->participate_family); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <th>How long the family has been living in this house?</th>
                                                <td><?php echo e($observation_this_year[0]->fdip_observation_past_life); ?></td>
                                            </tr>
                                            
                                            <tr>
                                                <th scope="row">3</th>
                                                <th>Give a few highlights about this family (who they are? What they do for living? were they ready for discussion? whether they actively participated, etc) </th>
                                                <td><?php echo e($observation_this_year[0]->fdip_observation_daily); ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <th>What is special that you observed about this family? What are the three things you would like to highlight for this family (e.g. Readiness or reluctance to change,  attitudes in goal setting, feelings about commitments to act and unity within family, and so on) </th>
                                                <td>
                                                    <ol type="A" >
                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_a != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_a); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_b != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_b); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_c != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_c); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_d != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_d); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_e != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_e); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                   </ol>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td scope="row">5</td>
                                                <th>What is this family burdened with or worried about (things that bother them on a daily basis)?
                                                </th>
                                                <td><?php echo e($observation_this_year[0]->fdip_observation_vulnerabilities); ?>

                                                    <?php if($observation_this_year[0]->fdip_observation_vulnerabilities == 'Yes'): ?>
                                                    <br>
                                                    <ol type="A">
                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_a_6 != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_a_6); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_b_6 != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_b_6); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_c_6 != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_c_6); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_d_6 != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_d_6); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_e_6 != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_e_6); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                    </ol>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td scope="row">6</td>
                                                <th>In your assessment, what are key risks this family faces? Did this discussion help them understand their risks?”</th>
                                                <td><?php echo e($observation_this_year[0]->fdip_risk_assesment); ?></td>
                                            </tr>

                                            <tr>
                                                <td scope="row">7</td>
                                                <th>Does their SHG help them?</th>
                                                <td><?php echo e($observation_this_year[0]->fdip_observation_how); ?></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">8</td>
                                                <th>What was this family’s feedback on FDIP (did this discussion help them, if yes, in what ways)</th>
                                                <td><?php echo e($observation_this_year[0]->fdip_observation_agreement); ?>

                                                    <?php if($observation_this_year[0]->fdip_observation_agreement == 'Yes'): ?>
                                                    <ol>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_agreement_edittext); ?></li>
                                                    </ol>

                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td scope="row">9</td>
                                                <th>Are there in any observations that you have captured in other sections (e.g. family profile, assets, income, expenditures, loans, savings) that you would want to describe here                                                </th>
                                                <td>
                                                    <ol type="A">
                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_a_9 != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_a_9); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_b_9 != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_b_9); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_c_9 != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_c_9); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_d_9 != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_d_9); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_this_year[0]->fdip_observation_highlights_e_9 != ''): ?>
                                                        <li><?php echo e($observation_this_year[0]->fdip_observation_highlights_e_9); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                    </ol>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td scope="row">10</td>
                                                <th>Does this family want to take another loan for existing or new business (productive activities) – yes/no</th>
                                                <td><?php echo e($observation_this_year[0]->loan_new_existing !='1' ? 'Yes' :'No'); ?></td>
                                            </tr>
                                            <?php if($observation_this_year[0]->loan_new_existing == 0): ?>
                                            <tr>
                                                <td scope="row">10.a</td>
                                                <th>Which trade they want to take loan for?</th>
                                                <td><?php echo e($observation_this_year[0]->fdip_which_trade_loan); ?></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">10.b</td>
                                                <th>Is this trade feasible in your opinion?</th>
                                                <td><?php echo e($observation_this_year[0]->fdip_which_trade_feasible); ?></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">10.c</td>
                                                <th>Who in the family will run this business?  </th>
                                                <td><?php echo e($observation_this_year[0]->fdip_who_run_family_buisness); ?></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">10.d</td>
                                                <th>What is the amount of loan they want to take?</th>
                                                <td><?php echo e($observation_this_year[0]->fdip_observation_amount_of_loan); ?></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">10.e</td>
                                                <th>When will they prepare the business plan?</th>
                                                <td><?php echo e($observation_this_year[0]->fdip_when_will_prepare_buisness_plan); ?></td>
                                            </tr>
                                            <?php elseif($observation_this_year[0]->loan_new_existing == 1): ?>
                                            <tr>
                                                <td scope="row">10.a</td>
                                                <th>Why this family has decided not to take another loan and start business/trade (state reasons for not preparing an investment plan)</th>
                                                <td><?php echo e($observation_this_year[0]->fdip_why_family_decided_not_take_loan); ?></td>
                                            </tr>
                                            <?php endif; ?>

                                        </tbody>
                                    </table>
                                    <table class="table table-bordered  mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th width="25px">SN</th>
                                                <th width="400px" scope="col">2nd Visit Observation</th>
                                                <th scope="col">Answers</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <th>Has family revised challenges or actions since the last
                                                    discussion?</th>
                                                <td colspan="2">
                                                    <?php echo e($observation_next_year[0]->fdip_observation_next_has); ?>

                                                    <?php if($observation_next_year[0]->fdip_observation_next_describe != ''): ?>
                                                    <ol type="A">
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_describe); ?>

                                                        </li>
                                                    </ol>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <th>Has family done some preparation work for planning of the next
                                                    year
                                                    production and budget?</th>
                                                <td><?php echo e($observation_next_year[0]->fdip_observation_next_planning); ?>

                                                    <?php if($observation_next_year[0]->fdip_observation_next_describe2 != ''): ?>
                                                    <ol type="A">
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_describe2); ?>

                                                        </li>
                                                    </ol>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <th>Has family prepared their business plan? Who helped in preparing the business plan?</th>
                                                <td><?php echo e($observation_next_year[0]->fdip_observation_next_business); ?>


                                                    <?php if($observation_next_year[0]->fdip_observation_next_business == 'Yes'): ?>
                                                    <br>
                                                    <ol type="A">
                                                        <?php if($observation_next_year[0]->fdip_observation_next_highlight != ''): ?>
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_highlight); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_next_year[0]->fdip_observation_next_highlight_two != ''): ?>
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_highlight_two); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_next_year[0]->fdip_observation_next_highlight_three != ''): ?>
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_highlight_three); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_next_year[0]->fdip_observation_next_highlight_four != ''): ?>
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_highlight_four); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_next_year[0]->fdip_observation_next_highlight_five != ''): ?>
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_highlight_five); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                    </ol>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <td scope="row">4</td>
                                                <th>in your assessment, should this family take a
                                                    loan and what are the biggest risks in lending to them?</th>
                                                <td>
                                                    <ol type="A">
                                                        <?php if($observation_next_year[0]->fdip_observation_next_what != ''): ?>
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_what); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_next_year[0]->fdip_observation_next_what_b_4 != ''): ?>
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_what_b_4); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_next_year[0]->fdip_observation_next_what_c_4 != ''): ?>
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_what_c_4); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                    </ol>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td scope="row">5</td>
                                                <th>Did you observe any change in the family from the 1st visit?, if
                                                    yes
                                                    describe</th>
                                                <td><?php echo e($observation_next_year[0]->fdip_observation_next_did); ?>

                                                    <br>
                                                    <ol type="A">

                                                        <?php if($observation_next_year[0]->fdip_observation_next_any != ''): ?>
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_any); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_next_year[0]->fdip_observation_next_any_two != ''): ?>
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_any_two); ?>

                                                        </li>
                                                        <?php endif; ?>

                                                        <?php if($observation_next_year[0]->fdip_observation_next_any_three != ''): ?>
                                                        <li><?php echo e($observation_next_year[0]->fdip_observation_next_any_three); ?>

                                                        </li>
                                                        <?php endif; ?>
                                                    </ol>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!----tab-14----->
                            <div class="tab-pane fade" id="v-pills-Photos-Videos" role="tabpanel" aria-labelledby="v-pills-Photos-Videos-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Photos/Videos</h5>

                                    </div>
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>First Visit</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Photo</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $photos_first_year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image_first_year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($image_first_year->imagename != ''): ?>
                                                <tr class="text-center">
                                                    <th><img src="/assets/uploads/<?php echo e($image_first_year->imagename); ?>" height="100" width="100"></th>
                                                </tr>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="family-box">
                                        <div class="w-heading d-flex">
                                            <h5>Second Visit</h5>
                                        </div>
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>

                                                    <th>Photo</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $photos_second_year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image_second_year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($image_second_year->imagename != ''): ?>
                                                <tr class="text-center">
                                                    <th><img src="/assets/uploads/<?php echo e($image_second_year->imagename); ?>" height="100" width="100"></th>
                                                </tr>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!----tab-15----->
                            <div class="tab-pane fade" id="v-pills-consent" role="tabpanel" aria-labelledby="v-pills-consent-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Family Consent Form </h5>

                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th>Name</th>
                                                <th>Photo</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($concent[0]->name_of_participant != ''): ?>
                                            <tr class="text-center">
                                                <th><?php echo e($concent[0]->name_of_participant); ?></th>
                                                <th><img src="/signature/fac_<?php echo e($mst_id); ?>.png" height="100" width="100"></th>
                                                <th>Participant</th>
                                            </tr>
                                            <?php else: ?>
                                            <tr class="text-center">
                                                <th></th>
                                                <th></th>
                                                <th>Participant</th>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($concent[0]->name_of_facilitator != ''): ?>
                                            <tr class="text-center">
                                                <th><?php echo e($concent[0]->name_of_facilitator); ?></th>
                                                <th><img src="/signature/par_<?php echo e($mst_id); ?>.png" height="100" width="100"></th>
                                                <th>Facilitator</th>
                                            </tr>
                                            <?php else: ?>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th></th>
                                                    <th>Facilitator</th>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!----tab-15----->
                            <div class="tab-pane fade" id="v-pills-loan-approvel" role="tabpanel" aria-labelledby="v-pills-loan-approvel-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Loan Approval</h5>

                                    </div>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>1st REQUESTED LOAN</h5>

                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th>(1) Requested Loan Amount</th>
                                                <th>Purpose</th>
                                                <th>Repayment mode</th>
                                                <th>Loan duration </th>
                                                <th>Number installments </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($loan_repayment)): ?>
                                            <?php
                                            $loan_duration_a = '';
                                            $loan_tenure_a = '';
                                            $mode = '';
                                            if ($loan_repayment[0]->tenure_mode != '') {
                                            if ($loan_repayment[0]->tenure_mode == 1) {
                                            $mode = 'Yearly';
                                            }
                                            if ($loan_repayment[0]->tenure_mode == 0) {
                                            $mode = 'Monthly';
                                            }

                                            if ($loan_repayment[0]->tenure_mode == 1) {
                                            $loan_tenure_a = 12 * $loan_repayment[0]->loan_tenure;
                                            } else {
                                            $loan_tenure_a = $loan_repayment[0]->loan_tenure;
                                            }

                                            if ($loan_repayment[0]->tenure_mode == 1) {
                                            $loan_duration_a = $loan_repayment[0]->loan_tenure . 'Year';
                                            } else {
                                            $loan_duration_a = $loan_repayment[0]->loan_tenure . 'Month';
                                            }
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo e($loan_repayment[0]->principal); ?></td>
                                                <td><?php echo e($business_investment_plan[0]->type_of_business); ?></td>
                                                <td><?php echo e($mode); ?></td>
                                                <td><?php echo e($loan_duration_a); ?></td>
                                                <td><?php echo e($loan_tenure_a); ?></td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Updates/Changes to 1st loan- Verfication stage</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Reviewed/verified by District
                                                manager/federation</label>
                                            <select class="form-control" name="get_verified" id="get_verified" required>
                                                <option value="">--Select--</option>
                                                <option value="Verified" <?php echo $loan_approvel[0]->get_verified == 'Verified' ? 'selected' : ''; ?>>Verified</option>
                                                <option value="Reject" <?php echo $loan_approvel[0]->get_verified == 'Reject' ? 'selected' : ''; ?>>Reject</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Updated Loan Amount</label>
                                            <input type="text" value="<?php echo e($loan_approvel[0]->uloan_amount); ?>" name="uloan_amount" id="uloan_amount" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Updated Purpose</label>
                                            <input type="text" value="<?php echo e($loan_approvel[0]->uloan_purpose); ?>" id="uloan_pur" name="uloan_pur" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Updated Repayment mode</label>
                                            <select class="form-control" id="uloan_mode" name="uloan_mode" required>
                                                <option value="">--Select--</option>

                                                <option value="Yearly" <?php echo $loan_approvel[0]->urepayment_mode == 'Yearly' ? 'selected' : ''; ?>>Yearly</option>
                                                <option value="Monthly" <?php echo $loan_approvel[0]->urepayment_mode == 'Monthly' ? 'selected' : ''; ?>>Monthly</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Updated Loan duration </label>
                                            <select class="form-control" id="uloan_duration" name="uloan_duration" required>
                                                <option value="">--Select--</option>
                                                <option class="uloan_duration" value="1" <?php echo $loan_approvel[0]->uloan_duration == '1' ? 'selected' : ''; ?>>1
                                                </option>
                                                <option class="uloan_duration" value="2" <?php echo $loan_approvel[0]->uloan_duration == '2' ? 'selected' : ''; ?>>2
                                                </option>
                                                <option class="uloan_duration" value="3" <?php echo $loan_approvel[0]->uloan_duration == '3' ? 'selected' : ''; ?>>3
                                                </option>
                                                <?php for($i = 1; $i <= 36; $i++): ?> <option class="uloan_duration1" value="<?php echo e($i); ?>" <?php echo e(!empty($loan_approvel[0]->uloan_duration) && $loan_approvel[0]->uloan_duration == $i ? 'selected' : ''); ?>>
                                                    <?php echo e($i); ?></option>
                                                    <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Updated no. installments </label>
                                            <input type="text" value="<?php echo e($loan_approvel[0]->uloan_installments); ?>" id="uloan_installments" name="uloan_installments" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <?php if($locked == 1): ?>
                                    <?php if($u_type == 'M'): ?>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <input type="hidden" name="family_sub_mst" id="family_sub_mst" value="<?php echo e($mst_id); ?>">
                                            <button class="btn btn-sm btn-success" onclick="return submitAction2()">Save</button>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!----tab-16----->
                            <div class="tab-pane fade" id="v-pills-loan-approved" role="tabpanel" aria-labelledby="v-pills-loan-approved-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Loan Disbursement</h5>

                                    </div>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>1st REQUESTED LOAN</h5>

                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th>(1) Requested Loan Amount</th>
                                                <th>Purpose</th>
                                                <th>Repayment mode</th>
                                                <th>Loan duration </th>
                                                <th>Number installments </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($loan_repayment)): ?>
                                            <?php
                                            $loan_duration = '';
                                            $loan_tenure = '';
                                            if (!empty($loan_repayment[0]->tenure_mode)) {
                                            if ($loan_repayment[0]->tenure_mode == 1) {
                                            $loan_tenure = 12 * $loan_repayment[0]->loan_tenure;
                                            } else {
                                            $loan_tenure = $loan_repayment[0]->loan_tenure;
                                            }

                                            if ($loan_repayment[0]->tenure_mode == 1) {
                                            $loan_duration = $loan_repayment[0]->loan_tenure . 'Year';
                                            } else {
                                            $loan_duration = $loan_repayment[0]->loan_tenure . 'Month';
                                            }
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo e($loan_repayment[0]->principal); ?></td>
                                                <td><?php echo e($business_investment_plan[0]->type_of_business); ?></td>
                                                <td><?php echo e($loan_repayment[0]->tenure_mode == 1 ? 'Yearly' : 'Monthly'); ?>

                                                </td>
                                                <td><?php echo e($loan_duration); ?></td>
                                                <td><?php echo e($loan_tenure); ?></td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Updates/Changes to 1st loan- Verfication stage</h5>

                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th>Reviewed/verified </th>
                                                <th>Updated Loan Amount</th>
                                                <th>Updated Purpose</th>
                                                <th>Updated Repayment mode</th>
                                                <th>Updated Loan duration</th>
                                                <th>Updated no. installments</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($loan_approvel)): ?>
                                            <tr>
                                                <td><?php echo e($loan_approvel[0]->get_verified); ?></td>
                                                <td><?php echo e($loan_approvel[0]->uloan_amount); ?></td>
                                                <td><?php echo e($loan_approvel[0]->uloan_purpose); ?></td>
                                                <td><?php echo e($loan_approvel[0]->urepayment_mode); ?></td>
                                                <td><?php echo e($loan_approvel[0]->uloan_duration); ?></td>
                                                <td><?php echo e($loan_approvel[0]->uloan_installments); ?></td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>Approved By District Manager</h5>
                                    </div>
                                    <table class="table mytable">
                                        <thead class="back-color">
                                            <tr>
                                                <th>Reviewed/verified by</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td><?php echo e(!empty($manager[0]->name) ? $manager[0]->name : ''); ?></td>

                                                <td><?php echo e($loan_approvel[0]->date != '' ? change_date_month_name_char(str_replace('/', '-', $loan_approvel[0]->date)) : ''); ?>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>After Disbursement</h5>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Did they get a loan? (Y/N)</label>
                                            <select class="form-control" name="get_loan" id="get_loan" required>
                                                <option value="">--Select--</option>
                                                <option value="Yes" <?php if (!empty($loan_disbursement)) {
                                                                        echo $loan_disbursement[0]->get_loan == 'Yes' ? 'selected' : '';
                                                                    } ?>>Yes</option>
                                                <option value="No" <?php if (!empty($loan_disbursement)) {
                                                                        echo $loan_disbursement[0]->get_loan == 'No' ? 'selected' : '';
                                                                    } ?>>No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">If Y, enter disbursement date</label>
                                            <input type="text" value="<?php echo e(!empty($loan_disbursement[0]->disbursement_date) ? $loan_disbursement[0]->disbursement_date : ''); ?>" name="loan_date" id="loan_date" class="form-control datepicker" placeholder="date">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Final loan amount after
                                                disbursement</label>
                                            <input type="text" value="<?php echo e(!empty($loan_disbursement[0]->loan_amount) ? $loan_disbursement[0]->loan_amount : ''); ?>" id="loan_amount" name="loan_amount" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <div id="loan_changes">
                                        <div class="w-heading d-flex">
                                            <h5>Final changes in loan no. 1 (approved by Name of Lending
                                                Insitution/Partner) </h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">If change in loan purpose</label>
                                                <input type="text" value="<?php echo e(!empty($loan_disbursement[0]->loan_purpose) ? $loan_disbursement[0]->loan_purpose : ''); ?>" id="loan_purpose" name="loan_purpose" class="form-control ">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">If change in repayment mode</label>

                                                <select class="form-control" value="" id="loan_mode" name="loan_mode" required>

                                                    <option value="">--select--</option>
                                                    <option value="Yearly" <?php if (!empty($loan_disbursement)) {
                                                                                echo $loan_disbursement[0]->repayment_mode == 'Yearly' ? 'selected' : '';
                                                                            } ?>>Yearly</option>
                                                    <option value="Monthly" <?php if (!empty($loan_disbursement)) {
                                                                                echo $loan_disbursement[0]->repayment_mode == 'Monthly' ? 'selected' : '';
                                                                            } ?>>Monthly</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">if change in loan duration </label>

                                                <select class="form-control" id="loan_duration" name="loan_duration" required>
                                                    <option value="">--Select--</option>
                                                    <option class="loan_duration" value="1" <?php if (!empty($loan_disbursement)) {
                                                                                                echo $loan_disbursement[0]->loan_duration == '1' ? 'selected' : '';
                                                                                            } ?>>1
                                                    </option>
                                                    <option class="loan_duration" value="2" <?php if (!empty($loan_disbursement)) {
                                                                                                echo $loan_disbursement[0]->loan_duration == '2' ? 'selected' : '';
                                                                                            } ?>>2
                                                    </option>
                                                    <option class="loan_duration" value="3" <?php if (!empty($loan_disbursement)) {
                                                                                                echo $loan_disbursement[0]->loan_duration == '3' ? 'selected' : '';
                                                                                            } ?>>3
                                                    </option>

                                                    <?php for($i = 1; $i <= 36; $i++): ?> <option class="loan_duration1" value="<?php echo e($i); ?>" <?php echo e(!empty($loan_disbursement[0]->loan_duration) && $loan_disbursement[0]->loan_duration == $i ? 'selected' : ''); ?>>
                                                        <?php echo e($i); ?></option>
                                                        <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">if change in no. installments </label>
                                                <input type="text" value="<?php echo e(!empty($loan_disbursement[0]->no_installments) ? $loan_disbursement[0]->no_installments : ''); ?>" id="loan_installments" name="loan_installments" class="form-control" autocomplete="off">
                                            </div>

                                        </div>

                                    </div>
                                    <?php if($locked == 1): ?>
                                    <?php if(!empty($loan_approvel)): ?>
                                    <?php if($u_type == 'A' || $u_type == 'CEO'): ?>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <input type="hidden" name="family_sub_mst" id="family_sub_mst" value="<?php echo e($mst_id); ?>">
                                            <button class="btn btn-sm btn-success" onclick="return submitAction1()">Save</button>

                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>


                            <!----tab-18----->
                            <div class="tab-pane fade" id="v-pills-report-card" role="tabpanel" aria-labelledby="v-pills-loan-approvel-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Family Development Card</h5>

                                    </div>
                                    <div class="card-box">
                                        <table class="table table-bordered mytable" colspan="2">
                                            <thead class="back-color">

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th width="50%">Name of Member</th>
                                                    <td width="50%"><?php echo e($family_profile[0]->fp_member_name); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Aadhar No</th>
                                                    <td><?php echo e($family_profile[0]->fp_aadhar_no != '' ? aadhar($family_profile[0]->fp_aadhar_no) : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>UIN</th>
                                                    <td><?php echo e($family->uin); ?></td>
                                                </tr>

                                                <tr>
                                                    <th>Shg Name</th>
                                                    <td><?php echo e($shg_profile[0]->shgName); ?></td>
                                                </tr>

                                                <tr>
                                                    <th>Cluster Name</th>
                                                    <td><?php echo e(!empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Federation Name</th>
                                                    <td><?php echo e($fed_profile[0]->name_of_federation); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>State Name</th>
                                                    <td><?php echo e(checkna($family_profile[0]->fp_state)); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>District Name</th>
                                                    <td><?php echo e($family_profile[0]->fp_district != '' ? $family_profile[0]->fp_district : 'N/A'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Village Name</th>
                                                    <td><?php echo e($family_profile[0]->fp_village); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Date</th>
                                                    <td><?php echo e(change_date_month_name_char(str_replace('/', '-', $family->created_at))); ?>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered mytable" colspan="2">
                                            <thead class="back-color">
                                                <tr>
                                                    <th width="35%">FDP Indicators</th>
                                                    <td colspan="4"></td>
                                                    <th style="text-align:center;">Actual </th>
                                                    <th style="text-align:center;">Expected </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <td>1 Family Budget</td>
                                                        <td
                                                            style="background-color: green;width:50px;align-content: center;">
                                                            <?php if($score >= 90): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            <?php if($score >= 75 && $score <= 89): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            <?php if($score >= 60 && $score <= 74): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            <?php if($score <= 59): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td width="10px" style="text-align: center;">
                                                            <?php echo e($total_cy1); ?>

                                                        </td>
                                                        <td width="10px" style="text-align: center;">15</td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>2 Family Saving</td>
                                                        <td style="background-color: green;width:50px;">
                                                            <?php if($score1 >= 90): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            <?php if($score1 >= 75 && $score1 <= 89): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            <?php if($score1 >= 60 && $score1 <= 74): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            <?php if($score1 <= 59): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="text-align: center;"><?php echo e($total_cy2); ?></td>
                                                        <td style="text-align: center;">23</td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>3 Family Credit History</td>
                                                        <td style="background-color: green;width:50px;">
                                                            <?php if($score2 >= 90): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            <?php if($score2 >= 75 && $score2 <= 89): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            <?php if($score2 >= 60 && $score2 <= 74): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            <?php if($score2 <= 59): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="text-align: center;"><?php echo e($total_cy3); ?></td>
                                                        <td style="text-align: center;">50</td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>4 Family Commitment to Group Rules</td>
                                                        <td style="background-color: green;width:50px;">
                                                            <?php if($score3 >= 90): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: yellow;width:50px;">
                                                            <?php if($score3 >= 75 && $score3 <= 89): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: lightgrey;width:50px;">
                                                            <?php if($score3 >= 60 && $score3 <= 74): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="background-color: red;width:50px;">
                                                            <?php if($score3 <= 59): ?>
                                                                <i class="c-black-500 ti-check"
                                                                    style="font-size:25px;font-weight:bold;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="text-align: center;"><?php echo e($total_ny4); ?></td>
                                                        <td style="text-align: center;">12</td>
                                                        
                                                    </tr>


                                                </tbody>

                                        </table>
                                        <table class="table  mytable">

                                            <tr>
                                                <th style="width: 35%;">Total Score</th>

                                                <td style="background-color: green;text-align:center;font-weight:bold;font-size:20px;width:9.9%;">
                                                    <?php if($grand_total_cy >= 90): ?>
                                                    <?php echo e($grand_total_cy); ?>

                                                    <?php endif; ?>

                                                </td>


                                                <td style="background-color: yellow;text-align:center;font-weight:bold;font-size:20px;width:9.66%;">
                                                    <?php if($grand_total_cy >= 75 && $grand_total_cy <= 89): ?> <?php echo e($grand_total_cy); ?> <?php endif; ?> </td>


                                                <td style="background-color: lightgrey;text-align:center;font-weight:bold;font-size:20px;width:10%;">
                                                    <?php if($grand_total_cy >= 60 && $grand_total_cy <= 74): ?> <?php echo e($grand_total_cy); ?> <?php endif; ?> </td>


                                                <td style="background-color: red;text-align:center;font-weight:bold;font-size:20px;width:10%;">
                                                    <?php if($grand_total_cy <= 59): ?> <?php echo e($grand_total_cy); ?> <?php endif; ?> </td>
                                                <td colspan="2" style="width:28%;"></td>

                                            </tr>


                                        </table>



                                    </div>


                                </div>
                            </div>
                            <!---tab 19 Reports --->

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
                                                    <th width="50%">Family Profile </th>
                                                    <td><a href="<?php echo e(URL::to('/familyPdf/' . $family_ids)); ?>" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a></td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <th width="50%">Family Profile With Report Card</th>
                                                    <td><a href="<?php echo e(URL::to('/familyDetailCardPdf/' . $family_ids)); ?>" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <th>Family Report Card </th>
                                                    <td><a href="<?php echo e(URL::to('/familycardPdf/' . $family_ids)); ?>" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a></td>
                                                </tr>

                                                <tr>
                                                    <th>Family Buisness Plan </th>
                                                    <td> <a href="<?php echo e(URL::to('/familyBusinessplanPdf/' . $family_ids)); ?>" class="btn iconbtn btn-success ml-2">
                                                            <i class="las ti-download"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <th>Family Loan Disbursement</th>
                                                    <td><a href="<?php echo e(URL::to('/familyloanPdf/' . $family_ids)); ?>" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <th>Family Loan Application</th>
                                                    <td><a href="<?php echo e(URL::to('/familyloanApplicationPdf/' . $family_ids)); ?>" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <th>Family Consent Form</th>
                                                    <td><a href="<?php echo e(URL::to('/familyConsentPdf/' . $family_ids)); ?>" class="btn iconbtn btn-success ml-2"><i class="las ti-download"></i></a></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            
                            <div class="tab-pane fade" id="v-pills-remarks" role="tabpanel" aria-labelledby="v-pills-reports-tab">
                                <div class="family-box">
                                    <div class="w-heading d-flex">
                                        <h5>Remarks</h5>

                                    </div>
                                    <div class="card-box">
                                        <table class="table mytable">
                                            <thead class="back-color">
                                                <tr>
                                                    <th>Facilitator</th>
                                                    <th>Family Name</th>
                                                    <th>Task</th>
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
                                                $dm_status = 'Pending';
                                                if($res->dm_status == 'V'){
                                                $status = 'Verified';
                                                }
                                                else if (($res->dm_status == 'R')) {
                                                $status = ' Rejected';
                                                }
                                                if($res->qa_status == 'V'){
                                                $dm_status = 'Verified';
                                                }
                                                else if ($res->qa_status == 'R') {
                                                $dm_status = ' Rejected';
                                                }
                                                ?>
                                                <tr>
                                                    <td><?php echo e($res->name); ?></td>
                                                    <td><?php echo e($res->fp_member_name); ?></td>
                                                    <td><?php echo e($res->task_type); ?></td>
                                                    <td><?php echo e($status); ?></td>
                                                    <td><?php echo e($dm_status); ?></td>
                                                    <td><?php echo e(change_date_month_name_char(str_replace('/','-',$res->updated_at))); ?></td>

                                                    <td><a data-toggle="modal" data-id="<?php echo e($res->id); ?>" href="#remarks_m" data-type="M" class="btn btn-success btn-link btn-sm" data-target="#remarks_m"><i class="c-white-500 ti-eye"></i></a>
                                                    </td>
                                                    <td><a data-toggle="modal" data-id="<?php echo e($res->id); ?>" href="#remarks_q" data-type="QA" class="btn btn-success btn-link btn-sm" data-target="#remarks_q"><i class="c-white-500 ti-eye"></i></a>
                                                    </td>

                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <!----task asctions ---->
                            <?php if($u_type == 'M'): ?>
                               <?php if($family_flag ==1): ?>
                                <div class="tab-pane fade" id="v-pills-quality-check" role="tabpanel" aria-labelledby="v-pills-quality-check-tab">
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>District Manager busi - Take Action </h5>

                                        </div>

                                        <div class="card-box">
                                            <?php if($quality_status != 'P'): ?>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="col-md-8">
                                                        <label class="form-control-label" for="input-small" style="font-weight: bold;">Quality Action :
                                                        </label>
                                                        <?php if($quality_status == 'V'): ?>
                                                        <span>Verified</span>
                                                        <?php elseif($quality_status == 'R'): ?>
                                                        <span>Rejected</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-control-label" for="input-small" style="font-weight: bold;">Updated at:
                                                        </label>
                                                        <span><?php echo e($quality_date); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3" style="margin-top: -17px;" id="quality_remark">
                                                    <!-- <div class="col-md-12" id="remark_txt11">
                                                        <label for="TaskQaAssignment_remark11" class="required" style="font-weight: bold;">Quality Remark :
                                                        </label>
                                                        <span><?php echo e($quality_remark); ?></span>
                                                    </div> -->
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="col-md-8">
                                                        <label class="form-control-label" for="input-small">Action
                                                        </label>
                                                        <select class="form-control" name="TaskQaAssignment_status" id="TaskQaAssignment_status" style="width:172px;">
                                                            <option value="V">Verify</option>
                                                            <option value="R">Reject</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php if($task_type !='P2'&& $dm_p2_status ==''): ?>
                                                <div class="col-md-12 mb-3">
                                                    <div class="col-md-8">

                                                        <label id="buisness_status">
                                                            <input type="checkbox" name="buisness" id="buisness" value="1"> Send to Buisness plan
                                                            <input type="hidden" name="business_hidden" id="business_hidden" value="0">
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                                <div class="col-md-12 show_div mb-3">
                                                    <label for="TaskQaAssignment_remark" class="required form-control-label ml-3 mb-2"> Facilitator
                                                    </label>

                                                    <div class="col-md-8">
                                                        <select class="form-control facilitator_id" name="facilitator_id" id="facilitator_id" style="width:172px;"  required>
                                                            <option value="">--Select--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="col-md-8" id="remark_txt">
                                                        <label for="TaskQaAssignment_remark" class="required">Remark
                                                        </label>
                                                        <textarea class="form-control form-control-sm" name="TTaskQaAssignment_remark" id="TaskQaAssignment_remark" style="width: 751px;height:150px"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-8 text-center">
                                                <input type="hidden" name="family_flag" id="family_flag"  value="<?php echo e($family_flag); ?>">
                                                <input type="hidden" name="task_id" id="task_id" value="<?php echo e($task_id); ?>">
                                                <input type="hidden" name="agency_id" id="agency_id" value="<?php echo e($agency_id); ?>">
                                                <input type="hidden" name="facilitator" id="facilitator" value="<?php echo e($user_id); ?>">
                                                <input type="hidden" name="dm_id" id="dm_id" value="<?php echo e($dm_id); ?>">
                                                <input type="hidden" name="task" id="task">
                                                <input type="hidden" name="task_status" id="task_status" value="<?php echo e($task_status); ?>">
                                                <input type="hidden" name="task_type" id="task_type" value="<?php echo e($task_type); ?>">
                                                <input type="hidden" name="task_status_qa_p1" id="task_status_qa_p1" value="<?php echo e($task_status_qa_p1); ?>">

                                            </div>
                                            <?php if($qa_status == 'P' || $quality_status == 'R'): ?>

                                                <button type="button" id="save5" class="btn btn-sm btn-success " onclick="return submitAction5()" style="margin-left: 229px;">Save</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                               <?php else: ?>
                               <div class="tab-pane fade" id="v-pills-quality-check" role="tabpanel" aria-labelledby="v-pills-quality-check-tab">
                                <div class="family-box mt-3">
                                    <div class="w-heading d-flex">
                                        <h5>District Manager - Take Action </h5>

                                    </div>

                                    <div class="card-box">
                                        <?php if($quality_status != 'P'): ?>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="col-md-8">
                                                    <label class="form-control-label" for="input-small" style="font-weight: bold;">Quality Action :
                                                    </label>
                                                    <?php if($quality_status == 'V'): ?>
                                                    <span>Verified</span>
                                                    <?php elseif($quality_status == 'R'): ?>
                                                    <span>Rejected</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-control-label" for="input-small" style="font-weight: bold;">Updated at:
                                                    </label>
                                                    <span><?php echo e($quality_date); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mb-3" style="margin-top: -17px;" id="quality_remark">
                                                <!-- <div class="col-md-12" id="remark_txt11">
                                                    <label for="TaskQaAssignment_remark11" class="required" style="font-weight: bold;">Quality Remark :
                                                    </label>
                                                    <span><?php echo e($quality_remark); ?></span>
                                                </div> -->
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="col-md-8">
                                                    <label class="form-control-label" for="input-small">Action
                                                    </label>
                                                    <select class="form-control" name="TaskQaAssignment_status" id="TaskQaAssignment_status" style="width:172px;">
                                                        <option value="V">Verify</option>
                                                        <option value="R">Reject</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 show_div mb-3">
                                                <label for="TaskQaAssignment_remark" class="required form-control-label ml-3 mb-2"> Facilitator
                                                </label>
                                                <?php if($dm_p2_status == 'N' ): ?>
                                                <div class="col-md-8">
                                                    <select class="form-control user_id" name="user_id" id="user_id" style="width:172px;" readonly required>
                                                        <option value="">--Select--</option>
                                                    </select>
                                                <span style="color:red">NOTE: This task cannot be reassigned to another facilitator until P2 is uploaded.</span>

                                                </div>
                                                <?php else: ?>
                                                <div class="col-md-8">
                                                    <select class="form-control user_id" name="user_id" id="user_id" style="width:172px;"  required>
                                                        <option value="">--Select--</option>
                                                    </select>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <div class="col-md-8" id="remark_txt">
                                                    <label for="TaskQaAssignment_remark" class="required">Remark
                                                    </label>
                                                    <textarea class="form-control form-control-sm" name="TTaskQaAssignment_remark" id="TaskQaAssignment_remark" style="width: 751px;height:150px"></textarea>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-sm-8 text-center">
                                            <input type="hidden" name="task_id" id="task_id" value="<?php echo e($task_id); ?>">
                                            <input type="hidden" name="agency_id" id="agency_id" value="<?php echo e($agency_id); ?>">
                                            <input type="hidden" name="facilitator" id="facilitator" value="<?php echo e($user_id); ?>">
                                            <input type="hidden" name="dm_id" id="dm_id" value="<?php echo e($dm_id); ?>">
                                            <input type="hidden" name="task" id="task">
                                            <input type="hidden" name="task_status" id="task_status" value="<?php echo e($task_status); ?>">
                                            <input type="hidden" name="task_type" id="task_type" value="<?php echo e($task_type); ?>">
                                            <input type="hidden" name="task_status_qa_p1" id="task_status_qa_p1" value="<?php echo e($task_status_qa_p1); ?>">
                                            <?php if($qa_status == 'P' || $quality_status == 'R'): ?>
                                            <button type="button" id="save3" class="btn btn-sm btn-success " onclick="return submitAction3()" style="margin-left: 229px;">Save</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                               </div>
                               <?php endif; ?>
                            <?php elseif($u_type == 'QA'): ?>
                                <div class="tab-pane fade" id="v-pills-quality-check-qa" role="tabpanel" aria-labelledby="v-pills-quality-check-tab-qa">
                                    <div class="family-box mt-3">
                                        <div class="w-heading d-flex">
                                            <h5>Quality Check - Take Action </h5>

                                        </div>
                                        <?php if($manager_status == 'Verify'): ?>
                                        <div class="card-box">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="col-md-8">
                                                        <label class="form-control-label" for="input-small" style="font-weight: bold;">Manger Action :
                                                        </label>
                                                        <?php if($qa_status == 'V'): ?>
                                                        <span>Verified</span>
                                                        <?php elseif($qa_status == 'R'): ?>
                                                        <span>Rejected</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-control-label" for="input-small" style="font-weight: bold;">Updated at:
                                                        </label>
                                                        <span><?php echo e($manager_date); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3" style="margin-top: -17px;" id="manager_remark">
                                                    <!-- <div class="col-md-12" id="remark_txt11">
                                                        <label for="TaskQaAssignment_remark22" class="required" style="font-weight: bold;">Manager Remark :
                                                        </label>
                                                        <span><?php echo e($qa_remark); ?></span>

                                                    </div> -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="col-md-8">
                                                        <label class="form-control-label" for="input-small">Quality
                                                            Action
                                                        </label>
                                                        <select class="form-control" name="TaskQaAssignment_status1" id="TaskQaAssignment_status1" <?php echo e($qa_readonly1); ?>>
                                                            <option value="V">Verify</option>
                                                            <option value="R">Reject</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="col-md-8" id="remark_txt11">
                                                        <label for="TaskQaAssignment_remark1" class="required">Remark
                                                        </label>
                                                        <textarea class="form-control form-control-sm" name="TTaskQaAssignment_remark1" id="TaskQaAssignment_remark1" <?php echo e($qa_readonly1); ?>></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 text-center">
                                                <input type="hidden" name="task_id" id="task_id1" value="<?php echo e($task_id); ?>">
                                                <input type="hidden" name="agency_id" id="agency_id1" value="<?php echo e($agency_id); ?>">
                                                <input type="hidden" name="facilitator" id="facilitator1" value="<?php echo e($user_id); ?>">
                                                <input type="hidden" name="task" id="task">
                                                <?php if($quality_status == 'P'): ?>
                                                <button type="button" id="save4" class="btn btn-sm btn-success " onclick="return submitAction4()">Save</button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog">
    <div class="modal-dialog mw-100 w-75" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agriculture & Production (Current Year)
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="modal-body2" style="overflow-y: scroll; height:400px;">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog">
    <div class="modal-dialog mw-100 w-75" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agriculture & Production (Next Year)
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="modal-body3" style="overflow-y: scroll; height:400px;">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog">
    <div class="modal-dialog mw-100 w-75" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Yearly Operational Expenses</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="modal-body" style="overflow-y: scroll; height:400px;">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog">
    <div class="modal-dialog mw-100 w-75" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Yearly Income From Business</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="modal-body1" style="overflow-y: scroll; height:400px;">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter4" tabindex="-1" role="dialog">
    <div class="modal-dialog mw-100 w-75" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Expenditure This Year</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="modal-body4" style="overflow-y: scroll; height:400px;">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="Savings_expenditure" tabindex="-1" role="dialog">
    <div class="modal-dialog mw-100 w-50" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Savings</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="" style="overflow-y: scroll; height:400px;">
                <table class="table mytable">
                    
                    <thead class="back-color">

                        <tr>
                            <th>Type</th>

                            <th>Saved During Last 12 Months</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php if(!empty($savings_source)): ?>
                        <?php
                        $sum = 0;
                        $sum1 = 0;
                        $sum2 = 0;
                        ?>
                        <?php $__currentLoopData = $savings_source; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $sum = $sum + (float) $row['s_total_saving'];
                        $sum1 = $sum1 + (float) $row['s_saving_per_month'];
                        $sum2 = $sum2 + (float) $row['s_last_saved_amt'];
                        ?>
                        <tr>
                            <td><?php echo e($row['s_type']); ?></td>

                            <td><?php echo e($row['s_last_saved_amt']); ?></td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </tbody>

                    
                    <thead class="back-color">
                        
                    </thead>
                    <tbody>
                        <?php if(!empty($savings_source_other)): ?>
                        <?php $sum_a=0; ?>
                        <?php $__currentLoopData = $savings_source_other; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $sum_a=$sum_a+(float)$row->other_amount; ?>
                        <tr>
                            <td><?php echo e(checkna($row->other_loan)); ?></td>

                            <td><?php echo e($row->last_saved_amt != '' ? $row->last_saved_amt : 0); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <tr class="total">
                            <td colspan="">Total</td>
                            <td><?php echo e($saving_total[0]->saving_total ?? 0); ?></td>
                        </tr>

                    </tbody>



                </table>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog">
    <div class="modal-dialog mw-100 w-75" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Expenditure Next Year</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="modal-body5" style="overflow-y: scroll; height:400px;">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter6" tabindex="-1" role="dialog">
    <div class="modal-dialog mw-100 w-75" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Loan Expenditure This Year</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="modal-body6" style="overflow-y: scroll; height:400px;">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter7" tabindex="-1" role="dialog">
    <div class="modal-dialog mw-100 w-75" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Loan Expenditure Next Year</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="modal-body7" style="overflow-y: scroll; height:400px;">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Income Modal -->
<div class="modal fade" id="exampleModalCenter9" tabindex="-1" role="dialog">
    <div class="modal-dialog mw-100 w-75" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Income</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="modal-body9" style="overflow-y: scroll; height:400px;">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
    div#accordionExample table th,
    div#accordionExample table td {
        width: 100px;
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
</style>
<script src="//cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<script>
    $(document).ready(function() {

       // Define the common toolbar configuration
    const ckeditorConfig = {
        toolbarGroups: [
            {
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
                "name": "insert",
                "groups": ["Image"]
            },
            {
                "name": "styles",
                "groups": ["styles"]
            }
        ],
        removeButtons: 'Strike,Subscript,Superscript,Anchor,Styles,Specialchar,Source'
    };

    // Apply CKEditor to multiple textareas
    CKEDITOR.replace('TaskQaAssignment_remark', ckeditorConfig);
    CKEDITOR.replace('TaskQaAssignment_remark1', ckeditorConfig);

    });
    $('#exampleModalCenter').on('show.bs.modal', function(event) {
        var myVal = $(event.relatedTarget).data('id');

        $.ajax({
            type: 'GET',
            url: '/mapping_expense',
            data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal,
            success: function(response) {
                if (response != '') {
                    $('#modal-body').html(response);
                }
            }
        });

        //alert(myVal); return false;
        //$(this).find(".modal-body").text(myVal);
    });
    $('#exampleModalCenter1').on('show.bs.modal', function(event) {
        var myVal = $(event.relatedTarget).data('id');
        $.ajax({
            type: 'GET',
            url: '/mapping_income',
            data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal,
            success: function(response) {
                if (response != '') {
                    $('#modal-body1').html(response);
                }
            }
        });
    });
    $('#exampleModalCenter2').on('show.bs.modal', function(event) {
        // alert($(this).attr('data-id'));
        var myVal = $(event.relatedTarget).data('id');
        //alert(myVal);
        $.ajax({
            type: 'GET',
            url: '/mapping_agriculture',
            data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal,
            success: function(response) {
                if (response != '') {
                    $('#modal-body2').html(response);
                }
            }
        });
    });
    $('#exampleModalCenter3').on('show.bs.modal', function(event) {
        // alert($(this).attr('data-id'));
        var myVal = $(event.relatedTarget).data('id');
        //alert(myVal);
        $.ajax({
            type: 'GET',
            url: '/mapping_agriculture_next',
            data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal,
            success: function(response) {
                if (response != '') {
                    $('#modal-body3').html(response);
                }
            }
        });
    });
    $('#exampleModalCenter4').on('show.bs.modal', function(event) {
        // alert($(this).attr('data-id'));
        var myVal = $(event.relatedTarget).data('id');
        //alert(myVal);
        $.ajax({
            type: 'GET',
            url: '/expenditure_this',
            data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal,
            success: function(response) {
                if (response != '') {
                    $('#modal-body4').html(response);
                }
            }
        });
    });
    $('#exampleModalCenter5').on('show.bs.modal', function(event) {
        // alert($(this).attr('data-id'));
        var myVal = $(event.relatedTarget).data('id');
        //alert(myVal);
        $.ajax({
            type: 'GET',
            url: '/expenditure_next',
            data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal,
            success: function(response) {
                if (response != '') {
                    $('#modal-body5').html(response);
                }
            }
        });
    });
    $('#exampleModalCenter6').on('show.bs.modal', function(event) {
        // alert($(this).attr('data-id'));
        var myVal = $(event.relatedTarget).data('id');
        //alert(myVal);
        $.ajax({
            type: 'GET',
            url: '/loan_expenditure_this',
            data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal,
            success: function(response) {
                if (response != '') {
                    $('#modal-body6').html(response);
                }
            }
        });
    });
    $('#exampleModalCenter7').on('show.bs.modal', function(event) {
        // alert($(this).attr('data-id'));
        var myVal = $(event.relatedTarget).data('id');
        //alert(myVal);
        $.ajax({
            type: 'GET',
            url: '/loan_expenditure_next',
            data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal,
            success: function(response) {
                if (response != '') {
                    $('#modal-body7').html(response);
                }
            }
        });
    });
    $('#exampleModalCenter9').on('show.bs.modal', function(event) {
        var myVal = $(event.relatedTarget).data('id');
        var val = $(event.relatedTarget).data('val');

        $.ajax({
            type: 'GET',
            url: '/mapping_other_income',
            data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal + '&val=' + val,
            success: function(response) {
                if (response != '') {
                    $('#modal-body9').html(response);
                }
            }
        });
    });
    $('#remarks_m').on('show.bs.modal', function(event) {
        var myVal = $(event.relatedTarget).data('id');
        var type = $(event.relatedTarget).data('type');
        $.ajax({
            type: 'GET',
            url: '/get_remarks',
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
            url: '/get_remarks',
            data: '_token = <?php echo csrf_token(); ?>&myVal=' + myVal + '&type=' + type,
            success: function(response) {
                if (response != '') {
                    $('#modal-body11').html(response);
                }
            }
        });
    });



    function submitAction() {
        var id = $('#task_id').val();
        var sts = $('#TaskQaAssignment_status').val();
        var rmk = $('#TaskQaAssignment_remark').val();
        //var user_id = $('#user_id').val();
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
                        url: '/change_qa_status_fed',
                        type: 'GET',
                        // data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts +
                        //     '&rmk=' + rmk +
                        //     '&assignment_type="FM"&user_id=' + user_id,
                        data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts +
                            '&rmk=' + rmk + '&assignment_type="FM"',
                        success: function(response) {
                            data = JSON.parse(response);
                            if (data.result == 1) {
                                if ("<?php echo e($quality_check); ?>" == '0' ||
                                    "<?php echo e($quality_check); ?>" == 0) {
                                    location.reload();

                                } else {
                                    window.location.href =
                                        "<?php echo e(url('federation_task_qa')); ?>";
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
        var ctx = document.getElementById("raating_d_chart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Rating", ""],
                datasets: [{
                    data: ['<?php echo e($grand_total_cy); ?>', '<?php echo e(100 - $grand_total_cy); ?>'],
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
    <?php endif; ?>

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
                        $('#facilitator_id').html(data);
                        $('#facilitator_id').val($('#facilitator').val());
                        $('#facilitator_id').trigger("change");
                        // $('#user_id').html(data);

                        // var facilitatorId = $('#facilitator').val(); // Get integer value of facilitator
                        // alert(facilitatorId);
                        // // Find matching option in the response
                        // $('#user_id').each(function() {
                        //     if ($(this).val() == facilitatorId) {
                        //         $(this).prop('selected', true);
                        //     }
                        // });

                        // $('#user_id').trigger("change");
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

    $('#get_loan').on('change', function(e) {

        var get_loan = $(this).val();

        if (get_loan == "No") {
            $('#loan_changes').hide();
            $('#loan_date').prop('disabled', true);
            $('#loan_amount').prop('disabled', true);
            $('#loan_date').val(``);
            $('#loan_amount').val(``);
        }
        if (get_loan == "Yes") {
            $('#loan_changes').show();
            $('#loan_date').prop('disabled', false);
            $('#loan_date').prop('required', true);
            $('#loan_amount').prop('disabled', false);
            $('#loan_amount').prop('required', true);
        }


    });
    $('#get_verified').on('change', function(e) {

        var get_verified = $(this).val();

        if (get_verified == "Reject") {
            $('#uloan_amount').prop('disabled', true);
            $('#uloan_pur').prop('disabled', true);
            $('#uloan_mode').prop('disabled', true);
            $('#uloan_duration').prop('disabled', true);
            $('#uloan_installments').prop('disabled', true);
            $('#uloan_amount').val(``);
            $('#uloan_pur').val(``);
            $('#uloan_mode').val(``);
            $('#uloan_duration').val(``);
            $('#uloan_installments').val(``);
        }
        if (get_verified == "Verified") {
            $('#uloan_amount').prop('disabled', false);
            $('#uloan_amount').prop('required', true);
            $('#uloan_pur').prop('disabled', false);
            $('#uloan_pur').prop('required', true);
            $('#uloan_mode').prop('disabled', false);
            $('#uloan_mode').prop('required', true);
            $('#uloan_duration').prop('disabled', false);
            $('#uloan_duration').prop('required', true);
            $('#uloan_installments').prop('disabled', false);
            $('#uloan_installments').prop('required', true);
        }


    });
    $('#uloan_mode').on('change', function(e) {

        var uloan_mode = $(this).val();

        if (uloan_mode == "Monthly") {
            $('.uloan_duration1').show();
            $('.uloan_duration').hide();
        }
        if (uloan_mode == "Yearly") {
            $('.uloan_duration').show();
            $('.uloan_duration1').hide();
        }



    });

    $('#loan_mode').on('change', function(e) {

        var uloan_mode = $(this).val();

        if (uloan_mode == "Monthly") {
            $('.loan_duration1').show();
            $('.loan_duration').hide();
        }
        if (uloan_mode == "Yearly") {
            $('.loan_duration').show();
            $('.loan_duration1').hide();
        }
    });
    $(document).ready(function() {
        $('#dm_id').on('change', get_facilitator_list);
        $('#TaskQaAssignment_status').on('change', set_facilitator);
        $('#TaskQaAssignment_status').trigger('change');
        <?php if($qa_status == 'R' || $qa_status == 'V'): ?>
        $('#TaskQaAssignment_status').val("<?php echo e($qa_status); ?>");
        
        <?php endif; ?>
        $('.show_div').hide();
        var today = new Date();
        var tomorrow = new Date();
        // if($loan_approvel[0]->uloan_duration = ''){
        // $('.uloan_duration1').hide();
        // }
        // if($loan_disbursement[0]->loan_duration = ''){
        // $('.loan_duration1').hide();
        // }
        //var s_date = $loan_approvel[0]->date;
        tomorrow.setDate(today.getDate());
        var to = "<?php echo e(!empty($loan_approvel[0]->date) ? $loan_approvel[0]->date : ''); ?>";
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            startDate: to,
            endDate: tomorrow,
            enableOnReadonly: false
        });

        $('#TaskQaAssignment_status').change(function() {

            var value = $(this).val();
            // alert(value);
            if(value == 'R'){
                $('#buisness_status').hide();
                $('#buisness').prop('checked', false);
                $('.show_div').show();
            }if(value == 'V'){
                $('#buisness_status').show();
                $('.show_div').hide();
            }
        });
        // $('#buisness').click(function() {
        //     alert("kl");
        //     var dm_id = $('#dm_id').val();
        //     if ($(this).is(':checked')) {
        //         $('.show_div').show();
        //         get_facilitator_list(dm_id);
        //     }else{
        //         $('.show_div').hide();
        //     }

        // });
        $('#buisness').click(function () {

                var dm_id = $('#dm_id').val();
                if ($(this).is(':checked')) {

                    $('.show_div').show();
                    get_facilitator_list(dm_id);
                    $('#business_hidden').val('1');
                } else {
                    $('#business_hidden').val('0');
                    $('.show_div').hide();
                }
        });
    });

    function submitAction1() {
        //alert('kkk');
        var id = $('#family_sub_mst').val();
        var glon = $('#get_loan').val();
        var ldte = $('#loan_date').val();
        var lamt = $('#loan_amount').val();
        var lpur = $('#loan_purpose').val();
        var lmod = $('#loan_mode').val();
        var ldur = $('#loan_duration').val();
        var lint = $('#loan_installments').val();

        //var user_id = $('#user_id').val();
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
                        url: '/loan_disbursement',
                        type: 'GET',
                        data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&glon=' + glon +
                            '&ldte=' + ldte +
                            '&lamt=' + lamt + '&lpur=' + lpur + '&lmod=' + lmod + '&ldur=' + ldur +
                            '&lint=' + lint,
                        //data:'_token = <?php echo csrf_token(); ?>&id=' + id ,
                        success: function(response) {
                            data = JSON.parse(response);
                            if (data.result == 1) {
                                bootbox.alert('<h3>Data Saved Succesfully</h3>');
                                location.reload();
                            } else {
                                bootbox.alert('<h3>Error</h3>');

                            }
                        }
                    });
                }
            }
        });

    }

    function submitAction2() {
        //alert('kkk');
        var id = $('#family_sub_mst').val();
        var gver = $('#get_verified').val();
        var ulam = $('#uloan_amount').val();
        var ulpur = $('#uloan_pur').val();
        var ulmod = $('#uloan_mode').val();
        var uldur = $('#uloan_duration').val();
        var ulint = $('#uloan_installments').val();

        //alert(uldur);

        //var user_id = $('#user_id').val();
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
                        url: '/loan_approvel',
                        type: 'GET',
                        data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&gver=' + gver +
                            '&ulam=' + ulam +
                            '&ulpur=' + ulpur + '&ulmod=' + ulmod + '&uldur=' + uldur + '&ulint=' +
                            ulint,
                        //data:'_token = <?php echo csrf_token(); ?>&id=' + id ,
                        success: function(response) {
                            data = JSON.parse(response);
                            if (data.result == 1) {
                                bootbox.alert('<h3>Data Saved Succesfully</h3>');
                                location.reload();
                            } else {
                                bootbox.alert('<h3>Error</h3>');

                            }
                        }
                    });
                }
            }
        });

    }
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    function submitAction3() {

        var id = $('#task_id').val();
        var sts = $('#TaskQaAssignment_status').val();
        // var rmk = $('#TaskQaAssignment_remark').text();
        var task_status = $('#task_status').val();
        var task_type = $('#task_type').val();
        var task_status_qa_p1 = $('#task_status_qa_p1').val();
        var editor = CKEDITOR.instances['TaskQaAssignment_remark'];
        var remark = editor.getData();

        var rmk = encodeURIComponent(remark);
        
        var user_id = $('#user_id').val();
        
        // alert(task_status);
        // alert(task_status_qa_p1);
        if(user_id != null){
        if (task_type == "P2") {
            if (task_status == "V" && sts == "V" && (task_status_qa_p1 != "R" || task_status_qa_p1 == '')) {
                // alert("1st");
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
                            $('#save3').prop('disabled', true);
                            $('#save3').css('opacity', '0.4');
                            $.ajax({
                                url: '/change_qa_status_fm',
                                type: 'POST',
                                data: {
                                    _token: csrfToken, // Use the dynamically retrieved CSRF token
                                    id: id,
                                    sts: sts,
                                    rmk: rmk,
                                    assignment_type: "FM",
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
            } else if ((task_status == "V" || task_status_qa_p1 == "R") && sts == "R") {
                // ((task_status == "V" || task_status_qa_p1 == "R") && sts == "R")
                // alert("lll");
                // exit();
                // (task_status == "V" || task_status == "R" || task_status == "P") && sts == "R")
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
                            $('#save3').prop('disabled', true);
                            $('#save3').css('opacity', '0.4');
                            $.ajax({
                                url: '/change_qa_status_fm',
                                type: 'POST',
                                data: {
                                    _token: csrfToken, // Use the dynamically retrieved CSRF token
                                    id: id,
                                    sts: sts,
                                    rmk: rmk,
                                    assignment_type: "FM",
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
            } else {
                bootbox.confirm({
                    title: "Save Manager Action ?",
                    message: "Please first verify the family part 1",
                    buttons: {

                        confirm: {
                            label: '<i class="fa fa-check"></i> OK'
                        }
                    },
                    callback: function(result) {
                        // location.reload();
                    }

                });
            }
        } else {

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
                    // alert(result);
                    if (result) {
                        $('#save3').prop('disabled', true);
                        $('#save3').css('opacity', '0.4');
                        $.ajax({
                            url: '/change_qa_status_fm',
                            type: 'POST',
                            data: {
                                    _token: csrfToken, // Use the dynamically retrieved CSRF token
                                    id: id,
                                    sts: sts,
                                    rmk: rmk,
                                    assignment_type: "FM",
                                    user_id: user_id
                                },
                            //data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts + '&rmk=' + rmk + '&assignment_type="FM"&qrmk=' +qrmk,
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
        else{
            alert("Please select the Facilitator first");
        }



    }

    function submitAction4() {


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
                    $('#save4').prop('disabled', true);
                    $('#save4').css('opacity', '0.4');
                    $.ajax({
                        url: '/change_qa_status_fed1',
                        type: 'POST',

                            data: {
                                    _token: csrfToken, // Use the dynamically retrieved CSRF token
                                    id: id,
                                    sts: sts,
                                    rmk: rmk,
                                    assignment_type: "FM"
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


    function submitAction5() {

        var business = $('#business_hidden').val();
        var id = $('#task_id').val();
        var sts = $('#TaskQaAssignment_status').val();
        // var rmk = $('#TaskQaAssignment_remark').text();
        var task_status = $('#task_status').val();
        var task_type = $('#task_type').val();
        var task_status_qa_p1 = $('#task_status_qa_p1').val();
        var editor = CKEDITOR.instances['TaskQaAssignment_remark'];
        var remark = editor.getData();
        // alert(task_status);
        // alert(sts);
        // alert(task_status_qa_p1);
        // exit();
        var rmk = encodeURIComponent(remark);

        var user_id = $('#facilitator_id').val();


        if(user_id != null){
            if (task_type == "P2" ) {

                if (task_status == "V" && sts == "V" && (task_status_qa_p1 != "R" || task_status_qa_p1 == '')) {
                    // alert('first');
                    // exit();
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
                                $('#save5').prop('disabled', true);
                                $('#save5').css('opacity', '0.4');
                                $.ajax({
                                    url: '/change_qa_status_fm_new',
                                    type: 'POST',
                                    data: {
                                        _token: csrfToken, // Use the dynamically retrieved CSRF token
                                        id: id,
                                        sts: sts,
                                        rmk: rmk,
                                        assignment_type: "FM",
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
                }else if( sts == "R"){
                    // alert('second');
                    // exit();
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
                            $('#save5').prop('disabled', true);
                            $('#save5').css('opacity', '0.4');
                            $.ajax({
                                url: '/change_qa_status_fm_new',
                                type: 'POST',
                                data: {
                                    _token: csrfToken, // Use the dynamically retrieved CSRF token
                                    id: id,
                                    sts: sts,
                                    rmk: rmk,
                                    assignment_type: "FM",
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
                }else{
                    bootbox.confirm({
                    title: "Save Manager Action ?",
                    message: "Please first verify the family part 1",
                    buttons: {

                        confirm: {
                            label: '<i class="fa fa-check"></i> OK'
                        }
                    },
                    callback: function(result) {
                        // location.reload();
                    }

                });
                }
            } else {
                // alert('third');
                // exit();
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
                        // alert(result);
                        if (result) {
                            $('#save5').prop('disabled', true);
                            $('#save5').css('opacity', '0.4');
                            $.ajax({
                                url: '/change_qa_status_fm_new',
                                type: 'POST',
                                data: {
                                        _token: csrfToken, // Use the dynamically retrieved CSRF token
                                        id: id,
                                        sts: sts,
                                        rmk: rmk,
                                        assignment_type: "FM",
                                        user_id: user_id,
                                        business:business
                                    },
                                //data: '_token = <?php echo csrf_token(); ?>&id=' + id + '&sts=' + sts + '&rmk=' + rmk + '&assignment_type="FM"&qrmk=' +qrmk,
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
        else{
            alert("Please select the Facilitator first");
        }



}




</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/family/view.blade.php ENDPATH**/ ?>