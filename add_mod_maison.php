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


// Requette pour afficher le nombre des maisons en cours de reservation
	$req = $bdd->prepare('SELECT * FROM bailleurs,maisons WHERE maisons.IdB = bailleurs.Idbail AND maisons.EtatMaison = :etatMaisonInnoc AND maisons.StatutMaison = :statutMaisonInval AND maisons.IdB = :idBail');
    $req->execute(array('etatMaisonInnoc' => $etatMaisonInnoc,'statutMaisonInval' => $statutMaisonInval,'idBail' => $idBail));
    $nbMaison = $req->rowCount();
	
// Requette pour afficher le nombre des maisons en cours de reservation dans Ibanda
	$req = $bdd->prepare('SELECT * FROM bailleurs,maisons WHERE maisons.IdB = bailleurs.Idbail AND maisons.EtatMaison = :etatMaisonInnoc AND maisons.StatutMaison = :statutMaisonInval AND maisons.Commune = :commune AND maisons.IdB = :idBail');
    $req->execute(array('etatMaisonInnoc' => $etatMaisonInnoc,'statutMaisonInval' => $statutMaisonInval,'commune' => 'Ibanda','idBail' => $idBail));
    $nbMaisonIband = $req->rowCount();
		
// Requette pour afficher le nombre des maisons en cours de reservation dans Kadutu
	$req = $bdd->prepare('SELECT * FROM bailleurs,maisons WHERE maisons.IdB = bailleurs.Idbail AND maisons.EtatMaison = :etatMaisonInnoc AND maisons.StatutMaison = :statutMaisonInval AND maisons.Commune = :commune AND maisons.IdB = :idBail');
    $req->execute(array('etatMaisonInnoc' => $etatMaisonInnoc,'statutMaisonInval' => $statutMaisonInval,'commune' => 'Kadutu','idBail' => $idBail));
    $nbMaisonKad = $req->rowCount();
		
// Requette pour afficher le nombre des maisons en cours de reservation dans Bagira
	$req = $bdd->prepare('SELECT * FROM bailleurs,maisons WHERE maisons.IdB = bailleurs.Idbail AND maisons.EtatMaison = :etatMaisonInnoc AND maisons.StatutMaison = :statutMaisonInval AND maisons.Commune = :commune AND maisons.IdB = :idBail');
    $req->execute(array('etatMaisonInnoc' => $etatMaisonInnoc,'statutMaisonInval' => $statutMaisonInval,'commune' => 'Bagira','idBail' => $idBail));
    $nbMaisonBag= $req->rowCount();
	

//Requette pour afficher le nombre des maisons disponibles
	$reqNumMax = $bdd->prepare('SELECT COUNT(*) as nb FROM maisons ');
	$reqNumMax->execute(array('etat' => $etatMaison,'statutMaison' => $statutMaison ));
	$resultatNumMax = $reqNumMax->fetch();
	$numMax = $resultatNumMax['nb'];
	$numAdd = $numMax + 1;

