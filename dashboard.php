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
            <p>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae nesciunt cumque error dolorum voluptatum deleniti modi obcaecati suscipit omnis libero.
            </p>
        </div>
    </section>
     
    <?php include 'includes/foot.php'; ?>
