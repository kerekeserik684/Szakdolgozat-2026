<?php
session_start();
require_once "config.php";

// Ha nincs bejelentkezve → vissza a loginra
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Jelszócsere feldolgozása
if (isset($_POST['change_password'])) {

    $pass1 = $_POST['new_password'];
    $pass2 = $_POST['confirm_password'];

    // Ellenőrzés: egyeznek-e?
    if ($pass1 !== $pass2) {
        $error = "A két jelszó nem egyezik!";
    } else {
        // Hash + adatbázis frissítés
        $hashed = password_hash($pass1, PASSWORD_DEFAULT);
        $email = $_SESSION['email'];

        $conn->query("
            UPDATE users 
            SET password = '$hashed', first_log = 0
            WHERE email = '$email'
        ");

        // Siker → átirányítás a saját oldalára
        if ($_SESSION['role'] === 'admin') {
            header("Location: admin_page.php");
        } else {
            header("Location: user_page.php");
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Új jelszó beállítása</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="form-box active">

        <h2>Új jelszó beállítása</h2>

        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>

        <form method="POST">

            <input type="password" name="new_password" placeholder="Új jelszó" required>

            <input type="password" name="confirm_password" placeholder="Jelszó megerősítése" required>

            <button type="submit" name="change_password">Jelszó mentése</button>

        </form>

    </div>
</div>

</body>
</html>

