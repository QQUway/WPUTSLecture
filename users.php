
<?php
// Check if user is logged in and is an admin, if not, redirect to login page
if(!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="resource/css/navbar-footer.css">
    <title>Users List</title>
</head>

<body>
<div class="navbar">
        <a href="admin_home.php">Home</a>
        <a href="users.php">Users</a>
        <a href="logout.php">Log Out</a>
</div>

    <h1>User List</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Name</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Date of Birth</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "connect.php";
            $servername = "localhost";
            $username = "root";
            $password = "";
            $db_name = "uts_wp";
            $conn = new mysqli($servername, $username, $password, $db_name);

            // Fetch data from the nasabah table
            $sql = "SELECT nasabah_id, Email, Nama, Alamat, Jenis_Kelamin, Tanggal_Lahir FROM nasabah";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nasabah_id"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["Nama"] . "</td>";
                    echo "<td>" . $row["Alamat"] . "</td>";
                    echo "<td>" . $row["Jenis_Kelamin"] . "</td>";
                    echo "<td>" . $row["Tanggal_Lahir"] . "</td>";

                    echo "<td><button class='view-btn' onclick='viewProfile(" . $row["nasabah_id"] . ")'>View</button></td>";
                    echo "<td><button class='delete-btn' onclick='confirmDelete(" . $row["nasabah_id"] . ")'>Delete</button></td>";


                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No users found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; 2024 KDHH Koperasi. All rights reserved.</p>
    </div>

    <script>
        function confirmDelete(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "delete_user.php?user_id=" + userId;
            }
        }


        function viewProfile(userId) {
            window.location.href = "user_view.php?user_id=" + userId;
        }

    </script>
</body>

</html>