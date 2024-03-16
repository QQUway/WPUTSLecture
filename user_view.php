<?php
include('connect.php');

// Check if user is logged in and is an admin, if not, redirect to login page
if(!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}


// Check if user_id is provided in the query string
if (isset($_GET['user_id'])) {
    // Sanitize the user ID to prevent SQL injection
    $userId = $_GET['user_id'];

    // Fetch user data from the database based on the user ID
    $sql = "SELECT * FROM nasabah WHERE nasabah_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Assign user data to variables
        $userName = $userData['Nama'];
        $userEmail = $userData['Email'];
        $userAddress = $userData['Alamat'];
        // You can fetch and assign other user data here

        // Close prepared statement
        $stmt->close();
    } else {
        // User with the provided ID does not exist
        $userName = "User not found";
        $userEmail = "";
        $userAddress = "";
        // You can assign default values or handle this case as needed
    }
} else {
    // User ID is not provided in the query string
    $userName = "User ID not provided";
    $userEmail = "";
    $userAddress = "";
    // You can assign default values or handle this case as needed
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="resource/css/profile.css">
</head>

<body>
    <div class="container">
        <h1>User Profile</h1>
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
    </div>
    </script>
</body>

</html>