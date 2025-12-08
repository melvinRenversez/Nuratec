<?php 

$mail = $_POST["mail"];
$passwordInput = $_POST["password"];


if (!isset($mail) || !isset($passwordInput)) {
    header("Location: ../../admin/index.php?error=emptyFields");
    exit();
}

include("../database.php");

$query = "select id from admin_login where mail = :mail and verifyPassword(:password, password)";
$stmt = $db->prepare($query);
$stmt->execute(array(
    ':mail' => $mail,
    ':password' => $passwordInput
));

$result = $stmt->fetch();


$_SESSION["popup"] = true;
if ($result['id']) {
    session_start();
    $_SESSION['admin_id'] = $result['id'];
    header("Location: ../../admin/home.php");
    exit();
}else {
    header("Location: ../../admin/index.php?error=wrongCredentials");
    exit();
}