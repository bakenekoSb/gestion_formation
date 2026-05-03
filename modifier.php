<?php
require './authentification/config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "UPDATE formation
            SET titre_formation = ?, date_debut = ?, capacite = ?
            WHERE id_formation = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_POST['titre'],
        $_POST['date_debut'],
        $_POST['capacite'],
        $_POST['id']
    ]);

    header("Location: liste_formation.php");
    exit;
} else {
    echo "Aucune donnée reçue";
}
?>