<?php
include('bdd.php');
if($_GET['quiz'] > 0)
{
$req = $bdd->query('SELECT id_question, question FROM quiz_questions WHERE quiz = $_GET['quiz'] ORDER BY id_question');
$req_s = $bdd->prepare('SELECT id_reponse, reponse FROM quiz_reponses WHERE id_question = :question_id AND quiz = "maths" ORDER BY id_reponse');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Les Maths</title>
    </head>

    <body>
    	<center>
    		<h1>Les Maths</h1>
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
	    		<input type="submit" value="Valider" />
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