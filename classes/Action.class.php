<?php 
class TesteContrat{
	//Fonction pour tester la validite du contrat
	public function testerValiditeContrat($mois,$idRes){
		$sql = "SELECT * 
		FROM reservations
		WHERE MONTH(now()) - MONTH(DebutContrat) <= ?
		AND IdRes = ? ";
		$data = $this->executerRequete($sql,array($mois,$idRes));
		return $data->fetch();
		
	}	
}

?>