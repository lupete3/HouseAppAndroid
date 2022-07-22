<?php
	include('config/connexion.php');

	session_start();

	if (isset($_SESSION['idAdmin'])) {
	
	
    //Requette pour supprimer un bailleur du syteme
        if (isset($_GET['idBail'])) {
        	//Requette pour recuperer num de reservation
			$reqt = $bdd->prepare('SELECT * FROM bailleurs WHERE  IdBail = :idBail');
	        $reqt->execute(array('idBail' => $_GET['idBail']));
	        $result = $reqt->fetch();
	        $idBail = $result['IdBail'];
	        if ($result) {
	        	
	        	# requette poursupprimer un agent
	        	if (isset($_POST['supprimerAgent'])) {
	        		/*$req = $bdd->prepare('DELETE FROM bailleurs WHERE IdBail = :idBail');
	        		$req->execute(array('idBail' => $_GET['idBail'] ));
		        	if ($req) {
		        		header('Location:gBailleurs.php');
		        		echo "<meta http-equiv='refresh' content'0;URL=gBailleurs.php'>";
		        	}else{
		        		
		        	}*/
		        	$reqExist = $bdd->prepare('SELECT * FROM bailleurs,maisons,reservations, WHERE bailleurs.IdBail = maisons.IdB AND resevations.IdMaison = maisons.IdM AND bailleurs.IdBail = :idBail');
		        	$reqExist->execute(array('idBail' => $_GET['idBail']));
		        	$resExist = $reqExist->rowCount();
		        	if ($resExist == 0) {
		        		$statut = '';
		        		
		        	}else{
						$req = $bdd->prepare('DELETE FROM bailleurs WHERE IdBail = :idBail');
		        		$req->execute(array('idBail' => $_GET['idBail'] ));
			        	if ($req) {
			        		header('Location:gBailleurs.php');
			        		echo "<meta http-equiv='refresh' content'0;URL=gBailleurs.php'>";
			        	}else{
			        		
			        	}	        	
			        }
	        	}
	        }

        }else{
        	header('Location:gBailleurs.php');
        }
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Suppression Agent</title>
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
			<a href="gBailleurs.php" class="close"><span >x</span><meta http-equiv='refresh' content'0;URL=gBailleurs.php'></a>
			<h3>Supprimer Agent du systeme </h3>
		  </div>
		  <div class="modal-body" style="text-align: center;">
			<form class="form-vertical loginFrm" method="POST" action="" >
				<p><?php if (isset($statut)) {
					echo '<div class="alert alert-block alert-error fade in">';
				    echo '<a href = "gBailleurs.php" class="close" >×</a>';
				    echo '<strong>Ce Bailleur a des maisons en cours de réservation. Impossible de le supprimer. Vous ne pouvez que le modifier ';
					echo '</div>';
		        	echo "<meta http-equiv='refresh' content'0;URL=gBailleurs.php'>";
				} ?></p>
			  <h4> Voulez-vous vraiment supprimer <h4 style="color: blue;"><?php echo $result['NomBail'].' ?'; ?></h4> </h4>
			  	<table align="center">
				  <tr class="gallery">
				  	<td colspan="2">
				  		<span >
				  			<a href="themes/images/avatar_bail/<?php echo $result['Avatar']; ?>"><img width="200" style="border-radius: 200px;" src="themes/images/avatar_bail/<?php echo $result['Avatar']; ?>" alt=""/>
				  			</a>
				  		</span>
				  	</td>
				  </tr>
				  

				  <tr><td>
				  	<div class="control-group">	
				  	<input type="submit" id="inputEmail" class="btn btn-success" value="Oui" name="supprimerAgent">
				  	<a href="gBailleurs.php" id="inputEmail" class="btn btn-default"><span >Non</span><meta http-equiv='refresh' content'0;URL=gBailleurs.php'></a> 
				  	<?php if (isset($statut)){
				  		echo '<a href="mod_bailleur.php?idBail='.$result['IdBail'].'" id="inputEmail" class="btn btn-info"><span >Modifier</span></a>';
				  	}?>
				  </div></td>

				 </tr>	
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