<?php 
 include("fonctions.php");
	
	$category_name = $_POST['category_name'];

	$req = getPostByCategory($category_name);
	$result = array();

	while ($res = $req->fetch(PDO::FETCH_OBJ)) {

	$result[] = $res;	

}
echo json_encode($result);
		          			
?>