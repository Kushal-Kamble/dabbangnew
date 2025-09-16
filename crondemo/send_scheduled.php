<?php
// cron/send_scheduled.php
require_once __DIR__."/../config.php";
require_once __DIR__."/../admin/newsletter_send_helper.php";

// pick pending where scheduled_at <= now()
$res = $conn->query("SELECT id FROM newsletter_master 
                     WHERE sent_status='pending' AND scheduled_at IS NOT NULL 
                     AND scheduled_at <= NOW()");
while($r=$res->fetch_assoc()){
    send_newsletter_now((int)$r['id'], $conn, $BASE_URL);
}
