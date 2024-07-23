<?php
require_once("header.php");
// le but est d'afficher les informations concernant l'article sur lequelle j'ai cliquer 
// je me connecte a la base de donnée 
include("connect.php");
// je recupere l'identifiant qui apparait dans l'url pour l'inserer dans une variable 
if (isset($_GET["identification"])) {
  $identification = $_GET["identification"];
} else {
  if (isset($_SESSION["id_client"])) {
    header("location:index.php? identifiant=$_SESSION[id_client]&Veuillez cliquez sur un livre");
  } else {
    header("location:index.php?Veuillez cliquez sur un livre");
  }
}
// je lance une requette pour afficher les informations concernant l'article selectionné 
$requette = "SELECT livre.*, genre.type AS genre, edition.Nom AS edition
FROM livre
JOIN genre ON livre.id_genre = genre.id_genre
JOIN edition ON livre.id_edition = edition.id_edition
where livre.id_livre=$identification";
// j'execute ma requette 
$execute = mysqli_query($id, $requette);
// j'affiche une ligne de la requette 
$ligne = mysqli_fetch_assoc($execute);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/cd1eb87d27.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/article.css">
  <title>BookTop</title>
</head>

<body>
  <main>
    <div class="book-container">
      <div class="couvrir">
        <div class="book-cover">
          <img src="../img/<?php echo (file_exists('../img/' . trim($ligne['titre']) . '.png')) ? trim($ligne['titre']) . '.png' : (file_exists('../img/' . trim($ligne['titre']) . '.jpeg') ? trim($ligne['titre']) . '.jpeg' : trim($ligne['titre']) . '.jpg') ?>" class="d-block w-100 img" style="object-fit: cover;" alt="First Slide">
        </div>
        <form action="<?php if (isset($_SESSION["id_client"])) {
                        echo "panier.php?identifiant=$_SESSION[id_client]";
                      } else {
                        echo "connexion.php?Veuillez vous connectez pour accéder au panier";
                      } ?>" method="post">
          <div class="book-info">
            <h2><?= $ligne["titre"] ?></h2>
            <p>Auteur:<?= $ligne["auteur"] ?></p>
            <p>Genre:<?= $ligne["genre"] ?></p>
            <p>Edition:<?= $ligne["edition"] ?></p>
            <p><?= $ligne["prix"] ?><i class="fa-solid fa-euro-sign" style="width:2px;"></i></p>
            <input type="number" name="qte" min="1" placeholder="Quantité" style="border-radius: 10px; " required><br><br>
            <!-- Ajout de champs cachés pour récupérer les données dans l'url-->
            <?php
            $_SESSION["titre"] = $ligne["titre"];
            $_SESSION["prix"] = $ligne["prix"];
            $_SESSION["id_livre"] = $ligne["id_livre"];
            ?>
            <input type="hidden" name="titre" value="<?= $_SESSION["titre"] ?>">
            <input type="hidden" name="prix" value="<?= $_SESSION["prix"] ?>">
            <input type="hidden" name="id_livre" value="<?= $_SESSION["id_livre"] ?>">
            <button type="submit" name="panier">Ajouter au panier</button>
          </div>
        </form>
      </div>
      <div class="description">
        <h2>Description</h2>
        <div>
          <?= $ligne["description"] ?>
        </div>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <?php
  require_once("index.php");
  require_once("footer.php");
  ?>
</body>

</html>