<?php 
 include("function/fonctions.php");

 	$idM = $_POST['id_maison'];
						
	$req = getAllMaisonById($idM);
	$result = array();

	while ($res = $req->fetch(PDO::FETCH_OBJ)) {

	$result[] = $res;	

}
echo json_encode($result);
		          			
?>