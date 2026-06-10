<?php
require '../config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: produits.php');
    exit;
}

$error   = '';
$success = '';

// Fetch existing product
$stmt = $pdo->prepare("SELECT * FROM Phones WHERE idPhone = :id");
$stmt->execute(['id' => $id]);
$phone = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$phone) {
    header('Location: produits.php');
    exit;
}

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
        $image = $phone['image']; // keep old image by default
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $ext   = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image = uniqid('phone_') . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], '../asset/' . $image);
        }

        $stmt = $pdo->prepare("
            UPDATE Phones SET
                modele      = :modele,
                marque      = :marque,
                prix        = :prix,
                description = :description,
                ram         = :ram,
                stockage    = :stockage,
                batterie    = :batterie,
                camera      = :camera,
                stock       = :stock,
                image       = :image,
                categorie   = :categorie
            WHERE idPhone = :id
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
            'categorie'   => $categorie,
            'id'          => $id
        ]);

        $success = "Produit modifié avec succès.";

        // Refresh product data
        $stmt = $pdo->prepare("SELECT * FROM Phones WHERE idPhone = :id");
        $stmt->execute(['id' => $id]);
        $phone = $stmt->fetch(PDO::FETCH_ASSOC);
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
        </nav>
    </header>
    <main>
<div class="page-wrapper">

    <div class="page-top">
        <a href="produits.php" class="btn-back">Retour</a>
        <h2>Modifier le Produit</h2>
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
            <label>Modèle</label>
            <input type="text" name="modele"   value="<?= htmlspecialchars($phone['modele']) ?>">
            <label>Marque</label>
            <input type="text" name="marque"   value="<?= htmlspecialchars($phone['marque']) ?>">
            <label>Prix</label>
            <input type="number" name="prix"   value="<?= $phone['prix']  ?>">
            <label>RAM</label>
            <input type="text" name="ram"      value="<?= htmlspecialchars($phone['ram']) ?>">
            <label>Stockage</label>
            <input type="text" name="stockage" value="<?= htmlspecialchars($phone['stockage']) ?>">
            <label>Batterie</label>
            <input type="text" name="batterie" value="<?= htmlspecialchars($phone['batterie']) ?>">
            <label>Camera</label>
            <input type="text" name="camera"   value="<?= htmlspecialchars($phone['camera']) ?>">
            <label>Stock</label>
            <input type="number" name="stock"  value="<?= $phone['stock'] ?>">
            <label>Description</label>
            <textarea name="description"><?= htmlspecialchars($phone['description']) ?></textarea>
            <label>Image</label>
            <div class="image-upload-box">
                <input type="file" name="image" accept="image/*">
                <p>Cliquez pour uploader</p>
            </div>
            <label>Catégorie</label>
            <select name="categorie">
                <option value="phones"     <?= $phone['categorie'] === 'phones'     ? 'selected' : '' ?>>Phones</option>
                <option value="accessoirs" <?= $phone['categorie'] === 'accessoirs' ? 'selected' : '' ?>>Accessoires</option>
            </select>
            <button type="submit" class="btn-submit"> Sauvegarder</button>

        </div>
    </form>

</div>
</main>
</body>
</html>