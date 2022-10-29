<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Teacher List</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover" id="table-1" style="width: 100%;">
							<thead>
                                <tr>
                                    <th>UserId</th>
                                    <th>UserCode</th>
                                    <th>UserName</th>
                                    <th>Password</th>
                                    <th>School</th>
                                    <th>Email Id</th>
                                    <th>Phone No</th>
                                    <th>Action</th>
                                </tr>
							</thead>
							<tbody>
                                <?php
                                foreach($rec as $r){
                                ?>
                                <tr>
                                    <td><?php echo $r['user_id'];?></td>
                                    <td><?php echo $r['usercode'];?></td>
                                    <td><?php echo $r['username'];?></td>
                                    <td><?php echo $r['password'];?></td>
                                    <td><?php echo $r['school_name'];?></td>
                                    <td><?php echo $r['email_id'];?></td>
                                    <td><?php echo $r['phone_no'];?></td>
                                    <td><button class="btn btn-sm btn-outline-primary" data--toggle="edit" data--url="<?=base_url('backend/teacherlist/edit/'.$r['user_id']);?>"><i class="fa fa-edit"></i></button></td>
                                </tr>
                                <?php
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
