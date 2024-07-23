<?php
require_once("header.php");
// je me connecte a la base de donnée
include "connect.php";
// mon but est d'afficher tous les livres disponibles donc je lance une requette  
// si je suis sur la page article.php le livre sur lequel j'ai cliqué ne doit plus s'afficher normalement 
if (basename($_SERVER['PHP_SELF']) == 'article.php') {
    if (isset($_GET["identification"])) {
        $identification = $_GET["identification"];
        $requette = "SELECT livre.*, client.* FROM livre JOIN client ON livre.id_client = client.id_client WHERE id_livre != $identification ORDER BY titre";
    }
}
// sinon j'affiche tous les livres disponibles 
else {
    // si je suis sur la page livreFavorie.php je veux afficher tous les livres mais par orders de ceux qui sont les plus aimés 
    if (basename($_SERVER['PHP_SELF']) == 'livreFavorie.php') {
        $requette = "SELECT livre.*, client.*, COUNT(favoris.id_favori) AS total_favoris FROM livre JOIN client ON livre.id_client = client.id_client LEFT JOIN favoris ON livre.id_livre = favoris.id_livre GROUP BY livre.id_livre ORDER BY total_favoris DESC";
    } elseif (basename($_SERVER['PHP_SELF']) == 'annonce.php') {
        $requette = "SELECT livre.*, client.* FROM livre JOIN client ON livre.id_client = client.id_client WHERE livre.id_client= {$_SESSION["id_client"]} ORDER BY titre";
    } elseif (basename($_SERVER['PHP_SELF']) == 'categorie.php') {
        $requette = "SELECT livre.*,client.*, genre.type AS genre, edition.Nom AS edition FROM livre JOIN genre ON livre.id_genre = genre.id_genre JOIN edition ON livre.id_edition = edition.id_edition JOIN client ON livre.id_client = client.id_client where genre.type='$genre';";
    } elseif (basename($_SERVER['PHP_SELF']) == 'recherche.php') {
        $requette = "SELECT livre.*, client.* FROM livre JOIN client ON livre.id_client = client.id_client where titre like '%$recherche%'";
    }
    // dans les autres pages a part articles et annonces  j'affiche tous les livres disponibles 
    elseif (basename($_SERVER['PHP_SELF']) !== 'livreFavorie.php') {
        $requette = "SELECT livre.*, client.* FROM livre JOIN client ON livre.id_client = client.id_client ORDER BY livre.titre";
    }
}
// j'execute ma requette 
$execute = mysqli_query($id, $requette);
// je verifie si il y'a des erreurs dans la requête
if (!$execute) {
    die("Erreur dans la requête : " . mysqli_error($id));
}

