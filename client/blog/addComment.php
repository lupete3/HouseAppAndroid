<?php 
 include("fonctions.php");
	
	$comment = $_POST['comment'];
	$user_email = $_POST['user_email'];
	$post_id = $_POST['post_id'];
	$curDate = date('d-m-Y');

	$req = addComment($comment,$user_email,$post_id,$curDate);

	if ($req == 1){

		echo json_encode('SUCCESS');

	}else if ($req == -1) {

		echo json_encode('ERROR');
	}
		          			
?>