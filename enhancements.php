<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Brew & Go Coffee - Premium handcrafted beverages">
    <meta name="keywords" content="Coffee, Brew & Go, Kuching, handcrafted beverages">
    <meta name="author" content="TERENCE WONG, DARREN CHONG, HANS YEE">
    <title>Brew & Go Coffee - Enhancements</title>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
</head>
<body>
<div id="top"></div>
<header>
    <?php include 'navbar.php'; ?>
</header>

<section class="enhancement-wrapper">
    <div class="enhancement-title">
        <h1>Enhancements</h1>
        <ol>

            <a href="view_activity.php">
                <img src="images/Enhancements-ActivitiesModule.png" alt="Activities Module">
            </a>
            <li><h2>Activities Module</h2>
                <p>
                    A simple admin module to create, update, and delete events or activities (CRUD). Activities can be categorized, sorted, and displayed dynamically based on Time zone Asia/Kuching on public pages.
                </p>
            </li>
            <br>

            <a>
                <img src="images/Enhancements-ItemCart.png" alt="Item Cart">
            </a>
            <li><h2>Item Cart Module</h2>
                <p>
                  Lets users view and manage selected items in a cart sidebar picked from products page. Users can add items, update quantities, and remove items. The cart is session-based and works across all product pages.
                </p>
            </li>
            <br>
            
          <a href="checkout.php">
            <img src="images/Enhancements-CheckoutItemCart.png" alt="Checkout Item Cart">
          </a>
            <li><h2>Checkout Item Cart</h2>
            <p>
                Checkout item cart that allows users to update quantities, remove items before proceed to a secure checkout.
            </p>
          </li>
            <br>

            <a href="membership.php">
                <img src="images/Enhancements-TopUp.png" alt="Top Up Module">
            </a>
            <li><h2>Member Top-Up Module</h2>
                <p>
                    Registered members can top up their digital wallet (Demonstration Purposes- Implemented without Security Payment Gateway). Wallet balances are updated in real time.
                </p>
            </li>
            <br>

            <a href="view_job_applications.php">
                <img src="images/Enhancements-JobApplications.png" alt="Job Applications Module">
            </a>
            <li><h2>Job Applications Module</h2>
                <p>
                    Enables users to submit job applications with limited size file uploads (CV and photo). Admins can view, filter, and manage all job applications through a dedicated dashboard.
                </p>
            </li>
            <br>

            <a href="view_newsletters.php">
                <img src="images/Enhancements-Newsletter.png" alt="Newsletter Enhancement">
            </a>
            <li><h2>Newsletter System</h2>
                <p>
                    A newsletter system where admins can compose and send newsletters to registered users. Includes subscriber management and email tracking.
                </p>
            </li>
            <br>

            <a href="view_product.php">
                <img src="images/Enhancements-Products.png" alt="Products Module">
            </a>
            <li><h2>Products Module</h2>
                <p>
                    An admin dashboard for adding, editing, or removing (CRUD) products with images, categories, prices and products can be filtered by category or price range.
                </p>
                <p>
                  Admin can also add new categories of items, set item availability and navigate to different categories quickly with built in search functionality and category sorted sidebar.  
                </p>
            </li>
            <br>

            <a href="product1.php">
                <img src="images/Enhancements-ProductSearch.png" alt="Product Search Enhancement">
            </a>
            <li><h2>Product Search Feature</h2>
                <p>
                  Live search and filter system for users to instantly find products or activities by name, category, or price range. 
                </p>
                <p>
                  Both Product and activities has dedicated search functionality so wont need to worry about searching for the wrong item.
                </p>
            </li>
            <br>

            <a href="view_permissions.php">
                <img src="images/Enhancements-RBAC.png" alt="RBAC Enhancement">
            </a>
            <li><h2>Role-Based Access Control (RBAC)</h2>
                <p>
                    Implements secure role-based permissions: only admins can set access to certain management pages, while users and staff see only their allowed features. Session and database checks included.
                </p>
            </li>
            <br>

            <a href="view_membership.php">
                <img src="images/Enhancements-UserManagement.png" alt="User Management Enhancement">
            </a>
            <li><h2>User Management Module</h2>
                <p>
                    Comprehensive user management for admins: view, edit, reset password, change status, or remove accounts. Fully integrated with RBAC and secure backend logic.
                </p>
            </li>
            <br>
        </ol>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