// je recupere les informations du formulaire pour envoyez un message 
if (isset($_POST["ecrire"])) {
    // je verifie que la personne est connecter sinon je l'oblige a se connecter 
    if (isset($_SESSION["id_client"])) {
        // je recupere le message écrit par la personne connectée et l'id de la personne a qui on veut envoyer le message 
        $messageEnvoyer = $_POST["message"];
        $id_user_recu = $_POST["id_user_recu"];
        // je lance une requette pour inserer le message dans ma base de donnée 
        $requette_message = "insert into messages  (contenu,id_user_recu,id_client,date) values ('$messageEnvoyer','$id_user_recu','$_SESSION[id_client]',now())";
        // j'execute la requette 
        $execute_message = mysqli_query($id, $requette_message);
        // je verifie si il n'y a pas d'eerue dans la requette 
        header("location:discussion.php");
        if (!$execute_message) {
            die("Erreur dans l'insertion du message:" . mysqli_error($id));
        }
    } else {
        header("location:connexion.php?Veuillez vous connectez pour envoyer un message ");
    }
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/81e489c8c5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>BookTop</title>
</head>

<body><br><br><br>
    <?php
    // pour confirmer la suppression d'un livre
        if (isset($_GET["supIdentification"])) {
    ?>
            <div class="annonce">
                <form action="supprimerArticle.php<?php if (isset($_GET["supIdentification"])) {
                                                        echo "?supIdentification=$_GET[supIdentification]";
                                                    } ?>" method="post">
                    <p>Êtes-vous sûr de vouloir supprimé ce livre?</p>
                    <button type="submit" name="valider">Valider</button>
                    <button type="Submit" name="annuler">Annuler</button>
                </form>
            </div>
        <?php
        }
    //  pour voir les informations de celui qui a fait le poste 
    if (isset($_POST["inform"])) {
        // Récupérer l'identifiant du livre à partir du bouton cliqué
        $id_livre = $_POST["inform"];
        // Requête SQL pour récupérer les informations sur la personne associée au livre
        $requete_info_personne = "SELECT * FROM client WHERE id_client = (SELECT id_client FROM livre WHERE id_livre = $id_livre)";
        $resultat_info_personne = mysqli_query($id, $requete_info_personne);
        // Vérifier si la requête a réussi
        // if ($resultat_info_personne && mysqli_num_rows($resultat_info_personne) > 0) {
        // Récupérer les informations sur la personne
        $info_personne = mysqli_fetch_assoc($resultat_info_personne);
        // Afficher les informations sur la personne
        // }
        ?>
        <div class="responsable">
            <form action="" method="post">
                <p>Nom:<?= $info_personne["nom"] ?></p>
                <p>Prénom:<?= $info_personne["prenom"] ?></p>
                <p>Email:<?= $info_personne["email"] ?></p>
                <p>Téléphone<?= $info_personne["tel"] ?></p>
                <!-- je creer un champs cachée pour récuperer l'id de la personne sur laquelle on clique pour envoyez un message   -->
                <input type="hidden" name="id_user_recu" value="<?= $info_personne["id_client"] ?>">
                <input type="text" name="message" placeholder="Envoyez un message">
                <button type="submit" name="ecrire">Envoyez un message</button>
                <a href="">Annuler</a>
            </form>
        </div>
    <?php
    }
    // Comme j'ai inclu cette page dans d'autre page php je verifie si je suis bien dans la page index.php pour ne pas affichez le carousel en bas des autres pages 
    if (basename($_SERVER['PHP_SELF']) == 'index.php') {
    ?>
        <div class="carousel-container">
            <div class="slide" style="display: block; text-align: center;   background-image: linear-gradient(to left, rgba(0, 255, 255, 0.8));">
                <p>
                <h1>Bienvenue sur Booktop</h1><img src="../img/booktop_logo_uploaded_transparent.png" style="width: 100px;"></p>
            </div>
            <div class="slide">
                <img src="../img/slide1.jpg">
            </div>

            <div class="slide">
                <img src="../img/slide2.jpg">
            </div>
            <div class="slide">
                <img src="../img/slide3.jpg">
            </div>


        </div>
    <?php
    }
    ?>

    <main>
        <div class="titre">
            <?php
            if (basename($_SERVER['PHP_SELF']) == 'index.php') {
                echo " <p><span class='livre'>Les livres disponibles</span></p>";
            } elseif (basename($_SERVER['PHP_SELF']) == 'livreFavorie.php') {
                echo " <p><span class='livre'>Les livres les plus aimés </span></p>";
            } elseif (basename($_SERVER['PHP_SELF']) == 'annonce.php') {
                echo " <p><span class='livre'>Vos annonces</span></p>";
            } elseif (basename($_SERVER['PHP_SELF']) == 'categorie.php') {
                if (mysqli_num_rows($execute) === 0) {
                    echo "<p><span class='livre' style='margin-left: 250px;'>Aucun livre du genre" . " " . $genre . "</span></p>";
                } else {
                    echo "<p><span class='livre' style='margin-left: 250px;'>Les livres du genre" . " " . $genre . "</span></p>";
                }
            } elseif (basename($_SERVER['PHP_SELF']) == 'recherche.php') {
                if (mysqli_num_rows($execute) === 0) {
                    echo "<p><span class='livre'>Aucun livre ne comporte '" . $_POST["recherche"] . "'</span></p>";
                } else {
                    echo "<p><span class='livre'>Les livres comportant'" . $_POST["recherche"] . "'sont</span></p>";
                }
            } elseif (basename($_SERVER['PHP_SELF']) !== 'index.php') {
                echo " <p><span class='livre'>Autres livres disponibles </span></p>";
            }

            ?>
        </div>
        <div class="album py-5 ">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                    <?php
                    // je Déclare et j'initialisation  la variable $counter pour différencier chaque livres
                    $counter = 0;

                    // mon but est d'afficher les livres qui sont favoris pour chaque utilisateur  quand il se connecte ou sinon juste les favoris des non utilisateurs  donc comme j'ai déja ma table favorie je lance une requette 
                    // si l'utilisateur est connecter alors on utilise son identifiant dans la requette 
                    if (isset($_SESSION['id_client'])) {
                        $id_client = $_SESSION['id_client'];
                    }
                    // sinon l'identifiant=0 pour signifier juste les livres favoris des nons utilsateurs 
                    else {
                        $id_client = 0;
                    }
                    $requette3 = "select * from favoris where id_client='$id_client'";
                    // j'execute la requette 
                    $execute3 = mysqli_query($id, $requette3);
                    // Vérifiez s'il y a des erreurs dans la requête de récupération des favoris
                    if (!$execute3) {
                        die("Erreur dans la requête pour récupérer les favoris : " . mysqli_error($id));
                    }


                    // j'affiche toutes les lignes de la requette pour afficher tous les livres de ma base de donnée 
                    while ($ligne = mysqli_fetch_assoc($execute)) {
                        $counter++;
                        // je vérifier si le livre actuel est présent dans les favoris de l'utilisateur donc je l'initialise a false d'abord
                        $is_favorite = false;
                        // je réinitialisation le curseur lorqu'on doit reparcourir la boucle while pour la requette 3
                        mysqli_data_seek($execute3, 0);
                        // je parcours tous les livres favorie de l'utilisateur 
                        while ($favori = mysqli_fetch_assoc($execute3)) {
                            // si un livre de l'utilisateur est favorie 
                            if ($favori["id_livre"] == $ligne["id_livre"]) {
                                $is_favorite = true;
                                // je sors de la boucle une fois qu'on a trouvé le livre dans les favoris et ainsi de suite 
                                break;
                            }
                        }

                    ?>
                        <div class="col">
                            <div class="annonces">
                                <form action="" method="post">
                                    <button value="<?= $ligne['id_livre'] ?>" name="inform" class="inform">
                                        <!-- grace au php j'extrait l'initial de chaque prenom que je transforme en majuscule si il ne l'est pas déja -->
                                        <div class="icon"><?= strtoupper(substr($ligne["prenom"], 0, 1)) ?></div>
                                    </button>
                                </form>

                                <div class="info">
                                    <div class="name"><?= $ligne["prenom"] ?></div>
                                    <!-- j'ajoute une $counter a l'id pour spécifieé l'id de chaque livre  -->
                                    <div class="rating" id="starIconContainer<?= $counter ?>">
                                        <!-- je fais de même  quand on clique sur favoris d'un livre  -->
                                        <a href="favoris.php?identification=<?= $ligne["id_livre"] ?>" class="favoris-link">
                                            <?php
                                            // si le livre est déja dans les favoris alors l'icone sera celui qui est remplie  
                                            if ($is_favorite) {
                                                echo '<i class="fa-solid fa-star" id="starIcon' . $counter . '"></i>';
                                            }
                                            // par contre si le livre est n'est pas dans les favoris alors l'icone ne sera pas remplie  
                                            else {
                                                echo '<i class="fa-regular fa-star" id="starIcon' . $counter . '"></i>';
                                            }
                                            ?>
                                        </a>
                                    </div>
                                </div>
                                <!-- je veux que chaque utilisateur puisse gérer ces livres(suppression et modifications) -->
                                <?php
                                if (isset($_SESSION["id_client"])) {
                                    if ($_SESSION["id_client"] == $ligne["id_client"]) {
                                ?>
                                        <div style="margin-left:110px;margin-top: 10px;">
                                            <a href="annonce.php?identification=<?= $ligne['id_livre'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="?supIdentification=<?= $ligne['id_livre'] ?>&identification=<?= $ligne['id_livre'] ?>"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>

                            <div class="card shadow-sm">
                                <div style="margin:auto;height: 250px;">

                                    <a href="article.php?identification=<?= $ligne["id_livre"] ?><?php if (isset($_GET['identifiant'])) {
                                                                                                        $_SESSION['identifiant'] = $_GET['identifiant'];
                                                                                                        echo "&identifiant=$_SESSION[identifiant]";
                                                                                                    } ?>">
                                        <img src="../img/<?php echo (file_exists('../img/' . trim($ligne['titre']) . '.png')) ? trim($ligne['titre']) . '.png' : (file_exists('../img/' . trim($ligne['titre']) . '.jpeg') ? trim($ligne['titre']) . '.jpeg' : trim($ligne['titre']) . '.jpg') ?>" class="d-block w-100 img" alt="First Slide">
                                        <div class="card-body ">
                                            <p class="card-text " style="text-align: center;"><b><?= $ligne['titre'] ?><br><?= $ligne['prix'] ?>€</b></p>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </main><br><br>
    <?php
    require_once("footer.php");
    ?>
    <script src="../JS/carousel.js"></script>
</body>

</html>