<?php 
 include("function/fonctions.php");
						
	 	
	$prenom = $_POST['prenom'];
	$nom = $_POST['nom'];
	$telephone = $_POST['telephone'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$sexe = $_POST['sexe'];


	$req = addLocataire($prenom,$nom,$telephone,$email,$password,$sexe);
	$result = array();

	if ($req == 1){

		//echo json_encode('SUCCESS');

		$req = getUserAfterSignUp($nom,$telephone);
		$userData = array();

		$res = $req->fetch(PDO::FETCH_OBJ);

		$result[] = $res;

		echo json_encode($result);

	}else if ($req == -1) {

		echo json_encode('ERROR');
	}
		          			
?>