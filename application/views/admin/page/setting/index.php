<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Game Sound</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-sm-12 col-md-2">
							<ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="language-tab" data-toggle="tab" href="#language" role="tab" aria-controls="splash-screen" aria-selected="true">Language</a>
								</li>
								<li class="nav-item">
									<a class="nav-link " id="sound-tab" data-toggle="tab" href="#sound" role="tab" aria-controls="sound" aria-selected="true">Game Sound</a>
								</li>
								<li class="nav-item">
									<a class="nav-link " id="splash-screen-tab" data-toggle="tab" href="#splash-screen" role="tab" aria-controls="splash-screen" aria-selected="true">Splash Screen</a>
								</li>
								<li class="nav-item">
									<a class="nav-link " id="next_level-tab" data-toggle="tab" href="#next_level" role="tab" aria-controls="next_level" aria-selected="true">Next Level Unlock Settings</a>
								</li>
								
							</ul>
						</div>
						<div class="col-12 col-sm-12 col-md-10">
							<div class="tab-content no-padding" id="myTab2Content">
								<div class="tab-pane fade show active" id="language" role="tabpanel" aria-labelledby="language-tab">
									<form action="admin/extra/setLanguage" class="langSubmit">
										<div class="card-header">
											<h5 class="modal-title">Select Options</h5>
										</div>
										<div class="card-body">
											<div class="form-group mb-0">
												<label>Language</label>
												<select class="form-control select2" name="language" id="language_id"  onchange="getBoard(this.value)">
													<?php foreach($this->crud_model->get_table_data('languages') as $lang) : ?>
														<option value="<?= $lang['symbol']; ?>"
																<?= ($this->crud_model->getLanguage() ==  $lang['symbol']) ? 'selected' : '' ?>>
															<?= $lang['name'] ;?>
														</option>
													<?php endforeach;?>
												</select>
											</div>
											<div class="form-group mb-0">
												<label>Board</label>
												<select class="form-control select2" name="board" id="board_list"></select>
												<input type="hidden" value="<?= $this->crud_model->getBoard(); ?>" id="board_id">
											</div>
										</div>
										<div class="card-footer">
											<button type="submit" class="btn btn-primary btn-shadow" id="langSubmit">Submit</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="sound" role="tabpanel" aria-labelledby="sound-tab">
									<form method="post" action="<?=base_url('backend/setting/set-gamesound/'.$gamesound->gs_id);?>" enctype="multipart/form-data">
										<div class="form-group col-6">
											<label>Sound</label>
											<input type="file" class="form-control" name="file" accept="audio/*" required>
											<br>
											<audio controls><source src="<?=base_url($gamesound->game_sound);?>"></audio>
										</div>
										<div class="form-group">
											<input type="submit" class="btn btn-primary" name="btn">
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="splash-screen" role="tabpanel" aria-labelledby="splash-screen-tab">
									<div class="row">
										<div class="col-md-6">
											<div class="card">
										<div class="card-header">
											<h4>Splash Screen</h4>
										</div>
										<form method="post" action="<?=base_url('backend/setting/set-splashscreen/'.$splashscreen->sp_id);?>" enctype="multipart/form-data">
											<div class="card-body">
												<div class="form-group">
													<label>Name</label>
													<input type="text" class="form-control" name="name" id="name" required value="<?=(!empty($splashscreen))?$splashscreen->sp_name:''?>">
												</div>
												<div class="form-group">
													<label>Image</label>
													<input type="file" class="form-control" name="file" id="file">
													<?=(!empty($splashscreen))?'<img src="'.base_url('uploads/splashscreen/'.$splashscreen->sp_img_path).'" height="100px" width="100px">':''?>
												</div>
												<div class="form-group">
													<label>Copyright &amp; Trademark</label>
													<input type="text" class="form-control" name="cpy" id="cpy" required value="<?=(!empty($splashscreen))?$splashscreen->sp_copy:''?>">
												</div>
												<div class="form-group">
													<label>Color</label>
													<input type="color" class="form-control" name="color" id="color" required value="<?=(!empty($splashscreen))?$splashscreen->sp_color:''?>">
												</div>
												<div class="form-group">
													<input type="submit" class="btn btn-primary" name="btn" id="btn">
												</div>
											</div>
										</form>
									</div>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="next_level" role="tabpanel" aria-labelledby="next_level-tab">
									<form method="post" action="<?=base_url('backend/setting/next_level_details/'.$splashscreen->sp_id);?>" enctype="multipart/form-data">
										<div class="form-group col-6">
											<label>Next Level unlock Stars</label>
											<input type="text" class="form-control" name="unlock_star" required value="<?=(!empty($splashscreen))?$splashscreen->unlock_min_star:''?>">
										</div>
										<div class="form-group col-6">
											<label>Next Level Unlock usage time*</label>
											<input type="text" class="form-control" name="unlock_time" required value="<?=(!empty($splashscreen))?$splashscreen->ulock_usage_time:''?>">
										</div>
										<div class="form-group">
											<input type="submit" class="btn btn-primary" name="btn">
										</div>
									</form>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
