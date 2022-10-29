<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<title><?= $title ?></title>

	<!-- General CSS Files -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>"/>
	<link rel="stylesheet" href="<?= base_url('assets/css/components.css'); ?>"/>
	<link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>"/>

	<!-- General JS Scripts -->
	<script src="<?= base_url('assets/js/jquery-3.3.1.min.js');?>" crossorigin="anonymous"></script>
	<script src="<?= base_url('assets/js/popper.min.js');?>" crossorigin="anonymous"></script>
	<script src="<?= base_url('assets/js/bootstrap.min.js');?>" crossorigin="anonymous"></script>
	<script src="<?= base_url('assets/js/scripts.js'); ?>"></script>
</head>
<body>
<div id="app">
	<section class="section">
		<div class="container mt-5">
			<div class="row">
				<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
					<div class="login-brand">
						<img src="<?= base_url(); ?>assets/img/logo.png" alt="logo" width="50" class="shadow-light rounded-circle"> BrainPad Wave
					</div>

					<div class="card card-primary">
						<div class="card-header"><h4>Login</h4></div>

						<div class="card-body">
							<form method="POST" action="<?= $action ?? '#' ?>" class="needs-validation" novalidate="">
								<div class="form-group">
									<label for="email">Username</label>
									<input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
									<div class="invalid-feedback">
										Please fill in your username
									</div>
								</div>

								<div class="form-group">
									<div class="d-block">
										<label for="password" class="control-label">Password</label>
									</div>
									<input id="password" type="password" class="form-control" name="password" tabindex="2" required>
									<div class="invalid-feedback">
										please fill in your password
									</div>
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
										Login
									</button>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>



<!-- JS Libraies -->

<!-- Template JS File -->

<script src="<?= base_url('assets/js/custom.js'); ?>"></script>

<!-- Page Specific JS File -->
</body>
</html>
