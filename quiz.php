<?php
include('includes/bdd.php');
//Recupération du nom du Quiz et verification si le Quiz éxiste
if(isset($_GET['quiz']) AND $_GET['quiz'] > 0)
{
    $req_n = $bdd->prepare('SELECT * FROM quiz WHERE quiz_id = :quiz');
    $req_n->bindParam('quiz',$_GET['quiz'], PDO::PARAM_INT);
    $req_n->execute();
    $quiz_n = $req_n->fetch();
    if($quiz_n)
    {
        $id_quiz = htmlspecialchars($_GET['quiz']);
        $nom_quiz = htmlspecialchars($quiz_n['nom_quiz']);
        $req_n->closeCursor();
        //Recupération des Questions
        $req = $bdd->prepare('SELECT id_question, question FROM quiz_questions WHERE quiz_id = :id_quiz');
        $req->bindParam(':id_quiz',$id_quiz,PDO::PARAM_INT);
        $req->execute();
        //Préparation de la Recupération des Réponses
        $req_s = $bdd->prepare('SELECT id_reponse, reponse FROM quiz_reponses WHERE id_question = :question_id AND quiz_id = :id_quiz ORDER BY id_reponse');
        $req_s->bindParam(':id_quiz',$id_quiz,PDO::PARAM_INT);
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8" />
                <link rel="stylesheet" type="text/css" href="styles/style.css"/>
                <title><?php echo $nom_quiz;?></title>
            </head>

            <body>
            	<center>
            		<h1><?php echo $nom_quiz;?></h1>
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
                                echo "Il faut cocher au moins une case par question !";
                            }
                            ?>
                        </div>
                        <?php
                    }  
                    ?> 
            		<form action="includes/quiz_post.php" method="post">
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
                            		$req_s->execute();
                        			while ($quiz_r = $req_s->fetch()) 
                        			{
                            			$reponse_id = htmlspecialchars($quiz_r['id_reponse']);
                            			$reponse = htmlspecialchars($quiz_r['reponse']);

                            			?>
                                        <div id="reponse_question">
                            		        <input type="radio" name="input[<?php echo $question_id;?>]" value="<?php echo $reponse_id;?>" id="<?php echo $reponse_id;?>" /> <label for="<?php echo $reponse_id;?>"><?php echo $reponse;?></label><br>
                                        </div>    
                            			<?php
                        			}
                        			$req_s->closeCursor();
                                    ?>
                                </div>
                                <?php
                    		}
                    		$req->closeCursor();
                    		?>
                            <input type="hidden" name="id_quiz" value="<?php echo $id_quiz;?>" />
            	    		<br><input type="submit" value="Valider" />
            			</p>
            		</form>            
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
