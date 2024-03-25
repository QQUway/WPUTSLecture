<?php
if (!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['nasabah_id'])) {
    header("Location: users.php");
    exit;
}

$nasabah_id = $_GET['nasabah_id'];

include "connect.php";

$userQuery = $conn->prepare("SELECT * FROM nasabah WHERE nasabah_id = ?");
$userQuery->bind_param("i", $nasabah_id);
$userQuery->execute();
$userResult = $userQuery->get_result();
$userData = $userResult->fetch_assoc();

$pendingQuery = $conn->prepare("SELECT * FROM transaction_data WHERE nasabah_id = ? AND status = 'pending'");
$pendingQuery->bind_param("i", $nasabah_id);
$pendingQuery->execute();
$pendingResult = $pendingQuery->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="resource/css/navbar-footer.css">
    <title>Pending Transactions</title>
</head>

<body>
    <div class="navbar">
        <a href="admin_home.php">Home</a>
        <a href="users.php">Users</a>
        <a href="logout.php">Log Out</a>
    </div>

    <h1>Pending Transactions for <?php echo $userData['Nama']; ?></h1>

    <?php if ($pendingResult->num_rows > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Kategori</th>
                    <th>Bukti Transfer</th>
                    <th>Tanggal Transfer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($transaction = $pendingResult->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $transaction['transaction_id']; ?></td>
                        <td><?php echo $transaction['amount']; ?></td>
                        <td><?php echo $transaction['kategori']; ?></td>
                        <td><a href="<?php echo $transaction['file_upload_transaction_image_proof']; ?>" target="_blank">View</a></td>
                        <td><?php echo $transaction['tanggal_transfer']; ?></td>
                        <td><a href="confirm_transaction.php?transaction_id=<?php echo $transaction['transaction_id']; ?>">Confirm</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No pending transactions for this user.</p>
    <?php endif; ?>

    <div class="footer">
        <p>&copy; 2024 KDHH Koperasi. All rights reserved.</p>
    </div>
</body>

</html>
