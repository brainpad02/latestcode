
<div class="main-sidebar">
	<aside id="sidebar-wrapper">
		<div class="sidebar-brand">
			<a href="<?= base_url('backend/dashboard'); ?>">
				<img alt="image"  width="40" src="<?= base_url(); ?>assets/img/logo.png" class="header-logo img-fluid"/> <span class="logo-name">Brainpad Wave</span></a>
		</div>
		<div class="sidebar-brand sidebar-brand-sm">
			<a href="<?= base_url('backend/dashboard'); ?>">BV</a>
		</div>
		<div style="font-size: 12px;
    padding: 15px;
    margin: 1px;
    margin-bottom: -10%;
    margin-top: -5%;">
			<p style="margin: 0px;">Language : <b><?= $this->crud_model->get_type_name_by_id('languages','symbol',$this->crud_model->getLanguage()); ?></p></b>
			<p>Board : <b><?= $this->session->userdata('board_name'); ?></p></b>
		</div>
		<ul class="sidebar-menu">
			<li class="menu-header">Main</li>
			<li class="<?= ($this->uri->segment('2') == 'dashboard') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/dashboard'); ?>"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'user') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/user'); ?>"><i class="fas fa-users"></i><span>Users</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'user') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/user'); ?>"><i class="fas fa-users"></i><span>Subscription Plans</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'logout') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/logout'); ?>"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
		</ul>
	</aside>
</div>
