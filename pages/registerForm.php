<?php
include('../includes/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO customers (name, email, password, phone, address) 
            VALUES ('$name', '$email', '$password', '$phone', '$address')";

    if ($conn->query($sql)) {
        echo "Registration successful! You can now log in.";
        header("location:complexLoginForm.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
</head>
<body>
    <h1>Customer Registration</h1>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Phone:</label>
        <input type="text" name="phone" required><br>
        <label>Address:</label>
        <textarea name="address" required></textarea><br>
        <button type="submit">Register </button>
        <p class="or">
            --------- OR ---------
        </p>
        <p class="text-center"> Already have an account <a href="complexLoginForm.php" id="BtnRegister">Login Now</a></p>
    </form>
    <script src="index.js"></script>
</body>
</html>
