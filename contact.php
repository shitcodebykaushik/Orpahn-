<?php
$showError = isset($_GET["error"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact HopeCare to support orphaned children.">
    <title>Contact | HopeCare</title>
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
                    <li><a href="adoption.php">Adoption</a></li>
                    <li><a href="donation-track.php">Track</a></li>
                    <li><a href="blockchain-ledger.php">Ledger</a></li>
                    <li><a class="active" href="contact.php">Contact</a></li>
                </ul>
            </nav>
            <a class="btn btn-primary" href="donation.php">Donate</a>
        </div>
    </header>

    <main>
        <section class="page-hero">
            <div class="container">
                <span class="eyebrow">Contact</span>
                <h1>Let us know how you want to help.</h1>
                <p>We reply within two business days and can connect you with local volunteer or sponsorship options.</p>
            </div>
        </section>

        <section class="section">
            <div class="container contact-grid">
                <div class="form-card reveal">
                    <h2>Send a Message</h2>
                    <p>Share your question, and our team will respond shortly.</p>
                    <?php if ($showError) { ?>
                        <div class="notice">Please complete all fields so we can respond properly.</div>
                    <?php } ?>
                    <form method="post" action="contact-submit.php">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input id="name" name="name" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input id="email" name="email" type="email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <select id="subject" name="subject" required>
                                <option value="">Select a subject...</option>
                                <option value="donate">Sponsorship & donations</option>
                                <option value="volunteer">Volunteer opportunities</option>
                                <option value="partner">Partnerships</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        <button class="btn btn-primary" type="submit">Send Message</button>
                    </form>
                </div>
                <div class="card reveal">
                    <span class="eyebrow">Contact Info</span>
                    <h3>HopeCare Headquarters</h3>
                    <p>123 Hope Street<br>New York, NY 10001</p>
                    <p>Email: hello@hopecare.org<br>Phone: +1 (555) 123-4567</p>
                    <p>Hours: Mon-Fri, 9:00 AM - 6:00 PM</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-grid">
            <div>
                <a class="logo" href="index.html">HopeCare</a>
                <p>HopeCare provides safety, education, and health programs for orphaned children.</p>
            </div>
            <div>
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="about.html">About</a></li>
                    <li><a href="programs.html">Programs</a></li>
                    <li><a href="adoption.php">Adoption</a></li>
                    <li><a href="donation-track.php">Track Donation</a></li>
                    <li><a href="blockchain-ledger.php">Blockchain Ledger</a></li>
                    <li><a href="contact.php">Contact</a></li>
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

    <button class="sos-btn" type="button" aria-controls="sosModal" onclick="toggleSOS()">SOS</button>
    <div class="sos-modal" id="sosModal" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="sos-content">
            <button class="sos-close" type="button" aria-label="Close" onclick="toggleSOS()">&times;</button>
            <h2>Emergency SOS</h2>
            <p>If a child is in immediate danger, contact local authorities immediately or call our emergency response line.</p>
            <div class="sos-actions">
                <a class="btn btn-primary" href="tel:+18001234567">Call HopeCare Hotline</a>
                <a class="btn btn-ghost" href="tel:911">Call Local Emergency (911)</a>
                <button class="btn btn-outline" type="button" onclick="toggleSOS()">Cancel</button>
            </div>
        </div>
    </div>

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

    <script>
        function toggleSOS() {
            const modal = document.getElementById("sosModal");
            const isOpen = modal.classList.toggle("active");
            modal.setAttribute("aria-hidden", String(!isOpen));
        }
    </script>
    <script src="js/chatbot.js"></script>
</body>
</html>
