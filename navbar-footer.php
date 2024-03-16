<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        /* Change font family to sans-serif */
    }

    .navbar {
        overflow: hidden;
        background-color: #333;
    }

    .navbar a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 20px;
        text-decoration: none;
    }

    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }

    .footer {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #333;
        color: white;
        text-align: center;
        padding: 10px 0;
    }
</style>

<body>
    <div class="navbar">
        <a href="#">Home</a>
        <a href="#">Pembayaran</a>
        <a href="#">Profile</a>
        <a href="#">Log Out</a>
    </div>

    <div class="footer">
        <p>&copy; 2024 KDHH Koperasi. All rights reserved.</p>
    </div>
</body>

</html>