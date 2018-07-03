
<?php include('functions.php') ?>
<html>
<link rel="stylesheet" href="style.css">
<head>
	<title>Registration system PHP and MySQL</title>
</head>
<body>
<div class="header1">
	<h2>Register</h2>
</div>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form1" >
<?php echo display_error(); ?>
	<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" >
	</div>
	<div class="input-group">
		<label>Email</label>
		<input type="email" name="email"  >
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password_1">
	</div>
	<div class="input-group">
		<label>Confirm password</label>
		<input type="password" name="password_2">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="register_btn">Register</button>
	</div>
	<p>
		Already a member? <a href="login.php">Sign in</a>
	</p>
</form>
</body>
</html>