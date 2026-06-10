<?php
require '../config.php';
// Handle status update
if (isset($_POST['update_statut'])) {
    $idCommande = $_POST['idCommande'];
    $newStatut  = $_POST['statut'];

    $stmt = $pdo->prepare("UPDATE Commande SET statut = :statut WHERE idCommande = :id");
    $stmt->execute([
        'statut' => $newStatut,
        'id'     => $idCommande
    ]);

    header('Location: admin.php');
    exit;
}
//To affiche just three products
$sql = "SELECT * FROM Phones LIMIT 4";
$stmt = $pdo->query($sql);
$phones = $stmt->fetchAll(PDO:: FETCH_ASSOC);
$sql2 = "
    SELECT 
        c.idCommande,
        c.dateCmd,
        c.statut,
        cl.nom_complet AS client,
        GROUP_CONCAT(CONCAT(p.marque, ' ', p.modele) SEPARATOR ', ') AS produit,
        SUM(p.prix * pc.quantite) AS total
    FROM Commande c
    JOIN Client cl ON cl.idClient = c.idClient
    JOIN ProduitCmd pc ON pc.idCommande = c.idCommande
    JOIN Phones p ON p.idPhone = pc.idPhones
    GROUP BY c.idCommande, c.dateCmd, c.statut, cl.nom_complet
    ORDER BY c.idCommande DESC
    LIMIT 5
";
$stmt2 = $pdo->query($sql2);
$commandes = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/style_admin.css">
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
        <div>
            <h3>Produits:</h3>
            <a href="produits.php">Voir plus -></a>
            <?php foreach($phones as $phone){?>
            <div class="card">
                <img src="../asset/<?php echo ($phone['image']); ?>" alt="<?php echo ($phone['modele']); ?>" width="300">
                <p><?php echo ($phone['marque']); ?></p>
                <h3><?php echo ($phone['modele']); ?></h3>
                <p><?php echo ($phone['prix']); ?></p>
                <a href="modifier.php?id=<?= $phone['idPhone']; ?>">Modifier</a> <a href="remove.php?id=<?= $phone['idPhone']; ?>">Supprimer</a>
            </div>
            <?php }?>
        </div>
        <div>
            <h3>Stock Alerts:</h3>
            <?php foreach($phones as $phone){ if($phone['stock'] <=10) {?>
            <div class="card">
                <img src="../asset/<?php echo ($phone['image']); ?>" alt="<?php echo ($phone['modele']); ?>" width="300">
                <p><?php echo ($phone['marque']); ?></p>
                <h3><?php echo ($phone['modele']); ?></h3>
                <p><?php echo ($phone['prix']); ?></p>
                <a href="modifier.php?id=<?= $phone['idPhone']; ?>">Modifier</a> <a href="remove.php?id=<?= $phone['idPhone']; ?>">Supprimer</a>
            </div>
            <?php }}?>
        </div>
        <div>
            <h3>Nouveau Commandes:</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Produit</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($commandes as $commande):
                                $class = match($commande['statut']) {
                                    'Livrée'   => 'badge-livree',
                                    'Expédiée' => 'badge-expediee',
                                    default    => 'badge-attente'
                                };
                        ?>
                    <tr>
                        <td><?= $commande['idCommande'] ?></td>
                        <td><?= htmlspecialchars($commande['client']) ?></td>
                        <td><?= htmlspecialchars($commande['produit']) ?></td>
                        <td><?= date('d M Y', strtotime($commande['dateCmd'])) ?></td>
                        <td><?= number_format($commande['total'], 0, '.', ',') ?>DH</td>
                        <td>
                            <form method="post" style="display:flex; align-items:center; gap:8px;">
                                <input type="hidden" name="idCommande" value="<?= $commande['idCommande'] ?>">
                                <select name="statut" class="statut-select <?= $class ?>">
                                    <option value="En attente"  <?= $commande['statut'] === 'En attente' ? 'selected' : '' ?>>En attente</option>
                                    <option value="Expédiée"    <?= $commande['statut'] === 'Expédiée'   ? 'selected' : '' ?>>Expédiée</option>
                                    <option value="Livrée"      <?= $commande['statut'] === 'Livrée'     ? 'selected' : '' ?>>Livrée</option>
                                </select>
                                <button type="submit" name="update_statut" class="btn-update">✓</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>