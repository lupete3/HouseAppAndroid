<?php
	//======================== tester la validite des contrat en location
	$reqData = $bdd->prepare("SELECT * FROM reservations
		WHERE MONTH(now()) - MONTH(DebutContrat) <= ?
		AND IdRes = ? ");
	$reqData->execute(array($mois,$idRes));
	$data = $reqData->fetch();
?>