<?php
// admin/cron_newsletter.php
// Is file ko cronjob me run karna hai, example: */5 * * * * php /path/to/admin/cron_newsletter.php

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/newsletter_send_helper.php";

$now = date("Y-m-d H:i:s");

// Pick all due newsletters
$stmt = $conn->prepare("SELECT id, title FROM newsletter_master 
                        WHERE sent_status='pending' 
                        AND scheduled_at IS NOT NULL 
                        AND scheduled_at <= ?");
$stmt->bind_param("s", $now);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "[" . $now . "] No pending newsletters.\n";
    exit;
}

while ($nl = $res->fetch_assoc()) {
    $nid = (int)$nl['id'];
    echo "[" . $now . "] Sending newsletter #$nid ({$nl['title']})...\n";

    $ok = send_newsletter_now($nid, $conn, $BASE_URL);

    if ($ok) {
        $conn->query("UPDATE newsletter_master 
                      SET sent_status='sent', updated_at=NOW() 
                      WHERE id=$nid");
        echo "✅ Sent successfully.\n";
    } else {
        $conn->query("UPDATE newsletter_master 
                      SET sent_status='failed', updated_at=NOW() 
                      WHERE id=$nid");
        echo "❌ Failed. Check newsletter_logs for details.\n";
    }
}

echo "Done.\n";
