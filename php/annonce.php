<?php
require_once("header.php");
// je me connecte a la base de donnée 
include "connect.php";
// je verifie si la personne est connecté
if (isset($_SESSION["id_client"])) {
    // si le personne a cliquer sur un de ces livres ajoutés je veux que les informations soient préremplies 
    if (isset($_GET["identification"])) {
        // je lance une requette pour recuperer les informations du livre concerné 
        $requette =  "SELECT livre.*,genre.*,edition.* from livre JOIN genre ON livre.id_genre=genre.id_genre JOIN edition ON livre.id_edition=edition.id_edition where livre.id_livre=$_GET[identification]";
        // j'execute ma requette 
        $execute = mysqli_query($id, $requette);
        // je recupere une ligne du résultat de ma requette 
        $ligne = mysqli_fetch_assoc($execute);
    }
    // je verifie si le formulaire est envoyé 
    if (isset($_POST["bouton"])) {

        
        // je recupere le titre du livre que j'attribue a l'image directement 
        $titre = trim(mysqli_real_escape_string($id, $_POST["titre"]));
        // je telecharge l'image envoyer par la personne connectée
        if (isset($_FILES["image"])) {
            move_uploaded_file($_FILES["image"]["tmp_name"], "../img/" . $titre.".png");
        }
        // je récupérer les données du formulaire en filtrant les injections sql
        $_SESSION["titre"] = mysqli_real_escape_string($id, $_POST["titre"]);
        $_SESSION["prix2"] = mysqli_real_escape_string($id, $_POST["prix"]);
        $_SESSION["auteur"] = mysqli_real_escape_string($id, $_POST["auteur"]);
        $_SESSION["description"] = mysqli_real_escape_string($id, $_POST["description"]);
        // je dois verifier que la personne a cliquée sur un genre et une edition avant de les attribuer a une variable 
        if ((isset($_POST["genre"]) && $_POST["genre"] != "") && (isset($_POST["edition"]) && $_POST["edition"] != "")) {
            $_SESSION["genre"] = mysqli_real_escape_string($id, $_POST["genre"]);
            $_SESSION["edition"] = mysqli_real_escape_string($id, $_POST["edition"]);
           
        }
    }
} else {
    header("location:connexion.php?Veuillez vous connectez pour ajouter un article");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajoute ou modifier un livre</title>
    <script src="https://kit.fontawesome.com/81e489c8c5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body><br><br><br><br><br>
    <?php
    if (isset($_POST["bouton"])) {
        if ((isset($_POST["genre"]) && $_POST["genre"] != "") && (isset($_POST["edition"]) && $_POST["edition"] != "")) {
    ?>
            <div class="annonce">
                <form action="valider2.php<?php if (isset($_GET["identification"])) {
                                                echo "?identification=$_GET[identification]";
                                            } ?>" method="post">
                    <?php echo isset($_GET["identification"]) ? '<p>Êtes-vous sûr de vouloir modifié ce livre?</p>' : '<p>Êtes-vous sûr de vouloir ajouté ce livre?</p>' ?>
                    <button type="submit" name="valider">Valider</button>
                    <button type="Submit" name="annuler">Annuler</button>
                </form>
            </div>
        <?php
        }
    }

    if (isset($_SESSION['message'])) {
        // j'affiche le message qui montre que le livre a bien été enregistrer ou modifier 
        echo "<p style=' font-size: 70px; text-align: center; font-family: cursive; font-style: italic;'>$_SESSION[message]</p>";
        // je supprime la variable de session pour quelle apparaisse une seule fois 
        unset($_SESSION['message']);
    }
    // si je veux modifier un livre il affiche ce message 
    if (isset($_GET["identification"])) {
        echo '<p style=" font-size: 70px; text-align: center; font-family: cursive; font-style: italic;">Modifier votre livre </p>';
    } else {
        ?>
        <!-- dans le cas contraire il aaffiche celui là -->
        <p style=" font-size: 70px; text-align: center; font-family: cursive; font-style: italic;">Ajouter un nouveau livre </p>
    <?php
    }
    ?>
    <div class="contenant">
        <!-- enctype s'utilise quand on doit inserer une image un pdf etc.....  -->
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">

                <?php
                if (isset($_GET['identification'])) {
                    echo " <label for='image'>Image actuelle :</label>";
                    $titre = mysqli_real_escape_string($id, $ligne["titre"]);
                    // Construction du chemin de l'image
                    $imagePath = "../img/";
                    // Vérification de l'existence de différents formats d'image
                    $imagePath .= (file_exists($imagePath . $titre . '.png')) ? $titre . '.png' : ((file_exists($imagePath . $titre . '.jpeg')) ? $titre . '.jpeg' : $titre . '.jpg');
                    // Vérification de l'existence de l'image
                    if (file_exists($imagePath)) {
                        echo "<img src='$imagePath' alt='Image du livre' style='max-width: 200px;'>";
                        echo '<input type="file" class="form-control" id="image" name="image">';
                    } else {
                        echo "<p>Aucune image trouvée.</p>";
                        echo '<input type="file" class="form-control" id="image" name="image">';
                    }
                } else {
                    echo " <label for='image'>Image:</label>";
                    echo '<input type="file" class="form-control" id="image" name="image" required>';
                }
                ?>
            </div>
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" class="form-control" id="titre" name="titre" value="<?php if (isset($_GET['identification'])) {
                                                                                            echo $ligne["titre"];
                                                                                        } ?> " required>
            </div>
            <div class="form-group">
                <label for="prix">Prix :</label>
                <input type="number" min="1" class="form-control" id="prix" name="prix" value="<?php echo isset($_GET['identification']) ? $ligne["prix"] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="auteur">Auteur :</label>
                <input type="text" class="form-control" id="auteur" name="auteur" value="<?php if (isset($_GET['identification'])) {
                                                                                                echo $ligne["auteur"];
                                                                                            } ?> " required>
            </div>
            <div class="form-group">
                <label for="genre">Genre :</label>
                <select class="form-control" id="genre" name="genre">
                    <?php
                    if (isset($_GET['identification'])) {
                        echo '<option selected>' . $ligne["type"] . '</option>';
                    } else {
                    ?>
                        <option disabled selected>Choisissez un genre</option>
                    <?php
                    }
                    // mon but est de récupérer l'id du genre sur lequel l'utilisateur clique donc je lance une requette pour récupérer tous les genres de ma table genre 
                    $requette1 = "select * from genre";
                    // j'execute la requette 
                    $execute1 = mysqli_query($id, $requette1);
                    // j'affiche toutes les lignes possibles de ma requette 
                    while ($ligne1 = mysqli_fetch_assoc($execute1)) {
                    ?>
                        <option value="<?= $ligne1["id_genre"] ?>"><?= $ligne1["type"] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <?php
            if (isset($_POST["bouton"])) {
                if ((!isset($_POST["genre"]) || $_POST["genre"] === "")) {
                    echo "<p style='color:red;font-size: 10px;' >Veuillez sélectionner un genre";
                }
            }
            ?>
            <div class="form-group">
                <label for="edition">Edition :</label>
                <select class="form-control" id="edition" name="edition">
                    <?php
                    if (isset($_GET['identification'])) {
                        echo '<option selected >' . $ligne["Nom"] . '</option>';
                    } else {
                    ?>
                        <option disabled selected>Choisissez une édition</option>
                    <?php
                    }
                    // mon but est de récupérer l'id de l'édition sur lequel l'utilisateur clique donc je lance une requette pour récupérer tous les éditions de ma table edition 
                    $requette2 = "select * from edition";
                    // j'execute la requette 
                    $execute2 = mysqli_query($id, $requette2);
                    // j'affiche toutes les lignes possibles de ma requette 
                    while ($ligne2 = mysqli_fetch_assoc($execute2)) {
                    ?>
                        <option value="<?= $ligne2["id_edition"] ?>"><?= $ligne2["Nom"] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <?php
            if (isset($_POST["bouton"])) {
                if ((!isset($_POST["edition"]) || $_POST["edition"] === "")) {
                    echo "<p style='color:red;font-size: 10px;' >Veuillez sélectionner une édition";
                }
            }
            ?>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea class="form-control" id="description" name="description" required> <?php if (isset($_GET['identification'])) {
                                                                                                    echo $ligne["description"];
                                                                                                } ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="bouton"><?php echo isset($_GET["identification"]) ? 'Modifier' : 'Ajouter'; ?> </button>
        </form>
    </div>
</body>

</html>

<?php
require_once("index.php");
require_once("footer.php");
?>