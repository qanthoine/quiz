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
	    	$req = $bdd->prepare('SELECT id_question, question, type ,nb_rep FROM quiz_questions WHERE quiz_id = :id');
	    	$req->bindParam('id',$quiz_id,PDO::PARAM_INT);
	    	$req->execute();
	    	// Fin

	    	//Préparation de la Requete pour le Type Quizz = 1
	    	$req_type_un = $bdd->prepare('SELECT id_reponse, reponse, resultat FROM quiz_reponses WHERE id_question = :question_id AND quiz_id = :id ORDER BY id_reponse');
			$req_type_un->bindParam('id',$quiz_id,PDO::PARAM_INT);
			// Pause de la préparation

	    	//Préparation de la Requete pour le Type Quizz = 2
	    	$req_type_deux = $bdd->prepare('SELECT reponse FROM quiz_reponses WHERE id_question = :question_id AND quiz_id = :id');
			$req_type_deux->bindParam('id',$quiz_id,PDO::PARAM_INT);
			// Pause de la préparation

	    	//Préparation de la Requete pour le Type Quizz = 3
	    	$req_type_trois = $bdd->prepare('SELECT reponse, resultat FROM quiz_reponses WHERE id_question = :question_id AND quiz_id = :id ORDER BY resultat');
			$req_type_trois->bindParam('id',$quiz_id,PDO::PARAM_INT);
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
			                		$nb_question_t = "$nb_question réponse(s)";
			                		$type_question = htmlspecialchars($quiz_q['type']);
			        	    		if($type_question == 1)
			        	    		{
			        	    			$type_write = "QCM";
			        	    		}
			        	    		elseif($type_question == 2)
			        	    		{
			        	    			$type_write = "Nombre à saisir";
			        	    		}
			        	    		elseif($type_question == 3)
			        	    		{
			        	    			$type_write = "Elements à ordonner";
			        	    		}
			                		?>
			                		<div id="titre_question">
			        	    			<h3>Question n°<?php echo $question_id;?> - <?php echo $type_write;?> - <?php echo $nb_question_t;?></h3>
			        	    		</div>
			        	    		<div id="question_question">    
			        	    			<?php echo $question;?><br>
			        	    		</div>
			                		<?php
									$nb_rep = $quiz_q['nb_rep'];

									// Reprise de la requête [[Requête 3]]
									$req_compte_reponse->bindParam('question_id',$question_id,PDO::PARAM_INT);
									$req_compte_reponse->execute();
									// Fin de la requête [[Requête 3]]

									$nombre_de_reponse = $req_compte_reponse->rowcount();
									$req_compte_reponse->closeCursor();
				            			
				            		if($type_question == 1)
				            		{
				            			$req_type_un->bindParam('question_id',$question_id,PDO::PARAM_INT);
			                			$req_type_un->execute();
				            			while ($quiz_type_un = $req_type_un->fetch()) // Boucle affichage des réponses
				            			{
					            			$i = $question_id;
					                		$reponse_id = htmlspecialchars($quiz_type_un['id_reponse']);
					                		$reponse = htmlspecialchars($quiz_type_un['reponse']);
					                		$resultat = htmlspecialchars($quiz_type_un['resultat']);
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
						                $req_type_un->closeCursor();
					                }
					                elseif($type_question == 2)
					                {
				            			$req_type_deux->bindParam('question_id',$question_id,PDO::PARAM_INT);
			                			$req_type_deux->execute();
				            			while ($quiz_type_deux = $req_type_deux->fetch()) // Boucle affichage des réponses
				            			{
				            				$reponse = htmlspecialchars($quiz_type_deux['reponse']); 
					                		?>
						                	<div id="reponse_question">
						                		<img src="img/ok.jpg" alt="ok.jpg" width="15"/>         			
						                		<?php
						                			echo "Le résultat est : $reponse";
						                		?>
						              	  </div>
						            	  <?php
						            	}
						            	$req_type_deux->closeCursor();
					                }
					                elseif($type_question == 3)
					                {
				            			$req_type_trois->bindParam('question_id',$question_id,PDO::PARAM_INT);
			                			$req_type_trois->execute();
				            			while ($quiz_type_trois = $req_type_trois->fetch()) // Boucle affichage des réponses
				            			{
				            				$resultat = htmlspecialchars($quiz_type_trois['resultat']); 
				            				$reponse = htmlspecialchars($quiz_type_trois['reponse']);  
					                		?>
						                	<div id="reponse_question">        			
						                		<?php
						                			echo "$resultat } $reponse";
						                		?>
						                	</div>
						                	<?php
						                }
						                $req_type_trois->closeCursor();
					                }
			            			?>

				                	<div id ="vosreponses">
				                		<?php
				                		if($nb_rep == 1)
				                		{
				                			?><h3>Votre réponse :</h3><?php
				                			if($type_question == 1)
				                			{
				                				echo "Vous avez coché la réponse :";
				                			}
				                			elseif($type_question == 2)
				                			{
				                				echo "Vous avez inscrit la réponse :";
				                			}	
				                		}
				                		else
				                		{
				                			?><h3>Vos réponses :</h3><?php
				                			if($type_question == 1)
				                			{
				                				echo "Vous avez coché les réponses :";
				                			}
				                			elseif($type_question == 3)
				                			{
				                				echo "Vous avez ordonné les réponses dans l'ordre :";
				                			}

				                		}	
				                		?>
				                	</div>

				                </div>	
				                <?php
				            }
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
/*else
{
	header('Location: index.php?erreur=2');
}*/