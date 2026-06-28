<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$product = null;

/* ─────────────────────────────────────────────
   TERMÉK LEKÉRÉSE ANYAGSZÁM ALAPJÁN
────────────────────────────────────────────── */
if (isset($_GET['product_number'])) {
    $pn = $_GET['product_number'];

    $result = $conn->query("SELECT * FROM products WHERE product_number = '$pn'");
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
}

/* ─────────────────────────────────────────────
   TERMÉK ADATOK MENTÉSE
────────────────────────────────────────────── */
if (isset($_POST['save_product'])) {

    $id = $_POST['product_id'];
    $name = $_POST['name'];
    $qt = $_POST['quantity_type'];
    $storage = $_POST['storage'];
    $quantity = $_POST['quantity'];
    $price = $_POST['quantity_price'];
    $pn = $_POST['product_number'];
    $manufacturer = $_POST['manufacturer'];
    $indicator_set = $_POST['indicator_set'];
    $minimum_order_qty = $_POST['minimum_order_qty'];

    // HA LÉTEZIK A TERMÉK → UPDATE
    if ($id) {
        $conn->query("
            UPDATE products SET
                name = '$name',
                quantity_type = '$qt',
                storage = '$storage',
                quantity = '$quantity',
                quantity_price = '$price',
                product_number = '$pn',
                indicator_set = '$indicator_set',
                minimum_order_qty = '$minimum_order_qty',
                manufacturer = '$manufacturer'
            WHERE id = '$id'
        ");
        $msg_save = "Termék adatai frissítve!";
    }

    // HA NEM LÉTEZIK → INSERT
    else {
        $conn->query("
            INSERT INTO products (manufacturer ,name, quantity_type, storage, quantity, quantity_price, product_number, indicator_set, minimum_order_qty)
            VALUES ('$manufacturer', '$name', '$qt', '$storage', '$quantity', '$price', '$pn', $indicator_set, $minimum_order_qty)
        ");

        $msg_save = "Új termék sikeresen létrehozva!";
    }
}


/* ─────────────────────────────────────────────
   KÉP FELTÖLTÉSE
────────────────────────────────────────────── */
if (isset($_FILES['product_photo']) && $_FILES['product_photo']['error'] === 0) {

    $id = $_POST['product_id'];

    $filename = $id . "_" . time() . ".jpg";
    $target = "product_photos/" . $filename;

    move_uploaded_file($_FILES['product_photo']['tmp_name'], $target);

    $conn->query("
        UPDATE products
        SET product_photo = '$filename'
        WHERE id = '$id'
    ");

    $msg_save = "Kép sikeresen frissítve!";
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

        <h1>Termékkezelés</h1>
        
<div class="top-section">
    <form method="GET">
        <input type="text" name="product_number" placeholder="Anyagszám (pl. P00001)" class="search-input">
        <button type="submit" class="search-btn">Keresés</button>
    </form>
    <?php if (isset($msg_save)) echo "<p class='msg-success'>$msg_save</p>"; ?>
</div>

<!-- ALSÓ KÉTOSZLOPOS RÉSZ -->
<div class="bottom-section">

    <!-- BAL OLDAL: TERMÉK ADATOK -->
    <div class="left-panel">

                <div class="photo-name-row">
                    <?php if ($product): ?>
                        <img src="product_photos/<?= $product['product_photo'] ?? 'default.png' ?>" 
                            class="guest-photo"
                            onclick="document.getElementById('photoUpload').click();">
                    <?php endif; ?>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="file" id="photoUpload" name="product_photo" style="display:none;" onchange="this.form.submit();">
                </form>

        <form method="POST">
            <input type="hidden" name="product_id" value="<?= $product ? $product['id'] : '' ?>">

            <div class="output-field">
                <label>Gyártó</label>
                <input type="text" name="manufacturer" value="<?= $product ? $product['manufacturer'] : '' ?>">
            </div>

            <div class="output-field">
                <label>Jelzőkészlet</label>
                <input type="text" name="indicator_set" value="<?= $product ? $product['indicator_set'] : '' ?>">
            </div>

            <div class="output-field">
                <label>Minimum rendelési egység</label>
                <input type="text" name="minimum_order_qty" value="<?= $product ? $product['minimum_order_qty'] : '' ?>">
            </div>

            <div class="output-field">
                <label>Termék neve</label>
                <input type="text" name="name" value="<?= $product ? $product['name'] : '' ?>">
            </div>

            <div class="output-field">
                <label>Egység</label>
                <input type="text" name="quantity_type" value="<?= $product ? $product['quantity_type'] : '' ?>">
            </div>

            <div class="output-field">
                <label>Tárhely</label>
                <input type="text" name="storage" value="<?= $product ? $product['storage'] : '' ?>">
            </div>

            <div class="output-field">
                <label>Mennyiség</label>
                <input type="number" name="quantity" value="<?= $product ? $product['quantity'] : '' ?>">
            </div>

            <div class="output-field">
                <label>Egységár</label>
                <input type="number" name="quantity_price" value="<?= $product ? $product['quantity_price'] : '' ?>">
            </div>

            <div class="output-field">
                <label>Anyagszám</label>
                <input type="text" name="product_number" value="<?= $product ? $product['product_number'] : '' ?>">
            </div>

            <button type="submit" name="save_product" class="search-btn">
                Mentés
            </button>
        </form>

    </div>


    <!-- JOBB OLDAL: TERMÉK FOGYÁSA -->
    <div class="right-panel">
        <h3>Termék fogyása</h3>
        <p>Még nincs funkció hozzáadva.</p>
    </div>

</div>

</body>
</html>
