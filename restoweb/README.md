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
