<?php
require './../authentification/config.php';

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['btn_enreg'])){
    $formation_id=$_POST['formation_id'];
    $nom=$_POST['nom'];
    $contact=$_POST['contact'];

    // Vérifier places restantes
    $sql="SELECT placeDispo FROM formation WHERE id_formation = :formation_id";
    $result=$pdo->prepare($sql);
    $result->bindValue(':formation_id',$formation_id);
    $result->execute();
    $row=$result->fetchAll(PDO::FETCH_ASSOC);
    foreach($row as $r){
        if($r['placeDispo']<=0){
            die("Plus de places disponibles");
        }
    }

    //Insérer participant
    $stmt=$pdo->prepare("INSERT INTO participants(nom_participant,contact_participant,formation_id) VALUES(:nom,:contact,:formation_id)");
    $stmt->execute([
    'nom'=>$nom,
    'contact'=>$contact,
    'formation_id'=>$formation_id
    ]);

    //Décrémenter places
    $pdo->query("UPDATE formation SET placeDispo = placeDispo-1 WHERE id_formation=$formation_id");
    header("Location: ./../dashboard.php");
    exit();
}
?>