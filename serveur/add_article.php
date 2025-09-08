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


if ($conn->connect_error) {
    die("Erreur : " . $conn->connect_error);
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les valeurs des champs du formulaire
        $name = $_POST["name"];
        $massage_description = $_POST["massage_description"];
        $duree_massage = $_POST["duree_massage"];
        $prix = $_POST["prix"];
        $image_path = null;

        // Check if all required fields are provided
        if ($name == null || $massage_description == null || $prix == null || $duree_massage == null) {
            echo 'err';
        } else {
            // File upload handling
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
                $targetDirectory = "../upload/"; // Replace this with your desired directory for storing images
                $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Allow only certain image file formats (you can extend this list if needed)
                if ($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg" && $imageFileType !== "gif") {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    //faire attention au droit du dossier:
                    //sudo chown -R www-data:www-data /var/www/html/site_anaelle/upload
                    //sudo chmod -R 755 /var/www/html/site_anaelle/upload
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                        // The image has been successfully uploaded
                        $image_path = $targetFile;
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                        // Handle the error scenario, e.g., redirect back to the form with an error message
                    }
                }
            }

            // Perform the database insertion
            // Préparer la requête SQL INSERT avec des paramètres sous forme de marqueurs de position (?)
            $sql = "INSERT INTO massages (massage_description, duree_massage, prix, name, image_path) VALUES (?, ?, ?, ?, ?)";

            // Préparer la déclaration de requête
            $stmt = $conn->prepare($sql);

            // Vérifier si la préparation de la requête a réussi
            if ($stmt) {
                // Lier les valeurs des paramètres avec les variables
                $stmt->bind_param("sssss", $massage_description, $duree_massage, $prix, $name, $image_path);
                // Exécuter la requête préparée
                if ($stmt->execute()) {
                    // L'insertion a réussi
                    echo "Les données ont été ajoutées avec succès à la base de données.";
                } else {
                    // Une erreur s'est produite lors de l'insertion
                    echo "Erreur lors de l'ajout des données : " . $stmt->error;
                }

                // Fermer la déclaration de requête
                $stmt->close();
            } else {
                // Une erreur s'est produite lors de la préparation de la requête
                echo "Erreur lors de la préparation de la requête : " . $conn->error;
            }
        }
    }
}
