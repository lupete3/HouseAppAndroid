<?php
	include('config/connexion.php');

	session_start();
	if (isset($_SESSION['idBail'])) {
			$idBail = $_SESSION['idBail'];

	///Etat de la maison
	$etatMaison = 'Innocupee';
	$statutMaison = 'Valide';
	$etatMaisonVal = 'Occupee';
	$etatMaisonInnoc = 'Innocupee';
	$statutMaisonInval = 'Invalide';
	$statut = '';


//Requette pour afficher le nombre des maisons disponibles
	$req = $bdd->prepare('SELECT COUNT(*) as nb FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ');
	$req->execute(array('etat' => $etatMaison,'statutMaison' => $statutMaison ));
	$resultat = $req->fetch();
	//Requette pour annuler une reservation
        if (isset($_GET['idIm'])) {
        	//Requette pour recuperer num de reservation
			$reqt = $bdd->prepare('SELECT * FROM galeries WHERE  IdIm = :idIm');
	        $reqt->execute(array('idIm' => $_GET['idIm']));
	        $result = $reqt->fetch();
	        $idIM = $result['IdIm'];
	        if ($result) {
	        	
	        	if (isset($_POST['modifier'])) {
	        		# om recupere la photo
					$ptName = $_FILES['photo']['name'];

        				$tailleMax = 3097152;
        				$extValide = array('jpg','jpg','png','gif' );

        				if ($_FILES['photo']['size'] <= $tailleMax) {
        					$extentionUpload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
        					if (in_array($extentionUpload, $extValide)) {
        						$chemin = "themes/images/galerie/".$idIM.".".$extentionUpload;
        						$resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
        						if ($resultat) {
        							$reqMod = $bdd->prepare('UPDATE galeries SET 
				        			LibellePhoto = :libelle, 
				        			DescriptionPhoto = :description,
				        			Galerie = :photo 
				        			WHERE IdIm = :idIm');

				        			$reqMod->execute(array(
				        			'libelle' => $_POST['libelle'],
				        			'description' => $_POST['description'],
				        			'photo' => $idIM.".".$extentionUpload,
				        			'idIm' => $idIM
				        			
				        			 ));
				        			if ($reqMod) {
				        				$statut = 'Modification reussie !';
				        				header('Location:add_mod_photo.php');
				        			}else{
				        				$statut = 'Erreur lors de la Modification';
				        			}
        						}else{
        							$statut = 'Erreur lors de l\' importation de la photo';
        						}
        					}else{
        						$statut = 'Le format de votre photo n\' est pas valide';
        					}
        				}else{
        					$statut = 'La taille de la photo n\'est pas valide';
        				}
	        	}
	        }

        }else{
        	header('Location:espace_bailleur.php');
        }
	
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Gestion photos</title>
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
			    <a class="brand" href="index.html"><img src="themes/images/logo1.png" alt="HousesAllocation" title="HousesAllocation" /></a>
				
			    <ul id="topMenu" class="nav pull-right">
					 <li class=""><a href="espace_bailleur.php">Accueil</a></li>
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
			<li><a href="espace_bailleur.php">Accueil</a> <span class="divider">/</span></li>
			<li><a href="add_mod_photo.php">Gestion_Photo</a> <span class="divider">/</span></li>
			<li class="active"> Modification photo</li>
	    </ul>
	
		<div id="grids">
			<ul class="nav nav-tabs" id="myTab">
			  <li  class="active"><a href="#two" data-toggle="tab" class="label label-warning"> Modification de la Photo</a></li>
			</ul>
  		<div class="tab-pane active" id="two">
		  	<div class="row-fluid">
				<div class="span12">
		      <!-- Historique des maisons deja vaidees -->	
				<div class="well">
					<h3 style="text-align: center">Modifier la photo</h3><br/>
					<table align="center">
						<tr>
							<td>
								<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">		
									<div class="control-group">
										<label class="control-label" for="inputFname1">Libelle <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <textarea class="input-xlarge" id="textarea"  style="height:65px" name="libelle"><?php echo utf8_encode($result['LibellePhoto']); ?></textarea>
										</div>
									 </div>		
									<div class="control-group">
										<label class="control-label" for="inputFname1">Description <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <textarea class="input-xlarge" id="textarea"  style="height:65px" name="description"><?php echo utf8_encode($result['DescriptionPhoto']); ?></textarea>
										</div>
									 </div> 	  
									<div class="control-group">
										<label class="control-label" for="inputPassword1">Date Création <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="date" id="inputEmail" class="input-xlarge" name="dtCreation" placeholder="Date Creation" value="<?php echo $result['DateCreation']; ?>" required>
										</div>
									  </div>   
									<div class="control-group">
										<label class="control-label" for="inputPassword1">Photo <sup style="color: red;">*</sup></label>
										<div class="controls">
										  <input type="file" id="inputEmail" class="input-xlarge" name="photo" placeholder="Photo " required>
										</div>
									  </div>
										<div class="control-group">
												<div class="controls">
													<?php if (isset($statut)) {
												  		echo '<label style="color:red">'.$statut.'</babel>';
												  	} ?>
													<input class="btn btn-large btn-info" type="submit" name="modifier" value="Modifier" />
												</div>
											</div>		
								</form>
							</td><td>
							<td >
								<span  style="margin-left: 20px;"><a href="themes/images/galerie/<?php echo $result['Galerie']; ?>">
				  				<img width="200" src="themes/images/galerie/<?php echo $result['Galerie']; ?>" alt=""/></a>
				  			</span>
				  		    </td>
				  		</tr>  
				  	</table>
				</div>
	 	    </div>
  		</div>
  	</div>
 </div>
  
</div>
</div>	

</div>
</div>
</div>
</div>
<!-- Footer ================================================================== -->
	<?php include('include/footer.php'); ?>

</body>
</html>
<?php 
	}else{ 
		header('Loction:index.php');
	} 
?>