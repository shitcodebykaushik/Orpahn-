<?php
$trackingId = isset($_GET["id"]) ? htmlspecialchars($_GET["id"], ENT_QUOTES, "UTF-8") : "";
$email = isset($_GET["email"]) ? htmlspecialchars($_GET["email"], ENT_QUOTES, "UTF-8") : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Adoption request received by HopeCare.">
    <title>Request Received | HopeCare</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Source+Sans+3:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container">
            <a class="logo" href="index.html">HopeCare</a>
            <nav aria-label="Main">
                <ul class="nav-list">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="programs.html">Programs</a></li>
                    <li><a href="adoption-track.php">Track</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
            <a class="btn btn-primary" href="donation.php">Donate</a>
        </div>
    </header>

    <main>
        <section class="page-hero">
            <div class="container">
                <span class="eyebrow">Thank You</span>
                <h1>Your adoption request has been received.</h1>
                <p>Our care specialists will contact you within two business days.</p>
                <div class="tracking-card">
                    <p class="tracking-label">Your tracking code</p>
                    <h2><?php echo $trackingId !== "" ? $trackingId : "Check your email"; ?></h2>
                    <p class="hero-note">Use this code with your email to track progress.</p>
                </div>
                <div class="hero-actions center">
                    <a class="btn btn-primary" href="adoption-track.php?tracking_id=<?php echo urlencode($trackingId); ?>&email=<?php echo urlencode($email); ?>">Track Request</a>
                    <a class="btn btn-ghost" href="index.html">Back to Home</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-grid">
            <div>
                <a class="logo" href="index.html">HopeCare</a>
                <p>HopeCare supports safe, responsible adoption pathways for orphaned children.</p>
            </div>
            <div>
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="about.html">About</a></li>
                    <li><a href="programs.html">Programs</a></li>
                    <li><a href="adoption-track.php">Track Adoption</a></li>
                    <li><a href="donation-track.php">Track Donation</a></li>
                    <li><a href="admin-login.php">Admin Login</a></li>
                </ul>
            </div>
            <div>
                <h4>Contact</h4>
                <p>Email: hello@hopecare.org</p>
                <p>Phone: +1 (555) 123-4567</p>
                <p>Address: 123 Hope Street, New York, NY</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 HopeCare. All rights reserved.</p>
        </div>
    </footer>

    <button class="chat-toggle" id="chatToggle" type="button">Chat</button>
    <div class="chat-panel" id="chatPanel" aria-live="polite">
        <div class="chat-header">
            <h4>HopeCare Assistant</h4>
            <button class="chat-close" id="chatClose" type="button">&times;</button>
        </div>
        <div class="chat-body" id="chatMessages">
            <div class="chat-message bot">Hi! I can share ways to support orphaned children or explain our programs.</div>
        </div>
        <form class="chat-form" id="chatForm">
            <input id="chatInput" type="text" placeholder="Ask about orphan support..." required>
            <button class="btn btn-primary" type="submit">Send</button>
        </form>
    </div>

    <script src="js/chatbot.js"></script>
</body>
</html>
