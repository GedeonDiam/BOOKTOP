<?php
session_start();
// Incluez le fichier de connexion à la base de données
include "connect.php";
// je verifie si "identification" apparait dans l'url quand on clique sur favoris.
if (isset($_GET['identification'])) {
    // je récupérez l'ID du livre à partir de l'URL
    $identification = $_GET['identification'];
    // je vérifiez si le livre est déjà marqué comme favori ou non
    $is_favorite = isset($_SESSION['favorites'][$identification]) ? $_SESSION['favorites'][$identification] : false;
    // j'inverse l'état du favori en fonction de comment il est actuellement 
    $is_favorite = !$is_favorite;
     // je mets à jour la session avec le nouvel état du favori
     $_SESSION['favorites'][$identification] = $is_favorite;
    // Maintenant je veux que quand la personne ajoute le livre a ses favories il rentre dans la base de donnée(la table favoris) donc je lance une requette de pour inserer pour chaque utilisateurs ses favoris 
     // je recuperere l'id du client dans la variable id_client et l'id du livre aussi qui est deja dans la variable $identification
     $id_client = $_SESSION["id_client"];
    // donc si la personne mets le  livre est favorie 
    if ($is_favorite) {
        // je lance une requette pour inserer l'id de l'utilisateur,son livre favorie 
        $requette1 = "insert into favoris (id_client,id_livre) values ('$id_client','$identification') ";
        // j'execute cette requette 
        $execute1 = mysqli_query($id, $requette1);
    }
    // par contre quand la personne decide de supprimer le livre de ses favoris 
    else {
        // je lance une autre requette pour supprimer pour l'utilisateur connecter le livre qu'il a choisie d'enlevez de ses favoris 
        $requette2 = "delete from favoris where id_client='$id_client' and id_livre='$identification'";
        // j'execute maintenant cette requette 
        $execute2 = mysqli_query($id, $requette2);
    }
    // je redirige l'utilisateur vers la page précédente
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
