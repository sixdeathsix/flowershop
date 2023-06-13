<?php 
    session_start();

    $title = 'Товары';

    require_once 'database/dboperations.php';
    require_once 'templates/notification.php';

    $product_type_id = $_GET['type'];
    $sort = $_GET['sort'];

    if (isset($product_type_id)) {
        $products = $db->getAllProductsWithFilter($product_type_id);
    } else if (isset($sort)) {
        $products = $db->getAllProductsWithSort($sort);
    } else {
        $products = $db->getAllProducts();
    }

    $product_types = $db->getAllProductTypes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'templates/head.php' ?>
</head>
<body>
    
    <?php require_once 'templates/header.php' ?>

    <div class="container product-container">

        <?php if($products): ?>

            <div class="product-types">
                <?php foreach($product_types as $type): ?>
                    <a href="?type=<?= $type['id_product_type'] ?>"><?= $type['product_type_name'] ?></a>
                <?php endforeach; ?>
                <a href="products-page.php">Все</a>
            </div>

            <div class="product-list">
                <div class="product-sort">
                    <a href="products-page.php?sort=ct.country_name asc">По стране</a>
                    <a href="products-page.php?sort=p.product_name asc">По именованию</a>
                    <a href="products-page.php?sort=p.price desc">По убыванию цены</a>
                    <a href="products-page.php?sort=p.price asc">По возрастанию цены</a>
                </div>

                <div class="products">
                    <?php foreach($products as $product): ?>
                        <a href="product-page.php?product_id=<?= $product['id_product'] ?>" class="product" data-class="<?= $product ?>">
                            <img src="http://localhost/flowershop<?= $product['image'] ?>" alt="">
                            <p class="product-name"><?= $product['product_name'] ?></p>
                            <p class="product-price"><?= $product['price'] ?> P</p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php else: ?>

            <h1 class="title">Товаров нет</h1>

        <?php endif; ?>
        
    </div>

</body>
</html>