<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Edit Syllabus</h4>
					<div class="card-header-action">
						<a href="<?=base_url('admin/syllabus_list');?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Back</a>
					</div>
				</div>
				<div class="card-body">
					<?=form_open_multipart($action,array('class' => 'subtopics-form', 'id' => 'subtopics-form'));?>
                    <div class="row">
						<div class="col-12 col-sm-4" style="display:none;">
							<label>Language <span class="text-danger">*</span></label>
							<div class="form-group">
								<input type="text" class="form-control" name="lang"  readonly value="<?= $this->crud_model->get_type_name_by_id('languages','symbol',$this->crud_model->getLanguage()); ?>">
							</div>
						</div>
						<div class="col-12 col-sm-4" style="display:none;">
							<label>Board</label>
							<div class="form-group">
								<input type="text" class="form-control"  readonly  value="<?= $this->session->userdata('board_name'); ?>">
								<input type="hidden" name="board_id" value="<?= $this->session->userdata('board'); ?>" id="board_id">
							</div>
						</div>
                        <div class="col-12 col-sm-4">
                            <label>Syllabus Name <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="syllabus_name" value="<?=(!empty($editData)?$editData[0]->syllabus_name:'')?>">
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Syllabus Description</label>
                            <div class="form-group">
                                <textarea name="syllabus_desc" class="form-control" id="syllabus_desc" cols="30" rows="10"><?=(!empty($editData)?$editData[0]->syllabus_description:'')?></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label><br/></label>
                            <div class="form-group">
                                <a href="javascript:;" id="syllabusBtn" class="btn btn-success" name="add"><i class="fa fa-plus"></i> Add More</a>
                            </div>
                        </div>
					</div>
                    <input type="hidden" id="total_count" value="<?php echo count($details_data);?>">
                    <?php
                        if(!empty($details_data)){ $i=0;
                            foreach($details_data as $details){ $i++;
                            ?>
                            <div class="row" id="tprow<?php echo $i; ?>">
                                <input type="hidden" name="detail_id[]" id="detail_id_<?php echo $i;?>" value="<?php echo $details->syllabus_detail_id;?>">
                                <div class="col-12 col-sm-3">
                                    <label>Standard</label>
                                    <div class="form-group">
                                        <select class="form-control select2 std_list"  name="std_id[]" id="std_list_<?php echo $i; ?>" onchange="getSubject_syllabus(this.value,<?php echo $i; ?>)">
                                            <option value="">Select Standard</option>
                                            <?php
                                            foreach($standard as $std){
                                            ?>
                                            <option value="<?php echo $std->std_id;?>" <?php if($std->std_id == $details->standard_id){ echo "selected";}?>><?php echo $std->std_name;?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <label>Subject</label>
                                    <div class="form-group">
                                        <select class="form-control select2"  name="sub_id[]" id="sub_list_<?php echo $i; ?>" onchange="changeSubject_syllabus(this.value,<?php echo $i; ?>)">
                                            <option value="">Select Subject</option>
                                            <?php
                                            foreach($subject as $sub){
                                                if($sub->std_id == $details->standard_id){
                                                    ?>
                                                    <option value="<?php echo $sub->sub_id;?>" <?php if($sub->sub_id == $details->subject_id){ echo "selected";}?>><?php echo $sub->sub_name;?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <label>Chapter</label>
                                    <div class="form-group">
                                        <select class="form-control select2"  name="chapter[]" id="chapter_list_<?php echo $i; ?>" onchange="getTopics(this.value)">
                                            <option value="">Select Chapter</option>
                                            <?php
                                            foreach($chapter as $ch){
                                                if($ch->subject_id == $details->subject_id){
                                                    ?>
                                                    <option value="<?php echo $ch->ch_id;?>" <?php if($ch->ch_id == $details->chapter_id){ echo "selected";}?>><?php echo $ch->chapter_text;?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <label></label>
                                    <div class="form-group">
                                        <a href="javascript:;" id="<?php echo $i; ?>" class="btn btn-danger removeBtn" name="remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                        }
                    ?>
                    

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
