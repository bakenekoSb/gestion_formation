<?php

require_once('./../authentification/config.php');
session_start();

try{

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['btn_ajout'])){
    //on prend les éléments saisits dans le formulaire
    $nom_formation = trim($_POST['nom_formation']);
    $date = trim($_POST['date']);
    $nb_participant = $_POST['nb_participant'];

    //insertion des données dans la table formations
    $query = "INSERT INTO formation(titre_formation,date_debut,capacite)
            VALUES (:nom_formation,:date_formation,:nb_participant)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
    'nom_formation'=>$nom_formation,
    'date_formation'=>$date,
    'nb_participant'=>$nb_participant
    ]);

    echo "<script>
        alert('Formation ajoutée avec succès');
        </script>";
    header("Location: ./../dashboard.php");
    exit();
}
}catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    header("Location: ./../dashboard.php");
    exit();
}