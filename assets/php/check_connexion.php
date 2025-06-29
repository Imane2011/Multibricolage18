<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
// on verifie si l'utilisateur est connécté
if (!isset($_SESSION['id'])) {
    //redirige vers la page de connexion s'il n'est pas connecté
    header("Location: index.php?route=connexion");
    exit();
}


?>