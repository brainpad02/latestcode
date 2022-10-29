<?php foreach($data as $key => $r) { ?>
    <tr id="<?= $r['sub_id'] ?>">
        <td><i class="fas fa-align-justify"></i></td>
        <td><input type="checkbox" name="row-check" value="<?= $r['sub_id'] ?>"></td>
        <td><?= $r['bd_name'] ?></td>
        <td><?= $r['std_name'] ?></td>
        <td><?= $r['sub_name'];?></td>
        <td><img src="<?=base_url($r['sub_img_path']);?>" width="40"></td>
        <td><?= $r['se'];?></td>
        <td>
        <?= (($r['sub_status'])==1) ? '<a href="'.base_url().'backend/subject/status/'.$r['sub_id'].'/'.$r['sub_status'].'" class="btn btn-success">Active</a>'
                : '<a href="'.base_url().'backend/subject/status/'.$r['sub_id'].'/'.$r['sub_status'].'" class="btn btn-danger">DeActive</a>'
            ?>
        </td>
        <td>
            <a class="btn btn-sm btn-outline-primary" href="<?=base_url('backend/subject/edit/'.$r['sub_id']);?>"><i class="fa fa-edit"></i></a>
            <button class="btn btn-sm btn-outline-danger" data--toggle="delete" data--url="<?=base_url('backend/subject/remove/'.$r['sub_id']);?>"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
<?php } ?>