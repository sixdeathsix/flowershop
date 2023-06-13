<?php 

session_start();

function getOne($query)
{
    require 'connect.php';

    $query = mysqli_query($connect, $query);

    if (mysqli_num_rows($query) == 1) {
        return mysqli_fetch_assoc($query);
    } else {    
        return false;
    }

}

function getAll($query)
{
    require 'connect.php';

    $query = mysqli_query($connect, $query);

    if (mysqli_num_rows($query) > 0) {
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else {
        return false;
    }
}

function operation($query)
{
    require 'connect.php';

    return mysqli_query($connect, $query);
}

class DBOperations
{

    public function auth($login, $password)
    {

        $user = getOne("
            select * from users where login = '$login' and password = '$password'
        ");

        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: index.php');
        } else {
            $_SESSION['message'] = 'Неверный логин или пароль';
            header('Location: auth-page.php');
        }

    }

    public function register($surname, $name, $patronymic, $email, $login, $password, $password_repeat)
    {
        $login_isset = getOne("
            select login from users where login = '$login'
        ");

        if ($login_isset) {
            $_SESSION['message'] = 'Пользователь с таким логином уже зарегистрирован';
            header('Location: register-page.php');
        } else {

            if ($password == $password_repeat) {
                $success = operation("
                    insert into users values (null, '$surname', '$name', '$patronymic', '$email', '$login', '$password', 1)
                ");

                if ($success) {
                    $_SESSION['message'] = 'Регистрация прошла успешно';
                    header('Location: auth-page.php');
                } else {
                    $_SESSION['message'] = 'Произошла ошибка во время регистрации';
                    header('Location: register-page.php');
                }
            } else {
                $_SESSION['message'] = 'Пароли не совпадают';
                header('Location: register-page.php');
            }

        }
    }

    public function getAllProductsWithSort($sort)
    {   
        return getAll("
            select p.id_product, p.image, p.product_name, p.price, p.amount, c.color_name, pt.product_type_name, ct.country_name, p.product_type_id from products p 
            left join colors c on c.id_color = p.color_id
            left join product_types pt on pt.id_product_type = p.product_type_id
            left join countries ct on ct.id_country = p.country_id
            where p.amount > 0
            order by $sort;
        ");
    }

    public function getAllProductsWithFilter($product_type_id)
    {   
        return getAll("
            select p.id_product, p.image, p.product_name, p.price, p.amount, c.color_name, pt.product_type_name, ct.country_name, p.product_type_id from products p 
            left join colors c on c.id_color = p.color_id
            left join product_types pt on pt.id_product_type = p.product_type_id
            left join countries ct on ct.id_country = p.country_id
            where p.amount > 0 and p.product_type_id = '$product_type_id'
            order by p.id_product desc;
        ");
    }

    public function getAllProducts()
    {
        return getAll("
            select p.id_product, p.image, p.product_name, p.price, p.amount, c.color_name, pt.product_type_name, ct.country_name, p.product_type_id from products p 
            left join colors c on c.id_color = p.color_id
            left join product_types pt on pt.id_product_type = p.product_type_id
            left join countries ct on ct.id_country = p.country_id
            where p.amount > 0
            order by p.id_product desc;
        ");
    }

    public function getOneProduct($product_id)
    {
        return getOne("
            select p.id_product, p.image, p.product_name, p.price, p.amount, c.color_name, pt.product_type_name, ct.country_name from products p 
            left join colors c on c.id_color = p.color_id
            left join product_types pt on pt.id_product_type = p.product_type_id
            left join countries ct on ct.id_country = p.country_id
            where p.id_product = '$product_id' and p.amount > 0;
        ");
    }

    public function addProductInCart($count, $product_id, $user_id)
    {

        $count = $count ? $count : 1; 

        $success = operation("
            insert into cart_products values (null, '$count', '$product_id', '$user_id')
        ");

        if ($success) {
            $_SESSION['message'] = 'Товар добавлен в корзину';
            header('Location: cart-page.php');
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
            header("Location: product-page.php?product_id='$product_id'");
        }
    }

    // public function addProductInCart($count, $product_id, $user_id)
    // {

    //     $count = $count ? $count : 1; 

    //     $product_isset = getOne("
    //         select id_cart_product from cart_products where product_id = '$product_id' and user_id = '$user_id'
    //     ");

    //     if ($product_isset) {

    //         $count = $product_isset['count'] + $count;
    //         $new_id = $product_isset['id_cart_product'];

    //         $success = operation("
    //             update cart_products set count = '$count' where id_product_id = '$new_id'
    //         ");

    //     } else {
    
    //         $success = operation("
    //             insert into cart_products values (null, '$count', '$product_id', '$user_id')
    //         ");

    //     }
    
    //     if ($success) {
    //         $_SESSION['message'] = 'Товар добавлен в корзину';
    //         header('Location: cart-page.php');
    //     } else {
    //         $_SESSION['message'] = 'Произошла ошибка';
    //         header("Location: product-page.php?product_id='$product_id'");
    //     }
    // }

    public function getAllProductTypes()
    {
        return getAll("
            select * from product_types
        ");
    }

    public function getUserCartProducts($user_id)
    {
        return getAll("
            select cp.id_cart_product, cp.count, p.id_product, p.image, p.product_name, p.price, c.color_name, pt.product_type_name, ct.country_name from cart_products cp 
            left join products p on p.id_product = cp.product_id
            left join colors c on c.id_color = p.color_id
            left join product_types pt on pt.id_product_type = p.product_type_id
            left join countries ct on ct.id_country = p.country_id
            where cp.user_id = '$user_id';
        ");
    }

    public function orderCart($user_id, $password)
    {   

        if ($_SESSION['user']['password'] != $password) {
            $_SESSION['message'] = 'Пароль введен неверно';
        } else {
            require 'connect.php';

            mysqli_autocommit($connect, false);
    
            $commit = true;
    
            $cart_products = $this->getUserCartProducts($user_id);
    
            foreach ($cart_products as $product) {
    
                $count = $product['count'];
                $product_id = $product['id_product'];
                $id_cart_product = $product['id_cart_product'];
    
                $success = operation("
                    insert into order_products values (null, '$count', current_timestamp,'1', '$product_id', '$user_id', null)
                ");
    
                $success_remove = operation("
                    delete from cart_products where id_cart_product = '$id_cart_product'
                ");
    
                if (!$success || !$success_remove) {
                    $commit = false;
                    $_SESSION['message'] = 'err';
                    break;
                }
    
            }
    
            if ($commit) {
                mysqli_commit($connect);
                $_SESSION['message'] = 'Товары успешно оформлены';
            } else {
                mysqli_rollback($connect);
                $_SESSION['message'] = 'Произошла ошибка';
            }
        }

        header('Location: cart-page.php');
    }

    public function getSliderItems()
    {
        return getAll("
            select * from products order by id_product desc limit 5
        ");
    }

    public function getOrderHistory($user_id)
    {
        return getAll("
            select op.id_order_product, s.status_name, p.image, p.product_name, p.price, op.count, op.cancel_message from order_products op 
            left join statuses s on s.id_status = op.status_id
            left join products p on p.id_product = op.product_id
            where op.user_id = '$user_id' order by op.id_order_product desc;
        ");
    }

    public function cancelOrder($order_product_id)
    {
        $success = operation("
            update order_products set status_id = 3 where id_order_product = '$order_product_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Заказ успешно отменен';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: profile-page.php');
    }

    public function getAllAdminProduct()
    {
        return getAll("
            select p.id_product, p.image, p.product_name, p.price, p.amount, p.color_id, p.product_type_id, p.country_id, c.color_name, pt.product_type_name, ct.country_name, p.product_type_id from products p 
            left join colors c on c.id_color = p.color_id
            left join product_types pt on pt.id_product_type = p.product_type_id
            left join countries ct on ct.id_country = p.country_id
            order by p.id_product desc;
        ");
    }

    public function addProductType($product_type_name)
    {
        $success = operation("
            insert into product_types values (null, '$product_type_name')
        ");

        if ($success) {
            $_SESSION['message'] = 'Изменения сохранены';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: admin-category.php');
    }

    public function updateProductType($product_type_name, $product_type_id)
    {
        $success = operation("
            update product_types set product_type_name = '$product_type_name' where id_product_type = '$product_type_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Изменения сохранены';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: admin-category.php');
    }

    public function deleteProductType($product_type_id)
    {
        $success = operation("
            delete from product_types where id_product_type = '$product_type_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Изменения сохранены';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: admin-category.php');
    }

    public function addProduct($image, $product_name, $price, $amount, $color_id, $product_type_id, $country_id)
    {

        $filename = $image['name'];
        $tempname = $image['tmp_name'];
        $image = 'source/' . time() . '_' . $filename; 

        $success = operation("
            insert into products values (null, '/$image', '$product_name', '$price', '$amount', '$color_id', '$product_type_id', '$country_id')
        ");
        
        move_uploaded_file($tempname, $image);

        if ($success) {
            $_SESSION['message'] = 'Товар сохранен';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: admin-product.php');
    }

    public function updateProduct($product_id, $product_name, $price, $amount, $color_id, $product_type_id, $country_id)
    {
        $success = operation("
            update products set 
            product_name = '$product_name', 
            price = '$price', 
            amount = '$amount', 
            color_id = '$color_id',
            product_type_id = '$product_type_id',
            country_id = '$country_id'
            where id_product = '$product_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Изменения сохранены';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: admin-product.php');
    }

    public function deleteProduct($product_id)
    {
        $success = operation("
            delete from products where id_product = '$product_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Изменения сохранены';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: admin-product.php');
    }

    public function getAllColors()
    {
        return getAll("
            select * from colors
        ");
    }

    public function getAllCountries()
    {
        return getAll("
            select * from countries
        ");
    }

    public function getAllAdminStatusOrders($status_id)
    {
        return getAll("
            select * from order_products op
            left join users u on u.id_user = op.user_id
            left join products p on p.id_product = op.product_id
            left join statuses s on s.id_status = op.status_id
            where status_id = '$status_id'
        ");
    }

    public function getAllAdminOrders()
    {
        return getAll("
            select * from order_products op
            left join users u on u.id_user = op.user_id
            left join products p on p.id_product = op.product_id
            left join statuses s on s.id_status = op.status_id
        ");
    }

    public function acceptOrder($order_id)
    {
        $success = operation("
            update order_products set 
            status_id = '2'
            where id_order_product = '$order_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Заказ подтвержден';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: admin-order.php');
    }

    public function cancelAdminOrder($order_id, $cancel_message)
    {
        $success = operation("
            update order_products set status_id = 3, cancel_message = '$cancel_message' where id_order_product = '$order_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Заказ успешно отменен';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: admin-order.php');
    }

    public function deleteAdminOrder($order_id)
    {
        $success = operation("
            delete from order_products where id_order_product = '$order_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Заказ успешно удален';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: admin-order.php');
    }

    public function deleteCartProduct($cart_product_id)
    {
        $success = operation("
            delete from cart_products where id_cart_product = '$cart_product_id'
        ");

        if ($success) {
            $_SESSION['message'] = 'Товар удален из корзины';
        } else {
            $_SESSION['message'] = 'Произошла ошибка';
        }

        header('Location: cart-page.php');
    }

}

$db = new DBOperations();

?>