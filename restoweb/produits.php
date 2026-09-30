<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVALTAPIZZA - Nos Produits</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <img src="img/logo.png" alt="Logo AVALTAPIZZA">
        <h1>Nos Pizzas & Produits</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="produits.php">Carte & Produits</a>
            <a href="connexion.php">Connexion</a>
            <a href="inscription.php">Inscription</a>
            <a href="deconnexion.php">Déconnexion</a>
        </nav>
    </header>

    <main class="container">

        <!-- Choix du mode de consommation -->
        <section class="mode-consommation">
            <h2>1. Mode de consommation</h2>
            <div class="mode-options">
                <label class="mode-option">
                    <input type="radio" name="mode" value="sur_place" checked onchange="updateTvaInfo()">
                    Sur place
                </label>
                <label class="mode-option">
                    <input type="radio" name="mode" value="a_emporter" onchange="updateTvaInfo()">
                    À emporter
                </label>
            </div>

            <div id="tva-box" class="tva-info">
                <strong>TVA appliquée (Sur place) :</strong> 10 % sur la nourriture et boissons non alcoolisées, 20 % sur les boissons alcoolisées.
            </div>
        </section>

        <!-- Sélection des produits -->
        <section>
            <h2>2. Notre Carte</h2>

            <!-- CATEGORIE : MENUS -->
            <h3 class="categorie-titre">Menus</h3>
            <div class="grid-produits">
                <div class="produit-card">
                    <img src="images/pizza.jpg" alt="Menu Solo" class="produit-img">
                    <div class="produit-content">
                        <h3 class="produit-titre">Menu Solo</h3>
                        <p class="produit-desc">1 Pizza au choix + 1 Boisson 33cl au choix.</p>
                        <div class="produit-footer">
                            <div>
                                <span class="produit-prix">14.00 € TTC</span>
                                <span class="tva-badge">TVA 10 % incluses</span>
                            </div>
                            <div class="quantite-selector">
                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                <input type="number" name="quantite[m1]" value="0" min="0" max="20" readonly>
                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="produit-card">
                    <img src="images/pizza.jpg" alt="Menu Duo" class="produit-img">
                    <div class="produit-content">
                        <h3 class="produit-titre">Menu Duo</h3>
                        <p class="produit-desc">2 Pizzas au choix + 2 Boissons 33cl + 1 Tiramisu à partager.</p>
                        <div class="produit-footer">
                            <div>
                                <span class="produit-prix">27.50 € TTC</span>
                                <span class="tva-badge">TVA 10 % incluses</span>
                            </div>
                            <div class="quantite-selector">
                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                <input type="number" name="quantite[m2]" value="0" min="0" max="20" readonly>
                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CATEGORIE : PIZZAS -->
            <h3 class="categorie-titre">Nos Pizzas Artisanales</h3>
            <div class="grid-produits">
                <div class="produit-card">
                    <img src="images/pizza.jpg" alt="Pizza Margherita" class="produit-img">
                    <div class="produit-content">
                        <h3 class="produit-titre">Margherita</h3>
                        <p class="produit-desc">Sauce tomate, mozzarella fior di latte, basilic frais, huile d'olive.</p>
                        <div class="produit-footer">
                            <div>
                                <span class="produit-prix">9.50 € TTC</span>
                                <span class="tva-badge">TVA 10 % incluses</span>
                            </div>
                            <div class="quantite-selector">
                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                <input type="number" name="quantite[p1]" value="0" min="0" max="20" readonly>
                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="produit-card">
                    <img src="images/pizza.jpg" alt="Pizza Reine" class="produit-img">
                    <div class="produit-content">
                        <h3 class="produit-titre">Reine</h3>
                        <p class="produit-desc">Sauce tomate, mozzarella, jambon blanc, champignons frais.</p>
                        <div class="produit-footer">
                            <div>
                                <span class="produit-prix">11.50 € TTC</span>
                                <span class="tva-badge">TVA 10 % incluses</span>
                            </div>
                            <div class="quantite-selector">
                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                <input type="number" name="quantite[p2]" value="0" min="0" max="20" readonly>
                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="produit-card">
                    <img src="images/pizza.jpg" alt="Pizza 4 Fromages" class="produit-img">
                    <div class="produit-content">
                        <h3 class="produit-titre">4 Fromages</h3>
                        <p class="produit-desc">Sauce tomate, mozzarella, gorgonzola, chèvre, emmental.</p>
                        <div class="produit-footer">
                            <div>
                                <span class="produit-prix">12.50 € TTC</span>
                                <span class="tva-badge">TVA 10 % incluses</span>
                            </div>
                            <div class="quantite-selector">
                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                <input type="number" name="quantite[p3]" value="0" min="0" max="20" readonly>
                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="produit-card">
                    <img src="images/pizza.jpg" alt="Pizza Orientale" class="produit-img">
                    <div class="produit-content">
                        <h3 class="produit-titre">Orientale</h3>
                        <p class="produit-desc">Sauce tomate, mozzarella, merguez artisanale, poivrons, œufs.</p>
                        <div class="produit-footer">
                            <div>
                                <span class="produit-prix">12.00 € TTC</span>
                                <span class="tva-badge">TVA 10 % incluses</span>
                            </div>
                            <div class="quantite-selector">
                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                <input type="number" name="quantite[p4]" value="0" min="0" max="20" readonly>
                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CATEGORIE : DESSERTS -->
            <h3 class="categorie-titre">Desserts</h3>
            <div class="grid-produits">
                <div class="produit-card">
                    <img src="images/pizza.jpg" alt="Tiramisu Maison" class="produit-img">
                    <div class="produit-content">
                        <h3 class="produit-titre">Tiramisu Maison</h3>
                        <p class="produit-desc">Recette traditionnelle au café et mascarpone.</p>
                        <div class="produit-footer">
                            <div>
                                <span class="produit-prix">4.50 € TTC</span>
                                <span class="tva-badge">TVA 10 % (sur place) / 5.5 % (emporter)</span>
                            </div>
                            <div class="quantite-selector">
                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                <input type="number" name="quantite[d1]" value="0" min="0" max="20" readonly>
                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="produit-card">
                    <img src="images/pizza.jpg" alt="Panna Cotta" class="produit-img">
                    <div class="produit-content">
                        <h3 class="produit-titre">Panna Cotta</h3>
                        <p class="produit-desc">Nappage coulis de fruits rouges ou caramel au beurre salé.</p>
                        <div class="produit-footer">
                            <div>
                                <span class="produit-prix">4.00 € TTC</span>
                                <span class="tva-badge">TVA 10 % (sur place) / 5.5 % (emporter)</span>
                            </div>
                            <div class="quantite-selector">
                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                <input type="number" name="quantite[d2]" value="0" min="0" max="20" readonly>
                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CATEGORIE : BOISSONS -->
            <h3 class="categorie-titre">Boissons</h3>
            <div class="grid-produits">
                <div class="produit-card">
                    <img src="images/pizza.jpg" alt="Soda 33cl" class="produit-img">
                    <div class="produit-content">
                        <h3 class="produit-titre">Soda 33cl</h3>
                        <p class="produit-desc">Coca-Cola, Coca Zero, Ice Tea, Orangina.</p>
                        <div class="produit-footer">
                            <div>
                                <span class="produit-prix">2.50 € TTC</span>
                                <span class="tva-badge">TVA 10 % (sur place) / 5.5 % (emporter)</span>
                            </div>
                            <div class="quantite-selector">
                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                <input type="number" name="quantite[b1]" value="0" min="0" max="20" readonly>
                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="produit-card">
                    <img src="images/pizza.jpg" alt="Eau Minérale 50cl" class="produit-img">
                    <div class="produit-content">
                        <h3 class="produit-titre">Eau Minérale 50cl</h3>
                        <p class="produit-desc">Eau plate ou gazeuse.</p>
                        <div class="produit-footer">
                            <div>
                                <span class="produit-prix">2.00 € TTC</span>
                                <span class="tva-badge">TVA 10 % (sur place) / 5.5 % (emporter)</span>
                            </div>
                            <div class="quantite-selector">
                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                <input type="number" name="quantite[b2]" value="0" min="0" max="20" readonly>
                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="produit-card">
                    <img src="images/pizza.jpg" alt="Bière Italienne 33cl" class="produit-img">
                    <div class="produit-content">
                        <h3 class="produit-titre">Bière Italienne 33cl</h3>
                        <p class="produit-desc">Peroni ou Nastro Azzurro (Alcool).</p>
                        <div class="produit-footer">
                            <div>
                                <span class="produit-prix">4.00 € TTC</span>
                                <span class="tva-badge">TVA 20 % (Alcool)</span>
                            </div>
                            <div class="quantite-selector">
                                <button type="button" class="btn-qty" onclick="changeQty(this, -1)">-</button>
                                <input type="number" name="quantite[b3]" value="0" min="0" max="20" readonly>
                                <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bouton validation -->
            <div class="auth-buttons">
                <a href="paiement.php" class="btn-primary">Passer la commande</a>
            </div>
        </section>

    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés</p>
    </footer>

    <script>
    function changeQty(btn, delta) {
        const container = btn.closest('.quantite-selector');
        const input = container.querySelector('input[type="number"]');
        let val = parseInt(input.value) || 0;
        val = Math.max(0, Math.min(20, val + delta));
        input.value = val;
    }

    function updateTvaInfo() {
        const mode = document.querySelector('input[name="mode"]:checked').value;
        const tvaBox = document.getElementById('tva-box');
        
        if (mode === 'sur_place') {
            tvaBox.innerHTML = '<strong>TVA appliquée (Sur place) :</strong> 10 % sur les pizzas, plats préparés, desserts et sodas ; 20 % sur l\'alcool.';
        } else {
            tvaBox.innerHTML = '<strong>TVA appliquée (À emporter) :</strong> 10 % sur les pizzas chaudes et plats préparés ; 5,5 % sur les boissons sous emballage (sodas, eau) et desserts conditionnés ; 20 % sur l\'alcool.';
        }
    }
    </script>

</body>
</html>