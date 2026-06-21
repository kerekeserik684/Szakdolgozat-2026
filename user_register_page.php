<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Csak admin léphet be
if ($_SESSION['role'] !== 'admin') {
    header("Location: user_page.php");
    exit();
}

// Felhasználó létrehozása
if (isset($_POST['create_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $temp_password = $_POST['temp_password'];

    $hashed = password_hash($temp_password, PASSWORD_DEFAULT);

    $check = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $msg = "Ez az email már létezik!";
    } else {
        $conn->query("
            INSERT INTO users (name, email, password, role, first_log)
            VALUES ('$name', '$email', '$hashed', '$role', 1)
        ");
        $msg = "Felhasználó sikeresen létrehozva!";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Felhasználó hozzáadása</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page-wrapper">

    <div class="menu">
        <div class="menu-header">
            <div class="name"><?= $_SESSION['name'] ?></div>
            <img src="background/logout.png" class="logout-icon" onclick="window.location.href='logout.php'">
        </div>
            <button onclick="window.location.href='admin_page.php'"class="<?= basename($_SERVER['PHP_SELF']) == 'admin_page.php' ? 'active' : '' ?>">
            <img src="background/home.png" class="menu-icon">
            Főoldal</button>
            <h3>Vendégkezelés</h3>
            <button 
                onclick="window.location.href='guests_page.php'" 
                class="<?= basename($_SERVER['PHP_SELF']) == 'guests_page.php' ? 'active' : '' ?>"><img src="background/guests.png" class="menu-icon"> Vendégek kezelése
            </button>
            <button onclick="window.location.href='guest_register_page.php'"class="<?= basename($_SERVER['PHP_SELF']) == 'guest_register_page.php' ? 'active' : '' ?>">
                <img src="background/guest_add.png" class="menu-icon">
            Új vendég felvétele</button>
            <h3>Személyzetkezelés</h3>
            <button onclick="window.location.href='user_register_page.php'"class="<?= basename($_SERVER['PHP_SELF']) == 'user_register_page.php' ? 'active' : '' ?>">
                <img src="background/add-person.png" class="menu-icon">
            Felhasználó felvétele</button>
            <h3>Szolgáltatáskezelés</h3>
            <button onclick="window.location.href='service_register_page.php'"class="<?= basename($_SERVER['PHP_SELF']) == 'service_register_page.php' ? 'active' : '' ?>">
                <img src="background/service_add.png" class="menu-icon">
            Szolgáltatás létrehozása</button>
            <button onclick="window.location.href='user_register_page.php'">Felhasználó felvétele</button>
            <button onclick="window.location.href='user_register_page.php'">Felhasználó felvétele</button>
            <button onclick="window.location.href='user_register_page.php'">Felhasználó felvétele</button>
            <button onclick="window.location.href='user_register_page.php'">Felhasználó felvétele</button>
            <button onclick="window.location.href='user_register_page.php'">Felhasználó felvétele</button>
            <button onclick="window.location.href='user_register_page.php'">Felhasználó felvétele</button>
    </div>

    <div class="main-content">

        <h1>Felhasználó felvétele</h1>
        
<div class="top-section">

    <?php if (isset($msg)) echo "<p>$msg</p>"; ?>

    <form method="POST">

        <label>Név:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Szerepkör:</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="user">Recepciós</option>
        </select>

        <label>Ideiglenes jelszó:</label>
        <input type="text" name="temp_password" placeholder="123" required>

        <button type="submit" name="create_user" class="search-btn">Felhasználó létrehozása</button>

    </form>

</div>

</body>
</html>
