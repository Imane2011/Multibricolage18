<?php
ini_set('display_errors', 1);
error_reporting(E_ALL); 
require("assets/php/check_connexion.php");
require("assets/php/db.php");
// Récupération des services

class realisation {
    private $dbh;

    public function __construct($dbh){
        $this->dbh = $dbh;
    }

    public function recupRealisations($admin_id){
        $sql = "SELECT * FROM page_realisations WHERE admin_id = :admin_id";
        $req = $this->dbh->prepare($sql);
        $req->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterRealisation($admin_id, $image){
        $target = "assets/img/" . basename($image);  
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $sql = "INSERT INTO page_realisations (image, admin_id) VALUES (:image, :admin_id)";
            $req = $this->dbh->prepare($sql);
            $req->bindParam(":image", $target, PDO::PARAM_STR);
            $req->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);

            if($req->execute()){
                header("location: index.php?route=realisations_dsh");
                exit();
            } else {
                echo "Erreur lors de l'ajout de la realisation.";
            }
        } else {
            echo "Erreur lors de déplacement de la realisation.";
        }
    }

    public function modifierRealisation($id, $image, $admin_id){
        // Vérifie que la réalisation appartient à l'admin
        $sql = "SELECT * FROM page_realisations WHERE id_realisation = :id AND admin_id = :admin_id";
        $req = $this->dbh->prepare($sql);
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $req->execute();
        $realisation = $req->fetch(PDO::FETCH_ASSOC);

        if (!$realisation) {
            echo "Accès non autorisé.";
            exit;
        }

        if (!empty($image)) {
            $target = "assets/img/" . basename($image);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target);
    
            $sql = "UPDATE page_realisations SET image = :image WHERE id_realisation = :id_realisation AND admin_id = :admin_id";
            $req = $this->dbh->prepare($sql);
            $req->bindParam(":image", $target, PDO::PARAM_STR);
            $req->bindParam(":id_realisation", $id, PDO::PARAM_INT);
            $req->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);

            if($req->execute()){
                header("location: index.php?route=realisations_dsh");
                exit();
            } else {
                echo "Erreur lors de la modification de la realisation.";
            }
        }
    }

    public function supprimerRealisation($id, $admin_id){
        // Vérifie que la réalisation appartient à l'admin
        $sql = "DELETE FROM page_realisations WHERE id_realisation = :id AND admin_id = :admin_id";
        $req = $this->dbh->prepare($sql);
        $req->bindParam(":id", $id, PDO::PARAM_INT);
        $req->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);

        if($req->execute()){
            header("location: index.php?route=realisations_dsh");
            exit();
        } else {
            echo "Erreur lors de la suppression de la realisation.";
        }
    }
}

// Utilisation
$admin_id = $_SESSION['id'];
$gererRealisation = new realisation($dbh);
$realisations = $gererRealisation->recupRealisations($admin_id);

// Ajout d'une réalisation
if (isset($_POST['submit']) && !isset($_GET['action'])) {
    $image = $_FILES['image']['name'];
    $gererRealisation->ajouterRealisation($admin_id, $image);
}

// Modification d'une réalisation
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['submit'])) {
        $image = $_FILES['image']['name'];
        $gererRealisation->modifierRealisation($id, $image, $admin_id);
    }
}

// Suppression d'une réalisation
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $gererRealisation->supprimerRealisation($id, $admin_id);
}
?>