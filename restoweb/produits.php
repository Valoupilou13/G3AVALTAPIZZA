<?php
session_start();

// 1. Connexion à la BDD
$host = 'localhost';
$dbname = 'G3AVALTAPIZZA';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// 2. Récupération des produits
$stmt = $pdo->query("SELECT * FROM produit ORDER BY id_produit ASC");
$produits = $stmt->fetchAll();

// Fonctions utilitaires
function getCategorie($libelle) {
    $lib = strtolower($libelle);
    if (str_contains($lib, 'menu')) return 'Menus';
    if (str_contains($lib, 'pizza')) return 'Nos Pizzas Artisanales';
    if (str_contains($lib, 'tiramisu') || str_contains($lib, 'panna')) return 'Desserts';
    return 'Boissons';
}

function getTauxTVA($libelle) {
    if (str_contains(strtolower($libelle), 'bière') || str_contains(strtolower($libelle), 'biere')) {
        return 0.20; // 20% sur l'alcool
    }
    return 0.10; // 10% par défaut sur la restauration
}

// 3. Regroupement par catégorie
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
            <a href="connexion.php">Connexion</a>
            <a href="inscription.php">Inscription</a>
            <a href="deconnexion.php">Déconnexion</a>
        </nav>
    </header>

    <main class="container">
        <form action="paiement.php" method="POST">

            <!-- 1. Mode de consommation -->
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

                <div id="tva-box" class="tva-info">
                    <strong>TVA appliquée (Sur place) :</strong> 10 % sur les pizzas, plats préparés, desserts et sodas ; 20 % sur l'alcool.
                </div>
            </section>

            <!-- 2. Sélection des produits depuis la BDD -->
            <section>
                <h2>2. Notre Carte</h2>

                <?php if (empty($produits)) : ?>
                    <p>Aucun produit disponible en base de données.</p>
                <?php else : ?>
                    <?php foreach ($produitsParCategorie as $categorie => $listeProduits) : ?>
                        <h3 class="categorie-titre"><?= htmlspecialchars($categorie) ?></h3>
                        
                        <div class="grid-produits">
                            <?php foreach ($listeProduits as $prod) : 
                                $tva = getTauxTVA($prod['libelle']);
                                $prixTTC = $prod['prix_ht'] * (1 + $tva);
                            ?>
                                <div class="produit-card">
                                    <img src="images/pizza.jpg" alt="<?= htmlspecialchars($prod['libelle']) ?>" class="produit-img">
                                    <div class="produit-content">
                                        <h3 class="produit-titre"><?= htmlspecialchars($prod['libelle']) ?></h3>
                                        <div class="produit-footer">
                                            <div>
                                                <span class="produit-prix"><?= number_format($prixTTC, 2, '.', '') ?> € TTC</span>
                                                <span class="tva-badge">HT : <?= number_format($prod['prix_ht'], 2, '.', '') ?> €</span>
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

                <div class="auth-buttons">
                    <button type="submit" class="btn-primary">Passer la commande</button>
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
            tvaBox.innerHTML = '<strong>TVA appliquée (Sur place) :</strong> 10 % sur les pizzas, plats préparés, desserts et sodas ; 20 % sur l\'alcool.';
        } else {
            tvaBox.innerHTML = '<strong>TVA appliquée (À emporter) :</strong> 10 % sur les pizzas chaudes et plats préparés ; 5,5 % sur les boissons sous emballage et desserts ; 20 % sur l\'alcool.';
        }
    }
    </script>

</body>
</html>