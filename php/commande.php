<?php
include("header.php");
if (isset($_SESSION["id_client"])) {
    // Fontion de prévérification de la carte bancaire
    function Luhn($numero, $longueur)
    {
        // On passe à la fonction la variable contenant le numéro à vérifier
        // et la longueur qu'il doit impérativement avoir

        if ((strlen($numero) == $longueur) && preg_match(
            "#[0-9]{" . $longueur . "}#i",
            $numero
        )) {
            // si la longueur est bonne et que l'on n'a que des chiffres

            /* on décompose le numéro dans un tableau  */
            for ($i = 0; $i < $longueur; $i++) {
                $tableauChiffresNumero[$i] = substr($numero, $i, 1);
            }

            /* on parcours le tableau pour additionner les chiffres */
            $luhn = 0; // clef de luhn à tester
            for ($i = 0; $i < $longueur; $i++) {
                if ($i % 2 == 0) { // si le rang est pair (0,2,4 etc.)
                    if (($tableauChiffresNumero[$i] * 2) > 9) {
                        // On regarde si son double est > à 9
                        $tableauChiffresNumero[$i] = ($tableauChiffresNumero[$i] * 2) - 9;
                        //si oui on lui retire 9
                        // et on remplace la valeur
                        // par ce double corrigé
                    } else {

                        $tableauChiffresNumero[$i] = $tableauChiffresNumero[$i] * 2;
                        // si non on remplace la valeur
                        // par le double
                    }
                }
                $luhn = $luhn + $tableauChiffresNumero[$i];
                // on additionne le chiffre à la clef de luhn
            }

            /* test de la divition par 10 */
            if ($luhn % 10 == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
            // la valeur fournie n'est pas conforme (caractère non numérique ou mauvaise
            // longueur)
        }
    }
    // je verifie si les informations de la carte sont soumises 
    if (isset($_POST["livrer"])) {
        // je recupere le numero de la carte  pour verifier si le numero de la carte est valide
        $numero = $_POST["cardNumber"];
        // je donne la longueur d'un numéro de carte
        $longueur = 16;

        //je recupere la date de la carte  pour verifier si elle est valide
        $dateExpiration = $_POST["dateExpiration"];
        // je verifie d'abord si la date est au format MM/AA avec une regex
        if (preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $dateExpiration, $matches)) {
            // j'extrais le mois et l'année de la date d'expiration à partir des résultats de la correspondance de l'expression régulière stockés dans le tableau $matches. Ils seront convertis en entiers avec la fonction intval().
            $moisExpiration = intval($matches[1]);
            $anneeExpiration = intval('20' . $matches[2]);
            // je récupère maintenat  la date actuelle en créant un nouvel objet DateTime avec la date actuelle, puis j'extraient l'année et le mois de cette date actuelle comme précédemment.
            $dateActuelle = new DateTime();
            $anneeActuelle = intval($dateActuelle->format('Y'));
            $moisActuel = intval($dateActuelle->format('m'));
        }
        //je recupere le CCV de la carte  pour verifier si il est valide
        $cvv = $_POST["cvv"];
        // Récupération des informations du formulaire 
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $tel = $_POST["tel"];
        $adresse = $_POST["adresse"];
        $ville = $_POST["ville"];
        $codePostal = $_POST["codePostal"];

        // je mets les informations du formulaire dans une session aussi pour l'afficher l'inserer dans la table hist_commande dans la page valider.php 
        $_SESSION["nom"]=$nom;
        $_SESSION["prenom"]=$prenom ;
        $_SESSION["tel"]=$tel ;
        $_SESSION["adresse"]=$adresse;
        $_SESSION["ville"]=$ville;
        $_SESSION["codePostal"]= $codePostal;

    }
} else {
    header("location:connexion.php?Veuillez vous connectez pour passer une commande");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/81e489c8c5.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    // si j'appuie sur le bouton livrer je veux que la personne puisse confirmer effectivement qu'il veux passer sa commande 
    if (isset($_POST["livrer"])) {
        // j'initialise cette variable a true 
        $informations_correctes = true;
        // je verifie si tous les informations du formulaire sont bonnes 
        if (empty($numero) || !Luhn($numero, $longueur)) {
            $informations_correctes = false;
        }
        if (empty($dateExpiration) || !preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $dateExpiration, $matches) || ($anneeExpiration <= $anneeActuelle && !($anneeExpiration == $anneeActuelle && $moisExpiration >= $moisActuel))) {
            $informations_correctes = false;
        }
        if (empty($cvv) || (strlen($cvv) !== 3 && strlen($cvv) !== 4)) {
            $informations_correctes = false;
        }
        if (empty($nom) || empty($prenom) || empty($tel) || empty($adresse) || empty($ville) || empty($codePostal) || !preg_match("/^\+[0-9]{1,3} [0-9]{4,14}(?:x.+)?$/", $tel)) {
            $informations_correctes = false;
        }

        // Afficher la div de validation si toutes les informations sont correctes
        if ($informations_correctes) {
    ?>
            <div class="validement">
                <form action="valider.php" method="post">
                    <p>Êtes-vous sûr de vouloir validé votre commande?</p>
                    <button type="submit" name="valider">Valider</button>
                    <button type="Submit" name="annuler">Annuler</button>
                </form>
            </div>
    <?php
        }
    }
    ?>
    <div class="payement">
        <div class="logo">
            <img src="../img/booktop_logo_uploaded_transparent.png" alt="">
        </div>
        <div class="carte">
            <h2><i><b>Passer votre commande</b></i></h2>
            <form method="post">
                <fieldset>
                    <legend>Ajouter une carte de crédit ou de débit</legend>
                    <label for="cardNumber">Numéro de carte :</label>
                    <input type="text" id="cardNumber" name="cardNumber" placeholder="1234567890123456">
                    <?php
                    if (isset($_POST["livrer"])) {
                        if (empty($numero)) {
                            echo "<p style='color:red'>Veuillez entrez le numero de votre carte de credit";
                        } else {
                            // j'appelle la fonction luhn pour verifier si le numéro de la carte est valide 
                            if (Luhn($numero, $longueur)) {
                                echo "<p style='color:green'>Votre numéro de carte '$numero' est valide</p>";
                            } else {
                                echo "<p style='color:red'>Votre numéro de carte n'est pas valide</p>";
                            }
                        }
                    }
                    ?>
                    <label for="dateExpiration">Date d'expiration :</label>
                    <input type="text" id="dateExpiration" name="dateExpiration" placeholder="MM/AA">
                    <?php
                    if (isset($_POST["livrer"])) {
                        if (empty($dateExpiration)) {
                            echo "<p style='color:red'>Veuillez entrez la date d'expiration";
                        } else {
                            if (preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $dateExpiration, $matches)) {
                                // je vérifie maintenant  si l'année d'expiration est postérieure à l'année actuelle OU si l'année d'expiration est la même que l'année actuelle et si le mois d'expiration est supérieur ou égal au mois actuel. Cela garantit que la carte est valide jusqu'à la fin du mois d'expiration.
                                if ($anneeExpiration > $anneeActuelle || ($anneeExpiration == $anneeActuelle && $moisExpiration >= $moisActuel)) {
                                    echo "<p style='color:green'>La date d'expiration '$dateExpiration' est valide</p>";
                                } else {
                                    echo "<p style='color:red'>La date d'expiration est invalide</p>";
                                }
                            } else {
                                $mauvaisFormat = "<p style='color:red'>Format de date d'expiration invalide. Utilisez MM/AA.</p>";
                                echo "<p style='color:red'>Format de date d'expiration invalide. Utilisez MM/AA.</p>";
                            }
                        }
                    }
                    ?>

                    <label for="cvv">CVV :</label>
                    <input type="text" id="cvv" name="cvv" placeholder="123">
                    <?php
                    if (isset($_POST["livrer"])) {
                        if (empty($cvv)) {
                            echo "<p style='color:red'>Veuillez entrez le cvv ecrit sur votre carte";
                        } else {
                            // je verifie  si la longueur du CCV est correcte (3 ou 4 chiffres selon la carte)
                            if (strlen($cvv) === 3 || strlen($cvv) === 4) {
                                echo "<p style='color:green'> Le CVV '$cvv' est valide</p>";
                            } else {
                                echo "<p style='color:red'>CVV invalide</p>";
                            }
                        }
                    }
                    ?>
                </fieldset>
                <fieldset>
                    <legend>Adresse de livraison</legend>
                    <label for="nom">Nom*</label>
                    <input type="text" id="nom" name="nom" placeholder="Votre nom" value="<?php if (isset($_SESSION["id_client"])) {
                                                                                                echo "$_SESSION[nom]";
                                                                                            } ?>"><br>
                    <?php
                    if (isset($_POST["livrer"])) {
                        // je verifie que le champs nom  n'est pas vide 
                        if (empty($nom)) {
                            echo "<p style='color:red'>Veuillez entrez votre nom";
                        } else {
                            echo "<p style='color:green'>Le nom '$nom' est valide</p>";
                        }
                    }
                    ?>
                    <label for="prenom">Prénom*</label>
                    <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" value="<?php if (isset($_SESSION["id_client"])) {
                                                                                                        echo "$_SESSION[prenom]";
                                                                                                    } ?>"><br>
                    <?php
                    if (isset($_POST["livrer"])) {
                        // je verifie que le champs nom  n'est pas vide 
                        if (empty($prenom)) {
                            echo "<p style='color:red'>Veuillez entrez votre prenom";
                        } else {
                            echo "<p style='color:green'>Le prenom '$prenom' est valide</p>";
                        }
                    }
                    ?>
                    <label for="tel">Numero de téléphone*</label>
                    <input type="tel" id="tel" name="tel" placeholder="Votre numéro de téléphone" value="<?php if (isset($_SESSION["id_client"])) {
                                                                                                                echo "$_SESSION[tel]";
                                                                                                            } ?>"><br>
                    <?php
                    if (isset($_POST["livrer"])) {
                        // je verifie que le champs tel  n'est pas vide 
                        if (empty($tel)) {
                            echo "<p style='color:red'>Veuillez entrez votre numéro de téléphone";
                        } else {
                            // je vérifie si le numéro de téléphone est au bon format
                            if (!preg_match("/^\+[0-9]{1,3} [0-9]{4,14}(?:x.+)?$/", $tel)) {
                                echo "<p style='color:red'>Le format du numéro de téléphone est invalide.</p>";
                            } else {
                                echo "<p style='color:green'>Le numéro de téléphone '$tel' est valide</p>";
                            }
                        }
                    }
                    ?>
                    <label for="adresse">Adresse*</label>
                    <input type="text" id="adresse" name="adresse" placeholder="Ex: 123 rue de la République"><br>
                    <?php
                    if (isset($_POST["livrer"])) {
                        // je verifie que le champs adresse  n'est pas vide 
                        if (empty($adresse)) {
                            echo "<p style='color:red'>Veuillez entrez votre adresse</p>";
                        } else {
                            echo "<p style='color:green'>Votre adresse '$adresse' est valide</p>";
                        }
                    }
                    ?>
                    <label for="ville">Ville*</label>
                    <input type="text" id="ville" name="ville" placeholder="Ex: Paris"><br>
                    <?php
                    if (isset($_POST["livrer"])) {
                        // je verifie que le champs ville  n'est pas vide 
                        if (empty($ville)) {
                            echo "<p style='color:red'>Veuillez entrez la ville</p>";
                        } else {
                            echo "<p style='color:green'>Votre ville '$ville' est valide</p>";
                        }
                    }
                    ?>
                    <label for="codePostal">Code postal*</label>
                    <input type="text" id="codePostal" name="codePostal" placeholder="Ex: 75000"><br>
                    <?php
                    if (isset($_POST["livrer"])) {
                        // je verifie que le champs codePostal  n'est pas vide 
                        if (empty($codePostal)) {
                            echo "<p style='color:red'>Veuillez entrez votre le code postal de la ville";
                        } else {
                            echo "<p style='color:green'>Votre code postal '$codePostal' est valide</p>";
                        }
                    }
                    ?>
                    <!-- je veux utiliser une API pour afficher plusieurs pays dans ma liste deroulante      -->

                </fieldset>
                <button type="submit" name="livrer">Valider ma commande</button>
            </form>
        </div>
    </div>
    <?php
    include("footer.php");

    ?>
</body>

</html>