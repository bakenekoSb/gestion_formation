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
        header("Location: dashboard.php");
        
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
    <title>Login</title>
    <style>
    /* Notification globale */
        .notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    min-width: 250px;
                    padding: 15px 20px;
                    border-radius: 8px;
                    color: #fff;
                    font-family: Arial, sans-serif;
                    font-size: 14px;
                    opacity: 0;
                    pointer-events: none;
                    transition: opacity 0.5s, transform 0.5s;
                    z-index: 9999;
        }

        .notification.success { background-color: #4CAF50; }
        .notification.error { background-color: #f44336; }

        .notification.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
    </style>
    <script>
        function showNotification(message, type = 'success', duration = 3000) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type} show`;

            setTimeout(() => {
                notification.className = `notification ${type}`;
            }, duration);
        }
    </script>
</head>
<body>
    <div id="notification" class="notification"></div>
    <?php
        if (isset($_SESSION['notif'])):
            $notif = $_SESSION['notif'];
            unset($_SESSION['notif']); // Supprimer le message pour qu'il ne réapparaisse pas
        ?>
        <script>
            showNotification(<?= json_encode($notif['message']) ?>, <?= json_encode($notif['type']) ?>, 3000);
        </script>
        <?php endif; ?>

    <h2>Connexion Admin</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Se connecter</button>
    </form>

    <p style="color:red;"><?php echo $message; ?></p>

</body>
</html>