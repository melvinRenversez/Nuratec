<?php

if (isset($_GET["popup"])) {
   if (isset($_GET["popup"]) && $_GET["popup"] == "emptyFields") {
      echo "<div class='popup'>Veuillez remplir tous les champs</div>";
   } else if (isset($_GET["popup"]) && $_GET["popup"] == "passwordsDontMatch") {
      echo "<div class='popup'>Les mots de passe ne correspondent pas</div>";
   } else if (isset($_GET["popup"]) && $_GET["popup"] == "emailAlreadyExists") {
      echo "<div class='popup'>Cet email est deja utilise</div>";
   } else if (isset($_GET["popup"]) && $_GET["popup"] == "phoneAlreadyExists") {
      echo "<div class='popup'>Ce numero de telephone est deja utilise</div>";
   } else if (isset($_GET["popup"]) && $_GET["popup"] == "OK") {
      echo "<div class='popup'>Inscription reussie</div>";
   } else if (isset($_GET["popup"]) && $_GET["popup"] == "OKconn") {
      echo "<div class='popup'>Connection reussie</div>";
   }else if (isset($_GET["popup"]) && $_GET["popup"] == "wrongCredentials") {
      echo "<div class='popup'>Email ou mot de passe incorrect</div>";
   }else if (isset($_GET["popup"]) && $_GET["popup"] == "successSendReparation") {
      echo "<div class='popup'>Votre demande de reparation a bien ete envoyee</div>";
   }else if (isset($_GET["popup"]) && $_GET["popup"] == "errorSendReparation") {
      echo "<div class='popup'>Une erreur est survenue lors de l'envoi de votre demande de reparation</div>";
   }
}

?>