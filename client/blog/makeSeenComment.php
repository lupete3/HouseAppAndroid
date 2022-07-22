<?php 
 include("fonctions.php");
	
	$id = $_POST['id'];
	$isSeen = 1;

	$req = editSeenCategory($isSeen,$id);

	if ($req){

		echo json_encode('SUCCESS');

	}else{

		echo json_encode('ERROR');
	}
		          			
?>