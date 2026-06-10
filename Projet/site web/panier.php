<?php 
session_start(); 
require '../config.php';

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
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nom = $_POST['nom'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    if(empty($nom) || empty($telephone) || empty($email) || empty($adresse)){
        echo "Veuillez remplir tous les champs.";
    }else{
        
            // 1. Get the logged-in client's ID
            $idClient = $_SESSION['user']['id'];

            // 2. Insert into Commande
            $stmt = $pdo->prepare("INSERT INTO Commande (idClient) VALUES (:idClient)");
            $stmt->execute(['idClient' => $idClient]);
            $idCommande = $pdo->lastInsertId();

            // 3. Insert into Livraison (estimated delivery: 5 days from now)
            $stmt = $pdo->prepare("INSERT INTO Livraison (adresse, destinataire, dateLivraison, idCommande) 
                                VALUES (:adresse, :destinataire, :dateLivraison, :idCommande)");
            $stmt->execute([
                'adresse'       => $adresse,
                'destinataire'  => $nom,
                'dateLivraison' => date('Y-m-d H:i:s', strtotime('+5 days')),
                'idCommande'    => $idCommande
            ]);
            // 4. Insert each cart item into ProduitCmd
            $stmt = $pdo->prepare("INSERT INTO ProduitCmd (idPhones, idCommande, quantite, couleur, stockage) 
                                VALUES (:idPhone, :idCommande, :quantite, :couleur, :stockage)");
            foreach($_SESSION['panier'] as $item) {
                $stmt->execute([
                    'idPhone'    => $item['id'],
                    'idCommande' => $idCommande,
                    'quantite'   => $item['quantite'],
                    'couleur'    => $item['couleur'],
                    'stockage'   => $item['stockage']
                ]);
            }

            // 5. Clear the cart
            unset($_SESSION['panier']);

            // 6. Redirect to a confirmation page
            header('Location: confirm.php?commande=' . $idCommande);
            exit;

    }
}

$total_panier = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="../CSS/style_panier.css">
</head>
<body>
    <header>
        <img src="../asset/Logo.png" alt="Logo">
        <nav>
            <a href="Accueil.php">Accueil</a>
            <a href="category.php">Categorie</a>
            <a href="panier.php"><img src="../asset/panier.png" alt="Panier" width="16">Panier</a>
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
                    <img src="../asset/<?= $phone['image'] ?>" alt="<?= $phone['modele'] ?>">

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
                <a href="#livraison" class="btn-livraison">Procéder au livraison →</a>            
            </div>
        </div>
        <div class="livraison-wrapper" id="livraison">
            <!-- LEFT: Delivery form -->
            <div class="livraison-form-box">
                <h3>Livraison Information:</h3>
                <form method="post">
                    <label>Nom Complet:</label>
                    <input type="text" name="nom" placeholder="Ahmed Ahmed">
                    <label>Téléphone:</label>
                    <input type="tel" name="telephone" placeholder="00.0000.0000">
                    <label>Email:</label>
                    <input type="email" name="email" placeholder="Ahmedahmed@gmail.com">
                    <label>Adresse:</label>
                    <input type="text" name="adresse" placeholder="123 Innovation Way, Palo Alto, CA94301">
                    <button type="submit" name="commende">Commander</button>
                </form>
            </div>

            <!-- RIGHT: Order summary -->
            <div class="commande-box">
                <h3>Votre Commande</h3>
                <div class="commande-items">
                    <?php foreach ($_SESSION['panier'] as $key => $item):
                        $stmt = $pdo->prepare("SELECT * FROM Phones WHERE idPhone = :id");
                        $stmt->execute(['id' => $item['id']]);
                        $phone = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($phone): ?>
                        <div class="commande-item">
                            <img src="../asset/<?= $phone['image'] ?>" alt="<?= $phone['modele'] ?>">
                            <div class="commande-item-info">
                                <strong><?= $phone['marque'] . ' ' . $phone['modele'] ?></strong>
                                <small><?= $item['couleur'] ?>, <?= $item['stockage'] ?></small>
                            </div>
                            <span class="commande-item-price"><?= number_format($phone['prix'] * $item['quantite'], 0, '.', ',') ?>DH</span>
                        </div>
                    <?php endif; endforeach; ?>
                </div>
                    <hr class="summary-divider">
                    <div class="summary-row"><span>Sous-total</span><span><?= number_format($total_panier, 0, '.', ',') ?>DH</span></div>
                    <div class="summary-row"><span>Livraison</span><span class="free">Gratuite</span></div>
                    <hr class="summary-divider">
                    <div class="summary-total"><span>Total</span><span class="total-price"><?= number_format($total_panier, 0, '.', ',') ?>DH</span></div>
                </div>
        <?php else: ?>
            <div class="empty-cart">
                <h3>Votre panier est vide.</h3>
                <p>Parcourez nos smartphones pour trouver votre bonheur !</p>
            </div>
        <?php endif; ?>

        </div>
    </main>

    <footer>
        <div class="footer-container">
            <img src="../asset/Logo.png" alt="Smartphone">
            <a href="Accueil.php">Accueil</a>
            <a href="category.php">Categories</a>
            <a href="login.php">Connexion</a>
            <img src="../asset/facebook.png" alt="Facebook" width="40">
            <img src="../asset/insta.png" alt="Instagram" width="40">
            <img src="../asset/twiter.png" alt="Twitter" width="40">
        </div>
        <p>&copy; 2026 Smartphone. All rights reserved.</p>
    </footer>
</body>
</html>