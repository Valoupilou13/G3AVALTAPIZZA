# AVALTAPIZZA - RestoWeb 🍕

Application web de commande en ligne pour la pizzeria **AVALTAPIZZA**, couplée à une API REST permettant le suivi et le traitement des commandes en cuisine via l'application Java *RestoSwing*.

---

## 📌 Description détaillée du projet

**RestoWeb** est le module web du système d'information de la pizzeria **AVALTAPIZZA** (développé en PHP 8, HTML5/CSS3 et MySQL/MariaDB). Il permet aux clients de consulter la carte en ligne (menus, pizzas, desserts, boissons), de créer un compte personnel, de composer un panier en choisissant le mode de consommation (*Sur place* ou *À emporter*) et de valider le paiement de leur commande.

En parallèle, le module intègre une **API REST** retournant des flux **JSON**, exploitée par l'application lourde Java de la cuisine (*RestoSwing*) pour récupérer en temps réel les commandes payées en attente et mettre à jour leur état d'avancement (acceptation, préparation terminée ou refus).

---

## 🔐 Comptes prédéfinis (Jeu de test)

*(Comptes pré-enregistrés dans la table `utilisateur` de la base de données `G3AVALTAPIZZA`)*

| ID | Login | Email | Mot de passe | Rôle / Remarques |
| `9` | `adr` | `adm@gmail.com` | `1234` | Compte client de test 1 |

---

## 📁 Arborescence du projet

