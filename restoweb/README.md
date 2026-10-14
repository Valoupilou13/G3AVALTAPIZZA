# AVALTAPIZZA - RestoWeb 🍕

Application web de commande en ligne pour la pizzeria AVALTAPIZZA, couplée à une API REST pour la gestion de la cuisine via l'application Java *RestoSwing*.

---

## 📌 Présentation du Projet

**RestoWeb** est le module web du système d'information de la pizzeria AVALTAPIZZA. Il permet aux clients de :
- Consulter le catalogue de produits (pizzas, boissons, desserts, menus).
- Composer leur panier et passer commande.
- Choisir le mode de consommation (*Sur place* ou *À emporter*).

Le **Lot 5** du projet fournit une **API RESTful** en JSON permettant à l'application Java de la cuisine (*RestoSwing*) de lire et de mettre à jour l'état des commandes en temps réel.

---

## 🚀 Fonctionnalités Principales

- **Catalogue Interactif :** Affichage dynamique des produits et menus.
- **Gestion des Modes de Consommation :** Application automatique du taux de TVA adapté (10% sur place, 5,5% à emporter).
- **Calculs Métier Automatisés :** Calcul des totaux HT et TTC déporté dans des déclencheurs (*triggers*) MySQL.
- **API REST Cuisine (Lot 5) :**
  - Consultation des commandes en attente de préparation.
  - Acceptation, refus ou finalisation des commandes par la cuisine.

---

## 📁 Arborescence du Projet

```text
restoweb/
├── api/                           # Endpoints de l'API REST (Lot 5)
│   ├── commandes_en_attente.php   # Liste des commandes payées non servies
│   ├── commande_accepter.php      # Passage à l'état "En préparation" (id_etat = 2)
│   ├── commande_refuser.php       # Passage à l'état "Abandonnée" (id_etat = 4)
│   └── commande_terminer.php      # Passage à l'état "Prête" (id_etat = 3)
├── bdd/                           # Scripts SQL et Triggers
│   └── createdatabase.sql         # Structure, Triggers et Jeux de données
├── img/                           # Visuels des produits
├── css/                           # Styles de l'interface web
├── index.php                      # Page d'accueil
├── produits.php                   # Carte des produits
├── connexion.php                  # Authentification client
├── inscription.php                # Inscription
├── paiement.php                   # Validation de commande
├── confirmation.php               # Confirmation
├── DOCUMENTATION_TECHNIQUE.md     # Spécifications complètes de l'API REST
└── README.md                      # Présentation du projet
```

---

## 🛠️ Installation et Configuration

### Prérequis
- Serveur Web (Apache ou Nginx) avec **PHP 7.4+** ou **PHP 8.x**
- Base de données **MySQL** / **MariaDB**
- Extension PHP `pdo_mysql` activée

### Étapes d'installation

1. **Cloner le dépôt :**
   ```bash
   git clone https://github.com/votre-org/G3AVALTAPIZZA.git
   ```

2. **Base de Données :**
   - Importer `bdd/createdatabase.sql` dans MySQL (phpMyAdmin).
   - Le script crée les tables (`commande`, `ligne_commande`, `produit`, `utilisateur`), la colonne `id_etat` et les triggers de calcul de TVA.

3. **Configuration PDO :**
   - Vérifier les identifiants de connexion MySQL dans vos scripts PHP (`localhost`, base `G3AVALTAPIZZA`, utilisateur `root`).

4. **Accès :**
   - Interface Web : `http://localhost/restoweb/`
   - Endpoint API : `http://localhost/restoweb/api/commandes_en_attente.php`

---

## 📡 Synthèse des Endpoints API (Lot 5)

| Endpoint | Méthode | Action | État cible (`id_etat`) |
| :--- | :---: | :--- | :---: |
| `/api/commandes_en_attente.php` | `GET` | Liste des commandes à traiter | `1` (En attente) |
| `/api/commande_accepter.php?id_commande=X` | `GET` | Accepter la commande X | `2` (En préparation) |
| `/api/commande_terminer.php?id_commande=X` | `GET` | Marquer la commande X comme prête | `3` (Prête) |
| `/api/commande_refuser.php?id_commande=X` | `GET` | Refuser la commande X | `4` (Abandonnée) |

---

## 🎓 Cadre Académique

Projet réalisé dans le cadre du cursus BTS SIO / Développement Web à l'**Institut Limayrac**.