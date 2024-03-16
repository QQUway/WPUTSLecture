<?php 
include ('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" type="text/css" href="resource/css/profile.css">
</head>

<body>
    <div class="container">
        <h1>Customer Profile</h1>
        <div class="profile-info">
            <div class="profile-photo-container">
                <img id="profile-img" src="default-profile-pic.jpg" alt="Profile Picture">
            </div>
            <div class="biodata">
                <label for="customer-name">Name:</label>
                <p id="customer-name">John Doe</p>
                
                <label for="customer-email">Email:</label>
                <p id="customer-email">johndoe@example.com</p>
                
                <label for="customer-address">Address:</label>
                <p id="customer-address">123 Main St, City, Country</p>
                
                <label for="customer-phone">Phone:</label>
                <p id="customer-phone">123-456-7890</p>
                
                <label for="customer-joined">Joined:</label>
                <p id="customer-joined">January 1, 2020</p>
            </div>
        </div>

        <!-- Form for updating user data -->
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

        <!-- Form for changing profile photo -->
        <div class="form-container">
            <h2>Change Profile Photo</h2>
            <form id="photo-form">
                <input type="file" id="profile-photo" name="profile-photo">
                <input type="submit" value="Upload">
            </form>
        </div>

        <!-- Form for resetting password -->
        <div class="form-container">
            <h2>Reset Password</h2>
            <form id="password-form">
                <label for="current-password">Current Password:</label>
                <input type="password" id="current-password" name="current-password" placeholder="Enter current password">
                
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
                    aspectRatio: 1, // square aspect ratio
                    viewMode: 1, // restrict the cropped area to be within the container
                    autoCropArea: 1, // automatically fit the cropped area to the container
                });

                document.getElementById('crop-button').addEventListener('click', function() {
                    // Get the cropped canvas
                    var croppedCanvas = cropper.getCroppedCanvas({
                        width: 200, // set the desired width
                        height: 200, // set the desired height
                    });

                    // Convert the cropped canvas to a base64 encoded URL
                    var croppedDataURL = croppedCanvas.toDataURL();

                    // Display the cropped image for preview
                    var profilePhotoContainer = document.querySelector('.profile-photo-container');
                    profilePhotoContainer.innerHTML = '<img src="' + croppedDataURL + '" alt="Profile Picture">';

                    // Optionally, you can also submit the cropped image to the server
                    // by sending croppedDataURL to the server using AJAX
                });

                document.getElementById('upload-button').addEventListener('click', function() {
                    // Optionally, you can upload the cropped image to the server here
                    // by sending croppedDataURL to the server using AJAX
                });
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
</body>
</html>
