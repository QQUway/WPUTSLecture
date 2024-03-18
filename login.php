<?php
include("connect.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['pass'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the result
    $row = $result->fetch_assoc();
    $count = $result->num_rows;

    // Close the statement
    $stmt->close();

    if($count == 1){
        // Verify hashed password
        if (password_verify($password, $row['password'])) {
            // Set cookie to indicate the user is logged in
            setcookie("username", $username, time() + (86400 * 30), "/"); // 30 days expiration

            // Check if the user is an admin
            $adminQuery = $conn->prepare("SELECT * FROM admin WHERE user_id = ?");
            $adminQuery->bind_param("i", $row['id']);
            $adminQuery->execute();
            $adminResult = $adminQuery->get_result();

            if($adminResult->num_rows > 0) {
                // Set role cookie to 'admin'
                setcookie("role", "admin", time() + (86400 * 30), "/"); // 30 days expiration
                header("Location: admin_home.php");
                exit;
            }

            // Check if the user is a nasabah
            $nasabahQuery = $conn->prepare("SELECT * FROM nasabah WHERE user_id = ?");
            $nasabahQuery->bind_param("i", $row['id']);
            $nasabahQuery->execute();
            $nasabahResult = $nasabahQuery->get_result();

            if($nasabahResult->num_rows > 0) {
                header("Location: nasabah_home.php");
                exit;
            }

            // If the user is not an admin or nasabah, redirect to index.php
            header("Location: index.php");
            exit;
        } else {
            // Incorrect password
            echo '<script>
                alert("Login failed. Incorrect password.");
                window.location.href = "index.php";
            </script>';
            exit;
        }
    } else {
        // User not found
        echo '<script>
            alert("Login failed. User not found.");
            window.location.href = "index.php";
        </script>';
        exit;
    }
}
?>
