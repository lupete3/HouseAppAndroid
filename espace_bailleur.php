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

	///////////////// Valider la reservation ////////////////////////
	if (isset($_GET['idResVal'])) {
		# code...
		$idResVal = $_GET['idResVal'];
		$accord = 'Oui';
		$dtValid = date('Y-m-d');
						        	
		$reqMod = $bdd->prepare('UPDATE reservations SET DebutContrat = :dtValid, Accord = :accord WHERE IdRes = :idRes');
		$reqMod->execute(array('dtValid' => $dtValid,'accord' => $accord,'idRes' => $idResVal));
		if ($reqMod) {
			
			header('Location:espace_bailleur.php');
		}else{
			header('Location:espace_bailleur.php');
		}
	}else if (isset($_GET['idResAnn'])) {
		# code...
		$idResAnn = $_GET['idResAnn'];
		
		$reqt = $bdd->prepare('SELECT * FROM reservations WHERE  IdRes = :idRes');
		$reqt->execute(array('idRes' => $idResAnn));
		$result = $reqt->fetch();
		$idRes = $result['IdRes'];
		$idm = $result['IdMaison'];
		if ($result) {
			$statutResVal = 'Valide';
			$accord = 'Non';
			$dtValid = date('Y-m-d');
						        	
			$reqMod = $bdd->prepare('DELETE FROM reservations WHERE IdRes = :idRes');
			$reqMod->execute(array('idRes' => $idResAnn));
			if ($reqMod) {
				$reqMod = $bdd->prepare('UPDATE maisons SET EtatMaison = :etatMaison WHERE IdM = :idm');
				$reqMod->execute(array('etatMaison' => 'Innocupee', 'idm' => $idm));
					header('Location:espace_bailleur.php');
			}else{
				header('Location:espace_bailleur.php');
			}
		}	
							
	}

	//Requette pour afficher le nombre total des maisons louées
	$accord = 'Oui';
    $reqValid = $bdd->prepare('SELECT * 
	FROM reservations, locataires, maisons, bailleurs, agents
	WHERE reservations.IdLocat = locataires.IdLoc
	AND reservations.IdMaison = maisons.IdM
	AND maisons.IdB = bailleurs.IdBail
	AND reservations.IdAgent = agents.IdAg
	AND maisons.EtatMaison = :etatMaisonVal
	AND maisons.StatutMaison = :statutMaison
	And reservations.Accord = :accord
	AND bailleurs.IdBail = :idBail');
    $reqValid->execute(array('etatMaisonVal' => $etatMaisonVal , 'statutMaison' => $statutMaison,'accord' => $accord, 'idBail' => $idBail ));
    $nbMaisonL = $reqValid->rowCount();

	//Requette pour afficher le nombre total des maisons louées dansla commune d'Ibanda
    $reqValid = $bdd->prepare('SELECT * 
	FROM reservations, locataires, maisons, bailleurs, agents
	WHERE reservations.IdLocat = locataires.IdLoc
	AND reservations.IdMaison = maisons.IdM
	AND maisons.IdB = bailleurs.IdBail
	AND reservations.IdAgent = agents.IdAg
	AND maisons.EtatMaison = :etatMaisonVal
	AND maisons.StatutMaison = :statutMaison
	AND reservations.Accord = :accord
	AND bailleurs.IdBail = :idBail
	AND maisons.Commune = :commune');
    $reqValid->execute(array('etatMaisonVal' => $etatMaisonVal , 'statutMaison' => $statutMaison, 'accord' => $accord,'idBail' => $idBail, 'commune' => 'Ibanda' ));
    $nbMaisonIband = $reqValid->rowCount();

	//Requette pour afficher le nombre total des maisons louées dansla commune de kadutu
    $reqValid = $bdd->prepare('SELECT * 
	FROM reservations, locataires, maisons, bailleurs, agents
	WHERE reservations.IdLocat = locataires.IdLoc
	AND reservations.IdMaison = maisons.IdM
	AND maisons.IdB = bailleurs.IdBail
	AND reservations.IdAgent = agents.IdAg
	AND maisons.EtatMaison = :etatMaisonVal
	AND maisons.StatutMaison = :statutMaison
	AND reservations.Accord = :accord
	AND bailleurs.IdBail = :idBail
	AND maisons.Commune = :commune');
    $reqValid->execute(array('etatMaisonVal' => $etatMaisonVal , 'statutMaison' => $statutMaison, 'accord' => $accord,'idBail' => $idBail, 'commune' => 'Kadutu' ));
    $nbMaisonKad = $reqValid->rowCount();

	//Requette pour afficher le nombre total des maisons louées dansla commune de Bagira
    $reqValid = $bdd->prepare('SELECT * 
	FROM reservations, locataires, maisons, bailleurs, agents
	WHERE reservations.IdLocat = locataires.IdLoc
	AND reservations.IdMaison = maisons.IdM
	AND maisons.IdB = bailleurs.IdBail
	AND reservations.IdAgent = agents.IdAg
	AND maisons.EtatMaison = :etatMaisonVal
	AND maisons.StatutMaison = :statutMaison
	AND reservations.Accord = :accord
	AND bailleurs.IdBail = :idBail
	AND maisons.Commune = :commune');
    $reqValid->execute(array('etatMaisonVal' => $etatMaisonVal , 'statutMaison' => $statutMaison, 'accord' => $accord,'idBail' => $idBail, 'commune' => 'Bagira' ));
    $nbMaisonBag = $reqValid->rowCount();


    //Requete pour afficher le nombre des maisons en cours reservation
	$req = $bdd->prepare('SELECT * FROM bailleurs,maisons WHERE maisons.IdB = bailleurs.Idbail AND maisons.EtatMaison = :etatMaisonInnoc AND maisons.StatutMaison = :statutMaisonInval AND maisons.IdB = :idBail');
    $req->execute(array('etatMaisonInnoc' => $etatMaisonInnoc,'statutMaisonInval' => $statutMaisonInval,'idBail' => $idBail));
    $nbMaisonInval = $req->rowCount();
    
    //Requete pour afficher le nombre des maisons en cours reservation dans Ibanda
	$req = $bdd->prepare('SELECT * FROM bailleurs,maisons WHERE maisons.IdB = bailleurs.Idbail AND maisons.EtatMaison = :etatMaisonInnoc AND maisons.StatutMaison = :statutMaisonInval AND maisons.Commune = :commune AND maisons.IdB = :idBail');
    $req->execute(array('etatMaisonInnoc' => $etatMaisonInnoc,'statutMaisonInval' => $statutMaisonInval,'commune' => 'Ibanda','idBail' => $idBail));
    $nbMaisonInvalIband = $req->rowCount();

    
    //Requete pour afficher le nombre des maisons en cours reservation dans Kadutu
	$req = $bdd->prepare('SELECT * FROM bailleurs,maisons WHERE maisons.IdB = bailleurs.Idbail AND maisons.EtatMaison = :etatMaisonInnoc AND maisons.StatutMaison = :statutMaisonInval AND maisons.Commune = :commune AND maisons.IdB = :idBail');
    $req->execute(array('etatMaisonInnoc' => $etatMaisonInnoc,'statutMaisonInval' => $statutMaisonInval,'commune' => 'Kadutu','idBail' => $idBail));
    $nbMaisonInvalKad = $req->rowCount();

    
    //Requete pour afficher le nombre des maisons en cours reservation dans Bagira
	$req = $bdd->prepare('SELECT * FROM bailleurs,maisons WHERE maisons.IdB = bailleurs.Idbail AND maisons.EtatMaison = :etatMaisonInnoc AND maisons.StatutMaison = :statutMaisonInval AND maisons.Commune = :commune AND maisons.IdB = :idBail');
    $req->execute(array('etatMaisonInnoc' => $etatMaisonInnoc,'statutMaisonInval' => $statutMaisonInval,'commune' => 'Bagira','idBail' => $idBail));
    $nbMaisonInvalBag = $req->rowCount();

	//Requette pour recuperer le nom du bailleur
	$reqProf = $bdd->prepare('SELECT * FROM bailleurs WHERE IdBail = :idBail');
	$reqProf->execute(array('idBail' => $idBail));
	$resProf = $reqProf->fetch();

	//Requette pour modifier le profil du bailleur
	if (isset($_POST['btn_modif'])) {
		//On teste le nom est modofi2
		if ($_POST['nomBail'] != $resProf['NomBail']) {
			# on teste si l'ancien mot de passe est correct
			if ($_POST['ancMdp'] == $resProf['Password']) {
				# On teste le deux nouveaux mot de passes corrspondent
				if ($_POST['nvMdp'] == $_POST['confMdp']) {
					# om recupere la photo
					$ptName = $_FILES['avatarBail']['name'];

        				$tailleMax = 3097152;
        				$extValide = array('jpg','jpg','png','gif' );

        				if ($_FILES['avatarBail']['size'] <= $tailleMax) {
        					$extentionUpload = strtolower(substr(strrchr($_FILES['avatarBail']['name'], '.'), 1));
        					if (in_array($extentionUpload, $extValide)) {
        						$chemin = "themes/images/avatar_bail/".$idBail.".".$extentionUpload;
        						$resultat = move_uploaded_file($_FILES['avatarBail']['tmp_name'], $chemin);
        						if ($resultat) {
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
				        			Password = :password,
				        			TelBail = :telBail, 
				        			Avatar = :avatarBail 
				        			WHERE IdBail = :idBail');

				        			$reqMod->execute(array(
				        			'nomBail' => $_POST['nomBail'],
				        			'prenomBail' => $_POST['prenomBail'],
				        			'sexeBail' => $_POST['sexeBail'],
				        			'dtBail' => $_POST['dateNaissBail'],
				        			'etatCivilBail' => $_POST['etatCivilBail'],
				        			'nationaliteBail' => $_POST['nationaliteBail'],
				        			'residenceBail' => $_POST['residenceBail'],
				        			'emailBail' => $_POST['emailBail'],
				        			'NumPieceIdentBail' => $_POST['NumPieceIdentBail'],
				        			'password' => $_POST['confMdp'],
				        			'telBail' => $_POST['telBail'],
				        			'avatarBail' => $idBail.".".$extentionUpload,
				        			'idBail' => $idBail
				        			
				        			 ));
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
		}else{
			$statut = 'Aucune modofication';
		}
	}

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Espace Bailleur</title>
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
    <a class="brand" href="espace_bailleur.php"><img src="themes/images/logo1.png" alt="HousesAllocation" title="HousesAllocation" /></a>
		
    <ul id="topMenu" class="nav pull-right">
	 <li class=""><a href="espace_bailleur.php">Accueil</a></li>
	 <li class=""><a href="add_mod_maison.php">Gestion Maisons</a></li>
	 <li class=""><a href="add_mod_photo.php">Gestion Images</a></li>
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
		<!-- Total maisons Louees -->
		<div class="well well-small">
			<a id="myCart" href=""><img src="themes/images/ico-cart.png" alt="cart">Vos maison en Location<span class="badge badge-warning pull-right"><?php echo $nbMaisonL; ?></span></a>
		</div>
		<ul id="sideManu" class="nav nav-tabs nav-stacked">

		<!-- Maisons disponible dans Ibanda -->
			<li class="subMenu open"><a> IBANDA 
				<?php 
					echo "[ ".$nbMaisonIband." ]"; 
				?></a>
			</li>

		<!-- Maisons disponible dans Kadutu -->
			<li class="subMenu"><a> KADUTU 
				<?php 
					echo "[ ".$nbMaisonKad." ]"; 
				?> </a>
			</li>

		<!-- Maisons disponible dans Bagira -->
			<li class="subMenu"><a>BAGIRA 
				<?php
					echo "[ ".$nbMaisonBag." ]"; 
				?></a>
				
			</li>			
		</ul>
		<br/>

		<!-- Total maisons en cours de reservation -->
		 <div class="well well-small">
			<a id="myCart" href=""><img src="themes/images/ico-cart.png" alt="cart">Vos maison en cours d'offre<span class="badge badge-info pull-right"><?php echo $nbMaisonInval; ?></span></a>
		</div>
		<ul id="sideManu" class="nav nav-tabs nav-stacked">

		<!-- Maisons disponible dans Ibanda -->
			<li class="subMenu open"><a> IBANDA 
				<?php 
					echo "[ ".$nbMaisonInvalIband." ]"; 
				?></a>
			</li>

		<!-- Maisons disponible dans Kadutu -->
			<li class="subMenu"><a> KADUTU 
				<?php 
					echo "[ ".$nbMaisonInvalKad." ]"; 
				?> </a>
			</li>

		<!-- Maisons disponible dans Bagira -->
			<li class="subMenu"><a>BAGIRA 
				<?php
					echo "[ ".$nbMaisonInvalBag." ]"; 
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
		<li><a href="espace_bailleur.php">Accueil</a> <span class="divider">/</span></li>
		<li class="active"> Espace bailleur</li>
		<div class="pull-right" style="font-family: verdana">
		<i><?php echo $_SESSION['nomBail'].' '; ?></i></i><img style="width: 15px;" src="themes/images/products/large/point.png">
		</div>
    </ul>
	

<div id="grids">
<ul class="nav nav-tabs" id="myTab">
  <li><a href="#one" data-toggle="tab" class="label label-success"> Offres en cours</a></li>
  <li  class="active"><a href="#two" data-toggle="tab" class="label label-warning"> Maisons en location</a></li>
  <li><a data-toggle="tab" class="label label-default" href="#for"> Reservation en cours</a></li>
    <li><a data-toggle="tab" class="label label-info" href="#three"> Profil</a></li>

</ul>
 
<div class="tab-content">
  <div class="tab-pane" id="one">
  <div class="row-fluid">
	 <div class="span12">
	 	<ul class="breadcrumb">
	 		<?php 
	 		// Requette pour afficher le nombre des maisons en cours de reservation
	 		$stOff = 'Invalide';
					$req = $bdd->prepare('SELECT COUNT(*) AS nbMInval FROM bailleurs,maisons WHERE maisons.IdB = bailleurs.Idbail AND maisons.EtatMaison = :etatMaisonInnoc AND maisons.StatutMaison = :statutMaisonInval AND maisons.IdB = :idBail');
            		$req->execute(array('etatMaisonInnoc' => $etatMaisonInnoc,'statutMaisonInval' => $statutMaisonInval,'idBail' => $idBail));
            		$result = $req->fetch();
				?>
	 	<h3>  MAISONS EN COURS D'OFFRE [ <small><?php echo $result['nbMInval']; ?> Maisons </small>]<a href="products.html" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continuer l'offre</a></h3>	
	 </ul>
	 		
	<!-- Historique des maisons en cours -->		
	<table class="table table-bordered">
        <thead>
            <tr class="breadcrumb">
                <th>Maisons</th>
                <th>Num Maison</th>
                <th>Nombre Chambre</th>
				<th>Date Offre</th>
                <th>Commune</th>
                <th>Quartier</th>
                <th>Avenu </th>
				<th>Description de la maison</th>
                <th>Prix</th>
                <th>Action</th>
               
			</tr>
        </thead>
            <tbody><?php 
            		//Requette qui affiche les offres en cours
            	$reqOf = $bdd->prepare('SELECT * FROM bailleurs,maisons WHERE maisons.IdB = bailleurs.Idbail AND maisons.EtatMaison = :etatMaisonInnoc AND maisons.StatutMaison = :statutMaisonInval AND maisons.IdB = :idBail');
            		$reqOf->execute(array('etatMaisonInnoc' => $etatMaisonInnoc,'statutMaisonInval' => $statutMaisonInval,'idBail' => $idBail));
            		$nbMaison = $reqOf->rowCount();
            		if($nbMaison > 0){
            		while ($resultOff = $reqOf->fetch()) { ?>
            	
            <tr >
                <td> <a href="themes/images/maisons/<?php echo $resultOff['Photo']; ?>"><img width="200" src="themes/images/maisons/<?php echo $resultOff['Photo']; ?>" alt=""/></a></td>
                <td><?php echo $resultOff['Num']; ?></td>
				<td><?php echo $resultOff['NbChambre']; ?></td>
                <td><?php echo $resultOff['DateOffre']; ?></td>
                <td><?php echo $resultOff['Commune']; ?></td>
                <td><?php echo $resultOff['Quartier']; ?></td>
                <td><?php echo $resultOff['Avenue']; ?></td>
                <td><?php echo utf8_encode($resultOff['Libelle']); ?></td>
                <td>$<?php echo $resultOff['Prix']; ?></td>
                <td><a href="annuler_off.php?idM=<?php echo $resultOff['IdM']; ?>"  style="padding-right:0"><span class="btn btn-medium btn-inverse pull-right">Annuler</span></a></td>
            </tr> 
            <?php 		
            		}}elseif($nbMaison == 0){
            			echo '<tr><td colspan = 9 style="text-align:center;"><h3>Aucune maison en cours de d\'offre </h3><h5 ><a href="add_mod_maison.php" style = "color:green;">Effectuer une offre maintenant</a></h5></td></tr>';
            		}
            	?>
			<tr class="breadcrumb">
                <td colspan="9" style="text-align:right"><strong>TOTAL Maisons =</strong></td>
               	<td class="label label-info" style="display:block;text-align: center;color: white; font-size: 20px;"> <strong><?php echo $result['nbMInval']; ?> </strong></td>
            </tr>
		</tbody>
    </table>
    <hr class="soft"/>

	  </div>
  </div>
  </div>
  <div class="tab-pane active" id="two">
  <div class="row-fluid">
	  <div class="span12">
	  <!-- Historique des maisons deja vaidees -->	

    <ul class="breadcrumb">

    <h3>  HISTORIQUE DES MAISONS LOUEES </h3>	
	 </ul>
		
	<table class="table table-bordered">
        <thead>
            <tr class="breadcrumb">
                <th>Maisons</th>
                <th>Num Maison</th>
                <th>Nombre Chambre</th>
				<th>Nombre Salon</th>
                <th>Avenue</th>
                <th>Prix</th>
                <th>Localaire </th>
				<th>Civilité Locat</th>
				<th>Num Locataire</th>
				<th>Etat Contrat</th>
                <th>Photo Locataire</th>
               
			</tr>
        </thead>
            <tbody>
            	<?php
            	//Historique pour afficher les maisons deja louees
            	$statutVal = 'Valide';
            	$accord = 'Oui';
            		$reqValid = $bdd->prepare('SELECT * 
					FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.IdLocat = locataires.IdLoc
					AND reservations.IdMaison = maisons.IdM
					AND maisons.IdB = bailleurs.IdBail
					AND reservations.IdAgent = agents.IdAg
					AND maisons.EtatMaison = :etatMaisonVal
					AND reservations.Accord = :accord
					AND maisons.StatutMaison = :statutMaison
					AND bailleurs.IdBail = :idBail');

            		$reqValid->execute(array('etatMaisonVal' => $etatMaisonVal ,'accord' => $accord , 'statutMaison' => $statutMaison, 'idBail' => $idBail ));
            		$nbMaisonL = $reqValid->rowCount();
            		if($nbMaisonL > 0){
            		while($resultValid = $reqValid->fetch()){ 
            			$mois = $resultValid['NbMois'];
            			$idRes = $resultValid['IdRes'];
            			include('include/testerContratValide.php');
            		?>
            <tr>
                <td><a href="themes/images/maisons/<?php echo $resultValid['Photo'];?>"> <img width="200" src="themes/images/maisons/<?php echo $resultValid['Photo'];?>" alt=""/></a></td>
                <td><?php echo $resultValid['Num'];?></td>
				<td><?php echo $resultValid['NbChambre'];?></td>
                <td><?php echo $resultValid['NbSalon'];?></td>
                <td><?php echo $resultValid['Avenue'];?></td>
                <td>$<?php echo $resultValid['Prix'];?></td>
                
                <td><?php echo $resultValid['NomLoc'];?></td>
                <td><?php echo utf8_encode($resultValid['EtatCivilLoc']);?></td>
                <td><?php echo $resultValid['TelephoneLoc'];?></td>
                <td><?php if ($data) {
					echo '<span style="color: green;"> Cotrat en cours</span>';
				}else{ echo '<span style="color: red;"> Contrat expiré </span>'; } ?></td>
                <td><a href="themes/images/avatar_loc/<?php echo $resultValid['AvatarLoc'];?>"><img width="200"  style=" height:90px; border-radius: 100px;" src="themes/images/avatar_loc/<?php echo $resultValid['AvatarLoc'];?>" alt=""/></a></td> 
            </tr> 
        <?php }}elseif($nbMaisonL == 0){
            			echo '<tr><td colspan = 9 style="text-align:center;"><h3>Aucune de vos maisons est louée </h3></td></tr>';
            		}
         ?>
           
			<tr class="breadcrumb">
                <td colspan="10" style="text-align:right"><strong>TOTAL Maisons =</strong></td>
               	<td class="label label-info" style="display:block;text-align: center;color: white; font-size: 20px;"> <strong><?php echo $nbMaisonL; ?> </strong></td>
            </tr>
		</tbody>
    </table>	
	
	  </div>
  </div>
  </div>
  <!-- Reservation en cours -->
  <div class="tab-pane active" id="for">
  <div class="row-fluid">
	  <div class="span12">
	  <!-- ///////////////////// Historique des maisons deja vaidees /////////////////////////// -->	

    <ul class="breadcrumb">

    <h3>  RESERVATION EN COURS </h3>	
	 </ul>
		
	<table class="table table-bordered">
        <thead>
            <tr class="breadcrumb">
                <th>Maisons</th>
                <th>Num Maison</th>
                <th>Avenue</th>
                <th>Prix</th>
                <th>Localaire </th>
				<th>Civilité Locat</th>
				<th>Num Locataire</th>
                <th>Photo Locataire</th>
                <th>Accord</th>
                <th>Accord</th>
               
			</tr>
        </thead>
            <tbody>
            	<?php
            	//Historique pour afficher les maisons deja louees
            	$statutVal = 'Valide';
            	$accord = 'Non';
            		$reqValid = $bdd->prepare('SELECT * 
					FROM reservations, locataires, maisons, bailleurs, agents
					WHERE reservations.IdLocat = locataires.IdLoc
					AND reservations.IdMaison = maisons.IdM
					AND maisons.IdB = bailleurs.IdBail
					AND reservations.IdAgent = agents.IdAg
					AND maisons.EtatMaison = :etatMaisonVal
					AND maisons.StatutMaison = :statutMaison
					AND bailleurs.IdBail = :idBail
					AND reservations.Accord = :accord');

            		$reqValid->execute(array('etatMaisonVal' => $etatMaisonVal , 'statutMaison' => $statutMaison, 'idBail' => $idBail,'accord' => $accord ));
            		$nbMaisonL = $reqValid->rowCount();
            		if($nbMaisonL > 0){
            		while($resultValid = $reqValid->fetch()){ 
            			$mois = $resultValid['NbMois'];
            			$idRes = $resultValid['IdRes'];
            			include('include/testerContratValide.php');
            		?>
            <tr>
                <td><a href="themes/images/maisons/<?php echo $resultValid['Photo'];?>"> <img width="200" src="themes/images/maisons/<?php echo $resultValid['Photo'];?>" alt=""/></a></td>
                <td><?php echo $resultValid['Num'];?></td>
                <td><?php echo $resultValid['Avenue'];?></td>
                <td>$<?php echo $resultValid['Prix'];?></td>
                
                <td><?php echo $resultValid['NomLoc'];?></td>
                <td><?php echo utf8_encode($resultValid['EtatCivilLoc']);?></td>
                <td><?php echo $resultValid['TelephoneLoc'];?></td>
                
                <td><a href="themes/images/avatar_loc/<?php echo $resultValid['AvatarLoc'];?>"><img width="200"  style=" height:90px; border-radius: 100px;" src="themes/images/avatar_loc/<?php echo $resultValid['AvatarLoc'];?>" alt=""/></a></td> 
                <td><a href="?idResVal=<?php echo $resultValid['IdRes']; ?>"  style="padding-right:0"><span class="btn btn-small btn-success pull-right">Valider</span></a></td>
                <td><a onclick="return confirm('Voulez-vous vraiment annuler cette réservation ?')" href="?idResAnn=<?php echo $resultValid['IdRes']; ?>"  style="padding-right:0"><span class="btn btn-small btn-danger pull-right">Annuler</span></a></td>
            </tr> 
        <?php }}elseif($nbMaisonL == 0){
            			echo '<tr><td colspan = 10 style="text-align:center;"><h3>Aucune de vos maison est en cours de réservation </h3></td></tr>';
            		}
         ?>
           
			<tr class="breadcrumb">
                <td colspan="9" style="text-align:right"><strong>TOTAL Maisons =</strong></td>
               	<td class="label label-info" style="display:block;text-align: center;color: white; font-size: 20px;"> <strong><?php echo $nbMaisonL; ?> </strong></td>
            </tr>
		</tbody>
    </table>	
	
	  </div>
  </div>
  </div>

  <!-- ////////////////////////////////////////////////////////////////////// -->
  <div class="tab-pane" id="three">
  <div class="row-fluid">
	 <div class="span5">
			<div class="well">
				<ul class="thumbnails">
			<h5>VOTRE PROFIL</h5><br/>
			<?php 
				$reqProf = $bdd->prepare('SELECT * FROM bailleurs WHERE idBail = :idBail');
				$reqProf->execute(array('idBail' => $idBail));
				$resProf = $reqProf->fetch();
			?>
				<table align="center">
					<tr ><td style="text-align: right;"><img width="100" src="themes/images/avatar_bail/<?php echo $resProf['Avatar']; ?>" alt="" style="border-radius: 50px; height: 100px;" /></td></tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px">Nom</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['NomBail']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px ">Prenom</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo utf8_encode($resProf['PrenomBail']); ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px">Sexe</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo utf8_encode($resProf['Sexe']); ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px ">Date Naissance</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['DateNaiss']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px">Etat Civil</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo utf8_encode($resProf['EtatCivil']); ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px ">Nationalite</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['Nationalite']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px">Residence</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['Residence']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px ">Email</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['Email']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px ">Numero Piece Identite</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['NumPieceIdent']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px">Numero Telephone </td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['TelBail']; ?></td>
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
			  <input type="text" id="inputFname1" name="nomBail" placeholder="Nom" value="<?php echo $resProf['NomBail']; ?>"required>
			</div>
		 </div>
		 <div class="control-group">
			<label class="control-label" for="inputLnam">Prenom <sup style="color: red;">*</sup></label>
			<div class="controls">
			  <input type="text" id="inputLnam" name="prenomBail" placeholder="Prenom" value="<?php echo $resProf['PrenomBail']; ?>" required>
			</div>
		 </div>

	  	<div class="control-group">
			<label class="control-label" for="country">Sexe<sup style="color: red;">*</sup></label>
			<div class="controls">
			<select id="country" name="sexeBail" required>
				<option value="<?php echo $resProf['Sexe']; ?>"><?php echo $resProf['Sexe']; ?></option>
				<option value="Féminin">Féminin</option>
				<option value="Masculin">Masculin</option>
			</select>
			</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="input_email">Date de Naissance <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="date" id="input_email" name="dateNaissBail" placeholder="Date de Naissance" value="<?php echo $resProf['DateNaiss']; ?>">
		</div>
	  	</div>
	  	<div class="control-group">
			<label class="control-label" for="country">Etat Civil<sup style="color: red;">*</sup></label>
			<div class="controls">
			<select id="country" name="etatCivilBail" required>
				<option value="">-</option>
				<option value="Marié">Marié</option>
				<option value="Célibataire">Célibataire</option>
				<option value="Veuve">Veuve</option>
				<option value="Veuf">Veuf</option>
			</select>
			</div>
		</div>	
		 
		<div class="control-group">
		<label class="control-label" for="input_email">Nationalité <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="text" id="input_email" name="nationaliteBail" placeholder="Nationalité" value="<?php echo $resProf['Nationalite']; ?>" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Residence <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="text" id="inputPassword1" name="residenceBail" placeholder="Residence" value="<?php echo $resProf['Residence']; ?>" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Email <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="email" id="inputPassword1" name="emailBail" placeholder="Email" value="<?php echo $resProf['Email']; ?>" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Numero Pièce Identité <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="text" id="inputPassword1" name="NumPieceIdentBail" placeholder="Numero Pièce Identité" value="<?php echo $resProf['NumPieceIdent']; ?>" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Ancien Mot de passe <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="password" id="inputPassword1" name="ancMdp" placeholder="Ancien Mot de passe" required>
		</div>
	</div>		  
	<div class="control-group">
		<label class="control-label" for="inputPassword1"> Nouveau Mot de passe <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="password" id="inputPassword1" name="nvMdp" placeholder=" Nouveau Mot de passe" required >
		</div>
	</div>		  
	<div class="control-group">
		<label class="control-label" for="inputPassword1"> Repeter Mot de passe <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="password" id="inputPassword1" name="confMdp" placeholder="Confirmer Mot de passe" required>
		</div>
	</div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Téléphone <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="text" id="inputPassword1" name="telBail" placeholder="Téléphone" value="<?php echo $resProf['TelBail']; ?>" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Photo de profil <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="file" value="<?php echo $resProf['Avatar']; ?>" id="inputPassword1" name="avatarBail" placeholder="Residence">
		</div>
	  </div>

	
	<div class="control-group">
		<div class="controls">
			<?php
				if (isset($statut)) {
				echo '<label style="color:red;">'.$statut.'</label>';
						//echo '<script type="text/javascript">alert($erreur)</script>';
				}
			?>
			<input type="hidden" name="email_create" value="1">
			<input type="hidden" name="is_new_customer" value="1">
			<input class="btn btn-large btn-success" type="submit" name="btn_modif" value="Modifier" />
		</div>
	</div>		
	</form>
		</div>
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
	<?php }else{ header("Location:index.php");} ?>
