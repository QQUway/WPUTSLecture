<?php
include("connect.php");

// Check if user is logged in, if not, redirect to login page
if (!isset($_COOKIE['username'])) {
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

    <link rel="stylesheet" type="text/css" href="resource/css/navbar-footer.css">

</head>

<body>

    <div class="navbar">
        <a href="nasabah_home.php">Home</a>
        <a href="transaction_page.php">Pembayaran</a>
        <a href="profile.php">Profile</a>
        <a href="nasabah_history.php">History</a>
        <a href="logout.php">Log Out</a>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Our System</h1>
            <p>We provide innovative solutions for your financial needs.</p>
            <a href="#about" class="btn">Learn More</a>
        </div>
    </section>


    <!-- About Us Section -->
    <section id="about" class="about">
        <div class="container">
            <h2>About Us</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam luctus dolor nec ex volutpat, a dapibus elit rutrum. Integer sed risus ut orci consequat consectetur. Nulla facilisi. Aliquam nec tortor a risus gravida varius.</p>
            <p>Nulla nec eros in libero dignissim gravida nec eget nunc. Curabitur quis lacus eget quam blandit vulputate a at erat. In ut dui non lorem consectetur auctor et at libero. Aliquam erat volutpat. Integer luctus augue at velit bibendum, vel sodales eros fermentum.</p>
        </div>
    </section>

    <!-- Display Balance Section -->
    <section class="balances">
        <div class="container">
            <h2>Your Balances</h2>
            <?php
            include "connect.php";
            
            // Fetch user's balances
            $username = $_COOKIE['username'];
            $query = "SELECT saldo, wajib, sukarela FROM nasabah INNER JOIN user ON nasabah.user_id = user.id WHERE user.username = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            ?>
            <p>Saldo: <?php echo $row['saldo']; ?></p>
            <p>Wajib: <?php echo $row['wajib']; ?></p>
            <p>Sukarela: <?php echo $row['sukarela']; ?></p>

        </div>
    </section>

    <!-- Contact Us Section -->
    <section class="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <p>If you have any questions, feel free to contact us.</p>
            <a href="contact.php" class="btn">Contact</a>
        </div>
    </section>


</body>

</html>