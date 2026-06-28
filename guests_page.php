<?php

require_once 'config.php';

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$guest = null;
$key = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = $conn->query("SELECT * FROM guests WHERE guest_card_id = '$id'");

    if ($result->num_rows > 0) {
        $guest = $result->fetch_assoc();
    }
    $keyResult = $conn->query("SELECT * FROM keys_ WHERE guest_card_id = '$id' AND returned_at IS NULL");

    if ($keyResult->num_rows > 0) {
        $key = $keyResult->fetch_assoc();
    }
    if (isset($_POST['remove_key']) && $guest) {

        // A vendég kártyaszáma (keys_ táblához)
        $guest_card_id = $guest['guest_card_id'];

        // Kulcs visszavétele
        $conn->query("
            UPDATE keys_
            SET returned_at = NOW()
            WHERE guest_card_id = '$guest_card_id'
            AND returned_at IS NULL
        ");

        $msg_return = "Kulcs sikeresen visszavéve!";
        $key = null;
        

        // Friss kulcsadatok lekérése
        $keyResult = $conn->query("
            SELECT *
            FROM keys_
            WHERE guest_card_id = '$guest_card_id'
            ORDER BY keys_id DESC
            LIMIT 1
        ");

        if ($keyResult->num_rows > 0) {
            $key = $keyResult->fetch_assoc();
        } else {
            $key = null; // nincs aktív kulcs
        }
    }


if (isset($_POST['add_key'])) {

    // A vendég valódi ID-je (service_guest táblához)
    $guest_id = $guest['guest_id'];

    // A vendég kártyaszáma (keys_ táblához)
    $guest_card_id = $guest['guest_card_id'];

    $key_code = strtoupper($_POST['key_number'] ?? '');

        // AKTÍV SZOLGÁLTATÁS LEKÉRÉSE
    $today = date('Y-m-d');
    $active_service = $conn->query("
        SELECT *
        FROM service_guest
        WHERE guest_id = '$guest_id'
          AND start_date <= '$today'
          AND end_date >= '$today'
        ORDER BY id DESC
        LIMIT 1
    ")->fetch_assoc();

    // Ellenőrzés: van-e már kulcsa?
    $check = $conn->query("SELECT * FROM keys_ WHERE guest_card_id = '$guest_card_id' AND returned_at IS NULL");

    if ($check->num_rows > 0) {
        $msg_already = "Ennek a vendégnek már van kiadott kulcsa!";
    }
    else {

        // KULCS HOZZÁADÁSA – helyes guest_card_id-vel
        $conn->query("INSERT INTO keys_ (guest_card_id, key_number) VALUES ('$guest_card_id', '$key_code')");
            $conn->query("
            UPDATE keys_
            SET issued_at = NOW()
            WHERE guest_card_id = '$guest_card_id'
        ");
        $msg_add = "Kulcs sikeresen hozzáadva!";

        $keyResult = $conn->query("SELECT * FROM keys_ WHERE guest_card_id = '$guest_card_id' AND returned_at IS NULL");
        if ($keyResult->num_rows > 0) {
            $key = $keyResult->fetch_assoc();
        }
    }

    // ALKALOM LEVONÁSA
    if ($active_service && $active_service['service_entries'] > 0) {

        $new_entries = $active_service['service_entries'] - 1;

        $conn->query("
            UPDATE service_guest
            SET service_entries = '$new_entries'
            WHERE id = '{$active_service['id']}'
        ");
    }
}




}

if (isset($_POST['save_guest'])) {

    $id = $_POST['id'];

    $first = $_POST['guest_first_name'];
    $last = $_POST['guest_last_name'];
    $residence = $_POST['guest_residence'];
    $birth = $_POST['guest_birth_date'];
    $sex = $_POST['guest_sex'];
    $email = $_POST['guest_email'];
    $phone = $_POST['guest_phone'];
    $card = $_POST['guest_card_id'];

    $conn->query("
        UPDATE guests SET
            guest_first_name = '$first',
            guest_last_name = '$last',
            guest_residence = '$residence',
            guest_birth_date = '$birth',
            guest_sex = '$sex',
            guest_email = '$email',
            guest_phone = '$phone',
            guest_card_id = '$card'
        WHERE guest_card_id = '$id'
    ");

    $msg_save = "Adatok sikeresen frissítve!";
}

$services = $conn->query("SELECT service_id, service_name, service_price FROM services ORDER BY service_name ASC");

if (isset($_POST['assign_service'])) {

    $guest_id = $_POST['guest_id'];
    $service_id = $_POST['service_id'];
    $start = $_POST['start_date'];

    // Lekérjük a szolgáltatás adatait
    $service = $conn->query("
        SELECT valid_days, max_entries, service_price
        FROM services 
        WHERE service_id = '$service_id'
    ")->fetch_assoc();

    // Automatikus lejárat
    $end = date('Y-m-d', strtotime($start . " + {$service['valid_days']} days"));

    // Alkalmas bérlet esetén
    $entries = $service['valid_days'];   // <<< EZ LESZ A FELHASZNÁLHATÓ ALKALMAK SZÁMA

    // Mentés a kapcsolótáblába
    $conn->query("
        INSERT INTO service_guest (guest_id, service_id, start_date, end_date, service_entries)
        VALUES ('$guest_id', '$service_id', '$start', '$end', '$entries')
    ");

    $msg_service = "Szolgáltatás sikeresen hozzárendelve!";
}

if ($guest) {

    $guest_id = $guest['guest_id'];
    $today = date('Y-m-d');

    $active_service = $conn->query("
        SELECT gs.*, s.service_name, s.service_price, s.max_entries
        FROM service_guest gs
        JOIN services s ON gs.service_id = s.service_id
        WHERE gs.guest_id = '$guest_id'
          AND gs.start_date <= '$today'
          AND gs.end_date >= '$today'
        ORDER BY gs.id DESC
        LIMIT 1
    ")->fetch_assoc();

    if ($active_service) {

        if ($active_service['service_entries'] !== null && $active_service['service_entries'] < 1) {
            $msg_service_error = "A szolgáltatás lejárt (nincs több felhasználható alkalom).";
        } else {
            $msg_service = "Van érvényes szolgáltatása ma: " .
                           $active_service['service_name'] .
                           " (" . $active_service['service_price'] . " Ft)";
        }

    } else {
        $msg_service_error = "Nincs érvényes szolgáltatása a mai napra.";
    }
}

if (isset($_FILES['guest_photo']) && $_FILES['guest_photo']['error'] === 0) {

    $guest_id = $_POST['guest_id'];

    $filename = $guest_id . "_" . time() . ".jpg";
    $target = "guest_photos/" . $filename;

    move_uploaded_file($_FILES['guest_photo']['tmp_name'], $target);

    $conn->query("
        UPDATE guests
        SET guest_photo = '$filename'
        WHERE guest_id = '$guest_id'
    ");

    $msg_save = "Fotó sikeresen frissítve!";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendégek kezelése</title>
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

        <h1>Vendégek kezelése</h1>

<div class="top-section">

    <!-- Vendég ID mező + keresés egy formban -->
    <form method="GET" class="id-box">
        <input type="text" name="id" placeholder="Vendég ID..." class="search-input" value="<?= $_GET['id'] ?? '' ?>">
        <button type="submit" class="search-btn">Keresés</button>
    </form>

    <!-- Kulcs hozzáadása + visszavétele gombok egymás mellett -->
    <div class="key-buttons">

        <form method="POST">
            <!-- Ez a kártyaszám, amit GET-ből kaptál -->
            <input type="hidden" name="guest_card_id" value="<?= $_GET['id'] ?? '' ?>">

            <!-- Ez a vendég adatbázis ID-je -->
            <input type="hidden" name="guest_id" value="<?= $guest['guest_id'] ?>">

            <input type="text" name="key_number" placeholder="Kulcs kódja (pl. K001)" class="search-input">
            <button type="submit" name="add_key" class="search-btn">Kulcs hozzáadása</button>
        </form>


        <form method="POST">
            <button type="submit" name="remove_key" class="search-btn">Kulcs visszavétele</button>
        </form>


    </div>
    <!-- Üzenetek -->
    <?php if (isset($msg_already)) echo "<p class='msg-error'>$msg_already</p>"; ?>
    <?php if (isset($msg_add)) echo "<p class='msg-success'>$msg_add</p>"; ?>
    <?php if (isset($msg_return)) echo "<p class='msg-success'>$msg_return</p>"; ?>
    <?php if (isset($msg_save)) echo "<p class='msg-success'>$msg_save</p>"; ?>
    <?php if (isset($msg_service)) echo "<p class='msg-success'>$msg_service</p>"; ?>
    <?php if (isset($msg_service_error)) echo "<p class='msg-error'>$msg_service_error</p>"; ?>


</div>



        <!-- ALSÓ KÉTOSZLOPOS RÉSZ -->
        <div class="bottom-section">

            <!-- BAL OLDAL: VENDÉG ADATOK -->
            <div class="left-panel">

                <div class="photo-name-row">
                    <?php if ($guest): ?>
                        <img src="guest_photos/<?= $guest['guest_photo'] ?? 'default.png' ?>" 
                            class="guest-photo"
                            onclick="document.getElementById('photoUpload').click();">
                    <?php endif; ?>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="guest_id" value="<?= $guest['guest_id'] ?>">
                    <input type="file" id="photoUpload" name="guest_photo" style="display:none;" onchange="this.form.submit();">
                </form>


                <h4>Személyes adatok</h4>

                <form method="POST">

                    <input type="hidden" name="id" value="<?= $guest['guest_card_id'] ?>">

                    <div class="output-field">
                        <label>Keresztnév</label>
                        <input type="text" name="guest_first_name" 
                            value="<?= $guest ? $guest['guest_first_name'] : '' ?>">
                    </div>

                    <div class="output-field">
                        <label>Vezetéknév</label>
                        <input type="text" name="guest_last_name" 
                            value="<?= $guest ? $guest['guest_last_name'] : '' ?>">
                    </div>

                    <div class="output-field">
                        <label>Lakcím</label>
                        <input type="text" name="guest_residence" 
                            value="<?= $guest ? $guest['guest_residence'] : '' ?>">
                    </div>

                    <div class="output-field">
                        <label>Születési dátum</label>
                        <input type="date" name="guest_birth_date" 
                            value="<?= $guest ? $guest['guest_birth_date'] : '' ?>">
                    </div>

                    <div class="output-field">
                        <label>Nem</label>
                        <input type="text" name="guest_sex" 
                            value="<?= $guest ? $guest['guest_sex'] : '' ?>">
                    </div>
                    <h4>Elérhetőségek</h4>
                    <div class="output-field">
                        <label>E-mail</label>
                        <input type="email" name="guest_email" 
                            value="<?= $guest ? $guest['guest_email'] : '' ?>">
                    </div>

                    <div class="output-field">
                        <label>Telefonszám</label>
                        <input type="text" name="guest_phone" 
                            value="<?= $guest ? $guest['guest_phone'] : '' ?>">
                    </div>

                    <h4>Tagsági adatok</h4>
                    <div class="output-field">
                        <label>Kártya ID</label>
                        <input type="text" name="guest_card_id" 
                            value="<?= $guest ? $guest['guest_card_id'] : '' ?>">
                    </div>

                    <div class="output-field">
                        <label>Regisztráció ideje</label>
                        <span><?= $guest ? $guest['guest_register_time'] : '' ?></span>
                    </div>

                    <button type="submit" name="save_guest" class="search-btn">
                        Módosítások mentése
                    </button>

                </form>


            </div>

            <!-- JOBB OLDAL: SZOLGÁLTATÁSOK -->
            <div class="right-panel">
                <div class="right-panel-top">
                    <h4>Szolgáltatások</h4>
                    <form method="POST">

                        <input type="hidden" name="guest_id" value="<?= $guest['guest_id'] ?>">

                        <div class="output-field">
                            <label>Szolgáltatás kiválasztása</label>
                            <select name="service_id">
                                <?php while ($row = $services->fetch_assoc()): ?>
                                    <option value="<?= $row['service_id'] ?>">
                                        <?= $row['service_name'] ?> (<?= $row['service_price'] ?> Ft)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="output-field">
                            <label>Kezdés dátuma</label>
                            <input type="date" name="start_date">
                        </div>

                        <button type="submit" name="assign_service" class="search-btn">
                            Szolgáltatás hozzárendelése
                        </button>

                    </form>

                </div>
                <div class="right-panel-bottom">
                    <h4>Kiadott kulcsadatok</h4>
                    <div class="output-field">
                        <label>Aktív kulcs</label>
                        <span><?= $key ? $key['key_number'] : 'Nincs kiadott kulcs' ?></span>
                    </div>

                    <div class="output-field">
                        <label>Kiadás ideje</label>
                        <span><?= $key ? $key['issued_at'] : '-' ?></span>
                    </div>

                    <div class="output-field">
                        <label>Visszavétel ideje</label>
                        <span><?= $key && $key['returned_at'] ? $key['returned_at'] : '-' ?></span>
                    </div>
                </div> 

            </div>

        </div>

    </div>



</body>
</html>