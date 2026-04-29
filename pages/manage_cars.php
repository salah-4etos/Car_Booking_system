<?php
include('../includes/db_connection.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../index.php');
    exit;
}

// Handle adding a new car
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_car'])) {
    $model = $conn->real_escape_string($_POST['model']);
    $year = (int)$_POST['year'];
    $plate_id = $conn->real_escape_string($_POST['plate_id']);
    $status = $conn->real_escape_string($_POST['status']);
    $office_location = $conn->real_escape_string($_POST['office_location']);

    $sql = "INSERT INTO cars (model, year, plate_id, status, office_location) 
            VALUES ('$model', '$year', '$plate_id', '$status', '$office_location')";

    if ($conn->query($sql)) {
        echo "Car added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle updating car status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $car_id = (int)$_POST['car_id'];
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "UPDATE cars SET status = '$status' WHERE id = $car_id";

    if ($conn->query($sql)) {
        echo "Car status updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all cars
$search = '';
if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
}

$sql = "SELECT * FROM cars WHERE (model LIKE '%$search%' OR status LIKE '%$search' OR year LIKE '%$search%' OR plate_id LIKE '%$search%' OR office_location LIKE '%$search%')";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Cars</title>
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
            document.getElementById('addCarSection').classList.add('hidden');
            document.getElementById('viewCarsSection').classList.add('hidden');
            document.getElementById('editCarSection').classList.add('hidden');
            document.getElementById(sectionId).classList.remove('hidden');
        }
    </script>
</head>
<body>
    <h1>Manage Cars</h1>
    <form>
    <button onclick="showSection('addCarSection')">Add Car</button>
    </form>
    <form>
    <button onclick="showSection('viewCarsSection')">View All Cars</button>
    </form>
    <form>
    <button onclick="showSection('editCarSection')">Change Car Status</button>
    </form>    
    <div id="addCarSection" class="hidden">
        <h2>Add New Car</h2>
        <form method="POST" action="">
            <input type="hidden" name="add_car" value="1">
            <label>Model:</label>
            <input type="text" name="model" required><br>
            <label>Year:</label>
            <input type="number" name="year" required><br>
            <label>Plate ID:</label>
            <input type="text" name="plate_id" required><br>
            <label>Status:</label>
            <select name="status" required>
                <option value="active">Active</option>
                <option value="rented">Rented</option>
                <option value="out_of_service">Out of Service</option>
            </select><br>
            <label>Office Location:</label>
            <input type="text" name="office_location" required><br>
            <button type="submit">Add Car</button>
        </form>
    </div>

    <div id="viewCarsSection" >
        <h2>All Cars</h2>
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
            <th>status </th> 
            <th>Office Location</th>
        </tr>
        <?php while ($car = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($car['id']); ?></td>
                <td><?php echo htmlspecialchars($car['model']); ?></td>
                <td><?php echo htmlspecialchars($car['year']); ?></td>
                <td><?php echo htmlspecialchars($car['plate_id']); ?></td>
                <td><?php echo htmlspecialchars($car['status']); ?></td>
                <td><?php echo htmlspecialchars($car['office_location']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>

    <div id="editCarSection" class="hidden">
        <h2>Change Car Status</h2>
        <form method="POST" action="">
            <input type="hidden" name="update_status" value="1">
            <label for="car_id">Select Car:</label>
            <select name="car_id" id="car_id" required>
                <?php
                $sql = "SELECT id, model FROM cars";
                $cars = $conn->query($sql);
                while ($car = $cars->fetch_assoc()) {
                    echo "<option value='{$car['id']}'>{$car['model']}</option>";
                }
                ?>
            </select><br>
            <label for="status">New Status:</label>
            <select name="status" id="status" required>
                <option value="active">Active</option>
                <option value="rented">Rented</option>
                <option value="out_of_service">Out of Service</option>
            </select><br>
            <button type="submit">Change Status</button>
        </form>
    </div>
</body>
</html>