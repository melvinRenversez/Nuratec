<?php
session_start();
include("../php/admin/verifyUser.php");
include("../php/popup.php");

include("../php/database.php");

$query = 'SELECT u.id, u.nom, u.prenom , u.created_at, u.mail, u.telephone, u.adresse,  c.nom as ville, cp.code_postal, activation_code, activated
FROM users u
join communes c on c.id = ville_id
join codes_postaux cp on cp.id = u.code_postal_id
order by id DESC';
$stmt = $db->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../assets/css/popup.css">
    <link rel="stylesheet" href="../assets/admin/css/nav.css">
    <link rel="stylesheet" href="../assets/admin/css/users.css">

    <script src="../assets/admin/js/delete.js" defer></script>
</head>

<body>



    <nav>

        <ul>

            <li><a href="./home.php">Home</a></li>
            <li><a href="./type_appareil.php">Type d'appareil</a></li>
            <li><a href="./marque_appareil.php">Marque d'appareil</a></li>
            <li><a href="./modele_appareil.php">Modele d'appareil</a></li>
            <li><a href="./prise_en_charge.php">Prise en charge</a></li>
            <li><a href="./reparations.php">Reparations</a></li>
            <li class='actif'><a href="./users.php">Users</a></li>

            <div class="gap"></div>

            <li><a href="../php/logout.php">Deconnection</a></li>
        </ul>

    </nav>


    <div class="container">

        <table>
            <thead>
                <tr>
                    <th class='id'>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Mail</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Ville</th>
                    <th>Code postal</th>
                    <th>Code d'activation</th>
                    <th class='total'>Activer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr
                        onclick="sendMail( <?php echo $user['id'] ?>, '<?php echo $user['activation_code'] ?>', '<?php echo $user['mail'] ?>')">
                        <td class='id'><?php echo $user['id'] ?></td>
                        <td><?php echo $user['nom'] ?></td>
                        <td><?php echo $user['prenom'] ?></td>
                        <td><?php echo $user['mail'] ?></td>
                        <td>
                            <?php
                            $tel = preg_replace('/\D+/', '', $user['telephone']);
                            echo trim(chunk_split($tel, 2, ' '));
                            ?>
                        </td>

                        <td><?php echo $user['adresse'] ?></td>
                        <td><?php echo $user['ville'] ?></td>
                        <td><?php echo $user['code_postal'] ?></td>
                        <td title=" <?= htmlspecialchars($user['activation_code']) ?> ">
                            <?php echo $user['activation_code'] ?>
                        </td>
                        <!-- <td class="total"><?php echo $user['activated'] ?></td> -->
                        <td class="total">
                            <div class="center">
                                <input type="checkbox" name="" id="" <?php if ($user["activated"])
                                    echo "checked" ?>
                                        readonly </div>

                            </td>
                        </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    </div>

</body>
<script>
    function sendMail(id, code, mail) {
        const to = mail;

        const subject = encodeURIComponent(
            "Activation de votre compte sur le site de Nuratec"
        );

        const activationLink =
            "http://172.27.44.135/Nuratec/pages/activation.php?ac=" + code;

        const dropLink = 
            "http://172.27.44.135/Nuratec/pages/dropAccount.php?ac=" + code;

        const body = encodeURIComponent(
            "Bonjour,\n\n" +
            "Merci pour votre inscription sur le site de Nuratec.\n\n" +
            "Pour activer votre compte, veuillez cliquer sur le lien ci-dessous :\n\n" +
            activationLink + "\n\n" +
            "Si vous n’êtes pas à l’origine de cette demande, vous pouvez supprimer votre compte en cliquant sur le lien ci-dessous .\n\n" +
            dropLink + "\n\n" +
            "Cordialement,\n" +
            "L’équipe Nuratec"
        );

        const gmailUrl =
            "https://mail.google.com/mail/?view=cm&fs=1" +
            "&to=" + to +
            "&su=" + subject +
            "&body=" + body;

        window.open(gmailUrl, "_blank");
    }
</script>

</html>