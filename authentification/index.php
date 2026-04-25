<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../css/index.css">
    <title>Login</title>
</head>
<body>
    
    <form action="./../traitement/trt_index.php" method="POST" class="loginForm">
        <img src="./../img/Logo.png" alt="logo">
        <h2>Connexion Admin</h2>
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Se connecter</button>
    </form>

</body>
</html>