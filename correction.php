<?php
include('bdd.php');
session_start();
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
    	?>
    	<!DOCTYPE html>
    	<html>
        	<head>
            	<meta charset="utf-8" />
            	<title>Correction</title>
        	</head>

        	<body>
        		<center>
        			<h1>Correction du Quiz : <?php echo $nom_quiz;?></h1>
        			<h2>Votre Score : <?php echo $_SESSION['points'];?>%</h2>
        		</center>
    			<p>
            		<?php
            		while ($quiz_q = $req->fetch()) 
            		{
                		$question_id = htmlspecialchars($quiz_q['id_question']);
                		$question = htmlspecialchars($quiz_q['question']);
                		?>
        	    		<h2>Question n°<?php echo $question_id;?></h2>
        	    		<?php echo $question;?><br>
                		<?php
                		$req_s->bindParam('question_id',$question_id,PDO::PARAM_INT);
                		$req_s->bindParam('id',$quiz_id,PDO::PARAM_INT);
                		$req_s->execute();
            			while ($quiz_r = $req_s->fetch()) 
            			{
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
                			if($_SESSION['question'][$question_id] == $reponse_id)
                			{
                				$text = "(Votre choix)";
                			}
                			else
                			{
                				$text = "";
                			}
                			?>
                			<img src="img/<?php echo $logo;?>" alt="<?php echo $logo;?>" width="15"/>
                			<?php
                			echo $reponse." ".$text;
                			?>
                			<br>
                			<?php	
            			}
            			$req_s->closeCursor();
            		}
            		$req->closeCursor();
            		?>
    			</p>
        	</body>
    	</html>
    	<?php
	}
	else
	{
		header('Location: index.php');
	}
}
else
{
	header('Location: index.php');
}