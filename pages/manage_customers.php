<?php
include('../includes/db_connection.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../index.php');
    exit;
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM customers WHERE id=$id");
}

// Fetch all customers
$result = $conn->query("SELECT * FROM customers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../style.css">
    <style>
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

        .hidden {
            display: none;
        }
    </style>
    <script>
        function showSection(sectionId) {
            document.getElementById('viewCustomersSection').classList.add('hidden');
            document.getElementById(sectionId).classList.remove('hidden');
        }
    </script>
</head>
<body>
    <h1>Manage Customers</h1>
    <button onclick="showSection('viewCustomersSection')">View All Customers</button>

    <div id="viewCustomersSection" class="hidden">
        <h2>All Customers</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
                
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>
</html>

<?php
$conn->close();
?>