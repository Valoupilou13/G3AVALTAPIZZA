<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RestoWeb - Carte & Commande</title>
    <!-- Lien CSS selon l'arborescence du projet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <div class="logo-container">
            <img src="img/logo.png" alt="RestoWeb Logo" class="logo">
            <h1>RestoWeb</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="produits.php" class="active">Carte & Commande</a></li>
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="inscription.php">Inscription</a></li>
                <li><a href="deconnexion.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Notre Carte</h2>
        <p>Sélectionnez votre mode de consommation et vos produits ci-dessous :</p>

        
        <form action="paiement.php" method="POST">

            
            <section class="type-commande">
                <h3>1. Mode de consommation</h3>
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

            
            <section class="categorie-produits">
                <h3>🍔 Menus Burgers & Frites</h3>
                <div class="grid-produits">

                    <article class="produit-card">
                        <img src="img/produits/menu_burger_classique.jpg" alt="Menu Burger Classique" class="produit-img">
                        <div class="produit-info">
                            <h4>Menu Burger Classique</h4>
                            <p class="description">Burger bœuf, cheddar, salade, tomate + Frites maison</p>
                            <p class="prix">11.50 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_1">Quantité :</label>
                                <input type="number" id="qte_1" name="quantite[1]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <article class="produit-card">
                        <img src="img/produits/menu_burger_bacon.jpg" alt="Menu Cheese Bacon" class="produit-img">
                        <div class="produit-info">
                            <h4>Menu Cheese & Bacon</h4>
                            <p class="description">Double steak, bacon grillé, double cheddar + Frites maison</p>
                            <p class="prix">13.00 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_2">Quantité :</label>
                                <input type="number" id="qte_2" name="quantite[2]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <article class="produit-card">
                        <img src="img/produits/menu_burger_chicken.jpg" alt="Menu Chicken Burger" class="produit-img">
                        <div class="produit-info">
                            <h4>Menu Chicken Crispy</h4>
                            <p class="description">Poulet pané croustillant, sauce mayo-moutarde + Frites maison</p>
                            <p class="prix">12.00 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_3">Quantité :</label>
                                <input type="number" id="qte_3" name="quantite[3]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                </div>
            </section>

           
            <section class="categorie-produits">
                <h3>🍕 Nos Pizzas</h3>
                <div class="grid-produits">

                    <article class="produit-card">
                        <img src="img/produits/pizza_margherita.jpg" alt="Pizza Margherita" class="produit-img">
                        <div class="produit-info">
                            <h4>Pizza Margherita</h4>
                            <p class="description">Sauce tomate, mozzarella AOP, basilic frais</p>
                            <p class="prix">9.50 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_4">Quantité :</label>
                                <input type="number" id="qte_4" name="quantite[4]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <article class="produit-card">
                        <img src="img/produits/pizza_reine.jpg" alt="Pizza Reine" class="produit-img">
                        <div class="produit-info">
                            <h4>Pizza Reine (Regina)</h4>
                            <p class="description">Sauce tomate, mozzarella, jambon blanc, champignons</p>
                            <p class="prix">11.00 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_5">Quantité :</label>
                                <input type="number" id="qte_5" name="quantite[5]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <article class="produit-card">
                        <img src="img/produits/pizza_4fromages.jpg" alt="Pizza 4 Fromages" class="produit-img">
                        <div class="produit-info">
                            <h4>Pizza 4 Fromages</h4>
                            <p class="description">Mozzarella, gorgonzola, chèvre, emmental</p>
                            <p class="prix">12.50 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_6">Quantité :</label>
                                <input type="number" id="qte_6" name="quantite[6]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <article class="produit-card">
                        <img src="img/produits/pizza_pepperoni.jpg" alt="Pizza Pepperoni" class="produit-img">
                        <div class="produit-info">
                            <h4>Pizza Pepperoni Spicy</h4>
                            <p class="description">Sauce tomate, mozzarella, pepperoni piquant, origan</p>
                            <p class="prix">12.00 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_7">Quantité :</label>
                                <input type="number" id="qte_7" name="quantite[7]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <article class="produit-card">
                        <img src="img/produits/pizza_vegetarienne.jpg" alt="Pizza Végétarienne" class="produit-img">
                        <div class="produit-info">
                            <h4>Pizza Végétarienne</h4>
                            <p class="description">Sauce tomate, mozzarella, poivrons grillés, courgettes, olives</p>
                            <p class="prix">11.50 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_8">Quantité :</label>
                                <input type="number" id="qte_8" name="quantite[8]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                </div>
            </section>

            
            <section class="categorie-produits">
                <h3>🥤 Boissons</h3>
                <div class="grid-produits">

                    <article class="produit-card">
                        <img src="img/produits/coca_cola.jpg" alt="Coca-Cola 33cl" class="produit-img">
                        <div class="produit-info">
                            <h4>Coca-Cola (33cl)</h4>
                            <p class="prix">2.50 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_9">Quantité :</label>
                                <input type="number" id="qte_9" name="quantite[9]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <article class="produit-card">
                        <img src="img/produits/coca_zero.jpg" alt="Coca-Cola Zero 33cl" class="produit-img">
                        <div class="produit-info">
                            <h4>Coca-Cola Zero (33cl)</h4>
                            <p class="prix">2.50 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_10">Quantité :</label>
                                <input type="number" id="qte_10" name="quantite[10]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <article class="produit-card">
                        <img src="img/produits/ice_tea.jpg" alt="Ice Tea Pêche 33cl" class="produit-img">
                        <div class="produit-info">
                            <h4>Ice Tea Pêche (33cl)</h4>
                            <p class="prix">2.50 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_11">Quantité :</label>
                                <input type="number" id="qte_11" name="quantite[11]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <article class="produit-card">
                        <img src="img/produits/eau_minerale.jpg" alt="Eau Minérale 50cl" class="produit-img">
                        <div class="produit-info">
                            <h4>Eau Minérale (50cl)</h4>
                            <p class="prix">1.80 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_12">Quantité :</label>
                                <input type="number" id="qte_12" name="quantite[12]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                </div>
            </section>

            
            <section class="categorie-produits">
                <h3>🍰 Desserts</h3>
                <div class="grid-produits">

                    <article class="produit-card">
                        <img src="img/produits/tiramisu.jpg" alt="Tiramisu" class="produit-img">
                        <div class="produit-info">
                            <h4>Tiramisu Fait Maison</h4>
                            <p class="prix">4.00 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_13">Quantité :</label>
                                <input type="number" id="qte_13" name="quantite[13]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                    <article class="produit-card">
                        <img src="img/produits/brownie.jpg" alt="Brownie Chocolat" class="produit-img">
                        <div class="produit-info">
                            <h4>Brownie Chocolat & Noix</h4>
                            <p class="prix">3.50 € HT</p>
                            <div class="quantite-selector">
                                <label for="qte_14">Quantité :</label>
                                <input type="number" id="qte_14" name="quantite[14]" min="0" max="20" value="0">
                            </div>
                        </div>
                    </article>

                </div>
            </section>

        
            <div class="actions-commande">
                <button type="submit" class="btn-primary">Valider la commande & Payer &rarr;</button>
            </div>

        </form>
    </main>

    <footer>
        <p>&copy; 2024 RestoWeb - Tous droits réservés</p>
    </footer>

</body>
</html>