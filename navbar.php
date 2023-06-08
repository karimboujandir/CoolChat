<div id="header">
  <img src="./image/logoCC.png" class="logo">
  <nav>
    <ul>
      <li>
        <a href="accueil.php">Accueil</a>
      </li>
      <li>
        <a href="chat.php">Messagerie</a>
      </li>
      <li>
        <a href="compte.php?id=<?php echo isset($_SESSION['user']['ID']) ? $_SESSION['user']['ID'] : ''; ?>">Profil</a>
      </li>
      <li>
        <a href="logout.php">Deconnexion</a>
      </li>
</div>