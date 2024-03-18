<?php
include("connect.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['pass'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $count = $result->num_rows;

    $stmt->close();

    if($count == 1){
        if (password_verify($password, $row['password'])) {
            setcookie("username", $username, time() + (86400 * 30), "/"); 

            $adminQuery = $conn->prepare("SELECT * FROM admin WHERE user_id = ?");
            $adminQuery->bind_param("i", $row['id']);
            $adminQuery->execute();
            $adminResult = $adminQuery->get_result();

            if($adminResult->num_rows > 0) {

                setcookie("role", "admin", time() + (86400 * 30), "/");
                header("Location: admin_home.php");
                exit;
            }

            $nasabahQuery = $conn->prepare("SELECT * FROM nasabah WHERE user_id = ?");
            $nasabahQuery->bind_param("i", $row['id']);
            $nasabahQuery->execute();
            $nasabahResult = $nasabahQuery->get_result();

            if($nasabahResult->num_rows > 0) {
                header("Location: nasabah_home.php");
                exit;
            }

            header("Location: index.php");
            exit;
        } 
        else {
            echo '<script>
                alert("Login failed. Incorrect password.");
                window.location.href = "index.php";
            </script>';
            exit;
        }
    } else {
        echo '<script>
            alert("Login failed. User not found.");
            window.location.href = "index.php";
        </script>';
        exit;
    }
}
?>
