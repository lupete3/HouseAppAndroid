<?php
	include('config/connexion.php');

	session_start();

	if (isset($_SESSION['idAdmin'])) {
		# on recupere l'id de l'admin
		$idAdmin = $_SESSION['idAdmin'];

		///Etat de la maison
		$etatMaison = 'Innocupee';
		$statutMaison = 'Valide';

		$reqNb = $bdd->prepare('SELECT COUNT(*) as nbLoc FROM locataires');
		$reqNb->execute();
		$resNb = $reqNb->fetch();

		//Requette pour afficher le nombre des maisons disponibles
		$req = $bdd->prepare('SELECT COUNT(*) as nb FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
		$req->execute(array('etat' => $etatMaison, 'statutMaison' => $statutMaison));
		$resultat = $req->fetch();

?>


<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Gestion des locataires</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Placide">
	
<!-- Bootstrap style --> 
    <link id="callCss" rel="stylesheet" href="themes/bootshop/bootstrap.min.css" media="screen"/>
    <link href="themes/css/base.css" rel="stylesheet" media="screen"/>
<!-- Bootstrap style responsive -->	
	<link href="themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
	<link href="themes/css/font-awesome.css" rel="stylesheet" type="text/css">
<!-- Google-code-prettify -->	
	<link href="themes/js/google-code-prettify/prettify.css" rel="stylesheet"/>
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
    <a class="brand" href="espace_admin.php"><img src="themes/images/logo1.png" alt="HousesAllocation" title="HousesAllocation" /></a>
		
    <ul id="topMenu" class="nav pull-right">
	 <li class=""><a href="espace_admin.php">Accueil</a></li>
	 <li class=""><a href="contact.html">Contact</a></li>
	 <li class="">
	  <a href="config/deconnexion.php"  style="padding-right:0"><span class="btn btn-medium btn-info">Deconnexion</span></a>
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
		<div class="well well-small"><a id="myCart" href="product_summary.html"><i style="margin-left: 10px;" class="icon-user"></i>Nombre Locataires<span class="badge badge-info pull-right"><?php echo $resNb['nbLoc'];?></span></a></div>
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
		<li><a href="espace_admin.php">Espace_Adminstrateur</a> <span class="divider">/</span></li>
		<li><a href="gLocataires.php">Gestion Locataires</a> <span class="divider">/</span></li>
		<li class="active"> Gestion Locataires</li>
    </ul>
	
<div id="grids">

<!-- ============================================================================================================== -->
<!-- =================== Bloc suppression du locataire ============================================================= -->
<!-- ============================================================================================================== -->
<div class="tab-content">
	<?php if (isset($_GET['action'])=='supp') { 

		$reqt = $bdd->prepare('SELECT * FROM locataires WHERE  IdLoc = :idLoc');
	        $reqt->execute(array('idLoc' => $_GET['idLoc']));
	        $result = $reqt->fetch();
	        $idLoc = $result['IdLoc'];
	        if ($result) {
	        	
	        	# requette pour supprimer un agent
	        	if (isset($_POST['suppLocataire'])) {

	        		$id = $idLoc;
	        		$req = $bdd->prepare('DELETE FROM locataires WHERE IdLoc = :idLoc');
		        		$req->execute(array('idLoc' => $id ));
			        	if ($req) {
			        		header('Location:gLocataires.php');
			        		echo "<meta http-equiv='refresh' content'0;URL=gLocataires.php'>";
			        	}else{
			        		$statu = 'Erreur de suppression';
			        	}	        	
	        		/*
		        	$reqExist = $bdd->prepare('SELECT * FROM locataires,maisons,reservations, WHERE locataires.IdLoc = reservations.IdLoc AND resevations.IdMaison = maisons.IdM AND locataires.IdLoc = :idLoc');
		        	$reqExist->execute(array('idLoc' => $_GET['idLoc']));
		        	$resExist = $reqExist->rowCount();
		        	if ($resExist == 0) {
		        		$statut = '';
		        		
		        	}else{
						$req = $bdd->prepare('DELETE FROM locataires WHERE IdLoc = :idLoc');
		        		$req->execute(array('idLoc' => $_GET['idLoc'] ));
			        	if ($req) {
			        		header('Location:gLocataires.php');
			        		echo "<meta http-equiv='refresh' content'0;URL=gLocataires.php'>";
			        	}else{
			        		
			        	}	        	
			        } */
	        	}
	        }
		?>
		
		<div id="login" class="modal  fade in"  role="dialog" aria-labelledby="login" aria-hidden="false" >
		  <div class="modal-header">
			<a href="gLocataires.php" class="close"><span >x</span><meta http-equiv='refresh' content'0;URL=gLocataires.php'></a>
			<h3>Supprimer Locataires du systeme </h3>
		  </div>
		  <div class="modal-body" style="text-align: center;">
			<form class="form-vertical loginFrm" method="POST" action="" >
				<p><?php if (isset($statut)) {
					echo '<div class="alert alert-block alert-error fade in">';
				    echo '<a href = "gLocataires.php" class="close" >×</a>';
				    echo '<strong>Impossible de supprimer ce locataire. il ya une maison en cours de réservation';
					echo '</div>';
		        	echo "<meta http-equiv='refresh' content'0;URL=gLocataires.php'>";
				}elseif (isset($statu)) {
					echo $statu;
				} ?></p>
			  <h4> Voulez-vous vraiment supprimer <h4 style="color: blue;"><?php echo $result['NomLoc'].' ?'; ?></h4> </h4>
			  	<table align="center">
				  <tr class="gallery">
				  	<td colspan="2">
				  		<span >
				  			<a href="themes/images/avatar_loc/<?php echo $result['AvatarLoc']; ?>"><img width="200" style="border-radius: 200px;" src="themes/images/avatar_loc/<?php echo $result['AvatarLoc']; ?>" alt=""/>
				  			</a>
				  		</span>
				  	</td>
				  </tr>
				  

				  <tr><td>
				  	<div class="control-group">	
				  	<input type="submit" id="inputEmail" class="btn btn-success" value="Oui" name="suppLocataire">
				  	<a href="gLocataires.php" id="inputEmail" class="btn btn-default"><span >Non</span><meta http-equiv='refresh' content'0;URL=gLocataires.php'></a> 
				  	<?php if (isset($statut)){
				  		echo '<a href="?idLocMod='.$result['IdLoc'].'" id="inputEmail" class="btn btn-info"><span >Modifier</span></a>';
				  	}?>
				  </div></td>

				 </tr>	
				</table>		
			</form>		

		  </div>
	</div>

<!-- ============================================================================================================== -->
<!-- =================== Bloc modification du locataire ============================================================= -->
<!-- ============================================================================================================== -->

	<?php }elseif(isset($_GET['idLocMod'])){ 

		$idBail = $_GET['idLocMod'];
		//Requette pour recuperer num bailleur
			$reqt = $bdd->prepare('SELECT * FROM locataires WHERE  IdLoc = :idLoc');
	        $reqt->execute(array('idLoc' => $idBail));
	        $result = $reqt->fetch();
	        $idLoc = $result['IdLoc'];
	        if ($result) {
	        	
	        	if (isset($_POST['modifier'])) {
	        		$reqMod = $bdd->prepare('UPDATE locataires SET 
				        NomLoc = :nomLoc, 
				        PrenomLoc = :prenomLoc,
				        SexeLoc = :sexeLoc,
				        DateNaissLoc = :dtLoc,
				        EtatCivilLoc = :etatCivilLoc,
				        NationaliteLoc = :nationaliteLoc,
				        ResidenceLoc = :residenceLoc,
				        EmailLoc = :emailLoc,
				        NumPieceLoc = :numPieceLoc,
				        TelephoneLoc = :telephoneLoc, 
				        AvatarLoc = :avatarLoc 
				        	WHERE IdLoc = :idLoc');

				    $reqMod->execute(array(
				        'nomLoc' => $_POST['nom'],
				        'prenomLoc' => $_POST['prenom'],
				        'sexeLoc' => $_POST['sexe'],
				        'dtLoc' => $_POST['dtNaiss'],
				        'etatCivilLoc' => $_POST['etatCiv'],
				        'nationaliteLoc' => $_POST['nationalite'],
				        'residenceLoc' => $_POST['residence'],
				        'emailLoc' => $_POST['email'],
				        'numPieceLoc' => $_POST['numPiece'],
				        'telephoneLoc' => $_POST['telephone'],
				        'avatarLoc' => 'user.jpg',
				        'idLoc' => $idLoc
				    ));
				    if ($reqMod) {
				        	$statut = 'Ok';
				        }else{
				        	$statutErr;
				        }
	        	}
	        }
		?>
		<!-- =========================================== -->
		<div class="row-fluid">
			<div class="span12">
		      <!-- Message a afficher apres modofication -->	
				<div class="well">
					<h3 style="text-align: center">Modifier <?php echo $result['NomLoc'];?></h3><br/>
					<?php if (isset($statut)) {
						echo '<div class="alert alert-block alert-success fade in">';
					    echo '<a href = "gLocataires.php" class="close" >×</a>';
					    echo '<strong>Modification réussie avec succès ';
						echo '</div>';
			        	echo "<meta http-equiv='refresh' content'0;URL=gLocataires.php'>";
					}elseif (isset($statutErr)) {
						echo '<div class="alert alert-block alert-error fade in">';
					    echo '<a href = "gLocataires.php" class="close" >×</a>';
					    echo '<strong>Echec lors de la modification ';
						echo '</div>';
			        	echo "<meta http-equiv='refresh' content'0;URL=gLocataires.php'>";
					} ?>
					<table align="center">
						<tr>
							<td>
								<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">		
									<div class="control-group">
										<label class="control-label" for="inputFname1">Nom <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="nom" placeholder="Date Creation" value="<?php echo utf8_encode($result['NomLoc']); ?>" required>
										</div>
									 </div>		
									 		
									<div class="control-group">
										<label class="control-label" for="inputFname1">Prénom <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="prenom" placeholder="Date Creation" value="<?php echo utf8_encode($result['PrenomLoc']); ?>" required>
										</div>
									 </div>		
									 		
									<div class="control-group">
										<label class="control-label" for="inputFname1">Sexe <sup style="color: red;">*</sup></label>
										<div class="controls">
											<select class="input-xlarge" id="inputEmail" name="sexe">
												<option value="Féminin">Féminin</option>
												<option value="Masculin">Masculin</option>
											</select>
										</div>
									 </div>		
									 		
									<div class="control-group">
										<label class="control-label" for="inputFname1">Date de Naissance <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="date" id="inputEmail" class="input-xlarge" name="dtNaiss" placeholder="Date Naissance" value="<?php $result['DateNaissLoc']; ?>" required>
										</div>
									 </div> 		
									<div class="control-group">
										<label class="control-label" for="inputFname1">Etat Civil <sup style="color: red;">*</sup></label>
										<div class="controls">
											<select class="input-xlarge" id="inputEmail" name="etatCiv">
												<option value="<?php echo utf8_encode($result['EtatCivilLoc']); ?>"><?php echo utf8_encode($result['EtatCivilLoc']); ?></option>
												<option value="Célibataire">Célibataire</option>
												<option value="Marié">Marié</option>
												<option value="Veuf">Veuf</option>
												<option value="Veuf">Veuve</option>
											</select>
										</div>
									 </div>		
									<div class="control-group">
										<label class="control-label" for="inputPassword1">Nationalité <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="nationalite" placeholder="Nationalité " value="<?php echo $result['NationaliteLoc']; ?>" required>
										</div>
									  </div>		
									<div class="control-group">
										<label class="control-label" for="inputPassword1">Résidence <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="residence" placeholder="Résidence " value="<?php echo utf8_encode($result['ResidenceLoc']); ?>" required>
										</div>
									  </div>			
									<div class="control-group">
										<label class="control-label" for="inputPassword1">Email <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="email" placeholder="Email " value="<?php echo $result['EmailLoc']; ?>" required>
										</div>
									  </div>			
									<div class="control-group">
										<label class="control-label" for="inputPassword1">N° Pièce identité <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="numPiece" placeholder="Résidence " value="<?php echo $result['NumPieceLoc']; ?>" required>
										</div>
									  </div>				
									<div class="control-group">
										<label class="control-label" for="inputPassword1">N° Téléphone <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="telephone" placeholder="Résidence " value="<?php echo $result['TelephoneLoc']; ?>" required>
										</div>
									  </div>				
										<div class="control-group" style="text-align: center;">
											<input class="btn btn-large btn-info" type="submit" name="modifier" value="Modifier" />
										</div>
									</div>		
								</form>
							</td><td>
							<td >
								<span  style="margin-left: 20px;"><a href="themes/images/avatar_loc/<?php echo $result['AvatarLoc']; ?>">
				  				<img width="200" src="themes/images/avatar_loc/<?php echo $result['AvatarLoc']; ?>" alt=""/></a>
				  			</span>
				  		    </td>
				  		</tr>  
				  	</table>
				</div>
	 	    </div>

<!-- ============================================================================================================== -->
<!-- =================== Bloc pour afficher les locataires qui sont dans le systeme ================================ -->
<!-- ============================================================================================================== -->
	<?php }else{ ?>
  <div class="tab-pane active" id="one">
  
<?php } ?>
  

<!-- DataTables Example -->
        <div class="card mb-3">
          
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                   <tr class="breadcrumb">
		            	<th>Avatar </th>
		                <th>Nom</th>
		                <th>Prenom</th>
		                <th>Sexe</th>
						<th>Date de Naissance</th>
		                <th>Etat Civil</th>
		                <th>Nationalité</th>
		                <th>Residence</th>
		                <th>Email</th>
		                <th>N° Carte</th>
		                <th>Téléphone</th>
		                <th>Modifier</th>
		                <th>Supprimer</th>
		               
                  </tr>
                </thead>
                
                <tbody>
                  <?php

            		$reqAgent = $bdd->prepare("SELECT IdLoc, NomLoc, PrenomLoc, SexeLoc,  date_format(DateNaissLoc, '%d/%m/%Y') AS dtNaiss, EtatCivilLoc, NationaliteLoc , ResidenceLoc, EmailLoc, NumPieceLoc, TelephoneLoc, AvatarLoc  FROM locataires");
            		$reqAgent->execute();
            		while ($resAdmin = $reqAgent->fetch()) { ?>
            <tr>
                <td > <a href="themes/images/avatar_loc/<?php echo $resAdmin['AvatarLoc']; ?>"><img style="width:100%" src="themes/images/avatar_loc/<?php echo $resAdmin['AvatarLoc']; ?>" alt=""/></a></td>
                <td><?php echo $resAdmin['NomLoc']; ?></td>
                <td><?php echo $resAdmin['PrenomLoc']; ?></td>
                <td><?php echo $resAdmin['SexeLoc']; ?></td>
                <td><?php echo $resAdmin['dtNaiss']; ?></td>
                <td><?php echo utf8_encode($resAdmin['EtatCivilLoc']); ?></td>
                <td><?php echo $resAdmin['NationaliteLoc']; ?></td>
                <td><?php echo $resAdmin['ResidenceLoc']; ?></td>
                <td><?php echo $resAdmin['EmailLoc']; ?></td>
                <td><?php echo $resAdmin['NumPieceLoc']; ?></td>
                <td><?php echo $resAdmin['TelephoneLoc']; ?></td>
                <td><a href="?idLocMod=<?php echo $resAdmin['IdLoc']; ?>"  style="padding-right:0"><span class="btn btn-medium btn-info pull-right">Modifier</span></a></td>
                <td><a href="?action=supp&idLoc=<?php echo $resAdmin['IdLoc']; ?>"  style="padding-right:0"><span class="btn btn-medium btn-danger pull-right">Supprimer</span></a></td>
                
   			</tr> 
   		<?php } ?>
            
            
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Mise à jours le <?php echo date('d-m-y');?> </div>
          
        </div>
     
      </div>


</div>
</div>	

</div>
</div></div> 
</div>
<!-- Footer ================================================================== -->

<?php include('include/footer.php'); ?>
 
  <!-- Page level plugin JavaScript-->
  <script src="tb/vendor/datatables/jquery.dataTables.js"></script>

  <!-- Demo scripts for this page-->
  <script src="tb/js/demo/datatables-demo.js"></script>
</body>
</html>
<?php 
	}else{
	header('Location:index.php');
	}
?>