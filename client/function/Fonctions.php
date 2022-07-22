<?php
    require_once "config/config.php";

    function userExist($nom,$telephone){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM locataires WHERE NomLoc = ? AND TelephoneLoc = ? ");
	  $req->execute(array($nom,$telephone));

	  return $req;
	}

	function addLocataire($prenom,$nom,$telephone,$email,$password,$sexe){
		$bdd = connect();

		$test = userExist($username,$password);
		$res = $test->fetch(PDO::FETCH_ASSOC);
		if ($res > 0) {
			return -1;
		}else

		$req = $bdd->prepare("INSERT INTO locataires (PrenomLoc,NomLoc,TelephoneLoc,EmailLoc,Password,SexeLoc) VALUES (?,?,?,?,?,?) ");
		$req->execute(array($prenom,$nom,$telephone,$email,$password,$sexe));

		return 1;
	}


    function getUserAfterSignUp($nom,$telephone){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM locataires WHERE NomLoc = ? AND TelephoneLoc = ?");
	  $req->execute(array($nom,$telephone));

	  return $req;
	}

    function getAllMaison(){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM maisons ORDER BY idM DESC ");
	  $req->execute();

	  return $req;
	}

    function getAllMaisonById($idM){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM maisons WHERE idM = ? ");
	  $req->execute(array($idM));

	  return $req;
	}

    function getPhotosByMaison($idM){
	  $bdd=connect();

	  $req = $bdd->prepare("SELECT * FROM maisons, galeries WHERE galeries.IdMaison = maisons.IdM AND galeries.IdMaison = ? ORDER BY IdIm DESC ");
	  $req->execute(array($idM));

	  return $req;
	}

