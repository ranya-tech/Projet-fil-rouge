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

    </footer>
</body>
</html>