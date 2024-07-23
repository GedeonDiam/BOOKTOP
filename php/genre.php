<?php
require_once("header.php");
// je me connecte a la base de donnée
include "connect.php";
// mon but est d'afficher tous les livres disponibles donc je lance une requette 
// si je suis sur la page categorie.php le genre sur lequel j'ai cliqué ne doit plus s'afficher n'ormalement 
if (basename($_SERVER['PHP_SELF']) == 'categorie.php') {
    if (isset($_GET["genre"])) {
        $genre = $_GET["genre"];
        $requette = "SELECT * FROM genre WHERE genre !=$genre order by type";
        // j'exécute ma requette 
    }
}
// sinon j'affiche tous les genres disponibles 
$requette = "SELECT * FROM genre order by type";
$execute = mysqli_query($id, $requette);
// je vérifie si il y'a des erreurs dans la requête
if (!$execute) {
    die("Erreur dans la requête : " . mysqli_error($id));
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cd1eb87d27.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Genre de livres</title>
</head>

<body>
    <main>
        <div class="titre"><br><br>
            <?php
            if (basename($_SERVER['PHP_SELF']) !== 'genre.php') {
                echo ' <p><span class="livre">Autres genres de livres</span></p>';
            } else{
                echo ' <p><span class="livre">Les genres de livres</span></p>';
            }
            ?>
        </div>
        <div class="album py-5 ">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                    <?php
                    while ($ligne = mysqli_fetch_assoc($execute)) {
                    ?>
                        <div class="col">
                            <div class="card shadow-sm">
                                <div style="margin:auto;height: 250px;">
                                    <a href="categorie.php?<?php if (isset($_SESSION["id_client"])) { ?>identifiant=<?php echo "$_SESSION[id_client]";
                                                                                                                } ?>&genre=<?= $ligne['type'] ?>">
                                        <img src="../img/<?php echo (file_exists('../img/' . $ligne['type'] . '.jpeg')) ? $ligne['type'] . '.jpeg' : $ligne['type'] . '.jpg'; ?>" class="d-block w-100 img" alt="First Slide">
                                        <div class="card-body ">
                                            <p class="card-text " style="text-align: center;"><?= $ligne['type'] ?></p>

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
    </main><br><br>
    <?php
    require_once("footer.php");
    ?>
</body>

</html>