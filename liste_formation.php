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

                <button class="btn modifier"
                    onclick="ouvrirModif(
                    <?php echo $ligne['id_formation']; ?>,
                    '<?php echo addslashes($ligne['titre_formation']); ?>',
                    '<?php echo $ligne['date_debut']; ?>',
                    <?php echo $ligne['capacite']; ?>
                    )"
                >
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                
                <a class="btn supprimer" href="supprimer.php?id=<?php echo $ligne['id_formation']; ?>">
                    <i class="fa-solid fa-trash"></i>
                </a>

            </div>
            
        </div>
        <?php }
        } else {
            echo "Aucune formation";
        } ?>
        
    </div>

    <div class="modif_form" id="modif_form">
            <div class="contenue_modif">
                <form method="POST" action="modifier.php" onsubmit="return verifierForm()">
                        <input type="hidden" name="id" id="modif_id">

                        <label>Titre</label>
                        <input type="text" name="titre" id="modif_titre">

                        <label>Date</label>
                        <input type="date" name="date_debut" id="modif_date">

                        <label>Capacité</label>
                        <input type="number" name="capacite" id="modif_capacite">
                        <div class="action_modif">
                            <button type="submit" name="update">Modifier</button>
                            <button type="button" onclick="fermerModif()">Annuler</button>
                        </div>
                </form>
            </div>
    </div>
    <?php include 'includes/foot.php'; ?>

