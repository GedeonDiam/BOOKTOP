<?php
// require_once("header.php");
if (isset($_GET["genre"])) {
    // je recupere le genre qui apparait dans l'url pour l'inserer dans une variable 
    $genre = $_GET["genre"];
    // je me connecte a la base de donnée
    include "connect.php";
    // // je lance une requette dans la page index.phhp pour afficher les livres qui ont le genre selectionné 
    include "index.php";
    

} else {
    header("location:genre.php?identifiant=$_SESSION[id_client]&Veuillez cliquez un genre précis");
}

   