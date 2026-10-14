<?php
// Désactivation des décimales parasites PHP
ini_set('serialize_precision', -1);

// Indication du format JSON
header('Content-Type: application/json; charset=utf-8');

// Paramètres de connexion BDD
$host = 'localhost';
$dbname = 'G3AVALTAPIZZA';
$username = 'root';
$password = '';

// Récupération de l'ID de la commande
$idCommande = isset($_GET['id_commande']) ? (int) $_GET['id_commande'] : null;

$reponse = [];

if ($idCommande !== null && $idCommande > 0) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        // Passage de la commande à l'état 4 (Abandonnée / Refusée)
        $stmt = $pdo->prepare("
            UPDATE commande 
            SET id_etat = 4 
            WHERE id_commande = :id_commande
        ");
        $stmt->execute(['id_commande' => $idCommande]);

        // Réponse confirmant le changement d'état
        if ($stmt->rowCount() > 0) {
            $reponse = [
                'succes' => true,
                'id_commande' => $idCommande,
                'nouveau_statut' => 'Abandonnée',
                'id_etat' => 4
            ];
        }

    } catch (Exception $e) {
        // Exigence des consignes : gestion silencieuse des erreurs
        $reponse = [];
    }
}

echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);