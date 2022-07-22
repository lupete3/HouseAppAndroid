<?php 
include('config/connexion.php');

	session_start();

	///Etat de la maison
	$etatMaison = 'Innocupee';
	$statutMaison = 'Valide';
	$etatMaisonInnoc = 'Innocupee';

	$statut = '';
//Requette pour afficher le nombre des maisons disponibles prêtes en location
	$req = $bdd->prepare('SELECT COUNT(*) as nb FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ');
	$req->execute(array('etat' => $etatMaison,'statutMaison' => $statutMaison ));
	$resultat = $req->fetch();

//Requette pour enregistrer les locataires
	if (isset($_POST['EnregistrerLoc'])) {
		$nomLoc = $_POST['nomLoc'];
		$prenomLoc = $_POST['prenomLoc'];
		$sexeLoc = $_POST['sexeLoc'];
		$dtLoc = $_POST['dtLoc'];
		$etatCivLoc = $_POST['etatCivLoc'];
		$nationaliteLoc = $_POST['nationaliteLoc'];
		$residenceLoc = $_POST['residenceLoc'];
		$emailLoc = $_POST['emailLoc'];
		$numPieceLoc = $_POST['numPieceLoc'];
		$nvMdp = $_POST['nvMdp'];
		$confMdp = $_POST['confMdp'];
		$telephoneLoc = $_POST['telephoneLoc'];
		$user = 'user.jpg';

		if (empty($nomLoc) AND empty($prenomLoc) AND empty($sexeLoc) AND empty($dtLoc) AND empty($etatCivLoc) AND empty($nationaliteLoc) AND empty($ResidenceLoc) AND empty($emailLoc) AND empty($numPieceLoc) AND empty($nvMdp) AND empty($confMdp) AND empty($telephoneLoc)) {
			$statut = 'Completer toutes les informations';
					echo "<script>alert('$statut')</script>";
					echo '<meta http-equiv = "refresh" content = "0">';
		}else

		if ($nvMdp == $confMdp) {
			$reqRech = $bdd->prepare('SELECT * FROM locataires WHERE NomLoc = :nom AND PrenomLoc = :prenom AND TelephoneLoc = :telephone AND EmailLoc = :email');
			$reqRech->execute(array('nom' => $nomLoc, 'prenom' => $prenomLoc, 'telephone' => $telephoneLoc, 'email' => $emailLoc));
			$resRech = $reqRech->rowCount();
			if ($resRech == 1) {
				$statut = 'Ce locataire existe déjà dans le système';
			}else{
			$reqEnreg = $bdd->prepare('INSERT INTO locataires (NomLoc,PrenomLoc,SexeLoc, DateNaissLoc,EtatCivilLoc,NationaliteLoc,ResidenceLoc,EmailLoc,NumPieceLoc,Password,TelephoneLoc,AvatarLoc) VALUES (:nomLoc,:prenomLoc,:sexeLoc,:dtLoc,:etatCivLoc,:nationaliteLoc,:residenceLoc,:emailLoc,:numPieceLoc,:confMdp,:telephoneLoc,:user)');
			$reqEnreg->execute(array('nomLoc' => $nomLoc , 'prenomLoc' => $prenomLoc, 'sexeLoc' => $sexeLoc, 'dtLoc' => $dtLoc, 'etatCivLoc' => $etatCivLoc, 'nationaliteLoc' => $nationaliteLoc, 'residenceLoc' => $residenceLoc, 'emailLoc' => $emailLoc,'numPieceLoc' => $numPieceLoc, 'confMdp' => $confMdp, 'telephoneLoc' => $telephoneLoc,'user' => $user ));
			if ($reqEnreg) {
				$statut = 'Enregistrement éffectué avec succès !';
					echo "<script>alert('$statut')</script>";
					echo '<meta http-equiv = "refresh" content = "0;index.php">';
			}
			}
		}else{
			$statut = 'Ce deux mot de passe ne correspondent pas !';
					echo "<script>alert('$statut')</script>";
					echo '<meta http-equiv = "refresh" content = "0">';
		}

	}
