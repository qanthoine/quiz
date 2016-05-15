<?php
include('includes/bdd.php');
session_start();
//Recupération du nom du Quiz et verification si le Quiz éxiste
if(isset($_GET['quiz']) AND $_GET['quiz'] > 0)
{
    $id_quiz = htmlspecialchars($_GET['quiz']);
    if(!isset($_SESSION['quiz_termine'][$id_quiz]))
    {
        $req_n = $bdd->prepare('SELECT * FROM quiz WHERE quiz_id = :quiz');
        $req_n->bindParam('quiz',$id_quiz, PDO::PARAM_INT);
        $req_n->execute();
        $quiz_n = $req_n->fetch();
        if($quiz_n)
        {
            $nom_quiz = htmlspecialchars($quiz_n['nom_quiz']);
            $req_n->closeCursor();
            //Recupération des Questions
            $req = $bdd->prepare('SELECT id_question, question, type, nb_rep FROM quiz_questions WHERE quiz_id = :id_quiz');
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
                                elseif($_GET['erreur'] == 3) 
                                {
                                    echo "Vous n'avez pas coché le nombre de cases requises !";
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
                                        $nb_rep = htmlspecialchars($quiz_q['nb_rep']);
                                        $type_quizz = htmlspecialchars($quiz_q['type']);
                                		?>
                                        <div id="titre_question">
                        	    		    <h2>Question n°<?php echo $question_id;?></h2>
                                            <h3>(<?php echo $nb_rep;?> reponses possibles)</h3>
                                        </div>
                                        <div id="question_question">    
                        	    		    <?php echo $question;?><br>
                                        </div>    
                                		<?php
                                        $req_s->bindParam('question_id',$question_id,PDO::PARAM_INT);
                                		$req_s->execute();
                                        $i = 1;
                            			while ($quiz_r = $req_s->fetch()) 
                            			{
                                			$reponse_id = htmlspecialchars($quiz_r['id_reponse']);
                                			$reponse = htmlspecialchars($quiz_r['reponse']);

                                			?>
                                            <div id="reponse_question">
                                                <?php
                                                if($type_quizz == 1)
                                                {
                                                    if($nb_rep == 1)
                                                    {
                                                        ?>
                                    		          <input type="radio" name="input[<?php echo $question_id;?>][<?php echo $type_quizz;?>]" value="<?php echo $reponse_id;?>" id="<?php echo $reponse_id;?>" /> <label for="<?php echo $reponse_id;?>"><?php echo $reponse;?></label><br>
                                                      <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                      <input type="checkbox" name="input[<?php echo $question_id;?>][<?php echo $type_quizz;?>][<?php echo $i;?>]" value="<?php echo $reponse_id;?>" id="<?php echo $reponse_id;?>" /> <label for="<?php echo $reponse_id;?>"><?php echo $reponse;?></label><br>
                                                      <?php
                                                      $i++;
                                                    }
                                                }
                                                elseif($type_quizz == 2)  
                                                {
                                                    ?>
                                                        <input type="text" name="input[<?php echo $question_id;?>][<?php echo $type_quizz;?>]" required />
                                                    <?php
                                                }
                                                elseif($type_quizz == 3)
                                                {
                                                    ?>
                                                        <input type="text" name="input[<?php echo $question_id;?>][<?php echo $type_quizz;?>][<?php echo $reponse_id;?>]" required />
                                                    <?php
                                                    echo $reponse;
                                                } 
                                                ?>
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
        header('Location: index.php?erreur=2');
    }
        
}
else
{
    header('Location: index.php?erreur=1');
}
