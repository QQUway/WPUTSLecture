<?php
    // Check if user is logged in and is an admin, if not, redirect to login page
    if(!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="resource/css/navbar-footer.css">
</head>

<body>

    <div class="navbar">
        <a href="#">Home</a>
        <a href="#">Users</a>
        <a href="#">History</a>
        <a href="#">Log Out</a>
    </div>

    <div>
        <h2>Welcome admin!</h2>
        <p><a href="logout.php">Logout</a></p>
    </div>

</body>

</html>