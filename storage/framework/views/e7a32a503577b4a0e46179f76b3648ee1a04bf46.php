 <?php $__env->startSection('content'); ?>

<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.Add Vendor')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['route' => 'vendor.store', 'method' => 'post', 'files' => true]); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.UserName')); ?> *</strong> </label>
                                        <input type="text" name="name" required class="form-control">
                                        <?php if($errors->has('name')): ?>
                                       <span>
                                           <strong><?php echo e($errors->first('name')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Image')); ?> </strong> </label>
                                        <input type="file" name="image"  class="form-control">
                                        <?php if($errors->has('name')): ?>
                                       <span>
                                           <strong><?php echo e($errors->first('name')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Phone Number')); ?> *</strong></label>
                                        <input type="text" name="phone_number" required class="form-control">
                                        <?php if($errors->has('phone_number')): ?>
                                            <span>
                                               <strong><?php echo e($errors->first('phone_number')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Address')); ?> *</strong></label>
                                        <input type="text" name="address" required class="form-control customer-input">
                                    </div>
                                    <div class="form-group">
                                        <input class="mt-2" type="checkbox" name="is_active">
                                        <label class="mt-2"><strong><?php echo e(trans('file.Active')); ?></strong></label>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Add Admin *</strong></label>
                                        <button class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal">+</button>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Start Time')); ?> *</strong></label>
                                        <input type="time" name="start_time" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.End Time')); ?> *</strong></label>
                                        <input type="time" name="end_time" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Off Day')); ?> *</strong></label>
                                        <select name="offday" required class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Day...">
                                                <option value="Saturday">Saturday</option>
                                                <option value="Sunday">Sunday</option>
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="wednesday">wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>

                                          </select>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Facebook')); ?> </strong></label>
                                        <input type="url" name="social[]" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Instagram')); ?> </strong></label>
                                        <input type="url" name="social[]" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Twitter')); ?> </strong></label>
                                        <input type="url" name="social[]" class="form-control">
                                    </div>
                                   
                                </div>                              
                            </div>
                            <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
</section>

<script type="text/javascript">

    $("ul#people").siblings('a').attr('aria-expanded','true');
    $("ul#people").addClass("show");
    $("ul#people #user-create-menu").addClass("active");


    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });
    
    $('#genbutton').on("click", function(){
      $.get('genpass', function(data){
        $("input[name='password']").val(data);
      });
    });

    $('select[name="role_id"]').on('change', function() {
        if($(this).val() == 5) {
            $('#biller-id').hide(300);
            $('#warehouseId').hide(300);
            $('.customer-section').show(300);
            $('.customer-input').prop('required',true);
            $('select[name="warehouse_id"]').prop('required',false);
            $('select[name="biller_id"]').prop('required',false);
        }
        else if($(this).val() > 2 && $(this).val() != 5) {
            $('select[name="warehouse_id"]').prop('required',true);
            $('select[name="biller_id"]').prop('required',true);
            $('#biller-id').show(300);
            $('#warehouseId').show(300);
            $('.customer-section').hide(300);
            $('.customer-input').prop('required',false);
        }
        else {
            $('select[name="warehouse_id"]').prop('required',false);
            $('select[name="biller_id"]').prop('required',false);
            $('#biller-id').hide(300);
            $('#warehouseId').hide(300);
            $('.customer-section').hide(300);
            $('.customer-input').prop('required',false);
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\YRmarket\V8\resources\views/vendor/create.blade.php ENDPATH**/ ?>