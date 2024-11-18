<?php
session_start();
require 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: index.php");
    } else {
        echo "<script>alert('Invalid login credentials!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>

<!--font awesome-->
<script src="https://kit.fontawesome.com/5ed21b9157.js" crossorigin="anonymous"></script>

<!--daisy UI & tailwind-->
<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.tailwindcss.com"></script>

<style>
.font-manrope{
    font-family: 'Manrope', sans-serif;
}
</style>
</head>
<body class="max-w-3xl mx-auto m-16 bg-gray-100">
    <div class="p-6 bg-white shadow-lg rounded-xl ">
        <h2 class="text-2xl mb-4 text-center font-bold">Ridwanur Rahman Mazumder</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" class="input input-bordered w-full mb-4" required>
            <input type="password" name="password" placeholder="Password" class="input input-bordered w-full mb-4" required>
            <button type="submit" name="login" class="btn btn-primary w-full">Login</button>
        </form>
    </div>
</body>
</html>
