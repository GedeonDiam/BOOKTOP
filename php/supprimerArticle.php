<?php
session_start();
if (isset($_SESSION["id_client"])) {
    if (isset($_GET["supIdentification"])) {
        if (isset($_POST["valider"])) {
            // je me connecte a la base de donné 
            include("connect.php");
            // je recupere l'id present dans l'url 
            $supIdentification = mysqli_real_escape_string($id, $_GET['supIdentification']);
            // je lance une requette pour supprimer l'article concernée 
            $requette = "DELETE FROM livre WHERE id_livre='$supIdentification'";
            // j'execute ma requette 
            $execute = mysqli_query($id, $requette);
            header("location:index.php?Votre livre a été bien supprimé");
        }
        // Quand la personne clique sur annuler je le redirige directement vers la page panier.php
        if (isset($_POST["annuler"])) {
            header(("location:index.php"));
        }
    } else {    
        header("location:index.php?Veuillez cliquez sur un de vos articles");
    }
} else {
    header("location:connexion.php?Veuillez vous connectez pour supprimer un de vos article");
}
