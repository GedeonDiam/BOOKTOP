<?php
// require_once("header.php");
if (!empty($_POST["recherche"])) {
    // je me connecte a la base de données 
    include("connect.php");
    // je recupere d'abord l'element remplie dans le formulaire 
    $recherche = $_POST["recherche"];
    // je fais une requette pour afficher le livre que la personne recherche dans la page index.php 
    include("index.php");
} else {
    if (isset($_SESSION["id_client"])) {
        header("location:index.php? identifiant=$_SESSION[id_client]&Veuillez rechercher un livre");
    } else {
        header("location:index.php?Veuillez recherchez un livre");
    }
}
?>
