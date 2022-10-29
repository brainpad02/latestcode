<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Create Sub Topic</h4>
					<div class="card-header-action">
						<a href="<?=base_url('admin/subtopic');?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
					</div>
				</div>
				<div class="card-body">
					<?=form_open_multipart($action,array('class' => 'subtopics-form', 'id' => 'subtopics-form'));?>
						<div class="row">
							<div class="col-12 col-sm-4" style="display:none;">
								<label>Language <span class="text-danger">*</span></label>
								<div class="form-group">
									<input type="text" class="form-control" name="lang"  readonly value="<?= $this->crud_model->get_type_name_by_id('languages','symbol',$this->crud_model->getLanguage()); ?>">
								</div>
							</div>

							<div class="col-12 col-sm-4" style="display:none;">
								<label>Board</label>
								<div class="form-group">
									<input type="text" class="form-control"  readonly  value="<?= $this->session->userdata('board_name'); ?>">
									<input type="hidden" id="board_id" name="board_id" value="<?= $this->session->userdata('board'); ?>" id="board_id">
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<label>Syllabus Name <span class="text-danger">*</span></label>
								<div class="form-group">
									<input type="text" class="form-control" name="syllabus_name">
								</div>
							</div>

							<div class="col-12 col-sm-6">
								<label>Syllabus Description</label>
								<div class="form-group">
									<textarea name="syllabus_desc" class="form-control" id="syllabus_desc" cols="30" rows="10"></textarea>
								</div>
							</div>

							<div class="col-12 col-sm-3">
								<label>Standard</label>
								<div class="form-group">
									<select class="form-control select2 std_list"  name="std_id[]" id="std_list_0" onchange="getSubjectSyllabus(this.value,0)"></select>
								</div>
							</div>

							<div class="col-12 col-sm-3">
								<label>Subject</label>
								<div class="form-group">
									<select class="form-control select2"  name="sub_id[]" id="sub_list_0" onchange="getSyllabusChapter(this.value,0)" multiple></select>
								</div>
							</div>

							<div class="col-12 col-sm-3">
								<label>Chapter</label>
								<div class="form-group">
									<select class="form-control select2"  name="chapter[]" id="chapter_list_0" multiple></select>
								</div>
							</div>

							<!-- <div class="col-12 col-sm-4">
								<label>Topic</label>
								<div class="form-group">
									<select class="form-control select2" required name="topics" id="topic_list" onchange="getMethod(this.value,'mtd_list')"></select>
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<label>Sub Topic</label>
								<div class="form-group">
									<input type="file"  class="form-control" name="file[]" id="stp_img" accept="image/*">
									<?php if(!empty($edrec)) : ?>
										<img src="<?=base_url($edrec->subtopic_img);?>" height="100" width="100">
									<?php endif;?>
								</div>
							</div> -->

							<div class="col-12 col-sm-3">
								<label><br/></label>
								<div class="form-group">
									<a href="javascript:;" id="syllabusBtn" class="btn btn-success" name="add" onclick="add_more(0);"><i class="fa fa-plus"></i> Add More</a>
								</div>
							</div>
						</div>

						<div class="subtopic_field"></div>
						<div class="col-12 col-sm-6">
							<div class="form-group">
								<input type="submit" class="btn btn-primary" name="btn">
							</div>
						</div>
					<?=form_close();?>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	$(document).ready(function(){
		getSyllabusSubject();
	});
	function getSyllabusSubject(){
		var board_id = $("#board_id").val();
		var std_id = 0;
		if(board_id !== '') {
			$.ajax({
				url: base_url + 'admin/extra/getStandard',
				method: 'POST',
				data: {board_id: board_id, std_id: std_id},
				success: function (msg) {
					$(".std_list").html(msg);
				},
			});
		}
	}
	function getSubjectSyllabus(value,i){
		var std_id = $("#std_list_"+i).val();
		var sub_id = 0;
		if(std_id !== '') {
			$.ajax({
				url: base_url + 'admin/extra/getSubject',
				method: 'POST',
				data: {std_id: std_id, sub_id: sub_id},
				success: function (msg) { 
					$("#sub_list_"+i).html(msg);
				},
			});
		}
	}
	function getSyllabusChapter(value,i){
		var board_id = $("#board_id").val();
		var standard = $("#std_list_"+i).val();
		var echid = 0;
		var selected = $("#sub_list_"+i+" :selected").map((_, e) => e.value).get();
       	$.ajax({
			url : base_url+'admin/syllabus/getChapter',
			method: 'POST',
			data:{board_id:board_id,std_id:standard,sub_id:selected,echid:echid},
			success:function(msg){
				$("#chapter_list_"+i).html(msg);
			},
		});
	}

	function add_more(i){
		var board_id = $("#board_id").val();
		var std_id = $("#std_list_"+i).val();
		$.ajax({
			url: base_url + 'admin/extra/getStandard',
			method: 'POST',
			data: {board_id: board_id, std_id: std_id},
			success: function (msg) {
				$("#std_list_"+i).html(msg);
			},
		});
		var sn = parseInt(i+1);
		$('.subtopic_field').append(
			'<div class="row rm-pading" id="tprow' + sn + '">'
			+ '<div class="col-12 col-sm-3">'
			+ '<label>Standard</label>'
			+ '<div class="form-group">'
			+ '<select class="form-control select2 std_list"  name="std_id[]" id="std_list_'+sn+'" onchange="getSubjectSyllabus(this.value,'+sn+')"></select>'
			+ '</div>'
			+ '</div>'

			+ '<div class="col-12 col-sm-3">'
			+ '<label> Subject</label>'
			+ '<div class="form-group">'
			+ '<select class="form-control select2" name="sub_id[]" id="sub_list_'+sn+'" onchange="getSyllabusChapter(this.value,'+sn+')" multiple></select>'
			+ '</div>'
			+ '</div>'

			+ '<div class="col-12 col-sm-3">'
			+ '<label> Chapter</label>'
			+ '<div class="form-group">'
			+ '<select class="form-control select2" name="chapter[]" id="chapter_list_'+sn+'" multiple></select>'
			+ '</div>'
			+ '</div>'

			+ '<div class="col-12 col-sm-3"><label>-</label ><div class="form-group"><a href="javascript:;" id="' + sn + '" class="btn btn-danger removeBtn" name="remove"><i class="fa fa-times"></i></a></div></div></div>');

			getSyllabusSubject();
	}
	
</script>