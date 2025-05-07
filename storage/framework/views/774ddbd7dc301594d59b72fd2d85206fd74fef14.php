<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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
                        <li class="breadcrumb-item">Add Family</li>
                    </ul>
                </div>
                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Add Family</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->

    <!-- Page-body start -->
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-block">
                        <div class="mT-30">
                            <div class="row">
                                <div class="col-md-5 mb-3" id="table" style="margin-top: -6px;">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap" style="width: 100%;font-size:14px;">
                                        <thead>
                                            <tr>
                                                <th width="5%">S.No</th>
                                                <th width="30%">SHG Member Name</th>
                                                <th width="30%">UIN</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-5 mb-3" id="table1" style="margin-top: -6px;">
                                    <table id="simpletable1" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">S.No</th>
                                                <th width="30%">SHG Member Name</th>
                                                <th width="30%">UIN</th>

                                            </tr>
                                        </thead>

                                        <tbody style="font-size:14px;">
                                        </tbody>
                                    </table>
                                </div>


                                <div class="col-md-7 mb-3">
                                    <fieldset>
                                        <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <form class="" method="POST" action="<?php echo e(route('family.store')); ?>" autocomplete="off">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="validationCustom02">Agency<span class="red">*</span></label>
                                                    <select class="form-control " name="agency_id" id="agency_id" required>
                                                        <option value="">--Select--</option>
                                                        <?php $__currentLoopData = $agency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($row->agency_id); ?>">
                                                            <?php echo e($row->agency_name); ?>

                                                        </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="validationCustom02">Country<span class="red">*</span></label>
                                                    <select class="form-control " name="country" id="country" required>
                                                        <option value="">--Select--</option>

                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="validationCustom02">State<span class="red">*</span></label>
                                                    <select class="form-control " name="state" id="state" required>
                                                        <option value="">--Select--</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="validationCustom02">District</label>
                                                    <select class="form-control " name="district" id="district" required>
                                                        <option value="">--Select--</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="validationCustom02">Federation<span class="red">*</span></label>
                                                    <select class="form-control " name="federation_id" id="federation_id" required>
                                                        <option value="">--Select--</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="validationCustom02">Cluster</label>
                                                    <select class="form-control " name="cluster_uin" id="cluster_uin">
                                                        <option value="">--Select--</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="validationCustom02">SHG<span class="red">*</span></label>
                                                    <select class="form-control " name="shg_uin" id="shg_uin" required>
                                                        <option value="">--Select--</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    
                                                    <a class="btn btn-sm btn-success mt-4" id="search" style="color:white;" value="search">Search</a>
                                                    <a href="<?php echo e(url('family/create')); ?>" class="btn btn-sm btn-danger mt-4">Back</a>
                                                </div>
                                            </div>
                                            <table id="family_table" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th width="20%">SHG Name</th>
                                                        <th width="20%">SHG Member Name</th>
                                                        <th width="20%">Spouse Name</th>
                                                        <th width="20%">Mobile</th>
                                                        <th width="20%">Village Name</th>
                                                        <th width="20%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select class="form-control shg_uin2" name="shg_uin2[]" required>
                                                                <option value="">--Select--</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="text" class="form-control fp_member_name " name="fp_member_name[]" style="min-width: 20%;" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control fp_spouse_name" name="fp_spouse_name[]" style="min-width: 20%;" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control fp_contact_no" name="fp_contact_no[]" style="min-width: 20%;" title="please enter mobile number"  required>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control fp_village" name="fp_village[]" style="min-width: 20%;" readonly required>
                                                        </td>


                                                        <td>
                                                            <button class="btn btn-sm cur-p btn-primary add_faci" type="button" onclick="add_location(this);"><i class="c-white-500 ti-plus"></i></button>
                                                            <button class="btn btn-sm cur-p btn-danger" type="button" onclick="delete_location(this);"><i class="c-white-500 ti-minus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                            <div class="row" id="family_table_b">
                                                <div class="col-md-12 mb-3 text-center">
                                                    <button class="btn btn-sm btn-success mt-4" type="submit" id="save">Save</button>
                                                    <a href="<?php echo e(url('family')); ?>" class="btn btn-sm btn-danger mt-4">Back</a>
                                                </div>
                                            </div>

                                        </form>
                                    </fieldset>
                                </div>

                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page-body end -->
