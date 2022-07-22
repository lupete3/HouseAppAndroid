<?php
	include('config/connexion.php');

	session_start();

	if (isset($_SESSION['idAdmin'])) {
		# on recupere l'id de l'admin
		$idAdmin = $_SESSION['idAdmin'];

		///Etat de la maison
		$etatMaison = 'Innocupee';
		$statutMaison = 'Valide';

		$reqNb = $bdd->prepare('SELECT COUNT(*) as nbBail FROM bailleurs');
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
    <title>Gestion des agents</title>
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
	 <li class=""><a href="gBailleurs.php">Accueil</a></li>
	 <li class=""><a href="gMaisons.php">Maisons</a></li>
	 <li class=""><a href="contact.php">Contact</a></li>
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
		<div class="well well-small"><a id="myCart" href="product_summary.html"><i style="margin-left: 10px;" class="icon-user"></i>Bailleurs disponibles<span class="badge badge-info pull-right"><?php echo $resNb['nbBail'];?></span></a></div>
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
		<li class="active"> Gestion Bailleurs</li>
    </ul>
	
<div id="grids">

<!-- ============================================================================================================== -->
<!-- =================== Bloc suppression du bailleur ============================================================= -->
<!-- ============================================================================================================== -->
<div class="tab-content">
	<?php if (isset($_GET['action'])=='supp') { 

		$reqt = $bdd->prepare('SELECT * FROM bailleurs WHERE  IdBail = :idBail');
	        $reqt->execute(array('idBail' => $_GET['idBail']));
	        $result = $reqt->fetch();
	        $idBail = $result['IdBail'];
	        if ($result) {
	        	
	        	# requette poursupprimer un agent
	        	if (isset($_POST['suppBailleur'])) {

	        		$req = $bdd->prepare('DELETE FROM bailleurs WHERE IdBail = :idBail');
		        		$req->execute(array('idBail' => $_GET['idBail'] ));
			        	if ($req) {
			        		header('Location:gBailleurs.php');
			        		echo "<meta http-equiv='refresh' content'0;URL=gBailleurs.php'>";
			        	}else{
			        		
			        	}
	        		/*
	        		
		        	$reqExist = $bdd->prepare('SELECT * FROM bailleurs,maisons,reservations, WHERE bailleurs.IdBail = maisons.IdB AND resevations.IdMaison = maisons.IdM AND bailleurs.IdBail = :idBail');
		        	$reqExist->execute(array('idBail' => $_GET['idBail']));
		        	$resExist = $reqExist->rowCount();
		        	if ($resExist == 0) {
		        		$statut = '';
		        		
		        	}else{
						$req = $bdd->prepare('DELETE FROM bailleurs WHERE IdBail = :idBail');
		        		$req->execute(array('idBail' => $_GET['idBail'] ));
			        	if ($req) {
			        		header('Location:gBailleurs.php');
			        		echo "<meta http-equiv='refresh' content'0;URL=gBailleurs.php'>";
			        	}else{
			        		
			        	}	        	
			        } */
	        	}
	        }
		?>
		
		<div id="login" class="  fade in" style="margin-top: 20px; background-color: #f6f6f8;border-radius: 15px;"  role="dialog" aria-labelledby="login" aria-hidden="false" >
		  <div class="modal-header">
			<a href="gBailleurs.php" class="close"><span >x</span><meta http-equiv='refresh' content'0;URL=gBailleurs.php'></a>
		  </div>
		  <div class="modal-body" style="text-align: center;">
			<form class="form-vertical loginFrm" method="POST" action="" >
				<p><?php if (isset($statut)) {
					echo '<div class="alert alert-block alert-error fade in">';
				    echo '<a href = "gBailleurs.php" class="close" >×</a>';
				    echo '<strong>Ce Bailleur a des maisons en cours de réservation. Impossible de le supprimer. Vous ne pouvez que le modifier ';
					echo '</div>';
		        	echo "<meta http-equiv='refresh' content'0;URL=gBailleurs.php'>";
				} ?></p>
			  <h4> Voulez-vous vraiment supprimer <h4 style="color: blue;"><?php echo $result['NomBail'].' ?'; ?></h4> </h4>
			  	<table align="center">
				  <tr class="gallery">
				  	<td colspan="2">
				  		<span >
				  			<a href="themes/images/avatar_bail/<?php echo $result['Avatar']; ?>"><img width="200" style="border-radius: 200px;" src="themes/images/avatar_bail/<?php echo $result['Avatar']; ?>" alt=""/>
				  			</a>
				  		</span>
				  	</td>
				  </tr>
				  

				  <tr><td>
				  	<div class="control-group">	
				  	<input type="submit" id="inputEmail" class="btn btn-success" value="Oui" name="suppBailleur">
				  	<a href="gBailleurs.php" id="inputEmail" class="btn btn-default"><span >Non</span><meta http-equiv='refresh' content'0;URL=gBailleurs.php'></a> 
				  	<?php /*if (isset($statut)){
				  		echo '<a href="?idBailMod='.$result['IdBail'].'" id="inputEmail" class="btn btn-info"><span >Modifier</span></a>';
				  	} */?>
				  </div></td>

				 </tr>	
				</table>		
			</form>		

		  </div>
	</div>

<!-- ============================================================================================================== -->
<!-- =================== Bloc modification du bailleur ============================================================= -->
<!-- ============================================================================================================== -->

	<?php }elseif(isset($_GET['idBailMod'])){ 

		$idBail = $_GET['idBailMod'];
		//Requette pour recuperer num bailleur
			$reqt = $bdd->prepare('SELECT * FROM bailleurs WHERE  IdBail = :idBail');
	        $reqt->execute(array('idBail' => $idBail));
	        $result = $reqt->fetch();
	        $idIM = $result['IdBail'];
	        if ($result) {
	        	
	        	if (isset($_POST['modifier'])) {
	        		$reqMod = $bdd->prepare('UPDATE bailleurs SET 
				        NomBail = :nomBail, 
				        PrenomBail = :prenomBail,
				        Sexe = :sexeBail,
				        DateNaiss = :dtBail,
				        EtatCivil = :etatCivilBail,
				        Nationalite = :nationaliteBail,
				        Residence = :residenceBail,
				        Email = :emailBail,
				        NumPieceIdent = :NumPieceIdentBail,
				        TelBail = :telBail, 
				        Avatar = :avatarBail 
				        	WHERE IdBail = :idBail');

				    $reqMod->execute(array(
				        'nomBail' => $_POST['nom'],
				        'prenomBail' => $_POST['prenom'],
				        'sexeBail' => $_POST['sexe'],
				        'dtBail' => $_POST['dtNaiss'],
				        'etatCivilBail' => $_POST['etatCiv'],
				        'nationaliteBail' => $_POST['nationalite'],
				        'residenceBail' => $_POST['residence'],
				        'emailBail' => $_POST['email'],
				        'NumPieceIdentBail' => $_POST['numPiece'],
				        'telBail' => $_POST['telephone'],
				        'avatarBail' => 'user.jpg',
				        'idBail' => $idBail
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
		      <!-- Historique des maisons deja vaidees -->	
				<div class="well">
					<h3 style="text-align: center">Modifier <?php echo $result['NomBail'];?></h3><br/>
					<?php if (isset($statut)) {
						echo '<div class="alert alert-block alert-success fade in">';
					    echo '<a href = "gBailleurs.php" class="close" >×</a>';
					    echo '<strong>Modification réussie avec succès ';
						echo '</div>';
			        	echo "<meta http-equiv='refresh' content'0;URL=mod_bailleur.php'>";
					}elseif (isset($statutErr)) {
						echo '<div class="alert alert-block alert-error fade in">';
					    echo '<a href = "gBailleurs.php" class="close" >×</a>';
					    echo '<strong>Modification réussie avec succès ';
						echo '</div>';
			        	echo "<meta http-equiv='refresh' content'0;URL=mod_bailleur.php'>";
					} ?>
				</div>
			</div>
		</div>
					
		<div class="row-fluid">
			<div class="span8">
		      <!-- Historique des maisons deja vaidees -->	
				<div class="well">
								<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">		
									<div class="control-group">
										<label class="control-label" for="inputFname1">Nom <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="nom" placeholder="Date Creation" value="<?php echo utf8_encode($result['NomBail']); ?>" required>
										</div>
									 </div>		
									 		
									<div class="control-group">
										<label class="control-label" for="inputFname1">Prénom <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="prenom" placeholder="Date Creation" value="<?php echo utf8_encode($result['PrenomBail']); ?>" required>
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
										  <input type="date" id="inputEmail" class="input-xlarge" name="dtNaiss" placeholder="Date Naissance" value="<?php $result['DateNaiss']; ?>" required>
										</div>
									 </div> 		
									<div class="control-group">
										<label class="control-label" for="inputFname1">Etat Civil <sup style="color: red;">*</sup></label>
										<div class="controls">
											<select class="input-xlarge" id="inputEmail" name="etatCiv">
												<option value="<?php echo utf8_encode($result['EtatCivil']); ?>"><?php echo utf8_encode($result['EtatCivil']); ?></option>
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
										  <input type="text" id="inputEmail" class="input-xlarge" name="nationalite" placeholder="Nationalité " value="<?php echo $result['Nationalite']; ?>" required>
										</div>
									  </div>		
									<div class="control-group">
										<label class="control-label" for="inputPassword1">Résidence <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="residence" placeholder="Résidence " value="<?php echo utf8_encode($result['Residence']); ?>" required>
										</div>
									  </div>			
									<div class="control-group">
										<label class="control-label" for="inputPassword1">Email <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="email" placeholder="Email " value="<?php echo $result['Email']; ?>" required>
										</div>
									  </div>			
									<div class="control-group">
										<label class="control-label" for="inputPassword1">N° Pièce identité <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="numPiece" placeholder="Résidence " value="<?php echo $result['NumPieceIdent']; ?>" required>
										</div>
									  </div>				
									<div class="control-group">
										<label class="control-label" for="inputPassword1">N° Téléphone <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="text" id="inputEmail" class="input-xlarge" name="telephone" placeholder="Résidence " value="<?php echo $result['TelBail']; ?>" required>
										</div>
									  </div>				
										<div class="control-group" style="text-align: center;">
											<input class="btn btn-large btn-info" type="submit" name="modifier" value="Modifier" />
										</div>
									</div>		
								</form>
				</div>
				<div class="3">
			      <!-- Historique des maisons deja vaidees -->	
					<div class="well">
								<center><a href="themes/images/avatar_bail/<?php echo $result['Avatar']; ?>">
				  				<img width="200" src="themes/images/avatar_bail/<?php echo $result['Avatar']; ?>" alt=""/></a>
				  				</center>
				  	</div>    
				</div>

<!-- ============================================================================================================== -->
<!-- =================== Bloc pour afficher les bailleurs qui sont dans le systeme ================================ -->
<!-- ============================================================================================================== -->
	<?php }else{ ?>
  <div class="tab-pane active" id="one">
  <div class="row-fluid">
	 <div class="span12">
	 	
<center><form class="form-horizontal span9" method="POST"  action="">
		<div class="control-group">
			<input id="srchFld" type="text"  style="padding-left: 30px;"class="input-xlarge srchFld input-medium search-query" placeholder="Entrer le nom du bailleur" name="nomBailRech">
		  
		  <input type="submit" name="rechercher" style="margin-top: 5px;" value="Rechercher" class="btn btn-primary" >  
		</div>

	</form>	 	</center>	 		
	 		
	<!-- Historique des maisons en cours -->		
	<table class="table table-bordered" >
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
                <th>Modofier</th>
                <th>Supprimer</th>
               
			</tr>
        </thead>
            <tbody>
            	<?php
            	if (isset($_POST['rechercher'])) {
            		$nomBail = $_POST['nomBailRech'];

            		$reqAgent = $bdd->prepare("SELECT IdBail, NomBail, PrenomBail, Sexe,  date_format(DateNaiss, '%d/%m/%Y') AS dtNaiss, EtatCivil, Nationalite , Residence, Email, NumPieceIdent, TelBail, Avatar  FROM bailleurs WHERE NomBail = :nomBail");
            		$reqAgent->execute(array('nomBail' => $nomBail));
            		while ($resAdmin = $reqAgent->fetch()) { ?>
            			<tr>
                <td > <a href="themes/images/avatar_bail/<?php echo $resAdmin['Avatar']; ?>"><img style="width:100%" src="themes/images/avatar_bail/<?php echo $resAdmin['Avatar']; ?>" alt=""/></a></td>
                <td><?php echo $resAdmin['NomBail']; ?></td>
                <td><?php echo $resAdmin['PrenomBail']; ?></td>
                <td><?php echo $resAdmin['Sexe']; ?></td>
                <td><?php echo $resAdmin['dtNaiss']; ?></td>
                <td><?php echo utf8_encode($resAdmin['EtatCivil']); ?></td>
                <td><?php echo $resAdmin['Nationalite']; ?></td>
                <td><?php echo $resAdmin['Residence']; ?></td>
                <td><?php echo $resAdmin['Email']; ?></td>
                <td><?php echo $resAdmin['NumPieceIdent']; ?></td>
                <td><?php echo $resAdmin['TelBail']; ?></td>
                <td><a href="?idBailMod=<?php echo $resAdmin['IdBail']; ?>"  style="padding-right:0"><span class="btn btn-medium btn-info pull-right">Modifier</span></a></td>
                <td><a href="?action=supp&idBail=<?php echo $resAdmin['IdBail']; ?>"  style="padding-right:0"><span class="btn btn-medium btn-danger pull-right">Supprimer</span></a></td>
                
   			</tr>

            	<?php }}else{
            		$reqAgent = $bdd->prepare("SELECT IdBail, NomBail, PrenomBail, Sexe,  date_format(DateNaiss, '%d/%m/%Y') AS dtNaiss, EtatCivil, Nationalite , Residence, Email, NumPieceIdent, TelBail, Avatar  FROM bailleurs");
            		$reqAgent->execute();
            		while ($resAdmin = $reqAgent->fetch()) { ?>
            <tr>
                <td > <a href="themes/images/avatar_bail/<?php echo $resAdmin['Avatar']; ?>"><img style="width:100%" src="themes/images/avatar_bail/<?php echo $resAdmin['Avatar']; ?>" alt=""/></a></td>
                <td><?php echo $resAdmin['NomBail']; ?></td>
                <td><?php echo $resAdmin['PrenomBail']; ?></td>
                <td><?php echo $resAdmin['Sexe']; ?></td>
                <td><?php echo $resAdmin['dtNaiss']; ?></td>
                <td><?php echo utf8_encode($resAdmin['EtatCivil']); ?></td>
                <td><?php echo $resAdmin['Nationalite']; ?></td>
                <td><?php echo $resAdmin['Residence']; ?></td>
                <td><?php echo $resAdmin['Email']; ?></td>
                <td><?php echo $resAdmin['NumPieceIdent']; ?></td>
                <td><?php echo $resAdmin['TelBail']; ?></td>
                <td><a href="?idBailMod=<?php echo $resAdmin['IdBail']; ?>"  style="padding-right:0"><span class="btn btn-medium btn-info pull-right">Modifier</span></a></td>
                <td><a href="?action=supp&idBail=<?php echo $resAdmin['IdBail']; ?>"  style="padding-right:0"><span class="btn btn-medium btn-danger pull-right">Supprimer</span></a></td>
                
   			</tr> <?php } } ?>
            
		</tbody>
    </table>
    
	  </div>
  </div>
<?php } ?>
  
</div>
</div>	

</div>
</div></div> 
</div>
<!-- Footer ================================================================== -->
<?php include('include/footer.php'); ?>

</body>
</html>
<?php 
	}else{
	header('Location:index.php');
	}
?>