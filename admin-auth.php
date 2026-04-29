<?php
session_start();

$username = trim((string) ($_POST["username"] ?? ""));
$password = trim((string) ($_POST["password"] ?? ""));

if ($username === "kaushik" && $password === "1234") {
    $_SESSION["admin_logged_in"] = true;
    header("Location: admin-dashboard.php");
    exit;
}

header("Location: admin-login.php?error=1");
exit;
