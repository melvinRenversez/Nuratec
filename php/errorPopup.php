<?php

if (isset($_GET["error"])) {
   if (isset($_GET["error"]) && $_GET["error"] == "emptyFields") {
      echo "<div class='popup'>Veuillez remplir tous les champs</div>";
   } else if (isset($_GET["error"]) && $_GET["error"] == "passwordsDontMatch") {
      echo "<div class='popup'>Les mots de passe ne correspondent pas</div>";
   } else if (isset($_GET["error"]) && $_GET["error"] == "emailAlreadyExists") {
      echo "<div class='popup'>Cet email est deja utilise</div>";
   } else if (isset($_GET["error"]) && $_GET["error"] == "phoneAlreadyExists") {
      echo "<div class='popup'>Ce numero de telephone est deja utilise</div>";
   } else if (isset($_GET["error"]) && $_GET["error"] == "OK") {
      echo "<div class='popup'>Inscription reussie</div>";
   } else if (isset($_GET["error"]) && $_GET["error"] == "OKconn") {
      echo "<div class='popup'>Connection reussie</div>";
   }else if (isset($_GET["error"]) && $_GET["error"] == "wrongCredentials") {
      echo "<div class='popup'>Email ou mot de passe incorrect</div>";
   }
}

?>