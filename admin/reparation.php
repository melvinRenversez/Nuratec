<?php
session_start();
include( '../php/admin/verifyUser.php' );
include( '../php/database.php' );

$id = $_GET[ 'id' ];

$query = "select re.id, ty.libelle as type, ma.libelle as marque, mo.libelle as modele, re.prise_en_charge as object, re.description, concat(concat(us.nom, ' '), us.prenom) as user, serie, imei
from reparations re
join users us on us.id = re.user_id
join type_appareil ty on ty.id = re.type_id
join marque_appareil ma on ma.id = re.marque_id
join modele_appareil mo on mo.id = re.modele_id
where re.id = :id;";
$stmt = $db->prepare( $query );
$stmt->execute( array(
    ':id' => $id
) );

$reparation = $stmt->fetch( PDO::FETCH_ASSOC );

?>

<!DOCTYPE html>
<html lang = 'en'>
<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Détail de la réparation</title>
<link rel = 'stylesheet' href = '../assets/admin/css/reparation.css'>
</head>
<body>

<div class = 'container'>

<h1>Réparation #<?php echo $reparation[ 'id' ];
?></h1>

<div class = 'infos'>
<p><span>Type :</span> <?php echo $reparation[ 'type' ];
?></p>
<p><span>Marque :</span> <?php echo $reparation[ 'marque' ];
?></p>
<p><span>Modèle :</span> <?php echo $reparation[ 'modele' ];
?></p>
<p><span>Objet pris en charge :</span> <?php echo $reparation[ 'object' ];
?></p>
<p><span>Description :</span> <?php echo $reparation[ 'description' ];
?></p>
<p><span>Client :</span> <?php echo $reparation[ 'user' ];
?></p>
<p><span>N° Série :</span> <?php echo $reparation[ 'serie' ];
?></p>
<p><span>IMEI :</span> <?php echo $reparation[ 'imei' ];
?></p>
</div>

<a href = 'reparations.php' class = 'button'>
<span>Retour</span>
<div class = 'slider'></div>
</a>

</div>

</body>
</html>
