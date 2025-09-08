<?php
require_once("../constance.php");

$servername = DB_HOST;
$username = DB_USER;
$password = DB_PASSWORD;
$dbname = DB_NAME; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données: " . $conn->connect_error);
}

$name = "admin";
$admin_password = 'krossignol';
$hashed = password_hash($admin_password, PASSWORD_DEFAULT);

$sql = "INSERT INTO `admin`(`nom_utilisateur`, `mot_de_passe`) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt) {
        // Lier les valeurs des paramètres avec les variables
        $stmt->bind_param("ss", $name, $hashed);
        // Exécuter la requête préparée
        if ($stmt->execute()) {
          // L'insertion a réussi
          $result = "Les données ont été ajoutées avec succès à la base de données.";
          echo $result;
        } else {
          // Une erreur s'est produite lors de l'insertion
          $error = "Erreur lors de l'ajout des données : " . $stmt->error;
          echo $error;
        }
    }
?>