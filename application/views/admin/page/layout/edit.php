<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Edit Layout</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/layout');?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
					</div>
				</div>
				<div class="card-body">
					<?=form_open_multipart($action,array('class' => 'layout-form', 'id' => 'layout-form'));?>
						<div class="row">
							<div class="col-12 col-sm-4">
								<label>Category<span class="text-danger">*</span></label>
								<div class="form-group">
                                    <select class="form-control select2" required name="cat_id" id="cat_id" required>
                                        <option value="">Select Category</option>
                                        <?php
                                            if(!empty($category)){
                                                foreach($category as $cat){
                                                ?>
                                                <option value="<?= $cat['c_id'];?>" <?php if($cat['c_id'] == $editData->cat_id){ echo "selected"; }?>><?= $cat['c_name'];?></option>
                                                <?php
                                                }
                                            }
                                        ?>
                                    </select>
								</div>
							</div>

                            
							<div class="col-12 col-sm-4">
								<label>Layout Name<span class="text-danger">*</span></label>
								<div class="form-group">
									<input type="text" class="form-control" name="lay_name" id="lay_name" required placeholder="Enter Layout Name" value="<?= $editData->lay_name; ?>">
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<label>Layout Description<span class="text-danger">*</span></label>
								<div class="form-group">
									<textarea name="lay_description" id="lay_description" cols="30" rows="10" class="form-control"><?= $editData->lay_description; ?></textarea>
								</div>
							</div>

							<div class="col-12 col-sm-12">
								<label>Question Type<span class="text-danger">*</span></label>
                                <?php
                                $q_type =explode(',',$editData->question_type);
                                ?>
								<div class="form-group">&nbsp;
									<input type="checkbox" name="question_type[]" id="image_audio_text" value="image audio text" <?php if(in_array('image audio text',$q_type)){echo "checked";} ?>>  Image Audio Text &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="question_type[]" id="touch" value="touch" <?php if(in_array('touch',$q_type)){echo "checked";} ?>> Touch &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="question_type[]" id="true" value="true" <?php if(in_array('true',$q_type)){echo "checked";} ?>> True &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="question_type[]" id="add_question" value="add question" <?php if(in_array('add question',$q_type)){echo "checked";} ?>> Add Question &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="question_type[]" id="remove_question" value="remove question" <?php if(in_array('remove question',$q_type)){echo "checked";} ?>> Remove Question &nbsp;&nbsp;&nbsp;
                                </div>
							</div>

                            <div class="col-12 col-sm-12">
								<label>Answer Type<span class="text-danger">*</span></label>
                                <?php
                                $a_type =explode(',',$editData->answer_type);
                                ?>
								<div class="form-group">&nbsp;
									<input type="checkbox" name="answer_type[]" id="image_audio_text" value="image audio text" <?php if(in_array('image audio text',$a_type)){echo "checked";} ?>>  Image Audio Text &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="answer_type[]" id="touch" value="touch" <?php if(in_array('touch',$a_type)){echo "checked";} ?>> Touch &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="answer_type[]" id="true" value="true" <?php if(in_array('true',$a_type)){echo "checked";} ?>> True &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="answer_type[]" id="add_answer" value="add answer" <?php if(in_array('add answer',$a_type)){echo "checked";} ?>> Add Answer &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="answer_type[]" id="remove_answer" value="remove answer" <?php if(in_array('remove answer',$a_type)){echo "checked";} ?>> Remove Answer &nbsp;&nbsp;&nbsp;
                                </div>
							</div>

                            <div class="col-12 col-sm-12">
								<label>Extras<span class="text-danger">*</span></label>
                                <?php
                                $e_type =explode(',',$editData->extras);
                                ?>
								<div class="form-group">&nbsp;
									<input type="checkbox" name="extras[]" id="add_card" value="add card" <?php if(in_array('add card',$e_type)){echo "checked";} ?>>  Add Card &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="extras[]" id="remove_card" value="remove card" <?php if(in_array('remove card',$e_type)){echo "checked";} ?>> Remove Card &nbsp;&nbsp;&nbsp;
                                </div>
							</div>
							
							<div class="col-12 col-sm-12">
								<label>Explanation<span class="text-danger"></span></label>
								<div class="form-group">&nbsp;
									<input type="checkbox" name="explanation" id="explanation" value="explanation" <?php if($editData->explaination == 'explanation'){echo "checked";} ?>>  
                                </div>
							</div>

							
						<div class="subtopic_field"></div>
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
