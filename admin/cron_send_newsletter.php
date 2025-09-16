<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/mailer.php';

// find scheduled Drafts with send_date <= today
$res = $conn->query("SELECT * FROM newsletters WHERE status='Draft' AND send_date IS NOT NULL AND send_date <= CURDATE()");
while($n = $res->fetch_assoc()){
  $blocks = json_decode($n['blocks'], true);
  $title = $n['title'];
  $body = "<h1>".htmlspecialchars($title)."</h1>";
  foreach($blocks as $t=>$c) $body .= "<h3>".htmlspecialchars($t)."</h3>".$c."<hr>";

  $subs = $conn->query("SELECT email_id FROM user_master WHERE usertype='Subscriber' AND verified=1 AND status='Active'");
  while($s = $subs->fetch_assoc()){
    sendMail($s['email_id'], $title, $body);
  }
  $conn->query("UPDATE newsletters SET status='Published', last_sent=NOW() WHERE id=".$n['id']);
}
echo "Done";



/*
# Example: Run every Monday & Thursday at 08:00
0 8 * * 1,4 /usr/bin/php /var/www/html/newsletter-portal/admin/cron_send_newsletter.php

*/