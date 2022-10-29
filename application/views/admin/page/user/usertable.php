<table class="table table-striped table-hover" id="save-stage" style="width:100%;">
        <thead>
        <tr>
            <th>UserId</th>
            <th>SchoolId</th>
            <th>UserCode</th>
            <th>UserName</th>
            <th>Subscription Type</th>
            <th>Subscription Plan</th>
            <th>Registerd Date</th>
            <th>Lic Exp Date</th>
            <th>Phone no.</th>
            <th>Email</th>
            <th>Total App Usage</th>
            <th>Status</th>
            <!-- <th>Action</th> -->
        </tr>
        </thead>
        <tbody id="table">
        <?php foreach($data as $r) { ?>
            <tr>
                <td><?= $r['user_id'];?></td>
                <td><?php echo $r['school_id']?></td>
                <td><?php echo $r['usercode'];?></td>
                <td><?=$r['username'];?></td>
                <td><?php echo $r['type_name'];?></td>
                <td><?php echo $r['plan_name']?></td>
                <td><?php echo $r['created_on'];?></td>
                <td><?php echo $r['expiry_date'];?></td>
                <td><?=$r['phone_no'];?></td>
                <td><?=$r['email_id'];?></td>
                <td><?php echo $r['time'];?></td>
                <td><?=(($r['status'])==1)?'<a href="javascript:;" class="btn btn-success">Active</a>':'<a href="javascript:;" class="btn btn-danger">Deactive</a>'?></td>
                <!-- <td></td> -->
            </tr>
        <?php } ?>
        </tbody>
    </table>