<?php 
 include("fonctions.php");
	
	$name = $_POST['name'];
	$current_date = date("d-m-Y");

	$req = addCategory($name,$current_date);
	$result = array();

	if ($req == 1){

		echo json_encode('SUCCESS');

	}else if ($req == -1) {

		echo json_encode('ERROR');
	}
		          			
?>