<section class="section">
	<div class="row">
		<div class="col-8">
			<div class="card">
				<div class="card-header">
					<h4>Subject</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<div style="display:flex;">
							<div class="form-group col-12 col-sm-3">
								<label for="std_list">Standard</label>
								<select class="form-control select2" required name="std_id" id="std_list1" ></select>
							</div>
							<div class="form-group col-12 col-sm-1 mt-4">
								<button class="btn btn-primary" id="subject_filter">Submit</button>
							</div>
						</div>
						<button data--toggle="delete_selected" data--url="<?= base_url('backend/subject/removeSelected'); ?>" class="btn btn-danger btn-small mb-2" >Delete Selected Record(s)</button>
						<table class="table table-striped" id="table-1">
							<thead>
								<tr>
									<th></th>
									<th><input id="check_all" type="checkbox"></th>
									<th>Board</th>
									<th>Standard</th>
									<th>Subject</th>
									<th>Image</th>
									<th>Sequence</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody class="sortable" data--url="<?=base_url('backend/re-ordering/subject/sub_id');?>" id="table">
							<?php
							if(isset($rec)) {
								foreach($rec as $r) { ?>
									<!-- <tr id="<?= $r['sub_id'] ?>">
										<td><i class="fas fa-align-justify"></i></td>
										<td><input type="checkbox" name="row-check" value="<?= $r['sub_id'] ?>"></td>
										<td><?= $r['bd_name'] ?></td>
										<td><?= $r['std_name'] ?></td>
										<td><?= $r['sub_name'];?></td>
										<td><img src="<?=base_url($r['sub_img_path']);?>" width="40"></td>
										<td><?= $r['se'];?></td>
										<td>
											<?= (($r['sub_status'])==1) ? '<a href="'.base_url().'backend/subject/status/'.$r['sub_id'].'/'.$r['sub_status'].'" class="btn btn-success">Active</a>'
												: '<a href="'.base_url().'backend/subject/status/'.$r['sub_id'].'/'.$r['sub_status'].'" class="btn btn-danger">DeActive</a>'
											?>
										</td>
										<td>
											<a class="btn btn-sm btn-outline-primary" href="<?=base_url('backend/subject/edit/'.$r['sub_id']);?>"><i class="fa fa-edit"></i></a>
											<button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('backend/subject/remove/'.$r['sub_id']);?>"><i class="fa fa-trash"></i></button>
										</td>
									</tr> -->
								<?php }
							} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4 col-md-4 col-lg-4">
			<?php $this->load->view('admin/page/subject/'.$method); ?>
		</div>
	</div>
</section>
