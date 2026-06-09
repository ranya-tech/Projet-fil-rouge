<?php
require 'config.php';
//To affiche just three products
$sql = "SELECT * FROM Phones ";
$stmt = $pdo->query($sql);
$phones = $stmt->fetchAll(PDO:: FETCH_ASSOC);
$sql2 = "SELECT * FROM Commande ORDER BY idCommande DESC LIMIT 5";
$stmt2 = $pdo->query($sql2);
$commandes = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/style_admn.css">
</head>
<body>
    <header>
        <img src="asset/admin.png" alt="Admin">
        <nav>
            <a href="admin.php">Dashboard</a>
            <a href="produits.php">Produits</a>
            <a href="#">Commandes</a>
        </nav>
    </header>
    <main>
        <div>
            <h3>Produits:</h3>
            <a href="produits.php">Voir plus -></a>
            <?php foreach($phones as $phone){?>
            <div class="card">
                <img src="asset/<?php echo ($phone['image']); ?>" alt="<?php echo ($phone['modele']); ?>" width="300">
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
                <img src="asset/<?php echo ($phone['image']); ?>" alt="<?php echo ($phone['modele']); ?>" width="300">
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
                    <?php foreach($commandes as $commande){ ?>
                    <tr>
                        <td><?= $commande['idCommande']; ?></td>
                        <td><?= $commande['client']; ?></td>
                        <td><?= $commande['produit']; ?></td>
                        <td><?= $commande['date']; ?></td>
                        <td><?= $commande['total']; ?>DH</td>
                        <td>
                            <?php if($commande['status'] == 'En attente'){ ?>
                                <span class="badge badge-pending">En attente</span>
                            <?php } elseif($commande['status'] == 'Expédié'){ ?>
                                <span class="badge badge-shipped">Expédié</span>
                            <?php } elseif($commande['status'] == 'Livrée'){ ?>
                                <span class="badge badge-delivered">Livrée</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>