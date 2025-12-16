<?php 

session_start();

include("./verifyUser.php");
include("../database.php");


$name = $_POST['name'];
$price = $_POST['price'];
$modele = $_POST['modele'];

// echo $price;

// remplacer la virgule par un point
$price = str_replace(',', '.', $price);

// enlever les espaces
$price = str_replace(' ', '', $price);


// echo $name;
// echo "<br>";
// echo $price;
// echo "<br>";
// echo $modele;

$query = "insert into prise_en_charge(libelle, prix, modele_ref) values(:libelle, :prix, :modele)";
$stmt = $db->prepare($query);
$stmt->execute(array(
   ':libelle' => $name,
   ':prix' => $price,
   ':modele' => $modele
));



$_SESSION["popup"] = true;
if ($stmt->rowCount() > 0) {
   header("Location: ../../admin/prise_en_charge.php?popup=successAdd");
}else {
   header("Location: ../../admin/prise_en_charge.php?popup=errorAdd");
}