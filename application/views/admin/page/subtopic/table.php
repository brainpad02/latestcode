<?php foreach($data as $r) { ?>
<tr id="<?= $r['stp_id'] ?>" class="odd ui-sortable-handle">
    <td><input type="checkbox" name="row-check" value="<?= $r['stp_id'] ?>"></td>
    <td><?=$r['std_name'];?></td>
    <td><?=$r['subject_id'];?></td>
    <td><?=$r['chapter'];?></td>
    <td><?=$r['topic'];?></td>
    <td><?=$r['subtopic'];?></td>
    <td><img src="<?=base_url($r['image']);?>" width="45px"></td>
    <td><a href="<?=base_url('backend/example/view?'.$r['ids']);?>"><?= $r['no_example'];?></a></td>
    <td><?= $r['sequence']?></td>
    <td  style="width: 12%;">
        <a class="btn btn-sm btn-outline-primary" href="<?=base_url('backend/subtopic/edit/'.$r['stp_id']);?>"><i class="fa fa-edit"></i></a>
        <!-- <button class="btn btn-sm btn-outline-primary" data--toggle="edit" data--url="<?=base_url('backend/subtopic/edit/'.$r['stp_id']);?>"><i class="fa fa-edit"></i></button> -->
        <button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('backend/subtopic/remove/'.$r['stp_id']);?>"><i class="fa fa-trash"></i></button>
        <button class="btn btn-sm btn-outline-info" data--toggle="copy" data--url="<?=base_url('backend/subtopic/copy/'.$r['stp_id']);?>"><i class="fa fa-copy"></i></button>
    </td>
    <td>
        <?= (($r['status'])==1) ? '<a href="'.base_url().'backend/subtopic/status/'.$r['stp_id'].'/'.$r['status'].'" class="btn btn-success">Active</a>'
            : '<a href="'.base_url().'backend/subtopic/status/'.$r['stp_id'].'/'.$r['status'].'" class="btn btn-danger">DeActive</a>'
        ?>
    </td>
</tr>
<?php } ?>