<?php

session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? '',
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bengo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="index">

<div class="login-wrapper">

    <!-- BAL OLDAL – kép + szöveg -->
    <div class="left-side">
        <h1>Jó újra látni!</h1>
    </div>

    <!-- JOBB OLDAL – bejelentkezés -->
    <div class="right-side">
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
            <form action="login_register.php" method="post">
                <h2>Bejelentkezés</h2>
                <?= showError($errors['login']); ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Jelszó" required>
                <button type="submit" name="login"><img src="background/login.png" class="btn-icon"> Bejelentkezés</button>
            </form>
        </div>
    </div>

</div>

</body>


</html>