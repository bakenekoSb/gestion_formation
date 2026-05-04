<?php
require './authentification/config.php';

if(isset($_GET['id'])) {

    $stmt = $pdo->prepare("DELETE FROM formation WHERE id_formation = ?");
    $stmt->execute([$_GET['id']]);

    header("Location: liste_formation.php");
    exit;
}