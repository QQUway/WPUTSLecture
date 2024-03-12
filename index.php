<?php
    include("connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="resource/css/style.css">
</head>
<body>

<div class="login-container">
    <h2>Login Form cuy</h2>
    <form name="form" action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="user" name="username" required></br></br>

        <label for="password">Password:</label>
        <input type="password" id="pass" name="pass" required>
        </br></br>
        <input type="submit" id="btn" value="Login" name="submit">
    </form>
</div>

</body>
</html>
