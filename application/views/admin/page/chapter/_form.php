<?=form_open_multipart($action);?>
	<div class="card-body">
		<div class="form-group" style="display:none;">
			<label>Language <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="lang"  readonly value="<?= $this->crud_model->get_type_name_by_id('languages','symbol',$this->crud_model->getLanguage()); ?>">
		</div>
		<div class="form-group" style="display:none;">
			<label>Board</label>
			<input type="text" class="form-control"  readonly  value="<?= $this->session->userdata('board_name'); ?>">
			<input type="hidden" name="board_id" value="<?= $this->session->userdata('board'); ?>" id="board_id">
		</div>

		<div class="form-group">
			<label>Standard</label>
			<select class="form-control select2" required name="std_id" id="std_list" onchange="getSubject(this.value)"></select>
			<input type="hidden" id="estd_id" value="<?= (!empty($editData)) ? $editData['std_id'] : ''; ?>">
		</div>

		<div class="form-group">
			<label>Subject</label>
			<select class="form-control select2" required name="sub_id" id="sub_list"></select>
			<input type="hidden" id="esub_id" value="<?= (!empty($editData)) ? $editData['subject_id'] : ''; ?>">
		</div>


		<div class="form-group">
			<label>Chapter <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="name"  required value="<?= $editData['chapter_text'] ?? ''?>">
		</div>


		<div class="form-group">
			<label>Image <span class="text-danger">*</span>(Note: max upload size 1 MB)</label>
			<input type="file" class="form-control" name="file" id="file"  accept="image/*" >
			<?=(!empty($editData))?'<img src="'.base_url($editData['chapter_img']).'" height="100px" width="100px">':''?>
		</div>

		<div class="form-group">
			<input type="submit" class="btn btn-primary" name="btn" id="btn">
		</div>
	</div>
<?=form_close();?>
