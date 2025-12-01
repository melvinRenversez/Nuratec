
<?php 


include("../php/database.php");

$query = "select id, nom from communes";
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

   <link rel="stylesheet" href="../assets/css/logInOut.css">

</head>

<body>

<?php 

if (isset($_GET["error"])) {
   if (isset($_GET["error"]) && $_GET["error"] == "emptyFields") {
      echo "<div class='popup'>Veuillez remplir tous les champs</div>";
   } else if (isset($_GET["error"]) && $_GET["error"] == "passwordsDontMatch") {
      echo "<div class='popup'>Les mots de passe ne correspondent pas</div>";
   } else if (isset($_GET["error"]) && $_GET["error"] == "emailAlreadyExists") {
      echo "<div class='popup'>Cet email est deja utilise</div>";
   } else if (isset($_GET["error"]) && $_GET["error"] == "phoneAlreadyExists") {
      echo "<div class='popup'>Ce numero de telephone est deja utilise</div>";
   } else if (isset($_GET["error"]) && $_GET["error"] == "OK") {
      echo "<div class='popup'>Inscription reussie</div>";
   } else if (isset($_GET["error"]) && $_GET["error"] == "OKconn") {
      echo "<div class='popup'>Connection reussie</div>";
   }
}

?>


<a href="../index.php" class="return">
   Retour
</a>


   <div class="overlay">


      <div class='container <?php if ($_GET["error"] == "OK") echo "active" ?> ' id="container">



         <div class="left">

            <p id="switch">Vous avez deja un compte ?</p>

            <h3>Insciption</h3>

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
                  <input type="email" placeholder=" " required id="mailInput" name="mail">
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
                  <input list="villeList" type="text" placeholder=" " required id="villeInput" >
                  <label for="">Ville</label>

                  <input type="hidden" id="villeInputHidden" name="ville">

               </div>

               <datalist id="villeList">

                  <?php foreach ($communes as $commune) { ?>
                     <option value="<?= $commune['nom'] ?>"></option>
                  <?php } ?>
                  
               </datalist>

               <div class="field">
                  <input type="text" placeholder=" " required list="codeList" id="codeInput" >
                  <label for="">Code postal</label>

                  <input type="hidden" id="codeInputHidden" name="code_postal" >
               </div>

               <datalist id="codeList">

               </datalist>

               <div class="field">
                  <input type="password" placeholder=" " required id="mdpInput" minlength="8" name="mdp">
                  <label for="">Mot de passe</label>
               </div>

               <div class="field" id="fieldPassConf">
                  <input type="password" placeholder=" " required id="mdpConfInput" minlength="8" name="mdpConf">
                  <label for="">Confirmer le mot de passe</label>
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