</div>
<script src="<?php echo e(asset('bower_components\datatables.net\js\jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-buttons\js\dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets\pages\data-table\js\jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets\pages\data-table\js\pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets\pages\data-table\js\vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-buttons\js\buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-buttons\js\buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-responsive\js\dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js')); ?>"></script>
<script>
       $(function() {
            $("form").submit(function(e) {
                $('#save').prop('disabled', true);
                $('#save').css('opacity', '0.4');
                return true;
            });
        });
    var Table = null;
    $(function() {
        var table = $('#simpletable').DataTable({
            "processing": true,
            "serverSide": true, //Feature control DataTables' servermside processing mode.
            "bFilter": false,
            "bLengthChange": false,
            "ordering": false,
            "iDisplayLength": 10,
            "responsive": false,
            "ajax": {
                "url": '/family_table',
                "type": "GET",
                "dataType": "json",
                "data": function(data) {
                    // manipulate data used in ajax request prior to server call
                    delete data.columns;
                },
                "dataSrc": function(jsonData) {
                    return jsonData.data;
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }, ],

        });
        Table = $("#simpletable1").DataTable({
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bLengthChange": false,
            "iDisplayLength": 10,
            data: [],
            rowCallback: function(row, data) {},
            columns: [{
                    "data": "sn"
                },
                {
                    "data": "family_name"
                },
                {
                    "data": "uin"
                },

            ],
            filter: false,
            info: false,
            ordering: false,
            processing: true,
            retrieve: true
        });
    });

    $(document).ready(function() {
        $('#table1').hide();
        $('#family_table').hide();
        $('#family_table_b').hide();
        $('#agency_id').on('change', get_agency_demography);
        $('#agency_id').on('change', get_federation_list);
        $('#federation_id').on('change', get_cluster_list, );
        $('#cluster_uin').on('change', get_shg_list);
        $('#federation_id').on('change', get_shg_list2);
        $('.shg_uin2').on('change', get_shg_village);

        // $('#federation_id').on('change', get_federation_demography);
        $('#country,#state').attr("readonly", "readonly");
        $("#country,#state").css("pointer-events", "none");
        $('#search').on('click', function() {
            $('#table').hide();
            $('#table1').show();


            var agency_id = $('#agency_id').val();
            var country = $('#country').val();
            var state = $('#state').val();
            var district = $('#district').val();
            var federation_id = $('#federation_id').val();
            var cluster_id = $('#cluster_uin').val();
            var shg_id = $('#shg_uin').val();


            $.ajax({

                url: '/family_table_two',
                type: 'GET',
                data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id + '&country=' +
                    country +
                    '&state=' + state +
                    '&district=' + district + '&federation_id=' + federation_id +
                    '&cluster_id=' + cluster_id +
                    '&shg_id=' + shg_id,

                //data:'_token = <?php echo csrf_token(); ?>&id=' + id ,\

                success: function(response) {
                    console.log(response);
                    if (response != '') {
                        var result = JSON.parse(response);
                        //$('#simpletable1').html(response);
                        Table.clear().draw();
                        Table.rows.add(result).draw();

                    }

                    // // location.reload();

                }
            });


        });

    });
    $('#search').on('click', function() {
        var shg = $('#shg_uin').val();
        if (shg != '') {
            $('#family_table').show();
            $('#family_table_b').show();
            $('#agency_id,#federation_id,#district,#cluster_uin').attr("readonly", "readonly");
            $("#agency_id,#federation_id,#district,#cluster_uin").css("pointer-events", "none");
        }

    });


    function get_federation_list() {
        var obj = $(this);
        var agency_id = obj.val();
        if (agency_id > 0) {
            $.ajax({
                type: 'GET',
                url: '/get_federation_list',
                data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
                success: function(data) {
                    if (data != '') {
                        $('#federation_id').html(data);
                        $('#federation_id').trigger("change");
                    }
                }
            });
        }
    }

    function get_cluster_list() {
        var obj = $(this);
        var federation_id = obj.val();
        if (federation_id != '') {
            $.ajax({
                type: 'GET',
                url: '/get_cluster_list',
                data: '_token = <?php echo csrf_token(); ?>&federation_id=' + federation_id,
                success: function(data) {
                    if (data != '') {
                        $('#cluster_uin').html(data);
                        $('#cluster_uin').trigger("change");
                    }
                }
            });
        }
    }

    function get_shg_list() {
        var obj = $(this);
        var cluster_id = obj.val();
        if (cluster_id != '') {
            $.ajax({
                type: 'GET',
                url: '/get_shg_list',
                data: '_token = <?php echo csrf_token(); ?>&cluster_id=' + cluster_id,
                success: function(data) {
                    if (data != '') {
                        $('#shg_uin').html(data);
                        $('.shg_uin2').html(data);
                        $('#shg_uin').trigger("change");
                    }
                }
            });
        }
    }

    function get_shg_list2() {
        var obj = $(this);
        var federation_id = obj.val();
        if (federation_id != '') {
            $.ajax({
                type: 'GET',
                url: '/get_shg_list2',
                data: '_token = <?php echo csrf_token(); ?>&federation_id=' + federation_id,
                success: function(data) {
                    if (data != '') {
                        $('#shg_uin').html(data);
                        $('.shg_uin2').html(data);
                        $('#shg_uin').trigger("change");
                    }
                }
            });
        }
    }

    function get_agency_demography() {
        var obj = $(this);
        var agency_id = obj.val();
        //alert(agency_id);
        if (agency_id != '') {
            $.ajax({
                type: 'GET',
                url: '/get_agency_demography',
                data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
                success: function(data) {
                    if (data != '') {
                        $('#country').html(data.country_option);
                        $('#state').html(data.state_option);
                        $('#district').html(data.district_option);
                    }
                }
            });
        }
    }
    var location_counter = 1;

    function add_location(elem) {

        var cloned = $(elem).parents('tbody').clone();
        var len = $(".add_faci").length;
        var shg = $('.shg_uin2').val();
        // alert(len);
        $(cloned).find('.shg_uin2').attr('name', 'shg_uin2[]').val(shg);
        $(cloned).find('.fp_member_name').attr('name', 'fp_member_name[]').val('');
        $(cloned).find('.fp_spouse_name').attr('name', 'fp_spouse_name[]').val('');
        $(cloned).find('.fp_village').attr('name', 'fp_village[]').val('');
        $(cloned).find('.fp_contact_no').attr('name', 'fp_contact_no[]').val('');
        $(cloned).find('.select2-container').remove();
        $(cloned).appendTo('#family_table');

        $('.shg_uin2').on('change', get_shg_village);
        $('.shg_uin2').trigger('change');
        location_counter++;
        // $('.group').trigger('change');
    }

    function delete_location(elem) {
        if ($('#family_table tbody tr').length > 1)
            $(elem).parents('tr').remove();
    }

    function get_shg_village() {
        var index = $(this).index('.shg_uin2');
        var shg_uin = $('.shg_uin2').eq(index).val();



        if (shg_uin != '') {
            $.ajax({
                type: 'GET',
                url: '/get_shg_village',
                data: '_token = <?php echo csrf_token(); ?>&shg_uin=' + shg_uin,
                success: function(data) {
                    if (data != '') {

                        $('.fp_village').eq(index).val(data);

                    }
                }
            });
        }
    }

    // $('body').on('focusout', '.fp_member_name', function(e) {
    //     var inputValue = $(this).val();
    //     var index1 = $(this).index('.fp_member_name');
    //     var obj = $(this);
    //     var fp_member_name = obj.val();
    //     var flg = 0;

    //     $('.fp_member_name').each(function(index) {
    //         if ($(this).val() == fp_member_name && (index != index1)) {
    //             flg = 1;
    //             return false;
    //         }
    //     });
    //     if (flg == 1) {
    //         bootbox.alert('<h3>Duplicate Entry</h3>');

    //         obj.val('');
    //     } else {

    //         $.ajax({
    //             type: 'GET',
    //             url: '/check_family_member',
    //             data: '_token = <?php echo csrf_token(); ?>&inputValue=' + inputValue,
    //             success: function(data) {
    //                 if (data != '') {
    //                     if (data == 1) {
    //                         alert("Family is already Exist");
    //                         $('.fp_member_name').eq(index1).val('');

    //                     }

    //                 }
    //             }
    //         });
    //     }

    // });

    $('body').on('focusout', '.fp_contact_no', function(e) {



        var inputValue = $(this).val();
        var index1 = $(this).index('.fp_contact_no');
        var shg = $('.shg_uin2').eq(index1).val();
        // var member_name = $('.fp_contact_no').eq(index1).val();


        var obj = $(this);
        var fp_contact_no = obj.val();
        var flg = 0;

        $('.fp_contact_no').each(function(index) {
            if ($(this).val() == fp_contact_no && (index != index1)) {
                flg = 1;
                return false;
            }
        });
        if (flg == 1) {
            bootbox.alert('<h3>Duplicate Mobile Entry</h3>');

            obj.val('');
        } else {

            $.ajax({
                type: 'GET',
                url: '/check_family_spouse',
                data: '_token = <?php echo csrf_token(); ?>&inputValue=' + inputValue + '&shg=' + shg ,
                success: function(data) {
                    if (data != '') {
                        if (data == 1) {
                            alert("Family is already Exist,");
                            $('.fp_contact_no').eq(index1).val('');
                            // $('.fp_member_name').eq(index1).val('');

                        }

                    }
                }
            });
        }

    });
</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/family/add.blade.php ENDPATH**/ ?>