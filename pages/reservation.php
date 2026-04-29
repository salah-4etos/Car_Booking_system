<?php
include('../includes/db_connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

// Handle reservation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_SESSION['user_id'];
    $car_id = $_POST['car_id'];
    $reservation_date = $_POST['reservation_date'];
    $return_date = $_POST['return_date'];

    $sql = "INSERT INTO reservations (customer_id, car_id, reservation_date, return_date, status, payment_status) 
            VALUES ('$customer_id', '$car_id', '$reservation_date', '$return_date', 'rented', 'unpaid')";

    if ($conn->query($sql)) {
        echo "Reservation successful!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all active cars
$sql = "SELECT * FROM cars WHERE status = 'active'";
$cars = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reserve a Car</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Reserve a Car</h1>
    <form method="POST">
        <label>Select Car:</label>
        <select name="car_id" required>
            <?php while ($car = $cars->fetch_assoc()): ?>
                <option value="<?php echo $car['id']; ?>">
                    <?php echo $car['model'] . " (" . $car['plate_id'] . ")"; ?>
                </option>
            <?php endwhile; ?>
        </select><br>
        <label>Reservation Date:</label>
        <input type="date" name="reservation_date" required><br>
        <label>Return Date:</label>
        <input type="date" name="return_date" required><br>
        <button type="submit">Reserve</button>
    </form>
</body>
</html>
