<?php
include('../includes/db_connection.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../index.php');
    exit;
}

$sql = "SELECT reservations.id, customers.name AS customer_name, cars.model AS car_model, reservations.reservation_date, reservations.return_date, reservations.status 
        FROM reservations 
        JOIN customers ON reservations.customer_id = customers.id 
        JOIN cars ON reservations.car_id = cars.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Reservations</title>
    <link rel="stylesheet" href="../style.css">
    <script>
        table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid black;
    padding: 10px;
    text-align: left;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

th {
    background-color: #4CAF50;
    color: white;
}
        </script>
</head>
<body>
    <h1>All Reservations</h1>
    <table border="1">
        <tr>
            <th>Reservation ID</th>
            <th>Customer Name</th>
            <th>Car Model</th>
            <th>Reservation Date</th>
            <th>Return Date</th>
            <th>Status</th>
        </tr>
        <?php while ($reservation = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $reservation['id']; ?></td>
                <td><?php echo $reservation['customer_name']; ?></td>
                <td><?php echo $reservation['car_model']; ?></td>
                <td><?php echo $reservation['reservation_date']; ?></td>
                <td><?php echo $reservation['return_date']; ?></td>
                <td><?php echo $reservation['status']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
