<?php
// Check if user is logged in and is an admin, if not, redirect to login page
if (!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Check if the transaction ID is provided in the URL
if (!isset($_GET['transaction_id'])) {
    header("Location: admin_home.php");
    exit;
}

$transaction_id = $_GET['transaction_id'];

include "connect.php";

// Fetch transaction information
$transactionQuery = $conn->prepare("SELECT * FROM transaction_data WHERE transaction_id = ?");
$transactionQuery->bind_param("i", $transaction_id);
$transactionQuery->execute();
$transactionResult = $transactionQuery->get_result();

// If transaction is not found or it's not pending, redirect back
if ($transactionResult->num_rows === 0 || $transactionResult->fetch_assoc()['status'] !== 'pending') {
    header("Location: admin_home.php");
    exit;
}

// Update the transaction status to 'verified'
$updateQuery = $conn->prepare("UPDATE transaction_data SET status = 'verified' WHERE transaction_id = ?");
$updateQuery->bind_param("i", $transaction_id);
$updateQuery->execute();
$updateQuery->close();

// Get the user ID associated with the transaction
$transactionData = $transactionResult->fetch_assoc();
$nasabah_id = $transactionData['nasabah_id'];

// Check if the transaction category is valid
$kategori = $transactionData['kategori'];
if ($kategori === 'Wajib' || $kategori === 'Sukarela') {
    // Update the user's balance based on the transaction type
    $amount = $transactionData['amount'];
    if ($kategori === 'Wajib') {
        $updateBalanceQuery = $conn->prepare("UPDATE nasabah SET wajib = wajib + ? WHERE nasabah_id = ?");
    } elseif ($kategori === 'Sukarela') {
        $updateBalanceQuery = $conn->prepare("UPDATE nasabah SET sukarela = sukarela + ? WHERE nasabah_id = ?");
    }
    $updateBalanceQuery->bind_param("di", $amount, $nasabah_id);
    $updateBalanceQuery->execute();
    $updateBalanceQuery->close();
}

// Redirect back to pending transactions page
header("Location: pending_transactions.php?nasabah_id=$nasabah_id");
exit;
?>
