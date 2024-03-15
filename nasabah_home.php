<?php
    // Check if user is logged in, if not, redirect to login page
    if(!isset($_COOKIE['username'])) {
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
    <link rel="stylesheet" type="text/css" href="resource\css\nasabah.css">


</head>
<body>

<div>
    <h2>Welcome to the System!</h2>
    <iframe src="https://show.co/social-unlock/6cq55VMPFBC1WdFCXolYCc/widget" width="1920" height="1080" frameborder="0"></iframe>
    <h2><a href="logout.php">Logout</a></h2>
</div>

</body>
</html>
