<?php
session_start();

// Vérification du statut de connexion (compatible avec $_SESSION['id_user'] ou $_SESSION['user'])
$estConnecte = isset($_SESSION['id_user']) || isset($_SESSION['user']);
$loginUser = $_SESSION['login'] ?? $_SESSION['user']['login'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVALTAPIZZA - Accueil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <img src="img/logo.png" alt="Logo AVALTAPIZZA">
        <h1>Bienvenue chez AVALTAPIZZA</h1>
        <p>Vos pizzas artisanales à déguster sur place ou à emporter !</p>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="produits.php">Carte & Produits</a>
            <?php if ($estConnecte) : ?>
                <a href="deconnexion.php">Déconnexion (<?= htmlspecialchars($loginUser) ?>)</a>
            <?php else : ?>
                <a href="connexion.php">Connexion</a>
                <a href="inscription.php">Inscription</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="container">

        <!-- Bannière d'accueil dynamique -->
        <section class="hero-banner">
            <h2>À propos de notre pizzeria</h2>
            <p>
                Chez <strong>AVALTAPIZZA</strong>, nous préparons nos pizzas avec des ingrédients frais et sélectionnés avec soin. 
                Consultez notre carte, faites votre choix en quelques clics et indiquez si vous souhaitez manger sur place ou emporter votre commande.
            </p>

            <?php if ($estConnecte) : ?>
                <!-- Contenu affiché si l'utilisateur est CONNECTÉ -->
                <div class="user-welcome-box" style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px dashed var(--border-color);">
                    <p style="font-size: 1.1rem; color: var(--secondary); margin-bottom: 1.5rem;">
                        Ravi de vous revoir, <strong><?= htmlspecialchars($loginUser) ?></strong> ! Prêt à passer votre commande ?
                    </p>
                    <div class="hero-actions">
                        <a href="produits.php" class="btn-primary">Commander maintenant</a>
                        <a href="deconnexion.php" class="btn-secondary">Se déconnecter</a>
                    </div>
                </div>
            <?php else : ?>
                <!-- Contenu affiché si l'utilisateur N'EST PAS connecté -->
                <div class="auth-box-index" style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px dashed var(--border-color);">
                    <p style="margin-bottom: 1.2rem;">Pour passer votre commande, veuillez vous identifier ou créer un compte client :</p>
                    <div class="hero-actions">
                        <a href="connexion.php" class="btn-primary">Se connecter</a>
                        <a href="inscription.php" class="btn-secondary">S'inscrire</a>
                        <a href="produits.php" class="btn-primary">Voir la carte</a>
                    </div>
                </div>
            <?php endif; ?>
        </section>

        <!-- Points forts de la pizzeria -->
        <section>
            <div class="features-grid">
                <div class="feature-card">
                    <h3>Pâte Artisanale</h3>
                    <p>Pétrie chaque jour sur place et maturée au minimum 24h pour une pâte croustillante et digeste.</p>
                </div>
                <div class="feature-card">
                    <h3>Produits Frais</h3>
                    <p>Ingrédients soigneusement sélectionnés : légumes locaux, charcuteries et fromages italiens AOP.</p>
                </div>
                <div class="feature-card">
                    <h3>Sur Place ou À Emporter</h3>
                    <p>Commandez en ligne et choisissez votre mode de dégustation en un instant.</p>
                </div>
            </div>
        </section>

    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés</p>
    </footer>

</body>
</html>
