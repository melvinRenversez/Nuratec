<?php 

include("../php/database.php");
include("../php/errorPopup.php");

$query = 'select count(id) from admin_login';
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->fetch();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../assets/admin/css/index.css">

</head>

<body>

<?php if ($result['count(id)'] == 0 ): ?>

    <h1>Creer mon compte</h1>
 <form action="../php/admin/register.php" method="POST">



               <div class="field">
                  <input type="email" placeholder=" " required name="mail">
                  <label for="">Email</label>
               </div>

               <div class="field">
                  <input type="password" placeholder=" " required minlength="8" name="password">
                  <label for="">Mot de passe</label>
               </div>

               <button type="submit">Creer mon compte admin</button>
            </form>

<?php else: ?>


    <h1>Connection</h1>
    <form action="../php/admin/login.php" method="POST">


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

<?php endif; ?>
</body>
</html>