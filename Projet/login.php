<?php
session_start();
require 'config.php';
//A variable 
$current_view = 'login';
//an array to stock the erreurs
$error = [];
//an array to store success messages from signup
$success = "";
// Handle view switching between Login and Signup forms via POST buttons
if (isset($_POST['view_signup'])) {
    $current_view = 'signup';
} elseif (isset($_POST['view_login'])) {
    $current_view = 'login';
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // LOGIN LOGIC 
    if(isset($_POST['action_login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        if(empty($email) || empty($password)){
            $error[] = "Tous les champs sont obligatoire.";
        }else{
            //searching the user
            $sql = "SELECT * FROM client WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'email' => $email
            ]);
            $user = $stmt->fetchAll(PDO :: FETCH_ASSOC);
            if($user){
                foreach($user as $u){
                    if($u['mot_de_passe'] !== $password){
                        $error[] = "Password incorrect!!";
                    }else{
                        // Successful login: set session data
                        $_SESSION['user'] =[
                            'id' => $u['idClient'],
                            'name' => $u['nom_complet'],
                            'email' => $u['email']
                        ];
                        // Redirect to previous page or default catalog page
                        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)) !== 'login.php') {
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                        } else {
                            header('Location: category.php');
                        }
                        exit;
                    }
                }
            }else{
                $error[] = "Email introuvable";
            }
        }
    }
    if (isset($_POST['action_signup'])){
        // SIGNUP LOGIC 
        // Keep view as signup if validation fails
        $current_view = 'signup';
        $name = $_POST['nom_complet'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if(empty($name) || empty($telephone) || empty($email) || empty($password)){
            $error[] = "Tous les champs sont obligatoire.";
        }else{
            // Password complexity rules
            if(strlen($password)<8){
                $error[] = "Password doit contient 8 caractéres.";
            }
            if(!preg_match("/[0-9]/",$password)){
                $error[] = "Password doit contient au moins un chiffre.";
            }
            if(!preg_match("/[A-Z]/",$password)){
                $error[] = "Password doit contient au moins une majuscule.";
            }
            // If no errors, insert into database
            if(empty($error)){
                $sql = "INSERT INTO client(nom_complet, telephone, email, mot_de_passe) VALUES(:nom_complet, :telephone, :email, :mot_de_passe)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'nom_complet' => $name,
                    'telephone' => $telephone,
                    'email' => $email,
                    'mot_de_passe' => $password
                ]);
                $current_view = 'login';
                $success = "Inscription réussie ! Connectez-vous.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/style_log.css">
</head>
<body>
<header>
        <img src="asset/Logo.png" alt="Logo">
        <nav>
            <a href="Accueil.php">Accueil</a>
            <a href="category.php">Categorie</a>
            <a href="panier.php"><img src="asset/panier.png" alt="Panier" width="14">Panier</a>
        </nav>
    </header>
    <main>
        <?php if(!empty($success)){ ?>
            <p style="color:green; text-align:center; font-weight:bold; margin-bottom:15px;"><?php echo $success; ?></p>
        <?php } ?>
        <?php if(!empty($error)){ ?>
            <div style="text-align: center; margin-bottom: 15px;">
                <?php foreach($error as $er){ ?>
                    <p style="color:red; margin: 5px 0; font-weight: bold;"><?php echo $er; ?></p>
                <?php }; ?>
            </div>
        <?php } ?>
        <form method="post">
        <button type="submit" name="view_login" class="tab-btn <?php echo $current_view === 'login' ? 'active-tab' : 'inactive-tab'; ?>">Connexion</button>
        <button type="submit" name="view_signup" class="tab-btn <?php echo $current_view === 'signup' ? 'active-tab' : 'inactive-tab'; ?>">S'inscrire</button>            
        <?php if($current_view === 'login'){ ?>
                <label for="">Email</label>
                <input type="email" name="email" placeholder="nom@exemple.com">
                <label for="">Mot de passe</label>
                <input type="password" name="password" placeholder="*********">
                <button class="connecter" name="action_login">Se connecter</button>
        <?php }else{ ?>
                <label>Nom complet</label>
                <input type="text" name="nom_complet" placeholder="Ahmed Ahmed">

                <label>Téléphone</label>
                <input type="tel" name="telephone" placeholder="0674414346">

                <label>Email</label>
                <input type="email" name="email" placeholder="nom@exemple.com">
                
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="*********">
                <button class="connecter" name="action_signup">S'inscrire</button>
        <?php } ?>  
        </form> 
    </main>
    <footer>
        <p>&copy; 2026 Smartphone. All rights reserved.</p>
    </footer>
</body>
</html>