<?php 
 include("fonctions.php");
	
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$phone = $_POST['phone'];
	$statut = 'user';

	$req = addUser($name,$username,$password,$phone,$statut);
	$result = array();

	if ($req == 1){

		//echo json_encode('SUCCESS');

		$req = getUserAfterSignUp($name);
		$userData = array();

		$res = $req->fetch(PDO::FETCH_OBJ);

		$result[] = $res;

		echo json_encode($result);

	}else if ($req == -1) {

		echo json_encode('ERROR');
	}
		          			
?>