<?php
// Empêche PHP d'ajouter des décimales parasites lors du json_encode
ini_set('serialize_precision', -1);

header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$dbname = 'G3AVALTAPIZZA';
$username = 'root';
$password = '';

$commandes = [];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $stmt = $pdo->prepare("
        SELECT 
            c.id_commande,
            c.date_commande,
            c.type_conso,
            c.total_commande,
            u.login AS client_login,
            u.email AS client_email
        FROM commande c
        LEFT JOIN utilisateur u ON c.id_user = u.id_user
        WHERE c.id_etat = 1
        ORDER BY c.date_commande ASC
    ");
    $stmt->execute();
    $listeCommandes = $stmt->fetchAll();

    $stmtLignes = $pdo->prepare("
        SELECT 
            p.libelle,
            lc.qte,
            p.prix_ht,
            lc.total_ligne_ht
        FROM ligne_commande lc
        LEFT JOIN produit p ON lc.id_produit = p.id_produit
        WHERE lc.id_commande = :id_commande
    ");

    foreach ($listeCommandes as $cmd) {
        $stmtLignes->execute(['id_commande' => $cmd['id_commande']]);
        $lignes = $stmtLignes->fetchAll();

        $commandes[] = [
            'id_commande' => (int) $cmd['id_commande'],
            'date_commande' => $cmd['date_commande'],
            'type_conso' => ((int) $cmd['type_conso'] === 1) ? 'Sur place' : 'À emporter',
            'total_commande' => round((float) $cmd['total_commande'], 2),
            'client' => [
                'login' => $cmd['client_login'] ?? 'Inconnu',
                'email' => $cmd['client_email'] ?? 'Non renseigné'
            ],
            'produits' => array_map(function($l) {
                return [
                    'libelle' => $l['libelle'] ?? 'Produit inconnu',
                    'quantite' => (int) $l['qte'],
                    'prix_unitaire_ht' => round((float) $l['prix_ht'], 2),
                    'total_ligne_ht' => round((float) $l['total_ligne_ht'], 2)
                ];
            }, $lignes)
        ];
    }

} catch (Exception $e) {
    // Erreur silencieuse selon les spécifications
    $commandes = [];
}

echo json_encode($commandes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);