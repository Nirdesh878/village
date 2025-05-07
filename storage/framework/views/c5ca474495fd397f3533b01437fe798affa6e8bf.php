

<?php $__env->startSection('content'); ?>
<?php $user = \Illuminate\Support\Facades\Auth::user();?>

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ul>
                </div>
                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline">
                        <h2>Dashboard</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-right">
            </div>
        </div>
    </div>

    <div class="page-body">
        <?php if($user->u_type != 'M'): ?>
        <div class="row pb-4">
            <!-- task, page, download counter  start -->
            <div class="col-sm">
                <div class="w-box1 s-box">
                    <div class="d-flex">
                        <div class="count">
                            <h4>Total Family</h4>
                            <h3><?php echo e($model['Family_Total']); ?></h3>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="w-box2 s-box">
                    <div class="d-flex">
                        <div class="count">
                            <h4>Total SHG</h4>
                            <h3><?php echo e($model['Shg_Total']); ?></h3>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="w-box3 s-box">
                    <div class="d-flex">
                        <div class="count">
                            <h4>Total Cluster</h4>
                            <h3><?php echo e($model['Cluster_Total']); ?></h3>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="w-box4 s-box">
                    <div class="d-flex">
                        <div class="count">
                            <h4>Total Federation</h4>
                            <h3><?php echo e($model['Federation_Total']); ?></h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 mt-4">
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h5>Family Overview</h5>
                            </span>
                        </div>
                        <div class="w-box">
                            <canvas id="familyoverview"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 mt-4">
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h5>Family Analytics/Rating Result</h5>
                            </span>
                        </div>
                        <div class="w-box">
                            <canvas id="familyanalyticsrating"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-4">
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h5 style="margin-bottom: 28px;">Family Wealth Ranking & Result</h5>
                                <h6 style="margin-top: 5px;"><strong>Total:
                                        <?php echo e($fw_vpoor[0]->total + $fw_poor[0]->total + $fw_mpoor[0]->total + $fw_rich[0]->total); ?></strong>
                                </h6>
                            </span>
                        </div>
                        <div class="w-box" style=" height: 410px;width: 100%">
                            <canvas id="familyWealthRanking"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-4">
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h5 style="margin-bottom: 28px;">Family Credit Plan Based on Analytics</h5>
                                <h6 style="margin-top: 5px;">
                                    <strong>Total:
                                        <?php echo e('₹ ' . nice_number($family_pie_total[0]->total_loan)); ?></strong>
                                    
                                </h6>
                            </span>
                        </div>
                        <div class="w-box" style="height: 150px !important;width: 300px !important;margin: auto;">
                            <canvas id="familycreditplanonanalytics"></canvas>
                        </div>
                        <div class="row">
                            <div class="w-box col-md-6" style="height: 150px !important;width: 300px !important;margin-left: -20px;padding: 0px">
                                <canvas id="pi2"></canvas>
                            </div>
                            <div class="col-md-6 pt-5 text-justify" style="margin-left: -70px;">
                                <h6><strong>Qualified</strong><span style="float: right;margin-left: auto;"><?php echo e('₹ ' . nice_number($family_pie[0]->qualified_loan)); ?></span>
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="w-box col-md-6" style="height: 150px !important;width: 300px !important;margin-left: -20px;padding: 0px;margin-top: -41px;">
                                <canvas id="pi3"></canvas>
                            </div>
                            <div class="col-md-6 pt-0 text-justify" style="margin-left: -70px;">
                                <h6><strong>Non Qualified</strong> <span style="float: right;margin-left: auto;"><?php echo e('₹ ' . nice_number($family_pie_total[0]->total_loan - $family_pie[0]->qualified_loan)); ?></span>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h4>Recent Families Added</h4>
                            </span>
                            <div class="ml-auto">
                                <a href="<?php echo e(route('family.index')); ?>" class="btn btn-success">View All</a>

                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table class="table table-striped table-bordered nowrap dataTable home-table">
                                <thead>
                                    <tr>
                                        <th width="5%">S.No</th>
                                        <th width="10%">Created At</th>
                                        <th width="15%">Family</th>
                                        <th width="20%">UIN</th>
                                        <th width="15%">Approval Status</th>
                                        <th width="15%">Last Update</th>
                                        <th width="10%">Status</th>
                                        <th width="30%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    ?>
                                    <?php if(!empty($families)): ?>
                                    <?php $__currentLoopData = $families; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $family): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if ($family->dm_p1 == 'V' && $family->qa_p1 == 'V' && $family->dm_p2 == 'V' && $family->qa_p2 == 'V' && $family->locked == 1) {
                                    $visit = 'Locked';
                                    } elseif ($family->dm_p1 == 'V' && $family->dm_p2 == 'V' && $family->qa_p1 == 'V' && $family->qa_p2 == 'V') {
                                    $visit = 'Initial Rating';
                                    } elseif ($family->dm_p1 == 'V' && $family->dm_p2 == 'V') {
                                    $visit = 'Analytics Complete';
                                    } else if (($family->dm_p2 == 'P' || $family->dm_p2 == 'V') && ($family->dm_p1 == 'V' || $family->dm_p1 == 'P' || $family->dm_p1 == 'R')) {
                                    $visit = 'Second Visit';
                                    } else if ($family->dm_p2 == 'R' && $family->flag == 1) {
                                    $visit = 'Second Visit Reassigned';
                                    } else if ($family->dm_p1 == 'P' || $family->dm_p1 == 'V') {
                                    $visit = 'First Visit';
                                    } else if ($family->dm_p1 == 'R' && $family->flag == 1) {
                                    $visit = 'First Visit Reassigned';
                                    } elseif ($family->dm_p1 == 'N') {
                                    $visit = 'First Visit Pending';
                                    } else {
                                    $visit = 'Created';
                                    }
                                    ?>
                                    <tr class="<?php echo e(0 == $i % 2 ? 'even' : 'odd'); ?>">
                                        <td><?php echo e($i++); ?></td>
                                        <td><?php echo e(change_date_month_name_char($family->created)); ?></td>
                                        <td><?php echo e($family->fp_member_name); ?></td>
                                        <td><?php echo e($family->uin); ?></td>
                                        <td><?php echo e($visit); ?></td>
                                        <td><?php echo e(change_date_month_name_char($family->updated_at)); ?></td>
                                        <td>
                                            <?php if($family->status == 'A'): ?>
                                            <span class="status-active">Active</span>
                                            <?php else: ?>
                                            <span class="status-inactive">InActive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="<?php echo e(route('family.edit', $family->family_mst_id)); ?>" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>
                                            <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete( $family->family_mst_id)" title="Delete User" style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No Data Available</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h5>SHG Overview</h5>
                            </span>
                        </div>
                        <div class="w-box">
                            <canvas id="shgoverview"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h5>SHG Analytics/Rating Result</h5>
                            </span>
                        </div>
                        <div class="w-box">
                            <canvas id="shganalyticsrating"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h4>Recent SHG Added</h4>
                            </span>
                            <div class="ml-auto">
                                <a href="<?php echo e(route('shg.index')); ?>" class="btn btn-success">View All</a>

                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table class="table table-striped table-bordered nowrap dataTable home-table">
                                <thead>
                                    <tr>
                                        <th width="5%">S.No</th>
                                        <th width="10%">Created At</th>
                                        <th width="20%">SHG</th>
                                        <th width="20%">UIN</th>
                                        <th width="15%">Approval Status</th>
                                        <th width="10%">Last Update</th>
                                        <th width="10%">Status</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    ?>
                                    <?php if(!empty($shgs)): ?>
                                    <?php $__currentLoopData = $shgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $visit = 'Created';
                                    if ($shg->dm_a == 'V' && $shg->qa_a == 'V' && $shg->locked == 1) {
                                    $visit = 'Locked';
                                    } elseif ($shg->dm_a == 'V' && $shg->qa_a == 'V') {
                                    $visit = 'Initial Rating';
                                    } elseif ($shg->dm_a == 'V' && $shg->qa_a == 'P') {
                                    $visit = 'Analytics Complete';
                                    } elseif ($shg->dm_a == 'P') {
                                    $visit = 'Visit Complete';
                                    } elseif ($shg->dm_a == 'N') {
                                    $visit = 'Visit Pending';
                                    } elseif ($shg->dm_a == 'R' && $shg->flag == 1) {
                                    $visit = 'Visit Reassigned';
                                    }
                                    ?>
                                    <tr class="<?php echo e(0 == $i % 2 ? 'even' : 'odd'); ?>">
                                        <td><?php echo e($i++); ?></td>
                                        <td><?php echo e(change_date_month_name_char($shg->created)); ?></td>
                                        <td><?php echo e($shg->shgName); ?></td>
                                        <td><?php echo e($shg->uin); ?></td>
                                        <td><?php echo e($visit); ?></td>
                                        <td><?php echo e(change_date_month_name_char($shg->updated_at)); ?></td>
                                        <td>
                                            <?php if($shg->status == 'A'): ?>
                                            <span class="status-active">Active</span>
                                            <?php else: ?>
                                            <span class="status-inactive">InActive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>

                                            <a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="<?php echo e(route('shg.edit', $shg->shg_mst_id)); ?>" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>
                                            <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete( $shg->shg_mst_id)" title="Delete User" style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No Data Available</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h5>Cluster Overview</h5>
                            </span>
                        </div>
                        <div class="w-box">
                            <canvas id="clusteroverview"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h5>Cluster Analytics/Rating Result</h5>
                            </span>
                        </div>
                        <div class="w-box">
                            <canvas id="clusteranalyticsrating"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h4>Recent Cluster Added</h4>
                            </span>
                            <div class="ml-auto">
                                <a href="<?php echo e(route('cluster.index')); ?>" class="btn btn-success">View All</a>

                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table class="table table-striped table-bordered nowrap dataTable home-table">
                                <thead>
                                    <tr>
                                        <th width="5%">S.No</th>
                                        <th width="10%">Created At</th>
                                        <th width="15%">clusters</th>
                                        <th width="20%">UIN</th>
                                        <th width="15%">Approval Status</th>
                                        <th width="15%">Last Update</th>
                                        <th width="10%">Status</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    ?>
                                    <?php if(!empty($clusters)): ?>
                                    <?php $__currentLoopData = $clusters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cluster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $visit = 'Created';
                                    if ($cluster->dm_a == 'V' && $cluster->qa_a == 'V' && $cluster->locked == 1) {
                                    $visit = 'Locked';
                                    } elseif ($cluster->dm_a == 'V' && $cluster->qa_a == 'V') {
                                    $visit = 'Initial Rating';
                                    } elseif ($cluster->dm_a == 'V' && $cluster->qa_a == 'P') {
                                    $visit = 'Analytics Complete';
                                    } elseif ($cluster->dm_a == 'P') {
                                    $visit = 'Visit Complete';
                                    } elseif ($cluster->dm_a == 'N') {
                                    $visit = 'Visit Pending';
                                    } elseif ($cluster->dm_a == 'R' && $cluster->flag == 1) {
                                    $visit = 'Visit Reassigned';
                                    }
                                    ?>
                                    <tr class="<?php echo e(0 == $i % 2 ? 'even' : 'odd'); ?>">
                                        <td><?php echo e($i++); ?></td>
                                        <td><?php echo e(change_date_month_name_char($cluster->created)); ?></td>
                                        <td><?php echo e($cluster->name_of_cluster); ?></td>
                                        <td><?php echo e($cluster->uin); ?></td>
                                        <td><?php echo e($visit); ?></td>
                                        <td><?php echo e(change_date_month_name_char($cluster->updated_at)); ?></td>
                                        <td>
                                            <?php if($cluster->status == 'A'): ?>
                                            <span class="status-active">Active</span>
                                            <?php else: ?>
                                            <span class="status-inactive">InActive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>

                                            <a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="<?php echo e(route('cluster.edit', $cluster->cluster_mst_id)); ?>" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>
                                            <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete( $cluster->cluster_mst_id)" title="Delete User" style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No Data Available</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h5>Federation Overview</h5>
                            </span>
                        </div>
                        <div class="w-box">
                            <canvas id="federationoverview"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h5>Federation Analytics/Rating Result</h5>
                            </span>
                        </div>
                        <div class="w-box">
                            <canvas id="federationanalyticsrating"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-block">
                        <div class="w-heading d-flex">
                            <span>
                                <h4>Recent Federation Added</h4>
                            </span>
                            <div class="ml-auto">
                                <a href="<?php echo e(route('federation.index')); ?>" class="btn btn-success">View All</a>

                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table class="table table-striped table-bordered nowrap dataTable home-table">
                                <thead>
                                    <tr>
                                        <th width="5%">S.No</th>
                                        <th width="10%">Created At</th>
                                        <th width="15%">Federation</th>
                                        <th width="20%">UIN</th>
                                        <th width="10%">Approval Status</th>
                                        <th width="15%">Last Update</th>
                                        <th width="15%">Status</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    ?>
                                    <?php if(!empty($federations)): ?>
                                    <?php $__currentLoopData = $federations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $federation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $visit = 'Created';
                                    if ($federation->dm_a == 'V' && $federation->qa_a == 'V' && $federation->locked == 1) {
                                    $visit = 'Locked';
                                    } elseif ($federation->dm_a == 'V' && $federation->qa_a == 'V') {
                                    $visit = 'Initial Rating';
                                    } elseif ($federation->dm_a == 'V' && $federation->qa_a == 'P') {
                                    $visit = 'Analytics Complete';
                                    } elseif ($federation->dm_a == 'P') {
                                    $visit = 'Visit Complete';
                                    } elseif ($federation->dm_a == 'N' && $federation->flag == 0) {
                                    $visit = 'Visit Pending';
                                    } elseif ($federation->dm_a == 'R' && $federation->flag == 1) {
                                    $visit = 'Visit Reassigned';
                                    }
                                    ?>
                                    <tr class="<?php echo e(0 == $i % 2 ? 'even' : 'odd'); ?>">
                                        <td><?php echo e($i++); ?></td>
                                        <td><?php echo e(change_date_month_name_char($federation->created)); ?>

                                        </td>
                                        <td><?php echo e($federation->name_of_federation); ?></td>
                                        <td><?php echo e($federation->uin); ?></td>
                                        <td><?php echo e($visit); ?></td>
                                        <td><?php echo e(change_date_month_name_char($federation->updated_at)); ?>

                                        </td>
                                        <td>
                                            <?php if($federation->status == 'A'): ?>
                                            <span class="status-active">Active</span>
                                            <?php else: ?>
                                            <span class="status-inactive">InActive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>

                                            <a class="btn btn-primary btn-link btn-sm" rel="tooltip" title="Edit" data-original-title="Edit" href="<?php echo e(route('federation.edit', $federation->federation_mst_id)); ?>" style="padding:0px;margin:0px"><i class="c-white-500 ti-pencil"></i></a>
                                            <a href="javascript:;" class="btn btn-danger btn-link btn-sm" rel="tooltip" title="Remove" onclick="fn_delete( $federation->federation_mst_id)" title="Delete User" style="padding:0px;margin:0px"><i class="c-white-500 ti-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No Data Available</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php endif; ?>

        <script type="text/javascript">
            //Family Overview
            <?php
            $familyoverviewAre = [];
            $familyoverviewAre[] = $model['Family_Total'];
            $familyoverviewAre[] = $model['Part_1_Completed'];
            $familyoverviewAre[] = $model['Part_2_Completed'];
            $familyoverviewAre[] = $model['Fully_Completed'];
            $familyoverviewAre[] = $model['Completed_Rating'];
            $familyoverviewAre[] = $model['verified']; //AS PER QA
            $familyoverviewAre[] = $model['loan_approved'];
            $familyoverviewAre[] = $model['loan_disbursed'];

            ?>
            var ctx = document.getElementById('familyoverview');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Total', 'First Visit', 'Second Visit', 'Analytics Complete', 'Initial Rating',
                        'Locked', 'Loan Approved', 'Loan Disbursed'
                    ],
                    datasets: [{
                        data: <?php echo json_encode($familyoverviewAre, true); ?>,
                        backgroundColor: ['#598FFF', '#B759FF', '#b46e39', '#FF599D', '#FFD359', '#FF5959',
                            '#FF8F59', '#A0E354'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 20,
                            bottom: 20
                        }
                    },
                    scales: {
                        yAxes: [{
                            barPercentage: 0.3,
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                suggestedMin: 0,
                                suggestedMax: 20,
                                maxTicksLimit: 6,
                                callback: function(value, index, values) {
                                    if (Math.floor(value) === value) {
                                        return value;
                                    }
                                }

                            }
                        }],
                        xAxes: [{
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                autoSkip: false,
                                display: false
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            generateLabels: function(chart) {
                                var labels = chart.data.labels;
                                var dataset = chart.data.datasets[0];
                                var legend = labels.map(function(label, index) {
                                    return {
                                        datasetIndex: 0,
                                        fillStyle: dataset.backgroundColor && dataset.backgroundColor[
                                            index],
                                        strokeStyle: dataset.borderColor && dataset.borderColor[index],
                                        lineWidth: dataset.borderWidth,
                                        text: label
                                    }
                                });
                                return legend;
                            }
                        }
                    },
                    animation: {
                        onComplete: function() {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal',
                                Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    for (var key in dataset._meta) {
                                        var model = dataset._meta[key].data[i]._model;
                                        ctx.fillText(dataset.data[i], model.x, model.y + 2);
                                    }
                                }
                            });
                        }
                    }
                }
            });
        </script>
        
        <?php
        /* $fwr_data_red = [];
                                    $fwr_data_gray = [];
                                    $fwr_data_yellow = [];
                                    $fwr_data_green = [];
                                    foreach ($model['wealth_ranking'] as $obj3) {
                                        $fwr_data_red[] = $obj3['red'];
                                        $fwr_data_gray[] = $obj3['grey'];
                                        $fwr_data_yellow[] = $obj3['yellow'];
                                        $fwr_data_green[] = $obj3['green'];
                                    }*/
        ?>
        <script>
            //Family Wealth Ranking
            var barOptions_stacked = {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 20,
                        bottom: 20
                    }
                },
                tooltips: {
                    enabled: true
                },
                hover: {
                    animationDuration: 0
                },
                scales: {
                    xAxes: [{
                        suggestedMin: 0,
                        ticks: {
                            beginAtZero: true,
                            fontFamily: "'Open Sans Bold', sans-serif",
                            fontSize: 11
                        },
                        scaleLabel: {
                            display: false
                        },
                        gridLines: {},
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            display: false,
                            color: "#fff",
                            zeroLineColor: "#fff",
                            zeroLineWidth: 0
                        },
                        ticks: {
                            beginAtZero: true,
                            suggestedMin: 0,
                            suggestedMax: 20,
                            maxTicksLimit: 6,

                            fontFamily: "'Open Sans Bold', sans-serif",
                            fontSize: 11,
                            callback: function(value, index, values) {
                                if (Math.floor(value) === value) {
                                    return value;
                                }
                            }
                        },
                    }]
                },
                plugins: {
                    datalabels: {
                        color: 'black',
                        font: {
                            weight: 'bold',
                            size: 10,
                        },
                        padding: {
                            bottom: 32
                        },

                        formatter: function(value, context) {
                            if (isNaN(context.dataset.data[context.dataIndex])) {
                                return null;
                            } else {
                                if (context.dataset.data[context.dataIndex] == 0) {
                                    return null;
                                } else {


                                    return context.dataset.data[context.dataIndex] + "";
                                }
                            }

                        }
                    },

                },
                legend: {
                    display: false
                },
                pointLabelFontFamily: "Quadon Extra Bold",
                scaleFontFamily: "Quadon Extra Bold",
            };
            var ctx = document.getElementById("familyWealthRanking");
            var data = {
                labels: ["Very Poor", "Poor", "Medium Poor", "Rich"],
                datasets: [{
                        label: "",
                        backgroundColor: 'red',
                        data: [<?php echo $fw_vpoor[0]->VPoor . ',' . $fw_poor[0]->VPoor . ',' . $fw_mpoor[0]->VPoor . ',' . $fw_rich[0]->VPoor; ?>],
                        datalabels: {
                            anchor: 'center',
                            align: 'center',
                        }
                    },
                    {
                        label: "",
                        backgroundColor: 'grey',
                        data: [<?php echo $fw_vpoor[0]->Poor . ',' . $fw_poor[0]->Poor . ',' . $fw_mpoor[0]->Poor . ',' . $fw_rich[0]->Poor; ?>],
                        datalabels: {
                            anchor: 'center',
                            align: 'center',
                        }
                    },
                    {
                        label: "",
                        backgroundColor: 'yellow',
                        data: [<?php echo $fw_vpoor[0]->MPoor . ',' . $fw_poor[0]->MPoor . ',' . $fw_mpoor[0]->MPoor . ',' . $fw_rich[0]->MPoor; ?>],
                        datalabels: {
                            anchor: 'center',
                            align: 'center',
                        }

                    },
                    {
                        label: "",
                        backgroundColor: 'green',
                        data: [<?php echo $fw_vpoor[0]->Rich . ',' . $fw_poor[0]->Rich . ',' . $fw_mpoor[0]->Rich . ',' . $fw_rich[0]->Rich; ?>],
                        datalabels: {
                            anchor: 'center',
                            align: 'center',
                        }

                    }
                ]
            };
            var myChart = new Chart(ctx, {
                plugins: [ChartDataLabels],
                type: 'bar',
                data: data,
                options: barOptions_stacked,
            });
        </script>

        <?php
        /*$qualified = $model['Qualified_business']['qualified'];
                                    $nonqualified = 0;
                                    if ($model['Family_Total'] > $model['Qualified_business']['qualified']) {
                                        $nonqualified = $model['Family_Total'] - $model['Qualified_business']['qualified'];
                                    }*/
        ?>
        <script>
            //Family Credit Plan on Analytics
            var ctx = document.getElementById("familycreditplanonanalytics").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Qualified", "Non Qualified"],
                    datasets: [{
                        backgroundColor: [
                            "#2ecc71",
                            "#3498db"
                        ],
                        data: ["<?php echo e($family_pie[0]->qualified_loan); ?>",
                            "<?php echo e($family_pie_total[0]->total_loan - $family_pie[0]->qualified_loan); ?>"
                        ]
                    }]
                },
                options: {
                    zoomOutPercentage: 10,
                    cutoutPercentage: 70,
                    legend: {
                        display: false,
                        position: 'bottom',
                        labels: {
                            generateLabels: function(chart) {
                                var labels = chart.data.labels;
                                var dataset = chart.data.datasets[0];
                                var legend = labels.map(function(label, index) {
                                    return {
                                        datasetIndex: 0,
                                        fillStyle: dataset.backgroundColor && dataset.backgroundColor[
                                            index],
                                        strokeStyle: dataset.borderColor && dataset.borderColor[index],
                                        lineWidth: dataset.borderWidth,
                                        text: label
                                    }
                                });
                                return legend;
                            }
                        },

                    },
                    plugins: {
                        labels: {
                            render: 'percentage',
                            fontColor: '#000',
                            position: 'outside',
                            outsidePadding: 4,
                            textMargin: 6
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataset = data.datasets[tooltipItem.datasetIndex];
                                var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                                var total = meta.total;
                                var currentValue = dataset.data[tooltipItem.index];
                                var percentage = parseFloat((currentValue / total * 100).toFixed(1));
                                return currentValue + ' (' + percentage + '%)';
                            },
                            title: function(tooltipItem, data) {
                                return data.labels[tooltipItem[0].index];
                            }
                        }
                    },
                }
            });
        </script>
        <?php
        $shgOverviewAre = [];
        $shgOverviewAre[] = $model['Shg_Total'];
        $shgOverviewAre[] = $model['Shg_visit'];
        $shgOverviewAre[] = $model['Shg_Full_Analytics'];
        $shgOverviewAre[] = $model['Shg_Full_Rating'];
        $shgOverviewAre[] = $model['Shg_verified'];
        ?>
        <script>
            //SHG Overview
            var ctx = document.getElementById('shgoverview');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Total', 'Visit Complete', 'Analytics Complete', 'Initial Rating', 'Locked'],
                    datasets: [{
                        data: <?php echo json_encode($shgOverviewAre, true); ?>,
                        backgroundColor: ['#598FFF', '#708090', '#BC8F8F', '#FFFF00', '#DC143C']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 20,
                            bottom: 20
                        }
                    },
                    scales: {
                        yAxes: [{
                            barPercentage: 0.3,
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                suggestedMin: 0,
                                suggestedMax: 20,
                                maxTicksLimit: 6,

                                callback: function(value, index, values) {
                                    if (Math.floor(value) === value) {
                                        return value;
                                    }
                                }

                            }
                        }],
                        xAxes: [{
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                autoSkip: false,
                                display: false
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            generateLabels: function(chart) {
                                var labels = chart.data.labels;
                                var dataset = chart.data.datasets[0];
                                var legend = labels.map(function(label, index) {
                                    return {
                                        datasetIndex: 0,
                                        fillStyle: dataset.backgroundColor && dataset.backgroundColor[
                                            index],
                                        strokeStyle: dataset.borderColor && dataset.borderColor[index],
                                        lineWidth: dataset.borderWidth,
                                        text: label
                                    }
                                });
                                return legend;
                            }
                        }
                    },
                    animation: {
                        onComplete: function() {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal',
                                Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    for (var key in dataset._meta) {
                                        var model = dataset._meta[key].data[i]._model;
                                        ctx.fillText(dataset.data[i], model.x, model.y + 2);
                                    }
                                }
                            });
                        }
                    }
                }
            });
        </script>
        <?php
        $clusterOverviewAre = [];
        $clusterOverviewAre[] = $model['Cluster_Total'];
        $clusterOverviewAre[] = $model['Cluster_Visit']; //No status for this
        $clusterOverviewAre[] = $model['Cluster_Full_Analytics'];
        $clusterOverviewAre[] = $model['Cluster_Full_Rating'];
        $clusterOverviewAre[] = $model['Cluster_verified']; //AS PER QA
        ?>
        <script>
            //Cluster Overview
            var ctx = document.getElementById('clusteroverview');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Total', 'Visit Complete', 'Analytics Complete', 'Initial Rating', 'Locked'],
                    datasets: [{
                        data: <?php echo json_encode($clusterOverviewAre, true); ?>,
                        backgroundColor: ['#598FFF', '#708090', '#BC8F8F', '#FFFF00', '#DC143C']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 20,
                            bottom: 20
                        }
                    },
                    scales: {
                        yAxes: [{
                            barPercentage: 0.3,
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                suggestedMin: 0,
                                suggestedMax: 20,
                                maxTicksLimit: 6,

                                callback: function(value, index, values) {
                                    if (Math.floor(value) === value) {
                                        return value;
                                    }
                                }

                            }
                        }],
                        xAxes: [{
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                autoSkip: false,
                                display: false
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            generateLabels: function(chart) {
                                var labels = chart.data.labels;
                                var dataset = chart.data.datasets[0];
                                var legend = labels.map(function(label, index) {
                                    return {
                                        datasetIndex: 0,
                                        fillStyle: dataset.backgroundColor && dataset.backgroundColor[
                                            index],
                                        strokeStyle: dataset.borderColor && dataset.borderColor[index],
                                        lineWidth: dataset.borderWidth,
                                        text: label
                                    }
                                });
                                return legend;
                            }
                        }
                    },
                    animation: {
                        onComplete: function() {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal',
                                Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    for (var key in dataset._meta) {
                                        var model = dataset._meta[key].data[i]._model;
                                        ctx.fillText(dataset.data[i], model.x, model.y + 2);
                                    }
                                }
                            });
                        }
                    }
                }
            });
        </script>

        <?php
        $FederationOverviewAre = [];
        $FederationOverviewAre[] = $model['Federation_Total'];
        $FederationOverviewAre[] = $model['Federation_Visit']; //No status for this
        $FederationOverviewAre[] = $model['Federation_Full_Analytics'];
        $FederationOverviewAre[] = $model['Federation_Full_Rating'];
        $FederationOverviewAre[] = $model['Federation_verified']; //AS PER QA
        ?>
        <script>
            //Federation Overview
            var ctx = document.getElementById('federationoverview');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Total', 'Visit Complete', 'Analytics Complete', 'Initial Rating', 'Locked'],
                    datasets: [{
                        data: <?php echo json_encode($FederationOverviewAre, true); ?>,
                        backgroundColor: ['#598FFF', '#708090', '#BC8F8F', '#FFFF00', '#DC143C']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 20,
                            bottom: 20
                        }
                    },
                    scales: {
                        yAxes: [{
                            barPercentage: 0.3,
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                suggestedMin: 0,
                                suggestedMax: 20,
                                maxTicksLimit: 6,

                                callback: function(value, index, values) {
                                    if (Math.floor(value) === value) {
                                        return value;
                                    }
                                }

                            }
                        }],
                        xAxes: [{
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                autoSkip: false,
                                display: false
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            generateLabels: function(chart) {
                                var labels = chart.data.labels;
                                var dataset = chart.data.datasets[0];
                                var legend = labels.map(function(label, index) {
                                    return {
                                        datasetIndex: 0,
                                        fillStyle: dataset.backgroundColor && dataset.backgroundColor[
                                            index],
                                        strokeStyle: dataset.borderColor && dataset.borderColor[index],
                                        lineWidth: dataset.borderWidth,
                                        text: label
                                    }
                                });
                                return legend;
                            }
                        }
                    },
                    animation: {
                        onComplete: function() {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal',
                                Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    for (var key in dataset._meta) {
                                        var model = dataset._meta[key].data[i]._model;
                                        ctx.fillText(dataset.data[i], model.x, model.y + 2);
                                    }
                                }
                            });
                        }
                    }
                }
            });
        </script>
        <?php
        /*$ShgAnalyticsRating_green[] = $model['Rating']['shg_green'];
                                        $ShgAnalyticsRating_yellow[] = $model['Rating']['shg_yellow'];
                                        $ShgAnalyticsRating_grey[] = $model['Rating']['shg_grey'];
                                        $ShgAnalyticsRating_red[] = $model['Rating']['shg_red'];*/
        /* $ShgAnalyticsRating = [$model['Rating']['shg_green'], $model['Rating']['shg_yellow'], $model['Rating']['shg_grey'], $model['Rating']['shg_red']];*/
        ?>
        <script>
            //SHG Analytics Rating

            var ctx = document.getElementById("shganalyticsrating");
            var data = {
                labels: ["Minimal Risk", "low Risk", "Moderate Risk", "High Risk"],
                datasets: [{
                        label: "Analytics",
                        backgroundColor: ['#94D789', '#FFDB29', '#afaead', '#fe5d70', '#FF599D'],
                        data: [<?php echo $shg_ana_rating[0]->Minimal_Risk . ',' . $shg_ana_rating[0]->Low_Risk . ',' . $shg_ana_rating[0]->Moderate_Risk . ',' . $shg_ana_rating[0]->High_Risk; ?>]
                    },
                    //{
                    //label: "Rating",
                    //backgroundColor: ['#94D789', '#FFDB29', '#afaead', '#fe5d70', '#FF599D'],
                    //data: [<?php echo $shg_rate_bars[0]->Minimal_Risk . ',' . $shg_rate_bars[0]->Low_Risk . ',' . $shg_rate_bars[0]->Moderate_Risk . ',' . $shg_rate_bars[0]->High_Risk; ?>]
                    //}
                ]
            };
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 20,
                            bottom: 20
                        }
                    },
                    scales: {
                        yAxes: [{
                            barPercentage: 0.3,
                            ticks: {
                                beginAtZero: true,
                                suggestedMin: 0,
                                suggestedMax: 20,
                                maxTicksLimit: 6,

                                callback: function(value, index, values) {
                                    if (Math.floor(value) === value) {
                                        return value;
                                    }
                                }

                            }
                        }],
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                autoSkip: false,
                                display: false
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            generateLabels: function(chart) {
                                var labels = chart.data.labels;
                                var dataset = chart.data.datasets[0];
                                var legend = labels.map(function(label, index) {
                                    return {
                                        datasetIndex: 0,
                                        fillStyle: dataset.backgroundColor && dataset.backgroundColor[
                                            index],
                                        strokeStyle: dataset.borderColor && dataset.borderColor[index],
                                        lineWidth: dataset.borderWidth,
                                        text: label
                                    }
                                });
                                return legend;
                            }
                        }
                    },
                    animation: {
                        onComplete: function() {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal',
                                Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    for (var key in dataset._meta) {
                                        var model = dataset._meta[key].data[i]._model;
                                        ctx.fillText(dataset.data[i], model.x, model.y + 2);
                                    }
                                }
                            });
                        }
                    }
                }
            });
        </script>
        <?php
        /*$ClusterAnalyticsRating_green[] = $model['Rating']['cluster_green'];
                                    $ClusterAnalyticsRating_yellow[] = $model['Rating']['cluster_yellow'];
                                    $ClusterAnalyticsRating_grey[] = $model['Rating']['cluster_grey'];
                                    $ClusterAnalyticsRating_red[] = $model['Rating']['cluster_red'];*/

        /*$ClusterAnalyticsRating[] = $model['Rating']['cluster_green'];
                                    $ClusterAnalyticsRating[] = $model['Rating']['cluster_yellow'];
                                    $ClusterAnalyticsRating[] = $model['Rating']['cluster_grey'];
                                    $ClusterAnalyticsRating[] = $model['Rating']['cluster_red'];*/
        ?>
        <script>
            //Cluster Analytics Rating
            var ctx = document.getElementById("clusteranalyticsrating");
            var data = {
                labels: ["Minimal Risk", "low Risk", "Moderate Risk", "High Risk"],
                datasets: [{
                        label: "Analytics",
                        backgroundColor: ['#94D789', '#FFDB29', '#afaead', '#fe5d70', '#FF599D'],
                        data: [<?php echo $clus_ana_rating[0]->Minimal_Risk . ',' . $clus_ana_rating[0]->Low_Risk . ',' . $clus_ana_rating[0]->Moderate_Risk . ',' . $clus_ana_rating[0]->High_Risk; ?>]
                    }
                    //{
                    //label: "Rating",
                    //backgroundColor: ['#94D789', '#FFDB29', '#afaead', '#fe5d70', '#FF599D'],
                    //data: [<?php echo $clus_rate_bars[0]->Minimal_Risk . ',' . $clus_rate_bars[0]->Low_Risk . ',' . $clus_rate_bars[0]->Moderate_Risk . ',' . $clus_rate_bars[0]->High_Risk; ?>]
                    //}
                ]
            };
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 20,
                            bottom: 20
                        }
                    },
                    scales: {
                        yAxes: [{
                            barPercentage: 0.3,
                            ticks: {
                                beginAtZero: true,
                                suggestedMin: 0,
                                suggestedMax: 20,
                                maxTicksLimit: 6,

                                callback: function(value, index, values) {
                                    if (Math.floor(value) === value) {
                                        return value;
                                    }
                                }

                            }
                        }],
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                autoSkip: false,
                                display: false
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            generateLabels: function(chart) {
                                var labels = chart.data.labels;
                                var dataset = chart.data.datasets[0];
                                var legend = labels.map(function(label, index) {
                                    return {
                                        datasetIndex: 0,
                                        fillStyle: dataset.backgroundColor && dataset.backgroundColor[
                                            index],
                                        strokeStyle: dataset.borderColor && dataset.borderColor[index],
                                        lineWidth: dataset.borderWidth,
                                        text: label
                                    }
                                });
                                return legend;
                            }
                        }
                    },
                    animation: {
                        onComplete: function() {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal',
                                Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    for (var key in dataset._meta) {
                                        var model = dataset._meta[key].data[i]._model;
                                        ctx.fillText(dataset.data[i], model.x, model.y + 2);
                                    }
                                }
                            });
                        }
                    }
                }
            });
        </script>
        <?php
        /*$FederationAnalyticsRating_green[] = $model['Rating']['federation_green'];
                                    $FederationAnalyticsRating_yellow[] = $model['Rating']['federation_yellow'];
                                    $FederationAnalyticsRating_grey[] = $model['Rating']['federation_grey'];
                                    $FederationAnalyticsRating_red[] = $model['Rating']['federation_red'];*/

        /* $FederationAnalyticsRating[] = $model['Rating']['federation_green'];
                                    $FederationAnalyticsRating[] = $model['Rating']['federation_yellow'];
                                    $FederationAnalyticsRating[] = $model['Rating']['federation_grey'];
                                    $FederationAnalyticsRating[] = $model['Rating']['federation_red'];*/
        ?>
        <script>
            //Federation Analytics Rating
            var ctx = document.getElementById("federationanalyticsrating");
            var data = {
                labels: ["Minimal Risk", "low Risk", "Moderate Risk", "High Risk"],
                datasets: [{
                        label: "Analytics",
                        backgroundColor: ['#94D789', '#FFDB29', '#afaead', '#fe5d70', '#FF599D'],
                        data: [<?php echo $fed_ana_rating[0]->Minimal_Risk . ',' . $fed_ana_rating[0]->Low_Risk . ',' . $fed_ana_rating[0]->Moderate_Risk . ',' . $fed_ana_rating[0]->High_Risk; ?>]
                    }
                    //, {
                    //label: "Rating",
                    //backgroundColor: ['#94D789', '#FFDB29', '#afaead', '#fe5d70', '#FF599D'],
                    //data: [<?php echo $fed_rate_bars[0]->Minimal_Risk . ',' . $fed_rate_bars[0]->Low_Risk . ',' . $fed_rate_bars[0]->Moderate_Risk . ',' . $fed_rate_bars[0]->High_Risk; ?>]
                    //}
                ]
            };
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 20,
                            bottom: 20
                        }
                    },
                    scales: {
                        yAxes: [{
                            barPercentage: 0.3,
                            ticks: {
                                beginAtZero: true,
                                suggestedMin: 0,
                                suggestedMax: 20,
                                maxTicksLimit: 6,

                                callback: function(value, index, values) {
                                    if (Math.floor(value) === value) {
                                        return value;
                                    }
                                }

                            }
                        }],
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                autoSkip: false,
                                display: false
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            generateLabels: function(chart) {
                                var labels = chart.data.labels;
                                var dataset = chart.data.datasets[0];
                                var legend = labels.map(function(label, index) {
                                    return {
                                        datasetIndex: 0,
                                        fillStyle: dataset.backgroundColor && dataset.backgroundColor[
                                            index],
                                        strokeStyle: dataset.borderColor && dataset.borderColor[index],
                                        lineWidth: dataset.borderWidth,
                                        text: label
                                    }
                                });
                                return legend;
                            }
                        }
                    },
                    animation: {
                        onComplete: function() {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal',
                                Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    for (var key in dataset._meta) {
                                        var model = dataset._meta[key].data[i]._model;
                                        ctx.fillText(dataset.data[i], model.x, model.y + 2);
                                    }
                                }
                            });
                        }
                    }
                }
            });
        </script>


        <script>
            //Family Analytics Rating
            var ctx = document.getElementById("familyanalyticsrating");
            var data = {
                labels: ["Minimal Risk", "low Risk", "Moderate Risk", "High Risk"],
                datasets: [{
                        label: "Analytics",
                        backgroundColor: ['#94D789', '#FFDB29', '#afaead', '#fe5d70', '#FF599D'],
                        data: [<?php echo $family_ana_rating[0]->Minimal_Risk . ',' . $family_ana_rating[0]->Low_Risk . ',' . $family_ana_rating[0]->Moderate_Risk . ',' . $family_ana_rating[0]->High_Risk; ?>]
                    },
                    //{
                    //label: "Rating",
                    //data: [<?php echo $family_rate_bars[0]->Minimal_Risk . ',' . $family_rate_bars[0]->Low_Risk . ',' . $family_rate_bars[0]->Moderate_Risk . ',' . $family_rate_bars[0]->High_Risk; ?>]
                    //}
                ]
            };
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 20,
                            bottom: 20
                        }
                    },
                    scales: {
                        yAxes: [{
                            barPercentage: 0.3,
                            ticks: {
                                beginAtZero: true,
                                suggestedMin: 0,
                                suggestedMax: 20,
                                maxTicksLimit: 6,

                                callback: function(value, index, values) {
                                    if (Math.floor(value) === value) {
                                        return value;
                                    }
                                }

                            }
                        }],
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                autoSkip: false,
                                display: false
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            generateLabels: function(chart) {
                                var labels = chart.data.labels;
                                var dataset = chart.data.datasets[0];
                                var legend = labels.map(function(label, index) {
                                    return {
                                        datasetIndex: 0,
                                        fillStyle: dataset.backgroundColor && dataset.backgroundColor[
                                            index],
                                        strokeStyle: dataset.borderColor && dataset.borderColor[index],
                                        lineWidth: dataset.borderWidth,
                                        text: label
                                    }
                                });
                                return legend;
                            }
                        }
                    },
                    animation: {
                        onComplete: function() {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal',
                                Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    for (var key in dataset._meta) {
                                        var model = dataset._meta[key].data[i]._model;
                                        ctx.fillText(dataset.data[i], model.x, model.y + 2);
                                    }
                                }
                            });
                        }
                    }
                }
            });
            Chart.defaults.global.plugins = {

                labels: {
                    render: () => {}
                }
            };
            Chart.plugins.unregister(ChartDataLabels);
        </script>

    </div>
    <!-- Page-body end -->
