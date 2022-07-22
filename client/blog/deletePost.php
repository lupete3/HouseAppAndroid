<?php 
 include("fonctions.php");
	
	$id = $_POST['id'];

	$reqF = getPostById($id);
	$res = $reqF->fetch(PDO::FETCH_OBJ);
	if($res->image){
		unlink('uploads/'.$res->image);
	}

	$req = deletePost($id);
	$result = array();

	if ($req){

		echo json_encode('SUCCESS');

	}else{

		echo json_encode('ERROR');
	}
		          			
?>