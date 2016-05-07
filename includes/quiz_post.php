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

	// Liste des variables
	$_SESSION['points'] = array();
	$points_q = 100 / $nb_rep_total;
	$points_r = round($points_q, 2);
	// Fin de Liste des variables

	if(count($_POST['input']) == $nb_q)
	{
		$i = 1;
		for($_POST['input'][$i];$i <= $nb_q;$i++)
		{
			$id_quest = $i;

			// Reprise de la requête [[Requête 1]]
			$req_r->bindParam('id_q',$id_quest,PDO::PARAM_INT);
			$req_r->execute();
			$sql_nb_rep = $req_r->fetch();
			$nb_rep = $sql_nb_rep['nb_rep'];

			// Fin de la requête [[Requête 1]]

			if($nb_rep == 1) // Si le nombre de reponse possible est égale à 1
			{
				$i_incre = 1;
				$id_rep = $_POST['input'][$i];

				// Reprise de la requête [[Requête 2]]
				$req_resultat->bindParam('id_q',$id_quest,PDO::PARAM_INT);
				$req_resultat->bindParam('id_r',$id_rep,PDO::PARAM_INT);
				$req_resultat->execute();
				$resultat_req = $req_resultat->fetch();
				// Fin de la requête [[Requête 2]]

				$points = $_SESSION['points'][$id_quiz];		
				if($resultat_req['resultat'] == 1)
				{
					$_SESSION['points'][$id_quiz] = $points + $points_r;
					$_SESSION['question'][$id_quest][$i][$i_incre] = $id_rep;
				}
				else
				{
					$_SESSION['points'][$id_quiz] = $points + 0;
					$_SESSION['question'][$id_quest][$i][$i_incre] = $id_rep;
				}
			}
			else // Sinon ..
			{
				$id_case = 1;

				// Reprise de la requête [[Requête 3]]
				$req_nb_reponse->bindParam('id_q',$id_quest,PDO::PARAM_INT);
				$req_nb_reponse->execute();
				$nb_reponse = $req_nb_reponse->rowcount();
				// Fin de la requête [[Requête 3]]
				if(count($_POST['input'][$i]) == $nb_rep)
				{
					for($_POST['input'][$i][$id_case];$id_case <= $nb_reponse;$id_case++)
					{
						if(!empty($_POST['input'][$i][$id_case]))
						{
							$i_incre = $id_case;
							$id_rep = $_POST['input'][$i][$id_case];

							// Reprise de la requête [[Requête 2]]
							$req_resultat->bindParam('id_q',$id_quest,PDO::PARAM_INT);
							$req_resultat->bindParam('id_r',$id_rep,PDO::PARAM_INT);
							$req_resultat->execute();
							$resultat_req = $req_resultat->fetch();
							// Fin de la requête [[Requête 2]]

							$points = $_SESSION['points'][$id_quiz];	
							if($resultat_req['resultat'] == 1)
							{
								$_SESSION['points'][$id_quiz] = $points + $points_r;
								$_SESSION['question'][$id_quest][$i][$i_incre] = $id_rep;
							}
							else
							{
								$_SESSION['points'][$id_quiz] = $points + 0;
								$_SESSION['question'][$id_quest][$i][$i_incre] = $id_rep;
							}
						}
					}
				}
				else
				{
					header('Location: ../quiz.php?quiz='.$id_quiz.'&erreur=3');
					exit();
					
				}
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