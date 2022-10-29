<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Category Table</h4>
                    <div class="card-header-action">
						<a href="<?=base_url('backend/category/create');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Category</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<button data--toggle="delete_selected" data--url="<?= base_url('backend/category/removeSelected'); ?>" class="btn btn-danger btn-small mb-2" >Delete Selected Record(s)</button>

						<table class="table table-striped table-hover" id="table-1" style="width: 100%;">
							<thead>
							<tr>
								<th></th>
								<th><input id="check_all" type="checkbox"></th>
								<th>Category Name</th>
								<th>Status</th>
                                <th>Action</th>
							</tr>
							</thead>
							<tbody class="sortable" data--url="<?=base_url('backend/re-ordering/category/c_id');?>">
							<?php foreach($rec as $r) { ?>
								<tr id="<?= $r['c_id'] ?>">
									<td><i class="fas fa-align-justify"></i></td>
									<td><input type="checkbox" name="row-check" value="<?= $r['c_id'] ?>"></td>
									<td><?=$r['c_name'] ?></td>
									<td>
										<?= (($r['status'])==1) ? '<a href="'.base_url().'backend/category/status/'.$r['c_id'].'/'.$r['status'].'" class="btn btn-success">Active</a>'
											: '<a href="'.base_url().'backend/category/status/'.$r['c_id'].'/'.$r['status'].'" class="btn btn-danger">DeActive</a>'
										?>
									</td>
									<td>
										<button class="btn btn-sm btn-outline-primary" data--toggle="edit" data--url="<?=base_url('backend/category/edit/'.$r['c_id']);?>"><i class="fa fa-edit"></i></button>
										<!-- <button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('backend/category/remove/'.$r['c_id']);?>"><i class="fa fa-trash"></i></button> -->
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
