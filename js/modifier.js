function ouvrirModif(id, titre, date, capacite) {

    document.getElementById("modif_form").style.display = "block";

    document.getElementById("modif_id").value = id;
    document.getElementById("modif_titre").value = titre;
    document.getElementById("modif_date").value = date;
    document.getElementById("modif_capacite").value = capacite;
}

function fermerModif() {
    document.getElementById("modif_form").style.display = "none";
}

window.onclick = function(event) {
    let modif = document.getElementById("modif_form");

    if (event.target === modif) {
        fermerModif();
    }
}


function verifierForm() {
    let titre = document.getElementById("modif_titre").value;

    if (titre.trim() === "") {
        alert("Le titre est obligatoire !");
        return false;
    }
    return true;
}