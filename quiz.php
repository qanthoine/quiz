<?php
include('bdd.php');
//Recupération du nom du Quiz et verification si le Quiz éxiste
$req_n = $bdd->query('SELECT * FROM quiz WHERE quiz_id = '.$_GET['quiz'].'');
$quiz_n = $req_n->fetch();
if(isset($_GET['quiz']) AND $_GET['quiz'] > 0 AND $quiz_n)
{
    $id_quiz = htmlspecialchars($_GET['quiz']);

    $nom_quiz = htmlspecialchars($quiz_n['nom_quiz']);
    $req_n->closeCursor();

    //Recupération des Questions
    $req = $bdd->query('SELECT id_question, question FROM quiz_questions WHERE quiz_id = '.$id_quiz.'');

    //Préparation de la Recupération des Réponses
    $req_s = $bdd->prepare('SELECT id_reponse, reponse FROM quiz_reponses WHERE id_question = :question_id AND quiz = '.$id_quiz.' ORDER BY id_reponse');
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <title><?php echo $nom_quiz;?></title>
        </head>

        <body>
        	<center>
        		<h1><?php echo $nom_quiz;?></h1>
        	</center>
    		<form action="quiz_post.php" method="post">
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
                		$req_s->execute(array('question_id' => $question_id));
            			while ($quiz_r = $req_s->fetch()) 
            			{
                			$reponse_id = htmlspecialchars($quiz_r['id_reponse']);
                			$reponse = htmlspecialchars($quiz_r['reponse']);

                			?>
                			<input type="radio" name="<?php echo $question_id;?>" value="<?php echo $reponse_id;?>" id="<?php echo $reponse_id;?>" /> <label for="<?php echo $reponse_id;?>"><?php echo $reponse;?></label><br>
                			<?php
            			}
            			$req_s->closeCursor();
            		}
            		$req->closeCursor();
            		?>
                    <input type="hidden" name="id_quiz" value="<?php echo $id_quiz;?>" />
    	    		<br><input type="submit" value="Valider" />
    			</p>
    		</form>
        </body>
    </html>
    <?php
}
else
{
	header('Location: index.php');
}