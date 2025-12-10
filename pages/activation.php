<?php 

include("../php/database.php");
include("../php/date.php");


$ac = $_GET['ac'];

if (!isset($ac)) {
   header("Location: ../index.php");
   exit();
}

$query = 'SELECT u.nom, u.prenom , u.created_at, u.mail, u.telephone, u.adresse,  c.nom as ville, cp.code_postal 
FROM users u
join communes c on c.id = ville_id
join codes_postaux cp on cp.id = u.code_postal_id
WHERE activation_code = :ac';
$stmt = $db->prepare($query);
$stmt->execute(array(
    ':ac' => $ac
));

$result = $stmt->fetch();

if (!$result) {
   header("Location: ../index.php");
   exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../assets/css/activations.css">
</head>
<body>

<h1>Bonjour <?php echo $result['nom'] . " " . $result['prenom']; ?></h1>
<h3>Vous avez voulu creer un compte sur notre site <?php echo formater_date($result['created_at']); ?></h3>

<h4>Voici vos informations :</h4>

<p>Nom : <?php echo $result['nom']; ?></p>
<p>Prénom : <?php echo $result['prenom']; ?></p>
<p>Mail : <?php echo $result['mail']; ?></p>
<p>Telephone : <?php echo $result['telephone']; ?></p>
<p>Adresse : <?php echo $result['adresse']; ?></p>
<p>Ville : <?php echo $result['ville']; ?></p>
<p>Code postal : <?php echo $result['code_postal']; ?></p>
<p>Date de création : <?php echo formater_date($result['created_at']); ?></p>


<form action="../php/activate.php" method="POST">
    <input type="hidden" name="ac" value="<?php echo $ac; ?>">
    <button>Activer mon compte</button>
</form>


</body>
</html>