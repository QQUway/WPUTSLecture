<?php
include('connect.php');

// Check if user is logged in and is an admin, if not, redirect to login page
if (!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Define variables and initialize with empty values
$userId = $amount = $kategori = "";
$userIdErr = $amountErr = $kategoriErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate user input
    if (empty($_POST["userId"])) {
        $userIdErr = "Please select a user";
    } else {
        $userId = $_POST["userId"];
    }

    if (empty($_POST["amount"])) {
        $amountErr = "Please enter the amount";
    } else {
        $amount = $_POST["amount"];
    }

    if (empty($_POST["kategori"])) {
        $kategoriErr = "Please select a category";
    } else {
        $kategori = $_POST["kategori"];
    }

    // If all fields are filled, proceed to update the balance
    if (!empty($userId) && !empty($amount) && !empty($kategori)) {
        // Update user's balance based on the selected category
        $updateBalanceQuery = "";
        if ($kategori === 'wajib' || $kategori === 'saldo' || $kategori === 'sukarela') {
            $updateBalanceQuery = $conn->prepare("UPDATE nasabah SET $kategori = $kategori + ? WHERE nasabah_id = ?");
            $updateBalanceQuery->bind_param("di", $amount, $userId);
            $updateBalanceQuery->execute();

            if (!$updateBalanceQuery) {
                die("Error: " . $conn->error);
            }

            // Redirect to a success page or display a success message
            header("Location: add_balance.php");
            exit;
        } else {
            // Invalid category selected
            $kategoriErr = "Invalid category selected";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Balance</title>
</head>

<body>
    <h2>Add Balance to User</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="userId">User ID:</label>
            <select name="userId" id="userId">
                <option value="">Select a user</option>
                <?php
                // Fetch users from the database
                $usersQuery = $conn->query("SELECT nasabah_id, Nama FROM nasabah");
                while ($row = $usersQuery->fetch_assoc()) {
                    echo "<option value='" . $row['nasabah_id'] . "'>" . $row['Nama'] . "</option>";
                }
                ?>
            </select>
            <span class="error"><?php echo $userIdErr; ?></span>
        </div>
        <div>
            <label for="amount">Amount:</label>
            <input type="number" name="amount" id="amount" step="0.01">
            <span class="error"><?php echo $amountErr; ?></span>
        </div>
        <div>
            <label for="kategori">Category:</label>
            <select name="kategori" id="kategori">
                <option value="">Select a category</option>
                <option value="wajib">Wajib</option>
                <option value="saldo">saldo</option>
                <option value="sukarela">Sukarela</option>
            </select>
            <span class="error"><?php echo $kategoriErr; ?></span>
        </div>
        <div>
            <input type="submit" value="Add Balance">
        </div>
    </form>
</body>

</html>
