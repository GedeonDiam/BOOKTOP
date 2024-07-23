<?php
include("header.php");
if (isset($_POST["bouton"])) {
    // je me connecte a la base de donnees 
    include("connect.php");
    // je créer une fonction pour hasher le mot de passe 
    function hasherMotDePasse($motDePasse)
    {
        // Utilisation de l'algorithme de hachage MD5
        $motDePasseHash = md5($motDePasse);

        // Retourner le mot de passe hashé
        return $motDePasseHash;
    }
    // je recupere les valeurs provenant du formulaire 
    $nom = mysqli_real_escape_string($id, $_POST["nom"]);
    $prenom = mysqli_real_escape_string($id, $_POST["prenom"]);
    $email = mysqli_real_escape_string($id, $_POST["email"]);
    $tel = mysqli_real_escape_string($id, $_POST["tel"]);
    $mdp = mysqli_real_escape_string($id, $_POST["mdp"]);
    $confirm_mdp = mysqli_real_escape_string($id, $_POST["confirm_mdp"]);
    // je hashe le mot de passe avant de l'insérer dans la base de données avec le fonction déclarée au dessus 
    $mdpHash = hasherMotDePasse($mdp);
    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($tel) && !empty($mdp) && !empty($confirm_mdp) && (isset($_POST["pays"]) && $_POST["pays"] != "")) {
        // je recupere aussi le pays que la personne a selectionner après avoir ete convaincu qu'il a selectionner un pays 
        $pays = mysqli_real_escape_string($id, $_POST["pays"]);
        // je verifie si le mail et le tel sont valide 
        if (preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/", $email) && preg_match("/^\+[0-9]{1,3} [0-9]{4,14}(?:x.+)?$/", $tel)  && preg_match("/^[a-zA-Z]{1,20}$/", $prenom) && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()-_+=?<>])[a-zA-Z0-9!@#$%^&*()-_+=?<>]{10,}$/', $mdp)) {
            // je vérifis si l'utilisateur existe déjà dans la base de données
            $requete_verif = "SELECT * FROM client WHERE email = '$email' OR tel = '$tel' OR nom='$nom' OR prenom='$prenom'";
            $resultat_verif = mysqli_query($id, $requete_verif);
            if (mysqli_num_rows($resultat_verif) > 0) {
                // pour afficher un message precis de l'information qui existe déja dans la base de donnée je mets le resultat de la requette dans un tableau 
                $row = mysqli_fetch_assoc($resultat_verif);
                // je compte  le nombre d'éléments existants pour pouvoir accorder le verbe"existe"
                // j'initialise d'abord la valeur a 0
                $nbElementsExistants = 0;
                $verif = "<p style='color:red;font-size: 10px;'>";
                // je Vérifie chaque champ et je le comparer avec les données de la base de données
                if ($row['email'] == $email) {
                    $verif .= "L'email '" . $email . "' ";
                    $nbElementsExistants++;
                }
                if ($row['tel'] == $tel) {
                    if ($nbElementsExistants > 0) {
                        $verif .= ", ";
                    }
                    $verif .= "le téléphone '" . $tel . "' ";
                    $nbElementsExistants++;
                }
                if ($row['nom'] == $nom) {
                    if ($nbElementsExistants > 0) {
                        $verif .= ", ";
                    }
                    $verif .= "le nom '" . $nom . "' ";
                    $nbElementsExistants++;
                }
                if ($row['prenom'] == $prenom) {
                    if ($nbElementsExistants > 0) {
                        $verif .= ", ";
                    }
                    $verif .= "le prénom '" . $prenom . "' ";
                    $nbElementsExistants++;
                }

                // j'accorde le verbe "existe" en fonction du nombre d'éléments existants
                if ($nbElementsExistants > 1) {
                    $verif .= "existent déjà. Veuillez changer vos informations.";
                } else {
                    $verif .= "existe déjà. Veuillez changer votre information.";
                }

                $verif .= "</p>";
            }
            // si il n'existe pas,là je peux insérer ces informations dans ma base de donnée 
            else {
                if ($mdp == $confirm_mdp) {
                    // le lance une requette pour inserer les informations dans la base de données
                    $requete = "INSERT INTO client (nom, prenom, email, tel, mdp,pays) VALUES ('$nom', '$prenom', '$email','$tel', '$mdpHash', '$pays')";
                    // j'execute ma requette 
                    $execute = mysqli_query($id, $requete);
                    // je lance une autre requette pour pouvoir recuperer l'id_client de l'utilisateur qui vient de s'inscrire de la table client afin de le mettre dans l'url
                    $requete = "select * from client where nom='$nom' and prenom='$prenom'";
                    // j'execute maintenant cette requette 
                    $execute = mysqli_query($id, $requete);
                    // j'affiche une ligne de ma requette pour pourvoir la mettre dans l'url 
                    $ligne = mysqli_fetch_assoc($execute);
                    // je redirige maintenant la page vers index.php
                    $_SESSION["id_client"] = $ligne["id_client"];
                    $_SESSION["prenom"] = $ligne["prenom"];
                    $_SESSION["nom"] = $ligne["nom"];
                    $_SESSION["tel"] = $ligne["tel"];
                    $_SESSION["pays"] = $ligne["pays"];
                    header("location:index.php?identifiant= $_SESSION[id_client]");
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cd1eb87d27.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/identification.css">
    <title>Identification</title>
</head>

<body><br><br>
    <div class="signup-form">
        <h2><i><b>Identification</b></i></h2>
        <hr>
        <?php
        if (isset($_POST["bouton"])) {
            if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($tel) && !empty($mdp) && !empty($confirm_mdp) && preg_match("/^[a-zA-Z]{1,20}$/", $prenom) && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()-_+=?<>])[a-zA-Z0-9!@#$%^&*()-_+=?<>]{10,}$/', $mdp)) {
                if (preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/", $email) && (preg_match("/^\+[0-9]{1,3} [0-9]{4,14}(?:x.+)?$/", $tel))) {
                    // quand la personne existe deja dans ma base de donné je l'affiche le message de verif
                    if (mysqli_num_rows($resultat_verif) > 0) {
                        echo $verif;
                    }
                }
            }
        }
        ?>
        <form action="" method="POST">
            <div class="input-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" placeholder="Nom_Utilisateur">
            </div>
            <?php
            if (isset($_POST["bouton"])) {
                if (empty($nom)) {
                    echo "<p  style='color:red;font-size: 10px;'>Veuillez entrez votre nom";
                }
            }
            ?>
            <div class="input-group">
                <label for="prenom">Prenom</label>
                <input type="text" name="prenom" placeholder="Prenom_Utilisateur">
            </div>
            <?php
            if (isset($_POST["bouton"])) {
                if (empty($prenom)) {
                    echo "<p style='color:red;font-size: 10px;'>Veuillez entrez votre prenom";
                } else {
                    if (!preg_match("/^[a-zA-Z]{1,20}$/", $prenom)) {
                        echo "<p style='color:red;font-size: 10px;'>Le prénom doit contenir au plus 20 lettres,aucun chiffre et aucun espace.</p>";
                    }
                }
            }
            ?>
            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder=".....@gmail.com">
            </div>
            <?php
            if (isset($_POST["bouton"])) {
                if (empty($email)) {
                    echo "<p style='color:red;font-size: 10px;'>Veuillez entrez votre email";
                } else {
                    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/", $email)) {
                        echo "<p style='color:red;font-size: 10px;'>L'adresse e-mail n'est pas valide</p>";
                    }
                }
            }
            ?>
            <div class="input-group">
                <label for="pays">Pays/Region</label>
                <select id="pays" name="pays">
                    <option disabled selected>Choisissez votre pays ou region </option>
                    <script src="../JS/listePays.js"></script>
                </select>
            </div>
            <?php
            if (isset($_POST["bouton"])) {
                if ((!isset($_POST["pays"]) || $_POST["pays"] === "")) {
                    echo "<p style='color:red;font-size: 10px;' >Veuillez sélectionner un pays";
                }
            }
            ?>
            <div class="input-group">
                <label for="tel">Telephone</label>
                <input type="tel" id="tel" name="tel" placeholder="eg. +XX XXXXXXXXXX">
            </div>
            <?php
            if (isset($_POST["bouton"])) {
                if (empty($tel)) {
                    echo "<p style='color:red;font-size: 10px;' >Veuillez entrez votre numéro de téléphone";
                } else { // je vérifie si le numéro de téléphone est au bon format
                    if (!preg_match("/^\+[0-9]{1,4} [0-9]{4,14}(?:x.+)?$/", $tel)) {
                        echo "<p style='color:red;font-size: 10px;'>Le format du numéro de téléphone est invalide.</p>";
                    }
                }
            }
            ?>
            <div class="input-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" placeholder="eg. X8df!90EO">
            </div>
            <?php
            if (isset($_POST["bouton"])) {
                if (empty($mdp)) {
                    echo "<p style='color:red;font-size: 10px;'>Veuillez entrez un mot de passe";
                } elseif (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()-_+=?<>])[a-zA-Z0-9!@#$%^&*()-_+=?<>]{10,}$/', $mdp)) {
                    echo "<p style='color:red;font-size: 10px;'>Le mot de passe doit contenir au moins 10 caractères, dont au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial parmi !@#$%^&*()-_+=?<>.</p>";
                }
            }
            ?>
            <div class="input-group">
                <label for="confirm-mdp">Confirmation mot de passe</label>
                <input type="password" name="confirm_mdp" placeholder="eg. X8df!90EO">
            </div>
            <?php
            if (isset($_POST["bouton"])) {
                if (empty($confirm_mdp)) {
                    echo "<p style='color:red;font-size: 10px;'>Veuillez confirmer le mot de passe";
                } else {
                    if ($mdp !== $confirm_mdp) {
                        echo "<p style='color:red;font-size:10px;'>La confirmation du mot de passe n'est pas conforme au mot de passe entré";
                    }
                }
            }
            ?>
            <button type="submit" value="Inscription" name="bouton">Inscription</button>
        </form>
        <p>Already a member? <a href="Connexion.php">Connexion</a></p>
    </div><br><br>
    <?php
    include("footer.php");
    ?>
</body>

</html>