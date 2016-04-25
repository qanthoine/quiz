<?php
include('includes/bdd.php');
session_start();
if(isset($_SESSION['fin']) AND $_SESSION['fin'] = 1)
{
	unset($_SESSION['fin']);
	if(isset($_GET['quiz']) AND $_GET['quiz'] > 0)
	{
		$quiz_id = htmlspecialchars($_GET['quiz']);
		//Recupération du nom du Quiz et verification si le Quiz éxiste
		$req_n = $bdd->prepare('SELECT * FROM quiz WHERE quiz_id = :id');
		$req_n->bindParam('id',$quiz_id,PDO::PARAM_INT);
		$req_n->execute();
		$quiz_n = $req_n->fetch();
	    $req_n->closeCursor();
		if($quiz_n)
		{
	    	$nom_quiz = htmlspecialchars($quiz_n['nom_quiz']);
	    	//Recupération des Questions
	    	$req = $bdd->prepare('SELECT id_question, question FROM quiz_questions WHERE quiz_id = :id');
	    	$req->bindParam('id',$quiz_id,PDO::PARAM_INT);
	    	$req->execute();
	    	//Préparation de la Recupération des Réponses
	    	$req_s = $bdd->prepare('SELECT id_reponse, reponse, resultat FROM quiz_reponses WHERE id_question = :question_id AND quiz_id = :id ORDER BY id_reponse');
	    	$score = htmlspecialchars($_SESSION['points']);
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
		            		while ($quiz_q = $req->fetch()) 
		            		{
		            			?>
		            			<div class="quiz_question">
		            				<?php
			                		$question_id = htmlspecialchars($quiz_q['id_question']);
			                		$question = htmlspecialchars($quiz_q['question']);
			                		?>
			                		<div id="titre_question">
			        	    			<h2>Question n°<?php echo $question_id;?></h2>
			        	    		</div>
			        	    		<div id="question_question">    
			        	    			<?php echo $question;?><br>
			        	    		</div>
			                		<?php
			                		$req_s->bindParam('question_id',$question_id,PDO::PARAM_INT);
			                		$req_s->bindParam('id',$quiz_id,PDO::PARAM_INT);
			                		$req_s->execute();
			            			while ($quiz_r = $req_s->fetch()) 
			            			{
			                			$reponse_id = htmlspecialchars($quiz_r['id_reponse']);
			                			$reponse = htmlspecialchars($quiz_r['reponse']);
			                			$resultat = htmlspecialchars($quiz_r['resultat']);
			                			$session_rep = htmlspecialchars($_SESSION['question'][$question_id]);
			                			if($resultat == 1)
			                			{
			                				$logo = 'ok.jpg';             				
			                			}
			                			else
			                			{
			                				$logo = 'croix.jpg';
			                			}
			                			if($session_rep == $reponse_id)
			                			{
			                				$text = "(Votre choix)";
			                			}
			                			else
			                			{
			                				$text = "";
			                			}
			                			?>
			                			<div id="reponse_question">
			                				<img src="img/<?php echo $logo;?>" alt="<?php echo $logo;?>" width="15"/>         			
			                				<?php
			                				echo $reponse." ".$text;
			                				?>
			                			</div>
			                			<?php
			            			}
			            			$req_s->closeCursor();
			            			?>
		            			</div>
		            			<?php
		            		}
		            		?>
		            		<br>
		                	<a href="index.php"> <input type="button" value="Retour à la liste des Quiz">
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