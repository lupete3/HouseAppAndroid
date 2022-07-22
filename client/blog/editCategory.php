<?php 
 include("fonctions.php");
	
	$id = $_POST['id'];
	$name = $_POST['name'];
	$current_date = date('d-m-Y');

	$req = editCategory($name,$current_date,$id);
	$result = array();

	if ($req){

		echo json_encode('SUCCESS');

	}else{

		echo json_encode('ERROR');
	}
		          			
?>