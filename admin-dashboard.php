<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin-login.php");
    exit;
}

require __DIR__ . "/blockchain.php";

function read_rows($filePath, $minColumns, $padTo) {
    if (!file_exists($filePath)) {
        return [];
    }

    $rows = [];
    if (($handle = fopen($filePath, "r")) !== false) {
        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) < $minColumns) {
                continue;
            }
            $rows[] = array_pad($data, $padTo, "");
        }
        fclose($handle);
    }

    return $rows;
}

function write_rows($filePath, $rows) {
    $dir = dirname($filePath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $handle = fopen($filePath, "w");
    if ($handle) {
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }
}

$donationFile = __DIR__ . "/data/donations.csv";
$adoptionFile = __DIR__ . "/data/adoptions.csv";

$notice = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $type = $_POST["type"] ?? "";
    $trackingId = trim((string) ($_POST["tracking_id"] ?? ""));
    $status = trim((string) ($_POST["status"] ?? ""));
    $assignedTo = trim((string) ($_POST["assigned_to"] ?? ""));

    $allowedStatuses = ["Pending", "Confirmed", "Delivered"];
    if ($trackingId !== "" && in_array($status, $allowedStatuses, true)) {
        if ($type === "donation") {
            $rows = read_rows($donationFile, 9, 10);
            $updated = false;
            foreach ($rows as &$row) {
                if ($row[1] === $trackingId) {
                    $row[7] = $status;
                    $row[9] = $assignedTo;
                    $notice = "Donation updated.";
                    $updated = true;
                    break;
                }
            }
            unset($row);
            write_rows($donationFile, $rows);
            if ($updated) {
                append_block("donation_updated", $trackingId, [
                    "status" => $status,
                    "assigned_to" => $assignedTo
                ]);
            }
        }

        if ($type === "adoption") {
            $rows = read_rows($adoptionFile, 9, 10);
            $updated = false;
            foreach ($rows as &$row) {
                if ($row[1] === $trackingId) {
                    $row[7] = $status;
                    $row[9] = $assignedTo;
                    $notice = "Adoption request updated.";
                    $updated = true;
                    break;
                }
            }
            unset($row);
            write_rows($adoptionFile, $rows);
            if ($updated) {
                append_block("adoption_updated", $trackingId, [
                    "status" => $status,
                    "assigned_to" => $assignedTo
                ]);
            }
        }
    }
}

$donations = read_rows($donationFile, 9, 10);
$adoptions = read_rows($adoptionFile, 9, 10);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HopeCare admin dashboard.">
    <title>Admin Dashboard | HopeCare</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Source+Sans+3:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <main class="admin-shell">
        <section class="admin-panel">
            <div class="admin-topbar">
                <div>
                    <span class="eyebrow">Admin Dashboard</span>
                    <h1>HopeCare Operations</h1>
                </div>
                <div class="admin-actions">
                    <a class="btn btn-ghost" href="blockchain-ledger.php">View Ledger</a>
                    <a class="btn btn-ghost" href="admin-logout.php">Logout</a>
                </div>
            </div>

            <?php if ($notice !== "") { ?>
                <div class="notice"><?php echo htmlspecialchars($notice, ENT_QUOTES, "UTF-8"); ?></div>
            <?php } ?>

            <div class="admin-grid">
                <div class="admin-section">
                    <h2>Donations</h2>
                    <div class="admin-table">
                        <div class="admin-row admin-head">
                            <span>Tracking</span>
                            <span>Donor</span>
                            <span>Amount</span>
                            <span>Status</span>
                            <span>Assign</span>
                            <span>Update</span>
                        </div>
                        <?php if (count($donations) === 0) { ?>
                            <div class="admin-empty">No donations yet.</div>
                        <?php } ?>
                        <?php foreach ($donations as $donation) { ?>
                            <form class="admin-row" method="post" action="admin-dashboard.php">
                                <input type="hidden" name="type" value="donation">
                                <input type="hidden" name="tracking_id" value="<?php echo htmlspecialchars($donation[1], ENT_QUOTES, "UTF-8"); ?>">
                                <span><?php echo htmlspecialchars($donation[1], ENT_QUOTES, "UTF-8"); ?></span>
                                <span>
                                    <?php echo htmlspecialchars($donation[2], ENT_QUOTES, "UTF-8"); ?><br>
                                    <small><?php echo htmlspecialchars($donation[3], ENT_QUOTES, "UTF-8"); ?></small>
                                </span>
                                <span><?php echo htmlspecialchars($donation[5], ENT_QUOTES, "UTF-8"); ?> <?php echo htmlspecialchars($donation[4], ENT_QUOTES, "UTF-8"); ?></span>
                                <span>
                                    <select name="status">
                                        <option value="Pending" <?php echo $donation[7] === "Pending" ? "selected" : ""; ?>>Pending</option>
                                        <option value="Confirmed" <?php echo $donation[7] === "Confirmed" ? "selected" : ""; ?>>Confirmed</option>
                                        <option value="Delivered" <?php echo $donation[7] === "Delivered" ? "selected" : ""; ?>>Delivered</option>
                                    </select>
                                </span>
                                <span>
                                    <input name="assigned_to" type="text" value="<?php echo htmlspecialchars($donation[9], ENT_QUOTES, "UTF-8"); ?>" placeholder="Assign to">
                                </span>
                                <span>
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </span>
                            </form>
                        <?php } ?>
                    </div>
                </div>

                <div class="admin-section">
                    <h2>Adoption Requests</h2>
                    <div class="admin-table">
                        <div class="admin-row admin-head">
                            <span>Tracking</span>
                            <span>Applicant</span>
                            <span>Preference</span>
                            <span>Status</span>
                            <span>Assign</span>
                            <span>Update</span>
                        </div>
                        <?php if (count($adoptions) === 0) { ?>
                            <div class="admin-empty">No adoption requests yet.</div>
                        <?php } ?>
                        <?php foreach ($adoptions as $adoption) { ?>
                            <form class="admin-row" method="post" action="admin-dashboard.php">
                                <input type="hidden" name="type" value="adoption">
                                <input type="hidden" name="tracking_id" value="<?php echo htmlspecialchars($adoption[1], ENT_QUOTES, "UTF-8"); ?>">
                                <span><?php echo htmlspecialchars($adoption[1], ENT_QUOTES, "UTF-8"); ?></span>
                                <span>
                                    <?php echo htmlspecialchars($adoption[2], ENT_QUOTES, "UTF-8"); ?><br>
                                    <small><?php echo htmlspecialchars($adoption[3], ENT_QUOTES, "UTF-8"); ?></small>
                                </span>
                                <span><?php echo htmlspecialchars($adoption[5], ENT_QUOTES, "UTF-8"); ?><br><small><?php echo htmlspecialchars($adoption[6], ENT_QUOTES, "UTF-8"); ?></small></span>
                                <span>
                                    <select name="status">
                                        <option value="Pending" <?php echo $adoption[7] === "Pending" ? "selected" : ""; ?>>Pending</option>
                                        <option value="Confirmed" <?php echo $adoption[7] === "Confirmed" ? "selected" : ""; ?>>Confirmed</option>
                                        <option value="Delivered" <?php echo $adoption[7] === "Delivered" ? "selected" : ""; ?>>Delivered</option>
                                    </select>
                                </span>
                                <span>
                                    <input name="assigned_to" type="text" value="<?php echo htmlspecialchars($adoption[9], ENT_QUOTES, "UTF-8"); ?>" placeholder="Assign to">
                                </span>
                                <span>
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </span>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
