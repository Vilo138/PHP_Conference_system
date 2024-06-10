<?php
include_once "index_top.php";
?>

<h1>Prihlásenie do systému</h1>

<form action="index.php" method="post" class="form-horizontal">
	<div class="form-group">
		<label for="email" class="col-sm-2 control-label">Email</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="email" name="email" value="" required>
		</div>
	</div>
	<div class="form-group">
		<label for="password" class="col-sm-2 control-label">Password</label>
		<div class="col-sm-6">
			<input type="password" class="form-control" id="password" name="password" value="" required>
		</div>
	</div>	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-info">Login</button>
		</div>
	</div>
</form>

<?php
include_once "index_bottom.php";