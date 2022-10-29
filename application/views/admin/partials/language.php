<?php if(!$this->session->has_userdata('language')) {  ?>

	<div class="modal fade" tabindex="-1" role="dialog" id="languageModal" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-centered" role="document">
			<div class="modal-content">
				<form action="admin/extra/setLanguage" class="langSubmit">
					<div class="modal-header"><h5 class="modal-title">Select Options</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">×</span></button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Language</label>
							<select class="form-control select2" name="language" id="language_id" onchange="getBoard(this.value)">
								<?php foreach($this->crud_model->get_table_data('languages') as $lang) : ?>
									<option value="<?= $lang['symbol']; ?>"><?= $lang['name'] ;?></option>
								<?php endforeach;?>
							</select>
						</div>
						<div class="form-group mb-0">
							<label>Board</label>
							<select class="form-control select2" name="board" id="board_list"></select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-shadow" id="langSubmit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$( document ).ready(function() {
			$('#languageModal').modal({backdrop: 'static', keyboard: false})
			$('#languageModal').modal('show');
		});
	</script>
<?php } ?>
