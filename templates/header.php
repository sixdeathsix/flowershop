<?php session_start(); ?>

<header class="header">
    <div class="logo">
        <a href="/flowershop"><img src="./assets/images/logo.svg" alt=""></a>
    </div>
    <nav class="nav">
        <?php if($_SESSION['user']['role_id'] == 1): ?>
            <a href="index.php">О нас</a>
            <a href="products-page.php">Каталог</a>
            <a href="profile-page.php">Профиль</a>
            <a href="cart-page.php">Корзина</a>
            <a href="about-page.php">Где нас найти?</a>
            <a href="database/logout.php">Выйти</a>
        <?php elseif($_SESSION['user']['role_id'] == 2): ?>
            <a href="admin-order.php">Управление заказами</a>
            <a href="admin-category.php">Управление категориями</a>
            <a href="admin-product.php">Управление товарами</a>
            <a href="database/logout.php">Выйти</a>
        <?php else: ?>
            <a href="index.php">О нас</a>
            <a href="products-page.php">Каталог</a>
            <a href="about-page.php">Где нас найти?</a>
            <a href="auth-page.php">Войти</a>
        <?php endif; ?>
    </nav>
</header>