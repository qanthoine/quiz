<?php
			// Reprise de la requête [[Requête 1]]
			$req_r->bindParam('id_q',$id_quest,PDO::PARAM_INT);
			$req_r->execute();
			$sql_nb_rep = $req_r->fetch();
			$nb_rep = $sql_nb_rep['nb_rep'];

			// Fin de la requête [[Requête 1]]

			if($nb_rep == 1) // Si le nombre de reponse possible est égale à 1
			{
				$points = $_SESSION['points'];
				$type = 1;
				$i_incre = 1;
				$id_rep = $_POST['input'][$id_quest][$type];

				// Reprise de la requête [[Requête 2]]
				$req_resultat->bindParam('id_q',$id_quest,PDO::PARAM_INT);
				$req_resultat->bindParam('id_r',$id_rep,PDO::PARAM_INT);
				$req_resultat->execute();
				$resultat_req = $req_resultat->fetch();
				// Fin de la requête [[Requête 2]]

						
				if($resultat_req['resultat'] == 1)
				{
					$_SESSION['points'] = $points + $points_r;
					$_SESSION['question'][$id_quest][$type][$i_incre] = $id_rep;
				}
				else
				{
					$_SESSION['points'] = $points + 0;
					$_SESSION['question'][$id_quest][$type][$i_incre] = $id_rep;
				}
				$req_write_historique->bindParam('reponse_id',$id_rep,PDO::PARAM_INT);
				$req_write_historique->execute();
			}
			else // Sinon ..
			{
				$i_incre = 1;
				$type = 1;
				

				// Reprise de la requête [[Requête 3]]
				$req_nb_reponse->bindParam('id_q',$id_quest,PDO::PARAM_INT);
				$req_nb_reponse->execute();
				$nb_reponse = $req_nb_reponse->rowcount();
				// Fin de la requête [[Requête 3]]
				if(count($_POST['input'][$i][$type]) == $nb_rep)
				{
					for($_POST['input'][$i][$type][$i_incre];$i_incre <= $nb_reponse;$i_incre++)
					{
						$points = $_SESSION['points'];
						if(!empty($_POST['input'][$i][$type][$i_incre]))
						{
							$id_rep = $_POST['input'][$i][$type][$i_incre];

							// Reprise de la requête [[Requête 2]]
							$req_resultat->bindParam('id_q',$id_quest,PDO::PARAM_INT);
							$req_resultat->bindParam('id_r',$id_rep,PDO::PARAM_INT);
							$req_resultat->execute();
							$resultat_req = $req_resultat->fetch();
							// Fin de la requête [[Requête 2]]
								
							if($resultat_req['resultat'] == 1)
							{
								$_SESSION['points'] = $points + $points_r;
								$_SESSION['question'][$id_quest][$type][$i_incre] = $id_rep;
							}
							else
							{
								$_SESSION['points'] = $points + 0;
								$_SESSION['question'][$id_quest][$type][$i_incre] = $id_rep;
							}
							$req_write_historique->bindParam('reponse_id',$id_rep,PDO::PARAM_INT);
							$req_write_historique->execute();
						}
					}
				}
				else
				{
					$req_delete->execute();
					header('Location: ../quiz.php?quiz='.$id_quiz.'&erreur=4');
					die();					
				}
			}