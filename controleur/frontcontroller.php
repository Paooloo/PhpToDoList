<?php
session_start();

require_once('../modeles/GatewayUtilisateur.php');
require_once('../modeles/Utilisateur.php');
require_once('../modeles/Connection.php');

$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";



