<?php
include("connect.php");

if (!isset($_COOKIE['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_COOKIE['username'];
$stmt = $conn->prepare("SELECT nasabah_id FROM nasabah WHERE user_id = (SELECT id FROM user WHERE username = ?)");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$nasabah_id = $row['nasabah_id'];
$stmt->close();

$userQuery = $conn->prepare("SELECT Nama, Email, Alamat FROM nasabah WHERE nasabah_id = ?");
$userQuery->bind_param("i", $nasabah_id);
$userQuery->execute();
$userResult = $userQuery->get_result();
$userData = $userResult->fetch_assoc();
$userQuery->close();

$userName = $userData['Nama'];
$userEmail = $userData['Email'];
$userAddress = $userData['Alamat'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" type="text/css" href="resource/css/profile.css">
    <link rel="stylesheet" type="text/css" href="resource/css/navbar-footer.css">
    <style>
    .profile-info {
        margin-left: 20px;
    }
    </style>
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
        <h1>Customer Profile</h1>
        <div class="profile-info">
            <div class="profile-photo-container">
                <img id="profile-img" src="default-profile-pic.jpg" alt="Profile Picture">
            </div>
            <div class="biodata">
                <label for="customer-name">Name:</label>
                <p id="customer-name"><?php echo $userName; ?></p>

                <label for="customer-email">Email:</label>
                <p id="customer-email"><?php echo $userEmail; ?></p>

                <label for="customer-address">Address:</label>
                <p id="customer-address"><?php echo $userAddress; ?></p>
            </div>
        </div>

        <div class="form-container">
            <h2>Update User Data</h2>
            <form id="update-form">
                <label for="update-name">Name:</label>
                <input type="text" id="update-name" name="update-name" placeholder="Enter new name">

                <label for="update-email">Email:</label>
                <input type="email" id="update-email" name="update-email" placeholder="Enter new email">

                <label for="update-address">Address:</label>
                <input type="text" id="update-address" name="update-address" placeholder="Enter new address">

                <input type="submit" value="Update">
            </form>
        </div>

        <div class="form-container">
            <h2>Change Profile Photo</h2>
            <form id="photo-form">
                <input type="file" id="profile-photo" name="profile-photo">
                <input type="submit" value="Upload">
            </form>
        </div>

        <div class="form-container">
            <h2>Reset Password</h2>
            <form id="password-form">
                <label for="current-password">Current Password:</label>
                <input type="password" id="current-password" name="current-password"
                    placeholder="Enter current password">

                <label for="new-password">New Password:</label>
                <input type="password" id="new-password" name="new-password" placeholder="Enter new password">

                <label for="confirm-password">Confirm New Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password">

                <input type="submit" value="Reset">
            </form>
        </div>
    </div>



    <script>
    document.getElementById('profile-photo-input').addEventListener('change', function(event) {
        var file = event.target.files[0];
        var cropperContainer = document.getElementById('cropper-container');
        var uploadButton = document.getElementById('upload-button');

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var cropperImage = document.getElementById('cropper-image');
                cropperImage.src = e.target.result;

                if (!cropperContainer.style.display || cropperContainer.style.display === 'none') {
                    cropperContainer.style.display = 'block';
                }

                if (!uploadButton.style.display || uploadButton.style.display === 'none') {
                    uploadButton.style.display = 'inline-block';
                }

                var cropper = new Cropper(cropperImage, {
                    aspectRatio: 1, 
                    viewMode: 1, 
                    autoCropArea: 1, 
                });

                document.getElementById('crop-button').addEventListener('click', function() {
                    var croppedCanvas = cropper.getCroppedCanvas({
                        width: 200, 
                        height: 200, 
                    });

                    var croppedDataURL = croppedCanvas.toDataURL();

                    var profilePhotoContainer = document.querySelector('.profile-photo-container');
                    profilePhotoContainer.innerHTML = '<img src="' + croppedDataURL +
                        '" alt="Profile Picture">';

                });

                document.getElementById('upload-button').addEventListener('click', function() {
                });
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
</body>

</html>