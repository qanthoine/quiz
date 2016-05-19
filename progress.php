<?php
include('includes/bdd.php');
if(isset($_GET['quiz']) AND $_GET['quiz'] > 0)
{
	$id_quiz = htmlspecialchars($_GET['quiz']);
	$req_v = $bdd->prepare('SELECT * FROM quiz WHERE quiz_id = :quiz');
    $req_v->bindParam('quiz',$id_quiz, PDO::PARAM_INT);
    $req_v->execute();
    $quiz_v = $req_v->fetch();
    $req_v->closeCursor();
    if($quiz_v)
    {
    	$ip = $_SERVER['REMOTE_ADDR'];
    	$req_info = $bdd->prepare('SELECT id, time_now, score FROM quiz_historique_info WHERE quiz_id = :quiz_id AND ip = :ip ORDER BY time_now DESC');
    	$req_info->bindParam(':quiz_id',$id_quiz,PDO::PARAM_INT);
    	$req_info->bindParam(':ip',$ip,PDO::PARAM_STR);
    	$req_info->execute();
    	$i = 1;
    	?>
    	<!DOCTYPE html>
    	<html>
    		<head>
                    <meta charset="utf-8" />
                    <link rel="stylesheet" type="text/css" href="styles/style.css"/>
                    <title>Votre Progression</title>    			
    		</head>
    	<center>
    	<table>
    	<h1>Votre Progression</h1>
        <?php
        if(isset($_GET['erreur']))
        {
        	?>
	        <div class="message">
	            <?php
	            if($_GET['erreur'] == 1)
	            {
	                 echo "Vous n'avez pas accès !";
	            }
	            ?>
	        </div>
	        <?php
	    }
	    ?>
    		<tr>
    			<th>N°</th>
    			<th>Lien</th>
    			<th>Score</th>
    			<th>Date</th>
    		</tr>
    		<?php
    		while($quiz_info = $req_info->fetch())
    		{
    			$id = htmlspecialchars($quiz_info['id']);
    			$time_now = date('d/m/Y à H:i', htmlspecialchars($quiz_info['time_now']));
    			$score = htmlspecialchars($quiz_info['score']);
    			?>
    			<tr>
    				<td><?php echo $i;?></td>
    				<td><a href="historique.php?id=<?php echo $id;?>">Votre Quiz</a></td>
    				<td><?php echo $score;?> %</td>
    				<td><?php echo $time_now;?></td>
    			</tr>
    			<?php
    			$i++;	
    		}
    		$req_info->closeCursor();
    		?>
    	</table>
    	</center>
    	<?php	
    }
    else
    {
    	header('Location: quiz.php?quiz=$id_quiz&erreur=1');
    }	
}
else
{
	header('Location: index.php?erreur=1');
}