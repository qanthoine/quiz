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

	// Liste des variables
	$points_q = 100 / $nb_rep_total;
	$points_r = round($points_q, 2);
	// Fin de Liste des variables

	if(count($_POST['input']) == $nb_q)
	{
		$i = 1;
		for($_POST['input'][$i];$i <= $nb_q;$i++)
		{
			$id_quest = $i;

			// Reprise de la requête [[Requête 4]]
			$req_type->bindParam('id_q',$id_quest,PDO::PARAM_INT);
			$req_type->execute();
			$type_req = $req_type->fetch();
			$req_type->closeCursor();
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
		header('Location: ../correction.php?quiz='.$id_quiz);
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