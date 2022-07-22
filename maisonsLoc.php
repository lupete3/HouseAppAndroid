<?php
	include('config/connexion.php');

	session_start();

	if (isset($_SESSION['idLoc'])) { 

	///Etat de la maison
	$etatMaison = 'Innocupee';
	$statutMaison = 'Valide';
	$statut = '';

	//Requette pour afficher le nombre des maisons disponibles
	$req = $bdd->prepare('SELECT COUNT(*) as nb FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison' );
	$req->execute(array('etat' => $etatMaison, 'statutMaison' => $statutMaison));
	$resultat = $req->fetch();

	//Delimiter le nombre des maisons a afficher par page
	$maisonsparPage = 6;
	$totalMaisonsReq = $bdd->prepare('SELECT IdM FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
	$totalMaisonsReq->execute(array('etat' => $etatMaison, 'statutMaison' => $statutMaison));
	$totalMaisons = $totalMaisonsReq->rowCount();
	$pagesTotales = ceil($totalMaisons / $maisonsparPage);

	if (isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0) {
		$_GET['page'] = intval($_GET['page']);
		$pageCourante = $_GET['page'];
	}else{
		$pageCourante = 1;
	}

	$depart = ($pageCourante - 1) * $maisonsparPage;

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
    <a class="brand" href="maisonsLoc.php"><img src="themes/images/logo1.png" alt="HousesAllocation" title="HousesAllocation" /></a>
	<ul id="topMenu" class="nav pull-right">
	 <li class=""><a href="espace_locataire.php">Espace Locataire</a></li>
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
		<div class="well well-small"><a id="myCart" href=""><img src="themes/images/ico-cart.png" alt="cart">Maisons disponibles<span class="badge badge-warning pull-right"><?php echo $resultat['nb']; ?></span></a></div>
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
					<a class="active" ><i class="icon-chevron-right"></i>Ndendere 
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
		<li><a href="maisonsLoc.php">Accueil</a> <span class="divider">/</span></li>
		<li class="active">Maisons disponible</li>
		<div class="pull-right" style="font-family: verdana">
		<i><?php echo $_SESSION['nomLoc'].' '; ?></i><img style="width: 15px;" src="themes/images/galerie/point.png" title="en ligne">
		</div>
    </ul>
	<hr class="soft"/>
	<form class="form-horizontal span9" method="POST"  action="">
		<div class="control-group">
		  <label class="control-label alignL">Entrer le critère </label>
			<input type="text"  style="margin-top: 5px;"class="input-medium search-query" placeholder="Prix Minimum" name="prixMin">
		  <input type="text" style="margin-top: 5px;" class="input-medium search-query" placeholder="Prix Maximum" name="prixMax">
		  <input type="submit" name="rechercher" style="margin-top: 5px;" value="Rechercher" class="btn btn-medium btn-info" >  
		</div>

	</form>
	  
<div id="myTab" class="pull-right">
 
</div>
<br class="clr"/>
<div class="tab-content ">
	<div class="tab-pane active" id="listView">

		<?php 

		if (isset($_POST['rechercher'])) {
			$prixMin = $_POST['prixMin'];
			$prixMax = $_POST['prixMax'];
			//Requette pour afficher le nombre des maisons disponibles selon le prix recherche
			$req = $bdd->prepare('SELECT * FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison AND  maisons.Prix BETWEEN :prixMin AND :prixMax ORDER BY IdM  ');
			$req->execute(array('etat' => 'Innocupee', 'statutMaison' => $statutMaison ,'prixMin' => $prixMin, 'prixMax' => $prixMax ));
			while ($resultat = $req->fetch()) {
		?>
		<div class="row">	  
			<div class="span2" style="height: 200px;">
				<img src="themes/images/maisons/<?php echo $resultat['Photo']; ?>" style="height: 200px;" alt=""  />
			</div>
			<div class="span4">
				<h3> <?php echo $resultat['NbChambre']; ?> | Chambres </h3>				
				<h5><?php echo $resultat['Quartier']; ?></h5>
				<p>
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
			</div>
			<div class="span3 alignR">
				<form class="form-horizontal qtyFrm">
				<h3> $<?php echo $resultat['Prix']; ?></h3>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				  <?php $idB = $resultat['IdB']; $photo = $resultat['Photo']; $numM = $resultat['Num']; $idM = $resultat['IdM'];  echo '<a href="detail_maison.php?idB='.$idB.'&& numM='.$numM.'&& idM='.$idM.'&& photo='.$photo.'" class="btn btn-large btn-primary"> Reserver </a>'; ?>
				  <?php $idB = $resultat['IdB']; $photo = $resultat['Photo']; $numM = $resultat['Num']; $idM = $resultat['IdM'];  echo '<a href="detail_maison.php?idB='.$idB.'&& numM='.$numM.'&& idM='.$idM.'&& photo='.$photo.'" class="btn btn-large"><i class="icon-zoom-in"></i></a>'; ?>
				 
				</form>
			</div>
		</div>
		<hr class="soft"/> 

	<?php } 
		}else{
			//Requette pour afficher le nombre des maisons disponibles en location
			$req = $bdd->prepare('SELECT * FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ORDER BY IdM DESC LIMIT '.$depart.','.$maisonsparPage);
			$req->execute(array('etat' => $etatMaison, 'statutMaison' => $statutMaison ));
			while ($resultat = $req->fetch()) {
				
		?>
		<div class="row">	  
			<div class="span2">
				<img src="themes/images/maisons/<?php echo $resultat['Photo']; ?>" alt=""/>
			</div>
			<div class="span4">
				<h3> <?php echo $resultat['NbChambre']; ?> | Chambres  </h3>				
				<h5><?php echo $resultat['Quartier']; ?></h5>
				<p>
				<?php echo utf8_encode($resultat['Description']); ?>
				</p>
			</div>
			<div class="span3 alignR">
				<form class="form-horizontal qtyFrm">
				<h3> $<?php echo $resultat['Prix']; ?></h3>
				 Numero de la maison <medium class="label"><?php echo $resultat['Num']; ?></medium>
				<br/>
				<br/>
				<!-- Affichage du detail de la maison -->
				  <?php $idB = $resultat['IdB']; $photo = $resultat['Photo']; $numM = $resultat['Num']; $idM = $resultat['IdM'];  echo '<a href="detail_maison.php?idB='.$idB.'&& numM='.$numM.'&& idM='.$idM.'&& photo='.$photo.'" class="btn btn-large btn-primary"> Détail Maison <i class=" icon-shopping-cart"></i></a>'; ?>
				  <?php $idB = $resultat['IdB']; $photo = $resultat['Photo']; $numM = $resultat['Num']; $idM = $resultat['IdM'];  echo '<a href="detail_maison.php?idB='.$idB.'&& numM='.$numM.'&& idM='.$idM.'&& photo='.$photo.'" class="btn btn-large"><i class="icon-zoom-in"></i></a>'; ?>
				</form>
			</div>
		</div>
		<hr class="soft"/> 

	<?php } 
		}?>
			
	<div class="pagination">
		<ul>
			<?php 
				$prec = $pageCourante - 1;
				$suiv = $pageCourante + 1;
				if ($suiv > $pagesTotales) {
					$suiv = $pageCourante;
				}
					echo '<li><a href="maisonsLoc.php?page='.$prec.'">&lsaquo;</a> </li>';
					for ($i=1; $i <= $pagesTotales; $i++) { 
						echo '<li active><a href="maisonsLoc.php?page='.$i.'">'.$i.'</a> </li>';
					}
						echo '<li><a href="maisonsLoc.php?page='.$suiv.'">&rsaquo;</a> </li>';
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

