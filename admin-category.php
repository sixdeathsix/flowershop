<?php 
    session_start();

    if ($_SESSION['user']['role_id'] != 2) {
        header('Location: /flowershop');
    }

    require_once 'database/dboperations.php';
    require_once 'templates/notification.php';

    $product_types = $db->getAllProductTypes();

    if(isset($_POST['delete'])) {
        $db->deleteProductType($_POST['delete']);
    }

    if(isset($_POST['update'])) {
        $db->updateProductType($_POST['product_type_name'], $_POST['update']);
    }

    if(isset($_POST['add'])) {
        $db->addProductType($_POST['product_type_name']);
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

        <form method="post">
            <input type="text" name="product_type_name" placeholder="Добавить категорию товара" required>
            <button name='add'>Добавить</button>
        </form>
        
        <table>
            <tr>
                <th>Название вида товара</th>
                <th></th>
            </tr>
            <?php foreach($product_types as $type): ?>
                <tr>
                    <form method="post">
                        <td><input type="text" name="product_type_name" value="<?= $type['product_type_name'] ?>"></td>
                        <td>
                            <button name='delete' value='<?= $type['id_product_type'] ?>'>Удалить</button>
                            <button name='update' value='<?= $type['id_product_type'] ?>'>Обновить</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>
</body>
</html>