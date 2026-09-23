<?php
session_start();

function db_connect(): PDO
{
    $dsn = 'mysql:host=localhost;dbname=G3AVALTAPIZZA;charset=utf8mb4';
    $user = 'root';
    $password = '';

    try {
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $dbh;
    } catch (PDOException $ex) {
        die("Erreur lors de la connexion SQL : " . $ex->getMessage());
    }
}

$dbh = db_connect();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mdp = $_POST['password'] ?? '';

    $sql = "SELECT * FROM utilisateur WHERE email = :email";
    $sth = $dbh->prepare($sql);
    $sth->execute(['email' => $email]);

    $utilisateur = $sth->fetch();

    /*
      Pour une vraie inscription avec password_hash(), garde :
      if ($utilisateur && password_verify($mdp, $utilisateur['password'])) {

      Si ton utilisateur SQL test possède le mot de passe test1234
      directement dans la base, utilise temporairement cette ligne :
    */
    if ($utilisateur && $mdp === $utilisateur['password']) {
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id_user' => $utilisateur['id_user'],
            'login' => $utilisateur['login'],
            'email' => $utilisateur['email']
        ];

        $message = "
            <div style='
                color: #155724;
                background-color: #d4edda;
                border: 1px solid #c3e6cb;
                padding: 12px;
                margin-bottom: 15px;
                text-align: center;
                border-radius: 5px;
            '>
                Connexion réussie. Bienvenue " . htmlspecialchars($utilisateur['login']) . " !
            </div>
        ";
    } else {
        $message = "
            <div style='
                color: #ff4444;
                background-color: #ffe5e5;
                border: 1px solid #ff4444;
                padding: 12px;
                margin-bottom: 15px;
                text-align: center;
                border-radius: 5px;
            '>
                Adresse e-mail ou mot de passe incorrect.
            </div>
        ";
    }
}

$utilisateurConnecte = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVALTAPIZZA - Connexion</title>
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
            <h2>Connexion</h2>

            <?php echo $message; ?>

            <?php if ($utilisateurConnecte) : ?>

                <div style="
                    color: #155724;
                    background-color: #d4edda;
                    border: 1px solid #c3e6cb;
                    padding: 12px;
                    text-align: center;
                    border-radius: 5px;
                ">
                    Vous êtes connecté avec l'adresse :
                    <strong>
                        <?php echo htmlspecialchars($utilisateurConnecte['email']); ?>
                    </strong>
                </div>

            <?php else : ?>

                <form action="" method="POST">
                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            placeholder="nom@exemple.com"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="Votre mot de passe"
                        >
                    </div>

                    <button type="submit" class="btn-primary">
                        Se connecter
                    </button>
                </form>

                <p class="form-text-link">
                    Pas encore de compte ?
                    <a href="inscription.php">S'inscrire</a>
                </p>

            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés</p>
    </footer>

</body>
</html>