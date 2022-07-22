<?php 
	include("fonctions.php");
	
	$username = $_POST['username'];
	$password = $_POST['password'];

	$req = userExist($username,$password);
	$result = array();

	$res = $req->fetch(PDO::FETCH_OBJ);

	if ($res) {

		$result[] = $res;
		echo json_encode($result);

	}else{

		echo json_encode('ERROR');

	}
		          			
?>