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
    <link rel="stylesheet" type="text/css" href="resource/css/style.css">
</head>
<body>

<div class="admin_home" >
    <h2>Welcome admin!</h2>
    <h2><a href="users.php">users</a></h2>
    <h2><a href="logout.php">Logout</a></h2>
</div>

</body>
</html>
