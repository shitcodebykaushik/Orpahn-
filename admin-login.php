<?php
session_start();
$showError = isset($_GET["error"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HopeCare admin login.">
    <title>Admin Login | HopeCare</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Source+Sans+3:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <main class="admin-shell">
        <section class="admin-card">
            <div class="admin-header">
                <span class="eyebrow">Admin Portal</span>
                <h1>HopeCare Dashboard</h1>
                <p>Sign in to manage donations and adoption requests.</p>
            </div>
            <?php if ($showError) { ?>
                <div class="notice">Invalid credentials. Please try again.</div>
            <?php } ?>
            <form class="admin-form" method="post" action="admin-auth.php">
                <div class="form-group">
                    <label for="username">Admin ID</label>
                    <input id="username" name="username" type="text" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required>
                </div>
                <button class="btn btn-primary" type="submit">Login</button>
            </form>
            <p class="hero-note">Authorized staff only.</p>
        </section>
    </main>
</body>
</html>
