<?php
include "connect.php"; // Include your PHP connection script

// Check if user_id is set in the query string
if (isset($_GET['user_id'])) {
    // Sanitize the user ID to prevent SQL injection
    $userId = $_GET['user_id'];

    // Prepare a DELETE statement to delete the user from the database
    $sql = "DELETE FROM nasabah WHERE nasabah_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the parameter to the prepared statement
        $stmt->bind_param("i", $userId);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // User deleted successfully
            echo "User deleted successfully.";
        } else {
            // Error occurred while executing the statement
            echo "Error deleting user: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Error occurred while preparing the statement
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    // User ID is not provided in the query string
    echo "User ID is not provided.";
}

// Close the database connection
$conn->close();
