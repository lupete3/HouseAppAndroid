<?php 
 include("fonctions.php");
	
	$user_email = 'deo';
	$post_id = 19;

	
	//$user_email = $_POST['user_email'];
	//$post_id = $_POST['post_id'];

	$req = getSelectLike($user_email,$post_id);

	$res = $req->fetch(PDO::FETCH_OBJ);
	$tot = $res->totLike;

	if ($tot == 1) {

		echo json_encode("ONE");

	}else{

		echo json_encode("ZERO");
	}	


		          			
?>