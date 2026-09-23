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
            <form id="formulaire" action="" method="POST">
                <div class="form-group">
                    <label>Identifiant :</label>
                    <input type="text" name="login" required>
                </div>
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
// 1. Définition de la fonction de connexion à la BDD
function db_connect() : PDO {
    $dsn = 'mysql:host=localhost;dbname=G3AVALTAPIZZA'; 
    $user = 'root'; 
    $password = ''; 

    try {
        $dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    } catch (PDOException $ex) {
        die("Erreur de connexion à la BDD : " . $ex->getMessage());
    }
}

$message = "";

// 2. Traitement lors de la soumission du formulaire en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    $dbh = db_connect();

    // Récupération des champs du formulaire
    $login = $_POST['login'] ?? '';
    $email = $_POST['email'] ?? '';
    $pass  = $_POST['mdp'] ?? ''; // Correction : 'mdp' au lieu de 'password'

    // Hachage du mot de passe
    $passwordHash = password_hash($pass, PASSWORD_DEFAULT);

    // Requête SQL d'insertion
    $sql = "INSERT INTO utilisateur (login, password, email) VALUES (:login, :password, :email)";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':login'    => $login,
            ':password' => $passwordHash,
            ':email'    => $email
        ));

        if ($sth->rowCount() > 0) {
    // Redirection vers connexion.php avec un paramètre d'information
        header('Location: connexion.php?inscription=succes');
        exit(); // Stoppe l'exécution du script pour forcer la redirection
}
    } catch (PDOException $ex) {
        $message = "<p style='color:red;'>Erreur lors de l'inscription : " . $ex->getMessage() . "</p>";
    }
}
?>



    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés</p>
    </footer>

</body>
</html>