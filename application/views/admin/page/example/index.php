<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Example List</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/example/create');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
					</div>
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
							<button class="btn btn-primary" id="example_filter">Submit</button>
						</div>
					</div>
					<div class="table-responsive" id="table">

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
