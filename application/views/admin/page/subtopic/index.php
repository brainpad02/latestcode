<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Sub Topics Table (Warning : Deleting Subtopic will delete all examples of it.)</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/example/create');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Example</a>
						<a href="<?=base_url('backend/subtopic/create');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Record</a>
						<!-- <button data--toggle="delete_selected" data--url="<?= base_url('backend/subtopic/removeSelected'); ?>" class="btn btn-danger btn-small mb-2" >Delete Selected Record(s)</button> -->
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="form-group col-12 col-sm-2" style="display:none;">
							<label for="lang_id">Language</label>
							<input type="text" class="form-control" id="lang_id" name="lang"  readonly value="<?= $this->crud_model->get_type_name_by_id('languages','symbol',$this->crud_model->getLanguage()); ?>">
						</div>
						<div class="form-group col-12 col-sm-2" style="display:none;">
							<label for="board_id">Board</label>
							<input type="text" class="form-control"  readonly  value="<?= $this->session->userdata('board_name'); ?>">
							
						</div>
						<input type="hidden" name="board_id" value="<?= $this->session->userdata('board'); ?>" id="board_id">
						<input type="hidden" value="<?php if(!empty($this->session->userdata('subtopics'))){ echo $this->session->userdata('subtopics')['std_id']; } ?>" id="estd_id">
						<input type="hidden" id="esub_id" value="<?php if(!empty($this->session->userdata('subtopics'))){ echo $this->session->userdata('subtopics')['subject_id']; } ?>">
						<input type="hidden" id="ch_id" value="<?php if(!empty($this->session->userdata('subtopics'))){ echo $this->session->userdata('subtopics')['chapter_id']; } ?>">
						<div class="form-group col-12 col-sm-3">
							<label for="std_list">Standard</label>
							<select class="form-control select2" required name="std_id" id="std_list" onchange="getSubject(this.value)"></select>
						</div>
						<div class="form-group col-12 col-sm-2">
							<label for="sub_list">Subject</label>
							<select class="form-control select2" required name="sub_id" id="sub_list"  onchange="changeSubject(this.value)"></select>
						</div>
						<div class="form-group col-12 col-sm-2">
							<label for="chapter_list">Chapter</label>
							<select class="form-control select2" required name="chapter_id" id="chapter_list" onchange="getTopics(this.value)"></select>
						</div>
						<div class="form-group col-12 col-sm-2">
							<label for="chapter_list">Topics</label>
							<select class="form-control select2" required name="topic_id" id="topic_list" ></select>
						</div>
						<div class="form-group col-12 col-sm-1 mt-4">
							<button class="btn btn-primary" id="subtopics_filter">Submit</button>
						</div>
					</div>
					<!-- <div class="table-responsive" id="table">

					</div> -->
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<button data--toggle="delete_selected" data--url="<?= base_url('backend/subtopic/removeSelected'); ?>" class="btn btn-danger btn-small mb-2" >Delete Selected Record(s)</button>

						<table class="table table-striped table-hover" id="table-1" style="width: 100%;">
							<thead>
							<tr>
							    <th><input id="check_all" type="checkbox"></th>
								<th>Standard</th>
								<th>Subject</th>
								<th>Chapter</th>
								<th>Topic</th>
								<th>Sub Topic</th>
								<th>Image</th>
								<th>No.Example</th>
								<th>Sequence</th>
								<th>Action</th>
								<th>Status</th>
							</tr>
							</thead>
							<tbody id="table" class="sortable" data--url="<?=base_url('backend/re-ordering/subtopics/stp_id');?>">
							<!-- <?php foreach($rec as $r) { ?>
								<tr id="<?= $r['stp_id'] ?>">
									<td><i class="fas fa-align-justify"></i></td>
									<td><input type="checkbox" name="row-check" value="<?= $r['stp_id'] ?>"></td>
									<td><?=$r['bd_name'] ?></td>
									<td><?=$r['std_name'];?></td>
									<td><?=$r['sub_name'];?></td>
									<td><?=$r['chapter_text'];?></td>
									<td><?=$r['topic_text'];?></td>
									<td><?=$r['subtopic_text'];?></td>
									<td><img src="<?=base_url($r['subtopic_img']);?>" width="45px"></td>
									<td>
										<?= (($r['subtopic_status'])==1) ? '<a href="'.base_url().'backend/subtopic/status/'.$r['stp_id'].'/'.$r['subtopic_status'].'" class="btn btn-success">Active</a>'
											: '<a href="'.base_url().'backend/subtopic/status/'.$r['stp_id'].'/'.$r['subtopic_status'].'" class="btn btn-danger">DeActive</a>'
										?>
									</td>
									<td>
										<button class="btn btn-sm btn-outline-primary" data--toggle="edit" data--url="<?=base_url('backend/subtopic/edit/'.$r['stp_id']);?>"><i class="fa fa-edit"></i></button>
										<button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('backend/subtopic/remove/'.$r['stp_id']);?>"><i class="fa fa-trash"></i></button>
									</td>
								</tr>
							<?php } ?> -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- The Modal -->
<div class="modal" id="selectpop">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
       
