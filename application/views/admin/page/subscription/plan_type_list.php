<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Plan Type Table</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/plan_type/create');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Plan Type</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<button data--toggle="delete_selected" data--url="<?= base_url('backend/plan_type/removeSelected'); ?>" class="btn btn-danger btn-small mb-2" >Delete Selected Record(s)</button>

						<table class="table table-striped table-hover" id="table-1" style="width: 100%;">
							<thead>
							<tr>
								<!-- <th></th> -->
								<th><input id="check_all" type="checkbox"></th>
								<th>Plan Type</th>
								<th>User Type</th>
								<th>Type Name</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody class="sortable" data--url="<?=base_url('backend/re-ordering/plan_type/plan_type_id');?>">
								<?php foreach($rec as $r) { ?>
									<tr id="<?= $r['plan_type_id'] ?>">
										<!-- <td><i class="fas fa-align-justify"></i></td> -->
										<td><input type="checkbox" name="row-check" value="<?= $r['plan_type_id'] ?>"></td>
										<td><?php echo $r['plan_type_id'];?></td>
										<td><?=$r['user_type'] ?></td>
										<td><?=$r['type_name'];?></td>
										<td>
											<button class="btn btn-sm btn-outline-primary" data--toggle="edit" data--url="<?=base_url('backend/plan_type/edit/'.$r['plan_type_id']);?>"><i class="fa fa-edit"></i></button>
											<button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('backend/plan_type/remove/'.$r['plan_type_id']);?>"><i class="fa fa-trash"></i></button>
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
