<?php
session_start();

if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: ../login&signup/index.php");
    die();
}

// Récupération des informations de réservation depuis les variables de session
$reservation_details = isset($_SESSION['reservation_details']) ? $_SESSION['reservation_details'] : array();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="corps">
        <div class="formulaire">
            <p class="titre">Information personnelle</p>
            <form action="" name="form1">
                <div class="input-nom-prenom">
                    <div class="titre-input1">
                        <p class="titre">Prénom</p>
                        <input type="text" name="Prenom" value="<?php echo isset($reservation_details['prenom']) ? $reservation_details['prenom'] : ''; ?>" required>
                    </div>
                    <div class="titre-input2">
                        <p class="titre">Nom</p>
                        <input type="text" name="Nom" value="<?php echo isset($reservation_details['nom']) ? $reservation_details['nom'] : ''; ?>" required>
                    </div>
                </div>
                <div class="titre-input">
                    <p class="titre">Email</p>
                    <input type="email" name="email" value="<?php echo isset($reservation_details['email']) ? $reservation_details['email'] : ''; ?>" placeholder="Ex:you@gmail.com" pattern="(^[a-z0-9]+)@([a-z0-9])+(\.)([a-z]{2,4})" required>
                </div>
                <div class="titre-input">
                    <p class="titre">Ville de départ</p>
                    <input type="text" name="ville_depart" value="<?php echo isset($reservation_details['ville_depart']) ? $reservation_details['ville_depart'] : ''; ?>" readonly>
                </div>
                <div class="titre-input">
                    <p class="titre">Ville d'arrivée</p>
                    <input type="text" name="ville_arrivee" value="<?php echo isset($reservation_details['ville_arrivee']) ? $reservation_details['ville_arrivee'] : ''; ?>" required>
                </div>
                <div class="input-pays-num">
                    <div class="pays">
                        <p class="titre">Type de billet</p>
                        <input type="text" name="classe" value="<?php echo isset($reservation_details['classe']) ? $reservation_details['classe'] : ''; ?>" required>
                    </div>
                    <div class="numero">
                        <p class="titre">Nombre de places</p>
                        <input type="number" name="nombre_places" value="<?php echo isset($reservation_details['nombre_places']) ? $reservation_details['nombre_places'] : ''; ?>" required>
                    </div>
                </div>
                <div class="titre-input">
                    <div class="input-type-submit">Envoyer</div>
                </div>
            </form>
        </div>
    </div>

    <style>   
        body {
            font-family: sans-serif;
        }
        .formulaire {
            width: 450px;
            margin: auto;
            border: 1px solid teal;
            padding: 15px;
        }
        .titre {
            color: teal;
            font-weight: bolder;
        }
        input {
            border-radius: 5px;
            border: 1px solid teal;
            height: 30px;
            width: 100%;
            outline: none;
            padding-left: 15px;
        }
        .input-nom-prenom {
            display: flex;
        }
        .titre-input1 {
            width: 45%;
        }
        .titre-input2 {
            width: 45%;
            margin-left: 30px; 
        }
        .titre-input {
            padding-right: 20px;
        }
        .titre-input3 {
            width: 45%;
        }
        .titre-input4 {
            width: 45%;
            margin-left: 30px; 
        }
        .titre-input0 {
            padding-right: 20px;
        }
        .input-pays-num {
            display: flex;
        }
        .numero {
            margin-left: 25px;
            margin-right: 25px;
        }
        .input-pays-num div {
            width: 127px;
        }
        .input-type-submit {
            background-color: green;
            color: whitesmoke;
            text-align: center;
            font-weight: bolder;
            margin-top: 15px;
            width: 440px;
           padding: 5px;
          
        }
       
        .macarte{
            width:450px;
            margin: auto;
            border: 1px solid teal;
            padding: 15px;
        }
        .input-type-submit2{
            margin: auto;
            background-color: green;
            color: whitesmoke;
            text-align: center;
            font-weight: bolder;
            margin-top: 15px;
            width:440px;
            padding: 5px;
        }
    </style>

    <script src="html2pdf.bundle.js"></script> <!-- la bibliotheque html2js Telecharger sur github; -->
    <script>
      
        var corps=document.querySelector(".corps");
        var btn=document.querySelector(".input-type-submit");
        
        btn.onclick=()=>{
            var form1 = document.form1;

            corps.innerHTML=`<div class="macarte">
                <p class="titre">Détails de vos Informations personnelles</p>
                <div class="input-nom-prenom" >
                    <div class="titre-input1" >
                         <p class="titre">Prenom : <strong style="color: black;">${form1.Prenom.value}</strong></p>
                    </div>
                    <div class="titre-input2" >
                        <p class="titre">Nom :<strong style="color: black;">${form1.Nom.value}</strong> </p>
                    </div>
                </div>  
                <div class="titre-input" >
                    <p class="titre">Email:  <strong style="color: black;">${form1.email.value}</strong></p>
                </div>
                <div class="titre-input" >
                    <p class="titre">Ville de départ :<strong style="color: black;">${form1.Adresse.value}</strong></p> 
                </div>
                <div class="titre-input" >
                    <p class="titre">Ville d'arrivée :<strong style="color: black;">${form1.username.value}</strong></p>
                </div>
                <div class="titre-input" >
                    <p class="titre">Type de billet :<strong style="color: black;">${form1.Pays.value}</strong></p>
                </div>
                <div >
                    <p class="titre">Nombre de place  <strong style="color: black;">${form1.Numero.value}</strong></p>
                </div>
                <p class="titre">Détails de Paiement</p>
                <div class="input-nom-prenom" >
                    <div class="titre-input3" >
                         <p class="titre">Prix des bagages : <strong style="color: black;">${form1.value}</strong></p>
                    </div>
                    <div class="titre-input4" >
                        <p class="titre">Prix du ticket :<strong style="color: black;">${form1.value}</strong> </p>
                    </div>
                </div>  
                <div class="titre-input0" >
                    <p class="titre">Montant Net à Payer  <strong style="color: black;">${form1.value}</strong></p>
                </div>
            </div>
            <div class="input-type-submit2">Telecharger</div>`;

            var btn2 = document.querySelector(".input-type-submit2");
            var element = document.querySelector(".macarte");
            btn2.onclick = () => {
                html2pdf().from(element).save("lefichierpdf");
            }
        }
    </script>
</body>
</html>
