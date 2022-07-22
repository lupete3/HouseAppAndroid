<?php
	session_start();
	include('config/connexion.php');

	///Etat de la maison
	$etatMaison = 'Innocupee';
	$statutMaison = 'Valide';
	$etatMaisonInnoc = 'Innocupee';

	$statut = '';

//Delimiter le nombre des maisons a afficher par page
	$maisonsparPage = 6;
	$totalMaisonsReq = $bdd->prepare('SELECT IdM FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ORDER BY IdM DESC');
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
	

	if (isset($_POST['connexion'])) {
		if (!empty($_POST['email']) AND !empty($_POST['password'])) {
			$email = htmlspecialchars($_POST['email']);
			$password = htmlspecialchars($_POST['password']);

			if ($bdd) {
				//Requete Admin
				$reqAdmin = $bdd->prepare('SELECT * FROM agents WHERE Email = :email AND Password = :pass');
				$reqAdmin->execute(array('email' => $email , 'pass' => $password ));
				$resAdmin = $reqAdmin->fetch();

				//Requette Bailleur 
				$reqBail = $bdd->prepare('SELECT * FROM bailleurs WHERE Email = :email AND Password = :pass');
				$reqBail->execute(array('email' => $email , 'pass' => $password ));
				$resBail = $reqBail->fetch();

				//Requette Client
				$reqLoc = $bdd->prepare('SELECT * FROM locataires WHERE EmailLoc = :email AND Password = :pass');
				$reqLoc->execute(array('email' => $email , 'pass' => $password ));
				$resLoc = $reqLoc->fetch();

				if ($resAdmin) {
					$_SESSION['login'] = $email;
					$_SESSION['idAdmin'] = $resAdmin['IdAg'];
					$_SESSION['nomAdmin'] = $resAdmin['NomAg'];
					$_SESSION['prenomAdmin'] = $resAdmin['PrenomAg'];
					$_SESSION['sexeAdmin'] = $resAdmin['Sexe'];
					$_SESSION['adresseAdmin'] = $resAdmin['Adresse'];
					$_SESSION['emailAdmin'] = $resAdmin['Email'];
					$_SESSION['passAdmin'] = $resAdmin['Password'];
					$_SESSION['avatarAdmin'] = $resAdmin['Avatar'];

					header('Location:espace_admin.php');

				}elseif ($resBail) {
					$_SESSION['login'] = $email;
					$_SESSION['idBail'] = $resBail['IdBail'];
					$_SESSION['nomBail'] = $resBail['NomBail'];
					$_SESSION['emailBail'] = $resBail['Email'];
					$_SESSION['passBail'] = $resBail['Password'];

					header('Location:espace_bailleur.php');

				}elseif ($resLoc) {
					$_SESSION['login'] = $email;
					$_SESSION['idLoc'] = $resLoc['IdLoc'];
					$_SESSION['nomLoc'] = $resLoc['NomLoc'];
					$_SESSION['emailLoc'] = $resLoc['EmailLoc'];
					$_SESSION['passLoc'] = $resLoc['Password'];

					header('Location:maisonsLoc.php');
				}
				else{
					$statut = 'Pseudo et password incorects ';
					echo "<script>alert('$statut')</script>";
					echo '<meta http-equiv = "refresh" content = "0">';
				}
			}else{
				$statut = 'Aucune connexion ';
				echo "<script>alert('$statut')</script>";
				echo '<meta http-equiv = "refresh" content = "0">';			
			}
		}
	}
	
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
    <a class="brand" href="themes/images/logo1.png" download><img src="themes/images/logo1.png" alt="HousesAllocation" title="HousesAllocation" /></a>
		
    <ul id="topMenu" class="nav pull-right">
	 <li class=""><a href="index.php"><span class="glyphicon-star"> Accueil</span></a></li>
	 <li class=""><a href="galeries.php">Galeries des photos</a></li>
	 <li class=""><a href="themes/loi/leganetContrat.pdf">Confidentialité</a></li>
	 <li class=""><a href="contact.php">Nous contacter</a></li>
	 <li class="">
	 <a href="#login" role="button" data-toggle="modal" style="padding-right:0"><span class="btn btn-medium btn-info">Connexion</span></a>
	 <!-- Bloc de connexion -->
	<div id="login" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3>Connexion</h3>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal loginFrm" method="POST" action="">
			  <div class="control-group">								
				<input type="email" id="inputEmail" name="email" placeholder="Email" autofocus required>
			  </div>
			  <div class="control-group">
				<input type="password" id="inputPassword" name="password" placeholder="Password" required>
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
<!-- Maisons en diaporama ====================================================================== -->
<div id="carouselBlk">
	<div id="myCarousel" class="carousel slide">
		
		<!-- Bouton Precedente et Suivante ================================================== -->
		<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
	</div> 
