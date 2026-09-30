<?php
session_start();

// 1. Protection : l'utilisateur doit être connecté
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}

// 2. Connexion à la BDD
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
    die("Erreur de connexion BDD : " . $e->getMessage());
}

$idUser = $_SESSION['user']['id_user'];
$loginUser = $_SESSION['user']['login'];

// Fonction de calcul de la TVA
function getTauxTVA(string $libelle, int $typeConso): float {
    $lib = strtolower($libelle);
    // Alcool = 20%
    if (str_contains($lib, 'bière') || str_contains($lib, 'biere')) {
        return 0.20;
    }
    // Sur place = 10%
    if ($typeConso === 1) {
        return 0.10;
    }
    // À emporter : 5.5% sur boissons non alcoolisées et desserts
    if (str_contains($lib, 'soda') || str_contains($lib, 'eau') || str_contains($lib, 'tiramisu') || str_contains($lib, 'panna')) {
        return 0.055;
    }
    return 0.10; // Pizzas et menus
}

$articlesPanier = [];
$totalHT = 0.0;
$totalTVA = 0.0;
$totalTTC = 0.0;
$idCommande = null;
$typeConso = 1;

// 3. Traitement lors de la validation depuis produits.php (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantite'])) {
    $typeConso = (int) ($_POST['mode'] ?? 1);
    $quantites = $_POST['quantite']; // tableau [id_produit => quantite]

    // Filtrer les produits commandés (quantité > 0)
    $idsProduits = [];
    foreach ($quantites as $idProd => $qte) {
        if ((int)$qte > 0) {
            $idsProduits[] = (int)$idProd;
        }
    }

    if (empty($idsProduits)) {
        header('Location: produits.php?erreur=panier_vide');
        exit();
    }

    // Récupérer les informations des produits choisis en BDD
    $inClause = implode(',', array_fill(0, count($idsProduits), '?'));
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id_produit IN ($inClause)");
    $stmt->execute($idsProduits);
    $produitsBDD = $stmt->fetchAll();

    // Calculs de la commande
    foreach ($produitsBDD as $prod) {
        $idP = $prod['id_produit'];
        $qte = (int)$quantites[$idP];
        $prixHT = (float)$prod['prix_ht'];
        $ligneHT = $prixHT * $qte;

        $tauxTVA = getTauxTVA($prod['libelle'], $typeConso);
        $ligneTVA = $ligneHT * $tauxTVA;
        $ligneTTC = $ligneHT + $ligneTVA;

        $totalHT += $ligneHT;
        $totalTVA += $ligneTVA;
        $totalTTC += $ligneTTC;

        $articlesPanier[] = [
            'id_produit' => $idP,
            'libelle' => $prod['libelle'],
            'qte' => $qte,
            'prix_ht' => $prixHT,
            'ligne_ht' => $ligneHT,
            'ligne_ttc' => $ligneTTC
        ];
    }

    // Insertion de la commande en BDD
    $stmtCmd = $pdo->prepare("INSERT INTO commande (id_user, date_commande, total_commande, type_conso) VALUES (:id_user, NOW(), :total, :type_conso)");
    $stmtCmd->execute([
        'id_user' => $idUser,
        'total' => $totalTTC,
        'type_conso' => $typeConso
    ]);
    $idCommande = $pdo->lastInsertId();

    // Insertion des lignes de commande en BDD
    $stmtLigne = $pdo->prepare("INSERT INTO ligne_commande (id_commande, id_produit, qte, total_ligne_ht) VALUES (:id_commande, :id_produit, :qte, :total_ligne_ht)");
    foreach ($articlesPanier as $art) {
        $stmtLigne->execute([
            'id_commande' => $idCommande,
            'id_produit' => $art['id_produit'],
            'qte' => $art['qte'],
            'total_ligne_ht' => $art['ligne_ht']
        ]);
    }

    // Sauvegarde en session pour rechargement éventuel
    $_SESSION['commande_active'] = [
        'id_commande' => $idCommande,
        'type_conso' => $typeConso,
        'articles' => $articlesPanier,
        'total_ht' => $totalHT,
        'total_tva' => $totalTVA,
        'total_ttc' => $totalTTC
    ];

} elseif (isset($_SESSION['commande_active'])) {
    // Récupération si la page est rafraîchie
    $cmdSession = $_SESSION['commande_active'];
    $idCommande = $cmdSession['id_commande'];
    $typeConso = $cmdSession['type_conso'];
    $articlesPanier = $cmdSession['articles'];
    $totalHT = $cmdSession['total_ht'];
    $totalTVA = $cmdSession['total_tva'];
    $totalTTC = $cmdSession['total_ttc'];
} else {
    header('Location: produits.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVALTAPIZZA - Paiement</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <img src="img/logo.png" alt="Logo AVALTAPIZZA">
        <h1>AVALTAPIZZA</h1>
        <p>Finalisation et paiement de votre commande</p>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="produits.php">Carte & Produits</a>
            <a href="deconnexion.php">Déconnexion (<?= htmlspecialchars($loginUser) ?>)</a>
        </nav>
    </header>

    <main class="container">

        <div class="checkout-grid">

            <!-- Récapitulatif dynamique depuis BDD -->
            <section class="recap-card">
                <h2>Récapitulatif de la commande n° <?= htmlspecialchars($idCommande) ?></h2>
                
                <div class="badge-mode">
                    Mode retenu : <strong><?= $typeConso === 1 ? 'Sur place' : 'À emporter' ?></strong>
                </div>

                <table class="recap-table">
                    <thead>
                        <tr>
                            <th>Article</th>
                            <th class="text-center">Qté</th>
                            <th class="text-right">Prix U. HT</th>
                            <th class="text-right">Total TTC</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articlesPanier as $item) : ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($item['libelle']) ?></strong></td>
                                <td class="text-center"><span class="qty-pill"><?= $item['qte'] ?></span></td>
                                <td class="text-right"><?= number_format($item['prix_ht'], 2, ',', ' ') ?> €</td>
                                <td class="text-right"><strong><?= number_format($item['ligne_ttc'], 2, ',', ' ') ?> €</strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="recap-totals">
                    <div class="total-row">
                        <span>Sous-total HT :</span>
                        <span><?= number_format($totalHT, 2, ',', ' ') ?> €</span>
                    </div>
                    <div class="total-row">
                        <span>TVA :</span>
                        <span><?= number_format($totalTVA, 2, ',', ' ') ?> €</span>
                    </div>
                    <div class="total-row final">
                        <span>Total TTC :</span>
                        <span><?= number_format($totalTTC, 2, ',', ' ') ?> €</span>
                    </div>
                </div>
            </section>

            <!-- Formulaire de paiement -->
            <section class="form-box">
                <h2>Payer par Carte Bancaire</h2>

                <form action="confirmer.php" method="GET">
                    <input type="hidden" name="id_commande" value="<?= $idCommande ?>">
                    <input type="hidden" name="total" value="<?= number_format($totalTTC, 2, '.', '') ?>">

                    <fieldset>
                        <legend>Informations de paiement</legend>

                        <div class="form-group">
                            <label for="cardholder">Nom figurant sur la carte</label>
                            <input type="text" id="cardholder" name="cardholder" required placeholder="M. Jean Dupont">
                        </div>

                        <div class="form-group">
                            <label for="cardnumber">Numéro de carte bancaire</label>
                            <input type="text" id="cardnumber" name="cardnumber" required maxlength="19" placeholder="1234 5678 9101 1121">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="cardexpiry">Expiration</label>
                                <input type="text" id="cardexpiry" name="cardexpiry" required maxlength="5" placeholder="MM/AA">
                            </div>

                            <div class="form-group">
                                <label for="cardcvc">Cryptogramme (CVC)</label>
                                <input type="text" id="cardcvc" name="cardcvc" required maxlength="4" placeholder="123">
                            </div>
                        </div>
                    </fieldset>

                    <button type="submit" class="btn-primary">Payer <?= number_format($totalTTC, 2, ',', ' ') ?> €</button>
                </form>
            </section>

        </div>

    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés. Transactions sécurisées SSL.</p>
    </footer>

</body>
</html>