<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Edit School</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/school');?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Back</a>
					</div>
				</div>
				<div class="card-body">
					<?=form_open_multipart($action,array('class' => 'school-form', 'id' => 'school-form'));?>
					<div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Username<span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" value="<?= $editData[0]->username ?>">
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <label>Password<span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="password" id="password" required placeholder="Enter Password" value="<?= $editData[0]->password;?>">
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
