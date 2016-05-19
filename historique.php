<?php
include('includes/bdd.php');
?>
<!DOCTYPE html>
<html>
<center>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="styles/style.css"/>
        <title>Votre Progression</title>    			
    </head>
<?php    
////////////////Requetes SQL\\\\\\\\\\\\\\\\\\
// Récuperation de l'IP (Verification de l'identité)
$req_ip = $bdd->prepare('SELECT quiz_id, ip, score FROM quiz_historique_info WHERE id = :id');
//Nom Quizz
$req_info = $bdd->prepare('SELECT nom_quiz FROM quiz WHERE quiz_id = :id_quiz');
//Recupération des Questions
$req_question = $bdd->prepare('SELECT id_question, question, type, nb_rep FROM quiz_questions WHERE quiz_id = :id_quiz');
//Préparation de la Recupération des Réponses
$req_reponse = $bdd->prepare('SELECT id_reponse, reponse FROM quiz_reponses WHERE id_question = :question_id AND quiz_id = :id_quiz ORDER BY id_reponse');
//Requete récuperation Historique_DATA
$req_historique_data = $bdd->prepare('SELECT reponse_id FROM quiz_historique_data WHERE question_id = :question_id AND historique_id = :historique_id');
//Requete récuperation valeur reponse_id
$req_val_reponse = $bdd->prepare('SELECT reponse FROM quiz_reponses WHERE id_question = :id_question AND quiz_id = :quiz_id AND id_reponse = :id_reponse');
//Préparation de la Requete pour le Type Quizz = 3
$recup_reponse_trois = $bdd->prepare('SELECT reponse FROM quiz_reponses WHERE id_question = :id_question AND quiz_id = :quiz_id ORDER BY id_reponse');
///////////////
if(isset($_GET['id']) AND $_GET['id'] > 0)
{
	$id = htmlspecialchars($_GET['id']);
	$req_v = $bdd->prepare('SELECT * FROM quiz_historique_info WHERE id = :id');
    $req_v->bindParam('id',$id, PDO::PARAM_INT);
    $req_v->execute();
    $quiz_v = $req_v->fetch();
    $req_v->closeCursor();
    if($quiz_v)
    {
    	$ip_user = $_SERVER['REMOTE_ADDR'];
    	$req_ip->bindParam('id',$id,PDO::PARAM_STR);
    	$req_ip->execute();
    	$resul_req_ip = $req_ip->fetch();
    	$ip_req = $resul_req_ip['ip'];
    	$quiz_id_req = $resul_req_ip['quiz_id'];
    	$score = $resul_req_ip['score'];
    	$req_ip->closeCursor();
    	if($ip_req == $ip_user)
    	{
			$req_question->bindParam(':id_quiz',$quiz_id_req,PDO::PARAM_INT);
			$req_question->execute();
			$req_info->bindParam('id_quiz',$quiz_id_req,PDO::PARAM_STR);
			$req_info->execute();
			$nom_quiz = $req_info->fetch();
			$req_val_reponse->bindParam(':quiz_id',$quiz_id_req,PDO::PARAM_INT);
			$req_historique_data->bindParam('historique_id',$id,PDO::PARAM_INT);
			$recup_reponse_trois->bindParam('quiz_id',$quiz_id_req,PDO::PARAM_INT);
			?>
			<h2>Quiz : <?php echo $nom_quiz['nom_quiz'];?></h2>
			<h3>Score : <?php echo $score;?>%</h3>
			<?php
			while($quiz_question = $req_question->fetch())
			{
	            ?>
	            <div class="quiz_question">
	                <?php
	        		$question_id = htmlspecialchars($quiz_question['id_question']);
	        		//Requete Historique DATA
					$req_historique_data->bindParam('question_id',$question_id,PDO::PARAM_INT);
					$req_historique_data->execute();			
					$req_val_reponse->bindParam('id_question',$question_id,PDO::PARAM_INT);
					$recup_reponse_trois->bindParam('id_question',$question_id,PDO::PARAM_INT);
					$recup_reponse_trois->execute();
					//Fin 
	        		$question = htmlspecialchars($quiz_question['question']);
	                $nb_rep = htmlspecialchars($quiz_question['nb_rep']);
	                $type_quizz = htmlspecialchars($quiz_question['type']);
	        		?>
	                <div id="titre_question">
		    		    <h2>Question n°<?php echo $question_id;?></h2>
	                    <h3>(<?php echo $nb_rep;?> reponses possibles)</h3>
	                </div>
	                <div id="question_question">    
		    		    <?php echo $question;?><br>
	                </div>
	        		<div id ="vosreponses">
	        			<?php
						if($type_quizz == 1)
						{
							echo "Vous avez répondu :";
							while($resultat_req = $req_historique_data->fetch())
							{
								$reponse_id = $resultat_req['reponse_id'];			
								$req_val_reponse->bindParam(':id_reponse',$reponse_id,PDO::PARAM_INT);
								$req_val_reponse->execute();
								$val_rep = $req_val_reponse->fetch();
								echo "<br>";
								echo $val_rep['reponse'];
							}
						}
						elseif($type_quizz == 2)
						{
							echo "Vous avez répondu :";
							$resultat_req = $req_historique_data->fetch();
							echo "<br>";
							echo $resultat_req['reponse_id'];
						}
						elseif($type_quizz == 3)
						{
							echo "Vous avez répondu :";
							while($resultat_req = $req_historique_data->fetch())
							{
								$resultat = $recup_reponse_trois->fetch();
								echo "<br>";
								echo $resultat_req['reponse_id'];
								echo " => ";
								echo $resultat['reponse'];
							}
						}
						?>
					</div>
				</div>
				<?php	
			}
    	}
    	else
    	{
    		header('Location: progress.php?quiz='.$quiz_id_req.'&erreur=1');
    	}
    }
    else
	{
		header('Location: index.php?erreur=1');
	}	
}
else
{
	header('Location: index.php?erreur=1');
}
?>
</center>