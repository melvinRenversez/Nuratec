<?php
session_start();
include("./php/database.php");
include("./php/popup.php");


$typeListe = [];
$marqueListe = [];
$modeleListe = [];

$query = "select id, libelle
from type_appareil";
$stmt = $db->prepare($query);
$stmt->execute();
$typeListe = $stmt->fetchAll();


$query = "select id, libelle, type_id as ref
from marque_appareil";
$stmt = $db->prepare($query);
$stmt->execute();
$marqueListe = $stmt->fetchAll();



$query = "select id, libelle, marque_id as ref
from modele_appareil";
$stmt = $db->prepare($query);
$stmt->execute();
$modeleListe = $stmt->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>

   <link rel="stylesheet" href="./assets/css/popup.css">
   <link rel="stylesheet" href="./assets/css/index.css">

</head>

<body>

<section class="nav">
   <nav>
      <ul>
         <li>
            <a href="" class="actif">
               Accueil
            </a>
         </li>

         <?php
         if (isset($_SESSION["user_id"])) {
            ?>
            <li>
               <a href="./pages/myReparation.php">Mes reparation</a>
            </li>
            <li>
               <a href="./pages/reparation.php">Reparation</a>
            </li>
            <li>
               <a href="./pages/account.php">Mon compte</a>
            </li>
            <li>
               <a href="./php/logout.php">Deconnection</a>
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

      <form action="./pages/reparation.php" method="GET">

         <div class="field">
            <label for="">Type d'appareil</label>
            <select name="type" id="type-select">
               <option value=""> -- Type d'appareil --</option>
               <?php foreach ($typeListe as $key => $type): ?>
                     <option value="<?php echo $type["id"]; ?>"><?php echo $type["libelle"]; ?></option>   
               <?php endforeach; ?>
            </select>
         </div>


         <div class="field">
            <label for="">Marque</label>
            <select name="marque" id="marque-select" disabled>
               <option value=""> -- Marque --</option>
               
            </select>
         </div>
         
         <div class="field">
            <label for="">Modele</label>
            <select name="model" id="model-select" disabled>
               <option value=""> -- Modele --</option>
            </select>
         </div>

         <button id="reparer-button" disabled>
            <div class="slider"></div>
            <span>Réparer</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24" fill="none">
               <path d="M13 15L16 12M16 12L13 9M16 12H8M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
               
</button>

      </form>
   </section>


      <section class="reprise">
            <div class="reprise-content">
               <span class="rep-text">
                  <h5>
                     Reprise d'achat
                  </h5>
                 Vous avez un appareil high tech dont vous ne vous servez pas ? Revendez-le ! Le cycle de vie d'un appareil aujourd'hui se résume souvent à l'achat d'un mobile, d'une tablette, d'un ordinateur ou autres produit high tech, qui atteint sa fin de vie ou qui ne nous plait plus, alors il finit dans un tiroir...
               </span>
               <div class="rep-button">
                  <span>J'y fonce</span>
                  <a href="">
                     <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none">
                     <path d="M13 15L16 12M16 12L13 9M16 12H8M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </a>
                  </svg>
               </div>
            </div>
   </section>

</body>

<script>

const typeAppareil = <?php echo json_encode($typeListe); ?>;
const marqueAppareil = <?php echo json_encode($marqueListe); ?>;
const modeleAppareil = <?php echo json_encode($modeleListe); ?>;
const buttonReparer = document.getElementById("reparer-button");



const typeInput = document.getElementById("type-select");
const marqueInput = document.getElementById("marque-select");
const modelInput = document.getElementById("model-select"); 


typeInput.addEventListener("change", () => {
   const type = typeInput.value;
   console.log("typeInput", type);

   const marqueByType = marqueAppareil.filter(marque => marque.ref == type);

   console.log("marque by type : ", marqueByType)

   marqueInput.disabled = false; 
   marqueInput.innerHTML = "";

   modelInput.disabled = true;
   modelInput.innerHTML = ""; 

   let option = document.createElement("option");
      option.textContent = "-- Marque --";
      marqueInput.appendChild(option);

   marqueByType.forEach(marque => {
      console.log(marque)
      const option = document.createElement("option");
      option.value = marque.id;
      option.textContent = marque.libelle;
      console.log(marque.libelle)
      marqueInput.appendChild(option);
   });
   buttonReparer.disabled = true;
});


marqueInput.addEventListener("change", () => {
   const marque = marqueInput.value;
   console.log("marqueInput", marque);
   modelInput.disabled = false;
   const modeleByMarque = modeleAppareil.filter(modele => modele.ref == marque);
   console.log("modele by marque : ", modeleByMarque)
   modelInput.innerHTML = "";
   let option = document.createElement("option");
      option.textContent = "-- Model --";
      modelInput.appendChild(option);
   modeleByMarque.forEach(modele => {
      console.log(modele)
      const option = document.createElement("option");
      option.value = modele.id;
      option.textContent = modele.libelle;
      console.log(modele.libelle)
      modelInput.appendChild(option);
   });
   buttonReparer.disabled = true;
});

modelInput.addEventListener("change", () => {
   const model = modelInput.value;
   console.log("modelInput", model);

   buttonReparer.disabled = false;
});



// typeInput.addEventListener("change", () => {
//    const type = typeInput.value;

//    const listeByType = liste[type];

//    marqueInput.disabled = false; 
//    marqueInput.innerHTML = "";

//    let option = document.createElement("option");
//       option.textContent = "-- Marque --";
//       marqueInput.appendChild(option);

//    for (const marque in listeByType) {
//       const option = document.createElement("option");
//       option.value = marque;
//       option.textContent = marque;
//       marqueInput.appendChild(option);
//    }

//    modelInput.innerHTML = "";
//    option = document.createElement("option");
//    option.textContent = "-- Model --";
//    modelInput.appendChild(option);

//    modelInput.disabled = true;

// });

// typeInput.addEventListener("change", () => {
//    const type = typeInput.value;

//    const listeByType = liste[type];

//    marqueInput.disabled = false; 
//    marqueInput.innerHTML = "";

//    const option = document.createElement("option");
//       option.textContent = "-- Marque --";
//       marqueInput.appendChild(option);

//    for (const marque in listeByType) {
//       const option = document.createElement("option");
//       option.value = marque;
//       option.textContent = marque;
//       marqueInput.appendChild(option);
//    }
// });

// marqueInput.addEventListener("change", () => {
//    const marque = marqueInput.value;

//    console.log("marqueINput");

   
//    modelInput.disabled = false; 
   
//    const type = typeInput.value;
//    const listeByMarque = liste[type][marque];
//    modelInput.innerHTML = "";
   
//    const option = document.createElement("option");
//    option.textContent = "-- Model --";
//    modelInput.appendChild(option);

//    for (const model of listeByMarque) {
//       const option = document.createElement("option");
//       option.value = model;
//       option.textContent = model;
//       modelInput.appendChild(option);
//    }
// });

</script>

</html>