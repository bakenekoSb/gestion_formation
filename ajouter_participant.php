<?php
require 'dashboard.php';
$idFormation=$_GET['id'];

?>

<form action="save_participant.php" method="POST">

    <input type="hidden"
    name="formation_id"
    value="<?php echo $idFormation; ?>">

    <label>Nom</label>

    <input type="text"
    name="nom">

    <label>Contact</label>

    <input type="text"
    name="contact">

    <button type="submit" name="btn_enreg">
    Enregistrer participant
    </button>

</form>