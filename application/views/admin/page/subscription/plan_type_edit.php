<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Edit Plan Type</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/plan_type');?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Back</a>
					</div>
				</div>
				<div class="card-body">
					<?=form_open_multipart($action,array('class' => 'plan_type-form', 'id' => 'plan_type-form'));?>
					<div class="row">
							<div class="col-12 col-sm-4">
								<label>User Type<span class="text-danger">*</span></label>
								<div class="form-group">
                                    <select class="form-control select2" required name="user_type" id="user_type" required>
                                        <option value="">Select User Type</option>
                                        <option value="Teacher" <?php if($editData->user_type == 'Teacher'){ echo "selected"; } ?>>Teacher</option>
                                        <option value="Student" <?php if($editData->user_type == 'Student'){ echo "selected"; } ?>>Student</option>
                                    </select>
								</div>
							</div>

                            <div class="col-12 col-sm-4">
								<label>Plan Type Name</label>
								<div class="form-group">
									<input type="text" class="form-control" name="plan_type_name" id="plan_type_name" required placeholder="Enter Plan Type Name" value="<?= $editData->type_name;?>">
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<label>Is Free Plan</label>
								<div class="form-group">
									<input type="checkbox" name="is_free" id="is_free" <?php if($editData->is_free_plan == 1){echo "checked"; }?>>
								</div>
							</div>

					    <div class="subtopic_field"></div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="btn">
                            </div>
                        </div>
                        <?=form_close();?>
				</div>
			</div>
		</div>
	</div>
</section>
