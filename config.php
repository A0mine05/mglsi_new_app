<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mglsi_news";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion failed : " . $conn->connect_error);
}
?>
