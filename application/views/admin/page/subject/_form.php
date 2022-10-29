<?= form_open_multipart($action); ?>
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
		<select class="form-control select2" required name="std_id" id="std_list"></select>
		<input type="hidden" id="estd_id" value="<?= (!empty($editData)) ? $editData['std_id'] : ''; ?>">
	</div>

	<div class="form-group">
		<label>Subject</label>
		<input type="text" class="form-control" name="name" id="name"  required value="<?=(!empty($editData))?$editData['sub_name']:''?>">
		<input type="hidden" class="form-control" name="id" id="id" value="<?=(!empty($editData))?$editData['sub_id']:0?>">
	</div>
	<div class="form-group">
		<label>Image <span class="text-danger">*</span></label>
		<input type="file" class="form-control" name="file" id="file"  accept="'image/*" >
		<?=(!empty($editData))?'<img src="'.base_url($editData['sub_img_path']).'" height="100px" width="100px">':''?>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="btn" id="btn">
	</div>
</div>
<?= form_close();?>
