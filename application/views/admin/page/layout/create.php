<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Create Layout</h4>
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
                                                <option value="<?= $cat['c_id'];?>"><?= $cat['c_name'];?></option>
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
									<input type="text" class="form-control" name="lay_name" id="lay_name" required placeholder="Enter Layout Name">
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<label>Layout Description<span class="text-danger">*</span></label>
								<div class="form-group">
									<textarea name="lay_description" id="lay_description" cols="30" rows="10" class="form-control">Add Description here..</textarea>
								</div>
							</div>

							<div class="col-12 col-sm-12">
								<label>Question Type<span class="text-danger">*</span></label>
								<div class="form-group">&nbsp;
									<input type="checkbox" name="question_type[]" id="image_audio_text" value="image audio text">  Image Audio Text &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="question_type[]" id="touch" value="touch"> Touch &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="question_type[]" id="true" value="true"> True &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="question_type[]" id="add_question" value="add question"> Add Question &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="question_type[]" id="remove_question" value="remove question"> Remove Question &nbsp;&nbsp;&nbsp;
                                </div>
							</div>

                            <div class="col-12 col-sm-12">
								<label>Answer Type<span class="text-danger">*</span></label>
								<div class="form-group">&nbsp;
									<input type="checkbox" name="answer_type[]" id="image_audio_text" value="image audio text">  Image Audio Text &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="answer_type[]" id="touch" value="touch"> Touch &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="answer_type[]" id="true" value="true"> True &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="answer_type[]" id="add_answer" value="add answer"> Add Answer &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="answer_type[]" id="remove_answer" value="remove answer"> Remove Answer &nbsp;&nbsp;&nbsp;
                                </div>
							</div>

                            <div class="col-12 col-sm-12">
								<label>Extras<span class="text-danger">*</span></label>
								<div class="form-group">&nbsp;
									<input type="checkbox" name="extras[]" id="add_card" value="add card">  Add Card &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="extras[]" id="remove_card" value="remove card"> Remove Card &nbsp;&nbsp;&nbsp;
                                </div>
							</div>

							<div class="col-12 col-sm-12">
								<label>Explanation<span class="text-danger"></span></label>
								<div class="form-group">&nbsp;
									<input type="checkbox" name="explanation" id="explanation" value="explanation">  
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
