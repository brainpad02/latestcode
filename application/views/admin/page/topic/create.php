<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Create Topic</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/topic');?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
					</div>
				</div>
				<div class="card-body">
					<?=form_open_multipart($action,array('class' => 'topics-form', 'id' => 'topics-form'));?>
					<div class="row">
						<div class="col-12 col-sm-4" style="display:none;">
							<label>Language <span class="text-danger">*</span></label>
							<div class="form-group">
								<input type="text" class="form-control" name="lang"  readonly value="<?= $this->crud_model->get_type_name_by_id('languages','symbol',$this->crud_model->getLanguage()); ?>">
							</div>
						</div>
						<div class="col-12 col-sm-4" style="display:none;">
							<label>Board</label>
							<input type="text" class="form-control"  readonly  value="<?= $this->session->userdata('board_name'); ?>">
							<input type="hidden" name="board_id" value="<?= $this->session->userdata('board'); ?>" id="board_id">
						</div>
						<div class="col-12 col-sm-6">
							<label>Standard</label>
							<div class="form-group">
								<select class="form-control select2" required name="std_id" id="std_list" onchange="getSubject(this.value)"></select>
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<label>Subject</label>
							<div class="form-group">
								<select class="form-control select2" required name="sub_id" id="sub_list" onchange="changeSubject(this.value)"></select>
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<label>Chapter</label>
							<div class="form-group">
								<select class="form-control select2" required name="chapter" id="chapter_list" ></select>
							</div>
						</div>

						<div class="col-12 col-sm-6">
							<label>Topic</label>
							<div class="form-group">
								<input type="file" class="form-control" name="tp_img[]" id="tp_img" accept="image/*" required >
							</div>
						</div>

						<div class="col-12 col-sm-6">
							<label>Title</label>
							<div class="form-group">
								<input type="text" class="form-control" name="tp_text[]" id="tp_text" required >
							</div>
						</div>

						<div class="col-12 col-sm-2">
							<label><br/></label>
							<div class="form-group">
								<a href="javascript:;"  id="topicBtn" class="btn btn-success" name="add"><i class="fa fa-plus"></i> Add More Fields</a>
							</div>
						</div>
					</div>

					<div class="topic_field col-12 col-sm-12"></div>
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
