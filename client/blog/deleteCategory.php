<?php 
 include("fonctions.php");
	
	$id = $_POST['id'];

	$req = deleteCategory($id);
	$result = array();

	if ($req){

		echo json_encode('SUCCESS');

	}else{

		echo json_encode('ERROR');
	}
		          			
?>