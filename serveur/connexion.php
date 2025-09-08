<?php
require_once("../constance.php");

error_reporting(E_ALL);
ini_set("display_errors", 1);

$servername = DB_HOST;
$username = DB_USER;
$password = DB_PASSWORD;
$dbname = DB_NAME; // Remplacez par le nom de votre base de données

// Créer une nouvelle connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données: " . $conn->connect_error);
}

session_start();

// Vérification des informations d'identification lors de la soumission du formulaire
if (isset($_POST['submit']) && isset($_POST['nom_utilisateur']) && isset($_POST['mot_de_passe'])) {
    // Récupération des données du formulaire
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Requête préparée pour récupérer l'utilisateur (SANS vérifier le mot de passe dans SQL)
    $sql = "SELECT nom_utilisateur, mot_de_passe FROM admin WHERE nom_utilisateur=?";
    $stmt = $conn->prepare($sql);
    
    // Vérifier si la préparation de la requête a réussi
    if ($stmt) {
        // Lier les valeurs des paramètres avec les variables
        $stmt->bind_param("s", $nom_utilisateur);
        
        // Exécuter la requête préparée
        if ($stmt->execute()) {
            // Récupérer le résultat de la requête
            $result = $stmt->get_result();
            
            // Vérifier si l'utilisateur existe dans la base de données
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                
                // Vérifier le mot de passe avec bcrypt
                if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
                    // Mot de passe correct, démarrer une session pour l'utilisateur
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $user['name'];
                    
                    // Redirection vers la page dashboard
                    header("Location: dashboard.php");
                    exit();
                } else {
                    // Mot de passe incorrect
                    echo "Nom d'utilisateur ou mot de passe incorrect.";
                }
            } else {
                // Utilisateur non trouvé
                echo "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } else {
            // Une erreur s'est produite lors de l'exécution de la requête
            echo "Erreur lors de l'exécution de la requête : " . $stmt->error;
        }
    } else {
        // Une erreur s'est produite lors de la préparation de la requête
        echo "Erreur de préparation de la requête : " . $conn->error;
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