```text
AVALTAPIZZA/
├── DA/                                    # Diagramme d'activités
│   └── DA avalTApizza.drawio.png
├── DCU-RestoWeb-Lot1/                     # Diagramme des cas d'utilisation
│   ├── DCU_RestoWeb_Lot1.odg
│   └── Diagramme des Cas d'Utilisation.pdf
├── IHM/                                   # Maquettes de l'interface graphique
│   └── IHM Avaltapizza.jpg
├── MCD/                                   # Modèle Conceptuel des Données
│   └── Capture d'écran MCD.png
├── MLD/                                   # Modèle Logique des Données
│   ├── Capture d'écran MLD.png
│   └── RestowebMCD-MLD.loo
├── MPD/                                   # Modèle Physique des Données (SQL)
│   └── G3AVALTAPIZZA.sql
├── Plan du site/                          # Sitemap (enchaînement des pages)
│   └── sitemap avaltapizza (1).png
├── doc/                                   # Documents de réalisation et d'exploitation (PDF)
│   ├── manuel_installation.pdf
│   ├── manuel_jeu_de_test.pdf
│   └── manuel_utilisation.pdf
├── restoweb/                              # Code source de l'application web et de l'API
│   ├── api/                               # Endpoints de l'API REST (JSON)
│   │   ├── commandes_en_attente.php       # Liste des commandes payées non traitées
│   │   ├── commande_accepter.php          # Passage à l'état "En préparation"
│   │   ├── commande_refuser.php           # Passage à l'état "Abandonnée"
│   │   └── commande_terminer.php          # Passage à l'état "Prête"
│   ├── bdd/                               # Scripts SQL de création et peuplement
│   │   └── create_database.sql            # Tables, triggers et jeu de données
│   ├── css/                               # Feuilles de style
│   │   └── style.css
│   ├── img/                               # Visuels des produits et logo
│   ├── index.php                          # Page d'accueil
│   ├── produits.php                       # Catalogue et ajout au panier
│   ├── inscription.php                    # Création de compte client
│   ├── connexion.php                      # Authentification client
│   ├── deconnexion.php                    # Fermeture de session
│   ├── paiement.php                   # Validation et paiement de la commande
│   ├── confirmation.php                   # Récapitulatif de commande confirmée
│   └── documentation_technique.md         # Maquette JSON et messages d'erreur API
└── README.md                              # Documentation générale du dépôt

---

## 🚀 Liste des fonctionnalités (voir DCU)

* **Gestion des utilisateurs :** Inscription d'un nouveau client (`inscription.php`), authentification sécurisée (`connexion.php`) et déconnexion (`deconnexion.php`).
* **Consultation du catalogue :** Affichage dynamique des 11 produits de la carte (`produits.php`) avec visuels et tarifs.
* **Gestion du panier et commande :** Sélection des produits, ajustement des quantités, choix du type de consommation (*Sur place* ou *À emporter*), validation du paiement (`paiement.php`) et confirmation (`confirmation.php`).
* **Suivi cuisine via l'API REST :** Consultation en temps réel des commandes en attente par *RestoSwing*, acceptation en cuisine, signalement de fin de préparation ou refus de commande.

---

## 🗄️ Liste et rôle des tables SQL

La base de données **`G3AVALTAPIZZA`** contient **4 tables** :

| Nom de la table | Colonnes | Rôle |
| :--- | :--- | :--- |
| `utilisateur` | `id_user` (PK), `login` (UQ), `password`, `email` (UQ) | Stocke les comptes clients inscrits avec leur identifiant, leur email et leur mot de passe haché (bcrypt). |
| `produit` | `id_produit` (PK), `libelle`, `prix_ht`, `image` | Contient le catalogue des 11 produits (menus, pizzas, desserts, boissons), leur prix HT et le fichier image associé. |
| `commande` | `id_commande` (PK), `id_user` (FK), `date_commande`, `total_commande`, `type_conso`, `id_etat` | Enregistre l'en-tête de chaque commande (client, date/heure, montant total TTC, mode de consommation et état d'avancement). |
| `ligne_commande` | `id_ligne_commande` (PK), `id_commande` (FK), `id_produit` (FK), `qte`, `total_ligne_ht` | Détaille les produits commandés, les quantités et le sous-total HT pour chaque commande. |

---

## 📡 Liste des routes de l'API

Toutes les routes se trouvent dans `restoweb/api/` et retournent une réponse au format `application/json`.

| Méthode | Route (Endpoint) | Paramètres | Rôle |
| :--- | :--- | :--- | :--- |
| `GET` | `/restoweb/api/commandes_en_attente.php` | Aucun | Retourne au format JSON la liste des commandes en attente de traitement (`id_etat = 1`). |
| `GET` | `/restoweb/api/commande_accepter.php` | `id_commande` | Passe l'état de la commande à **En préparation** (`id_etat = 2`). |
| `GET` | `/restoweb/api/commande_terminer.php` | `id_commande` | Passe l'état de la commande à **Prête** (`id_etat = 3`). |
| `GET` | `/restoweb/api/commande_refuser.php` | `id_commande` | Passe l'état de la commande à **Abandonnée** (`id_etat = 4`). |

---

## 📊 Description des données pertinentes

* **États de la commande (`commande.id_etat`, valeur par défaut `1`) :**
  * `1` : **En attente** — Commande validée et payée par le client, en attente de prise en charge en cuisine.
  * `2` : **En préparation** — Commande acceptée par le pizzaiolo via *RestoSwing*.
  * `3` : **Prête** — Préparation terminée, commande prête à être servie ou remise au client.
  * `4` : **Abandonnée** — Commande refusée ou annulée par la cuisine.
* **Types de consommation et taux de TVA appliqués (`commande.type_conso`) :**
  * `1` : **Sur place** — Consommation en salle au restaurant, applique automatiquement une TVA de **10 %** (`total_commande = total_ht × 1,10`).
  * `2` : **À emporter** — Vente à emporter, applique automatiquement une TVA de **5,5 %** (`total_commande = total_ht × 1,055`).

---

## ⚡ Liste et rôle des triggers SQL

Quatre déclencheurs (*triggers*) sont implémentés sur la table **`ligne_commande`** pour automatiser le calcul des montants HT et TTC avec TVA :

| Nom du Trigger | Événement | Rôle |
| :--- | :--- | :--- |
| `calcul_total_ligne_before_insert` | `BEFORE INSERT ON ligne_commande` | Calcule automatiquement le sous-total HT de la ligne (`total_ligne_ht = prix_ht * qte`) avant insertion. |
| `maj_total_commande_after_insert` | `AFTER INSERT ON ligne_commande` | Recalcule le montant total TTC (`total_commande`) de la commande en appliquant la TVA selon `type_conso` (`10 %` si `1`, `5,5 %` si `2`). |
| `before_ligne_update` | `BEFORE UPDATE ON ligne_commande` | Recalcule le sous-total HT de la ligne (`total_ligne_ht`) avant la mise à jour d'une quantité ou d'un produit. |
| `after_ligne_update` | `AFTER UPDATE ON ligne_commande` | Met à jour automatiquement le montant total TTC (`total_commande`) de la commande après modification d'une ligne. |

*(Aucune fonction ni procédure stockée n'est utilisée dans la base de données.)*

---

## 🌿 Branches Git

* `main` : Branche principale contenant la version finale et livrée de l'application (Lot 6).

---

## 📚 Liens vers les documents du projet

### Documents de conception
* [Diagramme des cas d'utilisation (DCU)](./DCU-RestoWeb-Lot1/)
* [Diagramme d'activités (DA)](./DA/DA%20avalTApizza.drawio.png)
* [Modèle Conceptuel des Données (MCD)](./MCD/Capture%20d'écran%20MCD.png)
* [Modèle Logique des Données (MLD)](./MLD/Capture%20d'écran%20MLD.png)
* [Modèle Physique des Données (MPD - Script SQL)](./MPD/G3AVALTAPIZZA.sql)
* [Sitemap (enchaînement des pages)](./Plan%20du%20site/sitemap%20avaltapizza%20(1).png)
* [Maquettes de l'IHM](./IHM/IHM%20Avaltapizza.jpg)
* [Maquette JSON et messages d'erreur de l'API](./restoweb/documentation_technique.md)

### Documents de réalisation
* [Manuel d'installation](./doc/manuel_installation.pdf)
* [Manuel du jeu de test](./doc/manuel_jeu_de_test.pdf)

### Documents d'exploitation
* [Manuel d'utilisation (Inscription, Connexion, Commande, Paiement)](./doc/manuel_utilisation.pdf)
* [Documentation d'exploitation de l'API](./restoweb/documentation_technique.md)

---

## 👥 Contributeurs

* **Adrien Mouly** (`@adrienmouly-cell`)
* **Valentin Maurin**
* **[Prénom Nom 3]**
* **[Prénom Nom 4]**
* **[Prénom Nom 5]**

---

## 🎓 Cadre académique

Projet réalisé dans le cadre du BTS SIO à l'**Institut Limayrac** (2026).
