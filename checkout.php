<?php
session_start();
include 'connection.php';

if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

// 1. Calculate total cart amount
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// 2. Check if user is logged in and is a member
$member_id = null;
$wallet = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_query = mysqli_query($conn, "SELECT membership_id FROM user WHERE id = $user_id");
    $user = mysqli_fetch_assoc($user_query);
    if ($user && $user['membership_id']) {
        $member_id = $user['membership_id'];
        $member_query = mysqli_query($conn, "SELECT * FROM membership WHERE id = $member_id");
        $member = mysqli_fetch_assoc($member_query);
        $wallet = $member['wallet'];
    }
}

$message = '';
$success = false;

$payment_method = $_POST['payment_method'] ?? 'wallet'; // default wallet for members
$can_use_wallet = ($member_id && $wallet !== null && $wallet >= $total);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_checkout'])) {
    if ($payment_method === 'wallet') {
    if ($member_id) {
        if ($wallet >= $total) {
            $new_wallet = $wallet - $total;
            $points_earned = floor($total); // 1 point per RM1 spent
            $sql = "UPDATE membership SET wallet = $new_wallet, points = points + $points_earned WHERE id = $member_id";
            mysqli_query($conn, $sql);
            $_SESSION['cart'] = [];
            $success = true;
            $message = "Payment successful! RM" . number_format($total, 2) . " has been deducted from your wallet. You earned $points_earned points. New balance: RM" . number_format($new_wallet, 2) . ".";
            $wallet = $new_wallet;
        }   
        else {
            $message = "Insufficient wallet balance. Please top up or select another payment method.";
            }
        } 
    else {
        $message = "You must be logged in as a member to use wallet.";
    }
    } else if (in_array($payment_method, ['cash', 'card', 'ewallet'])) {
        $_SESSION['cart'] = [];
        $success = true;
        $msg_map = [
            'cash' => 'Your order has been placed. Please prepare cash for payment on pickup!',
            'card' => 'Payment successful! Your card will be charged RM' . number_format($total, 2) . '.',
            'ewallet' => 'Payment successful! Please pay RM' . number_format($total, 2) . ' via your EWallet QR at pickup.'
        ];
        $message = $msg_map[$payment_method];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout - Brew & Go</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="checkout-container">
    <h2>Checkout</h2>
    <?php if (!empty($_SESSION['cart'])): ?>
        <ul class="checkout-cart-list">
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <li class="checkout-cart-item">
                    <img src="<?= htmlspecialchars($item['image'] ?? 'assets/no-image.png') ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="checkout-item-img">
                    <span class="checkout-item-name"><?= htmlspecialchars($item['name']) ?></span>
                    <span class="checkout-item-qty">×<?= $item['quantity'] ?></span>
                    <span class="checkout-item-price">RM<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="checkout-total">Total: RM<?= number_format($total, 2) ?></div>

        <?php if ($success): ?>
            <div class="checkout-success"><?= $message ?></div>
            <a href="index.php" class="checkout-back-link">Back to Home</a>
        <?php else: ?>
            <?php if ($member_id): ?>
                <div class="wallet-balance">
                    Wallet Balance: <b>RM<?= number_format($wallet, 2) ?></b>
                </div>
                <form method="post" class="checkout-form">
                    <input type="hidden" name="payment_method" value="wallet">
                    <?php if ($wallet >= $total): ?>
                        <button type="submit" name="confirm_checkout" class="checkout-btn">Pay with Wallet</button>
                    <?php else: ?>
                        <div class="checkout-error">Insufficient wallet balance.</div>
                        <a href="membership.php" class="topup-btn">Top Up Wallet</a>
                    <?php endif; ?>
                </form>
                <?php if ($message): ?>
                    <div class="checkout-error"><?= $message ?></div>
                <?php endif; ?>
            <?php else: ?>
                <div class="checkout-error">
                    Please <a href="login.php" class="checkout-back-link">log in</a> as a member to pay using wallet.
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <p>Your cart is empty.</p>
        <a href="product1.php" class="checkout-back-link">Shop Now</a>
    <?php endif; ?>
</div>
</body>
</html>