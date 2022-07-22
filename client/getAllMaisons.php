<?php 
 include("function/fonctions.php");
						
	$req = getAllMaison();
	$result = array();

	while ($res = $req->fetch(PDO::FETCH_OBJ)) {

	$result[] = $res;	

}
echo json_encode($result);
		          			
?>