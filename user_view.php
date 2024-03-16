<?php
<<<<<<< Updated upstream
include('connect.php');

=======
>>>>>>> Stashed changes
// Check if user is logged in and is an admin, if not, redirect to login page
if(!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    header("Location: index.php");
    exit;
<<<<<<< Updated upstream
}


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
=======
>>>>>>> Stashed changes
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="resource/css/navbar-footer.css">
    <title>Users List</title>
</head>

<body>
    <div class="navbar">
            <a href="admin_home.php">Home</a>
            <a href="users.php">Users</a>
            <a href="logout.php">Log Out</a>
    </div>

    <h1>User List</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Name</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Pending Transactions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "connect.php";

            // Fetch data from the nasabah table
            $sql = "SELECT nasabah_id, Email, Nama, Alamat, Jenis_Kelamin, Tanggal_Lahir FROM nasabah";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nasabah_id"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["Nama"] . "</td>";
                    echo "<td>" . $row["Alamat"] . "</td>";
                    echo "<td>" . $row["Jenis_Kelamin"] . "</td>";
                    echo "<td>" . $row["Tanggal_Lahir"] . "</td>";

                    // Fetch pending transactions for the current user
                    $pendingQuery = $conn->prepare("SELECT transaction_id FROM transaction_data WHERE nasabah_id = ? AND status = 'pending'");
                    $pendingQuery->bind_param("i", $row['nasabah_id']);
                    $pendingQuery->execute();
                    $pendingResult = $pendingQuery->get_result();
                    $numPending = $pendingResult->num_rows;

                    echo "<td>";
                    if ($numPending > 0) {
                        echo "<a href='pending_transactions.php?nasabah_id=" . $row['nasabah_id'] . "'>View Pending Transactions</a>";
                    } else {
                        echo "No Pending Transactions";
                    }
                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No users found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; 2024 KDHH Koperasi. All rights reserved.</p>
    </div>

    <script>
        function confirmDelete(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "delete_user.php?user_id=" + userId;
            }
        }


        function viewProfile(userId) {
            window.location.href = "user_view.php?user_id=" + userId;
        }
    </script>
</body>

</html>
