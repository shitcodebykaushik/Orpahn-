<?php
$trackingId = trim((string) ($_GET["tracking_id"] ?? ""));
$email = trim((string) ($_GET["email"] ?? ""));
$result = null;
$error = "";

function read_donations($filePath) {
    if (!file_exists($filePath)) {
        return [];
    }

    $rows = [];
    if (($handle = fopen($filePath, "r")) !== false) {
        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) < 9) {
                continue;
            }
            $rows[] = array_pad($data, 10, "");
        }
        fclose($handle);
    }

    return $rows;
}

if ($trackingId !== "" && $email !== "") {
    $donations = read_donations(__DIR__ . "/data/donations.csv");
    foreach ($donations as $donation) {
        if (strcasecmp($donation[1], $trackingId) === 0 && strcasecmp($donation[3], $email) === 0) {
            $result = [
                "timestamp" => $donation[0],
                "tracking_id" => $donation[1],
                "name" => $donation[2],
                "email" => $donation[3],
                "amount" => $donation[4],
                "currency" => $donation[5],
                "purpose" => $donation[6],
                "status" => $donation[7],
                "note" => $donation[8],
                "assigned_to" => $donation[9]
            ];
            break;
        }
    }

    if ($result === null) {
        $error = "We could not find a donation with that tracking code and email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Track your HopeCare donation.">
    <title>Track Donation | HopeCare</title>
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
                    <li><a class="active" href="donation-track.php">Track</a></li>
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
                <span class="eyebrow">Donation Tracking</span>
                <h1>Follow the progress of your support.</h1>
                <p>Enter your tracking code and email to view the latest status.</p>
            </div>
        </section>

        <section class="section">
            <div class="container donation-grid">
                <div class="form-card reveal">
                    <h2>Track Donation</h2>
                    <form method="get" action="donation-track.php">
                        <div class="form-group">
                            <label for="tracking_id">Tracking Code</label>
                            <input id="tracking_id" name="tracking_id" type="text" value="<?php echo htmlspecialchars($trackingId, ENT_QUOTES, "UTF-8"); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, "UTF-8"); ?>" required>
                        </div>
                        <button class="btn btn-primary" type="submit">Check Status</button>
                    </form>
                    <?php if ($error !== "") { ?>
                        <div class="notice" style="margin-top: 18px;"><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></div>
                    <?php } ?>
                </div>

                <div class="stack-card reveal">
                    <?php if ($result !== null) { ?>
                        <div class="card">
                            <span class="tag">Status</span>
                            <h3 class="status-pill <?php echo strtolower($result["status"]); ?>"><?php echo htmlspecialchars($result["status"], ENT_QUOTES, "UTF-8"); ?></h3>
                            <p>Last updated: <?php echo htmlspecialchars($result["timestamp"], ENT_QUOTES, "UTF-8"); ?></p>
                            <p>Assigned to: <?php echo $result["assigned_to"] !== "" ? htmlspecialchars($result["assigned_to"], ENT_QUOTES, "UTF-8") : "Awaiting assignment"; ?></p>
                        </div>
                        <div class="card">
                            <h3>Donation Details</h3>
                            <p><strong>Tracking ID:</strong> <?php echo htmlspecialchars($result["tracking_id"], ENT_QUOTES, "UTF-8"); ?></p>
                            <p><strong>Amount:</strong> <?php echo htmlspecialchars($result["currency"], ENT_QUOTES, "UTF-8"); ?> <?php echo htmlspecialchars($result["amount"], ENT_QUOTES, "UTF-8"); ?></p>
                            <p><strong>Purpose:</strong> <?php echo htmlspecialchars(ucfirst($result["purpose"]), ENT_QUOTES, "UTF-8"); ?></p>
                        </div>
                        <div class="card">
                            <h3>Next Steps</h3>
                            <p>Our team will update the status as funds are allocated. You can check back any time.</p>
                        </div>
                    <?php } else { ?>
                        <div class="card">
                            <span class="eyebrow">How it works</span>
                            <h3>Statuses you may see</h3>
                            <ul class="status-list">
                                <li><span class="status-pill pending">Pending</span> Donation received and queued for processing.</li>
                                <li><span class="status-pill confirmed">Confirmed</span> Funds allocated to a program or child.</li>
                                <li><span class="status-pill delivered">Delivered</span> Impact report recorded and shared.</li>
                            </ul>
                        </div>
                        <div class="card">
                            <h3>Need help?</h3>
                            <p>Contact our team if you misplace your tracking code or email.</p>
                            <a class="btn btn-ghost" href="contact.php">Contact Support</a>
                        </div>
                    <?php } ?>
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
                    <li><a href="donation.php">Donate</a></li>
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
