<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="">
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
                    echo "<a href='profil.php' class='profil'>" .$user['name'] . "</a>";
                }else{
                    echo "<a href='login.php' class='profil'>Connecter</a>";
                }
            ?>
        </nav>
    </header>
    <main>
        <a href="category.html">Retour</a>
        
    </main>
    <footer>
        <div class="footer-container">
            <img src="asset/Logo.png" alt="Smartphone">
            <a href="">Accueil</a>
            <a href="">Categories</a>
            <a href="">Connexion</a>
            <img src="asset/facebook.png" alt="Facebook" width="40">
            <img src="asset/insta.png" alt="Instagram" width="40">
            <img src="asset/twiter.png" alt="Twitter" width="40">
        </div>
        <p>&copy; 2026 Smartphone. All rights reserved.</p>
    </footer>
</body>
</html>