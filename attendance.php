<?php
include_once "index_top.php";
include_once "inc/config.php";
// Initialize form variables
$street = '';
$post_code = '';
$city = '';
$country = '';
$registration_fee = '';
$DIC = null;
$ICO = null;
$phone = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Získanie dát z formulára
    $street = isset($_POST['street']) ? $_POST['street'] : '';
    $post_code = isset($_POST['post_code']) ? $_POST['post_code'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $registration_fee = isset($_POST['registration_fee']) ? $_POST['registration_fee'] : '';
    $DIC = isset($_POST['DIC']) ? $_POST['DIC'] : '';
    $ICO = isset($_POST['ICO']) ? $_POST['ICO'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $user_id = $_SESSION['auth_id'];


    // Príprava SQL dotazu na vloženie dát
    
    $sql = "INSERT INTO registration (street, post_code, city, country, reg_fee_id, DIC, ICO, phone, user_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";


    // Príprava a vykonanie dotazu
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $street, $post_code, $city, $country, $registration_fee, $DIC, $ICO, $phone, $user_id);

    if ($stmt->execute()) 
    {
        echo showBox('You have successfully registered into the Conference system.', 'success');
        $_SESSION['form_submitted'] = true;
    } else 
    {
        echo showBox('Incorrect login credentials.', 'danger') . $stmt->error;
    }

    // Zatvorenie spojenia
    $stmt->close();
    $conn->close();
    
    if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']) {
        echo '<a href="attendance_pdf.php" class="btn btn-info btn-sm" id="pdfButton">PDF</a>';
    }
}
?>
    <a href="attendance_pdf.php" class="btn btn-info btn-sm" id="pdfButton" style="display: none;">PDF</a>

    <h1>Register</h1>
    <form action="" method="post" class="form-horizontal">
	<input type="hidden" name="id" value="<?php echo $id;?>">
	<div class="form-group">
		<label for="street" class="col-sm-2 control-label">Street</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="street" name="street" value="<?php echo $street;?>" required>
		</div>
	</div>
	<div class="form-group">
		<label for="post_code" class="col-sm-2 control-label">Post code</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="post_code" name="post_code" value="<?php echo $post_code;?>" required>
		</div>
	</div>
    <div class="form-group">
		<label for="city" class="col-sm-2 control-label">City</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="city" name="city" value="<?php echo $city;?>" required>
		</div>
	</div>
    <div class="form-group">
        <label for="country" class="col-sm-2 control-label">Country</label>
        <div class="col-sm-6">
            <input type="country" class="form-control" id="country" name="country" value="<?php echo $country;?>" required>
        </div>
    </div>
    
    <div class="form-group">
		<label for="registration_fee">Registration fee</label>
		<select class="form-control" id="registration_fee" name="registration_fee" value="<?php echo $registration_fee;?>" required>
			<?php
			$sql = "SELECT * FROM reg_fee";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) 
            {
				while ($row = mysqli_fetch_assoc($result)) 
                {
                    echo "<option value='" . $row['id'] . "'>" . $row['role_of_user'] .  "</option>";
				}
			} 
			?>
		</select>
	</div>
    <div class="form-group">
        <label for="DIC" class="col-sm-2 control-label">DIC</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="DIC" name="DIC" value="<?php echo $DIC;?>" >
        </div>
    </div>
    <div class="form-group">
        <label for="ICO" class="col-sm-2 control-label">ICO</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="ICO" name="ICO" value="<?php echo $ICO;?>" >
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
			<button type="submit" class="btn btn-info" id="registerButton" onclick="showPdfButton()">Register</button>
		</div>
	</div>
    
</form>
<?php



include_once "index_bottom.php";


