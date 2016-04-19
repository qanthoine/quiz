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
		$_SESSION['points'] = 0;
		$points_q = 100 / $nb_q;	
		$i = 1;
		for($_POST['input'][$i];$i <= $nb_q;$i++)
		{
			$id_input = $_POST['input'][$i];
			$id_quest = $i;
			$req_r->bindParam('id_r',$id_input,PDO::PARAM_INT);			
			$req_r->bindParam('id_q',$id_quest,PDO::PARAM_INT);
			$req_r->execute();
			$resultat_req = $req_r->rowcount();
			$points = $_SESSION['points'];
			if($resultat_req == 1)
			{
				$_SESSION['points'] = $points + $points_q;
			}	
		}
		header('Location: correction.php?quiz='.$id_quiz);
	}
	else
	{
		header('Location: quiz.php?quiz='.$id_quiz);
	}
}
else
{
	header('Location: quiz.php?quiz='.$id_quiz);
}