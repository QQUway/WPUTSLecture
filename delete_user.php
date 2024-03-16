<?php
include "connect.php"; // Include your PHP connection script
// Check if user is logged in and is an admin, if not, redirect to login page
if(!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Check if user_id is set in the query string
if (isset($_GET['user_id'])) {
    // Sanitize the user ID to prevent SQL injection
    $userId = $_GET['user_id'];

    // Prepare a DELETE statement to delete the user from the nasabah table
    $sqlNasabah = "DELETE FROM nasabah WHERE nasabah_id = ?";
    $stmtNasabah = $conn->prepare($sqlNasabah);

    // Prepare a DELETE statement to delete the user from the user table
    $sqlUser = "DELETE FROM user WHERE id = ?";
    $stmtUser = $conn->prepare($sqlUser);

    if ($stmtNasabah && $stmtUser) {
        // Bind the parameter to the prepared statement
        $stmtNasabah->bind_param("i", $userId);
        $stmtUser->bind_param("i", $userId);

        // Execute the prepared statements
        if ($stmtNasabah->execute() && $stmtUser->execute()) {
            // User deleted successfully from both tables
            echo "User deleted successfully from both tables.";
        } else {
            // Error occurred while executing the statement
            echo "Error deleting user: " . $stmtNasabah->error . " " . $stmtUser->error;
        }

        // Close the prepared statements
        $stmtNasabah->close();
        $stmtUser->close();
    } else {
        // Error occurred while preparing the statements
        echo "Error preparing statements: " . $conn->error;
    }
} else {
    // User ID is not provided in the query string
    echo "User ID is not provided.";
}

// Close the database connection
$conn->close();
?>
