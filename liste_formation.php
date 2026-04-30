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
                <p>Place disponible :<?php echo $ligne['placeDispo']; ?></p>
            </span>
                <p><?php
                    if($ligne['statut'] == "en inscription"){
                        echo '<span id="disponible">En inscription</span>';
                    } else if($ligne['statut'] == "en cours"){
                        echo '<span id="indisponible">En cours</span>';
                    } else{
                        echo '<span id="terminé">Terminé</span>';
                    }?>
                </p>
            <div class="actions">
                <button type="button" class="btn participant" data-bs-toggle="modal" data-bs-target="#participantModal<?php echo $ligne['id_formation']; ?>">Participants</button>
                <a class="btn formateur"href="attribuer_formateur.php?id=<?php echo $ligne['id_formation']; ?>">Formateur</a>
                <a class="btn modifier" href="modifier.php?id=<?php echo $ligne['id_formation']; ?>">Modifier</a>
                <a class="btn supprimer" href="supprimer.php?id=<?php echo $ligne['id_formation']; ?>">Supprimer</a>
            </div>

            
        </div>
        <!-- popup pour ajout de participant -->
            <div class="modal fade" id="participantModal<?php echo $ligne['id_formation']; ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Ajouter Participant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="./traitement/save_participant.php" method="POST">
                                <input type="hidden" name="formation_id" value="<?php echo $ligne['id_formation']; ?>">
                                <label>Nom</label>
                                <input type="text" name="nom" class="form-control mb-3">
                                <label>Contact</label>
                                <input type="text" name="contact" class="form-control mb-3">
                                <button class="btn btn-success" name="btn_enreg">Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        } else {
            echo "Aucune formation";
        } ?>
    </div>
    <?php include 'includes/foot.php'; ?>

