<?php
session_start();
include("../php/admin/verifyUser.php");
include("../php/popup.php");

include("../php/database.php");



$query = "select id, libelle, marque_id from modele_appareil";
$stmt = $db->prepare($query);
$stmt->execute();
$Liste_modele = $stmt->fetchAll();



$query = "select m.id, concat(concat(m.libelle, ' - '), t.libelle) as libelle
from marque_appareil m
join type_appareil t on t.id = m.type_id;";
$stmt = $db->prepare($query);
$stmt->execute();
$Liste_marque = $stmt->fetchAll();




// var_dump($Liste_modele);







$query = "select p.id, p.libelle, p.prix, mo.libelle as modele, ma.libelle as marque, concat(concat(ma.libelle, ' - '), t.libelle) as marque, ma.id as marque_id, mo.id as modele_id
from prise_en_charge p
join modele_appareil mo on mo.id = p.modele_ref 
join marque_appareil ma on ma.id = mo.marque_id
join type_appareil t on t.id = ma.type_id;";
$stmt = $db->prepare($query);
$stmt->execute();
$Liste = $stmt->fetchAll();

// var_dump($Liste);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../assets/css/popup.css">
    <link rel="stylesheet" href="../assets/admin/css/nav.css">
    <link rel="stylesheet" href="../assets/admin/css/prise_en_charge.css">

    <script src="../assets/admin/js/delete.js" defer></script>
</head>

<body>



    <nav>

        <ul>

            <li><a href="./home.php">Home</a></li>
            <li><a href="./type_appareil.php">Type d'appareil</a></li>
            <li><a href="./marque_appareil.php">Marque d'appareil</a></li>
            <li><a href="./modele_appareil.php">Modèle d'appareil</a></li>
            <li class='actif'><a href="./prise_en_charge.php">Prise en charge</a></li>
            <li><a href="./reparations.php">Réparations</a></li>
    <li><a href="./users.php">Users</a></li>

            <div class="gap"></div>

            <li><a href="../php/logout.php">Déconnexion</a></li>
        </ul>

    </nav>


    <div class="container">

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th class='id'>id</th>
                        <th>type</th>
                        <th>prix</th>
                        <th>modèle</th>
                        <th>marque</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php foreach ($Liste as $l) { ?>
                        <tr>
                            <td class='id'><?= $l['id'] ?></td>
                            <td><?= $l['libelle'] ?></td>
                            <td><?php echo number_format($l['prix'], 2, ',', ' ') ?> €</td>
                            <td><?= $l['modele'] ?></td>
                            <td><?= $l['marque'] ?>
                        
                                <div class="trash-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24"
                                    data-id="<?= $l['id'] ?>" fill="none" onclick="deleteElement(this,'<?= $l['libelle'] ?>' )">
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
            <form action="../php/admin/addPriseEnCharge.php" method="POST">

                <h3>Ajouter une prise en charge</h3>

                <div class="field">
                    <select name="" id="select-marque">
                        <option value=""> -- Marque -- </option>
                        <?php foreach ($Liste_marque as $marque): ?>
                            <option value="<?= $marque['id'] ?>"><?= $marque['libelle'] ?></option>
                        <?php endforeach; ?>
                        <!-- <label for="">Nom de la prise en charge</label> -->
                    </select>
                </div>


                <div class="field">
                    <select name="modele" id="select-modele">
                        <option value=""> -- Modèle -- </option>
                        <?php foreach ($Liste_modele as $modele): ?>
                            <option value="<?= $modele['id'] ?>"><?= $modele['libelle'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- <label for="">Nom de la prise en charge</label>     -->
                </div>

                <div class="field">
                    <input type="text" placeholder=" " name="name" required>
                    <label for="">Nom de la prise en charge</label>
                </div>
                
                <div class="field">
                    <input type="text" placeholder=" " name="price" required>
                    <label for="">Prix</label>
                </div>

                <button type="submit">Ajouter</button>

            </form>
        </div>

    </div>


    <div class="conf" id="conf">
        <span id="confText">Etes vous sûr de vouloir suprimmer l'élément n¤1</span>
        <div class="buttons">
            <button onclick="confDelete()">Oui</button>
            <button onclick="cancelDelete()">Non</button>
        </div>
    </div>

</body>
<script>
    const URL = "../php/admin/deletePriseEnCharge.php"

    const modeles = <?php echo json_encode($Liste_modele) ?>;
    const selectMarque = document.getElementById("select-marque") 
    const selectModele = document.getElementById("select-modele") 
    
    const Liste = <?php echo json_encode($Liste) ?>;
    const tbody = document.getElementById("tbody")

    selectMarque.addEventListener("change", () => {
        const marqueId = selectMarque.value;
        console.log(marqueId);

        var ListeSelected;

        if (marqueId == "") {
            ListeSelected = Liste;
        }else {
            ListeSelected = Liste.filter(liste => liste.marque_id == marqueId);
        }

        console.log(ListeSelected);

        tbody.innerHTML = "";
        ListeSelected.forEach(liste => {
            console.log(liste);

            const tr = document.createElement("tr");
            tr.innerHTML = `
            <td class='id'>${liste.id}</td>
            <td>${liste.libelle}</td>
            <td>${liste.prix.toLocaleString('fr-FR')} €</td>
            <td>${liste.modele}</td>
            <td>${liste.marque}

            <div class="trash-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24"
                                    data-id="<?= $l['id'] ?>" fill="none" onclick="deleteElement(this,'<?= $l['libelle'] ?>' )">
                                    <path
                                        d="M3 3L21 21M18 6L17.6 12M17.2498 17.2527L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6H4M16 6L15.4559 4.36754C15.1837 3.55086 14.4194 3 13.5585 3H10.4416C9.94243 3 9.47576 3.18519 9.11865 3.5M11.6133 6H20M14 14V17M10 10V17"
                                        stroke="#000000" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

            </td>
            `;
            tbody.appendChild(tr);
        });


        const modeleSelected = modeles.filter(modele => modele.marque_id == marqueId)

        console.log(modeleSelected);

        selectModele.innerHTML = "<option value=''> -- Modele -- </option>";

        modeleSelected.forEach(modele => {
            const option = document.createElement("option");
            option.value = modele.id;
            option.textContent = modele.libelle;
            selectModele.appendChild(option);
        });
    })

   selectModele.addEventListener("change", () => {
        const modeleId = selectModele.value;
        console.log(modeleId);

        var ListeSelected;

        if (modeleId == "") {
            ListeSelected = Liste;
        }else {

            ListeSelected = Liste.filter(liste => liste.modele_id == modeleId);
        }

        console.log(ListeSelected);

        tbody.innerHTML = "";
        ListeSelected.forEach(liste => {
            console.log(liste);

            const tr = document.createElement("tr");
            tr.innerHTML = `
            <td class='id'>${liste.id}</td>
            <td>${liste.libelle}</td>
            <td>${liste.prix.toLocaleString('fr-FR')} €</td>
            <td>${liste.modele}</td>
            <td>${liste.marque}

            <div class="trash-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24"
                                    data-id="<?= $l['id'] ?>" fill="none" onclick="deleteElement(this,'<?= $l['libelle'] ?>' )">
                                    <path
                                        d="M3 3L21 21M18 6L17.6 12M17.2498 17.2527L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6H4M16 6L15.4559 4.36754C15.1837 3.55086 14.4194 3 13.5585 3H10.4416C9.94243 3 9.47576 3.18519 9.11865 3.5M11.6133 6H20M14 14V17M10 10V17"
                                        stroke="#000000" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

            </td>
            `;
            tbody.appendChild(tr);
        });
    })
</script>

</html>