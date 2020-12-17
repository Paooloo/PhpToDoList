<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_error.css">
    <title>Erreur</title>
</head>
<body>
    <div id="clouds">
        <div class="cloud x1"></div>
        <div class="cloud x1_5"></div>
        <div class="cloud x2"></div>
        <div class="cloud x3"></div>
        <div class="cloud x4"></div>
        <div class="cloud x5"></div>
    </div>
    <div class='c'>
        <div class='erreur'>Erreur</div>
        <hr>
        <div class='_1'>NOM ERREUR</div>
        <div class='_2'><?php session_start();

        echo $_SESSION['erreur'] ?></div>
        <a class='btn' href='../index.php'>RETOUR ACCUEIL</a>
    </div>
</body>
</html>

<?php
