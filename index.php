
<?php
session_start();
include("./php/database.php");


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

</head>

<style>
   * {
   margin: 0;
   padding: 0;
   box-sizing: border-box;
}

body {
   background: #141313ff;
}

section.reparation {
   width: 400px;
   margin: 50px auto;
   padding: 20px;
   border: 1px solid #ccc;
   border-radius: 5px;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
   width: 60%;

   background: #242121ff;

   translate: translateY(-50%);

}

section.reparation form {

   display: flex;


   align-items: center;

}

section.reparation .field {
   display: flex;
   flex-direction: column;
   margin-bottom: 15px;
   flex: 1;
   margin-right: 10px;

   padding: 5px 20px;
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

section.reparation button {
   height: min-content;
   padding: 10px 15px;

   background: transparent;

   border: 2px solid #eee;
   border-radius: 4px;

   color: black;

   cursor: pointer;
   padding: 15px 80px;

   margin-left: 50px;

   font-size: 15px;

   justify-content: center;
   align-items: center;
   display: flex;
   gap: 10px;
   font-weight: bold;

   position: relative;

   overflow: hidden;

}

section.reparation button span {
   z-index: 1;

   color: #eee;

   transition: color 0.3s ease-in-out;
}

section.reparation button svg {
   z-index: 1;
}

section.reparation button svg path {
   stroke-width: 2.5px;
   stroke: #eee;
   width: 20px;
   height: 20px;


   transition: 0.3s ease-in-out;
}

section.reparation button .slider {
   width: 110%;
   height: 150%;
   /* background: red; */


   background: linear-gradient(135deg, #0A0A0A, #141414, #3A3A3A, #141414, #0A0A0A);

   box-shadow: 25px 0px 38px 8px rgba(58, 58, 58, 0.82);


   position: absolute;

   left: -15px;
   top: -15px;

   transform: rotate(3deg) translate(-100%);

   opacity: 0.3;

   transition: transform 0.3s ease-in-out, opacity 0.5s ease-in-out;

   z-index: 0;
}

section.reparation button:hover span,
section.reparation button:hover svg path {
   color: white;
   stroke: white;
}

section.reparation button:hover .slider {
   opacity: 1;
   transform: rotate(3deg) translate(0%);
}

section.titre {
   text-align: center;
   margin-top: 50px;
   padding-bottom: 100px;
   color: #eee;

   font-size: 80px;

   border-bottom: 2px solid #eee;
}

section.nav {
   display: flex;
   justify-content: flex-end;
}

section.nav nav {
   /* background: #3A3A3A; */

   width: min-content;
   padding: 30px;
}

section.nav nav ul {
   list-style: none;
   display: flex;
   gap: 20px;
   padding: 10px 20px;

   /* width: auto; */

   align-items: center;
   justify-content: center;
}

section.nav nav ul li a {
   text-decoration: none;
   color: #eee;
   font-weight: bold;
   font-size: 18px;

   position: relative;

   padding: 10px;

   /* width: auto; */

   text-align: center;

   white-space: nowrap;
}


section.nav nav ul li a::before {
   content: ' ';

   position: absolute;

   bottom: 0;
   left: 0;

   display: block;

   width: 0%;
   height: 2px;

   background: #eee;
   transition: width 0.3s;
}


section.nav nav ul li a:hover::before {
   width: 100%;
}

section.nav nav ul li a.actif::before {
   width: 100%;
}

button:disabled,
button:disabled span,
button:disabled svg path {
   opacity: 0.5;
   cursor: not-allowed;
   border-color: #9e1212 !important;
   color: #9e1212 !important;
   stroke: #9e1212 !important;
}
</style>

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
         if (isset($_SESSION["id"])) {
            ?>
            <li>
               <a href="./pages/reparation.php">Reparation</a>
            </li>
            <li>
               <a href="">Mon compte</a>
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
            <label for="">Model</label>
            <select name="model" id="model-select" disabled>
               <option value=""> -- Model --</option>
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