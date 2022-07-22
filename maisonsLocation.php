<?php
	session_start();
	include('config/connexion.php');	

	if (isset($_SESSION['idAdmin'])) { 

	///Etat de la maison
	$etatMaison = 'Innocupee';
	$statutMaison = 'Valide';
	$etatMaisonInnoc = 'Innocupee';
	$etatMaisonOccupe = 'Occupee';
	$statutMaisonInval = 'Invalide';
	$statut = '';

	//=============================Delimiter le nombre des maisons a afficher par page
	$maisonsparPage = 6;
	$accord = 'Oui';
	$totalMaisonsReq = $bdd->prepare('SELECT reservations.Idres, reservations.DateRes, reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, maisons.DateOffre, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail, bailleurs.Avatar, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg');
	$totalMaisonsReq->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison));
	$totalMaisons = $totalMaisonsReq->rowCount();
	$pagesTotales = ceil($totalMaisons / $maisonsparPage);

	if (isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0) {
		$_GET['page'] = intval($_GET['page']);
		$pageCourante = $_GET['page'];
	}else{
		$pageCourante = 1;
	}

	$depart = ($pageCourante - 1) * $maisonsparPage;

	if (isset($_GET['idM'])) {
		//Requette pour valider une maisons
		$reqVal = $bdd->prepare('UPDATE maisons SET StatutMaison = :statutMaison WHERE IdM = :idM');
		$reqVal->execute(array('statutMaison' => $statutMaison, 'idM' => $_GET['idM']));
		if ($reqVal) {
			header('Location:gMaisonss.php');
		}else{
			header('Location:gMaisonss.php');
		}
	}elseif (isset($_GET['idMSup'])) {
		# Requette pour annuler une maison en cours d'offre
		$reqAnnul = $bdd->prepare('DELETE FROM maisons WHERE IdM = :idM');
		$reqAnnul->execute(array('idM' => $_GET['idMSup'] ));
		if ($reqAnnul) {
			header('Location:gMaisonss.php');
		}else{
			header('Location:gMaisonss.php');
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Maisons en Location</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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
	
	<div class="span6">
	
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
	
	 <li class="">
		<a href="themes/images/avatar_admin/<?php echo $_SESSION['avatarAdmin']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_admin/<?php echo $_SESSION['avatarAdmin']; ?>"  alt=""/></a>	
	</li>
	<li class="">
	  <a href="config/deconnexion.php"  style="padding-right:0"><span class="btn btn-medium btn-info" style="border-radius: 15px;">Deconnexion</span></a></li>
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
			<a id="myCart" href="product_summary.html"><img src="themes/images/ico-cart.png" alt="cart">Maisons disponibles<span class="badge badge-warning pull-right"><?php echo $totalMaisons; ?></span></a>
		</div>
		<ul id="sideManu" class="nav nav-tabs nav-stacked">
			<li class="subMenu open"><a> IBANDA 
				<?php 

				//Requette pour afficher le nombre des maisons disponibles dans IBANDA
				$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.StatutRes =  :statutMaison
					AND reservations.Accord =  :accord
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Commune = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Ibanda'));
				$resultat = $req->fetch();
				echo "[ ".$resultat['nbi']." ]"; 

				?></a>
				<ul>
				<li>
					<a class="active" href="products.html"><i class="icon-chevron-right"></i>Ndendere 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Ndendere
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.StatutRes =  :statutMaison
					AND reservations.Accord =  :accord
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Ndendere'));
				$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Nyalukemba
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Nyalukemba
					$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Nyalukemba'));
				$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?> 
					</a>
				</li>
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Panzi 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Panzi
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Panzi'));
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
				$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.StatutRes =  :statutMaison
					AND reservations.Accord =  :accord
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Commune = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Kadutu'));
				$resultat = $req->fetch();
				echo "[ ".$resultat['nbi']." ]"; 

				?> </a>
			<ul style="display:none">
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Cimpunda 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Cimpunda
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Cimpunda'));
				$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Mosala 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Mosala
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Mosala'));
				$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>												
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Kasali 
						<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Kasali
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Kasali'));
				$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>	
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Nyamugo 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Nyamugo
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Nyamugo'));
				$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?> 
					</a>
				</li>	
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Nkafu 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Nkafu
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Nkafu'));
				$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?> 
					</a>
				</li>	
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Kajangu 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Kajangu
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Kajangu'));
				$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?> 
					</a>
				</li>	
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Nyakaliba 
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Nyakaliba
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Nyakaliba'));
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
				$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Commune = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Bagira'));
				$resultat = $req->fetch();
				echo "[ ".$resultat['nbi']." ]"; 

				?></a>
			<ul style="display:none">
				
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Nyakavogo
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Nyakavogo
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Nyakavogo'));
				$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Lumumba
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Lumumba
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Lumumba'));
				$resultat = $req->fetch();
						echo "( ".$resultat['nbi']." )"; 
					?>
					</a>
				</li>
				<li>
					<a href="products.html"><i class="icon-chevron-right"></i>Kasha
					<?php 
						//Requette pour afficher le nombre des maisons disponibles dans le quartier Kasha
						$req = $bdd->prepare('SELECT COUNT(*) as nbi FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :nom ');
				$req->execute(array('accord' => $accord,'statutMaison' => $statutMaison, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'nom'=>'Kasha'));
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
		<li><a href="gMaisons.php">Accueil</a> <span class="divider">/</span></li>
		<li class="active">Maisons en cours de location</li>
		<div class="pull-right" style="font-family: verdana">
		<?php echo $_SESSION['nomAdmin'].' '; ?>
		</div>
    </ul>
	<hr class="soft"/>
	<form class="form-horizontal span9" method="POST"  action="">
		<div class="btn-group ">
          <button type="submit" name="rechercher" class="btn dropdown-toggle" data-toggle="dropdown">Sélectionner une commune <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><a href="maisonsLocation.php">Toutes les communes</a></li>
            <li class="divider"></li>
            <li><a href="?ibanda">IBANDA</a></li>
            <li class="divider"></li>
            <li><a href="?ndendere">Ndendere</a></li>
            <li><a href="?nyalukemba">Nyalukemba</a></li>
            <li><a href="?panzi">Panzi</a></li>
            <li class="divider"></li>
            <li><a href="?kadutu">KADUTU</a></li>
            <li class="divider"></li>
            <li><a href="?cimpunda">Cimpunda</a></li>
            <li><a href="?mosala">Mosala</a></li>
            <li><a href="?kasali">Kasali</a></li>
            <li><a href="?nyamugo">Nyamugo</a></li>
            <li><a href="?nkafu">Nkafu</a></li>
            <li><a href="?kajangu">Kajangu</a></li>
            <li><a href="?nyakaliba">Nyakaliba</a></li>
            <li class="divider"></li>
            <li><a href="?bagira">BAGIRA</a></li>
            <li class="divider"></li>
            <li><a href="?nyakavogo">Nyakavogo</a></li>
            <li><a href="?lumumba">Lumumba</a></li>
            <li><a href="?kasha">Kasha</a></li>
          </ul>
        </div>

	</form>
	  
<div id="myTab" class="pull-right">
 
</div>
<br class="clr"/>
<div class="tab-content ">
	<div class="tab-pane active" id="listView">

		<?php 
		//================================Requette pour afficher les maisons en location dans la commune d'banda
		//===========================================================================================================
		if (isset($_GET['ibanda'])) {
			$commune = 'Ibanda';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Commune = :commune');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'commune' => $commune ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');		

		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?> 
				<?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ 
					echo '<span style="color: red;"> Contrat expiré </span>'; 
					$idM = $resultat['IdM'];  
					echo 'ok';
				} ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {

						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			} 
			// Requette pour afficher les naisons deja louees dans le quartier
		}elseif(isset($_GET['ndendere'])){
			$quartier = 'Ndendere';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :quartier ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'quartier' => $quartier ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			}

			//Requette pour afficher les maisons deja louees dans le quartier Nyalukemba
		}elseif(isset($_GET['nyalukemba'])){
			$quartier = 'Nyalukemba';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :quartier ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'quartier' => $quartier ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			} 
		

			//Requette pour afficher les maisons deja louees dans le quartier panzi
		}elseif(isset($_GET['panzi'])){
			$quartier = 'Panzi';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :quartier ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'quartier' => $quartier ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			} 
		}elseif(isset($_GET['kadutu'])){
			$commune = 'Kadutu';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Commune = :commune ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'commune' => $commune ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			} 
			//Requette pour afficher les maisons deja louees dans le quartier Cimpunda
		}elseif(isset($_GET['cimpunda'])){
			$quartier = 'Cimpunda';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :quartier ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'quartier' => $quartier ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			} 
			
			//Requette pour afficher les maisons deja louees dans le quartier Cimpunda
		}elseif(isset($_GET['mosala'])){
			$quartier = 'Mosala';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :quartier ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'quartier' => $quartier ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			} 
			
			//Requette pour afficher les maisons deja louees dans le quartier Kasali
		}elseif(isset($_GET['kasali'])){
			$quartier = 'Kasali';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :quartier ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'quartier' => $quartier ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			} 
			
			//Requette pour afficher les maisons deja louees dans le quartier Nyamugo
		}elseif(isset($_GET['nyamugo'])){
			$quartier = 'Nyamugo';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :quartier ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'quartier' => $quartier ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			}
			
			//Requette pour afficher les maisons deja louees dans le quartier Nkafu
		}elseif(isset($_GET['nkafu'])){
			$quartier = 'Nkafu';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :quartier ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'quartier' => $quartier ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			}
			
			//Requette pour afficher les maisons deja louees dans le quartier Kajangu
		}elseif(isset($_GET['kajangu'])){
			$quartier = 'Kajangu';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :quartier ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'quartier' => $quartier ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			}
			
			//Requette pour afficher les maisons deja louees dans le quartier Nyakaliba
		}elseif(isset($_GET['nyakaliba'])){
			$quartier = 'Nyakaliba';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Quartier = :quartier ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'quartier' => $quartier ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Contrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
			}
		}elseif(isset($_GET['bagira'])){
			$commune = 'Bagira';

			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					AND maisons.Commune = :commune ');
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison, 'commune' => $commune ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Contrat en cours</span>';
				}else{ echo '<span style="color: red;">Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/>

	<?php }
			}elseif ($nbb == 0) {
				echo '<center>
				<h2>Aucune maison en location </h2>
				<a href="maisonsLocation.php"><h4 style="color:green">Retour</h4></a></center>';
	} 
		}else{
			//Requette pour afficher le nombre des maisons disponibles en location
			$req = $bdd->prepare('
				SELECT reservations.Idres, DATE_FORMAT(maisons.DateOffre,\'%d-%m-%Y\') AS dtOff , reservations.NbMois,reservations.DebutContrat,reservations.StatutRes, reservations.Idmaison, reservations.IdAgent, reservations.IdLocat, maisons.IdM, maisons.Num, maisons.Prix, maisons.Commune, maisons.Quartier, maisons.Avenue, maisons.NbChambre, maisons.NbSalon, maisons.NbDouche, maisons.Description, maisons.EtatMaison, maisons.StatutMaison, DATE_FORMAT(reservations.DateRes, \'%d-%m-%Y\') AS DateRes, maisons.Photo, maisons.IdB, maisons.IdAdm, locataires.IdLoc, Telephone, locataires.NomLoc, locataires.AvatarLoc, bailleurs.Idbail, bailleurs.NomBail,bailleurs.Avatar,TelBail, agents.IdAg, agents.NomAg
				FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.Idmaison = maisons.IdM
					AND reservations.IdLocat = locataires.IdLoc
					AND reservations.IdAgent = agents.IdAg
					AND reservations.Accord =  :accord
					AND reservations.StatutRes =  :statutMaison
					AND maisons.IdB = bailleurs.Idbail
					AND maisons.EtatMaison =  :etatMaisonOccupe
					AND maisons.StatutMaison =  :statutMaison
					AND maisons.IdAdm = agents.IdAg
					LIMIT '.$depart.','.$maisonsparPage);
			$req->execute(array('accord' => $accord,'statutMaison' => $etatMaisonOccupe, 'etatMaisonOccupe' => $etatMaisonOccupe, 'statutMaison' => $statutMaison ));
			$nbb = $req->rowCount();
			if($nbb > 0){
			while ($resultat = $req->fetch()) {
				/////=========== On verifier la validite du contrat
				$mois = $resultat['NbMois'];
				$idRes = $resultat['Idres'];
				include('include/testerContratValide.php');
				
		?>
		<div class="row">	  
			<div class="span2">
				<a href="themes/images/maisons/<?php echo $resultat['Photo']; ?>"><img class="rounded-circle" src="themes/images/maisons/<?php echo $resultat['Photo']; ?>"  alt=""/></a>
			</div>
			<div class="span4" style="text-align: justify;">
				<h5 style="text-align: justify;"> <?php echo $resultat['NbChambre']; ?> | Chambres Du <?php echo $resultat['dtOff']; ?> De Mrs/Msell <?php echo $resultat['NomBail']; ?> Avec <?php echo $resultat['NbChambre']; ?> Salon(s) Réservé le <?php echo $resultat['DateRes']; ?></h5>				
				
				<h5><?php echo $resultat['Commune']; ?> / <?php echo $resultat['Quartier']; ?> / Av <?php echo $resultat['Avenue']; ?><?php if ($data) {
					echo '<span style="color: green;"> Contrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></h5>
				<p style="text-align: justify;">
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
				
			</div>
			<div class="span3 alignR">
				<div class="form-horizontal qtyFrm">
				<h4> $<?php echo $resultat['Prix']; ?></h4>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<div class="row">
					<table align="right">
						<tr style="margin-bottom: 10px;">
							<td>Locataire : <?php echo $resultat['NomLoc']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resultat['AvatarLoc']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['Telephone']; ?></td>
						</tr>
						<tr>
							<td>Bailleur : <?php echo $resultat['NomBail']; ?> </td>
							<td rowspan="2"><a href="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_bail/<?php echo $resultat['Avatar']; ?>"  alt=""/></a></td>
						</tr>
						<tr>
							<td>Téléphone  : <?php echo $resultat['TelBail']; ?> </td>
						</tr>
					</table>
					
				</div>
				
				</div>
			</div>
		</div>
		<hr class="soft"/> 
	<?php } 
			}elseif ($nbb == 0) {
						echo '<center>
						<h2>Aucune maison en location </h2>
						<a href="gMaisons.php"><h4 style="color:green">Retour</h4></a></center>';
			} 
		}?>
			
	<div class="pagination">
		<ul>
			<?php 
				$prec = $pageCourante - 1;
				$suiv = $pageCourante + 1;
				if ($suiv > $pagesTotales) {
					$suiv = $pageCourante;
				}
					echo '<li><a href="?page='.$prec.'">&lsaquo;</a> </li>';
					for ($i=1; $i <= $pagesTotales; $i++) { 
						echo '<li active><a href="?page='.$i.'">'.$i.'</a> </li>';
					}
						echo '<li><a href="?page='.$suiv.'">&rsaquo;</a> </li>';
			?>
						
		</ul>
	</div>
	<br class="clr"/>
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
	<?php }else{ header('Location:index.php');}

