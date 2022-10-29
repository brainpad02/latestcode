<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Edit Topic</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/topic');?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Back</a>
					</div>
				</div>
				<div class="card-body">
					<?=form_open_multipart($action,array('class' => 'topics-form', 'id' => 'topics-form'));
					
					?>
						<div class="row">
							<div class="col-12 col-sm-6">
								<label>Language <span class="text-danger">*</span></label>
								<div class="form-group">
									<input type="hidden" class="form-control" name="lang_id" id="language_id"   readonly value="<?php echo $editData->lang;?>">
									<select class="form-control select2" required name="lang" id="lng_list" onchange="getBoard(this.value)"></select>
								</div>
							</div>

							<div class="col-12 col-sm-6">
								<label>Board</label>
								<input type="hidden" name="board_id" value="<?= $editData->board_id ?>" id="board_id">
								<select class="form-control select2" required name="board_id" id="board_list" onchange="getStandard(this.value)"></select>
							</div>
							
							<div class="col-12 col-sm-6">
								<label>Standard</label>
								<div class="form-group">
									<select class="form-control select2" required name="std_id" id="std_list" onchange="getSubject(this.value)"></select>
									<input type="hidden" id="estd_id" value="<?=(!empty($editData) ? $editData->std_id :'' )?>">
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<label>Subject</label>
								<div class="form-group">
									<select class="form-control select2" required name="sub_id" id="sub_list" onchange="changeSubject(this.value)"></select>
									<input type="hidden" id="esub_id" value="<?=(!empty($editData) ? $editData->subject_id :'' )?>">
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<label>Chapter</label>
								<div class="form-group">
									<select class="form-control select2" required name="chapter" id="chapter_list"></select>
									<input type="hidden" name="edChid" id="edChid" value="<?=(!empty($editData) ? $editData->ch_id :'' )?>">
								</div>
							</div>

							<div class="col-12 col-sm-6">
								<label>Topic</label>
								<div class="form-group">
									<input type="file" class="form-control" name="file" id="tp_img" accept="image/*" >
									<?php if(!empty($editData)) : ?>
										<img src="<?=base_url($editData->topic_img);?>" height="100" width="100">
									<?php endif;?>
								</div>
							</div>

							<div class="col-12 col-sm-6">
								<label>Title</label>
								<div class="form-group">
									<input type="text" class="form-control" name="tp_text" id="tp_text" required value="<?= (!empty($editData) ? $editData->topic_text : '') ?>">
								</div>
							</div>

						</div>

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
		var lng = $("#language_id").val(); 
		getLanguage(lng); 
		
	});
</script>