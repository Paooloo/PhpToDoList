<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_sign.css ">
    <script type="text/javascript" src="script.js"></script>
    <title>Connexion</title>
</head>
<body>

<h2>Connection / Création De Compte - TODOLIST</h2>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form method="post" action="../controleur/frontcontroller.php">
            <h1>Créez un compte !</h1>
            <input type="text" name="nom" placeholder="Nom" required/>
            <input type="text" name="prenom" placeholder="Prénom" required/>
            <input type="text" name="naissance" placeholder="Date de naissance" />
            <input type="email" name="email" placeholder="Email" required/>
            <input type="password" name="password" placeholder="Password" minlength="8" required/>
            <input type="submit" id="button" value="S'inscrire">
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form method="post" action="../controleur/CtrlUser.php">
                <h1>Se Connecter</h1>
            <span>avec vos identifiants</span>
            <input type="email" name="conemail" placeholder="Email" required/>
            <input type="password" name="conpassword" placeholder="Mot de passe" minlength="8" required/>
            <input type="submit" id="button" value="Connexion">
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Vous avez un compte ?</h1>
                <p>Saisissez vos informations pour vous connecter à votre compte TODOLIST</p>
                <button class="ghost" id="signIn" onclick="logF()">Se connecter</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Vous n'avez pas de compte ?</h1>
                <p>Créez un compte pour rejoindre notre site TODOLIST</p>
                <button class="ghost" id="signUp" onclick="signF()">S'inscrire</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php