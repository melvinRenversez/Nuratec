<?php
session_start();
include("../php/database.php");

// Récupérer les listes
$typeListe = $db->query("SELECT id, libelle FROM type_appareil ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);
$marqueListe = $db->query("SELECT id, libelle, type_id as ref FROM marque_appareil ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);
$modeleListe = $db->query("SELECT id, libelle, marque_id as ref FROM modele_appareil ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);
$priseEnCharge = $db->query("SELECT libelle FROM prise_en_charge")->fetchAll(PDO::FETCH_ASSOC);

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
   <style>
      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
      }

      body {
         background: #141313;
         font-family: Arial, sans-serif;
      }

      section.nav {
         display: flex;
         justify-content: flex-end;
      }

      section.nav nav {
         width: min-content;
         padding: 30px;
      }

      section.nav nav ul {
         list-style: none;
         display: flex;
         gap: 20px;
         padding: 10px 20px;
         align-items: center;
      }

      section.nav nav ul li a {
         text-decoration: none;
         color: #eee;
         font-weight: bold;
         font-size: 18px;
         position: relative;
         padding: 10px;
         white-space: nowrap;
      }

      section.nav nav ul li a::before {
         content: '';
         position: absolute;
         bottom: 0;
         left: 0;
         width: 0%;
         height: 2px;
         background: #eee;
         transition: width 0.3s;
      }

      section.nav nav ul li a:hover::before,
      section.nav nav ul li a.actif::before {
         width: 100%;
      }

      section.titre {
         text-align: center;
         margin-top: 50px;
         padding-bottom: 60px;
         color: #eee;
         font-size: 70px;
         border-bottom: 2px solid #eee;
         width: 90%;
         margin: auto;
      }

      section.reparation {
         width: 90%;
         margin: 50px auto;
         padding: 20px 40px;
         border: 1px solid #333;
         border-radius: 5px;
         background: #242121;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      }

      section.reparation h2 {
         color: #eee;
         margin-bottom: 20px;
         border-bottom: 1px solid #444;
         padding-bottom: 10px;
      }

      .field {
         display: flex;
         flex-direction: column;
         margin-bottom: 20px;
      }

      .field label {
         color: #ddd;
         margin-bottom: 5px;
         font-weight: bold;
      }

      .field select,
      .field input {
         padding: 10px;
         border: none;
         border-bottom: 1px solid #888;
         background: transparent;
         color: #ddd;
         outline: none;
      }

      .field textarea {
         padding: 10px;
         border: none;
         border-bottom: 1px solid #888;
         background: transparent;
         color: #ddd;
         outline: none;

         height: 200px
      }


      section.reparation .field label {
         margin-right: 0;
         font-weight: bold;
         margin-bottom: 5px;

         color: #ddd
      }

      section.reparation .field select {
         padding: 8px;

         /* appearance: none; */

         background: transparent;

         color: #ddd;


         border: none;
         border-bottom: 1px solid #ccc;

         border-radius: 0px;

         outline: none;

         cursor: pointer;

      }

      select,
      select::picker(select) {
         appearance: base-select;
      }

      select::picker(select) {
         background: transparent;
         backdrop-filter: blur(12px);

         border: none;

      }

      section.reparation .field select option {
         background: transparent;
         backdrop-filter: blur(10px);
         color: #ddd;
         padding: 10px;
      }

      section.reparation .field select:disabled {
         opacity: 0.5;
         cursor: not-allowed;
      }

      section.reparation .field select option:hover {
         background: #333;
      }


      .checkbox-group {
         display: flex;
         flex-direction: column;
         gap: 10px;
         padding: 15px;
         background: rgba(255, 255, 255, 0.05);
         border-radius: 5px;
         border: 1px solid #333;
      }

      .checkbox-group label {
         display: flex;
         align-items: center;
         gap: 10px;
         color: #ccc;
         cursor: pointer;
      }

      .checkbox-group input {
         width: 18px;
         height: 18px;
         accent-color: #555;

         cursor: pointer
      }

      button {
         padding: 15px 40px;
         background: transparent;
         border: 2px solid #eee;
         color: #eee;
         cursor: pointer;
         font-size: 16px;
         font-weight: bold;
         border-radius: 4px;
         position: relative;
         overflow: hidden;
         transition: all 0.3s ease-in-out;
      }

      button:hover {
         color: #141313;
         background: #eee;
      }

      button span {
         position: relative;
         z-index: 5;
      }
   </style>
</head>

<body>

   <section class="nav">
      <nav>
         <ul>
            <li><a href="../index.php">Accueil</a></li>
            <?php if (isset($_SESSION["id"])) { ?>
               <li><a href="" class="actif">Reparation</a></li>
               <li><a href="">Mon compte</a></li>
               <li><a href="./php/logout.php">Deconnection</a></li>
            <?php } else { ?>
               <li><a href="./pages/logInOut.php">Connection</a></li>
            <?php } ?>
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
            <select id="type-select" name="type">
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
            <select id="marque-select" name="marque" disabled>
               <option value=""> -- Marque -- </option>
            </select>
         </div>

         <div class="field">
            <label>Modèle</label>
            <select id="modele-select" name="modele" disabled>
               <option value=""> -- Modèle -- </option>
            </select>
         </div>

               <div class="field">
            <label>Numero de serie</label>
            <input name="serie" type="text" placeholder="Ex : 356789123456789" />
         </div>

         <div class="field">
            <label>Numéro IMEI</label>
            <input name="imei" type="text" placeholder="Ex : 356789123456789" />
         </div>

         

         <h2>Prise en charge</h2>
         <div class="checkbox-group">

            <?php 
            
            foreach($priseEnCharge as $prise){
               echo '<label><input type="checkbox" name="prise[]" value="' . $prise["libelle"] . '" /> ' . $prise["libelle"] . '</label>';
            }
            
            
            ?>

         </div>


         <div class="field">
            <label>Description du problème</label>
            <textarea name="description" rows="5" placeholder="Décrivez le problème rencontré..."></textarea>
         </div>

         <button><span>Envoyer la demande</span></button>
      </form>
   </section>

   <script>
      document.addEventListener("DOMContentLoaded", () => {
         const typeInput = document.getElementById('type-select');
         const marqueInput = document.getElementById('marque-select');
         const modeleInput = document.getElementById('modele-select');

         const marqueAppareil = <?php echo json_encode($marqueListe); ?>;
         const modeleAppareil = <?php echo json_encode($modeleListe); ?>;

         const urlParams = new URLSearchParams(window.location.search);
         const paramType = urlParams.get("type");
         const paramMarque = urlParams.get("marque");
         const paramModel = urlParams.get("model");

         function loadMarques(typeId, callback = null) {
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

         typeInput.addEventListener('change', () => loadMarques(typeInput.value));
         marqueInput.addEventListener('change', () => loadModeles(marqueInput.value));
      });
   </script>

</body>

</html>