<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$idClient = $user['id'];

// personelle information update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profil'])) {
    $nom       = trim($_POST['nom_complet']);
    $email     = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);

    $stmt = $pdo->prepare("UPDATE Client SET nom_complet = :nom, email = :email, telephone = :telephone WHERE idClient = :id");
    $stmt->execute([
        'nom'       => $nom,
        'email'     => $email,
        'telephone' => $telephone,
        'id'        => $idClient
    ]);

    // Update session
    $_SESSION['user']['name']  = $nom;
    $_SESSION['user']['email'] = $email;

    $success = "Profil mis à jour avec succès.";
}

// Fetch latest client info
$stmt = $pdo->prepare("SELECT * FROM Client WHERE idClient = :id");
$stmt->execute(['id' => $idClient]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch last delivery address
$stmtAddr = $pdo->prepare("
    SELECT l.adresse FROM Livraison l
    JOIN Commande c ON c.idCommande = l.idCommande
    WHERE c.idClient = :id
    ORDER BY c.dateCmd DESC LIMIT 1
");
$stmtAddr->execute(['id' => $idClient]);
$lastAddr = $stmtAddr->fetchColumn();

// Fetch order history
$stmt = $pdo->prepare("
    SELECT c.idCommande, c.dateCmd, c.statut,
           SUM(p.prix * pc.quantite) AS total
    FROM Commande c
    JOIN ProduitCmd pc ON pc.idCommande = c.idCommande
    JOIN Phones p ON p.idPhone = pc.idPhones
    WHERE c.idClient = :id
    GROUP BY c.idCommande, c.dateCmd, c.statut
    ORDER BY c.dateCmd DESC
");
$stmt->execute(['id' => $idClient]);
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="../CSS/style_profil.css">
</head>
<body>

<header>
    <div class="header-logo">
        <img src="../asset/Logo.png" alt="Smartphone">
    </div>
    <nav>
        <a href="Accueil.php">Accueil</a>
        <a href="category.php">Categorie</a>
        <a href="panier.php"><img src="../asset/panier.png" alt="Panier" width="16">Panier</a>
        <a href="logout.php" class="btn-deconnexion">Déconnexion</a>
    </nav>
</header>

<main>

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-avatar">
            <img src="../asset/avatar.png" alt="Avatar">
        </div>
        <div class="profile-name">
            <h2><?= htmlspecialchars($client['nom_complet']) ?></h2>
        </div>
        <?php
            if($client['role'] == 'admin'){
                echo "<a href='../admin/admin.php'> Dasboard</a>";
            }
        ?>
    </div>

    <?php if (isset($success)): ?>
        <div class="alert-success"><?= $success ?></div>
    <?php endif; ?>

    <!-- Personal Info -->
    <div class="info-card">
        <div class="info-card-header">
            <h3>Informations Personnelles</h3>
            <button class="edit-btn" id="toggleBtn" onclick="toggleEdit()"> Edit All</button>
        </div>

        <!-- VIEW MODE -->
        <div id="view-mode">
            <div class="info-grid">
                <div class="info-field">
                    <label>NOM COMPLET</label>
                    <div class="info-value"><?= htmlspecialchars($client['nom_complet']) ?></div>
                </div>
                <div class="info-field">
                    <label>EMAIL</label>
                    <div class="info-value"><?= htmlspecialchars($client['email']) ?></div>
                </div>
                <div class="info-field">
                    <label>TÉLÉPHONE</label>
                    <div class="info-value"><?= htmlspecialchars($client['telephone']) ?></div>
                </div>
                <div class="info-field">
                    <label>ADDRESS</label>
                    <div class="info-value"><?= htmlspecialchars($lastAddr ?: '—') ?></div>
                </div>
            </div>
        </div>

        <!-- EDIT MODE -->
        <div id="edit-mode" style="display:none;">
            <form method="post">
                <div class="info-grid">
                    <div class="info-field">
                        <label>NOM COMPLET</label>
                        <input type="text" name="nom_complet" class="info-input"
                               value="<?= htmlspecialchars($client['nom_complet']) ?>">
                    </div>
                    <div class="info-field">
                        <label>EMAIL</label>
                        <input type="email" name="email" class="info-input"
                               value="<?= htmlspecialchars($client['email']) ?>">
                    </div>
                    <div class="info-field">
                        <label>TÉLÉPHONE</label>
                        <input type="tel" name="telephone" class="info-input"
                               value="<?= htmlspecialchars($client['telephone']) ?>">
                    </div>
                    <div class="info-field">
                        <label>ADDRESS</label>
                        <div class="info-value" style="color:#9ca3af; font-size:12px;">
                            Modifiable via une nouvelle commande
                        </div>
                    </div>
                </div>
                <div class="edit-actions">
                    <button type="button" class="btn-cancel" onclick="toggleEdit()">Annuler</button>
                    <button type="submit" name="update_profil" class="btn-save"> Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Order History -->
    <div class="orders-card">
        <div class="orders-card-header">
            <h3>Historique des commandes</h3>
        </div>
        <table class="orders-table">
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
                    <td colspan="5" style="text-align:center; color:#9ca3af; padding:20px;">
                        Aucune commande trouvée.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($commandes as $cmd): ?>
                <tr>
                    <td><?= $cmd['idCommande'] ?></td>
                    <td><?= date('M d, Y', strtotime($cmd['dateCmd'])) ?></td>
                    <td>
                        <?php
                            $statut = $cmd['statut'];
                            $class = match($statut) {
                                'Livrée'   => 'badge-livree',
                                'Expédiée' => 'badge-expediee',
                                default    => 'badge-attente'
                            };
                        ?>
                        <span class="badge <?= $class ?>"><?= $statut ?></span>
                    </td>
                    <td><?= number_format($cmd['total'], 2, '.', ',') ?>DH</td>
                    <td>
                        <a href="confirm.php?commande=<?= $cmd['idCommande'] ?>" class="details-btn">Détails</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</main>

<footer>
    <p>&copy; 2026 Smartphone. All rights reserved.</p>
</footer>

<script>
    function toggleEdit() {
        const viewMode = document.getElementById('view-mode');
        const editMode = document.getElementById('edit-mode');
        const btn      = document.getElementById('toggleBtn');

        if (editMode.style.display === 'none') {
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
            btn.textContent = '✕ Annuler';
        } else {
            viewMode.style.display = 'block';
            editMode.style.display = 'none';
            btn.textContent = ' Edit All';
        }
    }

    // If update was successful, stay in view mode
    <?php if (isset($success)): ?>
        document.getElementById('view-mode').style.display = 'block';
        document.getElementById('edit-mode').style.display = 'none';
    <?php endif; ?>
</script>

</body>
</html>