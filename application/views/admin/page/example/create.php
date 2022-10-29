<section class="section">
	<div class="row method">
		<div class="col-12 col-md-12 col-lg-12 pl-0 pr-0">
			<div class="card">
				<div class="card-header">
					<h4>Add Example</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/syllabus');?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
					</div>
				</div>
				<?= form_open_multipart( $action, array('id' => 'exampleForm')); ?>

					<div class="card-body">
						<div class="form-row sticky-top bg-white" >
							<div class="form-group col-12 col-sm-3" style="display:none;">
								<label>Language <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="lang"  readonly value="<?= $this->crud_model->get_type_name_by_id('languages','symbol',$this->crud_model->getLanguage()); ?>">
							</div>

							<div class="form-group col-12 col-sm-3" style="display:none;">
								<label>Board</label>
								<input type="text" class="form-control"  readonly  value="<?= $this->session->userdata('board_name'); ?>">
								<input type="hidden" name="board_id" value="<?= $this->session->userdata('board'); ?>" id="board_id">
							</div>

							<div class="form-group col-12 col-sm-2">
								<label>Standard</label>
								<select class="form-control select2" required name="std_id" id="std_list" onchange="getSubject(this.value)"></select>
								<input type="hidden" id="estd_id" value="<?= $std_id ?>">
							</div>

							<div class="form-group col-12 col-sm-2">
								<label>Subject</label>
								<select class="form-control select2" required name="sub_id" id="sub_list" onchange="changeSubject(this.value)"></select>
								<input type="hidden" id="esub_id" value="<?= $subject_id ?>">
							</div>

							<div class="form-group col-12 col-sm-2">
								<label for="chapter_list">Chapter</label>
								<select class="form-control select2" required name="chapter" id="chapter_list" onchange="getTopics(this.value)"></select>
								<input type="hidden" id="edChid" value="<?= $ch_id ?>">
							</div>

							<div class="form-group col-12 col-sm-3">
								<label for="topic_list">Topic</label>
								<select class="form-control select2" required name="topics" id="topic_list" onchange="getSubTopics(this.value)"></select>
								<input type="hidden" id="edTpid" value="<?= $tp_id ?>">
							</div>

							<div class="form-group col-12 col-sm-3">
								<label for="subtopic_list">Sub Topic</label>
								<select class="form-control select2" required name="sub_topic" id="subtopic_list" onchange="getExampleData(this.value)" ><select>
								<input type="hidden" id="edStpid" value="<?= $stp_id ?>">

							</div>
						</div>

						<div class="form-row">
							<div class="col-md-12 mb-3" >
								<div id="accordion">
									<div class="accordion" style="border: #0b76cc 1px solid">
										<div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true">
											<h4>Subtopic Example</h4>
										</div>
										<div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion">
											<table id="item-list" class="table table-bordered table-striped table-hover">
												<thead>
												<tr>
													<th>ID</th>
													<th>Name</th>
													<th>Instruction</th>
												</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-4">
								<label>Category</label>
								<select class="form-control select2" name="category" id="category" onchange="getLayout(this.value)" required>
									<option value="">---- Choose Category ----</option>
									<?php if (isset($category)) {
										foreach ($category as $cat) : ?>
											<option value="<?= $cat['c_id']; ?>"><?= $cat['c_name']; ?></option>
										<?php endforeach;
									} ?>
								</select>
							</div>
							<div class="form-group col-4">
								<label>Layout</label>
								<select class="form-control select2" name="layout_id" id="layout_id" required onchange="getLayoutDesign(this.value)"></select >
							</div>
							<div class="form-group col-4">
								<label>Animation</label>
								<select class="form-control select2" name="animation_id" id="animation_id" required >
									<option value="">---- Choose Animation ----</option>
									<?php if (isset($animation)) {
										foreach($animation as $an) : ?>
											<option value="<?= $an['anim_id'];?>" ><?= $an['anim_name'] .'- ('.$an['anim_description'].')' ;?></option>
										<?php endforeach;
									} ?>
								</select>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-4">
								<label for="heading">Example Name</label>
								<input type="text" class="form-control" name="heading" id="heading">
							</div>
							<div class="form-group col-4">
								<label for="title">Example Instruction</label>
								<input type="text" class="form-control" name="title" id="title">
							</div>
							<div class="form-group col-4">
								<label>Audio</label>
								<input type="file" class="form-control" name="sound" id="sound">
							</div>
							<div class="form-group col-4  exp" >
								<label>Example Explanation</label>
								<input type="file" class="form-control" name="explaination" id="explaination">
							</div>
						</div>

						<div class="que-ans " id="que-ans">
							<div class="jumbotron">
								<div id="question">
									<div class="form-row">
										<div class="form-group col-3 mb-0  q-audio d-none">
											<label for="qm2img">Q.Image/Audio</label>
										</div>

										<div class="form-group col-3 mb-0">
											<label for="qm2text">Q.Text</label>
										</div>

										<div class="form-group col-3 mb-0 q-touch d-none">
											<label for="touch-audio">Q.Touch Audio</label>
										</div>

										<div class="form-group col-3 mb-0 q-true d-none">
											<label for="true-audio">Q.True Audio</label>
										</div>
									</div>
									<input type="hidden" name="hidden_value[1]" value="1">
									<div id="question-item-1">
										<div class="form-row">
											<div class="form-group col-3  q-audio d-none">
												<input type="file" class="form-control que-img" name="qm2files[1][]" id="eqd_img" data--disable="eqd_text">
											</div>

											<div class="form-group col-3 ">
												<input type="text" class="form-control eqd_text" name="qm2text[1][]" id="eqd_text" placeholder="Enter Question">
											</div>

											<div class="form-group col-3 q-touch d-none" >
												<input type="file" class="form-control" name="touch_audio[1][]" id="eqd_touch_audio">
											</div>

											<div class="form-group col-3 q-true d-none">
												<input type="file" class="form-control" name="audio[1][]" id="eqd_audio">
											</div>
											<input type="hidden" name="total_que_item[1][]" value="1">
										</div>
									</div>
									<div id="dynamic-rows-1"></div>
									<div class="form-row">
									<div class="form-group col-12">
										<button type="button" class="btn btn-primary btn-sm que-btn q-add d-none" onclick="addNewRow('question-item-1','dynamic-rows-1')" >Add Q.</button>
										<button type="button" class="btn btn-danger btn-sm que-btn q-remove d-none" onclick="removeRow('dynamic-rows-1','form-row')" >Remove Q.</button>
									</div>
								</div>
								</div>

								<div id="answer">
									<hr>
									<div class="form-row">
										<div class="form-group col-3 mb-0 a-audio d-none">
											<label for="qm2img">A.Image/Audio</label>
										</div>
										<div class="form-group col-3 mb-0">
											<label for="qm2text">A.Text</label>
										</div>
										<div class="form-group col-3 mb-0 a-touch d-none">
											<label for="true-audio">A.Touch Audio</label>
										</div>
										<div class="form-group col-3 mb-0 a-true d-none">
											<label for="true-audio">A.True Audio</label>
										</div>
									</div>
									<div id="answer-item-1">
										<div class="form-row">
											<div class="form-group col-3 a-audio d-none" >
												<input type="file" class="form-control ans-img" name="ead_img[1][]"  id="ead_img" data--disable="ead_text">
											</div>
											<div class="form-group col-3">
												<input type="text" class="form-control ead_text" name="ead_text[1][]" placeholder="Enter Text Answer" id="ead_text">
											</div>
											<div class="form-group col-3 a-touch d-none">
												<input type="file" class="form-control" name="ead_touch_audio[1][]" id="ead_touch_audio">
											</div>
											<div class="form-group col-3 a-true d-none">
												<input type="file" class="form-control" name="ead_audio[1][]" id="ead_audio">
											</div>
											<input type="hidden" name="total_ans_item[1][]" value="1">
										</div>
									</div>
									<div id="dynamic-ans-rows-1"></div>
									<div class="form-row">
									<div class="form-group col-12 mb-0">
										<button type="button" class="btn btn-primary btn-sm ans-btn a-add d-none" onclick="addNewRow('answer-item-1','dynamic-ans-rows-1')">Add A.</button>
										<button type="button" class="btn btn-danger btn-sm ans-btn a-remove d-none" onclick="removeRow('dynamic-ans-rows-1','form-row')">Remove A.</button>
									</div>
								</div>
								</div>
							</div>
						</div>

						<div id="sorting_field"></div>

					</div>
					<div class="card-footer text-right pt-0">
						<div class="form-group">
							<span id="add-remove-card-btn">
								<button type="button" class="btn btn-sm btn-success add-card " id="add-que"><i class="fa fa-plus-circle"></i>  Add Card</button>
								<button type="button" class="btn btn-sm btn-danger  remove-card" id="remove-card" onclick="removeRow('sorting_field','que-ans')"><i class="fa fa-minus-circle"></i> Remove Card</button>
							</span>
							<button type="submit" class="btn btn-primary ml-3" name="btn" id="save-btn" value="save"> <i class="fa fa-file"></i> Save </button>
						</div>
					</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</section>
