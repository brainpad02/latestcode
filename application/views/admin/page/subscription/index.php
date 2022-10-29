<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Subscribers Table</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<button data--toggle="delete_selected" data--url="<?= base_url('backend/subscription/removeSelected'); ?>" class="btn btn-danger btn-small mb-2" >Delete Selected Record(s)</button>

						<table class="table table-striped table-hover" id="table-1" style="width: 100%;">
							<thead>
							<tr>
								<th></th>
								<th><input id="check_all" type="checkbox"></th>
								<th>User Name</th>
                                <th>User Type</th>
								<th>Plan Name</th>
								<th>Plan Type</th>
								<th>Price</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody class="sortable" data--url="<?=base_url('backend/re-ordering/subscription/sub_id');?>">
							<?php foreach($rec as $r) { ?>
								<tr id="<?= $r['sub_id'] ?>">
									<td><i class="fas fa-align-justify"></i></td>
									<td><input type="checkbox" name="row-check" value="<?= $r['sub_id'] ?>"></td>
									<td><?=$r['username'] ?></td>
									<td><?=$r['user_category'];?></td>
									<td><?=$r['plan_name'];?></td>
									<td><?=$r['plan_type'];?></td>
									<td><?=$r['plan_price'];?></td>
									<td><?=$r['start_date'];?></td>
                                    <td><?=$r['end_date'];?></td>
									<td>
										<!-- <button class="btn btn-sm btn-outline-primary" data--toggle="edit" data--url="<?=base_url('backend/subscription/edit/'.$r['sub_id']);?>"><i class="fa fa-edit"></i></button> -->
										<button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('backend/subscription/remove/'.$r['sub_id']);?>"><i class="fa fa-trash"></i></button>
									</td>
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
