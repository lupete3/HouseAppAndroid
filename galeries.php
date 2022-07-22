<?php
	
	include('config/connexion.php');

	///Etat de la maison
	$etatMaison = 'Innocupee';
	$statutMaison = 'Valide';
	$etatMaisonInnoc = 'Innocupee';

	$statut = '';

//Delimiter le nombre des maisons a afficher par page
	$maisonsparPage = 12;
	$totalMaisonsReq = $bdd->prepare('SELECT IdM FROM maisons WHERE maisons.StatutMaison = :statutMaison ORDER BY IdM DESC');
	$totalMaisonsReq->execute(array('statutMaison' => $statutMaison));
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
    <title>Allocation House</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

<!-- Bootstrap style --> 
    <link id="callCss" rel="stylesheet" href="themes/bootshop/bootstrap.min.css" media="screen"/>
    <link href="themes/css/base.css" rel="stylesheet" media="screen"/>
<!-- Bootstrap style responsive -->	
	<link href="themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
	<link href="themes/css/font-awesome.css" rel="stylesheet" type="text/css">

  </head>
<body>
<div id="header">
<div class="container">
<div id="welcomeLine" class="row">
	
	
</div>
<!-- Navbar ================================================== -->
<div id="logoArea" class="navbar" style="background-color: blue">
<a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>
  <div class="navbar-inner">
    <a class="brand" href="index.php" ><img src="themes/images/logo1.png" alt="HousesAllocation" title="HousesAllocation" /></a>
		
    <ul id="topMenu" class="nav pull-right">
		 <li class=""><a href="index.php">Accueil</a></li>
		 <li class=""><a href="galerie_autres.php">Autres Photos</a></li>
		 <li class=""><a href="normal.php">Confidentialité</a></li>
		 <li class=""><a href="contact.php">Nous contacter</a></li>
		 <li class="">
		
		</li>
    </ul>
  </div>
</div>
</div>
</div>

<div id="mainBody">
	<div class="container">
	<div class="row">

		<div class="span12">		
		<h4>Galerie Photos  <small class="pull-right"> + 
			<?php 
				$req = $bdd->prepare('SELECT COUNT(*) as nb FROM maisons WHERE  maisons.StatutMaison = :statutMaison ');
				  	$req->execute(array('statutMaison' => $statutMaison ));
				$resultat = $req->fetch(); 
				echo $resultat['nb'] ;
			?>
				images</small></h4>
			  <ul class="thumbnails">
			  	<?php 
			  		//Requette pour afficher le nombre des maisons disponibles en location
				  	$req = $bdd->prepare('SELECT * FROM maisons WHERE  maisons.StatutMaison = :statutMaison ORDER BY IdM DESC LIMIT '.$depart.','.$maisonsparPage);
				  	$req->execute(array('statutMaison' => $statutMaison ));
				  	while ($resultat = $req->fetch()) {
				  	
				?>
				<li class="span3">
				  <div class="thumbnail">
					<a  href="themes/images/maisons/<?php echo $resultat['Photo']; ?>" ><img src="themes/images/maisons/<?php echo $resultat['Photo']; ?>" alt="Télécharger l'image" title = "Télécharger l'image" style="height: 120px; width: 100%;" alt=""/><span class="badge badge-inverse" style="position: absolute; display:block; top: -4px;right: -18px; height:25px; width:30px; border-radius: 50px; text-align: left;padding-top: 10px;padding-right: 19px;">N°<?php echo $resultat['Num']; ?></span></a>
					<div class="caption">
					  <p style="text-align: justify;"><?php echo utf8_encode($resultat['Libelle']); ?></p>
					 
					</div>
				  </div>
				</li>
				
				 <?php 		
				  	}
				 ?>

			  </ul>	<!-- Systeme de pagination -->
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
<!-- Footer -->
<?php include('include/footer.php'); ?>

</body>
</html>