<?php
require './authentification/config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ./authentification/index.php");
    exit;
}
?>
    <?php include 'includes/head.php'; ?>
    <?php include 'includes/header.php'; ?>
    <section class="section_pple">
        <div class="contenue_section">

            <h2 class="hbienvenue">Bienvenue <?php echo $_SESSION['admin']; ?> </h2>
            <p>Que voulez vous faire aujourd'hui??</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal" >Ajouter formation</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#factureModal" >Créer facture</button>
        </div>
        </section>
        
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
                        <input name="adresse" placeholder="Adresse" class="form-control mb-2">

                        <h3>Formation</h3>
                        <label>Date début</label>
                        <input type="date" id="date_debut" name="date_debut" placeholder="Date début" class="form-control mb-2">
                        <label>Date fin</label>
                        <input type="date" id="date_fin" name="date_fin" placeholder="Date fin" class="form-control mb-2">
                        <select name="designation" class="form-control mb-3">
                            <option value="">Choisir la formation</option>
                            <?php
                                //prend tous les id de formation sans doublons et afficher les noms correspondants
                                $sqlCategorie = "SELECT DISTINCT id_formation,titre_formation FROM formation";
                                $stmt = $pdo->prepare($sqlCategorie);
                                $stmt->execute();
                                $resultCategorie = $stmt->fetchAll();//le resultat est sous forme de tableau

                                foreach($resultCategorie as $r):?>
                                    <option value="<?php echo $r['id_formation']; ?>"><?php echo $r['titre_formation']; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <h3>Frais</h3>
                        <input type="number" name="prix" placeholder="Prix unitaire" class="form-control mb-3">
                        <input type="number" name="indemnite" placeholder="Indemnité" class="form-control mb-2">
                        <input type="number" name="tva" placeholder="TVA" class="form-control mb-3">
                        <button class="btn btn-success" name="btn_apercu">Aperçu PDF</button>
                        <button class="btn btn-success" name="btn_telecharge">Télécharger PDF</button>

                    </form>
                </div>
            </div>
        </div>
    </div>




    <?php include 'includes/foot.php'; ?>
