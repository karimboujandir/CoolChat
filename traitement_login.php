<?php
session_start();

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

// On vérifie l'existence des variables
if (isset($_POST['pseudo']) && isset($_POST['password'])) {
    // On échappe les caractères spéciaux dans les variables
    $pseudo = $dbh->quote($_POST['pseudo']);
    $password = $dbh->quote($_POST['password']);
    // On tente de sélectionner une entrée dans la base de données qui y correspond
    $sql = "SELECT * FROM Inscrit WHERE pseudo = $pseudo AND password = $password";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        error();
    } else {
        // La connexion est réussie, on enregistre le pseudo de l'utilisateur dans une variable de session
        $_SESSION['user'] = $result;
        unset($_SESSION['user']['password']);
        // On redirige l'utilisateur vers la page d'accueil
        header('Location: accueil.php');
        exit;
    }
}

function error()
{
?>
    <font color="red">Erreur : identifiant ou mot de passe incorrect.</font>
<?php
}
?>
