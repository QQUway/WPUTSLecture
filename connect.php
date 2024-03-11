<?php
    $servername = "localhost";
    $username = "root";
    $password = "@Rifqi001";
    $db_name = "uts_wp_login";
    $conn = new mysqli($servername, $username, $password, $db_name);

    if ($conn->connect_error) {
        die("code 0 : " . $conn->connect_error);
    }
    
    echo "code 1"; 
?>