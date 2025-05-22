<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $large_price = floatval($_POST['large_price']);
    $quantity = intval($_POST['quantity']);
    $image = $_POST['image'];
    
    $unit_price = $price;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'id' => $product_id,
            'name' => $name,
            'price' => $unit_price,
            'quantity' => $quantity,
            'image' => $image
        ];
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
