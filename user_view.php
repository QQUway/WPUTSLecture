<?php
include('connect.php');

// Initialize $userId variable
$userId = "";

// Check if user_id is provided in the query string
if (isset($_GET['user_id'])) {
    // Sanitize the user ID to prevent SQL injection
    $userId = $_GET['user_id'];

    // Fetch user data from the database based on the user ID
    $sql = "SELECT * FROM nasabah WHERE nasabah_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Assign user data to variables
        $userName = $userData['Nama'];
        $userEmail = $userData['Email'];
        $userAddress = $userData['Alamat'];
        $userGender = $userData['Jenis_Kelamin'];
        $userDateOfBirth = $userData['Tanggal_Lahir'];

        // Close prepared statement
        $stmt->close();
    } else {
        // User with the provided ID does not exist
        $userName = "User not found";
        $userEmail = "";
        $userAddress = "";
        $userGender = "";
        $userDateOfBirth = "";
        // You can assign default values or handle this case as needed
    }
} else {
    // User ID is not provided in the query string
    $userName = "User ID not provided";
    $userEmail = "";
    $userAddress = "";
    $userGender = "";
    $userDateOfBirth = "";
    // You can assign default values or handle this case as needed
}


// Fetch transaction data for the user from the transaction_data table
$sqlTransactions = "SELECT * FROM transaction_data WHERE nasabah_id = ?";
$stmtTransactions = $conn->prepare($sqlTransactions);
$stmtTransactions->bind_param("i", $userId);
$stmtTransactions->execute();
$resultTransactions = $stmtTransactions->get_result();
$stmtTransactions->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="resource/css/navbar-footer.css">
    <title>User Details</title>
</head>

<body>
    <div class="navbar">
        <a href="admin_home.php">Home</a>
        <a href="users.php">Users</a>
        <a href="logout.php">Log Out</a>
    </div>

    <h1>User Details</h1>

    <table>
        <tr>
            <th>User ID</th>
            <td><?php echo $userId; ?></td>
        </tr>
        <tr>
            <th>Name</th>
            <td><?php echo $userName; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $userEmail; ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?php echo $userAddress; ?></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td><?php echo $userGender; ?></td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td><?php echo $userDateOfBirth; ?></td>
        </tr>
    </table>

    <h2>Pending Transactions</h2>

    <?php
    // Fetch pending transactions for the user
    $pendingQuery = $conn->prepare("SELECT * FROM transaction_data WHERE nasabah_id = ? AND status = 'pending'");
    $pendingQuery->bind_param("i", $userId);
    $pendingQuery->execute();
    $pendingResult = $pendingQuery->get_result();
    ?>

    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Proof</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $pendingResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['transaction_id'] . "</td>";
                echo "<td>" . $row['amount'] . "</td>";
                echo "<td>" . $row['kategori'] . "</td>";
                echo "<td><a href='" . 'resource/data/' . $row['file_upload_transaction_image_proof'] . "' target='_blank'>View</a></td>";
                echo "<td>" . $row['tanggal_transfer'] . "</td>";
                echo "<td><a href='confirm_transaction.php?transaction_id=" . $row['transaction_id'] . "'>Confirm</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; 2024 KDHH Koperasi. All rights reserved.</p>
    </div>
</body>

</html>