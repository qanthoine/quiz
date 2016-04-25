<?php
include('includes/bdd.php');
$req = $bdd->query('SELECT * FROM quiz ORDER BY quiz_id');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="styles/style.css"/>
        <title>Quiz</title>
    </head>

    <body>
    	<center>
    		<h1>Mes Quiz</h1>
            <div class="message">
                <?php
                if (isset($_GET['erreur']) AND $_GET['erreur'] == 1)
                {
                    echo "Une erreur est survenue";
                }
                elseif(isset($_GET['erreur']) AND $_GET['erreur'] == 2) 
                {
                    echo "Vous n'avez pas accès à cette page pour le moment";
                }
                ?>
            </div>
            <?php  
            while ($quiz = $req->fetch()) 
            {
                ?>
                <div class="pres_quiz">
                    <?php 
                    $quiz_id = htmlspecialchars($quiz['quiz_id']);
                    $nom_quiz = htmlspecialchars($quiz['nom_quiz']);
                    $description = htmlspecialchars($quiz['description']);
                    $nb_questions = htmlspecialchars($quiz['nb_questions']);
                    ?>
                    <div id="titre_quiz">
            	       <h2><?php echo $nom_quiz;?> (<?php echo $nb_questions;?> questions)</h2>
                    </div>
                    <div id="description_quiz">
            	       <?php echo $description;?><br><br>
                    </div>
                    <div id="boutton_quiz">
            	       <img src="img/ok.jpg" alt="ok.jpg" width="15"/> 
                       <a href="quiz.php?quiz=<?php echo $quiz_id;?>">Lancer le Quiz !</a> 
                       <img src="img/ok.jpg" alt="ok.jpg" width="15"/>
                    </div>
                </div> 
                <?php
            }
            $req->closeCursor();
            ?>       
        </center>
    </body>
</html>