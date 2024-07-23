<?php
include("header.php");
// je me connecte a la base de donnée 
include('connect.php');
// si j'appuie sur le bouton pour envoyez un message 
if (isset($_POST['bouton'])) {
    // je récupère le message écrit par la personne connectée 
    $EnvoyezMessage = mysqli_real_escape_string($id, $_POST["EnvoyezMessage"]);
    // je lance une requette pour insérer le message dans la table message 
    $requette4 = "INSERT into messages (contenu,id_user_recu,id_client,date) values ('$EnvoyezMessage','{$_GET['userId']}','{$_SESSION['id_client']}',now())";
    $execute = mysqli_query($id, $requette4);
    header("Refresh:1");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/discussion.css">
    <script src="https://kit.fontawesome.com/81e489c8c5.js" crossorigin="anonymous"></script>
</head>

<body><br><br><br><br>
    <div class="contain">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">
                    <!-- voici la div pour regarder la liste des contacts avec qui la personne connecté a écrit  -->
                    <div id="plist" class="people-list" style=" <?php echo isset($_GET['userId']) ? 'width: 280px; text-align: center;overflow-y: scroll;height:490px;' : 'width: 500px;overflow-y: scroll;height:490px;' ?>">
                        <p>
                            <!-- j'affiche le nom et le prenom de la personne connecté -->
                            <?php echo "<strong><i>" . $_SESSION["nom"] . "</i></strong>" . " " . "<strong><i>" . $_SESSION["prenom"] . "</a>"; ?>
                        </p>
                        <div class="input-group">
                            <p>Contacts</p>
                        </div>
                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            <?php
                            // si la personne est connecté donc si il a son id_client je le mets dans une variable id_client
                                if (isset($_SESSION['id_client'])) {
                                $id_client = $_SESSION['id_client'];
                            }
                            // je lance une requette pour récupérer  les utilisateurs avec qui  la personne connecter a déja ecrite 
                            $requette ="SELECT messages.*, client.* FROM messages JOIN client ON messages.id_user_recu = client.id_client WHERE messages.id_client =$id_client  GROUP BY messages.id_user_recu";
                            // j'execute maintenant cette requette 
                            $execute = mysqli_query($id, $requette);
                            // tant que je peux afficher une ligne de la requette 
                            while ($ligne = mysqli_fetch_assoc($execute)) {
                                // je récupère l'email et l'identifiant de chaque personne 
                                $email = $ligne["email"];
                                // je mets userId a la place de id_client pour ne pas confondre les id quand je vais les mettres dans une session 
                                $userId  = $ligne["id_client"];
                                $nom = $ligne['nom'];
                                $prenom = $ligne['prenom'];
                            ?>
                                <li class='clearfix'>
                                    <div class="cote">
                                        <div class="icon"><?= strtoupper(substr($ligne["nom"], 0, 1)) ?></div>
                                        <a href="?userId=<?= $userId ?>">
                                            <div class='about'>
                                                <!-- j'affiche le nom et le prenom de ceux qui sont connecté -->
                                                <div class='name'><?= $nom ?> <?= $prenom ?></div>
                                                <?php
                                                // je vérifie si la longueur de l'email dépasse 10 caractères et ajuster l'affichage
                                                $displayEmail = strlen($email) > 15 ? substr($email, 0, 15) . "..." : $email;
                                                echo "<div class='status'>" . $displayEmail . " </div>";
                                                ?>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>

                        </ul>
                    </div>
                    <?php
                    if (isset($_GET["userId"])) {
                    ?>
                        <!-- voici la div pour afficher le nom de la personne a qui on veut envoyer le message  -->
                        <div class="chat">
                            <div class="chat-header clearfix">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <img src="https://static.vecteezy.com/system/resources/previews/019/879/198/non_2x/user-icon-on-transparent-background-free-png.png" alt="avatar">
                                        <div class="chat-about">
                                            <?php
                                            // quand de l'utilisateur sur lequel je clique existe 
                                            if (isset($_GET['userId'])) {
                                                // je lance une requette 
                                                $requette1 = "select * from client where id_client= '$_GET[userId]'";
                                                // j'execute la requette 
                                                $execute1 = mysqli_query($id, $requette1);
                                                while ($ligne1 = mysqli_fetch_assoc($execute1)) {
                                                    echo " <h6 class='m-b-0'>" . $ligne1['nom'] . " " . $ligne1['prenom'] . "</h6>
                                       <small>" . $ligne1['email'] . "</small>";
                                                }
                                            }
                                            ?>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- voici la div pour afficher les messages envoyés a une personne   -->
                            <div class="chat-history" style="height: 300px;   overflow-y: scroll;">
                                <ul class="m-b-0">
                                    <?php
                                    if (isset($_GET['userId'])) {
                                        // je lance ue requette pour récuperer les messages entre celui qui est connecté et celui sur qui il clique 
                                        $requette3 = "SELECT * FROM messages WHERE (id_user_recu =$_GET[userId] AND id_client =$_SESSION[id_client]) OR (id_user_recu =$_SESSION[id_client] AND id_client =  $_GET[userId]) ORDER BY date ";
                                        // j'execute la requette 
                                        $execute3 = mysqli_query($id, $requette3);
                                        // tant que je peux récupérer uen ligne de la requette 
                                        while ($ligne3 = mysqli_fetch_assoc($execute3)) {
                                            // je récupère le message a envoyer que je mets dans une variable 
                                            $contenu = $ligne3["contenu"];
                                            // si l'id de celui qui est connecter correspond a l'id de celui qui a envoyer le message (id_client) alors on mets le message a droite  
                                            if ($ligne3["id_client"] == $_SESSION['id_client']) {
                                                echo " <div  class='messageRecu'> $contenu </div>";
                                            }
                                            // dans le cas contraire on mets le message a gauche 
                                            else {
                                                echo "<div class='messageEnvoyez'>$contenu</div>";
                                            }
                                        }
                                    }
                                    ?>


                                </ul>
                            </div>
                            <!-- voici la div où on peut entrer des messages  -->
                            <div class="chat-message clearfix">
                                <form action="" method="post">
                                    <div class="input-group mb-0">
                                        <input type="text" name="EnvoyezMessage" class="form-control" placeholder="Envoyez un message ici...">
                                        <div class="input-group-prepend">
                                            <button type="submit" name="bouton" class="btn btn-lg"><span class="input-group-text"><i class="fa fa-send"></i></span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div style="margin-left: 570px;margin-top: 30px; ">
                            <a href="index.php<?php if (isset($_SESSION['id_client'])) {
                                                    echo "?identifiant=$_SESSION[id_client]";
                                                } ?>"><img src="../img/booktop_logo_uploaded_transparent.png" style="width: 500px;"></a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("index.php");
    include("footer.php");
    ?>
</body>

</html>