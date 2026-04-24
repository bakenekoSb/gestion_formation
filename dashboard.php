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
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal" >Ajouter formation</button>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#factureModal" >Créer facture</button>
    
    <!-- popup formulaire pour ajout de formation-->
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

    <!-- popup formulaire pour creer une facture-->
    <div class="modal fade" id="factureModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Nouvelle Facture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="./traitement/test.php" method="POST">                       
                    <h3>Client</h3>
                        <input name="nom" placeholder="Nom client" class="form-control mb-2">
                        <input name="entreprise" value="GASY TECH" class="form-control mb-2">
                        <input name="adresse" placeholder="Adresse" class="form-control mb-2">
                        <input name="nif" value="6005717692/74908 112021 0 07713" class="form-control mb-2">
                        <input name="rcs" value="2024 A 01833" class="form-control mb-2">
                        <input name="email" placeholder="Email" class="form-control mb-3">
                        <input name="proforma" placeholder="N° Proforma" class="form-control mb-3">
                        <input name="bc" placeholder="N° BC" class="form-control mb-3">

                        <h3>Formation</h3>
                        <label>Date début</label>
                        <input type="date" id="date_debut" name="date_debut" placeholder="Date début" class="form-control mb-2">
                        <label>Date fin</label>
                        <input type="date" id="date_fin" name="date_fin" placeholder="Date fin" class="form-control mb-2">
                        <input name="designation" placeholder="Désignation" class="form-control mb-2">
                        <input type="number" name="jours" placeholder="Nombre de jours" class="form-control mb-3" readonly>

                        <h3>Frais</h3>
                        <input type="number" name="prix" placeholder="Prix unitaire" class="form-control mb-3">
                        <input type="number" name="indemnite" placeholder="Indemnité" class="form-control mb-2">
                        <input type="number" name="tva" placeholder="TVA" class="form-control mb-3">
                        <button class="btn btn-success" name="btn_facture">Générer PDF</button>

                    </form>
                        <script>
                        //pour calculer le nombre de jours entre deux dates
                        document.getElementById("date_fin").addEventListener("change", function(){
                            let debut = new Date(document.getElementById("date_debut").value);
                            let fin = new Date(document.getElementById("date_fin").value);
                            if(debut && fin){
                                let diff = fin - debut;
                                let jours = diff / (1000 * 60 * 60 * 24) + 1;
                                document.getElementById("jours").value = jours;
                            }
                        });
                        </script>
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