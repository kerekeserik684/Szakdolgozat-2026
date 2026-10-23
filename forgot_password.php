
<?php
session_start();
require_once "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/vendor/autoload.php";

$error = "";
$message = "";

// Az aktuális visszaállítási folyamat e-mail-címe
$email = $_SESSION["reset_email"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. Hatjegyű kód küldése
    if (isset($_POST["send_code"])) {

        $email = trim($_POST["email"] ?? "");

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Adj meg egy érvényes e-mail-címet!";
        } else {
            // Akkor is általános üzenetet adunk, ha nincs ilyen fiók.
            $message = "";

            $stmt = $conn->prepare(
                "SELECT email FROM users WHERE email = ?"
            );
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $userExists = $result->num_rows > 0;
            $stmt->close();

            if ($userExists) {
                // Hatjegyű, véletlenszerű kód
                $code = (string) random_int(100000, 999999);
                $codeHash = password_hash($code, PASSWORD_DEFAULT);

                // A korábbi kód helyett új kód kerül az adatbázisba.
                $stmt = $conn->prepare(
                    "INSERT INTO password_reset
                        (email, hash, expires_at, attempts)
                     VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 10 MINUTE), 0)
                     ON DUPLICATE KEY UPDATE
                        hash = VALUES(hash),
                        expires_at = VALUES(expires_at),
                        attempts = 0"
                );
                $stmt->bind_param("ss", $email, $codeHash);
                $stmt->execute();
                $stmt->close();

                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = "smtp.gmail.com";
                    $mail->SMTPAuth = true;

                    // Írd be a saját Gmail-címedet!
                    $mail->Username = "kerekeserik684@gmail.com";

                    // Gmail alkalmazásjelszó, nem a normál jelszó!
                    $mail->Password = "byud tvas zcsc cayg";

                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    $mail->CharSet = "UTF-8";

                    $mail->setFrom(
                        "kerekeserik684@gmail.com",
                        "Jelszó-visszaállítás"
                    );
                    $mail->addAddress($email);

                    $mail->Subject = "Jelszó-visszaállítási kód";
                    $mail->Body =
                        "Kód: " . $code
                        . "\n\nA kód 10 percig érvényes.";

                    $mail->send();

                    $_SESSION["reset_email"] = $email;
                    $_SESSION["reset_started"] = time();

                } catch (Exception $e) {
                    // A részletes hiba a PHP hibanaplójába kerül.
                    error_log("E-mail-küldési hiba: " . $mail->ErrorInfo);

                    $error = "Nem sikerült elküldeni az e-mailt. "
                           . "Ellenőrizd az SMTP-beállításokat.";

                    unset($_SESSION["reset_email"]);
                    unset($_SESSION["reset_started"]);
                }
            } else {
                $msg_already = "Nincs ilyen e-mail-címmel regisztrált felhasználó!";
                unset($_SESSION["reset_email"]);
                unset($_SESSION["reset_started"]);
            }
        }
    }

    // 2. Kód ellenőrzése és jelszócsere
    if (isset($_POST["reset_password"])) {

        $email = $_SESSION["reset_email"] ?? "";
        $code = trim($_POST["code"] ?? "");
        $pass1 = $_POST["new_password"] ?? "";
        $pass2 = $_POST["confirm_password"] ?? "";

        if ($email === "") {
            $error = "Kérj először egy visszaállítási kódot!";
        } elseif (!preg_match('/^\d{6}$/', $code)) {
            $error = "A kódnak pontosan 6 számjegyűnek kell lennie!";
        } elseif ($pass1 !== $pass2) {
            $error = "A két jelszó nem egyezik!";
        } elseif (strlen($pass1) < 8) {
            $error = "A jelszó legalább 8 karakter hosszú legyen!";
        } else {
            $stmt = $conn->prepare(
                "SELECT hash, expires_at, attempts
                 FROM password_reset
                 WHERE email = ?"
            );
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $reset = $result->fetch_assoc();
            $stmt->close();

            if (!$reset) {
                $error = "Érvénytelen vagy lejárt kód. Kérj újat!";
            } elseif ((int)$reset["attempts"] >= 5) {
                $error = "Túl sok hibás próbálkozás. Kérj új kódot!";
            } elseif (strtotime($reset["expires_at"]) < time()) {
                $error = "Lejárt a kód. Kérj egy újat!";
            } elseif (!password_verify($code, $reset["hash"])) {

                $stmt = $conn->prepare(
                    "UPDATE password_reset
                     SET attempts = attempts + 1
                     WHERE email = ?"
                );
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->close();

                $error = "Hibás kód!";
            } else {
                $hashed = password_hash($pass1, PASSWORD_DEFAULT);

                $stmt = $conn->prepare(
                    "UPDATE users SET password = ? WHERE email = ?"
                );
                $stmt->bind_param("ss", $hashed, $email);
                $stmt->execute();
                $updated = $stmt->affected_rows;
                $stmt->close();

                if ($updated >= 0) {
                    // A kódot felhasználás után töröljük.
                    $stmt = $conn->prepare(
                        "DELETE FROM password_reset WHERE email = ?"
                    );
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $stmt->close();

                    unset($_SESSION["reset_email"]);
                    unset($_SESSION["reset_started"]);

                    header("Location: index.php?reset=success");
                    exit();
                } else {
                    $error = "Nem sikerült elmenteni az új jelszót.";
                }
            }
        }
    }
}

$showResetForm = isset($_SESSION["reset_email"])
    && isset($_SESSION["reset_started"]);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elfelejtett jelszó</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="form-box active">

        <h2>Elfelejtett jelszó</h2>


            <p><?php if ($error !== ""): ?>
                <p class="msg-error">
                    <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
                </p>
            <?php endif; ?>

            <?php if (isset($msg_already)): ?>
                <p class="msg-error">
                    <?= htmlspecialchars($msg_already, ENT_QUOTES, "UTF-8") ?>
                </p>
            <?php endif; ?></p>


        <?php if ($message !== ""): ?>
            <p>
                <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <?php if ($showResetForm): ?>

            <form method="POST">
                <input
                    type="text"
                    name="code"
                    placeholder="Hatjegyű szám"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    maxlength="6"
                    required
                >

                <input
                    type="password"
                    name="new_password"
                    placeholder="Új jelszó"
                    minlength="8"
                    required
                >

                <input
                    type="password"
                    name="confirm_password"
                    placeholder="Új jelszó megerősítése"
                    minlength="8"
                    required
                >

                <button type="submit" name="reset_password">
                    Jelszó megváltoztatása
                </button>
            </form>

        <?php else: ?>

            <form method="POST">
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    required
                >

                <button type="submit" name="send_code">
                    Kód küldése
                </button>
            </form>

        <?php endif; ?>

        
        <p>
            <button type="button" class="btn"
                onclick="window.location.href='index.php'">
                Vissza a bejelentkezéshez
            </button>
        </p>


    </div>
</div>

</body>
</html>
