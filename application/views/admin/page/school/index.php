<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>School Table</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/school/create');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add School</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<button data--toggle="delete_selected" data--url="<?= base_url('backend/school/removeSelected'); ?>" class="btn btn-danger btn-small mb-2" >Delete Selected Record(s)</button>

						<table class="table table-striped table-hover" id="table-1" style="width: 100%;">
							<thead>
							<tr>
								<th></th>
								<th><input id="check_all" type="checkbox"></th>
								<th>Logo</th>
								<th>School Code</th>
								<th>School Name</th>
								<th>Description</th>
								<th>Phone No</th>
								<th>Address</th>
								<th>City</th>
								<th>State</th>
								<th>Country</th>
								<th>Zipcode</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody class="sortable" data--url="<?=base_url('backend/re-ordering/school/school_id');?>">
							<?php foreach($rec as $r) { ?>
								<tr id="<?= $r['school_id'] ?>">
									<td><i class="fas fa-align-justify"></i></td>
									<td><input type="checkbox" name="row-check" value="<?= $r['school_id'] ?>"></td>
									<td><img src="<?=base_url($r['school_logo']);?>" width="40"></td>
									<td><?= $r['school_code'];?></td>
									<td><?=$r['school_name'] ?></td>
									<td><?=$r['school_description'];?></td>
									<td><?=$r['school_phoneno']; ?></td>
									<td><?=$r['school_address'];?></td>
									<td><?=$r['school_city'];?></td>
									<td><?=$r['school_state'];?></td>
									<td><?=$r['school_country'];?></td>
									<td><?=$r['school_zipcode'];?></td>
									<td>
										<button class="btn btn-sm btn-outline-primary" data--toggle="edit" data--url="<?=base_url('backend/school/edit/'.$r['school_id']);?>"><i class="fa fa-edit"></i></button>
										<button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('backend/school/remove/'.$r['school_id']);?>"><i class="fa fa-trash"></i></button>
										<button class="btn btn-sm btn-outline-danger"><a href="<?=base_url('backend/school/view/'.$r['school_id']);?>"><i class="fa fa-eye"></i></a></button>
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
