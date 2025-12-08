<?php 
session_start();

include("../php/verifyUser.php");
include("../php/database.php");
include("../php/date.php");



$query = "select id, nom from communes";
$stmt = $db->prepare($query);
$stmt->execute();
$communes = $stmt->fetchAll();


$query = "select id, code_postal, commune_id from codes_postaux";
$stmt = $db->prepare($query);
$stmt->execute();
$codes_postaux = $stmt->fetchAll();

$query = "select u.nom, u.prenom, u.mail, u.telephone, u.adresse, c.nom as ville, cp.code_postal
from users u
join communes c on c.id = ville_id
join codes_postaux cp on cp.id = u.code_postal_id 
where u.id = :user_id;";
$stmt = $db->prepare($query);
$stmt->execute(array(
    ':user_id' => $_SESSION["user_id"]
));
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>

   <link rel="stylesheet" href="../assets/css/popup.css">
   <link rel="stylesheet" href="../assets/css/account.css">

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
               <a href="../pages/reparation.php">Reparation</a>
            </li>
            <li>
               <a href=""  class="actif">Mon compte</a>
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

<section class="content">

  <form action="../php/register.php" method="POST">

               <div class="field">
                  <input type="text" placeholder=" " required name="nom" 
                    value="<?= $user['nom'] ?>"
                  >
                  <label for="">Nom</label>
               </div>

               <div class="field">
                  <input type="text" placeholder=" " required name="prenom"
                    value="<?= $user['prenom'] ?>"
                  >
                  <label for="">Prénom</label>
               </div>

               <div class="field">
                  <input type="email" placeholder=" " required id="mailInput" name="mail"
                    value="<?= $user['mail'] ?>"
                  >
                  <label for="">Email</label>
               </div>

               <div class="field">
                  <input type="text" placeholder=" " required name="telephone"
                    value="<?= $user['telephone'] ?>"
                  >
                  <label for="">Telephone</label>
               </div>

               <div class="field">
                  <input type="text" placeholder=" " required name="adresse"
                    value="<?= $user['adresse'] ?>"
                  >
                  <label for="">Adresse</label>
               </div>

               <div class="field">
                  <input list="villeList" type="text" placeholder=" " required id="villeInput" 
                    value="<?= $user['ville'] ?>"
                  >
                  <label for="">Ville</label>

                  <input type="hidden" id="villeInputHidden" name="ville">

               </div>

               <datalist id="villeList">

                  <?php foreach ($communes as $commune) { ?>
                     <option value="<?= $commune['nom'] ?>"></option>
                  <?php } ?>
                  
               </datalist>

               <div class="field">
                  <input type="text" placeholder=" " required list="codeList" id="codeInput" 
                    value="<?= $user['code_postal'] ?>"
                  >
                  <label for="">Code postal</label>

                  <input type="hidden" id="codeInputHidden" name="code_postal" >
               </div>

               <datalist id="codeList">

               </datalist>
               <button type="submit">S'inscrire</button>


            </form>

</section>

</body>


<script>
const allSwitch = document.querySelectorAll('#switch');
const container = document.getElementById('container');

const communes = <?php echo json_encode($communes); ?>;
const codes_postaux = <?php echo json_encode($codes_postaux); ?>;

const villeInput = document.getElementById('villeInput');
const villeInputHidden = document.getElementById('villeInputHidden');

const codeListInput = document.getElementById('codeList');

const codeInput = document.getElementById('codeInput');
const codeInputHidden = document.getElementById('codeInputHidden');

const mailInput = document.getElementById('mailInput');


const mdpInput = document.getElementById('mdpInput');
const mdpConfInput = document.getElementById('mdpConfInput');
const fieldPassConf = document.getElementById('fieldPassConf'); 


console.log(mailInput)


console.log(allSwitch);

allSwitch.forEach(element => {
   
   element.addEventListener('click', () => {
      console.log('clicked');
      container.classList.toggle('active');
   });
   
});


villeInput.addEventListener('change', () => {
   const ville = villeInput.value;
   dataVille = communes.find(c => c.nom === ville);
   villeInputHidden.value = dataVille.id;

   const codes = codes_postaux
      .filter(c => c.commune_id == dataVille.id)
      .map(c => c.code_postal);

   console.log(codes);

   codeListInput.innerHTML = '';
   codes.forEach(code => {
      const option = document.createElement('option');
      option.value = code;
      codeListInput.appendChild(option);
   });
})

codeInput.addEventListener('change', () => {
   console.log('code changed to: ' + codeInput.value);
   const code = codeInput.value;
   console.log(codes_postaux);
   codeId = codes_postaux.find(c => c.code_postal == code).id;
   console.log(codeId);
   codeInputHidden.value = codeId;
})


mailInput.addEventListener('change', () => {
   console.log(mail.contain("@"));
   console.log('Mail changed to: ' + mail);
});


console.log('mdpInput:', mdpInput);

mdpInput.addEventListener('input', () => {

   console.log('mdp changed to: ' + mdpInput.value);
   console.log('mdpConf is: ' + mdpConfInput.value);

   if(mdpInput.value.length < 8) {
      mdpInput.classList.add('error');
      mdpInput.classList.remove('good');
   }else {
      mdpInput.classList.add('good');
      mdpInput.classList.remove('error');
   }

   if(mdpInput.value !== mdpConfInput.value) {
      mdpConfInput.setCustomValidity("Les mots de passe ne correspondent pas");

      fieldPassConf.classList.add('error');
      fieldPassConf.classList.remove("good")

   } else {
      mdpConfInput.setCustomValidity("");

      fieldPassConf.classList.remove('error');
      fieldPassConf.classList.add("good")

   }
});

mdpConfInput.addEventListener('input', () => {

   console.log('mdp changed to: ' + mdpInput.value);
   console.log('mdpConf is: ' + mdpConfInput.value);

   if(mdpInput.value !== mdpConfInput.value) {
      mdpConfInput.setCustomValidity("Les mots de passe ne correspondent pas");

      fieldPassConf.classList.add('error');
      fieldPassConf.classList.remove("good")

   } else {
      mdpConfInput.setCustomValidity("");

      fieldPassConf.classList.remove('error');
      fieldPassConf.classList.add("good")

   }
});


</script>


</html>