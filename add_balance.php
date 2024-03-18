<?php
include('connect.php');

if (!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$userId = $amount = $kategori = "";
$userIdErr = $amountErr = $kategoriErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    if (!empty($userId) && !empty($amount) && !empty($kategori)) {
        $updateBalanceQuery = "";
        if ($kategori === 'wajib' || $kategori === 'saldo' || $kategori === 'sukarela') {
            $updateBalanceQuery = $conn->prepare("UPDATE nasabah SET $kategori = $kategori + ? WHERE nasabah_id = ?");
            $updateBalanceQuery->bind_param("di", $amount, $userId);
            $updateBalanceQuery->execute();

            if (!$updateBalanceQuery) {
                die("Error: " . $conn->error);
            }

            header("Location: add_balance.php");
            exit;
        } else {
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