</div>
<style>
    .home-table tr td {
        padding: 7px 5px
    }

    .w-box {
        height: 300px;
        width: 100%
    }
</style>
<script type="text/javascript">
    var ctx = $("#pi2");
    var total = "<?php
                    if ($family_pie_total[0]->total_loan == 0) {
                        echo 0;
                    } else {
                        echo round(($family_pie[0]->qualified_loan * 100) / $family_pie_total[0]->total_loan, 2);
                    }
                    ?>";

    var data = {
        labels: ["Qualified"],
        datasets: [{
            backgroundColor: [
                '#2ecc71',
                '#ededed',

            ],
            hoverBackgroundColor: [
                '#2ecc71',
                '#ededed'

            ],
            borderWidth: 1,
            data: ["<?php echo e($family_pie[0]->qualified_loan); ?>",
                "<?php echo e($family_pie_total[0]->total_loan - $family_pie[0]->qualified_loan); ?>"
            ]


        }]
    };

    var options = {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            animateRotate: true,
            duration: 2000,
        },

        legend: false,
        zoomOutPercentage: 15,
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 25,
                bottom: 45
            }
        },
        cutoutPercentage: 70,
        events: [],
        rotation: (-0.5 * Math.PI) - (45 / 180 * Math.PI),

        plugins: {
            doughnutlabel: {
                labels: [{
                    text: total + "%",
                    font: {
                        size: '28'
                    },
                    color: '#505050',
                }]
            },
        },
    };
    var chart2 = new Chart(ctx, {
        type: "doughnut",
        data: data,
        options: options
    });

    var ctx = $("#pi3");
    var total = "<?php
                    if ($family_pie[0]->qualified_loan == 0) {
                        echo 0;
                    } else {
                        echo round((($family_pie_total[0]->total_loan - $family_pie[0]->qualified_loan) * 100) / $family_pie_total[0]->total_loan, 2);
                    }
                    ?>";

    var data = {
        labels: ["Non Qualified"],
        datasets: [{
            backgroundColor: [
                '#3498db',
                '#ededed',

            ],
            hoverBackgroundColor: [
                '#3498db',
                '#ededed'

            ],
            borderWidth: 1,
            data: ["<?php echo e($family_pie_total[0]->total_loan - $family_pie[0]->qualified_loan); ?>",
                "<?php echo e($family_pie[0]->qualified_loan); ?>"
            ]


        }]
    };

    var options = {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            animateRotate: true,
            duration: 2000,
        },

        legend: false,
        zoomOutPercentage: 15,
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 25,
                bottom: 45
            }
        },
        cutoutPercentage: 70,
        events: [],
        rotation: (-0.5 * Math.PI) - (45 / 180 * Math.PI),

        plugins: {
            doughnutlabel: {
                labels: [{
                    text: total + "%",
                    font: {
                        size: '28'
                    },
                    color: '#505050',
                }]
            },
        },
    };
    var chart2 = new Chart(ctx, {
        type: "doughnut",
        data: data,
        options: options
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/home.blade.php ENDPATH**/ ?>