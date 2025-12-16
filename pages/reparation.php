<?php
session_start();
include("../php/database.php");
include("../php/verifyUser.php");

// Récupérer les listes
$typeListe = $db->query("SELECT id, libelle FROM type_appareil ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);
$marqueListe = $db->query("SELECT id, libelle, type_id as ref FROM marque_appareil ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);
$modeleListe = $db->query("SELECT id, libelle, marque_id as ref FROM modele_appareil ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);
$priseEnCharge = $db->query("SELECT id, modele_ref, libelle, prix FROM prise_en_charge")->fetchAll(PDO::FETCH_ASSOC);

// Paramètres GET
$selectedType = isset($_GET['type']) ? intval($_GET['type']) : null;
$selectedMarque = isset($_GET['marque']) ? intval($_GET['marque']) : null;
$selectedModel = isset($_GET['model']) ? intval($_GET['model']) : null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Réparation - Nuratec</title>

   <link rel="stylesheet" href="../assets/css/reparation.css">
</head>

<body>

   <section class="nav">
      <nav>
         <ul>
            <li>
               <a href="../index.php">
                  Accueil
               </a>
            </li>

            <?php
            if (isset($_SESSION["user_id"])) {
               ?>
               <li>
                  <a href="../pages/myReparation.php">Mes reparation</a>
               </li>
               <li>
                  <a class="actif">Reparation</a>
               </li>
               <li>
                  <a href="">Mon compte</a>
               </li>
               <li>
                  <a href="../php/logout.php">Deconnection</a>
               </li>
               <?php
            } else {
               ?>


               <li>
                  <a href="./admin/index.php">Admin login</a>
               </li>
               <li>
                  <a href="./pages/logInOut.php">Connection</a>
               </li>

               <?php
            }
            ?>
         </ul>
      </nav>
   </section>

   <section class="titre">
      <h1>Nuratec</h1>
   </section>

   <section class="reparation">
      <form method="POST" action="../php/sendReparation.php" style="display:flex;flex-direction:column;gap:20px;">
         <h2>Réparation d'appareil</h2>

         <div class="field">
            <label>Type d'appareil</label>
            <select id="type-select" name="type" required>
               <option value=""> -- Type -- </option>
               <?php foreach ($typeListe as $type): ?>
                  <option value="<?= $type['id'] ?>" <?= ($selectedType == $type['id']) ? 'selected' : '' ?>>
                     <?= $type['libelle'] ?>
                  </option>
               <?php endforeach; ?>
            </select>
         </div>

         <div class="field">
            <label>Marque</label>
            <select id="marque-select" name="marque" disabled required>
               <option value=""> -- Marque -- </option>
            </select>
         </div>

         <div class="field">
            <label>Modèle</label>
            <select id="modele-select" name="modele" disabled required>
               <option value=""> -- Modèle -- </option>
            </select>
         </div>

         <div class="field">
            <label>Numero de série</label>
            <input name="serie" type="number" pattern="[0-9]+" inputmode="numeric" placeholder="Ex : 356789123456789"
               required />
         </div>

         <div class="field">
            <label>Numéro IMEI</label>
            <input name="imei" type="number" pattern="[0-9]+" inputmode="numeric" placeholder="Ex : 356789123456789"
               required />
         </div>



         <h2>Prise en charge</h2>
         <div class="checkbox-group" id="checkbox-group">

            <p> Veuillez choisir on modele pour pouvoir choisir la/les prise en charge </p>

         </div>


         <div class="field">
            <label>Description du problème</label>
            <textarea name="description" rows="5" placeholder="Décrivez le problème rencontré..."></textarea>
         </div>

         <div class="field">
            <label>Total :</label>
            <input id="total" name="total" value="0" readonly />
         </div>

         <button type="submit"><span>Envoyer la demande</span></button>
      </form>
   </section>

   <script>
      document.addEventListener("DOMContentLoaded", () => {
         const typeInput = document.getElementById('type-select');
         const marqueInput = document.getElementById('marque-select');
         const modeleInput = document.getElementById('modele-select');
         const checkboxGroup = document.getElementById('checkbox-group');
         const totalInput = document.getElementById('total');

         const paramModele = <?php echo isset($_GET['model']) ? json_encode($_GET['model']) : 'null'; ?>;

         const marqueAppareil = <?php echo json_encode($marqueListe); ?>;
         const modeleAppareil = <?php echo json_encode($modeleListe); ?>;
         const priseEnCharge = <?php echo json_encode($priseEnCharge); ?>;

         console.log(priseEnCharge);

         const urlParams = new URLSearchParams(window.location.search);
         const paramType = urlParams.get("type");
         const paramMarque = urlParams.get("marque");
         const paramModel = urlParams.get("model");

         function loadMarques(typeId, callback = null) {
            console.log('load marque')
            marqueInput.innerHTML = '<option value=""> -- Marque -- </option>';
            const filtered = marqueAppareil.filter(m => m.ref == typeId);
            filtered.forEach(m => {
               const opt = document.createElement('option');
               opt.value = m.id;
               opt.textContent = m.libelle;
               marqueInput.appendChild(opt);
            });
            marqueInput.disabled = filtered.length === 0;
            modeleInput.innerHTML = '<option value=""> -- Modèle -- </option>';
            modeleInput.disabled = true;
            if (callback) callback();
         }

         function loadModeles(marqueId, callback = null) {
            modeleInput.innerHTML = '<option value=""> -- Modèle -- </option>';
            const filtered = modeleAppareil.filter(m => m.ref == marqueId);
            filtered.forEach(m => {
               const opt = document.createElement('option');
               opt.value = m.id;
               opt.textContent = m.libelle;
               modeleInput.appendChild(opt);
            });
            modeleInput.disabled = filtered.length === 0;
            if (callback) callback();
         }

         if (paramType) {
            typeInput.value = paramType;
            loadMarques(paramType, () => {
               if (paramMarque) {
                  marqueInput.value = paramMarque;
                  loadModeles(paramMarque, () => {
                     if (paramModel) {
                        modeleInput.value = paramModel;
                     }
                  });
               }
            });
         }

         function showPriseEnCharge(id) {
            if (id === '') {
               checkboxGroup.innerHTML = '<p>Veuillez choisir un modèle pour pouvoir choisir la/les prise en charge</p>';
               return;
            }

            const priseEnChargeEnable = priseEnCharge.filter(prise => prise.modele_ref == id);
            console.log(priseEnChargeEnable);

            checkboxGroup.innerHTML = '';

            priseEnChargeEnable.forEach(prise => {
               const label = document.createElement('label');
               const checkbox = document.createElement('input');
               let value = prise.libelle + ' - ' + prise.prix + '    €';
               console.log(value)
               checkbox.type = 'checkbox';
               checkbox.name = 'prise[]';
               checkbox.value = prise.libelle ;
               checkbox.dataset.id = prise.id;
               checkbox.addEventListener('change', () => updateTotal());

               label.appendChild(checkbox);
               label.appendChild(document.createTextNode(' ' + value));
               checkboxGroup.appendChild(label);
            });
         }

         function updateTotal() {
            const checked = Array.from(document.querySelectorAll('input[name="prise[]"]:checked'));

            var total = 0
            checked.forEach(c => {
               console.log(c)
               total += priseEnCharge.filter(p => p.id == c.dataset.id)[0].prix
            })
            totalInput.value = total
         }

         typeInput.addEventListener('change', () => loadMarques(typeInput.value));
         marqueInput.addEventListener('change', () => loadModeles(marqueInput.value));
         modeleInput.addEventListener('change', () => showPriseEnCharge(modeleInput.value));

         if (paramModel) {
            showPriseEnCharge(paramModel);
         }

      });
   </script>

</body>

</html>