<?php 
	include('config/connexion.php');

	
	///Etat de la maison
	$etatMaison = 'Innocupee';
	$statutMaison = 'Valide';
	$statut = '';

//Requette pour afficher le nombre des maisons disponibles
	$req = $bdd->prepare('SELECT COUNT(*) as nb FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
	$req->execute(array('etat' => $etatMaison, 'statutMaison' => $statutMaison));
	$resultat = $req->fetch();

	if (isset($_GET['idB'])) {
		$idM = $_GET['idB'];
		

		$req = $bdd->prepare('SELECT * FROM maisons,bailleurs WHERE maisons.IdB = bailleurs.IdBail');
		$req->execute();
		$result = $req->fetch();

		$nom = $result['NomBail'];

		$reqM = $bdd->prepare('SELECT * FROM maisons WHERE IdM = :id');
		$reqM->execute(array('id' => $idM ));
		$res = $reqM->fetch();
		$photo = $res['Photo'];

	//Enregistrement de la commande locataire
		$statu = 'Invalide';
		$dtRes = date('Y-m-d');
		if (isset($_POST['validerDem'])) {
			$nbMois = $_POST['nbMois'];
			if ($nbMois == 0) {
				echo "<script>alert('Le mois est invalide')</script>";
				echo '<meta http-equiv = "refresh" content = "0">';
			}else{
					//On teste si la maison exite deja ou en cours de reservation
				$reqMaison = $bdd->prepare('SELECT * FROM reservations WHERE IdMaison = :idMaison');
				$reqMaison->execute(array('idMaison' => $idM));
				$maisomExist = $reqMaison->rowCount();
				//Si la maison exist
				if ($maisomExist == 0) {
					$reqEnreg = $bdd->prepare('INSERT INTO reservations (DateRes,NbMois,StatutRes,IdLocat,IdMaison) VALUES (:dtRes,:nbMois, :statRes, :idLoc, :idM)');
					$reqEnreg->execute(array('dtRes' => $dtRes ,'nbMois' => $nbMois ,'statRes' => $statu,'idLoc' => $idLoc,'idM' => $idM));
					if ($reqEnreg) {
						$st = 'Ok';
					}else{
						//echo "<script type='text/javascript'>alert('Une rerreur est survenue')</script>";
						$stf = 'Faux';
					}
				}else{
					$stEx = "Exist";
				}
			}

		}
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Allocation Houses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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
    <a class="brand" href="maisonsLoc.php"><img src="themes/images/logo.png" alt="Bootsshop"/></a>
		
    <ul id="topMenu" class="nav pull-right">
	 <li class=""><a href="contact.php">Contact</a></li>
	 <li class="">
	  <a href="#login" role="button" data-toggle="modal" style="padding-right:0"><span class="btn btn-medium btn-info">Connexion</span></a>
	 <!-- Bloc valider inscrption -->
	
	<div id="login" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Faire une réservation</h3>
		  </div>
		  <div class="modal-body">
			<form class="form-vertical loginFrm" method="POST" action="index.php" >
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
    <li><a href="index.php">Maisons</a> <span class="divider">/</span></li>
    <li class="active">Detail sur la maison</li>
    

    </ul>	
	<div class="row">	
	<!-- ============= Message pour notifier l'enregistremt ========== -->
	<div class="span9 ">
	<?php 
		if (isset($st)) {
			echo '<div class="alert alert-block alert-success fade in">';
		    echo '<a href = "maisonsLoc.php" class="close" >×</a>';
		    echo '<strong>La réservation s\'est bien effectuée';
			echo '</div>';	
		}elseif (isset($stf)) {
			echo '<div class="alert alert-block alert-error fade in">';
		    echo '<a href = "maisonsLoc.php" class="close" >×</a>';
		    echo '<strong>Une erreur s\'est produite lors de la réservation ';
			echo '</div>';
		}elseif (isset($stEx)) {
			echo '<div class="alert alert-block alert-info fade in">';
		    echo '<a href = "maisonsLoc.php" class="close" >×</a>';
		    echo '<strong>Cette maison est en cours de réservation vueillez choisir une autre ! ';
			echo '</div>';
		}
	?>  </div>
			<div id="gallery" class="span4">
            <a href="themes/images/maisons/<?php echo $photo; ?>" title="Visualiser">
				<img src="themes/images/maisons/<?php echo $photo; ?>" style="width:100%" alt="Fujifilm FinePix S2950 Digital Camera"/>
            </a>
            
			<div id="differentview" class="moreOptopm carousel slide">
                <div class="carousel-inner">
                  <div class="item active">
                	<?php 
                  		$req = $bdd->prepare('SELECT * FROM galeries WHERE galeries.IdMaison = :idPhot ORDER BY IdIm DESC LIMIT 6 ');
                  		$req->execute(array('idPhot' => $idM ));
                  		while ($resultt = $req->fetch()) {
                   	?>

                   <a href="themes/images/galerie/<?php echo $resultt['Galerie']; ?>"> <img style="width:30%" src="themes/images/galerie/<?php echo $resultt['Galerie']; ?>" alt=""/></a>
                    <?php } ?>
                  </div>
                </div>
              </div>
			 
			</div>
			<div class="span5">
				<h3><?php echo utf8_encode($res['Libelle']); ?></h3>
				<h4>Av <?php echo $res['Avenue']; ?> </h4>
				<medium>- <?php echo $resultt['Description'].' Chambres'; ?></medium>

				<form class="form-horizontal qtyFrm pull-center" method="POST" action="">
				  <div class="control-group">
					<label class="control-label"></label><h2>Prix : $<?php echo $res['Prix']; ?></h2>
					
				  </div>
				</form>
				<hr class="soft"/>
				
				
				
				<hr class="soft"/>
				<h4 style="color: blue;">Description de l'Annonce</h4>
				
				<p style="font-size: 16px; font-family: 'Trebuchet MS',Verdana; ">
				<?php echo utf8_encode($res['Description']); ?>
				</p>

				<a class="btn btn-small pull-right" href="index.php">Continuer la réservation</a>
				<br class="clr"/>
			<a href="#" name="detail"></a>
			<hr class="soft"/>
			</div>
		</div>
</div>
</div> </div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
	<?php 
		include('include/footer.php');
	?>
</body>
</html>
	