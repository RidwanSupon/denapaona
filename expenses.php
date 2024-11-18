<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Add Expense
if (isset($_POST['add'])) {
    $product = $_POST['product'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $sql = "INSERT INTO expenses (product, price, date_added) VALUES ('$product', '$price', '$date')";
    $conn->query($sql);
}

// Edit Expense
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $new_price = $_POST['price'];
    $conn->query("UPDATE expenses SET price='$new_price' WHERE id='$id'");
}

// Delete Expense
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM expenses WHERE id='$id'");
}

$expenses = $conn->query("SELECT * FROM expenses ORDER BY date_added DESC");

$expenses = $conn->query("SELECT * FROM expenses ORDER BY date_added DESC");

// Calculate total expense
$total_expense = 0;
while ($row = $expenses->fetch_assoc()) {
    $total_expense += $row['price'];
}

// Reset the pointer back to the beginning for displaying in the table
$expenses->data_seek(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Expenses</title>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/5ed21b9157.js" crossorigin="anonymous"></script>
    <!-- Daisy UI & Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .font-manrope {
            font-family: 'Manrope', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 m-10 rounded-xl shadow-lg max-w-5xl mx-auto outline outline-offset-2 outline-1">
    <div class="container mx-auto p-6 ">
        <a href="index.php">
        <h2 class="text-2xl font-bold mb-4">My Expenses</h2>
        </a>
        <form method="POST" class="mb-6 grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div>
                <input type="text" name="product" placeholder="Product Name" class="input input-bordered mr-2 w-full">
            </div>
            <div>
                <input type="number" step="0.01" name="price" placeholder="Price" class="input input-bordered mr-2 w-full">
            </div>
            <div>
                <input type="date" name="date" class="input input-bordered mr-2 w-full text-xl">
            </div>
            <div>
                <button type="submit" name="add" class="btn btn-primary w-full">Add</button>
            </div>
        </form>

        <table class="table-auto w-full bg-white shadow-md rounded-lg">
            <thead>
                <tr>
                    <th class="text-left px-6 py-3">Product</th>
                    <th class="text-left px-6 py-3">Price</th>
                    <th class="text-left px-6 py-3">Date</th>
                    <th class="text-left px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $expenses->fetch_assoc()) { ?>
                    <tr>
                        <td class="text-left px-6 py-3"><?php echo $row['product']; ?></td>
                        <form method="POST">
                            <td class="text-left px-6 py-3">
                                <input type="number" step="1" name="price" value="<?php echo $row['price']; ?>" class="input input-bordered w-20">
                            </td>
                            <td class="text-left px-6 py-3"><?php echo $row['date_added']; ?></td>
                            <td class="text-left px-6 py-3">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="edit" class="btn btn-sm btn-primary">Update</button>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-error">Delete</a>
                            </td>
                        </form>
                    </tr>
                    
                <?php } ?>
                <tr class="flex flex-row">
                    <td colspan="3" class="text-left px-6 py-3 font-bold">Total Expense</td>
                    <td class="text-left px-6 py-3 font-bold"><?php echo number_format($total_expense); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
