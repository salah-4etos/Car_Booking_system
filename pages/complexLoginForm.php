<?php
include('../includes/db_connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $customer_query = "SELECT * FROM customers WHERE email = '$email' AND password = '$password'";
    $customer_result = $conn->query($customer_query);

    $admin_query = "SELECT * FROM admins WHERE email = '$email' AND password = '$password'";
    $admin_result = $conn->query($admin_query);

    if ($customer_result->num_rows === 1) {
        $customer = $customer_result->fetch_assoc();
        $_SESSION['user_id'] = $customer['id'];
        header('Location: ../index.php');
        exit;
    } elseif ($admin_result->num_rows === 1) {
        $admin = $admin_result->fetch_assoc();
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: ../index.php');
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Login</h1>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Login</button>
        <p class="or">
            --------- OR ---------
        </p>
        <p class="text-center">Don`t have account? <a href="registerForm.php" id="BtnRegister">Regiester</a></p>
    </form>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
