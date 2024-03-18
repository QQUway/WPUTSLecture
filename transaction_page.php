<?php
include("connect.php");

// Check if user is logged in, if not, redirect to login page
if (!isset($_COOKIE['username'])) {
    header("Location: index.php");
    exit;
}

// Fetch nasabah ID based on username
$username = $_COOKIE['username'];
$stmt = $conn->prepare("SELECT nasabah_id FROM nasabah WHERE user_id = (SELECT id FROM user WHERE username = ?)");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$nasabah_id = $row['nasabah_id'];
$stmt->close();

// Handle transaction form submission
if (isset($_POST['submit'])) {
    $amount = $_POST['amount'];
    $kategori = $_POST['kategori'];
    $bukti_transfer = $_FILES['bukti_transfer'];
    $tanggal_transfer = date("Y-m-d"); // Get current date

    // Handle file upload
    $targetDir = "resource/data/";
    $targetFile = $targetDir . basename($bukti_transfer["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($bukti_transfer["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($bukti_transfer["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($bukti_transfer["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($bukti_transfer["name"])) . " has been uploaded.";

            // Get the basename separately
            $filename = basename($bukti_transfer["name"]);

            // Insert the transaction data into the database with current date
            $insertStmt = $conn->prepare("INSERT INTO transaction_data (nasabah_id, kategori, amount, file_upload_transaction_image_proof, status, tanggal_transfer) VALUES (?, ?, ?, ?, 'pending', ?)");
            $insertStmt->bind_param("issss", $nasabah_id, $kategori, $amount, $filename, $tanggal_transfer);
            $insertStmt->execute();
            $insertStmt->close();

            // Redirect to the transaction history page
            // Remove or comment out debugging output before the header() function call
            // header("Location: nasabah_history.php");
            // exit;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Page</title>
    <link rel="stylesheet" type="text/css" href="resource/css/style.css">
    <link rel="stylesheet" type="text/css" href="resource/css/profile.css">
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
<div class="login-container">
    <h2>Perform Transaction</h2>
    <form action="transaction_page.php" method="post" enctype="multipart/form-data">
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required><br><br>

        <label for="kategori">Kategori Simpanan:</label>
        <select id="kategori" name="kategori" required>
            <option value="Wajib">Wajib</option>
            <option value="Sukarela">Sukarela</option>
        </select><br><br>

        <label for="bukti_transfer">Upload Bukti Transfer:</label>
        <input type="file" id="bukti_transfer" name="bukti_transfer" required><br><br>

        <input type="submit" id="submit" name="submit" value="Submit">
    </form>
    <br>
    <a href="nasabah_home.php">Back to Nasabah Home</a>
</div>
<footer class="footer">
    <div class="container">
        <p>&copy; 2024 Company Name. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
