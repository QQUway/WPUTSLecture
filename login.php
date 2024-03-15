<?php
include("connect.php");

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['pass'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the result
    $row = $result->fetch_assoc();
    $count = $result->num_rows;

    // Close the statement
    $stmt->close();

    if($count == 1){
        // Set cookie to indicate the user is logged in
        setcookie("username", $username, time() + (86400 * 30), "/"); // 30 days expiration

        // Check if the user is an admin
        $adminQuery = $conn->prepare("SELECT * FROM admin WHERE user_id = ?");
        $adminQuery->bind_param("i", $row['id']);
        $adminQuery->execute();
        $adminResult = $adminQuery->get_result();

        // Check if the user is a nasabah
        $nasabahQuery = $conn->prepare("SELECT * FROM nasabah WHERE user_id = ?");
        $nasabahQuery->bind_param("i", $row['id']);
        $nasabahQuery->execute();
        $nasabahResult = $nasabahQuery->get_result();

        if($adminResult->num_rows > 0) {
            header("Location: admin_home.php");
            exit;
        } elseif($nasabahResult->num_rows > 0) {
            header("Location: nasabah_home.php");
            exit;
        } else {
            // If the user is not an admin or nasabah, redirect to index.php
            header("Location: index.php");
            exit;
        }
    } else {
        echo '<script>
            alert("Login failed.");
            window.location.href = "index.php";
        </script>';
        exit;
    }
}
?>
