<?php
require __DIR__ . "/blockchain.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: adoption.php");
    exit;
}

function clean_value($value) {
    $value = trim((string) $value);
    $value = str_replace(["\r", "\n"], " ", $value);
    return $value;
}

$applicantName = clean_value($_POST["applicant_name"] ?? "");
$applicantEmail = clean_value($_POST["applicant_email"] ?? "");
$applicantPhone = clean_value($_POST["applicant_phone"] ?? "");
$childPref = clean_value($_POST["child_pref"] ?? "");
$location = clean_value($_POST["location"] ?? "");
$note = trim((string) ($_POST["note"] ?? ""));

if ($applicantName === "" || $applicantEmail === "" || $applicantPhone === "" || $childPref === "" || $location === "") {
    header("Location: adoption.php?error=1");
    exit;
}

if (!filter_var($applicantEmail, FILTER_VALIDATE_EMAIL)) {
    header("Location: adoption.php?error=1");
    exit;
}

$timestamp = date("Y-m-d H:i:s");
$trackingId = "AD-" . date("Ymd") . "-" . strtoupper(bin2hex(random_bytes(2)));
$status = "Pending";
$assignedTo = "";

$entry = [$timestamp, $trackingId, $applicantName, $applicantEmail, $applicantPhone, $childPref, $location, $status, $note, $assignedTo];

$dirPath = __DIR__ . "/data";
$filePath = $dirPath . "/adoptions.csv";

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

append_block("adoption_created", $trackingId, [
    "child_pref" => $childPref,
    "location" => $location,
    "status" => $status
]);

header("Location: adoption-success.php?id=" . urlencode($trackingId) . "&email=" . urlencode($applicantEmail));
exit;
