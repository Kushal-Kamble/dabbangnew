<?php 
// admin/newsletter_send_helper_all.php
require_once __DIR__ . "/../inc/mailer.php";

function send_newsletter_now_all($newsletter_id, $conn, $BASE_URL) {
    $stmt = $conn->prepare("SELECT * FROM newsletter_master WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $newsletter_id);
    $stmt->execute();
    $nl = $stmt->get_result()->fetch_assoc();
    if (!$nl) return false;

    $multi = [];
    if (!empty($nl['multi_content'])) {
        $multi = json_decode($nl['multi_content'], true);
        if (!is_array($multi)) $multi = [];
    }

    $sections_def = [
        'this_weeks_insights' => "This Week’s Insights",
        'quick_bytes'         => "Quick Bytes",
        'ai_tip'              => "AI Tip of the Week",
        'toolbox'             => "Toolbox",
        'market_news'         => "Market News",
        'wellnessbyte'        => "Wellnessbyte",
        'quote_of_the_day'    => "Quote of the Day",
    ];

    // Distinct pastel colors
    $section_colors = [
        'this_weeks_insights' => '#e7d9fb',
        'quick_bytes'         => '#e6f3ff',
        'ai_tip'              => '#f5d8f9',
        'toolbox'             => '#d7ecfb',
        'market_news'         => '#d4f4d4',
        'wellnessbyte'        => '#f9f6d0',
        'quote_of_the_day'    => '#fde2d2',
    ];

    // Hero image with its own soft background
    $hero = "";
    if (!empty($nl['image'])) {
        $hero = "
        <div style='background:#fff7ec;padding:10px;border-radius:12px;margin:12px 0;text-align:center;'>
          <img src='".htmlspecialchars($nl['image'])."' style='width:100%;border-radius:10px;' alt='Hero'>
        </div>";
    }

    // Video block with separate background
    $videoBlock = "";
    if (!empty($nl['video'])) {
        $ytId = "";
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]+)/', $nl['video'], $m)) {
            $ytId = $m[1];
        }
        if ($ytId) {
            $thumb = "https://img.youtube.com/vi/".$ytId."/hqdefault.jpg";
            $videoBlock = "
            <div style='background:#eef7ff;padding:12px;border-radius:12px;margin:18px 0;text-align:center;'>
              <a href='".htmlspecialchars($nl['video'])."' target='_blank'>
                <img src='{$thumb}' alt='Watch Video' style='max-width:100%;border-radius:8px;'>
              </a><br>
              <a href='".htmlspecialchars($nl['video'])."' target='_blank' style='display:inline-block;margin-top:8px;padding:10px 14px;background:#fd5402;color:#fff;text-decoration:none;border-radius:6px;'>▶ Watch Video</a>
            </div>";
        } else {
            $videoBlock = "
            <div style='background:#eef7ff;padding:12px;border-radius:12px;margin:18px 0;text-align:center;'>
              <a href='".htmlspecialchars($nl['video'])."' target='_blank' style='display:inline-block;padding:10px 14px;background:#fd5402;color:#fff;text-decoration:none;border-radius:6px;'>🎬 Watch Video</a>
            </div>";
        }
    }

    // Outer wrapper with border-radius on orange body
    $html_body = "<div style='font-family:Arial,sans-serif;background:#fe9e43;padding:20px;border-radius:20px;'>
      <div style='max-width:640px;margin:auto;background:#ffffff;border-radius:14px;padding:20px'>
        <h2 style='margin:0 0 8px 0;color:#212428'>".htmlspecialchars($nl['title'])."</h2>
        <div style='color:#666;font-size:13px;margin-bottom:8px'>Newsletter</div>
        {$hero}
        {$videoBlock}
    ";

    $alt_parts = [];
    foreach ($sections_def as $key => $label) {
        if (!empty($multi[$key])) {
            $sec = $multi[$key];
            $sec_label = $sec['label'] ?? $label;
            $content_html = $sec['content'] ?? '';
            $bg = $section_colors[$key] ?? '#ffffff';

            $html_body .= "
            <div style='background:{$bg};padding:16px;border-radius:10px;margin:18px 0'>
                <h3 style='color:#212428;margin-top:0;margin-bottom:8px;font-size:18px'>".htmlspecialchars($sec_label)."</h3>
                <div style='color:#333;line-height:1.6;font-size:14px'>".$content_html."</div>";

            if (!empty($sec['post_url'])) {
                $purl = htmlspecialchars($sec['post_url']);
                $html_body .= "<div style='text-align:center;margin:14px 0'>
                    <a href='{$purl}' style='background:#fd5402;color:#fff;padding:10px 16px;border-radius:6px;text-decoration:none;display:inline-block;'>Read more</a>
                  </div>";
            }

            $html_body .= "</div>";

            $plain = trim(strip_tags($content_html));
            $alt_section = $sec_label . "\n" . $plain;
            if (!empty($sec['post_url'])) {
                $alt_section .= "\nRead more: " . $sec['post_url'];
            }
            $alt_parts[] = $alt_section;
        }
    }

    $html_body .= "
      <div style='color:#999;font-size:12px;margin-top:16px;text-align:center'>
        You are receiving this because you subscribed.<br>
        Unsubscribe: <a href='".rtrim($BASE_URL,'/')."/public/unsubscribe.php?email={email}' style='color:#666'>Unsubscribe</a>
      </div>
    </div></div>";

    $alt_template = implode("\n\n----------------\n\n", $alt_parts);
    if (empty($alt_template)) {
        $alt_template = strip_tags($nl['editor_content'] ?? '');
    }

    $subs = $conn->query("SELECT name, email FROM subscribers WHERE status=1");
    if (!$subs) return false;

    $okCount = 0; $failCount = 0;
   $lg = $conn->prepare("INSERT INTO newsletter_logs 
(newsletter_id, subscriber_email, status, error_msg, sent_at) 
VALUES (?, ?, ?, ?, NOW())");

if (!$lg) { $lg = null; }

while ($s = $subs->fetch_assoc()) {
    $email = $s['email'];
    $name = $s['name'] ?? '';

    $html_to_send = str_replace('{email}', urlencode($email), $html_body);
    $alt_to_send  = str_replace('{email}', urlencode($email), $alt_template);

    $sent = sendMailHTML($email, $name, $nl['title'], $html_to_send, $alt_to_send);

    if ($sent) {
        $status = 'sent'; 
        $err = null; 
        $okCount++;
    } else {
        $status = 'failed'; 
        $err = 'mailer_error'; 
        $failCount++;
    }

    if ($lg) {
        // ✅ 4 variables bind karne hain (newsletter_id, email, status, error_msg)
        $lg->bind_param("isss", $newsletter_id, $email, $status, $err);
        $lg->execute();
    }

    usleep(120000); // 0.12s delay to avoid spam triggers
}


    $new_status = ($okCount > 0) ? 'sent' : 'failed';
    $up = $conn->prepare("UPDATE newsletter_master SET sent_status = ? WHERE id = ?");
    if ($up) {
        $up->bind_param("si", $new_status, $newsletter_id);
        $up->execute();
        $up->close();
    }

    if ($lg) $lg->close();

    return $okCount > 0;
}
?>
