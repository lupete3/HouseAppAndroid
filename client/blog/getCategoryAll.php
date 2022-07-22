<?php 
 include("fonctions.php");
						
	$req = getCategory();
	$result = array();

	while ($res = $req->fetch(PDO::FETCH_OBJ)) {

	$result[] = $res;	

}
echo json_encode($result);
		          			
?>