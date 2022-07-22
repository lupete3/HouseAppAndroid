<?php 
 include("fonctions.php");
						
	$title = $_POST['title'];
	
	$req = getPostSearch($title);
	$result = array();

	while ($res = $req->fetch(PDO::FETCH_OBJ)) {

	$result[] = $res;	

}
echo json_encode($result);
		          			
?>