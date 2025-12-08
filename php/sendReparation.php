<?php

session_start();
include("./verifyUser.php");
include("./database.php");


var_dump($_POST);

$user = $_SESSION["user_id"];
$type = $_POST["type"];
$marque = $_POST["marque"];
$model = $_POST["modele"];
$serie = $_POST["serie"];
$imei = $_POST["imei"];
$prise = $priseText = implode(", ", $_POST["prise"]);
$description = $_POST["description"];


echo '<br>';
var_dump($prise);


$query = "
insert into reparations(user_id, type_id, marque_id, modele_id, prise_en_charge, serie, imei, description) VALUES
(:user, :type, :marque, :model, :prise, :serie, :imei, :description)";
$stmt = $db->prepare($query);

$stmt->execute(array(
    ':user' => $user,
    ':type' => $type,
    ':marque' => $marque,
    ':model' => $model,
    ':prise' => $prise,
    ':serie' => $serie,
    ':imei' => $imei,
    ':description' => $description
));


$_SESSION["popup"] = true;

if ($stmt->rowCount() > 0) {
    
    header("Location: ../index.php?popup=successSendReparation");
} else {
    header("Location: ../index.php?error=errorSendReparation");
}