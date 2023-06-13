<?php 
    session_start();

    if ($_SESSION['user']) {
        header('Location: /flowershop');
    }

    require_once 'database/dboperations.php';
    require_once 'templates/notification.php';

    $title = 'Авторизация';

    if (isset($_POST['login'], $_POST['password'])) {
        $db->auth($_POST['login'], $_POST['password']);
    }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <?php require_once 'templates/head.php' ?>
</head>
<body>
    
    <?php require_once 'templates/header.php' ?>

    <div class="container auth">
        <form class="auth-form" method="post">
            <input type="text" name="login" placeholder="Логин" required>
            <input type="password" name="password" placeholder="Пароль" minLength="6" required>
            <button>Войти</button>
            <p>Нет профиля? <a href="register-page.php">Зарегистрироваться</a></p>
        </form>
    </div>
</body>
</html>