<?php
require '../config.php';

// Handle status update
if (isset($_POST['update_statut'])) {
    $stmt = $pdo->prepare("UPDATE Commande SET statut = :statut WHERE idCommande = :id");
    $stmt->execute([
        'statut' => $_POST['statut'],
        'id'     => $_POST['idCommande']
    ]);
    header('Location: commandes.php');
    exit;
}

// Fatch ALL the commandes
$stmt = $pdo->query("
    SELECT 
        c.idCommande,
        c.dateCmd,
        c.statut,
        cl.nom_complet AS client,
        cl.telephone,
        cl.email,
        l.adresse,
        l.dateLivraison,
        GROUP_CONCAT(CONCAT(p.marque, ' ', p.modele) SEPARATOR ', ') AS produits,
        SUM(p.prix * pc.quantite) AS total
    FROM Commande c
    JOIN Client cl ON cl.idClient = c.idClient
    JOIN Livraison l ON l.idCommande = c.idCommande
    JOIN ProduitCmd pc ON pc.idCommande = c.idCommande
    JOIN Phones p ON p.idPhone = pc.idPhones
    GROUP BY c.idCommande, c.dateCmd, c.statut, cl.nom_complet, cl.telephone, cl.email, l.adresse, l.dateLivraison
    ORDER BY c.idCommande DESC
");
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes</title>
    <link rel="stylesheet" href="../CSS/style_admin.css">
    <link rel="stylesheet" href="../CSS/commandes.css">
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
            <h2>Toutes les Commandes</h2>
            <span class="total-count"><?= count($commandes) ?> commande(s)</span>
        </div>
        <hr class="page-divider">

        <?php if (empty($commandes)): ?>
            <div class="empty-state">
                <p>Aucune commande trouvée.</p>
            </div>
        <?php else: ?>

        <table class="commandes-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Produits</th>
                    <th>Adresse</th>
                    <th>Date Commande</th>
                    <th>Livraison Prévue</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandes as $cmd):
                    $class = match($cmd['statut']) {
                        'Livrée'   => 'badge-livree',
                        'Expédiée' => 'badge-expediee',
                        default    => 'badge-attente'
                    };
                ?>
                <tr>
                    <td><strong>#<?= $cmd['idCommande'] ?></strong></td>
                    <td>
                        <div class="client-info">
                            <strong><?= htmlspecialchars($cmd['client']) ?></strong>
                            <small><?= htmlspecialchars($cmd['email']) ?></small>
                            <small><?= htmlspecialchars($cmd['telephone']) ?></small>
                        </div>
                    </td>
                    <td class="produits-cell"><?= htmlspecialchars($cmd['produits']) ?></td>
                    <td class="adresse-cell"><?= htmlspecialchars($cmd['adresse']) ?></td>
                    <td><?= date('d M Y', strtotime($cmd['dateCmd'])) ?></td>
                    <td><?= date('d M Y', strtotime($cmd['dateLivraison'])) ?></td>
                    <td><strong><?= number_format($cmd['total'], 0, '.', ',') ?>DH</strong></td>
                    <td><span class="badge <?= $class ?>"><?= $cmd['statut'] ?></span></td>
                    <td>
                        <form method="post" action="commandes.php" style="display:flex; gap:6px; align-items:center;">
                            <input type="hidden" name="idCommande" value="<?= $cmd['idCommande'] ?>">
                            <select name="statut" class="statut-select <?= $class ?>">
                                <option value="En attente" <?= $cmd['statut'] === 'En attente' ? 'selected' : '' ?>>En attente</option>
                                <option value="Expédiée"   <?= $cmd['statut'] === 'Expédiée'   ? 'selected' : '' ?>>Expédiée</option>
                                <option value="Livrée"     <?= $cmd['statut'] === 'Livrée'     ? 'selected' : '' ?>>Livrée</option>
                            </select>
                            <button type="submit" name="update_statut" value="1" class="btn-update">✓</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php endif; ?>
    </div>
</main>

<footer>
    <p>&copy; 2026 Smartphone. All rights reserved.</p>
</footer>
</body>
</html>