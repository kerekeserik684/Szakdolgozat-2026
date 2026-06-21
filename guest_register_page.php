<?php

require_once "config.php";

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['register_guest'])) {
    $first_name = $_POST['guest_first_name'];
    $last_name = $_POST['guest_last_name'];
    $card_id = $_POST['guest_card_id'];

    $photo_name = time() . "_" . basename($_FILES['guest_photo']['name']);
    $target_path = "guest_photos/" . $photo_name;

    move_uploaded_file($_FILES['guest_photo']['tmp_name'], $target_path);
    $conn->query("INSERT INTO guests (guest_first_name, guest_last_name, guest_card_id, guest_photo) VALUES ('$first_name', '$last_name', '$card_id', '$photo_name')");

    header("Location: guests_page.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendégekfelvétele</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background: #fff;">

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
        <h1>Új vendég regisztrálása</h1>
<div class="top-section">

    <form method="POST" action="guest_register_page.php" enctype="multipart/form-data">

        <input type="text" name="guest_first_name" placeholder="Keresztnév" class="search-input" required>

        <input type="text" name="guest_last_name" placeholder="Vezetéknév" class="search-input" required>

        <input type="text" name="guest_card_id" placeholder="Kártya ID" class="search-input" required>

        <input type="file" name="guest_photo" accept="image/*" class="search-input" required>

        <button type="submit" name="register_guest" class="search-btn">
            Vendég regisztrálása
        </button>

    </form>

</div>


</body>
</html>