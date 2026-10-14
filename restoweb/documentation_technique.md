# Documentation Technique - API REST (Lot 5)
**Projet :** AVALTAPIZZA / RestoWeb  
**Module :** API REST pour la gestion de cuisine (*RestoSwing*)  
**Auteur :** Équipe AVALTAPIZZA - BTS SIO Institut Limayrac  

---

## 1. Architecture et Flux d'Échanges

L'API REST fait le lien entre le serveur web PHP/MySQL (**RestoWeb**) et l'application client lourd Java (**RestoSwing**).

```text
+-------------------+                   +-------------------+
|                   |  HTTP GET (JSON)  |                   |
|   RestoSwing      | <---------------> |     RestoWeb      |
|  (Client Java)    |                   |   (Serveur PHP)   |
+-------------------+                   +-------------------+
                                                  |
                                                  v
                                        +-------------------+
                                        |    MySQL BDD      |
                                        |  G3AVALTAPIZZA    |
                                        +-------------------+
```

- **Format des données :** JSON (`Content-Type: application/json; charset=utf-8`).
- **Sécurité :** Connexion directe sur le réseau local ou VPN.
- **Gestion des erreurs :** En cas d'erreur réseau ou SQL, le serveur retourne une structure vide (`[]` ou `{}`) afin de garantir la stabilité de l'application cliente.

---

## 2. Cycle de Vie des Commandes (`id_etat`)

Le champ `id_etat` de la table `commande` régit l'avancement d'une commande :

| `id_etat` | Libellé | Description |
| :---: | :--- | :--- |
| **1** | **En attente** | Commande validée et payée par le client sur le site web. |
| **2** | **En préparation** | Commande validée par la cuisine via `commande_accepter.php`. |
| **3** | **Prête** | Commande confectionnée et prête à être servie via `commande_terminer.php`. |
| **4** | **Abandonnée** | Commande refusée ou annulée par la cuisine via `commande_refuser.php`. |

---

## 3. Spécifications Détaillées des Endpoints

### 3.1. Listes des commandes en attente
Retourne la liste complète des commandes payées n'ayant pas encore été traitées.

- **URL :** `http://<serveur_restoweb>/api/commandes_en_attente.php`
- **Méthode :** `GET`
- **Réponse HTTP :** `200 OK`
- **Content-Type :** `application/json; charset=utf-8`

#### Structure du JSON :
- `id_commande` *(int)* : Identifiant unique de la commande.
- `date_commande` *(string)* : Horizon d'enregistrement (`YYYY-MM-DD HH:MM:SS`).
- `type_conso` *(string)* : Mode de consommation (`Sur place` ou `À emporter`).
- `total_commande` *(float)* : Total TTC de la commande arrondi à 2 décimales.
- `client` *(object)* :
  - `login` *(string)* : Identifiant du client.
  - `email` *(string)* : Email de contact.
- `produits` *(array)* : Liste des articles associés :
  - `libelle` *(string)* : Libellé du produit.
  - `quantite` *(int)* : Quantité commandée.
  - `prix_unitaire_ht` *(float)* : Prix unitaire HT.
  - `total_ligne_ht` *(float)* : Total HT de la ligne.

#### Exemple de flux JSON :
```json
[
  {
    "id_commande": 10,
    "date_commande": "2026-10-14 14:30:00",
    "type_conso": "Sur place",
    "total_commande": 21,
    "client": {
      "login": "mario",
      "email": "mario@pizzeria.com"
    },
    "produits": [
      {
        "libelle": "Pizza Reine",
        "quantite": 1,
        "prix_unitaire_ht": 9.5,
        "total_ligne_ht": 9.5
      },
      {
        "libelle": "Soda 33cl",
        "quantite": 2,
        "prix_unitaire_ht": 2.27,
        "total_ligne_ht": 4.54
      }
    ]
  }
]
```

---

### 3.2. Accepter une commande
Passe la commande spécifiée à l'état **2** (*En préparation*).

- **URL :** `http://<serveur_restoweb>/api/commande_accepter.php?id_commande={id}`
- **Méthode :** `GET`
- **Paramètre URL :** `id_commande` (Entier strict)
- **Exemple de réponse :**
```json
{
  "succes": true,
  "id_commande": 10,
  "nouveau_statut": "En préparation",
  "id_etat": 2
}
```

---

### 3.3. Refuser une commande
Passe la commande spécifiée à l'état **4** (*Abandonnée*).

- **URL :** `http://<serveur_restoweb>/api/commande_refuser.php?id_commande={id}`
- **Méthode :** `GET`
- **Paramètre URL :** `id_commande` (Entier strict)
- **Exemple de réponse :**
```json
{
  "succes": true,
  "id_commande": 10,
  "nouveau_statut": "Abandonnée",
  "id_etat": 4
}
```

---

### 3.4. Terminer une commande
Passe la commande spécifiée à l'état **3** (*Prête*).

- **URL :** `http://<serveur_restoweb>/api/commande_terminer.php?id_commande={id}`
- **Méthode :** `GET`
- **Paramètre URL :** `id_commande` (Entier strict)
- **Exemple de réponse :**
```json
{
  "succes": true,
  "id_commande": 10,
  "nouveau_statut": "Prête",
  "id_etat": 3
}
```

---

## 4. Notes d'Implémentation Technique

1. **Format des Flottants dans PHP :**  
   Pour éviter l'affichage de décimales résiduelles liées au format IEEE 754 lors du `json_encode` (ex: `2.2699999999999`), la directive PHP suivante est appliquée en en-tête des fichiers API :
   ```php
   ini_set('serialize_precision', -1);
   ```

2. **Calculs BDD par Triggers :**  
   Les montants Hors Taxes, la TVA et les totaux TTC sont calculés et mis à jour automatiquement en base de données MySQL via des déclencheurs (*Triggers*) sur les événements `INSERT` et `UPDATE` des tables `commande` et `ligne_commande`.