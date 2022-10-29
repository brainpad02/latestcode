<section class="section">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4>Subscribe Users</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover" id="table-1" style="width: 100%;">
							<thead>
							<tr>
								<th>User Name</th>
								<th>Standard</th>
								<th>Plan Start Date</th>
								<th>Plan End Date</th>
								<th>Subscription Plans</th>
							</tr>
							</thead>
							<tbody class="sortable">
							<?php foreach($users as $r) { ?>
								<tr id="<?= $r->user_id; ?>">
									<td><?php echo $r->username;?></td>
									<td><?php echo $r->std_name;?></td>
									<td><?php echo $r->start_date;?></td>
									<td><?php echo $r->end_date;?></td>
									<td>
                                        <select name="plan_ids" id="plan_ids_<?php echo $r->user_id;?>" class="form-control" onchange="change_plan(this.value,<?php echo $r->user_id;?>)">
                                            <option value="">Select Plan</option>
                                            <?php
                                            if(!empty($plan_data)){
                                                foreach($plan_data as $plans){
                                                    ?>
                                                    <option value="<?php echo $plans['plan_id'];?>" <?php if($plans['plan_id'] == $r->plan_id){ echo "selected";}?>><?php echo $plans['plan_name'];?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
   function change_plan(val,user_id){
        $.ajax({
			url : base_url+'teachers/subscription/change_plan',
			method: 'POST',
			data:{plan_id:val,user_id:user_id},
			success:function(msg){ 
				location.reload();
			},
		});
   }
</script>