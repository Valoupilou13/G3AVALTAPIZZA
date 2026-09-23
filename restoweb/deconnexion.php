<?php
session_start();

$message = '';

/* La déconnexion se fait uniquement après un clic sur le bouton */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $_SESSION = [];

    /* Supprime le cookie de session du navigateur */
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    /* Détruit les données de la session côté serveur */
    session_destroy();

    $message = 'Vous avez bien été déconnecté.';
}

$utilisateurConnecte = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVALTAPIZZA - Déconnexion</title>
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
        <div class="form-box text-center">
            <h2>Déconnexion</h2>

            <?php if ($message !== '') : ?>

                <div style="
                    color: #155724;
                    background-color: #d4edda;
                    border: 1px solid #c3e6cb;
                    padding: 12px;
                    margin-bottom: 20px;
                    text-align: center;
                    border-radius: 5px;
                ">
                    <?php echo htmlspecialchars($message); ?>
                </div>

                <div class="auth-buttons">
                    <a href="index.php" class="btn-primary">
                        Retour à l'accueil
                    </a>

                    <a href="connexion.php" class="btn-primary">
                        Se reconnecter
                    </a>
                </div>

            <?php elseif ($utilisateurConnecte) : ?>

                <p>
                    Vous êtes connecté avec l'adresse :
                    <strong>
                        <?php echo htmlspecialchars($utilisateurConnecte['email']); ?>
                    </strong>
                </p>

                <p>Voulez-vous vraiment vous déconnecter ?</p>

                <form action="" method="POST">
                    <button type="submit" class="btn-primary">
                        Se déconnecter
                    </button>
                </form>

            <?php else : ?>

                <div style="
                    color: #856404;
                    background-color: #fff3cd;
                    border: 1px solid #ffeeba;
                    padding: 12px;
                    margin-bottom: 20px;
                    text-align: center;
                    border-radius: 5px;
                ">
                    Vous n'êtes pas connecté.
                </div>

                <div class="auth-buttons">
                    <a href="connexion.php" class="btn-primary">
                        Aller à la connexion
                    </a>
                </div>

            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés</p>
    </footer>

</body>
</html>