<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Edit Sub Topic</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/subtopic');?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Back</a>
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
								<input type="hidden" name="board_id" value="<?= $this->session->userdata('board'); ?>" id="board_id">
							</div>
						</div>
						<div class="col-12 col-sm-4">
							<label>Language <span class="text-danger">*</span></label>
							<select class="form-control select2" name="language" id="language_id" onchange="getBoard(this.value)">
								<?php foreach($this->crud_model->get_table_data('languages') as $lang) : ?>
									<option value="<?= $lang['symbol']; ?>" <?php if($lang['symbol'] == $editData->lang) { echo "selected";}?>><?= $lang['name'] ;?></option>
								<?php endforeach;?>
							</select>
						</div>

						<div class="col-12 col-sm-4">
							<label>Board</label>
							<select class="form-control select2" name="board" id="board_list" onchange="getStandard(this.value)"></select>
						</div>
						<div class="col-12 col-sm-4">
							<label>Standard</label>
							<div class="form-group">
								<select class="form-control select2" required name="std_id" id="std_list" onchange="getSubject(this.value)"></select>
								<input type="hidden" id="estd_id" value="<?=(!empty($editData) ? $editData->std_id :'' )?>">
							</div>
						</div>
						<div class="col-12 col-sm-4">
							<label>Subject</label>
							<div class="form-group">
								<select class="form-control select2" required name="sub_id" id="sub_list" onchange="changeSubject(this.value)"></select>
								<input type="hidden" id="esub_id" value="<?=(!empty($editData) ? $editData->subject_id :'' )?>">
							</div>
						</div>

						<div class="col-12 col-sm-4">
							<label>Chapter</label>
							<div class="form-group">
								<select class="form-control select2" required name="chapter" id="chapter_list" onchange="getTopics(this.value)"></select>
								<input type="hidden" name="edChid" id="edChid" value="<?=(!empty($editData)?$editData->ch_id:'')?>">
							</div>
						</div>

						<div class="col-12 col-sm-4">
							<label>Topic</label>
							<div class="form-group">
								<select class="form-control select2" required name="topics" id="topic_list" onchange="getMethod(this.value,'mtd_list')"></select>
								<input type="hidden" name="edTpid" id="edTpid" value="<?=(!empty($editData)?$editData->tp_id:'')?>">
							</div>
						</div>

						<div class="col-12 col-sm-3">
							<label>Sub Topic</label>
							<div class="form-group">
								<input type="file"  class="form-control" name="file" id="stp_img">
								<?php if(!empty($editData)) : ?>
									<img src="<?=base_url($editData->subtopic_img);?>" height="100" width="100">
								<?php endif;?>
							</div>
						</div>

						<div class="col-12 col-sm-4">
							<label>Title</label>
							<div class="form-group">
								<input type="text" class="form-control" name="stp_text" id="stp_text" required value="<?=(!empty($editData)?$editData->subtopic_text:'')?>">
							</div>
						</div>

					</div>

					<div class="subtopic_field col-12 col-sm-12"></div>
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
