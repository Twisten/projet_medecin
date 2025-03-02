<?php
session_start();

// Constante pour la clé de session utilisateur_authentifie
define('SESSION_USER_AUTHENTICATED', 'utilisateur_authentifie');

// Vérifier si l'utilisateur est déjà connecté, rediriger vers une page sécurisée si c'est le cas
if (isset($_SESSION[SESSION_USER_AUTHENTICATED]) && $_SESSION[SESSION_USER_AUTHENTICATED] === true) {
    header("Location: page/index.php");
    exit();
}

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_utilisateur = $_POST["nom_utilisateur"];
    $mot_de_passe = $_POST["mot_de_passe"];

    // Vérifier les informations d'authentification
    // Vous devrez récupérer le mot de passe hashé de la base de données et le comparer avec le mot de passe fourni par l'utilisateur
    $mot_de_passe_bdd = password_hash('motdepasse', PASSWORD_DEFAULT); // Remplacez 'votre_mot_de_passe' par le mot de passe hashé stocké dans la base de données

    if ($nom_utilisateur === 'admin' && password_verify($mot_de_passe, $mot_de_passe_bdd)) {
        // Authentification réussie, définir une variable de session pour indiquer que l'utilisateur est connecté
        $_SESSION[SESSION_USER_AUTHENTICATED] = true;

        // Rediriger vers la page sécurisée
        header("Location: page/index.php");
        exit();
    } else {
        // Authentification échouée, afficher un message d'erreur générique
        $erreur_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Authentification</title>
    <link rel="stylesheet" href="Css/login.css">
</head>
<body>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <h2>Connexion</h2>
        <label for="nom_utilisateur">Nom d'utilisateur:</label>
        <input type="text" name="nom_utilisateur" required><br>

        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" name="mot_de_passe" required><br>

        <input type="submit" value="Se Connecter">

        <?php
    // Afficher le message d'erreur s'il existe
    if (!empty($erreur_message)) {
        echo '<p style="color: red;">' . $erreur_message . '</p>';
    }
    ?>
    </form>

</body>
</html>
