<?php
include('../includes/db_connection.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../index.php');
    exit;
}

// Fetch reports based on the selected option
$reservations = [];
$cars_status = [];
$customer_reservations = [];
$payments = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $report_type = $_POST['report_type'];

    if ($report_type === 'reservations') {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $sql = "SELECT reservations.id, customers.name AS customer_name, cars.model AS car_model, reservations.reservation_date, reservations.return_date, reservations.status 
                FROM reservations 
                JOIN customers ON reservations.customer_id = customers.id 
                JOIN cars ON reservations.car_id = cars.id 
                WHERE reservations.reservation_date BETWEEN '$start_date' AND '$end_date'";
        $reservations = $conn->query($sql);
    } elseif ($report_type === 'cars_status') {
        $date = $_POST['specific_date'];

        $sql = "SELECT * FROM cars";
        $cars_status = $conn->query($sql);
    } elseif ($report_type === 'customer_reservations') {
        $customer_id = $_POST['customer_id'];

        $sql = "SELECT reservations.id, cars.model AS car_model, cars.plate_id, reservations.reservation_date, reservations.return_date 
                FROM reservations 
                JOIN cars ON reservations.car_id = cars.id 
                WHERE reservations.customer_id = '$customer_id'";
        $customer_reservations = $conn->query($sql);
    } elseif ($report_type === 'daily_payments') {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $sql = "SELECT reservations.id, payments.amount, payments.payment_date, customers.name AS customer_name 
                FROM payments 
                JOIN reservations ON payments.reservation_id = reservations.id 
                JOIN customers ON reservations.customer_id = customers.id 
                WHERE payments.payment_date BETWEEN '$start_date' AND '$end_date'";
        $payments = $conn->query($sql);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
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
    <h1>Reports</h1>

    <form method="POST">
        <label>Select Report Type:</label>
        <select name="report_type" required>
            <option value="reservations">Reservations (within a period)</option>
            <option value="cars_status">Cars Status (specific day)</option>
            <option value="customer_reservations">Customer Reservations</option>
            <option value="daily_payments">Daily Payments (within a period)</option>
        </select>
        <br><br>

        <!-- Input fields based on selected report -->
        <div id="date_range">
            <label>Start Date:</label>
            <input type="date" name="start_date">
            <label>End Date:</label>
            <input type="date" name="end_date">
        </div>

        <div id="specific_date">
            <label>Date:</label>
            <input type="date" name="specific_date">
        </div>

        <div id="customer_id">
            <label>Customer ID:</label>
            <input type="text" name="customer_id">
        </div>

        <button type="submit">Generate Report</button>
    </form>

    <hr>

    <!-- Display Reports -->
    <?php if ($reservations): ?>
        <h2>Reservations Report</h2>
        <table border="1">
            <tr>
                <th>Reservation ID</th>
                <th>Customer Name</th>
                <th>Car Model</th>
                <th>Reservation Date</th>
                <th>Return Date</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $reservations->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['car_model']; ?></td>
                    <td><?php echo $row['reservation_date']; ?></td>
                    <td><?php echo $row['return_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <?php if ($cars_status): ?>
        <h2>Cars Status Report</h2>
        <table border="1">
            <tr>
                <th>Car ID</th>
                <th>Model</th>
                <th>Year</th>
                <th>Plate ID</th>
                <th>Status</th>
                <th>Office Location</th>
            </tr>
            <?php while ($row = $cars_status->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['model']; ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td><?php echo $row['plate_id']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['office_location']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <?php if ($customer_reservations): ?>
        <h2>Customer Reservations Report</h2>
        <table border="1">
            <tr>
                <th>Reservation ID</th>
                <th>Car Model</th>
                <th>Plate ID</th>
                <th>Reservation Date</th>
                <th>Return Date</th>
            </tr>
            <?php while ($row = $customer_reservations->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['car_model']; ?></td>
                    <td><?php echo $row['plate_id']; ?></td>
                    <td><?php echo $row['reservation_date']; ?></td>
                    <td><?php echo $row['return_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <?php if ($payments): ?>
        <h2>Daily Payments Report</h2>
        <table border="1">
            <tr>
                <th>Reservation ID</th>
                <th>Customer Name</th>
                <th>Amount</th>
                <th>Payment Date</th>
            </tr>
            <?php while ($row = $payments->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['payment_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
</body>
</html>
