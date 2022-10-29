<section class="section">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4>Users Table</h4>
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
							<div class="form-group col-12 col-sm-1 mt-4">
								<button class="btn btn-primary" id="school_user_filter">Submit</button>
							</div>
						</div>
						
						<a href="<?=base_url('admin/user/export_user');?>" class="btn btn-success" style="margin-bottom:20px"><i class="fa fa-export"></i> Export Data</a>
						<div class="table-responsive" id="usertable">
							<table class="table table-striped table-hover" id="save-stage" style="width:100%;">
								<thead>
								<tr>
									<th>UserId</th>
									<th>SchoolId</th>
            						<th>UserCode</th>
									<th>Total App Usage</th>
									<th>Username</th>
									<th>Subscription Type</th>
									<th>Subscription Plan</th>
									<th>Registerd Date</th>
									<th>Lic Exp Date</th>
									<th>Phone no.</th>
									<th>Email</th>
									
									<th>Status</th>
									<!-- <th>Action</th> -->
								</tr>
								</thead>
								<tbody id="table">
								<?php foreach($rec as $r) {
									$time = $r['time']/60;
									?>
									<tr>
										<td><?= $r['user_id'];?></td>
										<td><?php echo $r['school_id']?></td>
                						<td><?php echo $r['usercode'];?></td>
										<td><?php echo $time;?></td>
										<td><?=$r['username'];?></td>
										<td><?php echo $r['type_name'];?></td>
										<td><?php echo $r['plan_name']?></td>
										<td><?php echo $r['created_on'];?></td>
										<td><?php echo $r['expiry_date'];?></td>
										<td><?=$r['phone_no'];?></td>
										<td><?=$r['email_id'];?></td>
										
										<td><?=(($r['status'])==1)?'<a href="javascript:;" class="btn btn-success">Active</a>':'<a href="javascript:;" class="btn btn-danger">Deactive</a>'?></td>
										<!-- <td></td> -->
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>

