<!-- <div class="navbar-bg"></div> -->

<nav class="navbar navbar-expand-lg main-navbar">
<a href="#" data-toggle="sidebar" class="nav-link nav-link-lg" style="color:#6777ef;"><i class="fas fa-bars"></i></a>
	<!-- <form class="form-inline mr-auto">
		<ul class="navbar-nav mr-3">
			<li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
			<li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
		</ul>
	</form> -->
	<!-- <ul class="navbar-nav navbar-right">
		<li class="dropdown dropdown-list-toggle">
			<a href="<?= base_url('backend/setting#language') ?>" class="nav-link nav-link-lg pt-2">
			<b>	<?= $this->crud_model->get_type_name_by_id('languages','symbol',$this->crud_model->getLanguage()); ?> </b>
			</a>
		</li>
		<li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
				<img alt="image" src="<?=base_url('assets/img/avatar-1.png'); ?>" class="rounded-circle mr-1">
				<div class="d-sm-none d-lg-inline-block">Hi,<?= $this->session->userdata('brain_sess')['name'] ?></div></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="<?= base_url('backend/logout'); ?>" class="dropdown-item has-icon">
					<i class="far fa-user"></i> Profile
				</a>
				<a href="<?= base_url('backend/logout'); ?>" class="dropdown-item has-icon">
					<i class="fas fa-cog"></i> Settings
				</a>
				<div class="dropdown-divider"></div>
				<a href="<?= base_url('backend/logout'); ?>" class="dropdown-item has-icon text-danger">
					<i class="fas fa-sign-out-alt"></i> Logout
				</a>
			</div>
		</li>
	</ul> -->
</nav>
