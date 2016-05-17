<?php
include('bdd.php');
session_start();
if(!empty($_POST['id_quiz']))
{
	$id_quiz = htmlspecialchars($_POST['id_quiz']);

	// Je compte les questions	
	$req = $bdd->prepare('SELECT * FROM quiz_questions WHERE quiz_id = :id');
	$req->bindParam('id',$id_quiz,PDO::PARAM_INT);
	$req->execute();
	$nb_q = $req->rowcount();
	$req->closeCursor();
	// Fin

	// Je compte le nombre de resultats
	$req_nb_rep = $bdd->prepare('SELECT sum(nb_rep) AS nb_rep_total FROM quiz_questions WHERE quiz_id = :id');
	$req_nb_rep->bindParam('id',$id_quiz,PDO::PARAM_INT);
	$req_nb_rep->execute();
	$sql_nb_rep = $req_nb_rep->fetch();
	$nb_rep_total = $sql_nb_rep['nb_rep_total'];
	$req_nb_rep->closeCursor();
	// Fin	

	// Je prépare la requête pour récuperer le nombre de reponse par question [[Requête 1]]
	$req_r= $bdd->prepare('SELECT nb_rep FROM quiz_questions WHERE quiz_id = :id AND id_question = :id_q');
	$req_r->bindParam('id',$id_quiz,PDO::PARAM_INT);
	// Pause de la préparation

	// Je prépare la requête pour récuperer les résultats [[Requête 2]]
	$req_resultat= $bdd->prepare('SELECT resultat FROM quiz_reponses WHERE quiz_id = :id AND id_question = :id_q AND id_reponse = :id_r');
	$req_resultat->bindParam('id',$id_quiz,PDO::PARAM_INT);
	// Pause de la préparation

	// Je prépare la requête pour récuperer le nombre de réponse résultats [[Requête 3]]
	$req_nb_reponse= $bdd->prepare('SELECT * FROM quiz_reponses WHERE quiz_id = :id AND id_question = :id_q');
	$req_nb_reponse->bindParam('id',$id_quiz,PDO::PARAM_INT);
	// Pause de la préparation

	// Je prépare la requête pour récuperer le type de Quizz [[Requête 4]]
	$req_type= $bdd->prepare('SELECT type FROM quiz_questions WHERE quiz_id = :id AND id_question = :id_q');
	$req_type->bindParam('id',$id_quiz,PDO::PARAM_INT);
	// Pause de la préparation

	// Je prépare la requête pour récuperer la reponse du champs à saisir [[Requête 5]]
	$req_recup_reponse= $bdd->prepare('SELECT reponse FROM quiz_reponses WHERE quiz_id = :id AND id_question = :id_q AND id_reponse = :id_r');
	$req_recup_reponse->bindParam('id',$id_quiz,PDO::PARAM_INT);
	// Pause de la préparation

	// Creation Historique
	$req_creat_historique = $bdd->prepare("INSERT INTO quiz_historique_info (ip, quiz_id, time_now) VALUES (:ip, :quiz_id, :time_now)");
	// Pause de la préparation

	// Recuperation de la dernière ligne + traitement
	$req_historique = $bdd->prepare('SELECT id FROM quiz_historique_info ORDER BY id DESC LIMIT 0,1');
	// Pause de la préparation

	// Creation de DATA HISTORIQUE
	$req_write_historique = $bdd->prepare("INSERT INTO quiz_historique_data (historique_id, question_id, reponse_id) VALUES (:id, :question_id, :reponse_id)");
	$req_write_historique->bindParam('id',$lastid,PDO::PARAM_INT);
	// Pause de la préparation

	// UPDATE SCORE
	$req_update_score = $bdd->prepare("UPDATE quiz_historique_info SET score = :score WHERE id = :lastid");
	$req_update_score->bindParam('lastid',$lastid,PDO::PARAM_INT);
	// Pause de la préparation

	// Liste des variables
	$points_q = 100 / $nb_rep_total;
	$points_r = round($points_q, 2);
	$_SESSION['points'][$id_quiz] = 0;
	$ip = $_SERVER['REMOTE_ADDR'];
	$time_now = time();
	// Fin de Liste des variables

	//Creation historique
	$req_creat_historique->bindParam('ip',$ip,PDO::PARAM_INT);
	$req_creat_historique->bindParam('quiz_id',$id_quiz,PDO::PARAM_INT);
	$req_creat_historique->bindParam('time_now',$time_now,PDO::PARAM_INT);
	$req_creat_historique->execute();
	$req_historique->execute();
	$last_id = $req_historique->fetch();
	$lastid = $last_id['id'];
	//Fin

	if(count($_POST['input']) == $nb_q)
	{
		$i = 1;
		for($_POST['input'][$i];$i <= $nb_q;$i++)
		{
			$points = $_SESSION['points'][$id_quiz];
			$id_quest = $i;

			// Reprise de la requête [[Requête 4]]
			$req_type->bindParam('id_q',$id_quest,PDO::PARAM_INT);
			$req_type->execute();
			$type_req = $req_type->fetch();
			$req_type->closeCursor();
			$req_write_historique->bindParam('question_id',$id_quest,PDO::PARAM_INT);
			// Fin de la requête [[Requête 4]]

			$type = $type_req['type'];
			if($type == 1)
			{
				include('formulaire_qcm.php');
			}
			elseif($type == 2)
			{
				include('formulaire_champs.php');
			}
			elseif($type == 3)
			{
				include('formulaire_ordonne.php');
			}	

		}
		$_SESSION['fin'] = 1;
		$score_final = $_SESSION['points'][$id_quiz];
		$req_update_score->bindParam('score',$score_final,PDO::PARAM_INT);
		$req_update_score->execute();
		//header('Location: ../correction.php?quiz='.$id_quiz);
	}
	else
	{
		header('Location: ../quiz.php?quiz='.$id_quiz.'&erreur=2');
	}
}
else
{
	header('Location: ../quiz.php?quiz='.$id_quiz.'&erreur=1');
}