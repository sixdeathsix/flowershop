<?php 
    session_start();

    $title = 'Главная';

    require_once 'database/dboperations.php';
    require_once 'templates/notification.php';

    $slides = $db->getSliderItems();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'templates/head.php' ?>
</head>
<body>

    <?php require_once 'templates/header.php' ?>

    <div class="container">

        <div id="viewport">
            <div class="slider">
                <?php foreach($slides as $slide): ?>
                    <div class="slide">
                        <img src="http://localhost/flowershop<?= $slide['image'] ?>" alt="">
                        <p><?= $slide['product_name'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="slider-button">
            <button class="prev slider-btn">Назад</button>
            <button class="next slider-btn">Вперед</button>
        </div>

        <div class="">Наш девиз - Хороший букет красноречивее слов</div>
    </div>

    <script src="assets/js/slider.js"></script>
</body>
</html>