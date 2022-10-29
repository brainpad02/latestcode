<form action="<?= $action ?>" class="board-form" enctype="multipart/form-data" method="post" >
	<div class="card-body">
		<!-- <div class="form-group">
			<label>Language <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="lang"  readonly value="<?= $this->crud_model->get_type_name_by_id('languages','symbol',$this->crud_model->getLanguage()); ?>">
		</div> -->
		<div class="form-group">
			<label>Board <span class="text-danger">*</span></label>
			<input type="text" class="form-control" name="bd_name"  required value="<?= $editData['bd_name'] ?? ''?>">
		</div>
		<div class="form-group">
			<label>Image <span class="text-danger">*</span>(Note: max upload size 1 MB)</label>
			<input type="file" class="form-control" name="file" id="file"  accept="'image/jpg,image/jpeg,image/png,image/PNG,image/Png" >
			<?=(!empty($editData))?'<img src="'.base_url($editData['bd_img_path']).'" height="100px" width="100px">':''?>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" name="btn" id="btn">
		</div>
	</div>
</form>
