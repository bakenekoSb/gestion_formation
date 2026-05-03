<?php 
    require './authentification/config.php';
    session_start();
?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>

<section id="Facture">
    <h2>Creation de facture</h2>
    <form action="./traitement/test.php" method="POST">
        <h3>Client</h3>
        <label for="nom_client">Nom du client:</label><br>
        <input name="nom" placeholder="Nom client" id="nom_client"><br><br>
        <label for="adresse_client">Adresse du client:</label><br>
        <input name="adresse" placeholder="Adresse" id="adresse_client"><br><br>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
        <h3>Formation</h3>
        <label for="date_debut">Date début:</label><br>
        <input type="date" id="date_debut" name="date_debut" placeholder="Date début formation"><br><br>
        <label for="date_fin">Date fin:</label><br>
        <input type="date" id="date_fin" name="date_fin" placeholder="Date fin formation"><br><br>
        <select name="designation">
            <option value="">Choisir la formation</option>
                <?php
                    //prend tous les id de formation sans doublons et afficher les noms correspondants
                    $sqlCategorie = "SELECT DISTINCT id_formation,titre_formation FROM formation";
                    $stmt = $pdo->prepare($sqlCategorie);
                    $stmt->execute();
                    $resultCategorie = $stmt->fetchAll();//le resultat est sous forme de table
                    foreach($resultCategorie as $r):?>
                        <option value="<?php echo $r['id_formation']; ?>"><?php echo $r['titre_formation']; ?></option>
                <?php endforeach; ?>
        </select>
        <h3>Frais</h3>
        <label for="prix_formation">Prix Formation:</label><br>
        <input type="number" name="prix" placeholder="Prix unitaire" min="100" id="prix_formation"><br><br>
        <label for="indemnite">Indemnité:</label><br>
        <input type="number" name="indemnite" placeholder="Indemnité" min="100"><br><br>
        <label for="tva">TVA:</label><br>
        <input type="number" name="tva" placeholder="TVA" min="0" id="tva"><br><br>
        <button class="btn btn-success" name="btn_apercu">Aperçu PDF</button>
        <button class="btn btn-success" name="btn_telecharge">Télécharger PDF</button>
    </form>
</section>
<?php include 'includes/foot.php'; ?>