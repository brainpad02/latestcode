<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Create School</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/school');?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
					</div>
				</div>
				<div class="card-body">
					<?=form_open_multipart($action,array('class' => 'layout-form', 'id' => 'layout-form'));?>
						<div class="row">

                            <div class="col-12 col-sm-4">
                                <label>School Logo<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="file" class="form-control" name="file" id="file"  accept="'image/*">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>School Name<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="school_name" id="school_name" required placeholder="Enter School Name">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>School Description<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <textarea name="school_description" id="school_description" cols="30" rows="10" class="form-control">Add Description here..</textarea>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>School Phone No<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="school_phone" id="school_phone" required placeholder="Enter School Phone No">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>School Address<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="school_address" id="school_address" required placeholder="Enter School Address">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>School City<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="school_city" id="school_city" required placeholder="Enter School City">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>School State<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="school_state" id="school_state" required placeholder="Enter School State">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>School Country<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="school_country" id="school_country" required placeholder="Enter School Country">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>School Zipcode<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="school_zipcode" id="school_zipcode" required placeholder="Enter School Zipcode">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>School App Link<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="school_applink" id="school_applink" placeholder="Enter School App Link">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>School Payment Link<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="school_paymentlink" id="school_paymentlink" placeholder="Enter School Payment Link">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>No of free students<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="free_students" id="free_students" placeholder="Enter Free Students Number">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>No of Licence<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="no_licence" id="no_licence" placeholder="Enter No Of Licence">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>Expiry Date<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="date" class="form-control" name="expiry_date" id="expiry_date" placeholder="Enter Expiry Date">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>Language<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <select class="form-control select2" name="language" id="language_id" onchange="getBoard(this.value)" required>
                                        <?php foreach($this->crud_model->get_table_data('languages') as $lang) : ?>
                                            <option value="<?= $lang['symbol']; ?>"><?= $lang['name'] ;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>Board<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <select class="form-control select2" name="board" id="board_list" onchange="getStandard(this.value)" required></select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>Standard<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <select class="form-control select2" required name="std_id" id="std_list"></select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>Branch Code<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="branch_code" id="branch_code" placeholder="Enter Branch Code">
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>Student's Subscription Plan<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <select class="form-control select2" required name="student_plans[]" id="student_plans" required multiple>
                                        <option>Select Plan</option>
                                        <?php 
                                        if(!empty($studentplan)){
                                            foreach($studentplan as $p){
                                            ?>
                                            <option value="<?php echo $p->plan_id;?>"><?php echo $p->plan_name;?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>Teacher's Subscription Plan<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <select class="form-control select2" required name="teacher_plans[]" id="teacher_plans" required multiple>
                                        <option>Select Plan</option>
                                        <?php 
                                        if(!empty($teacherplan)){
                                            foreach($teacherplan as $p){
                                            ?>
                                            <option value="<?php echo $p->plan_id;?>"><?php echo $p->plan_name;?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>Google Package Token<span class="text-danger"></span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="package_token" id="package_token" placeholder="Enter Package Token">
                                </div>
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
