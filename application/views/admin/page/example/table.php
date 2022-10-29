<table class="table table-striped table-hover" id="item-list" style="width: 100%;">
	<thead>
	<tr>
		<th>Chapter</th>
		<th>Topic</th>
		<th>Sub Topic</th>
		<th>Example Mapped</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<?php if (!empty($data)) {
		foreach ($data as $d) { ?>
			<tr>
				<td><?= $d['chapter'] ?? '-' ?></td>
				<td><?= $d['topic'] ?? '-' ?></td>
				<td><?= $d['subtopic'] ?? '-' ?></td>
				<td><?= $d['total'] ?></td>
				<td>
					<a class="btn btn-sm btn-outline-info"  href="<?=base_url('backend/example/view?'.$d['ids']);?>" target="_blank"> View</a>&nbsp;
					<a class="btn btn-sm btn-outline-primary"  href="<?=base_url('backend/example/create?'.$d['ids']);?>" target="_blank"> Add</a>&nbsp;
				</td>
			</tr>
		<?php }
	} ?>
	</tbody>
</table>
