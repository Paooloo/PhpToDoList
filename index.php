<!DOCTYPE html>
<html>
<head lang="fr">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="vues/style_index.css">
    <script type="text/javascript" src="vues/script.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
	<title>ToDoList</title>

</head>
<body>

<div id="container-gauche">
    <div id="utilisateur">
        <div class="avatar">
            <img src="https://i.imgur.com/p9fj5Wn.png" alt="Avatar"/>
        </div>

        <div class="welcome">
            <span>Bienvenue</span>
            <br/>

            <?php
            /*
             * Gérer l'authentification
             */

            session_start();
            if (isset($_SESSION["idUser"])){
                $id = $_SESSION["idUser"];
                $name = $_SESSION["pseudo"];
                echo "$name <br>";
                echo '<form method="post" action="./controleur/CtrlUser.php">
                       <input type="submit" id="button" value="Deconnexion" name="deconnexion"></form>';
            }else{
                echo '<form method="post" action="vues/logsign.php"><input type="submit" id="button" value="Se connecter"></form>';
            }
            ?>

        </div>
        <div class="logout">
            <a href=""><img src="" alt="Logout"/></a>
        </div>
    </div>
    <div id="lists-names">
        <form method="post" action="controleur/listcontroller.php">

            <div><input class="input2" type="text" name="nomliste" placeholder="Nouvelle liste..." /></div>
            <div><input type="submit" name="addList" class="button addL" value="Ajouter Liste"/></div>
            <div id="lists-container">

                <?php
                /*
                 * Affichage des listes
                 */
                    include("controleur/frontcontroler.php");
                    frontcontroler::bonsoir(1);
                ?>

            </div>
        </form>

    </div>

</div>
<div id="main-content">
    <header>
        <div class="list-name">
            <h1 id="nomListActive"><?php
                /*
                 * Affichage le nom des listes
                 */
                    echo $_SESSION['listename'];
                ?></h1>
        </div>
        <div class="list-actions">
            <form method="post" action="controleur/listcontroller.php">
                <!-- <input id="tesst" type="submit" name="editname" class="button" value="Editer"/> -->
                <input type="submit" name="suppressionListe" class="button red" value="Supprimer Liste"/>
            </form>

        </div>
    </header>
    <div id="new-task">
        <form method="post" action="controleur/tachecontroller.php">
            <div id="new-task-form">
                <div><input type="text" name="nomtache" placeholder="Entrer une nouvelle tâche..." /></div>
                <div ><input type="submit" name="action-task-add" class="button" value="Ajouter tâche"/></div>
            </div>
        </form>
    </div>
    <div id="tasks-list-container">
        <form method="post" action="controleur/tachecontroller.php">
            <ul id="tasks-list">
                <!--Insertion ici-->
                <?php
                /*
                 * Affichage des tâches
                 */

                frontcontroler::bonsoir(2);

                ?>
            </ul>
            <div id="tasks-list-actions">
                <input type="submit" name="action-task-todo" class="button" value="Marqué Fait"/>
                <input type="submit" name="action-task-done" class="button" value="Marqué A faire"/>
                <input type="submit" name="action-task-delete" class="button red" value="Supprimer Tache"/>
            </div>
        </form>
    </div>
</div>
</body>
</html>

<?php

