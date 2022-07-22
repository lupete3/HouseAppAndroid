<?php 
 include("fonctions.php");
	
	
	$user_email = $_POST['user_email'];
	$post_id = $_POST['post_id'];
	$curDate = date('d/m/Y');

	$req = getSelectLike($user_email,$post_id);

	$res = $req->fetch(PDO::FETCH_OBJ);
	$tot = $res->totLike;
	$id = $res->id;

	if ($tot == 1) {

		$req = getPostById($post_id);
		$res = $req->fetch(PDO::FETCH_OBJ);
		$allLike = $res->total_like;
		$newTotLike = $allLike - 1;

		$reqUpdate = editPostTotLike($newTotLike,$post_id);
		$reqdelete = deleteFromPostLike($id);

	}else{

		$req = getPostById($post_id);
		$res = $req->fetch(PDO::FETCH_OBJ);
		$allLike = $res->total_like;
		$newTotLike = $allLike + 1;
		$isLike = 1;
		
		$reqdelete = addPostLike($user_email,$post_id,$isLike,$curDate);
		$reqUpdate = editPostTotLike($newTotLike,$post_id);
	}	


		          			
?>