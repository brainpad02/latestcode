<section class="section">
	<div class="row">
		<div class="col-8">
			<div class="card">
				<div class="card-header">
					<h4>Board</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<button data--toggle="delete_selected" data--url="<?= base_url('backend/board/removeSelected'); ?>" class="btn btn-danger btn-small mb-2" >Delete Selected Record(s)</button>

						<table class="table table-striped" id="table-1">
							<thead>
							<tr>
								<th><input id="check_all" type="checkbox"></th>
								<th>Boards</th>
								<th>Img</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php if (isset($rec)) {
								foreach($rec as $r) { ?>
									<tr>
										<td><input type="checkbox" name="row-check" value="<?= $r['bd_id'] ?>"></td>
										<td><?=$r['bd_name'];?></td>
										<td><img src="<?=base_url($r['bd_img_path']);?>" width="40"></td>
										<td>
											<?= (($r['status'])==1) ? '<a href="'.base_url().'backend/board/status/'.$r['bd_id'].'/'.$r['status'].'" class="btn btn-success">Active</a>'
												: '<a href="'.base_url().'backend/board/status/'.$r['bd_id'].'/'.$r['status'].'" class="btn btn-danger">DeActive</a>'
											?>
										</td>
										<td>
											<a class="btn btn-sm btn-outline-primary" href="<?=base_url('backend/board/edit/'.$r['bd_id']);?>"><i class="fa fa-edit"></i></a>
											<!-- <button class="btn btn-sm btn-outline-primary" data--toggle="edit" data--url="<?=base_url('backend/board/edit/'.$r['bd_id']);?>"><i class="fa fa-edit"></i></button> -->
											<button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('backend/board/remove/'.$r['bd_id']);?>"><i class="fa fa-trash"></i></button>
										</td>
									</tr>
								<?php }
							} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4 col-md-4 col-lg-4">
			<?php $this->load->view('admin/page/board/'.$method); ?>
		</div>
	</div>
</section>
