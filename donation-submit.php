<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: donation.php");
    exit;
}

function clean_value($value) {
    $value = trim((string) $value);
    $value = str_replace(["\r", "\n"], " ", $value);
    return $value;
}

$donorName = clean_value($_POST["donor_name"] ?? "");
$donorEmail = clean_value($_POST["donor_email"] ?? "");
$amount = (float) ($_POST["amount"] ?? 0);
$purpose = clean_value($_POST["purpose"] ?? "");
$note = trim((string) ($_POST["note"] ?? ""));

if ($donorName === "" || $donorEmail === "" || $amount <= 0 || $purpose === "") {
    header("Location: donation.php?error=1");
    exit;
}

if (!filter_var($donorEmail, FILTER_VALIDATE_EMAIL)) {
    header("Location: donation.php?error=1");
    exit;
}

$timestamp = date("Y-m-d H:i:s");
$trackingId = "HC-" . date("Ymd") . "-" . strtoupper(bin2hex(random_bytes(2)));
$currency = "USD";
$status = "Pending";
$assignedTo = "";

$entry = [$timestamp, $trackingId, $donorName, $donorEmail, number_format($amount, 2, ".", ""), $currency, $purpose, $status, $note, $assignedTo];

$dirPath = __DIR__ . "/data";
$filePath = $dirPath . "/donations.csv";

if (!is_dir($dirPath)) {
    mkdir($dirPath, 0755, true);
}

$handle = fopen($filePath, "a");
if ($handle) {
    flock($handle, LOCK_EX);
    fputcsv($handle, $entry);
    flock($handle, LOCK_UN);
    fclose($handle);
}

header("Location: donation-success.php?id=" . urlencode($trackingId) . "&email=" . urlencode($donorEmail));
exit;
