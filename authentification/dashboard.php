<?php
require 'config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
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

    <h2>Bienvenue <?php echo $_SESSION['admin']; ?> 🎉</h2>

    <a href="logout.php">Se déconnecter</a>

</body>
</html>