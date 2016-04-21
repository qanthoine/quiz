<?php
// Adresse du serveur MYSQL :
$adresse = '127.0.0.1';
//////////////////////////////////
// Nom de la DataBase :
$db = 'site';
//////////////////////////////////
// Nom d'Utilisateur :
$utilisateur = 'root';
//////////////////////////////////
// Mot de Passe de l'Utilisateur :
$pass = '';
//////////////////////////////////
// Variable $bdd :
$bdd = new PDO('mysql:host='.$adresse.';dbname='.$db.';charset=utf8', $utilisateur, $pass);
?>