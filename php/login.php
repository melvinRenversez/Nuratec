<?php 

include("./database.php");

$mdp = $_POST["password"];
$mail = $_POST["mail"];




if (!isset($mail) || !isset($mdp)) {
   header("Location: ../pages/logInOut.php?error=emptyFields   ");
   exit();
}


$query = 'select u.id 
from users u 
join credentials c on c.user_id = u.id
where u.mail = :mail and verifyPassword(:password , c.password_hash);
';

$stmt = $db->prepare($query);
$stmt->execute(array(
   ':mail' => $mail,
   ':password' => $mdp
));

$result = $stmt->fetch();

if ($result) {
   session_start();
   $_SESSION["user_id"] = $result["id"];
   header("Location: ../index.php");
   exit();
} else {
   header("Location: ../pages/logInOut.php?error=wrongCredentials");
   exit();
}

