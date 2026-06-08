<?php
session_start();
require 'config.php';

// Redirect if not logged in
if (!$_SESSION['user']) {
    header('Location: login.php');
    exit;
}

$idClient = $_SESSION['user']['id'];

// Fetch client info
$stmt = $pdo->prepare("SELECT * FROM client WHERE idClient = :id");
$stmt->execute(['id' => $idClient]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch orders with total
$stmtCmd = $pdo->prepare("
    SELECT c.idCommande, c.dateCmd, c.statut,
           SUM(p.prix * pc.quantite) AS total
    FROM Commande c
    JOIN ProduitCmd pc ON pc.idCommande = c.idCommande
    JOIN Phones p ON p.idPhone = pc.idPhones
    WHERE c.idClient = :id
    GROUP BY c.idCommande
    ORDER BY c.dateCmd DESC
");
$stmtCmd->execute(['id' => $idClient]);
$commandes = $stmtCmd->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="CSS/style_profil.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="header-logo">
        <img src="asset/Logo.png" alt="Logo">
    </div>
    <nav>
        <a href="Accueil.php">Accueil</a>
        <a href="category.php">Catégories</a>
        <a href="panier.php">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            Panier
        </a>
    </nav>
    <a href="logout.php" class="btn-deconnexion">Déconnexion</a>
</header>

<main>

    <!-- Profile Header Card -->
    <div class="card profile-header-card">
        <div class="avatar">
            <img src="asset/avatar.png" alt="Avatar" onerror="this.style.display='none';this.parentElement.innerHTML='<span class=\'avatar-initials\'><?php echo strtoupper(substr($client['nom_complet'], 0, 1)); ?></span>'">
        </div>
        <h1><?php echo htmlspecialchars($client['nom_complet']); ?></h1>
    </div>

    <!-- Personal Info Card -->
    <div class="card">
        <div class="card-header">
            <h2>Informations Personnelles</h2>
            <a href="edit_profil.php" class="edit-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit All
            </a>
        </div>
        <div class="info-grid">
            <div class="info-field">
                <label>NOM COMPLET</label>
                <div class="info-value"><?php echo htmlspecialchars($client['nom_complet']); ?></div>
            </div>
            <div class="info-field">
                <label>EMAIL</label>
                <div class="info-value"><?php echo htmlspecialchars($client['email']); ?></div>
            </div>
            <div class="info-field">
                <label>TÉLÉPHONE</label>
                <div class="info-value"><?php echo htmlspecialchars($client['telephone']); ?></div>
            </div>
            <div class="info-field">
                <label>ADDRESS</label>
                <div class="info-value">—</div>
            </div>
        </div>
    </div>

    <!-- Orders History Card -->
    <div class="card">
        <div class="card-header">
            <h2>Historique des commandes</h2>
            <a href="commandes.php" class="view-all-link">View All Orders</a>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID COMMANDE</th>
                        <th>DATE</th>
                        <th>STATUT</th>
                        <th>TOTAL</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($commandes)): ?>
                    <tr>
                        <td colspan="5" class="no-orders">Aucune commande pour l'instant.</td>
                    </tr>
                <?php else: foreach ($commandes as $cmd): ?>
                    <tr>
                        <td><?php echo $cmd['idCommande']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($cmd['dateCmd'])); ?></td>
                        <td>
                            <?php
                                $statut = $cmd['statut'];
                                $class = 'badge-pending';
                                if ($statut === 'Livrée') $class = 'badge-delivered';
                                elseif ($statut === 'Expédiée') $class = 'badge-shipped';
                            ?>
                            <span class="badge <?php echo $class; ?>"><?php echo htmlspecialchars($statut); ?></span>
                        </td>
                        <td class="total"><?php echo number_format($cmd['total'], 2); ?>DH</td>
                        <td>
                            <a href="commande_detail.php?id=<?php echo $cmd['idCommande']; ?>" class="btn-details">Details</a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<footer>
    <p>&copy; 2026 Smartphone. All rights reserved.</p>
</footer>

</body>
</html>