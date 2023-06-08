<?php
// On se connecte à MySQL avec PDO
$dsn = 'mysql:host=localhost;dbname=coolchat';
$username = 'root';
$password = 'karim34500';
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
try {
    $dbh = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Error : ' . $e->getMessage());
}

// On vérifie que le formulaire a bien été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // On récupère les données du formulaire
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Hachage du mot de passe
   // $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    // Définition du statut
    $statut = 'actif';

    // On prépare la requête SQL pour insérer les données dans la base de données
    $sql = "INSERT INTO Inscrit (pseudo, password, email) 
            VALUES (:pseudo, :password, :email)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);

    // On exécute la requête SQL
    $stmt->execute();

    // On redirige l'utilisateur vers la page de connexion
    header('Location: accueil.php');
    exit;
}
