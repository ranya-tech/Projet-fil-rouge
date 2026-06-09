<?php 
session_start(); 
require 'config.php';

// 1. Remove Item from Cart
if (isset($_GET['remove'])) {
    $key_to_remove = $_GET['remove'];
    unset($_SESSION['panier'][$key_to_remove]);
    header('Location: panier.php');
    exit;
}

// 2. Optional: Handle Quantity Changes (Plus/Minus Buttons)
if (isset($_GET['action']) && isset($_GET['key'])) {
    $key = $_GET['key'];
    if (isset($_SESSION['panier'][$key])) {
        if ($_GET['action'] === 'increase') {
            $_SESSION['panier'][$key]['quantite']++;
        } elseif ($_GET['action'] === 'decrease') {
            $_SESSION['panier'][$key]['quantite']--;
            // If quantity drops to 0, remove it
            if ($_SESSION['panier'][$key]['quantite'] <= 0) {
                unset($_SESSION['panier'][$key]);
            }
        }
    }
    header('Location: panier.php');
    exit;
}

$total_panier = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="CSS/style_panier.css">
</head>
<body>
    <header>
        <img src="asset/Logo.png" alt="Logo">
        <nav>
            <a href="Accueil.php">Accueil</a>
            <a href="category.php">Categorie</a>
            <a href="panier.php"><img src="asset/panier.png" alt="Panier" width="16">Panier</a>
            <?php 
                if(isset($_SESSION['user'])){
                    $user = $_SESSION['user'];
                    echo "<a href='profil.php' class='profil'>" . $user['name'] . "</a>";
                }else{
                    header('Location: login.php');
                    exit;
                }
            ?>
        </nav>
    </header>

    <main>
        <a href="category.php">&larr; Retour aux catégories</a>
        <h2>Panier</h2>

        <?php if (!empty($_SESSION['panier'])): ?>

        <div class="panier-wrapper">

            <!-- LEFT: cart items -->
            <div class="cart-items-col">
                <?php foreach ($_SESSION['panier'] as $key => $item):
                    $sql  = "SELECT * FROM Phones WHERE idPhone = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['id' => $item['id']]);
                    $phone = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($phone):
                        $subtotal      = $phone['prix'] * $item['quantite'];
                        $total_panier += $subtotal;
                ?>
                <div class="cart-item-card">
                    <img src="asset/<?= $phone['image'] ?>" alt="<?= $phone['modele'] ?>">

                    <div class="item-info">
                        <h4><?= $phone['marque'] . ' ' . $phone['modele'] ?></h4>
                        <p><?= $item['couleur'] ?> | <?= $item['stockage'] ?></p>
                        <div class="qty-row">
                            <a href="panier.php?action=decrease&key=<?= urlencode($key) ?>" class="qty-btn">−</a>
                            <span class="qty-value"><?= $item['quantite'] ?></span>
                            <a href="panier.php?action=increase&key=<?= urlencode($key) ?>" class="qty-btn">+</a>
                        </div>
                    </div>

                    <div class="item-right">
                        <span class="item-price"><?= number_format($phone['prix'], 0, '.', ',') ?>DH</span>
                        <a href="panier.php?remove=<?= urlencode($key) ?>" class="remove-btn"
                        onclick="return confirm('Supprimer cet article ?')"> SUPPRIMER</a>
                    </div>
                </div>
                <?php endif; endforeach; ?>
            </div>

            <!-- RIGHT: order summary -->
            <div class="summary-box">
                <h3>Résumé de la commande</h3>
                <div class="summary-row">
                    <span>Sous-total</span>
                    <span><?= number_format($total_panier, 0, '.', ',') ?></span>
                </div>
                <div class="summary-row">
                    <span>Livraison</span>
                    <span class="free">Gratuite</span>
                </div>
                <hr class="summary-divider">
                <div class="summary-total">
                    <span>Total</span>
                    <span class="total-price"><?= number_format($total_panier, 0, '.', ',') ?>DH</span>
                </div>
                <a href="confirm.php" class="btn-livraison">Procéder au livraison →</a>
            </div>

        </div>

        <?php else: ?>
            <div class="empty-cart">
                <h3>Votre panier est vide.</h3>
                <p>Parcourez nos smartphones pour trouver votre bonheur !</p>
                <a href="category.php" class="checkout-btn" style="background:#3498db;">Voir les produits</a>
            </div>
        <?php endif; ?>
        <div>
            <h3>Livraison Information:</h3>
            <form method="post">
                <label for="">Nom Complet:</label>
                <input type="text" name="nom" placeholder="Ahmed Ahmed">
                <label for="">Téléphone:</label>
                <input type="tel" name="telephone" placeholder="0671234568">
                <label for="">Email:</label>
                <input type="email" name="email" placeholder="Ahmedahmed@gmail.com">
                <label for="">Adresse:</label>
                <input type="text" name="adresse" placeholder="123 Innovation Way, Palo Alto, CA94301">
                <button>Commander</button>
            </form>
        </div>

        <div>
            <h3>Votre Commande</h3>
            
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <img src="asset/Logo.png" alt="Smartphone">
            <a href="Accueil.php">Accueil</a>
            <a href="category.php">Categories</a>
            <a href="login.php">Connexion</a>
            <img src="asset/facebook.png" alt="Facebook" width="40">
            <img src="asset/insta.png" alt="Instagram" width="40">
            <img src="asset/twiter.png" alt="Twitter" width="40">
        </div>
        <p>&copy; 2026 Smartphone. All rights reserved.</p>
    </footer>
</body>
</html>