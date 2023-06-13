<?php 
    session_start();

    if (!$_SESSION['user']) {
        header('Location: /flowershop');
    }

    $title = 'Профиль';

    $user = $_SESSION['user'];

    require_once 'database/dboperations.php';
    require_once 'templates/notification.php';

    $history = $db->getOrderHistory($user['id_user']);

    if (isset($_POST['order_product_id'])) {
        $db->cancelOrder($_POST['order_product_id']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'templates/head.php' ?>
</head>
<body>

    <?php require_once 'templates/header.php' ?>

    <div class="container">

        <div class="">
            <p>ФИО пользователя: <?= $user['surname'] ?> <?= $user['name'] ?> <?= $user['patronymic'] ?></p>
        </div>

        <h3>Заказы</h3>

        <?php if($history): ?>

            <div class="cart-body products">
                <?php foreach($history as $product): ?>
                    <a href="product-page.php?product_id=<?= $product['id_product'] ?>" class="product">
                        <img src="http://localhost/flowershop<?= $product['image'] ?>" alt="">
                        <p class="product-name"><?= $product['product_name'] ?></p>
                        <p class="product-count">Количество: <?= $product['count'] ?></p>
                        <p>Итого: <span class="product-price"><?= $product['price'] * $product['count'] ?></span> P</p>
                        <p class='status'>Статус заказа: <?= $product['status_name'] ?></p>
                        <?php if($product['cancel_message']): ?>
                            <p class='status'>Причина отмены: <?= $product['cancel_message'] ?></p>
                        <?php endif; ?>
                        <?php if($product['status_name'] == 'Новый'): ?>
                            <form method="post">
                                <input type="hidden" name="order_product_id" value="<?= $product['id_order_product'] ?>">
                                <button>Отменить</button>
                            </form>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>

        <?php else: ?>

            <h1 class="title">История заказов отсутствует</h1>

        <?php endif; ?>
        
    </div>

    <script src="assets/js/slider.js"></script>
</body>
</html>