<?php
session_start();

if (!isset($_SESSION['user_cart'])) {
    $_SESSION['user_cart'] = [];
}

if (isset($_POST['item_id'], $_POST['item_name'], $_POST['item_price'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

    if (isset($_SESSION['user_cart'][$item_id])) {
        $_SESSION['user_cart'][$item_id]['qty'] += $item_quantity;
    } else {
        $_SESSION['user_cart'][$item_id] = [
            'product_name' => $item_name,
            'unit_price' => $item_price,
            'qty' => $item_quantity
        ];
    }

    echo "Товар добавлен в корзину!";
}

?>
