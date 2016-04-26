<?php
include('bdd.php');
session_start();
if(!empty($_POST['id_quiz']))
{
	$id_quiz = htmlspecialchars($_POST['id_quiz']);	
	$req = $bdd->prepare('SELECT * FROM quiz_questions WHERE quiz_id = :id');
	$req->bindParam('id',$id_quiz,PDO::PARAM_INT);
	$req->execute();
	$nb_q = $req->rowcount();
	$req_r= $bdd->prepare('SELECT resultat FROM quiz_reponses WHERE quiz_id = :id AND id_reponse = :id_r AND id_question = :id_q');
	$req_r->bindParam('id',$id_quiz,PDO::PARAM_INT);
	if(count($_POST['input']) == $nb_q)
	{
		$points_q = 100 / $nb_q;
		$points_r = round($points_q, 2);
		$i = 1;
		for($_POST['input'][$i];$i <= $nb_q;$i++)
		{
			$id_input = $_POST['input'][$i];
			$id_quest = $i;
			$req_r->bindParam('id_r',$id_input,PDO::PARAM_INT);			
			$req_r->bindParam('id_q',$id_quest,PDO::PARAM_INT);
			$req_r->execute();
			$resultat_req = $req_r->fetch();
			$points = $_SESSION['points'][$id_quiz];
			if($resultat_req['resultat'] == 1)
			{
				$_SESSION['points'][$id_quiz] = $points + $points_r;
				$_SESSION['question'][$id_quest] = $id_input;
			}
			else
			{
				$_SESSION['points'][$id_quiz] = $points + 0;
				$_SESSION['question'][$id_quest] = $id_input;
			}	
		}
		$_SESSION['fin'] = 1;
		$_SESSION['quiz_termine'][$id_quiz] = $id_quiz;
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