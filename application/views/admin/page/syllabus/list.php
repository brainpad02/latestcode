<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Syllbus List</h4>
					<div class="card-header-action">
						<a href="<?=base_url('admin/syllabus/create');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Syllabus</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<button data--toggle="delete_selected" data--url="<?= base_url('admin/topic/removeSelected'); ?>" class="btn btn-danger btn-small mb-2" >Delete Selected Record(s)</button>

						<table class="table table-striped table-hover" id="table-1" style="width: 100%;">
							<thead>
							<tr>
								<!-- <th></th> -->
								<th><input id="check_all" type="checkbox"></th>
								<th>Syllabus Id</th>
								<th>Syllabus Name</th>
								<th>Syllabus Description</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody class="sortable">
							<?php foreach($rec as $r) { ?>
								<tr id="<?= $r['syllabus_id'] ?>">
									<td><input type="checkbox" name="row-check" value="<?= $r['syllabus_id'] ?>"></td>
									<td><?= $r['syllabus_id'];?></td>
									<td><?= $r['syllabus_name'];?></td>
									<td><?=$r['syllabus_description'] ?></td>
									<td>
										<button class="btn btn-sm btn-outline-primary" data--toggle="edit" data--url="<?=base_url('admin/syllabus/edit/'.$r['syllabus_id']);?>"><i class="fa fa-edit"></i></button>
										<!-- <button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('admin/syllabus/remove/'.$r['syllabus_id']);?>"><i class="fa fa-trash"></i></button> -->
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
