<?php
include('bdd.php');
session_start();
if(!empty($_POST['id_quiz']))
{
	$id_quiz = htmlspecialchars($_POST['id_quiz']);	
	$req = $bdd->prepare('SELECT * FROM quiz_questions WHERE quiz_id = :id'); //Je compte les questions pour le quiz  ..
	$req->bindParam('id',$id_quiz,PDO::PARAM_INT);
	$req->execute();
	$req_resultat = $bdd->prepare('SELECT sum(nb_rep) AS sql_nb_rep FROM quiz_questions WHERE quiz_id = :id'); // Je compte le nombre de réponses totales pour le quiz	
	$req_resultat->bindParam('id',$id_quiz,PDO::PARAM_INT);
	$req_resultat->execute();
	$nb_q = $req->rowcount();
	$sql_nb_r = $req_resultat->fetch();
	$nb_r = $sql_nb_r['sql_nb_rep'];
	$req_r= $bdd->prepare('SELECT resultat FROM quiz_reponses WHERE quiz_id = :id AND id_reponse = :id_r AND id_question = :id_q'); // Je prepare la récupération des résultats des questions
	$req_r->bindParam('id',$id_quiz,PDO::PARAM_INT);
	$req_nb_question = $bdd->prepare('SELECT * FROM quiz_reponses WHERE quiz_id = :id AND id_question = :id_question'); // Je prepare la récupération du nombre de reponse
	$req_nb_question->bindParam('id',$id_quiz,PDO::PARAM_INT);
	$points_q = 100 / $nb_r; // 100 divisé par le nombre de réponses totales
	$points_r = round($points_q, 2); // J'arrondi le résultat
	$i_q = 1; // Premiere question = 1
	for($_POST[$i_q];$i_q <= $nb_q;$i_q++) // Boucle pour les questions
	{
		$i_r = 1;
		$id_input = $_POST[$i_q];
		$nb_reponse = $req_nb_question->rowcount();
		$req_nb_question->bindParam('id_question',$i_q,PDO::PARAM_INT);
		$req_r->bindParam('id_q',$i_q,PDO::PARAM_INT);
		$req_nb_question->execute();
		$nb_reponse = $req_nb_question->rowcount();
		for($id_input[$i_r];$i_r <= $nb_reponse;$i_r++) // Boucle vérification des résultats
		{
			$req_r->bindParam('id_r',$i_r,PDO::PARAM_INT);
			$req_r->execute();
			$resultat_req = $req_r->fetch();
			$points = $_SESSION['points'][$id_quiz];
			if($resultat_req['resultat'] == 1)
			{
				$_SESSION['points'][$id_quiz] = $points + $points_r;
				$_SESSION[$i_q][$i_r] = $i_r;
				echo $_SESSION['points'][$id_quiz];
			}
			else
			{
				$_SESSION['points'][$id_quiz] = $points + 0;
				$_SESSION[$i_q][$i_r] = $i_r;
			}
		}	
	}
	$_SESSION['fin'] = 1;
	$_SESSION['quiz_termine'][$id_quiz] = $id_quiz;
	header('Location: ../correction.php?quiz='.$id_quiz);
}
else
{
	header('Location: ../quiz.php?quiz='.$id_quiz.'&erreur=1');
}