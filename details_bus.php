<!-- Deuxième colonne (informations de bus) -->
<div class="col" data-aos="fade-up" data-aos-delay="300">
        <div class="card mb-5 mb-lg-0" style="height: 490px;">
            <div class="card-body">
                <h6 class="card-price text-center">Informations Bus</h6>
                <hr>
                <ul class="fa-ul" style="list-style-type: none;">
                    <?php
                    // ID du bus à afficher
                    $bus_id = 1; // Remplacez 1 par l'ID du bus souhaité
    
                    // Requête pour récupérer les informations du bus avec l'ID spécifié
                    $bus_query = mysqli_query($conn, "SELECT * FROM bus WHERE id_bus = $bus_id");
    

                    // Vérification s'il y a des résultats
                    if (mysqli_num_rows($bus_query) > 0) {
                        // Parcours des résultats et affichage des informations
                        while ($bus_row = mysqli_fetch_assoc($bus_query)) {
                            echo "<li><span class='fa-li'><i class='fa fa-check'></i></span><strong>plaque d'immatriculation:</strong> " . $bus_row['plaque_immatriculation'] . "</li>";
                            echo "<li><span class='fa-li'><i class='fa fa-check'></i></span><strong>Classe :</strong> " . $bus_row['type_bus'] . "</li>";
                            echo "<li><span class='fa-li'><i class='fa fa-check'></i></span><strong>nom du chauffeur:</strong> " . $bus_row['nom_chauffeur'] . "</li>";
                            echo "<li><span class='fa-li'><i class='fa fa-check'></i></span><strong>nombre de sieges disponibles:</strong> " . $bus_row['nbre_siege'] . "</li>";
                        }
                    }
                    ?>
                </ul>
                <hr>
            </div>
        </div>
    </div>
</div>
</div>