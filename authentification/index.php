<?php
session_start();
require 'config.php';

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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../css/index.css">
    <title>Login</title>
</head>
<body>
    
    <form method="POST" class="loginForm">
        <img src="./../img/Logo.png" alt="logo">
        <h2>Connexion Admin</h2>
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Se connecter</button>
    </form>

    <p style="color:red;"><?php echo $message; ?></p>

</body>
</html>