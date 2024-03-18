<?php
include("connect.php");

// Check if user is logged in, if not, redirect to login page
if (!isset($_COOKIE['username'])) {
    header("Location: index.php");
    exit;
}

// Fetch nasabah ID based on username
$username = $_COOKIE['username'];
$stmt = $conn->prepare("SELECT nasabah_id FROM nasabah WHERE user_id = (SELECT id FROM user WHERE username = ?)");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$nasabah_id = $row['nasabah_id'];
$stmt->close();

// Fetch transaction history for the nasabah
$historyQuery = $conn->prepare("SELECT tanggal_transfer, amount, kategori, status FROM transaction_data WHERE nasabah_id = ?");
$historyQuery->bind_param("i", $nasabah_id);
$historyQuery->execute();
$historyResult = $historyQuery->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nasabah History</title>
    <link rel="stylesheet" type="text/css" href="resource/css/style.css">
    <link rel="stylesheet" type="text/css" href="resource/css/navbar-footer.css">
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="nasabah_home.php">Home</a>
        <a href="transaction_page.php">Pembayaran</a>
        <a href="profile.php">Profile</a>
        <a href="nasabah_history.php">History</a>
        <a href="logout.php">Log Out</a>
    </div>
    <div class="login-container">

        <h2>Nasabah History</h2>
        <table>
            <tr>
                <th>Tanggal Transfer</th>
                <th>Jumlah Transfer</th>
                <th>Kategori Simpanan</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $historyResult->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['tanggal_transfer']; ?></td>
                <td><?php echo $row['amount']; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <a href="nasabah_home.php">Back to Nasabah Home</a>
    </div>
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Company Name. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>

<?php
$conn->close();
?>