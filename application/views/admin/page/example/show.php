<div class="table-responsive">
	<table class="table table-striped table-hover">
		<tr>
			<th>Board </th>
			<td>:</td>
			<td><?= $e['bd_name']; ?></td>

			<th>Standard</th>
			<td>:</td>
			<td><?=  $e['std_name'];?></td>
		</tr>
		<tr>
			<th>Subject </th>
			<td>:</td>
			<td><?= $e['sub_name']; ?></td>

			<th>Topic</th>
			<td>:</td>
			<td><?= $e['topic_text']; ?></td>
		</tr>

		<tr>
			<th>Sub Topic</th>
			<td>:</td>
			<td><?= $e['subtopic_text']; ?> </td>

			<th>Category</th>
			<td>:</td>
			<td><?= $e['c_name']; ?></td>
		</tr>

		<tr>
			<th>Animation</th>
			<td>:</td>
			<td><?= $e['anim_name']. '('.$e['anim_description'].')'; ?>	</td>

			<th>Layout</th>
			<td>:</td>
			<td><?= $e['lay_name']. '('.$e['lay_description'].')'; ?></td>
		</tr>

		<tr>
			<th>Example Name</th>
			<td>:</td>
			<td><?php
					echo $e['ex_title'];
				?>
			</td>

			<th>Example Instruction</th>
			<td>:</td>
			<td><?php
					echo $e['ex_heading'];
				?>
			</td>
		</tr>
		<tr>
			<th>Audio</th>
			<td>:</td>
			<td><?php
					echo  '<audio controls><source src="'.base_url($e['ex_audio']).'"></audio>';
				?>
			</td>
		</tr>
	</table>
	<hr>
	<h6 class="text-primary mb-2">Question & Answer Detail</h6>
	<table class="table table-striped ">
		<?php
		$exampleDataArray = $this->crud_model->get_example_data($e['ex_id']);
		if (!empty($exampleDataArray)) {
			foreach($exampleDataArray as $key => $ed) { ?>
				<thead>
				<tr>
					<th colspan="3" class=" text-primary"> Question/Answer - <?= $key + 1 ?></th>
				</tr>
				</thead>
				<tr>
					<th>Question Image/Text</th>
					<th>Question True Audio</th>
					<th>Question Touch Audio</th>
				</tr>

				<?php
				$get_question_data = $this->crud_model->get_question_data($ed->ed_id);
				if (!empty($get_question_data)) {
					foreach ($get_question_data as $key1 => $qiData) {
						?>
						<tr>
							<td>
								<?php if(!empty($qiData['eqd_img'])){ ?>
									<img src="<?php echo base_url().$qiData['eqd_img']; ?>" height="35px" width="35px" alt="">
								<?php }
								if(!empty($qiData['eqd_text'])){
									echo $qiData['eqd_text'];
								} ?>
							</td>
							<td>
								<?php if(!empty($qiData['eqd_audio'])){ ?>
									<audio controls>
										<source src="<?= base_url() . $qiData['eqd_audio'] ?>">
									</audio>
								<?php } ?>
							</td>
							<td>
								<?php if(!empty($qiData['eqd_touch_audio'])){ ?>
									<audio controls>
										<source src="<?= base_url() . $qiData['eqd_touch_audio'] ?>">
									</audio>
								<?php } ?>
							</td>
						</tr>
					<?php }
				} ?>

				<tr>
					<th>Answer Image/Text</th>
					<th>Answer True Audio</th>
					<th>Answer Touch Audio</th>
				</tr>
				<?php
				$get_answer_data = $this->crud_model->get_answer_data($ed->ed_id);
				if (!empty($get_answer_data)) {
					foreach ($get_answer_data as  $aiData) {
						?>
						<tr>
							<td>
								<?php if(!empty($aiData['ead_img'])){ ?>
									<img src="<?php echo base_url().$aiData['ead_img']; ?>" height="35px" width="35px" alt="">
								<?php }
								if(!empty($aiData['ead_text'])){
									echo $aiData['ead_text'];
								} ?>
							</td>
							<td>
								<?php if(!empty($aiData['ead_audio'])){ ?>
									<audio controls>
										<source src="<?= base_url() . $aiData['ead_audio'] ?>">
									</audio>
								<?php } ?>
							</td>
							<td>
								<?php if(!empty($aiData['ead_touch_audio'])){ ?>
									<audio controls>
										<source src="<?= base_url() . $aiData['ead_touch_audio'] ?>">
									</audio>
								<?php } ?>
							</td>
						</tr>
					<?php }
				} ?>
				<?php
			}
		} ?>
	</table>
</div>
