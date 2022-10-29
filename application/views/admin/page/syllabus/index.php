<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Syllabus Table</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/example/create');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
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
						<input type="hidden" value="<?php if(!empty($this->session->userdata('syllabus'))){ echo $this->session->userdata('syllabus')['std_id']; } ?>" id="estd_id">
						<input type="hidden" id="esub_id" value="<?php if(!empty($this->session->userdata('syllabus'))){ echo $this->session->userdata('syllabus')['subject_id']; } ?>">
						<input type="hidden" id="ch_id" value="<?php if(!empty($this->session->userdata('syllabus'))){ echo $this->session->userdata('syllabus')['chapter_id']; } ?>">
						<input type="hidden" id="edTpid" value="<?php if(!empty($this->session->userdata('syllabus'))){ echo $this->session->userdata('syllabus')['topic_id']; } ?>">
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
							<select class="form-control select2" required name="topic_id" id="topic_list" onchange="getSubTopics(this.value)"></select>
						</div>
						<div class="form-group col-12 col-sm-2">
							<label for="chapter_list">Sub Topics</label>
							<select class="form-control select2" required name="subtopic_list" id="subtopic_list" ></select>
						</div>
						<div class="form-group col-12 col-sm-1 mt-4">
							<button class="btn btn-primary" id="syllabus_filter">Submit</button>
						</div>
						<div class="noexample" style="display:none;">
							<h6>No of Example : <span class="noex"></span></h6>
						</div>
					</div>
					<!-- <div class="table-responsive" id="table">

					</div> -->
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover" id="table-1" style="width: 100%;">
							<thead>
							<tr>
								<th>Standard</th>
								<th>Subject</th>
								<th>Chapter</th>
								<th>Topic</th>
								<th>Subtopic</th>
								<th>Category</th>
								<th>Layout</th>
								<th>Example ID</th>
								<th>Example Description</th>
								<th>Sequence</th>
								<th>Status</th>
                                <th>Action</th>
							</tr>
							</thead>
							<tbody class="sortable" data--url="<?=base_url('backend/re-ordering/example/ex_id');?>" id="table">
							<!-- <?php foreach($rec as $r) { 
                                if(!empty($r['ex_id'])){
                                    ?>
								<tr id="<?= $r['ex_id'] ?>">
									<td><?=$r['std_name'] ?></td>
									<td><?= $r['sub_name'];?></td>
									<td><?=$r['chapter_text'];?></td>
									<td><?=$r['topic_text'];?></td>
									<td><?=$r['subtopic_text'];?></td>
									<td><?=$r['c_name'];?></td>
									<td><?=$r['lay_name'];?></td>
                                    <td><?=$r['ex_id'];?></td>
                                    <td><?=$r['ex_heading'];?></td>
									<td>
										<button class="btn btn-sm btn-outline-primary" data--toggle="edit" data--url="<?=base_url('backend/example/edit/'.$r['ex_id']);?>"><i class="fa fa-edit"></i></button>
									</td>
								</tr>
							<?php
                                }
                                 } ?> -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<style>
.show {
  background: #e5e5e5;
}
</style>