//Requette pour ajouter une nouvelle maison
	if (isset($_POST['Enregistrer'])) {
		$photoName = $_FILES['photo']['name'];

		$tailleMax = 3097152;
        $extValide = array('jpg','jpg','png','gif' );

        if ($_FILES['photo']['size'] <= $tailleMax) {
        	$extentionUpload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
        	if (in_array($extentionUpload, $extValide)) {
        		$chemin = "themes/images/maisons/".$numAdd.".".$extentionUpload;
        		$resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
        		if ($resultat) {
        			# Requette pour ajouter une noulle maison
        			$libelle = $_POST['libelle'];
        			$num = $_POST['num'];
        			$prix = $_POST['prix'];
        			$commune = $_POST['commune'];
        			$quartier = $_POST['quartier'];
        			$avenue = $_POST['avenue'];
        			$chambre = $_POST['nbChambre'];
        			$salon = $_POST['nbSalon'];
        			$douche = $_POST['nbDouche'];
        			$description = $_POST['description'];
        			$dtOffre = date('Y-m-d');
        			$photo = $numAdd.".".$extentionUpload;
        			$idAdm = 'NULL';

        			//Maison se trouvant au bord du lac. La prise en charge du courant et de l'eau. une belle terrasse; un dépôt pour la conservation des nourritures

        			$reqMaisonExist = $bdd->prepare('SELECT *  FROM maisons WHERE Num = :num AND Avenue = :avenue AND IdB = :idBail');
        			$reqMaisonExist->execute(array('num' => $num, 'avenue' => $avenue, 'idBail' => $idBail ));
        			$resultMaisonExist = $reqMaisonExist->rowCount();
        			if ($resultMaisonExist == 0) {
        				$reqEnreg = $bdd->prepare('INSERT INTO maisons (
				        Libelle, Num ,Prix ,Commune ,Quartier ,Avenue, NbChambre, NbSalon, NbDouche, Description, EtatMaison ,StatutMaison, DateOffre, Photo, IdB ) 

				    VALUES (:libelle, :num, :prix, :commune, :quartier, :avenue, :chambre, :salon, :douche, :description, :etatMaisonInnoc, :statutMaisonInval, :dtOffre, :photo, :idBail)');
				    $reqEnreg->execute(array(
				    	'libelle' => $libelle,
				    	'num' => $num,
				    	'prix' => $prix,
				    	'commune' => $commune,
				    	'quartier' => $quartier,
				    	'avenue' => $avenue,
				    	'chambre' => $chambre,
				    	'salon' => $salon,
				    	'douche' => $douche,
				    	'description' => $description,
				    	'etatMaisonInnoc' => $etatMaisonInnoc,
				    	'statutMaisonInval' => $statutMaisonInval,
				    	'dtOffre' => $dtOffre,
				    	'photo' => $photo,
				    	'idBail' => $idBail
				    ));
				    if ($reqEnreg) {
				    	$statut1 = 'Enregistrement effectuée avec certitude';
				    }else{
				    	$statut = 'Erreur lors de l\'enregistrement de ma maison';
				    }
        			}else{
        				$statut = 'Cette maisons est en cours de validation; vueillez patienter !';
        			}
				    
        		}else{
        			$statut = 'Erreur lors de l\' importation de la photo';
        		}
        	}else{
        		$statut = 'Le format de votre photo n\'est pa valide';
        	}
        }else{
        	$statut = 'La taille de la photo \'est pas valide';
        }
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
    <a class="brand" href="espace_bailleur.php"><img src="themes/images/logo1.png" alt="HousesAllocation" title="HousesAllocation" /></a>
		
    <ul id="topMenu" class="nav pull-right">
	 <li class=""><a href="espace_bailleur.php">Accueil</a></li>
	 <li class=""><a href="add_mod_photo.php">Galeries</a></li>
	 <li class=""><a href="contact.html">Contact </a></li>
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
			<a id="myCart" href=""><img src="themes/images/ico-cart.png" alt="cart">Vos maison en cours d'Offre<span class="badge badge-warning pull-right"><?php echo $nbMaison; ?></span></a>
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
		<li><a href="espace_bailleur.php">Espace_Bailleur</a> <span class="divider">/</span></li>
		<li class="active"> Gestion maisons</li>
		<div class="pull-right" style="font-family: verdana">
		<i><?php echo $_SESSION['nomBail'].' '; ?></i></i><img style="width: 15px;" src="themes/images/products/large/point.png">
		</div>
    </ul>
	
<div id="grids">
<ul class="nav nav-tabs" id="myTab">
  <li><a href="#one" data-toggle="tab" class="label label-success"> Modification Maisons</a></li>
  <li  class="active"><a href="#two" data-toggle="tab" class="label label-warning"> Ajouter Maisons</a></li>
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
	 	<h3>  MAISONS EN COURS D'OFFRE [ <small><?php echo $result['nbMInval']; ?> Maisons </small>]</h3>	
	 </ul>
	 		
	<!-- Historique des maisons en cours -->		
	<table class="table table-bordered" >           
        <thead>
            <tr class="breadcrumb">
                <th>Maisons</th>
                <th>Libelle</th>
                <th>Num</th>
				<th>Prix</th>
                <th>Commune</th>
                <th>Quartier</th>
                <th>Avenu </th>
				<th>Nbre Chambre</th>
                <th>Nbre Salon</th>
                <th>Nbre Douche</th>
                <th>Etat Maison</th>
                <th>Action</th>
               
			</tr>
        </thead>
            <tbody>
            	<?php 
		// Requette pour afficher le nombre des maisons en cours de reservation
	 		$stOff = 'Invalide';
			$req = $bdd->prepare('SELECT * FROM bailleurs,maisons WHERE maisons.IdB = bailleurs.Idbail AND maisons.EtatMaison = :etatMaisonInnoc AND maisons.StatutMaison = :statutMaisonInval AND maisons.IdB = :idBail');
            $req->execute(array('etatMaisonInnoc' => $etatMaisonInnoc,'statutMaisonInval' => $statutMaisonInval,'idBail' => $idBail));
            $maisonDispo = $req->rowCount();
            if($maisonDispo > 0){
            while ($resMaison = $req->fetch()) { ?>
            <tr>
                <td > <a href="themes/images/maisons/<?php echo $resMaison['Photo']; ?>"><img style="width:100%" src="themes/images/maisons/<?php echo $resMaison['Photo']; ?>" alt=""/></a></td>
                <td><?php echo utf8_encode($resMaison['Libelle']); ?></td>
                <td><?php echo $resMaison['Num']; ?></td>
                <td>$<?php echo $resMaison['Prix']; ?></td>
                <td><?php echo $resMaison['Commune']; ?></td>
                <td><?php echo $resMaison['Quartier']; ?></td>
                <td><?php echo $resMaison['Avenue']; ?></td>
                <td><?php echo $resMaison['NbChambre']; ?></td>
                <td><?php echo $resMaison['NbSalon']; ?></td>
                <td><?php echo $resMaison['NbDouche']; ?></td>
                <td><?php echo $resMaison['EtatMaison']; ?></td>
                <td><div class="input-append"><a href="mod_maisons.php?idM=<?php echo $resMaison['IdM']; ?>"  style="padding-right:0"><span class="btn btn-medium btn-warning pull-right">Modifier</span></a></div></td>

            </tr>
        <?php  }}elseif ($maisonDispo == 0) {
        	echo '<tr><td colospan = 12><h4 style="text-align:center;">Vous n\'avez aucune maison en coud d\'offre</h4></td></tr>';
        } ?>
           
		</tbody>
    </table>
    <hr class="soft"/>

	  </div>
  </div>
  </div>
  <div class="tab-pane active" id="two">
  <div class="row-fluid">
	  <div class="span12">
	  	<p><?php if (isset($statut1)) {
					echo '<div class="alert alert-success">';
        			echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        			echo '<strong>Succès ! </strong>'.$statut1;
      				echo '</div>';
					
				}elseif(isset($statut)){
					echo '<div class="alert alert-error">';
        			echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        			echo '<strong>Attention ! </strong>'.$statut;
      				echo '</div>';
				} ?></p>
	  <!-- Historique des maisons deja vaidees -->	
			<div class="well">
			<h5>AJOUTER UNE MAISON</h5>
			
	<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">		
		<div class="control-group">
			<label class="control-label"  for="inputFname1">Libelle <sup style="color: red;">*</sup></label>
			<div class="controls">
			  <input type="text" name="libelle" id="inputFname1" placeholder="Libelle" class="input-xlarge" required="">
			</div>
		 </div>
		 <div class="control-group">
			<label class="control-label" for="inputLnam">Numero Maison <sup style="color: red;">*</sup></label>
			<div class="controls">
			  <input type="text" name="num" id="inputLnam" placeholder="Numero Maison" class="input-xlarge" required="">
			</div>
		 </div>

		<div class="control-group">
		<label class="control-label" for="input_email">Prix <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="number" name="prix" id="input_email" placeholder="Prix" class="input-xlarge" required="">
		</div>
	  	</div>
		<div class="control-group">
		<label class="control-label" for="input_email">Commune <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="text" name="commune" id="input_email" placeholder="Commune" class="input-xlarge" required="">
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Quartier <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="text" name="quartier" id="inputPassword1" placeholder="Quartier" class="input-xlarge" required="">
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Avenue <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="text" name="avenue" id="inputPassword1" placeholder="Avenue" class="input-xlarge" required="">
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Nombre Chambres <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="number" name="nbChambre" id="inputPassword1" placeholder="Nombre Chambres" class="input-xlarge" required="">
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Nombre Salon <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="number" name="nbSalon" id="inputPassword1" placeholder="Nombre Salon" class="input-xlarge" required="">
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Nombre Douche <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="number" name="nbDouche" id="inputPassword1" placeholder="Nombre Douche" class="input-xlarge" required="">
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Description <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <textarea class="input-xlarge" name="description" id="textarea"  style="height:65px" required=""></textarea>
		</div>
	  </div>	  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Photo de profil <sup style="color: red;">*</sup></label>
		<div class="controls">
		  <input type="file" name="photo" id="inputPassword1" >
		</div>
	  </div>

	
	<div class="control-group">
			<div class="controls">
				<input class="btn btn-large btn-success" name="Enregistrer" type="submit" value="Enregistrer" />
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

</div>
</div></div>
</div>
<!-- Footer ================================================================== -->
	<?php
	include('include/footer.php');
	?>
</body>
</html>
<?php 
	}else{ 
		header('Loction:index.php');
	} 
?>