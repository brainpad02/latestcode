<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Teacher Access</h4>
					<div class="card-header-action">
						<a href="<?=base_url('backend/teacher');?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
					</div>
				</div>
				<div class="card-body">
					<?=form_open_multipart($action,array('class' => 'layout-form', 'id' => 'layout-form'));?>
						<div class="row">
							<?php
							if(!empty($accessdata)){
								$access_points = explode(',',$accessdata[0]->access_topics);
							}
							?>
							<input type="hidden" name="id" value="<?php if(!empty($accessdata)){ echo $accessdata[0]->id; }?>">
                            <div class="col-12 col-sm-12">
								<label>Access Module<span class="text-danger">*</span></label>
								<div class="form-group">&nbsp;
									<input type="checkbox" name="access_module[]" id="access_module" value="syllabus" <?php if(!empty($access_points)){ if(in_array('syllabus',$access_points)){echo "checked";} }?>>  Syllabus &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="boards" <?php if(!empty($access_points)){ if(in_array('boards',$access_points)){echo "checked";} }?>>  Board &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="standard" <?php if(!empty($access_points)){ if(in_array('standard',$access_points)){echo "checked";} }?> >  Standard &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="subject" <?php if(!empty($access_points)){ if(in_array('subject',$access_points)){echo "checked";} }?> >  Subjects &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="chapter" <?php if(!empty($access_points)){ if(in_array('chapter',$access_points)){echo "checked";} }?>>  Chapter &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="topics" <?php if(!empty($access_points)){ if(in_array('topics',$access_points)){echo "checked";} }?>>  Topics &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="subtopics" <?php if(!empty($access_points)){ if(in_array('subtopics',$access_points)){echo "checked";} }?>>  Sub Topics &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="plantypes" <?php if(!empty($access_points)){ if(in_array('plantypes',$access_points)){echo "checked";} }?>>  Plan Types &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="plans" <?php if(!empty($access_points)){ if(in_array('plans',$access_points)){echo "checked";} }?>>  Plans &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="subscribers" <?php if(!empty($access_points)){ if(in_array('subscribers',$access_points)){echo "checked";} }?>>  Subscribers &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="category" <?php if(!empty($access_points)){ if(in_array('category',$access_points)){echo "checked";} }?>>  Category &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="layout" <?php if(!empty($access_points)){ if(in_array('layout',$access_points)){echo "checked";} }?>>  Layout &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="school" <?php if(!empty($access_points)){ if(in_array('school',$access_points)){echo "checked";} }?>>  School &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="access_module[]" id="access_module" value="reports" <?php if(!empty($access_points)){ if(in_array('reports',$access_points)){echo "checked";} }?>>  Reports &nbsp;&nbsp;&nbsp;
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
