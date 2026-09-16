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
            <a href="connexion.php">Connexion</a>
            <a href="inscription.php">Inscription</a>
            <a href="deconnexion.php">Déconnexion</a>
        </nav>
    </header>

    <main class="container">

        <div class="checkout-grid">

            <!-- Colonne 1 : Récapitulatif -->
            <section class="recap-card">
                <h2>Récapitulatif de commande</h2>
                
                <div class="badge-mode">
                    Mode retenu : <strong>À emporter</strong>
                </div>

                <table class="recap-table">
                    <thead>
                        <tr>
                            <th>Article</th>
                            <th class="text-center">Qté</th>
                            <th class="text-right">Prix</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Pizza Reine</strong></td>
                            <td class="text-center"><span class="qty-pill">1</span></td>
                            <td class="text-right">11,50 €</td>
                            <td class="text-right"><strong>11,50 €</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Soda 33cl</strong><br><small>Coca-Cola</small></td>
                            <td class="text-center"><span class="qty-pill">2</span></td>
                            <td class="text-right">2,50 €</td>
                            <td class="text-right"><strong>5,00 €</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Tiramisu Maison</strong></td>
                            <td class="text-center"><span class="qty-pill">1</span></td>
                            <td class="text-right">4,50 €</td>
                            <td class="text-right"><strong>4,50 €</strong></td>
                        </tr>
                    </tbody>
                </table>

                <div class="recap-totals">
                    <div class="total-row">
                        <span>Sous-total HT :</span>
                        <span>19,18 €</span>
                    </div>
                    <div class="total-row">
                        <span>TVA :</span>
                        <span>1,82 €</span>
                    </div>
                    <div class="total-row final">
                        <span>Total TTC :</span>
                        <span>21,00 €</span>
                    </div>
                </div>
            </section>

            <!-- Colonne 2 : Formulaire de paiement -->
            <section class="form-box">
                <h2>Payer par Carte Bancaire</h2>

                <form action="index.php" method="GET">
                    <fieldset>
                        <legend>Informations de paiement</legend>

                        <div class="form-group">
                            <label for="cardholder">Nom figurant sur la carte</label>
                            <input type="text" id="cardholder" name="cardholder" required autocomplete="cc-name" placeholder="M. Jean Dupont">
                        </div>

                        <div class="form-group">
                            <label for="cardnumber">Numéro de carte bancaire</label>
                            <input type="text" id="cardnumber" name="cardnumber" required inputmode="numeric" maxlength="19" autocomplete="cc-number" placeholder="1234 5678 9101 1121">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="cardexpiry">Expiration</label>
                                <input type="text" id="cardexpiry" name="cardexpiry" required inputmode="numeric" maxlength="5" placeholder="MM/AA" autocomplete="cc-exp">
                            </div>

                            <div class="form-group">
                                <label for="cardcvc">Code CVC / CVV</label>
                                <input type="text" id="cardcvc" name="cardcvc" required inputmode="numeric" maxlength="4" placeholder="123" autocomplete="cc-csc">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" id="savecard" name="savecard">
                                Enregistrer cette carte
                            </label>
                        </div>
                    </fieldset>

                    <button type="submit" class="btn-primary">Payer 21,00 €</button>
                </form>
            </section>

        </div>

    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés. Transactions sécurisées SSL.</p>
    </footer>

</body>
</html>