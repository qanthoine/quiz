<?php
include('bdd.php');
session_start();
$_SESSION = array();
session_destroy();
$req = $bdd->query('SELECT * FROM quiz ORDER BY quiz_id');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quiz</title>
    </head>

    <body>
    	<center>
    		<h1>Mes Quiz</h1>
    	</center>
        <?php
        while ($quiz = $req->fetch()) 
        {
            $quiz_id = htmlspecialchars($quiz['quiz_id']);
            $nom_quiz = htmlspecialchars($quiz['nom_quiz']);
            $description = htmlspecialchars($quiz['description']);
            $nb_questions = htmlspecialchars($quiz['nb_questions']);
            ?>
    	    <h2><?php echo $nom_quiz;?> (<?php echo $nb_questions;?> questions)</h2>
    	    <?php echo $description;?><br><br>
    	    <a href="quiz.php?quiz=<?php echo $quiz_id;?>">Lancer le Quiz !</a>
            <?php
        }
        $req->closeCursor();
        ?>
    </body>
</html>