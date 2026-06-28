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

// Szolgáltatás létrehozása
if (isset($_POST['create_service'])) {

    $name = $_POST['service_name'];
    $price = $_POST['service_price'];
    $days = $_POST['valid_days'];
    $entries = $_POST['max_entries'];

    // NULL kezelés
    if ($entries === "" || $entries === null) {
        $entries = "NULL";
    } else {
        $entries = "'$entries'";
    }

    $conn->query("
        INSERT INTO services (service_name, service_price, valid_days, max_entries)
        VALUES ('$name', '$price', '$days', $entries)
    ");

    $msg = "Szolgáltatás sikeresen létrehozva!";
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Szolgáltatás létrehozása</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page-wrapper">

    <div class="menu">
        <div class="menu-header">
            <div class="name"><?= $_SESSION['name'] ?></div>
            <img src="background/logout.png" class="logout-icon" onclick="window.location.href='logout.php'">
        </div>

        <button onclick="window.location.href='admin_page.php'"
            class="<?= basename($_SERVER['SCRIPT_NAME']) == 'admin_page.php' ? 'active' : '' ?>">
            <img src="background/home.png" class="menu-icon"> Főoldal
        </button>

        <h3>Vendégkezelés</h3>
        <button onclick="window.location.href='guests_page.php'"
            class="<?= basename($_SERVER['SCRIPT_NAME']) == 'guests_page.php' ? 'active' : '' ?>">
            <img src="background/guests.png" class="menu-icon"> Vendégek kezelése
        </button>

        <button onclick="window.location.href='guest_register_page.php'"
            class="<?= basename($_SERVER['SCRIPT_NAME']) == 'guest_register_page.php' ? 'active' : '' ?>">
            <img src="background/guest_add.png" class="menu-icon"> Új vendég felvétele
        </button>

        <h3>Személyzetkezelés</h3>
        <button onclick="window.location.href='user_register_page.php'"
            class="<?= basename($_SERVER['SCRIPT_NAME']) == 'user_register_page.php' ? 'active' : '' ?>">
            <img src="background/add-person.png" class="menu-icon"> Felhasználó felvétele
        </button>

        <h3>Szolgáltatáskezelés</h3>
        <button onclick="window.location.href='service_register_page.php'"
            class="<?= basename($_SERVER['SCRIPT_NAME']) == 'service_register_page.php' ? 'active' : '' ?>">
            <img src="background/service_add.png" class="menu-icon"> Szolgáltatás létrehozása
        </button>
            <h3>Készletkezelés</h3>
            <button onclick="window.location.href='product_management.php'"class="<?= basename($_SERVER['PHP_SELF']) == 'product_management.php' ? 'active' : '' ?>">
                <img src="background/whey.png" class="menu-icon">
            Termékkezelés</button>
            <button onclick="window.location.href='user_register_page.php'">Felhasználó felvétele</button>
            <button onclick="window.location.href='user_register_page.php'">Felhasználó felvétele</button>
            <button onclick="window.location.href='user_register_page.php'">Felhasználó felvétele</button>
            <button onclick="window.location.href='user_register_page.php'">Felhasználó felvétele</button>
            <button onclick="window.location.href='user_register_page.php'">Felhasználó felvétele</button>
    </div>

    <div class="main-content">

        <h1>Szolgáltatás létrehozása</h1>

        <div class="top-section">

            <?php if (isset($msg)) echo "<p>$msg</p>"; ?>

            <form method="POST">

                <label>Szolgáltatás neve:</label>
                <input type="text" name="service_name" required>

                <label>Ár (Ft):</label>
                <input type="number" name="service_price" required>

                <label>Érvényesség (nap):</label>
                <input type="number" name="valid_days" required>

                <label>Alkalmak száma (opcionális):</label>
                <input type="number" name="max_entries" placeholder="Hagyja üresen, ha nincs limit">

                <button type="submit" name="create_service" class="search-btn">
                    Szolgáltatás létrehozása
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>
