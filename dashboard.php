<?php
require './authentification/config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ./authentification/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
        <header>
        <nav>
            <div style="font-weight: 700; font-size: 1.2rem; color: var(--color-accent);">
                <img src="fond3.png" alt="erreur" width="50px" height="30px">  Gasy Tech</div>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <button id="theme-toggle">🌙 / ☀️</button>
                <a href="./authentification/logout.php">Se déconnecter</a>
                
            </div>
        </nav>
    </header>

    <h2>Bienvenue <?php echo $_SESSION['admin']; ?> 🎉</h2>
    <!-- section pour ouvrir un popup: formulaire d'ajout de formation -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal" >Ajouter formation</button>
    
    <!-- popup formulaire -->
    <div class="modal fade" id="formModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Nouvelle Formation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="./traitement/save_formation.php" method="POST">
                        <label>Nom formation</label>
                        <input type="text" name="nom_formation" class="form-control mb-3">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control mb-3">
                        <button class="btn btn-success" name="btn_ajout">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
</body>
</html>