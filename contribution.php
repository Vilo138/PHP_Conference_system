<?php
include_once "index_top.php";
// Initialize form variables
$title = '';
$first_name = '';
$last_name = '';
$email = '';
$abstract = '';
$section = '';
$type = '';
$section_id = '';

$ok = isset($_SESSION['contribution_ok']) ? $_SESSION['contribution_ok'] : false;
$error = isset($_SESSION['contribution_error']) ? $_SESSION['contribution_error'] : false;
if($ok)
{
	echo showBox($ok, 'success');
	unset($_SESSION['contribution_ok']);
}
elseif($error)
{
	echo showBox($error, 'danger');
	unset($_SESSION['contribution_error']);
}



$ok = isset($_SESSION['email_ok']) ? $_SESSION['email_ok'] : false;
$error = isset($_SESSION['email_error']) ? $_SESSION['email_error'] : false;
if($ok)
{
	echo showBox($ok, 'success');
	unset($_SESSION['email_ok']);
}
elseif($error)
{
	echo showBox($error, 'danger');
	unset($_SESSION['email_error']);
}
	
$id=0;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Získanie dát z formulára
    //print_r($_POST);exit;
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    /*
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email']: '';
    */
    $abstract = isset($_POST['abstract']) ? $_POST['abstract'] : '';
    $section_id = isset($_POST['section_id']) ? intval($_POST['section_id']) : '';
    $presentation_id = isset($_POST['presentation_id']) ? intval($_POST['presentation_id']) : '';
    $user_id = $_SESSION['auth_id'];


    // Príprava SQL dotazu na vloženie dát
    
    $sql = "INSERT INTO contribution (title, abstract, section_id, presentation_id, user_id )
        VALUES (?, ?, ?, ?, ? )";


    // Príprava a vykonanie dotazu
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $title, $abstract, $section_id, $presentation_id, $user_id );

    if ($stmt->execute()) 
    {
        $_SESSION['contribution_ok']='You have successfully registered your Contribution into the Conference system.';
    } else 
    {
        $_SESSION['contribution_error']= 'Incorrect credentials.' . $stmt->error;
    }
    
        $contribution_id = $conn->insert_id;
        for($i = 0; $i < count($_POST['first_name']); $i++) {
        $first_name = $_POST['first_name'][$i];
        $last_name = $_POST['last_name'][$i];
        $email = $_POST['email'][$i];
        if($first_name && $last_name && $email)
        {
            $sql = "INSERT INTO author (first_name, last_name, email, contribution_id)
            VALUES (?, ?, ?, ? )";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $first_name, $last_name, $email, $contribution_id );
            $stmt->execute();
        }
    }
    // Zatvorenie spojenia
    $stmt->close();
    $conn->close();
    header('Location: mail.php?id='.$user_id);
    
}
?>
    

    <h1>Register</h1>
    <form action="" method="post" class="form-horizontal">
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Title of the contribution</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="title" name="title" value="<?php echo $title;?>" required>
		</div>
	</div>
    <?php
    for($i = 1; $i <= 5; $i++) {
        ?>
        <div class="form-group">
            <label for="first_name" class="col-sm-2 control-label">First name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="first_name" name="first_name[]" value="<?php echo $first_name;?>" <?php if($i==1) echo 'required';?>>
            </div>
        </div>
        <div class="form-group">
            <label for="last_name" class="col-sm-2 control-label">Last name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="last_name" name="last_name[]" value="<?php echo $last_name;?>" <?php if($i==1) echo 'required';?>>
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" id="email" name="email[]" value="<?php echo $email;?>" <?php if($i==1) echo 'required';?>>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="form-group">
        <label for="abstract" class="col-sm-2 control-label">Abstract</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="abstract" name="abstract" value="<?php echo $abstract;?>" required>
        </div>
    </div>
    <div class="form-group">
		<label for="section_id">Section</label>
		<select class="form-control" id="section_id" name="section_id" value="<?php echo $section_id;?>" required>
			<?php
			$sql = "SELECT * FROM section";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) 
            {
				while ($row = mysqli_fetch_assoc($result)) 
                {
					echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
				}
			} 
			?>
		</select>
	</div>
    <div class="form-group">
		<label for="presentation_id">Type of presentation</label>
		<select class="form-control" id="presentation_id" name="presentation_id" value="<?php echo $type;?>" required>
			<?php
			$sql = "SELECT * FROM presentation";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) 
            {
				while ($row = mysqli_fetch_assoc($result)) 
                {
					echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
				}
			} 
			?>
		</select>
	</div>
    
   
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info">Register</button>
	</div>
</form>

<?php
include_once "index_bottom.php";


