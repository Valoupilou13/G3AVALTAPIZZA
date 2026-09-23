<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVALTAPIZZA - Inscription</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <img src="img/logo.png" alt="Logo AVALTAPIZZA">
        <h1>AVALTAPIZZA</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="produits.php">Carte & Produits</a>
            <a href="connexion.php">Connexion</a>
            <a href="inscription.php">Inscription</a>
            <a href="deconnexion.php">Déconnexion</a>
        </nav>
    </header>

    <main class="container">
        <div class="form-box">
            <h2>Inscription</h2>
            <form id="formulaire" action="connexion.php" method="GET">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="nom@exemple.com" required>
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="mdp" name="mdp" required>
                </div>
                <button type="submit" name="submit" class="btn-primary">S'inscrire</button>
            </form>
            <p class="form-text-link">
                Vous avez déjà un compte ? <a href="connexion.php">Se connecter</a>
            </p>
        </div>
    </main>

    <?php

// 1. Paramètres de connexion
$dsn = 'mysql:host=localhost;dbname=mabase'; 
$user = 'root';
$password = '';

// 2. Connexion à la base de données
try {
    $dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Erreur lors de la connexion SQL : " . $ex->getMessage());
}

// 3. Traitement de l'inscription après soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';

    // Ordre SQL d'insertion
    $sql = "INSERT INTO personnes (nom, prenom, email) VALUES (:nom, :prenom, :email)";

    try {
        // Préparation de la requête SQL
        $sth = $dbh->prepare($sql);

        // Exécution avec passage des paramètres dans un tableau associatif
        $sth->execute(array(
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email
        ));

        // Vérification de l'insertion
        if ($sth->rowCount() > 0) {
            $nouveauId = $dbh->lastInsertId();
            echo "<p>Inscription réussie ! L'utilisateur porte l'ID n° : " . $nouveauId . "</p>";
        }
    } catch (PDOException $ex) {
        die("Erreur lors de la requête SQL : " . $ex->getMessage());
    }
}
?>



    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés</p>
    </footer>

</body>
</html>