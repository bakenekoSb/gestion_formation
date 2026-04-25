<?php
session_start();
require './../authentification/config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM administrateur WHERE nom_admin= :nom_admin";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nom_admin', $username);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user && ($password == $user['mdp'])) {
        $_SESSION['admin'] = $user['nom_admin'];
        $_SESSION['notif'] = [
                    'message' => "Connexion réussie, {$user['nom_admin']}",
                    'type' => 'success'
                ];
        header("Location: ./../dashboard.php");
        
        exit;
    } else {
        $_SESSION['notif'] = [
                    'message' => "Informations incompatibles, vérifiez votre mot de passe ou votre nom",
                    'type' => 'error'
                ];
        //$message = "Nom d'utilisateur ou mot de passe incorrect";
    }
    
}
?>