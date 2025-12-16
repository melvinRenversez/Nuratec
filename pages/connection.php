<?php 

include("../php/database.php");
include("../php/popup.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
    <link rel="stylesheet" href="../assets/css/insconn.css">

</head>

<body>
    <div class="container">

        <div class="right">

            
            <h3>Connexion</h3>
            <form action="../php/login.php" method="POST">
                <a href="./inscription.php">Vous n'avez pas de compte ?</a>

                <div class="field">
                    <input type="email" placeholder=" " required name="mail">
                    <label for="">Email</label>
                </div>

                <div class="field">
                    <input type="password" placeholder=" " required minlength="8" name="password">
                    <label for="">Mot de passe</label>
                </div>

                <button type="submit">Connexion</button>
            </form>

        </div>

    </div>
</body>

</html>