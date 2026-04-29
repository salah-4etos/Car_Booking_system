<?php
session_start();
$isCustomer = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['admin_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }
        nav {
            text-align: center;
            margin: 20px 0;
        }
        nav a {
            text-decoration: none;
            color: #333;
            background: #ccc;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
        }
        nav a:hover {
            background: #777;
            color: white;
        }
        .car-card {
        margin-top: 20px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
    }
    .car-card img {
        width: auto;
        height: auto;
        border-radius: 5px;
    }

        .container {
            max-width: 800px;
            margin: auto;
            text-align: center;
            padding: 20px;
        }
        footer {
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Car Rental System</h1>
        <p>Your trusted platform for car rentals</p>
    </header>

    <nav>
        <?php if ($isCustomer): ?>
            <a href="pages/search_cars.php">Search Cars</a>
            <a href="pages/reservation.php">Reserve a Car</a>
            <a href="logout.php">Log Out</a>
        <?php elseif ($isAdmin): ?>

            <a href="pages/reservations.php">All Reservations</a>
            <a href="pages/payments.php">Payments</a>
            <a href="pages/manage_cars.php">Manage Cars</a>
            <a href="pages/reports.php">View Reports</a>
            <a href="pages/manage_customers.php">Manage Customers</a>
            <a href="logout.php">Log Out</a>
        <?php else: ?>
            <a href="pages/complexLoginForm.php">Login Now</a>
        <?php endif; ?>
    </nav>

    <div class="container">
        <h2>Welcome to Car Rental System</h2>
        <p>Explore, reserve, and enjoy car rentals with ease!</p>
    </div>

    <div class="car-card">
    <img src="images/darkteal2f-optimized.png" alt="Car Image">
    <h3>Toyota Corolla</h3>
    <p>Year: 2020</p>
    <p>Location: Egypt</p>
</div>


    <footer>
        <p>&copy; 2024 Car Rental System. All Rights Reserved.</p>
    </footer>
</body>
</html>
