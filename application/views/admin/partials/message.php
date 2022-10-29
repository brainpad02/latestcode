 <?php if ($this->session->flashdata('succ')) { ?>
    <script>
        swal({
            title: 'Success!',
            icon: 'success',
            text: "<?=$this->session->flashdata('succ')?>",
            timer: 3000,
        });
    </script>
 <?php }
    if ($this->session->flashdata('err')) { ?>
        <script>
            swal({
                title: 'Opps!',
                icon: 'error',
                text: "<?=$this->session->flashdata('err')?>",
                timer: 3000,
            });
        </script>
 <?php } ?>