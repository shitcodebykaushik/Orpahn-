<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact.php");
    exit;
}

function clean_value($value) {
    $value = trim((string) $value);
    $value = str_replace(["\r", "\n"], " ", $value);
    return $value;
}

$name = clean_value($_POST["name"] ?? "");
$email = clean_value($_POST["email"] ?? "");
$subject = clean_value($_POST["subject"] ?? "");
$message = trim((string) ($_POST["message"] ?? ""));

if ($name === "" || $email === "" || $subject === "" || $message === "") {
    header("Location: contact.php?error=1");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: contact.php?error=1");
    exit;
}

$timestamp = date("Y-m-d H:i:s");
$entry = [$timestamp, $name, $email, $subject, $message];

$dirPath = __DIR__ . "/data";
$filePath = $dirPath . "/messages.csv";

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

header("Location: contact-success.php");
exit;
