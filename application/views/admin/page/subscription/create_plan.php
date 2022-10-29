<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Create Subscription Plan</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/subscription_plans');?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
					</div>
				</div>
				<div class="card-body">
					<?=form_open_multipart($action,array('class' => 'subplan-form', 'id' => 'subplan-form'));?>
						<div class="row">
							<div class="col-12 col-sm-4">
								<label>User Type<span class="text-danger">*</span></label>
								<div class="form-group">
                                    <select class="form-control select2" required name="user_type" id="user_type" required onchange="get_plan_type(this.value);">
                                        <option value="">Select User Type</option>
                                        <option value="Teacher">Teacher</option>
                                        <option value="Student">Student</option>
                                    </select>
								</div>
							</div>

                            <div class="col-12 col-sm-4">
								<label>Plan Type<span class="text-danger">*</span></label>
								<div class="form-group">
                                    <select class="form-control select2" required name="plan_type" onchange="plan_select(this.value);" required>
                                        <option value="">Select Plan Type</option>
										<option value="Free">Free</option>
										<option value="Paid">Paid</option>
                                    </select>
									<!-- <input type="text" name="plan_type" class="form-control" required placeholder="Enter Plan Type"> -->
								</div>
							</div>

							<!-- <div class="col-12 col-sm-4">
								<label>School<span class="text-danger">*</span></label>
								<div class="form-group">
                                    <select class="form-control select2" required name="school_id" id="school_id" required>
                                        <option value="">Select School</option>
										<?php
											if(!empty($schools)){
												foreach($schools as $s){
												?>
												<option value="<?= $s['school_id']?>"><?= $s['school_name'].' - '.$s['school_code'];?></option>
												<?php
												}
											}
										?>
                                    </select>
								</div>
							</div> -->

							<!-- <div class="col-12 col-sm-4">
								<label>Language<span class="text-danger">*</span></label>
								<div class="form-group">
                                    <select class="form-control select2" required name="language_id" id="language_id" required>
                                        <option value="">Select Language</option>
										<?php
											if(!empty($languages)){
												foreach($languages as $l){
												?>
												<option value="<?= $l['id']?>"><?= $l['name'];?></option>
												<?php
												}
											}
										?>
                                    </select>
								</div>
							</div> -->

							<div class="col-12 col-sm-4">
								<label>Plan Name<span class="text-danger">*</span></label>
								<div class="form-group">
									<input type="text" class="form-control" name="plan_name" id="plan_name" required placeholder="Enter Plan Name">
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<label>Plan Description<span class="text-danger">*</span></label>
								<div class="form-group">
									<textarea name="plan_desc" id="plan_desc" cols="30" rows="10" class="form-control" placeholder="Add Description here.."></textarea>
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<label>Plan Price</label>
								<div class="form-group">
									<input type="number" class="form-control" name="plan_price" id="plan_price" required placeholder="Enter Plan Price">
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<label>Plan Start Date<span class="text-danger">*</span></label>
								<div class="form-group">
									<input type="date" class="form-control" name="start_date" id="start_date" >
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<label>Plan End Date<span class="text-danger">*</span></label>
								<div class="form-group">
									<input type="date" class="form-control" name="end_date" id="end_date" >
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<label>Plan Suspend Time</label>
								<div class="form-group">
									<input type="text" class="form-control" name="resume_time" id="resume_time"  placeholder="Example : 20 min OR 2 Days OR 1 Hour">
								</div>
							</div>

                            <div class="col-12 col-sm-4">
								<label>Plan Notes</label>
								<div class="form-group">
                                <textarea name="plan_notes" id="plan_notes" cols="30" rows="10" class="form-control" placeholder="Add Notes Here.."></textarea>
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<label>Access No Of Topics<span class="text-danger">*</span></label>
								<div class="form-group">
									<input type="number" class="form-control" name="no_topics" id="no_topics"  placeholder="Ex: 3 OR 1 OR 2">
								</div>
							</div>

							<!-- <div class="col-12 col-sm-4">
								<label>Is Default Free Plan</label>
								<div class="form-group">
									<input type="checkbox" name="is_free_plan" id="is_free_plan">
								</div>
							</div> -->
							

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
