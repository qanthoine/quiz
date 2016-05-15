<?php
			$id_reponse = 1;

			// Reprise de la requête [[Requête 5]]
			$req_recup_reponse->bindParam('id_q',$id_quest,PDO::PARAM_INT);
			$req_recup_reponse->bindParam('id_r',$id_reponse,PDO::PARAM_INT);
			$req_recup_reponse->execute();
			$recup_reponse_req = $req_recup_reponse->fetch();
			$req_recup_reponse->closeCursor();
			// Fin de la requête [[Requête 5]]

			$points = $_SESSION['points'][$id_quiz];
			if($_POST['input'][$i][$type] == $recup_reponse_req['reponse'])
			{	
				$_SESSION['points'][$id_quiz] = $points + $points_r;
				$_SESSION['question'][$id_quest][$i][$i_incre] = $id_rep;
			}
			else
			{
				$_SESSION['points'][$id_quiz] = $points + 0;
				$_SESSION['question'][$id_quest][$i][$i_incre] = $id_rep;				
			}