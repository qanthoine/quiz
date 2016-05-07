<?php
include('includes/bdd.php');
session_start();
if(isset($_SESSION['fin']) AND $_SESSION['fin'] = 1)
{
	if(isset($_GET['quiz']) AND $_GET['quiz'] > 0)
	{
		$quiz_id = htmlspecialchars($_GET['quiz']);

		//Recupération du nom du Quiz et verification si le Quiz éxiste
		$req_n = $bdd->prepare('SELECT * FROM quiz WHERE quiz_id = :id');
		$req_n->bindParam('id',$quiz_id,PDO::PARAM_INT);
		$req_n->execute();
		// Fin 

		$quiz_n = $req_n->fetch();
	    $req_n->closeCursor();
		if($quiz_n)
		{
			// Liste des variables
	    	$nom_quiz = htmlspecialchars($quiz_n['nom_quiz']);
	    	$score = htmlspecialchars($_SESSION['points'][$quiz_id]);
	    	// Fin de Liste des variables

	    	//Recupération des Questions
	    	$req = $bdd->prepare('SELECT id_question, question, nb_rep FROM quiz_questions WHERE quiz_id = :id');
	    	$req->bindParam('id',$quiz_id,PDO::PARAM_INT);
	    	$req->execute();
	    	// Fin

	    	//Préparation de la Recupération des Réponses [[Requete 2]]
	    	$req_s = $bdd->prepare('SELECT id_reponse, reponse, resultat FROM quiz_reponses WHERE id_question = :question_id AND quiz_id = :id ORDER BY id_reponse');
			$req_s->bindParam('id',$quiz_id,PDO::PARAM_INT);
			// Pause de la préparation

	    	//Préparation de la Recupération du nombre de réponses [[Requete 3]]
	    	$req_compte_reponse = $bdd->prepare('SELECT * FROM quiz_reponses WHERE id_question = :question_id AND quiz_id = :id');
			$req_compte_reponse->bindParam('id',$quiz_id,PDO::PARAM_INT);
			// Pause de la préparation
	    	
	    	// Traitement score 
	    	if($score > 100)
	    	{
	    		$score = 100;
	    	}
	    	// Fin du traitement
	    		
	    	?>
	    	<!DOCTYPE html>
	    	<html>
	        	<head>
	            	<meta charset="utf-8" />
	            	<title>Correction</title>
        			<link rel="stylesheet" type="text/css" href="styles/style.css"/>
	        	</head>

	        	<body>
	        		<center>
	        			<h1>Correction du Quiz : <?php echo $nom_quiz;?></h1>
	        			<h2>Votre Score : <?php echo $score?>%</h2>
		    			<p>
		            		<?php
		            		while ($quiz_q = $req->fetch()) // Boucle affichage des questions
		            		{
		            			$i_incre = 1;
		            			?>
		            			<div class="quiz_question">
		            				<?php
			                		$question_id = htmlspecialchars($quiz_q['id_question']);
			                		$question = htmlspecialchars($quiz_q['question']);
			                		$nb_question = htmlspecialchars($quiz_q['nb_rep']);
			                		?>
			                		<div id="titre_question">
			        	    			<h2>Question n°<?php echo $question_id;?></h2>
			        	    			<h4><?php echo $nb_question;?> réponse(s)</h4>
			        	    		</div>
			        	    		<div id="question_question">    
			        	    			<?php echo $question;?><br>
			        	    		</div>
			                		<?php

			                		// Reprise de la requête [[Requête 2]]
			                		$req_s->bindParam('question_id',$question_id,PDO::PARAM_INT);
			                		$req_s->execute();
			                		// Fin de la requête [[Requête 2]]

									$nb_rep = $quiz_q['nb_rep'];

									// Reprise de la requête [[Requête 3]]
									$req_compte_reponse->bindParam('question_id',$question_id,PDO::PARAM_INT);
									$req_compte_reponse->execute();
									// Fin de la requête [[Requête 3]]

									$nombre_de_reponse = $req_compte_reponse->rowcount();
									$req_compte_reponse->closeCursor();

									while ($quiz_r = $req_s->fetch()) // Boucle affichage des réponses
				            		{
				            			$i = $question_id;
				                		$reponse_id = htmlspecialchars($quiz_r['id_reponse']);
				                		$reponse = htmlspecialchars($quiz_r['reponse']);
				                		$resultat = htmlspecialchars($quiz_r['resultat']);
				                		if($resultat == 1)
				                		{
				                			$logo = 'ok.jpg';             				
				                		}
				                		else
				                		{
				                			$logo = 'croix.jpg';
				                		} 
				                		?>
					                	<div id="reponse_question">
					                		<img src="img/<?php echo $logo;?>" alt="<?php echo $logo;?>" width="15"/>         			
					                		<?php
					                		echo $reponse;
					                		?>
					                	</div>
					                	<?php
					                }
				            		$req_s->closeCursor();
			            			?>
				                	<div id ="vosreponses">
				                		<?php
				                		if($nb_rep == 1)
				                		{
				                			?><h3>Votre reponse :</h3><?php
				                			$session_rep = htmlspecialchars($_SESSION['question'][$question_id][$i][$i_incre]);
				                			echo 'Vous avez choisi la réponse : '.$session_rep.'';
				                		}
				                		else
				                		{
				                			?><h3>Vos reponses :</h3><?php
				                			for($_SESSION['question'][$question_id][$i][$i_incre];$i_incre<=$nombre_de_reponse;$i_incre++)
				                			{
				                				if(isset($_SESSION['question'][$question_id][$i][$i_incre]))
				                				{
				                					$session_rep = $_SESSION['question'][$question_id][$i][$i_incre];
				                					echo 'Vous avez choisi la réponse : '.$session_rep.'<br>';
				                				}
				                			}
				                		}	
				                		?>
				                	</div>
				                </div>	
				                <?php
				            }
				            unset($_SESSION['question']);
				            unset($_SESSION['fin']);
		            		?>
		            		<br>
		                	<a href="index.php"><input type="button" value="Retour à la liste des Quiz"></a>
		                	<?php
		            		$req->closeCursor();
		            		?>
		    			</p>
	        		</center>
	        	</body>
	    	</html>
	    	<?php
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
}
else
{
	header('Location: index.php?erreur=2');
}