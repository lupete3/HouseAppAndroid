<?php
	session_start();
	include('config/connexion.php');

	if (isset($_SESSION['login'])) {

		$idAdmin = $_SESSION['idAdmin'];

			///Etat de la maison
		$etatMaison = 'Occupee';
		$statutMaison = 'Valide';
		$statutResInval = 'Invalide';
		$statutMaisonsInval = 'Invalide';
		$etatMaisonInnoc = 'Innocupee';

		$statut = '';

		//Afficher les nombre des maisons non alouées
		$totalMaisonsReq = $bdd->prepare('SELECT IdM FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ORDER BY IdM DESC');
		$totalMaisonsReq->execute(array('etat' => $etatMaisonInnoc, 'statutMaison' => $statutMaison));
		$totalMaisons = $totalMaisonsReq->rowCount();

		//Afficher les nombre des maisons louées
		$totalMaisonsReq = $bdd->prepare('SELECT IdM FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ');
		$totalMaisonsReq->execute(array('etat' => $etatMaison, 'statutMaison' => $statutMaison));
		$totalMaisonsOcc = $totalMaisonsReq->rowCount();

		//Afficher les nombre des réservations en cours
		$totalResReq = $bdd->prepare('SELECT IdRes FROM reservations WHERE reservations.StatutRes = :statut ');
		$totalResReq->execute(array('statut' => $statutResInval));
		$totResInval = $totalResReq->rowCount();

		//Afficher les nombre des locataires 
		$totalLocReq = $bdd->prepare('SELECT * FROM locataires ');
		$totalLocReq->execute();
		$totLocataires = $totalLocReq->rowCount();

		//Afficher les nombre des bailleurs 
		$totalBailReq = $bdd->prepare('SELECT * FROM bailleurs ');
		$totalBailReq->execute();
		$totBailleurs = $totalBailReq->rowCount();


		//Afficher les nombre des maisons en cours d'offre 
		$totalMaisonsInvalReq = $bdd->prepare('SELECT IdM FROM maisons WHERE  maisons.StatutMaison = :statutMaisonsInval ');
		$totalMaisonsInvalReq->execute(array('statutMaisonsInval' => $statutMaisonsInval));
		$totMaisonsInval = $totalMaisonsInvalReq->rowCount();

		# Requette pour recuperer les informations en rapport del'admin
		$reqProf = $bdd->prepare('SELECT * FROM agents WHERE IdAg = :idAdmin');
		$reqProf->execute(array('idAdmin' => $idAdmin));
		$resProf = $reqProf->fetch();

		if (isset($_POST['btnModifier'])) {
			# on teste si l'ancien mot de passe est correct
			if ($_POST['ancMdp'] == $resProf['Password']) {
				# On teste le deux nouveaux mot de passes corrspondent
				if ($_POST['nvMdp'] == $_POST['confMdp']) {
					# om recupere la photo
					$ptName = $_FILES['avatarAdmin']['name'];

        				$tailleMax = 3097152;
        				$extValide = array('jpg','jpg','png','gif' );

        				if ($_FILES['avatarAdmin']['size'] <= $tailleMax) {
        					$extentionUpload = strtolower(substr(strrchr($_FILES['avatarAdmin']['name'], '.'), 1));
        					if (in_array($extentionUpload, $extValide)) {
        						$chemin = "themes/images/avatar_admin/".$idAdmin.".".$extentionUpload;
        						$resultat = move_uploaded_file($_FILES['avatarAdmin']['tmp_name'], $chemin);
        						if ($resultat) {
        							$reqMod = $bdd->prepare('UPDATE agents SET 
				        			NomAg = :nomAdmin, 
				        			PrenomAg = :prenomAdmin,
				        			Sexe = :sexeAdmin,
				        			Adresse = :adresse,
				        			Email = :email,
				        			Password = :password,
				        			Telephone = :telephone,
				        			Avatar = :avatar 
				        			WHERE IdAg = :idAdmin');

				        			$reqMod->execute(array(
				        			'nomAdmin' => $_POST['nom'],
				        			'prenomAdmin' => $_POST['prenom'],
				        			'sexeAdmin' => $_POST['sexe'],
				        			'adresse' => $_POST['adresse'],
				        			'email' => $_POST['email'],
				        			'password' => $_POST['confMdp'],
				        			'telephone' => $_POST['telephone'],
				        			'avatar' => $idAdmin.".".$extentionUpload,
				        			'idAdmin' => $idAdmin
				        			
				        			 ));
				        			if ($reqMod) {
				        				header('Location:espace_admin.php');
				        				echo "<meta http-equiv='refresh' content'0;URL=espace_admin.php'>";
				        			}
        						}else{
        							$statut = 'Erreur lors de l\' importation de la photo';
        						}
        					}else{
        						$statut = 'Le format de votre photo n\' est pas valide';
        					}
        				}else{
        					$statut = 'La taille de la photo \'est pas valide';
        				}
				}else{
					$statut = 'Le mot de passes ne corrsspondent pas';
				}
			}else{
				$statut = 'L\'Ancien mot de passe est incorrect';
			}
		
		}
	
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Espace Administrateur</title>
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


	
	<link rel="stylesheet" href="themes/styles/main.css">
  </head>
<body>
<div id="header">
<div class="container">
<div id="welcomeLine" class="row">
	<!-- Deconnexion apres 5min -->
	<div class="span6">
		<script language="javascript" type='text/javascript'>
		    function session(){
		        window.location="config/deconnexion.php"; //page de déconnexion
		    }
		    setTimeout("session()",300000); //ça fait bien 5min??? c'est pour le test
		</script>
	</div>
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
	 <li class=""><a href="gAgents.php">Gestion Agents</a></li>
	 <li class=""><a href="gBailleurs.php">Gestion Bailleurs</a></li>
	 <li class=""><a href="gLocataires.php">Gestion Locataires</a></li>
	 <li class=""><a href="gMaisons.php">Gestion Offres Maisons</a></li>
	 <li class=""><a href="gReservations.php">Gestion Réservation</a></li>
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
		<div class="well well-small">
			<a id="myCart" href="product_summary.html"><img src="themes/images/ico-cart.png" alt="cart">Maisons disponibles<span class="badge badge-warning pull-right" style="font-size: 18px;"><?php echo $totalMaisons; ?></span></a>
		</div>
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
					<a class="active"><i class="icon-chevron-right"></i>Ndendere 
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
					<a><i class="icon-chevron-right"></i>Nyalukemba
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
					<a><i class="icon-chevron-right"></i>Panzi 
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
					<a><i class="icon-chevron-right"></i>Cimpunda 
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
					<a><i class="icon-chevron-right"></i>Mosala 
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
					<a><i class="icon-chevron-right"></i>Kasali 
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
					<a><i class="icon-chevron-right"></i>Nyamugo 
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
					<a><i class="icon-chevron-right"></i>Nkafu 
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
					<a><i class="icon-chevron-right"></i>Kajangu 
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
					<a><i class="icon-chevron-right"></i>Nyakaliba 
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
					<a><i class="icon-chevron-right"></i>Nyakavogo
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
					<a><i class="icon-chevron-right"></i>Lumumba
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
					<a><i class="icon-chevron-right"></i>Kasha
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
		<div class="well well-small">
			<a id="myCart" href="maisonsLocation.php"><img src="themes/images/ico-cart.png" alt="cart">Maisons Louées<span class="badge badge-info pull-right" style="font-size: 18px;"><?php echo $totalMaisonsOcc; ?></span></a>
		</div>
		 
			<div class="thumbnail">
				<a href="www.nossavoirs.blogspot.com"><img src="themes/images/carousel/winphone.png" title="Blog nossavoirs" alt="Blog nossavoirs"></a>
				<div class="caption">
				  <h5 style="color: green;"><a href="https://nossavoirs.blogspot.com" target="_blank">www.nossavoirs.blogspot.com</a></h5>
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
		<li><a href="espace_admin.php">Accueil</a> <span class="divider">/</span></li>
		<li class="active"> Espace Administrateur</li>
		<div class="pull-right" style="font-family: verdana">
		<i><?php echo $_SESSION['nomAdmin'].' '; ?></i></i><img style="width: 15px;" src="themes/images/products/large/point.png">
		</div>
    </ul>
	


	<div class="row-fluid">
		<div class="span3">
			<div class="well well-small" style="background-color: #53796e; border-radius: 20px 20px 4px 4px; color: #fff">
				<a id="myCart" href="gReservations.php"><img src="themes/images/ico-cart.png" alt="cart" style="color: #fff;">Nouvelles réservations<span class="badge badge-inverse pull-right" style="font-size: 18px;"><?php echo $totResInval; ?></span>
				</a>
			</div>
		</div>
		<div class="span3">
			<div class="well well-small" style="background-color: #66ACAE; border-radius: 4px 4px 20px 20px;">
				<a id="myCart" href="gLocataires.php"><img src="themes/images/ico-cart.png" alt="cart">Total Locataires disponibles<span class="badge badge-info pull-right" style="font-size: 18px;"><?php echo $totLocataires; ?></span>
				</a>
			</div>
		</div>
		<div class="span3">
			<div class="well well-small" style="background-color: #74DDE4; border-radius: 20px 20px 4px 4px;">
				<a id="myCart" href="gBailleurs.php"><img src="themes/images/ico-cart.png" alt="cart">Total Bailleurs disponibles<span class="badge badge-succes pull-right" style="font-size: 18px;"><?php echo $totBailleurs;?></span>
				</a>
			</div>
		</div>
		<div class="span3">
			<div class="well well-small" style="background-color: #DADBDD; border-radius: 4px 4px 20px 20px;">
				<a id="myCart" href="gMaisons.php"><img src="themes/images/ico-cart.png" alt="cart">Maisons en cours d'offre<span class="badge badge-important pull-right"style="font-size: 18px;"><?php echo $totMaisonsInval;?></span>
				</a>
			</div>
		</div>
	</div>
<div id="grids">
	<div class="row-fluid">
	 	<div class="span5">
			<div class="well">
				<ul class="thumbnails">
			<h5>VOTRE PROFIL</h5><br/><?php $img = $_SESSION['avatarAdmin']; ?>
				<table>
					<tr >
						<td colspan="2" style="text-align: center;"><a href="themes/images/avatar_admin/<?php echo $resProf['Avatar']; ?>"><img width="100" src="themes/images/avatar_admin/<?php echo $resProf['Avatar']; ?>" alt="" style="border-radius: 50px; height: 100px;" /></a>
						</td>
					</tr>
					<tr>
						<td style="font-size: 18px">Nom</td>
						<td style="text-align: right;  font-size: 18px"><?php echo  $resProf['NomAg']; ?></td>
					</tr>
					<tr>
						<td style=" font-size: 18px ">Prenom</td>
						<td style="text-align: right;  font-size: 18px"><?php echo $resProf['PrenomAg']; ?></td>
					</tr>
					<tr>
						<td style=" font-size: 18px ">Sexe</td>
						<td style="text-align: right; font-size: 18px"><?php echo $resProf['Sexe'] ;?></td>
					</tr>
					<tr>
						<td style=" font-size: 18px ">Adresse</td>
						<td style="text-align: right;  font-size: 18px"><?php echo $resProf['Adresse']; ?></td>
					</tr>
					<tr>
						<td style=" font-size: 18px ">Email</td>
						<td style="text-align: right;  font-size: 18px"><?php echo $resProf['Email']; ?></td>
					</tr>
					<tr>
						<td style=" font-size: 18px ">Numero Telephone </td>
						<td style="text-align: right;  font-size: 18px"><?php echo $resProf['Telephone']; ?></td>
					</tr>

					
					
				</table></ul>
			  	
		</div>
	</div>
	 	<div class="span7">
			<div class="well">
			<h5>MODIFIER VOTRE PROFIL</h5><br/>
	<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" >		
		<div class="control-group">
			<label class="control-label" for="inputFname1">Nom <sup style="color: red;">*</sup></label>
			<div class="controls">
			  <input type="text" id="inputFname1" name="nom" placeholder="Nom" value="<?php echo  $resProf['NomAg']; ?>" required>
			</div>
		 </div>
		 <div class="control-group">
			<label class="control-label" for="inputLnam">Prenom <sup style="color: red;">*</sup></label>
			<div class="controls">
			  <input type="text" id="inputLnam" name="prenom" placeholder="Prenom" value="<?php echo $resProf['PrenomAg']; ?>" required>
			</div>
		 </div>

	  	<div class="control-group">
			<label class="control-label" for="country">Sexe<sup style="color: red;">*</sup></label>
			<div class="controls">
			<select id="country" name="sexe" required>
				<option value="<?php echo $resProf['Sexe']; ?>"><?php echo $resProf['Sexe']; ?></option>
				<option value="Féminin">Féminin</option>
				<option value="Masculin">Masculin</option>
			</select>
			</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="input_email">Adresse <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="text" id="input_email" name="adresse" placeholder="Adresse" value="<?php echo  $resProf['Adresse']; ?>" required>
		</div>
	  	</div>
	  	<div class="control-group">
			<label class="control-label" for="country">Email<sup style="color: red;">*</sup></label>
			<div class="controls">
			<input type="email" id="input_email" name="email" placeholder="Email" value="<?php echo  $resProf['Email']; ?>" required>
			</div>
		</div>	
	  	<div class="control-group">
			<label class="control-label" for="country">Téléphone<sup style="color: red;">*</sup></label>
			<div class="controls">
			<input type="text" id="input_email" name="telephone" placeholder="Téléphone" value="<?php echo  $resProf['Telephone']; ?>" required>
			</div>
		</div>	
		<div class="control-group">
		<label class="control-label" for="input_email">Ancien Mot de Passe <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="password" id="input_email" name="ancMdp" placeholder="Ancien Mot de Passe" value="" required>
		</div>
	  </div>		
		<div class="control-group">
		<label class="control-label" for="input_email">Nouveau Mot de Passe <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="password" id="input_email" name="nvMdp" placeholder="Nouveau Mot de Passe" value="" required>
		</div>
	  </div>		
		<div class="control-group">
		<label class="control-label" for="input_email">Repeter le Mot de Passe <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="password" id="input_email" name="confMdp" placeholder="Repeter le Mot de passe" required>
		</div>
	  </div>
	
		<div class="controls">
		  <input type="file" name="avatarAdmin" id="inputPassword1" placeholder="Residence" class="hiddenFileInput" value="<?php echo  $resProf['Avatar']; ?>" >
		</div>
	
	<div class="control-group">
			<div class="controls">
				<?php
				if (isset($statut)) {
				echo '<label style="color:red;">'.$statut.'</label>';
						//echo '<script type="text/javascript">alert($erreur)</script>';
				}
			?>
				
				<input class="btn btn-large btn-info" name="btnModifier" type="submit" value="Modifier" />
			</div>
		</div>		
	</form>
		</div>
		</div>
	 </div>
  </div>
  
</div>
	
</div>
</div></div>
</div>
<!-- Footer ================================================================== -->
	<!-- Footer -->
<?php include('include/footer.php'); ?>

</body>
</html>
<?php }else{
	header('Location:index.php');
}
?>