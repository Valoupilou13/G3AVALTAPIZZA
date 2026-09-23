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
            <a href="connexion.php">Connexion</a>
            <a href="inscription.php">Inscription</a>
            <a href="deconnexion.php">Déconnexion</a>
        </nav>
    </header>

    <main class="container">
        <section>
            <h2>À propos de notre pizzeria</h2>
            <p>
                Chez <strong>AVALTAPIZZA</strong>, nous préparons nos pizzas avec des ingrédients frais et sélectionnés. 
                Consultez notre carte, faites votre choix en quelques clics et indiquez si vous souhaitez manger sur place ou emporter votre commande.
            </p>
        </section>

        <section>
            <h2>Rejoignez-nous pour commander</h2>
            <p>Pour passer votre commande, veuillez vous identifier ou créer un compte client :</p>
            <div class="auth-buttons">
                <a href="connexion.php" class="btn-primary">Se connecter</a>
                <a href="inscription.php" class="btn-secondary">S'inscrire</a>
                <a href="produits.php" class="btn-primary">Voir la carte</a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés</p>
    </footer>

</body>
</html>
