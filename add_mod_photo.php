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


//Requette pour afficher le nombre total des maisons louées
    $reqValid = $bdd->prepare('SELECT * 
	FROM reservations, locataires, maisons, bailleurs, agents
	WHERE reservations.IdLocat = locataires.IdLoc
	AND reservations.IdMaison = maisons.IdM
	AND maisons.IdB = bailleurs.IdBail
	AND reservations.IdAgent = agents.IdAg
	AND maisons.EtatMaison = :etatMaisonVal
	AND maisons.StatutMaison = :statutMaison
	AND bailleurs.IdBail = :idBail');
    $reqValid->execute(array('etatMaisonVal' => $etatMaisonVal , 'statutMaison' => $statutMaison, 'idBail' => $idBail ));
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
	AND bailleurs.IdBail = :idBail
	AND maisons.Commune = :commune');
    $reqValid->execute(array('etatMaisonVal' => $etatMaisonVal , 'statutMaison' => $statutMaison, 'idBail' => $idBail, 'commune' => 'Ibanda' ));
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
	AND bailleurs.IdBail = :idBail
	AND maisons.Commune = :commune');
    $reqValid->execute(array('etatMaisonVal' => $etatMaisonVal , 'statutMaison' => $statutMaison, 'idBail' => $idBail, 'commune' => 'Kadutu' ));
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
	AND bailleurs.IdBail = :idBail
	AND maisons.Commune = :commune');
    $reqValid->execute(array('etatMaisonVal' => $etatMaisonVal , 'statutMaison' => $statutMaison, 'idBail' => $idBail, 'commune' => 'Bagira' ));
    $nbMaisonBag = $reqValid->rowCount();
	

//Requette pour afficher le nombre des photo disponibles
	$reqNumMax = $bdd->prepare('SELECT COUNT(*) as nb FROM galeries ');
	$reqNumMax->execute(array());
	$resultatNumMax = $reqNumMax->fetch();
	$numMax = $resultatNumMax['nb'];
	$numAdd = $numMax + 1;

//Requette pour ajouter une nouvelle maison
	if (isset($_POST['Enregistrer'])) {
		# Requette pour ajouter une noulle maison
        			$libelle = $_POST['libelle'];
        			$description = $_POST['description'];
        			$dtJour = date('Y-m-d');
        			
        			$maison = $_POST['maison'];
        			
		$req = $bdd->prepare('SELECT * FROM galeries,maisons,bailleurs WHERE galeries.IdMaison = maisons.IdM AND maisons.IdB = bailleurs.Idbail AND bailleurs.IdBail = :idBail AND galeries.LibellePhoto = :Libellephoto AND galeries.DescriptionPhoto = :description AND galeries.IdMaison = :maison' );
            $req->execute(array('idBail' => $idBail, 'Libellephoto' => $libelle, 'description' => $description, 'maison' => $maison));
            $nbPhotos = $req->rowCount();
            if ($nbPhotos >= 1) {

            	echo "<script>alert('Cet enregistrement existe ')</script>";
				echo '<meta http-equiv = "refresh" content = "0">';
            }else
		$photoName = $_FILES['photo']['name'];

		$tailleMax = 3097152;
        $extValide = array('jpg','jpg','png','gif' );

        if ($_FILES['photo']['size'] <= $tailleMax) {
        	$extentionUpload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
        	if (in_array($extentionUpload, $extValide)) {
        		$chemin = "themes/images/galerie/".$numAdd.".".$extentionUpload;
        		$resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
        		if ($resultat) {
        			$photo = $numAdd.".".$extentionUpload;
        			
        				$reqEnreg = $bdd->prepare('INSERT INTO galeries (
				        Libellephoto, DescriptionPhoto ,DateCreation ,Galerie ,IdMaison) 

				    VALUES (:libelle, :description, :dtJour, :photo, :maison)');
				    $reqEnreg->execute(array(
				    	'libelle' => $libelle,
				    	'description' => $description,
				    	'dtJour' => $dtJour,
				    	'photo' => $photo,
				    	'maison' => $maison
				    	
				    ));
				    if ($reqEnreg) {
				    	$statut1 = 'Enregistrement effectué avec certitude';
				    }else{
				    	$statut = 'Erreur lors de l\'enregistrement de ma maison';
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
    <title>Gestion des images chambres</title>
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
	 <li class=""><a href="add_mod_photo.php">Accueil</a></li>
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
		<li><a href="add_mod_maison.php">Gestion_Maisons</a> <span class="divider">/</span></li>
		<li class="active"> Gestion galerie</li>
		<div class="pull-right" style="font-family: verdana">
		<i><?php echo $_SESSION['nomBail'].' '; ?></i></i><img style="width: 15px;" src="themes/images/products/large/point.png">
		</div>
    </ul>
	
<div id="grids">
<ul class="nav nav-tabs" id="myTab">
  <li><a href="#one" data-toggle="tab" class="label label-success">Photos Chambres-Salon-...</a></li>
  <li  class="active"><a href="#two" data-toggle="tab" class="label label-warning"> Ajouter Photo</a></li>
</ul>
 
<div class="tab-content">
  <div class="tab-pane" id="one">
  <div class="row-fluid">
	 <div class="span12">
	 	<ul class="breadcrumb">
	 	<?php 
	 		// Requette pour afficher le nombre des des photos des chambres er salons diponibles
	 		$stOff = 'Invalide';
			$req = $bdd->prepare('SELECT * FROM galeries,maisons,bailleurs WHERE galeries.IdMaison = maisons.IdM AND maisons.IdB = bailleurs.Idbail AND bailleurs.IdBail = :idBail');
            $req->execute(array('idBail' => $idBail));
            $nbPhotos = $req->rowCount();
		?>
	 	<h3>  GALERIE PHOTOS [ <small><?php echo $nbPhotos; ?> Photos </small>]</h3>	
	 </ul>
	 		
	<!-- Historique des maisons en cours -->		
	<table class="table table-bordered" >           
        <thead>
            <tr class="breadcrumb">
                <th>Photo</th>
                <th>Titre</th>
                <th>Description</th>
				<th>Dtate Publication</th>
                <th>Maison</th>
                <th>Action</th>
                
               
			</tr>
        </thead>
            <tbody>
            	<?php 
		// Requette pour afficher le nombre des maisons en cours de reservation
	 		$stOff = 'Invalide';
			$req = $bdd->prepare('SELECT * FROM galeries,maisons,bailleurs WHERE galeries.IdMaison = maisons.IdM AND maisons.IdB = bailleurs.Idbail AND bailleurs.IdBail = :idBail');
            $req->execute(array('idBail' => $idBail));
            while ($resMaison = $req->fetch()) { ?>
            <tr>
                <td > <a href="themes/images/galerie/<?php echo $resMaison['Galerie']; ?>"><img style="width:100% " src="themes/images/galerie/<?php echo $resMaison['Galerie']; ?>" alt=""/></a></td>
                <td><?php echo utf8_encode($resMaison['LibellePhoto']); ?></td>
                <td><?php echo utf8_encode($resMaison['DescriptionPhoto']); ?></td>
                <td><?php echo $resMaison['DateCreation']; ?></td>
                <td><?php echo utf8_encode($resMaison['Libelle']); ?></td>
                
                
                <td><div class="input-append"><a href="mod_photo.php?idIm=<?php echo $resMaison['IdIm']; ?>"  style="padding-right:0"><span class="btn btn-medium btn-warning pull-right">Modifier</span></a></div></td>

            </tr>
        <?php  } ?>
           
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
			<h5>AJOUTER UNE PHOTO</h5>
			
	<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">		
		<div class="control-group">
			<label class="control-label"  for="inputFname1">Libelle <sup style="color: red;">*</sup></label>
			<div class="controls">
			  <input type="text" name="libelle" id="inputFname1" placeholder="Libelle" class="input-xlarge" required="">
			</div>
		 </div>
		 <div class="control-group">
			<label class="control-label" for="inputPassword1">Description <sup style="color: red;">*</sup></label>
			<div class="controls">
			  <textarea class="input-xlarge" name="description" id="textarea"  style="height:65px" required=""></textarea>
			</div>
		  </div>
		  <div class="control-group">
		  	<label class="control-label" for="inputPassword1">Choisir une maison <sup style="color: red;">*</sup></label>
		  	<div class="controls">
		  		<select class="input-xlarge" id="textarea" name="maison">
			  		<option value="">-</option>
			  		<?php
			  			$req = $bdd->prepare('SELECT * FROM maisons WHERE IdB = :idBail');
			  			$req->execute(array('idBail' => $idBail));
			  			while ($res = $req->fetch()) { ?>		  		
			  		<option value="<?php echo $res['IdM']; ?>">N° <?php echo $res['Num']; ?></option>
			  		<?php 	}
			  		?>
		  		</select>
		  	</div>
		  </div>
		 <div class="control-group">
			<label class="control-label" for="inputLnam">Date <sup style="color: red;">*</sup></label>
			<div class="controls">
			  <input type="date" name="dtJour" id="inputLnam" placeholder="Numero Maison" class="input-xlarge" value="<?php echo date('Y-m-d') ;?>" disabled="" required="">
			</div>
		 </div>

		  
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Photo  <sup style="color: red;">*</sup></label>
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