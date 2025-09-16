<?php 
// admin/newsletter_send_helper.php
require_once __DIR__."/../inc/mailer.php";

function send_newsletter_now(int $newsletter_id, mysqli $conn, string $BASE_URL): bool {
    $stmt = $conn->prepare("SELECT * FROM newsletter_master WHERE id=?");
    $stmt->bind_param("i", $newsletter_id);
    $stmt->execute();
    $nl = $stmt->get_result()->fetch_assoc();
    if (!$nl) return false;

    $post_url = null;
    if (!empty($nl['links'])) {
        $links = json_decode($nl['links'], true);
        if (!empty($links['post_url'])) $post_url = $links['post_url'];
    }

    $plain = trim(strip_tags($nl['editor_content'] ?? ''));
    $snippet = mb_substr($plain, 0, 180).(mb_strlen($plain) > 180 ? '…' : '');

    // Hero image with its own background
    $hero = $nl['image'] 
        ? "<div style='background:#fff2e6;padding:12px;border-radius:12px;margin:12px 0;text-align:center;'>
             <img src='".htmlspecialchars($nl['image'])."' style='width:100%;border-radius:10px;' alt='Hero'>
           </div>"
        : "";

    // Video block with pastel background
    $videoBlock = "";
    if (!empty($nl['video'])) {
        $ytId = "";
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]+)/', $nl['video'], $m)) {
            $ytId = $m[1];
        }
        if ($ytId) {
            $thumb = "https://img.youtube.com/vi/".$ytId."/hqdefault.jpg";
            $videoBlock = "
            <div style='background:#e6f7ff;padding:14px;border-radius:12px;margin:18px 0;text-align:center;'>
                <a href='".htmlspecialchars($nl['video'])."' target='_blank'>
                    <img src='{$thumb}' alt='Watch Video' style='max-width:100%;border-radius:8px;'>
                </a><br>
                <a href='".htmlspecialchars($nl['video'])."' target='_blank'
                   style='display:inline-block;margin-top:8px;padding:10px 15px;background:#fd5402;color:#fff;text-decoration:none;border-radius:6px;'>
                    ▶ Watch Video
                </a>
            </div>";
        } else {
            $videoBlock = "
            <div style='background:#e6f7ff;padding:14px;border-radius:12px;margin:18px 0;text-align:center;'>
                <a href='".htmlspecialchars($nl['video'])."' target='_blank'
                   style='display:inline-block;padding:10px 15px;background:#fd5402;color:#fff;text-decoration:none;border-radius:6px;'>
                    🎬 Watch Video
                </a>
            </div>";
        }
    }

    // CTA button
    $cta  = $post_url 
        ? "<div style='text-align:center;margin:20px 0'>
                <a href='".htmlspecialchars($post_url)."' style='background:#ff7f50;color:#fff;padding:12px 20px;border-radius:6px;text-decoration:none;display:inline-block;'>
                Read More</a>
           </div>" 
        : "";

    // Colored header band
    $headerBand = "<div style='background:#fe9e43;color:#fff;padding:10px 14px;border-radius:8px 8px 0 0;font-weight:bold;text-align:center;margin-bottom:10px;'>Weekly Digest</div>";

    // Build colorful HTML template
    $html_template = "
    <div style='font-family:Arial,sans-serif;background:#f5f7fb;padding:20px;border-radius:20px;'>
      <div style='max-width:640px;margin:auto;background:#ffffff;border-radius:14px;overflow:hidden;'>
        {$headerBand}
        <div style='padding:20px'>
          <h2 style='margin:0 0 6px 0;color:#333'>".htmlspecialchars($nl['title'])."</h2>
          <div style='color:#666;font-size:13px;margin-bottom:8px'>Newsletter</div>
          {$hero}
          {$videoBlock}
          <div style='background:#f0f8ff;padding:16px;border-radius:10px;margin:12px 0;color:#333;line-height:1.6;font-size:14px'>
            ".$nl['editor_content']."
          </div>
          {$cta}
          <hr style='margin:18px 0;border:none;border-top:1px solid #eee'>
          <p style='color:#555;font-size:14px;margin:0'>{$snippet}</p>
          <div style='color:#999;font-size:12px;margin-top:16px;text-align:center'>
            You are receiving this because you subscribed.<br>
            Unsubscribe: <a href='".rtrim($BASE_URL,'/')."/public/unsubscribe.php?email={email}' style='color:#666'>Unsubscribe</a>
          </div>
        </div>
      </div>
    </div>";

    // Alt body
    $alt_template = strip_tags(str_replace(["<br>", "<br/>", "<br />"], "\n", $nl['editor_content']));
    if ($post_url) $alt_template .= "\n\nRead more: ".$post_url;

    // Send emails
    $subs = $conn->query("SELECT name,email FROM subscribers WHERE status=1");
    $okCount=0; $failCount=0;
    while($s = $subs->fetch_assoc()){
        $email = $s['email'];
        $name = $s['name'] ?? '';

        $html = str_replace('{email}', urlencode($email), $html_template);
        $alt  = str_replace('{email}', urlencode($email), $alt_template);

        $ok = sendMailHTML($email, $name, $nl['title'], $html, $alt);

        $lg = $conn->prepare("INSERT INTO newsletter_logs (newsletter_id, subscriber_email, status, error_msg) VALUES (?, ?, ?, ?)");
        if ($ok) {
            $status='sent'; $err=NULL; $okCount++;
        } else {
            $status='failed'; $err='mailer_error'; $failCount++;
        }
        $lg->bind_param("isss", $newsletter_id, $email, $status, $err);
        $lg->execute();

        usleep(150000);
    }

    $new_status = $failCount>0 && $okCount===0 ? 'failed' : 'sent';
    $u = $conn->prepare("UPDATE newsletter_master SET sent_status=? WHERE id=?");
    $u->bind_param("si", $new_status, $newsletter_id);
    $u->execute();

    return $okCount>0;
}
?>
