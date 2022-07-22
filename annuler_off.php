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
	        $idOff = $result['IdM'];
	        if ($result) {
	        	
	        	# requette pour anuler une reservation
	        	if (isset($_POST['annulerOff'])) {
	        		
	        		$req = $bdd->prepare('DELETE FROM maisons WHERE IdM = :idOff');
	        	$req->execute(array('idOff' => $idOff ));
		        	if ($req) {
		        		header('Location:espace_bailleur.php');
		        	}else{
		        		
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
    <title>Historique de location</title>
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

	<div id="login" class="modal  fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Annuler l'offre Maison <?php if (isset($statut)) {
				echo $statut;
			} ?></h3>
		  </div>
		  <div class="modal-body" style="text-align: center;">
			<form class="form-vertical loginFrm" method="POST" action="" >
			  <h4>Voulez-vous vraiment annuler cette offre ?</h4>
			  	<table align="center">
				  <tr class="gallery"><td colspan="2"><span ><a href="themes/images/maisons/<?php echo $result['Photo']; ?>"><img width="200" src="themes/images/maisons/<?php echo $result['Photo']; ?>" alt=""/></a></span></td></tr>

				  <tr><td><input type="submit" class="btn btn-success" value="Oui" name="annulerOff"></td>

				  <td><a href="espace_bailleur.php" class="btn btn-default"><span >Non</span></a></td></tr>	
				</table>		
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