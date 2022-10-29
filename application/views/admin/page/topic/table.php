<?php foreach($data as $key => $r) { ?>
    <tr id="<?= $r['tp_id'] ?>">
        <!-- <td><i class="fas fa-align-justify"></i></td> -->
        <td><input type="checkbox" name="row-check" value="<?= $r['tp_id'] ?>"></td>
        <td><?=$r['bd_name'] ?></td>
        <td><?=$r['std_name'];?></td>
        <td><?=$r['sub_name'];?></td>
        <td><?=$r['chapter_text'];?></td>
        <td><?=$r['topic_text'];?></td>
        <td><img src="<?=base_url($r['topic_img']);?>" width="45px"></td>
        <td><?= $r['se'];?></td>
        <td>
            <?= (($r['topic_status'])==1) ? '<a href="'.base_url().'backend/topic/status/'.$r['tp_id'].'/'.$r['topic_status'].'" class="btn btn-success">Active</a>'
                : '<a href="'.base_url().'backend/topic/status/'.$r['tp_id'].'/'.$r['topic_status'].'" class="btn btn-danger">DeActive</a>'
            ?>
        </td>
        <td>
            <a class="btn btn-sm btn-outline-primary" href="<?=base_url('backend/topic/edit/'.$r['tp_id']);?>"><i class="fa fa-edit"></i></a>
            <!-- <button class="btn btn-sm btn-outline-primary" data--toggle="edit" data--url="<?=base_url('backend/topic/edit/'.$r['tp_id']);?>"><i class="fa fa-edit"></i></button> -->
            <button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('backend/topic/remove/'.$r['tp_id']);?>"><i class="fa fa-trash"></i></button>
            <button class="btn btn-sm btn-outline-info" data--toggle="copy" data--url="<?=base_url('backend/topic/copy/'.$r['tp_id']);?>"><i class="fa fa-copy"></i></button>
        </td>
    </tr>
<?php } ?>