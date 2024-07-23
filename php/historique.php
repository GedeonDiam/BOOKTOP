<?php
require_once("header.php");
// je me connecte a la base de donnée
include "connect.php";
if (isset($_SESSION["id_client"])) {
    $identifiant = $_SESSION["id_client"];
    // mon but est d'afficher l'historique de toutes les commandes de l'utilisateur 
    $requette = "SELECT * FROM hist_commande WHERE id_client = '$identifiant'";
    // j'execute ma requette 
    $execute = mysqli_query($id, $requette);
    // je verifie si il y'a des erreurs dans la requête
    if (!$execute) {
        die("Erreur dans la requête : " . mysqli_error($id));
    }
} else {
    header("location:connexion.php?Veuillez vous connectez pour accéder au panier");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cd1eb87d27.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style.css">
    <title>Mon panier</title>
</head>

<body>
    <main>
        <?php
        // je veux regarder si la personne a au moins un trucs dans son panier sinon on lui met un autre message 
        if (mysqli_num_rows($execute) > 0) {
        ?>
            <div class="titre" style="text-align: center;"><br><br>

                <p><span class="livre">Historique(s)</span></p>
                <div class="historique">
                    <?php
                    while($ligne=mysqli_fetch_assoc($execute)){
                    ?>
                    <div class="achat">
                        <p>Date de commande: <?=$ligne["Date_de_commande"] ?></p>
                        <p>Client:<?=$ligne["nom"]." ".$ligne["prenom"]?> </p>
                        <p>Téléphone:<?=$ligne["tel"]?></p>
                        <p>Adresse: <?=$ligne["adresse"]." ".$ligne["codePostal"]." ".$ligne["ville"]?></p>
                        <p>Nombre de livres achetés: <?=$ligne["nombreLivresAchetes"]?></p>
                        <p>Prix total: <?=$ligne["prix_total"]?><i class="fa-solid fa-euro-sign" style="width:2px;"></i></p>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
        } else {
            ?>
                <div class="titre" style="text-align: center;"><br><br>
                    <p><span class="livre">Votre Historique est vide </span></p>
                </div>
            <?php
        }
            ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php
    require_once("index.php");
    require_once("footer.php");
    ?>
</body>

</html>