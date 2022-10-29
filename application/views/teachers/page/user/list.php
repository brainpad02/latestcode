<link rel="stylesheet" href="<?= base_url('assets/bundles/datatables/datatables.min.css'); ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css'); ?>"/>
<script src="<?= base_url('assets/bundles/datatables/datatables.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/datatables.js'); ?>"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<table class="table table-bordered" id="table-1" style="width: 100%;">
<thead>
    <tr>
<th>User Name</th>
<?php
if(!empty($subtopics)){
    foreach($subtopics as $sub){
    ?>
    <th><?php echo $sub->sequence;?></th>
    <?php
    }
    ?>
    </tr>
</thead>
    <tbody>
    <?php
    if(!empty($user_list)){
        foreach($user_list as $key=>$users){ 
            if(!empty($users[$key])){

            
        ?>
        <tr>
            <td><?php echo $users[$key]->username;?></td>
            <?php
            foreach($subtopics as $sb){
                if($sb->stp_id == $users[$key]->subtopic_id){
                ?><td>Crown:<?php echo $users[$key]->crown;?>,Star:<?php echo $users[$key]->star;?>,Time:<?php echo $users[$key]->time;?></td><?php
                }
            }
            ?>
        </tr>
        <?php
            }
        }
    }
    ?>
    </tbody>
    <?php
}
?>
</table>
