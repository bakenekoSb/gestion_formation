<header>
        <nav>
            <div class="logo">
                <img src="img/Logo.png" alt="Logo">
            </div>
            <ul>
                <li class="theme"><a href=""><button id="theme-toggle">🌙 / ☀️</button></a></li>
                <li class="btnheader" id="sortie"><a href="./authentification/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a></li>
                <li class="btnheader" onclick="Menu()"><div>☰</div></li>
            </ul>
        </nav>
    </header>
    <div id="sidebar" class="sidebar">
            <div class="closebtn" onclick="Menu()">✖️</div>
            <a href="dashboard.php">Dashboard</a>
            <a href="liste_formation.php">Liste Formation</a>
            <a href="ajout_formation.php">Ajouter Formation</a>
            <a href="#">Fiche Formation</a>
            <a href="#">Generation Proforma</a>
            <a href="generation_facture.php">Generation Facture</a>
        </div>