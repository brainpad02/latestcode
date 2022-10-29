<?= form_open_multipart($action); ?>
	<div class="card-body">
		<div class="form-group" style="display:none;">
			<label>Language <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="lang"  readonly value="<?= $this->crud_model->get_type_name_by_id('languages','symbol',$this->crud_model->getLanguage()); ?>">
		</div>
		<div class="form-group" style="display:none;">
			<label>Board</label>
			<input type="text" class="form-control"  readonly  value="<?= $this->session->userdata('board_name'); ?>">
			<input type="hidden" name="board_id" value="<?= $this->session->userdata('board'); ?>">
		</div>
		<div class="form-group">
			<label>Standard</label>
			<input type="text" class="form-control " name="name" required value="<?=(!empty($editData))?$editData['std_name']:''?>">
			<input type="hidden" class="form-control" name="id"  value="<?=(!empty($editData))?$editData['std_id']:0?>">
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" name="btn" id="btn">
		</div>
	</div>
<?= form_close();?>
