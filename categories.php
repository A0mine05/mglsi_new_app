<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles par Catégorie</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="logo.jpg" alt="Logo Actualités" height="50">
            Actualités
        </a>
    </nav>
    <div class="container">
        <h1 class="my-4">Articles par Catégorie</h1>
        <div class="row">
            <div class="col-4">
                <div class="list-group" id="list-tab" role="tablist">
                    <?php
                    include 'config.php';

                    // Récupérer les catégories
                    $sql = "SELECT id, libelle FROM Categorie";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Afficher les catégories dans le menu
                        while($row = $result->fetch_assoc()) {
                            echo '<a class="list-group-item list-group-item-action" id="list-cat' . $row['id'] . '" data-toggle="list" href="#list-cat' . $row['id'] . '" role="tab" aria-controls="list-cat' . $row['id'] . '">' . $row['libelle'] . '</a>';
                        }
                    } else {
                        echo 'Aucune catégorie trouvée.';
                    }

                    // Fermer la connexion
                    $conn->close();
                    ?>
                </div>
            </div>
            <div class="col-8">
                <div class="tab-content" id="nav-tabContent">
                    <?php
                    include 'config.php';

                    // Récupérer les articles par catégorie
                    $sql = "SELECT id, titre, contenu FROM Article WHERE categorie = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $categorie);

                    // Afficher les articles par catégorie
                    $sql_categories = "SELECT id FROM Categorie";
                    $result_categories = $conn->query($sql_categories);

                    if ($result_categories->num_rows > 0) {
                        while ($cat = $result_categories->fetch_assoc()) {
                            $categorie = $cat['id'];
                            $stmt->execute();
                            $result_articles = $stmt->get_result();

                            echo '<div class="tab-pane fade" id="list-cat' . $categorie . '" role="tabpanel" aria-labelledby="list-cat' . $categorie . '">';
                            if ($result_articles->num_rows > 0) {
                                while($article = $result_articles->fetch_assoc()) {
                                    echo '<div class="card mb-3">';
                                    echo '<div class="card-body">';
                                    echo '<h5 class="card-title">' . $article['titre'] . '</h5>';
                                    echo '<p class="card-text">' . $article['contenu'] . '</p>';
                                    echo '<a href="news.php?id=' . $article['id'] . '" class="btn btn-primary">Lire plus</a>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>Aucun article trouvé pour cette catégorie.</p>';
                            }
                            echo '</div>';
                        }
                    } else {
                        echo 'Aucune catégorie trouvée.';
                    }

                    // Fermer la connexion
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
