<?php
session_start();
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
            <?php
            if(isset($_GET['erreur']))
            {
                ?>
                <div class="message">
                    <?php
                    if($_GET['erreur'] == 1)
                    {
                        echo "Une erreur est survenue";
                    }
                    elseif($_GET['erreur'] == 2) 
                    {
                        echo "Vous n'avez pas accès à cette page pour le moment";
                    }
                    ?>
                </div>
                <?php
            }  
            while ($quiz = $req->fetch()) 
            {
                ?>
                <div class="pres_quiz">
                    <?php 
                    $quiz_id = htmlspecialchars($quiz['quiz_id']);
                    $nom_quiz = htmlspecialchars($quiz['nom_quiz']);
                    $description = htmlspecialchars($quiz['description']);
                    $nb_questions = htmlspecialchars($quiz['nb_questions']);

                    // Traitement score 
                    if(isset($_SESSION['points'][$quiz_id]))
                    {
                        $score = $_SESSION['points'][$quiz_id];
                        if($score > 100)
                        {
                            $score = 100;
                        }
                    }
                    // Fin du traitement

                    ?>
                    <div id="titre_quiz">
            	       <h2><?php echo $nom_quiz;?> (<?php echo $nb_questions;?> questions)</h2>
                    </div>
                    <div id="description_quiz">
            	       <?php echo $description;?><br><br>
                    </div>
                    <?php
                    if(isset($_SESSION['quiz_termine'][$quiz_id]))
                    {  
                        ?>
                        <div id="boutton_quiz">
                           <img src="img/croix.jpg" alt="croix.jpg" width="15"/> 
                           Quiz terminé ! Score : <?php echo $score;?>% 
                           <img src="img/croix.jpg" alt="croix.jpg" width="15"/>
                        </div>
                        <?php                        
                    }
                    else
                    {
                        ?> 
                        <div id="boutton_quiz">
                	       <img src="img/ok.jpg" alt="ok.jpg" width="15"/> 
                           <a href="quiz.php?quiz=<?php echo $quiz_id;?>">Lancer le Quiz !</a> 
                           <img src="img/ok.jpg" alt="ok.jpg" width="15"/>
                        </div>
                        <?php
                    }
                    ?>
                </div> 
                <?php
            }
            $req->closeCursor();
            ?>       
        </center>
    </body>
</html>