<?php
$db = new SQLite3('C:\Users\ASUS\Desktop\cryptobox\ssad\db.sqlite3');

if (!$db) {
    die("Erreur de connexion à la base de données");
}

$username = $_POST['username'];
$password = $_POST['password'];

// Utilisez une requête préparée pour des raisons de sécurité
$stmt = $db->prepare("SELECT auth_user.username, app_todouserprofile.password1 FROM auth_user
                     JOIN app_todouserprofile ON auth_user.id = app_todouserprofile.user_id
                     WHERE auth_user.username = :username");
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();

if ($result) {
    $row = $result->fetchArray(SQLITE3_ASSOC);

    if ($row && $row['username'] === $username && $row['password1'] === $password) {
        header("Location: home.html");
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
} else {
    echo "Erreur lors de l'exécution de la requête.";
}

$db->close();
?>
