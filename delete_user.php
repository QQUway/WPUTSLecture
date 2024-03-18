<?php
include "connect.php"; 
if(!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    $sqlNasabah = "DELETE FROM nasabah WHERE nasabah_id = ?";
    $stmtNasabah = $conn->prepare($sqlNasabah);

    $sqlUser = "DELETE FROM user WHERE id = ?";
    $stmtUser = $conn->prepare($sqlUser);

    if ($stmtNasabah && $stmtUser) {
        $stmtNasabah->bind_param("i", $userId);
        $stmtUser->bind_param("i", $userId);

        if ($stmtNasabah->execute() && $stmtUser->execute()) {
            echo "User deleted successfully from both tables.";
            header("Location: users.php");
        } else {
            echo "Error deleting user: " . $stmtNasabah->error . " " . $stmtUser->error;
        }

        $stmtNasabah->close();
        $stmtUser->close();
    } else {
        echo "Error preparing statements: " . $conn->error;
    }
} else {
    echo "User ID is not provided.";
}

$conn->close();
?>
