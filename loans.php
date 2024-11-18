<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Add Loan
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];
    $sql = "INSERT INTO loans (name, amount, type) VALUES ('$name', '$amount', '$type')";
    $conn->query($sql);
}

// Update Loan Amount
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $amount = $_POST['amount'];
    $conn->query("UPDATE loans SET amount='$amount' WHERE id='$id'");
}

// Delete Loan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM loans WHERE id='$id'");
}

$loans = $conn->query("SELECT * FROM loans ORDER BY date_added DESC");

// total borrowed and lent amount
$totalLent = $conn->query("SELECT SUM(amount) AS total FROM loans WHERE type='lent'")->fetch_assoc()['total'];
$totalBorrowed = $conn->query("SELECT SUM(amount) AS total FROM loans WHERE type='borrowed'")->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Loans Management</title>
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
<body class="bg-gray-100 p-6 m-10 max-w-5xl mx-auto rounded-xl shadow-xl outline outline-offset-2 outline-1">
    <div class="">
        <a href="index.php">
        <h2 class="text-3xl font-bold mb-4">Loans</h2>
        </a>
        <form method="POST" class="mb-6">
            <section class="grid md:grid-cols-1 lg:grid-cols-4 gap-5">
                <div>
                    <input type="text" name="name" placeholder="Name" class="input input-bordered mr-2 w-full">
                </div>
                <div>
                    <input type="number" step="0.01" name="amount" placeholder="Amount" class="input input-bordered mr-2 w-full">
                </div>
                <div>
                    <select name="type" class="select select-bordered mr-2 w-full">
                        <option value="lent">Lent</option>
                        <option value="borrowed">Borrowed</option>
                    </select>
                </div>
                <div>
                    <button type="submit" name="add" class="btn btn-primary w-full">Add</button>
                </div>
            </section>
        </form>

        <table class="table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr>
                    <th class="text-left px-6 py-3">Name</th>
                    <th class="text-left px-6 py-3">Amount</th>
                    <th class="text-left px-6 py-3">Type</th>
                    <th class="text-left px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $loans->fetch_assoc()) { ?>
                    <tr>
                        <td class="text-left px-6 py-3"><?php echo $row['name']; ?></td>
                        <!-- Editable amount field -->
                        <form method="POST" class="text-left px-6 py-3">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <td class="text-left px-6 py-3">
                                <input type="number" step="0.01" name="amount" value="<?php echo $row['amount']; ?>" class="input input-bordered w-full">
                            </td>
                            <td class="text-left px-6 py-3"><?php echo $row['type']; ?></td>
                            <td class="text-left px-6 py-3">
                                <button type="submit" name="update" class="btn btn-sm btn-primary">Update</button>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-error">Delete</a>
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- Total Borrowed and Lent Amounts -->
        <div class="mt-4">
            <h3 class="text-xl font-bold">Total Lent: <?php echo number_format($totalLent); ?></h3>
            <h3 class="text-xl font-bold">Total Borrowed: <?php echo number_format($totalBorrowed); ?></h3>
        </div>
    </div>
</body>
</html>
