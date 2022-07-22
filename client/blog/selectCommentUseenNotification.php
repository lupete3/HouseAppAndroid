<?php 
 include("fonctions.php");
	
	
	$isSeen = 0;

	$list = array();

	$req = getCommentUnSeenNotification($isSeen);

	while ($res = $req->fetch(PDO::FETCH_OBJ)) {
		
		$list[] = $res;
	}


	echo json_encode($list);	


		          			
?>