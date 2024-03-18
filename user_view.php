<?php
include('connect.php');

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
        // You can fetch and assign other user data here

        // Close prepared statement
        $stmt->close();
    } else {
        // User with the provided ID does not exist
        $userName = "User not found";
        $userEmail = "";
        $userAddress = "";
        // You can assign default values or handle this case as needed
    }
} else {
    // User ID is not provided in the query string
    $userName = "User ID not provided";
    $userEmail = "";
    $userAddress = "";
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
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="resource/css/profile.css">
    <link rel="stylesheet" type="text/css" href="resource/css/navbar-footer.css">
</head>

<body>

    <div class="navbar">
        <a href="admin_home.php">Home</a>
        <a href="users.php">Users</a>
        <a href="history.php">History</a>
        <a href="logout.php">Log Out</a>
    </div>

    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-info">
            <div class="profile-photo-container">
                <img id="profile-img" src="default-profile-pic.jpg" alt="Profile Picture">
            </div>
            <div class="biodata">
                <label for="customer-name">Name:</label>
                <p id="customer-name"><?php echo $userName; ?></p>

                <label for="customer-email">Email:</label>
                <p id="customer-email"><?php echo $userEmail; ?></p>

                <label for="customer-address">Address:</label>
                <p id="customer-address"><?php echo $userAddress; ?></p>

            </div>
        </div>

        <div class="transaction-list">
            <h2>Transaction History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Proof</th> <!-- Add column for the view button -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $resultTransactions->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["transaction_id"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["kategori"] . "</td>";
                        echo "<td>" . $row["amount"] . "</td>";
                        // Add a view button to open the image in a new tab
                        echo "<td><a href='" . $row["file_upload_transaction_image_proof"] . "' target='_blank'>View</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>