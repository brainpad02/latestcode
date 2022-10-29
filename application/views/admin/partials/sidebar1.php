
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
			<li class="<?= ($this->uri->segment('2') == 'syllabus') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/syllabus'); ?>"><i class="fas fa-list"></i> <span>Syllabus</span></a></li>
			<!-- <li class="<?= ($this->uri->segment('2') == 'example') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/example'); ?>"><i class="fab fa-etsy"></i> <span>Example</span></a></li> -->
			<li class="<?= ($this->uri->segment('2') == 'board') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/board'); ?>"><i class="fas fa-bold"></i> <span>Boards</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'standard') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/standard'); ?>"><i class="fab fa-stripe-s"></i> <span>Standard</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'subject') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/subject'); ?>"><i class="far fa-file"></i><span>Subjects</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'chapter') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/chapter'); ?>"><i class="fas fa-list"></i><span>Chapter</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'topic') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/topic'); ?>"><i class="fas fa-th-list"></i><span>Topics</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'subtopic') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/subtopic'); ?>"><i class="far fa-square"></i> <span>Sub Topics</span></a></li>

			<li class="menu-header">Subscription Plans</li>
			<li class="<?= ($this->uri->segment('2') == 'plan_type') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/plan_type'); ?>"><i class="fas fa-th-list"></i> <span>Plan Types</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'subscription_plans') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/subscription_plans'); ?>"><i class="fas fa-th-list"></i> <span>Plans</span></a></li>
			<!-- <li class="<?= ($this->uri->segment('2') == 'subscription') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/subscription'); ?>"><i class="fas fa-list"></i> <span>Subscribers</span></a></li> -->

			<li class="menu-header">Extra</li>
			<li class="<?= ($this->uri->segment('2') == 'category') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/category'); ?>"><i class="fas fa-list"></i> <span>Category</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'layout') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/layout'); ?>"><i class="fas fa-list"></i> <span>Layout</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'school') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/school'); ?>"><i class="fas fa-list"></i> <span>School</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'teacher') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/teacher'); ?>"><i class="fas fa-list"></i> <span>Teacher Access</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'reports') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/reports'); ?>"><i class="fas fa-cogs"></i><span>Reports</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'setting') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/setting'); ?>"><i class="fas fa-cogs"></i><span>Setting</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'setting') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/setting'); ?>"><i class="far fa-user"></i></i><span>Profile</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'user') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/user'); ?>"><i class="fas fa-users"></i><span>Users</span></a></li>
			<li class="<?= ($this->uri->segment('2') == 'logout') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('backend/logout'); ?>"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
		</ul>
	</aside>
</div>
