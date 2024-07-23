<?php
session_start();
// je me connecte a la base de donnée 
include("connect.php");
$identifiant=$_GET["identifiant"];
// je lance une requette  
$requette="DELETE FROM panier WHERE id_panier='$identifiant'";
// j'execute ma requette 
$execute=mysqli_query($id,$requette);
header("location:panier.php?identifiant=$_SESSION[identifiant]");
?>