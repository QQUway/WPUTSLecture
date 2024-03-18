<?php
include('connect.php');
// Check if user is logged in and is an admin, if not, redirect to login page
if (!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
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

// Fetch transaction history for the user
$historyQuery = $conn->prepare("SELECT * FROM transaction_data WHERE nasabah_id = ?");
$historyQuery->bind_param("i", $userId);
$historyQuery->execute();
$historyResult = $historyQuery->get_result();
$historyQuery->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="resource/css/navbar-footer.css">
    <link rel="stylesheet" type="text/css" href="resource/css/style.css">
    <title>User Details</title>

    <style>
    .container {
        width: 80%;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

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
        <a href="admin_home.php">Home</a>
        <a href="users.php">Users</a>
        <a href="logout.php">Log Out</a>
    </div>
    <div class="container">
        <h1>User Details</h1>

        <table>
            <tr>
                <th style="width: 20%;">User ID</th>
                <td style="width: 80%;"><?php echo $userId; ?></td>
            </tr>
            <tr>
                <th style="width: 20%;">Name</th>
                <td style="width: 80%;"><?php echo $userName; ?></td>
            </tr>
            <tr>
                <th style="width: 20%;">Email</th>
                <td style="width: 80%;"><?php echo $userEmail; ?></td>
            </tr>
            <tr>
                <th style="width: 20%;">Address</th>
                <td style="width: 80%;"><?php echo $userAddress; ?></td>
            </tr>
            <tr>
                <th style="width: 20%;">Gender</th>
                <td style="width: 80%;"><?php echo $userGender; ?></td>
            </tr>
            <tr>
                <th style="width: 20%;">Date of Birth</th>
                <td style="width: 80%;"><?php echo $userDateOfBirth; ?></td>
            </tr>
        </table>

        <h2>Transaction History</h2>

        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">Transaction ID</th>
                    <th style="width: 10%;">Amount</th>
                    <th style="width: 15%;">Category</th>
                    <th style="width: 15%;">Proof</th>
                    <th style="width: 15%;">Date</th>
                    <th style="width: 15%;">Status</th>
                    <th style="width: 10%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $historyResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['transaction_id'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['kategori'] . "</td>";
                    echo "<td><a href='" . 'resource/data/' . $row['file_upload_transaction_image_proof'] . "' target='_blank'>View</a></td>";
                    echo "<td>" . $row['tanggal_transfer'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    // Add confirm action only if the transaction status is pending
                    if ($row['status'] === 'pending') {
                        echo "<td><a href='confirm_transaction.php?transaction_id=" . $row['transaction_id'] . "'>Confirm</a></td>";
                    } else {
                        echo "<td></td>"; // Empty cell for non-pending transactions
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>