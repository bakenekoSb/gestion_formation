   <?php 
        require './authentification/config.php';
        session_start();
    ?>
    <?php include 'includes/head.php'; ?>
    <?php include 'includes/header.php'; ?>
        <!-- affichage des formations -->
    <h1>Liste des Formations</h1>
    <?php
        $sql="SELECT * FROM formation";
        $result = $pdo->prepare($sql);
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
       
    ?>
    <div class="container">
        <?php
        //liste des formations
        if(count($row) > 0){
            foreach($row as $ligne){
        ?>
        <div class="card">
            <h3><?php echo $ligne['titre_formation']; ?></h3>
            <p>Date :<?php echo $ligne['date_debut']; ?></p>
            <span>
                <p>Capacité :<?php echo $ligne['capacite']; ?></p>
            </span>
            <div class="actions">
                <a class="btn modifier" href="modifier.php?id=<?php echo $ligne['id_formation']; ?>">Modifier</a>
                <a class="btn supprimer" href="supprimer.php?id=<?php echo $ligne['id_formation']; ?>">Supprimer</a>
            </div>
            
        </div>
        <?php }
        } else {
            echo "Aucune formation";
        } ?>
    </div>
    <?php include 'includes/foot.php'; ?>

