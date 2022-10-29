<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Student List</h4>
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
							<button class="btn btn-primary" id="student_filter">Submit</button>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<div id="table_data"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- The Modal -->
<script>
	$("#student_filter").click(function(){
		var std = $("#std_list").val();
		var sub = $("#sub_list").val();
		var chp = $("#chapter_list").val();
		var topic = $("#topic_list").val();
		$.ajax({
			url : base_url+'teachers/user/getSubtopics',
			method: 'POST',
			data:{std:std,sub:sub,chp:chp,topic:topic},
			success:function(msg){ 
				$("#table_data").empty();
				$("#table_data").append(msg);
			},
		});
	});
</script>
        
       
