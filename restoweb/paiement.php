<?php
session_start();

// 1. Protection : l'utilisateur doit être connecté
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}

// 2. Connexion BDD
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
    die("Erreur de connexion BDD : " . $e->getMessage());
}

$idUser = $_SESSION['user']['id_user'];
$loginUser = $_SESSION['user']['login'];

// 3. Traitement de la commande soumise depuis produits.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantite'])) {
    $typeConso = (int) ($_POST['mode'] ?? 1);
    $quantites = $_POST['quantite']; // [id_produit => qte]

    // Vérification qu'au moins un produit a été sélectionné
    $panierFiltre = array_filter($quantites, fn($q) => (int)$q > 0);
    if (empty($panierFiltre)) {
        header('Location: produits.php?erreur=panier_vide');
        exit();
    }

    // A. Insertion initiale de la commande (les triggers mettront à jour total_commande)
    $stmtCmd = $pdo->prepare("INSERT INTO commande (id_user, date_commande, total_commande, type_conso) VALUES (:id_user, NOW(), 0, :type_conso)");
    $stmtCmd->execute([
        'id_user' => $idUser,
        'type_conso' => $typeConso
    ]);
    $idCommande = $pdo->lastInsertId();

    // B. Insertion des lignes de commande
    // Les triggers 'before_ligne_insert' et 'after_ligne_insert' feront tous les calculs HT et TTC
    $stmtLigne = $pdo->prepare("INSERT INTO ligne_commande (id_commande, id_produit, qte, total_ligne_ht) VALUES (:id_commande, :id_produit, :qte, 0)");
    
    foreach ($panierFiltre as $idProd => $qte) {
        $stmtLigne->execute([
            'id_commande' => $idCommande,
            'id_produit' => (int)$idProd,
            'qte' => (int)$qte
        ]);
    }

    // Sauvegarde de l'ID en session pour consultation
    $_SESSION['derniere_commande_id'] = $idCommande;

} elseif (isset($_SESSION['derniere_commande_id'])) {
    $idCommande = $_SESSION['derniere_commande_id'];
} else {
    header('Location: produits.php');
    exit();
}

// 4. Lecture des valeurs CALCULÉES PAR LES TRIGGERS dans la BDD
$stmtGetCmd = $pdo->prepare("SELECT * FROM commande WHERE id_commande = :id");
$stmtGetCmd->execute(['id' => $idCommande]);
$commandeInfo = $stmtGetCmd->fetch();

$stmtGetLignes = $pdo->prepare("
    SELECT lc.*, p.libelle, p.prix_ht 
    FROM ligne_commande lc
    JOIN produit p ON lc.id_produit = p.id_produit
    WHERE lc.id_commande = :id
");
$stmtGetLignes->execute(['id' => $idCommande]);
$lignesCommande = $stmtGetLignes->fetchAll();

$totalCommandeTTC = (float) $commandeInfo['total_commande'];
$typeConso = (int) $commandeInfo['type_conso'];
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

            <!-- Récapitulatif généré directement par les données calculées de la BDD -->
            <section class="recap-card">
                <h2>Récapitulatif de la commande n° <?= htmlspecialchars($idCommande) ?></h2>
                
                <div class="badge-mode">
                    Mode retenu : <strong><?= $typeConso === 1 ? 'Sur place (TVA 10%)' : 'À emporter (TVA 5,5%)' ?></strong>
                </div>

                <table class="recap-table">
                    <thead>
                        <tr>
                            <th>Article</th>
                            <th class="text-center">Qté</th>
                            <th class="text-right">Prix U. HT</th>
                            <th class="text-right">Total HT (Calculé)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lignesCommande as $item) : ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($item['libelle']) ?></strong></td>
                                <td class="text-center"><span class="qty-pill"><?= $item['qte'] ?></span></td>
                                <td class="text-right"><?= number_format($item['prix_ht'], 2, ',', ' ') ?> €</td>
                                <td class="text-right"><strong><?= number_format($item['total_ligne_ht'], 2, ',', ' ') ?> €</strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="recap-totals">
                    <div class="total-row final">
                        <span>Total TTC à payer :</span>
                        <span><?= number_format($totalCommandeTTC, 2, ',', ' ') ?> €</span>
                    </div>
                </div>
            </section>

            <!-- Formulaire de paiement -->
            <section class="form-box">
                <h2>Payer par Carte Bancaire</h2>

                <form action="confirmation.php" method="GET">
                    <input type="hidden" name="id_commande" value="<?= $idCommande ?>">
                    <input type="hidden" name="total" value="<?= number_format($totalCommandeTTC, 2, '.', '') ?>">

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

                    <button type="submit" class="btn-primary">Payer <?= number_format($totalCommandeTTC, 2, ',', ' ') ?> €</button>
                </form>
            </section>

        </div>

    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés. Transactions sécurisées SSL.</p>
    </footer>

</body>
</html>