</div>
<div id="mainBody">
	<div class="container">
	<div class="row">
<!-- Sidebar ================================================== -->
	<div id="sidebar" class="span3">
		<div class="well well-small"><a id="myCart" href="#login" role="button" data-toggle="modal"><img src="themes/images/ico-cart.png" alt="cart">Maisons disponibles<span class="badge badge-warning pull-right"><?php echo $totalMaisons; ?></span></a></div>
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
		 
			<div class="thumbnail">
				<img src="themes/images/carousel/payment_methods.png" title="Allocation Houses Payment Methods" alt="Moyen de paiement">
				<div class="caption">
				  <h5>Moyens de payement</h5>
				</div>
			  </div> 
	</div>
<!-- Sidebar end=============================================== -->
		<div class="span9">		
		<h4>Récement publiées  <small class="pull-right"> + 
			<?php 
				$req = $bdd->prepare('SELECT COUNT(*) as nb FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ');
				  	$req->execute(array('etat' => 'Innocupee','statutMaison' => $statutMaison ));
				$resultat = $req->fetch(); 
				echo $resultat['nb'] ;
			?>
				nouvelles maisons</small></h4>
			  <ul class="thumbnails">
			  	<?php 
			  		//Requette pour afficher le nombre des maisons disponibles en location
				  	$req = $bdd->prepare('SELECT * FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ORDER BY IdM DESC LIMIT '.$depart.','.$maisonsparPage);
				  	$req->execute(array('etat' => 'Innocupee','statutMaison' => $statutMaison ));
				  	while ($resultat = $req->fetch()) {
				  	//Delimiter le nombre des caracteres a afficher dans la description
				  		$nbChar = 100;
				  		$description = $resultat['Description'];
				  		$new_description = substr($description, 0,$nbChar).'<a href="#login" role="button" data-toggle="modal" >...</a>';
				  		$description_finale = wordwrap($new_description,100,'<br>',false);
				?>
				<li class="span3">
				  <div class="thumbnail">
					<a  href="detail.php?idB=<?php echo $resultat['IdM']; ?>" ><img src="themes/images/maisons/<?php echo $resultat['Photo']; ?>" alt="" style="height: 150px;width: 500px;" alt=""/><span class="badge badge-inverse" style="position: absolute; display:block; top: -4px;right: -18px; height:25px; width:30px; border-radius: 50px; text-align: left;padding-top: 10px;padding-right: 19px;">N°<?php echo $resultat['Num']; ?></span></a>
					<div class="caption">
					  <h5 style="text-align: justify;"><?php echo utf8_encode($resultat['Libelle']); ?></h5>
					  <h5 style="text-align: center;"><?php echo $resultat['Quartier']; ?> </h5>
					  <p style="text-align: justify;"> 
						<?php echo utf8_encode($description_finale); ?> 
					  </p>
					 <h4 style="text-align:center;"> <span class="" href="#" style="color: blue;">Chambres <?php echo $resultat['NbChambre']; ?>  : </i></span> <a class="btn btn-primary" href="#">$<?php echo $resultat['Prix']; ?></a><a class="btn btn-medium" href="detail.php?idB=<?php echo $resultat['IdM']; ?>">Détail</a></h4>
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
					echo '<li><a href="index.php?page='.$prec.'">&lsaquo;</a> </li>';
					for ($i=1; $i <= $pagesTotales; $i++) { 
						echo '<li active><a href="index.php?page='.$i.'">'.$i.'</a> </li>';
					}
						echo '<li><a href="index.php?page='.$suiv.'">&rsaquo;</a> </li>';
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