<?php 
 include("fonctions.php");
	
	
	$isSeen = 0;

	$req = getCommentNotification($isSeen);

	$res = $req->fetch(PDO::FETCH_OBJ);
	
	$tot = $res->totCommentNonSeen;


	echo json_encode($tot);	


		          			
?>