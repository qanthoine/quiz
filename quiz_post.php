<?php
include('bdd.php');
if(!empty($_POST['id_quiz']))
{
	$id_quiz = htmlspecialchars($_POST['id_quiz']);	
	$req = $bdd->query('SELECT * FROM quiz_questions WHERE quiz_id = '.$id_quiz.'');
	$nb_q = $req->rowcount();
	if(count($_POST['input']) == $nb_q)
	{		
		for($i=1;$i<=$nb_q;$i++)
		{
			echo "Bonjour";		
		}
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