//Requette pour enregistrer les bailleurs
	if (isset($_POST['EnregistrerBail'])) {
		$nomBail = $_POST['nomBail'];
		$prenomBail = $_POST['prenomBail'];
		$sexeBail = $_POST['sexeBail'];
		$dtBail = $_POST['dtBail'];
		$etatCivBail = $_POST['etatCivBail'];
		$nationaliteBail = $_POST['nationaliteBail'];
		$residenceBail = $_POST['residenceBail'];
		$emailBail = $_POST['emailBail'];
		$numPieceBail = $_POST['numPieceBail'];
		$nvMdp = $_POST['nvMdp'];
		$confMdp = $_POST['confMdp'];
		$telephoneBail = $_POST['telephoneBail'];
		$user = 'user.jpg';

		if (empty($nomBail) AND empty($prenomBail) AND empty($sexeBail) AND empty($dtBail) AND empty($etatCivBail) AND empty($nationaliteBail) AND empty($residenceBail) AND empty($emailBail) AND empty($numPieceBail) AND empty($nvMdp) AND empty($confMdp) AND empty($telephoneBail)) {
			$statut = 'Completer toutes les informations';
					echo "<script>alert('$statut')</script>";
					echo '<meta http-equiv = "refresh" content = "0">';
		}else

		if ($nvMdp == $confMdp) {
			$reqRech = $bdd->prepare('SELECT * FROM bailleurs WHERE NomBail = :nom AND PrenomBail = :prenom AND TelBail = :telephone AND Email = :email');
			$reqRech->execute(array('nom' => $nomBail, 'prenom' => $prenomBail, 'telephone' => $telephoneBail, 'email' => $emailBail));
			$resRech = $reqRech->rowCount();
			if ($resRech == 1) {
				$statut = 'Ce bailleur existe déjà dans le système';
			}else{
			$reqEnreg = $bdd->prepare('INSERT INTO bailleurs (NomBail,PrenomBail,Sexe, DateNaiss,EtatCivil,Nationalite,Residence,Email,NumPieceIdent,Password,TelBail,Avatar) VALUES (:nomBail,:prenomBail,:sexeBail,:dtBail,:etatCivBail,:nationaliteBail,:residenceBail,:emailBail,:numPieceBail,:confMdp,:telephoneBail,:user)');
			$reqEnreg->execute(array('nomBail' => $nomBail , 'prenomBail' => $prenomBail, 'sexeBail' => $sexeBail, 'dtBail' => $dtBail, 'etatCivBail' => $etatCivBail, 'nationaliteBail' => $nationaliteBail, 'residenceBail' => $residenceBail, 'emailBail' => $emailBail,'numPieceBail' => $numPieceBail, 'confMdp' => $confMdp, 'telephoneBail' => $telephoneBail,'user' => $user ));
			if ($reqEnreg) {
				$statut = 'Enregistrement éffectué avec succès !';
					echo "<script>alert('$statut')</script>";
					echo '<meta http-equiv = "refresh" content = "0;index.php">';			}
			}
		}else{
			$statut = 'Ce deux mot de passe ne correspondent pas !';
					echo "<script>alert('$statut')</script>";
					echo '<meta http-equiv = "refresh" content = "0">';
		}

	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link id="callCss" rel="stylesheet" href="themes/bootshop/bootstrap.min.css" media="screen"/>
    <link href="themes/css/base.css" rel="stylesheet" media="screen"/>
<!-- Bootstrap style responsive -->	
	<link href="themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
	<link href="themes/css/font-awesome.css" rel="stylesheet" type="text/css">

<!-- fav and touch icons -->
    <link rel="shortcut icon" href="themes/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="themes/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="themes/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="themes/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="themes/images/ico/apple-touch-icon-57-precomposed.png">
	<style type="text/css" id="enject"></style>
  </head>
<body>
<div id="header">
<div class="container">
<div id="welcomeLine" class="row">
	
</div>
<!-- Navbar ================================================== -->
<div id="logoArea" class="navbar">
<a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>
  <div class="navbar-inner">
    <a class="brand" href="index.php"><img src="themes/images/logo1.png" alt="HousesAllocation" title="HousesAllocation" /></a>
	
    <ul id="topMenu" class="nav pull-right">
	 <li class=""><a href="index.php">Accueil</a></li>
	 <li class=""><a href="contact.php">Contact</a></li>
	 <li class="">
	 <a href="#login1" role="button" data-toggle="modal" style="padding-right:0"><span class="btn btn-medium btn-info">Connexion</span></a>
	 <!-- Bloc de connexion -->
	<div id="login1" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3>Connexion</h3>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal loginFrm" method="POST" action="index.php">
			  <div class="control-group">								
				<input type="email" id="inputEmail" name="email" placeholder="Email" required>
			  </div>
			  <div class="control-group">
				<input type="password" id="inputPassword" name="password" placeholder="Password" required>
			  </div>
			  <div class="control-group">
				<label class="checkbox">
				<input type="checkbox"> Se souvenir de moi
				</label>
			  </div>
			  <div class="control-group">
			  	<input type="submit" name="connexion" class="btn btn-medium btn-info" value="Se Connecter"> 
			  	<button class="btn" data-dismiss="modal" aria-hidden="true">Fermer</button>
			  	<label> Vous n'avez pas un compte ? <a href="register.php">Creer maintenant</a></label>
			  	<?php if (isset($statut)) {
			  		echo '<label style="color:red">'.$statut.'</babel>';
			  	} ?>
			  </div>
			</form>		
		  </div>
	</div>
	</li>
    </ul>
  </div>
</div>
</div>
</div>
<!-- Header End====================================================================== -->
<div id="mainBody">
	<div class="container">
	<div class="row">
<!-- Sidebar ================================================== -->
	<div id="sidebar" class="span3">
		<div class="well well-small"><a id="myCart" href="product_summary.html"><img src="themes/images/ico-cart.png" alt="cart">Maisons disponibles<span class="badge badge-warning pull-right"><?php echo $resultat['nb']; ?></span></a></div>
		<ul id="sideManu" class="nav nav-tabs nav-stacked">
			<li class="subMenu open"><a> IBANDA 
				<?php 

				//Requette pour afficher le nombre des maisons disponibles dans IBANDA
				$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Commune = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
				$req->execute(array('nom'=>'Ibanda','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
				$resultat = $req->fetch();
				echo "[ ".$resultat['nbi']." ]"; 

				?></a>
				<ul>
				<li>
					<a class="active" href="products.html"><i class="icon-chevron-right"></i>Ndendere 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Ndendere
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ');
						$req->execute(array('nom'=>'Ndendere','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Nyalukemba
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Nyalukemba
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
						$req->execute(array('nom'=>'Nyalukemba','etat' => $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?> 
					</a>
				</li>
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Panzi 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Panzi
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
						$req->execute(array('nom'=>'Panzi','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>
				</ul>
			</li>
			<li class="subMenu"><a> KADUTU 
				<?php 

				//Requette pour afficher le nombre des maisons disponibles dans KADUTU
				$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Commune = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ');
				$req->execute(array('nom'=>'Kadutu','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
				$resultat = $req->fetch();
				echo "[ ".$resultat['nbi']." ]"; 

				?> </a>
			<ul style="display:none">
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Cimpunda 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Cimpunda
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
						$req->execute(array('nom'=>'Cimpunda','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Mosala 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Mosala
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
						$req->execute(array('nom'=>'Mosala','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>												
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Kasali 
						<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Kasali
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ');
						$req->execute(array('nom'=>'Kasali','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>	
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Nyamugo 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Nyamugo
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ');
						$req->execute(array('nom'=>'Nyamugo','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?> 
					</a>
				</li>	
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Nkafu 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Nkafu
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ');
						$req->execute(array('nom'=>'Nkafu','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?> 
					</a>
				</li>	
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Kajangu 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Kajangu
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
						$req->execute(array('nom'=>'Kajangu','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?> 
					</a>
				</li>	
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Nyakaliba 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Nyakaliba
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
						$req->execute(array('nom'=>'Nyakaliba','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?> 
					</a>
				</li>
																
			</ul>
			</li>

			<li class="subMenu"><a>BAGIRA 
				<?php 

				//Requette pour afficher le nombre des maisons disponibles dans IBANDA
				$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Commune = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
				$req->execute(array('nom'=>'Bagira','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
				$resultat = $req->fetch();
				echo "[ ".$resultat['nbi']." ]"; 

				?></a>
			<ul style="display:none">
				
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Nyakavogo
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Nyakavogo
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
						$req->execute(array('nom'=>'Nyakavogo','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Lumumba
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Lumumba
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
						$req->execute(array('nom'=>'Lumumba','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Kasha
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Kasha
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM maisons WHERE  maisons.Quartier = :nom AND maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
						$req->execute(array('nom'=>'Kasha','etat'=> $etatMaison, 'statutMaison' => $statutMaison));
						$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>				
			</ul>
			</li>			
		</ul>
		<br/>
		 
			<div class="thumbnail">
				<img src="themes/images/carousel/winphone.png" title="Bootshop New Kindel" alt="Blog Blogspot">
				<div class="caption">
				  <h5 style="color: green;"><a href="www.nossavoirs.blogspot.com">www.nossavoirs.blogspot.com</a></h5>
				</div>
			  </div><br/>
			<div class="thumbnail">
				<img src="themes/images/carousel/payment_methods.png" title="Allocation Houses Payment Methods" alt="Moyen de paiement">
				<div class="caption">
				  <h5>Moyens de payement</h5>
				</div>
			  </div> 
	</div>
<!-- Sidebar end=============================================== -->
	<div class="span9">
	    <ul class="breadcrumb">
			<li><a href="index.php">Accueil</a> <span class="divider">/</span></li>
			<li class="active">Enregistrement</li>
	    </ul>
		<div class="well">
		        <div class="control-group" style="text-align: center;">
				  <div style="margin-top: 5px;" >
				  	<a href="?logLoc" class="btn btn-large btn-primary" >Compte Locataire</a> 
				  	<a href="?logBail" class="btn btn-large btn-info" >Compte Bailleur</a> 

				  	
				  </div>
					
				</div>
				
		</div>
	</div>

<?php 

	if (isset($_GET['logLoc'])) { ?>
		<div class="span9">
			<div class="well">
				<h4 style="text-align: center;">FORMULAIRE LOCATAIRE</h4><br/>
				<form class="form-horizontal" method="PoST" action="" enctype="multipart/form-data" >		
					<div class="control-group">
						<label class="control-label" for="inputFname1">Nom <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="text" id="inputFname1" name="nomLoc" placeholder="Nom" value="" required>
						</div>
					 </div>
					 <div class="control-group">
						<label class="control-label" for="inputLnam">Prenom <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="text" name="prenomLoc" id="inputLnam" placeholder="Prenom" value="" required>
						</div>
					 </div>

				  	<div class="control-group">
						<label class="control-label" for="country">Sexe<sup style="color: red;">*</sup></label>
						<div class="controls">
							<select id="country" name="sexeLoc" required>
								<option value="">-</option>
								<option value="Féminin">Féminin</option>
								<option value="Masculin">Masculin</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input_email">Date de Naissance <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="date" name="dtLoc" id="input_email" placeholder="Date de Naissance" value="" required>
						</div>
				  	</div>
				  	<div class="control-group">
						<label class="control-label" for="country">Etat Civil<sup style="color: red;">*</sup></label>
						<div class="controls">
							<select id="country" name="etatCivLoc" required>
								<option value="">-</option>
								<option value="Marié">Marié</option>
								<option value="Célibataire">Célibataire</option>
								<option value="Veuve">Veuve</option>
								<option value="Veuf">Veuf</option>
							</select>
						</div>
					</div>	
		 
					<div class="control-group">
					<label class="control-label" for="input_email">Nationalité <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="text" name="nationaliteLoc" id="input_email" placeholder="Nationalité" value="" required>
						</div>
				    </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1">Residence <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="text" name="residenceLoc" id="inputPassword1" placeholder="Residence" value="" required>
						</div>
					  </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1">Email <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="email" name="emailLoc" id="inputPassword1" placeholder="Email" value="" required>
						</div>
					  </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1">Numero Pièce Identité <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="text" name="numPieceLoc" id="inputPassword1" placeholder="Numero Pièce Identité" value="" required>
						</div>
					  </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1" >Mot de passe <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="password" name="nvMdp" id="inputPassword1" placeholder="Mot de passe" required>
						</div>
					  </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1"> Confirmer Mot de passe <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="password" name="confMdp" id="inputPassword1" placeholder=" Confirmer Mot de passe" required>
						</div>
					  </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1">Téléphone <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="phone" name="telephoneLoc" id="inputPassword1" placeholder="Téléphone" value="" required>
						</div>
					  </div>	  
					
	
					<div class="control-group">
						<div class="controls">
							<?php if (isset($statut)) {
			  					echo '<label style="color:red">'.$statut.'</babel>';
			  				} ?>
							<br>
							<input class="btn btn-large btn-success" name="EnregistrerLoc" type="submit" value="Enregistrer" />
						</div>
					</div>		
				</form>
			</div>
		</div>

<?php	}elseif (isset($_GET['logBail'])) { ?>
	<div class="span9">
			<div class="well">
				<h4 style="text-align: center;">FORMULAIRE BAILLLEUR</h4><br/>
				<form class="form-horizontal" method="PoST" action="" enctype="multipart/form-data" >		
					<div class="control-group">
						<label class="control-label" for="inputFname1">Nom <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="text" id="inputFname1" name="nomBail" placeholder="Nom" value="" required>
						</div>
					 </div>
					 <div class="control-group">
						<label class="control-label" for="inputLnam">Prenom <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="text" name="prenomBail" id="inputLnam" placeholder="Prenom" value="" required>
						</div>
					 </div>

				  	<div class="control-group">
						<label class="control-label" for="country">Sexe<sup style="color: red;">*</sup></label>
						<div class="controls">
							<select id="country" name="sexeBail" required>
								<option value="">-</option>
								<option value="Féminin">Féminin</option>
								<option value="Masculin">Masculin</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input_email">Date de Naissance <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="date" name="dtBail" id="input_email" placeholder="Date de Naissance" value="" required>
						</div>
				  	</div>
				  	<div class="control-group">
						<label class="control-label" for="country">Etat Civil<sup style="color: red;">*</sup></label>
						<div class="controls">
							<select id="country" name="etatCivBail" required>
								<option value="">-</option>
								<option value="Marié">Marié</option>
								<option value="Célibataire">Célibataire</option>
								<option value="Veuve">Veuve</option>
								<option value="Veuf">Veuf</option>
							</select>
						</div>
					</div>	
		 
					<div class="control-group">
					<label class="control-label" for="input_email">Nationalité <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="text" name="nationaliteBail" id="input_email" placeholder="Nationalité" value="" required>
						</div>
				    </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1">Residence <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="text" name="residenceBail" id="inputPassword1" placeholder="Residence" value="" required>
						</div>
					  </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1">Email <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="email" name="emailBail" id="inputPassword1" placeholder="Email" value="" required>
						</div>
					  </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1">Numero Pièce Identité <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="text" name="numPieceBail" id="inputPassword1" placeholder="Numero Pièce Identité" value="" required>
						</div>
					  </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1" >Mot de passe <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="password" name="nvMdp" id="inputPassword1" placeholder="Mot de passe" required>
						</div>
					  </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1"> Confirmer Mot de passe <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="password" name="confMdp" id="inputPassword1" placeholder=" Confirmer Mot de passe" required>
						</div>
					  </div>	  
					<div class="control-group">
						<label class="control-label" for="inputPassword1">Téléphone <sup style="color: red;">*</sup></label>
						<div class="controls">
						  <input type="phone" name="telephoneBail" id="inputPassword1" placeholder="Téléphone" value="" required>
						</div>
					  </div>	  
					
	
					<div class="control-group">
						<div class="controls">
							<?php if (isset($statut)) {
			  					echo '<label style="color:red">'.$statut.'</babel>';
			  				} ?>
							<br>
							<input class="btn btn-large btn-success" name="EnregistrerBail" type="submit" value="Enregistrer" />
						</div>
					</div>		
				</form>
			</div>
		</div>
<?php }
?>
</div>

</div>
</div>
</div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
	<?php include('include/footer.php'); ?>

	
</body>
</html>