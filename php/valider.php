<?php
session_start();
// je me connecte a la base de donnée 
include("connect.php");
// si une personne n'est pas connectée elle ne pourra entrer dans cette page 
if (isset($_SESSION["id_client"])) {
    // je veux que quand la personne valide sa commande il est une historique de ce qu'il commander et déjà payer et qu'apres ça son panier redevienne vide  
    if (isset($_POST["valider"])) {
        // je recupère l'id du client,le nombre de livre achetés,le nom,le prenom,l'adresse,le tel,le code postal,la ville, la date de sa commande et le prix_total de sa commande 
        $id_client = $_SESSION["id_client"];
        $Date_de_commande = date("Y-m-d H:i:s");
        // pour le nom je l'ai dejâ mis dans une session dans la page commande.php(  $_SESSION["nom"]=$nom)
        // pour le prenom je l'ai dejâ mis dans une session dans la page commande.php( $_SESSION["prenom"]=$prenom)
        // pour le tel je l'ai dejâ mis dans une session dans la page commande.php($_SESSION["tel"]=$tel )
        // pour l'adresse je l'ai dejâ mis dans une session dans la page commande.php(  $_SESSION["adresse"]=$adresse;)
        // pour le code postal je l'ai dejâ mis dans une session dans la page commande.php(  $_SESSION["codePostal"]= $codePostal)
        // pour la ville je l'ai dejâ mis dans une session dans la page commande.php( $_SESSION["ville"]=$ville)
        // pour le nombre de livres achetés je l'ai dejâ mis dans une session dans la page panier.php( $_SESSION["nombreLivresAchetes"])
        // pour le prix total je l'ai dejâ mis dans une session dans la page panier.php( $_SESSION["prixTotal"]=$prixTotal)

        //  je lance maintenant  une requette pour inserer dans ma table hist_commande l'historique de la commande du client connectée
        $requete = "INSERT INTO hist_commande (Date_de_commande, id_client, prix_total, nombreLivresAchetes, nom, prenom, tel, adresse, codePostal, ville) VALUES ('$Date_de_commande', '$id_client', '$_SESSION[prixTotal]','$_SESSION[nombreLivresAchetes]','$_SESSION[nom]','$_SESSION[prenom]', '$_SESSION[tel]', '$_SESSION[adresse]', '$_SESSION[codePostal]', '$_SESSION[ville]')";
        // j'execute maintenant la requette 
        $execute = mysqli_query($id, $requete);
        // maintenant que j'ai l'historique de la commande de la personne je dois vider son panier puisqu'il a déjà payé
        $requete2 = "DELETE FROM panier WHERE id_client = '$id_client'";
        // j'execute maintenant cette nouvelle requette 
        $execute2 = mysqli_query($id, $requete2);
        // je redirige maintenant la personne vers la page panier.php 
        header(("location:panier.php"));
    }
    // Quand la personne clique sur annuler je le redirige directement vers la page panier.php
    if (isset($_POST["annuler"])) {
        header(("location:panier.php"));
    }
} else {
    header("location:connexion.php?Veuillez vous connectez pour valider votre commande");
}
