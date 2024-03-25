<?php
if (!isset($_COOKIE['username']) || !isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['transaction_id'])) {
    header("Location: admin_home.php");
    exit;
}

$transaction_id = $_GET['transaction_id'];

include "connect.php";

$transactionQuery = $conn->prepare("SELECT * FROM transaction_data WHERE transaction_id = ? AND status = 'pending'");
$transactionQuery->bind_param("i", $transaction_id);
$transactionQuery->execute();
$transactionResult = $transactionQuery->get_result();

if ($transactionResult->num_rows === 0) {
    header("Location: admin_home.php");
    exit;
}

$updateQuery = $conn->prepare("UPDATE transaction_data SET status = 'verified' WHERE transaction_id = ?");
$updateQuery->bind_param("i", $transaction_id);
$updateQuery->execute();
$updateQuery->close();

$transactionData = $transactionResult->fetch_assoc();
$nasabah_id = $transactionData['nasabah_id'];
$kategori = $transactionData['kategori'];
$amount = $transactionData['amount'];

$updateBalanceQuery = null;

switch ($kategori) {
    case 'Wajib':
        $updateBalanceQuery = $conn->prepare("UPDATE nasabah SET wajib = wajib + ? WHERE nasabah_id = ?");
        break;
    case 'Sukarela':
        $updateBalanceQuery = $conn->prepare("UPDATE nasabah SET sukarela = sukarela + ? WHERE nasabah_id = ?");
        break;
    case 'Pokok':
        $updateBalanceQuery = $conn->prepare("UPDATE nasabah SET saldo = saldo + ? WHERE nasabah_id = ?");
        break;
}

if ($updateBalanceQuery) {
    $updateBalanceQuery->bind_param("di", $amount, $nasabah_id);
    $updateBalanceQuery->execute();
    $updateBalanceQuery->close();
} else {
    die("Error: Invalid category");
}

header("Location: user_view.php?user_id=$nasabah_id");
exit;
?>
