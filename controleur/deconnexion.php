<?php
session_start();
//$_SESSION["idUser"] = NULL;
//$_SESSION["pseudo"]= "";

//session_unset();
session_destroy();
$_SESSION = array();

header('Location: ../index.php');