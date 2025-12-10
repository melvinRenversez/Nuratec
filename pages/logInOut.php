<?php 

include("../php/database.php");
include("../php/popup.php");

$query = "select id, nom from communes ORDER BY nom ASC";
$stmt = $db->prepare($query);
$stmt->execute();
$communes = $stmt->fetchAll();

$query = "select id, code_postal, commune_id from codes_postaux";
$stmt = $db->prepare($query);
$stmt->execute();
$codes_postaux = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>

   <link rel="stylesheet" href="../assets/css/popup.css">
   <link rel="stylesheet" href="../assets/css/logInOut.css">

</head>

<body>

   <div class="overlay">

      <div class='container <?php if ($_GET["error"] == "OK") echo "active" ?> ' id="container">

         <div class="left">

            <p id="switch">Vous avez déjà un compte ?</p>

            <h3>Inscription</h3>

            <form action="../php/register.php" method="POST">

               <div class="field">
                  <input type="text" placeholder=" " required name="nom">
                  <label for="">Nom</label>
               </div>

               <div class="field">
                  <input type="text" placeholder=" " required name="prenom">
                  <label for="">Prénom</label>
               </div>

               <div class="field">
                  <input type="email" placeholder=" " required name="mail">
                  <label for="">Email</label>
               </div>

               <div class="field">
                  <input type="text" placeholder=" " required name="telephone">
                  <label for="">Telephone</label>
               </div>

               <div class="field">
                  <input type="text" placeholder=" " required name="adresse">
                  <label for="">Adresse</label>
               </div>

               <div class="field">
                  <select id="villeSelect" name="ville" required>
                     <option value="">-- Sélectionnez une ville --</option>
                     <?php foreach ($communes as $commune) { ?>
                        <option value="<?= $commune['id'] ?>"><?= $commune['nom'] ?></option>
                     <?php } ?>
                  </select>
                  <label for="">Ville</label>
               </div>

               <div class="field">
                  <select id="codeSelect" name="code_postal" required>
                     <option value="">-- Sélectionnez un code postal --</option>
                  </select>
                  <label for="">Code postal</label>
               </div>

               <div class="field">
                  <input type="password" placeholder=" " required id="mdpInput" minlength="8" name="mdp">
                  <label for="">Mot de passe</label>
               </div>

               <div class="field" id="fieldPassConf">
                  <input type="password" placeholder=" " required id="mdpConfInput" minlength="8" name="mdpConf">
                  <label for="">Confirmez le mot de passe</label>
               </div>

               <button type="submit">S'inscrire</button>

            </form>

         </div>

         <div class="right">

            <p id="switch">Vous n'avez pas de compte ?</p>

            <h3>Connexion</h3>
            <form action="../php/login.php" method="POST">

               <div class="field">
                  <input type="email" placeholder=" " required name="mail">
                  <label for="">Email</label>
               </div>

               <div class="field">
                  <input type="password" placeholder=" " required minlength="8" name="password">
                  <label for="">Mot de passe</label>
               </div>

               <button type="submit">Connexion</button>
            </form>

         </div>

      </div>

   </div>

</body>

<script>
const allSwitch = document.querySelectorAll('#switch');
const container = document.getElementById('container');

const communes = <?php echo json_encode($communes); ?>;
const codes_postaux = <?php echo json_encode($codes_postaux); ?>;

const villeSelect = document.getElementById('villeSelect');
const codeSelect = document.getElementById('codeSelect');

const mdpInput = document.getElementById('mdpInput');
const mdpConfInput = document.getElementById('mdpConfInput');
const fieldPassConf = document.getElementById('fieldPassConf');

allSwitch.forEach(element => {
   element.addEventListener('click', () => {
      container.classList.toggle('active');
   });
});

villeSelect.addEventListener('change', () => {
   const villeId = villeSelect.value;
   codeSelect.innerHTML = '<option value="">-- Sélectionnez un code postal --</option>';
   const codes = codes_postaux.filter(c => c.commune_id == villeId);
   codes.forEach(c => {
      const option = document.createElement('option');
      option.value = c.id;
      option.textContent = c.code_postal;
      codeSelect.appendChild(option);
   });
});

mdpInput.addEventListener('input', () => {
   if(mdpInput.value.length < 8) {
      mdpInput.classList.add('error');
      mdpInput.classList.remove('good');
   } else {
      mdpInput.classList.add('good');
      mdpInput.classList.remove('error');
   }

   if(mdpInput.value !== mdpConfInput.value) {
      mdpConfInput.setCustomValidity("Les mots de passe ne correspondent pas");
      fieldPassConf.classList.add('error');
      fieldPassConf.classList.remove("good");
   } else {
      mdpConfInput.setCustomValidity("");
      fieldPassConf.classList.remove('error');
      fieldPassConf.classList.add("good");
   }
});

mdpConfInput.addEventListener('input', () => {
   if(mdpInput.value !== mdpConfInput.value) {
      mdpConfInput.setCustomValidity("Les mots de passe ne correspondent pas");
      fieldPassConf.classList.add('error');
      fieldPassConf.classList.remove("good");
   } else {
      mdpConfInput.setCustomValidity("");
      fieldPassConf.classList.remove('error');
      fieldPassConf.classList.add("good");
   }
});
</script>

</html>
