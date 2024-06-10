<?php
// Funkcia na kontrolu pred pouzitim v SQL dotaze
function checkDBInput($in, $entities = 0)
{
	// $in - lubovolna vstupna hodnota
	// $entities:
	// 0/nic: odstrani HTML znacky,  
	// 1: nahradi HTML znacky za entity,
	// 2: validuje na integer,
	// 3: validuje na desatinne cislo
	global $conn;

	// Odstrani "prazdne znaky" pred a za 
	$in = trim($in);

	if($entities == 1)
		$in = strip_tags($in);
	elseif($entities == 2)
		$in = intval($in);
	elseif($entities == 3)
		$in = (float) str_replace(',', '.', $in);
	else
		$in = htmlspecialchars($in);

	return mysqli_real_escape_string($conn, $in);
}

// Funkcia na zobrazenie textoveho boxu
function showBox($text, $type = 'warning', $close = 1)
{
	$out = '<div class="alert alert-' . $type . ' fade in alert-dismissable">' . PHP_EOL;
	if($close)
		$out .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . PHP_EOL;
	$out .= $text;
	$out .= '</div>' . PHP_EOL;
	
	return $out;
}

// Funkcia na zistenie role
function getPosition($id)
{
	global $conn;
	$sql = "SELECT position_id FROM users WHERE id = $id";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if(isset($row['position_id']) && $row['position_id'])
	{
		return $row['position_id'];
	}
	else
	{
		return false;
	}
}