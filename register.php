<?php
include_once "index_top.php";
include_once "inc/config.php";
// Initialize form variables
$first_name = '';
$last_name = '';
$email = '';
$password = '';
$institution = '';
$institution_street = '';
$institution_postal_code = '';
$institution_city = '';
$institution_country = '';
$phone = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Získanie dát z formulára
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? md5($_POST['password']) : '';
    $institution = isset($_POST['institution']) ? $_POST['institution'] : '';
    $institution_street = isset($_POST['institution_street']) ? $_POST['institution_street'] : '';
    $institution_postal_code = isset($_POST['institution_postal_code']) ? intval($_POST['institution_postal_code']): '';
    $institution_city = isset($_POST['institution_city']) ? $_POST['institution_city'] : '';
    $institution_country = isset($_POST['institution_country']) ? $_POST['institution_country'] : '';
    $phone = isset($_POST['phone']) ? intval($_POST['phone']) : null;


    // Príprava SQL dotazu na vloženie dát
    $sql = "INSERT INTO users (first_name, last_name, email, password, institution, institution_street, institution_postal_code, institution_city, institution_country, phone)
            VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?)";

    // Príprava a vykonanie dotazu
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $first_name, $last_name, $email, $password, $institution, $institution_street, $institution_postal_code, $institution_city, $institution_country,$phone);

    if ($stmt->execute()) {
        echo showBox('You have successfully registered into the Conference system.', 'success');
    } else {
        echo showBox('Incorrect login credentials.', 'danger') . $stmt->error;
    }

    // Zatvorenie spojenia
    $stmt->close();
    $conn->close();
}
?>
    

    <h1>Register</h1>
    <form action="" method="post" class="form-horizontal">
	<input type="hidden" name="id" value="<?php echo $id;?>">
	<div class="form-group">
		<label for="first_name" class="col-sm-2 control-label">Name</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name;?>" required>
		</div>
	</div>
	<div class="form-group">
		<label for="last_name" class="col-sm-2 control-label">Last Name</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name;?>" required>
		</div>
	</div>
    <div class="form-group">
		<label for="email" class="col-sm-2 control-label">Email</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="email" name="email" value="<?php echo $email;?>" required>
		</div>
	</div>
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-6">
            <input type="password" class="form-control" id="password" name="password" value="<?php echo $password;?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="institution" class="col-sm-2 control-label">Institution</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="institution" name="institution" value="<?php echo $institution;?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="institution_street" class="col-sm-2 control-label">Institution Street</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="institution_street" name="institution_street" value="<?php echo $institution_street;?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="institution_postal_code" class="col-sm-2 control-label">Institution Postal Code</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="institution_postal_code" name="institution_postal_code" value="<?php echo $institution_postal_code;?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="institution_city" class="col-sm-2 control-label">Institution City</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="institution_city" name="institution_city" value="<?php echo $institution_city;?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="institution_country" class="col-sm-2 control-label">Institution Country</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="institution_country" name="institution_country" value="<?php echo $institution_country;?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="phone" class="col-sm-2 control-label">Phone</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone;?>">
        </div>
    </div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-info">Register</button>
		</div>
	</div>
</form>

<?php
include_once "index_bottom.php";


