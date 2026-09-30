<?php
session_start();

// Connexion BDD (optionnelle pour vérifier la commande)
$host = 'localhost';
$dbname = 'G3AVALTAPIZZA';
$username = 'root';
$password = '';

// Récupération des données transmises ou valeurs par défaut de démonstration
$idCommande = $_GET['id_commande'] ?? $_SESSION['derniere_commande_id'] ?? '1042';
$totalCommande = $_GET['total'] ?? $_SESSION['derniere_commande_total'] ?? '21.00';

if (isset($_GET['id_commande'])) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $stmt = $pdo->prepare("SELECT * FROM commande WHERE id_commande = :id");
        $stmt->execute(['id' => $_GET['id_commande']]);
        $commande = $stmt->fetch();

        if ($commande) {
            $idCommande = $commande['id_commande'];
            $totalCommande = number_format($commande['total_commande'], 2, ',', ' ');
        }
    } catch (PDOException $e) {
        // En cas d'erreur de connexion, les valeurs GET/SESSION restent utilisées
    }
}

// Récupération de l'utilisateur connecté s'il y en a un
$utilisateurConnecte = $_SESSION['user'] ?? null;
$emailClient = $utilisateurConnecte['email'] ?? 'votre adresse e-mail';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVALTAPIZZA - Confirmation de commande</title>
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
        <div class="form-box text-center" style="max-width: 650px; margin: 2rem auto; padding: 2rem;">
            
            <div style="font-size: 3rem; margin-bottom: 1rem;">👍</div>

            <h2>Confirmation de votre commande</h2>

            <div style="color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin: 1.5rem 0; border-radius: 5px;">
                <strong>Paiement validé !</strong><br>
                Votre commande <strong>n° <?= htmlspecialchars($idCommande) ?></strong> d'un montant de <strong><?= htmlspecialchars($totalCommande) ?> €</strong> est en cours de préparation.
            </div>

            <p style="margin-bottom: 1.5rem; font-size: 1.05rem;">
                Vous recevrez un message sur <strong><?= htmlspecialchars($emailClient) ?></strong> dès qu'elle sera prête.
            </p>

            <p style="font-weight: bold; font-size: 1.2rem; margin-bottom: 2rem; color: var(--secondary);">
                Merci pour votre confiance !
            </p>

            <div class="auth-buttons" style="justify-content: center;">
                <a href="index.php" class="btn-primary">Revenir à l'accueil</a>
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés.</p>
    </footer>

</body>
</html>