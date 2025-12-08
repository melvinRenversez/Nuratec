<?php

include("./database.php");

$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$mail = $_POST["mail"];
$telephone = $_POST["telephone"];
$adresse = $_POST["adresse"];
$ville = $_POST["ville"];
$code_postal = $_POST["code_postal"];
$mdp = $_POST["mdp"];
$mdpConf = $_POST["mdpConf"];


echo $nom . " " . $prenom . " " . $mail . " " . $telephone . " " . $adresse . " " . $ville . " " . $code_postal . " " . $mdp . " " . $mdpConf;



if (!isset($nom) || !isset($prenom) || !isset($mail) || !isset($telephone) || !isset($adresse) || !isset($ville) || !isset($code_postal) || !isset($mdp) || !isset($mdpConf)) {
    header("Location: ../pages/logInOut.php?popup=emptyFields   ");
    exit();
}

if ($mdp !== $mdpConf) {
    header("Location: ../pages/logInOut.php?popup=passwordsDontMatch");
    exit();
}


$query = 'insert into users(nom, prenom, mail, telephone, adresse, ville_id, code_postal_id) 
                    values (:nom, :prenom, :mail, :telephone, :adresse, :ville, :code_postal);';

$stmt = $db->prepare($query);
$stmt->execute(array(
    ':nom' => $nom,
    ':prenom' => $prenom,
    ':mail' => $mail,
    ':telephone' => $telephone,
    ':adresse' => $adresse,
    ':ville' => $ville,
    ':code_postal' => $code_postal
));

$user_id = $db->lastInsertId();

echo $user_id;



$query = 'insert into credentials(user_id, password_hash) values (:user_id, hashPassword(:mdp));';
$stmt = $db->prepare($query);
$stmt->execute(array(
    ':user_id' => $user_id,
    ':mdp' => $mdp
));


$_SESSION["popup"] = true;
header("Location: ../pages/logInOut.php?popup=OK");
exit();

?>