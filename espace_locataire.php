<?php
	session_start();
	include('config/connexion.php');
	if (isset($_SESSION['idLoc'])) {
	$idLoc = $_SESSION['idLoc'];

	///Etat de la maison
	$etatMaison = 'Innocupee';
	$stRes = 'Valide';
	$statut = '';
	$accord = 'Oui';

	//Requette pour afficher le nombre total des maisons louées
    $req = $bdd->prepare('SELECT * FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.Accord = :accord AND reservations.StatutRes = :stRes AND reservations.IdLocat = :idLoc');
            		$req->execute(array('accord' => $accord,'stRes' => $stRes, 'idLoc' => $idLoc));
    $nbMaisonL = $req->rowCount();

	//Requette pour afficher le nombre total des maisons louées dansla commune d'Ibanda
    $req = $bdd->prepare('SELECT * FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.Accord = :accord AND reservations.StatutRes = :stRes AND maisons.Commune = :commune AND reservations.IdLocat = :idLoc');
            		$req->execute(array('accord' => $accord,'stRes' => $stRes,'commune' => 'Ibanda', 'idLoc' => $idLoc));
    $nbMaisonIband = $req->rowCount();

	//Requette pour afficher le nombre total des maisons louées dansla commune de kadutu
     $req = $bdd->prepare('SELECT * FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.Accord = :accord AND reservations.StatutRes = :stRes AND maisons.Commune = :commune AND reservations.IdLocat = :idLoc');
            		$req->execute(array('accord' => $accord,'stRes' => $stRes,'commune' => 'Kadutu', 'idLoc' => $idLoc));
    $nbMaisonKad = $req->rowCount();

	//Requette pour afficher le nombre total des maisons louées dansla commune de Bagira
     $req = $bdd->prepare('SELECT * FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.Accord = :accord AND reservations.StatutRes = :stRes AND maisons.Commune = :commune AND reservations.IdLocat = :idLoc');
            		$req->execute(array('accord' => $accord,'stRes' => $stRes,'commune' => 'Bagira', 'idLoc' => $idLoc));
    $nbMaisonBag = $req->rowCount();



    //Requete pour afficher le nombre des maisons en cours reservation
    $stRes = 'Invalide';
	$req = $bdd->prepare('SELECT * FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.StatutRes = :stRes AND reservations.IdLocat = :idLoc');
    $req->execute(array('stRes' => $stRes, 'idLoc' => $idLoc));
    $nbMaisonInval = $req->rowCount();
    
    //Requete pour afficher le nombre des maisons en cours reservation dans Ibanda
	$req = $bdd->prepare('SELECT * FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.StatutRes = :stRes AND maisons.Commune = :commune AND reservations.IdLocat = :idLoc');
    $req->execute(array('stRes' => $stRes,'commune' => 'Ibanda', 'idLoc' => $idLoc));
    $nbMaisonInvalIband = $req->rowCount();

    
    //Requete pour afficher le nombre des maisons en cours reservation dans Kadutu
	$req = $bdd->prepare('SELECT * FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.StatutRes = :stRes AND maisons.Commune = :commune AND reservations.IdLocat = :idLoc');
    $req->execute(array('stRes' => $stRes,'commune' => 'Kadutu', 'idLoc' => $idLoc));
    $nbMaisonInvalKad = $req->rowCount();

    
    //Requete pour afficher le nombre des maisons en cours reservation dans Bagira
	$req = $bdd->prepare('SELECT * FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.StatutRes = :stRes AND maisons.Commune = :commune AND reservations.IdLocat = :idLoc');
    $req->execute(array('stRes' => $stRes,'commune' => 'Bagira', 'idLoc' => $idLoc));
    $nbMaisonInvalBag = $req->rowCount();

    //Modification du profil
        $reqLoc = $bdd->prepare('SELECT * FROM locataires WHERE IdLoc = :idLoc');
        $reqLoc->execute(array('idLoc' => $idLoc));
        $resultLoc = $reqLoc->fetch();
        //Tester si les donnees ne changent pas
        if (isset($_POST['btn_modif'])) {
        	# Code pour editer le profil
        	if (
        		
        	$_POST['nomLoc'] != $resultLoc['NomLoc']
        	
        	) {
        		//On vérifie l'ancien mot de passe
        		if ($_POST['ancMdp'] == $resultLoc['Password']) {
        			# on teste si le nouveau mot de passe est identique quand on confirme
        			if ($_POST['nvMdp'] == $_POST['confMdp']) {

        				$ptName = $_FILES['avatarLoc']['name'];

        				$tailleMax = 3097152;
        				$extValide = array('jpg','jpg','png','gif' );
        				if ($_FILES['avatarLoc']['size'] <= $tailleMax) {
        					$extentionUpload = strtolower(substr(strrchr($_FILES['avatarLoc']['name'], '.'), 1));
        					if (in_array($extentionUpload, $extValide)) {
        						$chemin = "themes/images/avatar_loc/".$idLoc.".".$extentionUpload;
        						$resultat = move_uploaded_file($_FILES['avatarLoc']['tmp_name'], $chemin);
        						if ($resultat) {
        							$reqMod = $bdd->prepare('UPDATE locataires SET 
				        			NomLoc = :nomLoc, 
				        			PrenomLoc = :prenomLoc,
				        			SexeLoc = :sexeLoc,
				        			DateNaissLoc = :dtLoc,
				        			EtatCivilLoc = :etatCivLoc,
				        			NationaliteLoc = :nationaliteLoc,
				        			ResidenceLoc = :residenceLoc,
				        			EmailLoc = :emailLoc,
				        			NumPieceLoc = :numPieceLoc,
				        			Password = :password,
				        			TelephoneLoc = :telephoneLoc, 
				        			AvatarLoc = :avatarLoc 
				        			WHERE IdLoc = :idLoc');

				        			$reqMod->execute(array(
				        			'nomLoc' => $_POST['nomLoc'],
				        			'prenomLoc' => $_POST['prenomLoc'],
				        			'sexeLoc' => $_POST['sexeLoc'],
				        			'dtLoc' => $_POST['dtLoc'],
				        			'etatCivLoc' => $_POST['etatCivLoc'],
				        			'nationaliteLoc' => $_POST['nationaliteLoc'],
				        			'residenceLoc' => $_POST['residenceLoc'],
				        			'emailLoc' => $_POST['emailLoc'],
				        			'numPieceLoc' => $_POST['numPieceLoc'],
				        			'password' => $_POST['confMdp'],
				        			'telephoneLoc' => $_POST['telephoneLoc'],
				        			'avatarLoc' => $idLoc.".".$extentionUpload,
				        			'idLoc' => $idLoc
				        			
				        			 ));
        						}else{
        							$erreur = 'Erreur lors de l\' importation de la photo';
        						}
        					}else{
        						$erreur = 'Le format de votre photo n\' est pas valide';
        					}
        				}else{
        					$erreur = 'La taille de la photo \'est pas valide ';
        				}
        				# code...
        		
        			}else{

        				$erreur = "Le deux mot de passes ne correspondent pas";
        			}
        		}else{
        			$erreur = "Ce mot de passe ne pas reconnu ";
        		}
        	}else{
        			$erreur = "Aucune modification ";
        		}

        }

		
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Espace Locataire</title>
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
    <a class="brand" href="espace_locataire.php"><img src="themes/images/logo1.png" alt="HousesAllocation" title="HousesAllocation" /></a>
		
    <ul id="topMenu" class="nav pull-right">
	 <li class=""><a href="maisonsLoc.php">Accueil</a></li>
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
			<a id="myCart" href=""><img src="themes/images/ico-cart.png" alt="cart">Vos maison Louées<span class="badge badge-warning pull-right"><?php echo $nbMaisonL; ?></span></a>
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
			<a id="myCart" href=""><img src="themes/images/ico-cart.png" alt="cart">Réservation Maison en cours<span class="badge badge-info pull-right"><?php echo $nbMaisonInval; ?></span></a>
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
		<li><a href="maisonsLoc.php">Accueil</a> <span class="divider">/</span></li>
		<li class="active"> Historiquue de location</li>
		<div class="pull-right" style="font-family: verdana">
		<i><?php echo $_SESSION['nomLoc'].' '; ?></i><img style="width: 15px;" src="themes/images/galerie/point.png" title="en ligne">
		</div>
    </ul>
	

<div class="page-header">
<h4>ESPACE LOCATAIRE </h4>
</div>
<div id="grids">
<ul class="nav nav-tabs" id="myTab">
  <li><a href="#one" data-toggle="tab" class="label label-success"> Reservations en cours</a></li>
  <li  class="active"><a href="#two" data-toggle="tab" class="label label-warning"> Maisons louées</a></li>
  <li><a data-toggle="tab" class="label label-info" href="#three"> Profil</a></li>
</ul>
 
<div class="tab-content">
  <div class="tab-pane" id="one">
  <div class="row-fluid">
	 <div class="span12">
	 	<ul class="breadcrumb">
	 		<?php 
	 		// Requette pour afficher le nombre des maisons en cours de reservation
	 		$stRes = 'Invalide';
					$req = $bdd->prepare('SELECT COUNT(*) as nbM FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.StatutRes = :stRes AND reservations.IdLocat = :idLoc');
            		$req->execute(array('stRes' => $stRes, 'idLoc' => $idLoc));
            		$result = $req->fetch();
				?>
	 	<h4>  MAISONS EN COURS DE RESERVATION [ <small><?php echo $result['nbM']; if (isset($statut)) {
	 		echo $statut;
	 	} ?> Maisons </small>]<a href="maisonsLoc.php" class="btn btn-medium pull-right"><i class="icon-arrow-left"></i> Continuer la  Réservation</a></h4>	
	 </ul>
	 	
	<!-- Historique des maisons en cours -->		
	<table class="table table-bordered" border="1">
        <thead>
            <tr class="breadcrumb">
                <th>Maisons</th>
                <th>Description de la maison</th>
                <th>Chambres</th>
                <th>Date</th>
				<th>Quartier</th>
                <th>Prix</th>
                <th>Action </th>
			</tr>
        </thead>
            <tbody>
            	<?php
            	// Requette pour afficher les maisons en enttente de validation de la reservation
            	$stRes = 'Invalide';
            		$req = $bdd->prepare('SELECT * FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.StatutRes = :stRes AND reservations.IdLocat = :idLoc');
            		$req->execute(array('stRes' => $stRes, 'idLoc' => $idLoc));
            		$nbMaison = $req->rowCount();
            		if($nbMaison > 0){
            		while ($result = $req->fetch()) { ?>
            	
            <tr>
                <td> <img width="200" src="themes/images/maisons/<?php echo $result['Photo']; ?>" alt=""/></td>
                <td><?php echo utf8_encode($result['Libelle']); ?><br/></td>
                <td><?php echo utf8_encode($result['NbChambre']); ?><br/></td>
				<td><?php echo $result['DateRes']; ?></td>
                <td><?php echo $result['Quartier']; ?></td>
                <td>$<?php echo $result['Prix']; ?></td>
                <td><a href="annuler_res.php?idM=<?php echo $result['IdM']; ?>"  style="padding-right:0"><span class="btn btn-medium btn-inverse pull-right">Annuler</span></a></td>
            </tr>

             <?php		
            		}
            		}elseif($nbMaison == 0){
            			echo '<tr><td colspan = 8 style="text-align:center;"><h3>Aucune maison en cours de réservation </h3><h5 ><a href="maisonsLoc.php" style = "color:green;">Effectuer une réservation maintenant</a></h5></td></tr>';
            		}
            	?>
            	
			<tr class="breadcrumb">
				<?php 

            	// Requette pour afficher le nombre des maisons en enttente de validation de la reservation
            	$stRes = 'Invalide';
            		$req = $bdd->prepare('SELECT COUNT(*) AS nbInval FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.StatutRes = :stRes AND reservations.IdLocat = :idLoc');
            		$req->execute(array('stRes' => $stRes, 'idLoc' => $idLoc));
            		$result = $req->fetch();
				?>
                <td colspan="6" style="text-align:right"><strong>TOTAL Maisons =</strong></td>
               	<td class="label label-info" style="display:block;text-align: center;color: white; font-size: 20px;"> <strong> <?php echo $result['nbInval']; ?> </strong></td>
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

    <h3>  HISTORIQUE DES MAISONS LOUEES [ <small>3 Maisons </small>]</h3>	
	 </ul>
		
	<table class="table table-bordered">
        <thead>
            <tr class="breadcrumb">
                <th>Maisons</th>
                <th>Description de la maison</th>
				<th>Quartier</th>
                <th>Prix</th>
                <th>Etat</th>
                <th>Bailleur</th>
                <th>Contact Bailleur </th>
                <th>Photo Bailleur </th>
			</tr>
        </thead>
            <tbody>
            <?php
            //Historique pour afficher les maisons déjà louees
            	$statutVal = 'Valide';
            	$reqValid = $bdd->prepare('SELECT * FROM locataires,reservations,maisons,bailleurs 
            		WHERE reservations.IdLocat = locataires.IdLoc 
            		AND reservations.IdMaison =  maisons.IdM 
            		AND maisons.IdB = bailleurs.IdBail
            		AND reservations.StatutRes = :stt 
            		AND reservations.Accord = :accord 
            		AND reservations.IdLocat = :idLoc ');
            		$reqValid->execute(array('accord' => $accord,'stt' => $statutVal, 'idLoc' => $idLoc));
            		$nbMaison = $reqValid->rowCount();
            		if($nbMaison > 0){
            		while($resultValid = $reqValid->fetch()){ 
            			$mois = $resultValid['NbMois'];
            			$idRes = $resultValid['IdRes'];
            			include('include/testerContratValide.php');

            		?>
             <tr>
                <td><a href="themes/images/maisons/<?php echo $resultValid['Photo']; ?>"> <img width="120" src="themes/images/maisons/<?php echo $resultValid['Photo']; ?>" alt=""/></a></td>
                <td><?php echo utf8_encode($resultValid['Description']); ?></td>
                <td><?php echo $resultValid['Quartier']; ?></td>
                <td>$<?php echo $resultValid['Prix']; ?></td>
                <td><?php if ($data) {
					echo '<span style="color: green;"><b> Cotrat en cours </b></span>';
				}else{ echo '<span style="color: red;"><b> Contrat expiré </b></span>'; } ?></td>
                <td><?php echo $resultValid['NomBail']; ?></td>
                <td><?php echo $resultValid['TelBail']; ?></td>
                <td><a href="themes/images/avatar_bail/<?php echo $resultValid['Avatar']; ?>"><img width="80" src="themes/images/avatar_bail/<?php echo $resultValid['Avatar']; ?>" alt=""/></a></td>
            </tr>
            <?php 	
            		}}elseif($nbMaison == 0){
            			echo '<tr><td colspan = 8 style="text-align:center;"><h3>Aucune maison en location </h3></td></tr>';
            		}
            	?>
			<?php 

			//Requette pour afficher le nombre total des maisons louees
			$reqValid = $bdd->prepare('SELECT COUNT(*) AS nbVal FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.Accord = :accord AND reservations.StatutRes = :stt AND reservations.IdLocat = :idLoc ');
            		$reqValid->execute(array('accord' => $accord,'stt' => $statutVal, 'idLoc' => $idLoc));
            		$resultValid = $reqValid->fetch();

			// Requette pour calculer le montant des maisons a payer par mois
				$reN = $bdd->prepare('SELECT SUM(maisons.Prix) AS prixTot FROM locataires,reservations,maisons WHERE reservations.IdLocat = locataires.IdLoc AND reservations.IdMaison =  maisons.IdM AND reservations.Accord = :accord AND reservations.StatutRes = :statutVal AND reservations.IdLocat = :idLoc;');
                	$reN->execute(array('accord' => $accord,'statutVal' => $statutVal, 'idLoc' => $idLoc));
                	$resN = $reN->fetch();
			?>
            <tr>
                <td colspan="7" style="text-align:right"><b> Total Maisons:	</b></td>
                <td style="font-size: 20px;"><center> <b><?php echo $resultValid['nbVal']; ?></b></center></td>
            </tr>
			<tr class="breadcrumb">
                <td colspan="7" style="text-align:right"><strong> <b> ESTIMATION COUTS = <b> </strong></td>
               	<td class="label label-important" style="display:block; font-size : 16px;"> <center> <b> $ <?php echo $resN['prixTot'];?> <b></center></td>
            </tr>
		</tbody>
    </table>	
	<a href="maisonsLoc.php" class="btn btn-large"><i class="icon-arrow-left"></i> Continuer la réservation </a>
	
	  </div>
  </div>
  </div>
  <div class="tab-pane" id="three">
  <div class="row-fluid">
	 <div class="span5">
			<div class="well">
				<ul class="thumbnails">
			<h5>VOTRE PROFIL</h5><br/>
				<table align="center">
					<?php 
						$reqProf = $bdd->prepare('SELECT * FROM locataires WHERE IdLoc = :idLoc');
						$reqProf->execute(array('idLoc' => $idLoc));
						$resProf = $reqProf->fetch();
					?>
					<tr ><td style="text-align: right;"><img width="100" src="themes/images/avatar_loc/<?php echo $resProf['AvatarLoc']; ?>" alt="" style="border-radius: 50px; height: 100px;" /></td></tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px">Nom</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['NomLoc']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px ">Prenom</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo utf8_encode($resProf['PrenomLoc']); ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px">Sexe</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo utf8_encode($resProf['SexeLoc']); ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px ">Date Naissance</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['DateNaissLoc']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px">Etat Civil</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo utf8_encode($resProf['EtatCivilLoc']); ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px ">Nationalite</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['NationaliteLoc']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px">Residence</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['ResidenceLoc']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px ">Email</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['EmailLoc']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px ">Numero Piece Identite</td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['NumPieceLoc']; ?></td>
					</tr>
					<tr>
						<td style="font-family: Arial; font-size: 14px">Numero Telephone </td>
						<td style="text-align: right; font-family: Arial; font-size: 14px"><?php echo $resProf['TelephoneLoc']; ?></td>
					</tr>
				</table></ul>
		</div>
		</div>
	 <div class="span7">
			<div class="well">
			<h5>MODIFIER VOTRE PROFIL</h5><br/>
			<form class="form-horizontal" method="PoST" action="" enctype="multipart/form-data" >		
		<div class="control-group">
			<label class="control-label" for="inputFname1">Nom <sup style="color: red;">*</sup></label>
			<div class="controls">
			  <input type="text" id="inputFname1" name="nomLoc" placeholder="Nom" value="<?php echo $resProf['NomLoc']; ?>" required>
			</div>
		 </div>
		 <div class="control-group">
			<label class="control-label" for="inputLnam">Prenom <sup style="color: red;">*</sup></label>
			<div class="controls">
			  <input type="text" name="prenomLoc" id="inputLnam" placeholder="Prenom" value="<?php echo $resProf['PrenomLoc']; ?>" required>
			</div>
		 </div>

	  	<div class="control-group">
			<label class="control-label" for="country">Sexe<sup style="color: red;">*</sup></label>
			<div class="controls">
			<select id="country" name="sexeLoc" required>
				<option value="<?php echo $resProf['SexeLoc']; ?>"><?php echo $resProf['SexeLoc']; ?></option>
				<option value="Féminin">Féminin</option>
				<option value="Masculin">Masculin</option>
			</select>
			</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="input_email">Date de Naissance <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="date" name="dtLoc" id="input_email" placeholder="Date de Naissance" value="<?php echo $resProf['DateNaissLoc']; ?>" required>
		</div>
	  	</div>
	  	<div class="control-group">
			<label class="control-label" for="country">Etat Civil<sup style="color: red;">*</sup></label>
			<div class="controls">
			<select id="country" name="etatCivLoc" required>
				<option value="<?php echo $resProf['EtatCivilLoc']; ?>"><?php echo utf8_encode($resProf['EtatCivilLoc']); ?></option>
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
		  <input type="text" name="nationaliteLoc" id="input_email" placeholder="Nationalité" value="<?php echo $resProf['NationaliteLoc']; ?>" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Residence <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="text" name="residenceLoc" id="inputPassword1" placeholder="Residence" value="<?php echo $resProf['ResidenceLoc']; ?>" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Email <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="email" name="emailLoc" id="inputPassword1" placeholder="Email" value="<?php echo $resProf['EmailLoc']; ?>" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Numero Pièce Identité <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="text" name="numPieceLoc" id="inputPassword1" placeholder="Numero Pièce Identité" value="<?php echo $resProf['NumPieceLoc']; ?>" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1"> Ancien Mot de passe <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="password" name="ancMdp" id="inputPassword1" placeholder=" Ancien Mot de passe" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1" >Nouvea Mot de passe <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="password" name="nvMdp" id="inputPassword1" placeholder="Nouveau Mot de passe" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1"> Confirmer Mot de passe <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="password" name="confMdp" id="inputPassword1" placeholder=" Confirmer Mot de passe" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Téléphone <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="phone" name="telephoneLoc" id="inputPassword1" placeholder="Téléphone" value="<?php echo $resProf['TelephoneLoc']; ?>" required>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Photo de profil <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="file" value="<?php echo $resProf['AvatarLoc']; ?>" name="avatarLoc" id="inputPassword1" placeholder="Residence" required>
		</div>
	  </div>

	
	<div class="control-group">
		<div class="controls">
		<?php
			if (isset($erreur)) {
			echo '<label style="color:red;">'.$erreur.'</label>';
				//echo '<script type="text/javascript">alert($erreur)</script>';
			}
		?>
				<input type="hidden" name="email_create" value="1">
				<input type="hidden" name="is_new_customer" value="1">
				<input class="btn btn-large btn-success" name="btn_modif" type="submit" value="Modifier" />
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
<?php include('include/footer.php'); ?>

</body>

</html>

<?php }else{

		header('Location:index.php');

	} ?>