<?php 

$mail = $_POST["mail"];
$passwordInput = $_POST["password"];


if (!isset($mail) || !isset($passwordInput)) {
    header("Location: ../../admin/index.php?error=emptyFields");
    exit();
}

include("../database.php");

$query = "insert into admin_login (mail, password) values (:mail, hashPassword(:password))";
$stmt = $db->prepare($query);
$stmt->execute(array(
    ':mail' => $mail,
    ':password' => $passwordInput
));

header("Location: ../../admin/index.php?error=OK");
exit();