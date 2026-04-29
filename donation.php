<?php
$showError = isset($_GET["error"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Donate to HopeCare and help orphaned children thrive.">
    <title>Donate | HopeCare</title>
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
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
            <a class="btn btn-primary" href="donation.php">Donate</a>
        </div>
    </header>

    <main>
        <section class="page-hero">
            <div class="container">
                <span class="eyebrow">Donate</span>
                <h1>Support a child with steady care and opportunity.</h1>
                <p>Your donation funds meals, school supplies, healthcare visits, and safe housing programs.</p>
            </div>
        </section>

        <section class="section">
            <div class="container donation-grid">
                <div class="form-card reveal">
                    <h2>Make a Donation</h2>
                    <p>Every contribution is tracked so you can follow the impact of your support.</p>
                    <?php if ($showError) { ?>
                        <div class="notice">Please complete all required fields correctly.</div>
                    <?php } ?>
                    <form method="post" action="donation-submit.php">
                        <div class="form-group">
                            <label for="donor_name">Full Name</label>
                            <input id="donor_name" name="donor_name" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="donor_email">Email Address</label>
                            <input id="donor_email" name="donor_email" type="email" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Donation Amount (USD)</label>
                            <input id="amount" name="amount" type="number" min="5" step="1" placeholder="50" required>
                        </div>
                        <div class="form-group">
                            <label for="purpose">Donation Purpose</label>
                            <select id="purpose" name="purpose" required>
                                <option value="">Select a purpose...</option>
                                <option value="education">Education support</option>
                                <option value="health">Healthcare & nutrition</option>
                                <option value="housing">Safe housing</option>
                                <option value="emergency">Emergency relief</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="note">Message (optional)</label>
                            <textarea id="note" name="note" placeholder="Share any notes for our team."></textarea>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit Donation</button>
                        <p class="hero-note">You will receive a tracking code instantly.</p>
                    </form>
                </div>
                <div class="stack-card reveal">
                    <div class="card">
                        <span class="eyebrow">Impact</span>
                        <h3>$25</h3>
                        <p>Provides school supplies for one child for a semester.</p>
                    </div>
                    <div class="card">
                        <h3>$60</h3>
                        <p>Covers medical checkups and basic medicine.</p>
                    </div>
                    <div class="card">
                        <h3>$120</h3>
                        <p>Funds nutritious meals for a child for an entire month.</p>
                    </div>
                    <div class="card">
                        <h3>Track your support</h3>
                        <p>Already donated? <a class="inline-link" href="donation-track.php">Track your donation</a>.</p>
                    </div>
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
