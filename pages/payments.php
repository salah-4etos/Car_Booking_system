<?php
include('../includes/db_connection.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../index.php');
    exit;
}

// Handle payment addition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];

    $sql = "INSERT INTO payments (reservation_id, amount, payment_date) VALUES ('$reservation_id', '$amount', '$payment_date')";
    if ($conn->query($sql)) {
        $update_sql = "UPDATE reservations SET payment_status = 'paid' WHERE id = '$reservation_id'";
        $conn->query($update_sql);
        echo "Payment added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch unpaid reservations
$sql = "SELECT * FROM reservations WHERE payment_status = 'unpaid'";
$reservations = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Payments</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Manage Payments</h1>
    <form method="POST">
        <label>Select Reservation:</label>
        <select name="reservation_id" required>
            <?php while ($reservation = $reservations->fetch_assoc()): ?>
                <option value="<?php echo $reservation['id']; ?>">
                    <?php echo "Reservation #" . $reservation['id']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>
        <label>Amount:</label>
        <input type="number" step="0.01" name="amount" required><br>
        <label>Payment Date:</label>
        <input type="date" name="payment_date" required><br>
        <button type="submit">Add Payment</button>
    </form>
</body>
</html>
