<?php
$showError = isset($_GET["error"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Submit an adoption support request with HopeCare.">
    <title>Adoption Support | HopeCare</title>
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
                    <li><a class="active" href="adoption.php">Adoption</a></li>
                    <li><a href="adoption-track.php">Track</a></li>
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
                <span class="eyebrow">Adoption Support</span>
                <h1>Begin the adoption support journey with guided care.</h1>
                <p>We help families navigate processes, match children with safe homes, and coordinate local authorities.</p>
            </div>
        </section>

        <section class="section">
            <div class="container donation-grid">
                <div class="form-card reveal">
                    <h2>Submit Adoption Request</h2>
                    <p>Provide your details and a care specialist will respond within two business days.</p>
                    <?php if ($showError) { ?>
                        <div class="notice">Please complete all required fields correctly.</div>
                    <?php } ?>
                    <form method="post" action="adoption-submit.php">
                        <div class="form-group">
                            <label for="applicant_name">Full Name</label>
                            <input id="applicant_name" name="applicant_name" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="applicant_email">Email Address</label>
                            <input id="applicant_email" name="applicant_email" type="email" required>
                        </div>
                        <div class="form-group">
                            <label for="applicant_phone">Phone Number</label>
                            <input id="applicant_phone" name="applicant_phone" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="child_pref">Child Age Preference</label>
                            <select id="child_pref" name="child_pref" required>
                                <option value="">Select a range...</option>
                                <option value="0-3">0-3 years</option>
                                <option value="4-8">4-8 years</option>
                                <option value="9-12">9-12 years</option>
                                <option value="13-17">13-17 years</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="location">Preferred Location</label>
                            <input id="location" name="location" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="note">Message (optional)</label>
                            <textarea id="note" name="note" placeholder="Share any information helpful for the care team."></textarea>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit Request</button>
                        <p class="hero-note">You will receive a tracking code immediately.</p>
                    </form>
                </div>
                <div class="stack-card reveal">
                    <div class="card">
                        <span class="eyebrow">Process</span>
                        <h3>1. Intake review</h3>
                        <p>Our adoption specialists review your submission and confirm eligibility.</p>
                    </div>
                    <div class="card">
                        <h3>2. Home study</h3>
                        <p>We coordinate with local authorities to ensure a safe placement.</p>
                    </div>
                    <div class="card">
                        <h3>3. Match & placement</h3>
                        <p>We align children with loving families and provide ongoing support.</p>
                    </div>
                    <div class="card">
                        <h3>Track your request</h3>
                        <p>Already submitted? <a class="inline-link" href="adoption-track.php">Track your request</a>.</p>
                    </div>
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
                    <li><a href="blockchain-ledger.php">Blockchain Ledger</a></li>
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
