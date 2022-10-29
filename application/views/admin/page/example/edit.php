<section class="section">
	<div class="row method">
		<div class="col-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4>Edit Example</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/syllabus');?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
					</div>
				</div>
				<?= form_open_multipart($action); ?>
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

						<div class="form-group col-4">
							<label>Standard</label>
							<select class="form-control select2" required name="std_id" id="std_list" onchange="getSubject(this.value)"></select>
							<input type="hidden" id="estd_id" value="<?= (!empty($example) ? $example->std_id : '') ?>">
						</div>

						<div class="form-group col-4">
							<label>Subject</label>
							<select class="form-control select2" required name="sub_id" id="sub_list" onchange="changeSubject(this.value)"></select>
							<input type="hidden" id="esub_id" value="<?= (!empty($example) ? $example->sub_id : '') ?>">
						</div>

						<div class="form-group col-4">
							<label for="chapter_list">Chapter</label>
							<select class="form-control select2" required name="chapter" id="chapter_list" onchange="getTopics(this.value)"></select>
							<input type="hidden" id="edChid" value="<?= (!empty($example) ? $example->ch_id : '') ?>">
						</div>

						<div class="form-group col-4">
							<label for="topic_list">Topic</label>
							<select class="form-control select2" required name="topics" id="topic_list" onchange="getSubTopics(this.value)"></select>
							<input type="hidden" id="edTpid" value="<?= (!empty($example) ? $example->tp_id : '') ?>">
						</div>

						<div class="form-group col-4">
							<label for="topic_list">Sub Topic</label>
							<select class="form-control select2 select2-tags" required name="sub_topic" id="subtopic_list"></select>
							<input type="hidden" id="edStpid" value="<?= (!empty($example) ? $example->stp_id : '') ?>">

						</div>
					<!-- </div>

					<div class="form-row"> -->
						<div class="form-group col-4">
							<label>Category</label>
							<select class="form-control select2" name="category" id="category" onchange="getLayout(this.value)"  >
								<option value="">---- Choose Category ----</option>
								<?php if (isset($category)) {
									foreach ($category as $cat) : ?>
										<option <?= ($cat['c_id'] == $example->cat_id) ? 'selected':'' ?> value="<?= $cat['c_id']; ?>" ><?= $cat['c_name']; ?></option>
									<?php endforeach;
								} ?>
							</select>
						</div>
						<div class="form-group col-4">
							<label>Layout</label>
							<input type="hidden" id="lay_id" value="<?= (!empty($example) ? $example->layout_id : '') ?>">
							<select class="form-control select2" name="layout_id" id="layout_id" required onchange="getLayoutDesign(this.value)">
							</select>
						</div>
						<div class="form-group col-4">
							<label>Animation</label>
							<select class="form-control select2" name="animation_id" id="animation_id" required >
								<option value="">---- Choose Animation ----</option>
								<?php if (isset($animation)) {
									foreach($animation as $an) : ?>
										<option <?= ($an['anim_id'] == $example->animation_id) ? 'selected':'' ?> value="<?= $an['anim_id'];?>" ><?= $an['anim_name'] .'- ('.$an['anim_description'].')' ;?></option>
									<?php endforeach;
								} ?>
							</select>
						</div>
					<!-- </div>

					<div class="form-row"> -->
						<div class="form-group col-4">
							<label for="heading">Example Name</label>
							<input type="text" class="form-control" name="heading" id="heading" value="<?= (!empty($example) ? $example->ex_heading : '') ?>" >
							<input type="hidden" name="ex_id" value="<?= $example->ex_id ?>">
						</div>
						<div class="form-group col-4">
							<label for="title">Example  Instruction</label>
							<input type="text" class="form-control" name="title" id="title" value="<?= (!empty($example) ? $example->ex_title : '') ?>" >
						</div>
						<div class="form-group col-4">
							<label>Audio</label>
							<input type="hidden" name='ex_audio' id="ex_audio">
							<?php if(!empty($example->ex_audio)){ ?>
								<audio controls style="width: 53%;height: 30%;" class="main_audio">
									<source src="<?= base_url() . $example->ex_audio ?>">
								</audio>
								<a href="javascript:void(0)" onclick="removeAudio('main_audio',<?php echo $example->ex_id;?>,'ex_audio');" class="main_audio"><i class="fa fa-close"></i></a>
							<?php } ?>
							<input type="file" class="form-control" name="sound" id="sound" >
						</div>

						<?php 
						if(!empty($example->ex_explaination)){
							?>
							<div class="form-group col-4 exp" >
								<label>Example Explanation</label>
								<input type="hidden" name='ex_explaination' id="ex_explaination">
								<?php if(!empty($example->ex_explaination)){ ?>
									<audio controls style="width: 53%;height: 30%;" class="main_audio">
										<source src="<?= base_url() . $example->ex_explaination ?>">
									</audio>
									<a href="javascript:void(0)" onclick="removeAudio('main_audio',<?php echo $example->ex_id;?>,'ex_explaination');" class="main_audio"><i class="fa fa-close"></i></a>
								<?php } ?>
								<input type="file" class="form-control" name="explaination" id="explaination">
							</div>
							<?php
						}
						?>
						
					</div>

					<div id="sorting_field">
					<?php
						$i=0;
						if (!empty($exampleDataArray)) {
							foreach ($exampleDataArray as $key => $exData) { $i = $key+1 ?>
								<div class="que-ans">
									<div class="jumbotron">
										<div id="question">
											<div class="form-row">
												<div class="form-group col-3 mb-0 q-audio">
													<label for="qm2img">Q.Image/Audio</label>
												</div>

												<div class="form-group col-3 mb-0">
													<label for="qm2text">Q.Text</label>
												</div>

												<div class="form-group col-3 mb-0 q-touch">
													<label for="touch-audio">Q.Touch Audio</label>
												</div>

												<div class="form-group col-3 mb-0 q-true">
													<label for="true-audio">Q.True Audio</label>
												</div>
											</div>
											<input type="hidden" name="ed_id[<?= $i ?>]" value="<?= $exData['ed_id'] ?>" class="ed_ids">
											<input type="hidden" name="hidden_value[<?= $i ?>]" value="<?= $i ?>">
											<div id="question-item-<?= $i ?>" class="d-none">
												<div class="form-row">
													<div class="form-group col-3 d-none q-audio">
														<input type="file" class="form-control" name="qm2files[<?= $i ?>][]" id="qm2img" >
													</div>

													<div class="form-group col-3 ">
														<input type="text" class="form-control" name="qm2text[<?= $i ?>][]" id="qm2text" placeholder="Enter Question">
													</div>

													<div class="form-group col-3 q-touch d-none">
														<input type="file" class="form-control" name="touch_audio[<?= $i ?>][]" id="touch-audio" >
													</div>

													<div class="form-group col-3 q-true d-none">
														<input type="file" class="form-control" name="audio[<?= $i ?>][]" id="true-audio" >
													</div>
													<input type="hidden" name="total_que_item[<?= $i ?>][]" value="1">
													<input type="hidden" name="eqd_id[<?= $i ?>][]" value="0">
												</div>
											</div>
											<div id="dynamic-rows-<?= $i ?>">
												<?php
												 $get_question_data = $this->crud_model->get_question_data($exData['ed_id']);
												 if (!empty($get_question_data)) { $j = 0;
													foreach ($get_question_data as $key1 => $qiData) { $j++;
												 ?>
													<div class="form-row">
														<input type="hidden" name="eqd_id[<?= $i ?>][]" class="eqd_ids" value="<?= $qiData['eqd_id'] ?>">

														<div class="form-group col-3">
															<input type="hidden" name="eqd_img[<?= $i ?>][]" id="eqd_img_<?= $i.$j ?>">
															<?php if(!empty($qiData['eqd_img'])){
															$array = explode(".", $qiData['eqd_img']);
															if(strtolower(end($array)) == "mp3"){ ?>
																<audio controls style="width: 94%;height: 30%;" class="q_imag_<?php echo $i.$j;?>">
																	<source src="<?= base_url() . $qiData['eqd_img'] ?>">
																</audio>
																<a href="javascript:void(0)" onclick="removeAudio('q_imag_<?php echo $i.$j;?>',<?= $qiData['eqd_id']?>,'eqd_img_<?= $i.$j ?>');" class="q_imag_<?php echo $i.$j;?>"><i class="fa fa-close"></i></a>
															<?php } else {
																?>
																<img src="<?php echo base_url().$qiData['eqd_img']; ?>" height="35px" width="35px" alt="">
																<a href="javascript:void(0)" onclick="removeAudio('q_imag_<?php echo $i.$j;?>',<?= $qiData['eqd_id']?>,'eqd_img_<?= $i.$j ?>');" class="q_imag_<?php echo $i.$j;?>"><i class="fa fa-close"></i></a>
															<?php } } ?>
															<input type="file" class="form-control" name="qm2files[<?= $i ?>][]" id="qm2img" >
														</div>

														<div class="form-group col-3 ">
															<input type="text" class="form-control " name="qm2text[<?= $i ?>][]" id="qm2text" placeholder="Enter Question" value="<?=  $qiData['eqd_text'] ?>">
														</div>

														<div class="form-group col-3">
															<input type="hidden" name="eqd_touch[<?= $i ?>][]" id="eqd_touch_audio_<?= $i.$j ?>">
															<?php if(!empty($qiData['eqd_touch_audio'])){ ?>
																<audio controls style="width: 94%;height: 30%;" class="q_touch_<?php echo $i.$j;?>">
																	<source src="<?= base_url() . $qiData['eqd_touch_audio'] ?>">
																</audio>
																<a href="javascript:void(0)" onclick="removeAudio('q_touch_<?php echo $i.$j;?>',<?= $qiData['eqd_id']?>,'eqd_touch_audio_<?= $i.$j ?>');" class="q_touch_<?php echo $i.$j;?>"><i class="fa fa-close"></i></a>
															<?php } ?>
															<input type="file" class="form-control" name="touch_audio[<?= $i ?>][]" id="touch-audio" >
														</div>

														<div class="form-group col-3">
														<input type="hidden" name="eqd_audio[<?= $i ?>][]" id="eqd_audio_<?= $i.$j ?>">
															<?php if(!empty($qiData['eqd_audio'])){ ?>
																<audio controls style="width: 94%;height: 30%;" class="q_true_<?php echo $i.$j;?>">
																	<source src="<?= base_url() . $qiData['eqd_audio'] ?>">
																</audio>
																<a href="javascript:void(0)" onclick="removeAudio('q_true_<?php echo $i.$j;?>',<?= $qiData['eqd_id']?>,'eqd_audio_<?= $i.$j ?>');" class="q_true_<?php echo $i.$j;?>"><i class="fa fa-close"></i></a>
															<?php } ?>
															<input type="file" class="form-control" name="audio[<?= $i ?>][]" id="true-audio" >
														</div>
														<input type="hidden" name="total_que_item[<?= $i ?>][]" value="1">
													</div>
												<?php } } ?>
											</div>
											<div class="form-row">
												<div class="form-group col-12">
													<button type="button" class="btn btn-primary btn-sm  que-btn q-add d-none" onclick="addNewRow('question-item-<?= $i ?>','dynamic-rows-<?= $i ?>')">Add Q.</button>
													<button type="button" class="btn btn-danger btn-sm  que-btn q-remove d-none" onclick="removeRow('dynamic-rows-<?= $i ?>','form-row','eqd_ids','eqd')">Remove Q.</button>
												</div>
											</div>
										</div>
										<!----------------------------------------------------------------------------- Answer ------------------------------------------------------------------------>
										<div id="answer">
											<hr>
											<!-- labels -->
											<div class="form-row">
												<div class="form-group col-3 mb-0">
													<label for="qm2img">A.Image/Audio</label>
												</div>
												<div class="form-group col-3 mb-0">
													<label for="qm2text">A.Text</label>
												</div>
												<div class="form-group col-3 mb-0">
													<label for="true-audio">A.Touch Audio</label>
												</div>
												<div class="form-group col-3 mb-0">
													<label for="true-audio">A.True Audio</label>
												</div>
											</div>

											<!-- blank fields -->
											<div id="answer-item-<?= $i ?>" class="d-none">
												<div class="form-row">
													<div class="form-group col-3">
														<input type="file" class="form-control" name="ead_img[<?= $i ?>][]" accept="image/*">
													</div>

													<div class="form-group col-3 ">
														<input type="text" class="form-control" name="ead_text[<?= $i ?>][]" placeholder="Enter Question">
													</div>

													<div class="form-group col-3">
														<input type="file" class="form-control" name="ead_touch_audio[<?= $i ?>][]"  id="ead_touch_audio">
													</div>

													<div class="form-group col-3">
														<input type="file" class="form-control" name="ead_audio[<?= $i ?>][]" >
													</div>

													<input type="hidden" name="total_ans_item[<?= $i ?>][]" value="1">
													<input type="hidden" name="ead_id[<?= $i ?>][]" value="0">
												</div>
											</div>

											<!-- fields -->
											<div id="dynamic-ans-rows-<?= $i ?>">
												<?php
												$get_answer_data = $this->crud_model->get_answer_data($exData['ed_id']);
												if (!empty($get_answer_data)) { $k=0;
													foreach ($get_answer_data as $key1 => $aiData) { $k++;
														?>
														<div class="form-row">
															<input type="hidden" name="ead_id[<?= $i ?>][]" class="ead_ids" value="<?= $aiData['ead_id'] ?>">

															<div class="form-group col-3">
																<input type="hidden" name="ead_img[<?= $i ?>][]" id="ead_img_<?= $i.$k ?>">
																<?php if(!empty($aiData['ead_img'])){
																	$array = explode(".", $aiData['ead_img']);
																	if(strtolower(end($array)) == "mp3"){
																	?>
																	<audio controls style="width: 94%;height: 30%;" class="a_imag_<?php echo $i.$k;?>">
																	<source src="<?= base_url() . $aiData['ead_img'] ?>">
																	</audio>
																	<a href="javascript:void(0)" onclick="removeAudio('a_imag_<?php echo $i.$k;?>',<?= $aiData['eqd_id']?>,'ead_img_<?= $i.$k ?>');" class="a_imag_<?php echo $i.$k;?>"><i class="fa fa-close"></i></a>
																	<?php
																	}
																else{	
																?>
																	<img src="<?php echo base_url().$aiData['ead_img']; ?>" height="35px" width="35px" alt="" class="a_imag_<?php echo $i.$k;?>">
																	<a href="javascript:void(0)" onclick="removeAudio('a_imag_<?php echo $i.$k;?>',<?= $aiData['ead_id']?>,'ead_img_<?= $i.$k ?>');"  class="a_imag_<?php echo $i.$k;?>"><i class="fa fa-close"></i></a>
																<?php } } ?>
																<input type="file" class="form-control" name="ead_img[<?= $i ?>][]" accept="image/*">
															</div>

															<div class="form-group col-3 ">
																<input type="text" class="form-control" name="ead_text[<?= $i ?>][]" placeholder="Enter Text Answer" value="<?=  $aiData['ead_text'] ?>">
															</div>

															<div class="form-group col-3">
																<input type="hidden" name="ead_touch_audio[<?= $i ?>][]" id="ead_touch_audio_<?= $i.$k ?>">
																<?php if(!empty($aiData['ead_touch_audio'])){ ?>
																	<audio controls style="width: 94%;height: 30%;" class="a_touch_<?php echo $i.$k;?>">
																		<source src="<?= base_url() . $aiData['ead_touch_audio'] ?>">
																	</audio>
																	<a href="javascript:void(0)" onclick="removeAudio('a_touch_<?php echo $i.$k;?>',<?= $aiData['ead_id']?>,'ead_touch_audio_<?= $i.$k ?>');" class="a_touch_<?php echo $i.$k;?>"><i class="fa fa-close"></i></a>
																<?php } ?>
																<input type="file" class="form-control" name="ead_touch_audio[<?= $i ?>][]" >
															</div>


															<div class="form-group col-3">
																<input type="hidden" name="ead_audio[<?= $i ?>][]" id="ead_audio_<?= $i.$k ?>">
																<?php if(!empty($aiData['ead_audio'])){ ?>
																	<audio controls style="width: 94%;height: 30%;" class="a_true_<?php echo $i.$k;?>">
																		<source src="<?= base_url() . $aiData['ead_audio'] ?>">
																	</audio>
																	<a href="javascript:void(0)" onclick="removeAudio('a_true_<?php echo $i.$k;?>',<?= $aiData['ead_id']?>,'ead_audio_<?= $i.$k ?>');" class="a_true_<?php echo $i.$k;?>"><i class="fa fa-close"></i></a>
																<?php } ?>
																<input type="file" class="form-control" name="ead_audio[<?= $i ?>][]" >
															</div>

															<input type="hidden" name="total_ans_item[<?= $i ?>][]" value="1">
														</div>
													<?php } } ?>
											</div>
											<div class="form-row">
												<div class="form-group col-12">
													<button type="button" class="btn btn-primary btn-sm ans-btn" onclick="addNewRow('answer-item-<?= $i ?>','dynamic-ans-rows-<?= $i ?>')">Add A.</button>
													<button type="button" class="btn btn-danger btn-sm ans-btn" onclick="removeRow('dynamic-ans-rows-<?= $i ?>','form-row','ead_ids','ead')">Remove A.</button>
												</div>
											</div>
										</div>
									</div>
								</div>

					<?php }
						} ?>
					</div>
					<input type="hidden" value="<?= $i + 1 ?>" id="i_value">


					<div class="card-footer text-right pt-0">
						<div class="form-group ">
							<span  id="add-remove-card-btn">
								<button type="button" class="btn btn-sm btn-success" id="add-que"> <i class="fa fa-plus-circle"></i> Add Card</button>
								<button type="button" class="btn btn-sm btn-danger"  id="remove-card" onclick="removeRow('sorting_field','que-ans','ed_ids','ed')"> <i class="fa fa-minus-circle"></i> Remove Card</button>
							</span>
							<button type="submit" class="btn btn-primary" name="btn" id="save-btn" value="save"> <i class="fa fa-file"></i> Save </button>
							<a href="<?=base_url('backend/example/view?board_id='. $example->board_id. '&std_id='. $example->std_id. '&subject_id='. $example->subject_id. '&ch_id='. $example->ch_id.
									'&tp_id='. $example->tp_id. '&stp_id='. $example->stp_id) ?>" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</section>