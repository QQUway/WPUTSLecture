<?php
include("connect.php");

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

    <div class="container">
        <section class="hero">
            <div class="hero-content">
                <h1>Welcome to Our System</h1>
                <p>We provide innovative solutions for your financial needs.</p>

            </div>
        </section>
    </div>


    <section id="about" class="about">

        <div class="container">
            <h2>About Us</h2>
            <p>KDHH Koperasi adalah sebuah organisasi koperasi yang berperan penting dalam memajukan kesejahteraan anggotanya di masyarakat. 
                Sebagai wadah bagi para anggota, KDHH Koperasi memberikan berbagai layanan yang bertujuan untuk meningkatkan kualitas hidup dan ekonomi mereka. 
                Salah satu layanan utama yang ditawarkan adalah pembayaran wajib dan sukarela.</p>
            <p>Pembayaran wajib merupakan kontribusi rutin yang harus dibayarkan oleh setiap anggota KDHH Koperasi sesuai dengan ketentuan yang telah ditetapkan. 
                Pembayaran ini penting untuk membiayai berbagai program dan kegiatan yang dilaksanakan oleh koperasi guna meningkatkan kesejahteraan anggotanya secara kolektif. 
                Selain itu, anggota juga dapat melakukan pembayaran sukarela sebagai bentuk dukungan tambahan bagi keberlangsungan operasional KDHH Koperasi. 
                Pembayaran sukarela ini dapat dilakukan secara fleksibel sesuai dengan kemampuan finansial masing-masing anggota, namun memiliki dampak yang signifikan dalam memperkuat fondasi koperasi dan meningkatkan manfaat yang diberikan kepada seluruh anggota. 
                Dengan partisipasi aktif dalam pembayaran wajib dan sukarela, anggota KDHH Koperasi turut berperan dalam membangun masa depan yang lebih cerah bagi diri mereka sendiri serta komunitas sekitar.</p>
        </div>
    </section>

    <section class="balances">
        <div class="container">
            <h2>Your Balances</h2>
            <?php
            include "connect.php";

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

    <section class="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <p>If you have any questions, feel free to contact us.</p>
            <a href="mailto:contact@kdhh-koperasi.com" class="btn" style="color: #e88eed;">Contact</a>
        </div>
    </section>
   
</body>

</html>