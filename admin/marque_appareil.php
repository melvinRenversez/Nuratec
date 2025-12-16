<?php
session_start();
include("../php/admin/verifyUser.php");
include("../php/database.php");
include("../php/popup.php");

$query = "select ma.id, ma.libelle as marque, ty.libelle as type from type_appareil ty  join marque_appareil ma on ma.type_id = ty.id ORDER BY ma.id DESC;";
$stmt = $db->prepare($query);
$stmt->execute();
$Liste = $stmt->fetchAll();

$query = "select id, libelle from type_appareil order by id desc;";
$stmt = $db->prepare($query);
$stmt->execute();
$ListeType = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../assets/css/popup.css">
    <link rel="stylesheet" href="../assets/admin/css/marque_appareil.css">
    <link rel="stylesheet" href="../assets/admin/css/nav.css">

    <script src="../assets/admin/js/delete.js" defer></script>
</head>

<body>



    <nav>

        <ul>

            <li><a href="./home.php">Home</a></li>
            <li><a href="./type_appareil.php">Type d'appareil</a></li>
            <li class='actif'><a href="./marque_appareil.php">Marque d'appareil</a></li>
            <li><a href="./modele_appareil.php">Modele d'appareil</a></li>
            <li><a href="./prise_en_charge.php">Prise en charge</a></li>
            <li><a href="./reparations.php">Reparations</a></li>
    <li><a href="./users.php">Users</a></li>

            <div class="gap"></div>

            <li><a href="../php/logout.php">Deconnection</a></li>
        </ul>

    </nav>


    <div class="container">


        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>marque</th>
                        <th>type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Liste as $l) { ?>
                        <tr>
                            <td><?= $l['id'] ?></td>
                            <td><?= $l['marque'] ?></td>
                            <td><?= $l['type'] ?>
                                <div class="trash-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24"
                                        data-id="<?= $l['id'] ?>" fill="none"
                                        onclick="deleteElement(this,'<?= $l['marque'] ?>' )">
                                        <path
                                            d="M3 3L21 21M18 6L17.6 12M17.2498 17.2527L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6H4M16 6L15.4559 4.36754C15.1837 3.55086 14.4194 3 13.5585 3H10.4416C9.94243 3 9.47576 3.18519 9.11865 3.5M11.6133 6H20M14 14V17M10 10V17"
                                            stroke="#000000" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="add">
            <form action="../php/admin/addMarque.php" method="POST">

                <h3>Ajouter une marque</h3>

                <div class="field s">

                    <select name="type" id="" required>
                    <option value=""> -- Choisir un type --</option>
                        <?php foreach ($ListeType as $lt) { ?>
                            <option value="<?= $lt['id'] ?>"><?= $lt['libelle'] ?></option>
                        <?php } ?>
                    </select>

                    <label for="">Type d'appareil</label>

                </div>

                <div class="field">
                    <input type="text" placeholder=" " name="name" required>
                    <label for="">Nom de la marque</label>
                </div>
                <button type="submit">Ajouter</button>

            </form>
        </div>

    </div>


    <div class="conf" id="conf">
        <span id="confText">Etes vous sur de vouloir suprimmer l element n¤1</span>
        <div class="buttons">
            <button onclick="confDelete()">Oui</button>
            <button onclick="cancelDelete()">Non</button>
        </div>
    </div>


    </div>

</body>
<script>
    const URL = "../php/admin/deleteMarque.php"
</script>

</html>