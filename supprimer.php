<?php
// Définition des paramètres de connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=coolchat';
$username = 'root';
$password = 'karim34500';

// Options de configuration pour la connexion PDO
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);

try {
    // Établissement de la connexion à la base de données
    $dbh = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // En cas d'erreur, affiche un message d'erreur et arrête l'exécution du script
    die('Error: ' . $e->getMessage());
}
// Vérifier si un identifiant d'inscrit a été passé en paramètre
if (!isset($_GET['id'])) {
    // Si l'identifiant n'a pas été passé en paramètre, rediriger vers la liste des inscrits
    header('Location: compte.php');
    exit;
}

// Récupérer l'identifiant de l'inscrit à modifier
$id = $_GET['id'];

// Vérifier si l'utilisateur existe 
$sql = "SELECT * FROM Inscrit WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':email', $id);
$stmt->execute();
$inscrit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$inscrit) {
    // Sinon
    header('Location: compte.php');
    exit;
}
// Vérifier si le formulaire de confirmation de suppression a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Préparer la requête SQL pour supprimer 
    $sql = "DELETE FROM Inscrit WHERE email = :email";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $id);

    // Exécuter la requête SQL
    $stmt->execute();

    // Redirige
    header('Location: compte.php');
    exit;
}
?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include_once('startsession.php'); ?>
  <link rel="stylesheet" href="./css/supprimer.css">
  <title>Succulent Illustration using HTML and CSS - Coding Torque</title>
</head>

<body>
<header>
    <img src="./image/logoCC.png" class="logo">
  </header>
  <div>
      <h1> Êtes-vous sûr de vouloir nous quitter</h1>

<form method="POST">
  <input type="hidden" name="id" value="<?= $id ?>">
  <input type="submit" value="Oui">
  <input type="submit" value="Non" formaction="index.php">
</form>
  </div>
  <div class="george">
    <div class="shadow"></div>
    <div class="george_flower"></div>
    <div class="george_head">
    <div class="line"></div>
    <div class="cheek"></div>
    <div class="eye"></div>
    <div class="eye"></div>
  </div>
  <div class="pot_top"></div>
  <div class="pot_body"></div>
  <div class="pot_plate"></div>
</div>

</body>
</html>