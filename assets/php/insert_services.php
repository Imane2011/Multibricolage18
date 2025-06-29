<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require("assets/php/check_connexion.php");
require("assets/php/db.php");

class Service {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Récupère uniquement les services de l'admin connecté
    public function getServices($admin_id) {
        $sql = "SELECT * FROM page_services WHERE admin_id = :admin_id";
        $req = $this->dbh->prepare($sql);
        $req->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addService($titre, $description, $admin_id, $image) {
        $target = "assets/img/" . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $sql = "INSERT INTO page_services (titre, description, image, admin_id) VALUES (:titre, :description, :image, :admin_id)";
            $req = $this->dbh->prepare($sql);
            $req->bindParam(':titre', $titre, PDO::PARAM_STR);
            $req->bindParam(':description', $description, PDO::PARAM_STR);
            $req->bindParam(':image', $target, PDO::PARAM_STR);
            $req->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);

            if ($req->execute()) {
                header("Location: index.php?route=services_dsh");
                exit();
            } else {
                echo "Erreur lors de l'ajout du service.";
            }
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    }

    public function editService($id, $titre, $description, $image, $admin_id) {
        // Vérifie que le service appartient à l'admin connecté
        $sqlCheck = "SELECT * FROM page_services WHERE id_service = :id AND admin_id = :admin_id";
        $check = $this->dbh->prepare($sqlCheck);
        $check->bindParam(':id', $id, PDO::PARAM_INT);
        $check->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $check->execute();
        $service = $check->fetch(PDO::FETCH_ASSOC);

        if (!$service) {
            echo "Accès non autorisé.";
            exit;
        }

        if (!empty($image)) {
            $target = "assets/img/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $sql = "UPDATE page_services SET titre = :titre, description = :description, image = :image WHERE id_service = :id_service AND admin_id = :admin_id";
        } else {
            $sql = "UPDATE page_services SET titre = :titre, description = :description WHERE id_service = :id_service AND admin_id = :admin_id";
        }

        $req = $this->dbh->prepare($sql);
        $req->bindParam(':titre', $titre, PDO::PARAM_STR);
        $req->bindParam(':description', $description, PDO::PARAM_STR);
        $req->bindParam(':id_service', $id, PDO::PARAM_INT);
        $req->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        if (!empty($image)) {
            $req->bindParam(':image', $target, PDO::PARAM_STR);
        }

        if ($req->execute()) {
            header("location: index.php?route=services_dsh");
            exit();
        } else {
            echo "Erreur lors de la modification du service.";
        }
    }

    public function deleteService($id, $admin_id) {
        $sql = "DELETE FROM page_services WHERE id_service = :id_service AND admin_id = :admin_id";
        $req = $this->dbh->prepare($sql);
        $req->bindParam(':id_service', $id, PDO::PARAM_INT);
        $req->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);

        if ($req->execute()) {
            header("location: index.php?route=services_dsh");
            exit();
        } else {
            echo "Erreur lors de la suppression du service.";
        }
    }
}

// Instanciation
$admin_id = $_SESSION['id'];
$serviceManager = new Service($dbh);
$services = $serviceManager->getServices($admin_id);

// Ajout
if (isset($_POST['submit']) && !isset($_GET['action'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $serviceManager->addService($titre, $description, $admin_id, $image);
}

// Modification
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['submit'])) {
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];
        $serviceManager->editService($id, $titre, $description, $image, $admin_id);
    }
}

// Suppression
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $serviceManager->deleteService($id, $admin_id);
}
?>