<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

require_once "config.php";

$todayKeyCount = $conn->query("
    SELECT COUNT(*) AS c
    FROM keys_
    where DATE(issued_at) = CURDATE()
")->fetch_assoc()['c'];

$stockValue = $conn->query("
    SELECT SUM(order_price / minimum_order_qty * quantity) AS total
    FROM products
")->fetch_assoc()['total'];

$newGuests7Days = $conn->query("
    SELECT COUNT(*) AS c
    FROM guests
    WHERE guest_register_time >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
")->fetch_assoc()['c'];

$peak = $conn->query("
    SELECT 
        HOUR(issued_at) AS hour,
        COUNT(*) AS count
    FROM keys_
    GROUP BY HOUR(issued_at)
    ORDER BY count DESC
    LIMIT 1
")->fetch_assoc();

$peakHour = $peak['hour'];
$peakCount = $peak['count'];

$topProducts = $conn->query("
    SELECT 
        p.name,
        SUM(pg.quantity / p.scoop_volume) AS total_scoops
    FROM product_guest pg
    JOIN products p ON pg.product_id = p.id
    WHERE pg.reason = 'fogyás'
    GROUP BY pg.product_id
    ORDER BY total_scoops DESC
    LIMIT 3
");

// Lekérdezzük azokat a termékeket, amelyek készlete alacsonyabb, mint a jelzőkészlet és még nincs beérkezett rendelésük
$toOrder = $conn->query("
    SELECT p.product_number, p.name, p.quantity, p.indicator_set, p.quantity_price, p.minimum_order_qty, p.order_price
    FROM products p
    WHERE p.quantity < p.indicator_set
      AND NOT EXISTS (SELECT 1
          FROM orders o
          WHERE o.product_id = p.product_number
            AND o.status = 'Rendelve'
      )
");
if (isset($_POST['order_submit'])) {
    foreach ($_POST['multiplier'] as $product_number => $multiplier){if ($multiplier == 0) continue;
        $p = $conn->query("
            SELECT minimum_order_qty 
            FROM products 
            WHERE product_number = '$product_number'
        ")->fetch_assoc();
        $ordered_amount = $p['minimum_order_qty'] * $multiplier;
        $conn->query("
            INSERT INTO orders (product_id, multiplier, status)
            VALUES ('$product_number', $multiplier, 'Rendelve')");}
    $_SESSION['msg_save'] = "Adatok sikeresen frissítve!";
    header("Location: admin_page.php");
    exit();
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kezdőlap</title>
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
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <h3>Személyzetkezelés</h3>
                <button onclick="window.location.href='user_register_page.php'"
                        class="<?= basename($_SERVER['PHP_SELF']) == 'user_register_page.php' ? 'active' : '' ?>">
                    <img src="background/add-person.png" class="menu-icon">
                    Felhasználó felvétele
                </button>
                <h3>Szolgáltatáskezelés</h3>
                <button onclick="window.location.href='service_register_page.php'"class="<?= basename($_SERVER['PHP_SELF']) == 'service_register_page.php' ? 'active' : '' ?>">
                <img src="background/service_add.png" class="menu-icon">
            Szolgáltatás létrehozása</button>
            <?php endif; ?>
            <h3>Készletkezelés</h3>
            <button onclick="window.location.href='product_management.php'"class="<?= basename($_SERVER['PHP_SELF']) == 'product_management.php' ? 'active' : '' ?>">
                <img src="background/whey.png" class="menu-icon">
            Termékkezelés</button>

    </div>


    <div class="main-content">
        <h1>Üdv újra itt!</h1>
        <div class="kpi-container">
            <div class="kpi-card">
                <h4>Napi kulcskiadások</h4>
                <p><?= $todayKeyCount ?></p>
            </div>
            <div class="kpi-card">
                <h4>Készletérték</h4>
                <p><?= number_format($stockValue, 0, ',', ' ') ?> Ft</p>
            </div>
            <div class="kpi-card">
                <h4>Új vendégek az elmúlt 7 napban</h4>
                <p><?= $newGuests7Days ?></p>
            </div>
            <div class="kpi-card">
                <h4>Csúcsidőszak</h4>
                <p><?= $peakHour ?>:00 - <?= $peakHour + 1 % 24 % 12 ?>:00 (<?= $peakCount ?> kulcskiadás)</p>
            </div>
            <div class="kpi-card">
                <h4>Legnépszerűbb termékek</h4>
                <ol>
                    <?php while ($product = $topProducts->fetch_assoc()): ?>
                        <li><?= $product['name'] ?> (<?= round($product['total_scoops']) ?> Db)</li>
                    <?php endwhile; ?>
                </ol>
            </div>
            <div class="kpi-card">
                <h4>Jelzőkészlet alatti termékek</h4>

                <form method="POST" action="admin_page.php">
                    <table class="order-table">
                        <tr>
                            <th>Anyagszám</th>
                            <th>Név</th>
                            <th>Készlet</th>
                            <th>Jelzőkészlet</th>
                            <th>Egységár</th>
                            <th>Rendelés</th>
                        </tr>

                        <?php while ($p = $toOrder->fetch_assoc()): ?>
                            <tr>
                                <td><?= $p['product_number'] ?></td>
                                <td><?= $p['name'] ?></td>
                                <td><?= $p['quantity'] ?></td>
                                <td><?= $p['indicator_set'] ?></td>
                                <td><?= $p['order_price'] ?> Ft</td>

                                <td>
                                    <select name="multiplier[<?= $p['product_number'] ?>]">
                                        <option value="0">0×</option>
                                        <option value="1">1×</option>
                                        <option value="2">2×</option>
                                        <option value="3">3×</option>
                                        <option value="4">4×</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                    <button type="submit" name="order_submit">Rendelés rögzítése</button>
                </form>
            </div>
    </div>

</div>

</body>
<html>