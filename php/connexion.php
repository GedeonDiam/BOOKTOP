<?php
require_once("header.php");
if (isset($_POST["bouton"])) {
    include("connect.php");
    // je ramene également la même fonction pour hacher a nouveau le mot de passe de celui qui veux se connecter afin de comparer ce mot de passe haché a celui dans ma base de donnée 
    function hasherMotDePasse($motDePasse)
    {
        // Utilisation de l'algorithme de hachage MD5
        $motDePasseHash = md5($motDePasse);

        // Retourner le mot de passe hashé
        return $motDePasseHash;
    }
    // je recupere les valeurs provenant du formulaire pour la connexion en 
    $email = mysqli_real_escape_string($id, $_POST["email"]);
    $mdp = mysqli_real_escape_string($id, $_POST["mdp"]);
    // je hashe le mot de passe pour le comparer a celui dans ma base de donnée
    $mdpHash = hasherMotDePasse($mdp);
    // je lance une requette pour recuperer les donnes concernant celui qui veut se connecter  
    if (!empty($email) && !empty($mdp)) {
        $requette = "select * from client where email='$email' and mdp='$mdpHash'";
        // j'execute ma requette 
        $execute = mysqli_query($id, $requette);
        // si le resutat de ma requette donne un resulat je laisse la personne qui veux se connecter entrer dans la page index.php 
        if (mysqli_num_rows($execute) > 0) {
            // j'affiche la ligne du resultat de la requette 
            $ligne = mysqli_fetch_assoc($execute);
            $_SESSION["id_client"] = $ligne["id_client"];
            $_SESSION["prenom"] = $ligne["prenom"];
            $_SESSION["nom"] = $ligne["nom"];
            $_SESSION["tel"] = $ligne["tel"];
            $_SESSION["pays"] = $ligne["pays"];
            header("location:index.php?identifiant=$_SESSION[id_client]");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cd1eb87d27.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/connexion.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>BookTop</title>
</head>

<body>
    <div class="signup-form">
        <h2><i><b>Connexion</b></i></h2>
        <hr>
        <?php
        if (isset($_POST["bouton"])) {
            if (!empty($email) && !empty($mdp)) {
                if (!mysqli_num_rows($execute) > 0) {
                    echo "<p  style='color:red;font-size: 10px;'>Veuillez verifier vos informations de connexion";
                }   
            }
        }
        ?>
        <form action="" method="POST">
            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder=".....@mail.com">
            </div>
            <?php
            if (isset($_POST["bouton"])) {
                if (empty($email)) {
                    echo "<p  style='color:red;font-size: 10px;'>Veuillez entrez votre mail";
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
                    echo "<p  style='color:red;font-size: 10px;'>Veuillez entrez votre mot de passe";
                }
            }
            ?>
            <button type="submit" value="Inscription" name="bouton">Connexion</button>
        </form>
        <p>Not already a member? <a href="identification.php">Inscription</a></p>
    </div><br><br>
    <?php
    include("footer.php");
    ?>


</body>

</html>