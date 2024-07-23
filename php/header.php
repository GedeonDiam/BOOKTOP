<?php
// j'ouvre une session start pour que quand l'utilisateur vient directement sur la page sans etre connecter il ne verras que identifiez.Mais si il est connecté il verra deconnecter vous 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>


    <div class="navbar">
        <div class="logo"><a href="index.php<?php if (isset($_SESSION['id_client'])) {
                                                echo "?identifiant=$_SESSION[id_client]";
                                            } ?>"><img src="../img/booktop_logo_uploaded_transparent.png" alt="" width="135" style="color: #8f99e1; margin-left: 15px;"></a></div>
            <a href="index.php<?php if (isset($_SESSION['id_client'])) {
                                        echo "?identifiant=$_SESSION[id_client]";
                                    } ?>">Accueil</a>
        <div id="welcome">
                    <span><i class="fa-solid fa-bars"></i> Appliquer un filtre</span>
                    <div class="options">
                        <ul style="display: block;   list-style-type: none; text-align: center;">
                            <li style="margin: 5px;"> <a href="genre.php">Genre</a></li>
                            <li style="margin: 5px;"> <a href="livreFavorie.php">Favoris</a></li>
                        </ul>
                    </div>
                </div>
        <form action="recherche.php<?php if (isset($_SESSION['id_client'])) {
                                        echo "?identifiant=$_SESSION[id_client]";
                                    } ?>" method="post">
            <input type="text" name="recherche" class="search-box" placeholder="Quel livre recherchez-vous?" size="45" style="font-style: italic;">
            <label for="bouton"><i class="fa-solid fa-magnifying-glass" style="border: 2px solid white; padding: 5.5px;"></i></label>
            <input type="submit" id="bouton" name="bouton" value="" style="display: none;">
        </form>
        <div class="user-info">
            <?php
            // c'est quand la personne est connecter il pourra voir deconnecter vous 
            if (isset($_SESSION['id_client'])) {
            ?>
                <div id="welcome">
                    <?= "Bienvenue $_SESSION[prenom]" ?>                    <div class="options">
                        <ul style="display: block;   list-style-type: none; text-align: center;">
                            <li style="margin: 5px;"> <a href="historique.php">Historiques</a></li>
                            <li style="margin: 5px;"> <a href="commande.php">Commande</a></li>
                            <li style="margin: 5px;"> <a href="annonce.php">Annonces</a></li>
                            <li style="margin: 5px;"> <a href="discussion.php">Messages</a></li>
                        </ul>
                    </div>
                </div>
                <a href="deconnexion.php">Deconnectez-vous <i class="fa-solid fa-user-slash" style="color: #6574e6;  font-size: 20px;"></i></a>
            <?php
            }
            // Quand la personne n'est pas connecter il ne doit pas voir deconnectez-vous puisqu'il n'est pas connecter
            else {
                echo '<span><a href="connexion.php">Connectez-vous<i class="fa-regular fa-user" style="color: #6574e6;  font-size: 20px;"></i></a></span>';
            }

            ?>
            <?php
            if (isset($_SESSION['id_client'])) {
            ?>
                <a href="panier.php?identifiant=<?= $_SESSION["id_client"] ?>">Mon panier <i class="fa-sharp fa-solid fa-basket-shopping" style="color: #6574e6;  font-size: 20px;"></i></a>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>