<?php
	include('config/connexion.php');

	session_start();

	if (isset($_SESSION['idAdmin'])) {
		# on recupere l'id de l'admin
		$idAdmin = $_SESSION['idAdmin'];
		$statutResVal = 'Valide';

		///Etat de la maison
		$etatMaison = 'Innocupee';
		$statutMaison = 'Valide';
		$statutRes = 'Invalide';

		//Requette pour afficher le nombre de reservations de maisons
		$reqNb = $bdd->prepare('SELECT COUNT(*) as nbRes FROM reservations, maisons  WHERE reservations.IdMaison = maisons.IdM AND reservations.StatutRes = :statutRes');
		$reqNb->execute(array('statutRes' => $statutResVal));
		$resNb = $reqNb->fetch();

		//Requette pour afficher le nombre des reservations valides
		$req = $bdd->prepare('SELECT COUNT(*) as nb FROM maisons WHERE maisons.EtatMaison = :etat AND maisons.StatutMaison = :statutMaison');
		$req->execute(array('etat' => $etatMaison, 'statutMaison' => $statutMaison));
		$resultat = $req->fetch();

		//Requette pour afficher le nombre des reservations valides dans ibanda
		$reqNb = $bdd->prepare('SELECT * FROM reservations, maisons,agents  WHERE reservations.IdMaison = maisons.IdM AND reservations.IdAgent = agents.IdAg AND reservations.StatutRes = :statutReserv AND maisons.Commune = :commune');
		$reqNb->execute(array('statutReserv' => $statutResVal,'commune' => 'Ibanda'));
		$nbMaisonsIband = $reqNb->rowCount();

		//Requette pour afficher le nombre des reservations valides dans Kadutu
		$reqNb = $bdd->prepare('SELECT * FROM reservations, maisons,agents  WHERE reservations.IdMaison = maisons.IdM AND reservations.IdAgent = agents.IdAg AND reservations.StatutRes = :statutReserv AND maisons.Commune = :commune');
		$reqNb->execute(array('statutReserv' => $statutResVal,'commune' => 'Kadutu'));
		$nbMaisonsKad = $reqNb->rowCount();

		//Requette pour afficher le nombre des reservations valides dans Bagira
		$reqNb = $bdd->prepare('SELECT * FROM reservations, maisons,agents  WHERE reservations.IdMaison = maisons.IdM AND reservations.IdAgent = agents.IdAg AND reservations.StatutRes = :statutReserv AND maisons.Commune = :commune');
		$reqNb->execute(array('statutReserv' => $statutResVal,'commune' => 'Bagira'));
		$nbMaisonsBag = $reqNb->rowCount();


		//Requette ppour afficher le nombre de reservations de maisons en cours
		$reqNbInval = $bdd->prepare("SELECT COUNT(*) as nbResInval FROM reservations WHERE reservations.StatutRes = '$statutRes'");
		$reqNbInval->execute();
		$resNbInval = $reqNbInval->fetch();


		//Requette pour afficher le nombre des reservations en cours dans Ibanda
		$reqNb = $bdd->prepare('SELECT * FROM reservations, maisons  WHERE reservations.IdMaison = maisons.IdM  AND reservations.StatutRes = :statutReservInv AND maisons.Commune = :commune');
		$reqNb->execute(array('statutReservInv' => $statutRes,'commune' => 'Ibanda'));
		$nbMaisonsInvIband = $reqNb->rowCount();
		
		//Requette pour afficher le nombre des reservations en cours dans Kadutu
		$reqNb = $bdd->prepare('SELECT * FROM reservations, maisons  WHERE reservations.IdMaison = maisons.IdM  AND reservations.StatutRes = :statutReservInv AND maisons.Commune = :commune');
		$reqNb->execute(array('statutReservInv' => $statutRes,'commune' => 'Kadutu'));
		$nbMaisonsInvKad = $reqNb->rowCount();
		
		//Requette pour afficher le nombre des reservations en cours dans Bagira
		$reqNb = $bdd->prepare('SELECT * FROM reservations, maisons  WHERE reservations.IdMaison = maisons.IdM  AND reservations.StatutRes = :statutReservInv AND maisons.Commune = :commune');
		$reqNb->execute(array('statutReservInv' => $statutRes,'commune' => 'Bagira'));
		$nbMaisonsInvBag = $reqNb->rowCount();
		


		//Delimiter le nombre des maisons a afficher par page
	$maisonsparPage = 6;
	$totalMaisonsReq = $bdd->prepare("SELECT * FROM reservations,locataires,maisons,agents WHERE 
            		reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison = maisons.IdM AND reservations.StatutRes = '$statutRes'");
	$totalMaisonsReq->execute();
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
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Gestion des réservation</title>
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
			 <li class=""><a href="gMaisons.php">Maisons</a></li>
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
					<a id="myCart" href="product_summary.html"><i style="margin-left: 10px;" class="icon-user"></i>Total Reservations<span class="badge badge-info pull-right"><?php echo $resNb['nbRes'];?></span></a>
				</div>
				<ul id="sideManu" class="nav nav-tabs nav-stacked">
					<li class="subMenu open"><a> IBANDA 
						<?php 
						echo "[ ".$nbMaisonsIband." ]"; 
						?></a>
						
					</li>
					<li class="subMenu"><a> KADUTU 
						 
						<?php 
						echo "[ ".$nbMaisonsKad." ]"; 
						?></a>
					</li>

					<li class="subMenu"><a>BAGIRA 
						
						<?php 
						echo "[ ".$nbMaisonsBag." ]"; 
						?></a>
					</li>			
				</ul>
				<br/>
				<div class="well well-small">
					<a id="myCart" href="product_summary.html"><i style="margin-left: 10px;" class="icon-user"></i>Réservations en cours<span class="badge badge-inverse pull-right"><?php echo $resNbInval['nbResInval'];?></span></a>
				</div>
				<ul id="sideManu" class="nav nav-tabs nav-stacked">
					<li class="subMenu open"><a> IBANDA 
						<?php 
						echo "[ ".$nbMaisonsInvIband." ]"; 
						?></a>
						
					</li>
					<li class="subMenu"><a> KADUTU 
						 
						<?php 
						echo "[ ".$nbMaisonsInvKad." ]"; 
						?></a>
					</li>

					<li class="subMenu"><a>BAGIRA 
						
						<?php 
						echo "[ ".$nbMaisonsInvBag." ]"; 
						?></a>
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
					<li><a href="espace_admin.php">Espace_Adminstrateur</a> <span class="divider">/</span></li>
					<li class="active"> Gestion Réservations</li>
			    </ul>
	
					<!-- ========================================================================================================= -->
					<!-- =================== Bloc suppression du agents ========================================================== -->
					<!-- ========================================================================================================= -->
				<div class="tab-content">
					<?php if (isset($_GET['action'])=='supp') { 

							$reqAff = $bdd->prepare('SELECT * FROM reservations,locataires,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.Idmaison = maisons.IdM AND IdRes = :idRes');
						    $reqAff->execute(array('idRes' => $_GET['idRes']));
						    $result = $reqAff->fetch();
						    $idRes = $result['IdRes'];
						    if ($result) {
						    # requette pourannuler une reservations
						        if (isset($_POST['annulerRes'])) {
						        		
									$req = $bdd->prepare('DELETE FROM reservations WHERE IdRes = :idRes');
							        $req->execute(array('idRes' => $_GET['idRes'] ));
								    if ($req) {
								        header('Location:gReservations.php');
								        echo "<meta http-equiv='refresh' content'0;URL=gReservations.php'>";
								    }else{
								        		
								    }	        	
								        
						        }
						    }
						?>
						
					<div id="login" class="modal  fade in"  role="dialog" aria-labelledby="login" aria-hidden="false" >
					  <div class="modal-header">
						<a href="gReservations.php" class="close"><span >x</span><meta http-equiv='refresh' content'0;URL=gReservations.php'></a>
						<h3>Annuler Réservation </h3>
					  </div>
			  			<div class="modal-body" style="text-align: center;">
							<form class="form-vertical loginFrm" method="POST" action="" >
					
				  				<h4> Voulez-vous vraiment annuler cette réservations de ? <h4 style="color: blue;"><?php echo $result['NomLoc'].' ?'; ?></h4> </h4>
							  	<table align="center">
								  <tr class="gallery">
								  	<td colspan="2">
								  		<span >
								  			<a href="themes/images/maisons/<?php echo $result['Photo']; ?>"><img width="200" style="border-radius: 200px;" src="themes/images/maisons/<?php echo $result['Photo']; ?>" alt=""/>
								  			</a>
								  		</span>
								  	</td>
								  </tr>
								  
								  <tr><td>
								  	<div class="control-group">	
								  	<input type="submit" id="inputEmail" class="btn btn-success" value="Oui" name="annulerRes">
								  	<a href="gReservations.php" id="inputEmail" class="btn btn-default"><span >Non</span><meta http-equiv='refresh' content'0;URL=gReservations.php'></a> 
								  	
								  </div></td>

								 </tr>	
								</table>		
							</form>		
			  			</div>
					</div>
					<!-- ======================================================================================================= -->
					<!-- =================== Bloc validation reservation ======================================================= -->
					<!-- ====================================================================================================== -->

					<?php }elseif(isset($_GET['idResValid'])){ 

						$idRes = $_GET['idResValid'];
						//Requette pour recuperer num reservation
						$reqt = $bdd->prepare('SELECT * FROM reservations WHERE  IdRes = :idRes');
						$reqt->execute(array('idRes' => $idRes));
						$result = $reqt->fetch();
						$idRes = $result['IdRes'];
						$idm = $result['IdMaison'];
						if ($result) {
						    $statutResVal = 'Valide';
						    $accord = 'Non';
						    $dtValid = date('Y-m-d');
						        	
						    $reqMod = $bdd->prepare('UPDATE reservations SET DebutContrat = :dtDebut, StatutRes = :statutResVal, IdAgent = :idAgent, Accord = :accord WHERE IdRes = :idRes');
							$reqMod->execute(array('dtDebut' => $dtValid, 'statutResVal' => $statutResVal,'idAgent' => $idAdmin,'accord' => $accord,'idRes' => $idRes));
							if ($reqMod) {
								$reqMod = $bdd->prepare('UPDATE maisons SET EtatMaison = :etatMaison WHERE IdM = :idm');
							$reqMod->execute(array('etatMaison' => 'Occupee', 'idm' => $idm));
								header('Location:gReservations.php');
							}else{
								header('Location:gReservations.php');
							}
						}
					?>
					<!-- ======================================================================================================= -->
					<!-- =================== Bloc pour afficher les reservations en cours ================================ -->
					<!-- ====================================================================================================== -->
					<?php }else{ ?>
  
					<!-- ================ Formulaire pour faire la recherche du l'agnt ======================= -->	 	
					<center>
						<form class="form-horizontal span9" method="POST"  action="">
							<div class="control-group">
								<input id="srchFld" type="date"  style="padding-left: 30px;"class="input-xlarge srchFld input-medium search-query" placeholder="Selectionner une date " name="dtResRech">
							  
							  <input type="submit" name="rechercher" style="margin-top: 5px;" value="Rechercher" class="btn btn-primary" >  
							</div>

						</form>	 	
					</center>
					
					<br class="clr"/>
					<div class="tab-content ">
						<div class="tab-pane active" id="listView">
						 	<?php
						        if (isset($_POST['rechercher'])) {
						           $dateRes = $_POST['dtResRech'];
						           $reqRes = $bdd->prepare("SELECT * FROM reservations,locataires,maisons,agents
						           WHERE 
						            	reservations.IdLocat = locataires.IdLoc 
						            	AND reservations.IdMaison = maisons.IdM 
						            	AND reservations.StatutRes = '$statutRes' 
						            	AND DateRes LIKE '%$dateRes%' ORDER BY DateRes ASC");
						            $reqRes->execute();
						            $nbb = $reqRes->rowCount();
						            //On test s'il ya un des maisons disponibles apres affichage
									if($nbb > 0){
						            while ($resAdmin = $reqRes->fetch()) { ?>
            				<div class="row">	  
								<div class="span2">
									<a href="themes/images/maisons/<?php echo $resAdmin['Photo']; ?>"><img style="width:100%" src="themes/images/maisons/<?php echo $resAdmin['Photo']; ?>" alt=""/></a>
								</div>
								<div class="span4" style="text-align: justify;">
									<h5 style="text-align: justify;"><?php echo $resAdmin['NbChambre']; ?> | Chambres Du <?php echo $resAdmin['DateRes']; ?> Réservée par Mrs/Msell <?php echo $resAdmin['NomLoc']; ?> De <?php echo $resAdmin['NbSalon']; ?> Salon(s)</h5>				
									
									<h5><?php echo $resAdmin['Commune']; ?> / <?php echo $resAdmin['Quartier']; ?> / Av <?php echo $resAdmin['Avenue']; ?></h5>
									<p style="text-align: justify;">
									<?php echo utf8_encode($resAdmin['Description']); ?>
									</p>
									
								</div>
								<div class="span3 alignR">
									<div class="form-horizontal qtyFrm">
										<h4> $<?php echo $resAdmin['Prix']; ?></h4>
										 Numero de la maison <medium class="label"><?php echo $resAdmin['Num']; ?></medium>
										<br/>
										<br/>
										<div class="row">
											<table align="right">
												<tr style="margin-bottom: 10px;">
													<td>Locataire : <?php echo $resAdmin['NomLoc']; ?> </td>
													<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resAdmin['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resAdmin['AvatarLoc']; ?>"  alt=""/></a>
													</td>
												</tr>
											</table>
										</div>
									</div><br><br>
									  <a href="?idResValid=<?php echo $resAdmin['IdRes']; ?>"  style="margin-right:10px"><span class="btn btn-medium btn-primary">Valider</span></a>
									  <a href="?action=supp&idRes=<?php echo $resAdmin['IdRes']; ?>" ><span class="btn btn-medium btn-danger pull-right">Annuler</span></a>
								</div>
								<hr class="soft"/> 
							</div>
				            <?php }
				            		}elseif ($nbb <= 0) {
									echo '<center>
									<h2>Aucune Réservation correspondant à cette date </h2>
									<a href="gReservations.php"><h4 style="color:green"><==</h4></a></center>';
								}
            					}else{
					            	$statutRes = 'Invalide';

					            	$reqRes = $bdd->prepare("SELECT * FROM reservations,locataires,maisons,agents WHERE 
					            		reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison = maisons.IdM AND reservations.StatutRes = '$statutRes' ORDER BY DateRes ASC");
					            	$reqRes->execute();
					            	$nbb = $reqRes->rowCount();
					            		//On test s'il ya un des maisons disponibles apres affichage
									if($nbb > 0){
					            		while ($resAdmin = $reqRes->fetch()) { ?>   			  
							<div class="row">	  
								<div class="span2">
									<a href="themes/images/maisons/<?php echo $resAdmin['Photo']; ?>"><img style="width:100%" src="themes/images/maisons/<?php echo $resAdmin['Photo']; ?>" alt=""/></a>
								</div>
								<div class="span5" style="text-align: justify;">
									<h5 style="text-align: justify;"><?php echo $resAdmin['NbChambre']; ?> | Chambres Du <?php echo $resAdmin['DateRes']; ?> Réservée par Mrs/Msell <?php echo $resAdmin['NomLoc']; ?> De <?php echo $resAdmin['NbSalon']; ?> Salon(s)</h5>				
									
									<h5><?php echo $resAdmin['Commune']; ?> / <?php echo $resAdmin['Quartier']; ?> / Av <?php echo $resAdmin['Avenue']; ?></h5>
									<p style="text-align: justify;">
									<?php echo utf8_encode($resAdmin['Description']); ?>
									</p>
									
								</div>
								<div class="span2 alignR">
									<div class="form-horizontal qtyFrm">
										<h4> $<?php echo $resAdmin['Prix']; ?></h4>
										 Numero de la maison <medium class="label"><?php echo $resAdmin['Num']; ?></medium>
										<br/>
										<br/>
										<div class="row">
											<table align="right">
												<tr style="margin-bottom: 10px;">
													<td>Locataire : <?php echo $resAdmin['NomLoc']; ?> </td>
													<td rowspan="2"><a href="themes/images/avatar_loc/<?php echo $resAdmin['AvatarLoc']; ?>"><img style="width: 40px; height: 40px; border-radius: 20px;" src="themes/images/avatar_loc/<?php echo $resAdmin['AvatarLoc']; ?>"  alt=""/></a>
													</td>
												</tr>
											</table>
										</div>
									</div><br><br>
									  <a href="?idResValid=<?php echo $resAdmin['IdRes']; ?>"  style="margin-right:10px"><span class="btn btn-medium btn-primary">Valider</span></a>
									  <a href="?action=supp&idRes=<?php echo $resAdmin['IdRes']; ?>" ><span class="btn btn-medium btn-danger pull-right">Annuler</span></a>
								</div>
							</div>
							<hr class="soft"/> 
				   			
				   			<?php 
				   				} 
				   			}elseif ($nbb <= 0) {
								echo '<center>
								<h2>Aucune Réservation en cours de réservations </h2>
								<a href="espace_admin.php"><h4 style="color:green"><==</h4></a></center>';
								}
				   			}  
				   			} ?>
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
	</div>	
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