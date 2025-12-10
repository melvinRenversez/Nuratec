<?php 
session_start();
include("../php/database.php");
include("../php/date.php");


$ac = $_POST['ac'];

if (!isset($ac)) {
   header("Location: ../index.php");
   exit();
}

$query = 'SELECT id 
from users
WHERE activation_code = :ac';
$stmt = $db->prepare($query);
$stmt->execute(array(
    ':ac' => $ac
));

$result = $stmt->fetch();

if (!$result) {
   header("Location: ../index.php");
   exit();
}else {
    $query = 'UPDATE users set activated = true WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':id' => $result['id']
    ));
    $_SESSION["popup"] = true;
    header("Location: ../index.php?popup=activationSuccess");
    exit();
}

?>