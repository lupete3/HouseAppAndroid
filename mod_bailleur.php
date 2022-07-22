<?php
	include('config/connexion.php');

	session_start();
	if (isset($_SESSION['idBail'])) {
			$idBail = $_GET['idBail'];

	///Etat de la maison
	$etatMaison = 'Innocupee';
	$statutMaison = 'Valide';
	$etatMaisonVal = 'Occupee';
	$etatMaisonInnoc = 'Innocupee';
	$statutMaisonInval = 'Invalide';
	


//Requette pour afficher le nombre des maisons disponibles
	$req = $bdd->prepare('SELECT COUNT(*) as nb FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison ');
	$req->execute(array('etat' => $etatMaison,'statutMaison' => $statutMaison ));
	$resultat = $req->fetch();
	//Requette pour annuler une reservation
    if (isset($_GET['idBail'])) {
        	//Requette pour recuperer num de reservation
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

        }else{
        	header('Location:espace_bailleur.php');
        }
	
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Gestion des maisons</title>
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
			<li><a href="espace_admin.php">Accueil</a> <span class="divider">/</span></li>
			<li><a href="gBailleurs.php">Gestion Bailleur</a> <span class="divider">/</span></li>
			<li class="active"> Modification Bailleur</li>
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
					<table align="center">
						<tr>
							<td>
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
							</td><td>
							<td >
								<span  style="margin-left: 20px;"><a href="themes/images/avatar_bail/<?php echo $result['Avatar']; ?>">
				  				<img width="200" src="themes/images/avatar_bail/<?php echo $result['Avatar']; ?>" alt=""/></a>
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