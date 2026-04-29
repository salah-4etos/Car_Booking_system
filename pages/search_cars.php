<?php
include('../includes/db_connection.php');

$search = '';
if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
}

$sql = "SELECT * FROM cars WHERE status = 'active' AND (model LIKE '%$search%' OR year LIKE '%$search%' OR plate_id LIKE '%$search%' OR office_location LIKE '%$search%')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Cars</title>
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
    <h1>Search Available Cars</h1>
    <form method="POST" action="">
        <input type="text" name="search" id="searchInput" placeholder="Search for cars.." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>
    <table id="carsTable" border="1">
        <tr>
            <th>ID</th>
            <th>Model</th>
            <th>Year</th>
            <th>Plate ID</th>
            <th>Office Location</th>
        </tr>
        <?php while ($car = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($car['id']); ?></td>
                <td><?php echo htmlspecialchars($car['model']); ?></td>
                <td><?php echo htmlspecialchars($car['year']); ?></td>
                <td><?php echo htmlspecialchars($car['plate_id']); ?></td>
                <td><?php echo htmlspecialchars($car['office_location']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
