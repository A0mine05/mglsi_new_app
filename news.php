<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Actualité</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Actualité</h1>
        <div class="card">
            <div class="card-body">
                <?php
                include 'config.php';

                // Récupérer l'ID de l'actualité depuis l'URL
                $id = $_GET['id'];

                // Récupérer l'actualité correspondante
                $sql = "SELECT titre, contenu, dateCreation, dateModification FROM Article WHERE id = $id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Afficher l'actualité
                    while($row = $result->fetch_assoc()) {
                        echo '<h2 class="card-title">' . $row['titre'] . '</h2>';
                        echo '<p class="card-text">' . $row['contenu'] . '</p>';
                        echo '<p class="card-text"><small class="text-muted">Créé le : ' . $row['dateCreation'] . ' | Modifié le : ' . $row['dateModification'] . '</small></p>';
                    }
                } else {
                    echo "Aucune actualité ";
                }

                // Fermer la connexion
                $conn->close();
                ?>
            </div>
        </div>
        <br>
        <a class="btn btn-primary" href="index.php">Retour aux actualités</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
