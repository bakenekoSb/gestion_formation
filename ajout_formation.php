<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>
     <!--Formulaire d'ajout -->
    <form id="form_principale" action="./traitement/save_formation.php" method="POST">

        <!--Etape1:Ajout de formation-->
        <div id="etape1" class="etape active">
            <h3>Ajouter une formation</h3>
            <label for="nom_formation">Nom formation:</label><br>
            <input type="text" placeholder="Nom Formation" id="nom_formation" name="nom_formation" required><br><br>
            <label for="date">Date de début:</label><br>
            <input type="date" name="date" id="date" required><br><br>
            <label for="nbr_jour">Nombre de jour de formation:</label><br>
            <input type="number" id="nb_jour" min="1" value="5" name="capacite"><br><br>
            <button type="button" onclick="etapeSuivante(1,2)">Suivant</button>
            <button type="button" onclick="annulerForm()">Annuler<button>
        </div>

        <!--Etape2:Nombre de participant-->
        <div id="etape2" class="etape">
            <h3>Nombre de participant</h3>
            <label for="nb_participant">Nombre de participant:</label><br>
            <input type="number" min="0" value="20" id="nb_participant" name="nb_participant"><br><br>
            <button type="button" onclick="etapePrecedente(2,1)">Précédent</button>
            <button type="button" onclick="etapeSuivante(2,3)">Suivant</button>
            <button type="button" onclick="annulerForm()">Annuler<button>
        </div>

         <!--Etape3:Ajout de formateur-->
        <div id="etape3" class="etape">
            <h3>Ajout Formateur</h3>
            <label for="nom_formateur">Nom formateur:</label><br>
            <input type="text" placeholder="Nom Formateur" id="nom_formateur"><br><br>
            <label for="prenom_formateur">Prenom formateur:</label><br>
            <input type="text"  id="prenom_formateur" placeholder="Prenom Formateur"><br><br>
            <button type="button" onclick="etapePrecedente(3,2)">Précédent</button>
            <button type="submit" name="btn_ajout">Envoyer</button>
            <button type="button" onclick="annulerForm()">Annuler<button>
        </div>

    </form>
   
<?php include 'includes/foot.php'; ?>