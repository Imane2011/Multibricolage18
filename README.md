Documentation de déploiement local du site multibricolage18
1. Présentation du projet
Le projet multibricolage18 est un site web développé pour présenter les services et réalisations d’une entreprise de bricolage. 
Il comprend à la fois une interface utilisateur (front-office) et une interface administrateur (back-office).
•	Technologies utilisées :
•	HTML / CSS / JavaScript pour le front-end
•	PHP / MySQL pour le back-end
•	WAMP pour l’environnement local
Base de données : multibricolage
2. Structure du projet
Le projet est organisé dans un seul dossier principal nommé multibricolage18 et contient les sous-dossiers suivants :
•	views/ : Interfaces utilisateur et administrateur
•	assets/css/ : Fichiers CSS
•	assets/css/interface_adminCss/ : Fichiers CSS
•	assets/js/ : Fichiers JavaScript
•	assets/php/ : Scripts PHP
•	assets/php/db.php : Fichier de connexion à la base de données
•	assets/img/ : Images téléchargées (services, réalisations)
3. Configuration de l’environnement local (WAMP)
Étapes à suivre :
1.	1. Copier le dossier du site dans C:\Xampp\htdocs\
2.	2. Démarrer Xampp et appuyer sur start pour apache et MySQL
3.	3. Accéder au site via http://localhost/multibricolage18/
4. Création de la base de données
4.	1. Aller sur http://localhost/phpmyadmin
5.	2. Créer une base de données nommée multibricolage
6.	3. Importer le fichier SQL si disponible
5. Connexion à la base de données
Fichier : db.php

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
try {
    $dsn = "mysql:dbname=multibricolage;host=localhost;port=3306";
    $user = "root";
    $password = "";
    $dbh = new PDO($dsn, $user,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'")
    );
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit; 
}
?>

6. Fonctionnalités du site
•	Front-office :
•	Page d’accueil, services, réalisations, contact, demande de devis
•	Back-office :
•	Inscription, connexion, gestion des services et réalisations
7. Accès au site
Site principal : http://localhost/multibricolage18/
Interface admin : http://localhost/multibricolage18/index.php?route=admin
8. Remarques complémentaires
Les images sont stockées dans assets/img/.
Les scripts PHP gèrent le téléchargement des fichiers et les sessions assurent la sécurité du back-office.
9. Vérifications à faire
•	Apache et MySQL doivent être actifs
•	Le fichier db.php doit être fonctionnel
•	Le fichier .sql doit être correctement importé
