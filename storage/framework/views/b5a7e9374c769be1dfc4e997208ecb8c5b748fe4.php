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
                        <h4><?php echo e(trans('file.Update Vendor')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['route' => ['vendors.update', $lims_vendor_data->id], 'method' => 'put', 'files' => true]); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.UserName')); ?> *</strong> </label>
                                        <input type="text" name="name" required class="form-control" value="<?php echo e($lims_vendor_data->name); ?>">
                                        <?php if($errors->has('name')): ?>
                                       <span>
                                           <strong><?php echo e($errors->first('name')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Image')); ?></strong> </label>
                                        <div class="input-group">
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Phone Number')); ?> *</strong></label>
                                        <input type="text" name="phone_number" required maxlength="11" class="form-control" value="<?php echo e($lims_vendor_data->phone); ?>">
                                        <?php if($errors->has('phone_number')): ?>
                                            <span>
                                               <strong><?php echo e($errors->first('phone_number')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Address')); ?> *</strong></label>
                                        <input type="text" name="address"  required class="form-control customer-input" value="<?php echo e($lims_vendor_data->address); ?>">
                                    </div>
                                    <div class="form-group">
                                        <?php if($lims_vendor_data->is_active): ?>
                                        <input class="mt-2" type="checkbox" name="is_active" value="1" checked>
                                        <?php else: ?>
                                        <input class="mt-2" type="checkbox" name="is_active" value="1">
                                        <?php endif; ?>
                                        <label class="mt-2"><strong><?php echo e(trans('file.Active')); ?></strong></label>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Start Time')); ?> *</strong></label>
                                            <input type="time" name="start_time" required class="form-control" value="<?php echo e($lims_vendor_data->start_time); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.End Time')); ?> *</strong></label>
                                            <input type="time" name="end_time" required class="form-control" value="<?php echo e($lims_vendor_data->end_time); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Off Day')); ?> *</strong></label>
                                            <input type="hidden" name="off_day_hidden" value="<?php echo e($lims_vendor_data->off_day); ?>">
                                            <select name="off_day" class="selectpicker form-control customer-input" required data-live-search="true" data-live-search-style="begins" title="Select Day Off...">
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                    <option value="Monday">Monday</option>
                                                    <option value="Tuesday">Tuesday</option>
                                                    <option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                            </select>                                    
                                        </div>
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Facebook')); ?></strong></label>
                                            <input type="url" name="social_list[]" class="form-control" value="<?php echo e($lims_vendor_data->social_list[0]); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Instgram')); ?></strong></label>
                                            <input type="url" name="social_list[]" class="form-control" value="<?php echo e($lims_vendor_data->social_list[1]); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Twitter')); ?></strong></label>
                                            <input type="url" name="social_list[]" class="form-control" value="<?php echo e($lims_vendor_data->social_list[2]); ?>">
                                    </div>
                                </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.Add Admin')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.UserName')); ?> *</strong> </label>
                                        <input type="text" name="admin_name" required class="form-control" value="<?php echo e($lims_user_data->name); ?>">
                                        <?php if($errors->has('name')): ?>
                                       <span>
                                           <strong><?php echo e($errors->first('name')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Change Password')); ?></strong> </label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control">
                                            <div class="input-group-append">
                                                <button id="genbutton" type="button" class="btn btn-default"><?php echo e(trans('file.Generate')); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label><strong><?php echo e(trans('file.Email')); ?></strong></label>
                                        <input type="email" name="email" placeholder="example@example.com"  class="form-control" value="<?php echo e($lims_user_data->email); ?>">
                                        <?php if($errors->has('email')): ?>
                                       <span>
                                           <strong><?php echo e($errors->first('email')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <?php if($lims_user_data->is_active): ?>
                                        <input class="mt-2" type="checkbox" name="admin_is_active" value="1" checked>
                                        <?php else: ?>
                                        <input class="mt-2" type="checkbox" name="admin_is_active" value="1">
                                        <?php endif; ?>
                                        <label class="mt-2"><strong><?php echo e(trans('file.Active')); ?></strong></label>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label><strong><?php echo e(trans('file.Phone Number')); ?> *</strong></label>
                                        <input type="text" name="admin_phone_number" required class="form-control" value="<?php echo e($lims_user_data->phone); ?>">
                                    </div>
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Company Name')); ?></strong></label>
                                            <input type="text" name="company_name" class="form-control" value="<?php echo e($lims_user_data->company_name); ?>">
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
    $('#biller-id').hide();
    $('#warehouseId').hide();
    
    var off_day = $("input[name='off_day_hidden']").val();
    $('select[name=off_day]').val(off_day);

    $('select[name=role_id]').val($("input[name='role_id_hidden']").val());
    if($('select[name=role_id]').val() > 2){
        $('#warehouseId').show();
        $('select[name=warehouse_id]').val($("input[name='warehouse_id_hidden']").val());
        $('#biller-id').show();
        $('select[name=biller_id]').val($("input[name='biller_id_hidden']").val());
    }
    $('.selectpicker').selectpicker('refresh');

    $('select[name="role_id"]').on('change', function() {
        if($(this).val() > 2){
            $('select[name="warehouse_id"]').prop('required',true);
            $('select[name="biller_id"]').prop('required',true);
            $('#biller-id').show();
            $('#warehouseId').show();
        }
        else{
            $('select[name="warehouse_id"]').prop('required',false);
            $('select[name="biller_id"]').prop('required',false);
            $('#biller-id').hide();
            $('#warehouseId').hide();
        }
    });

    $('#genbutton').on("click", function(){
      $.get('../genpass', function(data){
        $("input[name='password']").val(data);
      });
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admins.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\YRmarket\V8\resources\views/admins/vendor/edit.blade.php ENDPATH**/ ?>