<?php
require '../config.php';

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modele      = trim($_POST['modele']);
    $marque      = trim($_POST['marque']);
    $prix        = trim($_POST['prix']);
    $description = trim($_POST['description']);
    $ram         = trim($_POST['ram']);
    $stockage    = trim($_POST['stockage']);
    $batterie    = trim($_POST['batterie']);
    $camera      = trim($_POST['camera']);
    $stock       = trim($_POST['stock']);
    $categorie   = trim($_POST['categorie']);

    if (empty($modele) || empty($marque) || empty($prix)) {
        $error = "Veuillez remplir tous les champs obligatoires.";
    } else {
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $ext   = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image = uniqid('phone_') . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], '../asset/' . $image);
        }

        $stmt = $pdo->prepare("
            INSERT INTO Phones (modele, marque, prix, description, ram, stockage,  batterie, camera, stock, image, categorie)
            VALUES (:modele, :marque, :prix, :description, :ram, :stockage,  :batterie, :camera, :stock, :image, :categorie)
        ");
        $stmt->execute([
            'modele'      => $modele,
            'marque'      => $marque,
            'prix'        => $prix,
            'description' => $description,
            'ram'         => $ram,
            'stockage'    => $stockage,
            'batterie'    => $batterie,
            'camera'      => $camera,
            'stock'       => $stock,
            'image'       => $image,
            'categorie'   => $categorie
        ]);

        $success = "Produit ajouté avec succès.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/ajouter.css">
</head>
<body>
    <header>
        <img src="../asset/admin.png" alt="Admin">
        <nav>
            <a href="admin.php">Dashboard</a>
            <a href="produits.php">Produits</a>
            <a href="commandes.php">Commandes</a>
        </nav>
    </header>
    <main>
<div class="page-wrapper">

    <div class="page-top">
        <a href="produits.php" class="btn-back">Retour</a>
        <h2>Ajouter un Produit</h2>
        <div style="width:80px;"></div> <!-- spacer to center title -->
    </div>
    <hr class="page-divider">

    <?php if ($error): ?>
        <div class="alert-error"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-body">

            <!-- LEFT -->
            <div class="form-left">
                <div class="form-field">
                    <label>Modèle</label>
                    <input type="text" name="modele" placeholder="iPhone 15 Pro">
                </div>
                <div class="form-field">
                    <label>Marque</label>
                    <input type="text" name="marque" placeholder="Apple">
                </div>
                <div class="form-field">
                    <label>Prix</label>
                    <input type="number" name="prix" placeholder="12500">
                </div>
                <div class="form-field">
                    <label>RAM</label>
                    <input type="text" name="ram" placeholder="8GB">
                </div>
                <div class="form-field">
                    <label>Stockage</label>
                    <input type="text" name="stockage" placeholder="256GB">
                </div>
                <div class="form-field">
                    <label>Batterie</label>
                    <input type="text" name="batterie" placeholder="4000mAh">
                </div>
                <div class="form-field">
                    <label>Caméra</label>
                    <input type="text" name="camera" placeholder="48MP + 12MP">
                </div>
                <div class="form-field">
                    <label>Catégorie</label>
                    <select name="categorie">
                        <option value="phones">Phones</option>
                        <option value="accessoirs">Accessoires</option>
                    </select>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="form-right">
                <div class="form-field">
                    <label>Description</label>
                    <textarea name="description" placeholder="Enter detailed product description..."></textarea>
                </div>
                <div class="form-field">
                    <label>Image</label>
                    <div class="image-upload-box">
                        <input type="file" name="image" accept="image/*">
                        <p>Cliquez pour uploader</p>
                    </div>
                </div>
                <div class="form-field">
                    <label>Stock</label>
                    <input type="number" name="stock" placeholder="50">
                </div>
                <button type="submit" class="btn-submit">Ajouter</button>
            </div>

        </div>
    </form>

</div>
</main>
</body>
</html>