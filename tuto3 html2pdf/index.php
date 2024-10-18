<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taziya";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour récupérer les informations de la dernière réservation effectuée
$sql_reservation = "SELECT * FROM reservation ORDER BY id_reservation DESC LIMIT 1";
$result_reservation = $conn->query($sql_reservation);
$row_reservation = $result_reservation->fetch_assoc();

// Requête SQL pour récupérer les informations de paiement correspondant à la dernière réservation effectuée
$sql_paiement = "SELECT * FROM paiement WHERE id_reservation = " . $row_reservation['id_reservation'];

$result_paiement = $conn->query($sql_paiement);
$row_paiement = $result_paiement->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download TICKET TAZIYA</title>
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
            line-height: 1.2; /* Réduction de l'espace interligne */
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

        .titre-input1, .titre-input2 {
            width: 45%;
        }

        .titre-input2 {
            margin-left: 30px;
        }

        .titre-input5 {
            text-align: center;
            line-height: 1.2; /* Réduction de l'espace interligne */
        }

        .titre-input {
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

        .macarte {
            width: 450px;
            margin: auto;
            border: 1px solid teal;
            padding: 15px;
            overflow: hidden; /* Ajouté pour éviter les coupures */
            line-height: 1.2; /* Réduction de l'espace interligne */
        }

        .input-type-submit2 {
            margin: auto;
            background-color: green;
            color: whitesmoke;
            text-align: center;
            font-weight: bolder;
            margin-top: 15px;
            width: 440px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="corps"></div>

    <script src="html2pdf.bundle.js"></script> <!-- la bibliothèque html2pdf Télécharger sur github; -->
    <script>
        // Données PHP encodées en JSON pour utilisation en JavaScript
        const reservation = <?php echo json_encode($row_reservation); ?>;
        const paiement = <?php echo json_encode($row_paiement); ?>;

        var corps = document.querySelector(".corps");

        // Fonction pour insérer les données dans le DOM
        function afficherInformations() {
            corps.innerHTML = `
                <div class="macarte">
                    <div class="titre-input5">
                        <p class="titre"><strong style="color: black;">${reservation.nom_agence}</strong> le ${reservation.date_reservation} (<strong style="color: red;">Expiration du billet après 24h</strong>)</p>
                         </div>
                    <hr>
                    <p class="titre">Détails de vos Informations personnelles</p>
                    <div class="input-nom-prenom">
                        <div class="titre-input1">
                            <p class="titre">Prenom : <strong style="color: black;">${reservation.prenom}</strong></p>
                        </div>
                        <div class="titre-input2">
                            <p class="titre">Nom : <strong style="color: black;">${reservation.nom}</strong></p>
                        </div>
                    </div>  
                    <div class="input-nom-prenom">
                        <div class="titre-input1">
                            <p class="titre">Ville de départ : <strong style="color: black;">${reservation.ville_depart}</strong></p> 
                        </div>
                        <div class="titre-input2">
                            <p class="titre">Ville d'arrivée : <strong style="color: black;">${reservation.ville_arrivee}</strong></p>
                        </div>
                    </div> 
                    <div class="titre-input">
                        <p class="titre">Heure de départ : <strong style="color: black;">${reservation.heure_depart}</strong></p>
                    </div>
                    <div class="input-nom-prenom">
                        <div class="titre-input1">
                            <p class="titre">Type de billet : <strong style="color: black;">${reservation.classe}</strong></p>
                        </div>
                        <div class="titre-input2">
                            <p class="titre">Nombre de place : <strong style="color: black;">${reservation.nombre_places}</strong></p>
                        </div>
                    </div>
                    <hr>
                    <p class="titre">Détails de Paiement</p> 
                    <div class="input-nom-prenom">
                        <div class="titre-input1">
                            <p class="titre">Prix des bagages : <strong style="color: black;">${paiement.prix_bagages}F</strong></p>
                        </div>
                        <div class="titre-input2">
                            <p class="titre">Prix du(s) ticket : <strong style="color: black;">${paiement.prix_ticket}F</strong></p>
                        </div>
                    </div>  
                    <div class="titre-input">
                        <p class="titre">Montant Net à Payer : <strong style="color: black;">${paiement.montantnetPayer}F</strong></p>
                    </div>
                </div>
                <div class="input-type-submit2">Télécharger</div>
            `;

            var btn2 = document.querySelector(".input-type-submit2");
            var element = document.querySelector(".macarte");
            btn2.onclick = () => {
                const opt = {
                    margin: [0.5, 0.5, 0.5, 0.5],  // Ajustement des marges
                    filename: 'ticketTAZTIYA.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2, useCORS: true },  // Ajustement de html2canvas
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                };
                html2pdf().set(opt).from(element).save();
            }
        }

        // Appel de la fonction pour insérer les données dans le DOM dès le chargement de la page
        afficherInformations();
    </script>
</body>
</html>
