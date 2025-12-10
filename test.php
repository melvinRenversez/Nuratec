<?php
session_start();
include( '../php/admin/verifyUser.php' );
include( '../php/database.php' );

$page = $_GET[ 'page' ] ?? 1;
$range = 50;
$offset = $range * ( $page-1 );

$limit = $db->query( "select floor(count(*) / $range)+1 as total_pages from reparations;" )->fetch( PDO::FETCH_ASSOC )[ 'total_pages' ];

$minerPage = $page - 1;
if ( $minerPage < 1 ) {
    $minerPage = 1;
}
$plusPage = $page + 1;
if ( $plusPage > $limit ) {
    $plusPage = $limit;
}

$reparations = $db->query( "select re.id, ty.libelle as type, ma.libelle as marque, mo.libelle as modele, re.prise_en_charge as object, re.description, concat(concat(us.nom, ' '), us.prenom) as user, serie, imei
from reparations re
join users us on us.id = re.user_id
join type_appareil ty on ty.id = re.type_id
join marque_appareil ma on ma.id = re.marque_id
join modele_appareil mo on mo.id = re.modele_id
ORDER BY id DESC
LIMIT $offset , $range;" )->fetchAll( PDO::FETCH_ASSOC );
?>

<!DOCTYPE html>
<html lang = 'en'>
<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Document</title>

<link rel = 'stylesheet' href = '../assets/admin/css/nav.css'>
<link rel = 'stylesheet' href = '../assets/admin/css/reparations.css'>
</head>
<body>

<nav>

<ul>

<li><a href = './home.php'>Home</a></li>
<li><a href = './type_appareil.php'>Type d'appareil</a></li>
    <li><a href="./marque_appareil.php">Marque d'appareil</a></li>
<li><a href = './modele_appareil.php'>Modele d'appareil</a></li>
    <li><a href="./prise_en_charge.php">Prise en charge</a></li>
    <li class='actif'><a href="./reparations.php">Reparations</a></li>

    <div class="gap"></div>

    <li><a href="../php/logout.php">Deconnection</a></li>
</ul>

</nav>


<div class="container">

    <table>
        <thead>
            <th>Id</th>
            <th>Type</th>
            <th>Marque</th>
            <th>Modele</th>
            <th>Objet</th>
            <th>Description</th>
            <th>User</th>
            <th>Numero de serie</th>
            <th>IMEI</th>
        </thead>
        <tbody>
            <?php foreach($reparations as $reparation): ?>
                <tr data-id="<?= $reparation['id'] ?>">
                    <td title=" <?= htmlspecialchars($reparation['id']) ?> " > <?= $reparation['id'] ?> </td>
                    <td title=" <?= htmlspecialchars($reparation['type']) ?> " > <?= $reparation['type'] ?> </td>
                    <td title=" <?= htmlspecialchars($reparation['marque']) ?> " > <?= $reparation['marque'] ?> </td>
                    <td title=" <?= htmlspecialchars($reparation['modele']) ?> " > <?= $reparation['modele'] ?> </td>
                    <td title=" <?= htmlspecialchars($reparation['object']) ?> " > <?= $reparation['object'] ?> </td>
                    <td title=" <?= htmlspecialchars($reparation['description']) ?> " > <?= $reparation['description'] ?> </td>
                    <td title=" <?= htmlspecialchars($reparation['user']) ?> " > <?= $reparation['user'] ?> </td>
                    <td title=" <?= htmlspecialchars($reparation['serie']) ?> " > <?= $reparation['serie'] ?> </td>
                    <td title=" <?= htmlspecialchars($reparation['imei']) ?> " > <?= $reparation['imei'] ?> </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div class="switch">
        <div class="moin">
            <a href="./reparations.php?page=<?= $minerPage ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none">
    <path d="M14.2893 5.70708C13.8988 5.31655 13.2657 5.31655 12.8751 5.70708L7.98768 10.5993C7.20729 11.3805 7.2076 12.6463 7.98837 13.427L12.8787 18.3174C13.2693 18.7079 13.9024 18.7079 14.293 18.3174C14.6835 17.9269 14.6835 17.2937 14.293 16.9032L10.1073 12.7175C9.71678 12.327 9.71678 11.6939 10.1073 11.3033L14.2893 7.12129C14.6799 6.73077 14.6799 6.0976 14.2893 5.70708Z"/>
    </svg>
            </a>
        </div>
        <span><?php echo $offset . ' / ' . ( $range*$page ) ?></span>
<div class = 'plus'>
<a href = "./reparations.php?page=<?= $plusPage ?>">
<svg xmlns = 'http://www.w3.org/2000/svg' width = '800px' height = '800px' viewBox = '0 0 24 24' fill = 'none'>
<path d = 'M9.71069 18.2929C10.1012 18.6834 10.7344 18.6834 11.1249 18.2929L16.0123 13.4006C16.7927 12.6195 16.7924 11.3537 16.0117 10.5729L11.1213 5.68254C10.7308 5.29202 10.0976 5.29202 9.70708 5.68254C9.31655 6.07307 9.31655 6.70623 9.70708 7.09676L13.8927 11.2824C14.2833 11.6729 14.2833 12.3061 13.8927 12.6966L9.71069 16.8787C9.32016 17.2692 9.32016 17.9023 9.71069 18.2929Z'/>
</svg>
</a>
</div>
</div>

</div>

</body>
<script>
    const trs = document.querySelectorAll('tr');
                console.log(trs);
    trs.forEach(tr => {
        tr.addEventListener('click', () => {
            console.log(tr.dataset.id);
        });
    });
</script>
</html>