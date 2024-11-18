<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
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
<body class="mx-10">
    <section class="bg-gray-200 max-w-5xl mx-auto m-11 p-6 mt-10 rounded-lg drop-shadow-2xl outline outline-offset-2 outline-1">
    <div class="container mx-auto mt-5 p-6">
        <div class="flex justify-between items-center">
           <a href="index.php"> <h2 class="text-3xl font-bold">দেনা পাওনা</h2></a>
            <a href="login.php" class="btn btn-error text-white">Logout</a>
        </div>
        <div class="my-10 grid grid-cols-1 gap-6">
            <a href="expenses.php" class="btn bg-gradient-to-r from-cyan-500 to-blue-500 w-auto h-16 cursor: pointer shadow-xl;">My Expenses</a>
            <a href="loans.php" class="btn bg-gradient-to-r from-green-500 to-green-700 w-auto h-16 cursor: pointer shadow-xl;">Manage Loans</a>
        </div>
    </div>
    </section>
</body>
</html>
