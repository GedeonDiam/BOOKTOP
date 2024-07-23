<?php
session_start();
include("connect.php");
if (isset($_SESSION["id_client"])) {

    if (isset($_POST["valider"])) {
        $titre = mysqli_real_escape_string($id, $_SESSION["titre"]);
        $prix = mysqli_real_escape_string($id, $_SESSION["prix2"]);
        $auteur = mysqli_real_escape_string($id, $_SESSION["auteur"]);
        $id_genre =  mysqli_real_escape_string($id, $_SESSION["genre"]);
        $id_edition =   mysqli_real_escape_string($id, $_SESSION["edition"]);
        $description = mysqli_real_escape_string($id, $_SESSION["description"]);
        $id_client = mysqli_real_escape_string($id, $_SESSION["id_client"]);
        // si la personne souhaite modifier un de ses livres je lance une requette pour ca 
        if (isset($_GET["identification"])) {
            $requette = "UPDATE livre SET titre='$titre', prix='$prix', auteur='$auteur', id_genre='$id_genre', id_edition='$id_edition', description='$description' WHERE id_livre='$_GET[identification]'";
            // j'ecris un message a la personne pour qu'il sache que sont livre a bien été enrégistrée 
            $_SESSION['message'] = "Votre livre a été modifié avec succès !";
        } else {
            // j'insère les données dans la base de données
            $requette = "INSERT INTO livre (titre, prix, auteur,id_genre,id_edition,description,id_client) VALUES ('$titre', '$prix', '$auteur','$id_genre','$id_edition','$description','$id_client')";
            // j'ecis un message a la personne pour qu'il sache que sont livre a bien été enrégistrée 
            $_SESSION['message'] = "Votre livre a été ajouté avec succès !";
        }
        // j'execute la requette 
        $execute = mysqli_query($id, $requette);
        // je supprime les variables de session une fois que le livre est ajouté
        unset($_SESSION["titre"]);
        unset($_SESSION["prix2"]);
        unset($_SESSION["auteur"]);
        unset($_SESSION["genre"]);
        unset($_SESSION["edition"]);
        unset($_SESSION["description"]);    
        header(("location:annonce.php"));
    }
    // Quand la personne clique sur annuler je le redirige directement vers la page panier.php
    if (isset($_POST["annuler"])) {
        header(("location:annonce.php"));
    }
} else {
    header("location:connexion.php?Veuillez vous connectez pour valider votre annonce");
}
