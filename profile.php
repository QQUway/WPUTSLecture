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
        document.getElementById('update-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting

            // Get the updated data from the form fields
            var newName = document.getElementById('update-name').value;
            var newEmail = document.getElementById('update-email').value;
            var newAddress = document.getElementById('update-address').value;

            // Update the profile information
            document.getElementById('customer-name').innerText = newName;
            document.getElementById('customer-email').innerText = newEmail;
            document.getElementById('customer-address').innerText = newAddress;

            // Optional: You can also send the updated data to the server here using AJAX
        });

        document.getElementById('photo-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting
            
            var fileInput = document.getElementById('profile-photo');
            var file = fileInput.files[0];

            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-img').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
