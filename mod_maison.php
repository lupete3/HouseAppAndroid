<?php
	include('config/connexion.php');

	session_start();

	if (isset($_SESSION['idBail'])) {
	

	///Etat de la maison
	$etatMaison = 'Innocupee';
	$statutMaison = 'Valide';
	$statut = '';

	$stRes = 'Invalide';
	
    //Requette pour annuler une reservation
        if (isset($_GET['idM'])) {
        	//Requette pour recuperer num de reservation
			$reqt = $bdd->prepare('SELECT * FROM maisons WHERE  IdM = :idM');
	        $reqt->execute(array('idM' => $_GET['idM']));
	        $result = $reqt->fetch();
	        $idM = $result['IdM'];
	        if ($result) {
	        	
	        	if (isset($_POST['modifier'])) {
	        		# om recupere la photo
					$ptName = $_FILES['photo']['name'];

        				$tailleMax = 3097152;
        				$extValide = array('jpg','jpg','png','gif' );

        				if ($_FILES['photo']['size'] <= $tailleMax) {
        					$extentionUpload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
        					if (in_array($extentionUpload, $extValide)) {
        						$chemin = "themes/images/maisons/".$idM.".".$extentionUpload;
        						$resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
        						if ($resultat) {
        							$reqMod = $bdd->prepare('UPDATE maisons SET 
				        			Libelle = :libelle, 
				        			Num = :num,
				        			Prix = :prix,
				        			Commune = :commune,
				        			Quartier = :quartier,
				        			Avenue = :avenue,
				        			NbChambre = :nbChambre,
				        			NbSalon = :nbSalon,
				        			NbDouche = :nbDouche,
				        			Description = :description,
				        			Photo = :photo 
				        			WHERE IdM = :idM');

				        			$reqMod->execute(array(
				        			'libelle' => $_POST['libelle'],
				        			'num' => $_POST['num'],
				        			'prix' => $_POST['prix'],
				        			'commune' => $_POST['commune'],
				        			'quartier' => $_POST['quartier'],
				        			'avenue' => $_POST['avenue'],
				        			'nbChambre' => $_POST['chambre'],
				        			'nbSalon' => $_POST['salon'],
				        			'nbDouche' => $_POST['douche'],
				        			'description' => $_POST['description'],
				        			'photo' => $idM.".".$extentionUpload,
				        			'idM' => $idM
				        			
				        			 ));
				        			if ($reqMod) {
				        				$statut = 'Modification reussie !';
				        				header('Location:add_mod_maison.php');
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
        					$statut = 'La taille de la photo \'est pas valide';
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
    <title>Modification de ma maison</title>
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

	<div id="login" class="modal  fade in" tabindex="-6" role="dialog" aria-labelledby="login" aria-hidden="false" >
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4>Modification de la Maison </h4>
		  </div>
		  <div class="modal-body" style="text-align: center;">
			<form class="form-vertical loginFrm" method="POST" action="" enctype="multipart/form-data" >
			  	<table align="center">
				  <tr>
				  		<td colspan="2">
				  			<span ><a href="themes/images/maisons/<?php echo $result['Photo']; ?>">
				  				<img width="90" src="themes/images/maisons/<?php echo $result['Photo']; ?>" alt=""/></a>
				  			</span>
				  		</td>
				  	</tr>
				</table>		
		
			  <div class="control-group">	
			  <textarea id="inputEmail" name="libelle"><?php echo utf8_encode($result['Libelle']); ?></textarea>							
			  <textarea id="inputEmail" name="description"><?php echo utf8_encode($result['Description']); ?></textarea>							
			  </div>
			  <div class="control-group">								
				<input type="text" id="inputEmail" name="num" placeholder="Email" value="<?php echo $result['Num']; ?>" required>
				<input type="number" id="inputEmail" name="prix" placeholder="Email" value="<?php echo $result['Prix']; ?>" required>
			  </div>
			  <div class="control-group">								
				<input type="text" id="inputEmail" name="commune" placeholder="Email" value="<?php echo $result['Commune']; ?>" required>
				<input type="text" id="inputEmail" name="quartier" placeholder="Email" value="<?php echo $result['Quartier']; ?>" required>
			  </div>
			  <div class="control-group">								
				<input type="text" id="inputEmail" name="avenue" placeholder="Email" value="<?php echo $result['Avenue']; ?>" required>
				<input type="number" id="inputEmail" name="chambre" placeholder="Email" value="<?php echo $result['NbChambre']; ?>" required>
			  </div>
			  <div class="control-group">								
				<input type="number" id="inputEmail" name="salon" placeholder="Email" value="<?php echo $result['NbSalon']; ?>" required>
				<input type="number" id="inputEmail" name="douche" placeholder="Email" value="<?php echo $result['NbDouche']; ?>" required>
			  </div>
			  <div class="control-group">								
				<input type="file" id="inputEmail" name="photo" placeholder="Email" required>
			  </div>
			  
			  
			  <div class="control-group">
			  	<input type="submit" name="modifier" class="btn btn-medium btn-info" value="Modifier"> 
			  	<a href="add_mod_maison.php" class="btn btn-default"><span >Annuler</span></a>
			  	
			  	<?php if (isset($statut)) {
			  		echo '<label style="color:red">'.$statut.'</babel>';
			  	} ?>
			  </div>
			</form>		
		  </div>
	</div>	

<!-- Placed at the end of the document so the pages load faster ============================================= -->
	<script src="themes/js/jquery.js" type="text/javascript"></script>
	<script src="themes/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="themes/js/google-code-prettify/prettify.js"></script>
	
	<script src="themes/js/bootshop.js"></script>
    <script src="themes/js/jquery.lightbox-0.5.js"></script>
</body>

</html>

<?php }else{

		header('Location:espace_bailleur.php');

	} ?>