<?php

include("./database.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

session_start();

$length = 255;

$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$user_mail = $_POST["mail"];
$telephone = $_POST["telephone"];
$adresse = $_POST["adresse"];
$ville = $_POST["ville"];
$code_postal = $_POST["code_postal"];
$mdp = $_POST["mdp"];
$mdpConf = $_POST["mdpConf"];

if (!$nom || !$prenom || !$user_mail || !$telephone || !$adresse || !$ville || !$code_postal || !$mdp || !$mdpConf) {
    header("Location: ../pages/logInOut.php?popup=emptyFields");
    exit();
}

if ($mdp !== $mdpConf) {
    header("Location: ../pages/logInOut.php?popup=passwordsDontMatch");
    exit();
}

$query = "SELECT id FROM users WHERE mail = :mail";
$stmt = $db->prepare($query);
$stmt->execute([":mail" => $user_mail]);

if ($stmt->rowCount() > 0) {
    header("Location: ../pages/logInOut.php?popup=mailExists");
    exit();
}

$url_activation = bin2hex(random_bytes($length / 2));

$query = 'INSERT INTO users(nom, prenom, mail, telephone, adresse, ville_id, code_postal_id, activation_code)
          VALUES (:nom, :prenom, :mail, :telephone, :adresse, :ville, :code_postal, :activation_code)';
$stmt = $db->prepare($query);
$stmt->execute([
    ':nom' => $nom,
    ':prenom' => $prenom,
    ':mail' => $user_mail,
    ':telephone' => $telephone,
    ':adresse' => $adresse,
    ':ville' => $ville,
    ':code_postal' => $code_postal,
    ':activation_code' => $url_activation
]);

$user_id = $db->lastInsertId();

$query = 'INSERT INTO credentials(user_id, password_hash) VALUES (:user_id, hashPassword(:password_hash))';
$stmt = $db->prepare($query);
$stmt->execute([
    ':user_id' => $user_id,
    ':password_hash' => $mdp
]);

if ($stmt->rowCount() == 0) {
    header("Location: ../pages/logInOut.php?popup=registerFailed");
    exit();
}




$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = '127.0.0.1';           // Ton serveur SMTP local
    $mail->SMTPAuth = true;
    $mail->Username = 'serveur@mondomaine.com';
    $mail->Password = 'motdepasse';
    $mail->SMTPSecure = false;           // Pas de SSL pour local
    $mail->Port = 25;                     // Port SMTP local

    $mail->setFrom('serveur@mondomaine.com', 'Serveur Local');
    $mail->addAddress($user_mail);

    $mail->isHTML(false);
    $mail->Subject = 'Activation de votre compte';
    $mail->Body = '
    <p>Bonjour,</p>
    <p>Veuillez cliquer sur le bouton ci-dessous pour activer votre compte :</p>
    <p>
        <a href="http://localhost/ProjetWeb/pages/logInOut.php?activation=' . $url_activation . '" 
           style="
               display: inline-block;
               padding: 10px 20px;
               font-size: 16px;
               color: #ffffff;
               background-color: #007BFF;
               text-decoration: none;
               border-radius: 5px;
           ">
           Activer mon compte
        </a>
    </p>
';
    $mail->send();
    echo 'Mail envoyé avec succès !';

} catch (Exception $e) {
    echo "Erreur : {$mail->ErrorInfo}";
}







$_SESSION["popup"] = true;
header("Location: ../index.php?popup=registerSuccess");
exit();

?>
