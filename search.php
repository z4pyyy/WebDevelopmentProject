<?php
session_start();
include 'connection.php';

$q = trim($_GET['q'] ?? '');
$q_sql = mysqli_real_escape_string($conn, $q);

if ($q !== '') {
    // Find product with its category name
    $sql = "SELECT p.id, p.name, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.name LIKE '%$q_sql%'
            LIMIT 1";
    $res = mysqli_query($conn, $sql);

    if ($res === false) {
        $_SESSION['search_error'] = "An error occurred while searching. Please try again.";
        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        header("Location: $referer");
        exit;
    }

    if ($row = mysqli_fetch_assoc($res)) {
        $product_fragment = preg_replace('/[^a-z0-9-]/', '-', strtolower(str_replace(' ', '-', htmlspecialchars($row['name']))));
        $category_name = $row['category_name'] ?? '';

        // Predefined pages
        $predefined_pages = [
            'Basic Brew'    => 'product1.php',
            'Artisan Brew'  => 'product2.php',
            'Non-Coffee'    => 'product3.php',
            'Hot Beverages' => 'product4.php'
        ];

        // Decide page
        if (array_key_exists($category_name, $predefined_pages)) {
            $target_page = $predefined_pages[$category_name];
        } else {
            $target_page = 'other_products.php';
        }

        header("Location: $target_page#$product_fragment");
        exit;
    }

    // No match found
    $_SESSION['search_error'] = "No products found matching '$q'. Please try a different search.";
    $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header("Location: $referer");
    exit;
}

header("Location: index.php");
exit;
?>
