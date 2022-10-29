<?php foreach($data as $key => $r) { ?>
    <tr id="<?= $r['ch_id'] ?>">
        <td><i class="fas fa-align-justify"></i></td>
        <td><input type="checkbox" name="row-check" value="<?= $r['ch_id'] ?>"></td>
        <td><?=$r['bd_name'];?></td>
        <td><?=$r['std_name'];?></td>
        <td><?=$r['sub_name'];?></td>
        <td><?=$r['chapter_text'];?></td>
        <td><img src="<?=base_url($r['chapter_img']);?>" width="45px"></td>
        <td><?= $r['se'];?></td>
        <td>
        <?= (($r['chapter_status'])==1) ? '<a href="'.base_url().'backend/chapter/status/'.$r['ch_id'].'/'.$r['chapter_status'].'" class="btn btn-success">Active</a>'
                : '<a href="'.base_url().'backend/chapter/status/'.$r['ch_id'].'/'.$r['chapter_status'].'" class="btn btn-danger">DeActive</a>'
            ?>
        </td>
        <td>
            <a class="btn btn-sm btn-outline-primary" href="<?=base_url('backend/chapter/edit/'.$r['ch_id']);?>"><i class="fa fa-edit"></i></a>
            <button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('backend/chapter/remove/'.$r['ch_id']);?>"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
<?php } ?>