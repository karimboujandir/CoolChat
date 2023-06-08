<?php

if(isset($_POST['message']) && !empty($_POST['message'])) {
    $message = $_POST['message'];
    $file = 'messages.txt';

    // Ouvre le fichier en mode écriture
    $handle = fopen($file, 'a');

    // Écrit le message dans le fichier
    fwrite($handle, $message . PHP_EOL);

    // Ferme le fichier
    fclose($handle);
}