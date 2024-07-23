<?php
require_once("header.php");
// je me connecte a la base de donnée
include "connect.php";
if (isset($_SESSION["id_client"])) {
    if (isset($_POST["panier"])) {
        $titre = $_POST["titre"];
        $_SESSION["qte"] = $_POST["qte"];
        $qte = $_POST["qte"];
        $id_livre = $_POST["id_livre"];
        $identifiant = $_SESSION["id_client"];
        // Mon but est que si l'article existe deja dans la base de donnée je veux juste qu'il change la quantité et le prix mais dans la cas contraire qu'il ajoute l'article dans le panier 
        // je verifie donc si l'article existe déjà dans le panier pour une même personne 
        $requete_verif_article = "SELECT * FROM panier WHERE id_client = '$identifiant' AND id_livre = '$id_livre'";
        // j'execute cette requette 
        $resultat_verif_article = mysqli_query($id, $requete_verif_article);
        // si le resultat de la requette est supperieur a 0 il s'agira d'un remplacement et non d'un ajout 
        if (mysqli_num_rows($resultat_verif_article) > 0) {
            // pour mettre a jour la quantiter je recupere dans un tableau $row les informations de l'article dans ma base de donnée  
            $row = mysqli_fetch_assoc($resultat_verif_article);
            // je recupere maintenant l'ancienne quantité dans une variable 
            $ancienne_qte = $row["qte"];
            // j'ajoute maintenant la nouvelle quantité voulue par l'utilisateur 
            $nouvelle_qte = $ancienne_qte + $qte;
            // je lance maintenant une requette pour ajuster la nouvelle quantité 
            $requete_maj_qte = "UPDATE panier SET qte = '$nouvelle_qte' WHERE id_client = '$identifiant' AND id_livre = '$id_livre'";
            // j'execute maintenant la requette 
            $execute_maj_qte = mysqli_query($id, $requete_maj_qte);
            // je verifie si il n'y a pas d'erreur dans ma requette 
            if (!$execute_maj_qte) {
                die("Erreur lors  de la mise à jour de la quantité: " . mysqli_error($id));
            }
        } else {
            // maintenant quand l'article n'existe pas deja dans ma base de donnée je l'insère juste 
            $requete_insert = "INSERT INTO panier (id_client, qte, id_livre) VALUES ('$identifiant', '$qte', '$id_livre')";
            //    j'execute maintenat cette nouvelle requette 
            $execute_insert = mysqli_query($id, $requete_insert);
            // je verifie si il n'y a pas d'erreur dans ma requette 
            if (!$execute_insert) {
                die("Erreur lors de l'insertion dans le panier : " . mysqli_error($id));
            }
        }
    }

    $identifiant = $_SESSION["id_client"];
    // mon but est d'afficher tous les livres disponibles donc je lance une requette 
    $requette = "SELECT  panier.*, livre.* FROM panier JOIN livre ON panier.id_livre = livre.id_livre WHERE panier.id_client = '$identifiant'";
    // j'execute ma requette 
    $execute = mysqli_query($id, $requette);
    // je verifie si il y'a des erreurs dans la requête
    if (!$execute) {
        die("Erreur dans la requête : " . mysqli_error($id));
    }
    // je Compte le nombre de lignes retournées par la requête pour pouvoir l'inserer dans mon historique de commande dans la page valider.php
    $nombreLivresAchetes = mysqli_num_rows($execute);
    // je le mets dans une session pour pouvoir recupérer le nombre de livres achetés 
    $_SESSION["nombreLivresAchetes"]=$nombreLivresAchetes;
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
                <p><span class="livre">Votre panier</span></p>
            </div>
            <div class="tableau">
                <table class="tableau1">
                    <tr>
                        <th style="width:auto;">Nom du livre</th>
                        <th style="width:50px;">Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Supprimer</th>
                    </tr>
                    <?php
                    $prixTotal = 0;
                    while ($ligne = mysqli_fetch_assoc($execute)) {
                        $nom = $ligne["titre"];
                        $prix = $ligne["prix"];
                        $qte = $ligne["qte"];
                        $total = $ligne["prix"] * $ligne["qte"];
                        $prixTotal += $total;
                        // je mets le prix total dans une session pour le récupérer dans la page valider.php 
                        $_SESSION["prixTotal"] = $prixTotal
                    ?>
                        <tr>
                            <td><?= $nom ?></td>
                            <td><?= $prix ?><i class="fa-solid fa-euro-sign" style="width:2px;"></i></td>
                            <td style="width: 5px;"><?= $qte ?></td>
                            <td><?= $total ?><i class="fa-solid fa-euro-sign" style="width:2px;"></i></td>
                            <td><a href="supprimer.php?identifiant=<?= $ligne["id_panier"] ?>"><span class="material-symbols-outlined">delete</span></a></td>
                        </tr>

                    <?php
                    }

                    ?>

                </table>
                <div class="tableau2">
                    <img src="../img/booktop_logo_uploaded_transparent.png" alt="logo"><br><br>
                    <table class="commandes">
                        <tr>
                            <th>Montant Total</th>
                            <th><?= $prixTotal ?><i class="fa-solid fa-euro-sign"></i></th>
                        </tr>
                    </table>
                    <form action="commande.php <?php if (isset($_SESSION["id_client"])) {
                                                    echo "?identifiant=" . $_SESSION["id_client"];
                                                } ?>" method="post">
                        <button type="submit" name="passer_commande">Passer la commande</button>
                    </form>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="titre" style="text-align: center;"><br><br>
                <p><span class="livre">Votre Panier booktop est vide</span></p>
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