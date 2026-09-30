<?php
session_start();

// 1. Connexion à la BDD
$host = 'localhost';
$dbname = 'G3AVALTAPIZZA';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// 2. Vérification de la connexion de l'utilisateur
$estConnecte = isset($_SESSION['user']);
$loginUser = $_SESSION['user']['login'] ?? '';

// 3. Récupération des produits
$stmt = $pdo->query("SELECT * FROM produit ORDER BY id_produit ASC");
$produits = $stmt->fetchAll();

function getCategorie($libelle) {
    $lib = strtolower($libelle);
    if (str_contains($lib, 'menu')) return 'Menus';
    if (str_contains($lib, 'pizza')) return 'Nos Pizzas Artisanales';
    if (str_contains($lib, 'tiramisu') || str_contains($lib, 'panna')) return 'Desserts';
    return 'Boissons';
}

$produitsParCategorie = [];
foreach ($produits as $p) {
    $cat = getCategorie($p['libelle']);
    $produitsParCategorie[$cat][] = $p;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVALTAPIZZA - Nos Produits</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <img src="img/logo.png" alt="Logo AVALTAPIZZA">
        <h1>Nos Pizzas & Produits</h1>
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
        <form action="paiement.php" method="POST">

            <!-- Mode de consommation -->
            <section class="mode-consommation">
                <h2>1. Mode de consommation</h2>
                <div class="mode-options">
                    <label class="mode-option">
                        <input type="radio" name="mode" value="1" checked onchange="updateTvaInfo()">
                        Sur place
                    </label>
                    <label class="mode-option">
                        <input type="radio" name="mode" value="2" onchange="updateTvaInfo()">
                        À emporter
                    </label>
                </div>

                <!-- Message d'information TVA conforme BDD -->
                <div id="tva-box" class="tva-info">
                    <strong>TVA appliquée (Sur place) :</strong> 10 % sur l'ensemble de la commande.
                </div>
            </section>

            <!-- Sélection des produits -->
            <section>
                <h2>2. Notre Carte</h2>

                <?php if (empty($produits)) : ?>
                    <p>Aucun produit disponible en base de données.</p>
                <?php else : ?>
                    <?php foreach ($produitsParCategorie as $categorie => $listeProduits) : ?>
                        <h3 class="categorie-titre"><?= htmlspecialchars($categorie) ?></h3>
                        
                        <div class="grid-produits">
                            <?php foreach ($listeProduits as $prod) : 
                                $prixHT = (float) $prod['prix_ht'];
                            ?>
                                <div class="produit-card">
                                    <img src="images/pizza.jpg" alt="<?= htmlspecialchars($prod['libelle']) ?>" class="produit-img">
                                    <div class="produit-content">
                                        <h3 class="produit-titre"><?= htmlspecialchars($prod['libelle']) ?></h3>
                                        <div class="produit-footer">
                                            <div>
                                                <span class="produit-prix"><?= number_format($prixHT, 2, ',', ' ') ?> € HT</span>
                                            </div>
                                            <div class="quantite-selector">
                                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                                <input type="number" name="quantite[<?= $prod['id_produit'] ?>]" value="0" min="0" max="20" readonly>
                                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Zone de validation conditionnelle -->
                <div style="margin-top: 2rem; text-align: center;">
                    <?php if ($estConnecte) : ?>
                        <button type="submit" class="btn-primary">Passer la commande</button>
                    <?php else : ?>
                        <div style="background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 15px; border-radius: 5px; margin-bottom: 1rem;">
                            <strong>Connexion requise :</strong> Vous devez être connecté à votre compte pour pouvoir passer une commande.
                        </div>
                        <div class="auth-buttons" style="justify-content: center;">
                            <a href="connexion.php" class="btn-primary">Se connecter</a>
                            <a href="inscription.php" class="btn-secondary">Créer un compte</a>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

        </form>
    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés</p>
    </footer>

    <script>
    function changeQty(btn, delta) {
        const container = btn.closest('.quantite-selector');
        const input = container.querySelector('input[type="number"]');
        let val = parseInt(input.value) || 0;
        val = Math.max(0, Math.min(20, val + delta));
        input.value = val;
    }

    function updateTvaInfo() {
        const mode = document.querySelector('input[name="mode"]:checked').value;
        const tvaBox = document.getElementById('tva-box');
        
        if (mode === '1') {
            tvaBox.innerHTML = '<strong>TVA appliquée (Sur place) :</strong> 10 % sur l\'ensemble de la commande.';
        } else {
            tvaBox.innerHTML = '<strong>TVA appliquée (À emporter) :</strong> 5,5 % sur l\'ensemble de la commande.';
        }
    }
    </script>

</body>
</html>