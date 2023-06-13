<?php 
    session_start();

    require_once 'database/dboperations.php';
    require_once 'templates/notification.php';

    $product_id = $_GET['product_id'];

    $product = $db->getOneProduct($product_id);

    $title = 'Товар' . ' ' . $product['product_name'];

    if (isset($_POST['count'])) {
        $db->addProductInCart($_POST['count'], $product_id, $_SESSION['user']['id_user']);
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
        <form class="product-card" method="post">
            <img class="product-image" src="http://localhost/flowershop<?= $product['image'] ?>" alt="">
            <div class="product-body">
                <h2><?= $product['product_name'] ?></h2>
                <p>Цена: <?= $product['price'] ?> рублей</p>
                <p>Количество на складе: <?= $product['amount'] ?></p>
                <p>Цвет: <?= $product['color_name'] ?></p>
                <p>Вид товара: <?= $product['product_type_name'] ?></p>
                <p>Страна: <?= $product['country_name'] ?></p>
                <?php if($_SESSION['user']): ?>
                    <input type="number" name="count" placeholder='Количество товара' min='1' max='<?= $product['amount'] ?>'>
                    <button>В корзину</button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</body>
</html>