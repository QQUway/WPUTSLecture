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
            header("Location: welcome.php");
            exit;
        } else {
            echo '<script>
                alert("Login failed.");
                window.location.href = "index.php";
            </script>';
            exit;
        }
    }
?>
