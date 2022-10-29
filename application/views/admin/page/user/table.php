<table class="table table-striped table-hover" id="save-stage" style="width:100%;">
        <thead>
        <tr>
            <th>School Logo</th>
            <th>Name</th>
            <th>School Code</th>
            <th>Free Licence</th>
            <th>Paid Licence</th>
            <th>Total Registred Students</th>
            <th>Total Registred Teacher</th>
            <th>Total Free Students</th>
            <th>Total Paid Students</th>
            <th>Total Free Teachers</th>
            <th>Total Paid Teachers</th>
            <th>Phone no.</th>
            <th>City</th>
            <th>State</th>
            <th>Zipcode</th>
            <th>Branch Code</th>
            <th>AppLink</th>
            <th>PaymentLink</th>
            <th>Acdemic expirey date</th>
            <th>Student Plans</th>
            <th>Teacher Plans</th>
            <th>Language</th>
            <th>Board</th>
            <th>Standard</th>
        </tr>
        </thead>
        <tbody id="table">
        <?php 
        if(!empty($data)){
            foreach($data as $r) { ?>
                <tr>
                    <td><img src="<?=base_url($r['school_logo']);?>" alt="" style="width:50px;"></td>
                    <td><?=$r['school_name'];?></td>
                    <td><?php echo $r['school_code'];?></td>
                    <td><?php echo $r['free_licence'];?></td>
                    <td><?=$r['paid_licence'];?></td>
                    <td><?=$r['registerd_students'];?></td>
                    <td><?php echo $r['registerd_teachers'];?></td>
                    <td><?php echo $r['total_free_students']?></td>
                    <td><?php echo $r['total_paid_students']?></td>
                    <td><?php echo $r['total_free_teachers']?></td>
                    <td><?php echo $r['total_paid_teachers']?></td>
                    <td><?php echo $r['phoneno'];?></td>
                    <td><?php echo $r['city'];?></td>
                    <td><?php echo $r['state'];?></td>
                    <td><?php echo $r['zipcode'];?></td>
                    <td><?php echo $r['branch_code'];?></td>
                    <td><?php echo $r['applink'];?></td>
                    <td><?php echo $r['paymentlink'];?></td>
                    <td><?php echo $r['expiry_date'];?></td>
                    <td><?php echo $r['student_plan'];?></td>
                    <td><?php echo $r['teacher_plan'];?></td>
                    <td><?php echo $r['language'];?></td>
                    <td><?php echo $r['board'];?></td>
                    <td><?php echo $r['standard'];?></td>
                    
                </tr>
            <?php }
        } else {
            ?><tr><td colspan="8">Users Not Found</td>
                </tr><?php
        }
         ?>
        </tbody>
    </table>