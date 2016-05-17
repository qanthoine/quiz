<?php
$type = 3;

// Reprise de la requête [[Requête 3]]
$req_nb_reponse->bindParam('id_q',$i,PDO::PARAM_INT);
$req_nb_reponse->execute();
$nb_reponse = $req_nb_reponse->rowcount();
// Fin de la requête [[Requête 3]]

	for($_POST['input'][$i][$type][$id_reponse];$id_reponse <= $nb_reponse;$id_reponse++)
	{
		$points = $_SESSION['points'][$id_quiz];
		$id_rep = $_POST['input'][$i][$type][$id_reponse];
		
		// Reprise de la requête [[Requête 2]]
		$req_resultat->bindParam('id_q',$i,PDO::PARAM_INT);
		$req_resultat->bindParam('id_r',$id_reponse,PDO::PARAM_INT);
		$req_resultat->execute();
		$resultat_req = $req_resultat->fetch();
		// Fin de la requête [[Requête 2]]

		
		if($resultat_req['resultat'] == $id_rep)
		{
				$_SESSION['points'][$id_quiz] = $points + $points_r;
				$_SESSION['question'][$id_quest][$type][$id_reponse] = $id_rep;
		}
		else
		{
				$_SESSION['points'][$id_quiz] = $points + 0;
				$_SESSION['question'][$id_quest][$type][$id_reponse] = $id_rep;
		}
		$req_write_historique->bindParam('reponse_id',$id_rep,PDO::PARAM_INT);
		$req_write_historique->execute();

	}