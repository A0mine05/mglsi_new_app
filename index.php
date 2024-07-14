<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Actualités</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php
                // Connexion à la base de données (à inclure depuis config.php)
                require_once 'config.php';
                
                // Récupérer les catégories
                $sql = "SELECT id, libelle FROM Categorie";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    // Afficher les catégories dans le menu
                    while($row = $result->fetch_assoc()) {
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown' . $row['id'] . '" role="button" aria-haspopup="true" aria-expanded="false">';
                        echo $row['libelle'];
                        echo '</a>';
                        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown' . $row['id'] . '">';
                        
                        // Récupérer les articles de cette catégorie
                        $categorie_id = $row['id'];
                        $sql_articles = "SELECT id, titre FROM Article WHERE categorie = $categorie_id";
                        $result_articles = $conn->query($sql_articles);
                        
                        if ($result_articles->num_rows > 0) {
                            while($article = $result_articles->fetch_assoc()) {
                                echo '<a class="dropdown-item" href="news.php?id=' . $article['id'] . '">' . $article['titre'] . '</a>';
                            }
                        } else {
                            echo '<a class="dropdown-item" href="#">Aucune actualité</a>';
                        }
                        echo '</div>';
                        echo '</li>';
                    }
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="#">Aucune catégorie trouvée</a></li>';
                }

                ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="my-4">Actualités par Catégorie</h1>
        <!-- Contenu principal de la page -->
    </div>
    
    <div class="row">
        <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
                <?php
                // Réutilisation des données de catégories et articles
                if ($result->num_rows > 0) {
                    $result->data_seek(0); // Remettre le pointeur au début
                    while($row = $result->fetch_assoc()) {
                        echo '<a class="list-group-item list-group-item-action" id="list-' . $row['libelle'] . '-list" data-bs-toggle="list" href="#list-' . $row['libelle'] . '" role="tab" aria-controls="list-' . $row['libelle'] . '">' . $row['libelle'] . '</a>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
                <?php
                // Réutilisation des données d'articles
                if ($result->num_rows > 0) {
                    $result->data_seek(0); // Remettre le pointeur au début
                    while($row = $result->fetch_assoc()) {
                        $categorie_id = $row['id'];
                        $mes_articles_bd = "SELECT id, titre, contenu FROM Article WHERE categorie = $categorie_id";
                        $retour_articles = $conn->query($mes_articles_bd);
                        
                        echo '<div class="tab-pane fade" id="list-' . $row['libelle'] . '" role="tabpanel" aria-labelledby="list-' . $row['libelle'] . '-list">';
                        
                        if ($retour_articles->num_rows > 0) {
                            while($article = $retour_articles->fetch_assoc()) {
                                echo '<h4>' . $article['titre'] . '</h4>';
                                echo '<p>' . $article['contenu'] . '</p>';
                                echo '<hr>';
                            }
                        } else {
                            echo '<p>Aucun article dans cette rubrique</p>';
                        }
                        
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Script pour afficher/cacher les articles au clic sur le menu
        $(document).ready(function(){
            $('.dropdown-toggle').click(function(e){
                e.preventDefault();
                $(this).next('.dropdown-menu').slideToggle();
            });
            
            // Script pour basculer entre les onglets du deuxième menu
            $('#list-tab a').on('click', function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
</body>
</html>
