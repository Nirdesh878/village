

<?php $__env->startSection('content'); ?>
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
                            <li class="breadcrumb-item">Add Partner</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Add Partner</h4>
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
                                <form class="container" method="POST" action="<?php echo e(route('partner.store')); ?>"
                                    autocomplete="off">
                                    <?php echo csrf_field(); ?>
                                    <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Partner Name<span
                                                    class="red">*</span></label>
                                            <input type="text" class="form-control" name="partners_name"
                                                value="<?php echo e(old('partners_name')); ?>" autocomplete="off"  required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">

                                        </div>
                                        <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Country<span class="red">*</span></label>
                                        <select class="form-control country" name="country" id="country" required>
                                            <option value="">--Select--</option>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($row->id); ?>" <?php if(old('country') == $row->id): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($row->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Contact Person<span
                                                    class="red">*</span></label>
                                            <input type="text" class="form-control" name="contact_person"
                                                value="<?php echo e(old('contact_person')); ?>" autocomplete="off" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />

                                        </div>
                                        <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Address<span class="red">*</span></label>
                                        <input type="text" class="form-control" name="address"
                                                value="<?php echo e(old('address')); ?>" autocomplete="off" required>
                                        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Email<span
                                                    class="red">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                value="<?php echo e(old('email')); ?>" autocomplete="off" required>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">Phone Number<span class="red">*</span></label>
                                        <input type="text" class="form-control number" name="contact_number"
                                                value="<?php echo e(old('contact_number')); ?>" autocomplete="off" required>
                                        
                                        </div>
                                    </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3 text-center">
                                    <button class="btn btn-sm btn-success" type="submit">Save</button>
                                    <a href="<?php echo e(url('partner')); ?>" class="btn btn-sm btn-danger">Back</a>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-body end -->
    </div>
    <script>
       (function($) {
        $.fn.inputFilter = function(inputFilter) {
          return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
            if (inputFilter(this.value)) {
              this.oldValue = this.value;
              this.oldSelectionStart = this.selectionStart;
              this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
              this.value = this.oldValue;
              this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            }
          });
        };
      }(jQuery));
     $(".number").inputFilter(function(value) {
         return /^-?\d*[.,]?\d{0,2}$/.test(value) && (value === "" || parseInt(value) <= 999999999999); });
    </script>
    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/partner/add.blade.php ENDPATH**/ ?>