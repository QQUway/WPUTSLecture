<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="resource/css/navbar-footer.css">
    <link rel="stylesheet" type="text/css" href="resource/css/style.css">
    <title>User List</title>

    <style>
    .container {
        width: 80%;
        margin: 0 auto;

        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .actions-btn {
        padding: 5px 10px;
        border: none;
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
        margin-right: 5px;
    }

    .actions-btn:hover {
        background-color: #45a049;
    }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="admin_home.php">Home</a>
        <a href="users.php">Users</a>
        <a href="logout.php">Log Out</a>
    </div>

    <div class="container">
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "connect.php";
                $sql = "SELECT nasabah_id, Email, Nama, Alamat, Jenis_Kelamin, Tanggal_Lahir FROM nasabah";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nasabah_id"] . "</td>";
                        echo "<td>" . $row["Email"] . "</td>";
                        echo "<td>" . $row["Nama"] . "</td>";
                        echo "<td>" . $row["Alamat"] . "</td>";
                        echo "<td>" . $row["Jenis_Kelamin"] . "</td>";
                        echo "<td>" . $row["Tanggal_Lahir"] . "</td>";
                        echo "<td>";
                        echo "<button class='actions-btn' onclick='viewProfile(" . $row["nasabah_id"] . ")'>View</button>";
                        echo "<button class='actions-btn' onclick='confirmDelete(" . $row["nasabah_id"] . ")'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No users found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>

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