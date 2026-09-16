<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RestoWeb - Carte des produits</title>
    <!-- Lien vers le fichier CSS selon ton arborescence -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- En-tête avec Logo et Navigation -->
    <header>
        <div class="logo-container">
            <img src="img/logo.png" alt="RestoWeb Logo" class="logo">
            <h1>RestoWeb</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="produits.html" class="active">Carte & Commande</a></li>
                <li><a href="connexion.html">Connexion</a></li>
                <li><a href="inscription.html">Inscription</a></li>
                <li><a href="deconnexion.html">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Notre Carte</h2>
        <p>Sélectionnez le mode de dégustation et vos produits ci-dessous :</p>

        <!-- Formulaire de commande (redirige vers la page de paiement) -->
        <form action="paiement.html" method="GET">

            <!-- 1. Choix du type de commande -->
            <section class="type-commande">
                <h3>1. Type de commande</h3>
                <div class="options-radio">
                    <label class="radio-card">
                        <input type="radio" name="type_commande" value="sur_place" checked>
                        <span><strong>Sur place</strong> (TVA 10%)</span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="type_commande" value="emporter">
                        <span><strong>À emporter</strong> (TVA 5.5%)</span>
                    </label>
                </div>
            </section>

            <!-- 2. Liste des produits -->
            <section class="liste-produits">
                <h3>2. Choisissez vos produits</h3>
                
                <div class="grid-produits">
                    
                    <!-- Produit 1 -->
                    <article class="produit-card">
                        <img src="img/produits/burger.jpg" alt="Burger Classique" class="produit-img">
                        <div class="produit-info">
                            <h4>Burger Classique</h4>
                            <p class="prix">8.50 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_1">Quantité :</label>
                                <input type="number" id="qte_1" name="qte_produit_1" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <!-- Produit 2 -->
                    <article class="produit-card">
                        <img src="img/produits/pizza.jpg" alt="Pizza Margherita" class="produit-img">
                        <div class="produit-info">
                            <h4>Pizza Margherita</h4>
                            <p class="prix">10.00 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_2">Quantité :</label>
                                <input type="number" id="qte_2" name="qte_produit_2" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <!-- Produit 3 -->
                    <article class="produit-card">
                        <img src="img/produits/frites.jpg" alt="Frites Maison" class="produit-img">
                        <div class="produit-info">
                            <h4>Frites Maison</h4>
                            <p class="prix">3.00 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_3">Quantité :</label>
                                <input type="number" id="qte_3" name="qte_produit_3" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <!-- Produit 4 -->
                    <article class="produit-card">
                        <img src="img/produits/boisson.jpg" alt="Soda 33cl" class="produit-img">
                        <div class="produit-info">
                            <h4>Soda 33cl</h4>
                            <p class="prix">2.50 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_4">Quantité :</label>
                                <input type="number" id="qte_4" name="qte_produit_4" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <!-- Produit 5 -->
                    <article class="produit-card">
                        <img src="img/produits/tiramisu.jpg" alt="Tiramisu" class="produit-img">
                        <div class="produit-info">
                            <h4>Tiramisu</h4>
                            <p class="prix">4.00 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_5">Quantité :</label>
                                <input type="number" id="qte_5" name="qte_produit_5" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                </div>
            </section>

            <!-- 3. Validation de la commande -->
            <div class="actions-commande">
                <button type="submit" class="btn-primary">Passer au paiement &rarr;</button>
            </div>

        </form>
    </main>

    <footer>
        <p>&copy; 2024 RestoWeb - Tous droits réservés</p>
    </footer>

</body>
</html>