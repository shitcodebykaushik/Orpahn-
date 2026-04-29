<?php
require __DIR__ . "/blockchain.php";
$ledger = array_reverse(read_ledger());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HopeCare transparency ledger.">
    <title>Blockchain Ledger | HopeCare</title>
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
                    <li><a class="active" href="blockchain-ledger.php">Ledger</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
            <a class="btn btn-primary" href="donation.php">Donate</a>
        </div>
    </header>

    <main>
        <section class="page-hero">
            <div class="container">
                <span class="eyebrow">Transparency Ledger</span>
                <h1>Immutable record of donation and adoption updates.</h1>
                <p>This is a demo blockchain ledger stored locally for transparency and learning.</p>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="ledger-card">
                    <h2>Latest Blocks</h2>
                    <div class="ledger-table">
                        <div class="ledger-row ledger-head">
                            <span>Index</span>
                            <span>Timestamp</span>
                            <span>Type</span>
                            <span>Record ID</span>
                            <span>Hash</span>
                        </div>
                        <?php foreach ($ledger as $block) { ?>
                            <div class="ledger-row">
                                <span><?php echo htmlspecialchars($block["index"], ENT_QUOTES, "UTF-8"); ?></span>
                                <span><?php echo htmlspecialchars($block["timestamp"], ENT_QUOTES, "UTF-8"); ?></span>
                                <span><?php echo htmlspecialchars($block["type"], ENT_QUOTES, "UTF-8"); ?></span>
                                <span><?php echo htmlspecialchars($block["record_id"], ENT_QUOTES, "UTF-8"); ?></span>
                                <span class="hash-cell"><?php echo htmlspecialchars($block["hash"], ENT_QUOTES, "UTF-8"); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-grid">
            <div>
                <a class="logo" href="index.html">HopeCare</a>
                <p>HopeCare is committed to transparency in every step of support.</p>
            </div>
            <div>
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="about.html">About</a></li>
                    <li><a href="programs.html">Programs</a></li>
                    <li><a href="adoption.php">Adoption</a></li>
                    <li><a href="donation.php">Donate</a></li>
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
</body>
</html>
