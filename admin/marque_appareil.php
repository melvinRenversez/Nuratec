<?php
session_start();
include("../php/admin/verifyUser.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../assets/admin/css/nav.css">
</head>
<body>



<nav>

<ul>

    <li><a href="./home.php">Home</a></li>
    <li><a href="./type_appareil.php">Type d'appareil</a></li>
    <li class='actif'><a href="./marque_appareil.php">Marque d'appareil</a></li>
    <li><a href="./modele_appareil.php">Modele d'appareil</a></li>
    <li><a href="./prise_en_charge.php">Prise en charge</a></li>
    <li><a href="./reparations.php">Reparations</a></li>

    <div class="gap"></div>

    <li><a href="../php/logout.php">Deconnection</a></li>
</ul>

</nav>


<div class="content">


</div>
    
</body>
</html>