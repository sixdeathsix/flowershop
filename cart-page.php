<?php 
    session_start();

    if (!$_SESSION['user']) {
        header('Location: /flowershop');
    }

    $title = 'Корзина';

    require_once 'database/dboperations.php';
    require_once 'templates/notification.php';

    $cart_products = $db->getUserCartProducts($_SESSION['user']['id_user']);

    if (isset($_POST['orderall'])) {
        $db->orderCart($_SESSION['user']['id_user'], $_POST['password_check']);
        unset($_POST['orderall']);
    }

    if (isset($_POST['delete'])) {
        $db->deleteCartProduct($_POST['delete']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'templates/head.php' ?>
</head>
<body>

    <?php require_once 'templates/header.php' ?>

    <div class="container cart">
        
        <?php if($cart_products): ?>

            <div class="cart-body products">
                <?php foreach($cart_products as $product): ?>
                    <a href="product-page.php?product_id=<?= $product['id_product'] ?>" class="product">
                        <img src="http://localhost/flowershop<?= $product['image'] ?>" alt="">
                        <p class="product-name"><?= $product['product_name'] ?></p>
                        <p class="product-count">Количество: <?= $product['count'] ?> штук</p>
                        <p>Итого: <span class="product-price"><?= $product['price'] * $product['count'] ?></span> P</p>
                        <form method="post">
                            <button name="delete" value="<?= $product['id_cart_product'] ?>">Удалить</button>
                        </form>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="cart-order">
                Сумма: <span id='amount'>0</span>
                <form method="post">
                    <input type="password" name="password_check" placeholder="Для оформления введите пароль" required>
                    <button name="orderall">Оформить все</button>
                </form>
            </div>

        <?php else: ?>

            <h1 class="title">Корзина пустая</h1>

        <?php endif; ?>
        
    </div>

    <script src="assets/js/cart.js"></script>
</body>
</html>