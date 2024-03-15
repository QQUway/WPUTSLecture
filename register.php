<?php
include("connect.php");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    // Handle file upload
    $targetDir = "resource/data/";
    $targetFile = $targetDir . basename($_FILES["bukti_transfer"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["bukti_transfer"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["bukti_transfer"]["size"] > 500000) {
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
        if (move_uploaded_file($_FILES["bukti_transfer"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["bukti_transfer"]["name"])) . " has been uploaded.";

            // Check if the username already exists
            $checkQuery = $conn->prepare("SELECT COUNT(*) as count FROM user WHERE username = ?");
            $checkQuery->bind_param("s", $username);
            $checkQuery->execute();
            $result = $checkQuery->get_result();
            $row = $result->fetch_assoc();

            if ($row['count'] > 0) {
                // Username already exists
                echo '<script>
                    alert("Username already exists. Please choose a different username.");
                    window.location.href = "register.php";
                </script>';
                exit;
            }

            // Fetch the number of entries in the user table
            $countResult = $conn->query("SELECT COUNT(*) as count FROM user");
            $countRow = $countResult->fetch_assoc();
            $count = $countRow['count'];

            // Assign an ID (assuming the ID is an integer with a maximum length of 4)
            $newId = ($count < 9999) ? $count + 1 : 1;

            // Use prepared statement to prevent SQL injection
            $userInsertStmt = $conn->prepare("INSERT INTO user (id, username, password) VALUES (?, ?, ?)");
            $userInsertStmt->bind_param("iss", $newId, $username, $password);

            // Execute the user insertion statement
            $userInsertStmt->execute();

            // Insert nasabah data with the uploaded file name
            $nasabahInsertStmt = $conn->prepare("INSERT INTO nasabah (user_id, Email, Nama, Alamat, Jenis_Kelamin, Tanggal_Lahir, Upload_File_Bukti_Pembayaran_Bayaran_Simpanan_Pokok) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $nasabahInsertStmt->bind_param("issssss", $newId, $email, $nama, $alamat, $jenis_kelamin, $tanggal_lahir, basename($_FILES["bukti_transfer"]["name"]));

            // Execute the nasabah insertion statement
            $nasabahInsertStmt->execute();

            // Close the statements
            $userInsertStmt->close();
            $nasabahInsertStmt->close();

            echo "Registration successful! Your ID is: " . sprintf('%04d', $newId);
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
    <title>Registration Form</title>
    <link rel="stylesheet" type="text/css" href="resource/css/style.css">
</head>
<body>

<div class="login-container">
    <h2>Registration Form</h2>
    <form name="form" action="register.php" method="post" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" id="user" name="username" required></br></br>

        <label for="password">Password:</label>
        <input type="password" id="pass" name="password" required></br></br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required></br></br>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required></br></br>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" required></br></br>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select></br></br>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required></br></br>

        <label for="bukti_transfer">Upload File Bukti Pembayaran Simpanan Pokok:</label>
        <input type="file" id="bukti_transfer" name="bukti_transfer" required></br></br>

        <input type="submit" id="btn" value="Register" name="submit">
    </form>
</div>

</body>
</html>
