    <?php
session_start();
include( '../php/admin/verifyUser.php' );
include( '../php/database.php' );

$typeListe = $db->query( 'SELECT id, libelle FROM type_appareil ORDER BY id DESC' )->fetchAll( PDO::FETCH_ASSOC );

$marqueListe = $db->query( 'select ma.id, ma.libelle as marque, ty.libelle as type from type_appareil ty  join marque_appareil ma on ma.type_id = ty.id ORDER BY ma.id DESC;' )->fetchAll( PDO::FETCH_ASSOC );

$modeleListe = $db->query( 'select mo.id, mo.libelle as model, ma.libelle as marque, ty.libelle as type  from type_appareil ty  join marque_appareil ma on ma.type_id = ty.id join modele_appareil mo on mo.marque_id = ma.id ORDER BY mo.id DESC;' )->fetchAll( PDO::FETCH_ASSOC );

$priseEnChargeListe = $db->query( 'select id, libelle from prise_en_charge;' )->fetchAll( PDO::FETCH_ASSOC );

$reparations = $db->query('select re.id, mo.libelle as modele, re.prise_en_charge as object from reparations re join modele_appareil mo on mo.id = re.modele_id ;')->fetchAll( PDO::FETCH_ASSOC );

// var_dump( $typeListe );
// var_dump( $marqueListe );
// var_dump( $modeleListe );

?>

<!DOCTYPE html>
<html lang = 'en'>
<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Document</title>

<link rel = 'stylesheet' href = '../assets/admin/css/nav.css'>
<link rel = 'stylesheet' href = '../assets/admin/css/home.css'>
</head>
<body>

<nav>

<ul>

<li class = 'actif'><a href = './home.php'>Home</a></li>
<li><a href = './type_appareil.php'>Type d'appareil</a></li>
    <li><a href="./marque_appareil.php">Marque d'appareil</a></li>
<li><a href = './modele_appareil.php'>Modele d'appareil</a></li>
    <li><a href="./prise_en_charge.php">Prise en charge</a></li>
    <li><a href="./reparations.php">Reparations</a></li>

    <div class="gap"></div>

    <li><a href="../php/logout.php">Deconnection</a></li>
</ul>

</nav>


<div class="container">

    <div class="type_appareil">
        <header> 
            Type appareil

            <a href="./type_appareil.php" class="redirect">
                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 48 48"><path d="M12.905,20.0328H9.0934L4.5,27.9889H8.3116Z"/><path d="M28.1821,9.0236V19.8082H24.3705l-4.5934,7.9561h8.405V38.9764L43.5,23.8437Z"/><path d="M20.4316,20.0328H16.62l-4.5934,7.9561h3.8116Z"/></svg>
            </a>
        </header>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($typeListe as $type) : ?>
                        <tr>
                            <td><?= $type['id'] ?></td>
                            <td><?= $type['libelle'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="marque_appareil">
        <header> 
            Marque appareil

            <a href="./marque_appareil.php" class="redirect">
                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 48 48"><defs><style>.a{fill:none;stroke:#000000;stroke-linecap:round;stroke-linejoin:round;}</style></defs><path class="a" d="M12.905,20.0328H9.0934L4.5,27.9889H8.3116Z"/><path class="a" d="M28.1821,9.0236V19.8082H24.3705l-4.5934,7.9561h8.405V38.9764L43.5,23.8437Z"/><path class="a" d="M20.4316,20.0328H16.62l-4.5934,7.9561h3.8116Z"/></svg>
            </a>
        </header>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>marque</th>
                        <th>type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($marqueListe as $type) : ?>
                        <tr>
                            <td><?= $type['id'] ?></td>
                            <td><?= $type['marque'] ?></td>
                            <td><?= $type['type'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="model_appareil">
        <header> 
            Modele appareil

            <a href="./modele_appareil.php" class="redirect">
                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 48 48"><defs><style>.a{fill:none;stroke:#000000;stroke-linecap:round;stroke-linejoin:round;}</style></defs><path class="a" d="M12.905,20.0328H9.0934L4.5,27.9889H8.3116Z"/><path class="a" d="M28.1821,9.0236V19.8082H24.3705l-4.5934,7.9561h8.405V38.9764L43.5,23.8437Z"/><path class="a" d="M20.4316,20.0328H16.62l-4.5934,7.9561h3.8116Z"/></svg>
            </a>
        </header>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>modele</th>
                        <th>marque</th>
                        <th>type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($modeleListe as $type) : ?>
                        <tr>
                            <td><?= $type['id'] ?></td>
                            <td><?= $type['model'] ?></td>
                            <td><?= $type['marque'] ?></td>
                            <td><?= $type['type'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="prise_en_charge">
        <header> 
            Prise en charge

            <a href="./prise_en_charge.php" class="redirect">
                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 48 48"><defs><style>.a{fill:none;stroke:#000000;stroke-linecap:round;stroke-linejoin:round;}</style></defs><path class="a" d="M12.905,20.0328H9.0934L4.5,27.9889H8.3116Z"/><path class="a" d="M28.1821,9.0236V19.8082H24.3705l-4.5934,7.9561h8.405V38.9764L43.5,23.8437Z"/><path class="a" d="M20.4316,20.0328H16.62l-4.5934,7.9561h3.8116Z"/></svg>
            </a>
        </header>

        <div class="content">

        <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nom</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($priseEnChargeListe as $type) : ?>
                        <tr>
                            <td><?= $type['id'] ?></td>
                            <td><?= $type['libelle' ] ?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
        </table>
    </div>
</div>

    <div class = 'reparations'>
        <header>
        Reparations

        <a href="./reparations.php" class="redirect">
            <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 48 48"><defs><style>.a{fill:none;stroke:#000000;stroke-linecap:round;stroke-linejoin:round;}</style></defs><path class="a" d="M12.905,20.0328H9.0934L4.5,27.9889H8.3116Z"/><path class="a" d="M28.1821,9.0236V19.8082H24.3705l-4.5934,7.9561h8.405V38.9764L43.5,23.8437Z"/><path class="a" d="M20.4316,20.0328H16.62l-4.5934,7.9561h3.8116Z"/></svg>
        </a>
        </header>

        <div class='content'>
            <table>
                <thead>
                    <tr>
                        <th class="id">id</th>
                        <th>modele</th>
                        <th>objet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reparations as $type) : ?>
                        <tr>
                            <td><?= $type['id'] ?></td>
                            <td><?= $type['modele'] ?></td>
                            <td><?= $type['object'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>