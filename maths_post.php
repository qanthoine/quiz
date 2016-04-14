<?php
if(!empty($_POST['question_un'] AND $_POST['question_deux'] AND $_POST['question_trois'] AND $_POST['question_quatre']))
{
	session_start();
	$_SESSION['question_un'] = htmlspecialchars($_POST['question_un']);
	$_SESSION['question_deux'] = htmlspecialchars($_POST['question_deux']);
	$_SESSION['question_trois'] = htmlspecialchars($_POST['question_trois']);
	$_SESSION['question_quatre'] = htmlspecialchars($_POST['question_quatre']);
	if($_SESSION['question_un'] == 'reponse_un')
	{
		$points_q_un = 25;
	}
	else
	{
		$points_q_un = 0;
	}	
	if($_SESSION['question_deux'] == 'reponse_deux')
	{
		$points_q_deux = 25;
	}
	else
	{
		$points_q_deux = 0;
	}
	if($_SESSION['question_trois'] == 'reponse_trois')
	{
		$points_q_trois = 25;
	}
	else
	{
		$points_q_trois = 0;
	}
	if($_SESSION['question_quatre'] == 'reponse_un')
	{
		$points_q_quatre = 25;
	}
	else
	{
		$points_q_quatre = 0;
	}
	$resultat = $points_q_un + $points_q_deux + $points_q_trois + $points_q_quatre;
	echo $resultat;
	$_SESSION['resultat'] = $resultat;
}
?>