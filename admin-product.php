<?php 
    session_start();

    if ($_SESSION['user']['role_id'] != 2) {
        header('Location: /flowershop');
    }

    require_once 'database/dboperations.php';
    require_once 'templates/notification.php';

    $products = $db->getAllAdminProduct();
    $types = $db->getAllProductTypes();
    $colors = $db->getAllColors();
    $countries = $db->getAllCountries();

    if(isset($_POST['delete'])) {
        $db->deleteProduct($_POST['delete']);
    }

    if(isset($_POST['update'])) {
        $db->updateProduct(
            $_POST['update'],
            $_POST['product_name'],
            $_POST['product_price'],
            $_POST['product_amount'],
            $_POST['color_id'],
            $_POST['product_type_id'],
            $_POST['country_id'],
        );
    }

    if(isset($_POST['add'])) {
        $db->addProduct(
            $_FILES['product_image'],
            $_POST['product_name'],
            $_POST['product_price'],
            $_POST['product_amount'],
            $_POST['color_id'],
            $_POST['product_type_id'],
            $_POST['country_id']
        );
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

    

        <form method="post" enctype="multipart/form-data">
            <input type="text" name="product_name" placeholder="Название товара" required>
            <input type="text" name="product_price" placeholder="Цена" required>
            <input type="text" name="product_amount" placeholder="Количество на складе" required>
            <select name="color_id">
                <?php foreach($colors as $color): ?>
                    <option value="<?= $color['id_color'] ?>"><?= $color['color_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <select name="product_type_id">
                <?php foreach($types as $type): ?>
                    <option value="<?= $type['id_product_type'] ?>"><?= $type['product_type_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <select name="country_id">
                <?php foreach($countries as $country): ?>
                    <option value="<?= $country['id_country'] ?>"><?= $country['country_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="file" name="product_image" required>
            <button name='add'>Добавить</button>
        </form>
        
        <table>
            <tr>
                <th>Товар</th>
                <th></th>
            </tr>
            <?php foreach($products as $product): ?>
                <tr>
                    <form method="post">
                        <td>
                            <input type="text" name="product_name" value="<?= $product['product_name'] ?>">
                            <input type="text" name="product_price" value="<?= $product['price'] ?>">
                            <input type="text" name="product_amount" value="<?= $product['amount'] ?>">
                            <select name="color_id">
                                <option value="<?= $product['color_id'] ?>" selected><?= $product['color_name'] ?></option>
                                <?php foreach($colors as $color): ?>
                                    <option value="<?= $color['id_color'] ?>"><?= $color['color_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select name="product_type_id">
                                <option value="<?= $product['product_type_id'] ?>" selected><?= $product['product_type_name'] ?></option>
                                <?php foreach($types as $type): ?>
                                    <option value="<?= $type['id_product_type'] ?>"><?= $type['product_type_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select name="country_id">
                                <option value="<?= $product['country_id'] ?>" selected><?= $product['country_name'] ?></option>
                                <?php foreach($countries as $country): ?>
                                    <option value="<?= $country['id_country'] ?>"><?= $country['country_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <button name='delete' value='<?= $product['id_product'] ?>'>Удалить</button>
                            <button name='update' value='<?= $product['id_product'] ?>'>Обновить</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>
</body>
</html>