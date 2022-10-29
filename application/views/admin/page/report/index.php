<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Reports</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="form-group col-12 col-sm-2">
							<label for="chapter_list">School</label>
							<select class="form-control select2" required name="school_id" id="school_id">
                                <option>Select School</option>
                                <?php
                                if(!empty($school)){
                                    foreach($school as $s){
                                    ?>
                                    <option value="<?php echo $s['school_id'];?>"><?php echo $s['school_name'];?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>
						</div>
						<!-- <div class="form-group col-12 col-sm-2">
							<label for="chapter_list">Topics</label>
							<select class="form-control select2" required name="subtopic_id" id="subtopic_id">
                                <option>Select Subtopic</option>
                                <?php
                                if(!empty($subtopic)){
                                    foreach($subtopic as $s){
                                    ?>
                                    <option value="<?php echo $s['stp_id'];?>"><?php echo $s['subtopic_text'];?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>
						</div> -->
						<div class="form-group col-12 col-sm-1 mt-4">
							<button class="btn btn-primary" id="school_filter">Submit</button>
						</div>
					</div>
					<!-- <div class="table-responsive" id="table">

					</div> -->
				</div>
				<div class="card-body">
					<div class="table-responsive" id="usertable">
						<!-- <button data--toggle="delete_selected" data--url="<?= base_url('backend/subtopic/removeSelected'); ?>" class="btn btn-danger btn-small mb-2" >Delete Selected Record(s)</button> -->

						<table class="table table-striped table-hover" id="table-1" style="width: 100%;">
							<thead>
							<tr>
								<th>School Logo</th>
								<th>Name</th>
								<th>School Code</th>
								<th>Free Licence</th>
								<th>Paid Licence</th>
								<th>Total Registred Students</th>
								<th>Total Registred Teacher</th>
								<th>Total Free Students</th>
								<th>Total Paid Students</th>
								<th>Total Free Teachers</th>
								<th>Total Paid Teachers</th>
								<th>Phone no.</th>
								<th>City</th>
								<th>State</th>
								<th>Zipcode</th>
								<th>Branch Code</th>
								<th>AppLink</th>
								<th>PaymentLink</th>
								<th>Acdemic expirey date</th>
								<th>Student Plans</th>
								<th>Teacher Plans</th>
								<th>Language</th>
								<th>Board</th>
								<th>Standard</th>
							</tr>
							</thead>
							<tbody id="table" class="sortable" data--url="<?=base_url('backend/re-ordering/subtopics/stp_id');?>">
							<?php
							if(!empty($school)){
								foreach($school as $r) { ?>
									<tr>
										<td><img src="<?=base_url($r['school_logo']);?>" alt="" style="width:50px;"></td>
										<td><?=$r['school_name'];?></td>
										<td><?php echo $r['school_code'];?></td>
										<td><?php echo $r['free_students'];?></td>
										<td><?=$r['no_licence'];?></td>
										<td><?=$r['registerd_students'];?></td>
										<td><?php echo $r['registerd_teachers'];?></td>
										<td><?php echo $r['total_free_students']?></td>
										<td><?php echo $r['total_paid_students']?></td>
										<td><?php echo $r['total_free_teachers']?></td>
										<td><?php echo $r['total_paid_teachers']?></td>
										<td><?php echo $r['school_phoneno'];?></td>
										<td><?php echo $r['school_city'];?></td>
										<td><?php echo $r['school_state'];?></td>
										<td><?php echo $r['school_zipcode'];?></td>
										<td><?php echo $r['branch_code'];?></td>
										<td><?php echo $r['applink'];?></td>
										<td><?php echo $r['paymentlink'];?></td>
										<td><?php echo $r['expiry_date'];?></td>
										<td><?php echo $r['student_plan'];?></td>
										<td><?php echo $r['teacher_plan'];?></td>
										<td><?php echo $r['name'];?></td>
										<td><?php echo $r['bd_name'];?></td>
										<td><?php echo $r['std_name'];?></td>
										
									</tr>
								<?php }
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
